@extends('dashboard.employer.layout')

@section('title', 'Submit Documents')
@section('page_title', 'Submit Documents')
@section('page_subtitle', 'Upload the required files for LRA/SRA review.')

@section('content')
    <div class="panel">
        <h2>Submit Local / Special Recruitment Documents</h2>
        <form method="POST" action="{{ route('employer.recruitment.request') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid">
                <div>
                    <label>Activity Type</label>
                    <select name="activity_type" required>
                        <option value="">Select</option>
                        <option value="lra" @selected(old('activity_type', $defaultActivityType) === 'lra')>LRA</option>
                        <option value="sra" @selected(old('activity_type', $defaultActivityType) === 'sra')>SRA</option>
                    </select>
                </div>
                <div>
                    <label>Letter of Intent</label>
                    <input type="file" name="letter_of_intent" required>
                </div>
                <div>
                    <label>Company Profile</label>
                    <input type="file" name="company_profile" required>
                </div>
                <div>
                    <label>Job Advertisement (Facebook/Social Media Ready)</label>
                    <input type="file" name="job_advertisement" required>
                </div>
            </div>
            <button class="btn" type="submit">Submit LRA/SRA Request</button>
        </form>
    </div>

    <div class="panel">
        <h2>Recent Submissions</h2>
        <div class="list">
            @forelse ($recruitmentRequests as $request)
                <div class="item">
                    <strong>{{ strtoupper($request->activity_type) }}</strong>
                    <p>Status: {{ strtoupper($request->status) }}</p>
                    <p>Submitted: {{ optional($request->created_at)->format('M d, Y h:i A') }}</p>
                </div>
            @empty
                <p>No document submissions yet.</p>
            @endforelse
        </div>
    </div>
@endsection
