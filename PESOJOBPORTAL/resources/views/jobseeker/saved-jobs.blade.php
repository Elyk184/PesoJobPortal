@extends('layouts.dashboard')

@section('title', 'Saved Jobs | Jobseeker')

@section('content')
<section aria-label="Saved jobs">
    <div class="dashboard-topbar">
        <div>
            <div class="dashboard-topbar-title">Saved Jobs</div>
            <div class="dashboard-topbar-subtitle">Jobs you have bookmarked for later</div>
        </div>
        <div class="d-none d-md-block text-end">
            <div class="fw-semibold text-secondary">{{ auth()->user()->name ?? 'Jobseeker' }}</div>
            <div class="dashboard-topbar-subtitle">{{ $savedCount }} saved</div>
        </div>
    </div>

    <div class="dashboard-section-card p-3 p-lg-4 mb-4">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
            <div>
                <h2 class="h4 mb-1 fw-bold">Your Saved Job Opportunities</h2>
                <p class="mb-0 text-muted">Bookmark jobs while browsing and review them here anytime.</p>
            </div>
            <a href="{{ route('jobseeker.vacancies') }}" class="btn btn-primary px-3 shadow-sm">
                <i class="bi bi-briefcase me-2"></i>Browse Jobs
            </a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
                <div class="dashboard-stat-icon" style="background: rgba(204, 141, 36, 0.14); color: #a06d19;"><i class="bi bi-bookmark-fill"></i></div>
                <div>
                    <div class="dashboard-stat-number">{{ $savedCount }}</div>
                    <div class="dashboard-stat-label">Saved Jobs</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
                <div class="dashboard-stat-icon"><i class="bi bi-briefcase"></i></div>
                <div>
                    <div class="dashboard-stat-number">{{ \App\Models\PesoJob::query()->where('status', 'active')->count() }}</div>
                    <div class="dashboard-stat-label">Active Job Posts</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
                <div class="dashboard-stat-icon" style="background: rgba(47, 157, 98, 0.12); color: var(--dash-success);"><i class="bi bi-send"></i></div>
                <div>
                    <div class="dashboard-stat-number">{{ \App\Models\JobApplication::query()->where('user_id', auth()->id())->count() }}</div>
                    <div class="dashboard-stat-label">Applications Sent</div>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-section-card p-3 p-lg-4">
        <div class="d-flex align-items-center justify-content-between gap-3 mb-3 border-bottom pb-3">
            <h3 class="h5 mb-0 fw-bold"><i class="bi bi-bookmark me-2"></i>Saved Job Posts</h3>
            <a href="{{ route('jobseeker.vacancies') }}" class="btn btn-sm btn-outline-primary">Browse All Jobs</a>
        </div>

        @if ($savedJobs->isEmpty())
            <div class="dashboard-empty-state">
                <div>
                    <div class="fs-1 mb-2">✦</div>
                    <div class="fw-semibold text-secondary">No saved jobs yet.</div>
                    <div class="small">Browse vacancies and click the bookmark icon to save jobs for later.</div>
                    <a href="{{ route('jobseeker.vacancies') }}" class="btn btn-sm btn-outline-primary mt-2">Browse Vacancies</a>
                </div>
            </div>
        @else
            <div class="row g-3">
                @foreach ($savedJobs as $job)
                    <div class="col-12 col-xl-6">
                        <article class="dashboard-stat-card p-3 h-100 d-flex flex-column gap-3">
                            <div class="d-flex flex-wrap align-items-start justify-content-between gap-2">
                                <div>
                                    <h4 class="h6 mb-1 fw-bold text-dark">{{ $job['title'] }}</h4>
                                    <div class="small text-muted">
                                        <i class="bi bi-building me-1"></i>{{ $job['employer_name'] }}
                                        <span class="mx-1">|</span>
                                        <i class="bi bi-geo-alt me-1"></i>{{ $job['location'] }}
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-warning" onclick="toggleSaveJob({{ $job['id'] }}, this)">
                                    <i class="bi bi-bookmark-fill"></i>
                                </button>
                            </div>

                            @if (! empty($job['salary_range']))
                                <div class="small text-secondary">
                                    <i class="bi bi-cash-stack me-1"></i>{{ $job['salary_range'] }}
                                </div>
                            @endif

                            <p class="mb-0 small text-muted">{{ \Illuminate\Support\Str::limit($job['description'], 150) }}</p>

                            @if (! empty($job['requirements_list']))
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach (collect($job['requirements_list'])->take(4) as $requirement)
                                        <span class="badge rounded-pill text-bg-light border">{{ $requirement }}</span>
                                    @endforeach
                                </div>
                            @endif

                            <div class="mt-auto pt-2">
                                <a href="{{ route('jobseeker.vacancies') }}" class="btn btn-sm btn-outline-primary w-100">
                                    View Details & Apply
                                </a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
    function toggleSaveJob(jobId, button) {
        fetch('{{ url('jobseeker/saved-jobs') }}/' + jobId, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (!data.saved) {
                // Job was unsaved — remove the card with animation
                const card = button.closest('.col-12');
                card.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                card.style.opacity = '0';
                card.style.transform = 'scale(0.95)';
                setTimeout(() => card.remove(), 300);
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endpush
@endsection

