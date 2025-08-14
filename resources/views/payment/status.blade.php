@extends('layouts.app')

@section('title', 'DevRank - Payment Status')

@push('styles')
<style>
    :root {
        --primary: #4facfe;
        --primary-dark: #00f2fe;
        --glass-bg: rgba(255, 255, 255, 0.1);
        --glass-border: rgba(255, 255, 255, 0.2);
    }

    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        color: #fff;
    }

    .card {
        background: linear-gradient(145deg, var(--glass-bg), rgba(255, 255, 255, 0.05));
        backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        border-radius: 16px;
        overflow: hidden;
        padding: 20px;
        text-align: center;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border: none;
        font-weight: 700;
        border-radius: 12px;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--primary-dark), var(--primary));
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(79, 172, 254, 0.4);
    }

    .toast {
        position: fixed;
        top: 20px;
        right: 20px;
        min-width: 250px;
        background: linear-gradient(145deg, var(--glass-bg), rgba(255, 255, 255, 0.05));
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 12px;
        padding: 15px;
        color: #fff;
        font-weight: 500;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        opacity: 0;
        transform: translateY(-20px);
        transition: opacity 0.5s, transform 0.5s;
        z-index: 1000;
    }

    .toast.show {
        opacity: 1;
        transform: translateY(0);
    }

    .toast.success {
        border-left: 4px solid #28a745;
    }

    .slide-in {
        opacity: 0;
        transform: translateY(30px);
        animation: slideIn 0.8s forwards;
    }

    @keyframes slideIn {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card slide-in">
                <h3 class="mb-3">Payment Status</h3>

                @if ($payment->status === 'completed')
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> Payment was successful!
                    </div>
                    <p>You will be redirected to the dashboard in <span id="countdown">5</span> seconds.</p>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary mt-2">Go to Dashboard Now</a>
                @elseif ($payment->status === 'failed')
                    <div class="alert alert-danger">
                        <i class="fas fa-times-circle"></i> Payment failed. Please try again.
                    </div>
                    <a href="{{ route('coaching.book.form', $payment->coaching_session_id) }}" class="btn btn-outline-light mt-2">Try Again</a>
                @else
                    <div class="alert alert-info">
                        <div class="spinner-border text-light" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        Waiting for payment confirmation...
                    </div>
                    <p>Amount: KES {{ number_format($payment->amount, 2) }}</p>
                    <p>Session: {{ $payment->coachingSession->title ?? 'N/A' }}</p>
                    <p>Please complete the payment by entering your M-Pesa PIN on your phone.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div id="payment-toast" class="toast success">
    <i class="fas fa-check-circle toast-icon"></i>
    <span class="toast-message">Thank you for your payment!</span>
</div>

@push('scripts')
<script>
function showToast(message, duration = 3000) {
    const toast = document.getElementById('payment-toast');
    toast.querySelector('.toast-message').textContent = message;
    toast.style.display = 'block';
    toast.classList.add('show');

    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => { toast.style.display = 'none'; }, 500);
    }, duration);
}

@if ($payment->status === 'completed')
    showToast('Payment successful!');
    let countdown = 5;
    const countdownElement = document.getElementById('countdown');
    const interval = setInterval(() => {
        countdown--;
        countdownElement.textContent = countdown;
        if (countdown <= 0) {
            clearInterval(interval);
            window.location.href = '{{ route('dashboard') }}';
        }
    }, 1000);
@elseif ($payment->status === 'pending')
    function checkPaymentStatus(paymentId) {
        fetch('{{ route('payment.status.check', $payment) }}', {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'completed') {
                // Update card to show success
                const card = document.querySelector('.card');
                card.innerHTML = `
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> Payment was successful!
                    </div>
                    <p>You will be redirected to the dashboard in <span id="countdown">5</span> seconds.</p>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary mt-2">Go to Dashboard Now</a>
                `;
                showToast('Payment successful!');
                let countdown = 5;
                const countdownElement = document.getElementById('countdown');
                const interval = setInterval(() => {
                    countdown--;
                    countdownElement.textContent = countdown;
                    if (countdown <= 0) {
                        clearInterval(interval);
                        window.location.href = '{{ route('dashboard') }}';
                    }
                }, 1000);
            } else if (data.status === 'failed') {
                window.location.reload();
            } else {
                setTimeout(() => checkPaymentStatus(paymentId), 5000);
            }
        })
        .catch(() => setTimeout(() => checkPaymentStatus(paymentId), 5000));
    }
    checkPaymentStatus({{ $payment->id }});
@endif
</script>
@endpush
@endsection
