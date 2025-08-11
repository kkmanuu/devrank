@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h1 class="mb-4 text-white fw-bold">Notification Details</h1>
    <div class="card p-4">
        <h5 class="card-title">{{ ucfirst($notification->type) }}</h5>
        <p class="card-text"><strong>Message:</strong> {{ $notification->message }}</p>
        <p class="card-text"><strong>Date:</strong> {{ $notification->created_at->format('F d, Y H:i') }}</p>
        <p class="card-text"><strong>Status:</strong> {{ $notification->is_read ? 'Read' : 'Unread' }}</p>
        <a href="{{ route('admin.notifications.index') }}" class="btn btn-custom">Back to Notifications</a>
    </div>
</div>
@endsection