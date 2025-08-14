@extends('layouts.app')

@section('content')
<style>
    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(-45deg, #0f2027, #203a43, #2c5364, #0f2027);
        background-size: 400% 400%;
        animation: gradientShift 15s ease infinite;
        color: #fff;
        min-height: 100vh;
        padding: 40px 0;
    }

    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .content {
        max-width: 900px;
        margin: auto;
        padding: 20px;
        animation: fadeIn 0.8s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Card container */
    .card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(12px);
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.4);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.5);
    }

    /* Titles */
    h1 {
        font-weight: 700;
        text-align: center;
        margin-bottom: 25px;
        color: #fff;
    }

    /* Form inputs */
    .form-control,
    .form-select {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: #fff;
        border-radius: 12px;
        padding: 10px 15px;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        background: rgba(255, 255, 255, 0.2);
        border-color: #00ddeb;
        box-shadow: 0 0 8px rgba(0, 221, 235, 0.6);
    }

    label {
        font-weight: 600;
        margin-bottom: 6px;
        color: #d1d1d1;
    }

    /* FAQ Items */
    .faq-item {
        background: rgba(255,255,255,0.05);
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
        animation: slideIn 0.4s ease-in-out;
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateX(-15px); }
        to { opacity: 1; transform: translateX(0); }
    }

    /* Buttons */
    .btn-custom {
        background: linear-gradient(90deg, #00ddeb, #007bff);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 12px 20px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-custom:hover {
        background: linear-gradient(90deg, #007bff, #00ddeb);
        transform: translateY(-2px);
    }

    /* Alert styling */
    .alert {
        border-radius: 10px;
        padding: 15px;
        background: rgba(255, 75, 75, 0.85);
        border: none;
        color: #fff;
    }

    /* Image preview */
    .event-image-preview {
        max-width: 150px;
        border-radius: 8px;
        margin-bottom: 10px;
        border: 2px solid rgba(255,255,255,0.15);
    }

</style>

<div class="content">
    <h1>Edit Event</h1>
    <div class="card">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label>Event Title</label>
                <input type="text" name="title" class="form-control" required value="{{ old('title', $event->title) }}">
            </div>

            <div class="mb-4">
                <label>Event Description</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description', $event->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label>Event Agenda</label>
                <textarea name="agenda" class="form-control" rows="4">{{ old('agenda', $event->agenda) }}</textarea>
            </div>

            <div class="mb-4">
                <label>About Event</label>
                <textarea name="about" class="form-control" rows="4">{{ old('about', $event->about) }}</textarea>
            </div>

            <div class="mb-4">
                <label>Event FAQs</label>
                <div id="faq-container">
                    @php
                        $faqs = old('faqs', $event->faqs ? json_decode($event->faqs, true) : []);
                        if(empty($faqs)) {
                            $faqs = [['question' => '', 'answer' => '']];
                        }
                    @endphp
                    @foreach($faqs as $index => $faq)
                        <div class="faq-item">
                            <input type="text" name="faqs[{{ $index }}][question]" class="form-control mb-2" placeholder="Question" value="{{ $faq['question'] ?? '' }}">
                            <textarea name="faqs[{{ $index }}][answer]" class="form-control" rows="3" placeholder="Answer">{{ $faq['answer'] ?? '' }}</textarea>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-custom mt-2" onclick="addFaq()">+ Add Another FAQ</button>
            </div>

            <div class="mb-4">
                <label>Event Location</label>
                <input type="text" name="location" class="form-control" value="{{ old('location', $event->location) }}">
            </div>

            <div class="mb-4">
                <label>Event Image</label>
                @if($event->image)
                    <div>
                        <img src="{{ asset('storage/' . $event->image) }}" class="event-image-preview" alt="Event Image">
                    </div>
                @endif
                <input type="file" name="image" class="form-control" accept="image/*">
                <small class="text-muted">Upload a new image to replace the existing one.</small>
            </div>

            <div class="mb-4">
                <label>Event Date</label>
                <input type="date" name="event_date" class="form-control" required value="{{ old('event_date', $event->event_date->format('Y-m-d')) }}">
            </div>

            <div class="mb-4">
                <label>Start Time</label>
                <input type="time" name="start_time" class="form-control" required value="{{ old('start_time', $event->start_time) }}">
            </div>

            <div class="mb-4">
                <label>Capacity</label>
                <input type="number" name="capacity" class="form-control" required min="1" value="{{ old('capacity', $event->capacity) }}">
            </div>

            <div class="mb-4">
                <label>Price (KES)</label>
                <input type="number" name="amount" class="form-control" required min="0" step="0.01" value="{{ old('amount', $event->amount) }}">
            </div>

            <div class="mb-4">
                <label>Status</label>
                <select name="status" class="form-select">
                    <option value="upcoming" {{ old('status', $event->status) == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                    <option value="completed" {{ old('status', $event->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ old('status', $event->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <button type="submit" class="btn btn-custom w-100">Update Event</button>
        </form>
    </div>
</div>

<script>
    let faqIndex = {{ count($faqs) }};
    function addFaq() {
        const container = document.getElementById('faq-container');
        const faqItem = document.createElement('div');
        faqItem.className = 'faq-item';
        faqItem.innerHTML = `
            <input type="text" name="faqs[${faqIndex}][question]" class="form-control mb-2" placeholder="Question">
            <textarea name="faqs[${faqIndex}][answer]" class="form-control" rows="3" placeholder="Answer"></textarea>
        `;
        container.appendChild(faqItem);
        faqIndex++;
    }
</script>
@endsection
