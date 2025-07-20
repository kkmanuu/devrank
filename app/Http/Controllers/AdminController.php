<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Payment;
use App\Models\Feedback;
use App\Models\Badge;
use App\Models\Submission;
use App\Models\User;
use App\Models\EventRegistration;
use App\Models\CoachingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }


    public function adminDashboard()
    {
        $totalUsers = User::count();
        $totalSubmissions = Submission::count();
        $pendingReviews = Submission::where('status', 'pending')->count();
        $totalPayments = Payment::sum('amount');
        $pendingMessages = Message::where('status', 'unread')->count();
        $eventRegistrations = EventRegistration::count();
        $eventParticipants = EventRegistration::distinct('user_id')->count('user_id');
        $coachingBookings = CoachingSession::count();

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalSubmissions' => $totalSubmissions,
            'pendingReviews' => $pendingReviews,
            'totalPayments' => $totalPayments,
            'pendingMessages' => $pendingMessages,
            'eventRegistrations' => $eventRegistrations,
            'eventParticipants' => $eventParticipants,
            'coachingBookings' => $coachingBookings,
            
        ]);
    }

    public function review(Request $request, Submission $submission)
    {
        $request->validate([
            'score' => 'required|numeric|min:0|max:100',
            'correct' => 'required|string',
            'incorrect' => 'required|string',
        ]);

        $submission->update([
            'score' => $request->score,
            'feedback_id' => Feedback::create([
                'submission_id' => $submission->id,
                'content' => 'Review completed.',
                'correct' => $request->correct,
                'incorrect' => $request->incorrect,
            ])->id,
        ]);

        // Award badge if applicable
        $user = $submission->user;
        if ($user->submissions()->count() >= 5) {
            $user->badges()->attach(Badge::firstOrCreate(['name' => '5 Submissions']));
        }

        return redirect()->route('admin.submissions')->with('success', 'Submission reviewed successfully.');
    }
}
