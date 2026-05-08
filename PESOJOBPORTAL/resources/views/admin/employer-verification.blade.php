@extends('layouts.admin-dashboard')

@section('title', 'Employer Verification | PESO Admin')

<?php
    $pageTitle = 'Employer Verification';
    $pageSubtitle = 'Review and verify employer registration requests';
    $pageIcon = 'bi-building';
?>

@section('content')
<div class="admin-dashboard">
    <style>
        .verification-header { display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-bottom: 1rem; }
        .verification-count-badge { display: inline-flex; align-items: center; gap: 6px; border-radius: 999px; background: #dbeafe; color: #1e40af; padding: 6px 12px; font-size: 12px; font-weight: 700; }
        .verification-container { display: grid; grid-template-columns: 1fr 320px; gap: 1.5rem; }
        .verification-main { }
        .employers-sidebar { background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); padding: 1.25rem; border: 1px solid #eef2f7; height: fit-content; position: sticky; top: 20px; }
        .employers-sidebar-title { margin: 0 0 1rem; font-size: 14px; font-weight: 700; color: #0d1f3c; display: flex; align-items: center; gap: 8px; }
        .employers-list { list-style: none; padding: 0; margin: 0; }
        .employer-item { padding: 0.75rem; margin-bottom: 0.5rem; border-radius: 8px; background: #f8fafc; border: 1px solid #e2e8f0; cursor: pointer; transition: all 0.2s ease; display: flex; align-items: center; gap: 8px; text-decoration: none; color: inherit; }
        .employer-item:hover { background: #eff6ff; border-color: #bfdbfe; box-shadow: 0 2px 8px rgba(59, 130, 246, 0.1); }
        .employer-item.active { background: #dbeafe; border-color: #3b82f6; }
        .employer-avatar { width: 32px; height: 32px; border-radius: 6px; background: linear-gradient(135deg, #d72638 0%, #ff6b7a 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 12px; flex-shrink: 0; }
        .employer-item-content { min-width: 0; flex: 1; }
        .employer-item-name { font-size: 12px; font-weight: 600; color: #0d1f3c; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .employer-item-status { font-size: 10px; color: #64748b; margin-top: 2px; }
        .employers-count { display: inline-flex; align-items: center; justify-content: center; background: #dbeafe; color: #1e40af; border-radius: 6px; font-size: 10px; font-weight: 700; padding: 2px 6px; margin-left: auto; }
        .verification-table { width: 100%; background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); overflow: hidden; }
        .verification-table table { width: 100%; border-collapse: collapse; }
        .verification-table thead { background: #f3f4f6; border-bottom: 2px solid #e5e7eb; }
        .verification-table th { padding: 1rem; text-align: left; font-weight: 700; color: #0d1f3c; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
        .verification-table td { padding: 1rem; vertical-align: middle; font-size: 14px; border-bottom: 1px solid #f0f0f0; }
        .verification-table tbody tr:hover { background: #f9fafb; }
        .status-badge { display: inline-block; padding: 0.5rem 0.75rem; border-radius: 6px; font-size: 12px; font-weight: 600; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-under-review { background: #dbeafe; color: #1e40af; }
        .status-verified { background: #d1fae5; color: #065f46; }
        .status-rejected { background: #fee2e2; color: #991b1b; }
        .btn-small { padding: 0.5rem 1rem; border: none; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s ease; text-decoration: none; display: inline-block; }
        .btn-view { background: #3b82f6; color: white; }
        .btn-view:hover { background: #2563eb; }
        .btn-approve { background: #10b981; color: white; }
        .btn-approve:hover { background: #059669; }
        .btn-reject { background: #ef4444; color: white; }
        .btn-reject:hover { background: #dc2626; }
        .company-info { display: flex; align-items: center; gap: 12px; }
        .company-logo { width: 40px; height: 40px; border-radius: 8px; background: linear-gradient(135deg, #d72638 0%, #ff6b7a 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 16px; flex-shrink: 0; }
        .company-details h6 { margin: 0; font-size: 14px; font-weight: 600; color: #0d1f3c; }
        .company-details p { margin: 2px 0 0; font-size: 12px; color: #6b7280; }
        .empty-state { text-align: center; padding: 3rem; color: #9ca3af; }
        .empty-state i { font-size: 3rem; margin-bottom: 1rem; opacity: 0.5; }
        .pagination { margin-top: 2rem; display: flex; justify-content: center; gap: 0.5rem; }
        .pagination a, .pagination span { padding: 0.5rem 0.75rem; border-radius: 6px; }
        .pagination a { background: #e5e7eb; color: #0d1f3c; text-decoration: none; }
        .pagination a:hover { background: #d1d5db; }
        .pagination .active { background: #d72638; color: white; }
        .doc-badges { display: flex; flex-wrap: wrap; gap: 6px; }
        .doc-badge { display: inline-flex; align-items: center; gap: 4px; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 600; }
        .doc-present { background: #d1fae5; color: #065f46; }
        .doc-missing { background: #fee2e2; color: #991b1b; }
        .alerts-card { background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); padding: 1rem; margin-bottom: 1rem; border: 1px solid #eef2f7; }
        .alerts-head { display: flex; justify-content: space-between; align-items: center; gap: 8px; margin-bottom: 0.75rem; }
        .alerts-head h5 { margin: 0; font-size: 14px; color: #0d1f3c; font-weight: 700; }
        .alerts-count { background: #dbeafe; color: #1e40af; border-radius: 999px; font-size: 11px; font-weight: 700; padding: 4px 8px; }
        .alert-row { padding: 0.65rem 0; border-top: 1px solid #f1f5f9; }
        .alert-row:first-of-type { border-top: none; }
        .alert-title { margin: 0; font-size: 13px; font-weight: 700; color: #0f172a; }
        .alert-message { margin: 2px 0 0; font-size: 12px; color: #475569; }
        .alert-meta { margin-top: 4px; font-size: 11px; color: #64748b; display: flex; gap: 10px; align-items: center; }
        .alert-state { display: inline-flex; align-items: center; gap: 4px; border-radius: 999px; padding: 2px 8px; font-size: 10px; font-weight: 700; text-transform: uppercase; }
        .alert-unread { background: #dcfce7; color: #166534; }
        .alert-read { background: #f1f5f9; color: #475569; }
        .request-grid { display: grid; gap: 12px; margin-bottom: 1rem; }
        .request-card { background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); padding: 1rem; border: 1px solid #eef2f7; }
        .request-head { display: flex; justify-content: space-between; align-items: start; gap: 12px; margin-bottom: 0.75rem; }
        .request-title { margin: 0; font-size: 15px; font-weight: 700; color: #0d1f3c; }
        .request-subtitle { margin: 3px 0 0; color: #64748b; font-size: 12px; }
        .request-meta { display: flex; flex-wrap: wrap; gap: 8px; }
        .request-status { display: inline-flex; align-items: center; padding: 4px 8px; border-radius: 999px; font-size: 11px; font-weight: 700; background: #e0f2fe; color: #075985; }
        .request-docs { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 0.75rem; }
        .request-doc-link { display: inline-flex; align-items: center; gap: 6px; padding: 6px 10px; border-radius: 8px; background: #f8fafc; border: 1px solid #dbe4ee; color: #0f172a; text-decoration: none; font-size: 12px; font-weight: 600; }
        .request-doc-link:hover { background: #eff6ff; border-color: #bfdbfe; }
        @media (max-width: 1200px) {
            .verification-container { grid-template-columns: 1fr; }
            .employers-sidebar { position: relative; top: 0; }
        }
    </style>

    <div class="verification-header">
        <div>
            <h4 style="margin: 0; color: #0d1f3c; font-weight: 800;">Employer Verification</h4>
            <small style="color: #64748b;">Review uploaded Business Permit and DTI/SEC registrations before approving employers.</small>
        </div>
        <span class="verification-count-badge"><i class="bi bi-bell-fill"></i>{{ $verificationRequestCount ?? 0 }} pending review</span>
    </div>

    <div class="verification-container">
        <div class="verification-main">

    @if(isset($verificationAlerts) && $verificationAlerts->count() > 0)
        <div class="alerts-card">
            <div class="alerts-head">
                <h5><i class="bi bi-bell-fill me-1"></i>Recent Verification Alerts</h5>
                <span class="alerts-count">{{ $verificationUnreadCount ?? 0 }} unread</span>
            </div>

            @foreach($verificationAlerts as $alert)
                <div class="alert-row">
                    <p class="alert-title">{{ $alert->portalNotification->title ?? 'Verification Alert' }}</p>
                    <p class="alert-message">{{ $alert->portalNotification->message ?? '' }}</p>
                    <div class="alert-meta">
                        <span>{{ $alert->created_at?->diffForHumans() }}</span>
                        @if($alert->read_at)
                            <span class="alert-state alert-read"><i class="bi bi-check2-circle"></i>Read</span>
                        @else
                            <span class="alert-state alert-unread"><i class="bi bi-bell"></i>Unread</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if(isset($verificationRequests) && $verificationRequests->count() > 0)
        <div class="request-grid">
            @foreach($verificationRequests as $request)
                <div class="request-card">
                    <div class="request-head">
                        <div>
                            <h5 class="request-title">{{ $request['company_name'] }}</h5>
                            <p class="request-subtitle">{{ $request['employer_name'] }} | {{ $request['employer_email'] }}</p>
                        </div>
                        <div class="request-meta">
                            <span class="request-status">{{ ucfirst(str_replace('_', ' ', $request['verification_status'])) }}</span>
                            @if($request['company_profile_id'])
                                <a href="{{ route('admin.employer-verification.detail', $request['company_profile_id']) }}" class="btn-small btn-view">Review Profile</a>
                            @endif
                        </div>
                    </div>

                    <div class="doc-badges">
                        <span class="doc-badge {{ $request['has_business_permit'] ? 'doc-present' : 'doc-missing' }}">
                            <i class="bi {{ $request['has_business_permit'] ? 'bi-file-earmark-check' : 'bi-file-earmark-x' }}"></i> Business Permit
                        </span>
                        <span class="doc-badge {{ $request['has_dti_sec'] ? 'doc-present' : 'doc-missing' }}">
                            <i class="bi {{ $request['has_dti_sec'] ? 'bi-file-earmark-check' : 'bi-file-earmark-x' }}"></i> DTI/SEC
                        </span>
                    </div>

                    <div class="request-docs">
                        @foreach($request['documents'] as $document)
                            <a href="{{ asset('storage/' . $document['file_path']) }}" target="_blank" class="request-doc-link">
                                <i class="bi bi-eye"></i>
                                {{ ucfirst(str_replace('_', ' ', $document['type'])) }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if($companyProfiles->count() > 0)
        <div class="verification-table">
            <table>
                <thead>
                    <tr>
                        <th>Company</th>
                        <th>Contact Email</th>
                        <th>Documents</th>
                        <th>Registration Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($companyProfiles as $profile)
                        <tr>
                            <td>
                                <div class="company-info">
                                    <div class="company-logo">{{ strtoupper(substr($profile->company_name, 0, 1)) }}</div>
                                    <div class="company-details">
                                        <h6>{{ $profile->company_name }}</h6>
                                        <p>{{ $profile->employer->name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $profile->establishment_email ?? 'N/A' }}</td>
                            <td>
                                <div class="doc-badges">
                                    @if($profile->business_permit_path)
                                        <span class="doc-badge doc-present"><i class="bi bi-file-earmark-text"></i> Permit</span>
                                    @else
                                        <span class="doc-badge doc-missing"><i class="bi bi-file-earmark-x"></i> Permit</span>
                                    @endif
                                    @if($profile->dti_sec_registration_path)
                                        <span class="doc-badge doc-present"><i class="bi bi-file-earmark-ruled"></i> DTI/SEC</span>
                                    @else
                                        <span class="doc-badge doc-missing"><i class="bi bi-file-earmark-x"></i> DTI/SEC</span>
                                    @endif
                                </div>
                            </td>
                            <td><small>{{ $profile->created_at->format('d M Y') }}</small></td>
                            <td>
                                @if($profile->verification_status === 'pending')
                                    <span class="status-badge status-pending"><i class="bi bi-hourglass-split me-1"></i>Pending</span>
                                @elseif($profile->verification_status === 'under_review')
                                    <span class="status-badge status-under-review"><i class="bi bi-search me-1"></i>Under Review</span>
                                @elseif($profile->verification_status === 'verified')
                                    <span class="status-badge status-verified"><i class="bi bi-check-circle me-1"></i>Verified</span>
                                @else
                                    <span class="status-badge status-rejected"><i class="bi bi-x-circle me-1"></i>Rejected</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.employer-verification.detail', $profile->id) }}" class="btn-small btn-view"><i class="bi bi-eye me-1"></i>Review</a>
                                <form method="POST" action="{{ route('admin.employer-verification.approve', $profile->id) }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn-small btn-approve" onclick="return confirm('Approve this company profile?')"><i class="bi bi-check-lg me-1"></i>Approve</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($companyProfiles->hasPages())
            <div class="pagination">
                {{ $companyProfiles->links() }}
            </div>
        @endif
    @elseif((isset($verificationRequests) && $verificationRequests->count() === 0))
        <div class="verification-table">
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <p>No company profiles pending verification</p>
                <small style="color: #d1d5db;">All company profiles have been verified or are approved.</small>
            </div>
        </div>
    @endif
        </div><!-- End verification-main -->

        <!-- Employers Sidebar -->
        <aside class="employers-sidebar">
            <h5 class="employers-sidebar-title">
                <i class="bi bi-building"></i>
                All Employers
                <span class="employers-count">{{ $allEmployers->count() ?? 0 }}</span>
            </h5>
            
            @if($allEmployers->count() > 0)
                <ul class="employers-list">
                    @foreach($allEmployers as $profile)
                        <a href="{{ route('admin.employer-verification.detail', $profile->id) }}" class="employer-item" title="{{ $profile->company_name }}">
                            <div class="employer-avatar">{{ strtoupper(substr($profile->company_name, 0, 1)) }}</div>
                            <div class="employer-item-content">
                                <div class="employer-item-name">{{ Str::limit($profile->company_name, 22) }}</div>
                                <div class="employer-item-status">
                                    @if($profile->verification_status === 'verified')
                                        <span style="color: #10b981;">Verified</span>
                                    @elseif($profile->verification_status === 'pending')
                                        <span style="color: #f59e0b;">Pending</span>
                                    @elseif($profile->verification_status === 'under_review')
                                        <span style="color: #3b82f6;">Reviewing</span>
                                    @else
                                        <span style="color: #ef4444;">Rejected</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </ul>
            @else
                <div style="text-align: center; padding: 2rem 0; color: #9ca3af;">
                    <i class="bi bi-inbox" style="font-size: 2rem; margin-bottom: 0.5rem; display: block; opacity: 0.5;"></i>
                    <small>No employers yet</small>
                </div>
            @endif
        </aside>
    </div><!-- End verification-container -->
</div>


@endsection
