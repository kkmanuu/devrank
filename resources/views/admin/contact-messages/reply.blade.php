@extends('layouts.app')

@section('title', 'Reply to Message')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Reply to {{ $contactMessage->name }}</h1>

    <a href="{{ route('admin.contact-messages.replyForm', $contactMessage) }}" class="btn btn-sm btn-info text-white">Reply</a>

        @csrf
        <div class="mb-3">
            <label for="reply" class="form-label">Your Reply</label>
            <textarea name="reply" id="reply" class="form-control" rows="6" required>{{ old('reply', $contactMessage->reply) }}</textarea>
            @error('reply')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-success">Send Reply</button>
        <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
