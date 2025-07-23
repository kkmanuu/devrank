<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.event_details') }} - DevRank</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
            color: #fff;
        }
        .content {
            padding: 40px;
        }
        .card {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.4);
            transition: all 0.3s ease-in-out;
        }
        .card:hover {
            transform: translateY(-8px) scale(1.02);
        }
        .btn-custom {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
            border: none;
        }
        .btn-custom:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
        .event-image {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    @extends('layouts.app')

    @section('content')
        <div class="content">
            <h1 class="mb-4 text-white fw-bold">{{ __('messages.event_details') }}</h1>
            <div class="card p-4">
                @if($event->image)
                    <img src="{{ asset('storage/' . $event->image) }}" class="event-image mb-3" alt="{{ $event->title }}">
                @endif
                <h3>{{ $event->title }}</h3>
                <p>{{ $event->description }}</p>
                <p><strong>{{ __('messages.event_date') }}:</strong> {{ $event->event_date->format('Y-m-d') }} {{ $event->start_time }}</p>
                <p><strong>{{ __('messages.status') }}:</strong> {{ ucfirst($event->status) }}</p>
                <p><strong>{{ __('messages.available_slots') }}:</strong> {{ $event->availableSlots() }}</p>
                <h4 class="mt-4">{{ __('messages.booked_users') }}</h4>
                @if($event->bookings->isEmpty())
                    <p>{{ __('messages.no_bookings') }}</p>
                @else
                    <ul class="list-group">
                        @foreach($event->bookings as $booking)
                            <li class="list-group-item bg-transparent text-white">{{ $booking->user->name }} ({{ $booking->status }})</li>
                        @endforeach
                    </ul>
                @endif
                <a href="{{ route('admin.events.index') }}" class="btn btn-custom mt-3">{{ __('messages.back_to_events') }}</a>
            </div>
        </div>
    @endsection
</body>
</html>