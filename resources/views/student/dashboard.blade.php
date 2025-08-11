@extends('layouts.app')

@section('content')
<style>
    body {
        font-family: 'Inter', 'Segoe UI', sans-serif;
        background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
        color: #fff;
        margin: 0;
        overflow-x: hidden;
    }
    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 6px;
    }
    ::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 8px;
    }
    ::-webkit-scrollbar-thumb {
        background: linear-gradient(45deg, #0ff, #8a2be2);
        border-radius: 8px;
    }
    .sidebar {
        min-height: 100vh;
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border-right: 1px solid rgba(255, 255, 255, 0.1);
        padding: 15px;
        width: 200px;
        position: sticky;
        top: 0;
    }
    .sidebar .nav-link {
        color: #b0bec5;
        font-weight: 500;
        font-size: 0.9rem;
        border-radius: 6px;
        padding: 8px 12px;
        margin-bottom: 8px;
    }
    .sidebar .nav-link.active {
        background: linear-gradient(45deg, #0ff, #8a2be2);
        color: #fff;
    }
    .sidebar .nav-link i {
        margin-right: 8px;
    }
    .content {
        padding: 20px;
        width: 100%;
    }
    .card {
        background: linear-gradient(135deg, rgba(30, 60, 114, 0.8), rgba(42, 82, 152, 0.8));
        color: white;
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.4);
        backdrop-filter: blur(6px);
    }
    .card-header {
        background: linear-gradient(45deg, #0ff, #8a2be2);
        padding: 8px 15px;
        border-radius: 10px 10px 0 0;
        margin: -1px;
    }
    .card-title {
        font-size: 1rem;
        font-weight: 600;
        margin: 0;
    }
    .card-body {
        padding: 15px;
    }
    .btn-custom {
        background: linear-gradient(45deg, #0ff, #8a2be2);
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 6px 12px;
        font-size: 0.85rem;
    }
    .btn-custom:hover {
        background: linear-gradient(45deg, #00cccc, #6a0dad);
    }
    .chart-container {
        background: rgba(255,255,255,0.05);
        padding: 15px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        backdrop-filter: blur(10px);
    }
    .chart-container canvas {
        max-height: 200px;
    }
    .notification-card {
        background: rgba(255,255,255,0.05);
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 12px;
    }
    .notification-card.unread {
        border-left: 3px solid #0ff;
    }
    .notification-card p {
        font-size: 0.85rem;
        margin: 0 0 5px;
    }
    .progress-ring {
        position: relative;
        width: 70px;
        height: 70px;
        margin: 10px auto;
    }
    .progress-ring circle {
        fill: none;
        stroke-width: 6;
        stroke-linecap: round;
        transform: rotate(-90deg);
        transform-origin: 50% 50%;
    }
    .progress-ring .bg {
        stroke: rgba(255,255,255,0.1);
    }
    .progress-ring .fg {
        stroke: url(#progressGradient);
        stroke-dasharray: 188;
        stroke-dashoffset: calc(188 - (188 * var(--progress)) / 100);
    }
    .coach-profile-img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #0ff;
        margin-right: 8px;
    }
    h1 {
        font-size: 1.5rem;
        font-weight: 700;
    }
    h3 {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 15px;
    }
    p {
        font-size: 0.9rem;
    }
    @media (max-width: 768px) {
        .sidebar {
            width: 100%;
            min-height: auto;
            position: relative;
        }
        .content {
            padding: 15px;
        }
        .card {
            margin-bottom: 15px;
        }
        .chart-container canvas {
            max-height: 150px;
        }
    }
</style>

<div class="d-flex">
    <!-- Sidebar -->
    <nav class="sidebar d-flex flex-column p-3">
        <a href="{{ route('dashboard') }}" class="d-flex align-items-center mb-3 text-white text-decoration-none">
            <span class="fs-5 fw-bold">DevRank</span>
        </a>
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}"><i class="bi bi-house"></i>Dashboard</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('project.create') }}" class="nav-link {{ Route::is('project.create') ? 'active' : '' }}"><i class="bi bi-code-slash"></i>Submit Project</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('coaching.index') }}" class="nav-link {{ Route::is('coaching.index') ? 'active' : '' }}"><i class="bi bi-person-video3"></i>Coaching</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('messages.index') }}" class="nav-link {{ Route::is('messages.index') ? 'active' : '' }}"><i class="bi bi-chat-square-text"></i>Messages</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('profile.edit') }}" class="nav-link {{ Route::is('profile.edit') ? 'active' : '' }}"><i class="bi bi-person"></i>Profile</a>
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
            <h1 class="mb-3 text-white fw-bold">Welcome to Your Dashboard</h1>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Statistics Section -->
            <h3 class="mt-4 text-white">Your Stats</h3>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Project Completion</h5>
                        </div>
                        <div class="card-body text-center">
                            <svg class="progress-ring" style="--progress: {{ $submissionCount * 25 }}">
                                <defs>
                                    <linearGradient id="progressGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#0ff" />
                                        <stop offset="100%" stop-color="#8a2be2" />
                                    </linearGradient>
                                </defs>
                                <circle class="bg" cx="35" cy="35" r="30"></circle>
                                <circle class="fg" cx="35" cy="35" r="30"></circle>
                            </svg>
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
                            <svg class="progress-ring" style="--progress: {{ $submissions->avg('score') ?? 0 }}">
                                <circle class="bg" cx="35" cy="35" r="30"></circle>
                                <circle class="fg" cx="35" cy="35" r="30"></circle>
                            </svg>
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
                            <svg class="progress-ring" style="--progress: {{ count($coachingSessions) * 20 }}">
                                <circle class="bg" cx="35" cy="35" r="30"></circle>
                                <circle class="fg" cx="35" cy="35" r="30"></circle>
                            </svg>
                            <p>{{ count($coachingSessions) }} Sessions</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notifications Section -->
            <h3 class="text-white">Notifications</h3>
            @if($notifications->isEmpty())
                <p class="text-white-50">No new notifications.</p>
            @else
                <div class="row g-3">
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
            <h3 class="mt-4 text-white">Performance Analytics</h3>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="chart-container">
                        <h5 class="mb-2 text-white">Submission Scores</h5>
                        <canvas id="scoresLineChart"></canvas>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="chart-container">
                        <h5 class="mb-2 text-white">Skills Distribution</h5>
                        <canvas id="skillsDoughnutChart"></canvas>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="chart-container">
                        <h5 class="mb-2 text-white">Monthly Progress</h5>
                        <canvas id="monthlyBarChart"></canvas>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="chart-container">
                        <h5 class="mb-2 text-white">Performance Metrics</h5>
                        <canvas id="performanceRadarChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Project Submissions Section -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Project Submissions</h5>
                        </div>
                        <div class="card-body">
                            <p>You have submitted <strong>{{ $submissionCount }}</strong> out of <strong>4</strong> allowed projects.</p>
                            @if(!$canSubmit)
                                <p class="text-danger">You’ve reached your submission limit.</p>
                                <a href="{{ route('payment.initiate') }}" class="btn btn-custom">Make Payment</a>
                            @else
                                <a href="{{ route('project.create') }}" class="btn btn-custom">Submit New Project</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Your Submissions Section -->
            <h3 class="text-white">Your Submissions</h3>
            @if($submissions->isEmpty())
                <p class="text-white-50">No submissions yet.</p>
            @else
                <div class="row g-3">
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
            <h3 class="mt-4 text-white">Recent Events</h3>
            @if($recentEvents->isEmpty())
                <p class="text-white-50">No recent events available.</p>
            @else
                <div class="row g-3">
                    @foreach($recentEvents as $event)
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">{{ $event->title }}</h5>
                                </div>
                                @if($event->image)
                                    <img src="{{ asset('storage/' . $event->image) }}" class="event-image" alt="{{ $event->title }}" style="width: 100%; height: 120px; object-fit: cover;">
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
            <h3 class="mt-4 text-white">Upcoming Events</h3>
            @if($upcomingEvents->isEmpty())
                <p class="text-white-50">No upcoming events available.</p>
            @else
                <div class="row g-3">
                    @foreach($upcomingEvents as $event)
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">{{ $event->title }}</h5>
                                </div>
                                @if($event->image)
                                    <img src="{{ asset('storage/' . $event->image) }}" class="event-image" alt="{{ $event->title }}" style="width: 100%; height: 120px; object-fit: cover;">
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
            <h3 class="mt-4 text-white">Your Coaching Sessions</h3>
            @if($coachingSessions->isEmpty())
                <p class="text-white-50">No coaching sessions scheduled.</p>
            @else
                <div class="row g-3">
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