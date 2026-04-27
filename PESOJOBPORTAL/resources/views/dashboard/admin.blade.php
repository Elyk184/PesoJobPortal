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
        font-family: 'Segoe UI', 'Inter', -apple-system, BlinkMacSystemFont, 'Helvetica Neue', sans-serif;
        font-weight: 400;
        letter-spacing: 0.3px;
    }

    body {
        background: #f8fafc;
        color: #0f172a;
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
        background: linear-gradient(180deg, #1e293b 0%, #0f172a 50%, #0f172a 100%);
        color: white;
        padding: 1.5rem 0;
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        overflow-y: auto;
        box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
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
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 20px;
        color: white;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
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
        background: rgba(59, 130, 246, 0.15);
        padding-left: 1.8rem;
        border-left-color: #3b82f6;
    }

    .sidebar-menu-link.active {
        color: #fff;
        background: linear-gradient(90deg, rgba(59, 130, 246, 0.2) 0%, rgba(59, 130, 246, 0.05) 100%);
        border-left-color: #3b82f6;
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
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 50%, #e2e8f0 100%);
    }

    .admin-dashboard {
        background: transparent;
        min-height: 100%;
    }

    .stat-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: none;
        border-radius: 16px;
        padding: 1.25rem 1rem;
        margin-bottom: 0;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12), 0 2px 8px rgba(0, 0, 0, 0.06);
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 100% 0%, rgba(255,255,255,0.3) 0%, transparent 70%);
        pointer-events: none;
        z-index: 0;
    }

    .stat-card::after {
        content: '';
        position: absolute;
        bottom: -30px;
        right: -30px;
        width: 120px;
        height: 120px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        border-radius: 50%;
        z-index: 0;
    }

    .stat-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 24px 48px rgba(0, 0, 0, 0.18), 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    /* Colored stat cards */
    .stat-card[data-color="primary"] {
        background: linear-gradient(135deg, #5B5DEE 0%, #3730A3 100%);
        color: white;
    }

    .stat-card[data-color="info"] {
        background: linear-gradient(135deg, #1E90FF 0%, #0066FF 100%);
        color: white;
    }

    .stat-card[data-color="warning"] {
        background: linear-gradient(135deg, #FFA500 0%, #FF8C00 100%);
        color: white;
    }

    .stat-card[data-color="danger"] {
        background: linear-gradient(135deg, #FF6B6B 0%, #EE5A6F 100%);
        color: white;
    }

    .stat-card[data-color="success"] {
        background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        color: white;
    }

    .stat-card[data-color="secondary"] {
        background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);
        color: white;
    }

    .stat-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.75rem;
        position: relative;
        z-index: 1;
    }

    .stat-card-icon-box {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
        flex-shrink: 0;
    }

    .stat-card-icon-box i {
        font-size: 1.75rem;
        color: rgba(255, 255, 255, 0.95);
    }

    .stat-card-mini-chart {
        display: flex;
        align-items: flex-end;
        gap: 2px;
        height: 35px;
        opacity: 0.8;
    }

    .stat-card-mini-bar {
        flex: 1;
        background: rgba(255, 255, 255, 0.4);
        border-radius: 3px;
        transition: background 0.3s ease;
    }

    .stat-card-mini-bar.high {
        background: rgba(255, 255, 255, 0.7);
    }

    .stat-value {
        font-size: 32px;
        font-weight: 900;
        color: inherit;
        margin: 8px 0 4px 0;
        letter-spacing: -0.5px;
        position: relative;
        z-index: 1;
    }

    .stat-card[data-color] .stat-value {
        color: white;
    }

    .stat-label {
        font-size: 11px;
        color: inherit;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        position: relative;
        z-index: 1;
        opacity: 0.95;
    }

    .stat-card[data-color] .stat-label {
        color: rgba(255, 255, 255, 0.9);
    }

    .stat-card-subtitle {
        font-size: 10px;
        margin-top: 0.4rem;
        position: relative;
        z-index: 1;
    }

    .stat-card[data-color] .stat-card-subtitle {
        color: rgba(255, 255, 255, 0.85);
    }

    .stat-icon {
        font-size: 3.5rem;
        opacity: 0.2;
        position: absolute;
        right: 15px;
        top: 15px;
        color: inherit;
    }

    .stat-card[data-color] .stat-icon {
        color: rgba(255, 255, 255, 0.25);
    }

    .stat-icon {
        font-size: 3.5rem;
        opacity: 0.2;
        position: absolute;
        right: 15px;
        top: 15px;
        color: inherit;
    }

    .stat-card[data-color] .stat-icon {
        color: rgba(255, 255, 255, 0.25);
    }

    .dashboard-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border-radius: 20px;
        padding: 2.25rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08), 0 2px 8px rgba(0, 0, 0, 0.04);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        position: relative;
        overflow: hidden;
    }

    .dashboard-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: #1a1a1a;
        border-radius: 20px 20px 0 0;
    }

    .dashboard-card:hover {
        box-shadow: 0 24px 48px rgba(59, 130, 246, 0.15), 0 8px 16px rgba(0, 0, 0, 0.1);
        transform: translateY(-8px);
    }

    .dashboard-card h5 {
        color: #1e293b;
        font-weight: 800;
        margin-bottom: 1.75rem;
        margin-top: 0;
        padding-bottom: 1.25rem;
        border-bottom: 2px solid #e2e8f0;
        font-size: 18px;
        letter-spacing: -0.3px;
    }
    
    .dashboard-card h5 i {
        color: #1a1a1a;
        margin-right: 0.5rem;
    }

    .data-table {
        font-size: 13px;
        width: 100%;
    }

    .data-table th {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        color: #1e293b;
        font-weight: 700;
        border-bottom: 2px solid #cbd5e1;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        padding: 1.25rem 1rem;
    }

    .data-table td {
        padding: 1.25rem 1rem;
        vertical-align: middle;
        font-weight: 500;
        color: #0f172a;
        border-bottom: 1px solid #e2e8f0;
    }

    .data-table tbody tr:last-child td {
        border-bottom: none;
    }

    .data-table tbody tr:hover {
        background: linear-gradient(90deg, #f8fafc 0%, #eef2f5 100%);
    }

    .badge-role {
        font-size: 11px;
        padding: 8px 12px;
        border-radius: 8px;
        font-weight: 700;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-admin {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e40af;
        box-shadow: 0 2px 8px rgba(30, 58, 138, 0.15);
    }

    .badge-employer {
        background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        color: #3730a3;
        box-shadow: 0 2px 8px rgba(55, 48, 163, 0.15);
    }

    .badge-jobseeker {
        background: linear-gradient(135deg, #ccfbf1 0%, #99f6e4 100%);
        color: #0d9488;
        box-shadow: 0 2px 8px rgba(13, 148, 136, 0.15);
    }

    .badge-active {
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        color: #166534;
        box-shadow: 0 2px 8px rgba(22, 101, 52, 0.15);
    }

    .badge-pending {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
        box-shadow: 0 2px 8px rgba(146, 64, 14, 0.15);
    }

    .badge-closed {
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        color: #374151;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .header-section {
        display: none;
    }

    .quick-stats {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 1.5rem;
        margin-bottom: 3.5rem;
        padding: 0;
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
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        padding: 2rem 2rem;
        margin-bottom: 2.5rem;
        border-bottom: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 2rem;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08), 0 2px 8px rgba(0, 0, 0, 0.04);
        border: none;
        backdrop-filter: none;
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
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        width: 80px;
        height: 80px;
        border-radius: 16px;
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
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
        color: #1e293b;
        font-weight: 800;
        font-size: 36px;
        letter-spacing: -0.5px;
    }

    .topbar-subtitle {
        font-size: 14px;
        color: #64748b;
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
        background: linear-gradient(135deg, #eff6ff 0%, #f0f9ff 100%);
        border-radius: 16px;
        border: 2px solid #bfdbfe;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.1);
    }

    .topbar-time {
        text-align: right;
    }

    .topbar-time-display {
        font-size: 22px;
        font-weight: 800;
        color: #1e293b;
        line-height: 1.1;
        letter-spacing: -0.3px;
    }

    .topbar-date-display {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    .topbar-datetime-icon {
        font-size: 28px;
        color: #3b82f6;
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

    /* Layout Improvements */
    .row {
        --bs-gutter-x: 2rem;
        --bs-gutter-y: 2rem;
    }

    .col-lg-6 {
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .mb-4 {
        margin-bottom: 2rem !important;
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
                <div class="stat-card" data-color="info">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-label">Job Postings</div>
                            <div class="stat-value">{{ $stats['total_jobs'] }}</div>
                            <div class="stat-card-subtitle">✓ {{ $stats['active_jobs'] }} active</div>
                        </div>
                        <div class="stat-card-icon-box">
                            <i class="bi bi-briefcase-fill"></i>
                        </div>
                    </div>
                    <div class="stat-card-mini-chart">
                        <div class="stat-card-mini-bar" style="height: 45%;"></div>
                        <div class="stat-card-mini-bar high" style="height: 65%;"></div>
                        <div class="stat-card-mini-bar high" style="height: 80%;"></div>
                        <div class="stat-card-mini-bar" style="height: 55%;"></div>
                        <div class="stat-card-mini-bar high" style="height: 75%;"></div>
                    </div>
                </div>

                <div class="stat-card" data-color="warning">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-label">Applications</div>
                            <div class="stat-value">{{ $stats['total_applications'] }}</div>
                            <div class="stat-card-subtitle">⚠ {{ $stats['pending_applications'] }} pending</div>
                        </div>
                        <div class="stat-card-icon-box">
                            <i class="bi bi-file-earmark-text-fill"></i>
                        </div>
                    </div>
                    <div class="stat-card-mini-chart">
                        <div class="stat-card-mini-bar high" style="height: 60%;"></div>
                        <div class="stat-card-mini-bar" style="height: 35%;"></div>
                        <div class="stat-card-mini-bar high" style="height: 90%;"></div>
                        <div class="stat-card-mini-bar" style="height: 50%;"></div>
                        <div class="stat-card-mini-bar high" style="height: 70%;"></div>
                    </div>
                </div>

                <div class="stat-card" data-color="danger">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-label">Pending Job Approvals</div>
                            <div class="stat-value">{{ $stats['pending_job_approvals'] }}</div>
                            <a href="{{ route('admin.job-approvals') }}" style="color: rgba(255,255,255,0.95); text-decoration: none; font-weight: 700; font-size: 12px; display: inline-block; margin-top: 0.5rem;">Review →</a>
                        </div>
                        <div class="stat-card-icon-box">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                    </div>
                    <div class="stat-card-mini-chart">
                        <div class="stat-card-mini-bar" style="height: 20%;"></div>
                        <div class="stat-card-mini-bar" style="height: 15%;"></div>
                        <div class="stat-card-mini-bar" style="height: 25%;"></div>
                        <div class="stat-card-mini-bar" style="height: 10%;"></div>
                        <div class="stat-card-mini-bar" style="height: 30%;"></div>
                    </div>
                </div>

                <div class="stat-card" data-color="secondary">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-label">Pending LRA/SRA Requests</div>
                            <div class="stat-value">{{ $stats['pending_lra_sra'] }}</div>
                            <a href="{{ route('admin.lra-sra-approvals') }}" style="color: rgba(255,255,255,0.95); text-decoration: none; font-weight: 700; font-size: 12px; display: inline-block; margin-top: 0.5rem;">Review →</a>
                        </div>
                        <div class="stat-card-icon-box">
                            <i class="bi bi-file-earmark-check"></i>
                        </div>
                    </div>
                    <div class="stat-card-mini-chart">
                        <div class="stat-card-mini-bar" style="height: 18%;"></div>
                        <div class="stat-card-mini-bar" style="height: 22%;"></div>
                        <div class="stat-card-mini-bar" style="height: 12%;"></div>
                        <div class="stat-card-mini-bar" style="height: 28%;"></div>
                        <div class="stat-card-mini-bar" style="height: 15%;"></div>
                    </div>
                </div>

                <div class="stat-card" data-color="success">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-label">Pending Document Approvals</div>
                            <div class="stat-value">{{ $stats['pending_documents'] }}</div>
                            <a href="{{ route('admin.document-verification') }}" style="color: rgba(255,255,255,0.95); text-decoration: none; font-weight: 700; font-size: 12px; display: inline-block; margin-top: 0.5rem;">Review →</a>
                        </div>
                        <div class="stat-card-icon-box">
                            <i class="bi bi-shield-check"></i>
                        </div>
                    </div>
                    <div class="stat-card-mini-chart">
                        <div class="stat-card-mini-bar" style="height: 25%;"></div>
                        <div class="stat-card-mini-bar" style="height: 35%;"></div>
                        <div class="stat-card-mini-bar" style="height: 20%;"></div>
                        <div class="stat-card-mini-bar" style="height: 40%;"></div>
                        <div class="stat-card-mini-bar" style="height: 30%;"></div>
                    </div>
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
                        <h5><i class="bi bi-briefcase me-2"></i>All Posted Jobs</h5>
                        @if($recentJobs->count() > 0)
                            <div class="job-feed">
                                @foreach($recentJobs as $job)
                                    <div class="job-post">
                                        <div class="job-post-header">
                                            <div class="job-post-company">
                                                <div class="job-company-avatar">
                                                    <i class="bi bi-building"></i>
                                                </div>
                                                <div class="job-company-info">
                                                    <div class="job-company-name">{{ Str::limit($job->employer_name, 25) }}</div>
                                                    <div class="job-post-date">Posted {{ $job->created_at->diffForHumans() }}</div>
                                                </div>
                                            </div>
                                            <div class="job-post-status">
                                                @if($job->status === 'active')
                                                    <span class="badge badge-role badge-active">Active</span>
                                                @elseif($job->status === 'closed')
                                                    <span class="badge badge-role badge-closed">Closed</span>
                                                @else
                                                    <span class="badge badge-role badge-pending">Pending</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="job-post-content">
                                            <h6 class="job-title">{{ Str::limit($job->title, 50) }}</h6>
                                            <p class="job-description">{{ Str::limit($job->description, 120) }}</p>
                                            <div class="job-meta">
                                                <span class="job-meta-item">
                                                    <i class="bi bi-geo-alt"></i> {{ Str::limit($job->location ?? 'Remote', 20) }}
                                                </span>
                                                <span class="job-meta-item">
                                                    <i class="bi bi-cash-coin"></i> {{ $job->salary_range ?? 'Competitive' }}
                                                </span>
                                                <span class="job-meta-item">
                                                    <i class="bi bi-file-text"></i> {{ $job->employment_type ?? 'Full-time' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="job-post-footer">
                                            <a href="{{ route('admin.jobs.review', $job) }}" class="job-view-btn">View Details</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="bi bi-briefcase"></i>
                                <p>No Jobs Posted Yet</p>
                                <small>All job postings will be displayed here</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
    .job-feed {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .job-post {
        background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%);
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .job-post:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        transform: translateY(-2px);
    }

    .job-post-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0.75rem;
        border-bottom: 1px solid #f0f0f0;
    }

    .job-post-company {
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .job-company-avatar {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1rem;
    }

    .job-company-info {
        display: flex;
        flex-direction: column;
    }

    .job-company-name {
        font-weight: 700;
        color: #1e293b;
        font-size: 11px;
    }

    .job-post-date {
        font-size: 9px;
        color: #64748b;
        margin-top: 0px;
    }

    .job-post-status {
        display: flex;
        gap: 0.5rem;
    }

    .job-post-content {
        padding: 0.5rem 0.75rem;
    }

    .job-title {
        font-size: 11px;
        font-weight: 800;
        color: #1e293b;
        margin: 0 0 0.25rem 0;
    }

    .job-description {
        font-size: 9px;
        color: #475569;
        line-height: 1.3;
        margin: 0 0 0.4rem 0;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .job-meta {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .job-meta-item {
        display: flex;
        align-items: center;
        gap: 0.2rem;
        font-size: 8px;
        color: #64748b;
        font-weight: 600;
    }

    .job-meta-item i {
        color: #3b82f6;
        font-size: 10px;
    }

    .job-post-footer {
        padding: 0.4rem 0.75rem;
        display: flex;
        gap: 0.4rem;
    }

    .job-view-btn {
        padding: 0.3rem 0.6rem;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        text-decoration: none;
        border-radius: 4px;
        font-size: 8px;
        font-weight: 700;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
    }

    .job-view-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(59, 130, 246, 0.3);
    }
</style>

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

