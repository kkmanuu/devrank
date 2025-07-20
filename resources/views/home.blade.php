@extends('layouts.app')

@section('title', 'DevRank - Empowering Student Developers')

@section('content')
<!-- Hero Section -->
<section class="hero-section position-relative d-flex align-items-center text-white" style="background: url('{{ asset('images/devk.jpg') }}') no-repeat center center / cover; height: 100vh">
    <div class="overlay position-absolute w-100 h-100" style="background: rgba(0, 0, 0, 0.65); z-index: 1"></div>
    <div class="container text-center position-relative z-2 py-5">
        <h1 class="display-3 fw-bold animate__animated animate__fadeInDown">Welcome to DevRank</h1>
        <p class="lead mb-4 animate__animated animate__fadeInUp animate__delay-1s">Empowering student developers to build, grow, and thrive in tech.</p>
        <div class="d-flex justify-content-center gap-3 animate__animated animate__fadeInUp animate__delay-2s">
            <a href="{{ route('register') }}" class="btn btn-lg btn-primary px-4">Get Started</a>
            <a href="{{ route('services') }}" class="btn btn-lg btn-outline-light px-4">Learn More</a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center fw-bold mb-5 animate__animated animate__fadeIn">Why Choose DevRank?</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 text-center p-4 animate__animated animate__fadeInUp">
                    <i class="bi bi-code-slash display-4 text-primary mb-3"></i>
                    <h5 class="fw-bold">Submit Projects</h5>
                    <p class="mb-3">Upload your coding projects for review, scoring, and expert feedback.</p>
                    <a href="{{ route('project.create') }}" class="btn btn-primary btn-sm">Submit Now</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 text-center p-4 animate__animated animate__fadeInUp animate__delay-1s">
                    <i class="bi bi-chat-square-text display-4 text-primary mb-3"></i>
                    <h5 class="fw-bold">Get Feedback</h5>
                    <p class="mb-3">Receive detailed reviews to improve your code and development skills.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 text-center p-4 animate__animated animate__fadeInUp animate__delay-2s">
                    <i class="bi bi-person-video3 display-4 text-primary mb-3"></i>
                    <h5 class="fw-bold">Coaching Sessions</h5>
                    <p class="mb-3">Join live 1-on-1 or group coaching with senior developers and mentors.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Impact Section -->
<section class="py-5 text-white" style="background: #1c1f23;">
    <div class="container">
        <h2 class="text-center mb-5 animate__animated animate__fadeIn">Our Impact</h2>
        <div class="row text-center g-4">
            @foreach ([
                ['1,000+', 'Students Empowered'],
                ['5,000+', 'Projects Evaluated'],
                ['500+', 'Coaching Sessions Held'],
                ['95%', 'Satisfaction Rate']
            ] as $i => $stat)
            <div class="col-md-3 animate__animated animate__fadeInUp animate__delay-{{ $i+1 }}s">
                <div class="p-4 bg-dark rounded shadow-sm">
                    <h3 class="display-6 text-primary fw-bold">{{ $stat[0] }}</h3>
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
        <h2 class="text-center fw-bold mb-5 animate__animated animate__fadeIn">What Our Students Say</h2>
        <div class="row g-4">
            @foreach ([
                ['DevRank helped me land my first internship by reviewing and guiding my portfolio!', 'Jane Doe, Frontend Developer'],
                ['Thanks to DevRank, I improved my code quality and passed technical interviews.', 'John Smith, Full-Stack Developer']
            ] as $i => $t)
            <div class="col-md-6 animate__animated animate__fadeInUp animate__delay-{{ $i+1 }}s">
                <div class="p-4 bg-white shadow-sm rounded">
                    <p class="mb-2">“{{ $t[0] }}”</p>
                    <footer class="blockquote-footer">{{ $t[1] }}</footer>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="py-5 text-white text-center" style="background: linear-gradient(135deg, #007bff, #6610f2);">
    <div class="container">
        <h2 class="mb-3 animate__animated animate__fadeIn">Join the DevRank Community</h2>
        <p class="lead mb-4 animate__animated animate__fadeInUp">Whether you're just starting or looking to level up, DevRank is here to support your journey.</p>
        <a href="{{ route('register') }}" class="btn btn-lg btn-light px-4 animate__animated animate__fadeInUp animate__delay-1s">Get Started</a>
    </div>
</section>
@endsection
