@extends('layouts.app')

@section('title', 'Services - DevRank')

@section('content')
<!-- Hero Section with Forward-Scrolling Background -->
<section id="hero-slider" class="hero-section position-relative d-flex align-items-center text-white" style="height: 70vh; overflow: hidden;">
    <div class="slider-container position-absolute w-100 h-100" style="z-index: 0;">
        <div class="slider-track">
            <div class="slide" style="background-image: url('{{ asset('images/tech.jpg') }}');"></div>
            <div class="slide" style="background-image: url('{{ asset('images/techs.jpg') }}');"></div>
            <div class="slide" style="background-image: url('{{ asset('images/techss.jpg') }}');"></div>
        </div>
    </div>
    <div class="overlay position-absolute w-100 h-100" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.5)); z-index: 1;"></div>
    <div class="container text-center position-relative z-2 py-5">
        <h1 class="display-3 fw-bold fade-in">Explore Our Services</h1>
        <p class="lead mb-4 fade-in delay-1">Empowering student developers with cutting-edge tools and personalized support.</p>
        <a href="#services" class="btn btn-primary btn-lg px-5 py-3 fade-in delay-2">Discover Now</a>
    </div>
</section>

<!-- Services Overview Section -->
<section id="services" class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center fw-bold mb-5 text-dark fade-in">Our Core Services</h2>
        <div class="row g-4">
            @foreach($services as $service)
            <div class="col-md-4 col-sm-6">
                <div class="service-item text-center p-4 border border-light rounded-3 bg-gradient-light slide-in">
                    <i class="bi {{ $service->icon }} display-3 text-primary mb-3"></i>
                    <h5 class="fw-bold text-dark">{{ $service->title }}</h5>
                    <p class="text-muted mb-0">{{ $service->description }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Event Management and Booking Section -->
<section class="py-5 text-white" style="background: linear-gradient(135deg, #2c3e50, #1c2526);">
    <div class="container">
        <h2 class="text-center fw-bold mb-5 fade-in">Event Management & Booking</h2>
        <div class="row g-4">
            <div class="col-12">
                <div class="p-5 bg-dark rounded-3 shadow-lg text-center scale-up">
                    <h4 class="fw-bold">Join Our Tech Events</h4>
                    <p class="mb-4">Participate in tech events, hackathons, and workshops to network, learn, and showcase your skills. Secure your spot in our upcoming events or coaching sessions to accelerate your growth.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('events.welcome') }}" class="btn btn-outline-light btn-lg px-4">Browse Events</a>
                        <a href="{{ route('coaching.index') }}" class="btn btn-primary btn-lg px-4">Book Coaching</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- YouTube Video Section -->
<section class="py-5 bg-white">
    <div class="container">
        <h2 class="text-center fw-bold mb-5 text-dark fade-in">Why Attend Our Events?</h2>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="ratio ratio-16x9 shadow-lg rounded-3 overflow-hidden">
                    <iframe src="https://www.youtube.com/embed/suATPK45sjk?si=mL64WR9c0QEkuOEN" title="DevRank Events" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
                <p class="text-center mt-4 text-muted fade-in delay-1">Connect with mentors, master cutting-edge skills, and elevate your career with DevRank events!</p>
            </div>
        </div>
    </div>
</section>

