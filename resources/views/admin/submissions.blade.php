@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">All Submissions</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Project Title</th>
                <th>Status</th>
                <th>Score</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($submissions as $submission)
                <tr>
                    <td>{{ $submission->user->name ?? 'No User' }}</td>
<td>{{ $submission->project->title ?? 'No Project' }}</td>

                    <td>{{ $submission->project->title }}</td>
                    <td>{{ $submission->status }}</td>
                    <td>{{ $submission->score ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.submissions.edit', $submission->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        
                        <form action="{{ route('admin.submissions.destroy', $submission->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No submissions found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
