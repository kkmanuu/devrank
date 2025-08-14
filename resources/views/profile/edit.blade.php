@extends('layouts.app')

@section('content')
<div class="bg-light min-vh-100 py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12">

                <!-- Professional Header Section -->
                <div class="text-center mb-5">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary rounded-circle mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-user-edit text-white fs-2"></i>
                    </div>
                    <h1 class="display-4 fw-bold text-dark mb-2">Edit Profile</h1>
                    <p class="lead text-muted">Manage your account information, password, and security settings</p>
                    <hr class="w-25 mx-auto border-primary border-2">
                </div>

                <!-- Profile Management Cards -->
                <div class="row g-4">
                    
                    <!-- Update Profile Information Card -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-lg rounded-4 h-100">
                            <div class="card-header bg-primary text-white text-center py-4 rounded-top-4">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <i class="fas fa-user-circle fs-2 me-3"></i>
                                    <div>
                                        <h4 class="mb-0 fw-semibold">Profile Information</h4>
                                        <small class="opacity-75">Update your personal details</small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                @include('profile.partials.update-profile-information-form')
                            </div>
                        </div>
                    </div>

                    <!-- Update Password Card -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-lg rounded-4 h-100">
                            <div class="card-header bg-success text-white text-center py-4 rounded-top-4">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <i class="fas fa-lock fs-2 me-3"></i>
                                    <div>
                                        <h4 class="mb-0 fw-semibold">Security Settings</h4>
                                        <small class="opacity-75">Change your password</small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                @include('profile.partials.update-password-form')
                            </div>
                        </div>
                    </div>

                    <!-- Delete Account Card - Full Width -->
                    <div class="col-12">
                        <div class="card border-0 shadow-lg rounded-4">
                            <div class="card-header bg-danger text-white text-center py-4 rounded-top-4">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <i class="fas fa-exclamation-triangle fs-2 me-3"></i>
                                    <div>
                                        <h4 class="mb-0 fw-semibold">Danger Zone</h4>
                                        <small class="opacity-75">Permanently delete your account</small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="alert alert-danger border-0 rounded-3 mb-4">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-exclamation-circle text-danger me-3 mt-1"></i>
                                        <div>
                                            <h6 class="alert-heading">Warning: This action cannot be undone</h6>
                                            <p class="mb-0">Deleting your account will permanently remove all your data, including your profile, settings, and any associated content. Please be certain before proceeding.</p>
                                        </div>
                                    </div>
                                </div>
                                @include('profile.partials.delete-user-form')
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Navigation Actions -->
                <div class="text-center mt-5 pt-4">
                    <a href="{{ route('profile.show') }}" class="btn btn-outline-primary btn-lg px-5 rounded-pill me-3">
                        <i class="fas fa-eye me-2"></i>
                        View Profile
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-lg px-5 rounded-pill">
                        <i class="fas fa-arrow-left me-2"></i>
                        Back to Dashboard
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
