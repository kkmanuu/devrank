@extends('layouts.app')

@section('content')
<div class="d-flex">
    <!-- Sidebar -->
    @include('layouts.navbar') <!-- Assuming sidebar is included in app layout or separate partial -->
    <div class="content flex-grow-1">
        <div class="container py-5">
            <h1 class="mb-4">Manage Coaching Sessions</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Coach</th>
                        <th>Date</th>
                        <th>Topic</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sessions as $session)
                        <tr>
                            <td>{{ $session->user->name }}</td>
                            <td>{{ $session->coach->name ?? 'Not Assigned' }}</td>
                            <td>{{ $session->session_date->format('Y-m-d H:i') }}</td>
                            <td>{{ $session->topic }}</td>
                            <td>{{ ucfirst($session->status) }}</td>
                            <td>
                                <form action="{{ route('admin.coaching.assign', $session) }}" method="POST">
                                    @csrf
                                    <select name="coach_id" class="form-control d-inline w-auto mb-2">
                                        <option value="">Select Coach</option>
                                        @foreach(\App\Models\User::where('role', 'coach')->get() as $coach)
                                            <option value="{{ $coach->id }}" {{ $session->coach_id == $coach->id ? 'selected' : '' }}>{{ $coach->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary">Assign Coach</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $sessions->links() }}
        </div>
    </div>
</div>
@endsection
