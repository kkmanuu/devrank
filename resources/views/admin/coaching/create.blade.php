@extends('layouts.app')

@section('content')
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
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
        }
        .btn-custom {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
            border: none;
        }
        .btn-custom:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
        .form-control, .form-select {
            background: rgba(255,255,255,0.1);
            border: none;
            color: #fff;
        }
        .form-control:focus {
            background: rgba(255,255,255,0.2);
            color: #fff;
            box-shadow: none;
            border-color: #0ff;
        }
    </style>

    <div class="content">
        <h1 class="mb-4 text-white fw-bold">Create New Coaching Session</h1>
        <div class="card p-4 mx-auto" style="max-width: 600px;">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('admin.coaching.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Topic</label>
                    <input type="text" name="topic" class="form-control" required value="{{ old('topic') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Coach</label>
                    <select name="coach_id" class="form-select" required>
                        <option value="">Select a Coach</option>
                        @foreach($coaches as $coach)
                            <option value="{{ $coach->id }}" {{ old('coach_id') == $coach->id ? 'selected' : '' }}>
                                {{ $coach->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="session_date" class="form-control" required value="{{ old('session_date') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Start Time</label>
                    <input type="time" name="start_time" class="form-control" required value="{{ old('start_time') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Capacity</label>
                    <input type="number" name="capacity" class="form-control" required min="1" value="{{ old('capacity', 10) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="upcoming" {{ old('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-custom w-100">Save Coaching Session</button>
            </form>
        </div>
    </div>
@endsection
