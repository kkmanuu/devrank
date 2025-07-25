<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin')->only(['create', 'store']);
    }


    public function welcome()
{
    $events = Event::where('status', 'upcoming')
                   ->orderBy('event_date')
                   ->take(6)
                   ->get();

    return view('events.welcome', compact('events'));
}

    public function index()
    {
        $events = Event::withCount('bookings')->latest()->paginate(10);

        if (Auth::user()->isAdmin()) {
            return view('admin.events.index', compact('events'));
        }

        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('uploads/events', 'public')
            : null;

        Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'agenda' => $request->agenda,
            'about' => $request->about,
            'faqs' => $request->faqs ? json_encode($request->faqs) : null,
            'event_date' => $request->event_date,
            'start_time' => $request->start_time,
            'location' => $request->location,
            'status' => $request->status ?? 'upcoming',
            'image' => $imagePath,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('admin.events.index')->with('success', __('messages.event_created'));
    }

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

    public function book(Event $event)
    {
        if ($event->status !== 'upcoming' || $event->availableSlots() <= 0) {
            return redirect()->route('events.index')->with('error', __('messages.event_unavailable'));
        }

        $alreadyBooked = Booking::where('user_id', Auth::id())
            ->where('bookable_id', $event->id)
            ->where('bookable_type', Event::class)
            ->exists();

        if ($alreadyBooked) {
            return redirect()->route('events.index')->with('error', __('messages.already_booked'));
        }

        Booking::create([
            'user_id' => Auth::id(),
            'bookable_id' => $event->id,
            'bookable_type' => Event::class,
            'status' => 'confirmed',
        ]);

        return redirect()->route('dashboard')->with('success', __('messages.event_booked'));
    }
}