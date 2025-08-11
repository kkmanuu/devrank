@extends('layouts.app')

@section('title', 'Notifications')

@push('styles')
<style>
    body {
        background-color: #121212; /* dark admin bg */
    }
    .admin-container {
        max-width: 900px;
        margin: auto;
    }
    .notification-card {
        background-color: #1e1e2d;
        border: 1px solid #2d2d3f;
        border-radius: 10px;
        padding: 1.2rem;
        color: #fff;
        transition: transform 0.2s ease-in-out;
    }
    .notification-card:hover {
        transform: translateY(-3px);
    }
    .notification-meta {
        font-size: 0.85rem;
        color: #aaa;
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
    <h1 class="mb-4 fw-bold text-white">Notifications</h1>

    @if($notifications->isEmpty())
        <p class="text-white-50">No notifications available.</p>
    @else
        <div class="row g-3">
            @foreach($notifications as $notification)
                <div class="col-12">
                    <div class="notification-card">
                        <p class="mb-1"><strong>{{ ucfirst($notification->type) }}:</strong> {{ $notification->message }}</p>
                        <p class="notification-meta">{{ $notification->created_at->format('F d, Y H:i') }}</p>
                        <div class="mt-2">
                            @if(!$notification->is_read)
                                <form action="{{ route('notifications.markAsRead', $notification) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-custom btn-sm">Mark as Read</button>
                                </form>
                            @endif
                            <a href="{{ route('admin.notifications.show', $notification) }}" class="btn btn-custom btn-sm">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4">
            {{ $notifications->links() }}
        </div>
    @endif
</div>
@endsection
