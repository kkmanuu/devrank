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
        padding: 2rem;
    }
    .btn-custom {
        background-color: rgba(255, 255, 255, 0.1);
        color: #fff;
        border: none;
        margin-bottom: 1rem;
        display: inline-block;
    }
    .btn-custom:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }
</style>

<div class="d-flex">
    @include('layouts.navbar')
    <div class="content flex-grow-1">
        <div class="container">
            <a href="{{ route('admin.coaching.index') }}" class="btn btn-custom mb-4">
                <i class="bi bi-arrow-left-circle"></i> Back to Sessions
            </a>

            <div class="card">
                <h2 class="mb-4 fw-bold">{{ $session->topic }}</h2>
                <p><strong>Description:</strong> {{ $session->description ?? 'N/A' }}</p>
                <p><strong>Type:</strong> {{ $session->type ?? 'N/A' }}</p>
                <p><strong>Coach:</strong> {{ $session->coach->name ?? 'Not Assigned' }}</p>
                <p><strong>Date:</strong> {{ $session->session_date->format('Y-m-d') }}</p>
                <p><strong>Time:</strong> {{ $session->start_time }}</p>
                <p><strong>Price:</strong> {{ number_format($session->amount, 2) }} KES</p>
                <p><strong>Status:</strong> {{ ucfirst($session->status) }}</p>
                <p><strong>Capacity:</strong> {{ $session->capacity }}</p>
                <p><strong>Available Slots:</strong> {{ $session->availableSlots() }}</p>

                <hr class="border-white">

                <h5 class="fw-semibold">Students Booked:</h5>
                @if($session->bookings && $session->bookings->count())
                    <ul class="list-group">
                        @foreach($session->bookings as $booking)
                            <li class="list-group-item bg-transparent text-white">
                                {{ $booking->full_name }} ({{ $booking->email }})<br>
                                <strong>Question:</strong> {{ $booking->question ?? 'N/A' }}
                            </li>
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
