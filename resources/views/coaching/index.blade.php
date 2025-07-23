@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coaching Sessions - DevRank</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            background: #0f2027;
            overflow-x: hidden;
        }

        .sparkle {
        position: absolute;
        width: 2px;
        height: 2px;
        background: white;
        border-radius: 50%;
        animation: sparkle 3s infinite ease-in-out;
        opacity: 0.6;
    }

         @keyframes sparkle {
        0%, 100% {
            opacity: 0;
            transform: translateY(0) scale(1);
        }
        50% {
            opacity: 1;
            transform: translateY(-20px) scale(1.5);
        }
    }

    /* Randomly place sparkles */
    @for ($i = 0; $i < 50; $i++)
        .sparkle-{{ $i }} {
            left: {{ rand(0, 100) }}%;
            top: {{ rand(0, 100) }}%;
            animation-delay: {{ rand(0, 3000) / 1000 }}s;
        }
    @endfor

        .content {
            padding: 60px 20px;
            color: #fff;
        }

        .card {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-10px) scale(1.02);
        }

        .btn-custom {
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-weight: bold;
        }

        .btn-custom:hover {
            background-color: rgba(255, 255, 255, 0.4);
        }

        .card-title {
            font-size: 1.3rem;
            font-weight: 600;
        }

        .card-text {
            font-size: 0.95rem;
        }

        .text-muted {
            color: #ddd !important;
        }
    </style>
</head>
<body class="sparkles">

    <div class="container content">
        <h1 class="mb-5 fw-bold text-center">Available Coaching Sessions</h1>

        @if (session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger text-center">{{ session('error') }}</div>
        @endif

        @if($sessions->isEmpty())
            <p class="text-center text-muted">No coaching sessions are available at the moment. Please check back later.</p>
        @else
            <div class="row g-4">
                @foreach($sessions as $session)
                    <div class="col-md-6 col-lg-4">
                        <div class="card p-4 h-100">
                            <h5 class="card-title">{{ $session->topic }}</h5>
                            <p class="card-text"><i class="bi bi-person-circle"></i> <strong>Coach:</strong> {{ $session->coach->name ?? 'Not Assigned' }}</p>
                            <p class="card-text"><i class="bi bi-calendar-event"></i> <strong>Date:</strong> {{ $session->session_date->format('F d, Y') }}</p>
                            <p class="card-text"><i class="bi bi-clock"></i> <strong>Time:</strong> {{ \Carbon\Carbon::parse($session->start_time)->format('h:i A') }}</p>
                            <p class="card-text"><i class="bi bi-person-lines-fill"></i> <strong>Slots Left:</strong> {{ $session->availableSlots() }}</p>

                            <form action="{{ route('coaching.book', $session) }}" method="POST" class="mt-3">
                                @csrf
                                <button type="submit" class="btn btn-custom w-100"
                                    {{ $session->availableSlots() <= 0 || $session->status !== 'upcoming' ? 'disabled' : '' }}>
                                    <i class="bi bi-calendar-check-fill"></i> Book Now
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>
@endsection
