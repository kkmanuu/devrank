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

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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
    </style>
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

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4 mt-5">
        <div class="container">
            <p>&copy; {{ date('Y') }} DevRank. All rights reserved.</p>
            <p>
                <a href="{{ route('about') }}" class="text-white">About</a> |
                <a href="{{ route('services') }}" class="text-white">Services</a> |
                <a href="{{ route('contact') }}" class="text-white">Contact</a>

            </p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
