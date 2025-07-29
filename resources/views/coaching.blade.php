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
    <div class="overlay position-absolute w-100 h-100"></div>
    <div class="container text-center position-relative z-2 py-5">
        <h1 class="display-4 fw-bold slide-in">Book Coaching Session</h1>
        <p class="lead mb-4 slide-in delay-1">Reserve your spot with a tech mentor and grow your skills today!</p>
    </div>
</div>

<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center fw-bold mb-5 text-dark fade-in">Our Coaching Mission</h2>
        <div class="row g-4">
            <div class="col-12 text-center">
                <p class="lead text-muted mb-4 slide-in">
                    At DevRank, we are committed to empowering student developers through personalized coaching sessions that enhance skills, boost confidence, and pave the way for career success.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        @if (session('error'))
            <div class="alert alert-danger fade-in mb-4">{{ session('error') }}</div>
        @endif
        @if (session('success'))
            <div class="alert alert-success fade-in mb-4">{{ session('success') }}</div>
        @endif

        <h2 class="fw-bold text-dark mb-4 slide-in">Available Sessions</h2>
        @if($sessions->isEmpty())
            <div class="alert alert-warning text-center fade-in">No coaching sessions available at the moment.</div>
        @else
            <div class="row g-4 mb-5">
                @foreach($sessions as $session)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 bg-gradient-light border-0 rounded-3 shadow-sm slide-in delay-{{ $loop->index % 3 }}">
                            <div class="card-body p-4">
                                <h5 class="card-title fw-bold text-dark">{{ $session->topic }}</h5>
                                <p class="text-muted"><i class="bi bi-person-circle text-primary me-2"></i>Coach: {{ $session->coach->name ?? 'Not Assigned' }}</p>
                                <p class="text-muted"><i class="bi bi-calendar-event text-primary me-2"></i>Date: {{ $session->session_date->format('F d, Y') }}</p>
                                <p class="text-muted"><i class="bi bi-clock text-primary me-2"></i>Time: {{ \Carbon\Carbon::parse($session->start_time)->format('h:i A') }}</p>
                                <p class="text-muted"><i class="bi bi-person-lines-fill text-primary me-2"></i>Slots Left: {{ $session->availableSlots() }}</p>
                                <p class="text-muted"><span class="badge bg-{{ $session->status === 'upcoming' ? 'success' : ($session->status === 'pending' ? 'warning' : 'secondary') }}">{{ ucfirst($session->status) }}</span></p>
                                <button class="btn btn-primary btn-sm w-100 mt-3 select-session" 
                                        data-session-id="{{ $session->id }}"
                                        data-topic="{{ $session->topic }}"
                                        data-coach="{{ $session->coach->name ?? 'Not Assigned' }}"
                                        data-date="{{ $session->session_date->format('F d, Y') }}"
                                        data-time="{{ \Carbon\Carbon::parse($session->start_time)->format('h:i A') }}"
                                        data-slots="{{ $session->availableSlots() }}"
                                        {{ $session->availableSlots() <= 0 || $session->status !== 'upcoming' ? 'disabled' : '' }}>
                                    <i class="bi bi-calendar-check-fill me-2"></i>Select Session
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="card bg-gradient-light border-0 rounded-3 shadow-sm slide-in mt-5">
            <div class="card-body p-5 position-relative">
                <h3 class="fw-bold text-dark mb-4">Booking Form</h3>
                <form id="booking-form" action="" method="POST">
                    @csrf
                    <input type="hidden" name="session_id" id="session_id">
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
                    <div class="card bg-white border-0 shadow-sm mt-4 p-4" id="session-details" style="display: none;">
                        <h5 class="fw-bold text-dark mb-3">Selected Session Details</h5>
                        <p class="text-muted mb-2"><i class="bi bi-bookmark-star text-primary me-2"></i><strong>Session:</strong> <span id="selected-topic"></span></p>
                        <p class="text-muted mb-2"><i class="bi bi-person-circle text-primary me-2"></i><strong>Coach:</strong> <span id="selected-coach"></span></p>
                        <p class="text-muted mb-2"><i class="bi bi-calendar-event text-primary me-2"></i><strong>Date:</strong> <span id="selected-date"></span></p>
                        <p class="text-muted mb-2"><i class="bi bi-clock text-primary me-2"></i><strong>Time:</strong> <span id="selected-time"></span></p>
                        <p class="text-muted mb-0"><i class="bi bi-person-lines-fill text-primary me-2"></i><strong>Slots Left:</strong> <span id="selected-slots"></span></p>
                    </div>
                    <div class="d-flex justify-content-between mt-5">
                        <a href="{{ route('coaching.index') }}" class="btn btn-outline-primary btn-lg px-5">Back to Sessions</a>
                        <button type="submit" class="btn btn-primary btn-lg px-5" id="book-button" disabled>Book Now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    body {
        font-family: 'Inter', sans-serif;
        line-height: 1.6;
        color: #333;
    }

    .hero-section {
        position: relative;
        height: 60vh;
        overflow: hidden;
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
        background-size: cover;
        background-position: center;
    }

    .overlay {
        position: absolute;
        top: 0; left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.5));
        z-index: 1;
    }

    @keyframes slideForward {
        0% { transform: translateX(0); }
        100% { transform: translateX(-33.33%); }
    }

    .hero-section h1 {
        font-size: 3rem;
        color: white;
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.4);
    }

    .hero-section .lead {
        font-size: 1.25rem;
        color: #eee;
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

    .badge {
        font-size: 0.9rem;
        padding: 0.5em 0.75em;
    }

    /* Sparkle effect background */
    .card-body {
        position: relative;
    }

    .card-body::before {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        background-image: radial-gradient(circle, #cce5ff 1px, transparent 1px),
                          radial-gradient(circle, #99ccff 1px, transparent 1px);
        background-size: 40px 40px;
        background-position: 0 0, 20px 20px;
        opacity: 0.15;
        animation: sparkleMove 50s linear infinite;
        top: 0;
        left: 0;
        z-index: 0;
    }

    @keyframes sparkleMove {
        0% { background-position: 0 0, 20px 20px; }
        100% { background-position: 1000px 1000px, 1020px 1020px; }
    }

    #booking-form .form-control,
    #booking-form textarea {
        z-index: 1;
        position: relative;
        background-color: #fff;
    }

    #session-details {
        background-color: #f9f9f9;
        border-radius: 12px;
        z-index: 1;
    }

    @media (max-width: 768px) {
        .hero-section h1 {
            font-size: 2.2rem;
        }

        .hero-section .lead {
            font-size: 1rem;
        }

        .btn-lg {
            font-size: 1rem;
            padding: 0.75rem 1.25rem;
        }
    }
</style>
@endpush


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectButtons = document.querySelectorAll('.select-session');
        const form = document.getElementById('booking-form');
        const sessionIdInput = document.getElementById('session_id');
        const bookButton = document.getElementById('book-button');
        const sessionDetails = document.getElementById('session-details');
        const selectedTopic = document.getElementById('selected-topic');
        const selectedCoach = document.getElementById('selected-coach');
        const selectedDate = document.getElementById('selected-date');
        const selectedTime = document.getElementById('selected-time');
        const selectedSlots = document.getElementById('selected-slots');

        selectButtons.forEach(button => {
            button.addEventListener('click', function () {
                const sessionId = this.getAttribute('data-session-id');
                const topic = this.getAttribute('data-topic');
                const coach = this.getAttribute('data-coach');
                const date = this.getAttribute('data-date');
                const time = this.getAttribute('data-time');
                const slots = this.getAttribute('data-slots');

                sessionIdInput.value = sessionId;
                form.action = "{{ route('coaching.book', '') }}/" + sessionId;
                selectedTopic.textContent = topic;
                selectedCoach.textContent = coach;
                selectedDate.textContent = date;
                selectedTime.textContent = time;
                selectedSlots.textContent = slots;

                sessionDetails.style.display = 'block';
                bookButton.disabled = false;

                selectButtons.forEach(btn => btn.classList.remove('btn-success'));
                this.classList.add('btn-success');
            });
        });
    });
</script>
@endpush
@endsection
