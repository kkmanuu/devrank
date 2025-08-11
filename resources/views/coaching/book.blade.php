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
    <div class="overlay position-absolute w-100 h-100" style="background: linear-gradient(135deg, rgba(0, 98, 255, 0.8), rgba(0, 0, 0, 0.6)); z-index: 1;"></div>
    <div class="container text-center position-relative z-2 py-5">
        <h1 class="display-4 fw-bold slide-in">Book Coaching Session</h1>
        <p class="lead mb-4 slide-in delay-1">
            Reserve your spot with {{ $session->coach->name ?? 'a mentor' }} to dive into {{ $session->topic }} and accelerate your growth.
        </p>
        <div class="session-badge slide-in delay-2">
            <span class="badge bg-{{ $session->developer_type === 'professional' ? 'warning' : 'info' }} text-dark px-3 py-2">
                <i class="bi bi-{{ $session->developer_type === 'professional' ? 'briefcase' : 'code-slash' }} me-2"></i>
                {{ ucfirst($session->developer_type ?? 'fresher') }} Level Session
            </span>
        </div>
    </div>
</div>

<section class="py-5 sparkle-wrapper position-relative overflow-hidden" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh;">
    <!-- Sparkle Background -->
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
                            <p class="text-white-50">Fill in your details to secure your coaching session</p>
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

                        <form action="{{ route('coaching.book', $session) }}" method="POST">
                            @csrf
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
                                    <label for="question" class="form-label text-white fw-semibold">
                                        <i class="bi bi-chat-quote me-2"></i>Your Question (Optional)
                                    </label>
                                    <textarea class="form-control form-control-modern" id="question" name="question" rows="4" placeholder="Do you have any specific questions or areas you'd like to focus on during this session?">{{ old('question') }}</textarea>
                                    @error('question')<div class="text-warning mt-2 small"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <!-- Session Details Card -->
                            <div class="session-details-card mt-5 p-4 rounded-3 position-relative overflow-hidden">
                                <div class="session-details-bg"></div>
                                <div class="position-relative">
                                    <h5 class="fw-bold text-white mb-4 d-flex align-items-center">
                                        <i class="bi bi-info-circle-fill me-2 text-primary"></i>
                                        Selected Session Details
                                    </h5>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="detail-item">
                                                <i class="bi bi-bookmark-star text-primary me-2"></i>
                                                <strong class="text-white">Session:</strong>
                                                <span class="text-white-75">{{ $session->topic }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="detail-item">
                                                <i class="bi bi-person-circle text-primary me-2"></i>
                                                <strong class="text-white">Coach:</strong>
                                                <span class="text-white-75">{{ $session->coach->name ?? 'Not Assigned' }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="detail-item">
                                                <i class="bi bi-calendar-event text-primary me-2"></i>
                                                <strong class="text-white">Date:</strong>
                                                <span class="text-white-75">{{ $session->session_date->format('F d, Y') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="detail-item">
                                                <i class="bi bi-clock text-primary me-2"></i>
                                                <strong class="text-white">Time:</strong>
                                                <span class="text-white-75">{{ \Carbon\Carbon::parse($session->start_time)->format('h:i A') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="detail-item">
                                                <i class="bi bi-hourglass-split text-primary me-2"></i>
                                                <strong class="text-white">Duration:</strong>
                                                <span class="text-white-75">{{ $session->duration ?? '60' }} minutes</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="detail-item">
                                                <i class="bi bi-people text-primary me-2"></i>
                                                <strong class="text-white">Slots Left:</strong>
                                                <span class="text-warning fw-bold">{{ $session->availableSlots() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="action-buttons mt-5 d-flex flex-column flex-md-row gap-3">
                                <a href="{{ route('coaching.index') }}" class="btn btn-outline-light btn-lg px-5 flex-fill">
                                    <i class="bi bi-arrow-left me-2"></i>Back to Sessions
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg px-5 flex-fill btn-booking">
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
        --glass-bg: rgba(255, 255, 255, 0.1);
        --glass-border: rgba(255, 255, 255, 0.2);
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        line-height: 1.6;
        color: #333;
    }

    /* Hero Section Styles */
    .slider-container {
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    .slider-track {
        display: flex;
        width: 300%;
        height: 100%;
        animation: slideForward 20s linear infinite;
    }

    .slide {
        width: 33.33%;
        height: 100%;
        background-size: cover;
        background-position: center;
        filter: brightness(0.7);
    }

    @keyframes slideForward {
        0% { transform: translateX(0); }
        33.33% { transform: translateX(-33.33%); }
        66.66% { transform: translateX(-66.66%); }
        100% { transform: translateX(-100%); }
    }

    .hero-section h1 {
        font-size: 3.2rem;
        font-weight: 800;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);
        background: linear-gradient(135deg, #fff, #e0e7ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-section .lead {
        font-size: 1.3rem;
        max-width: 700px;
        margin: 0 auto;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
    }

    .session-badge .badge {
        font-size: 1rem;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    /* Sparkle Background */
    .sparkle-wrapper {
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
            radial-gradient(circle, rgba(255,255,255,0.4) 1px, transparent 1px),
            radial-gradient(circle, rgba(255,255,255,0.6) 1px, transparent 1px);
        background-size: 50px 50px, 100px 100px, 75px 75px;
        background-position: 0 0, 25px 25px, 50px 50px;
        opacity: 0.3;
        animation: sparkleFloat 60s linear infinite;
    }

    @keyframes sparkleFloat {
        0% { background-position: 0 0, 25px 25px, 50px 50px; }
        100% { background-position: 1000px 1000px, 1025px 1025px, 1050px 1050px; }
    }

    /* Booking Card */
    .booking-card {
        background: linear-gradient(145deg, var(--glass-bg), rgba(255, 255, 255, 0.05));
        backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        box-shadow: 
            0 8px 32px rgba(0, 0, 0, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
        position: relative;
        overflow: hidden;
    }

    .booking-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #4facfe, #00f2fe, #4facfe);
        background-size: 200% 100%;
        animation: shimmer 2s ease-in-out infinite;
    }

    @keyframes shimmer {
        0%, 100% { background-position: -200% 0; }
        50% { background-position: 200% 0; }
    }

    .booking-header {
        position: relative;
    }

    .booking-icon {
        background: linear-gradient(135deg, var(--glass-bg), rgba(255, 255, 255, 0.05));
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        border: 2px solid var(--glass-border);
        backdrop-filter: blur(15px);
    }

    /* Form Controls */
    .form-control-modern {
        background: var(--glass-bg);
        border: 2px solid transparent;
        border-radius: 12px;
        color: #fff;
        font-size: 1.05rem;
        padding: 0.875rem 1.25rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(10px);
    }

    .form-control-modern:focus {
        background: rgba(255, 255, 255, 0.15);
        border-color: var(--primary);
        color: #fff;
        box-shadow: 
            0 0 0 0.2rem rgba(79, 172, 254, 0.25),
            0 8px 25px rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }

    .form-control-modern::placeholder {
        color: rgba(255, 255, 255, 0.6);
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
    }

    /* Session Details Card */
    .session-details-card {
        background: linear-gradient(145deg, rgba(255, 255, 255, 0.08), rgba(255, 255, 255, 0.02));
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        position: relative;
    }

    .session-details-bg {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(79, 172, 254, 0.1), rgba(0, 242, 254, 0.05));
        border-radius: inherit;
    }

    .detail-item {
        display: flex;
        align-items: center;
        margin-bottom: 0.75rem;
        padding: 0.5rem;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.05);
        transition: all 0.3s ease;
    }

    .detail-item:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateX(4px);
    }

    .text-white-75 {
        color: rgba(255, 255, 255, 0.75);
        margin-left: 0.5rem;
    }

    /* Action Buttons */
    .action-buttons {
        position: relative;
    }

    .btn-outline-light {
        border: 2px solid rgba(255, 255, 255, 0.4);
        color: rgba(255, 255, 255, 0.9);
        font-weight: 600;
        border-radius: 12px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(10px);
    }

    .btn-outline-light:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: #fff;
        color: #fff;
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    .btn-booking {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border: none;
        font-weight: 700;
        border-radius: 12px;
        position: relative;
        overflow: hidden;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .btn-booking:hover {
        background: linear-gradient(135deg, var(--primary-dark), var(--primary));
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(79, 172, 254, 0.4);
    }

    .btn-glow {
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .btn-booking:hover .btn-glow {
        left: 100%;
    }

    .btn-lg {
        padding: 1rem 2rem;
        font-size: 1.1rem;
    }

    /* Alerts */
    .alert-modern {
        background: var(--glass-bg);
        backdrop-filter: blur(15px);
        border: 1px solid var(--glass-border);
        border-radius: 12px;
        color: #fff;
        font-weight: 500;
    }

    /* Animations */
    .fade-in {
        opacity: 0;
        animation: fadeIn 1s ease-in-out forwards;
    }

    .slide-in {
        opacity: 0;
        transform: translateY(30px);
        animation: slideIn 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }

    .slide-in.delay-1 { animation-delay: 0.2s; }
    .slide-in.delay-2 { animation-delay: 0.4s; }

    @keyframes fadeIn {
        to { opacity: 1; }
    }

    @keyframes slideIn {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .hero-section {
            height: 50vh;
        }
        
        .hero-section h1 {
            font-size: 2.2rem;
        }

        .hero-section .lead {
            font-size: 1.1rem;
        }

        .booking-card .card-body {
            padding: 2rem 1.5rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .session-details-card .row {
            --bs-gutter-x: 0.5rem;
        }

        .detail-item {
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
        }

        .text-white-75 {
            margin-left: 0;
            margin-top: 0.25rem;
        }
    }

    @media (max-width: 576px) {
        .hero-section h1 {
            font-size: 1.8rem;
        }

        .session-badge .badge {
            font-size: 0.85rem;
            padding: 0.5rem 1rem;
        }

        .btn-lg {
            padding: 0.875rem 1.5rem;
            font-size: 1rem;
        }
    }
</style>
@endpush
@endsection