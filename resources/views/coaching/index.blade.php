@extends('layouts.app')

@section('title', 'DevRank - Coaching Sessions')

@section('content')
<!-- Hero Section -->
<div class="hero-section position-relative d-flex align-items-center text-white" style="height: 70vh; overflow: hidden;">
    <div class="slider-container position-absolute w-100 h-100" style="z-index: 0;">
        <div class="slider-track">
            <div class="slide" style="background-image: url('{{ asset('images/techss.jpg') }}');"></div>
            <div class="slide" style="background-image: url('{{ asset('images/pex.jpg') }}');"></div>
            <div class="slide" style="background-image: url('{{ asset('images/deve.jpg') }}');"></div>
        </div>
    </div>
    <div class="overlay position-absolute w-100 h-100" style="background: linear-gradient(135deg, rgba(0, 98, 255, 0.6), rgba(0, 0, 0, 0.7));"></div>
    <div class="container text-center position-relative z-2 py-5">
        <h1 class="display-3 fw-bold slide-in">Elevate Your Tech Journey</h1>
        <p class="lead mb-4 slide-in delay-1">Unlock your potential with personalized 1:1 coaching from industry leaders.</p>
        <a href="#sessions" class="btn btn-primary btn-lg px-5 py-3 slide-in delay-2">
            <i class="bi bi-calendar-check me-2"></i>Explore Sessions
        </a>
    </div>
</div>

<!-- Mission Section -->
<section class="py-5 mission-section position-relative overflow-hidden" style="background-color: #2c3e50;">
    <div class="container position-relative z-1">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8 text-center">
                <div class="section-header mb-5">
                    <span class="badge bg-primary text-white mb-3">Our Mission</span>
                    <h2 class="fw-bold mb-4 text-white fade-in">Empowering Developers to Succeed</h2>
                    <div class="divider mx-auto bg-white"></div>
                </div>
                <p class="lead text-white-50 mb-5 fade-in delay-1">DevRank connects aspiring developers with seasoned mentors, offering tailored guidance, career insights, and hands-on technical coaching to fast-track your success in tech.</p>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="feature-card p-4 rounded-3 h-100 bg-white shadow-sm slide-in">
                            <div class="icon-wrapper bg-primary text-white rounded-circle mb-3">
                                <i class="bi bi-person-gear fs-3"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Expert Mentorship</h5>
                            <p class="text-muted mb-0">Learn from industry veterans with proven expertise at leading tech companies.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-card p-4 rounded-3 h-100 bg-white shadow-sm slide-in delay-1">
                            <div class="icon-wrapper bg-primary text-white rounded-circle mb-3">
                                <i class="bi bi-graph-up fs-3"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Career Acceleration</h5>
                            <p class="text-muted mb-0">Receive strategic advice to navigate your career path and secure top roles.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-card p-4 rounded-3 h-100 bg-white shadow-sm slide-in delay-2">
                            <div class="icon-wrapper bg-primary text-white rounded-circle mb-3">
                                <i class="bi bi-code-square fs-3"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Skill Mastery</h5>
                            <p class="text-muted mb-0">Hone your technical skills through practical, project-based coaching.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sessions Section -->
