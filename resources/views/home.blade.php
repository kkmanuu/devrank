@extends('layouts.app')

@section('title', 'DevRank - Empowering Student Developers')

@section('content')
<!-- Hero Section with Forward-Scrolling Background -->
<section id="hero-slider" class="hero-section position-relative d-flex align-items-center text-white" style="height: 80vh; overflow: hidden;">
    <div class="slider-container position-absolute w-100 h-100" style="z-index: 0;">
        <div class="slider-track">
            <div class="slide" style="background-image: url('{{ asset('images/techss.jpg') }}');"></div>
            <div class="slide" style="background-image: url('{{ asset('images/pex.jpg') }}');"></div>
            <div class="slide" style="background-image: url('{{ asset('images/deve.jpg') }}');"></div>
        </div>
    </div>
    <div class="overlay position-absolute w-100 h-100" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.5)); z-index: 1;"></div>
    <div class="container text-center position-relative z-2 py-5">
        <h1 class="display-3 fw-bold slide-in">Welcome to DevRank</h1>
        <p class="lead mb-4 slide-in delay-1">Empowering student developers to build, grow, and thrive in tech.</p>
        <div class="d-flex justify-content-center gap-3 slide-in delay-2">
            <a href="{{ route('register') }}" class="btn btn-lg btn-primary px-5 py-3">Get Started</a>
            <a href="{{ route('services') }}" class="btn btn-lg btn-outline-light px-5 py-3">Learn More</a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center fw-bold mb-5 text-dark fade-in">Why Choose DevRank?</h2>
        <div class="row g-4">
            <div class="col-md-4 col-sm-6">
                <div class="feature-item text-center p-4 border border-light rounded-3 bg-gradient-light slide-in">
                    <i class="bi bi-code-slash display-4 text-primary mb-3"></i>
                    <h5 class="fw-bold text-dark">Submit Projects</h5>
                    <p class="text-muted mb-3">Upload your coding projects for review, scoring, and expert feedback.</p>
                    <a href="{{ route('project.create') }}" class="btn btn-primary btn-sm">Submit Now</a>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="feature-item text-center p-4 border border-light rounded-3 bg-gradient-light slide-in delay-1">
                    <i class="bi bi-chat-square-text display-4 text-primary mb-3"></i>
                    <h5 class="fw-bold text-dark">Get Feedback</h5>
                    <p class="text-muted mb-3">Receive detailed reviews to improve your code and development skills.</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="feature-item text-center p-4 border border-light rounded-3 bg-gradient-light slide-in delay-2">
                    <i class="bi bi-person-video3 display-4 text-primary mb-3"></i>
                    <h5 class="fw-bold text-dark">Coaching Sessions</h5>
                    <p class="text-muted mb-3">Join live 1-on-1 or group coaching with senior developers and mentors.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Impact Section -->
<section class="py-5 text-white" style="background: linear-gradient(135deg, #1c2526, #2c3e50);">
    <div class="container">
        <h2 class="text-center fw-bold mb-5 fade-in">Our Impact</h2>
        <div class="d-flex flex-wrap justify-content-center gap-4">
            @foreach ([
                ['1,000+', 'Students Empowered'],
                ['5,000+', 'Projects Evaluated'],
                ['500+', 'Coaching Sessions Held'],
                ['95%', 'Satisfaction Rate']
            ] as $i => $stat)
            <div class="impact-item text-center scale-up delay-{{ $i+1 }}">
                <div class="stat-circle rounded-circle bg-dark d-flex align-items-center justify-content-center flex-column">
                    <h3 class="display-6 text-primary fw-bold mb-2">{{ $stat[0] }}</h3>
                    <p class="text-white-50 mb-0">{{ $stat[1] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center fw-bold mb-5 text-dark fade-in">What Our Students Say</h2>
        <div class="row g-4">
            @foreach ([
                ['DevRank helped me land my first internship by reviewing and guiding my portfolio!', 'Jane Doe, Frontend Developer'],
                ['Thanks to DevRank, I improved my code quality and passed technical interviews.', 'John Smith, Full-Stack Developer']
            ] as $i => $t)
            <div class="col-md-6">
                <div class="testimonial-item p-4 bg-gradient-light rounded-3 position-relative slide-in delay-{{ $i+1 }}">
                    <i class="bi bi-quote position-absolute text-primary" style="font-size: 2rem; top: 10px; left: 10px; opacity: 0.2;"></i>
                    <p class="mb-2 text-muted">“{{ $t[0] }}”</p>
                    <footer class="blockquote-footer text-primary">{{ $t[1] }}</footer>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="py-5 text-white text-center" style="background: linear-gradient(135deg, #007bff, #6610f2);">
    <div class="container">
        <h2 class="mb-3 fw-bold fade-in">Join the DevRank Community</h2>
        <p class="lead mb-4 fade-in delay-1">Whether you're just starting or looking to level up, DevRank is here to support your journey.</p>
        <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 py-3 fade-in delay-2">Get Started</a>
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

    /* Features Section */
    .bg-gradient-light {
        background: linear-gradient(145deg, #ffffff, #e6e6e6);
    }
    .feature-item {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .feature-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }
    .feature-item i {
        transition: transform 0.3s ease;
    }
    .feature-item:hover i {
        transform: scale(1.1);
    }
    .feature-item .btn-primary {
        font-weight: 600;
    }
    .feature-item .btn-primary:hover {
        background-color: #0056b3;
    }

    /* Impact Section */
    .stat-circle {
        width: 150px;
        height: 150px;
        border: 2px solid #007bff;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .stat-circle:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }
    .text-white-50 {
        color: rgba(255, 255, 255, 0.7) !important;
    }

    /* Testimonials Section */
    .testimonial-item {
        background: linear-gradient(145deg, #ffffff, #e6e6e6);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .testimonial-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }
    .blockquote-footer {
        color: #007bff;
        font-weight: 500;
    }

    /* Call to Action */
    .btn-light {
        background-color: #fff;
        color: #007bff;
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