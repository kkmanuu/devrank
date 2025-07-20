<?php

namespace App\Http\Controllers;

use App\Models\CoachingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoachingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['index', 'book']);
        $this->middleware(['auth', 'role:admin'])->only(['assign']);
    }

    public function index()
    {
        $sessions = Auth::user()->coachingSessions()->with('coach')->latest()->get();
        return view('coaching.index', compact('sessions'));
    }

    public function book(Request $request)
    {
        $request->validate([
            'session_date' => 'required|date|after:today',
            'topic' => 'required|string|max:255',
        ]);

        if (Auth::user()->submission_count >= 4 && !Auth::user()->hasActivePayment()) {
            return redirect()->route('payment.required');
        }

        CoachingSession::create([
            'user_id' => Auth::user()->id,
            'session_date' => $request->session_date,
            'topic' => $request->topic,
            'status' => 'pending',
        ]);

        return redirect()->route('coaching.index')->with('success', 'Coaching session booked successfully.');
    }

    public function assign(Request $request, CoachingSession $session)
    {
        $request->validate([
            'coach_id' => 'required|exists:users,id',
        ]);

        $session->update(['coach_id' => $request->coach_id]);

        return redirect()->route('admin.coaching.index')->with('success', 'Coach assigned successfully.');
    }
}
?>