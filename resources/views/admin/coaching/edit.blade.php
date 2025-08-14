@extends('layouts.app')

@section('title', 'Edit Coaching Session')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
        font-family: 'Segoe UI', sans-serif;
        color: #fff;
    }
    .form-wrapper {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        padding: 30px;
        max-width: 800px;
        margin: 0 auto;
        box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    }
    .form-title {
        font-weight: bold;
        margin-bottom: 20px;
        font-size: 1.5rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        padding-bottom: 10px;
    }
    label {
        font-weight: 500;
    }
    .form-control, .form-select {
        background-color: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #fff;
    }
    .form-control:focus, .form-select:focus {
        border-color: #00d4ff;
        box-shadow: 0 0 0 0.2rem rgba(0, 212, 255, 0.25);
        background-color: rgba(255, 255, 255, 0.15);
    }
    .btn-primary {
        background-color: #00d4ff;
        border-color: #00d4ff;
        font-weight: 600;
    }
    .btn-primary:hover {
        background-color: #00b8e6;
        border-color: #00b8e6;
    }
    .btn-secondary {
        background-color: rgba(255,255,255,0.2);
        border: none;
        font-weight: 600;
    }
    .btn-secondary:hover {
        background-color: rgba(255,255,255,0.3);
    }
    small.text-danger {
        display: block;
        margin-top: 4px;
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="form-wrapper">
        <div class="form-title">Edit Coaching Session</div>

        <form action="{{ route('admin.coaching.update', $session) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="topic" class="form-label">Topic *</label>
                <input type="text" name="topic" id="topic" class="form-control" value="{{ old('topic', $session->topic) }}" required>
                @error('topic') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control">{{ old('description', $session->description) }}</textarea>
                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <input type="text" name="type" id="type" class="form-control" value="{{ old('type', $session->type) }}">
                @error('type') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="developer_type" class="form-label">Developer Type *</label>
                <select name="developer_type" id="developer_type" class="form-select" required>
                    <option value="fresher" {{ old('developer_type', $session->developer_type) === 'fresher' ? 'selected' : '' }}>Fresher</option>
                    <option value="professional" {{ old('developer_type', $session->developer_type) === 'professional' ? 'selected' : '' }}>Professional</option>
                </select>
                @error('developer_type') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="coach_id" class="form-label">Coach *</label>
                <select name="coach_id" id="coach_id" class="form-select" required>
                    @foreach($coaches as $coach)
                        <option value="{{ $coach->id }}" {{ old('coach_id', $session->coach_id) == $coach->id ? 'selected' : '' }}>
                            {{ $coach->name }}
                        </option>
                    @endforeach
                </select>
                @error('coach_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="session_date" class="form-label">Session Date *</label>
                <input type="date" name="session_date" id="session_date" class="form-control" value="{{ old('session_date', $session->session_date->format('Y-m-d')) }}" required>
                @error('session_date') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="start_time" class="form-label">Start Time *</label>
                    <input type="time" name="start_time" id="start_time" class="form-control" value="{{ old('start_time', $session->start_time) }}" required>
                    @error('start_time') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-6">
                    <label for="capacity" class="form-label">Capacity *</label>
                    <input type="number" name="capacity" id="capacity" class="form-control" value="{{ old('capacity', $session->capacity) }}" min="1" required>
                    @error('capacity') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="mb-3 mt-3">
                <label for="amount" class="form-label">Price (KES) *</label>
                <input type="number" step="0.01" name="amount" id="amount" class="form-control" value="{{ old('amount', $session->amount) }}" min="0" required>
                @error('amount') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-4">
                <label for="status" class="form-label">Status *</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="upcoming" {{ old('status', $session->status) === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                    <option value="completed" {{ old('status', $session->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ old('status', $session->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                @error('status') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-primary px-4">Update Session</button>
                <a href="{{ route('admin.coaching.index') }}" class="btn btn-secondary px-4">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
