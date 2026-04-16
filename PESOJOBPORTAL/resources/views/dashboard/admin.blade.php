@extends('layouts.app')

@section('title', 'Admin Dashboard | PESO Job Portal')

@section('content')
<section class="container-fluid pt-5 mt-4 pb-4" aria-label="Admin dashboard">
    <!-- Header -->
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-lg-between gap-3 mb-4">
        <div>
            <h1 class="mb-1 fw-bold">Admin Dashboard</h1>
            <p class="mb-0 text-muted">Welcome, {{ auth()->user()->name ?? 'Admin' }}. Here's an overview of your portal.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#quickActionsModal">
                <i class="bi bi-lightning me-2"></i>Quick Actions
            </button>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="btn btn-outline-danger">
                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Total Users</p>
                            <h3 class="mb-0 fw-bold">{{ $stats['total_users'] }}</h3>
                        </div>
                        <i class="bi bi-people-fill text-primary" style="font-size: 1.8rem;"></i>
                    </div>
                    <small class="text-muted">
                        <i class="bi bi-briefcase me-1"></i>{{ $stats['total_employers'] }} Employers
                        <i class="bi bi-person me-1 ms-2"></i>{{ $stats['total_jobseekers'] }} Jobseekers
                    </small>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Job Postings</p>
                            <h3 class="mb-0 fw-bold">{{ $stats['total_jobs'] }}</h3>
                        </div>
                        <i class="bi bi-briefcase-fill text-success" style="font-size: 1.8rem;"></i>
                    </div>
                    <small class="text-muted">
                        <span class="badge bg-success">{{ $stats['active_jobs'] }} Active</span>
                    </small>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Applications</p>
                            <h3 class="mb-0 fw-bold">{{ $stats['total_applications'] }}</h3>
                        </div>
                        <i class="bi bi-file-earmark-text-fill text-info" style="font-size: 1.8rem;"></i>
                    </div>
                    <small class="text-muted">
                        <span class="badge bg-warning">{{ $stats['pending_applications'] }} Pending</span>
                    </small>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">System Status</p>
                            <h3 class="mb-0 fw-bold"><span class="badge bg-success">Online</span></h3>
                        </div>
                        <i class="bi bi-cloud-check-fill text-success" style="font-size: 1.8rem;"></i>
                    </div>
                    <small class="text-muted">All systems operational</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row g-3 mb-4">
        <!-- Recent Users -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-semibold">Recent Users</h5>
                    <small class="text-muted">Last 5 registered</small>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentUsers as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 0.75rem; font-weight: bold;">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                                {{ $user->name }}
                                            </div>
                                        </td>
                                        <td><small class="text-muted">{{ $user->email }}</small></td>
                                        <td>
                                            @if($user->role === 'admin')
                                                <span class="badge bg-danger">Admin</span>
                                            @elseif($user->role === 'employer')
                                                <span class="badge bg-primary">Employer</span>
                                            @else
                                                <span class="badge bg-info">Jobseeker</span>
                                            @endif
                                        </td>
                                        <td><small class="text-muted">{{ $user->created_at->diffForHumans() }}</small></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">No users yet</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Job Postings -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-semibold">Recent Job Postings</h5>
                    <small class="text-muted">Last 5 posted</small>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Job Title</th>
                                    <th>Employer</th>
                                    <th>Status</th>
                                    <th>Posted</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentJobs as $job)
                                    <tr>
                                        <td><strong>{{ Str::limit($job->title, 20) }}</strong></td>
                                        <td><small class="text-muted">{{ Str::limit($job->employer_name, 15) }}</small></td>
                                        <td>
                                            @if($job->status === 'active')
                                                <span class="badge bg-success">Active</span>
                                            @elseif($job->status === 'closed')
                                                <span class="badge bg-secondary">Closed</span>
                                            @else
                                                <span class="badge bg-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td><small class="text-muted">{{ $job->created_at->diffForHumans() }}</small></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">No job postings yet</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Applications -->
    <div class="row g-3">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-semibold">Recent Job Applications</h5>
                    <small class="text-muted">Last 5 applications</small>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Applicant</th>
                                    <th>Job Title</th>
                                    <th>Status</th>
                                    <th>Applied</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentApplications as $application)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm rounded-circle bg-info text-white d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 0.75rem; font-weight: bold;">
                                                    {{ strtoupper(substr($application->user->name, 0, 1)) }}
                                                </div>
                                                {{ $application->user->name }}
                                            </div>
                                        </td>
                                        <td><strong>{{ Str::limit($application->job->title ?? 'N/A', 25) }}</strong></td>
                                        <td>
                                            @if($application->status === 'accepted')
                                                <span class="badge bg-success">Accepted</span>
                                            @elseif($application->status === 'rejected')
                                                <span class="badge bg-danger">Rejected</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @endif
                                        </td>
                                        <td><small class="text-muted">{{ $application->created_at->diffForHumans() }}</small></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">No applications yet</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Actions Modal -->
<div class="modal fade" id="quickActionsModal" tabindex="-1" aria-labelledby="quickActionsLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quickActionsLabel">Admin Quick Actions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-grid gap-2">
                    <a href="#" class="btn btn-outline-primary">
                        <i class="bi bi-person-plus me-2"></i>Add New User
                    </a>
                    <a href="#" class="btn btn-outline-primary">
                        <i class="bi bi-briefcase-plus me-2"></i>Post New Job
                    </a>
                    <a href="#" class="btn btn-outline-primary">
                        <i class="bi bi-file-earmark me-2"></i>View Reports
                    </a>
                    <a href="#" class="btn btn-outline-primary">
                        <i class="bi bi-gear me-2"></i>System Settings
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@include('components.footer')
@endsection

