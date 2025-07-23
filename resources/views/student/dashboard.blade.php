@extends('layouts.app')

@section('content')
<div class="d-flex">
    <!-- Sidebar -->
    <nav class="sidebar d-flex flex-column p-3 bg-primary text-white" style="min-height: 100vh;">
        <a href="{{ route('dashboard') }}" class="d-flex align-items-center mb-4 text-white text-decoration-none">
            <span class="fs-4">DevRank</span>
        </a>
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link text-white {{ Route::is('dashboard') ? 'active bg-white text-primary' : '' }}"><i class="bi bi-house me-2"></i>Dashboard</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('project.create') }}" class="nav-link text-white {{ Route::is('project.create') ? 'active bg-white text-primary' : '' }}"><i class="bi bi-code-slash me-2"></i>Submit Project</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('coaching.index') }}" class="nav-link text-white {{ Route::is('coaching.index') ? 'active bg-white text-primary' : '' }}"><i class="bi bi-person-video3 me-2"></i>Coaching</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('messages.index') }}" class="nav-link text-white {{ Route::is('messages.index') ? 'active bg-white text-primary' : '' }}"><i class="bi bi-chat-square-text me-2"></i>Messages</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('profile.edit') }}" class="nav-link text-white {{ Route::is('profile.edit') ? 'active bg-white text-primary' : '' }}"><i class="bi bi-person me-2"></i>Profile</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link text-white" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="content flex-grow-1 p-4">
        <div class="container">
            <h1 class="mb-4 animate__animated animate__fadeIn">Welcome to Your Dashboard</h1>

            @if (session('success'))
                <div class="alert alert-success animate__animated animate__fadeIn">{{ session('success') }}</div>
            @endif

            <div class="row mb-5">
                <div class="col-md-6">
                    <div class="card p-4">
                        <h5 class="mb-3">Project Submissions</h5>
                        <p>You have submitted <strong>{{ $submissionCount }}</strong> out of <strong>4</strong> allowed projects.</p>
                        @if(!$canSubmit)
                            <p class="text-danger">You’ve reached your submission limit.</p>
                            <a href="{{ route('payment.initiate') }}" class="btn btn-primary">Make Payment</a>
                        @else
                            <a href="{{ route('project.create') }}" class="btn btn-success">Submit New Project</a>
                        @endif
                    </div>
                </div>
                <div class="col-md-6 d-flex align-items-center justify-content-center">
                    <div class="chart-container" style="max-width: 300px;">
                        <canvas id="submissionChart"></canvas>
                    </div>
                </div>
            </div>

            <h3 class="mb-3">Your Submissions</h3>
            @if($submissions->isEmpty())
                <p>No submissions yet.</p>
            @else
                <div class="row g-4">
                    @foreach($submissions as $submission)
                        <div class="col-md-6">
                            <div class="card p-3">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $submission->project->title ?? 'Untitled' }}</h5>
                                    <p><strong>Score:</strong> {{ $submission->score ?? 'Pending' }}</p>
                                    <p><strong>Status:</strong> {{ ucfirst($submission->status ?? 'pending') }}</p>
                                    @if($submission->feedback)
                                        <p><strong>Correct:</strong> {{ Str::limit($submission->feedback->correct, 80) }}</p>
                                        <p><strong>Incorrect:</strong> {{ Str::limit($submission->feedback->incorrect, 80) }}</p>
                                    @endif
                                    <a href="{{ route('submission.show', $submission) }}" class="btn btn-outline-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="row mt-5">
                <div class="col-md-6">
                    <h3>Coaching Sessions</h3>
                    @if($coachingSessions->isEmpty())
                        <p>No coaching sessions scheduled.</p>
                    @else
                        <div class="row g-4">
                            @foreach($coachingSessions as $session)
                                <div class="col-md-12">
                                    <div class="card p-3">
                                        <div class="card-body">
                                            <h5>{{ $session->topic ?? 'Session' }}</h5>
                                            <p><strong>Coach:</strong> {{ $session->coach->name ?? 'TBA' }}</p>
                                            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($session->session_date)->format('Y-m-d H:i') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <h3>Scores Overview</h3>
                    <div class="chart-container" style="max-width: 300px;">
                        <canvas id="scoreChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Doughnut Chart: Submission Count
    const submissionChart = new Chart(document.getElementById('submissionChart'), {
        type: 'doughnut',
        data: {
            labels: ['Used', 'Remaining'],
            datasets: [{
                data: [{{ $submissionCount }}, {{ 4 - $submissionCount }}],
                backgroundColor: ['#0d6efd', '#e0e0e0'],
                borderWidth: 1
            }]
        },
        options: {
            cutout: '65%',
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // Bar Chart: Scores
    const scoreChart = new Chart(document.getElementById('scoreChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($submissions->pluck('project.title')) !!},
            datasets: [{
                label: 'Score',
                data: {!! json_encode($submissions->pluck('score')) !!},
                backgroundColor: '#1976d2'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>
@endsection
