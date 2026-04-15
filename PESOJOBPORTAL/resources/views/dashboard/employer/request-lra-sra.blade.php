@extends('dashboard.employer.layout')

@section('title', 'Request LRA/SRA')
@section('page_title', 'Request LRA/SRA')
@section('page_subtitle', 'Choose your activity type, then continue to document submission.')

@section('content')
    <div class="panel">
        <h2>Recruitment Activity Requests</h2>
        <p>Start with an activity type, then submit your required files.</p>
        <div class="actions">
            <a class="btn" href="{{ route('employer.documents.index', ['activity_type' => 'lra']) }}">Start LRA Request</a>
            <a class="btn btn-secondary" href="{{ route('employer.documents.index', ['activity_type' => 'sra']) }}">Start SRA Request</a>
        </div>
        <p class="placeholder-note">Document uploads are handled in the Submit Documents page.</p>
    </div>

    <div class="panel">
        <h2>Submitted Requests</h2>
        <div class="list">
            @forelse ($recruitmentRequests as $request)
                <div class="item">
                    <strong>{{ strtoupper($request->activity_type) }}</strong>
                    <p>Status: {{ strtoupper($request->status) }}</p>
                    <p>Submitted: {{ optional($request->created_at)->format('M d, Y h:i A') }}</p>
                </div>
            @empty
                <p>No LRA/SRA requests submitted yet.</p>
            @endforelse
        </div>
    </div>
@endsection
