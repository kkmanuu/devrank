@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <h1 class="mb-4 text-white fw-bold">Notifications</h1>

        @if($notifications->isEmpty())
            <p class="text-white-50">No notifications available.</p>
        @else
            <div class="row g-4">
                @foreach($notifications as $index => $notification)
                    <div class="col-md-12">
                        <div class="card p-3">
                            <p><strong>{{ ucfirst($notification->type) }}:</strong> {{ $notification->message }}</p>
                            <p class="text-white-50" style="font-size: 0.9rem;">{{ $notification->created_at->format('F d, Y H:i') }}</p>
                            @if(!$notification->is_read)
                                <form action="{{ route('notifications.markAsRead', $notification) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-custom btn-sm">Mark as Read</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $notifications->links() }}
        @endif
    </div>
@endsection