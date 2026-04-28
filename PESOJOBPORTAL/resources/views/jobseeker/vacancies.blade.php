@extends('layouts.dashboard')

@section('title', 'Vacancies | Jobseeker | PESO Job Portal')

@section('content')
<section class="container py-4" aria-label="Job vacancies">
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-lg-between gap-3 mb-3">
        <div>
            <h1 class="mb-1 fw-bold dashboard-section-title">Active Job Vacancies</h1>
            <p class="mb-0 text-muted">Browse {{ $jobs->total() }} approved job posts available now.</p>
        </div>
        <a href="{{ route('jobseeker.dashboard') }}" class="btn btn-outline-danger">
            <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
        </a>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-3">Filters</h5>
            <form class="row g-3" action="#" method="GET">
                <div class="col-12 col-md-6 col-lg-3">
                    <label class="form-label">Location</label>
                    <select class="form-select" disabled>
                        <option selected>All locations</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <label class="form-label">Industry</label>
                    <select class="form-select" disabled>
                        <option selected>All industries</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <label class="form-label">Skills</label>
                    <input class="form-control" placeholder="e.g., cashier, driving" disabled />
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <label class="form-label">Barangay</label>
                    <select class="form-select" disabled>
                        <option selected>All barangays</option>
                    </select>
                </div>

                <div class="col-12 col-lg-6">
                    <label class="form-label">Sort</label>
                    <select class="form-select" disabled>
                        <option selected>Newest</option>
                        <option>Expiring soon</option>
                    </select>
                </div>

                <div class="col-12 col-lg-6 d-flex align-items-end justify-content-lg-end">
                    <button class="btn btn-danger" type="button" disabled>
                        <i class="bi bi-funnel me-2"></i>Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-3">
        @forelse($jobs as $job)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <div>
                                <h5 class="card-title fw-semibold mb-1">{{ $job->title }}</h5>
                                <p class="text-muted small mb-0">{{ $job->employer->name ?? 'Company' }}</p>
                            </div>
                            <span class="badge text-bg-success">Open</span>
                        </div>
                        <p class="text-muted small mb-2">{{ $job->location }}</p>
                        
                        @if($job->job_type)
                            <p class="text-muted small mb-2">
                                <strong>Type:</strong> {{ ucfirst($job->job_type) }}
                            </p>
                        @endif
                        
                        @if($job->salary_range)
                            <p class="text-muted small mb-2">
                                <strong>Salary:</strong> {{ $job->salary_range }}
                            </p>
                        @endif

                        @if($job->preferred_skills)
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                @foreach(array_slice(explode(',', $job->preferred_skills), 0, 3) as $skill)
                                    <span class="badge rounded-pill text-bg-light">{{ trim($skill) }}</span>
                                @endforeach
                            </div>
                        @endif

                        <p class="text-muted small mb-3 text-truncate" title="{{ $job->description }}">
                            {{ \Illuminate\Support\Str::limit($job->description, 100) }}
                        </p>
                        
                        <div class="d-flex gap-2">
                            <a href="{{ route('jobseeker.apply-job', $job->id) }}" class="btn btn-danger flex-grow-1">
                                <i class="bi bi-send me-2"></i>Apply
                            </a>
                            <button class="btn btn-outline-secondary" type="button" title="Save for later">
                                <i class="bi bi-bookmark"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info" role="alert">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>No jobs available</strong> - There are currently no approved job vacancies. Please check back later.
                </div>
            </div>
        @endforelse
    </div>

    @if($jobs->hasPages())
        <nav aria-label="Job pagination" class="mt-4">
            <ul class="pagination justify-content-center">
                {{-- Previous Page Link --}}
                @if ($jobs->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $jobs->previousPageUrl() }}">Previous</a></li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($jobs->getUrlRange(1, $jobs->lastPage()) as $page => $url)
                    @if ($page == $jobs->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($jobs->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $jobs->nextPageUrl() }}">Next</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                @endif
            </ul>
        </nav>
    @endif
</section>
@endsection
