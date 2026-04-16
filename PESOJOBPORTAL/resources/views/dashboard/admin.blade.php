@extends('layouts.app')

@section('title', 'Admin Dashboard | PESO Job Portal')

@section('content')
<style>
    /* Hide navbar on admin dashboard */
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
    }

    body {
        background: #f5f7fa;
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
        background: linear-gradient(180deg, #0f2d52 0%, #1f4b8f 100%);
        color: white;
        padding: 2rem 0;
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        overflow-y: auto;
        box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
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
        padding: 0 1.5rem;
        margin-bottom: 2rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding-bottom: 1.5rem;
    }

    .sidebar-user {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .sidebar-user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 18px;
    }

    .sidebar-user-name {
        flex: 1;
    }

    .sidebar-user-name h6 {
        margin: 0;
        font-size: 13px;
        font-weight: 600;
    }

    .sidebar-user-name p {
        margin: 2px 0 0 0;
        font-size: 11px;
        opacity: 0.8;
    }

    .sidebar-menu {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .sidebar-menu-item {
        margin: 0;
        padding: 0;
    }

    .sidebar-menu-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 1.5rem;
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 14px;
        font-weight: 500;
    }

    .sidebar-menu-link:hover {
        color: white;
        background: rgba(255, 255, 255, 0.1);
        padding-left: 1.75rem;
    }

    .sidebar-menu-link.active {
        color: white;
        background: rgba(215, 38, 56, 0.2);
        border-right: 3px solid #d72638;
        padding-right: calc(1.5rem - 3px);
    }

    .sidebar-menu-link i {
        font-size: 18px;
        min-width: 18px;
    }

    .sidebar-menu-divider {
        height: 1px;
        background: rgba(255, 255, 255, 0.1);
        margin: 1rem 0;
    }

    .admin-main {
        margin-left: 260px;
        flex: 1;
        padding: 2rem;
    }

    .admin-dashboard {
        background: transparent;
        min-height: 100%;
    }

    .stat-card {
        background: white;
        border-left: 4px solid #0f2d52;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
    }

    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: #0f2d52;
        margin: 10px 0;
    }

    .stat-label {
        font-size: 13px;
        color: #666;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-icon {
        font-size: 2rem;
        opacity: 0.1;
        position: absolute;
        right: 15px;
        top: 15px;
    }

    .dashboard-card {
        background: white;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .dashboard-card h5 {
        color: #0f2d52;
        font-weight: 700;
        margin-bottom: 1rem;
        border-bottom: 2px solid #d72638;
        padding-bottom: 0.75rem;
    }

    .data-table {
        font-size: 13px;
    }

    .data-table th {
        background: #f8f9fa;
        color: #0f2d52;
        font-weight: 700;
        border-bottom: 2px solid #e9ecef;
    }

    .data-table td {
        padding: 12px 8px;
        vertical-align: middle;
    }

    .data-table tbody tr:hover {
        background: #f8f9fa;
    }

    .badge-role {
        font-size: 11px;
        padding: 4px 8px;
        border-radius: 4px;
    }

    .badge-admin {
        background: #dc2626;
        color: white;
    }

    .badge-employer {
        background: #2563eb;
        color: white;
    }

    .badge-jobseeker {
        background: #16a34a;
        color: white;
    }

    .badge-active {
        background: #10b981;
        color: white;
    }

    .badge-pending {
        background: #f59e0b;
        color: white;
    }

    .badge-closed {
        background: #6b7280;
        color: white;
    }

    .header-section {
        display: none;
    }

    .logout-btn {
        background: #d72638;
        border: none;
        border-radius: 6px;
        padding: 8px 16px;
        color: white;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    .logout-btn:hover {
        background: #b81a2d;
    }

    .quick-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .list-item {
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .list-item:last-child {
        border-bottom: none;
    }

    .list-item-label {
        flex: 1;
        font-size: 13px;
    }

    .list-item-value {
        font-weight: 600;
        color: #0f2d52;
    }

    .empty-state {
        text-align: center;
        padding: 2rem;
        color: #999;
    }

    /* Top Bar with Title */
    .admin-topbar {
        background: white;
        padding: 1rem 0;
        margin-bottom: 1.5rem;
        border-bottom: 2px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .admin-topbar h2 {
        margin: 0;
        color: #0f2d52;
        font-weight: 700;
    }

    .admin-topbar-right {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .toggle-sidebar-btn {
        display: none;
        background: #0f2d52;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 18px;
    }

    @media (max-width: 768px) {
        .admin-sidebar {
            position: fixed;
            left: -260px;
            width: 260px;
            height: 100vh;
            transition: left 0.3s ease;
            z-index: 200;
            top: 0;
        }

        .admin-sidebar.show {
            left: 0;
        }

        .admin-main {
            margin-left: 0;
            padding: 1rem;
        }

        .toggle-sidebar-btn {
            display: block;
        }

        .quick-stats {
            grid-template-columns: 1fr;
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
                <a href="#" class="sidebar-menu-link active">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="#" class="sidebar-menu-link">
                    <i class="bi bi-people"></i>
                    <span>Users</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="#" class="sidebar-menu-link">
                    <i class="bi bi-briefcase"></i>
                    <span>Jobs</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="#" class="sidebar-menu-link">
                    <i class="bi bi-file-earmark-check"></i>
                    <span>Applications</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="#" class="sidebar-menu-link">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Reports</span>
                </a>
            </li>

            <li style="padding: 0; margin: 1rem 0;"><div class="sidebar-menu-divider"></div></li>

            <li class="sidebar-menu-item">
                <a href="#" class="sidebar-menu-link">
                    <i class="bi bi-bar-chart"></i>
                    <span>Analytics</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="#" class="sidebar-menu-link">
                    <i class="bi bi-gear"></i>
                    <span>Settings</span>
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
            <h2><i class="bi bi-speedometer2 me-2"></i>Dashboard</h2>
            <div class="admin-topbar-right">
                <button class="toggle-sidebar-btn" id="toggleSidebar">
                    <i class="bi bi-list"></i>
                </button>
            </div>
        </div>

        <div class="admin-dashboard">
            <!-- Quick Stats -->
            <div class="quick-stats">
                <div class="stat-card">
                    <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
                    <div class="stat-label">Total Users</div>
                    <div class="stat-value">{{ $stats['total_users'] }}</div>
                    <small style="color: #999;">
                        {{ $stats['total_employers'] }} employers &bull; {{ $stats['total_jobseekers'] }} jobseekers
                    </small>
                </div>

                <div class="stat-card">
                    <div class="stat-icon"><i class="bi bi-briefcase-fill"></i></div>
                    <div class="stat-label">Job Postings</div>
                    <div class="stat-value">{{ $stats['total_jobs'] }}</div>
                    <small style="color: #10b981;">✓ {{ $stats['active_jobs'] }} active</small>
                </div>

                <div class="stat-card">
                    <div class="stat-icon"><i class="bi bi-file-earmark-text-fill"></i></div>
                    <div class="stat-label">Applications</div>
                    <div class="stat-value">{{ $stats['total_applications'] }}</div>
                    <small style="color: #f59e0b;">⚠ {{ $stats['pending_applications'] }} pending</small>
                </div>

                <div class="stat-card">
                    <div class="stat-icon"><i class="bi bi-cloud-check-fill"></i></div>
                    <div class="stat-label">System Status</div>
                    <div class="stat-value" style="color: #10b981;">Online</div>
                    <small style="color: #999;">All systems operational</small>
                </div>
            </div>

            <!-- Main Content -->
            <div class="row">
                <!-- Recent Users -->
                <div class="col-lg-6 mb-4">
                    <div class="dashboard-card">
                        <h5><i class="bi bi-people me-2"></i>Recent Users</h5>
                        @if($recentUsers->count() > 0)
                            <table class="data-table w-100">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Joined</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentUsers as $user)
                                        <tr>
                                            <td>
                                                <strong>{{ Str::limit($user->name, 15) }}</strong>
                                            </td>
                                            <td>{{ Str::limit($user->email, 20) }}</td>
                                            <td>
                                                @if($user->role === 'admin')
                                                    <span class="badge badge-role badge-admin">Admin</span>
                                                @elseif($user->role === 'employer')
                                                    <span class="badge badge-role badge-employer">Employer</span>
                                                @else
                                                    <span class="badge badge-role badge-jobseeker">Jobseeker</span>
                                                @endif
                                            </td>
                                            <td><small>{{ $user->created_at->format('d M') }}</small></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="empty-state">No users yet</div>
                        @endif
                    </div>
                </div>

                <!-- Recent Jobs -->
                <div class="col-lg-6 mb-4">
                    <div class="dashboard-card">
                        <h5><i class="bi bi-briefcase me-2"></i>Recent Job Postings</h5>
                        @if($recentJobs->count() > 0)
                            <table class="data-table w-100">
                                <thead>
                                    <tr>
                                        <th>Job Title</th>
                                        <th>Employer</th>
                                        <th>Status</th>
                                        <th>Posted</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentJobs as $job)
                                        <tr>
                                            <td><strong>{{ Str::limit($job->title, 15) }}</strong></td>
                                            <td>{{ Str::limit($job->employer_name, 12) }}</td>
                                            <td>
                                                @if($job->status === 'active')
                                                    <span class="badge badge-role badge-active">Active</span>
                                                @elseif($job->status === 'closed')
                                                    <span class="badge badge-role badge-closed">Closed</span>
                                                @else
                                                    <span class="badge badge-role badge-pending">Pending</span>
                                                @endif
                                            </td>
                                            <td><small>{{ $job->created_at->format('d M') }}</small></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="empty-state">No jobs posted yet</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Recent Applications -->
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="dashboard-card">
                        <h5><i class="bi bi-file-earmark-check me-2"></i>Recent Job Applications</h5>
                        @if($recentApplications->count() > 0)
                            <table class="data-table w-100">
                                <thead>
                                    <tr>
                                        <th>Applicant</th>
                                        <th>Job Title</th>
                                        <th>Status</th>
                                        <th>Applied</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentApplications as $app)
                                        <tr>
                                            <td><strong>{{ Str::limit($app->user->name, 18) }}</strong></td>
                                            <td>{{ Str::limit($app->job->title ?? 'N/A', 20) }}</td>
                                            <td>
                                                @if($app->status === 'accepted')
                                                    <span class="badge badge-role badge-active">Accepted</span>
                                                @elseif($app->status === 'rejected')
                                                    <span class="badge badge-role" style="background: #dc2626; color: white;">Rejected</span>
                                                @else
                                                    <span class="badge badge-role badge-pending">Pending</span>
                                                @endif
                                            </td>
                                            <td><small>{{ $app->created_at->format('d M') }}</small></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="empty-state">No applications yet</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Role Breakdown & System Info -->
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="dashboard-card">
                        <h5><i class="bi bi-pie-chart me-2"></i>User Role Distribution</h5>
                        <div class="list-item">
                            <span class="list-item-label">👔 Employers</span>
                            <span class="list-item-value">{{ $stats['total_employers'] }}</span>
                        </div>
                        <div class="list-item">
                            <span class="list-item-label">👤 Jobseekers</span>
                            <span class="list-item-value">{{ $stats['total_jobseekers'] }}</span>
                        </div>
                        <div class="list-item">
                            <span class="list-item-label">🔐 Admins</span>
                            <span class="list-item-value">{{ $stats['total_admins'] }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="dashboard-card">
                        <h5><i class="bi bi-info-circle me-2"></i>System Information</h5>
                        <div class="list-item">
                            <span class="list-item-label">Current Time</span>
                            <span class="list-item-value">{{ now()->format('H:i') }}</span>
                        </div>
                        <div class="list-item">
                            <span class="list-item-label">Today's Date</span>
                            <span class="list-item-value">{{ now()->format('d M, Y') }}</span>
                        </div>
                        <div class="list-item">
                            <span class="list-item-label">Status</span>
                            <span class="list-item-value" style="color: #10b981;">✓ Online</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    // Sidebar toggle for mobile
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('adminSidebar');

    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });
    }

    // Close sidebar when clicking on a menu item (mobile)
    document.querySelectorAll('.sidebar-menu-link').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 768) {
                sidebar.classList.remove('show');
            }
        });
    });

    // Menu item active state
    document.querySelectorAll('.sidebar-menu-link').forEach(link => {
        link.addEventListener('click', function(e) {
            if (!this.closest('form')) {
                e.preventDefault();
                document.querySelectorAll('.sidebar-menu-link').forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            }
        });
    });
