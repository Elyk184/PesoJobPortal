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

    .topbar-clock-container {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .topbar-analog-clock {
        width: 100px;
        height: 100px;
        border: 3px solid #3b82f6;
        border-radius: 50%;
        background: white;
        position: relative;
        box-shadow: 0 0 8px rgba(59, 130, 246, 0.2), inset 0 0 4px rgba(59, 130, 246, 0.1);
    }

    .clock-center {
        position: absolute;
        width: 8px;
        height: 8px;
        background: #3b82f6;
        border-radius: 50%;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 10;
    }

    .clock-hand {
        position: absolute;
        bottom: 50%;
        left: 50%;
        transform-origin: bottom center;
        background: #1e293b;
        border-radius: 10px;
    }

    .clock-hand.hour {
        width: 5px;
        height: 25px;
        margin-left: -2.5px;
        background: #1e293b;
    }

    .clock-hand.minute {
        width: 4px;
        height: 33px;
        margin-left: -2px;
        background: #3b82f6;
    }

    .clock-hand.second {
        width: 2px;
        height: 35px;
        margin-left: -1px;
        background: #ef4444;
    }

    .clock-tick {
        position: absolute;
        width: 1px;
        height: 6px;
        background: #64748b;
        left: 50%;
        transform-origin: left 50px;
        margin-left: -0.5px;
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
                    <i class="bi bi-file-earmark-check"></i>
                    <span>Application Approvals</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="{{ route('admin.employer-verification') }}" class="sidebar-menu-link">
                    <i class="bi bi-building"></i>
                    <span>Employer Verification</span>
                    @if(($adminSidebarCounts['pendingEmployerVerification'] ?? 0) > 0)
                        <span class="badge badge-pending">{{ $adminSidebarCounts['pendingEmployerVerification'] }}</span>
                    @endif
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="{{ route('admin.job-approvals') }}" class="sidebar-menu-link">
                    <i class="bi bi-file-check"></i>
                    <span>Job Approvals</span>
                    @if(($adminSidebarCounts['pendingJobApprovals'] ?? 0) > 0)
                        <span class="badge badge-pending" style="background:#0ea5e9;">{{ $adminSidebarCounts['pendingJobApprovals'] }}</span>
                    @endif
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
                    @if(($adminSidebarCounts['pendingPesoClearances'] ?? 0) > 0)
                        <span class="sidebar-badge" style="background:#f59e0b;">{{ $adminSidebarCounts['pendingPesoClearances'] }}</span>
                    @endif
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
                    @if(($adminSidebarCounts['adminUnreadNotifications'] ?? 0) > 0)
                        <span class="sidebar-badge">{{ $adminSidebarCounts['adminUnreadNotifications'] }}</span>
                    @endif
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
                    <div class="topbar-clock-container">
                        <div class="topbar-analog-clock" id="analogClock">
                            <div class="clock-tick" style="transform: rotate(0deg);"></div>
                            <div class="clock-tick" style="transform: rotate(30deg);"></div>
                            <div class="clock-tick" style="transform: rotate(60deg);"></div>
                            <div class="clock-tick" style="transform: rotate(90deg);"></div>
                            <div class="clock-tick" style="transform: rotate(120deg);"></div>
                            <div class="clock-tick" style="transform: rotate(150deg);"></div>
                            <div class="clock-tick" style="transform: rotate(180deg);"></div>
                            <div class="clock-tick" style="transform: rotate(210deg);"></div>
                            <div class="clock-tick" style="transform: rotate(240deg);"></div>
                            <div class="clock-tick" style="transform: rotate(270deg);"></div>
                            <div class="clock-tick" style="transform: rotate(300deg);"></div>
                            <div class="clock-tick" style="transform: rotate(330deg);"></div>
                            <div class="clock-hand hour" id="hourHand"></div>
                            <div class="clock-hand minute" id="minuteHand"></div>
                            <div class="clock-hand second" id="secondHand"></div>
                            <div class="clock-center"></div>
                        </div>
                        <div class="topbar-time">
                            <div class="topbar-time-display" id="currentTime">--:--</div>
                            <div class="topbar-date-display" id="currentDate">--/--/----</div>
                        </div>
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

            <!-- Analytics Charts Section -->
            <div class="row mb-4">
                <!-- Comprehensive Approvals Analytics Chart -->
                <div class="col-lg-12 mb-4">
                    <div class="dashboard-card modern-chart-card">
                        <div class="chart-header">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <h5 style="margin: 0; font-weight: 800; color: #0f172a;"><i class="bi bi-graph-up me-2" style="color: #3b82f6;"></i>All Approvals Analytics</h5>
                                    <p style="margin: 0.5rem 0 0 0; font-size: 12px; color: #64748b;">Combined view of all system approvals (Applications, Jobs, Documents)</p>
                                </div>
                                <div style="display: flex; gap: 0.5rem;">
                                    <button class="btn btn-sm btn-outline-secondary analytics-filter active" data-period="week">Week</button>
                                    <button class="btn btn-sm btn-outline-secondary analytics-filter" data-period="month">Month</button>
                                    <button class="btn btn-sm btn-outline-secondary analytics-filter" data-period="year">Year</button>
                                    <button class="btn btn-sm btn-outline-secondary analytics-filter" data-period="day">Day</button>
                                </div>
                            </div>
                        </div>
                        <div style="position: relative; height: 350px; display: flex; align-items: center; justify-content: center; margin: 2rem 0;">
                            <canvas id="approvalsAnalyticsChart"></canvas>
                        </div>
                        <div class="chart-stats" style="grid-template-columns: repeat(4, 1fr);">
                            <div class="stat-box info">
                                <div class="stat-number">{{ $stats['total_applications'] }}</div>
                                <div class="stat-text">Total Applications</div>
                            </div>
                            <div class="stat-box danger">
                                <div class="stat-number">{{ $stats['pending_job_approvals'] }}</div>
                                <div class="stat-text">Pending Jobs</div>
                            </div>
                            <div class="stat-box warning">
                                <div class="stat-number">{{ $stats['pending_lra_sra'] }}</div>
                                <div class="stat-text">LRA/SRA Requests</div>
                            </div>
                            <div class="stat-box success">
                                <div class="stat-number">{{ $stats['pending_documents'] }}</div>
                                <div class="stat-text">Pending Documents</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                .modern-chart-card {
                    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
                    border: 1px solid #e2e8f0;
                    padding: 2rem !important;
                    border-radius: 16px !important;
                    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06), inset 0 1px 0 rgba(255, 255, 255, 0.6) !important;
                    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                    position: relative;
                    overflow: hidden;
                }

                .modern-chart-card::before {
                    content: '';
                    position: absolute;
                    top: 0;
                    right: -50%;
                    width: 300px;
                    height: 300px;
                    background: radial-gradient(circle, rgba(59, 130, 246, 0.08) 0%, transparent 70%);
                    border-radius: 50%;
                    pointer-events: none;
                }

                .modern-chart-card:hover {
                    transform: translateY(-8px);
                    box-shadow: 0 16px 48px rgba(0, 0, 0, 0.12), inset 0 1px 0 rgba(255, 255, 255, 0.6) !important;
                    border-color: #cbd5e1;
                }

                .chart-header {
                    position: relative;
                    z-index: 1;
                    margin-bottom: 0.5rem;
                    padding-bottom: 1rem;
                    border-bottom: 2px solid #f1f5f9;
                }

                .chart-stats {
                    display: grid;
                    grid-template-columns: repeat(3, 1fr);
                    gap: 1rem;
                    margin-top: 1.5rem;
                    position: relative;
                    z-index: 1;
                }

                .stat-box {
                    padding: 1rem;
                    border-radius: 12px;
                    text-align: center;
                    backdrop-filter: blur(10px);
                    border: 1px solid rgba(255, 255, 255, 0.8);
                    transition: all 0.3s ease;
                }

                .stat-box:hover {
                    transform: translateY(-4px);
                }

                .stat-box.pending {
                    background: linear-gradient(135deg, #fff8e1 0%, #ffe5a6 100%);
                    border-color: #f59e0b;
                }

                .stat-box.success {
                    background: linear-gradient(135deg, #e6f9f3 0%, #c1f0e6 100%);
                    border-color: #10b981;
                }

                .stat-box.info {
                    background: linear-gradient(135deg, #e1f5ff 0%, #a6e3ff 100%);
                    border-color: #3b82f6;
                }

                .stat-box.danger {
                    background: linear-gradient(135deg, #ffe6e6 0%, #ffb3b3 100%);
                    border-color: #ef4444;
                }

                .stat-box.warning {
                    background: linear-gradient(135deg, #f5e6ff 0%, #e8b3ff 100%);
                    border-color: #8b5cf6;
                }

                .stat-number {
                    font-size: 32px;
                    font-weight: 900;
                    background: linear-gradient(135deg, #0f172a 0%, #334155 100%);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-clip: text;
                    margin-bottom: 0.5rem;
                }

                .stat-text {
                    font-size: 11px;
                    font-weight: 700;
                    color: #475569;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                }

                .analytics-filter {
                    background: #f1f5f9 !important;
                    color: #64748b !important;
                    border: 1px solid #e2e8f0 !important;
                    font-weight: 600;
                    font-size: 12px;
                    padding: 0.5rem 1rem !important;
                    border-radius: 8px;
                    transition: all 0.3s ease;
                    cursor: pointer;
                }

                .analytics-filter:hover {
                    background: #e2e8f0 !important;
                    border-color: #cbd5e1 !important;
                }

                .analytics-filter.active {
                    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
                    color: #fff !important;
                    border-color: #3b82f6 !important;
                    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
                }
            </style>

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
            <div class="row jobs-container">
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
                                            <button type="button" class="job-view-btn" onclick="openJobDetailModal({{ $job->id }})" data-job-id="{{ $job->id }}">View Details</button>
                                            <button type="button" class="job-trash-btn" onclick="openJobDeleteModal({{ $job->id }})" title="Delete this job"><i class="bi bi-trash3"></i></button>
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
    .jobs-container {
        display: flex;
        flex-direction: column;
        height: calc(100vh - 280px);
        overflow: hidden;
    }

    .jobs-container .col-12 {
        display: flex;
        flex: 1;
        overflow: hidden;
    }

    .jobs-container .dashboard-card {
        display: flex;
        flex-direction: column;
        height: 100%;
        overflow: hidden;
        width: 100%;
    }

    .jobs-container .dashboard-card > h5 {
        flex-shrink: 0;
        margin-bottom: 1rem;
    }

    .job-feed {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        max-width: 100%;
        flex: 1;
        overflow-y: auto;
        padding-right: 0.5rem;
    }

    .job-feed::-webkit-scrollbar {
        width: 8px;
    }

    .job-feed::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }

    .job-feed::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    .job-feed::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    .empty-state {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .job-post {
        background: white;
        border: 1.5px solid #d1d5db;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.05);
        padding: 0.6rem;
    }

    .job-post:hover {
        box-shadow: 0 12px 32px rgba(59, 130, 246, 0.2);
        transform: translateY(-4px);
        border-color: #3b82f6;
    }

    .job-post-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 0;
        border-bottom: 1px solid #f0f0f0;
        gap: 0.4rem;
        margin-bottom: 0.4rem;
    }

    .job-post-company {
        display: flex;
        align-items: flex-start;
        gap: 0.4rem;
        flex: 1;
        min-width: 0;
    }

    .job-company-avatar {
        width: 28px;
        height: 28px;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.875rem;
        flex-shrink: 0;
    }

    .job-company-info {
        display: flex;
        flex-direction: column;
        min-width: 0;
    }

    .job-company-name {
        font-weight: 700;
        color: #1e293b;
        font-size: 12px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .job-post-date {
        font-size: 10px;
        color: #64748b;
        margin-top: 0px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .job-post-status {
        display: flex;
        gap: 0.5rem;
    }

    .job-post-content {
        padding: 0;
    }

    .job-title {
        font-size: 14px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 0.35rem 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.35;
    }

    .job-description {
        font-size: 11px;
        color: #475569;
        line-height: 1.35;
        margin: 0 0 0.45rem 0;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .job-meta {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .job-meta-item {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 10px;
        color: #475569;
        font-weight: 600;
        white-space: nowrap;
    }

    .job-meta-item i {
        color: #3b82f6;
        font-size: 12px;
    }

    .job-post-footer {
        padding: 0;
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .job-view-btn {
        padding: 0.35rem 0.65rem;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        text-decoration: none;
        border-radius: 4px;
        font-size: 10px;
        font-weight: 700;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }
    .job-view-btn:hover {
        box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4);
        transform: translateY(-1px);
    }

    .job-trash-btn {
        padding: 0.35rem 0.5rem;
        background: #f3f4f6;
        color: #ef4444;
        border: none;
        border-radius: 4px;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .job-trash-btn:hover {
        background: #ef4444;
        color: white;
        transform: scale(1.05);
    }

    /* Job Detail Modal Styles */
    .job-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        animation: fadeIn 0.3s ease;
    }

    .job-modal.show {
        display: flex !important;
        align-items: center;
        justify-content: center;
    }

    .job-modal-content {
        background: white;
        border-radius: 12px;
        width: 90%;
        max-width: 700px;
        max-height: 85vh;
        overflow-y: auto;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        animation: slideUp 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from {
            transform: translateY(30px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .job-modal-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .job-modal-close {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #64748b;
        transition: color 0.2s ease;
    }

    .job-modal-close:hover {
        color: #1e293b;
    }

    .job-modal-body {
        padding: 1.5rem;
    }

    .job-detail-section {
        margin-bottom: 1.5rem;
    }

    .job-detail-label {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    .job-detail-value {
        font-size: 15px;
        font-weight: 600;
        color: #1e293b;
    }

    .job-modal-loader {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 3rem 1.5rem;
    }

    .spinner {
        border: 3px solid #f0f0f0;
        border-top: 3px solid #3b82f6;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Delete Modal Styles */
    .delete-modal {
        display: none;
        position: fixed;
        z-index: 10000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .delete-modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .delete-modal-content {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        max-width: 500px;
        width: 90%;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        animation: slideUp 0.3s ease;
    }

    .delete-modal-header {
        font-size: 20px;
        font-weight: 700;
        color: #ef4444;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .delete-modal-body {
        margin-bottom: 1.5rem;
    }

    .delete-reason-input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        font-size: 14px;
        font-family: inherit;
        resize: vertical;
        min-height: 80px;
    }

    .delete-reason-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .delete-reason-label {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
        display: block;
    }

    .delete-modal-footer {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }

    .delete-cancel-btn {
        padding: 0.6rem 1.2rem;
        background: #f3f4f6;
        color: #1e293b;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .delete-cancel-btn:hover {
        background: #e5e7eb;
    }

    .delete-confirm-btn {
        padding: 0.6rem 1.2rem;
        background: #ef4444;
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .delete-confirm-btn:hover {
        background: #dc2626;
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

    // Job Detail Modal Functions
    function openJobDetailModal(jobId) {
        const modal = document.getElementById('jobDetailModal');
        const modalContent = document.getElementById('jobDetailContent');

        // Show loader
        modalContent.innerHTML = '<div class="job-modal-loader"><div class="spinner"></div></div>';
        modal.classList.add('show');

        // Fetch job details via AJAX
        fetch(`/api/jobs/${jobId}/detail`)
            .then(response => response.json())
            .then(data => {
                renderJobDetailModal(data);
            })
            .catch(error => {
                modalContent.innerHTML = '<div class="job-modal-body"><p class="text-danger">Error loading job details</p></div>';
            });
    }

    function closeJobDetailModal() {
        const modal = document.getElementById('jobDetailModal');
        modal.classList.remove('show');
    }

    function renderJobDetailModal(job) {
        const modalContent = document.getElementById('jobDetailContent');

        const formatDate = (dateString) => {
            if (!dateString) return 'N/A';
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });
        };

        let html = `
            <div class="job-modal-header">
                <h4 class="mb-0">${escapeHtml(job.title)}</h4>
                <button type="button" class="job-modal-close" onclick="closeJobDetailModal()">×</button>
            </div>
            <div class="job-modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="job-detail-section">
                            <div class="job-detail-label">Company</div>
                            <div class="job-detail-value">${escapeHtml(job.employer_name)}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="job-detail-section">
                            <div class="job-detail-label">Status</div>
                            <div class="job-detail-value">
                                <span class="badge badge-active">${job.status.toUpperCase()}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="job-detail-section">
                            <div class="job-detail-label">Location</div>
                            <div class="job-detail-value">${escapeHtml(job.location)}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="job-detail-section">
                            <div class="job-detail-label">Employment Type</div>
                            <div class="job-detail-value">${escapeHtml(job.job_type.replace('_', ' ').toUpperCase())}</div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="job-detail-section">
                            <div class="job-detail-label">Salary Range</div>
                            <div class="job-detail-value">${escapeHtml(job.salary_range || job.salary || 'Competitive')}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="job-detail-section">
                            <div class="job-detail-label">Vacancies</div>
                            <div class="job-detail-value">${job.vacancies}</div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="job-detail-section">
                    <div class="job-detail-label">Description</div>
                    <div class="job-detail-value" style="font-weight: 400; white-space: pre-wrap;">${escapeHtml(job.description)}</div>
                </div>

                ${job.key_responsibilities ? `
                    <hr>
                    <div class="job-detail-section">
                        <div class="job-detail-label">Key Responsibilities</div>
                        <div class="job-detail-value" style="font-weight: 400; white-space: pre-wrap;">${escapeHtml(job.key_responsibilities)}</div>
                    </div>
                ` : ''}

                ${job.qualifications ? `
                    <hr>
                    <div class="job-detail-section">
                        <div class="job-detail-label">Qualifications</div>
                        <div class="job-detail-value" style="font-weight: 400; white-space: pre-wrap;">${escapeHtml(job.qualifications)}</div>
                    </div>
                ` : ''}

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <div class="job-detail-label">Posted Date</div>
                        <div class="job-detail-value">${formatDate(job.created_at)}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="job-detail-label">Deadline</div>
                        <div class="job-detail-value">${formatDate(job.application_end_date)}</div>
                    </div>
                </div>
            </div>
        `;

        modalContent.innerHTML = html;
    }

    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Close modal when clicking outside
    document.getElementById('jobDetailModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeJobDetailModal();
        }
    });

    // Job Delete Modal Functions
    function openJobDeleteModal(jobId) {
        const modal = document.getElementById('jobDeleteModal');
        document.getElementById('deleteJobId').value = jobId;
        document.getElementById('deleteReason').value = '';
        modal.classList.add('show');
    }

    function closeJobDeleteModal() {
        const modal = document.getElementById('jobDeleteModal');
        modal.classList.remove('show');
    }

    function submitJobDelete() {
        const jobId = document.getElementById('deleteJobId').value;
        const reason = document.getElementById('deleteReason').value.trim();

        if (!reason) {
            alert('Please provide a reason for deletion');
            return;
        }

        if (reason.length < 10) {
            alert('Reason must be at least 10 characters long');
            return;
        }

        // Send delete request
        fetch(`/api/jobs/${jobId}/delete`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ reason: reason })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Job post has been archived successfully');
                closeJobDeleteModal();
                location.reload();
            } else {
                alert(data.message || 'Error deleting job');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting job post');
        });
    }

    // Close modal when clicking outside
    document.getElementById('jobDeleteModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeJobDeleteModal();
        }
    });
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

<!-- Job Detail Modal -->
<div id="jobDetailModal" class="job-modal">
    <div class="job-modal-content" id="jobDetailContent">
        <!-- Modal content will be loaded here -->
    </div>
</div>

<!-- Job Delete Modal -->
<div id="jobDeleteModal" class="delete-modal">
    <div class="delete-modal-content">
        <div class="delete-modal-header">
            <i class="bi bi-exclamation-triangle-fill"></i>
            Archive Job Post
        </div>
        <div class="delete-modal-body">
            <p style="color: #64748b; margin-bottom: 1rem;">This job will be moved to archives and can be restored later if needed.</p>

            <label class="delete-reason-label">Reason for Archiving (Required)</label>
            <textarea id="deleteReason" class="delete-reason-input" placeholder="Please provide a detailed reason for archiving this job posting..."></textarea>
        </div>
        <div class="delete-modal-footer">
            <button type="button" class="delete-cancel-btn" onclick="closeJobDeleteModal()">Cancel</button>
            <button type="button" class="delete-confirm-btn" onclick="submitJobDelete()">Archive Job</button>
        </div>
        <input type="hidden" id="deleteJobId" value="">
    </div>
</div>

<script>
    // Update clock every second
    function updateClock() {
        const now = new Date();
        
        // Get time components
        const hours = now.getHours();
        const minutes = now.getMinutes();
        const seconds = now.getSeconds();
        const milliseconds = now.getMilliseconds();
        
        // Format time (HH:MM)
        const timeString = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;
        
        // Format date (MMM DD, YYYY)
        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const month = monthNames[now.getMonth()];
        const day = now.getDate();
        const year = now.getFullYear();
        const dateString = `${month} ${day}, ${year}`;
        
        // Update digital display
        const timeElement = document.getElementById('currentTime');
        const dateElement = document.getElementById('currentDate');
        
        if (timeElement) timeElement.textContent = timeString;
        if (dateElement) dateElement.textContent = dateString;
        
        // Calculate analog clock hand angles
        // Hour hand: 360 / 12 hours = 30 degrees per hour + 0.5 degrees per minute
        const hourDegrees = (hours % 12) * 30 + minutes * 0.5 + seconds * 0.5 / 60;
        
        // Minute hand: 360 / 60 minutes = 6 degrees per minute
        const minuteDegrees = minutes * 6 + seconds * 0.1;
        
        // Second hand: 360 / 60 seconds = 6 degrees per second (smooth with milliseconds)
        const secondDegrees = seconds * 6 + (milliseconds / 1000) * 6;
        
        // Update analog clock hands
        const hourHand = document.getElementById('hourHand');
        const minuteHand = document.getElementById('minuteHand');
        const secondHand = document.getElementById('secondHand');
        
        if (hourHand) hourHand.style.transform = `rotate(${hourDegrees}deg)`;
        if (minuteHand) minuteHand.style.transform = `rotate(${minuteDegrees}deg)`;
        if (secondHand) secondHand.style.transform = `rotate(${secondDegrees}deg)`;
    }
    
    // Update clock immediately and then frequently for smooth second hand
    updateClock();
    setInterval(updateClock, 50); // Update every 50ms for smooth motion

    // Initialize Charts
    document.addEventListener('DOMContentLoaded', function() {
        // Load Chart.js library
        const script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js';
        script.onload = function() {
            initializeCharts();
        };
        document.head.appendChild(script);
    });

    function initializeCharts() {
        // Comprehensive Approvals Analytics Chart
        const approvalsCtx = document.getElementById('approvalsAnalyticsChart');
        if (approvalsCtx) {
            const ctx = approvalsCtx.getContext('2d');
            
            // Generate dates based on selected period
            const generateDateLabels = (period) => {
                const today = new Date();
                const labels = [];
                let count = 7; // Default for week

                if (period === 'day') {
                    count = 24; // hourly
                    for (let i = 23; i >= 0; i--) {
                        const hour = new Date(today);
                        hour.setHours(today.getHours() - i);
                        labels.push(hour.getHours() + ':00');
                    }
                } else if (period === 'week') {
                    count = 7; // daily
                    const dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                    for (let i = 6; i >= 0; i--) {
                        const date = new Date(today);
                        date.setDate(today.getDate() - i);
                        labels.push(dayNames[date.getDay()] + ' ' + date.getDate());
                    }
                } else if (period === 'month') {
                    count = 4; // weekly
                    for (let i = 3; i >= 0; i--) {
                        const date = new Date(today);
                        date.setDate(today.getDate() - (i * 7));
                        labels.push('W' + Math.ceil(date.getDate() / 7));
                    }
                } else if (period === 'year') {
                    count = 12; // monthly
                    const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    for (let i = 11; i >= 0; i--) {
                        const date = new Date(today);
                        date.setMonth(today.getMonth() - i);
                        labels.push(monthNames[date.getMonth()] + ' ' + date.getFullYear().toString().slice(-2));
                    }
                }
                return labels;
            };

            // Generate data function
            const generateData = (count) => Array.from({ length: count }, () => Math.floor(Math.random() * 20) + 5);

            let chart = null;

            const updateChart = (period) => {
                const labels = generateDateLabels(period);
                const count = labels.length;
                
                const datasets = [
                    {
                        label: 'Applications',
                        data: generateData(count),
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5,
                        pointBackgroundColor: '#3b82f6',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointHoverRadius: 8
                    },
                    {
                        label: 'Job Approvals',
                        data: generateData(count),
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5,
                        pointBackgroundColor: '#ef4444',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointHoverRadius: 8
                    },
                    {
                        label: 'LRA/SRA Requests',
                        data: generateData(count),
                        borderColor: '#8b5cf6',
                        backgroundColor: 'rgba(139, 92, 246, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5,
                        pointBackgroundColor: '#8b5cf6',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointHoverRadius: 8
                    },
                    {
                        label: 'Documents',
                        data: generateData(count),
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5,
                        pointBackgroundColor: '#10b981',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointHoverRadius: 8
                    }
                ];

                if (chart) {
                    chart.data.labels = labels;
                    chart.data.datasets = datasets;
                    chart.update('active');
                } else {
                    chart = new Chart(approvalsCtx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: datasets
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: {
                                intersect: false,
                                mode: 'index'
                            },
                            animation: {
                                duration: 1000,
                                easing: 'easeInOutQuart'
                            },
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top',
                                    labels: {
                                        font: { size: 13, weight: '600' },
                                        color: '#0f172a',
                                        padding: 15,
                                        usePointStyle: true,
                                        pointStyle: 'circle'
                                    }
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                                    padding: 16,
                                    titleFont: { size: 14, weight: '700' },
                                    bodyFont: { size: 13 },
                                    borderColor: 'rgba(255, 255, 255, 0.2)',
                                    borderWidth: 1
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.08)',
                                        drawBorder: false
                                    },
                                    ticks: {
                                        font: { size: 12, weight: '600' },
                                        color: '#64748b',
                                        padding: 10
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false,
                                        drawBorder: false
                                    },
                                    ticks: {
                                        font: { size: 12, weight: '600' },
                                        color: '#64748b'
                                    }
                                }
                            }
                        }
                    });
                }
            };

            updateChart('week');

            // Filter button listeners
            document.querySelectorAll('.analytics-filter').forEach(button => {
                button.addEventListener('click', function() {
                    document.querySelectorAll('.analytics-filter').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    updateChart(this.dataset.period);
                });
            });
        }
    }
</script>

@endsection

