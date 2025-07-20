
<>
    @extends('layouts.app')

    @section('content')
        <div class="container py-5">
            <h1 class="text-center mb-4 animate__animated animate__fadeIn">{{ __('messages.submit_project') }}</h1>
            <div class="form-container bg-white shadow-sm rounded p-4 animate__animated animate__fadeInUp">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <form action="{{ route('project.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">{{ __('messages.project_title') }}</label>
                        <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
                    </div>
                    <div class="mb-3">
                        <label for="github_url" class="form-label">{{ __('messages.github_url') }}</label>
                        <input type="url" name="github_url" class="form-control" required value="{{ old('github_url') }}">
                    </div>
                    <div class="mb-3">
                        <label for="linkedin_url" class="form-label">{{ __('messages.linkedin_url') }}</label>
                        <input type="url" name="linkedin_url" class="form-control" value="{{ old('linkedin_url') }}">
                    </div>
                    <div class="mb-3">
                        <label for="cv" class="form-label">{{ __('messages.upload_cv') }}</label>
                        <input type="file" name="cv" class="form-control" accept=".pdf">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">{{ __('messages.submit') }}</button>
                </form>
            </div>
        </div>
    @endsection