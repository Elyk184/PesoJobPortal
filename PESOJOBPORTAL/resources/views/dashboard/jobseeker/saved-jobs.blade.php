@extends('layouts.dashboard')

@section('title', 'Saved Jobs | Jobseeker')

@section('content')
<section aria-label="Saved jobs" class="saved-jobs-page">

    <div class="dashboard-section-card p-3 p-lg-4 mb-4">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
            <div>
                <h2 class="h4 mb-1 fw-bold">Your Saved Job Opportunities</h2>
                <p class="mb-0 text-muted">Bookmark jobs while browsing and review them here anytime.</p>
            </div>
            <a href="{{ route('jobseeker.browse-jobs') }}" class="btn btn-primary px-3 shadow-sm">
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
            <a href="{{ route('jobseeker.browse-jobs') }}" class="btn btn-sm btn-outline-primary">Browse All Jobs</a>
        </div>

        @if ($savedJobs->isEmpty())
            <div class="dashboard-empty-state text-center py-5">
                <div class="mb-3">
                    <svg width="84" height="84" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <rect x="1" y="4" width="22" height="14" rx="2" fill="#E9F5FF"/>
                        <path d="M7 9h10M7 13h6" stroke="#2D65B1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="fw-semibold text-secondary">No saved jobs yet.</div>
                <div class="small mb-3">Save interesting job posts while browsing and review them here anytime.</div>
                <a href="{{ route('jobseeker.browse-jobs') }}" class="btn btn-primary btn-lg px-4">Browse Jobs</a>
            </div>
        @else
            <div class="row g-3">
                @foreach ($savedJobs as $job)
                    <div class="col-12 col-xl-6">
                        <article class="saved-job-card p-3 h-100 d-flex flex-column">
                            <div class="saved-job-card-header">
                                <div class="logo-placeholder rounded-3 bg-light d-flex align-items-center justify-content-center">
                                    <i class="bi bi-building fs-4 text-secondary"></i>
                                </div>
                                <div class="saved-job-heading">
                                    <h4 class="h6 mb-1 fw-bold text-dark">{{ $job['title'] }}</h4>
                                    <div class="small text-muted saved-job-subtitle">
                                        <i class="bi bi-building me-1"></i>{{ $job['employer_name'] }}
                                        <span class="mx-1">|</span>
                                        <i class="bi bi-geo-alt me-1"></i>{{ $job['location'] }}
                                    </div>
                                </div>
                                <div class="saved-job-actions">
                                    <button type="button" class="btn btn-sm btn-outline-warning saved-bookmark-btn" onclick="toggleSaveJob({{ $job['id'] }}, this)" title="Remove from saved jobs">
                                        <i class="bi bi-bookmark-fill"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="saved-job-meta mt-3 small text-secondary">
                                @if (! empty($job['salary_range']))
                                    <span class="saved-meta-item"><i class="bi bi-cash-stack me-1"></i>{{ $job['salary_range'] }}</span>
                                @endif
                                @if (! empty($job['application_deadline']))
                                    <span class="badge bg-light text-dark border saved-expiry-badge">Expires {{ $job['application_deadline'] }}</span>
                                @endif
                            </div>

                            <p class="mb-0 small text-muted mt-2">{{ \Illuminate\Support\Str::limit($job['description'], 140) }}</p>

                            @if (! empty($job['requirements_list']))
                                <div class="d-flex flex-wrap gap-2 mt-3">
                                    @foreach (collect($job['requirements_list'])->take(3) as $requirement)
                                        <span class="badge rounded-pill text-bg-light border">{{ $requirement }}</span>
                                    @endforeach
                                </div>
                            @endif

                            <div class="mt-auto pt-3 saved-cta-wrap">
                                <a href="{{ route('jobseeker.apply-job', $job['id']) }}" class="btn btn-sm btn-primary w-100">
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

<style>
    .saved-jobs-page .dashboard-section-card {
        border-radius: 14px;
    }

    .saved-job-card {
        border-radius: 14px;
        border: 1px solid var(--dash-border);
        background: #fff;
        transition: box-shadow 0.18s ease, transform 0.12s ease, border-color 0.18s ease;
        display: flex;
        flex-direction: column;
    }

    .saved-job-card:hover {
        box-shadow: 0 12px 30px rgba(15, 45, 82, 0.06);
        transform: translateY(-4px);
        border-color: rgba(45, 101, 177, 0.24);
    }

    .saved-job-card-header {
        display: grid;
        grid-template-columns: 64px minmax(0, 1fr) auto;
        align-items: start;
        gap: 0.8rem;
    }

    .saved-job-heading {
        min-width: 0;
    }

    .saved-job-subtitle {
        line-height: 1.35;
        word-break: break-word;
    }

    .saved-job-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }

    .saved-bookmark-btn {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .saved-job-meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.5rem;
    }

    .saved-meta-item {
        display: inline-flex;
        align-items: center;
        color: #4b5e74;
    }

    .saved-expiry-badge {
        font-weight: 600;
    }

    .saved-cta-wrap .btn {
        min-height: 38px;
        font-weight: 700;
    }

    .logo-placeholder {
        width: 64px;
        height: 64px;
        flex: 0 0 64px;
        border-radius: 10px;
    }

    .dashboard-empty-state svg { display: inline-block; }

    @media (max-width: 575.98px) {
        .saved-job-card-header {
            grid-template-columns: 56px minmax(0, 1fr);
        }

        .saved-job-actions {
            grid-column: 1 / -1;
            justify-content: flex-end;
            margin-top: 0.15rem;
        }

        .logo-placeholder {
            width: 56px;
            height: 56px;
            flex: 0 0 56px;
        }
    }
</style>

