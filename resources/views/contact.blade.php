@extends('layouts.app')

@section('title', 'Contact - DevRank')

@section('content')
<!-- Hero Section with Forward-Scrolling Background -->
<section id="hero-slider" class="hero-section position-relative d-flex align-items-center text-white" style="height: 70vh; overflow: hidden;">
    <div class="slider-container position-absolute w-100 h-100" style="z-index: 0;">
        <div class="slider-track">
            <div class="slide" style="background-image: url('{{ asset('images/tech.jpg') }}');"></div>
            <div class="slide" style="background-image: url('{{ asset('images/techs.jpg') }}');"></div>
            <div class="slide" style="background-image: url('{{ asset('images/techss.jpg') }}');"></div>
        </div>
    </div>
    <div class="overlay position-absolute w-100 h-100" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.5)); z-index: 1;"></div>
    <div class="container text-center position-relative z-2 py-5">
        <h1 class="display-3 fw-bold fade-in">Contact Us</h1>
        <p class="lead mb-4 fade-in delay-1">We're here to help you grow, connect, and succeed in your tech journey.</p>
        <a href="#contact" class="btn btn-primary btn-lg px-5 py-3 fade-in delay-2">Get in Touch</a>
    </div>
</section>

<!-- Contact Details Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center fw-bold mb-5 text-dark fade-in">Our Contact Details</h2>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="contact-item text-center p-4 border border-light rounded-3 bg-gradient-light slide-in">
                    <i class="bi bi-envelope-fill display-4 text-primary mb-3"></i>
                    <h5 class="fw-bold text-dark">Email</h5>
                    <p class="text-muted mb-0">support@devrank.com</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="contact-item text-center p-4 border border-light rounded-3 bg-gradient-light slide-in delay-1">
                    <i class="bi bi-telephone-fill display-4 text-primary mb-3"></i>
                    <h5 class="fw-bold text-dark">Phone</h5>
                    <p class="text-muted mb-0">+254 123 456 789</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Get in Touch Section with Map and Form -->
<section id="contact" class="py-5" style="background: linear-gradient(135deg, #2c3e50, #1c2526);">
    <div class="container">
        <h2 class="text-center fw-bold mb-5 text-white fade-in">Get in Touch</h2>
        <div class="row g-4">
            <!-- Map -->
            <div class="col-md-6">
                <div class="map-container rounded-3 overflow-hidden scale-up">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.835434509374!2d144.9537353153167!3d-37.81627927975146!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0xf577d9c8c8f8d8c!2sMelbourne%20VIC%2C%20Australia!5e0!3m2!1sen!2sus!4v1634567890123!5m2!1sen!2sus" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
                <p class="text-center text-white-50 mt-3 slide-in">Our office is located in the heart of the tech hub.</p>
            </div>
            <!-- Contact Form -->
            <div class="col-md-6">
                <div class="contact-form p-4 bg-dark rounded-3 shadow-lg scale-up delay-1">
                    <form action="{{ route('contact.submit') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label text-white">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label text-white">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="company" class="form-label text-white">Company (Optional)</label>
                            <input type="text" class="form-control" id="company" name="company">
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label text-white">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg px-4">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="py-5 text-white text-center" style="background: linear-gradient(135deg, #007bff, #6610f2);">
    <div class="container">
        <h2 class="mb-3 fw-bold fade-in">Let's Make Your Event Memorable!</h2>
        <p class="lead mb-4 fade-in delay-1">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
        <div class="d-flex justify-content-center gap-3 fade-in delay-2">
            <a href="{{ route('events.welcome') }}" class="btn btn-light btn-lg px-5 py-3">Book Now</a>
            <a href="{{ route('coaching.index') }}" class="btn btn-outline-light btn-lg px-5 py-3">Book Coaching</a>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    /* General Styling */
 /* ========== General ========== */
body {
    font-family: 'Inter', sans-serif;
    line-height: 1.6;
    color: #333;
}

/* ========== Hero Section ========== */
.hero-section h1 {
    font-size: 3.5rem;
    text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.5);
}
.hero-section .lead {
    font-size: 1.2rem;
    max-width: 650px;
    margin: 0 auto;
}
.hero-section .btn-primary {
    background-color: #007bff;
    border: none;
    font-weight: 600;
}
.hero-section .btn-primary:hover {
    background-color: #0056b3;
    transform: scale(1.05);
}

/* ========== Slider Animation ========== */
.slider-container {
    width: 100%;
    height: 100%;
    overflow: hidden;
}
.slider-track {
    display: flex;
    width: 300%;
    height: 100%;
    animation: slideForward 15s linear infinite;
}
.slide {
    width: 33.33%;
    height: 100%;
    background-size: cover;
    background-position: center;
}
@keyframes slideForward {
    0% { transform: translateX(0); }
    100% { transform: translateX(-33.33%); }
}

/* ========== Contact Details Section ========== */
.bg-gradient-light {
    background: linear-gradient(145deg, #ffffff, #f0f0f0);
}
.contact-item {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.contact-item:hover {
    transform: translateY(-10px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
}
.contact-item i {
    transition: transform 0.3s ease;
}
.contact-item:hover i {
    transform: scale(1.1);
}

/* ========== Get in Touch Section ========== */
#contact {
    background: linear-gradient(135deg, #2c3e50, #1a1a1a);
}

.map-container {
    height: 600px;
    border-radius: 18px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
    overflow: hidden;
    border: 2px solid #007bff;
}
.map-container iframe {
    width: 100%;
    height: 100%;
    filter: grayscale(20%) brightness(90%) contrast(105%);
}

/* ========== Contact Form ========== */
.contact-form {
    background-color: #1f1f1f;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
}
.contact-form .form-control {
    background-color: #2c3e50;
    border: 1px solid #444;
    color: #fff;
}
.contact-form .form-control:focus {
    background-color: #2c3e50;
    border-color: #007bff;
    color: #fff;
    box-shadow: none;
}
.contact-form .btn-primary {
    font-weight: 600;
}
.contact-form .btn-primary:hover {
    background-color: #0056b3;
    transform: scale(1.02);
}

/* ========== Call to Action Section ========== */
.btn-light {
    background-color: #fff;
    color: #007bff;
    font-weight: 600;
    transition: transform 0.3s ease;
}
.btn-light:hover {
    background-color: #f8f9fa;
    color: #0056b3;
    transform: scale(1.05);
}
.btn-outline-light {
    border-color: #fff;
    color: #fff;
    font-weight: 600;
}
.btn-outline-light:hover {
    background-color: #fff;
    color: #007bff;
}

/* ========== Animations ========== */
.fade-in {
    opacity: 0;
    animation: fadeIn 1s ease-in-out forwards;
}
.fade-in.delay-1 { animation-delay: 0.5s; }
.fade-in.delay-2 { animation-delay: 1s; }

.slide-in {
    opacity: 0;
    transform: translateX(30px);
    animation: slideIn 1s ease-in-out forwards;
}
.slide-in.delay-1 { animation-delay: 0.5s; }

.scale-up {
    opacity: 0;
    transform: scale(0.9);
    animation: scaleUp 0.8s ease-in-out forwards;
}
.scale-up.delay-1 { animation-delay: 0.4s; }

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
@keyframes slideIn {
    from { opacity: 0; transform: translateX(30px); }
    to { opacity: 1; transform: translateX(0); }
}
@keyframes scaleUp {
    from { opacity: 0; transform: scale(0.9); }
    to { opacity: 1; transform: scale(1); }
}

</style>
@endpush