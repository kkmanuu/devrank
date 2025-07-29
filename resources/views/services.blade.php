@extends('layouts.app')

@section('title', 'Services - DevRank')

@section('content')
<!-- Hero Section -->
<section id="hero-slider" class="hero-section position-relative d-flex align-items-center text-white" style="height: 70vh; overflow: hidden;">
    <div class="slider-container position-absolute w-100 h-100" style="z-index: 0;">
        <div class="slider-track">
            <div class="slide" style="background-image: url('{{ asset('images/tech.jpg') }}');"></div>
            <div class="slide" style="background-image: url('{{ asset('images/techs.jpg') }}');"></div>
            <div class="slide" style="background-image: url('{{ asset('images/techss.jpg') }}');"></div>
        </div>
    </div>
    <div class="overlay position-absolute w-100 h-100" style="background: linear-gradient(135deg, rgba(0, 98, 255, 0.6), rgba(0, 0, 0, 0.7)); z-index: 1;"></div>
    <div class="container text-center position-relative z-2 py-5">
        <h1 class="display-3 fw-bold slide-in">Explore Our Services</h1>
        <p class="lead mb-4 slide-in delay-1">Empowering student developers with tools and support to excel in tech.</p>
        <a href="#services" class="btn btn-primary btn-lg px-5 py-3 slide-in delay-2">
            <i class="bi bi-rocket-takeoff me-2"></i>Discover Now
        </a>
    </div>
</section>

<!-- Services Overview Section -->
<section id="services" class="py-5 services-section" style="background-color: #e6f0fa;">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="fw-bold mb-3 fade-in">Our Core Services</h2>
            <p class="text-muted mx-auto fade-in delay-1" style="max-width: 700px;">
                Discover tailored solutions designed to accelerate your growth in the tech industry.
            </p>
        </div>
        <div class="row g-4">
            @foreach($services as $service)
            <div class="col-md-4 col-sm-6">
                <div class="service-item text-center p-4 border-0 rounded-3 bg-white shadow-sm slide-in delay-{{ $loop->index % 3 }}">
                    <div class="icon-wrapper bg-primary text-white rounded-circle mb-3">
                        <i class="bi {{ $service->icon }} fs-3"></i>
                    </div>
                    <h5 class="fw-bold text-dark">{{ $service->title }}</h5>
                    <p class="text-muted mb-0">{{ $service->description }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Event Management and Booking Section -->
<section class="py-5 event-management-section text-white" style="background: linear-gradient(135deg, #2c3e50, #1c2526);">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="fw-bold mb-3 fade-in">Event Management & Booking</h2>
            <p class="mx-auto fade-in delay-1" style="max-width: 700px;">
                Engage in transformative tech events and personalized coaching sessions.
            </p>
        </div>
        <div class="row g-4">
            <div class="col-12">
                <div class="p-5 bg-dark rounded-3 shadow-lg text-center scale-up">
                    <h4 class="fw-bold">Join Our Tech Events</h4>
                    <p class="mb-4">From hackathons to workshops, our events offer networking, learning, and skill-building opportunities. Book a coaching session to take your skills to the next level.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('events.index') }}" class="btn btn-outline-light btn-lg px-4">Browse Events</a>
                        <a href="{{ route('coaching.index') }}" class="btn btn-primary btn-lg px-4">Book Coaching</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- YouTube Video Section -->
<section class="py-5 video-section" style="background-color: #fff8e1;">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="fw-bold mb-3 fade-in">Why Attend Our Events?</h2>
            <p class="text-muted mx-auto fade-in delay-1" style="max-width: 700px;">
                See how DevRank events can transform your tech journey.
            </p>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="ratio ratio-16x9 shadow-lg rounded-3 overflow-hidden">
                    <iframe src="https://www.youtube.com/embed/suATPK45sjk?si=mL64WR9c0QEkuOEN" title="DevRank Events" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
                <p class="text-center mt-4 text-muted fade-in delay-1">Connect with mentors, master new skills, and advance your career with DevRank!</p>
            </div>
        </div>
    </div>
</section>

<!-- Event Process Section -->
<section class="py-5 process-section" style="background-color: #fce4ec;">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="fw-bold mb-3 fade-in">How We Handle Events</h2>
            <p class="text-muted mx-auto fade-in delay-1" style="max-width: 700px;">
                Our streamlined process ensures a seamless and impactful experience.
            </p>
        </div>
        <div class="row g-4">
            @foreach([
                ['step' => '1', 'title' => 'Event Planning', 'description' => 'We collaborate with industry experts to design impactful tech events and workshops.', 'icon' => 'bi-calendar-event'],
                ['step' => '2', 'title' => 'Registration', 'description' => 'Easily register for events or coaching sessions through our secure platform.', 'icon' => 'bi-person-plus'],
                ['step' => '3', 'title' => 'Execution', 'description' => 'Participate in well-organized events with hands-on learning and networking.', 'icon' => 'bi-gear'],
                ['step' => '4', 'title' => 'Follow-Up', 'description' => 'Receive post-event resources, feedback, and continued support.', 'icon' => 'bi-check-circle'],
            ] as $process)
            <div class="col-md-3 col-sm-6">
                <div class="process-item text-center p-4 border-0 rounded-3 bg-white shadow-sm slide-in" style="animation-delay: {{ $process['step'] * 0.2 }}s;">
                    <div class="icon-wrapper bg-primary text-white rounded-circle mb-3">
                        <i class="bi {{ $process['icon'] }} fs-3"></i>
                    </div>
                    <h5 class="fw-bold text-dark">Step {{ $process['step'] }}: {{ $process['title'] }}</h5>
                    <p class="text-muted mb-0">{{ $process['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="py-5 cta-section text-white text-center" style="background: linear-gradient(135deg, #007bff, #6610f2);">
    <div class="container">
        <h2 class="mb-3 fw-bold fade-in">Make Your Tech Journey Unforgettable!</h2>
        <p class="lead mb-4 fade-in delay-1">Join DevRank to learn, connect, and lead in the tech world.</p>
        <a href="{{ route('events.index') }}" class="btn btn-light btn-lg px-5 py-3 fade-in delay-2">Get Started</a>
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
        --danger: #dc3545;
        --danger-soft: rgba(220, 53, 69, 0.15);
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

    /* Section Headers */
    .section-header .divider {
        width: 100px;
        height: 4px;
        border-radius: 2px;
        background-color: var(--primary);
    }

    /* Services Section */
    .services-section .service-item {
        transition: transform 0.4s ease, box-shadow 0.4s ease;
        border-radius: 12px;
    }

    .services-section .service-item:hover {
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

    /* Event Management Section */
    .event-management-section .bg-dark {
        background-color: #1a1a1a !important;
        border-radius: 15px;
    }

    /* Video Section */
    .video-section .ratio iframe {
        border-radius: 12px;
    }

    /* Process Section */
    .process-section .process-item {
        transition: transform 0.4s ease, box-shadow 0.4s ease;
        border-radius: 12px;
    }

    .process-section .process-item:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
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

    .btn-outline-light {
        border-color: #ffffff;
        color: #ffffff;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-outline-light:hover {
        background-color: #ffffff;
        color: #1c2526;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .btn-light {
        background-color: #ffffff;
        color: var(--primary);
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-light:hover {
        background-color: #f8f9fa;
        color: #0052d9;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .btn-lg {
        padding: 1rem 2rem;
        font-size: 1.25rem;
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

    .scale-up {
        opacity: 0;
        transform: scale(0.9);
        animation: scaleUp 0.9s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes scaleUp {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
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

        .service-item, .process-item {
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