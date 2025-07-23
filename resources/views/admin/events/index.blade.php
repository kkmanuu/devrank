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
            height: 150px;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
        }
    </style>

    <div class="content">
        <h1 class="mb-4 text-white fw-bold">{{ __('messages.events') }}</h1>
        <a href="{{ route('admin.events.create') }}" class="btn btn-custom mb-4">{{ __('messages.create_event') }}</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($events->isEmpty())
            <p>{{ __('messages.no_events') }}</p>
        @else
            <div class="row g-4">
                @foreach($events as $event)
                    <div class="col-md-4">
                        <div class="card">
                            @if($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" class="event-image" alt="{{ $event->title }}">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $event->title }}</h5>
                                <p class="card-text">{{ Str::limit($event->description, 100) }}</p>
                                <p class="card-text"><strong>{{ __('messages.event_date') }}:</strong> {{ $event->event_date->format('Y-m-d') }} {{ $event->start_time }}</p>
                                <p class="card-text"><strong>{{ __('messages.available_slots') }}:</strong> {{ $event->availableSlots() }}</p>
                                <a href="{{ route('admin.events.show', $event) }}" class="btn btn-custom btn-sm">{{ __('messages.view_details') }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $events->links() }}
        @endif
    </div>
@endsection
