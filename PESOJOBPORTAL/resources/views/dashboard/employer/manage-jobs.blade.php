@extends('dashboard.employer.layout')

@section('title', 'Manage Jobs')
@section('page_title', 'Manage Jobs')
@section('page_subtitle', 'Extend, archive, duplicate, and close your postings.')

@section('content')
    <div class="panel">
        <h2>Manage Job Postings</h2>
        <div class="list">
            @forelse ($jobs as $job)
                <div class="item">
                    <h3>{{ $job->position ?? $job->title }}</h3>
                    <p>{{ $job->location }} | {{ $job->job_type ?? 'N/A' }} | Vacancies: {{ $job->vacancies ?? 1 }}</p>
                    <span class="pill">Status: {{ strtoupper($job->status) }}</span>
                    @if ($job->is_filled)
                        <span class="pill" style="background:#fee2e2;color:#991b1b;">Filled</span>
                    @endif
                    @if ($job->archived_at)
                        <span class="pill" style="background:#e2e8f0;color:#334155;">Archived</span>
                    @endif

                    <div class="actions">
                        <form method="POST" action="{{ route('employer.jobs.extend', $job) }}">
                            @csrf
                            @method('PATCH')
                            <input type="date" name="application_end_date" required>
                            <button class="btn" type="submit">Extend Posting</button>
                        </form>

                        <form method="POST" action="{{ route('employer.jobs.archive', $job) }}">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-danger" type="submit">Archive</button>
                        </form>

                        <form method="POST" action="{{ route('employer.jobs.duplicate', $job) }}">
                            @csrf
                            <button class="btn btn-secondary" type="submit" @disabled(! $isVerifiedEmployer)>Duplicate</button>
                        </form>

                        @if (! $job->is_filled)
                            <form method="POST" action="{{ route('employer.jobs.filled', $job) }}">
                                @csrf
                                @method('PATCH')
                                <button class="btn" type="submit">Mark as Filled</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <p>No postings yet.</p>
            @endforelse
        </div>
    </div>
@endsection
