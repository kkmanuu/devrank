@extends('layouts.app')

@section('content')
<style>
    body {
        position: relative;
        background: #0f172a; /* Dark base */
        overflow: hidden;
    }

    .sparkle {
        position: absolute;
        width: 2px;
        height: 2px;
        background: white;
        border-radius: 50%;
        animation: sparkle 3s infinite ease-in-out;
        opacity: 0.6;
    }

    @keyframes sparkle {
        0%, 100% {
            opacity: 0;
            transform: translateY(0) scale(1);
        }
        50% {
            opacity: 1;
            transform: translateY(-20px) scale(1.5);
        }
    }

    /* Randomly place sparkles */
    @for ($i = 0; $i < 50; $i++)
        .sparkle-{{ $i }} {
            left: {{ rand(0, 100) }}%;
            top: {{ rand(0, 100) }}%;
            animation-delay: {{ rand(0, 3000) / 1000 }}s;
        }
    @endfor
</style>

<!-- Sparkle elements -->
@for ($i = 0; $i < 50; $i++)
    <div class="sparkle sparkle-{{ $i }}"></div>
@endfor


<div class="container py-5">
    <h1 class="mb-4 fw-bold text-center text-white">Upcoming Events</h1>

    @if (session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    @if($events->isEmpty())
        <div class="alert alert-warning text-center">No events available at the moment.</div>
    @else
        <div class="row g-4">
            @foreach($events as $event)
                <div class="col-md-4">
                    <div class="card h-100 shadow-lg border-0">
                        @if($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top" alt="{{ $event->title }}">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $event->title }}</h5>
                            <p class="text-muted mb-2">{{ Str::limit($event->description, 100) }}</p>
                            <p class="mb-1"><i class="bi bi-calendar-event"></i> {{ $event->event_date->format('F j, Y') }} at {{ $event->start_time }}</p>
                            <p class="mb-2"><i class="bi bi-people-fill"></i> Slots Left: {{ $event->availableSlots() }}</p>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <a href="{{ route('events.show', $event) }}" class="btn btn-outline-light btn-sm">
                                    View Details
                                </a>
                                <form action="{{ route('events.book', $event) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm"
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
