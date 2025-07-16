@extends('layouts.app')

@section('title', 'DevRank - Empowering Student Developers')

@section('content')
<div class="hero-section text-center">
    <div class="container">
        <h1 class="display-3 fw-bold mb-4">{{ __('welcome') }}</h1>
        <p class="lead mb-4">Empower your coding journey with expert project evaluations, detailed feedback, and personalized coaching.</p>
        <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-2">{{ __('get_started') }}</a>
        <a href="{{ route('services') }}" class="btn btn-outline-light btn-lg">{{ __('learn_more') }}</a>
    </div>
</div>

<div class="container py-5">
    <h2 class="text-center mb-5">Why Choose DevRank?</h2>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card feature-card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">{{ __('submit_project') }}</h5>
                    <p class="card-text">Submit your frontend, backend, or full-stack projects for expert evaluation.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card feature-card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">{{ __('feedback') }}</h5>
                    <p class="card-text">Receive detailed feedback based on our scoring rubric to improve your skills.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card feature-card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">{{ __('coaching') }}</h5>
                    <p class="card-text">Book personalized coaching sessions with experienced mentors.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-light py-5">
    <div class="container">
        <h2 class="text-center mb-5">What Our Users Say</h2>
        <div class="row">
            <div class="col-md-6 mb-4">
                <blockquote class="blockquote">
                    <p>"DevRank helped me improve my coding skills with actionable feedback!"</p>
                    <footer class="blockquote-footer">Jane Doe, Student Developer</footer>
                </blockquote>
            </div>
            <div class="col-md-6 mb-4">
                <blockquote class="blockquote">
                    <p>"The coaching sessions were a game-changer for my career."</p>
                    <footer class="blockquote-footer">John Smith, Full-Stack Developer</footer>
                </blockquote>
            </div>
        </div>
    </div>
</div>
@endsection