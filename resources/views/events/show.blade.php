@extends('layouts.app')

@section('content')
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
            color: #fff;
        }
        .content {
            padding: 40px;
        }
        .event-image {
            width: 100%;
            max-height: 350px;
            object-fit: cover;
            border-radius: 12px;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.05);
            border: none;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }
        .list-group-item {
            background: rgba(255,255,255,0.05);
            border: none;
            color: #fff;
        }
        .btn-custom {
            background-color: #1e3c72;
            color: #fff;
            border: none;
        }
        .btn-custom:hover {
            background-color: #2a5298;
        }
    </style>

    <div class="content">
        <h1 class="mb-4 fw-bold">Event Details</h1>
        <div class="card">
            @if($event->image)
                <img src="{{ asset('storage/' . $event->image) }}" class="event-image mb-4" alt="{{ $event->title }}">
            @endif

            <h3 class="mb-3">{{ $event->title }}</h3>

            <p><strong>Description:</strong> {{ $event->description }}</p>
            <p><strong>Agenda:</strong> {{ $event->agenda ?? 'Not available' }}</p>
            <p><strong>About:</strong> {{ $event->about ?? 'Not available' }}</p>
            <p><strong>Location:</strong> {{ $event->location ?? 'Not specified' }}</p>
            <p><strong>Date & Time:</strong> {{ $event->event_date->format('F d, Y') }} at {{ $event->start_time }}</p>
            <p><strong>Status:</strong> {{ ucfirst($event->status) }}</p>
            <p><strong>Available Slots:</strong> {{ $event->availableSlots() }}</p>

            <h4 class="mt-4">Frequently Asked Questions</h4>
            @if($event->faqs && is_array($event->faqs))
                <ul class="list-group mt-3">
                    @foreach($event->faqs as $faq)
                        <li class="list-group-item">
                            <strong>Q: {{ $faq['question'] }}</strong><br>
                            A: {{ $faq['answer'] }}
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No FAQs available for this event.</p>
            @endif

            @if($event->status === 'upcoming' && $event->availableSlots() > 0)
                <form action="{{ route('events.book', $event) }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="btn btn-custom w-100">Book This Event</button>
                </form>
            @endif

            <a href="{{ route('events.index') }}" class="btn btn-outline-light mt-3 w-100">← Back to Events</a>
        </div>
    </div>
@endsection
