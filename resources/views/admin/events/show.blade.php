@extends('layouts.app')

@section('title', __('messages.event details') . ' - DevRank')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
        color: #fff;
    }
    .content {
        padding: 40px;
        max-width: 1000px;
        margin: auto;
    }
    .card {
        background: linear-gradient(135deg, #1e3c72, #2a5298);
        border: none;
        border-radius: 18px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
        padding: 30px;
    }
    .event-image {
        width: 100%;
        max-height: 350px;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        margin-bottom: 25px;
    }
    .section-title {
        font-weight: 600;
        margin-top: 40px;
        margin-bottom: 15px;
        border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        padding-bottom: 5px;
        font-size: 1.2rem;
    }
    .list-group-item {
        background: rgba(255, 255, 255, 0.05);
        border: none;
        border-radius: 10px;
        margin-bottom: 8px;
        padding: 12px;
    }
    .list-group-item strong {
        color: #ffd700;
    }
    .info-row {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
        font-size: 1rem;
    }
    .info-row i {
        margin-right: 10px;
        color: #ffd700;
        font-size: 1.2rem;
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
<div class="content">
    <h1 class="mb-4 text-white fw-bold"><i class="bi bi-calendar-event"></i> {{ __('messages.event details') }}</h1>
    <div class="card">
        @if($event->image)
            <img src="{{ asset('storage/' . $event->image) }}" class="event-image" alt="{{ $event->title }}">
        @endif

        <h2 class="mb-4">{{ $event->title }}</h2>

        <div class="info-row">
            <i class="bi bi-card-text"></i> <strong>{{ __('messages.event description') }}:</strong>&nbsp; {{ $event->description }}
        </div>
        <div class="info-row">
            <i class="bi bi-list-check"></i> <strong>{{ __('messages.event agenda') }}:</strong>&nbsp; {{ $event->agenda ?? 'N/A' }}
        </div>
        <div class="info-row">
            <i class="bi bi-info-circle"></i> <strong>{{ __('messages.event about') }}:</strong>&nbsp; {{ $event->about ?? 'N/A' }}
        </div>
        <div class="info-row">
            <i class="bi bi-geo-alt"></i> <strong>{{ __('messages.event location') }}:</strong>&nbsp; {{ $event->location ?? 'N/A' }}
        </div>
        <div class="info-row">
            <i class="bi bi-calendar"></i> 
            <strong>{{ __('messages.event date') }}:</strong>&nbsp; {{ $event->event_date->format('F d, Y') }}
        </div>
        <div class="info-row">
            <i class="bi bi-clock"></i> 
            <strong>{{ __('messages.time') }}:</strong>&nbsp; 
            {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }} - 
            {{ \Carbon\Carbon::parse($event->end_time)->format('g:i A') }}
        </div>
        <div class="info-row">
            <i class="bi bi-check-circle"></i> <strong>{{ __('messages.status') }}:</strong>&nbsp; {{ ucfirst($event->status) }}
        </div>
        <div class="info-row">
            <i class="bi bi-people"></i> <strong>{{ __('messages.available slots') }}:</strong>&nbsp; {{ $event->availableSlots() }}
        </div>

        <h4 class="section-title"><i class="bi bi-question-circle"></i> {{ __('messages.event faqs') }}</h4>
        @if($event->faqs && is_array($event->faqs))
            <ul class="list-group">
                @foreach($event->faqs as $faq)
                    <li class="list-group-item text-white">
                        <strong>{{ $faq['question'] }}</strong><br>
                        {{ $faq['answer'] }}
                    </li>
                @endforeach
            </ul>
        @else
            <p>{{ __('messages.no faqs') }}</p>
        @endif

        <h4 class="section-title"><i class="bi bi-people-fill"></i> {{ __('messages.booked users') }}</h4>
        @if($event->bookings->isEmpty())
            <p>{{ __('messages.no bookings') }}</p>
        @else
            <ul class="list-group">
                @foreach($event->bookings as $booking)
                    <li class="list-group-item text-white">
                        {{ $booking->user->name }} ({{ ucfirst($booking->status) }})
                    </li>
                @endforeach
            </ul>
        @endif

        <a href="{{ route('admin.events.index') }}" class="btn btn-custom mt-4">
            <i class="bi bi-arrow-left"></i> {{ __('messages.back to events') }}
        </a>
    </div>
</div>
@endsection
