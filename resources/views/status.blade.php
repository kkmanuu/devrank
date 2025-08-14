@extends('layouts.app')

@section('title', 'Payment Status - DevRank')

@section('content')
<div class="container py-5">
    <div class="card bg-gradient-light border-0 rounded-3 shadow-sm text-center">
        <div class="card-body p-5">
            @if($status === 'completed')
                <div class="booking-icon mb-3">
                    <i class="bi bi-check-circle-fill display-4 text-success"></i>
                </div>
                <h3 class="fw-bold text-dark mb-3">Payment Successful!</h3>
                <p class="text-muted">{{ $message }}</p>
                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg mt-4">Go to Dashboard</a>
            @elseif($status === 'pending')
                <div class="booking-icon mb-3">
                    <i class="bi bi-hourglass-split display-4 text-warning"></i>
                </div>
                <h3 class="fw-bold text-dark mb-3">Payment Pending</h3>
                <p class="text-muted">{{ $message }}</p>
                <a href="{{ route('events.index') }}" class="btn btn-outline-primary btn-lg mt-4">Back to Events</a>
            @else
                <div class="booking-icon mb-3">
                    <i class="bi bi-exclamation-triangle-fill display-4 text-danger"></i>
                </div>
                <h3 class="fw-bold text-dark mb-3">Payment Failed</h3>
                <p class="text-muted">{{ $message }}</p>
                <a href="{{ route('events.index') }}" class="btn btn-outline-primary btn-lg mt-4">Try Again</a>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        color: #333;
    }

    .card {
        background: linear-gradient(145deg, #ffffff, #e6e6e6);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    .booking-icon {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        border: 2px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(15px);
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        font-weight: 600;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }

    .btn-outline-primary {
        border-color: #007bff;
        color: #007bff;
        font-weight: 500;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .btn-outline-primary:hover {
        background-color: #007bff;
        color: #fff;
    }
</style>
@endpush
@endsection