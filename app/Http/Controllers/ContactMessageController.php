<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    /**
     * Show contact form to public or authenticated users
     */
    public function index()
    {
        return view('contact');
    }


    
    /**
     * Handle contact form submission
     */
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        ContactMessage::create($validated);

        return redirect()->route('contact')->with('success', 'Message sent successfully!');
    }

    /**
     * Display all contact messages in admin panel
     */
    public function adminIndex()
    {
        // This uses the policy correctly
        $this->authorize('viewAny', ContactMessage::class);

        $messages = ContactMessage::latest()->get();

        return view('admin.contact-messages.index', compact('messages'));
    }

    /**
     * Mark a contact message as read
     */
    public function markAsRead(ContactMessage $contactMessage)
    {
        $this->authorize('update', $contactMessage);

        $contactMessage->update(['is_read' => true]);

        return redirect()->route('admin.contact-messages.index')
                         ->with('success', 'Message marked as read.');
    }

    /**
     * Delete a contact message
     */
    public function destroy(ContactMessage $contactMessage)
    {
        $this->authorize('delete', $contactMessage);

        $contactMessage->delete();

        return redirect()->route('admin.contact-messages.index')
                         ->with('success', 'Message deleted successfully.');
    }
}
