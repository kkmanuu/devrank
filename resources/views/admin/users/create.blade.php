@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
        color: #fff;
        font-family: 'Segoe UI', sans-serif;
    }
    .form-container {
        max-width: 600px;
        margin: 60px auto;
        background: linear-gradient(135deg, #1e3c72, #2a5298);
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.6);
    }
    .form-label {
        font-weight: 500;
        color: #fff;
    }
    .form-control, .form-select {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #fff;
    }
    .form-control::placeholder {
        color: #ccc;
    }
    .form-control:focus, .form-select:focus {
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
        border-color: #0ff;
        box-shadow: none;
    }
    .btn-custom {
        background-color: rgba(255, 255, 255, 0.1);
        color: #fff;
        border: none;
        width: 100%;
    }
    .btn-custom:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }
</style>

<div class="container">
    <div class="form-container">
        <h2 class="mb-4 text-center fw-bold"><i class="bi bi-person-plus"></i> Add New User</h2>

        @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.
                <ul class="mt-2 mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input name="name" type="text" class="form-control" placeholder="e.g. John Doe" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input name="email" type="email" class="form-control" placeholder="e.g. user@example.com" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Select Role</label>
                <select name="role" class="form-select" required>
                    <option value="" disabled selected>Choose a role</option>
                    <option value="coach" {{ old('role') == 'coach' ? 'selected' : '' }}>Coach</option>
                    <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input name="password" type="password" class="form-control" placeholder="Minimum 6 characters" required>
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input name="password_confirmation" type="password" class="form-control" placeholder="Re-enter password" required>
            </div>

            <button type="submit" class="btn btn-custom">
                <i class="bi bi-check-circle-fill me-2"></i> Create User
            </button>
        </form>
    </div>
</div>
@endsection
