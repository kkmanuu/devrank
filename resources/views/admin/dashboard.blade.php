<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - DevRank</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
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
      color: #fff;
    }
  </style>
</head>
<body>
<div class="d-flex">
  <!-- Sidebar -->
  <nav class="sidebar d-flex flex-column p-3">
    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center mb-4 text-white text-decoration-none">
      <span class="fs-4 fw-bold">🚀 DevRank Admin</span>
    </a>
    <ul class="nav nav-pills flex-column mb-auto">
      <li><a href="{{ route('admin.dashboard') }}" class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i>Dashboard</a></li>
      <li><a href="{{ route('admin.users') }}" class="nav-link {{ Route::is('admin.users') ? 'active' : '' }}"><i class="bi bi-people"></i>Users</a></li>
      <li><a href="{{ route('admin.submissions') }}" class="nav-link {{ Route::is('admin.submissions') ? 'active' : '' }}"><i class="bi bi-file-earmark-text"></i>Submissions</a></li>
      <li><a href="{{ route('admin.payments') }}" class="nav-link {{ Route::is('admin.payments') ? 'active' : '' }}"><i class="bi bi-cash-stack"></i>Payments</a></li>
      <li><a href="{{ route('admin.messages') }}" class="nav-link {{ Route::is('admin.messages') ? 'active' : '' }}"><i class="bi bi-envelope"></i>Messages</a></li>
      <li><a href="{{ route('admin.events.index') }}" class="nav-link {{ Route::is('admin.events.*') ? 'active' : '' }}"><i class="bi bi-calendar-week"></i>Events</a></li>
      <li><a href="{{ route('admin.coaching.index') }}" class="nav-link {{ Route::is('admin.coaching.*') ? 'active' : '' }}"><i class="bi bi-person-video3"></i>Coaching</a></li>
      <li class="mt-auto">
  <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="nav-link btn btn-link text-start text-danger w-100">
      <i class="bi bi-box-arrow-right"></i> Logout
    </button>
  </form>
</li>

    </ul>
  </nav>

  <!-- Main content -->
  <div class="content flex-grow-1">
    <div class="container-fluid">
      <h1 class="mb-4 text-white fw-bold">Admin Dashboard</h1>

      <div class="row">
        @php
          $cards = [
            ['title' => 'Total Users', 'value' => $totalUsers, 'route' => 'admin.users'],
            ['title' => 'Submissions', 'value' => $totalSubmissions, 'route' => 'admin.submissions'],
            ['title' => 'Pending Reviews', 'value' => $pendingReviews, 'route' => 'admin.submissions'],
            ['title' => 'Payments', 'value' => 'KSH ' . number_format($totalPayments, 2), 'route' => 'admin.payments'],
            ['title' => 'Unread Messages', 'value' => $pendingMessages, 'route' => 'admin.messages'],
            ['title' => 'Event Registrations', 'value' => $eventRegistrations, 'route' => 'admin.events.index'],
            ['title' => 'Event Participants', 'value' => $eventParticipants, 'route' => 'admin.events.index'],
            ['title' => 'Coaching Bookings', 'value' => $coachingBookings, 'route' => 'admin.coaching.index'],
          ];
        @endphp

        @foreach($cards as $card)
          <div class="col-lg-3 col-md-6 mb-4">
            <div class="card text-center p-3">
              <h5 class="card-title">{{ $card['title'] }}</h5>
              <p class="card-text">{{ $card['value'] }}</p>
              <a href="{{ route($card['route']) }}" class="btn btn-custom btn-sm mt-2">Manage</a>
            </div>
          </div>
        @endforeach
      </div>

      <!-- Chart -->
      <div class="chart-container mt-5">
        <h4 class="mb-4 text-white">Performance Overview</h4>
        <canvas id="adminChart" height="80"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('adminChart').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Submissions', 'Pending', 'Participants', 'Bookings'],
      datasets: [{
        label: 'Admin Stats',
        data: [
          {{ $totalSubmissions }},
          {{ $pendingReviews }},
          {{ $eventParticipants }},
          {{ $coachingBookings }}
        ],
        backgroundColor: [
          'rgba(0, 255, 255, 0.6)',
          'rgba(255, 99, 132, 0.6)',
          'rgba(255, 206, 86, 0.6)',
          'rgba(153, 102, 255, 0.6)'
        ],
        borderColor: [
          'rgba(0, 255, 255, 1)',
          'rgba(255, 99, 132, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(153, 102, 255, 1)'
        ],
        borderWidth: 2,
        borderRadius: 10
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false },
        tooltip: { backgroundColor: '#111', titleColor: '#0ff', bodyColor: '#fff' }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: { color: '#fff' }
        },
        x: {
          ticks: { color: '#fff' }
        }
      }
    }
  });
</script>
</body>
</html>
