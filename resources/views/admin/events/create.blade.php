@extends('layouts.app')

@section('title', 'DevRank - Create Event')

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
        <h1 class="display-4 fw-bold slide-in">Create New Event</h1>
        <p class="lead mb-4 slide-in delay-1">Add a new event to inspire and engage our community of developers.</p>
    </div>
</div>

<section class="py-5 sparkle-wrapper position-relative overflow-hidden" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh;">
    <div class="sparkle-bg position-absolute top-0 start-0 w-100 h-100"></div>
    <div class="container position-relative" style="z-index: 1;">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="booking-card bg-gradient-glass border-0 rounded-4 shadow-lg slide-in">
                    <div class="card-body p-5 position-relative">
                        <a href="{{ route('admin.events.index') }}" class="btn btn-outline-light mb-4">
                            <i class="bi bi-arrow-left-circle me-2"></i> Back to Events
                        </a>

                        @if ($errors->any())
                            <div class="alert alert-danger alert-modern fade-in mb-4">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" id="createEventForm">
                            @csrf
                            <div class="row g-4">
                                <div class="col-12">
                                    <label for="title" class="form-label text-white fw-semibold">
                                        <i class="bi bi-bookmark-star me-2"></i>Event Title
                                    </label>
                                    <input type="text" class="form-control form-control-modern" id="title" name="title" value="{{ old('title') }}" required>
                                    @error('title')<div class="text-warning mt-2 small"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12">
                                    <label for="description" class="form-label text-white fw-semibold">
                                        <i class="bi bi-text-paragraph me-2"></i>Event Description
                                    </label>
                                    <textarea class="form-control form-control-modern" id="description" name="description" rows="5">{{ old('description') }}</textarea>
                                    @error('description')<div class="text-warning mt-2 small"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12">
                                    <label for="agenda" class="form-label text-white fw-semibold">
                                        <i class="bi bi-list-task me-2"></i>Event Agenda
                                    </label>
                                    <textarea class="form-control form-control-modern" id="agenda" name="agenda" rows="5">{{ old('agenda') }}</textarea>
                                    @error('agenda')<div class="text-warning mt-2 small"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12">
                                    <label for="about" class="form-label text-white fw-semibold">
                                        <i class="bi bi-info-circle me-2"></i>About Event
                                    </label>
                                    <textarea class="form-control form-control-modern" id="about" name="about" rows="5">{{ old('about') }}</textarea>
                                    @error('about')<div class="text-warning mt-2 small"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-white fw-semibold">
                                        <i class="bi bi-chat-quote me-2"></i>Event FAQs
                                    </label>
                                    <div id="faq-container">
                                        <div class="faq-item mb-3">
                                            <input type="text" name="faqs[0][question]" class="form-control form-control-modern mb-2" placeholder="Question" value="{{ old('faqs.0.question') }}">
                                            <textarea name="faqs[0][answer]" class="form-control form-control-modern" rows="3" placeholder="Answer">{{ old('faqs.0.answer') }}</textarea>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-outline-light mt-3" onclick="addFaq()">Add Another FAQ</button>
                                </div>
                                <div class="col-md-6">
                                    <label for="event_date" class="form-label text-white fw-semibold">
                                        <i class="bi bi-calendar-event me-2"></i>Event Date
                                    </label>
                                    <input type="date" class="form-control form-control-modern" id="event_date" name="event_date" value="{{ old('event_date') }}" required>
                                    @error('event_date')<div class="text-warning mt-2 small"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="start_time" class="form-label text-white fw-semibold">
                                        <i class="bi bi-clock me-2"></i>Start Time
                                    </label>
                                    <input type="time" class="form-control form-control-modern" id="start_time" name="start_time" value="{{ old('start_time') }}" required>
                                    @error('start_time')<div class="text-warning mt-2 small"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="location" class="form-label text-white fw-semibold">
                                        <i class="bi bi-geo-alt me-2"></i>Event Location
                                    </label>
                                    <input type="text" class="form-control form-control-modern" id="location" name="location" value="{{ old('location') }}">
                                    @error('location')<div class="text-warning mt-2 small"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="status" class="form-label text-white fw-semibold">
                                        <i class="bi bi-info-circle me-2"></i>Status
                                    </label>
                                    <select class="form-control form-control-modern" id="status" name="status" required>
                                        <option value="upcoming" {{ old('status', 'upcoming') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    @error('status')<div class="text-warning mt-2 small"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="amount" class="form-label text-white fw-semibold">
                                        <i class="bi bi-currency-dollar me-2"></i>Price (KES)
                                    </label>
                                    <input type="number" class="form-control form-control-modern" id="amount" name="amount" value="{{ old('amount', 0) }}" min="0" step="0.01" required>
                                    @error('amount')<div class="text-warning mt-2 small"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="capacity" class="form-label text-white fw-semibold">
                                        <i class="bi bi-people me-2"></i>Capacity
                                    </label>
                                    <input type="number" class="form-control form-control-modern" id="capacity" name="capacity" value="{{ old('capacity', 100) }}" min="1" required>
                                    @error('capacity')<div class="text-warning mt-2 small"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12">
                                    <label for="image" class="form-label text-white fw-semibold">
                                        <i class="bi bi-image me-2"></i>Event Image
                                    </label>
                                    <input type="file" class="form-control form-control-modern" id="image" name="image" accept="image/*">
                                    @error('image')<div class="text-warning mt-2 small"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg px-5 mt-5 w-100 btn-booking">
                                <i class="bi bi-check-circle-fill me-2"></i>Create Event
                                <span class="btn-glow"></span>
                            </button>
                        </form>
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

    .form-control-modern {
        background: var(--glass-bg);
        border: 2px solid transparent;
        border-radius: 12px;
        color: #fff;
        font-size: 1.05rem;
        padding: 0.875rem 1.25rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(10px);
    }

    .form-control-modern:focus {
        background: rgba(255, 255, 255, 0.15);
        border-color: var(--primary);
        color: #fff;
        box-shadow: 
            0 0 0 0.2rem rgba(79, 172, 254, 0.25),
            0 8px 25px rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }

    .form-control-modern::placeholder {
        color: rgba(255, 255, 255, 0.6);
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
    }

    .btn-primary {
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

    .btn-primary:hover {
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

    .btn-primary:hover .btn-glow {
        left: 100%;
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

    .alert-modern {
        background: rgba(255, 75, 75, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        backdrop-filter: blur(10px);
        color: #fff;
    }

    .faq-item {
        background: rgba(255, 255, 255, 0.05);
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .faq-item:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateX(4px);
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
    }

    @media (max-width: 576px) {
        .hero-section h1 {
            font-size: 1.8rem;
        }

        .btn-lg {
            padding: 0.875rem 1.5rem;
            font-size: 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    let faqIndex = 1;
    function addFaq() {
        const container = document.getElementById('faq-container');
        const faqItem = document.createElement('div');
        faqItem.className = 'faq-item mb-3';
        faqItem.innerHTML = `
            <input type="text" name="faqs[${faqIndex}][question]" class="form-control form-control-modern mb-2" placeholder="Question">
            <textarea name="faqs[${faqIndex}][answer]" class="form-control form-control-modern" rows="3" placeholder="Answer"></textarea>
        `;
        container.appendChild(faqItem);
        faqIndex++;
    }

    document.getElementById('createEventForm').addEventListener('submit', function(e) {
        const eventDate = document.getElementById('event_date').value;
        const today = new Date().toISOString().split('T')[0];
        if (eventDate <= today) {
            e.preventDefault();
            alert('Event date must be in the future.');
        }
    });
</script>
@endpush
@endsection