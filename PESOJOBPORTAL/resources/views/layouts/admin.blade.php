@extends('layouts.app')

@section('content')
<style>
    /* Hide navbar on admin pages */
    .peso-header, nav, .navbar {
        display: none !important;
    }

    html, body {
        margin: 0;
        padding: 0;
        background: linear-gradient(135deg, #0d1625 0%, #1a2d45 50%, #0a1220 100%);
        color: #1f2937;
        font-family: 'Segoe UI', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        font-weight: 400;
        letter-spacing: 0.3px;
    }

    body {
        background: linear-gradient(135deg, #0d1625 0%, #1a2d45 50%, #0a1220 100%);
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
        background: linear-gradient(180deg, #0a1428 0%, #0f1f35 50%, #08141f 100%);
        color: white;
        padding: 1.5rem 0;
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        overflow-y: auto;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
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
        padding: 0;
    }

    .sidebar-menu-link {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 11px 1.5rem;
        color: rgba(255, 255, 255, 0.68);
        text-decoration: none;
        transition: all 0.25s ease;
        font-size: 14px;
        font-weight: 500;
        letter-spacing: 0.3px;
    }

    .sidebar-menu-link:hover {
        color: white;
        background: rgba(255, 255, 255, 0.08);
        padding-left: 1.8rem;
    }

    .sidebar-menu-link.active {
        color: #fff;
        background: rgba(215, 38, 56, 0.25);
        border-right: 3px solid #d72638;
        padding-right: calc(1.5rem - 3px);
        font-weight: 600;
    }

    .sidebar-menu-link i {
        font-size: 20px;
        min-width: 20px;
        opacity: 0.9;
    }

    .sidebar-menu-link.active i {
        opacity: 1;
    }

    .sidebar-menu-divider {
        height: 1px;
        background: rgba(255, 255, 255, 0.12);
        margin: 1rem 0;
    }

    .admin-main {
        margin-left: 260px;
        flex: 1;
        padding: 2.5rem;
        background: #ffffff;
    }

    .admin-dashboard {
        background: transparent;
    }

    .dashboard-card {
        background: white;
        border-radius: 10px;
        padding: 2rem;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        border: 1px solid #e5e7eb;
    }

    .dashboard-card h5 {
        margin: 0 0 1.5rem 0;
        color: #0d1f3c;
        font-weight: 700;
        font-size: 18px;
        letter-spacing: -0.3px;
    }

    .list-item {
        display: flex;
        justify-content: space-between;
        padding: 1rem 0;
        border-bottom: 1px solid #e5e7eb;
        color: #1f2937;
    }

    .list-item:last-child {
        border-bottom: none;
    }

    .list-item-label {
        flex: 1;
        font-size: 13px;
        color: #6b7280;
        font-weight: 500;
    }

    .list-item-value {
        font-weight: 700;
        color: #0d1f3c;
        font-size: 14px;
    }

    .empty-state {
        text-align: center;
        padding: 2rem;
        color: #9ca3af;
        font-size: 14px;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    /* Top Bar with Title */
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

    .topbar-logo {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .topbar-logo img {
        height: 56px;
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
            gap: 1rem;
            align-items: center;
        }

        .admin-topbar-left {
            width: 100%;
            flex-direction: row;
            justify-content: center;
        }

        .topbar-logo img {
            height: 48px;
        }

        .topbar-title {
            text-align: center;
        }

        .admin-topbar h2 {
            font-size: 20px;
        }

        .topbar-subtitle {
            font-size: 11px;
        }
    }
</style>

<div class="admin-wrapper">
    <!-- Sidebar Component -->
    <x-admin.sidebar />

    <!-- Main Content -->
    <main class="admin-main">
        <!-- Page Content -->
        @yield('admin-content')
    </main>
</div>

@endsection
