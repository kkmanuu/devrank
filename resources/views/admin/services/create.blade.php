@extends('layouts.app')

@section('content')
    <div class="container content">
        <h2 class="text-white mb-4">Add New Service</h2>
        <form method="POST" action="{{ route('admin.services.store') }}">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label text-white">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                @error('title')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label text-white">Description</label>
                <textarea class="form-control" id="description" name="description" required>{{ old('description') }}</textarea>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="icon" class="form-label text-white">Icon (e.g., bi-code-slash)</label>
                <input type="text" class="form-control" id="icon" name="icon" value="{{ old('icon') }}" required>
                @error('icon')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Create Service</button>
            <a href="{{ route('admin.services.index') }}" class="btn btn-outline-light">Cancel</a>
        </form>
    </div>
@endsection