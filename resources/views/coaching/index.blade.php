@extends('layouts.app')

@section('title', 'DevRank - Coaching Sessions')

@section('content')
<style>
    :root {
        --primary: #2563eb;
        --primary-light: #3b82f6;
        --primary-dark: #1d4ed8;
        --secondary: #64748b;
        --secondary-light: #94a3b8;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --dark: #1e293b;
        --darker: #0f172a;
        --light: #f8fafc;
        --glass-bg: rgba(255, 255, 255, 0.1);
        --glass-border: rgba(255, 255, 255, 0.15);
        --shadow-light: rgba(0, 0, 0, 0.05);
        --shadow-medium: rgba(0, 0, 0, 0.1);
        --shadow-heavy: rgba(0, 0, 0, 0.25);
    }

    * {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        line-height: 1.6;
        color: #334155;
        background: linear-gradient(135deg, var(--dark) 0%, var(--darker) 100%);
        min-height: 100vh;
        margin: 0;
        padding: 0;
    }

    /* Hero Section */
    .hero-section {
        position: relative;
        padding: 6rem 0 4rem;
        overflow: hidden;
        background: transparent; /* Removed background color */
        min-height: 70vh;
        display: flex;
        align-items: center;
        text-align: center;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 25% 25%, rgba(37, 99, 235, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 75% 75%, rgba(16, 185, 129, 0.08) 0%, transparent 50%);
        animation: gradientFloat 8s ease-in-out infinite;
    }

    @keyframes gradientFloat {
        0%, 100% { opacity: 0.5; transform: scale(1); }
        50% { opacity: 0.8; transform: scale(1.1); }
    }

    .slider-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        opacity: 0.8; /* Adjusted opacity for better visibility */
    }

    .slider-track {
        display: flex;
        width: 300%;
        height: 100%;
        animation: slideAnimation 20s infinite ease-in-out;
    }

    .slide {
        width: 33.333%;
        height: 100%;
        background-size: cover;
        background-position: center;
        filter: brightness(0.8) saturate(1); /* Adjusted filter for clearer images */
    }

    @keyframes slideAnimation {
        0%, 30% { transform: translateX(0); }
        33.33%, 63.33% { transform: translateX(-33.333%); }
        66.66%, 96.66% { transform: translateX(-66.666%); }
        100% { transform: translateX(0); }
    }

    .hero-content {
        position: relative;
        z-index: 2;
        color: white;
        max-width: 800px;
        margin: 0 auto;
    }

    .hero-content h1 {
        font-size: 3.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, #ffffff, #e2e8f0);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1.5rem;
        letter-spacing: -0.02em;
    }

    .hero-content p {
        font-size: 1.25rem;
        color: #cbd5e1;
        margin-bottom: 2.5rem;
        font-weight: 400;
        line-height: 1.7;
    }

    .btn-hero {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        border: none;
        color: white;
        font-weight: 600;
        border-radius: 12px;
        padding: 1rem 2.5rem;
        font-size: 1.1rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        box-shadow: 0 8px 25px rgba(37, 99, 235, 0.3);
        position: relative;
        overflow: hidden;
    }

    .btn-hero:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 35px rgba(37, 99, 235, 0.4);
        color: white;
        background: linear-gradient(135deg, var(--primary-light), var(--primary));
    }

    .btn-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.6s;
    }

    .btn-hero:hover::before {
        left: 100%;
    }

    /* Main Content Background */
    .main-content {
        background: linear-gradient(135deg, var(--dark) 0%, var(--darker) 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    /* Section Styling */
    .section {
        background: rgba(255, 255, 255, 0.02);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 24px;
        padding: 3rem 2rem;
        margin: 2rem 0;
        color: white;
    }

    .section h2 {
        font-size: 2.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, #ffffff, #e2e8f0);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .section p {
        font-size: 1.1rem;
        color: #cbd5e1;
        max-width: 800px;
        margin: 0 auto 2rem;
        text-align: center;
        line-height: 1.7;
    }

    /* Why Join Cards */
    .why-join-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 2rem;
        text-align: center;
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .why-join-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.05), rgba(16, 185, 129, 0.05));
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .why-join-card:hover::before {
        opacity: 1;
    }

    .why-join-card:hover {
        transform: translateY(-8px);
        border-color: rgba(255, 255, 255, 0.2);
        box-shadow: 0 20px 40px var(--shadow-heavy);
    }

    .why-join-card i {
        font-size: 3rem;
        color: var(--primary-light);
        margin-bottom: 1.5rem;
        display: block;
    }

    .why-join-card h4 {
        font-size: 1.5rem;
        font-weight: 600;
        color: white;
        margin-bottom: 1rem;
    }

    .why-join-card p {
        color: #cbd5e1;
        font-size: 1rem;
        line-height: 1.6;
        text-align: center;
        margin: 0;
    }

    /* Filter Section */
    .filter-section {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 3rem;
        text-align: center;
    }

    .filter-section h5 {
        color: white;
        font-weight: 600;
        margin-bottom: 1.5rem;
        font-size: 1.2rem;
    }

    .filter-btn {
        background: rgba(255, 255, 255, 0.08);
        border: 2px solid rgba(255, 255, 255, 0.15);
        color: #cbd5e1;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 500;
        margin: 0.25rem;
        font-size: 0.95rem;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .filter-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(37, 99, 235, 0.3), transparent);
        transition: left 0.6s;
    }

    .filter-btn:hover::before {
        left: 100%;
    }

    .filter-btn:hover,
    .filter-btn.active {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        border-color: var(--primary-light);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(37, 99, 235, 0.3);
    }

    /* Session Cards */
    .session-card {
        margin-bottom: 2rem;
        opacity: 1;
        transform: translateY(0);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .session-card.hidden {
        opacity: 0;
        transform: translateY(20px);
        pointer-events: none;
        height: 0;
        overflow: hidden;
        margin: 0;
    }

    .card-modern {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 24px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 32px var(--shadow-medium);
        height: 100%;
    }

    .card-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), var(--primary-light), var(--success));
        background-size: 200% 100%;
        animation: shimmer 3s ease-in-out infinite;
    }

    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    .card-modern:hover {
        transform: translateY(-8px);
        border-color: rgba(255, 255, 255, 0.2);
        box-shadow: 0 25px 50px var(--shadow-heavy);
    }

    .developer-type-badge {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        font-size: 0.8rem;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        z-index: 2;
        box-shadow: 0 4px 15px var(--shadow-medium);
    }

    .badge-fresher {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
    }

    .badge-professional {
        background: linear-gradient(135deg, var(--warning), #fbbf24);
        color: white;
    }

    .card-header-modern,
    .card-body-modern,
    .card-footer-modern {
        background: transparent;
        border: none;
        color: white;
        position: relative;
        z-index: 1;
    }

    .card-header-modern {
        padding: 2rem 2rem 1rem;
    }

    .card-body-modern {
        padding: 1rem 2rem;
    }

    .card-footer-modern {
        padding: 1rem 2rem 2rem;
    }

    .session-title {
        font-size: 1.4rem;
        font-weight: 600;
        color: white;
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }

    .session-coach {
        color: #cbd5e1;
        font-size: 0.95rem;
        margin-bottom: 1rem;
    }

    .session-info-item {
        display: flex;
        align-items: center;
        margin-bottom: 0.75rem;
        padding: 0.5rem 0.75rem;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        font-size: 0.9rem;
    }

    .session-info-item:hover {
        background: rgba(255, 255, 255, 0.08);
        transform: translateX(4px);
    }

    .session-info-item i {
        color: var(--primary-light);
        margin-right: 0.75rem;
        font-size: 1rem;
        width: 16px;
        text-align: center;
    }

    .status-badge {
        font-size: 0.8rem;
        padding: 0.4rem 0.8rem;
        border-radius: 50px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-upcoming {
        background: linear-gradient(135deg, var(--success), #34d399);
        color: white;
    }

    .status-completed {
        background: linear-gradient(135deg, var(--secondary), var(--secondary-light));
        color: white;
    }

    .status-cancelled {
        background: linear-gradient(135deg, var(--danger), #f87171);
        color: white;
    }

    /* Buttons */
    .btn-modern {
        border-radius: 10px;
        font-weight: 500;
        padding: 0.75rem 1.25rem;
        font-size: 0.9rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: none;
    }

    .btn-outline-light-modern {
        background: rgba(255, 255, 255, 0.08);
        border: 2px solid rgba(255, 255, 255, 0.2);
        color: #cbd5e1;
    }

    .btn-outline-light-modern:hover {
        background: rgba(255, 255, 255, 0.15);
        border-color: rgba(255, 255, 255, 0.3);
        color: white;
        transform: translateY(-1px);
        text-decoration: none;
    }

    .btn-primary-modern {
        background: personal: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
        box-shadow: 0 4px 15px rgba(37, 99, 235, 0.2);
    }

    .btn-primary-modern:hover {
        background: linear-gradient(135deg, var(--primary-light), var(--primary-dark));
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
        color: white;
        text-decoration: none;
    }

    .btn-primary-modern:disabled,
    .btn-primary-modern.disabled {
        background: var(--secondary);
        transform: none;
        box-shadow: none;
        cursor: not-allowed;
        opacity: 0.6;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 24px;
        color: white;
    }

    .empty-state i {
        font-size: 4rem;
        color: var(--secondary-light);
        margin-bottom: 1.5rem;
        opacity: 0.7;
    }

    .empty-state h4 {
        color: white;
        margin-bottom: 1rem;
    }

    .empty-state p {
        color: #cbd5e1;
        margin-bottom: 2rem;
    }

    /* Alerts */
    .alert {
        border-radius: 12px;
        border: none;
        padding: 1rem 1.5rem;
        margin-bottom: 2rem;
        backdrop-filter: blur(10px);
    }

    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        border-left: 4px solid var(--success);
        color: #34d399;
    }

    .alert-danger {
        background: rgba(239, 68, 68, 0.1);
        border-left: 4px solid var(--danger);
        color: #f87171;
    }

    /* Page Title */
    .page-title {
        color: white;
        font-weight: 700;
        font-size: 2rem;
        margin-bottom: 2rem;
    }

    /* Animations */
    .fade-in {
        opacity: 0;
        animation: fadeIn 0.8s ease-in-out forwards;
    }

    .slide-in {
        opacity: 0;
        transform: translateY(20px);
        animation: slideIn 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }

    .slide-in.delay-1 { animation-delay: 0.2s; }
    .slide-in.delay-2 { animation-delay: 0.4s; }
    .slide-in.delay-3 { animation-delay: 0.6s; }

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
        .hero-content h1 {
            font-size: 2.5rem;
        }
        
        .hero-content p {
            font-size: 1.1rem;
        }
        
        .section {
            padding: 2rem 1rem;
            margin: 1rem 0;
        }
        
        .filter-section {
            padding: 1.5rem;
        }
        
        .developer-type-badge {
            position: relative;
            top: auto;
            right: auto;
            margin-bottom: 1rem;
            display: inline-block;
        }

        .section h2 {
            font-size: 2rem;
        }

        .why-join-card {
            margin-bottom: 1.5rem;
        }

        .btn-modern {
            font-size: 0.85rem;
            padding: 0.6rem 1rem;
        }
    }

    @media (max-width: 576px) {
        .hero-section {
            padding: 4rem 0 2rem;
            min-height: 60vh;
        }
        
        .btn-hero {
            font-size: 1rem;
            padding: 0.875rem 2rem;
        }
        
        .filter-btn {
            display: block;
            width: 100%;
            margin: 0.25rem 0;
        }
    }
</style>

<!-- Hero Section -->
<section class="hero-section">
    <div class="slider-container">
        <div class="slider-track">
            <div class="slide" style="background-image: url('{{ asset('images/techss.jpg') }}');"></div>
            <div class="slide" style="background-image: url('{{ asset('images/pex.jpg') }}');"></div>
            <div class="slide" style="background-image: url('{{ asset('images/deve.jpg') }}');"></div>
        </div>
    </div>
    <div class="container">
        <div class="hero-content">
            <h1 class="slide-in">Elevate Your Tech Journey</h1>
            <p class="slide-in delay-1">Unlock your potential with personalized 1:1 coaching from industry leaders.</p>
            <a href="#sessions" class="btn-hero slide-in delay-2">
                <i class="bi bi-calendar-check me-2"></i>Explore Sessions
            </a>
        </div>
    </div>
</section>

<div class="main-content">
    <!-- Mission Section -->
    <div class="container">
        <section class="section slide-in">
            <h2>Our Mission</h2>
            <p>
                At DevRank, we are dedicated to empowering developers at every stage of their journey. 
                Our mission is to bridge the gap between ambition and achievement by providing world-class 
                coaching that fosters growth, innovation, and confidence in the tech world.
            </p>
        </section>
    </div>

    <!-- Why Join Section -->
    <div class="container">
        <section class="section slide-in delay-1">
            <h2>Why Join DevRank Coaching?</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="why-join-card slide-in delay-1">
                        <i class="bi bi-rocket-takeoff"></i>
                        <h4>Accelerate Your Growth</h4>
                        <p>Learn cutting-edge skills from industry experts to fast-track your career.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="why-join-card slide-in delay-2">
                        <i class="bi bi-person-check"></i>
                        <h4>Personalized Mentorship</h4>
                        <p>Get tailored guidance to overcome your unique challenges and achieve your goals.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="why-join-card slide-in delay-3">
                        <i class="bi bi-people-fill"></i>
                        <h4>Join a Thriving Community</h4>
                        <p>Connect with like-minded developers and build a network that lasts.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Sessions Section -->
    <section id="sessions" class="py-5">
        <div class="container">
            <h1 class="page-title fade-in">Discover Our Coaching Sessions</h1>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($sessions->isEmpty())
                <p>No coaching sessions available yet.</p>
            @else
                <!-- Filter Buttons -->
                <div class="filter-section slide-in">
                    <h5>Filter by Experience Level</h5>
                    <div class="filter-buttons">
                        <button class="btn filter-btn active" data-filter="all">All Sessions</button>
                        <button class="btn filter-btn" data-filter="fresher">Fresher Developer</button>
                        <button class="btn filter-btn" data-filter="professional">Professional Developer</button>
                    </div>
                </div>

                <div class="row g-4" id="sessions-grid">
                    @foreach($sessions as $session)
                        <div class="col-md-6 col-lg-4 session-card slide-in delay-{{ $loop->index % 3 }}" data-type="{{ $session->developer_type ?? 'fresher' }}">
                            <div class="card card-modern border-0">
                                <span class="developer-type-badge badge-{{ $session->developer_type ?? 'fresher' }}">
                                    <i class="bi bi-{{ $session->developer_type === 'professional' ? 'briefcase' : 'code-slash' }} me-1"></i>
                                    {{ ucfirst($session->developer_type ?? 'fresher') }} Level
                                </span>
                                
                                <div class="card-header-modern">
                                    <h5 class="session-title">{{ $session->topic }}</h5>
                                    <p class="session-coach">
                                        <i class-="bi bi-person-circle me-1"></i>
                                        {{ $session->coach->name ?? 'Not Assigned' }}
                                    </p>
                                    <span class="status-badge status-{{ $session->status }}">
                                        {{ ucfirst($session->status) }}
                                    </span>
                                </div>
                                
                                <div class="card-body-modern">
                                    @if($session->description)
                                        <div class="session-info-item mb-3">
                                            <i class="bi bi-card-text"></i>
                                            <span>{{ Str::limit($session->description, 80) }}</span>
                                        </div>
                                    @endif
                                    
                                    <div class="session-info-item">
                                        <i class="bi bi-calendar-event"></i>
                                        <span><strong>Date:</strong> {{ $session->session_date->format('M d, Y') }}</span>
                                    </div>
                                    
                                    <div class="session-info-item">
                                        <i class="bi bi-clock"></i>
                                        <span><strong>Time:</strong> {{ \Carbon\Carbon::parse($session->start_time)->format('h:i A') }}</span>
                                    </div>
                                    
                                    <div class="session-info-item">
                                        <i class="bi bi-currency-exchange"></i>
                                        <span><strong>Price:</strong> {{ number_format($session->amount, 2) }} KES</span>
                                    </div>
                                    
                                    <div class="session-info-item">
                                        <i class="bi bi-hourglass-split"></i>
                                        <span><strong>Duration:</strong> {{ $session->duration ?? '60' }}min</span>
                                    </div>
                                    
                                    <div class="session-info-item">
                                        <i class="bi bi-people"></i>
                                        <span><strong>Available:</strong> 
                                            <span class="text-warning fw-bold">{{ $session->availableSlots() }}</span>/{{ $session->capacity ?? $session->max_students }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="card-footer-modern">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('coaching.show', $session) }}" class="btn btn-outline-light-modern btn-modern flex-fill">
                                            <i class="bi bi-eye me-2"></i>Details
                                        </a>
                                        <a href="{{ route('coaching.book.form', $session) }}" 
                                           class="btn btn-primary-modern btn-modern flex-fill {{ $session->availableSlots() <= 0 || $session->status !== 'upcoming' ? 'disabled' : '' }}">
                                            <i class="bi bi-calendar-check-fill me-2"></i>
                                            Book Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality with smooth animations
    const filterBtns = document.querySelectorAll('.filter-btn');
    const sessionCards = document.querySelectorAll('.session-card');
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const filter = this.dataset.filter;
            
            // Update active button with smooth transition
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Filter cards with staggered animation
            sessionCards.forEach((card, index) => {
                const cardType = card.dataset.type;
                
                if (filter === 'all' || cardType === filter) {
                    // Show card
                    setTimeout(() => {
                        card.classList.remove('hidden');
                        card.style.display = 'block';
                    }, index * 50); // Staggered animation
                } else {
                    // Hide card
                    card.classList.add('hidden');
                    setTimeout(() => {
                        if (card.classList.contains('hidden')) {
                            card.style.display = 'none';
                        }
                    }, 400);
                }
            });
        });
    });
    
    // Smooth scroll to sections
    document.querySelector('a[href="#sessions"]')?.addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector('#sessions').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    });
    
    // Intersection Observer for scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
            }
        });
    }, observerOptions);
    
    // Observe elements for scroll animations
    document.querySelectorAll('.slide-in:not(.delay-1):not(.delay-2):not(.delay-3)').forEach(el => {
        observer.observe(el);
    });
    
    // Card hover effects
    document.querySelectorAll('.card-modern').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
    
    // Filter button hover effects
    filterBtns.forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            if (!this.classList.contains('active')) {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 6px 20px rgba(255, 255, 255, 0.1)';
            }
        });
        
        btn.addEventListener('mouseleave', function() {
            if (!this.classList.contains('active')) {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'none';
            }
        });
    });
});
</script>

@endsection