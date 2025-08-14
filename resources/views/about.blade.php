@extends('layouts.app')

@section('title', 'About Us - DevRank')

@section('content')
<!-- Hero Section -->
<section id="hero-slider" class="hero-section position-relative d-flex align-items-center text-white" style="height: 75vh; overflow: hidden;">
    <div class="slider-container position-absolute w-100 h-100" style="z-index: 0;">
        <div class="slider-track">
            <div class="slide" style="background-image: url('{{ asset('images/techss.jpg') }}');"></div>
            <div class="slide" style="background-image: url('{{ asset('images/pex.jpg') }}');"></div>
            <div class="slide" style="background-image: url('{{ asset('images/deve.jpg') }}');"></div>
        </div>
    </div>
    
    <div class="container text-center position-relative z-2 py-5">
        <h1 class="display-3 fw-bold slide-in">About DevRank</h1>
        <p class="lead mb-4 slide-in delay-1">Empowering the next generation of developers through innovation, mentorship, and community.</p>
        <a href="#story" class="btn btn-primary btn-lg px-5 py-3 slide-in delay-2">
            <i class="bi bi-arrow-down-circle me-2"></i>Our Story
        </a>
    </div>
</section>

<!-- Company Story Section -->
<section id="story" class="py-5 story-section" style="background-color: #e6f0fa;">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="story-content">
                    <h2 class="fw-bold mb-4 fade-in">Our Journey Began with a Vision</h2>
                    <p class="text-muted mb-4 fade-in delay-1">
                        DevRank was founded in 2022 with a simple yet powerful mission: to bridge the gap between academic learning and real-world tech skills. We recognized that talented student developers often lack the guidance and feedback needed to excel in their careers.
                    </p>
                    <p class="text-muted mb-4 fade-in delay-2">
                        What started as a small community of passionate developers has grown into a comprehensive platform serving thousands of students worldwide. We've facilitated over 5,000 project reviews, hosted hundreds of coaching sessions, and helped launch countless tech careers.
                    </p>
                    <div class="d-flex align-items-center fade-in delay-3">
                        <div class="founder-avatar bg-primary rounded-circle me-3" style="width: 50px; height: 50px;">
                            <i class="bi bi-person-fill text-white fs-4 d-flex align-items-center justify-content-center h-100"></i>
                        </div>
                        <div>
                            <strong class="text-dark">Founded by Tech Leaders</strong>
                            <small class="text-muted d-block">Industry veterans with 15+ years experience</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="story-visual position-relative slide-in delay-1">
                    <div class="ratio ratio-16x9 shadow-lg rounded-3 overflow-hidden">
                        <iframe src="https://www.youtube.com/embed/suATPK45sjk?si=mL64WR9c0QEkuOEN" title="DevRank Story" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision Section -->
<section class="py-5 mission-section" style="background-color: #fff8e1;">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="fw-bold mb-3 fade-in">Mission & Vision</h2>
            <p class="text-muted mx-auto fade-in delay-1" style="max-width: 700px;">
                Driving innovation through education, mentorship, and community building.
            </p>
        </div>
        <div class="row g-5">
            <div class="col-md-6">
                <div class="mission-card bg-white p-5 rounded-3 shadow-sm h-100 slide-in">
                    <div class="icon-wrapper bg-primary text-white rounded-circle mb-4">
                        <i class="bi bi-bullseye fs-3"></i>
                    </div>
                    <h4 class="fw-bold mb-3 text-primary">Our Mission</h4>
                    <p class="text-muted mb-0">
                        To empower student developers with the tools, feedback, and mentorship they need to transform their passion for coding into successful tech careers. We believe every developer deserves access to quality guidance and real-world experience.
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="vision-card bg-white p-5 rounded-3 shadow-sm h-100 slide-in delay-1">
                    <div class="icon-wrapper bg-primary text-white rounded-circle mb-4">
                        <i class="bi bi-eye fs-3"></i>
                    </div>
                    <h4 class="fw-bold mb-3 text-primary">Our Vision</h4>
                    <p class="text-muted mb-0">
                        To become the global leader in developer education and mentorship, creating a world where every aspiring programmer has access to expert guidance, meaningful projects, and a supportive community to accelerate their growth.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Core Values Section -->
