@extends('layouts.app')

@section('content')
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            min-height: 100vh;
        }
        
        .content {
            padding: 2rem;
            min-height: 100vh;
        }
        
        .main-card {
            background: linear-gradient(145deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05));
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 24px;
            box-shadow: 
                0 8px 32px rgba(0,0,0,0.3),
                inset 0 1px 0 rgba(255,255,255,0.2);
            position: relative;
            overflow: hidden;
        }
        
        .main-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4, #ffeaa7);
            background-size: 300% 100%;
            animation: gradientShift 3s ease infinite;
        }
        
        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .back-btn {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
        }
        
        .back-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.6);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }
        
        .developer-type-badge {
            position: absolute;
            top: 2rem;
            right: 2rem;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            z-index: 2;
        }
        
        .badge-fresher {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: 2px solid rgba(255,255,255,0.3);
        }
        
        .badge-professional {
            background: linear-gradient(135deg, #f093fb, #f5576c);
            color: white;
            border: 2px solid rgba(255,255,255,0.3);
        }
        
        .session-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin: 1.5rem 0 2rem;
            background: linear-gradient(135deg, #fff, #e0e7ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 0 30px rgba(255,255,255,0.5);
        }
        
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }
        
        .stat-card {
            background: linear-gradient(145deg, rgba(255,255,255,0.15), rgba(255,255,255,0.05));
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1);
            border-radius: 20px;
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 15px 40px rgba(0,0,0,0.3);
        }
        
        .stat-card:hover::before {
            opacity: 1;
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: 900;
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }
        
        .session-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }
        
        .info-item {
            background: linear-gradient(145deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05));
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 16px;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }
        
        .info-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            border-color: rgba(255,255,255,0.4);
        }
        
        .info-item i {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 1.4rem;
            margin-right: 0.75rem;
        }
        
        .info-item strong {
            color: #fff;
            font-weight: 700;
        }
        
        .info-item span {
            color: rgba(255,255,255,0.85);
            font-weight: 500;
        }
        
        .status-badge {
            padding: 0.6rem 1.2rem;
            border-radius: 50px;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
            display: inline-block;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        
        .status-upcoming { 
            background: linear-gradient(135deg, #11998e, #38ef7d);
            color: white;
        }
        .status-completed { 
            background: linear-gradient(135deg, #bdc3c7, #2c3e50);
            color: white;
        }
        .status-cancelled { 
            background: linear-gradient(135deg, #ff416c, #ff4b2b);
            color: white;
        }
        
        .bookings-section {
            background: linear-gradient(145deg, rgba(255,255,255,0.08), rgba(255,255,255,0.02));
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 2rem;
            margin-top: 2rem;
        }
        
        .bookings-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }
        
        .bookings-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
            margin: 0;
        }
        
        .bookings-title i {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-right: 0.5rem;
        }
        
        .fill-percentage {
            background: linear-gradient(135deg, rgba(255,255,255,0.15), rgba(255,255,255,0.05));
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .booking-item {
            background: linear-gradient(145deg, rgba(255,255,255,0.08), rgba(255,255,255,0.02));
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .booking-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s ease;
        }
        
        .booking-item:hover {
            background: linear-gradient(145deg, rgba(255,255,255,0.12), rgba(255,255,255,0.06));
            transform: translateX(8px) translateY(-2px);
            border-color: rgba(255,255,255,0.3);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }
        
        .booking-item:hover::before {
            left: 100%;
        }
        
        .booking-name {
            font-size: 1.2rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 0.5rem;
        }
        
        .booking-name i {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-right: 0.5rem;
        }
        
        .booking-email {
            color: rgba(255,255,255,0.8);
            margin-bottom: 1rem;
        }
        
        .booking-email i {
            color: rgba(255,255,255,0.6);
            margin-right: 0.5rem;
        }
        
        .booking-question {
            background: rgba(255,255,255,0.05);
            border-left: 4px solid #4facfe;
            padding: 1rem;
            border-radius: 0 8px 8px 0;
            margin-top: 1rem;
        }
        
        .question-label {
            color: #4facfe;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .question-text {
            color: rgba(255,255,255,0.9);
            font-style: italic;
            line-height: 1.5;
        }
        
        .booking-number {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: linear-gradient(135deg, rgba(255,255,255,0.2), rgba(255,255,255,0.1));
            color: rgba(255,255,255,0.7);
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .empty-bookings {
            text-align: center;
            padding: 4rem 2rem;
        }
        
        .empty-bookings i {
            font-size: 4rem;
            background: linear-gradient(135deg, rgba(255,255,255,0.3), rgba(255,255,255,0.1));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1.5rem;
        }
        
        .empty-bookings h4 {
            color: #fff;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .empty-bookings p {
            color: rgba(255,255,255,0.7);
            font-size: 1.1rem;
        }
        
        .admin-info {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255,255,255,0.2);
        }
        
        .admin-info .row > div {
            margin-bottom: 1rem;
        }
        
        .admin-info p {
            margin-bottom: 0.5rem;
            color: rgba(255,255,255,0.8);
        }
        
        .admin-info strong {
            color: #fff;
            font-weight: 700;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .content {
                padding: 1rem;
            }
            
            .developer-type-badge {
                position: relative;
                top: auto;
                right: auto;
                display: inline-block;
                margin-bottom: 1rem;
            }
            
            .session-title {
                font-size: 2rem;
                margin-top: 2rem;
            }
            
            .stats-container {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .session-info {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .bookings-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .booking-number {
                position: relative;
                top: auto;
                right: auto;
                display: inline-block;
                margin-bottom: 1rem;
            }
        }
    </style>

    <div class="content">
        <div class="container-fluid">
            <a href="{{ auth()->user()->role === 'admin' ? route('admin.coaching.index') : route('coaching.index') }}" class="back-btn mb-4 d-inline-flex align-items-center">
                <i class="bi bi-arrow-left-circle me-2"></i> Back to Sessions
            </a>

            <div class="main-card p-4">
                <span class="developer-type-badge badge-{{ $session->developer_type ?? 'fresher' }}">
                    <i class="bi bi-{{ $session->developer_type === 'professional' ? 'briefcase' : 'code-slash' }} me-2"></i>
                    {{ ucfirst($session->developer_type ?? 'fresher') }} Level
                </span>

                <h1 class="session-title">{{ $session->topic }}</h1>

                <!-- Stats Cards -->
                <div class="stats-container">
                    <div class="stat-card">
                        <div class="stat-number">{{ $session->capacity ?? $session->max_students ?? 'N/A' }}</div>
                        <div class="stat-label">Total Capacity</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ $session->bookings->count() }}</div>
                        <div class="stat-label">Students Booked</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ $session->availableSlots() }}</div>
                        <div class="stat-label">Available Slots</div>
                    </div>
                </div>

                <!-- Session Information Grid -->
                <div class="session-info">
                    <div class="info-item">
                        <i class="bi bi-card-text"></i>
                        <strong>Description:</strong><br>
                        <span>{{ $session->description ?? 'No description provided' }}</span>
                    </div>
                    
                    <div class="info-item">
                        <i class="bi bi-tag"></i>
                        <strong>Type:</strong><br>
                        <span>{{ $session->type ?? 'General Coaching' }}</span>
                    </div>
                    
                    <div class="info-item">
                        <i class="bi bi-person-circle"></i>
                        <strong>Coach:</strong><br>
                        <span>{{ $session->coach->name ?? 'Not Assigned' }}</span>
                    </div>
                    
                    <div class="info-item">
                        <i class="bi bi-calendar-event"></i>
                        <strong>Date:</strong><br>
                        <span>{{ $session->session_date->format('F d, Y') }}</span>
                    </div>
                    
                    <div class="info-item">
                        <i class="bi bi-clock"></i>
                        <strong>Time:</strong><br>
                        <span>{{ \Carbon\Carbon::parse($session->start_time)->format('h:i A') }}</span>
                    </div>
                    
                    <div class="info-item">
                        <i class="bi bi-info-circle"></i>
                        <strong>Status:</strong><br>
                        <span class="status-badge status-{{ $session->status }}">{{ $session->status }}</span>
                    </div>
                </div>

                <!-- Bookings Section -->
                <div class="bookings-section">
                    <div class="bookings-header">
                        <h5 class="bookings-title">
                            <i class="bi bi-people-fill"></i>Students Booked ({{ $session->bookings->count() }})
                        </h5>
                        @if($session->bookings->count() > 0)
                            <div class="fill-percentage">
                                <i class="bi bi-graph-up me-1"></i>
                                {{ number_format(($session->bookings->count() / ($session->capacity ?? $session->max_students ?? 1)) * 100, 1) }}% filled
                            </div>
                        @endif
                    </div>

                    @if($session->bookings && $session->bookings->count())
                        <div class="bookings-container">
                            @foreach($session->bookings as $index => $booking)
                                <div class="booking-item">
                                    <div class="booking-number">
                                        <i class="bi bi-hash"></i>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                    </div>
                                    
                                    <h6 class="booking-name">
                                        <i class="bi bi-person-badge"></i>{{ $booking->full_name }}
                                    </h6>
                                    
                                    <p class="booking-email">
                                        <i class="bi bi-envelope"></i>{{ $booking->email }}
                                    </p>
                                    
                                    @if($booking->question)
                                        <div class="booking-question">
                                            <div class="question-label">
                                                <i class="bi bi-question-circle me-1"></i>Question:
                                            </div>
                                            <div class="question-text">
                                                "{{ $booking->question }}"
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-bookings">
                            <i class="bi bi-people d-block"></i>
                            <h4>No Students Booked Yet</h4>
                            <p>This session is waiting for its first participants.</p>
                            <p>Share this session to encourage more bookings!</p>
                        </div>
                    @endif
                </div>

                @if(auth()->user()->role === 'admin')
                    <div class="admin-info">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Created By:</strong> {{ $session->creator->name ?? $session->user->name ?? 'System' }}</p>
                                <p><strong>Created At:</strong> {{ $session->created_at->format('F d, Y h:i A') }}</p>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <p><strong>Session ID:</strong> #{{ $session->id }}</p>
                                <p><strong>Last Updated:</strong> {{ $session->updated_at->format('F d, Y h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection