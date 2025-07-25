@extends('layouts.app')

@section('content')
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #0f172a;
            font-family: 'Segoe UI', sans-serif;
        }

        .hero-section {
            background: url('{{ asset("images/event-bg.jpg") }}') no-repeat center center/cover;
            height: 100vh;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
        }

        .hero-overlay {
            background-color: rgba(0, 0, 0, 0.6);
            position: absolute;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
        }

        .hero-content {
            z-index: 2;
            padding: 20px;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: bold;
        }

        .hero-subtitle {
            font-size: 1.5rem;
            margin-top: 10px;
        }

        .explore-btn {
            margin-top: 30px;
            padding: 10px 25px;
            font-size: 1.2rem;
            border: none;
            background: #1e3c72;
            color: white;
            border-radius: 8px;
        }

        .explore-btn:hover {
            background: #2a5298;
        }

        .events-section {
            padding: 60px 0;
            background-color: #0f172a;
        }

        .card {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            border: none;
            border-radius: 15px;
            color: #fff;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
    </style>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 class="hero-title">Welcome to Our Events</h1>
            <p class="hero-subtitle">Explore upcoming events and book your spot now</p>
            <a href="#events" class="explore-btn">See Upcoming Events</a>
        </div>
    </div>

    <!-- Events Section -->
    <div class="container events-section" id="events">
        <h2 class="text-center text-white mb-5 fw-bold">Upcoming Events</h2>

        @if($events->isEmpty())
            <div class="alert alert-warning text-center">No events available at the moment.</div>
        @else
            <div class="row g-4">
                @foreach($events as $event)
                    <div class="col-md-4">
                        <div class="card h-100">
                            @if($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top" alt="{{ $event->title }}">
                            @endif
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $event->title }}</h5>
                                <p class="text-muted">{{ Str::limit($event->description, 100) }}</p>
                                <p><i class="bi bi-calendar-event"></i> {{ $event->event_date->format('F j, Y') }} at {{ $event->start_time }}</p>
                                <p><i class="bi bi-geo-alt"></i> {{ $event->location }}</p>

                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <a href="{{ route('events.show', $event) }}" class="btn btn-outline-light btn-sm">View</a>
                                    <form action="{{ route('events.book', $event) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="btn btn-success btn-sm"
                                                {{ $event->availableSlots() <= 0 || $event->status !== 'upcoming' ? 'disabled' : '' }}>
                                            Book Now
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