<!-- Event Process Section -->
<section class="py-5" style="background: linear-gradient(to bottom, #f8f9fa, #e9ecef);">
    <div class="container">
        <h2 class="text-center fw-bold mb-5 text-dark fade-in">How We Handle Events</h2>
        <div class="row g-4">
            @foreach([
                ['step' => '1', 'title' => 'Event Planning', 'description' => 'We collaborate with industry experts to design impactful tech events and workshops.', 'icon' => 'bi-calendar-event'],
                ['step' => '2', 'title' => 'Registration', 'description' => 'Easily register for events or coaching sessions through our secure platform.', 'icon' => 'bi-person-plus'],
                ['step' => '3', 'title' => 'Execution', 'description' => 'Participate in well-organized events with hands-on learning and networking.', 'icon' => 'bi-gear'],
                ['step' => '4', 'title' => 'Follow-Up', 'description' => 'Receive post-event resources, feedback, and continued support.', 'icon' => 'bi-check-circle'],
            ] as $process)
            <div class="col-md-3 col-sm-6">
                <div class="process-item text-center p-4 border border-light rounded-3 bg-gradient-light slide-in" style="animation-delay: {{ $process['step'] * 0.2 }}s;">
                    <i class="bi {{ $process['icon'] }} display-4 text-primary mb-3"></i>
                    <h5 class="fw-bold text-dark">Step {{ $process['step'] }}: {{ $process['title'] }}</h5>
                    <p class="text-muted mb-0">{{ $process['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="py-5 text-white text-center" style="background: linear-gradient(135deg, #007bff, #6610f2);">
    <div class="container">
        <h2 class="mb-3 fw-bold fade-in">Let's Make Your Event Memorable!</h2>
        <p class="lead mb-4 fade-in delay-1">Whether you're learning or leading, DevRank makes your journey unforgettable.</p>
        <a href="{{ route('events.welcome') }}" class="btn btn-light btn-lg px-5 py-3 fade-in delay-2">Book Now</a>
    </div>
</section>
@endsection

@push('styles')
<style>
    /* General Styling */
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        line-height: 1.6;
        color: #333;
    }

    /* Hero Slider */
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

    /* Hero Section */
    .hero-section h1 {
        font-size: 3.5rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }
    .hero-section .lead {
        font-size: 1.25rem;
        max-width: 600px;
        margin: 0 auto;
    }
    .hero-section .btn-primary {
        background-color: #007bff;
        border: none;
        font-weight: 600;
        transition: transform 0.3s ease, background-color 0.3s ease;
    }
    .hero-section .btn-primary:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }
    .hero-section .btn-outline-light {
        border-color: #fff;
        color: #fff;
        font-weight: 500;
        transition: background-color 0.3s ease, color 0.3s ease;
    }
    .hero-section .btn-outline-light:hover {
        background-color: #fff;
        color: #007bff;
    }

    /* Custom Animations */
    .fade-in {
        opacity: 0;
        animation: fadeIn 1s ease-in-out forwards;
    }
    .fade-in.delay-1 {
        animation-delay: 0.5s;
    }
    .fade-in.delay-2 {
        animation-delay: 1s;
    }
    .fade-in.delay-3 {
        animation-delay: 1.5s;
    }
    .fade-in.delay-4 {
        animation-delay: 2s;
    }
    .slide-in {
        opacity: 0;
        transform: translateX(30px);
        animation: slideIn 1s ease-in-out forwards;
    }
    .slide-in.delay-1 {
        animation-delay: 0.5s;
    }
    .slide-in.delay-2 {
        animation-delay: 1s;
    }
    .slide-in.delay-3 {
        animation-delay: 1.5s;
    }
    .slide-in.delay-4 {
        animation-delay: 2s;
    }
    .scale-up {
        opacity: 0;
        transform: scale(0.8);
        animation: scaleUp 1s ease-in-out forwards;
    }
    .scale-up.delay-1 {
        animation-delay: 0.5s;
    }
    .scale-up.delay-2 {
        animation-delay: 1s;
    }
    .scale-up.delay-3 {
        animation-delay: 1.5s;
    }
    .scale-up.delay-4 {
        animation-delay: 2s;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes slideIn {
        from { opacity: 0; transform: translateX(30px); }
        to { opacity: 1; transform: translateX(0); }
    }
    @keyframes scaleUp {
        from { opacity: 0; transform: scale(0.8); }
        to { opacity: 1; transform: scale(1); }
    }

    /* Services Section */
    .bg-gradient-light {
        background: linear-gradient(145deg, #ffffff, #e6e6e6);
    }
    .service-item {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .service-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }
    .service-item i {
        transition: transform 0.3s ease;
    }
    .service-item:hover i {
        transform: scale(1.1);
    }

    /* Event Management Section */
    .bg-dark {
        background-color: #1a1a1a !important;
        border-radius: 15px;
    }
    .btn-outline-light {
        border-color: #fff;
        color: #fff;
        font-weight: 500;
        transition: background-color 0.3s ease, color 0.3s ease;
    }
    .btn-outline-light:hover {
        background-color: #fff;
        color: #1c2526;
    }
    .btn-primary {
        background-color: #007bff;
        border: none;
        font-weight: 600;
    }
    .btn-primary:hover {
        background-color: #0056b3;
    }

    /* Video Section */
    .ratio iframe {
        border-radius: 10px;
    }
    .text-muted {
        color: #6c757d !important;
    }

    /* Process Section */
    .process-item {
        background: linear-gradient(145deg, #ffffff, #e6e6e6);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .process-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    /* Call to Action */
    .btn-light {
        background-color: #fff;
        color: #007aff;
        font-weight: 600;
        transition: transform 0.3s ease, background-color 0.3s ease;
    }
    .btn-light:hover {
        background-color: #f8f9fa;
        transform: scale(1.05);
        color: #0056b3;
    }
</style>
@endpush