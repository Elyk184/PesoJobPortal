@extends('layouts.dashboard')

@section('title', 'Vacancies | Jobseeker | PESO Job Portal')

@section('content')
<section class="container py-4" aria-label="Job vacancies">
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-lg-between gap-3 mb-3">
        <div>
            <h1 class="mb-1 fw-bold dashboard-section-title">Active Job Vacancies</h1>
            <p class="mb-0 text-muted">Filter and sort available job posts based on your preferences.</p>
        </div>
        <a href="{{ route('jobseeker.dashboard') }}" class="btn btn-outline-danger">
            <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
        </a>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-3">Filters</h5>
            <form class="row g-3" action="{{ route('jobseeker.vacancies') }}" method="GET">
                <div class="col-12 col-md-6 col-lg-3">
                    <label class="form-label">Barangay (Manolo Fortich only)</label>
                    <select class="form-select" name="location">
                        <option value="">All barangays</option>
                        @foreach ($locations as $item)
                            <option value="{{ $item }}" {{ $filters['location'] === $item ? 'selected' : '' }}>{{ $item }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <label class="form-label">Employer</label>
                    <input
                        class="form-control"
                        name="employer"
                        value="{{ $filters['employer'] }}"
                        placeholder="e.g., ABC Company"
                    />
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <label class="form-label">Skills</label>
                    <input
                        class="form-control"
                        name="skills"
                        value="{{ $filters['skills'] }}"
                        placeholder="e.g., cashier, driving"
                    />
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <label class="form-label">Keyword</label>
                    <input
                        class="form-control"
                        name="keyword"
                        value="{{ $filters['keyword'] }}"
                        placeholder="Title, company, description"
                    />
                </div>

                <div class="col-12 col-lg-6">
                    <label class="form-label">Sort</label>
                    <select class="form-select" name="sort">
                        <option value="newest" {{ $filters['sort'] === 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="oldest" {{ $filters['sort'] === 'oldest' ? 'selected' : '' }}>Oldest</option>
                        <option value="title_asc" {{ $filters['sort'] === 'title_asc' ? 'selected' : '' }}>Title (A-Z)</option>
                        <option value="location_asc" {{ $filters['sort'] === 'location_asc' ? 'selected' : '' }}>Location (A-Z)</option>
                    </select>
                </div>

                <div class="col-12 col-lg-6 d-flex align-items-end justify-content-lg-end gap-2">
                    <a href="{{ route('jobseeker.vacancies') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-2"></i>Reset
                    </a>
                    <button class="btn btn-danger" type="submit">
                        <i class="bi bi-funnel me-2"></i>Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>

    @php
        $hasActiveFilters = collect($filters)->except('sort')->filter(fn ($value) => trim((string) $value) !== '')->isNotEmpty();
        $showSampleJobs = $jobs->count() === 0 && ! $hasActiveFilters;
    @endphp

    <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="text-muted small">
            Showing <strong>{{ $showSampleJobs ? $sampleJobs->count() : $jobs->total() }}</strong>
            {{ $showSampleJobs ? 'sample vacancies' : 'active vacancies' }}
        </div>
    </div>

    @if ($jobs->count() > 0)
        <div class="row g-3">
            @foreach ($jobs as $job)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start gap-2">
                                <h5 class="card-title fw-semibold mb-1">{{ $job->title }}</h5>
                                <span class="badge text-bg-success">Open</span>
                            </div>
                            <p class="text-muted small mb-2">{{ $job->location }} • {{ $job->employer_name }}</p>

                            @if (! empty($job->salary_range))
                                <p class="small mb-2"><strong>Salary:</strong> {{ $job->salary_range }}</p>
                            @endif

                            <p class="small text-muted mb-3">{{ \Illuminate\Support\Str::limit($job->description, 120) }}</p>

                            <div class="d-flex flex-wrap gap-2 mb-3">
                                @forelse (collect($job->requirements_list)->take(4) as $requirement)
                                    <span class="badge rounded-pill text-bg-light">{{ $requirement }}</span>
                                @empty
                                    <span class="badge rounded-pill text-bg-light">No listed requirements</span>
                                @endforelse
                            </div>

                            <div class="mt-auto">
                                <button class="btn btn-outline-danger w-100" type="button" disabled>
                                    <i class="bi bi-send me-2"></i>Apply (coming soon)
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $jobs->links() }}
        </div>
    @elseif ($showSampleJobs)
        @include('dashboard.jobseeker.partials.sample-vacancies', ['sampleJobs' => $sampleJobs])
    @else
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <div class="mb-2"><i class="bi bi-search" style="font-size: 2rem;"></i></div>
                <h5 class="fw-semibold mb-2">No jobs found</h5>
                <p class="text-muted mb-3">Try adjusting your filters to see more vacancies.</p>
                <a href="{{ route('jobseeker.vacancies') }}" class="btn btn-outline-danger">Clear Filters</a>
            </div>
        </div>
    @endif
</section>
@endsection
