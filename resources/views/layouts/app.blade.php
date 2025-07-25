<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="DevRank - Empowering student developers with project evaluations and coaching.">
    <meta name="keywords" content="DevRank, student developers, project evaluation, coding feedback, coaching">
    <meta name="author" content="DevRank Team">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'DevRank')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        .hero-section {
            background: linear-gradient(135deg, #343a40, #6c757d);
            color: white;
            padding: 5rem 0;
        }
        .feature-card {
            transition: transform 0.3s;
        }
        .feature-card:hover {
            transform: translateY(-10px);
        }
        html {
            scroll-behavior: smooth;
        }
    </style>

    <!-- Extra Styles from Child Views -->
    @stack('styles')
</head>
<body>

    <!-- Navbar -->
    @include('layouts.navigation')

    <!-- Page Heading (optional) -->
    @hasSection('header')
        <header class="bg-white shadow-sm mb-4">
            <div class="container py-4">
                @yield('header')
            </div>
        </header>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- ─────── Footer ─────── -->
    <footer class="bg-dark text-white pt-4">
        <div class="container">
            <div class="row">
                <!-- About -->
                <div class="col-md-4 mb-3">
                    <h5>About DevRank</h5>
                    <p>We empower student developers with structured project reviews, personalized coaching, and expert feedback.</p>
                </div>
                <!-- Quick Links -->
                <div class="col-md-4 mb-3">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('about') }}" class="text-white-50 text-decoration-none">About Us</a></li>
                        <li><a href="{{ route('services') }}" class="text-white-50 text-decoration-none">Services</a></li>
                        <li><a href="{{ route('contact') }}" class="text-white-50 text-decoration-none">Contact</a></li>
                    </ul>
                </div>
                <!-- Connect With Us -->
                <div class="col-md-4 mb-3">
                    <h5>Connect With Us</h5>
                    <a href="#" class="text-white me-3" aria-label="Facebook"><i class="bi bi-facebook fs-4"></i></a>
                    <a href="#" class="text-white me-3" aria-label="Twitter"><i class="bi bi-twitter fs-4"></i></a>
                    <a href="#" class="text-white" aria-label="LinkedIn"><i class="bi bi-linkedin fs-4"></i></a>
                </div>
            </div>
            <div class="text-center py-3 border-top border-secondary">
                <small>&copy; {{ date('Y') }} DevRank. All rights reserved.</small>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Extra Scripts from Child Views -->
    @stack('scripts')

</body>
</html>
