@extends('layouts.app')

@section('title', 'Admin Dashboard | Link Job Resource Portal')

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
        font-family: 'Segoe UI', 'Inter', -apple-system, BlinkMacSystemFont, 'Helvetica Neue', sans-serif;
        font-weight: 400;
        letter-spacing: 0.3px;
    }

    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        color: #1f2937;
        min-height: 100vh;
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
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        z-index: 100;
    }

    .admin-sidebar::-webkit-scrollbar {
        width: 8px;
    }

    .admin-sidebar::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
    }

    .admin-sidebar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.25);
        border-radius: 4px;
    }

    .admin-sidebar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.4);
    }

    .sidebar-header {
        padding: 1.5rem 1.5rem;
        margin-bottom: 1.5rem;
        border-bottom: 2px solid rgba(215, 38, 56, 0.3);
        padding-bottom: 1.5rem;
        background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.02) 100%);
    }

    .sidebar-header a:hover {
        background: rgba(255, 255, 255, 0.1) !important;
        border-radius: 8px;
    }

    .sidebar-user {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .sidebar-user-avatar {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: linear-gradient(135deg, #d72638 0%, #ff6b7a 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 20px;
        color: white;
        box-shadow: 0 4px 12px rgba(215, 38, 56, 0.4);
    }

    .sidebar-user-name {
        flex: 1;
    }

    .sidebar-user-name h6 {
        margin: 0;
        font-size: 14px;
        font-weight: 700;
        color: white;
        letter-spacing: 0.2px;
    }

    .sidebar-user-name p {
        margin: 4px 0 0 0;
        font-size: 12px;
        opacity: 0.8;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.7);
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
        gap: 14px;
        padding: 12px 1.5rem;
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 14px;
        font-weight: 500;
        letter-spacing: 0.3px;
        border-left: 3px solid transparent;
    }

    .sidebar-menu-link:hover {
        color: white;
        background: rgba(255, 255, 255, 0.1);
        padding-left: 1.8rem;
        border-left-color: #d72638;
    }

    .sidebar-menu-link.active {
        color: #fff;
        background: linear-gradient(90deg, rgba(215, 38, 56, 0.3) 0%, rgba(215, 38, 56, 0.1) 100%);
        border-left-color: #d72638;
        font-weight: 600;
    }

    .sidebar-menu-link i {
        font-size: 20px;
        min-width: 20px;
        opacity: 0.85;
    }

    .sidebar-menu-link.active i {
        opacity: 1;
    }

    .sidebar-menu-divider {
        height: 1px;
        background: linear-gradient(90deg, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0) 100%);
        margin: 1rem 0;
    }

    .admin-main {
        margin-left: 260px;
        flex: 1;
        padding: 2.5rem;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    .admin-dashboard {
        background: transparent;
        min-height: 100%;
    }

    .stat-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border-left: 5px solid #0d1f3c;
        border-radius: 12px;
        padding: 1.75rem;
        margin-bottom: 1rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, rgba(215, 38, 56, 0.08) 0%, rgba(215, 38, 56, 0) 100%);
        border-radius: 50%;
        transform: translate(30%, -30%);
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        border-left-color: #d72638;
    }

    .stat-value {
        font-size: 40px;
        font-weight: 800;
        color: #0d1f3c;
        margin: 12px 0 8px 0;
        letter-spacing: -0.5px;
    }

    .stat-label {
        font-size: 12px;
        color: #6b7280;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
    }

    .stat-icon {
        font-size: 2.5rem;
        opacity: 0.15;
        position: absolute;
        right: 15px;
        top: 15px;
    }

    .dashboard-card {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .dashboard-card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    .dashboard-card h5 {
        color: #0d1f3c;
        font-weight: 800;
        margin-bottom: 1.5rem;
        border-bottom: 3px solid #d72638;
        padding-bottom: 1rem;
        font-size: 17px;
        letter-spacing: -0.3px;
    }

    .data-table {
        font-size: 13px;
    }

    .data-table th {
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        color: #0d1f3c;
        font-weight: 800;
        border-bottom: 2px solid #d72638;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        padding: 1rem;
    }

    .data-table td {
        padding: 1rem;
        vertical-align: middle;
        font-weight: 500;
    }

    .data-table tbody tr:hover {
        background: linear-gradient(90deg, #f9fafb 0%, #f0f1f3 100%);
    }

    .badge-role {
        font-size: 11px;
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 700;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-admin {
        background: linear-gradient(135deg, #fecaca 0%, #fca5a5 100%);
        color: #7c2d12;
        box-shadow: 0 2px 8px rgba(220, 38, 38, 0.2);
    }

    .badge-employer {
        background: linear-gradient(135deg, #bfdbfe 0%, #93c5fd 100%);
        color: #1e3a8a;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.2);
    }

    .badge-jobseeker {
        background: linear-gradient(135deg, #bbf7d0 0%, #86efac 100%);
        color: #15803d;
        box-shadow: 0 2px 8px rgba(34, 197, 94, 0.2);
    }

    .badge-active {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.2);
    }

    .badge-pending {
        background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
        color: #92400e;
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.2);
    }

    .badge-closed {
        background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%);
        color: #374151;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .header-section {
        display: none;
    }

    .quick-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    .list-item {
        padding: 14px 0;
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
        color: #6b7280;
        font-weight: 600;
    }

    .list-item-value {
        font-weight: 800;
        color: #0d1f3c;
        font-size: 16px;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: #9ca3af;
        font-size: 14px;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.4;
        color: #d1d5db;
    }

    .empty-state p {
        margin: 1rem 0 0.5rem;
        font-weight: 600;
        color: #6b7280;
    }

    .empty-state small {
        color: #a1a5ab;
    }

    /* Top Bar with Title */
    .admin-topbar {
        background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.85) 100%);
        padding: 2rem 2rem;
        margin-bottom: 2.5rem;
        border-bottom: 3px solid #d72638;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 2rem;
        border-radius: 0 0 12px 12px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    .admin-topbar-left {
        display: flex;
        align-items: center;
        gap: 2rem;
        flex: 1;
    }

    .topbar-logo {
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #d72638 0%, #ff6b7a 100%);
        width: 80px;
        height: 80px;
        border-radius: 14px;
        box-shadow: 0 8px 20px rgba(215, 38, 56, 0.4);
        flex-shrink: 0;
    }

    .topbar-logo img {
        height: 50px;
        width: auto;
    }

    .topbar-title {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .admin-topbar h2 {
        margin: 0;
        color: #0d1f3c;
        font-weight: 800;
        font-size: 36px;
        letter-spacing: -0.5px;
    }

    .topbar-subtitle {
        font-size: 14px;
        color: #6b7280;
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    .admin-topbar-right {
        display: flex;
        gap: 1.5rem;
        align-items: center;
    }

    .topbar-datetime {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        padding: 1rem 1.75rem;
        background: linear-gradient(135deg, #0d1f3c 0%, #1a3a5c 100%);
        border-radius: 12px;
        border: 2px solid rgba(215, 38, 56, 0.3);
        box-shadow: 0 8px 20px rgba(13, 31, 60, 0.25);
    }

    .topbar-time {
        text-align: right;
    }

    .topbar-time-display {
        font-size: 22px;
        font-weight: 800;
        color: white;
        line-height: 1.1;
        letter-spacing: -0.3px;
    }

    .topbar-date-display {
        font-size: 13px;
        color: rgba(255, 255, 255, 0.75);
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    .topbar-datetime-icon {
        font-size: 28px;
        color: #d72638;
    }

    .toggle-sidebar-btn {
        display: none;
        background: linear-gradient(135deg, #0d1f3c 0%, #1a3a5c 100%);
        color: white;
        border: none;
        padding: 10px 14px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 18px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(13, 31, 60, 0.2);
    }

    .toggle-sidebar-btn:hover {
        background: linear-gradient(135deg, #152d52 0%, #1f5080 100%);
        box-shadow: 0 6px 16px rgba(13, 31, 60, 0.3);
        transform: translateY(-2px);
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
            padding: 1.5rem;
        }

        .admin-topbar {
            flex-direction: column;
            gap: 1.5rem;
            align-items: center;
            padding: 1.5rem 1rem;
        }

        .admin-topbar-left {
            width: 100%;
            flex-direction: row;
            justify-content: center;
            gap: 1.5rem;
        }

        .topbar-logo {
            height: 64px;
            width: 64px;
            flex-shrink: 0;
        }

        .topbar-logo img {
            height: 40px;
        }

        .topbar-title {
            text-align: center;
        }

        .admin-topbar h2 {
            font-size: 28px;
        }

        .topbar-subtitle {
            font-size: 12px;
        }

        .admin-topbar-right {
            width: 100%;
            gap: 1rem;
            justify-content: center;
        }

        .topbar-datetime {
            width: 100%;
            justify-content: center;
        }

        .toggle-sidebar-btn {
            display: block;
        }

        .quick-stats {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .stat-card {
            padding: 1.5rem;
        }

        .stat-value {
            font-size: 32px;
        }
    }
</style>

<div class="admin-wrapper">
    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-header">
            <a href="{{ route('admin.profile') }}" style="text-decoration: none; color: inherit; display: block; transition: all 0.3s ease; border-radius: 8px; padding: 0.5rem; margin: -0.5rem;">
                <div class="sidebar-user" style="cursor: pointer;">
                    <div class="sidebar-user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <div class="sidebar-user-name">
                        <h6>{{ Str::limit(auth()->user()->name, 15) }}</h6>
                        <p>Administrator</p>
                    </div>
                </div>
            </a>
        </div>

        <ul class="sidebar-menu">
            <!-- Dashboard -->
            <li class="sidebar-menu-item">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-link active">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li style="padding: 0; margin: 1rem 0;"><div class="sidebar-menu-divider"></div></li>

            <!-- Approvals & Verification Section -->
            <li style="padding: 0 1.5rem; margin: 0.5rem 0; opacity: 0.6;">
                <small style="text-transform: uppercase; font-weight: 700; letter-spacing: 1px; font-size: 10px;">Approvals & Verification</small>
            </li>

            <li class="sidebar-menu-item">
                <a href="{{ route('admin.jobseekers.index') }}" class="sidebar-menu-link">
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

            <!-- Management Section -->
            <li style="padding: 0 1.5rem; margin: 0.5rem 0; opacity: 0.6;">
                <small style="text-transform: uppercase; font-weight: 700; letter-spacing: 1px; font-size: 10px;">Management</small>
            </li>

            <li class="sidebar-menu-item">
                <a href="{{ route('admin.jobseekers-management') }}" class="sidebar-menu-link">
                    <i class="bi bi-people"></i>
                    <span>Jobseekers</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="{{ route('admin.employers-management') }}" class="sidebar-menu-link">
                    <i class="bi bi-shop"></i>
                    <span>Employers</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="{{ route('admin.jobs-management') }}" class="sidebar-menu-link">
                    <i class="bi bi-briefcase"></i>
                    <span>Jobs</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="{{ route('admin.applications-management') }}" class="sidebar-menu-link">
                    <i class="bi bi-file-earmark-check"></i>
                    <span>Applications</span>
                </a>
            </li>

            <li style="padding: 0; margin: 1rem 0;"><div class="sidebar-menu-divider"></div></li>

            <!-- Intelligence & Reports Section -->
            <li style="padding: 0 1.5rem; margin: 0.5rem 0; opacity: 0.6;">
                <small style="text-transform: uppercase; font-weight: 700; letter-spacing: 1px; font-size: 10px;">Intelligence & Reports</small>
            </li>

            <li class="sidebar-menu-item">
                <a href="{{ route('admin.employment-stats') }}" class="sidebar-menu-link">
                    <i class="bi bi-bar-chart-line"></i>
                    <span>Employment Stats</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="{{ route('admin.skills-gap-analysis') }}" class="sidebar-menu-link">
                    <i class="bi bi-diagram-3"></i>
                    <span>Skills Gap Analysis</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="{{ route('admin.barangay-intelligence') }}" class="sidebar-menu-link">
                    <i class="bi bi-map"></i>
                    <span>Barangay Intelligence</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="{{ route('admin.report-builder') }}" class="sidebar-menu-link">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Dynamic Report Builder</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="{{ route('admin.peso-clearances') }}" class="sidebar-menu-link">
                    <i class="bi bi-file-pdf"></i>
                    <span>PESO Clearances</span>
                </a>
            </li>



            <li style="padding: 0; margin: 1rem 0;"><div class="sidebar-menu-divider"></div></li>

            <!-- Tools & Settings Section -->
            <li style="padding: 0 1.5rem; margin: 0.5rem 0; opacity: 0.6;">
                <small style="text-transform: uppercase; font-weight: 700; letter-spacing: 1px; font-size: 10px;">Tools & Settings</small>
            </li>

            <li class="sidebar-menu-item">
                <a href="{{ route('admin.settings') }}" class="sidebar-menu-link">
                    <i class="bi bi-gear"></i>
                    <span>Settings</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="{{ route('admin.alerts-notifications') }}" class="sidebar-menu-link">
                    <i class="bi bi-bell"></i>
                    <span>Alerts & Notifications</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="{{ route('admin.qr-verification') }}" class="sidebar-menu-link">
                    <i class="bi bi-qr-code"></i>
                    <span>QR Verification</span>
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
                <div class="topbar-logo">
                    <img src="{{ asset('images/logo.png') }}" alt="PESO Logo">
                </div>
                <div class="topbar-title">
                    <h2><i class="bi bi-speedometer2 me-2"></i>Dashboard</h2>
                    <div class="topbar-subtitle">Welcome to PESO Admin Portal</div>
                </div>
            </div>
            <div class="admin-topbar-right">
                <div class="topbar-datetime">
                    <i class="bi bi-clock-history topbar-datetime-icon"></i>
                    <div class="topbar-time">
                        <div class="topbar-time-display" id="currentTime">--:--</div>
                        <div class="topbar-date-display" id="currentDate">--/--/----</div>
                    </div>
                </div>
                <button class="toggle-sidebar-btn" id="toggleSidebar">
                    <i class="bi bi-list"></i>
                </button>
            </div>
        </div>

        <div class="admin-dashboard">
            <!-- Quick Stats -->
            <div class="quick-stats">
                <div class="stat-card" style="border-left: 5px solid #10b981;">
                    <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
                    <div class="stat-label">Total Users</div>
                    <div class="stat-value">{{ $stats['total_users'] }}</div>
                    <small style="color: #6b7280; font-weight: 600;">
                        <span style="color: #1e40af;">{{ $stats['total_employers'] }}</span> employers • <span style="color: #065f46;">{{ $stats['total_jobseekers'] }}</span> jobseekers
                    </small>
                </div>

                <div class="stat-card" style="border-left: 5px solid #3b82f6;">
                    <div class="stat-icon"><i class="bi bi-briefcase-fill"></i></div>
                    <div class="stat-label">Job Postings</div>
                    <div class="stat-value">{{ $stats['total_jobs'] }}</div>
                    <small style="color: #10b981; font-weight: 600;">✓ {{ $stats['active_jobs'] }} active</small>
                </div>

                <div class="stat-card" style="border-left: 5px solid #f59e0b;">
                    <div class="stat-icon"><i class="bi bi-file-earmark-text-fill"></i></div>
                    <div class="stat-label">Applications</div>
                    <div class="stat-value">{{ $stats['total_applications'] }}</div>
                    <small style="color: #f59e0b; font-weight: 600;">⚠ {{ $stats['pending_applications'] }} pending</small>
                </div>

                <div class="stat-card" style="border-left: 5px solid #06b6d4;">
                    <div class="stat-icon"><i class="bi bi-cloud-check-fill"></i></div>
                    <div class="stat-label">System Status</div>
                    <div class="stat-value" style="color: #10b981; font-size: 24px;">●</div>
                    <small style="color: #10b981; font-weight: 600;">All systems operational</small>
                </div>

                <div class="stat-card" style="border-left: 5px solid #f59e0b;">
                    <div class="stat-icon" style="color: #f59e0b;"><i class="bi bi-hourglass-split"></i></div>
                    <div class="stat-label">Pending Job Approvals</div>
                    <div class="stat-value">{{ $stats['pending_job_approvals'] }}</div>
                    <a href="{{ route('admin.job-approvals') }}" style="color: #f59e0b; text-decoration: none; font-weight: 700; font-size: 12px;">Review →</a>
                </div>

                <div class="stat-card" style="border-left: 5px solid #f97316;">
                    <div class="stat-icon" style="color: #f97316;"><i class="bi bi-file-earmark-check"></i></div>
                    <div class="stat-label">Pending LRA/SRA Requests</div>
                    <div class="stat-value">{{ $stats['pending_lra_sra'] }}</div>
                    <a href="{{ route('admin.lra-sra-approvals') }}" style="color: #f97316; text-decoration: none; font-weight: 700; font-size: 12px;">Review →</a>
                </div>

                <div class="stat-card" style="border-left: 5px solid #ec4899;">
                    <div class="stat-icon" style="color: #ec4899;"><i class="bi bi-shield-check"></i></div>
                    <div class="stat-label">Pending Document Approvals</div>
                    <div class="stat-value">{{ $stats['pending_documents'] }}</div>
                    <a href="{{ route('admin.document-verification') }}" style="color: #ec4899; text-decoration: none; font-weight: 700; font-size: 12px;">Review →</a>
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
                            <div class="empty-state">
                                <i class="bi bi-inbox"></i>
                                <p>No Recent Users</p>
                                <small>Users will appear here as they register</small>
                            </div>
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
                                        <tr style="cursor: pointer;" onclick="window.location.href='{{ route('admin.jobs.review', $job) }}';" title="Click to review">
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
                            <div class="empty-state">
                                <i class="bi bi-briefcase"></i>
                                <p>No Recent Job Postings</p>
                                <small>New job listings will appear here</small>
                            </div>
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
                            <div class="empty-state">
                                <i class="bi bi-file-earmark-check"></i>
                                <p>No Recent Applications</p>
                                <small>Job applications will be displayed here</small>
                            </div>
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
            // Only prevent default for placeholder links (#)
            if (this.getAttribute('href') === '#') {
                e.preventDefault();
                document.querySelectorAll('.sidebar-menu-link').forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            }
        });
    });

    // Update date and time
    function updateDateTime() {
        const now = new Date();
        
        // Format time as HH:MM
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const timeString = `${hours}:${minutes}`;
        
        // Format date as MMM DD, YYYY
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const year = now.getFullYear();
        const dateString = `${month}/${day}/${year}`;
        
        // Update the display
        const timeElement = document.getElementById('currentTime');
        const dateElement = document.getElementById('currentDate');
        
        if (timeElement) {
            timeElement.textContent = timeString;
        }
        if (dateElement) {
            dateElement.textContent = dateString;
        }
    }

    // Update on page load immediately
    updateDateTime();
    
    // Update every second for live clock
    setInterval(updateDateTime, 1000);
</script>

<style>
    /* Clickable table rows styling */
    .data-table tbody tr[onclick] {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .data-table tbody tr[onclick]:hover {
        background: linear-gradient(90deg, rgba(0, 123, 255, 0.1) 0%, rgba(0, 123, 255, 0.05) 100%) !important;
        box-shadow: inset 0 0 0 1px rgba(0, 123, 255, 0.2);
        transform: scale(1.01);
    }

    .data-table tbody strong {
        color: #0d1f3c;
        font-weight: 700;
    }

    small {
        color: #6b7280;
        font-weight: 500;
    }
</style>

@endsection

