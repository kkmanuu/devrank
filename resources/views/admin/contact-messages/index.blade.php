@extends('layouts.app')

@section('title', 'Admin - Contact Messages')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">Manage Contact Messages</h1>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered bg-white shadow-lg rounded-3">
        <thead class="bg-dark text-white">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Company</th>
                <th>Message</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($messages as $message)
            <tr>
                <td>{{ $message->name }}</td>
                <td>{{ $message->email }}</td>
                <td>{{ $message->company ?? 'N/A' }}</td>
                <td>{{ Str::limit($message->message, 50) }}</td>
                <td>{{ $message->is_read ? 'Read' : 'Unread' }}</td>
                <td>
                    @if (!$message->is_read)
                        <form action="{{ route('admin.contact-messages.markAsRead', $message) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-primary">Mark as Read</button>
                        </form>
                    @endif
                    <form action="{{ route('admin.contact-messages.destroy', $message) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection