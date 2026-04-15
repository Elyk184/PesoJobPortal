@extends('dashboard.employer.layout')

@section('title', 'View Applicants')
@section('page_title', 'View Applicants')
@section('page_subtitle', 'Review referred applicants and update decisions.')

@section('content')
    <div class="panel">
        <h2>Referred Applicants</h2>
        <p>Only referred applicants for your vacancies are shown below.</p>
        <div class="list">
            @forelse ($referredApplications as $application)
                <div class="item">
                    <h3>{{ $application->user->name ?? 'Applicant' }}</h3>
                    <p>Email: {{ $application->user->email ?? 'N/A' }}</p>
                    <p>Job: {{ $application->job->position ?? $application->job->title ?? 'N/A' }}</p>
                    <p>Phone: {{ $application->user->profile->phone ?? 'N/A' }}</p>
                    <p>Address: {{ $application->user->profile->address ?? 'N/A' }}</p>
                    <p>Objective: {{ $application->user->profile->objective ?? 'N/A' }}</p>
                    <p>Skills: {{ is_array($application->user->profile->skills ?? null) ? implode(', ', $application->user->profile->skills) : 'N/A' }}</p>

                    <form method="POST" action="{{ route('employer.applications.update', $application) }}">
                        @csrf
                        @method('PATCH')
                        <div class="grid">
                            <div>
                                <label>Status</label>
                                <select name="employer_status" required>
                                    <option value="interview_scheduled" @selected($application->employer_status === 'interview_scheduled')>Interview Scheduled</option>
                                    <option value="hired" @selected($application->employer_status === 'hired')>Hired</option>
                                    <option value="not_selected" @selected($application->employer_status === 'not_selected')>Not Selected</option>
                                </select>
                            </div>
                            <div>
                                <label>Final Decision</label>
                                <select name="final_decision" required>
                                    <option value="pending" @selected($application->final_decision === 'pending')>Pending</option>
                                    <option value="hired" @selected($application->final_decision === 'hired')>Hired</option>
                                    <option value="not_selected" @selected($application->final_decision === 'not_selected')>Not Selected</option>
                                </select>
                            </div>
                        </div>
                        <label>Feedback for Jobseeker (Optional)</label>
                        <textarea name="employer_feedback">{{ $application->employer_feedback }}</textarea>
                        <button class="btn" type="submit">Update Applicant Decision</button>
                    </form>
                </div>
            @empty
                <p>No referred applicants yet.</p>
            @endforelse
        </div>
    </div>
@endsection
