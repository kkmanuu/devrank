@extends('layouts.app')

@section('title', 'DevRank - Book Coaching Session')

@section('content')
<div class="hero-section position-relative d-flex align-items-center text-white" style="height: 60vh; overflow: hidden;">
    <div class="slider-container position-absolute w-100 h-100" style="z-index: 0;">
        <div class="slider-track">
            <div class="slide" style="background-image: url('{{ asset('images/techss.jpg') }}');"></div>
            <div class="slide" style="background-image: url('{{ asset('images/pex.jpg') }}');"></div>
            <div class="slide" style="background-image: url('{{ asset('images/deve.jpg') }}');"></div>
        </div>
    </div>
    <div class="overlay position-absolute w-100 h-100" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.5)); z-index: 1;"></div>
    <div class="container text-center position-relative z-2 py-5">
        <h1 class="display-4 fw-bold slide-in">Book Coaching Session</h1>
        <p class="lead mb-4 slide-in delay-1">
            Reserve your spot with {{ $session->coach->name ?? 'a mentor' }} to dive into {{ $session->topic }} and grow your skills.
        </p>
    </div>
</div>

<section class="py-5 sparkle-wrapper position-relative overflow-hidden">
    <!-- Sparkle Background -->
    <div class="sparkle-bg position-absolute top-0 start-0 w-100 h-100"></div>

    <div class="container position-relative" style="z-index: 1;">
        <div class="card bg-gradient-light border-0 rounded-3 shadow-sm slide-in">
            <div class="card-body p-5 position-relative">
                <h3 class="fw-bold text-dark mb-4">Booking Form</h3>

                @if (session('error'))
                    <div class="alert alert-danger fade-in mb-4">{{ session('error') }}</div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success fade-in mb-4">{{ session('success') }}</div>
                @endif

                <form action="{{ route('coaching.book', $session) }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="full_name" class="form-label text-dark fw-medium">Full Name</label>
                            <input type="text" class="form-control form-control-lg" id="full_name" name="full_name" value="{{ old('full_name', Auth::user()->name) }}" required>
                            @error('full_name')<div class="text-danger mt-1 small">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label text-dark fw-medium">Email Address</label>
                            <input type="email" class="form-control form-control-lg" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                            @error('email')<div class="text-danger mt-1 small">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label for="question" class="form-label text-dark fw-medium">Your Question (Optional)</label>
                            <textarea class="form-control form-control-lg" id="question" name="question" rows="5" placeholder="Do you have any specific questions or areas you'd like to focus on?">{{ old('question') }}</textarea>
                            @error('question')<div class="text-danger mt-1 small">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="card bg-white border-0 shadow-sm mt-4 p-4">
                        <h5 class="fw-bold text-dark mb-3">Selected Session Details</h5>
                        <p class="text-muted mb-2"><i class="bi bi-bookmark-star text-primary me-2"></i><strong>Session:</strong> {{ $session->topic }}</p>
                        <p class="text-muted mb-2"><i class="bi bi-person-circle text-primary me-2"></i><strong>Coach:</strong> {{ $session->coach->name ?? 'Not Assigned' }}</p>
                        <p class="text-muted mb-2"><i class="bi bi-calendar-event text-primary me-2"></i><strong>Date:</strong> {{ $session->session_date->format('F d, Y') }}</p>
                        <p class="text-muted mb-2"><i class="bi bi-clock text-primary me-2"></i><strong>Time:</strong> {{ \Carbon\Carbon::parse($session->start_time)->format('h:i A') }}</p>
                        <p class="text-muted mb-0"><i class="bi bi-person-lines-fill text-primary me-2"></i><strong>Slots Left:</strong> {{ $session->availableSlots() }}</p>
                    </div>

                    <div class="d-flex justify-content-between mt-5">
                        <a href="{{ route('coaching.index') }}" class="btn btn-outline-primary btn-lg px-5">Back to Sessions</a>
                        <button type="submit" class="btn btn-primary btn-lg px-5">Book Now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    body {
        font-family: 'Inter', sans-serif;
        line-height: 1.6;
        color: #333;
    }

    .slider-container {
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    .slider-track {
        display: flex;
        width: 300%;
        height: 100%;
        animation: slideForward 15s linear infinite;
    }

    .slide {
        width: 33.33%;
        height: 100%;
        background-size: cover;
        background-position: center;
    }

    @keyframes slideForward {
        0% { transform: translateX(0); }
        100% { transform: translateX(-33.33%); }
    }

    .hero-section h1 {
        font-size: 3rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .hero-section .lead {
        font-size: 1.25rem;
        max-width: 600px;
        margin: 0 auto;
    }

    .fade-in {
        opacity: 0;
        animation: fadeIn 1s ease-in-out forwards;
    }

    .slide-in {
        opacity: 0;
        transform: translateX(30px);
        animation: slideIn 1s ease-in-out forwards;
    }

    @keyframes fadeIn {
        to { opacity: 1; }
    }

    @keyframes slideIn {
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .bg-gradient-light {
        background: linear-gradient(145deg, #ffffff, #f2f4f7);
    }

   .sparkle-wrapper {
     background: linear-gradient(to bottom right,rgb(49, 74, 94),rgb(3, 33, 60));
    position: relative;
    overflow: hidden;
}

.sparkle-bg::before {
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    background-image:
        radial-gradient(circle, rgba(255,255,255,0.8) 1px, transparent 1px),
        radial-gradient(circle, rgba(255,255,255,0.5) 1px, transparent 1px);
    background-size: 40px 40px;
    background-position: 0 0, 20px 20px;
    opacity: 0.3;
    animation: sparkleMove 60s linear infinite;
    z-index: 0;
}

@keyframes sparkleMove {
    0% { background-position: 0 0, 20px 20px; }
    100% { background-position: 1000px 1000px, 1020px 1020px; }
}


    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
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

    .form-control {
        border-radius: 8px;
        border: 1px solid #ced4da;
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .form-control-lg {
        font-size: 1.1rem;
        padding: 0.75rem 1rem;
    }
</style>
@endpush
@endsection
