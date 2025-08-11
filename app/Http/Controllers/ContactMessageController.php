<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\User;
use App\Models\Notification; // Your custom notification model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ContactMessageController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email|max:255',
            'company' => 'nullable|string|max:255',
            'type'    => 'nullable|string|max:100',
            'message' => 'required|string',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['is_read'] = false;

        $message = ContactMessage::create($validated);

        // Notify all admins using your custom notifications table
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $this->sendNotification(
                $admin->id,
                'message',
                "New contact message from " . ($message->user ? $message->user->name : $message->name)
            );
        }

        return redirect()->route('contact')->with('success', 'Message sent successfully!');
    }

    public function reply(Request $request, ContactMessage $contactMessage)
    {
        $this->authorize('update', $contactMessage);

        $request->validate([
            'reply' => 'required|string',
        ]);

        $contactMessage->update([
            'reply'   => $request->reply,
            'is_read' => true,
        ]);

        // Notify the user if they exist
        if ($contactMessage->user_id) {
            $this->sendNotification(
                $contactMessage->user_id,
                'message',
                "Reply to your contact message: " . Str::limit($request->reply, 100)
            );
        }

        return redirect()->route('admin.contact-messages.index')->with('success', 'Reply sent successfully.');
    }

    public function adminIndex()
    {
        $this->authorize('viewAny', ContactMessage::class);

        $messages = ContactMessage::with('user')->latest()->get();

        return view('admin.contact-messages.index', compact('messages'));
    }

    public function markAsRead(ContactMessage $contactMessage)
    {
        $this->authorize('update', $contactMessage);

        $contactMessage->update(['is_read' => true]);

        return redirect()->route('admin.contact-messages.index')->with('success', 'Message marked as read.');
    }

    public function destroy(ContactMessage $contactMessage)
    {
        $this->authorize('delete', $contactMessage);

        $contactMessage->delete();

        return redirect()->route('admin.contact-messages.index')->with('success', 'Message deleted successfully.');
    }

    /**
     * Helper method to insert into your custom notifications table.
     */
    private function sendNotification(int $userId, string $type, string $message): void
    {
        Notification::create([
            'user_id' => $userId,
            'type'    => $type,
            'message' => $message,
            'is_read' => false,
        ]);
    }
}
