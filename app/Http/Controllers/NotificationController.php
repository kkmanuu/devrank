<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $notifications = $user->customNotifications()
                              ->latest()
                              ->paginate(10);

        $view = $user->role === 'admin'
            ? 'admin.notifications.index'
            : 'notifications.index';

        return view($view, compact('notifications'));
    }

    public function show($id)
    {
        $notification = Auth::user()->customNotifications()->findOrFail($id);

        // Mark as read
        $notification->update(['is_read' => true]);

        $view = Auth::user()->role === 'admin'
            ? 'admin.notifications.show'
            : 'notifications.show';

        return view($view, compact('notification'));
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->customNotifications()->findOrFail($id);

        $notification->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Notification marked as read.');
    }
}
