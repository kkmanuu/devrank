@extends('layouts.app')

@section('content')
    <style>
        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
            color: #fff;
        }
        .sidebar {
            min-height: 100vh;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
            width: 260px;
        }
        .sidebar .nav-link {
            color: #b0bec5;
            font-weight: 500;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            border-radius: 8px;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
        }
        .content {
            padding: 40px;
            width: 100%;
        }
        .card {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.4);
            transition: all 0.3s ease-in-out;
        }
        .card:hover {
            transform: translateY(-8px) scale(1.02);
        }
        .card-title {
            font-size: 1.2rem;
            font-weight: 600;
        }
        .card-text {
            font-size: 2rem;
            font-weight: bold;
        }
        .chart-container {
            background: rgba(255,255,255,0.05);
            padding: 30px;
            border-radius: 20px;
            margin-top: 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }
        .btn-custom {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
            border: none;
        }
        .btn-custom:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
        .event-image {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
        }
        /* Custom Animations */
        .fade-in {
            opacity: 0;
            animation: fadeIn 1s ease-in-out forwards;
        }
        .slide-in {
            opacity: 0;
            transform: translateX(30px);
            animation: slideIn 1s ease-in-out forwards;
        }
        .fade-in.delay-1 {
            animation-delay: 0.5s;
        }
        .slide-in.delay-1 {
            animation-delay: 0.5s;
        }
        .slide-in.delay-2 {
            animation-delay: 1s;
        }
        .slide-in.delay-3 {
            animation-delay: 1.5s;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }
    </style>

    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar d-flex flex-column p-3">
            <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center mb-4 text-white text-decoration-none">
                <span class="fs-4 fw-bold">🚀 DevRank Admin</span>
            </a>
            <ul class="nav nav-pills flex-column mb-auto">
                <li><a href="{{ route('admin.dashboard') }}" class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i>Dashboard</a></li>
                <li><a href="{{ route('admin.users') }}" class="nav-link {{ Route::is('admin.users') ? 'active' : '' }}"><i class="bi bi-people"></i>All Users</a></li>
                <li><a href="{{ route('admin.submissions') }}" class="nav-link {{ Route::is('admin.submissions') ? 'active' : '' }}"><i class="bi bi-file-earmark-text"></i>Code Submissions</a></li>
                <li><a href="{{ route('admin.payments') }}" class="nav-link {{ Route::is('admin.payments') ? 'active' : '' }}"><i class="bi bi-cash-stack"></i>Total Payments</a></li>
                <li><a href="{{ route('admin.contact-messages.index') }}" class="nav-link {{ Route::is('admin.contact-messages.*') ? 'active' : '' }}"><i class="bi bi-envelope"></i>Contact Messages</a></li>
                <li><a href="{{ route('admin.events.index') }}" class="nav-link {{ Route::is('admin.events.*') ? 'active' : '' }}"><i class="bi bi-calendar-week"></i>Event Bookings</a></li>
                <li><a href="{{ route('admin.coaching.index') }}" class="nav-link {{ Route::is('admin.coaching.*') ? 'active' : '' }}"><i class="bi bi-person-video3"></i>Coaching Sessions</a></li>
                <li><a href="{{ route('admin.services.index') }}" class="nav-link {{ Route::is('admin.services.*') ? 'active' : '' }}"><i class="bi bi-gear"></i>Manage Services</a></li>
                <li class="mt-auto">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-start text-danger w-100">
                            <i class="bi bi-box-arrow-right"></i>Logout
                        </button>
                    </form>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="content flex-grow-1">
            <div class="container-fluid">
                <h1 class="mb-4 text-white fw-bold fade-in">Admin Dashboard</h1>

                <a href="{{ route('admin.users.create') }}" class="btn btn-outline-light mb-4 d-inline-flex align-items-center gap-2 fade-in delay-1">
                    <i class="bi bi-person-plus"></i> <span>Create New User</span>
                </a>

                <div class="row">
                    @php
                        $cards = [
                            ['title' => 'Total Users', 'value' => $totalUsers, 'route' => 'admin.users'],
                            ['title' => 'Code Submissions', 'value' => $totalSubmissions, 'route' => 'admin.submissions'],
                            ['title' => 'Pending Reviews', 'value' => $pendingReviews, 'route' => 'admin.submissions'],
                            ['title' => 'Total Payments', 'value' => 'KSH ' . number_format($totalPayments, 2), 'route' => 'admin.payments'],
                            ['title' => 'Unread Messages', 'value' => $pendingMessages, 'route' => 'admin.contact-messages.index'],
                            ['title' => 'Event Bookings', 'value' => $eventBookings, 'route' => 'admin.events.index'],
                            ['title' => 'Coaching Bookings', 'value' => $coachingBookings, 'route' => 'admin.coaching.index'],
                            ['title' => 'Manage Services', 'value' => $totalServices ?? 0, 'route' => 'admin.services.index'],
                            ['title' => 'Add New User', 'value' => '+', 'route' => 'admin.users.create'],
                        ];
                    @endphp

                    @foreach($cards as $index => $card)
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card text-center p-3 slide-in delay-{{ $index % 4 }}">
                                <h5 class="card-title">{{ $card['title'] }}</h5>
                                <p class="card-text">{{ $card['value'] }}</p>
                                <a href="{{ route($card['route']) }}" class="btn btn-custom btn-sm mt-2">Manage</a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Services Management Section -->
                <h3 class="mt-5 text-white fade-in">Manage Services</h3>
                <div class="mb-4 text-end">
                    <a href="{{ route('admin.services.create') }}" class="btn btn-outline-light d-inline-flex align-items-center gap-2 fade-in delay-1">
                        <i class="bi bi-plus-circle"></i> <span>Add New Service</span>
                    </a>
                </div>
                @if($services->isEmpty())
                    <p class="text-white-50 slide-in">No services have been created yet.</p>
                @else
                    <div class="row g-4">
                        @foreach($services as $index => $service)
                            <div class="col-md-4">
                                <div class="card slide-in delay-{{ $index % 3 }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $service->title }}</h5>
                                        <p class="card-text">{{ Str::limit($service->description, 100) }}</p>
                                        <p class="card-text"><strong>Icon:</strong> {{ $service->icon }}</p>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-custom btn-sm">Edit</a>
                                            <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Events Section -->
                <h3 class="mt-5 text-white fade-in">Created Events</h3>
                @if($events->isEmpty())
                    <p class="text-white-50 slide-in">No events have been created yet.</p>
                @else
                    <div class="row g-4">
                        @foreach($events as $index => $event)
                            <div class="col-md-4">
                                <div class="card slide-in delay-{{ $index % 3 }}">
                                    @if($event->image)
                                        <img src="{{ asset('storage/' . $event->image) }}" class="event-image" alt="{{ $event->title }}">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $event->title }}</h5>
                                        <p class="card-text">{{ Str::limit($event->description, 100) }}</p>
                                        <p class="card-text"><strong>Event Date:</strong> {{ $event->event_date->format('Y-m-d') }} {{ $event->start_time }}</p>
                                        <p class="card-text"><strong>Available Slots:</strong> {{ $event->availableSlots() }}</p>
                                        <a href="{{ route('admin.events.show', $event) }}" class="btn btn-custom btn-sm">View Event Details</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Coaching Sessions Section -->
                <h3 class="mt-5 text-white fade-in">Created Coaching Sessions</h3>
                @if($coachingSessions->isEmpty())
                    <p class="text-white-50 slide-in">No coaching sessions available.</p>
                @else
                    <div class="row g-4">
                        @foreach($coachingSessions as $index => $session)
                            <div class="col-md-4">
                                <div class="card slide-in delay-{{ $index % 3 }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $session->topic }}</h5>
                                        <p class="card-text"><strong>Coach Name:</strong> {{ $session->coach->name ?? 'N/A' }}</p>
                                        <p class="card-text"><strong>Session Date:</strong> {{ $session->session_date->format('Y-m-d') }} {{ $session->start_time }}</p>
                                        <p class="card-text"><strong>Available Slots:</strong> {{ $session->availableSlots() }}</p>
                                        <a href="{{ route('admin.coaching.index') }}" class="btn btn-custom btn-sm">View Details</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Contact Messages Section -->
                <h3 class="mt-5 text-white fade-in">Contact Messages</h3>
                <div class="mb-4 text-end">
                    <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-outline-light d-inline-flex align-items-center gap-2 fade-in delay-1">
                        <i class="bi bi-envelope"></i> <span>View All Messages</span>
                    </a>
                </div>
                @if($contactMessages->isEmpty())
                    <p class="text-white-50 slide-in">No contact messages received yet.</p>
                @else
                    <div class="row g-4">
                        @foreach($contactMessages->take(3) as $index => $message)
                            <div class="col-md-4">
                                <div class="card slide-in delay-{{ $index % 3 }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $message->name }}</h5>
                                        <p class="card-text"><strong>Email:</strong> {{ $message->email }}</p>
                                        <p class="card-text"><strong>Company:</strong> {{ $message->company ?? 'N/A' }}</p>
                                        <p class="card-text"><strong>Message:</strong> {{ Str::limit($message->message, 50) }}</p>
                                        <p class="card-text"><strong>Status:</strong> {{ $message->is_read ? 'Read' : 'Unread' }}</p>
                                        <div class="d-flex gap-2">
                                            @if (!$message->is_read)
                                                <form action="{{ route('admin.contact-messages.markAsRead', $message) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-custom btn-sm">Mark as Read</button>
                                                </form>
                                            @endif
                                            <form action="{{ route('admin.contact-messages.destroy', $message) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Chart Section -->
                <div class="chart-container mt-5 fade-in">
                    <h4 class="mb-4 text-white">Platform Performance Overview</h4>
                    <canvas id="adminChart" height="80"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('adminChart').getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(0, 255, 255, 0.7)');
        gradient.addColorStop(1, 'rgba(0, 0, 128, 0.7)');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Submissions', 'Pending Reviews', 'Event Bookings', 'Coaching Bookings', 'Services', 'Messages'],
                datasets: [{
                    label: 'Admin Stats',
                    data: [
                        {{ $totalSubmissions }},
                        {{ $pendingReviews }},
                        {{ $eventBookings }},
                        {{ $coachingBookings }},
                        {{ $totalServices ?? 0 }},
                        {{ $pendingMessages }}
                    ],
                    backgroundColor: gradient,
                    borderColor: 'rgba(255,255,255,0.9)',
                    borderWidth: 2,
                    borderRadius: 10,
                    hoverBackgroundColor: 'rgba(255,255,255,0.2)',
                }]
            },
            options: {
                responsive: true,
                animation: {
                    duration: 1500,
                    easing: 'easeInOutCubic'
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#111',
                        titleColor: '#0ff',
                        bodyColor: '#fff'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { color: '#fff' },
                        grid: { color: 'rgba(255,255,255,0.1)' }
                    },
                    x: {
                        ticks: { color: '#fff' },
                        grid: { color: 'rgba(255,255,255,0.1)' }
                    }
                }
            }
        });
    </script>
@endsection