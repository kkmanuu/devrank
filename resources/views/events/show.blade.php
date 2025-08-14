@extends('layouts.app')

@section('title', 'DevRank - Event Details')

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
        <h1 class="display-4 fw-bold slide-in">{{ $event->title }}</h1>
        <p class="lead mb-4 slide-in delay-1">
            {{ $event->event_date->format('F d, Y') }} at {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}
        </p>
        <div class="event-badge slide-in delay-2">
            <span class="badge bg-info text-dark px-3 py-2">
                <i class="bi bi-calendar-event me-2"></i>
                {{ $event->status === 'upcoming' ? 'Upcoming Event' : ucfirst($event->status) }}
            </span>
        </div>
    </div>
</div>

<section class="py-5 sparkle-wrapper position-relative overflow-hidden" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh;">
    <div class="sparkle-bg position-absolute top-0 start-0 w-100 h-100"></div>
    <div class="container position-relative" style="z-index: 1;">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="booking-card bg-gradient-glass border-0 rounded-4 shadow-lg slide-in">
                    <div class="card-body p-5 position-relative">
                        <a href="{{ route('events.index') }}" class="btn btn-outline-light mb-4">
                            <i class="bi bi-arrow-left-circle me-2"></i> Back to Events
                        </a>

                        @if($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}" class="img-fluid mb-4 rounded-3" alt="{{ $event->title }}" style="max-height: 400px; object-fit: cover; width: 100%;">
                        @endif

                        <h2 class="fw-bold text-white mb-4">{{ $event->title }}</h2>
                        <div class="event-details-card p-4 rounded-3 position-relative overflow-hidden mb-4">
                            <div class="event-details-bg"></div>
                            <div class="position-relative">
                                <h5 class="fw-bold text-white mb-4 d-flex align-items-center">
                                    <i class="bi bi-info-circle-fill me-2 text-primary"></i>
                                    Event Details
                                </h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="detail-item">
                                            <i class="bi bi-calendar-event text-primary me-2"></i>
                                            <strong class="text-white">Date:</strong>
                                            <span class="text-white-75">{{ $event->event_date->format('F d, Y') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="detail-item">
                                            <i class="bi bi-clock text-primary me-2"></i>
                                            <strong class="text-white">Time:</strong>
                                            <span class="text-white-75">{{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="detail-item">
                                            <i class="bi bi-geo-alt text-primary me-2"></i>
                                            <strong class="text-white">Location:</strong>
                                            <span class="text-white-75">{{ $event->location ?? 'TBD' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="detail-item">
                                            <i class="bi bi-currency-dollar text-primary me-2"></i>
                                            <strong class="text-white">Cost:</strong>
                                            <span class="text-white-75">KES {{ number_format($event->amount, 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="detail-item">
                                            <i class="bi bi-people text-primary me-2"></i>
                                            <strong class="text-white">Slots Left:</strong>
                                            <span class="text-warning fw-bold">{{ $event->availableSlots() }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="detail-item">
                                            <i class="bi bi-info-circle text-primary me-2"></i>
                                            <strong class="text-white">Status:</strong>
                                            <span class="text-white-75">{{ ucfirst($event->status) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h5 class="fw-bold text-white mb-3">Description</h5>
                        <p class="text-white-75 mb-4">{{ $event->description ?? 'No description available.' }}</p>

                        <h5 class="fw-bold text-white mb-3">Agenda</h5>
                        <p class="text-white-75 mb-4">{{ $event->agenda ?? 'No agenda available.' }}</p>

                        <h5 class="fw-bold text-white mb-3">About</h5>
                        <p class="text-white-75 mb-4">{{ $event->about ?? 'No additional information available.' }}</p>

                        <h5 class="fw-bold text-white mb-3">FAQs</h5>
                        @if($event->faqs && is_array($event->faqs))
                            <div class="accordion" id="faqsAccordion">
                                @foreach($event->faqs as $index => $faq)
                                    <div class="accordion-item bg-transparent border-0">
                                        <h2 class="accordion-header" id="faqHeading{{ $index }}">
                                            <button class="accordion-button bg-gradient-glass text-white" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse{{ $index }}" aria-expanded="true" aria-controls="faqCollapse{{ $index }}">
                                                {{ $faq['question'] }}
                                            </button>
                                        </h2>
                                        <div id="faqCollapse{{ $index }}" class="accordion-collapse collapse" aria-labelledby="faqHeading{{ $index }}" data-bs-parent="#faqsAccordion">
                                            <div class="accordion-body text-white-75">
                                                {{ $faq['answer'] }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-white-75 mb-4">No FAQs available.</p>
                        @endif

                        @if($event->status === 'upcoming' && $event->availableSlots() > 0)
                            <a href="{{ route('events.bookForm', $event) }}" class="btn btn-primary btn-lg px-5 mt-4 btn-booking">
                                <i class="bi bi-calendar-check-fill me-2"></i>Book This Event
                                <span class="btn-glow"></span>
                            </a>
                        @endif
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

    .event-badge .badge {
        font-size: 1rem;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

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

    .event-details-card {
        background: linear-gradient(145deg, rgba(255, 255, 255, 0.08), rgba(255, 255, 255, 0.02));
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        position: relative;
    }

    .event-details-bg {
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

    .accordion-button {
        background: var(--glass-bg);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-weight: 600;
    }

    .accordion-button:not(.collapsed) {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
    }

    .accordion-body {
        background: transparent;
        color: rgba(255, 255, 255, 0.75);
    }

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

        .event-badge .badge {
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