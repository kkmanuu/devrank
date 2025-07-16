<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services - DevRank</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('layouts.navbar')

    <div class="container py-5">
        <h1 class="mb-4">Our Services</h1>
        <ul>
            <li>Project Submission and Evaluation</li>
            <li>Detailed Feedback Reports</li>
            <li>Personalized Coaching Sessions</li>
            <li>Progress Tracking and Analytics</li>
            <li>Secure Payment via M-PESA</li>
        </ul>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>