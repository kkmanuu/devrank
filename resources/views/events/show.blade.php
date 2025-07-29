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
    <div class="overlay position-absolute w-100 h-100" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.5)); z-index: 1;"></div>
    <div class="container text-center position-relative z-2 py-5">
        <h1 class="display-4 fw-bold slide-in">{{ $event->title }}</h1>
        <p class="lead mb-4 slide-in delay-1">Discover the details of this exciting event and join our community!</p>
    </div>
</div>

<section class="py-5 bg-light">
    <div class="container">
        <div class="card bg-gradient-light border-0 rounded-3 shadow-sm slide-in">
            @if($event->image)
                <img src="{{ asset('storage/' . $event->image) }}" class="event-image mb-4" alt="{{ $event->title }}" style="width: 100%; max-height: 350px; object-fit: cover; border-radius: 15px;">
            @endif
            <div class="card-body p-4">
                <h3 class="fw-bold text-dark mb-3">{{ $event->title }}</h3>
                <p class="text-muted"><strong>Description:</strong> {{ $event->description }}</p>
                <p class="text-muted"><strong>Agenda:</strong> {{ $event->agenda ?? 'Not available' }}</p>
                <p class="text-muted"><strong>About:</strong> {{ $event->about ?? 'Not available' }}</p>
                <p class="text-muted"><strong>Location:</strong> {{ $event->location ?? 'Not specified' }}</p>
                <p class="text-muted"><strong>Date & Time:</strong> {{ $event->event_date->format('F d, Y') }} at {{ $event->start_time }}</p>
                <p class="text-muted"><strong>Status:</strong> {{ ucfirst($event->status) }}</p>
                <p class="text-muted"><strong>Available Slots:</strong> {{ $event->availableSlots() }}</p>

                <h4 class="mt-4 fw-bold text-dark">Frequently Asked Questions</h4>
                @if($event->faqs && is_array($event->faqs))
                    <ul class="list-group mt-3">
                        @foreach($event->faqs as $faq)
                            <li class="list-group-item bg-gradient-light border-0 text-dark">
                                <strong>Q: {{ $faq['question'] }}</strong><br>
                                A: {{ $faq['answer'] }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">No FAQs available for this event.</p>
                @endif

                @if($event->status === 'upcoming' && $event->availableSlots() > 0)
                    <form action="{{ route('events.book', $event) }}" method="POST" class="mt-4">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-lg w-100">Book This Event</button>
                    </form>
                @endif

                <a href="{{ route('events.index') }}" class="btn btn-outline-primary btn-lg w-100 mt-3">← Back to Events</a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
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

    .hero-section h1 {
        font-size: 3rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }
    .hero-section .lead {
        font-size: 1.25rem;
        max-width: 600px;
        margin: 0 auto;
    }

    .fade-in {
        opacity: 0;
        animation: fadeIn 1s ease-in-out forwards;
    }
    .fade-in.delay-1 { animation-delay: 0.5s; }
    .slide-in {
        opacity: 0;
        transform: translateX(30px);
        animation: slideIn 1s ease-in-out forwards;
    }
    .slide-in.delay-1 { animation-delay: 0.5s; }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes slideIn {
        from { opacity: 0; transform: translateX(30px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .bg-gradient-light {
        background: linear-gradient(145deg, #ffffff, #e6e6e6);
    }
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }
    .btn-primary {
        background-color: #007bff;
        border: none;
        font-weight: 600;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }
    .btn-outline-primary {
        border-color: #007bff;
        color: #007bff;
        font-weight: 500;
        transition: background-color 0.3s ease, color 0.3s ease;
    }
    .btn-outline-primary:hover {
        background-color: #007bff;
        color: #fff;
    }
</style>
@endpush