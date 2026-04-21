@extends('layouts.app')

@section('title', $jobseeker->name . ' - Jobseeker Registration Review')

@section('content')
<style>
    /* Hide navbar on admin pages */
    .peso-header {
        display: none !important;
    }
    
    nav {
        display: none !important;
    }
    
    .navbar {
        display: none !important;
    }

    html, body {
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', 'Inter', -apple-system, BlinkMacSystemFont, 'Helvetica Neue', sans-serif;
        font-weight: 400;
        letter-spacing: 0.3px;
    }

    body {
        background: #f7f9fc;
        color: #1f2937;
    }
    
    .peso-main {
        margin: 0;
        padding: 0;
    }

    .admin-wrapper {
        display: flex;
        min-height: 100vh;
        margin-top: 0;
    }

    .admin-sidebar {
        width: 260px;
        background: linear-gradient(180deg, #0d1f3c 0%, #1a3a5c 100%);
        color: white;
        padding: 1.5rem 0;
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        overflow-y: auto;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 100;
    }

    .admin-sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .admin-sidebar::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
    }

    .admin-sidebar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 3px;
    }

    .admin-sidebar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    .sidebar-header {
        padding: 1.25rem 1.5rem;
        margin-bottom: 1.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        padding-bottom: 1.5rem;
    }

    .sidebar-user {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .sidebar-user-avatar {
        width: 44px;
        height: 44px;
        border-radius: 8px;
        background: linear-gradient(135deg, #d72638 0%, #ff6b7a 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 18px;
        color: white;
        box-shadow: 0 2px 8px rgba(215, 38, 56, 0.3);
    }

    .sidebar-user-name {
        color: white;
    }

    .sidebar-user-name h6 {
        margin: 0;
        font-size: 14px;
        font-weight: 700;
    }

    .sidebar-user-name p {
        margin: 0;
        font-size: 12px;
        opacity: 0.75;
        font-weight: 500;
    }

    .sidebar-menu {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .sidebar-menu-item {
        margin: 0;
    }

    .sidebar-menu-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 11px 1.5rem;
        color: rgba(255, 255, 255, 0.75);
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s ease;
        border-left: 3px solid transparent;
    }

    .sidebar-menu-link:hover {
        color: white;
        background: rgba(255, 255, 255, 0.08);
        border-left-color: #ff6b7a;
    }

    .sidebar-menu-link.active {
        color: white;
        background: rgba(215, 38, 56, 0.2);
        border-left-color: #ff6b7a;
    }

    .sidebar-menu-link i {
        font-size: 16px;
    }

    .sidebar-menu-divider {
        height: 1px;
        background: rgba(255, 255, 255, 0.1);
        margin: 0;
    }

    .admin-main {
        margin-left: 260px;
        padding: 2.5rem;
        width: calc(100% - 260px);
        flex: 1;
    }

    .admin-topbar {
        background: transparent;
        padding: 1rem 0 1.5rem 0;
        margin-bottom: 2rem;
        border-bottom: 2px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 2rem;
    }

    .admin-topbar-left {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex: 1;
    }

    .topbar-title {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .admin-topbar h2 {
        margin: 0;
        color: #0d1f3c;
        font-weight: 700;
        font-size: 28px;
        letter-spacing: -0.5px;
    }

    .topbar-subtitle {
        font-size: 13px;
        color: #6b7280;
        font-weight: 500;
        letter-spacing: 0.3px;
    }

    .dashboard-card {
        background: white;
        border-radius: 10px;
        padding: 1.75rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        margin-bottom: 1.5rem;
    }

    .dashboard-card h5 {
        color: #0d1f3c;
        font-weight: 700;
        margin-bottom: 1.25rem;
        border-bottom: 2px solid #d72638;
        padding-bottom: 0.75rem;
        font-size: 16px;
        letter-spacing: 0.3px;
    }

    .list-group-item {
        border: 1px solid #e5e7eb;
    }

    .badge {
        font-size: 11px;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: 600;
        display: inline-block;
    }

    .toggle-sidebar-btn {
        display: none;
        background: #0d1f3c;
        color: white;
        border: none;
        padding: 10px 14px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 18px;
        transition: all 0.2s ease;
    }

    @media (max-width: 768px) {
        .admin-sidebar {
            position: fixed;
            left: -260px;
            width: 260px;
            height: 100vh;
            transition: left 0.3s ease;
            z-index: 200;
        }

        .admin-sidebar.show {
            left: 0;
        }

        .admin-main {
            margin-left: 0;
            padding: 1.5rem;
            width: 100%;
        }

        .admin-topbar {
            flex-direction: column;
            gap: 1rem;
        }

        .admin-topbar-left {
            width: 100%;
        }

        .admin-topbar h2 {
            font-size: 20px;
        }

        .toggle-sidebar-btn {
            display: block;
        }

        .row > [class*="col"] {
            margin-bottom: 1rem;
        }
    }
</style>

<div class="admin-wrapper">
    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-header">
            <div class="sidebar-user">
                <div class="sidebar-user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="sidebar-user-name">
                    <h6>{{ Str::limit(auth()->user()->name, 15) }}</h6>
                    <p>Administrator</p>
                </div>
            </div>
        </div>

        <ul class="sidebar-menu">
            <li class="sidebar-menu-item">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-link">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li style="padding: 0; margin: 1rem 0;"><div class="sidebar-menu-divider"></div></li>

            <li style="padding: 0 1.5rem; margin: 0.5rem 0; opacity: 0.6;">
                <small style="text-transform: uppercase; font-weight: 700; letter-spacing: 1px; font-size: 10px;">Approvals & Verification</small>
            </li>

            <li class="sidebar-menu-item">
                <a href="{{ route('admin.jobseekers.index') }}" class="sidebar-menu-link active">
                    <i class="bi bi-person-check"></i>
                    <span>Jobseeker Approvals</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="{{ route('admin.employer-verification') }}" class="sidebar-menu-link">
                    <i class="bi bi-building"></i>
                    <span>Employer Verification</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="{{ route('admin.job-approvals') }}" class="sidebar-menu-link">
                    <i class="bi bi-file-check"></i>
                    <span>Job Approvals</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="{{ route('admin.lra-sra-approvals') }}" class="sidebar-menu-link">
                    <i class="bi bi-clipboard-check"></i>
                    <span>LRA/SRA Approvals</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="{{ route('admin.document-verification') }}" class="sidebar-menu-link">
                    <i class="bi bi-file-earmark"></i>
                    <span>Document Verification</span>
                </a>
            </li>

            <li style="padding: 0; margin: 1rem 0;"><div class="sidebar-menu-divider"></div></li>

            <li class="sidebar-menu-item">
                <a href="{{ route('logout') }}" class="sidebar-menu-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">@csrf</form>
    </aside>

    <!-- Main Content -->
    <main class="admin-main">
        <!-- Top Bar -->
        <div class="admin-topbar">
            <div class="admin-topbar-left">
                <div class="topbar-title">
                    <h2>{{ $jobseeker->name }}</h2>
                    <div class="topbar-subtitle">
                        @if($jobseeker->is_approved === null)
                            <span class="badge bg-warning">Pending Approval</span>
                        @elseif($jobseeker->is_approved)
                            <span class="badge bg-success">Approved</span>
                        @else
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </div>
                </div>
            </div>
            <a href="{{ route('admin.jobseekers.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back
            </a>
            <button class="toggle-sidebar-btn" id="toggleSidebar">
                <i class="bi bi-list"></i>
            </button>
        </div>

        <div class="row">
            <!-- Main Details -->
            <div class="col-lg-8">
                <!-- Contact Information Card -->
                <div class="dashboard-card">
                    <h5><i class="bi bi-envelope-fill me-2"></i>Contact Information</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Email</small>
                            <strong>{{ $jobseeker->email }}</strong>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Registered</small>
                            <strong>{{ $jobseeker->created_at->format('d M, Y h:i A') }}</strong>
                        </div>
                    </div>
                </div>

                <!-- Profile Information Card -->
                @if($jobseeker->profile)
                    <div class="dashboard-card">
                        <h5><i class="bi bi-person-badge-fill me-2"></i>Profile Information</h5>
                        <div class="row">
                            @if($jobseeker->profile->phone)
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Phone</small>
                                    <strong>{{ $jobseeker->profile->phone }}</strong>
                                </div>
                            @endif
                            @if($jobseeker->profile->date_of_birth)
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Date of Birth</small>
                                    <strong>{{ \Carbon\Carbon::parse($jobseeker->profile->date_of_birth)->format('d M, Y') }}</strong>
                                </div>
                            @endif
                            @if($jobseeker->profile->address)
                                <div class="col-12 mb-3">
                                    <small class="text-muted d-block">Address</small>
                                    <strong>{{ $jobseeker->profile->address }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Applications Card -->
                <div class="dashboard-card">
                    <h5><i class="bi bi-file-earmark-check me-2"></i>Applications <span class="badge bg-secondary ms-2">{{ $jobseeker->applications->count() }}</span></h5>
                    @if($jobseeker->applications->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Job Title</th>
                                        <th>Employer</th>
                                        <th>Status</th>
                                        <th>Applied</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jobseeker->applications as $app)
                                        <tr>
                                            <td><small>{{ Str::limit($app->job?->title ?? 'N/A', 25) }}</small></td>
                                            <td><small>{{ Str::limit($app->job?->employer_name ?? 'N/A', 20) }}</small></td>
                                            <td>
                                                @if($app->status === 'pending')
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @elseif($app->status === 'accepted')
                                                    <span class="badge bg-success">Accepted</span>
                                                @elseif($app->status === 'rejected')
                                                    <span class="badge bg-danger">Rejected</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ ucfirst($app->status) }}</span>
                                                @endif
                                            </td>
                                            <td><small>{{ $app->created_at->format('d M, Y') }}</small></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-info-circle me-2"></i>No applications yet.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar Actions -->
            <div class="col-lg-4">
                <!-- Status Card -->
                <div class="dashboard-card">
                    <h5>Registration Status</h5>
                    @if($jobseeker->is_approved === null)
                        <div class="alert alert-warning" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>Pending Review</strong>
                            <p class="mb-0 mt-2 small">This registration is awaiting approval.</p>
                        </div>

                        <!-- Approval Actions -->
                        <form method="POST" class="d-grid gap-2">
                            @csrf
                            <button type="submit" formaction="{{ route('admin.jobseekers.approve', $jobseeker) }}" 
                                    class="btn btn-lg btn-success">
                                <i class="bi bi-check-circle me-2"></i>Approve
                            </button>
                        </form>

                        <button type="button" class="btn btn-lg btn-danger w-100 mt-2" data-bs-toggle="modal" 
                                data-bs-target="#rejectModal">
                            <i class="bi bi-x-circle me-2"></i>Reject
                        </button>
                    @elseif($jobseeker->is_approved)
                        <div class="alert alert-success" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <strong>Approved</strong>
                            <p class="mb-0 mt-2 small">
                                Approved on: <strong>{{ $jobseeker->approved_at?->format('d M, Y h:i A') }}</strong>
                            </p>
                        </div>
                    @else
                        <div class="alert alert-danger" role="alert">
                            <i class="bi bi-x-circle-fill me-2"></i>
                            <strong>Rejected</strong>
                            <p class="mb-0 mt-2 small">
                                Reason: <strong>{{ $jobseeker->rejection_reason ?? 'No reason provided' }}</strong>
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Summary Card -->
                <div class="dashboard-card">
                    <h5>Summary</h5>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-muted">Total Applications</span>
                            <strong class="badge bg-secondary">{{ $jobseeker->applications->count() }}</strong>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-muted">Accepted</span>
                            <strong class="badge bg-success">{{ $jobseeker->applications->where('status', 'accepted')->count() }}</strong>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-muted">Profile Completed</span>
                            <strong class="badge {{ $jobseeker->profile ? 'bg-success' : 'bg-warning' }}">
                                {{ $jobseeker->profile ? 'Yes' : 'No' }}
                            </strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Rejection Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">Reject Registration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.jobseekers.reject', $jobseeker) }}">
                @csrf
                <div class="modal-body">
                    <p class="text-muted mb-3">You are about to reject <strong>{{ $jobseeker->name }}</strong>'s registration.</p>
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label">
                            Reason <span class="text-danger">*</span>
                        </label>
                        <textarea 
                            id="rejection_reason"
                            name="rejection_reason" 
                            class="form-control" 
                            rows="4" 
                            placeholder="Explain the rejection reason..."
                            required></textarea>
                        <small class="text-muted d-block mt-2">Minimum 10 characters.</small>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('adminSidebar');
        const toggleBtn = document.getElementById('toggleSidebar');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('show');
            });
        }

        document.querySelectorAll('.sidebar-menu-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('show');
                }
            });
        });
    });
</script>

@endsection
