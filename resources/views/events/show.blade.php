@extends('layouts.app')

@section('content')
<style>
    body {
        position: relative;
        overflow-x: hidden;
         background: #0f172a;
    }

    .sparkle {
        position: absolute;
        width: 4px;
        height: 4px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        animation: sparkle 3s infinite ease-in-out;
        z-index: 0;
    }

    @keyframes sparkle {
        0%, 100% {
            opacity: 0;
            transform: scale(0.5);
        }
        50% {
            opacity: 1;
            transform: scale(1.2);
        }
    }

    .card {
        position: relative;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
        z-index: 1;
    }

    .card-img-top {
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        max-height: 300px;
        object-fit: cover;
    }

    .list-group-item {
        background: #ffffff;
    }
</style>

{{-- Sparkles --}}
@for ($i = 0; $i < 40; $i++)
    <div class="sparkle" style="
        left: {{ rand(0, 100) }}%;
        top: {{ rand(0, 100) }}%;
        animation-delay: {{ rand(0, 3000) / 1000 }}s;
    "></div>
@endfor

<div class="container py-5 position-relative">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow border-0">
                @if($event->image)
                    <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top" alt="{{ $event->title }}">
                @endif
                <div class="card-body">
                    <h2 class="card-title">{{ $event->title }}</h2>
                    <p class="card-text">{{ $event->description }}</p>
                    <p><strong>Date:</strong> {{ $event->event_date->format('F j, Y') }} at {{ $event->start_time }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($event->status) }}</p>
                    <p><strong>Slots Left:</strong> {{ $event->availableSlots() }}</p>

                    @if($event->bookings->isNotEmpty())
                        <h5 class="mt-4">Attendees</h5>
                        <ul class="list-group list-group-flush">
                            @foreach($event->bookings as $booking)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $booking->user->name }}
                                    <span class="badge bg-info text-dark">{{ ucfirst($booking->status) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted mt-3">No bookings yet for this event.</p>
                    @endif

                    <a href="{{ route('events.index') }}" class="btn btn-outline-secondary mt-4">
                        <i class="bi bi-arrow-left-circle"></i> Back to Events
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
