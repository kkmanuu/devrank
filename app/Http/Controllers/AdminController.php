<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\Booking;
use App\Models\CoachingSession;
use App\Models\ContactMessage;
use App\Models\Event;
use App\Models\Feedback;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Service;
use App\Models\Submission;
use App\Models\User;
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
     * Display the admin dashboard.
     */
    public function adminDashboard()
    {
        $totalUsers = User::count();
        $totalSubmissions = Submission::count();
        $pendingReviews = Submission::where('status', 'pending')->count();
        $totalPayments = Payment::sum('amount');
        $pendingMessages = ContactMessage::where('is_read', false)->count();
        $eventBookings = Booking::where('bookable_type', Event::class)->count();
        $eventParticipants = Booking::where('bookable_type', Event::class)
            ->distinct('user_id')
            ->count('user_id');
        $coachingBookings = Booking::where('bookable_type', CoachingSession::class)->count();
        $events = Event::latest()->take(3)->get();
        $coachingSessions = CoachingSession::with('coach')->latest()->take(3)->get();
        $services = Service::latest()->take(3)->get();
        $totalServices = Service::count();
        $eventRegistrations = $eventBookings;
        $contactMessages = ContactMessage::latest()->take(3)->get();

        // Fetch user-specific notifications
        $user = Auth::user();
        $notifications = $user->notifications()->latest()->take(5)->get();
        $unreadNotificationsCount = $user->unreadNotifications()->count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalSubmissions',
            'pendingReviews',
            'totalPayments',
            'pendingMessages',
            'eventBookings',
            'eventParticipants',
            'eventRegistrations',
            'coachingBookings',
            'events',
            'coachingSessions',
            'services',
            'totalServices',
            'contactMessages',
            'notifications',
            'unreadNotificationsCount'
        ));
    }


    /**
     * Review a submission and provide feedback.
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
            'content' => 'Manual review completed.',
            'correct' => $request->correct,
            'incorrect' => $request->incorrect,
        ]);

        $submission->update([
            'score' => $request->score,
            'status' => 'reviewed',
            'feedback_id' => $feedback->id,
        ]);

        // Award badge for 5+ submissions
        $user = $submission->user;
        if ($user->submissions()->count() >= 5) {
            $user->badges()->attach(Badge::firstOrCreate(['name' => '5 Submissions']));
        }

        return redirect()->route('admin.submissions')->with('success', __('messages.submission_reviewed'));
    }

    /**
     * Show the form to create a new user.
     */
    public function createUser()
    {
        return view('admin.users.create');
    }

    public function index()
    {
        return view('admin.index');
    }
    /**
     * Store a new user.
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

        return redirect()->route('admin.users.create')->with('success', __('messages.user_created'));
    }

    /**
     * Display all users.
     */
    public function users()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Display all submissions.
     */
    public function submissions()
    {
        $submissions = Submission::with('user', 'project')->latest()->get();
        return view('admin.submissions', compact('submissions'));
    }

    /**
     * Display all payments.
     */
    public function payments()
    {
        $payments = Payment::with('user')->latest()->get();
        return view('admin.payments', compact('payments'));
    }

    /**
     * Display all contact messages.
     */
    public function contactMessages()
    {
        $messages = ContactMessage::latest()->get();
        return view('admin.contact-messages.index', compact('messages'));
    }

    /**
     * Mark a contact message as read.
     */
    public function markMessageAsRead(Request $request, ContactMessage $message)
    {
        $message->update(['is_read' => true]);
        return redirect()->route('admin.contact-messages.index')->with('success', 'Message marked as read.');
    }


    // Show edit form
public function editSubmission(Submission $submission)
{
    return view('admin.edit-submission', compact('submission'));
}

// Update submission
public function updateSubmission(Request $request, Submission $submission)
{
    $request->validate([
        'status' => 'required|in:pending,reviewed,rejected',
        'score' => 'nullable|numeric|min:0|max:100'
    ]);

    $submission->update($request->only('status', 'score'));

    return redirect()->route('admin.submissions')->with('success', 'Submission updated successfully.');
}

