@extends('layouts.dashboard')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header">
            <h5>Applicant Details</h5>
        </div>
        <div class="card-body">
            <h6>{{ $application->user->name }}</h6>
            <p class="text-muted">{{ $application->user->email }}</p>

            <p><strong>Applied For:</strong> {{ $application->jobPost->title ?? 'N/A' }}</p>
            <p><strong>Date Applied:</strong> {{ $application->applied_at?->format('M d, Y H:i') ?? $application->created_at->format('M d, Y H:i') }}</p>
            <p><strong>Status:</strong> {{ $application->status }}</p>

            @if($application->resume_path)
            <p><strong>Resume:</strong> <a href="{{ Storage::url($application->resume_path) }}" target="_blank">Download</a></p>
            @endif

            @if($application->notes)
            <div class="mt-3">
                <h6>Notes / Cover Letter</h6>
                <div class="p-3 bg-light">
                    {!! nl2br(e($application->notes)) !!}
                </div>
            </div>
            @endif

            <div class="mt-3">
                <a href="{{ route('employer.applicants.index') }}" class="btn btn-outline-secondary">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
