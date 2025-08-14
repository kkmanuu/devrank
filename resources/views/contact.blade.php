@extends('layouts.app')

@section('title', 'Contact - DevRank')

@section('content')
<!-- Hero Section with Forward-Scrolling Background -->
<section id="hero-slider" class="hero-section position-relative d-flex align-items-center text-white" style="height: 75vh; overflow: hidden;">
    <div class="slider-container position-absolute w-100 h-100" style="z-index: 0;">
        <div class="slider-track">
            <div class="slide" style="background-image: url('{{ asset('images/tech.jpg') }}');"></div>
            <div class="slide" style="background-image: url('{{ asset('images/techs.jpg') }}');"></div>
            <div class="slide" style="background-image: url('{{ asset('images/techss.jpg') }}');"></div>
        </div>
    </div>
   
    <div class="container text-center position-relative z-2 py-5">
        <h1 class="display-3 fw-bold slide-in">Contact DevRank</h1>
        <p class="lead mb-4 slide-in delay-1">Ready to transform your tech journey? Let's connect and make it happen together.</p>
        <div class="d-flex justify-content-center gap-3 slide-in delay-2">
            <a href="#contact" class="btn btn-primary btn-lg px-5 py-3">
                <i class="bi bi-chat-dots me-2"></i>Start Conversation
            </a>
            <a href="#quick-info" class="btn btn-outline-light btn-lg px-5 py-3">
                <i class="bi bi-info-circle me-2"></i>Quick Info
            </a>
        </div>
    </div>
</section>

