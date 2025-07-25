@extends('layouts.app')

@section('title', 'Admin - Manage Services')

@section('content')
<section class="py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Manage Services</h2>

        <!-- Add New Service Button -->
        <div class="mb-4 text-end">
            <a href="{{ route('admin.services.create') }}" class="btn btn-primary">Add New Service</a>
        </div>

        <!-- Services Table -->
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Icon</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($services as $service)
                        <tr>
                            <td>{{ $service->title }}</td>
                            <td>{{ $service->description }}</td>
                            <td>{{ $service->icon }}</td>
                            <td>
                                <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" class="d-inline">
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
        </div>
    </div>
</section>
@endsection