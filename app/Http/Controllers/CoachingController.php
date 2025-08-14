<?php

namespace App\Http\Controllers;

use App\Models\CoachingSession;
use App\Models\Booking;
use App\Models\Notification;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoachingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    public function index()
    {
        if (auth()->user()->role === 'admin') {
            $sessions = CoachingSession::with('coach')->latest()->get();
            return view('admin.coaching.index', compact('sessions'));
        }

        $sessions = CoachingSession::where('status', 'upcoming')
            ->with('coach')
            ->latest()
            ->get();

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
            'developer_type' => 'required|string|in:fresher,professional',
            'coach_id' => 'required|exists:users,id',
            'session_date' => 'required|date|after:now',
            'start_time' => 'required|date_format:H:i',
            'capacity' => 'required|integer|min:1',
            'amount' => 'required|numeric|min:0',
            'status' => 'nullable|string|in:upcoming,completed,cancelled',
        ]);

        CoachingSession::create([
            'topic' => $request->topic,
            'description' => $request->description,
            'type' => $request->type,
            'developer_type' => $request->developer_type,
            'coach_id' => $request->coach_id,
            'session_date' => $request->session_date,
            'start_time' => $request->start_time,
            'scheduled_at' => now(),
            'capacity' => $request->capacity,
            'amount' => $request->amount,
            'status' => $request->status ?? 'upcoming',
            'created_by' => Auth::id(),
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.coaching.index')->with('success', 'Coaching session created successfully.');
    }

   public function edit(CoachingSession $session)
{
    $coaches = User::where('role', 'coach')->get();
    return view('admin.coaching.edit', compact('session', 'coaches'));
}

public function update(Request $request, CoachingSession $session)
{
    $request->validate([
        'topic' => 'required|string|max:255',
        'description' => 'nullable|string',
        'type' => 'nullable|string|max:255',
        'developer_type' => 'required|string|in:fresher,professional',
        'coach_id' => 'required|exists:users,id',
        'session_date' => 'required|date|after:now',
        'start_time' => 'required|date_format:H:i',
        'capacity' => 'required|integer|min:1',
        'amount' => 'required|numeric|min:0',
        'status' => 'nullable|string|in:upcoming,completed,cancelled',
    ]);

    $session->update([
        'topic' => $request->topic,
        'description' => $request->description,
        'type' => $request->type,
        'developer_type' => $request->developer_type,
        'coach_id' => $request->coach_id,
        'session_date' => $request->session_date,
        'start_time' => $request->start_time,
        'capacity' => $request->capacity,
        'amount' => $request->amount,
        'status' => $request->status ?? $session->status,
    ]);

    return redirect()->route('admin.coaching.index')->with('success', 'Coaching session updated successfully.');
}


    public function show(CoachingSession $session)
    {
        $session->load('coach', 'bookings.user');
        return view('coaching.show', compact('session'));
    }

    public function showBookingForm(CoachingSession $session)
    {
        if ($session->status !== 'upcoming' || $session->availableSlots() <= 0) {
            return redirect()->route('coaching.index')->with('error', 'This coaching session is unavailable.');
        }
        return view('coaching.book', compact('session'));
    }

    public function book(Request $request, CoachingSession $session)
{
    $request->validate([
        'full_name' => 'required|string|max:255',
        'email' => 'required|email',
        'question' => 'nullable|string',
        'phone_number' => 'required|string|max:15',
    ]);

    if ($session->status !== 'upcoming' || $session->availableSlots() <= 0) {
        return redirect()->route('coaching.index')->with('error', 'This coaching session is unavailable.');
    }

    if (Auth::user()->submission_count >= 4 && !Auth::user()->hasActivePayment()) {
        return redirect()->route('payment.required')->with('error', 'Payment required.');
    }

    $existingBooking = Booking::where('user_id', Auth::id())
        ->where('bookable_id', $session->id)
        ->where('bookable_type', CoachingSession::class)
        ->exists();

    if ($existingBooking) {
        return redirect()->route('coaching.index')->with('error', 'You have already booked this session.');
    }

    // Redirect to PaymentController::initiatePayment with parameters
    return redirect()->route('payment', [
        'phone' => $request->phone_number,
        'amount' => $session->amount,
        'bookable_id' => $session->id,
        'bookable_type' => CoachingSession::class,
    ]);
}


    private function initiateMpesaPayment(Payment $payment)
    {
        return (object) ['success' => true]; // Placeholder
    }

    public function destroy(CoachingSession $session)
    {
        $session->bookings()->delete();
        Notification::where('message', 'like', "%{$session->topic}%")->delete();
        Payment::where('coaching_session_id', $session->id)->delete();
        $session->delete();

        return redirect()->route('admin.coaching.index')->with('success', 'Coaching session deleted successfully.');
    }
}
