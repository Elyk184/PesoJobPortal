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
    </style>

    @if($companyProfiles->count() > 0)
        <div class="verification-table">
            <table>
                <thead>
                    <tr>
                        <th>Company</th>
                        <th>Contact Email</th>
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
    @else
        <div class="verification-table">
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <p>No company profiles pending verification</p>
                <small style="color: #d1d5db;">All company profiles have been verified or are approved.</small>
            </div>
        </div>
    @endif
</div>

@endsection
