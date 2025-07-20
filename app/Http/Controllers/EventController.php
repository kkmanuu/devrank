<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $events = Event::withCount(['users as registered_count', 'users as participants' => function ($query) {
            $query->wherePivot('participated', true);
        }])->latest()->paginate(10);
        return view('admin.events.index', compact('events'));
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
        'event_date' => 'required|date|after:now',
        'start_time' => 'required|date_format:H:i',
        'status' => 'nullable|string|in:upcoming,completed,cancelled'
    ]);

    Event::create([
        'title' => $request->title,
        'description' => $request->description,
        'event_date' => $request->event_date,
        'start_time' => $request->start_time,
        'status' => $request->status ?? 'upcoming',
    ]);

    return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
}


    public function show(Event $event)
    {
        $event->load(['users' => function ($query) {
            $query->where('role', 'student');
        }]);
        return view('admin.events.show', compact('event'));
    }

    public function toggleParticipation(Request $request, Event $event, User $user)
    {
        $event->users()->updateExistingPivot($user->id, ['participated' => $request->participated]);
        return redirect()->route('admin.events.show', $event)->with('success', 'Participation updated.');
    }
}
?>