@extends('layouts.app')

@section('content')
    <style>
        body {
            background: #0f172a;
        }

        .card {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            border: none;
            border-radius: 15px;
            color: #fff;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s;
        }

        .card:hover {
            transform: scale(1.02);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        .btn-outline-light:hover {
            background-color: #fff;
            color: #1e3c72;
        }
    </style>

    <div class="container py-5">
        <h1 class="mb-5 text-center fw-bold text-white">Upcoming Events</h1>

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
                        <div class="card h-100">
                            @if($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top" alt="{{ $event->title }}">
                            @endif
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $event->title }}</h5>
                                <p class="mb-2">{{ Str::limit($event->description, 100) }}</p>
                                <p><i class="bi bi-calendar-event"></i> {{ $event->event_date->format('F j, Y') }} at {{ $event->start_time }}</p>
                                <p><i class="bi bi-people-fill"></i> Slots Left: {{ $event->availableSlots() }}</p>

                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <a href="{{ route('events.show', $event) }}" class="btn btn-outline-light btn-sm">
                                        View Details
                                    </a>
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
