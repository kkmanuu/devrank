<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\User;
use App\Models\Payment;
use App\Models\Message;
use App\Models\CoachingSession;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['studentDashboard']);
        $this->middleware(['auth', 'role:admin'])->only(['adminDashboard', 'manageSubmissions', 'manageUsers', 'managePayments', 'manageMessages', 'manageCoaching']);
    }

    public function studentDashboard()
    {
        $user = Auth::user();
        $submissions = $user->submissions()->with(['feedback', 'project'])->latest()->get();
        $badges = $user->badges()->get();
        $messages = $user->messages()->latest()->get();
        $coachingSessions = $user->coachingSessions()->with('coach')->latest()->get();
        $submissionCount = $user->submissions()->count();
        $canSubmit = $submissionCount < 4 || $user->hasActivePayment();

        return view('student.dashboard', compact('submissions', 'badges', 'messages', 'coachingSessions', 'submissionCount', 'canSubmit'));
    }

    public function adminDashboard()
    {
        $totalUsers = User::count();
        $totalSubmissions = Submission::count();
        $pendingReviews = Submission::whereNull('score')->count();
        $totalPayments = Payment::sum('amount');
        $pendingMessages = Message::where('status', 'pending')->count();
        $eventRegistrations = Event::withCount('users')->get()->sum('users_count');
        $eventParticipants = Event::withCount(['users' => function ($query) {
            $query->wherePivot('participated', true);
        }])->get()->sum('users_count');
        $coachingBookings = CoachingSession::count();

        return view('admin.dashboard', compact('totalUsers', 'totalSubmissions', 'pendingReviews', 'totalPayments', 'pendingMessages', 'eventRegistrations', 'eventParticipants', 'coachingBookings'));
    }

    public function manageSubmissions(Request $request)
    {
        $submissions = Submission::with('user')->latest()->paginate(10);
        return view('admin.submissions', compact('submissions'));
    }

    public function manageUsers(Request $request)
    {
        $users = User::where('role', 'student')->latest()->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function managePayments(Request $request)
    {
        $payments = Payment::with('user')->latest()->paginate(10);
        return view('admin.payments', compact('payments'));
    }

    public function manageMessages(Request $request)
    {
        $messages = Message::with('user')->latest()->paginate(10);
        return view('admin.messages', compact('messages'));
    }

    public function manageCoaching(Request $request)
    {
        $sessions = CoachingSession::with(['user', 'coach'])->latest()->paginate(10);
        return view('admin.coaching.index', compact('sessions'));
    }
}
?>