@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
        color: #fff;
        font-family: 'Segoe UI', sans-serif;
    }
    .table-container {
        max-width: 900px;
        margin: 60px auto;
        background: linear-gradient(135deg, #1e3c72, #2a5298);
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.6);
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 12px 15px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }
    th {
        color: #0ff;
        font-weight: 600;
    }
    td {
        color: #fff;
    }
    .btn-custom {
        background-color: rgba(255, 255, 255, 0.1);
        color: #fff;
        border: none;
        padding: 6px 12px;
        border-radius: 8px;
        text-decoration: none;
    }
    .btn-custom:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }
</style>

<div class="container">
    <div class="table-container">
        <h2 class="mb-4 text-center fw-bold"><i class="bi bi-people"></i> All Users</h2>

        @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        <div class="text-end mb-3">
            <a href="{{ route('admin.users.create') }}" class="btn-custom">
                <i class="bi bi-person-plus"></i> Add New User
            </a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>{{ $user->created_at->format('Y-m-d') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No users found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
