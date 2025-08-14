@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary-color: #0ff;
        --secondary-color: #8a2be2;
        --accent-color: #00cccc;
        --dark-bg: #0f1419;
        --card-bg: rgba(255, 255, 255, 0.08);
        --text-primary: #ffffff;
        --text-secondary: #b0bec5;
        --success-color: #4caf50;
        --warning-color: #ff9800;
        --danger-color: #f44336;
    }

    body {
        font-family: 'Inter', 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #0f1419 0%, #1a1f2e 50%, #2d3748 100%);
        color: var(--text-primary);
        margin: 0;
        overflow-x: hidden;
        min-height: 100vh;
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }
    ::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
    }
    ::-webkit-scrollbar-thumb {
        background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
        border-radius: 10px;
    }

    /* Sidebar Styling */
    .sidebar {
        min-height: 100vh;
        background: rgba(15, 20, 25, 0.95);
        backdrop-filter: blur(20px);
        border-right: 1px solid rgba(255, 255, 255, 0.1);
        padding: 20px;
        width: 260px;
        position: sticky;
        top: 0;
        transition: all 0.3s ease;
    }

    .sidebar .brand {
        display: flex;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        text-decoration: none;
    }

    .sidebar .brand span {
        font-size: 1.5rem;
        font-weight: 700;
        background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .sidebar .nav-link {
        color: var(--text-secondary);
        font-weight: 500;
        font-size: 0.95rem;
        border-radius: 12px;
        padding: 12px 16px;
        margin-bottom: 8px;
        transition: all 0.3s ease;
        border: 1px solid transparent;
        text-decoration: none;
    }

    .sidebar .nav-link:hover {
        color: var(--text-primary);
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(0, 255, 255, 0.3);
        transform: translateX(4px);
    }

    .sidebar .nav-link.active {
        background: linear-gradient(135deg, rgba(0, 255, 255, 0.15), rgba(138, 43, 226, 0.15));
        color: var(--text-primary);
        border-color: var(--primary-color);
        box-shadow: 0 4px 15px rgba(0, 255, 255, 0.2);
    }

    .sidebar .nav-link i {
        margin-right: 12px;
        width: 20px;
        text-align: center;
    }

    /* Main Content */
    .content {
        padding: 30px;
        width: 100%;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 2rem;
    }

    /* Enhanced Cards */
    .card {
        background: var(--card-bg);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        color: white;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(10px);
    }

    .card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(0, 255, 255, 0.15);
        border-color: rgba(0, 255, 255, 0.3);
    }

    .card-header {
        background: linear-gradient(135deg, rgba(0, 255, 255, 0.1), rgba(138, 43, 226, 0.1));
        border: none;
        padding: 20px;
        border-radius: 16px 16px 0 0 !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0;
        color: var(--text-primary);
    }

    .card-body {
        padding: 20px;
    }

    /* Progress Rings */
    .progress-ring {
        position: relative;
        width: 80px;
        height: 80px;
        margin: 0 auto 1rem;
    }

    .progress-ring svg {
        transform: rotate(-90deg);
        width: 100%;
        height: 100%;
    }

    .progress-ring circle {
        fill: none;
        stroke-width: 6;
        stroke-linecap: round;
    }

    .progress-ring .bg {
        stroke: rgba(255, 255, 255, 0.1);
    }

    .progress-ring .fg {
        stroke: url(#progressGradient);
        stroke-dasharray: 251.2;
        stroke-dashoffset: calc(251.2 - (251.2 * var(--progress)) / 100);
        transition: stroke-dashoffset 1s ease-in-out;
    }

    .progress-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-weight: 700;
        font-size: 0.9rem;
        color: var(--text-primary);
    }

    /* Buttons */
    .btn-custom {
        background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 255, 255, 0.3);
        color: white;
    }

    .btn-sm {
        padding: 6px 12px;
        font-size: 0.875rem;
    }

    /* Notifications */
    .notification-card {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 16px;
        border-left: 4px solid transparent;
        transition: all 0.3s ease;
    }

    .notification-card.unread {
        border-left-color: var(--primary-color);
        background: rgba(0, 255, 255, 0.08);
    }

    .notification-card:hover {
        background: rgba(255, 255, 255, 0.08);
    }

    .notification-card p {
        margin: 0 0 8px 0;
        font-size: 0.9rem;
    }

    .notification-card p:last-child {
        margin-bottom: 0;
        color: var(--text-secondary);
        font-size: 0.8rem;
    }

    /* Charts Container */
    .chart-container {
        background: var(--card-bg);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 24px;
        backdrop-filter: blur(10px);
    }

    .chart-container h5 {
        color: var(--text-primary);
        margin-bottom: 20px;
        font-weight: 600;
    }

    .chart-container canvas {
        max-height: 250px;
    }

    /* Event Cards */
    .event-image {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 8px;
    }

    /* Coach Profile */
    .coach-profile-img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: 2px solid var(--primary-color);
        object-fit: cover;
        margin-right: 12px;
    }

    /* Alert Styling */
    .alert-success {
        background: rgba(76, 175, 80, 0.15);
        border: 1px solid rgba(76, 175, 80, 0.3);
        color: var(--success-color);
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 24px;
    }

    /* Section Headings */
    h3 {
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
    }

    h3 i {
        margin-right: 8px;
        color: var(--primary-color);
    }

    /* Text Colors */
    .text-white {
        color: var(--text-primary) !important;
    }

    .text-white-50 {
        color: var(--text-secondary) !important;
    }

    /* Mobile Responsiveness */
    @media (max-width: 768px) {
        .sidebar {
            width: 100%;
            min-height: auto;
            position: relative;
        }
        
        .content {
            padding: 20px 15px;
        }
        
        .page-title {
            font-size: 1.5rem;
        }
        
        .card {
            margin-bottom: 16px;
        }
        
        .chart-container canvas {
            max-height: 180px;
        }
        
        .progress-ring {
            width: 60px;
            height: 60px;
        }
    }

    /* Animation */
    .fade-in {
        animation: fadeIn 0.6s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="d-flex">
    <!-- Sidebar -->
    <nav class="sidebar d-flex flex-column p-3">
        <a href="{{ route('dashboard') }}" class="brand">
            <span>DevRank</span>
        </a>
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('project.create') }}" class="nav-link {{ Route::is('project.create') ? 'active' : '' }}">
                    <i class="bi bi-code-slash"></i>Submit Project
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('coaching.index') }}" class="nav-link {{ Route::is('coaching.index') ? 'active' : '' }}">
                    <i class="bi bi-person-video3"></i>Coaching
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('messages.index') }}" class="nav-link {{ Route::is('messages.index') ? 'active' : '' }}">
                    <i class="bi bi-chat-square-text"></i>Messages
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('profile.edit') }}" class="nav-link {{ Route::is('profile.edit') ? 'active' : '' }}">
                    <i class="bi bi-person"></i>Profile
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right"></i>Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="content flex-grow-1">
        <div class="container-fluid">
            <h1 class="page-title">Welcome to Your Dashboard</h1>

            @if (session('success'))
                <div class="alert alert-success fade-in">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Statistics Section -->
            <h3 class="mt-4"><i class="bi bi-graph-up"></i>Your Stats</h3>
            <div class="row g-3 mb-4 fade-in">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Project Completion</h5>
                        </div>
                        <div class="card-body text-center">
                            <div class="progress-ring" style="--progress: {{ $submissionCount * 25 }}">
                                <svg>
                                    <defs>
                                        <linearGradient id="progressGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#0ff" />
                                            <stop offset="100%" stop-color="#8a2be2" />
                                        </linearGradient>
                                    </defs>
                                    <circle class="bg" cx="40" cy="40" r="35"></circle>
                                    <circle class="fg" cx="40" cy="40" r="35"></circle>
                                </svg>
                                <div class="progress-text">{{ $submissionCount }}/4</div>
                            </div>
                            <p>{{ $submissionCount }} of 4 Projects</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Average Score</h5>
                        </div>
                        <div class="card-body text-center">
                            <div class="progress-ring" style="--progress: {{ $submissions->avg('score') ?? 0 }}">
                                <svg>
                                    <circle class="bg" cx="40" cy="40" r="35"></circle>
                                    <circle class="fg" cx="40" cy="40" r="35"></circle>
                                </svg>
                                <div class="progress-text">{{ round($submissions->avg('score') ?? 0) }}%</div>
                            </div>
                            <p>{{ round($submissions->avg('score') ?? 0) }}%</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Coaching Sessions</h5>
                        </div>
                        <div class="card-body text-center">
                            <div class="progress-ring" style="--progress: {{ count($coachingSessions) * 20 }}">
                                <svg>
                                    <circle class="bg" cx="40" cy="40" r="35"></circle>
                                    <circle class="fg" cx="40" cy="40" r="35"></circle>
                                </svg>
                                <div class="progress-text">{{ count($coachingSessions) }}</div>
                            </div>
                            <p>{{ count($coachingSessions) }} Sessions</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Balance Section -->
            <div class="row g-3 mb-4 fade-in">
                <div class="col-md-8">
                    <div class="card" style="background: linear-gradient(135deg, rgba(0, 255, 255, 0.1), rgba(138, 43, 226, 0.1)); border: 1px solid rgba(0, 255, 255, 0.3);">
                        <div class="card-header">
                            <h5 class="card-title"><i class="bi bi-wallet2 me-2"></i>Account Balance</h5>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="text-center">
                                        <div style="font-size: 2.5rem; font-weight: 700; color: var(--primary-color); margin-bottom: 0.5rem;">
                                            ${{ number_format($accountBalance ?? 0, 2) }}
                                        </div>
                                        <p class="text-secondary">Available Balance</p>
                                        <a href="{{ route('payment') }}" class="btn btn-custom">
                                            <i class="bi bi-plus-circle me-2"></i>Add Funds
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="mb-3">Recent Payments</h6>
                                    @if(isset($recentPayments) && $recentPayments->isNotEmpty())
                                        @foreach($recentPayments->take(3) as $payment)
                                            <div class="d-flex justify-content-between align-items-center mb-2 p-2" style="background: rgba(255,255,255,0.05); border-radius: 6px;">
                                                <div>
                                                    <small class="text-primary">${{ number_format($payment->amount, 2) }}</small><br>
                                                    <small class="text-secondary">{{ $payment->created_at->format('M d, Y') }}</small>
                                                </div>
                                                <span class="badge {{ $payment->status == 'completed' ? 'bg-success' : 'bg-warning' }}">
                                                    {{ ucfirst($payment->status) }}
                                                </span>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-secondary small">No payment history yet.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title"><i class="bi bi-graph-up me-2"></i>Total Spent</h5>
                        </div>
                        <div class="card-body text-center">
                            <div style="font-size: 2rem; font-weight: 700; color: var(--secondary-color); margin-bottom: 1rem;">
                                ${{ number_format($totalPayments ?? 0, 2) }}
                            </div>
                            <p class="text-secondary">Lifetime Total</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notifications Section -->
            <h3><i class="bi bi-bell"></i>Notifications</h3>
            @if($notifications->isEmpty())
                <p class="text-white-50">No new notifications.</p>
            @else
                <div class="row g-3 fade-in">
                    @foreach($notifications as $notification)
                        <div class="col-md-12">
                            <div class="notification-card {{ !$notification->is_read ? 'unread' : '' }}">
                                <p><strong>{{ $notification->type }}:</strong> {{ $notification->message }}</p>
                                <p class="text-white-50">{{ $notification->created_at->format('F d, Y H:i') }}</p>
                                @if(!$notification->is_read)
                                    <form action="{{ route('notifications.markAsRead', $notification) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-custom btn-sm">Mark as Read</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Charts Section -->
            <h3 class="mt-4"><i class="bi bi-bar-chart"></i>Performance Analytics</h3>
            <div class="row g-3 mb-4 fade-in">
                <div class="col-md-6">
                    <div class="chart-container">
                        <h5 class="mb-2">Submission Scores</h5>
                        <canvas id="scoresLineChart"></canvas>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="chart-container">
                        <h5 class="mb-2">Skills Distribution</h5>
                        <canvas id="skillsDoughnutChart"></canvas>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="chart-container">
                        <h5 class="mb-2">Monthly Progress</h5>
                        <canvas id="monthlyBarChart"></canvas>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="chart-container">
                        <h5 class="mb-2">Performance Metrics</h5>
                        <canvas id="performanceRadarChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Project Submissions Section -->
            <div class="row mb-4 fade-in">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title"><i class="bi bi-code-slash me-2"></i>Project Submissions</h5>
                        </div>
                        <div class="card-body">
                            <p>You have submitted <strong>{{ $submissionCount }}</strong> out of <strong>4</strong> allowed projects.</p>
                            @if(!$canSubmit)
                                <p class="text-danger">You've reached your submission limit.</p>
                                <a href="{{ route('payment.initiate') }}" class="btn btn-custom">Make Payment</a>
                            @else
                                <a href="{{ route('project.create') }}" class="btn btn-custom">Submit New Project</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Your Submissions Section -->
            <h3><i class="bi bi-file-earmark-code"></i>Your Submissions</h3>
            @if($submissions->isEmpty())
                <p class="text-white-50">No submissions yet.</p>
            @else
                <div class="row g-3 fade-in">
                    @foreach($submissions as $submission)
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">{{ $submission->project->title ?? 'Untitled' }}</h5>
                                </div>
                                <div class="card-body">
                                    <p><strong>Score:</strong> {{ $submission->score ?? 'Pending' }}</p>
                                    <p><strong>Status:</strong> {{ ucfirst($submission->status ?? 'pending') }}</p>
                                    @if($submission->feedback)
                                        <p><strong>Correct:</strong> {{ Str::limit($submission->feedback->correct, 60) }}</p>
                                        <p><strong>Incorrect:</strong> {{ Str::limit($submission->feedback->incorrect, 60) }}</p>
                                    @endif
                                    <a href="{{ route('submission.show', $submission) }}" class="btn btn-custom btn-sm">View Details</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Recent Events Section -->
            <h3 class="mt-4"><i class="bi bi-calendar-event"></i>Recent Events</h3>
            @if($recentEvents->isEmpty())
                <p class="text-white-50">No recent events available.</p>
            @else
                <div class="row g-3 fade-in">
                    @foreach($recentEvents as $event)
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">{{ $event->title }}</h5>
                                </div>
                                @if($event->image)
                                    <img src="{{ asset('storage/' . $event->image) }}" class="event-image" alt="{{ $event->title }}">
                                @endif
                                <div class="card-body">
                                    <p class="card-text">{{ Str::limit($event->description, 80) }}</p>
                                    <p class="card-text"><strong>Date:</strong> {{ $event->event_date->format('F d, Y') }}</p>
                                    <p class="card-text"><strong>Time:</strong> {{ $event->start_time }}</p>
                                    <a href="{{ route('events.show', $event) }}" class="btn btn-custom btn-sm">View Details</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Upcoming Events Section -->
            <h3 class="mt-4"><i class="bi bi-calendar-plus"></i>Upcoming Events</h3>
            @if($upcomingEvents->isEmpty())
                <p class="text-white-50">No upcoming events available.</p>
            @else
                <div class="row g-3 fade-in">
                    @foreach($upcomingEvents as $event)
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">{{ $event->title }}</h5>
                                </div>
                                @if($event->image)
                                    <img src="{{ asset('storage/' . $event->image) }}" class="event-image" alt="{{ $event->title }}">
                                @endif
                                <div class="card-body">
                                    <p class="card-text">{{ Str::limit($event->description, 80) }}</p>
                                    <p class="card-text"><strong>Date:</strong> {{ $event->event_date->format('F d, Y') }}</p>
                                    <p class="card-text"><strong>Time:</strong> {{ $event->start_time }}</p>
                                    <a href="{{ route('events.show', $event) }}" class="btn btn-custom btn-sm">View Details</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Coaching Sessions Section -->
            <h3 class="mt-4"><i class="bi bi-person-video3"></i>Your Coaching Sessions</h3>
            @if($coachingSessions->isEmpty())
                <p class="text-white-50">No coaching sessions scheduled.</p>
            @else
                <div class="row g-3 fade-in">
                    @foreach($coachingSessions as $session)
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">{{ $session->topic ?? 'Session' }}</h5>
                                </div>
                                <div class="card-body d-flex align-items-center">
                                    @if($session->coach->profile_image)
                                        <img src="{{ asset('storage/' . $session->coach->profile_image) }}" class="coach-profile-img" alt="{{ $session->coach->name ?? 'Coach' }}">
                                    @endif
                                    <div>
                                        <p><strong>Coach:</strong> {{ $session->coach->name ?? 'TBA' }}</p>
                                        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($session->session_date)->format('F d, Y') }}</p>
                                        <p><strong>Time:</strong> {{ $session->start_time }}</p>
                                        <p><strong>Status:</strong> {{ ucfirst($session->status) }}</p>
                                        <a href="{{ route('coaching.show', $session) }}" class="btn btn-custom btn-sm">View Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart.js Gradient
    const createGradient = (ctx, height) => {
        const gradient = ctx.createLinearGradient(0, 0, 0, height);
        gradient.addColorStop(0, '#0ff');
        gradient.addColorStop(1, '#8a2be2');
        return gradient;
    };

    // Line Chart - Submission Scores
    const scoresLineChart = document.getElementById('scoresLineChart').getContext('2d');
    new Chart(scoresLineChart, {
        type: 'line',
        data: {
            labels: {!! json_encode($submissions->pluck('project.title')) !!},
            datasets: [{
                label: 'Submission Scores',
                data: {!! json_encode($submissions->pluck('score')->map(fn($score) => $score ?? 0)) !!},
                borderColor: createGradient(scoresLineChart, 200),
                backgroundColor: 'rgba(0, 255, 255, 0.2)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#0ff',
                pointRadius: 3,
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true, max: 100, ticks: { color: '#fff', font: { size: 10 } }, grid: { color: 'rgba(255,255,255,0.1)' } },
                x: { ticks: { color: '#fff', font: { size: 10 } }, grid: { color: 'rgba(255,255,255,0.1)' } }
            },
            plugins: {
                legend: { display: true, labels: { color: '#fff', font: { size: 10 } } },
                tooltip: { backgroundColor: '#111', titleColor: '#0ff', bodyColor: '#fff', titleFont: { size: 10 }, bodyFont: { size: 10 } }
            }
        }
    });

    // Doughnut Chart - Skills Distribution
    const skillsDoughnutChart = document.getElementById('skillsDoughnutChart').getContext('2d');
    new Chart(skillsDoughnutChart, {
        type: 'doughnut',
        data: {
            labels: ['Frontend', 'Backend', 'Database', 'DevOps'],
            datasets: [{
                data: [30, 25, 20, 25],
                backgroundColor: ['#0ff', '#8a2be2', '#00cccc', '#6a0dad'],
                borderColor: '#fff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom', labels: { color: '#fff', font: { size: 10 } } },
                tooltip: { backgroundColor: '#111', titleColor: '#0ff', bodyColor: '#fff', titleFont: { size: 10 }, bodyFont: { size: 10 } }
            }
        }
    });

    // Bar Chart - Monthly Progress
    const monthlyBarChart = document.getElementById('monthlyBarChart').getContext('2d');
    new Chart(monthlyBarChart, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Monthly Scores',
                data: [65, 70, 80, 85, 90, 95],
                backgroundColor: createGradient(monthlyBarChart, 200),
                borderColor: '#fff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true, max: 100, ticks: { color: '#fff', font: { size: 10 } }, grid: { color: 'rgba(255,255,255,0.1)' } },
                x: { ticks: { color: '#fff', font: { size: 10 } }, grid: { color: 'rgba(255,255,255,0.1)' } }
            },
            plugins: {
                legend: { display: true, labels: { color: '#fff', font: { size: 10 } } },
                tooltip: { backgroundColor: '#111', titleColor: '#0ff', bodyColor: '#fff', titleFont: { size: 10 }, bodyFont: { size: 10 } }
            }
        }
    });

    // Radar Chart - Performance Metrics
    const performanceRadarChart = document.getElementById('performanceRadarChart').getContext('2d');
    new Chart(performanceRadarChart, {
        type: 'radar',
        data: {
            labels: ['Code Quality', 'Efficiency', 'Creativity', 'Problem Solving', 'Collaboration'],
            datasets: [{
                label: 'Performance',
                data: [80, 85, 70, 90, 75],
                backgroundColor: 'rgba(0, 255, 255, 0.2)',
                borderColor: createGradient(performanceRadarChart, 200),
                pointBackgroundColor: '#fff',
                pointBorderColor: '#0ff',
                pointRadius: 2
            }]
        },
        options: {
            responsive: true,
            scales: {
                r: {
                    ticks: { color: '#fff', backdropColor: 'transparent', font: { size: 10 } },
                    grid: { color: 'rgba(255,255,255,0.1)' },
                    pointLabels: { color: '#fff', font: { size: 10 } }
                }
            },
            plugins: {
                legend: { display: true, labels: { color: '#fff', font: { size: 10 } } },
                tooltip: { backgroundColor: '#111', titleColor: '#0ff', bodyColor: '#fff', titleFont: { size: 10 }, bodyFont: { size: 10 } }
            }
        }
    });
</script>
@endsection