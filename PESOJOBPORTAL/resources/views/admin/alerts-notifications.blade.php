@extends('layouts.admin-dashboard')

@section('title', 'Alerts & Notifications | PESO Admin')

<?php
    $pageTitle = 'Alerts & Notifications';
    $pageSubtitle = 'Manage system alerts and notifications';
    $pageIcon = 'bi-bell';
?>

@section('content')
<div class="admin-dashboard">
    <style>
        .alerts-shell { display: grid; gap: 1rem; }
        .alerts-summary { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; }
        .alerts-stat { background: white; border-radius: 16px; padding: 1.25rem; box-shadow: 0 6px 18px rgba(13,31,60,0.06); border: 1px solid #e7edf5; }
        .alerts-stat-label { font-size: 12px; text-transform: uppercase; letter-spacing: 0.6px; color: #6b7280; font-weight: 700; margin-bottom: 0.35rem; }
        .alerts-stat-value { font-size: 2rem; font-weight: 800; color: #0d1f3c; line-height: 1; }
        .alerts-stat-note { font-size: 13px; color: #6b7280; margin-top: 0.45rem; }
        .alerts-panel { background: white; border-radius: 18px; border: 1px solid #e7edf5; box-shadow: 0 6px 18px rgba(13,31,60,0.05); overflow: hidden; }
        .alerts-panel-head { padding: 1.15rem 1.25rem; border-bottom: 1px solid #edf2f7; display: flex; justify-content: space-between; align-items: center; gap: 1rem; }
        .alerts-panel-head h3 { margin: 0; font-size: 1rem; font-weight: 800; color: #0d1f3c; }
        .alerts-panel-head p { margin: 0; color: #6b7280; font-size: 0.9rem; }
        .alerts-list { padding: 1rem 1.25rem 1.25rem; display: grid; gap: 0.9rem; }
        .alert-item { background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%); padding: 1rem 1.1rem; border-radius: 14px; border: 1px solid #edf2f7; display: flex; gap: 1rem; align-items: flex-start; }
        .alert-icon { width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex: 0 0 auto; font-size: 1.05rem; background: #eff6ff; }
        .alert-info { flex: 1; min-width: 0; }
        .alert-title { font-weight: 800; color: #0d1f3c; margin-bottom: 0.3rem; }
        .alert-message { color: #5f6c80; font-size: 14px; margin-bottom: 0.55rem; line-height: 1.55; }
        .alert-meta { display: flex; flex-wrap: wrap; gap: 0.5rem 1rem; align-items: center; font-size: 12px; color: #8b95a7; }
        .alert-actions { display: flex; gap: 0.5rem; align-items: flex-start; flex-shrink: 0; }
        .btn-small { padding: 0.55rem 0.9rem; border: none; border-radius: 999px; font-size: 12px; font-weight: 700; cursor: pointer; transition: all 0.2s ease; }
        .btn-dismiss { background: #eef2f7; color: #1f2937; }
        .btn-dismiss:hover { background: #dbe3ee; }
        .alerts-empty { background: #fff; border: 1px dashed #dbe4ee; border-radius: 16px; padding: 2.25rem 1.5rem; text-align: center; color: #64748b; }
    </style>

    <div class="alerts-shell">
        <div class="alerts-summary">
            <div class="alerts-stat">
                <div class="alerts-stat-label">Unread Alerts</div>
                <div class="alerts-stat-value">{{ $adminUnreadNotificationsCount ?? 0 }}</div>
                <div class="alerts-stat-note">Pending PESO and portal notifications</div>
            </div>
            <div class="alerts-stat">
                <div class="alerts-stat-label">Pending Job Approvals</div>
                <div class="alerts-stat-value">{{ $adminSidebarCounts['pendingJobApprovals'] ?? 0 }}</div>
                <div class="alerts-stat-note">Job posts waiting for review</div>
            </div>
            <div class="alerts-stat">
                <div class="alerts-stat-label">Employer Verifications</div>
                <div class="alerts-stat-value">{{ $adminSidebarCounts['pendingEmployerVerification'] ?? 0 }}</div>
                <div class="alerts-stat-note">Company profiles awaiting approval</div>
            </div>
            <div class="alerts-stat">
                <div class="alerts-stat-label">Pending PESO Clearances</div>
                <div class="alerts-stat-value">{{ $adminSidebarCounts['pendingPesoClearances'] ?? 0 }}</div>
                <div class="alerts-stat-note">Requests awaiting admin action</div>
            </div>
        </div>

        <div class="alerts-panel">
            <div class="alerts-panel-head">
                <div>
                    <h3>Recent Alerts</h3>
                    <p>Live notifications from the PESO clearance workflow and other portal updates.</p>
                </div>
                <span class="badge text-bg-primary rounded-pill px-3 py-2">{{ $adminUnreadNotificationsCount ?? 0 }} unread</span>
            </div>

            <div class="alerts-list">
                @forelse (($adminNotifications ?? collect()) as $notification)
                    @php
                        $title = (string) data_get($notification, 'portalNotification.title', 'Notification');
                        $message = (string) data_get($notification, 'portalNotification.message', '');
                        $createdAt = data_get($notification, 'portalNotification.created_at');
                        $alertText = mb_strtolower($title . ' ' . $message);
                        $isJobApproval = str_contains($alertText, 'job post') || str_contains($alertText, 'job approval');
                        $isEmployerVerification = str_contains($alertText, 'employer verification') || str_contains($alertText, 'company verification') || str_contains($alertText, 'business permit');
                        $isPesoClearance = str_contains($alertText, 'peso clearance');
                    @endphp
                    <div class="alert-item">
                        <div class="alert-icon" style="color: {{ $isPesoClearance ? '#f59e0b' : ($isEmployerVerification ? '#16a34a' : '#2563eb') }}; background: {{ $isPesoClearance ? 'rgba(245, 158, 11, 0.12)' : ($isEmployerVerification ? 'rgba(22, 163, 74, 0.12)' : 'rgba(37, 99, 235, 0.12)') }};">
                            <i class="bi bi-bell-fill"></i>
                        </div>
                        <div class="alert-info">
                            <div class="alert-title">{{ $title }}</div>
                            <div class="alert-message">{{ $message }}</div>
                            <div class="alert-meta">
                                <span><i class="bi bi-clock me-1"></i>{{ $createdAt ? $createdAt->diffForHumans() : 'Recently' }}</span>
                                @if($isJobApproval)
                                    <span class="badge text-bg-primary rounded-pill">Job Approval</span>
                                @endif
                                @if($isEmployerVerification)
                                    <span class="badge text-bg-success rounded-pill">Employer Verification</span>
                                @endif
                                @if($isPesoClearance)
                                    <span class="badge text-bg-warning text-dark rounded-pill">PESO Clearance</span>
                                @endif
                            </div>
                        </div>
                        <div class="alert-actions">
                            @if($isJobApproval)
                                <a href="{{ route('admin.job-approvals') }}" class="btn-small btn-dismiss" style="background:#2563eb; color:#fff; text-decoration:none;">Open Queue</a>
                            @endif
                            @if($isEmployerVerification)
                                <a href="{{ route('admin.employer-verification') }}" class="btn-small btn-dismiss" style="background:#16a34a; color:#fff; text-decoration:none;">Review Queue</a>
                            @endif
                            @if($isPesoClearance)
                                <a href="{{ route('admin.peso-clearances') }}" class="btn-small btn-dismiss" style="background:#f59e0b; color:#fff; text-decoration:none;">Open Queue</a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="alerts-empty">
                        <div class="fw-semibold mb-1">No admin notifications yet</div>
                        <div class="small">New job approvals, employer verifications, and PESO clearance requests will appear here as alerts.</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
