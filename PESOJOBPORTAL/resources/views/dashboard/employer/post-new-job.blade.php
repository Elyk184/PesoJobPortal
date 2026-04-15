@extends('dashboard.employer.layout')

@section('title', 'Post New Job')
@section('page_title', 'Post New Job')
@section('page_subtitle', 'Create a new vacancy for jobseekers.')

@section('content')
    <div class="panel">
        <h2>Post Job Vacancies</h2>
        <p>Only verified employers can create job vacancies.</p>
        @if ($isVerifiedEmployer)
            <span class="pill">Verified Employer</span>
        @else
            <span class="pill" style="background:#fef2f2;color:#b91c1c;">Not Verified</span>
        @endif

        <form method="POST" action="{{ route('employer.jobs.store') }}">
            @csrf
            <div class="grid">
                <div>
                    <label>Position</label>
                    <input type="text" name="position" value="{{ old('position') }}" required>
                </div>
                <div>
                    <label>Salary</label>
                    <input type="text" name="salary" value="{{ old('salary') }}" placeholder="PHP 20,000 - 30,000">
                </div>
                <div>
                    <label>Location</label>
                    <input type="text" name="location" value="{{ old('location') }}" required>
                </div>
                <div>
                    <label>Type</label>
                    <select name="job_type" required>
                        <option value="">Select</option>
                        <option value="Full-time" @selected(old('job_type') === 'Full-time')>Full-time</option>
                        <option value="Part-time" @selected(old('job_type') === 'Part-time')>Part-time</option>
                        <option value="Contract" @selected(old('job_type') === 'Contract')>Contract</option>
                        <option value="Project-based" @selected(old('job_type') === 'Project-based')>Project-based</option>
                    </select>
                </div>
                <div>
                    <label>Vacancies</label>
                    <input type="number" min="1" name="vacancies" value="{{ old('vacancies', 1) }}" required>
                </div>
                <div>
                    <label>Application Start Date</label>
                    <input type="date" name="application_start_date" value="{{ old('application_start_date') }}" required>
                </div>
                <div>
                    <label>Application End Date</label>
                    <input type="date" name="application_end_date" value="{{ old('application_end_date') }}" required>
                </div>
            </div>

            <label>Qualifications</label>
            <textarea name="qualifications" required>{{ old('qualifications') }}</textarea>

            <button class="btn" type="submit" @disabled(! $isVerifiedEmployer)>Post Vacancy</button>
        </form>
    </div>
@endsection
