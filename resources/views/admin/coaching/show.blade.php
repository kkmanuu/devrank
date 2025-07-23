@extends('layouts.app')

@section('content')
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            color: #fff;
        }
        .content {
            padding: 40px;
        }
        .card {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.4);
        }
        .btn-custom {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
            border: none;
        }
        .btn-custom:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
    </style>

    <div class="d-flex">
        @include('layouts.navbar') <!-- Sidebar -->
        <div class="content flex-grow-1">
            <div class="container">
                <a href="{{ route('admin.coaching.index') }}" class="btn btn-custom mb-4">
                    <i class="bi bi-arrow-left-circle"></i> Back to Sessions
                </a>

                <div class="card p-4">
                    <h2 class="mb-4 fw-bold">{{ $session->topic }}</h2>

                    <p><strong>Date:</strong> {{ $session->session_date->format('Y-m-d') }}</p>
                    <p><strong>Time:</strong> {{ $session->start_time }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($session->status) }}</p>
                    <p><strong>Coach:</strong> {{ $session->coach->name ?? 'Not Assigned' }}</p>
                    <p><strong>Capacity:</strong> {{ $session->capacity }}</p>
                    <p><strong>Available Slots:</strong> {{ $session->availableSlots() }}</p>

                    <hr class="border-white">

                    <h5 class="fw-semibold">Students Booked:</h5>
                    @if($session->bookings && $session->bookings->count())
                        <ul>
                            @foreach($session->bookings as $booking)
                                <li>{{ $booking->user->name }} ({{ $booking->user->email }})</li>
                            @endforeach
                        </ul>
                    @else
                        <p>No students have booked this session yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
