@extends('layouts.app')

@section('title', 'DevRank - Book Event')

@section('content')
<div class="hero-section position-relative d-flex align-items-center text-white" style="height: 60vh; overflow: hidden;">
    <div class="slider-container position-absolute w-100 h-100" style="z-index: 0;">
        <div class="slider-track">
            <div class="slide" style="background-image: url('{{ asset('images/techss.jpg') }}');"></div>
            <div class="slide" style="background-image: url('{{ asset('images/pex.jpg') }}');"></div>
            <div class="slide" style="background-image: url('{{ asset('images/deve.jpg') }}');"></div>
        </div>
    </div>
    <div class="overlay position-absolute w-100 h-100" style="background: linear-gradient(135deg, rgba(0, 98, 255, 0.8), rgba(0, 0, 0, 0.6)); z-index: 1;"></div>
    <div class="container text-center position-relative z-2 py-5">
        <h1 class="display-4 fw-bold slide-in">Book Event</h1>
        <p class="lead mb-4 slide-in delay-1">
            Pay KSH {{ number_format($event->amount, 2) }} to reserve your spot for {{ $event->title }} on {{ $event->event_date->format('F d, Y') }}.
        </p>
        <div class="event-badge slide-in delay-2">
            <span class="badge bg-info text-dark px-3 py-2">
                <i class="bi bi-calendar-event me-2"></i>
                {{ $event->status === 'upcoming' ? 'Upcoming Event' : ucfirst($event->status) }}
            </span>
        </div>
    </div>
</div>

