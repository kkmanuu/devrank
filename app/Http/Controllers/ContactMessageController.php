<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ContactMessageReceived;
use App\Mail\ContactMessageReply;

class ContactMessageController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|max:255', // Made required since form requires it
            'phone'      => 'nullable|string|max:20',
            'company'    => 'nullable|string|max:255',
            'subject'    => 'required|string|max:255', // Updated field name to match form
            'message'    => 'required|string|max:5000',
            'newsletter' => 'nullable|boolean',
        ]);

        // Set user_id if authenticated, otherwise null for guest users
        $validated['user_id'] = Auth::id();
        $validated['is_read'] = false;
        $validated['status'] = 'pending'; // Add status field
        $validated['priority'] = $this->determinePriority($validated['subject']);

        $message = ContactMessage::create($validated);

        // Send email notifications to admins
        $this->notifyAdmins($message);

        // Send auto-reply to user
        $this->sendAutoReply($message);

        // Add user to newsletter if requested
        if ($validated['newsletter'] ?? false) {
            $this->subscribeToNewsletter($validated['email'], $validated['name']);
        }

        // Return JSON response for AJAX or redirect for regular form submission
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you for your message! We\'ll get back to you within 24 hours.',
                'contact_id' => $message->id
            ]);
        }

        return redirect()->route('contact')->with([
            'success' => 'Thank you for your message! We\'ll get back to you within 24 hours.',
            'contact_id' => $message->id
        ]);
    }

    public function reply(Request $request, ContactMessage $contactMessage)
    {
        $this->authorize('update', $contactMessage);

        $validated = $request->validate([
            'reply' => 'required|string|max:5000',
        ]);

        $contactMessage->update([
            'reply'      => $validated['reply'],
            'is_read'    => true,
            'status'     => 'replied',
            'replied_at' => now(),
            'replied_by' => Auth::id(),
        ]);

        // Send email reply to user
        if ($contactMessage->email) {
            Mail::to($contactMessage->email)->send(
                new ContactMessageReply($contactMessage, $validated['reply'])
            );
        }

        // Notify the user if they have an account
        if ($contactMessage->user_id) {
            $this->sendNotification(
                $contactMessage->user_id,
                'contact_reply',
                "We've replied to your contact message about: " . $contactMessage->subject
            );
        }

        return redirect()->route('admin.contact-messages.index')
            ->with('success', 'Reply sent successfully to ' . $contactMessage->name);
    }

    public function adminIndex()
    {
        $this->authorize('viewAny', ContactMessage::class);

        $messages = ContactMessage::with(['user', 'repliedBy'])
            ->when(request('status'), function ($query) {
                return $query->where('status', request('status'));
            })
            ->when(request('priority'), function ($query) {
                return $query->where('priority', request('priority'));
            })
            ->when(request('search'), function ($query) {
                return $query->where(function ($q) {
                    $search = request('search');
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('subject', 'like', "%{$search}%")
                      ->orWhere('message', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(20);

        $stats = [
            'total' => ContactMessage::count(),
            'pending' => ContactMessage::where('status', 'pending')->count(),
            'replied' => ContactMessage::where('status', 'replied')->count(),
            'high_priority' => ContactMessage::where('priority', 'high')->count(),
        ];

        return view('admin.contact-messages.index', compact('messages', 'stats'));
    }

    public function show(ContactMessage $contactMessage)
    {
        $this->authorize('view', $contactMessage);

        // Mark as read when viewed
        if (!$contactMessage->is_read) {
            $contactMessage->update(['is_read' => true]);
        }

        return view('admin.contact-messages.show', compact('contactMessage'));
    }

    public function markAsRead(ContactMessage $contactMessage)
    {
        $this->authorize('update', $contactMessage);

        $contactMessage->update(['is_read' => true]);

        return redirect()->route('admin.contact-messages.index')
            ->with('success', 'Message marked as read.');
    }

    public function bulkAction(Request $request)
    {
        $this->authorize('viewAny', ContactMessage::class);

        $validated = $request->validate([
            'action' => 'required|in:mark_read,delete,set_priority',
            'messages' => 'required|array|min:1',
            'messages.*' => 'exists:contact_messages,id',
            'priority' => 'required_if:action,set_priority|in:low,medium,high',
        ]);

        $messages = ContactMessage::whereIn('id', $validated['messages']);

        switch ($validated['action']) {
            case 'mark_read':
                $messages->update(['is_read' => true]);
                $successMessage = 'Messages marked as read.';
                break;

            case 'delete':
                $count = $messages->count();
                $messages->delete();
                $successMessage = "{$count} messages deleted successfully.";
                break;

            case 'set_priority':
                $messages->update(['priority' => $validated['priority']]);
                $successMessage = "Priority updated to {$validated['priority']}.";
                break;
        }

        return redirect()->route('admin.contact-messages.index')
            ->with('success', $successMessage);
    }

    public function destroy(ContactMessage $contactMessage)
    {
        $this->authorize('delete', $contactMessage);

        $contactMessage->delete();

        return redirect()->route('admin.contact-messages.index')
            ->with('success', 'Message deleted successfully.');
    }

    public function export(Request $request)
    {
        $this->authorize('viewAny', ContactMessage::class);

        $messages = ContactMessage::with('user')
            ->when($request->status, function ($query) use ($request) {
                return $query->where('status', $request->status);
            })
            ->when($request->date_from, function ($query) use ($request) {
                return $query->whereDate('created_at', '>=', $request->date_from);
            })
            ->when($request->date_to, function ($query) use ($request) {
                return $query->whereDate('created_at', '<=', $request->date_to);
            })
            ->get();

        $filename = 'contact-messages-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($messages) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, [
                'ID', 'Name', 'Email', 'Phone', 'Company', 'Subject', 
                'Message', 'Status', 'Priority', 'Created At', 'Replied At'
            ]);

            // CSV Data
            foreach ($messages as $message) {
                fputcsv($file, [
                    $message->id,
                    $message->name,
                    $message->email,
                    $message->phone,
                    $message->company,
                    $message->subject,
                    Str::limit($message->message, 200),
                    $message->status,
                    $message->priority,
                    $message->created_at->format('Y-m-d H:i:s'),
                    $message->replied_at ? $message->replied_at->format('Y-m-d H:i:s') : '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Determine message priority based on subject
     */
    private function determinePriority(string $subject): string
    {
        $subject = strtolower($subject);
        
        $highPriorityKeywords = ['urgent', 'emergency', 'critical', 'asap', 'immediate'];
        $mediumPriorityKeywords = ['support', 'technical', 'bug', 'issue', 'problem'];
        
        foreach ($highPriorityKeywords as $keyword) {
            if (str_contains($subject, $keyword)) {
                return 'high';
            }
        }
        
        foreach ($mediumPriorityKeywords as $keyword) {
            if (str_contains($subject, $keyword)) {
                return 'medium';
            }
        }
        
        // Default priority based on subject type
        return match ($subject) {
            'partnership' => 'high',
            'coaching' => 'medium',
            'events' => 'medium',
            'support' => 'medium',
            default => 'low'
        };
    }

    /**
     * Send notifications to all admins
     */
    private function notifyAdmins(ContactMessage $message): void
    {
        $admins = User::where('role', 'admin')->get();
        
        foreach ($admins as $admin) {
            // Send database notification
            $this->sendNotification(
                $admin->id,
                'contact_message',
                "New {$message->priority} priority message from {$message->name} about {$message->subject}"
            );

            // Send email notification to admin
            try {
                Mail::to($admin->email)->send(new ContactMessageReceived($message));
            } catch (\Exception $e) {
                \Log::error('Failed to send admin notification email: ' . $e->getMessage());
            }
        }
    }


    // Show reply form
public function replyForm(ContactMessage $contactMessage)
{
    $this->authorize('update', $contactMessage);
    return view('admin.contact-messages.reply', compact('contactMessage'));
}

// Handle reply submission
// Duplicate reply method removed to resolve redeclaration error.

    /**
     * Send auto-reply to user
     */
    private function sendAutoReply(ContactMessage $message): void
    {
        try {
            $autoReplyContent = $this->getAutoReplyContent($message->subject);
            
            // You can create an AutoReplyMail class or use a simple mail
            Mail::raw($autoReplyContent, function ($mail) use ($message) {
                $mail->to($message->email)
                     ->subject('Thank you for contacting DevRank - We\'ve received your message');
            });
        } catch (\Exception $e) {
            \Log::error('Failed to send auto-reply: ' . $e->getMessage());
        }
    }

    /**
     * Get auto-reply content based on subject
     */
    private function getAutoReplyContent(string $subject): string
    {
        $baseMessage = "Thank you for contacting DevRank! We've received your message and will respond within 24 hours.\n\n";
        
        return match ($subject) {
            'coaching' => $baseMessage . "We're excited to help you with your coaching needs. Our team will review your request and get back to you with available slots and next steps.",
            'events' => $baseMessage . "Thanks for your interest in our events! We'll send you more details about upcoming events and how to participate.",
            'partnership' => $baseMessage . "We appreciate your interest in partnering with DevRank. Our business development team will contact you to discuss potential collaboration opportunities.",
            'support' => $baseMessage . "Our technical support team has received your request and will investigate the issue. We'll provide a solution or update as soon as possible.",
            default => $baseMessage . "Your message is important to us, and we'll make sure to address all your questions and concerns."
        };
    }

    /**
     * Subscribe user to newsletter
     */
    private function subscribeToNewsletter(string $email, string $name): void
    {
        try {
            // Add logic to subscribe user to newsletter
            // This could be integration with MailChimp, SendGrid, etc.
            
            \Log::info("Newsletter subscription request for: {$email}");
            
            // For now, just create a simple record or flag
            // You might want to create a Newsletter model for this
        } catch (\Exception $e) {
            \Log::error('Newsletter subscription failed: ' . $e->getMessage());
        }
    }

    /**
     * Helper method to insert into your custom notifications table
     */
    private function sendNotification(int $userId, string $type, string $message): void
    {
        try {
            Notification::create([
                'user_id' => $userId,
                'type'    => $type,
                'message' => $message,
                'is_read' => false,
                'data'    => json_encode(['timestamp' => now()]),
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to create notification: ' . $e->getMessage());
        }
    }
}