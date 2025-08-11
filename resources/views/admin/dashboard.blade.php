@extends('layouts.app')

@section('content')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', 'Roboto', sans-serif;
            background: #0a0e27;
            color: #e4e6ea;
            overflow-x: hidden;
        }

        /* Enhanced Sidebar */
        .sidebar {
            min-height: 100vh;
            width: 280px;
            background: linear-gradient(180deg, #1a1d3a 0%, #0f1419 100%);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(99, 102, 241, 0.2);
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.3);
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(99, 102, 241, 0.1);
        }

        .sidebar-header .brand {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .sidebar .nav-pills {
            padding: 1rem 0;
        }

        .sidebar .nav-link {
            color: #9ca3af;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 0.875rem 1.5rem;
            margin: 0.25rem 1rem;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            display: flex;
            align-items: center;
        }

        .sidebar .nav-link:hover {
            background: rgba(99, 102, 241, 0.1);
            color: #e4e6ea;
            transform: translateX(4px);
        }

        .sidebar .nav-link.active {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
        }

        .sidebar .nav-link i {
            margin-right: 12px;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .sidebar .badge {
            margin-left: auto;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }

        /* Main Content */
        .content {
            margin-left: 280px;
            padding: 2rem;
            min-height: 100vh;
            background: linear-gradient(135deg, #0a0e27 0%, #1a1d3a 100%);
        }

        .content h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 2rem;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Enhanced Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .card {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            border: 1px solid rgba(99, 102, 241, 0.1);
            border-radius: 16px;
            padding: 1.5rem;
            color: #e4e6ea;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #6366f1 0%, #8b5cf6 100%);
        }

        .card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(99, 102, 241, 0.2);
            border-color: rgba(99, 102, 241, 0.3);
        }

        .card-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.75rem;
        }

        .card-value {
            font-size: 2.25rem;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .btn-manage {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white;
            border: none;
            padding: 0.625rem 1.25rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-manage:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(99, 102, 241, 0.4);
        }

        /* Notifications Section */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 3rem 0 1.5rem 0;
        }

        .section-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #ffffff;
        }

        .btn-outline-custom {
            border: 2px solid #6366f1;
            color: #6366f1;
            background: transparent;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-custom:hover {
            background: #6366f1;
            color: white;
            transform: translateY(-2px);
        }

        .notification-card {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            border: 1px solid rgba(99, 102, 241, 0.1);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            position: relative;
            transition: all 0.3s ease;
        }

        .notification-card:hover {
            transform: translateX(4px);
            border-color: rgba(99, 102, 241, 0.3);
        }

        .notification-card.unread {
            border-left: 4px solid #06d6a0;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        }

        .notification-card.unread::before {
            content: '';
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 8px;
            height: 8px;
            background: #06d6a0;
            border-radius: 50%;
        }

        /* Enhanced Content Cards */
        .content-card {
            background: linear-gradient(145deg, #1e293b 0%, #0f172a 100%);
            border: 1px solid rgba(99, 102, 241, 0.2);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            position: relative;
        }

        .content-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #6366f1 0%, #8b5cf6 50%, #06d6a0 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .content-card:hover::before {
            opacity: 1;
        }

        .content-card:hover {
            transform: translateY(-12px) rotateX(5deg);
            box-shadow: 0 25px 50px rgba(99, 102, 241, 0.25);
            border-color: rgba(99, 102, 241, 0.4);
        }

        .content-card-body {
            padding: 2rem;
            position: relative;
        }

        .event-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: all 0.5s ease;
            filter: brightness(0.8) contrast(1.1);
        }

        .content-card:hover .event-image {
            transform: scale(1.05);
            filter: brightness(1) contrast(1.2);
        }

        /* Service Cards */
        .service-card {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            border: 1px solid rgba(139, 92, 246, 0.2);
            border-radius: 18px;
            padding: 2rem;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.1) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.4s ease;
            pointer-events: none;
        }

        .service-card:hover::before {
            opacity: 1;
        }

        .service-card:hover {
            transform: translateY(-8px) scale(1.02);
            border-color: rgba(139, 92, 246, 0.4);
            box-shadow: 0 20px 40px rgba(139, 92, 246, 0.2);
        }

        .service-icon {
            font-size: 2.5rem;
            color: #8b5cf6;
            margin-bottom: 1rem;
            display: block;
        }

        /* Event Cards */
        .event-card {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            border: 1px solid rgba(6, 214, 160, 0.2);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s ease;
            position: relative;
        }

        .event-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(6, 214, 160, 0.05) 0%, transparent 50%);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .event-card:hover::after {
            opacity: 1;
        }

        .event-card:hover {
            transform: translateY(-10px);
            border-color: rgba(6, 214, 160, 0.4);
            box-shadow: 0 20px 40px rgba(6, 214, 160, 0.15);
        }

        .event-date-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: linear-gradient(135deg, #06d6a0 0%, #059669 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.875rem;
            z-index: 2;
        }

        .event-slots-indicator {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(6, 214, 160, 0.1);
            color: #06d6a0;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
        }

        /* Coaching Cards */
        .coaching-card {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            border: 1px solid rgba(249, 115, 22, 0.2);
            border-radius: 18px;
            padding: 2rem;
            transition: all 0.4s ease;
            position: relative;
        }

        .coaching-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #f97316 0%, #ea580c 100%);
            border-radius: 18px 18px 0 0;
        }

        .coaching-card:hover {
            transform: translateY(-8px);
            border-color: rgba(249, 115, 22, 0.4);
            box-shadow: 0 20px 40px rgba(249, 115, 22, 0.2);
        }

        .coach-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        /* Message Cards */
        .message-card {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 16px;
            padding: 1.5rem;
            transition: all 0.4s ease;
            position: relative;
        }

        .message-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(180deg, #ef4444 0%, #dc2626 100%);
            border-radius: 0 16px 16px 0;
        }

        .message-card:hover {
            transform: translateX(8px);
            border-color: rgba(239, 68, 68, 0.4);
            box-shadow: 0 12px 30px rgba(239, 68, 68, 0.15);
        }

        .message-status {
            position: absolute;
            top: 1rem;
            right: 1rem;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .message-status.unread {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        .message-status.read {
            background: rgba(6, 214, 160, 0.1);
            color: #06d6a0;
        }

        .message-preview {
            background: rgba(255, 255, 255, 0.05);
            padding: 1rem;
            border-radius: 8px;
            margin: 1rem 0;
            border-left: 3px solid #ef4444;
            font-style: italic;
        }

        /* Enhanced Section Headers */
        .section-header-enhanced {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 4rem 0 2rem 0;
            padding-bottom: 1rem;
            border-bottom: 2px solid rgba(99, 102, 241, 0.1);
        }

        .section-title-enhanced {
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .section-icon {
            font-size: 1.75rem;
            padding: 0.5rem;
            background: rgba(99, 102, 241, 0.1);
            border-radius: 12px;
            color: #6366f1;
        }

        /* Chart Container */
        .chart-container {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            border: 1px solid rgba(99, 102, 241, 0.1);
            padding: 2rem;
            border-radius: 16px;
            margin-top: 3rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .chart-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 1.5rem;
        }

        /* Animations */
        .fade-in {
            opacity: 0;
            animation: fadeIn 0.8s ease-out forwards;
        }

        .slide-in {
            opacity: 0;
            transform: translateY(20px);
            animation: slideIn 0.8s ease-out forwards;
        }

        .fade-in.delay-1 { animation-delay: 0.2s; }
        .slide-in.delay-1 { animation-delay: 0.2s; }
        .slide-in.delay-2 { animation-delay: 0.4s; }
        .slide-in.delay-3 { animation-delay: 0.6s; }

        @keyframes fadeIn {
            to { opacity: 1; }
        }

        @keyframes slideIn {
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .content {
                margin-left: 0;
                padding: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .card-value {
                font-size: 1.875rem;
            }
        }

        /* Buttons */
        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(239, 68, 68, 0.4);
        }

        .btn-custom {
            background: rgba(99, 102, 241, 0.1);
            color: #6366f1;
            border: 1px solid #6366f1;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            background: #6366f1;
            color: white;
            transform: translateY(-2px);
        }

        /* Logout Button */
        .logout-btn {
            margin-top: auto;
            padding: 1rem 1.5rem;
        }

        .logout-btn .nav-link {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .logout-btn .nav-link:hover {
            background: #ef4444;
            color: white;
            transform: translateX(0);
        }
    </style>

    <div class="d-flex">
        <!-- Enhanced Sidebar -->
        <nav class="sidebar d-flex flex-column">
            <div class="sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="brand text-decoration-none">
                    🚀 DevRank Admin
                </a>
            </div>
            <ul class="nav nav-pills flex-column flex-grow-1">
                <li><a href="{{ route('admin.dashboard') }}" class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i>Dashboard</a></li>
                <li><a href="{{ route('admin.users') }}" class="nav-link {{ Route::is('admin.users') ? 'active' : '' }}"><i class="bi bi-people"></i>All Users</a></li>
                <li><a href="{{ route('admin.submissions') }}" class="nav-link {{ Route::is('admin.submissions') ? 'active' : '' }}"><i class="bi bi-file-earmark-text"></i>Code Submissions</a></li>
                <li><a href="{{ route('admin.payments') }}" class="nav-link {{ Route::is('admin.payments') ? 'active' : '' }}"><i class="bi bi-cash-stack"></i>Total Payments</a></li>
                <li><a href="{{ route('admin.contact-messages.index') }}" class="nav-link {{ Route::is('admin.contact-messages.*') ? 'active' : '' }}"><i class="bi bi-envelope"></i>Contact Messages</a></li>
                <li><a href="{{ route('admin.notifications.index') }}" class="nav-link {{ Route::is('admin.notifications.index') ? 'active' : '' }}"><i class="bi bi-bell"></i>Notifications <span class="badge">{{ $unreadNotificationsCount }}</span></a></li>
                <li><a href="{{ route('admin.events.index') }}" class="nav-link {{ Route::is('admin.events.*') ? 'active' : '' }}"><i class="bi bi-calendar-week"></i>Event Bookings</a></li>
                <li><a href="{{ route('admin.coaching.index') }}" class="nav-link {{ Route::is('admin.coaching.*') ? 'active' : '' }}"><i class="bi bi-person-video3"></i>Coaching Sessions</a></li>
                <li><a href="{{ route('admin.services.index') }}" class="nav-link {{ Route::is('admin.services.*') ? 'active' : '' }}"><i class="bi bi-gear"></i>Manage Services</a></li>
                <li class="logout-btn">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-start w-100">
                            <i class="bi bi-box-arrow-right"></i>Logout
                        </button>
                    </form>
                </li>
            </ul>
        </nav>

        <!-- Enhanced Main Content -->
        <div class="content">
            <div class="container-fluid">
                <h1 class="fade-in">Admin Dashboard</h1>

                <a href="{{ route('admin.users.create') }}" class="btn btn-outline-custom mb-4 d-inline-flex align-items-center gap-2 fade-in delay-1">
                    <i class="bi bi-person-plus"></i> <span>Create New User</span>
                </a>

                <!-- Enhanced Stats Grid -->
                <div class="stats-grid">
                    @php
                        $cards = [
                            ['title' => 'Total Users', 'value' => $totalUsers, 'route' => 'admin.users'],
                            ['title' => 'Code Submissions', 'value' => $totalSubmissions, 'route' => 'admin.submissions'],
                            ['title' => 'Pending Reviews', 'value' => $pendingReviews, 'route' => 'admin.submissions'],
                            ['title' => 'Total Payments', 'value' => 'KSH ' . number_format($totalPayments, 2), 'route' => 'admin.payments'],
                            ['title' => 'Unread Messages', 'value' => $pendingMessages, 'route' => 'admin.contact-messages.index'],
                            ['title' => 'Event Bookings', 'value' => $eventRegistrations, 'route' => 'admin.events.index'],
                            ['title' => 'Coaching Bookings', 'value' => $coachingBookings, 'route' => 'admin.coaching.index'],
                            ['title' => 'Manage Services', 'value' => $totalServices ?? 0, 'route' => 'admin.services.index'],
                            ['title' => 'Add New User', 'value' => '+', 'route' => 'admin.users.create'],
                        ];
                    @endphp

                    @foreach($cards as $index => $card)
                        <div class="card slide-in delay-{{ $index % 4 }}">
                            <div class="card-title">{{ $card['title'] }}</div>
                            <div class="card-value">{{ $card['value'] }}</div>
                            <a href="{{ route($card['route']) }}" class="btn btn-manage">Manage</a>
                        </div>
                    @endforeach
                </div>

                <!-- Enhanced Notifications Section -->
                <div class="section-header">
                    <h3 class="section-title fade-in">Notifications</h3>
                </div>
                @if($notifications->isEmpty())
                    <p class="text-white-50 slide-in">No new notifications.</p>
                @else
                    <div class="row g-4">
                        @foreach($notifications as $index => $notification)
                            <div class="col-md-12">
                                <div class="notification-card slide-in delay-{{ $index % 3 }} {{ !$notification->is_read ? 'unread' : '' }}">
                                    <p><strong>{{ ucfirst($notification->type) }}:</strong> {{ $notification->message }}</p>
                                    <p class="text-white-50" style="font-size: 0.9rem;">{{ $notification->created_at->format('F d, Y H:i') }}</p>
                                    @if(!$notification->is_read)
                                        <form action="{{ route('admin.notifications.markAsRead', $notification) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-custom btn-sm">Mark as Read</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Enhanced Services Management Section -->
                <div class="section-header-enhanced">
                    <h3 class="section-title-enhanced">
                        <span class="section-icon"><i class="bi bi-gear-fill"></i></span>
                        Manage Services
                    </h3>
                    <a href="{{ route('admin.services.create') }}" class="btn btn-outline-custom d-inline-flex align-items-center gap-2 fade-in delay-1">
                        <i class="bi bi-plus-circle"></i> <span>Add New Service</span>
                    </a>
                </div>
                @if($services->isEmpty())
                    <div class="empty-state slide-in">
                        <i class="bi bi-gear" style="font-size: 4rem; color: rgba(139, 92, 246, 0.3); margin-bottom: 1rem;"></i>
                        <p class="text-white-50">No services have been created yet.</p>
                    </div>
                @else
                    <div class="row g-4">
                        @foreach($services as $index => $service)
                            <div class="col-lg-4 col-md-6">
                                <div class="service-card slide-in delay-{{ $index % 3 }}">
                                    <div class="service-icon">{{ $service->icon }}</div>
                                    <h5 class="card-title text-white fw-bold mb-3">{{ $service->title }}</h5>
                                    <p class="card-text text-white-50 mb-4">{{ Str::limit($service->description, 120) }}</p>
                                    <div class="d-flex gap-2 mt-auto">
                                        <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-custom btn-sm flex-grow-1">
                                            <i class="bi bi-pencil-square me-1"></i>Edit
                                        </a>
                                        <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Enhanced Events Section -->
                <div class="section-header-enhanced">
                    <h3 class="section-title-enhanced">
                        <span class="section-icon"><i class="bi bi-calendar-event-fill"></i></span>
                        Created Events
                    </h3>
                </div>
                @if($events->isEmpty())
                    <div class="empty-state slide-in">
                        <i class="bi bi-calendar-x" style="font-size: 4rem; color: rgba(6, 214, 160, 0.3); margin-bottom: 1rem;"></i>
                        <p class="text-white-50">No events have been created yet.</p>
                    </div>
                @else
                    <div class="row g-4">
                        @foreach($events as $index => $event)
                            <div class="col-lg-4 col-md-6">
                                <div class="event-card slide-in delay-{{ $index % 3 }}">
                                    @if($event->image)
                                        <div class="position-relative">
                                            <img src="{{ asset('storage/' . $event->image) }}" class="event-image" alt="{{ $event->title }}">
                                            <div class="event-date-badge">
                                                {{ $event->event_date->format('M d') }}
                                            </div>
                                        </div>
                                    @endif
                                    <div class="content-card-body">
                                        <h5 class="card-title text-white fw-bold mb-3">{{ $event->title }}</h5>
                                        <p class="card-text text-white-50 mb-3">{{ Str::limit($event->description, 100) }}</p>
                                        
                                        <div class="d-flex flex-column gap-2 mb-3">
                                            <div class="d-flex align-items-center text-white-50">
                                                <i class="bi bi-calendar3 me-2 text-primary"></i>
                                                <span>{{ $event->event_date->format('Y-m-d') }} at {{ $event->start_time }}</span>
                                            </div>
                                            <div class="event-slots-indicator">
                                                <i class="bi bi-people-fill"></i>
                                                <span>{{ $event->availableSlots() }} slots available</span>
                                            </div>
                                        </div>
                                        
                                        <a href="{{ route('admin.events.show', $event) }}" class="btn btn-custom w-100">
                                            <i class="bi bi-eye me-2"></i>View Event Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Enhanced Coaching Sessions Section -->
                <div class="section-header-enhanced">
                    <h3 class="section-title-enhanced">
                        <span class="section-icon"><i class="bi bi-person-video3"></i></span>
                        Created Coaching Sessions
                    </h3>
                </div>
                @if($coachingSessions->isEmpty())
                    <div class="empty-state slide-in">
                        <i class="bi bi-person-video2" style="font-size: 4rem; color: rgba(249, 115, 22, 0.3); margin-bottom: 1rem;"></i>
                        <p class="text-white-50">No coaching sessions available.</p>
                    </div>
                @else
                    <div class="row g-4">
                        @foreach($coachingSessions as $index => $session)
                            <div class="col-lg-4 col-md-6">
                                <div class="coaching-card slide-in delay-{{ $index % 3 }}">
                                    <div class="coach-avatar">
                                        {{ substr($session->coach->name ?? 'C', 0, 1) }}
                                    </div>
                                    <h5 class="card-title text-white fw-bold mb-2">{{ $session->topic }}</h5>
                                    
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center text-white-50 mb-2">
                                            <i class="bi bi-person-badge me-2 text-warning"></i>
                                            <span><strong>Coach:</strong> {{ $session->coach->name ?? 'N/A' }}</span>
                                        </div>
                                        <div class="d-flex align-items-center text-white-50 mb-2">
                                            <i class="bi bi-calendar-date me-2 text-warning"></i>
                                            <span>{{ $session->session_date->format('Y-m-d') }} at {{ $session->start_time }}</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-people me-2 text-warning"></i>
                                            <span class="text-warning fw-semibold">{{ $session->availableSlots() }} slots available</span>
                                        </div>
                                    </div>
                                    
                                    <a href="{{ route('admin.coaching.index') }}" class="btn btn-custom w-100">
                                        <i class="bi bi-eye me-2"></i>View Details
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Enhanced Contact Messages Section -->
                <div class="section-header-enhanced">
                    <h3 class="section-title-enhanced">
                        <span class="section-icon"><i class="bi bi-envelope-fill"></i></span>
                        Contact Messages
                    </h3>
                    <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-outline-custom d-inline-flex align-items-center gap-2 fade-in delay-1">
                        <i class="bi bi-envelope-open"></i> <span>View All Messages</span>
                    </a>
                </div>
                @if($contactMessages->isEmpty())
                    <div class="empty-state slide-in">
                        <i class="bi bi-envelope-x" style="font-size: 4rem; color: rgba(239, 68, 68, 0.3); margin-bottom: 1rem;"></i>
                        <p class="text-white-50">No contact messages received yet.</p>
                    </div>
                @else
                    <div class="row g-4">
                        @foreach($contactMessages->take(3) as $index => $message)
                            <div class="col-lg-4 col-md-6">
                                <div class="message-card slide-in delay-{{ $index % 3 }}">
                                    <div class="message-status {{ $message->is_read ? 'read' : 'unread' }}">
                                        {{ $message->is_read ? 'Read' : 'Unread' }}
                                    </div>
                                    
                                    <h5 class="card-title text-white fw-bold mb-2">
                                        {{ $message->user ? $message->user->name : $message->name }}
                                    </h5>
                                    
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center text-white-50 mb-2">
                                            <i class="bi bi-envelope me-2 text-danger"></i>
                                            <span>{{ $message->user ? $message->user->email : $message->email }}</span>
                                        </div>
                                        @if($message->company)
                                            <div class="d-flex align-items-center text-white-50 mb-2">
                                                <i class="bi bi-building me-2 text-danger"></i>
                                                <span>{{ $message->company }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="message-preview">
                                        {{ Str::limit($message->message, 80) }}
                                    </div>
                                    
                                    <div class="d-flex gap-2 mt-3">
                                        @if (!$message->is_read)
                                            <form action="{{ route('admin.contact-messages.markAsRead', $message) }}" method="POST" class="flex-grow-1">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-custom btn-sm w-100">
                                                    <i class="bi bi-check-circle me-1"></i>Mark as Read
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.contact-messages.destroy', $message) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Enhanced Chart Section -->
                <div class="chart-container fade-in">
                    <h4 class="chart-title">Platform Performance Overview</h4>
                    <canvas id="adminChart" height="80"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('adminChart').getContext('2d');
        
        // Create sophisticated gradient
        const gradient1 = ctx.createLinearGradient(0, 0, 0, 400);
        gradient1.addColorStop(0, 'rgba(99, 102, 241, 0.8)');
        gradient1.addColorStop(1, 'rgba(139, 92, 246, 0.2)');
        
        const gradient2 = ctx.createLinearGradient(0, 0, 0, 400);
        gradient2.addColorStop(0, 'rgba(6, 214, 160, 0.8)');
        gradient2.addColorStop(1, 'rgba(6, 214, 160, 0.2)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Submissions', 'Pending Reviews', 'Event Bookings', 'Coaching Bookings', 'Services', 'Messages'],
                datasets: [{
                    label: 'Current Stats',
                    data: [
                        {{ $totalSubmissions }},
                        {{ $pendingReviews }},
                        {{ $eventRegistrations }},
                        {{ $coachingBookings }},
                        {{ $totalServices ?? 0 }},
                        {{ $pendingMessages }}
                    ],
                    borderColor: '#6366f1',
                    backgroundColor: gradient1,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#6366f1',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                }, {
                    label: 'Target Goals',
                    data: [
                        {{ $totalSubmissions + 10 }},
                        {{ max($pendingReviews - 5, 0) }},
                        {{ $eventRegistrations + 15 }},
                        {{ $coachingBookings + 8 }},
                        {{ ($totalServices ?? 0) + 3 }},
                        {{ max($pendingMessages - 2, 0) }}
                    ],
                    borderColor: '#06d6a0',
                    backgroundColor: gradient2,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#06d6a0',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    borderDash: [5, 5],
                }]
            },
            options: {
                responsive: true,
                animation: {
                    duration: 2000,
                    easing: 'easeInOutCubic'
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            color: '#e4e6ea',
                            font: {
                                size: 14,
                                weight: '600'
                            },
                            padding: 20
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(30, 41, 59, 0.95)',
                        titleColor: '#6366f1',
                        bodyColor: '#e4e6ea',
                        borderColor: '#6366f1',
                        borderWidth: 1,
                        cornerRadius: 8,
                        padding: 12,
                        displayColors: true,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(99, 102, 241, 0.1)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#9ca3af',
                            font: {
                                size: 12
                            },
                            padding: 8
                        },
                        border: {
                            display: false
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(99, 102, 241, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#9ca3af',
                            font: {
                                size: 12
                            },
                            padding: 8,
                            maxRotation: 45
                        },
                        border: {
                            display: false
                        }
                    }
                },
                elements: {
                    point: {
                        hoverBorderWidth: 3
                    }
                }
            }
        });

        // Add smooth scrolling and enhanced animations
        document.addEventListener('DOMContentLoaded', function() {
            // Stagger animation delays for better visual flow
            const slideElements = document.querySelectorAll('.slide-in');
            slideElements.forEach((element, index) => {
                element.style.animationDelay = `${index * 0.1}s`;
            });

            // Add hover effects to cards
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px) scale(1.02)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Enhanced notification interactions
            const notificationCards = document.querySelectorAll('.notification-card');
            notificationCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(8px)';
                    this.style.boxShadow = '0 12px 30px rgba(99, 102, 241, 0.15)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateX(0)';
                    this.style.boxShadow = 'none';
                });
            });

            // Smooth scrolling for internal links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });

        // Add loading state management
        window.addEventListener('beforeunload', function() {
            document.body.style.opacity = '0.7';
        });

        // Chart animation on scroll
        const observerOptions = {
            threshold: 0.3,
            rootMargin: '0px 0px -50px 0px'
        };

        const chartObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        const chartContainer = document.querySelector('.chart-container');
        if (chartContainer) {
            chartContainer.style.opacity = '0';
            chartContainer.style.transform = 'translateY(30px)';
            chartContainer.style.transition = 'all 0.8s ease-out';
            chartObserver.observe(chartContainer);
        }
    </script>
@endsection