<?php

namespace App\Http\Controllers;

use App\Models\Event;        // Eloquent model for events table
use App\Models\Booking;      // Eloquent model for bookings table
use App\Models\Notification; // Eloquent model for notifications table
use App\Models\User;         // Eloquent model for users table
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function __construct()
    {
        // Middleware ensures only authenticated users can access any method
        $this->middleware('auth');
        // Only admins can create, store, edit, update, and delete events
        $this->middleware('role:admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Show welcome page with 6 upcoming events.
     * Events come from the "events" database table via the Event model.
     */
    public function welcome()
    {
        // Fetch upcoming events sorted by event_date, limited to 6
        $events = Event::where('status', 'upcoming')
                       ->orderBy('event_date')
                       ->take(6)
                       ->get();

        return view('events.welcome', compact('events'));
    }

    /**
     * List events for the index page.
     * Admins see admin view; others see public event list.
     */
    public function index()
    {
        // Fetch events with count of bookings, sorted by latest
        $events = Event::withCount('bookings')
                       ->latest()
                       ->paginate(10);

        if (Auth::user()->isAdmin()) {
            return view('admin.events.index', compact('events'));
        }

        return view('events.index', compact('events'));
    }

    /** Show form to create a new event (admin only). */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a new event in the database.
     * Events are inserted into the "events" table via the Event model.
     */
    public function store(Request $request)
    {
        // Validate the event form inputs
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'agenda' => 'nullable|string',
            'about' => 'nullable|string',
            'faqs' => 'nullable|array',
            'faqs.*.question' => 'required_with:faqs|string',
            'faqs.*.answer' => 'required_with:faqs|string',
            'event_date' => 'required|date|after:now',
            'start_time' => 'required|date_format:H:i',
            'location' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:upcoming,completed,cancelled',
            'amount' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload image if present
        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('uploads/events', 'public')
            : null;

        // Create the event record
        $event = Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'agenda' => $request->agenda,
            'about' => $request->about,
            'faqs' => $request->faqs ? json_encode($request->faqs) : null,
            'event_date' => $request->event_date,
            'start_time' => $request->start_time,
            'location' => $request->location,
            'status' => $request->status ?? 'upcoming',
            'amount' => $request->amount,
            'capacity' => $request->capacity,
            'image' => $imagePath,
            'created_by' => Auth::id(),
        ]);

        // Send a notification to all students
        $students = User::where('role', 'student')->get();
        foreach ($students as $student) {
            Notification::create([
                'user_id' => $student->id,
                'type' => 'event',
                'message' => "New event created: {$event->title} on {$event->event_date->format('F d, Y')}",
                'is_read' => false,
            ]);
        }

        return redirect()->route('admin.events.index')->with('success', __('messages.event_created'));
    }

    /** Show the edit form for a specific event (admin only). */
    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update an existing event record in the database.
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'agenda' => 'nullable|string',
            'about' => 'nullable|string',
            'faqs' => 'nullable|array',
            'faqs.*.question' => 'required_with:faqs|string',
            'faqs.*.answer' => 'required_with:faqs|string',
            'event_date' => 'required|date|after:now',
            'start_time' => 'required|date_format:H:i',
            'location' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:upcoming,completed,cancelled',
            'amount' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle image update
        if ($request->hasFile('image')) {
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $imagePath = $request->file('image')->store('uploads/events', 'public');
        } else {
            $imagePath = $event->image;
        }

        // Update event record
        $event->update([
            'title' => $request->title,
            'description' => $request->description,
            'agenda' => $request->agenda,
            'about' => $request->about,
            'faqs' => $request->faqs ? json_encode($request->faqs) : null,
            'event_date' => $request->event_date,
            'start_time' => $request->start_time,
            'location' => $request->location,
            'status' => $request->status ?? $event->status,
            'amount' => $request->amount,
            'capacity' => $request->capacity,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }

    /**
     * Delete an event record from the database.
     */
    public function destroy(Event $event)
    {
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
    }

    /**
     * Show a single event's details.
     * Admins see attendees list; others see public details.
     */
    public function show(Event $event)
    {
        if (Auth::user()->isAdmin()) {
            $event->load(['bookings.user' => function ($query) {
                $query->where('role', 'student');
            }]);
            return view('admin.events.show', compact('event'));
        }

        return view('events.show', compact('event'));
    }

    /**
     * Show booking form for a specific event.
     */
    public function showBookingForm(Event $event)
    {
        \Log::info('Checking booking form for event: ' . $event->id);

        // Ensure event is upcoming and has slots available
        if ($event->status !== 'upcoming') {
            \Log::warning('Event not upcoming: ' . $event->status);
            return redirect()->route('events.index')->with('error', __('messages.event_unavailable'));
        }
        if ($event->availableSlots() <= 0) {
            \Log::warning('No available slots for event: ' . $event->id);
            return redirect()->route('events.index')->with('error', __('messages.event_unavailable'));
        }

        // Prevent duplicate booking
        $alreadyBooked = Booking::where('user_id', Auth::id())
            ->where('bookable_id', $event->id)
            ->where('bookable_type', Event::class)
            ->exists();

        if ($alreadyBooked) {
            \Log::warning('User already booked event: ' . $event->id);
            return redirect()->route('events.index')->with('error', __('messages.already_booked'));
        }

        return view('events.book', compact('event'));
    }

    /**
     * Process the booking form and initiate payment.
     */
    public function processBooking(Request $request, Event $event)
    {
        $request->validate([
            'phone_number' => ['required', 'string', 'regex:/^(\+254|0)[0-9]{9}$/'],
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'question' => 'nullable|string',
        ]);

        // Check if booking is possible
        if ($event->status !== 'upcoming' || $event->availableSlots() <= 0) {
            return redirect()->route('events.index')->with('error', __('messages.event_unavailable'));
        }

        // Prevent duplicate booking
        $alreadyBooked = Booking::where('user_id', Auth::id())
            ->where('bookable_id', $event->id)
            ->where('bookable_type', Event::class)
            ->exists();

        if ($alreadyBooked) {
            return redirect()->route('events.index')->with('error', __('messages.already_booked'));
        }

        // Prepare payment data
        $data = [
            'phone' => $request->phone_number,
            'amount' => $event->amount,
            'bookable_id' => $event->id,
            'bookable_type' => Event::class,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'question' => $request->question,
        ];

        // Pass booking details to PaymentController
        return app(PaymentController::class)->initiatePayment(new Request($data));
    }
}