<section class="py-5 sparkle-wrapper position-relative overflow-hidden" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh;">
    <div class="sparkle-bg position-absolute top-0 start-0 w-100 h-100"></div>

    <div class="container position-relative" style="z-index: 1;">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="booking-card bg-gradient-glass border-0 rounded-4 shadow-lg slide-in">
                    <div class="card-body p-5 position-relative">
                        <div class="booking-header text-center mb-5">
                            <div class="booking-icon mb-3">
                                <i class="bi bi-calendar-check display-4 text-primary"></i>
                            </div>
                            <h3 class="fw-bold text-white mb-2">Complete Your Booking</h3>
                            <p class="text-white-50">Fill in your details to secure your event ticket</p>
                        </div>

                        @if (session('error'))
                            <div class="alert alert-danger alert-modern fade-in mb-4">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success alert-modern fade-in mb-4">
                                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                            </div>
                        @endif

                        <form id="bookingForm" action="{{ route('events.book', $event) }}" method="POST">
                            @csrf
                            <input type="hidden" name="bookable_id" value="{{ $event->id }}">
                            <input type="hidden" name="bookable_type" value="{{ \App\Models\Event::class }}">
                            <input type="hidden" name="amount" value="{{ $event->amount }}">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="full_name" class="form-label text-white fw-semibold">
                                        <i class="bi bi-person me-2"></i>Full Name
                                    </label>
                                    <input type="text" class="form-control form-control-modern" id="full_name" name="full_name" value="{{ old('full_name', Auth::user()->name) }}" required>
                                    @error('full_name')<div class="text-warning mt-2 small"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label text-white fw-semibold">
                                        <i class="bi bi-envelope me-2"></i>Email Address
                                    </label>
                                    <input type="email" class="form-control form-control-modern" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                                    @error('email')<div class="text-warning mt-2 small"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12">
                                    <label for="phone_number" class="form-label text-white fw-semibold">
                                        <i class="bi bi-phone me-2"></i>Phone Number (for M-Pesa)
                                    </label>
                                    <input type="text" class="form-control form-control-modern" id="phone_number" name="phone_number" pattern="(\+254|0)[0-9]{9}" placeholder="+2547XXXXXXXX or 07XXXXXXXX" required>
                                    @error('phone_number')<div class="text-warning mt-2 small"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12">
                                    <label for="question" class="form-label text-white fw-semibold">
                                        <i class="bi bi-chat-quote me-2"></i>Your Question (Optional)
                                    </label>
                                    <textarea class="form-control form-control-modern" id="question" name="question" rows="4" placeholder="Do you have any specific questions or areas you'd like to focus on during this event?">{{ old('question') }}</textarea>
                                    @error('question')<div class="text-warning mt-2 small"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="event-details-card mt-5 p-4 rounded-3 position-relative overflow-hidden">
                                <div class="event-details-bg"></div>
                                <div class="position-relative">
                                    <h5 class="fw-bold text-white mb-4 d-flex align-items-center">
                                        <i class="bi bi-info-circle-fill me-2 text-primary"></i>
                                        Selected Event Details
                                    </h5>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="detail-item">
                                                <i class="bi bi-bookmark-star text-primary me-2"></i>
                                                <strong class="text-white">Event:</strong>
                                                <span class="text-white-75">{{ $event->title }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="detail-item">
                                                <i class="bi bi-calendar-event text-primary me-2"></i>
                                                <strong class="text-white">Date:</strong>
                                                <span class="text-white-75">{{ $event->event_date->format('F d, Y') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="detail-item">
                                                <i class="bi bi-clock text-primary me-2"></i>
                                                <strong class="text-white">Time:</strong>
                                                <span class="text-white-75">{{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="detail-item">
                                                <i class="bi bi-geo-alt text-primary me-2"></i>
                                                <strong class="text-white">Location:</strong>
                                                <span class="text-white-75">{{ $event->location ?? 'TBD' }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="detail-item">
                                                <i class="bi bi-currency-dollar text-primary me-2"></i>
                                                <strong class="text-white">Cost:</strong>
                                                <span class="text-white-75">KES {{ number_format($event->amount, 2) }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="detail-item">
                                                <i class="bi bi-people text-primary me-2"></i>
                                                <strong class="text-white">Slots Left:</strong>
                                                <span class="text-warning fw-bold">{{ $event->availableSlots() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="action-buttons mt-5 d-flex flex-column flex-md-row gap-3">
                                <a href="{{ route('events.index') }}" class="btn btn-outline-light btn-lg px-5 flex-fill">
                                    <i class="bi bi-arrow-left me-2"></i>Back to Events
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg px-5 flex-fill btn-booking" id="bookingButton">
                                    <i class="bi bi-calendar-check-fill me-2"></i>Confirm Booking
                                    <span class="btn-glow"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    :root {
        --primary: #4facfe;
        --primary-dark: #00f2fe;
        --glass-bg: rgba(255, 255, 255, 0.08);
        --glass-border: rgba(255, 255, 255, 0.18);
        --text-light: rgba(255, 255, 255, 0.85);
        --shadow: 0 8px 30px rgba(0,0,0,0.3);
    }

    body {
        background-color: #0a0a0a;
        font-family: 'Poppins', sans-serif;
        color: #fff;
    }

    /* HERO SECTION */
    .hero-section {
        height: 100vh;
        background: url('{{ asset('images/techss.jpg') }}') center/cover no-repeat;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .hero-section::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(0, 98, 255, 0.8), rgba(0, 0, 0, 0.6));
    }

    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 700px;
        padding: 20px;
    }

    .hero-content h1 {
        font-size: clamp(2.5rem, 6vw, 4rem);
        font-weight: 900;
        margin-bottom: 1rem;
        background: linear-gradient(to right, #fff, #e0e7ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .hero-content p {
        font-size: 1.2rem;
        color: var(--text-light);
    }

    /* BOOKING SECTION */
    .booking-section {
        background: #111;
        padding: 4rem 1rem;
        display: flex;
        justify-content: center;
    }

    .booking-card {
        background: var(--glass-bg);
        backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        padding: 2rem;
        max-width: 700px;
        width: 100%;
        box-shadow: var(--shadow);
        animation: fadeUp 0.8s ease forwards;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* FORM INPUTS */
    .form-control-modern {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: 12px;
        color: #fff;
        font-size: 1rem;
        padding: 0.8rem;
        transition: all 0.3s ease;
    }

    .form-control-modern:focus {
        border-color: var(--primary);
        background: rgba(255,255,255,0.12);
        box-shadow: 0 0 0 0.2rem rgba(79, 172, 254, 0.25);
    }

    /* BUTTONS */
    .btn-primary {
        background: linear-gradient(45deg, var(--primary), var(--primary-dark));
        border: none;
        border-radius: 50px;
        padding: 0.8rem 2rem;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: scale(1.05);
        box-shadow: 0 5px 20px rgba(0,0,0,0.3);
    }
</style>
@endpush
@endsection