// Delete submission
public function destroySubmission(Submission $submission)
{
    $submission->delete();
    return redirect()->route('admin.submissions')->with('success', 'Submission deleted successfully.');
}

    /**
     * Reply to a contact message and notify the user.
     */
    public function replyMessage(Request $request, ContactMessage $message)
    {
        $request->validate(['reply' => 'required|string']);

        $message->update([
            'reply' => $request->reply,
            'is_read' => true,
        ]);

        // Create notification for the user
        Notification::create([
            'user_id' => $message->user_id,
            'type' => 'message_reply',
            'message' => "Admin replied to your message: " . Str::limit($request->reply, 100),
        ]);

        return redirect()->route('admin.contact-messages.index')->with('success', 'Reply sent successfully.');
    }

    /**
     * Delete a contact message.
     */
    public function destroyMessage(Request $request, ContactMessage $message)
    {
        $message->delete();
        return redirect()->route('admin.contact-messages.index')->with('success', 'Message deleted successfully.');
    }

    /**
     * Display all events.
     */
    public function events()
    {
        $events = Event::latest()->get();
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form to create a new event.
     */
    public function createEvent()
    {
        return view('admin.events.create');
    }

    /**
     * Store a new event and notify students.
     */
    public function storeEvent(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'agenda' => 'nullable|string',
            'about' => 'nullable|string',
            'faqs' => 'nullable|array',
            'faqs.*.question' => 'required_with:faqs|string',
            'faqs.*.answer' => 'required_with:faqs|string',
            'event_date' => 'required|date',
            'start_time' => 'required',
            'capacity' => 'required|integer|min:1',
             'amount' => 'required|numeric|min:0',
            'location' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:upcoming,completed,cancelled',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('events', 'public');
        }
        if ($request->faqs) {
            $data['faqs'] = json_encode($request->faqs);
        }

        $event = Event::create($data);

        // Notify all students
        $students = User::where('role', 'student')->get();
        foreach ($students as $student) {
            Notification::create([
                'user_id' => $student->id,
                'type' => 'event',
                'message' => "New event created: {$event->title} on {$event->event_date->format('F d, Y')}",
            ]);
        }

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }

    /**
     * Show event details.
     */
    public function showEvent(Event $event)
    {
        $event->load(['bookings.user' => function ($query) {
            $query->where('role', 'student');
        }]);
        return view('admin.events.show', compact('event'));
    }

    /**
     * Display all coaching sessions.
     */
    public function coachingSessions()
    {
        $sessions = CoachingSession::with('coach')->latest()->get();
        return view('admin.coaching.index', compact('sessions'));
    }

    /**
     * Show the form to create a new coaching session.
     */
    public function createCoachingSession()
    {
        $coaches = User::where('role', 'coach')->get();
        return view('admin.coaching.create', compact('coaches'));
    }

    /**
     * Store a new coaching session and notify students.
     */
    public function storeCoachingSession(Request $request)
    {
        $request->validate([
            'topic' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'nullable|string',
            'developer_type' => 'required|in:fresher,professional',
            'coach_id' => 'required|exists:users,id',
            'session_date' => 'required|date',
            'start_time' => 'required',
            'capacity' => 'required|integer|min:1',
            'amount' => 'required|numeric|min:0', // Added price validation
            'status' => 'required|in:upcoming,completed,cancelled',
        ]);

        $session = CoachingSession::create($request->all());

        // Notify all students
        $students = User::where('role', 'student')->get();
        foreach ($students as $student) {
            Notification::create([
                'user_id' => $student->id,
                'type' => 'coaching',
                'message' => "New coaching session created: {$session->topic} on {$session->session_date->format('F d, Y')}",
            ]);
        }

        return redirect()->route('admin.coaching.index')->with('success', 'Coaching session created successfully.');
    }

    /**
     * Display all services.
     */
    public function services()
    {
        $services = Service::latest()->get();
        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form to create a new service.
     */
    public function createService()
    {
        return view('admin.services.create');
    }

    /**
     * Store a new service.
     */
    public function storeService(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string',
        ]);

        Service::create($request->all());

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
    }

    /**
     * Show the form to edit a service.
     */
    public function editService(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update a service.
     */
    public function updateService(Request $request, Service $service)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string',
        ]);

        $service->update($request->all());

        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully.');
    }

    /**
     * Delete a service.
     */
    public function destroyService(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully.');
    }
}