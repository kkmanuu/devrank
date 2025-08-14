@extends('layouts.app')

@section('title', 'Notification Details')

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
        max-width: 800px;
        margin: 0 auto;
        padding: 40px 20px;
    }
    .message-box {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 18px;
        padding: 25px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.4);
        position: relative;
    }
    .message-box::before {
        content: "";
        position: absolute;
        bottom: -15px;
        left: 50px;
        width: 0;
        height: 0;
        border-left: 15px solid transparent;
        border-right: 15px solid transparent;
        border-top: 15px solid rgba(255, 255, 255, 0.05);
    }
    .message-title {
        font-size: 1.4rem;
        font-weight: 600;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
    }
    .message-title i {
        margin-right: 10px;
        color: #ffd700;
    }
    .message-meta {
        font-size: 0.9rem;
        opacity: 0.8;
        margin-bottom: 15px;
    }
    .message-content {
        font-size: 1rem;
        line-height: 1.5;
        margin-bottom: 20px;
    }
    .status-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 500;
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
        padding: 10px 20px;
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
    <h1 class="mb-4 fw-bold text-white"><i class="bi bi-bell"></i> Notification Details</h1>
    <div class="message-box">
        <div class="message-title">
            <i class="bi bi-chat-left-text"></i> {{ ucfirst($notification->type) }}
        </div>
        <div class="message-meta">
            <i class="bi bi-calendar"></i> {{ $notification->created_at->format('F d, Y H:i') }}
        </div>
        <div class="message-content">
            {{ $notification->message }}
        </div>
        <div>
            <span class="status-badge {{ $notification->is_read ? 'status-read' : 'status-unread' }}">
                {{ $notification->is_read ? 'Read' : 'Unread' }}
            </span>
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.notifications.index') }}" class="btn btn-custom">
                <i class="bi bi-arrow-left"></i> Back to Notifications
            </a>
        </div>
    </div>
</div>
@endsection