<section id="sessions" class="py-5 sessions-section" style="background-color: #e6f0fa;">
    <div class="container">
        <div class="section-header mb-5 text-center">
            <h2 class="fw-bold mb-3 fade-in">Discover Our Coaching Sessions</h2>
            <p class="text-muted mx-auto fade-in delay-1" style="max-width: 700px;">Explore upcoming sessions and reserve your spot. Limited spaces ensure personalized attention.</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show text-center fade-in" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show text-center fade-in" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($sessions->isEmpty())
            <div class="empty-state text-center py-5 fade-in">
                <div class="empty-state-icon bg-primary text-white rounded-circle mb-4 mx-auto">
                    <i class="bi bi-calendar-x fs-1"></i>
                </div>
                <h4 class="fw-bold mb-3">No Sessions Currently Available</h4>
                <p class="text-muted mb-4">New sessions are added regularly. Subscribe to get notified when new opportunities are available.</p>
                <button class="btn btn-primary px-4 py-2">
                    <i class="bi bi-bell-fill me-2"></i>Notify Me
                </button>
            </div>
        @else
            <div class="row g-4">
                @foreach($sessions as $session)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm overflow-hidden slide-in delay-{{ $loop->index % 3 }}">
                        <div class="card-header bg-white border-bottom-0 pb-0">
                            <span class="badge bg-{{ $session->status === 'upcoming' ? 'success' : 'secondary' }} text-white float-end">
                                {{ ucfirst($session->status) }}
                            </span>
                            <h5 class="card-title fw-bold mb-1">{{ $session->topic }}</h5>
                            <p class="text-muted small mb-0">
                                <i class="bi bi-person-circle text-primary me-1"></i>
                                {{ $session->coach->name ?? __('coaching.not_assigned') }}
                            </p>
                        </div>
                        <div class="card-body pt-1">
                            <ul class="list-unstyled mb-4">
                                <li class="mb-2">
                                    <i class="bi bi-calendar-event text-primary me-2"></i>
                                    <strong>Date:</strong> {{ $session->session_date->format('F d, Y') }}
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-clock text-primary me-2"></i>
                                    <strong>Time:</strong> {{ \Carbon\Carbon::parse($session->start_time)->format('h:i A') }}
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-hourglass-split text-primary me-2"></i>
                                    <strong>Duration:</strong> {{ $session->duration }} minutes
                                </li>
                                <li>
                                    <i class="bi bi-people text-primary me-2"></i>
                                    <strong>Available:</strong> {{ $session->availableSlots() }} of {{ $session->max_students }} slots
                                </li>
                            </ul>
                        </div>
                        <div class="card-footer bg-white border-top-0 pt-0">
                            <a href="{{ route('coaching.book.form', $session) }}" 
                               class="btn btn-primary w-100" 
                               {{ $session->availableSlots() <= 0 || $session->status !== 'upcoming' ? 'disabled' : '' }}>
                                <i class="bi bi-calendar-check-fill me-2"></i>
                                {{ __('coaching.book_session') }}
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-5 why-choose-section" style="background-color: #fff8e1;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="pe-lg-4">
                    <span class="badge bg-primary text-white mb-3">Why Choose Us</span>
                    <h2 class="fw-bold mb-4 fade-in">Transform Your Learning Experience</h2>
                    <p class="lead text-muted mb-4 fade-in delay-1">Our sessions deliver targeted, high-impact coaching tailored to your goals, ensuring rapid progress in minimal time.</p>
                    <div class="d-flex mb-3 slide-in">
                        <div class="me-4">
                            <div class="icon-wrapper-sm bg-primary text-white rounded-circle mb-2">
                                <i class="bi bi-check-lg"></i>
                            </div>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-2">Tailored Coaching</h5>
                            <p class="text-muted mb-0">Sessions customized to your skill level and career aspirations.</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3 slide-in delay-1">
                        <div class="me-4">
                            <div class="icon-wrapper-sm bg-primary text-white rounded-circle mb-2">
                                <i class="bi bi-check-lg"></i>
                            </div>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-2">Practical Insights</h5>
                            <p class="text-muted mb-0">Gain skills you can apply directly to real-world projects.</p>
                        </div>
                    </div>
                    <div class="d-flex slide-in delay-2">
                        <div class="me-4">
                            <div class="icon-wrapper-sm bg-primary text-white rounded-circle mb-2">
                                <i class="bi bi-check-lg"></i>
                            </div>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-2">Ongoing Support</h5>
                            <p class="text-muted mb-0">Access curated resources to sustain your learning post-session.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="border rounded-3 overflow-hidden shadow-sm">
                    <img src="{{ asset('images/coaching-session.jpg') }}" alt="Coaching Session" class="img-fluid w-100">
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    :root {
        --primary: #0062ff;
        --primary-soft: rgba(0, 98, 255, 0.15);
        --success: #28a745;
        --success-soft: rgba(40, 167, 69, 0.15);
        --secondary: #6c757d;
        --secondary-soft: rgba(108, 117, 125, 0.15);
        --info: #17a2b8;
        --info-soft: rgba(23, 162, 184, 0.15);
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        line-height: 1.7;
        color: #2d3748;
        background-color: #f5f5f5;
    }

    /* Hero Section */
    .hero-section h1 {
        font-size: 3.5rem;
        letter-spacing: -1px;
        line-height: 1.1;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .hero-section .lead {
        font-size: 1.5rem;
        max-width: 650px;
        margin: 0 auto 2.5rem;
        opacity: 0.95;
    }

    /* Slider Animation */
    .slider-container {
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    .slider-track {
        display: flex;
        width: 300%;
        height: 100%;
        animation: slideForward 18s linear infinite;
    }

    .slide {
        width: 33.33%;
        height: 100%;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        filter: brightness(0.8);
    }

    @keyframes slideForward {
        0% { transform: translateX(0); }
        30% { transform: translateX(0); }
        33.33% { transform: translateX(-33.33%); }
        63.33% { transform: translateX(-33.33%); }
        66.66% { transform: translateX(-66.66%); }
        96.66% { transform: translateX(-66.66%); }
        100% { transform: translateX(-100%); }
    }

    /* Mission Section */
    .mission-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.1'%3E%3Cpath d='M50 50c0-5.52-4.48-10-10-10s-10 4.48-10 10 4.48 10 10 10 10-4.48 10-10zm-20-40c0-5.52-4.48-10-10-10S10 4.48 10 10s4.48 10 10 10 10-4.48 10-10zm40 20c0-5.52-4.48-10-10-10s-10 4.48-10 10 4.48 10 10 10 10-4.48 10-10z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.5;
    }

    .section-header .divider {
        width: 100px;
        height: 4px;
        border-radius: 2px;
        background-color: #ffffff;
    }

    /* Feature Cards */
    .feature-card {
        transition: transform 0.4s ease, box-shadow 0.4s ease;
        border-radius: 12px;
    }

    .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .icon-wrapper {
        width: 70px;
        height: 70px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .icon-wrapper-sm {
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Session Cards */
    .card {
        transition: transform 0.4s ease, box-shadow 0.4s ease;
        border-radius: 16px;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }

    .card-header {
        padding: 1.75rem 1.75rem 0.75rem;
    }

    .card-body {
        padding: 0.75rem 1.75rem;
    }

    .card-footer {
        padding: 1.25rem 1.75rem 1.75rem;
    }

    /* Buttons */
    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
        font-weight: 700;
        letter-spacing: 0.5px;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0052d9;
        border-color: #0052d9;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 98, 255, 0.3);
    }

    .btn-lg {
        padding: 1rem 2rem;
        font-size: 1.25rem;
    }

    /* Badges */
    .badge {
        font-weight: 700;
        letter-spacing: 1px;
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
        text-transform: uppercase;
        border-radius: 6px;
    }

    .bg-primary {
        background-color: var(--primary) !important;
    }

    .bg-success {
        background-color: var(--success) !important;
    }

    .bg-secondary {
        background-color: var(--secondary) !important;
    }

    /* Animations */
    .fade-in {
        opacity: 0;
        animation: fadeIn 1.2s ease-in-out forwards;
    }

    .fade-in.delay-1 { animation-delay: 0.4s; }
    .fade-in.delay-2 { animation-delay: 0.8s; }

    .slide-in {
        opacity: 0;
        transform: translateY(30px);
        animation: slideIn 0.9s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
    }

    .slide-in.delay-0 { animation-delay: 0s; }
    .slide-in.delay-1 { animation-delay: 0.3s; }
    .slide-in.delay-2 { animation-delay: 0.6s; }
    .slide-in.delay-3 { animation-delay: 0.9s; }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Empty State */
    .empty-state {
        max-width: 600px;
        margin: 0 auto;
    }

    .empty-state-icon {
        width: 90px;
        height: 90px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Responsive Adjustments */
    @media (max-width: 1200px) {
        .hero-section h1 {
            font-size: 3rem;
        }

        .hero-section .lead {
            font-size: 1.35rem;
        }
    }

    @media (max-width: 992px) {
        .hero-section h1 {
            font-size: 2.5rem;
        }

        .hero-section .lead {
            font-size: 1.25rem;
        }
    }

    @media (max-width: 768px) {
        .hero-section {
            height: 60vh;
        }

        .hero-section h1 {
            font-size: 2.2rem;
        }

        .hero-section .lead {
            font-size: 1.15rem;
        }

        .feature-card {
            padding: 1.5rem;
        }
    }

    @media (max-width: 576px) {
        .hero-section h1 {
            font-size: 1.8rem;
        }

        .hero-section .lead {
            font-size: 1rem;
        }

        .btn-lg {
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
        }
    }
</style>
@endpush