@extends('layouts.app')

@section('content')
<div class="d-flex">
    <!-- Sidebar -->
    @include('layouts.navbar') <!-- Assuming sidebar is included in app layout or separate partial -->

    <div class="content flex-grow-1">
        <div class="container py-5">
            <h1 class="mb-4">Manage Events</h1>

            <a href="{{ route('admin.events.create') }}" class="btn btn-primary mb-3">Create New Event</a>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Registrations</th>
                        <th>Participants</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $event)
                        <tr>
                            <td>{{ $event->title }}</td>
                            <td>{{ $event->event_date->format('Y-m-d H:i') }}</td>
                            <td>{{ ucfirst($event->status) }}</td>
                            <td>{{ $event->registered_count }}</td>
                            <td>{{ $event->participants }}</td>
                            <td>
                                <a href="{{ route('admin.events.show', $event) }}" class="btn btn-sm btn-info">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $events->links() }}
        </div>
    </div>
</div>
@endsection
