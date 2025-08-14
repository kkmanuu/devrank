@extends('layouts.app')

@section('title', 'Admin - Contact Messages')

@section('content')
<div class="py-5" style="background: linear-gradient(135deg, #e0f7fa, #80deea); min-height: 100vh;">
    <div class="container shadow-lg rounded-4 bg-white p-5">
        <h1 class="mb-5 text-center fw-bold text-primary">Manage Contact Messages</h1>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive shadow-sm rounded-3 bg-white p-3">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Company</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($messages as $message)
                    <tr>
                        <td>{{ $message->name }}</td>
                        <td>{{ $message->email }}</td>
                        <td>{{ $message->company ?? 'N/A' }}</td>
                        <td>{{ Str::limit($message->message, 50) }}</td>
                        <td>
                            <span class="badge {{ $message->is_read ? 'bg-success' : 'bg-warning text-dark' }} px-3 py-2">
                                {{ $message->is_read ? 'Read' : 'Unread' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                {{-- Mark as Read --}}
                                @if (!$message->is_read)
                                    <form action="{{ route('admin.contact-messages.markAsRead', $message) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-primary shadow-sm">Mark as Read</button>
                                    </form>
                                @endif

                                {{-- Reply Button --}}
                                <a href="{{ route('admin.contact-messages.replyForm', $message) }}" 
                                   class="btn btn-sm btn-info text-white shadow-sm">
                                   Reply
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('admin.contact-messages.destroy', $message) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger shadow-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                    @if($messages->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted fst-italic">No contact messages found.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
