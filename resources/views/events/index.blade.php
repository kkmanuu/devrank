@extends('layouts.app')

@section('title', 'DevRank - Upcoming Events')

@section('content')

<!-- Hero Section -->
<section class="hero-section position-relative d-flex align-items-center text-white" style="height: 70vh; overflow: hidden;">
    <div class="slider-container position-absolute w-100 h-100" style="z-index: 0;">
        <div class="slider-track">
            <div class="slide" style="background-image: url('{{ asset('images/techss.jpg') }}');"></div>
            <div class="slide" style="background-image: url('{{ asset('images/pex.jpg') }}');"></div>
            <div class="slide" style="background-image: url('{{ asset('images/deve.jpg') }}');"></div>
        </div>
    </div>
    <div class="overlay position-absolute w-100 h-100" style="background: linear-gradient(135deg, rgba(0, 98, 255, 0.6), rgba(0, 0, 0, 0.7)); z-index: 1;"></div>
    <div class="container text-center position-relative z-2 py-5">
        <h1 class="display-3 fw-bold slide-in">Discover Upcoming Events</h1>
        <p class="lead mb-4 slide-in delay-1">Join our vibrant community to learn, network, and elevate your developer skills.</p>
        <a href="#events" class="btn btn-primary btn-lg px-5 py-3 slide-in delay-2">
            <i class="bi bi-calendar-event me-2"></i>Explore Events
        </a>
    </div>
</section>

<!-- Mission Section -->
<section class="py-5 mission-section text-white" style="background-color: #2c3e50;">
    <div class="container">
        <div class="section-header text-center mb-5">
            <span class="badge bg-primary text-white mb-3">Our Mission</span>
            <h2 class="fw-bold mb-4 fade-in">Empowering the Next Generation of Developers</h2>
            <div class="divider mx-auto bg-white"></div>
        </div>
        <p class="lead text-center fade-in delay-1 px-3" style="max-width: 800px; margin: 0 auto;">
            At DevRank, we are committed to fostering a dynamic community where student developers gain practical skills, 
            connect with mentors, and unlock opportunities to excel in the tech industry.
        </p>
    </div>
</section>

<!-- What We Offer Section -->
<section class="py-5 offer-section" style="background-color: #e6f0fa;">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="fw-bold mb-3 text-dark fade-in">What We Offer</h2>
            <p class="text-muted mx-auto fade-in delay-1" style="max-width: 700px;">
                Engage in transformative experiences designed to boost your technical and professional growth.
            </p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 text-center p-4 border-0 bg-white shadow-sm fade-in">
                    <div class="icon-wrapper bg-primary text-white rounded-circle mb-3">
                        <i class="bi bi-lightbulb fs-3"></i>
                    </div>
                    <h5 class="fw-bold">Workshops</h5>
                    <p class="text-muted">Hands-on sessions on cutting-edge technologies led by industry experts.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center p-4 border-0 bg-white shadow-sm fade-in delay-1">
                    <div class="icon-wrapper bg-primary text-white rounded-circle mb-3">
                        <i class="bi bi-people-fill fs-3"></i>
                    </div>
                    <h5 class="fw-bold">Community</h5>
                    <p class="text-muted">A collaborative network for developers to connect and grow together.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center p-4 border-0 bg-white shadow-sm fade-in delay-2">
                    <div class="icon-wrapper bg-primary text-white rounded-circle mb-3">
                        <i class="bi bi-code-slash fs-3"></i>
                    </div>
                    <h5 class="fw-bold">Hackathons</h5>
                    <p class="text-muted">Compete in real-world projects for rewards and recognition.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Events Section -->
<section id="events" class="py-5 events-section" style="background-color: #fff8e1;">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="fw-bold mb-3 fade-in">Upcoming Events</h2>
            <p class="text-muted mx-auto fade-in delay-1" style="max-width: 700px;">
                Browse our events and secure your spot. Limited spaces ensure an engaging experience.
            </p>
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

        @if($events->isEmpty())
            <div class="empty-state text-center py-5 fade-in">
                <div class="empty-state-icon bg-primary text-white rounded-circle mb-4 mx-auto">
                    <i class="bi bi-calendar-x fs-1"></i>
                </div>
                <h4 class="fw-bold mb-3">No Events Available</h4>
                <p class="text-muted mb-4">Check back soon for new events or subscribe to stay updated.</p>
                <button class="btn btn-primary px-4 py-2">
                    <i class="bi bi-bell-fill me-2"></i>Notify Me
                </button>
            </div>
        @else
            <div class="row g-4">
                @foreach($events as $event)
                    <div class="col-md-4 col-sm-6">
                        <div class="card h-100 bg-white border-0 rounded-3 shadow-sm slide-in delay-{{ $loop->index % 3 }}">
                            @if($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top" alt="{{ $event->title }}" style="height: 200px; object-fit: cover; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                            @endif
                            <div class="card-body d-flex flex-column p-4">
                                <h5 class="card-title fw-bold text-dark mb-2">{{ $event->title }}</h5>
                                <p class="text-muted mb-3">{{ Str::limit($event->description, 100) }}</p>
                                <ul class="list-unstyled mb-4">
                                    <li class="mb-2">
                                        <i class="bi bi-calendar-event text-primary me-2"></i>
                                        <strong>Date:</strong> {{ $event->event_date->format('F j, Y') }}
                                    </li>
                                    <li class="mb-2">
                                        <i class="bi bi-clock text-primary me-2"></i>
                                        <strong>Time:</strong> {{ $event->start_time }}
                                    </li>
                                    <li>
                                        <i class="bi bi-people-fill text-primary me-2"></i>
                                        <strong>Slots Left:</strong> {{ $event->availableSlots() }}
                                    </li>
                                </ul>
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <a href="{{ route('events.show', $event) }}" class="btn btn-outline-primary btn-sm px-4">View Details</a>
                                    <form action="{{ route('events.book', $event) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm px-4" {{ $event->availableSlots() <= 0 || $event->status !== 'upcoming' ? 'disabled' : '' }}>
                                            Book Now
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
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
        --warning: #ffc107;
        --warning-soft: rgba(255, 193, 7, 0.15);
        --info: #17a2b8;
        --info-soft: rgba(23, 162, 184, 0.15);
        --secondary: #6c757d;
        --secondary-soft: rgba(108, 117, 125, 0.15);
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
    .mission-section .divider {
        width: 100px;
        height: 4px;
        border-radius: 2px;
        background-color: #ffffff;
    }

    /* Offer Section */
    .offer-section .card {
        transition: transform 0.4s ease, box-shadow 0.4s ease;
        border-radius: 12px;
    }

    .offer-section .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .icon-wrapper {
        width: 60px;
        height: 60px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin: 0 auto;
    }

    /* Events Section */
    .events-section .card {
        transition: transform 0.4s ease, box-shadow 0.4s ease;
        border-radius: 12px;
    }

    .events-section .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }

    .card-body {
        padding: 1.5rem;
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

    .btn-outline-primary {
        border-color: var(--primary);
        color: var(--primary);
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-outline-primary:hover {
        background-color: var(--primary);
        color: #ffffff;
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

        .card {
            padding: 1.25rem;
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