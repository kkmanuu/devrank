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
        .btn-custom {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
            border: none;
        }
        .btn-custom:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
    </style>

    <div class="content">
        <h1 class="mb-4 text-white fw-bold">{{ __('messages.create_event') }}</h1>
        <div class="card p-4 mx-auto" style="max-width: 600px;">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">{{ __('messages.event_title') }}</label>
                    <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">{{ __('messages.event_description') }}</label>
                    <textarea name="description" class="form-control" rows="5">{{ old('description') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">{{ __('messages.event_image') }}</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
                <div class="mb-3">
                    <label for="event_date" class="form-label">{{ __('messages.event_date') }}</label>
                    <input type="date" name="event_date" class="form-control" required value="{{ old('event_date') }}">
                </div>
                <div class="mb-3">
                    <label for="start_time" class="form-label">{{ __('messages.start_time') }}</label>
                    <input type="time" name="start_time" class="form-control" required value="{{ old('start_time') }}">
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">{{ __('messages.status') }}</label>
                    <select name="status" class="form-select">
                        <option value="upcoming" {{ old('status') == 'upcoming' ? 'selected' : '' }}>{{ __('messages.upcoming') }}</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>{{ __('messages.completed') }}</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>{{ __('messages.cancelled') }}</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-custom w-100">{{ __('messages.submit') }}</button>
            </form>
        </div>
    </div>
@endsection