<section class="py-5 values-section text-white" style="background: linear-gradient(135deg, #2c3e50, #1c2526);">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="fw-bold mb-3 fade-in">Our Core Values</h2>
            <p class="text-white-50 mx-auto fade-in delay-1" style="max-width: 700px;">
                The principles that guide everything we do at DevRank.
            </p>
        </div>
        <div class="row g-4">
            @foreach([
                ['icon' => 'bi-people', 'title' => 'Community First', 'description' => 'We believe in the power of community to drive learning and growth.'],
                ['icon' => 'bi-lightbulb', 'title' => 'Innovation', 'description' => 'We constantly evolve our platform to meet the changing needs of developers.'],
                ['icon' => 'bi-award', 'title' => 'Excellence', 'description' => 'We maintain high standards in everything we do, from code reviews to mentorship.'],
                ['icon' => 'bi-heart', 'title' => 'Inclusivity', 'description' => 'We welcome developers from all backgrounds and experience levels.'],
                ['icon' => 'bi-graph-up', 'title' => 'Growth Mindset', 'description' => 'We encourage continuous learning and embrace challenges as opportunities.'],
                ['icon' => 'bi-shield-check', 'title' => 'Integrity', 'description' => 'We operate with transparency, honesty, and ethical practices in all interactions.']
            ] as $i => $value)
            <div class="col-md-4 col-sm-6">
                <div class="value-item text-center p-4 bg-dark rounded-3 shadow-sm scale-up delay-{{ $i % 3 }}">
                    <div class="icon-wrapper bg-primary text-white rounded-circle mb-3">
                        <i class="bi {{ $value['icon'] }} fs-3"></i>
                    </div>
                    <h5 class="fw-bold text-white mb-3">{{ $value['title'] }}</h5>
                    <p class="text-white-50 mb-0">{{ $value['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-5 team-section" style="background-color: #fce4ec;">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="fw-bold mb-3 fade-in">Meet Our Team</h2>
            <p class="text-muted mx-auto fade-in delay-1" style="max-width: 700px;">
                Passionate professionals dedicated to your success in tech.
            </p>
        </div>
        <div class="row g-4">
            @foreach([
                ['name' => 'Sarah Johnson', 'role' => 'Co-Founder & CEO', 'bio' => 'Former Google engineer with 12 years experience in tech leadership.', 'skills' => 'Leadership, Strategy, Full-Stack'],
                ['name' => 'Michael Chen', 'role' => 'Co-Founder & CTO', 'bio' => 'Ex-Microsoft architect passionate about developer education.', 'skills' => 'System Design, Mentorship, AI'],
                ['name' => 'Emily Rodriguez', 'role' => 'Head of Community', 'bio' => 'Building inclusive communities for underrepresented developers.', 'skills' => 'Community Building, Diversity, Events'],
                ['name' => 'David Kim', 'role' => 'Senior Mentor', 'bio' => 'Full-stack developer and startup advisor with 10+ years experience.', 'skills' => 'React, Node.js, Mentoring'],
                ['name' => 'Lisa Thompson', 'role' => 'UX Design Lead', 'bio' => 'Creating intuitive experiences for developer tools and platforms.', 'skills' => 'UI/UX, Design Systems, Research'],
                ['name' => 'Alex Martinez', 'role' => 'Data Scientist', 'bio' => 'Using ML to personalize learning paths and improve outcomes.', 'skills' => 'Machine Learning, Python, Analytics']
            ] as $i => $member)
            <div class="col-lg-4 col-md-6">
                <div class="team-card bg-white p-4 rounded-3 shadow-sm text-center slide-in delay-{{ $i % 3 }}">
                    <div class="team-avatar bg-primary rounded-circle mx-auto mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-person-fill text-white fs-2 d-flex align-items-center justify-content-center h-100"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-1">{{ $member['name'] }}</h5>
                    <p class="text-primary mb-2 fw-semibold">{{ $member['role'] }}</p>
                    <p class="text-muted small mb-3">{{ $member['bio'] }}</p>
                    <div class="skills">
                        @foreach(explode(', ', $member['skills']) as $skill)
                        <span class="badge bg-light text-primary me-1 mb-1">{{ $skill }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Impact & Stats Section -->
<section class="py-5 impact-section" style="background-color: #e6f0fa;">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="fw-bold mb-3 fade-in">Our Growing Impact</h2>
            <p class="text-muted mx-auto fade-in delay-1" style="max-width: 700px;">
                Real numbers showing how DevRank is transforming developer careers worldwide.
            </p>
        </div>
        <div class="row g-4">
            @foreach([
                ['number' => '2,500+', 'label' => 'Active Students', 'description' => 'Developers actively using our platform', 'icon' => 'bi-people'],
                ['number' => '8,000+', 'label' => 'Projects Reviewed', 'description' => 'Code reviews and feedback provided', 'icon' => 'bi-code-slash'],
                ['number' => '1,200+', 'label' => 'Coaching Hours', 'description' => '1:1 mentorship sessions completed', 'icon' => 'bi-clock'],
                ['number' => '89%', 'label' => 'Job Success Rate', 'description' => 'Students who landed tech jobs', 'icon' => 'bi-briefcase'],
                ['number' => '45+', 'label' => 'Countries', 'description' => 'Global reach across continents', 'icon' => 'bi-globe'],
                ['number' => '4.8/5', 'label' => 'Satisfaction Score', 'description' => 'Average student rating', 'icon' => 'bi-star-fill']
            ] as $i => $stat)
            <div class="col-lg-4 col-md-6">
                <div class="stat-card bg-white p-4 rounded-3 shadow-sm text-center scale-up delay-{{ $i % 3 }}">
                    <div class="icon-wrapper bg-primary text-white rounded-circle mb-3">
                        <i class="bi {{ $stat['icon'] }} fs-3"></i>
                    </div>
                    <h3 class="fw-bold text-primary mb-1">{{ $stat['number'] }}</h3>
                    <h6 class="fw-bold text-dark mb-2">{{ $stat['label'] }}</h6>
                    <p class="text-muted small mb-0">{{ $stat['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Timeline Section -->
<section class="py-5 timeline-section" style="background-color: #fff8e1;">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="fw-bold mb-3 fade-in">Our Journey</h2>
            <p class="text-muted mx-auto fade-in delay-1" style="max-width: 700px;">
                Key milestones in DevRank's evolution from startup to global platform.
            </p>
        </div>
        <div class="timeline position-relative">
            @foreach([
                ['year' => '2022', 'title' => 'DevRank Founded', 'description' => 'Started with a vision to help student developers'],
                ['year' => '2023', 'title' => 'First 1,000 Users', 'description' => 'Reached our first major user milestone'],
                ['year' => '2024', 'title' => 'Global Expansion', 'description' => 'Extended services to 30+ countries worldwide'],
                ['year' => '2025', 'title' => 'AI Integration', 'description' => 'Launched AI-powered code review and learning paths']
            ] as $i => $milestone)
            <div class="timeline-item d-flex align-items-center mb-4 slide-in delay-{{ $i }}">
                <div class="timeline-marker bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; min-width: 60px;">
                    <span class="fw-bold">{{ $milestone['year'] }}</span>
                </div>
                <div class="timeline-content bg-white p-4 rounded-3 shadow-sm ms-4 flex-grow-1">
                    <h5 class="fw-bold text-dark mb-2">{{ $milestone['title'] }}</h5>
                    <p class="text-muted mb-0">{{ $milestone['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Contact CTA Section -->
<section class="py-5 cta-section text-white text-center" style="background: linear-gradient(135deg, #007bff, #6610f2);">
    <div class="container">
        <h2 class="mb-3 fw-bold fade-in">Ready to Join Our Community?</h2>
        <p class="lead mb-4 fade-in delay-1">Be part of the next generation of successful developers with DevRank.</p>
        <div class="d-flex justify-content-center gap-3 fade-in delay-2">
            <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 py-3">Start Your Journey</a>
            <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg px-5 py-3">Contact Us</a>
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

    /* Story Section */
    .story-section .founder-avatar {
        transition: transform 0.3s ease;
    }

    .story-section .founder-avatar:hover {
        transform: scale(1.1);
    }

    /* Mission & Vision Cards */
    .mission-card, .vision-card {
        transition: transform 0.4s ease, box-shadow 0.4s ease;
        border-left: 4px solid var(--primary);
    }

    .mission-card:hover, .vision-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    /* Values Section */
    .value-item {
        transition: transform 0.4s ease, box-shadow 0.4s ease;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .value-item:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
    }

    /* Team Section */
    .team-card {
        transition: transform 0.4s ease, box-shadow 0.4s ease;
        border-radius: 15px;
    }

    .team-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .team-avatar {
        transition: transform 0.3s ease;
    }

    .team-card:hover .team-avatar {
        transform: scale(1.1);
    }

    /* Stats Section */
    .stat-card {
        transition: transform 0.4s ease, box-shadow 0.4s ease;
        border-radius: 15px;
        border-left: 4px solid var(--primary);
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    /* Timeline */
    .timeline::before {
        content: '';
        position: absolute;
        left: 30px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(to bottom, var(--primary), rgba(0, 98, 255, 0.3));
    }

    .timeline-marker {
        position: relative;
        z-index: 2;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border: 3px solid #fff;
    }

    .timeline-content {
        transition: transform 0.4s ease, box-shadow 0.4s ease;
    }

    .timeline-item:hover .timeline-content {
        transform: translateX(8px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    /* Icon Wrapper */
    .icon-wrapper {
        width: 60px;
        height: 60px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin: 0 auto;
        transition: transform 0.3s ease;
    }

    .icon-wrapper:hover {
        transform: scale(1.1);
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

    /* Skills Badges */
    .skills .badge {
        font-size: 0.75rem;
        font-weight: 500;
    }

    /* Animations */
    .fade-in {
        opacity: 0;
        animation: fadeIn 1.2s ease-in-out forwards;
    }

    .fade-in.delay-0 { animation-delay: 0s; }
    .fade-in.delay-1 { animation-delay: 0.4s; }
    .fade-in.delay-2 { animation-delay: 0.8s; }
    .fade-in.delay-3 { animation-delay: 1.2s; }

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

        .timeline::before {
            left: 20px;
        }

        .timeline-marker {
            width: 40px;
            height: 40px;
            min-width: 40px;
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

        .timeline-item {
            flex-direction: column;
            text-align: center;
        }

        .timeline-content {
            margin-left: 0 !important;
            margin-top: 1rem;
        }

        .timeline::before {
            display: none;
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

        .team-avatar {
            width: 60px !important;
            height: 60px !important;
        }
    }
</style>
@endpush