@extends('layouts.app')

@section('title', 'Jobseeker Registration Approvals | PESO Admin')

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

    .data-table {
        font-size: 13px;
    }

    .data-table thead {
        background: #f3f4f6;
    }

    .data-table th {
        color: #0d1f3c;
        font-weight: 700;
        border-bottom: 2px solid #e5e7eb;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .data-table td {
        padding: 13px 10px;
        vertical-align: middle;
        font-weight: 500;
    }

    .data-table tbody tr:hover {
        background: #f9fafb;
    }

    .badge-role {
        font-size: 11px;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: 600;
        display: inline-block;
    }

    .badge-active {
        background: #d1fae5;
        color: #065f46;
    }

    .badge-pending {
        background: #fed7aa;
        color: #92400e;
    }

    .empty-state {
        text-align: center;
        padding: 2rem;
        color: #9ca3af;
        font-size: 14px;
    }

    .btn-sm {
        font-size: 12px;
        padding: 5px 12px;
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
    }
</style>

<div class="admin-wrapper">
    <!-- Sidebar (reuse from admin dashboard) -->
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

            <li style="padding: 0 1.5rem; margin: 0.5rem 0; opacity: 0.6;">
                <small style="text-transform: uppercase; font-weight: 700; letter-spacing: 1px; font-size: 10px;">Management</small>
            </li>

            <li class="sidebar-menu-item">
                <a href="{{ route('admin.jobseekers-management') }}" class="sidebar-menu-link">
                    <i class="bi bi-people"></i>
                    <span>Jobseekers Management</span>
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
                    <h2><i class="bi bi-person-check-fill me-2"></i>Jobseeker Registration Approvals</h2>
                    <div class="topbar-subtitle">Review and approve pending jobseeker registrations</div>
                </div>
            </div>
            <button class="toggle-sidebar-btn" id="toggleSidebar">
                <i class="bi bi-list"></i>
            </button>
        </div>

        <!-- Content -->
        <div class="dashboard-card">
            @if($pendingJobseekers->count() > 0)
                <!-- Approvals Table -->
                <table class="table data-table w-100">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Registered</th>
                            <th>Profile Status</th>
                            <th>Applications</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingJobseekers as $jobseeker)
                            <tr>
                                <td><strong>{{ $jobseeker->name }}</strong></td>
                                <td><small class="text-muted">{{ Str::limit($jobseeker->email, 30) }}</small></td>
                                <td><small>{{ $jobseeker->created_at->format('d M, Y') }}</small></td>
                                <td>
                                    @if($jobseeker->profile)
                                        <span class="badge badge-active">Completed</span>
                                    @else
                                        <span class="badge bg-secondary">Incomplete</span>
                                    @endif
                                </td>
                                <td>
                                    @php $appCount = $jobseeker->applications->count(); @endphp
                                    <span class="badge bg-light text-dark">{{ $appCount }}</span>
                                </td>
                                <td class="text-center">
                                    <form method="POST" class="d-inline-flex gap-2">
                                        @csrf
                                        <button type="submit" formaction="{{ route('admin.jobseekers.approve', $jobseeker) }}" 
                                                class="btn btn-sm btn-success">
                                            <i class="bi bi-check-circle"></i> Approve
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" 
                                                data-bs-target="#rejectModal{{ $jobseeker->id }}">
                                            <i class="bi bi-x-circle"></i> Reject
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Rejection Modal -->
                            <div class="modal fade" id="rejectModal{{ $jobseeker->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Reject Registration</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST" action="{{ route('admin.jobseekers.reject', $jobseeker) }}">
                                            @csrf
                                            <div class="modal-body">
                                                <p class="text-muted mb-3">Rejecting: <strong>{{ $jobseeker->name }}</strong></p>
                                                <div class="mb-3">
                                                    <label for="rejection_reason_{{ $jobseeker->id }}" class="form-label">
                                                        Reason <span class="text-danger">*</span>
                                                    </label>
                                                    <textarea 
                                                        id="rejection_reason_{{ $jobseeker->id }}"
                                                        name="rejection_reason" 
                                                        class="form-control" 
                                                        rows="4" 
                                                        placeholder="Explain the rejection reason..."
                                                        required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Reject</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $pendingJobseekers->links('pagination::bootstrap-5') }}
                </div>
            @else
                <!-- Empty State -->
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <strong>All caught up!</strong> No pending jobseeker registrations to review.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>
    </main>
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

        // Close sidebar when clicking a menu item (mobile)
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
