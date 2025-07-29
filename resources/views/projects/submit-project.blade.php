@extends('layouts.app')

@section('content')
<div class="submit-section py-5 position-relative">
    <!-- Sparkle animation background -->
    <div class="sparkle-bg position-absolute top-0 start-0 w-100 h-100"></div>

    <div class="container position-relative" style="z-index: 1;">
        <div class="form-wrapper mx-auto bg-white shadow rounded overflow-hidden" style="max-width: 900px;">
            <div class="row g-0">
                <!-- Left Image -->
                <div class="col-md-6 d-none d-md-block">
                    <img src="{{ asset('images/pex.jpg') }}" alt="Submit Project" class="img-fluid h-100 w-100" style="object-fit: cover;">
                </div>

                <!-- Right Form -->
                <div class="col-md-6 p-4 p-md-5">
                    <h2 class="text-center mb-4 animate__animated animate__fadeInDown">Submit Your Project</h2>

                    @if ($errors->any())
                        <div class="alert alert-danger animate__animated animate__fadeIn">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger animate__animated animate__fadeIn">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('project.store') }}" method="POST" enctype="multipart/form-data" class="animate__animated animate__fadeInUp">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label fw-semibold">Project Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter your project title" required value="{{ old('title') }}">
                        </div>

                        <div class="mb-3">
                            <label for="github_url" class="form-label fw-semibold">GitHub URL</label>
                            <input type="url" name="github_url" class="form-control" placeholder="https://github.com/yourproject" required value="{{ old('github_url') }}">
                        </div>

                        <div class="mb-3">
                            <label for="linkedin_url" class="form-label fw-semibold">LinkedIn URL (Optional)</label>
                            <input type="url" name="linkedin_url" class="form-control" placeholder="https://linkedin.com/in/yourprofile" value="{{ old('linkedin_url') }}">
                        </div>

                        <div class="mb-4">
                            <label for="cv" class="form-label fw-semibold">Upload CV (PDF only)</label>
                            <input type="file" name="cv" class="form-control" accept=".pdf">
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Submit Project</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<!-- Animate.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    .submit-section {
        background: linear-gradient(to bottom right,rgb(49, 74, 94),rgb(3, 33, 60));
        min-height: 100vh;
        overflow: hidden;
        position: relative;
    }

    .sparkle-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        pointer-events: none;
    }

    .sparkle-bg::before {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        background-image: radial-gradient(circle, #cce5ff 1px, transparent 1px),
                          radial-gradient(circle, #99ccff 1px, transparent 1px);
        background-size: 40px 40px;
        background-position: 0 0, 20px 20px;
        opacity: 0.3;
        animation: sparkleMove 60s linear infinite;
        z-index: 0;
    }

    @keyframes sparkleMove {
        0% { background-position: 0 0, 20px 20px; }
        100% { background-position: 1000px 1000px, 1020px 1020px; }
    }

    .form-wrapper {
        max-width: 900px;
        position: relative;
        z-index: 2;
        background-color: #fff;
    }

    .form-label {
        font-size: 0.95rem;
    }

    .form-control {
        border-radius: 0.5rem;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        border-radius: 0.5rem;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        transform: scale(1.02);
    }

    .img-fluid {
        height: 100%;
        object-fit: cover;
    }

    @media (max-width: 768px) {
        .submit-section {
            padding: 2rem 1rem;
        }
        .form-wrapper {
            max-width: 100%;
        }
    }
</style>
@endpush
