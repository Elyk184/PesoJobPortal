@extends('layouts.admin-dashboard')

@section('title', 'Job Applicants | PESO Admin')

<?php
    $pageTitle = 'Job Applicants';
    $pageSubtitle = 'Review job applications from jobseekers';
    $pageIcon = 'bi-file-person';
?>

@section('content')
<div class="admin-dashboard">
    <style>
        .data-table { font-size: 13px; }
        .data-table thead { background: #f3f4f6; }
        .data-table th { color: #0d1f3c; font-weight: 700; border-bottom: 2px solid #e5e7eb; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
        .data-table td { padding: 13px 10px; vertical-align: middle; font-weight: 500; }
        .data-table tbody tr:hover { background: #f9fafb; }
        .status-badge {
            display: inline-block;
            padding: 0.4rem 0.75rem;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-under_review { background: #dbeafe; color: #1e3a8a; }
        .status-approved { background: #dcfce7; color: #166534; }
        .status-rejected { background: #fee2e2; color: #991b1b; }
    </style>

    <div class="dashboard-card">
            @if($applications->count() > 0)
                <!-- Applications Table -->
                <table class="table data-table w-100">
                    <thead>
                        <tr>
                            <th>Jobseeker</th>
                            <th>Job Title</th>
                            <th>Employer</th>
                            <th>Applied</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $application)
                            <tr>
                                <td>
                                    <strong>{{ $application->user?->name ?? 'N/A' }}</strong><br>
                                    <small class="text-muted">{{ $application->user?->email ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    <strong>{{ Str::limit($application->pesoJob?->title ?? 'N/A', 25) }}</strong>
                                </td>
                                <td>{{ Str::limit($application->pesoJob?->employer?->name ?? 'N/A', 20) }}</td>
                                <td><small>{{ $application->created_at->format('d M, Y') }}</small></td>
                                <td>
                                    <span class="status-badge status-{{ $application->admin_status ?? 'pending' }}">
                                        {{ ucfirst($application->admin_status ?? 'pending') }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.jobseekers.show', $application->id) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i> Review
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $applications->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="alert alert-info text-center" role="alert">
                    <i class="bi bi-info-circle me-2"></i>
                    No job applications to review at the moment.
                </div>
            @endif
        </div>
</div>
@endsection
