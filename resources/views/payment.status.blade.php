@extends('layouts.app')

@section('title', 'DevRank - Payment Status')

@section('content')
<div class="container py-5">
    <div class="card bg-gradient-glass border-0 rounded-4 shadow-lg slide-in" style="max-width: 600px; margin: 0 auto;">
        <div class="card-body p-5 text-center">
            <div class="mb-4">
                <i class="bi bi-hourglass-split display-4 text-primary"></i>
            </div>
            <h3 class="fw-bold text-white mb-3">Payment Processing</h3>
            <p class="text-white-75 mb-4">
                Your payment request for KSH {{ number_format($payment->amount, 2) }} is being processed. Please complete the M-Pesa STK push on your phone.
            </p>
            <p class="text-white-50">
                Transaction ID: {{ $payment->transaction_id }}
            </p>
            <div class="mt-5">
                <a href="{{ route('payment.status', $payment->transaction_id) }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-arrow-repeat me-2"></i>Check Status
                </a>
                <a href="{{ route('events.index') }}" class="btn btn-outline-light btn-lg mt-3">
                    <i class="bi bi-arrow-left me-2"></i>Back to Events
                </a>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    :root {
        --primary: #4facfe;
        --primary-dark: #00f2fe;
        --glass-bg: rgba(255, 255, 255, 0.1);
        --glass-border: rgba(255, 255, 255, 0.2);
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        color: #fff;
    }

    .card {
        background: linear-gradient(145deg, var(--glass-bg), rgba(255, 255, 255, 0.05));
        backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        box-shadow: 
            0 8px 32px rgba(0, 0, 0, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
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
        background: linear-gradient(90deg, #4facfe, #00f2fe, #4facfe);
        background-size: 200% 100%;
        animation: shimmer 2s ease-in-out infinite;
    }

    @keyframes shimmer {
        0%, 100% { background-position: -200% 0; }
        50% { background-position: 200% 0; }
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border: none;
        font-weight: 700;
        border-radius: 12px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--primary-dark), var(--primary));
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(79, 172, 254, 0.4);
    }

    .btn-outline-light {
        border: 2px solid rgba(255, 255, 255, 0.4);
        color: rgba(255, 255, 255, 0.9);
        font-weight: 600;
        border-radius: 12px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(10px);
    }

    .btn-outline-light:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: #fff;
        color: #fff;
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    .text-white-75 {
        color: rgba(255, 255, 255, 0.75);
    }

    .text-white-50 {
        color: rgba(255, 255, 255, 0.5);
    }

    .slide-in {
        opacity: 0;
        transform: translateY(30px);
        animation: slideIn 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }

    @keyframes slideIn {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush
@endsection