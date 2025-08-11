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
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .content {
            padding: 40px;
            max-width: 800px;
            margin: 0 auto;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            border-radius: 20px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.5);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-10px) scale(1.03);
            box-shadow: 0 15px 30px rgba(0,0,0,0.6);
        }

        .form-control, .form-select {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.2);
            color: #fff;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255,255,255,0.25);
            color: #fff;
            border-color: #00ddeb;
            box-shadow: 0 0 10px rgba(0,221,235,0.5);
        }

        .btn-custom {
            background: linear-gradient(90deg, #00ddeb, #007bff);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            background: linear-gradient(90deg, #007bff, #00ddeb);
            transform: translateY(-2px);
        }

        .faq-item {
            margin-bottom: 20px;
            animation: slideIn 0.5s ease-in-out;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .alert {
            border-radius: 10px;
            background: rgba(255,75,75,0.8);
        }
    </style>

    <div class="content">
        <h1 class="mb-5 text-white fw-bold text-center">Create Event</h1>
        <div class="card p-5 mx-auto">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="title" class="form-label">Event Title</label>
                    <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
                </div>
                <div class="mb-4">
                    <label for="description" class="form-label">Event Description</label>
                    <textarea name="description" class="form-control" rows="5">{{ old('description') }}</textarea>
                </div>
                <div class="mb-4">
                    <label for="agenda" class="form-label">Event Agenda</label>
                    <textarea name="agenda" class="form-control" rows="5">{{ old('agenda') }}</textarea>
                </div>
                <div class="mb-4">
                    <label for="about" class="form-label">About Event</label>
                    <textarea name="about" class="form-control" rows="5">{{ old('about') }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="form-label">Event FAQs</label>
                    <div id="faq-container">
                        <div class="faq-item">
                            <input type="text" name="faqs[0][question]" class="form-control mb-2" placeholder="Question" value="{{ old('faqs.0.question') }}">
                            <textarea name="faqs[0][answer]" class="form-control" rows="3" placeholder="Answer">{{ old('faqs.0.answer') }}</textarea>
                        </div>
                    </div>
                    <button type="button" class="btn btn-custom mt-3" onclick="addFaq()">Add Another FAQ</button>
                </div>
                <div class="mb-4">
                    <label for="location" class="form-label">Event Location</label>
                    <input type="text" name="location" class="form-control" value="{{ old('location') }}">
                </div>
                <div class="mb-4">
                    <label for="image" class="form-label">Event Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
                <div class="mb-4">
                    <label for="event_date" class="form-label">Event Date</label>
                    <input type="date" name="event_date" class="form-control" required value="{{ old('event_date') }}">
                </div>
                <div class="mb-4">
                    <label for="start_time" class="form-label">Start Time</label>
                    <input type="time" name="start_time" class="form-control" required value="{{ old('start_time') }}">
                </div>
                <div class="mb-4">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="upcoming" {{ old('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-custom w-100">Submit Event</button>
            </form>
        </div>
    </div>

    <script>
        let faqIndex = 1;
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