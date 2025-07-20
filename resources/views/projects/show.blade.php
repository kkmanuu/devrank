@extends('layouts.app')

@section('title', __('messages.submission_details') . ' - DevRank')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-4 animate__animated animate__fadeIn">{{ __('messages.submission_details') }}</h1>
    <div class="submission-details bg-white shadow-sm rounded p-4 animate__animated animate__fadeInUp" style="max-width: 800px; margin: 0 auto;">
        <h3>{{ $submission->project->title }}</h3>
        <p><strong>{{ __('messages.github_url') }}:</strong> 
            <a href="{{ $submission->project->github_url }}" target="_blank">{{ $submission->project->github_url }}</a>
        </p>
        <p><strong>{{ __('messages.linkedin_url') }}:</strong> {{ $submission->project->linkedin_url ?? 'N/A' }}</p>
        <p><strong>{{ __('messages.cv') }}:</strong> 
            @if($submission->project->cv_path)
                <a href="{{ asset('storage/' . $submission->project->cv_path) }}" target="_blank">Download CV</a>
            @else
                N/A
            @endif
        </p>
        <p><strong>{{ __('messages.score') }}:</strong> {{ $submission->score ?? 'Pending' }}</p>
        <p><strong>{{ __('messages.status') }}:</strong> {{ ucfirst($submission->status) }}</p>

        @if($submission->feedback)
            <h4 class="mt-4">{{ __('messages.feedback') }}</h4>
            <p><strong>{{ __('messages.correct') }}:</strong> {{ $submission->feedback->correct }}</p>
            <p><strong>{{ __('messages.incorrect') }}:</strong> {{ $submission->feedback->incorrect }}</p>
        @endif
    </div>
</div>
@endsection
