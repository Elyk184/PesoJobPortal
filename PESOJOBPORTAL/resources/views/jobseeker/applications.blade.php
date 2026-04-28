@extends('layouts.dashboard')

@section('title', 'My Applications - PESO')
@section('page-title', 'My Applications')
@section('page-subtitle', 'Track and manage your job applications')

@section('content')
<style>
    .stats-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    .stats-card.info { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .stats-card.warning { background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); }
    .stats-card.success { background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%); color: #333; }
    .stats-card h3 { font-size: 2rem; font-weight: bold; }
    .stats-card p { margin: 0; opacity: 0.9; }

    .filter-btn {
        transition: all 0.3s ease;
        border-radius: 20px;
        font-weight: 500;
    }
    .filter-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    .filter-btn.active {
        transform: scale(1.05);
    }

    .app-row {
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
        padding: 12px;
        border-radius: 8px;
    }
    .app-row:hover {
        background-color: #f8f9fa;
        border-left-color: #667eea;
        transform: translateX(5px);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.85rem;
    }

    .application-empty {
        text-align: center;
        padding: 60px 20px;
    }
    .application-empty i {
        font-size: 4rem;
        margin-bottom: 20px;
    }
    .application-card {
        border-radius: 10px;
        padding: 16px;
        transition: all 0.25s ease;
        border: 1px solid rgba(0,0,0,0.04);
        background: #fff;
    }
    .application-card:hover { transform: translateY(-4px); box-shadow: 0 8px 30px rgba(102,126,234,0.08); }
    .logo-placeholder {
        width:56px; height:56px; border-radius:8px; background:#f1f3f5; display:inline-flex; align-items:center; justify-content:center; color:#6c757d; font-weight:600;
    }
    .job-title { font-size:1rem; font-weight:600; }
    .company-name { font-size:0.95rem; color:#495057; }
</style>

<div class="row">
    <div class="col-12">
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stats-card info">
                    <h3>{{ $statusCounts['all'] ?? 0 }}</h3>
                    <p><i class="bi bi-send me-1"></i>Total Applications</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card warning" style="color: #333;">
                    <h3>{{ $statusCounts['pending'] ?? 0 }}</h3>
                    <p><i class="bi bi-hourglass-split me-1"></i>Under Review</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card success">
                    <h3>{{ ($statusCounts['interview'] ?? 0) + ($statusCounts['shortlisted'] ?? 0) }}</h3>
                    <p><i class="bi bi-check-circle me-1"></i>Positive Progress</p>
                </div>
            </div>
        </div>

        <!-- Main Applications Card -->
        <div class="jobseeker-card shadow-sm">
            <div class="jobseeker-card-header d-flex justify-content-between align-items-center flex-wrap gap-3 pb-3">
                <div>
                    <h5 class="jobseeker-card-title mb-0">
                        <i class="bi bi-send-check me-2"></i>Application Tracking
                    </h5>
                    <small class="text-muted">View and manage all your applications</small>
                </div>
                <a href="{{ route('jobseeker.browse-jobs') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>New Application
                </a>
            </div>

            <!-- Status Filter Pills - Enhanced -->
            <div class="p-3 border-bottom bg-light rounded-top-3">
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('jobseeker.applications') }}" class="btn filter-btn btn-sm {{ !request('status') ? 'btn-dark active' : 'btn-outline-secondary' }}">
                        <i class="bi bi-filter-circle me-1"></i>All
                        <span class="badge {{ !request('status') ? 'bg-white text-dark' : 'bg-secondary' }} ms-2">{{ $statusCounts['all'] ?? 0 }}</span>
                    </a>
                    <a href="{{ route('jobseeker.applications', ['status' => 'pending']) }}" class="btn filter-btn btn-sm {{ request('status') == 'pending' ? 'btn-warning active text-dark' : 'btn-outline-warning text-warning' }}">
                        <i class="bi bi-hourglass-split me-1"></i>Under Review
                        <span class="badge {{ request('status') == 'pending' ? 'bg-dark text-warning' : 'bg-warning text-dark' }} ms-2">{{ $statusCounts['pending'] ?? 0 }}</span>
                    </a>
                    <a href="{{ route('jobseeker.applications', ['status' => 'reviewing']) }}" class="btn filter-btn btn-sm {{ request('status') == 'reviewing' ? 'btn-info active text-white' : 'btn-outline-info' }}">
                        <i class="bi bi-search me-1"></i>Reviewing
                        <span class="badge {{ request('status') == 'reviewing' ? 'bg-white text-info' : 'bg-info' }} ms-2">{{ $statusCounts['reviewing'] ?? 0 }}</span>
                    </a>
                    <a href="{{ route('jobseeker.applications', ['status' => 'shortlisted']) }}" class="btn filter-btn btn-sm {{ request('status') == 'shortlisted' ? 'btn-primary active text-white' : 'btn-outline-primary' }}">
                        <i class="bi bi-star me-1"></i>Shortlisted
                        <span class="badge {{ request('status') == 'shortlisted' ? 'bg-white text-primary' : 'bg-primary' }} ms-2">{{ $statusCounts['shortlisted'] ?? 0 }}</span>
                    </a>
                    <a href="{{ route('jobseeker.applications', ['status' => 'interview']) }}" class="btn filter-btn btn-sm {{ request('status') == 'interview' ? 'btn-success active text-white' : 'btn-outline-success' }}">
                        <i class="bi bi-calendar-check me-1"></i>Interview
                        <span class="badge {{ request('status') == 'interview' ? 'bg-white text-success' : 'bg-success' }} ms-2">{{ $statusCounts['interview'] ?? 0 }}</span>
                    </a>
                    <a href="{{ route('jobseeker.applications', ['status' => 'hired']) }}" class="btn filter-btn btn-sm {{ request('status') == 'hired' ? 'btn-success active text-white' : 'btn-outline-success' }}">
                        <i class="bi bi-award me-1"></i>Hired
                        <span class="badge {{ request('status') == 'hired' ? 'bg-white text-success' : 'bg-success' }} ms-2">{{ $statusCounts['hired'] ?? 0 }}</span>
                    </a>
                    <a href="{{ route('jobseeker.applications', ['status' => 'rejected']) }}" class="btn filter-btn btn-sm {{ request('status') == 'rejected' ? 'btn-danger active text-white' : 'btn-outline-danger' }}">
                        <i class="bi bi-x-circle me-1"></i>Not Selected
                        <span class="badge {{ request('status') == 'rejected' ? 'bg-white text-danger' : 'bg-danger' }} ms-2">{{ $statusCounts['rejected'] ?? 0 }}</span>
                    </a>
                </div>
            </div>

            <!-- Applications Table or Empty State -->
            <div class="jobseeker-card-body p-0">
                @if($applications->count() > 0)
                    <div class="p-3">
                        <div class="row g-3">
                            @foreach($applications as $application)
                                <div class="col-12">
                                    <div class="application-card d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="logo-placeholder">
                                                <i class="bi bi-briefcase" style="font-size:1.1rem"></i>
                                            </div>
                                            <div>
                                                <div class="job-title">{{ $application->jobPost->title ?? 'N/A' }}</div>
                                                <div class="company-name">
                                                    {{ $application->jobPost->company_name ?? 'N/A' }}
                                                    @if($application->jobPost && $application->jobPost->employment_type)
                                                        <small class="text-muted d-block">{{ $application->jobPost->employment_type }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-4">
                                            <div class="text-center">
                                                @switch($application->status)
                                                    @case('pending')
                                                        <span class="status-badge bg-warning bg-opacity-10 text-warning">Pending</span>
                                                        @break
                                                    @case('reviewing')
                                                        <span class="status-badge bg-info bg-opacity-10 text-info">Reviewing</span>
                                                        @break
                                                    @case('shortlisted')
                                                        <span class="status-badge bg-primary bg-opacity-10 text-primary">Shortlisted</span>
                                                        @break
                                                    @case('interview')
                                                        <span class="status-badge bg-success bg-opacity-10 text-success">Interview</span>
                                                        @break
                                                    @case('hired')
                                                        <span class="status-badge bg-success bg-opacity-10 text-success">Hired</span>
                                                        @break
                                                    @case('rejected')
                                                        <span class="status-badge bg-danger bg-opacity-10 text-danger">Not Selected</span>
                                                        @break
                                                    @default
                                                        <span class="status-badge bg-secondary bg-opacity-10 text-secondary">{{ $application->status }}</span>
                                                @endswitch

                                                @if($application->interview_scheduled_at)
                                                    <div class="small text-success mt-1">{{ $application->interview_scheduled_at->format('M d, Y h:i A') }}</div>
                                                @endif
                                            </div>

                                            <div class="text-center">
                                                <div class="fw-bold">{{ $application->applied_at->format('M d, Y') }}</div>
                                                <div class="small text-muted">{{ $application->applied_at->diffForHumans() }}</div>
                                            </div>

                                            <div class="text-end">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('jobseeker.applications') }}" class="btn btn-outline-primary" title="View Details">
                                                        <i class="bi bi-eye me-1"></i>
                                                    </a>
                                                    @if($application->resume_path)
                                                        <a href="{{ Storage::url($application->resume_path) }}" class="btn btn-outline-secondary" target="_blank" title="Download Resume">
                                                            <i class="bi bi-download"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if($applications->hasPages())
                            <div class="d-flex justify-content-center pt-4 pb-3">
                                {{ $applications->appends(request()->query())->links() }}
                            </div>
                        @endif
                    </div>
                @else
                    <div class="application-empty">
                        <i class="bi bi-inbox text-muted"></i>
                        <h5 class="mt-3 fw-bold">No Applications Found</h5>
                        <p class="text-muted mb-4">
                            @if(request('status'))
                                You don't have any applications with status <strong>"{{ ucfirst(str_replace('_', ' ', request('status'))) }}"</strong>.
                            @else
                                Start your job search journey! Browse available positions and submit your applications.
                            @endif
                        </p>
                        <a href="{{ route('jobseeker.browse-jobs') }}" class="btn btn-primary btn-lg">
                            <i class="bi bi-search me-2"></i>Browse Available Jobs
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Application Status Guide -->
<div class="row mt-5">
    <div class="col-12">
        <div class="jobseeker-card">
            <div class="jobseeker-card-header">
                <h5 class="jobseeker-card-title">
                    <i class="bi bi-info-circle me-2"></i>Understanding Application Statuses
                </h5>
                <small class="text-muted d-block mt-2">Learn what each status means and what to expect next</small>
            </div>
            <div class="jobseeker-card-body">
                <div class="row g-4">
                    <!-- Pending PESO Review -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                            <div class="position-absolute top-0 start-0 w-100" style="height: 4px; background: linear-gradient(90deg, #fda085, #f6d365);"></div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <i class="bi bi-hourglass-split" style="font-size: 2rem; color: #fda085;"></i>
                                </div>
                                <h6 class="card-title fw-bold">Pending PESO Review</h6>
                                <p class="card-text small text-muted mb-0">
                                    Your application has been submitted and is awaiting review by PESO staff before being referred to the employer.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Being Reviewed -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                            <div class="position-absolute top-0 start-0 w-100" style="height: 4px; background: linear-gradient(90deg, #667eea, #764ba2);"></div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <i class="bi bi-search" style="font-size: 2rem; color: #667eea;"></i>
                                </div>
                                <h6 class="card-title fw-bold">Being Reviewed</h6>
                                <p class="card-text small text-muted mb-0">
                                    PESO staff or the employer is actively reviewing your application and assessing your qualifications.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Shortlisted -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                            <div class="position-absolute top-0 start-0 w-100" style="height: 4px; background: linear-gradient(90deg, #667eea, #764ba2);"></div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <i class="bi bi-star-fill" style="font-size: 2rem; color: #667eea;"></i>
                                </div>
                                <h6 class="card-title fw-bold">Referred / Shortlisted</h6>
                                <p class="card-text small text-muted mb-0">
                                    Great! Your application has been referred to the employer for further consideration. You're among the top candidates.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Interview Scheduled -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                            <div class="position-absolute top-0 start-0 w-100" style="height: 4px; background: linear-gradient(90deg, #84fab0, #8fd3f4);"></div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <i class="bi bi-calendar-check" style="font-size: 2rem; color: #84fab0;"></i>
                                </div>
                                <h6 class="card-title fw-bold">Interview Scheduled</h6>
                                <p class="card-text small text-muted mb-0">
                                    Excellent! The employer has scheduled an interview with you. Check your application details for the date and time.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Hired -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                            <div class="position-absolute top-0 start-0 w-100" style="height: 4px; background: linear-gradient(90deg, #84fab0, #8fd3f4);"></div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <i class="bi bi-award" style="font-size: 2rem; color: #84fab0;"></i>
                                </div>
                                <h6 class="card-title fw-bold">Congratulations! Hired</h6>
                                <p class="card-text small text-muted mb-0">
                                    You got the job! Congratulations! Review your application details for next steps and onboarding information.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Not Selected -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                            <div class="position-absolute top-0 start-0 w-100" style="height: 4px; background: linear-gradient(90deg, #ff6b6b, #ee5a6f);"></div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <i class="bi bi-x-circle" style="font-size: 2rem; color: #ff6b6b;"></i>
                                </div>
                                <h6 class="card-title fw-bold">Not Selected</h6>
                                <p class="card-text small text-muted mb-0">
                                    Unfortunately, the employer has decided to move forward with other candidates. Keep applying to find the right opportunity!
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

