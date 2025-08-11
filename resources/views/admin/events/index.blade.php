@extends('layouts.app')

@section('content')
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(-45deg, #0f2027, #203a43, #2c5364, #0f2027);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            color: #fff;
            min-height: 100vh;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .content {
            padding: 40px;
            max-width: 1200px;
            margin: 0 auto;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            border-radius: 20px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.5);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-10px) scale(1.03);
            box-shadow: 0 15px 30px rgba(0,0,0,0.6);
        }

        .btn-custom {
            background: linear-gradient(90deg, #00ddeb, #007bff);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            background: linear-gradient(90deg, #007bff, #00ddeb);
            transform: translateY(-2px);
        }

        .event-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 20px 20px 0 0;
        }

        .alert-success {
            background: rgba(40,167,69,0.8);
            border-radius: 10px;
        }
    </style>

    <div class="content">
        <h1 class="mb-5 text-white fw-bold text-center">Events</h1>
        <a href="{{ route('admin.events.create') }}" class="btn btn-custom mb-5">Create Event</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($events->isEmpty())
            <p class="text-center">No Events Available</p>
        @else
            <div class="row g-4">
                @foreach($events as $event)
                    <div class="col-md-4">
                        <div class="card">
                            @if($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" class="event-image" alt="{{ $event->title }}">
                            @endif
                            <div class="card-body p-4">
                                <h5 class="card-title">{{ $event->title }}</h5>
                                <p class="card-text">{{ Str::limit($event->description, 100) }}</p>
                                <p class="card-text"><strong>Event Date:</strong> {{ $event->event_date->format('Y-m-d') }} {{ $event->start_time }}</p>
                                <p class="card-text"><strong>Available Slots:</strong> {{ $event->availableSlots() }}</p>
                                <a href="{{ route('admin.events.show', $event) }}" class="btn btn-custom btn-sm">View Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $events->links() }}
        @endif
    </div>
@endsection