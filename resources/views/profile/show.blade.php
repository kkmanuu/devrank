@extends('layouts.app')

@section('content')
<div class="bg-light min-vh-100 py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-10">

                <!-- Professional Header Section -->
                <div class="text-center mb-5">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary rounded-circle mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-user text-white fs-2"></i>
                    </div>
                    <h1 class="display-4 fw-bold text-dark mb-2">My Profile</h1>
                    <p class="lead text-muted">View and manage your account information</p>
                    <hr class="w-25 mx-auto border-primary border-2">
                </div>

                <!-- Main Profile Card -->
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <!-- Card Header with Gradient -->
                    <div class="card-header bg-gradient text-white text-center py-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <h3 class="mb-0 fw-semibold">
                            <i class="fas fa-id-card me-2"></i>
                            Profile Information
                        </h3>
                        <p class="mb-0 opacity-75">Your account details and settings</p>
                    </div>

                    <div class="card-body p-5">
                        <!-- Profile Information Grid -->
                        <div class="row g-4">
                            <!-- Name Field -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control bg-light border-0 shadow-sm" 
                                           value="{{ $user->name }}" readonly>
                                    <label class="text-muted">
                                        <i class="fas fa-user me-2"></i>Full Name
                                    </label>
                                </div>
                            </div>

                            <!-- Email Field -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control bg-light border-0 shadow-sm" 
                                           value="{{ $user->email }}" readonly>
                                    <label class="text-muted">
                                        <i class="fas fa-envelope me-2"></i>Email Address
                                    </label>
                                </div>
                            </div>

                            <!-- Member Since -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control bg-light border-0 shadow-sm" 
                                           value="{{ $user->created_at->format('F j, Y') }}" readonly>
                                    <label class="text-muted">
                                        <i class="fas fa-calendar me-2"></i>Member Since
                                    </label>
                                </div>
                            </div>

                            <!-- Account Status -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control bg-light border-0 shadow-sm" 
                                           value="@if($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && $user->hasVerifiedEmail()) Verified @else Unverified @endif" readonly>
                                    <label class="text-muted">
                                        <i class="fas fa-shield-alt me-2"></i>Account Status
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Email Verification Alert -->
                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div class="alert alert-warning border-0 shadow-sm mt-4 rounded-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-triangle text-warning me-3 fs-4"></i>
                                    <div>
                                        <h6 class="alert-heading mb-1">Email Verification Required</h6>
                                        <p class="mb-2">Your email address needs verification to secure your account.</p>
                                        <a href="{{ route('verification.send') }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-paper-plane me-1"></i>
                                            Resend Verification Email
                                        </a>
                                    </div>
                                </div>
                            </div>

                            @if (session('status') === 'verification-link-sent')
                                <div class="alert alert-success border-0 shadow-sm mt-3 rounded-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-check-circle text-success me-3 fs-4"></i>
                                        <div>
                                            <h6 class="alert-heading mb-1">Verification Email Sent</h6>
                                            <p class="mb-0">A new verification link has been sent to your email address.</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif

                        <!-- Action Buttons -->
                        <div class="text-center mt-5 pt-4 border-top">
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm">
                                <i class="fas fa-edit me-2"></i>
                                Edit Profile
                            </a>
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-lg px-5 rounded-pill ms-3">
                                <i class="fas fa-arrow-left me-2"></i>
                                Back to Dashboard
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