</script>

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
                <a href="#" class="sidebar-menu-link active">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="#" class="sidebar-menu-link">
                    <i class="bi bi-people"></i>
                    <span>Users</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="#" class="sidebar-menu-link">
                    <i class="bi bi-briefcase"></i>
                    <span>Jobs</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="#" class="sidebar-menu-link">
                    <i class="bi bi-file-earmark-check"></i>
                    <span>Applications</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="#" class="sidebar-menu-link">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Reports</span>
                </a>
            </li>

            <li style="padding: 0; margin: 1rem 0;"><div class="sidebar-menu-divider"></div></li>

            <li class="sidebar-menu-item">
                <a href="#" class="sidebar-menu-link">
                    <i class="bi bi-bar-chart"></i>
                    <span>Analytics</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="#" class="sidebar-menu-link">
                    <i class="bi bi-gear"></i>
                    <span>Settings</span>
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
            <h2><i class="bi bi-speedometer2 me-2"></i>Dashboard</h2>
            <div class="admin-topbar-right">
                <button class="toggle-sidebar-btn" id="toggleSidebar">
                    <i class="bi bi-list"></i>
                </button>
            </div>
        </div>

        <div class="admin-dashboard">
            <!-- Quick Stats -->
            <div class="quick-stats">
                <div class="stat-card">
                    <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
                    <div class="stat-label">Total Users</div>
                    <div class="stat-value">{{ $stats['total_users'] }}</div>
                    <small style="color: #999;">
                        {{ $stats['total_employers'] }} employers &bull; {{ $stats['total_jobseekers'] }} jobseekers
                    </small>
                </div>

                <div class="stat-card">
                    <div class="stat-icon"><i class="bi bi-briefcase-fill"></i></div>
                    <div class="stat-label">Job Postings</div>
                    <div class="stat-value">{{ $stats['total_jobs'] }}</div>
                    <small style="color: #10b981;">✓ {{ $stats['active_jobs'] }} active</small>
                </div>

                <div class="stat-card">
                    <div class="stat-icon"><i class="bi bi-file-earmark-text-fill"></i></div>
                    <div class="stat-label">Applications</div>
                    <div class="stat-value">{{ $stats['total_applications'] }}</div>
                    <small style="color: #f59e0b;">⚠ {{ $stats['pending_applications'] }} pending</small>
                </div>

                <div class="stat-card">
                    <div class="stat-icon"><i class="bi bi-cloud-check-fill"></i></div>
                    <div class="stat-label">System Status</div>
                    <div class="stat-value" style="color: #10b981;">Online</div>
                    <small style="color: #999;">All systems operational</small>
                </div>
            </div>

            <!-- Main Content -->
            <div class="row">
                <!-- Recent Users -->
                <div class="col-lg-6 mb-4">
                    <div class="dashboard-card">
                        <h5><i class="bi bi-people me-2"></i>Recent Users</h5>
                        @if($recentUsers->count() > 0)
                            <table class="data-table w-100">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Joined</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentUsers as $user)
                                        <tr>
                                            <td>
                                                <strong>{{ Str::limit($user->name, 15) }}</strong>
                                            </td>
                                            <td>{{ Str::limit($user->email, 20) }}</td>
                                            <td>
                                                @if($user->role === 'admin')
                                                    <span class="badge badge-role badge-admin">Admin</span>
                                                @elseif($user->role === 'employer')
                                                    <span class="badge badge-role badge-employer">Employer</span>
                                                @else
                                                    <span class="badge badge-role badge-jobseeker">Jobseeker</span>
                                                @endif
                                            </td>
                                            <td><small>{{ $user->created_at->format('d M') }}</small></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="empty-state">No users yet</div>
                        @endif
                    </div>
                </div>

                <!-- Recent Jobs -->
                <div class="col-lg-6 mb-4">
                    <div class="dashboard-card">
                        <h5><i class="bi bi-briefcase me-2"></i>Recent Job Postings</h5>
                        @if($recentJobs->count() > 0)
                            <table class="data-table w-100">
                                <thead>
                                    <tr>
                                        <th>Job Title</th>
                                        <th>Employer</th>
                                        <th>Status</th>
                                        <th>Posted</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentJobs as $job)
                                        <tr>
                                            <td><strong>{{ Str::limit($job->title, 15) }}</strong></td>
                                            <td>{{ Str::limit($job->employer_name, 12) }}</td>
                                            <td>
                                                @if($job->status === 'active')
                                                    <span class="badge badge-role badge-active">Active</span>
                                                @elseif($job->status === 'closed')
                                                    <span class="badge badge-role badge-closed">Closed</span>
                                                @else
                                                    <span class="badge badge-role badge-pending">Pending</span>
                                                @endif
                                            </td>
                                            <td><small>{{ $job->created_at->format('d M') }}</small></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="empty-state">No jobs posted yet</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Recent Applications -->
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="dashboard-card">
                        <h5><i class="bi bi-file-earmark-check me-2"></i>Recent Job Applications</h5>
                        @if($recentApplications->count() > 0)
                            <table class="data-table w-100">
                                <thead>
                                    <tr>
                                        <th>Applicant</th>
                                        <th>Job Title</th>
                                        <th>Status</th>
                                        <th>Applied</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentApplications as $app)
                                        <tr>
                                            <td><strong>{{ Str::limit($app->user->name, 18) }}</strong></td>
                                            <td>{{ Str::limit($app->job->title ?? 'N/A', 20) }}</td>
                                            <td>
                                                @if($app->status === 'accepted')
                                                    <span class="badge badge-role badge-active">Accepted</span>
                                                @elseif($app->status === 'rejected')
                                                    <span class="badge badge-role" style="background: #dc2626; color: white;">Rejected</span>
                                                @else
                                                    <span class="badge badge-role badge-pending">Pending</span>
                                                @endif
                                            </td>
                                            <td><small>{{ $app->created_at->format('d M') }}</small></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="empty-state">No applications yet</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Role Breakdown & System Info -->
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="dashboard-card">
                        <h5><i class="bi bi-pie-chart me-2"></i>User Role Distribution</h5>
                        <div class="list-item">
                            <span class="list-item-label">👔 Employers</span>
                            <span class="list-item-value">{{ $stats['total_employers'] }}</span>
                        </div>
                        <div class="list-item">
                            <span class="list-item-label">👤 Jobseekers</span>
                            <span class="list-item-value">{{ $stats['total_jobseekers'] }}</span>
                        </div>
                        <div class="list-item">
                            <span class="list-item-label">🔐 Admins</span>
                            <span class="list-item-value">{{ $stats['total_admins'] }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="dashboard-card">
                        <h5><i class="bi bi-info-circle me-2"></i>System Information</h5>
                        <div class="list-item">
                            <span class="list-item-label">Current Time</span>
                            <span class="list-item-value">{{ now()->format('H:i') }}</span>
                        </div>
                        <div class="list-item">
                            <span class="list-item-label">Today's Date</span>
                            <span class="list-item-value">{{ now()->format('d M, Y') }}</span>
                        </div>
                        <div class="list-item">
                            <span class="list-item-label">Status</span>
                            <span class="list-item-value" style="color: #10b981;">✓ Online</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    // Sidebar toggle for mobile
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('adminSidebar');

    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });
    }

    // Close sidebar when clicking on a menu item (mobile)
    document.querySelectorAll('.sidebar-menu-link').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 768) {
                sidebar.classList.remove('show');
            }
        });
    });

    // Menu item active state
    document.querySelectorAll('.sidebar-menu-link').forEach(link => {
        link.addEventListener('click', function(e) {
            if (!this.closest('form')) {
                e.preventDefault();
                document.querySelectorAll('.sidebar-menu-link').forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            }
        });
    });
</script>

@endsection

