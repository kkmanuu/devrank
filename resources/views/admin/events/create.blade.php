@extends('layouts.app')

@section('content')
<div class="d-flex">
    <!-- Sidebar -->
    @include('layouts.navbar') <!-- Assuming sidebar is included in app layout or separate partial -->

    <div class="content flex-grow-1">
        <div class="container py-5">
            <h1 class="mb-4">Create Event</h1>

            <form action="{{ route('admin.events.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label for="event_date" class="form-label">Event Date</label>
                    <input type="datetime-local" name="event_date" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="upcoming">Upcoming</option>
                        <option value="ongoing">Ongoing</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Create Event</button>
            </form>
        </div>
    </div>
</div>
@endsection
