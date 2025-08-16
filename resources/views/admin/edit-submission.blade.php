@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Submission #{{ $submission->id }}</h2>

    <form action="{{ route('admin.submissions.update', $submission->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="pending" @if($submission->status == 'pending') selected @endif>Pending</option>
                <option value="reviewed" @if($submission->status == 'reviewed') selected @endif>Reviewed</option>
                <option value="rejected" @if($submission->status == 'rejected') selected @endif>Rejected</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Score</label>
            <input type="number" name="score" class="form-control" value="{{ $submission->score }}">
        </div>

        <button type="submit" class="btn btn-primary">Up</button>
        <a href="{{ route('admin.submissions') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
