@extends('layouts.app')

@section('content')
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            color: #fff;
            min-height: 100vh;
        }

        .content {
            padding: 50px 20px;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: 1px;
        }

        /* Card Styling */
        .event-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0,0,0,0.35);
            transition: all 0.3s ease;
        }

        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 28px rgba(0,0,0,0.5);
        }

        .event-card img {
            height: 200px;
            width: 100%;
            object-fit: cover;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .event-card .card-body {
            padding: 20px;
        }

        .event-card h5 {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .event-info p {
            margin-bottom: 5px;
            font-size: 0.9rem;
            color: #e0e0e0;
        }

        .event-info strong {
            color: #fff;
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.6rem;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        /* Buttons */
        .btn-custom {
            background-color: rgba(255, 255, 255, 0.15);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 6px 14px;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            background-color: rgba(255, 255, 255, 0.25);
        }

        .btn-warning {
            background-color: #ffc107;
            border: none;
            color: #212529;
            border-radius: 8px;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .btn-danger {
            border-radius: 8px;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }

        .btn-create {
            padding: 8px 18px;
            font-weight: 600;
            background-color: #28a745;
            border-radius: 8px;
        }

        .btn-create:hover {
            background-color: #218838;
        }
    </style>

    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title">🎉 Events</h1>
            <a href="{{ route('admin.events.create') }}" class="btn btn-create text-white">
                + Create Event
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($events->isEmpty())
            <p class="text-light">No events available yet.</p>
        @else
            <div class="row g-4">
                @foreach($events as $event)
                    <div class="col-md-4">
                        <div class="event-card">
                            @if($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}">
                            @endif
                            <div class="card-body">
                                <h5>{{ $event->title }}</h5>
                                <div class="event-info">
                                    <p><strong>Description:</strong> {{ Str::limit($event->description, 100) ?? 'N/A' }}</p>
                                    <p><strong>Date:</strong> {{ $event->event_date->format('F d, Y') }}</p>
                                    <p><strong>Time:</strong> {{ $event->start_time }}</p>
                                    <p><strong>Price:</strong> {{ number_format($event->amount, 2) }} KES</p>
                                    <p><strong>Available Slots:</strong> {{ $event->availableSlots() }}</p>
                                </div>
                                <span class="status-badge bg-light text-dark">{{ ucfirst($event->status) }}</span>

                                <div class="mt-3 d-flex flex-wrap gap-2">
                                    <a href="{{ route('admin.events.show', $event) }}" class="btn btn-custom">View</a>
                                    <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-warning">Edit</a>
                                    <form action="{{ route('admin.events.destroy', $event) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this event?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
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
