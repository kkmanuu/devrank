@extends('layouts.app')

@section('title', 'Notification Details')

@push('styles')
<style>
    body {
        background-color: #121212;
    }
    .admin-container {
        max-width: 700px;
        margin: auto;
    }
    .notification-card {
        background-color: #1e1e2d;
        border: 1px solid #2d2d3f;
        border-radius: 10px;
        color: #fff;
        padding: 1.5rem;
    }
    .notification-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #4fc3f7;
    }
    .notification-label {
        font-weight: 500;
        color: #bbb;
    }
    .btn-custom {
        background-color: #4fc3f7;
        border: none;
        color: #000;
        font-weight: 500;
        padding: 0.35rem 0.75rem;
        border-radius: 6px;
    }
    .btn-custom:hover {
        background-color: #29b6f6;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4 admin-container">
    <h1 class="mb-4 fw-bold text-white">Notification Details</h1>

    <div class="notification-card">
        <h5 class="notification-title">{{ ucfirst($notification->type) }}</h5>
        <p class="mt-3"><span class="notification-label">Message:</span> {{ $notification->message }}</p>
        <p><span class="notification-label">Date:</span> {{ $notification->created_at->format('F d, Y H:i') }}</p>
        <p>
            <span class="notification-label">Status:</span> 
            <span class="{{ $notification->is_read ? 'text-success' : 'text-warning' }}">
                {{ $notification->is_read ? 'Read' : 'Unread' }}
            </span>
        </p>
        <a href="{{ route('admin.notifications.index') }}" class="btn btn-custom mt-3">
            ← Back to Notifications
        </a>
    </div>
</div>
@endsection
