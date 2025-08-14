<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\User;
use App\Models\Payment;
use App\Models\ContactMessage;
use App\Models\Service;
use App\Models\Badge;
use App\Models\Booking;
use App\Models\CoachingSession;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['studentDashboard']);
    }

    /**
     * Student dashboard.
     */
    public function studentDashboard()
    {
        $user = Auth::user();

        $submissionCount = $user->submissions()->count();
        $canSubmit = $submissionCount < 4 || $user->hasActivePayment();
        $submissions = $user->submissions()->with(['feedback', 'project'])->latest()->get();
        $badges = $user->badges()->get();
        $messages = $user->contactMessages()->latest()->get();
        $coachingSessions = $user->coachingSessions()->with('coach')->latest()->get();
        $notifications = $user->notifications()->latest()->take(5)->get();
        $recentEvents = Event::where('event_date', '>=', now()->subDays(30))->latest()->take(3)->get();
        $upcomingEvents = Event::where('event_date', '>=', now())->where('status', 'upcoming')->latest()->take(3)->get();
        
        // Add payment balance calculation similar to admin controller
        $userPayments = $user->payments()->where('status', 'completed')->get();
        $totalPayments = $userPayments->sum('amount');
        $accountBalance = $totalPayments; // You can modify this logic based on your business rules
        
        // Get payment history
        $recentPayments = $user->payments()->latest()->take(5)->get();

        return view('student.dashboard', compact(
            'submissionCount',
            'canSubmit',
            'submissions',
            'badges',
            'messages',
            'coachingSessions',
            'notifications',
            'recentEvents',
            'upcomingEvents',
            'totalPayments',
            'accountBalance',
            'recentPayments'
        ));
    }
}