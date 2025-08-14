@extends('layouts.app')

@section('title', 'Notifications')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
    body {
        background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
        color: #fff;
        font-family: 'Segoe UI', sans-serif;
    }
    .content-wrapper {
        max-width: 900px;
        margin: 0 auto;
        padding: 40px 20px;
    }
    .notification-box {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 14px;
        padding: 20px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.3);
        transition: all 0.3s ease;
        position: relative;
    }
    .notification-box:hover {
        transform: translateY(-3px);
        background: rgba(255, 255, 255, 0.08);
    }
    .notification-title {
        font-size: 1.1rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        margin-bottom: 8px;
    }
    .notification-title i {
        margin-right: 8px;
        color: #ffd700;
    }
    .notification-meta {
        font-size: 0.85rem;
        opacity: 0.8;
        margin-bottom: 10px;
    }
    .status-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 500;
        margin-right: 8px;
    }
    .status-read {
        background-color: rgba(0, 255, 0, 0.15);
        color: #0f0;
    }
    .status-unread {
        background-color: rgba(255, 0, 0, 0.15);
        color: #f55;
    }
    .btn-custom {
        background-color: rgba(255, 255, 255, 0.1);
        color: #fff;
        border-radius: 8px;
        padding: 6px 14px;
        font-size: 0.85rem;
        transition: all 0.3s;
    }
    .btn-custom:hover {
        background-color: rgba(255, 255, 255, 0.2);
        transform: scale(1.05);
    }
</style>
@endpush

@section('content')
<div class="content-wrapper">
    <h1 class="mb-4 fw-bold text-white"><i class="bi bi-bell"></i> Notifications</h1>

    @if($notifications->isEmpty())
        <p class="text-white-50">No notifications available.</p>
    @else
        <div class="d-flex flex-column gap-3">
            @foreach($notifications as $notification)
                <div class="notification-box">
                    <div class="notification-title">
                        <i class="bi bi-chat-left-text"></i> {{ ucfirst($notification->type) }}
                    </div>
                    <div class="notification-meta">
                        <i class="bi bi-calendar"></i> {{ $notification->created_at->format('F d, Y H:i') }}
                    </div>
                    <div class="mb-2">
                        {{ $notification->message }}
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="status-badge {{ $notification->is_read ? 'status-read' : 'status-unread' }}">
                            {{ $notification->is_read ? 'Read' : 'Unread' }}
                        </span>
                        @if(!$notification->is_read)
                            <form action="{{ route('notifications.markAsRead', $notification) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-custom btn-sm">
                                    <i class="bi bi-check2"></i> Mark as Read
                                </button>
                            </form>
                        @endif
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
