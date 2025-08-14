@extends('layouts.app')

@section('content')
<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
        color: #fff;
    }
    .content {
        padding: 40px;
    }
    .card {
        background: linear-gradient(135deg, #1e3c72, #2a5298);
        color: white;
        border: none;
        border-radius: 15px;
        box-shadow: 0 8px 16px rgba(0,0,0,0.4);
        transition: all 0.3s ease-in-out;
        position: relative;
    }
    .card:hover {
        transform: translateY(-8px) scale(1.02);
    }
    .btn-custom {
        background-color: rgba(255, 255, 255, 0.1);
        color: #fff;
        border: none;
    }
    .btn-custom:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }
    .btn-create {
        margin-bottom: 20px;
        float: right;
    }
    .developer-type-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 0.8rem;
    }
    .badge-fresher {
        background-color: #007bff !important;
    }
    .badge-professional {
        background-color: #28a745 !important;
    }
</style>

<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-white fw-bold">Coaching Sessions</h1>
        <a href="{{ route('admin.coaching.create') }}" class="btn btn-custom btn-create">
            + Create Coaching Session
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($sessions->isEmpty())
        <p>No coaching sessions available yet.</p>
    @else
        <!-- Filter Buttons -->
        <div class="mb-4">
            <button class="btn btn-outline-light me-2 filter-btn active" data-filter="all">All Sessions</button>
            <button class="btn btn-outline-light me-2 filter-btn" data-filter="fresher">Fresher Developer</button>
            <button class="btn btn-outline-light me-2 filter-btn" data-filter="professional">Professional Developer</button>
        </div>

        <div class="row g-4">
            @foreach($sessions as $session)
                <div class="col-md-4 session-card" data-type="{{ $session->developer_type ?? 'fresher' }}">
                    <div class="card p-3">
                        <span class="badge developer-type-badge badge-{{ $session->developer_type ?? 'fresher' }}">
                            {{ ucfirst($session->developer_type ?? 'fresher') }} Level
                        </span>
                        <h5 class="card-title">{{ $session->topic }}</h5>
                        <p><strong>Description:</strong> {{ Str::limit($session->description, 100) ?? 'N/A' }}</p>
                        <p><strong>Type:</strong> {{ $session->type ?? 'N/A' }}</p>
                        <p><strong>Developer Level:</strong> 
                            <span class="badge badge-{{ $session->developer_type ?? 'fresher' }}">
                                {{ ucfirst($session->developer_type ?? 'fresher') }} Developer
                            </span>
                        </p>
                        <p><strong>Coach:</strong> {{ $session->coach->name ?? 'Not Assigned' }}</p>
                        <p><strong>Date:</strong> {{ $session->session_date->format('F d, Y') }}</p>
                        <p><strong>Price:</strong> {{ number_format($session->amount, 2) }} KES</p>
                        <p><strong>Capacity:</strong> {{ $session->capacity }}</p>
                        <p><strong>Time:</strong> {{ $session->start_time }}</p>
                        <p><strong>Available Slots:</strong> {{ $session->availableSlots() }}</p>
                        <span class="badge bg-light text-dark">{{ ucfirst($session->status) }}</span>

                        <a href="{{ route('coaching.show', $session) }}" class="btn btn-custom btn-sm mt-2 me-2">View Details</a>

                        @if(auth()->user()->role === 'admin')
    <a href="{{ route('admin.coaching.edit', $session) }}" class="btn btn-warning btn-sm mt-2">
        Edit
    </a>

    <form action="{{ route('admin.coaching.destroy', $session) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this session?');" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm mt-2">
            Delete
        </button>
    </form>
@endif

                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.filter-btn');
        const sessionCards = document.querySelectorAll('.session-card');

        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                const filter = this.getAttribute('data-filter');
                
                // Update active button
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                // Filter sessions
                sessionCards.forEach(card => {
                    const cardType = card.getAttribute('data-type');
                    if (filter === 'all' || cardType === filter) {
                        card.style.display = 'block';
                        card.style.animation = 'fadeIn 0.5s ease-in';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    });
</script>

<style>
    .filter-btn.active {
        background-color: rgba(255, 255, 255, 0.2);
        border-color: #fff;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush
@endsection
