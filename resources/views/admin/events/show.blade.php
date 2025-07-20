@extends('layouts.app')

@section('content')
<div class="d-flex">
    <!-- Sidebar -->
    @include('layouts.navbar') <!-- Assuming sidebar is included in app layout or separate partial -->

    <div class="content flex-grow-1">
        <div class="container py-5">
            <h1 class="mb-4">Event: {{ $event->title }}</h1>
            <p><strong>Date:</strong> {{ $event->event_date->format('Y-m-d H:i') }}</p>
            <p><strong>Status:</strong> {{ ucfirst($event->status) }}</p>
            <p><strong>Description:</strong> {{ $event->description ?? 'N/A' }}</p>

            <h3 class="mt-4">Registered Users</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Participated</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($event->users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->pivot->participated ? 'Yes' : 'No' }}</td>
                            <td>
                                <form action="{{ route('admin.events.toggleParticipation', [$event, $user]) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="participated" value="{{ $user->pivot->participated ? 0 : 1 }}">
                                    <button type="submit" class="btn btn-sm {{ $user->pivot->participated ? 'btn-danger' : 'btn-success' }}">
                                        {{ $user->pivot->participated ? 'Mark Not Participated' : 'Mark Participated' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
