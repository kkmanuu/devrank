<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Event;
use App\Models\Payment;
use App\Models\Feedback;
use App\Models\Booking;
use App\Models\Badge;
use App\Models\Submission;
use App\Models\User;
use App\Models\EventRegistration;
use App\Models\CoachingSession;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Admin Dashboard
     */
    public function adminDashboard()
    {
        $totalUsers = User::count();
        $totalSubmissions = Submission::count();
        $pendingReviews = Submission::where('status', 'pending')->count();
        $totalPayments = Payment::sum('amount');
        $pendingMessages = Message::where('status', 'unread')->count();
        $eventRegistrations = EventRegistration::count();
        $eventParticipants = EventRegistration::distinct('user_id')->count('user_id');
        $events = Event::latest()->get();
        $coachingBookings = CoachingSession::count();
        $coachingSessions = CoachingSession::latest()->get();
        $eventBookings = Booking::count();

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalSubmissions' => $totalSubmissions,
            'pendingReviews' => $pendingReviews,
            'totalPayments' => $totalPayments,
            'pendingMessages' => $pendingMessages,
            'eventRegistrations' => $eventRegistrations,
            'eventParticipants' => $eventParticipants,
            'coachingBookings' => $coachingBookings,
            'coachingSessions' => $coachingSessions,
            'eventBookings' => $eventBookings,
            'events' => $events,
        ]);
    }

    /**
     * Review Project Submission
     */
    public function review(Request $request, Submission $submission)
    {
        $request->validate([
            'score' => 'required|numeric|min:0|max:100',
            'correct' => 'required|string',
            'incorrect' => 'required|string',
        ]);

        $feedback = Feedback::create([
            'submission_id' => $submission->id,
            'content' => 'Review completed.',
            'correct' => $request->correct,
            'incorrect' => $request->incorrect,
        ]);

        $submission->update([
            'score' => $request->score,
            'feedback_id' => $feedback->id,
        ]);

        // Award badge for 5+ submissions
        $user = $submission->user;
        if ($user->submissions()->count() >= 5) {
            $user->badges()->attach(Badge::firstOrCreate(['name' => '5 Submissions']));
        }

        return redirect()->route('admin.submissions')->with('success', 'Submission reviewed successfully.');
    }

    /**
     * Show Create User Form
     */
    public function createUser()
    {
        return view('admin.users.create');
    }

    /**
     * Store a New User
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,student,coach',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.create')->with('success', 'User created successfully!');
    }
}
