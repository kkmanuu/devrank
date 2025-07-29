@extends('layouts.app')

@section('title', 'DevRank - Empowering Student Developers')

@section('content')
<!-- Hero Section -->
<section id="hero-slider" class="hero-section position-relative d-flex align-items-center text-white" style="height: 80vh; overflow: hidden;">
    <div class="slider-container position-absolute w-100 h-100" style="z-index: 0;">
        <div class="slider-track">
            <div class="slide" style="background-image: url('{{ asset('images/techss.jpg') }}');"></div>
            <div class="slide" style="background-image: url('{{ asset('images/pex.jpg') }}');"></div>
            <div class="slide" style="background-image: url('{{ asset('images/deve.jpg') }}');"></div>
        </div>
    </div>
    
    <div class="container text-center position-relative z-2 py-5">
        <h1 class="display-3 fw-bold slide-in">Launch Your Tech Career with DevRank</h1>
        <p class="lead mb-4 slide-in delay-1">Join a community of student developers to build projects, gain expert feedback, and grow with personalized coaching.</p>
        <div class="d-flex justify-content-center gap-3 slide-in delay-2">
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5 py-3">Start Your Journey</a>
            <a href="#features" class="btn btn-outline-light btn-lg px-5 py-3">Explore Features</a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-5 features-section" style="background-color: #e6f0fa;">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="fw-bold mb-3 fade-in">Why Choose DevRank?</h2>
            <p class="text-muted mx-auto fade-in delay-1" style="max-width: 700px;">Unlock your potential with tools and support designed for student developers.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4 col-sm-6">
                <div class="feature-item text-center p-4 border-0 rounded-3 bg-white shadow-sm slide-in">
                    <div class="icon-wrapper bg-primary text-white rounded-circle mb-3">
                        <i class="bi bi-code-slash fs-3"></i>
                    </div>
                    <h5 class="fw-bold text-dark">Submit Projects</h5>
                    <p class="text-muted mb-3">Showcase your coding projects for expert reviews and personalized feedback.</p>
                    <a href="{{ route('project.create') }}" class="btn btn-primary btn-sm px-4">Submit Now</a>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="feature-item text-center p-4 border-0 rounded-3 bg-white shadow-sm slide-in delay-1">
                    <div class="icon-wrapper bg-primary text-white rounded-circle mb-3">
                        <i class="bi bi-chat-square-text fs-3"></i>
                    </div>
                    <h5 class="fw-bold text-dark">Get Feedback</h5>
                    <p class="text-muted mb-3">Receive actionable insights to enhance your code and technical skills.</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="feature-item text-center p-4 border-0 rounded-3 bg-white shadow-sm slide-in delay-2">
                    <div class="icon-wrapper bg-primary text-white rounded-circle mb-3">
                        <i class="bi bi-person-video3 fs-3"></i>
                    </div>
                    <h5 class="fw-bold text-dark">Coaching Sessions</h5>
                    <p class="text-muted mb-3">Learn directly from industry mentors in 1:1 or group sessions.</p>
                    <a href="{{ route('coaching.index') }}" class="btn btn-primary btn-sm px-4">Book a Session</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Showcase Section -->
<section class="py-5 showcase-section" style="background-color: #fff8e1;">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="fw-bold mb-3 fade-in">See DevRank in Action</h2>
            <p class="text-muted mx-auto fade-in delay-1" style="max-width: 700px;">Discover how our community transforms ideas into reality.</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="ratio ratio-16x9 shadow-lg rounded-3 overflow-hidden slide-in">
                    <iframe src="https://www.youtube.com/embed/suATPK45sjk?si=mL64WR9c0QEkuOEN" title="DevRank Showcase" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
                <p class="text-center mt-4 text-muted fade-in delay-1">Join thousands of developers building their future with DevRank.</p>
            </div>
        </div>
    </div>
</section>

<!-- Impact Section -->
<section class="py-5 impact-section text-white" style="background: linear-gradient(135deg, #2c3e50, #1c2526);">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="fw-bold mb-3 fade-in">Our Impact</h2>
            <p class="text-white-50 mx-auto fade-in delay-1" style="max-width: 700px;">See the difference DevRank makes for student developers worldwide.</p>
        </div>
        <div class="d-flex flex-wrap justify-content-center gap-4">
            @foreach ([
                ['1,000+', 'Students Empowered'],
                ['5,000+', 'Projects Evaluated'],
                ['500+', 'Coaching Sessions Held'],
                ['95%', 'Satisfaction Rate']
            ] as $i => $stat)
            <div class="impact-item text-center scale-up delay-{{ $i }}">
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
<section class="py-5 testimonials-section" style="background-color: #fce4ec;">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="fw-bold mb-3 fade-in">What Our Students Say</h2>
            <p class="text-muted mx-auto fade-in delay-1" style="max-width: 700px;">Hear from developers who transformed their careers with DevRank.</p>
        </div>
        <div class="row g-4">
            @foreach ([
                ['DevRank’s feedback on my portfolio was a game-changer for landing my first internship!', 'Jane Doe, Frontend Developer'],
                ['The coaching sessions helped me ace technical interviews and improve my coding skills.', 'John Smith, Full-Stack Developer'],
                ['DevRank’s community inspired me to push my limits and build impactful projects.', 'Alex Lee, Software Engineer']
            ] as $i => $t)
            <div class="col-md-4">
                <div class="testimonial-item p-4 bg-white rounded-3 shadow-sm position-relative slide-in delay-{{ $i }}">
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
<section class="py-5 cta-section text-white text-center" style="background: linear-gradient(135deg, #007bff, #6610f2);">
    <div class="container">
        <h2 class="mb-3 fw-bold fade-in">Join the DevRank Community Today</h2>
        <p class="lead mb-4 fade-in delay-1">Start building, learning, and growing with DevRank’s supportive community.</p>
        <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 py-3 fade-in delay-2">Get Started Now</a>
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

    /* Features Section */
    .features-section .feature-item {
        transition: transform 0.4s ease, box-shadow 0.4s ease;
        border-radius: 12px;
    }

    .features-section .feature-item:hover {
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

    /* Showcase Section */
    .showcase-section .ratio iframe {
        border-radius: 12px;
    }

    /* Impact Section */
    .impact-section .stat-circle {
        width: 140px;
        height: 140px;
        border: 2px solid var(--primary);
        transition: transform 0.4s ease, box-shadow 0.4s ease;
        border-radius: 50%;
    }

    .impact-section .stat-circle:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    /* Testimonials Section */
    .testimonials-section .testimonial-item {
        transition: transform 0.4s ease, box-shadow 0.4s ease;
        border-radius: 12px;
    }

    .testimonials-section .testimonial-item:hover {
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

    .fade-in.delay-0 { animation-delay: 0s; }
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

    .scale-up.delay-0 { animation-delay: 0s; }
    .scale-up.delay-1 { animation-delay: 0.3s; }
    .scale-up.delay-2 { animation-delay: 0.6s; }
    .scale-up.delay-3 { animation-delay: 0.9s; }

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

        .stat-circle {
            width: 120px;
            height: 120px;
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

        .feature-item, .testimonial-item {
            padding: 1.25rem;
        }

        .stat-circle {
            width: 100px;
            height: 100px;
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

        .stat-circle {
            width: 80px;
            height: 80px;
        }
    }
</style>
@endpush