<!-- Quick Contact Info Cards -->
<section id="quick-info" class="py-5" style="background-color: #e6f0fa;">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="fw-bold mb-3 fade-in">Get in Touch Instantly</h2>
            <p class="text-muted mx-auto fade-in delay-1" style="max-width: 700px;">
                Multiple ways to reach us - choose what works best for you.
            </p>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="contact-card text-center p-4 bg-white rounded-3 shadow-sm slide-in">
                    <div class="icon-wrapper bg-primary text-white rounded-circle mb-3">
                        <i class="bi bi-envelope-fill fs-3"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Email Us</h5>
                    <p class="text-muted mb-3">Quick response guaranteed</p>
                    <a href="mailto:support@devrank.com" class="btn btn-outline-primary btn-sm">
                        support@devrank.com
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="contact-card text-center p-4 bg-white rounded-3 shadow-sm slide-in delay-1">
                    <div class="icon-wrapper bg-success text-white rounded-circle mb-3">
                        <i class="bi bi-telephone-fill fs-3"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Call Us</h5>
                    <p class="text-muted mb-3">Direct line to our team</p>
                    <a href="tel:+254123456789" class="btn btn-outline-success btn-sm">
                        +254 123 456 789
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="contact-card text-center p-4 bg-white rounded-3 shadow-sm slide-in delay-2">
                    <div class="icon-wrapper bg-info text-white rounded-circle mb-3">
                        <i class="bi bi-chat-square-dots-fill fs-3"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Live Chat</h5>
                    <p class="text-muted mb-3">Instant support online</p>
                    <button class="btn btn-outline-info btn-sm" onclick="openLiveChat()">
                        Start Chat
                    </button>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="contact-card text-center p-4 bg-white rounded-3 shadow-sm slide-in delay-3">
                    <div class="icon-wrapper bg-warning text-white rounded-circle mb-3">
                        <i class="bi bi-geo-alt-fill fs-3"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Visit Us</h5>
                    <p class="text-muted mb-3">Come to our office</p>
                    <button class="btn btn-outline-warning btn-sm" onclick="scrollToMap()">
                        View Location
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Contact Section with Enhanced Form and Map -->
<section id="contact" class="py-5" style="background: linear-gradient(135deg, #2c3e50, #1c2526);">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="fw-bold mb-3 text-white fade-in">Send Us a Message</h2>
            <p class="text-white-50 mx-auto fade-in delay-1" style="max-width: 700px;">
                Whether you're a student looking for guidance or a company interested in our services, we'd love to hear from you.
            </p>
        </div>
        <div class="row g-5 align-items-center">
            <!-- Enhanced Contact Form -->
            <div class="col-lg-6">
                <div class="contact-form-wrapper scale-up">
                    <div class="contact-form p-5 bg-dark rounded-3 shadow-lg">
                        <div class="form-header mb-4">
                            <h4 class="text-white fw-bold mb-2">
                                <i class="bi bi-send me-2 text-primary"></i>Get Started
                            </h4>
                            <p class="text-white-50 small mb-0">Fill out the form below and we'll get back to you within 24 hours.</p>
                        </div>
                        <form action="{{ route('contact.store') }}" method="POST" id="contactForm">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label text-white">
                                        <i class="bi bi-person me-1"></i>Full Name *
                                    </label>
                                    <input type="text" class="form-control form-control-lg" id="name" name="name" placeholder="John Doe" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label text-white">
                                        <i class="bi bi-envelope me-1"></i>Email Address *
                                    </label>
                                    <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="john@example.com" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label text-white">
                                        <i class="bi bi-telephone me-1"></i>Phone Number
                                    </label>
                                    <input type="tel" class="form-control form-control-lg" id="phone" name="phone" placeholder="+254 123 456 789">
                                </div>
                                <div class="col-md-6">
                                    <label for="company" class="form-label text-white">
                                        <i class="bi bi-building me-1"></i>Company/Organization
                                    </label>
                                    <input type="text" class="form-control form-control-lg" id="company" name="company" placeholder="DevRank Inc.">
                                </div>
                                <div class="col-12">
                                    <label for="subject" class="form-label text-white">
                                        <i class="bi bi-bookmark me-1"></i>Subject *
                                    </label>
                                    <select class="form-select form-select-lg" id="subject" name="subject" required>
                                        <option value="">Choose a topic...</option>
                                        <option value="general">General Inquiry</option>
                                        <option value="coaching">Coaching Services</option>
                                        <option value="events">Event Booking</option>
                                        <option value="projects">Project Review</option>
                                        <option value="partnership">Partnership</option>
                                        <option value="support">Technical Support</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label text-white">
                                        <i class="bi bi-chat-text me-1"></i>Message *
                                    </label>
                                    <textarea class="form-control" id="message" name="message" rows="5" placeholder="Tell us about your project, goals, or how we can help..." required></textarea>
                                </div>
                                <div class="col-12">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter" value="1">
                                        <label class="form-check-label text-white-50 small" for="newsletter">
                                            Subscribe to our newsletter for updates and tips
                                        </label>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-lg w-100 py-3">
                                        <i class="bi bi-send me-2"></i>Send Message
                                        <span class="spinner-border spinner-border-sm ms-2 d-none" role="status"></span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Enhanced Map Section -->
            <div class="col-lg-6">
                <div class="map-section scale-up delay-1">
                    <div class="map-header text-center mb-4">
                        <h4 class="text-white fw-bold mb-2">
                            <i class="bi bi-geo-alt me-2 text-primary"></i>Find Us Here
                        </h4>
                        <p class="text-white-50 small mb-0">Located in the heart of Nairobi's tech district</p>
                    </div>
                    <div class="map-container rounded-3 overflow-hidden position-relative">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15955.123456789!2d36.8219462!3d-1.2920659!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f10d22ac83333%3A0x17267a001fb3b614!2sNairobi%2C%20Kenya!5e0!3m2!1sen!2sus!4v1634567890123!5m2!1sen!2sus" 
                            width="100%" 
                            height="450" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                        <div class="map-overlay position-absolute top-0 start-0 w-100 h-100 d-none" id="mapOverlay">
                            <div class="d-flex align-items-center justify-content-center h-100">
                                <div class="text-center text-white">
                                    <i class="bi bi-geo-alt display-1 mb-3"></i>
                                    <h5>Click to interact with map</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="office-info bg-dark p-4 rounded-3 mt-4">
                        <div class="row g-3 text-white-50 small">
                            <div class="col-6">
                                <i class="bi bi-clock text-primary me-2"></i>
                                <strong class="text-white">Office Hours:</strong><br>
                                Mon-Fri: 9AM - 6PM<br>
                                Sat: 10AM - 4PM
                            </div>
                            <div class="col-6">
                                <i class="bi bi-geo-alt text-primary me-2"></i>
                                <strong class="text-white">Address:</strong><br>
                                Tech Hub Plaza, 5th Floor<br>
                                Nairobi, Kenya
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5" style="background-color: #fff8e1;">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="fw-bold mb-3 fade-in">Frequently Asked Questions</h2>
            <p class="text-muted mx-auto fade-in delay-1" style="max-width: 700px;">
                Quick answers to common questions about DevRank services.
            </p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="faqAccordion">
                    @foreach([
                        ['question' => 'How quickly do you respond to messages?', 'answer' => 'We typically respond to all inquiries within 24 hours during business days. For urgent matters, please call us directly.'],
                        ['question' => 'What services does DevRank offer?', 'answer' => 'We offer project reviews, 1:1 coaching sessions, group workshops, tech events, and career guidance for student developers.'],
                        ['question' => 'Is there a cost for initial consultation?', 'answer' => 'No, we offer a free 15-minute initial consultation to understand your needs and how we can best help you.'],
                        ['question' => 'Do you work with international students?', 'answer' => 'Yes! We work with developers from around the world through our online platform and virtual coaching sessions.'],
                        ['question' => 'How do I book a coaching session?', 'answer' => 'You can book directly through our platform, contact us via this form, or call our office during business hours.']
                    ] as $i => $faq)
                    <div class="accordion-item border-0 rounded-3 mb-3 slide-in delay-{{ $i % 3 }}">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq{{ $i }}" aria-expanded="false">
                                {{ $faq['question'] }}
                            </button>
                        </h2>
                        <div id="faq{{ $i }}" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                {{ $faq['answer'] }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced CTA Section -->
<section class="py-5 text-white text-center" style="background: linear-gradient(135deg, #007bff, #6610f2);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto">
                <h2 class="mb-3 fw-bold fade-in">Ready to Accelerate Your Tech Journey?</h2>
                <p class="lead mb-4 fade-in delay-1">Join thousands of developers who've transformed their careers with DevRank's expert guidance and community support.</p>
                <div class="d-flex justify-content-center gap-3 flex-wrap fade-in delay-2">
                    <a href="{{ route('events.index') }}" class="btn btn-light btn-lg px-5 py-3">
                        <i class="bi bi-calendar-event me-2"></i>Browse Events
                    </a>
                    <a href="{{ route('coaching.index') }}" class="btn btn-outline-light btn-lg px-5 py-3">
                        <i class="bi bi-person-video3 me-2"></i>Book Coaching
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-warning btn-lg px-5 py-3">
                        <i class="bi bi-rocket-takeoff me-2"></i>Get Started Free
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    :root {
        --primary: #0062ff;
        --primary-soft: rgba(0, 98, 255, 0.15);
        --success: #28a745;
        --success-soft: rgba(40, 167, 69, 0.15);
        --warning: #ffc107;
        --warning-soft: rgba(255, 193, 7, 0.15);
        --info: #17a2b8;
        --info-soft: rgba(23, 162, 184, 0.15);
        --danger: #dc3545;
        --danger-soft: rgba(220, 53, 69, 0.15);
        --secondary: #6c757d;
        --secondary-soft: rgba(108, 117, 125, 0.15);
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        line-height: 1.7;
        color: #2d3748;
        background-color: #f5f5f5;
    }

    /* Hero Section */
    .hero-section h1 {
        font-size: 3.5rem;
        letter-spacing: -1px;
        line-height: 1.1;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .hero-section .lead {
        font-size: 1.5rem;
        max-width: 650px;
        margin: 0 auto 2.5rem;
        opacity: 0.95;
    }

    /* Slider Animation */
    .slider-container {
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    .slider-track {
        display: flex;
        width: 300%;
        height: 100%;
        animation: slideForward 18s linear infinite;
    }

    .slide {
        width: 33.33%;
        height: 100%;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        filter: brightness(0.8);
    }

    @keyframes slideForward {
        0% { transform: translateX(0); }
        30% { transform: translateX(0); }
        33.33% { transform: translateX(-33.33%); }
        63.33% { transform: translateX(-33.33%); }
        66.66% { transform: translateX(-66.66%); }
        96.66% { transform: translateX(-66.66%); }
        100% { transform: translateX(-100%); }
    }

    /* Contact Cards */
    .contact-card {
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        border-radius: 15px;
        border: 1px solid rgba(0, 98, 255, 0.1);
        position: relative;
        overflow: hidden;
    }

    .contact-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(0, 98, 255, 0.1), transparent);
        transition: left 0.6s;
    }

    .contact-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border-color: var(--primary);
    }

    .contact-card:hover::before {
        left: 100%;
    }

    /* Icon Wrapper */
    .icon-wrapper {
        width: 60px;
        height: 60px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin: 0 auto;
        transition: all 0.3s ease;
    }

    .contact-card:hover .icon-wrapper {
        transform: scale(1.1) rotate(5deg);
    }

    /* Enhanced Contact Form */
    .contact-form-wrapper {
        position: relative;
    }

    .contact-form {
        background: linear-gradient(145deg, #1a1a1a, #2d2d2d);
        border-radius: 20px;
        border: 1px solid rgba(0, 98, 255, 0.2);
        position: relative;
        overflow: hidden;
    }

    .contact-form::before {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        background: linear-gradient(45deg, var(--primary), #6610f2, var(--primary));
        border-radius: 20px;
        z-index: -1;
        animation: borderGlow 3s linear infinite;
    }

    @keyframes borderGlow {
        0%, 100% { opacity: 0.5; }
        50% { opacity: 1; }
    }

    .form-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .contact-form .form-control,
    .contact-form .form-select {
        background-color: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #fff;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .contact-form .form-control:focus,
    .contact-form .form-select:focus {
        background-color: rgba(255, 255, 255, 0.08);
        border-color: var(--primary);
        box-shadow: 0 0 0 0.25rem rgba(0, 98, 255, 0.15);
        color: #fff;
    }

    .contact-form .form-control::placeholder {
        color: rgba(255, 255, 255, 0.4);
    }

    .contact-form .form-select option {
        background-color: #2d2d2d;
        color: #fff;
    }

    /* Map Section */
    .map-container {
        position: relative;
        height: 450px;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        border: 2px solid rgba(0, 98, 255, 0.3);
    }

    .map-container iframe {
        filter: grayscale(20%) brightness(90%) contrast(110%);
        transition: filter 0.3s ease;
    }

    .map-container:hover iframe {
        filter: grayscale(0%) brightness(100%) contrast(115%);
    }

    .office-info {
        background: linear-gradient(145deg, #1a1a1a, #2d2d2d) !important;
        border: 1px solid rgba(0, 98, 255, 0.2);
    }

    /* FAQ Section */
    .accordion-item {
        background-color: #fff;
        border: 1px solid rgba(0, 98, 255, 0.1) !important;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .accordion-item:hover {
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .accordion-button {
        background-color: #fff;
        border: none;
        color: #2d3748;
        font-weight: 600;
        padding: 1.25rem 1.5rem;
    }

    .accordion-button:not(.collapsed) {
        background-color: rgba(0, 98, 255, 0.05);
        color: var(--primary);
        box-shadow: none;
    }

    .accordion-button:focus {
        box-shadow: 0 0 0 0.25rem rgba(0, 98, 255, 0.15);
        border-color: var(--primary);
    }

    /* Buttons */
    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
        font-weight: 700;
        letter-spacing: 0.5px;
        border-radius: 10px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .btn-primary:hover {
        background-color: #0052d9;
        border-color: #0052d9;
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 98, 255, 0.3);
    }

    .btn-primary:hover::before {
        left: 100%;
    }

    .btn-outline-primary {
        color: var(--primary);
        border-color: var(--primary);
        background-color: transparent;
    }

    .btn-outline-primary:hover {
        background-color: var(--primary);
        border-color: var(--primary);
        transform: translateY(-2px);
    }

    .btn-outline-light {
        border-color: #ffffff;
        color: #ffffff;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn-outline-light:hover {
        background-color: #ffffff;
        color: #1c2526;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(255, 255, 255, 0.3);
    }

    .btn-light {
        background-color: #ffffff;
        color: var(--primary);
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn-light:hover {
        background-color: #f8f9fa;
        color: #0052d9;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .btn-warning {
        background-color: var(--warning);
        border-color: var(--warning);
        color: #000;
        font-weight: 600;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #e0a800;
        color: #000;
        transform: translateY(-3px);
    }

    /* Form Validation */
    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: var(--danger);
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.15);
    }

    .form-control.is-valid,
    .form-select.is-valid {
        border-color: var(--success);
        box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.15);
    }

    /* Loading States */
    .btn-loading {
        pointer-events: none;
        opacity: 0.7;
    }

    /* Animations */
    .fade-in {
        opacity: 0;
        animation: fadeIn 1.2s ease-in-out forwards;
    }

    .fade-in.delay-0 { animation-delay: 0s; }
    .fade-in.delay-1 { animation-delay: 0.4s; }
    .fade-in.delay-2 { animation-delay: 0.8s; }

    .slide-in {
        opacity: 0;
        transform: translateY(30px);
        animation: slideIn 0.9s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
    }

    .slide-in.delay-0 { animation-delay: 0s; }
    .slide-in.delay-1 { animation-delay: 0.3s; }
    .slide-in.delay-2 { animation-delay: 0.6s; }
    .slide-in.delay-3 { animation-delay: 0.9s; }

    .scale-up {
        opacity: 0;
        transform: scale(0.9);
        animation: scaleUp 0.9s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
    }

    .scale-up.delay-0 { animation-delay: 0s; }
    .scale-up.delay-1 { animation-delay: 0.3s; }
    .scale-up.delay-2 { animation-delay: 0.6s; }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes scaleUp {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .hero-section h1 {
            font-size: 3rem;
        }

        .hero-section .lead {
            font-size: 1.35rem;
        }
    }

    @media (max-width: 992px) {
        .hero-section h1 {
            font-size: 2.5rem;
        }

        .hero-section .lead {
            font-size: 1.25rem;
        }

        .contact-form {
            margin-top: 2rem;
        }

        .map-container {
            height: 350px;
        }
    }

    @media (max-width: 768px) {
        .hero-section {
            height: 60vh;
        }

        .hero-section h1 {
            font-size: 2.2rem;
        }

        .hero-section .lead {
            font-size: 1.15rem;
        }

        .contact-card {
            margin-bottom: 1rem;
        }

        .contact-form {
            padding: 2rem 1.5rem;
        }

        .map-container {
            height: 300px;
        }

        .d-flex.gap-3 {
            flex-direction: column;
            gap: 1rem !important;
        }

        .btn-lg {
            width: 100%;
        }
    }

    @media (max-width: 576px) {
        .hero-section h1 {
            font-size: 1.8rem;
        }

        .hero-section .lead {
            font-size: 1rem;
        }

        .btn-lg {
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
        }

        .contact-form {
            padding: 1.5rem 1rem;
        }

        .icon-wrapper {
            width: 50px;
            height: 50px;
        }

        .section-header h2 {
            font-size: 1.8rem;
        }
    }

    /* Print Styles */
    @media print {
        .hero-section,
        .btn,
        .map-container,
        .slider-container {
            display: none !important;
        }

        .contact-card {
            break-inside: avoid;
        }
    }

    /* Dark Mode Support */
    @media (prefers-color-scheme: dark) {
        .contact-card {
            background-color: #2d2d2d;
            border-color: rgba(255, 255, 255, 0.1);
        }

        .accordion-item {
            background-color: #2d2d2d;
            border-color: rgba(255, 255, 255, 0.1) !important;
        }

        .accordion-button {
            background-color: #2d2d2d;
            color: #fff;
        }
    }

    /* Accessibility Improvements */
    .btn:focus,
    .form-control:focus,
    .form-select:focus {
        outline: 2px solid var(--primary);
        outline-offset: 2px;
    }

    .contact-card:focus-within {
        outline: 2px solid var(--primary);
        outline-offset: 2px;
    }

    /* Reduced Motion */
    @media (prefers-reduced-motion: reduce) {
        .slider-track {
            animation: none;
        }

        .fade-in,
        .slide-in,
        .scale-up {
            animation: none;
            opacity: 1;
            transform: none;
        }

        .contact-card:hover,
        .btn:hover {
            transform: none;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Enhanced form functionality
    document.addEventListener('DOMContentLoaded', function() {
        const contactForm = document.getElementById('contactForm');
        const submitButton = contactForm.querySelector('button[type="submit"]');
        const spinner = submitButton.querySelector('.spinner-border');

        // Form submission handling
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Add loading state
            submitButton.classList.add('btn-loading');
            spinner.classList.remove('d-none');
            submitButton.innerHTML = '<i class="bi bi-send me-2"></i>Sending... <span class="spinner-border spinner-border-sm ms-2" role="status"></span>';

            // Simulate form submission (replace with actual AJAX call)
            setTimeout(() => {
                // Reset button
                submitButton.classList.remove('btn-loading');
                spinner.classList.add('d-none');
                submitButton.innerHTML = '<i class="bi bi-check-circle me-2"></i>Message Sent!';
                submitButton.classList.remove('btn-primary');
                submitButton.classList.add('btn-success');

                // Show success message
                showNotification('Message sent successfully! We\'ll get back to you soon.', 'success');

                // Reset form after delay
                setTimeout(() => {
                    contactForm.reset();
                    submitButton.innerHTML = '<i class="bi bi-send me-2"></i>Send Message';
                    submitButton.classList.remove('btn-success');
                    submitButton.classList.add('btn-primary');
                }, 3000);

                // In real implementation, submit form data here
                // this.submit();
            }, 2000);
        });

        // Form validation
        const inputs = contactForm.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', validateField);
            input.addEventListener('input', clearValidation);
        });

        function validateField(e) {
            const field = e.target;
            const value = field.value.trim();
            
            // Remove existing validation classes
            field.classList.remove('is-valid', 'is-invalid');
            
            // Check if required field is empty
            if (field.hasAttribute('required') && !value) {
                field.classList.add('is-invalid');
                return false;
            }
            
            // Email validation
            if (field.type === 'email' && value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(value)) {
                    field.classList.add('is-invalid');
                    return false;
                }
            }
            
            // Phone validation
            if (field.type === 'tel' && value) {
                const phoneRegex = /^\+?[\d\s\-\(\)]{10,}$/;
                if (!phoneRegex.test(value)) {
                    field.classList.add('is-invalid');
                    return false;
                }
            }
            
            if (value) {
                field.classList.add('is-valid');
            }
            
            return true;
        }

        function clearValidation(e) {
            const field = e.target;
            field.classList.remove('is-valid', 'is-invalid');
        }
    });

    // Utility functions
    function openLiveChat() {
        showNotification('Live chat feature coming soon! Please use the contact form or call us directly.', 'info');
    }

    function scrollToMap() {
        document.querySelector('.map-container').scrollIntoView({ 
            behavior: 'smooth', 
            block: 'center' 
        });
    }

    function showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        // Add to page
        document.body.appendChild(notification);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 5000);
    }

    // Map interaction enhancement
    document.addEventListener('DOMContentLoaded', function() {
        const mapContainer = document.querySelector('.map-container');
        const mapIframe = mapContainer.querySelector('iframe');
        
        // Add click handler to focus map
        mapContainer.addEventListener('click', function() {
            mapIframe.style.pointerEvents = 'auto';
        });

        // Remove focus when clicking outside
        document.addEventListener('click', function(e) {
            if (!mapContainer.contains(e.target)) {
                mapIframe.style.pointerEvents = 'none';
            }
        });
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Intersection Observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationPlayState = 'running';
            }
        });
    }, observerOptions);

    // Observe all animated elements
    document.querySelectorAll('.fade-in, .slide-in, .scale-up').forEach(el => {
        el.style.animationPlayState = 'paused';
        observer.observe(el);
    });
</script>
@endpush