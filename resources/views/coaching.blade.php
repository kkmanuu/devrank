<template>
    <div class="container">
        <h1>{{ __('coaching.title') }}</h1>
        <p>{{ __('coaching.description') }}</p>

        <form method="POST" action="{{ route('coaching.book') }}">
            @csrf
            <div class="mb-3">
                <label for="topic" class="form-label">{{ __('coaching.topic_label') }}</label>
                <input type="text" class="form-control" id="topic" name="topic" required>
            </div>
            <div class="mb-3">
                <label for="scheduled_at" class="form-label">{{ __('coaching.scheduled_at_label') }}</label>
                <input type="datetime-local" class="form-control" id="scheduled_at" name="scheduled_at" required>
            </div> 
            <button type="submit" class="btn btn-primary">{{ __('coaching.book_session') }}</button>
        </form>
        <h2 class="mt-5">{{ __('coaching.sessions') }}</h2>
        <ul class="list-group">
            @foreach($sessions as $session)
                <li class="list-group-item">
                    <strong>{{ $session->topic }}</strong> - {{ $session->scheduled_at->format('d M Y, H:i') }}
                    <span class="badge bg-{{ $session->status === 'pending' ? 'warning' : 'success' }}">{{ $session->status }}</span>
                </li>
            @endforeach
        </ul>
    </div>
    