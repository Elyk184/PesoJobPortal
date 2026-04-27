@extends('layouts.app')

@section('title', 'Alerts & Notifications | PESO Admin')

@section('admin-content')
@include('admin.layouts.topbar', ['title' => 'Alerts & Notifications', 'subtitle' => 'Manage system alerts and notifications', 'icon' => 'bi-bell'])

<div class="admin-dashboard">
    <style>
        .alert-item { background: white; padding: 1.5rem; border-radius: 10px; margin-bottom: 1rem; box-shadow: 0 2px 10px rgba(0,0,0,0.06); display: flex; gap: 1.5rem; align-items: start; }
        .alert-icon { font-size: 24px; padding-top: 0.25rem; }
        .alert-info { flex: 1; }
        .alert-title { font-weight: 700; color: #0d1f3c; margin-bottom: 0.25rem; }
        .alert-message { color: #6b7280; font-size: 14px; margin-bottom: 0.5rem; }
        .alert-time { color: #9ca3af; font-size: 12px; }
        .alert-actions { display: flex; gap: 0.5rem; }
        .btn-small { padding: 0.5rem 1rem; border: none; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s ease; }
        .btn-dismiss { background: #e5e7eb; color: #1f2937; }
        .btn-dismiss:hover { background: #d1d5db; }
    </style>

    <div class="alert-item" style="border-left: 4px solid #fbbf24;">
        <div class="alert-icon" style="color: #fbbf24;"><i class="bi bi-exclamation-triangle-fill"></i></div>
        <div class="alert-info">
            <div class="alert-title">High Volume of Applications</div>
            <div class="alert-message">Received 45 new applications for Senior Software Engineer position in the last 24 hours.</div>
            <div class="alert-time">Sent 2 hours ago</div>
        </div>
        <div class="alert-actions">
            <button class="btn-small btn-dismiss">Dismiss</button>
        </div>
    </div>

    <div class="alert-item" style="border-left: 4px solid #60a5fa;">
        <div class="alert-icon" style="color: #60a5fa;"><i class="bi bi-info-circle-fill"></i></div>
        <div class="alert-info">
            <div class="alert-title">New Employer Registration</div>
            <div class="alert-message">Tech Solutions Inc. has completed registration and awaits verification.</div>
            <div class="alert-time">Sent 4 hours ago</div>
        </div>
        <div class="alert-actions">
            <button class="btn-small btn-dismiss">Dismiss</button>
        </div>
    </div>

    <div class="alert-item" style="border-left: 4px solid #34d399;">
        <div class="alert-icon" style="color: #34d399;"><i class="bi bi-check-circle-fill"></i></div>
        <div class="alert-info">
            <div class="alert-title">System Backup Completed</div>
            <div class="alert-message">Database backup for April 20, 2026 has been completed successfully.</div>
            <div class="alert-time">Sent 12 hours ago</div>
        </div>
        <div class="alert-actions">
            <button class="btn-small btn-dismiss">Dismiss</button>
        </div>
    </div>

    <div class="alert-item" style="border-left: 4px solid #f87171;">
        <div class="alert-icon" style="color: #f87171;"><i class="bi bi-exclamation-circle-fill"></i></div>
        <div class="alert-info">
            <div class="alert-title">Administrative Action Required</div>
            <div class="alert-message">5 jobseeker applications pending final approval for more than 7 days.</div>
            <div class="alert-time">Sent 1 day ago</div>
        </div>
        <div class="alert-actions">
            <button class="btn-small btn-dismiss">Dismiss</button>
        </div>
    </div>
</div>

@endsection
