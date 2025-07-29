<?php

namespace App\Http\Controllers;

use App\Models\CoachingSession;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoachingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin')->only(['create', 'store']);
    }

    public function index()
    {
        if (auth()->user()->role === 'admin') {
            $sessions = CoachingSession::with('coach')->latest()->get();
            return view('admin.coaching.index', compact('sessions'));
        }

        $sessions = CoachingSession::where('status', 'upcoming')->with('coach')->latest()->get();
        return view('coaching.index', compact('sessions'));
    }

    public function create()
    {
        $coaches = User::where('role', 'coach')->get();
        return view('admin.coaching.create', compact('coaches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'topic' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'nullable|string|max:255',
            'coach_id' => 'required|exists:users,id',
            'session_date' => 'required|date|after:now',
            'start_time' => 'required|date_format:H:i',
            'capacity' => 'required|integer|min:1',
            'status' => 'nullable|string|in:upcoming,completed,cancelled',
        ]);

        CoachingSession::create([
            'topic' => $request->topic,
            'description' => $request->description,
            'type' => $request->type,
            'coach_id' => $request->coach_id,
            'session_date' => $request->session_date,
            'start_time' => $request->start_time,
            'scheduled_at' => now(),
            'capacity' => $request->capacity,
            'status' => $request->status ?? 'upcoming',
            'created_by' => Auth::id(),
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.coaching.index')->with('success', __('messages.coaching_created'));
    }

    public function show(CoachingSession $session)
    {
        $session->load('coach', 'bookings.user');
        return view('coaching.show', compact('session'));
    }

    public function showBookingForm(CoachingSession $session)
    {
        if ($session->status !== 'upcoming' || $session->availableSlots() <= 0) {
            return redirect()->route('coaching.index')->with('error', __('messages.coaching_unavailable'));
        }
        return view('coaching.book', compact('session'));
    }

    public function book(Request $request, CoachingSession $session)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'question' => 'nullable|string',
        ]);

        if ($session->status !== 'upcoming' || $session->availableSlots() <= 0) {
            return redirect()->route('coaching.index')->with('error', __('messages.coaching_unavailable'));
        }

        if (Auth::user()->submission_count >= 4 && !Auth::user()->hasActivePayment()) {
            return redirect()->route('payment.required')->with('error', __('messages.payment_required'));
        }

        $existingBooking = Booking::where('user_id', Auth::id())
            ->where('bookable_id', $session->id)
            ->where('bookable_type', CoachingSession::class)
            ->exists();

        if ($existingBooking) {
            return redirect()->route('coaching.index')->with('error', __('messages.already_booked'));
        }

        Booking::create([
            'user_id' => Auth::id(),
            'bookable_id' => $session->id,
            'bookable_type' => CoachingSession::class,
            'status' => 'confirmed',
            'full_name' => $request->full_name,
            'email' => $request->email,
            'question' => $request->question,
        ]);

        return redirect()->route('dashboard')->with('success', __('messages.coaching_booked'));
    }
}