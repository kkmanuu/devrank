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
        .btn-create {
            margin-bottom: 20px;
            float: right;
        }
    </style>

    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-white fw-bold">Coaching Sessions</h1>
            <a href="{{ route('admin.coaching.create') }}" class="btn btn-custom btn-create">
                + Create Coaching Session
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($sessions->isEmpty())
            <p>No coaching sessions available yet.</p>
        @else
            <div class="row g-4">
                @foreach($sessions as $session)
                    <div class="col-md-4">
                        <div class="card p-3">
                            <h5 class="card-title">{{ $session->topic }}</h5>
                            <p><strong>Description:</strong> {{ Str::limit($session->description, 100) ?? 'N/A' }}</p>
                            <p><strong>Type:</strong> {{ $session->type ?? 'N/A' }}</p>
                            <p><strong>Coach:</strong> {{ $session->coach->name ?? 'Not Assigned' }}</p>
                            <p><strong>Date:</strong> {{ $session->session_date->format('F d, Y') }}</p>
                            <p><strong>Time:</strong> {{ $session->start_time }}</p>
                            <p><strong>Available Slots:</strong> {{ $session->availableSlots() }}</p>
                            <span class="badge bg-light text-dark">{{ ucfirst($session->status) }}</span>
                            <a href="{{ route('coaching.show', $session) }}" class="btn btn-custom btn-sm mt-2">View Details</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
