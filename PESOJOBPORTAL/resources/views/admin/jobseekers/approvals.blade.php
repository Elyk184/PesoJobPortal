@extends('layouts.admin-dashboard')

@section('title', 'Jobseekers | PESO Admin')

<?php
    $pageTitle = 'Jobseekers';
    $pageSubtitle = 'Manage jobseekers and recommend jobs';
    $pageIcon = 'bi-people';
?>

@section('content')
<div class="admin-dashboard">
    <style>
        .approval-header {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 2rem;
            margin-bottom: 3.5rem;
        }

        .approval-stat {
            background: linear-gradient(135deg, #ffffff 0%, #fafbfc 100%);
            border: 2px solid #d1d5db;
            border-radius: 16px;
            padding: 2rem 1.75rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.12), 0 1px 3px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .approval-stat:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2), 0 4px 12px rgba(0, 0, 0, 0.15);
            border-color: rgba(0, 0, 0, 0.2);
        }

        .approval-stat::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(0, 0, 0, 0.03) 0%, rgba(0, 0, 0, 0) 70%);
            border-radius: 50%;
        }

        .approval-stat::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #1f2937 0%, #374151 100%);
            border-radius: 16px 16px 0 0;
        }

        .approval-stat-label {
            font-size: 12px;
            color: #6b7280;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin-bottom: 0.75rem;
            position: relative;
            z-index: 1;
        }

        .approval-stat-value {
            font-size: 40px;
            font-weight: 800;
            color: #1f2937;
            letter-spacing: -0.5px;
            position: relative;
            z-index: 1;
        }

        .approval-stat-icon {
            font-size: 2.5rem;
            opacity: 0.08;
            position: absolute;
            right: 20px;
            top: 20px;
            color: #374151;
        }

        .data-table { 
            font-size: 13px;
            width: 100%;
        }
        
        .data-table thead { 
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        }
        
        .data-table th { 
            color: #1f2937; 
            font-weight: 800; 
            border-bottom: 2px solid #d1d5db; 
            font-size: 12px; 
            text-transform: uppercase; 
            letter-spacing: 0.8px;
            padding: 1.25rem 1rem !important;
        }
        
        .data-table td { 
            padding: 1.25rem 1rem !important; 
            vertical-align: middle; 
            font-weight: 500;
            color: #1f2937;
        }
        
        .data-table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .data-table tbody tr:last-child td {
            border-bottom: none;
        }
        
        .data-table tbody tr:hover { 
            background: linear-gradient(90deg, #fafbfc 0%, #f3f4f6 100%);
            box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.05);
        }

        .jobseeker-avatar {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            font-size: 16px;
            margin-right: 0.75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            flex-shrink: 0;
        }

        .jobseeker-name {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .badge-count {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 8px rgba(30, 58, 138, 0.15);
            display: inline-block;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-sm {
            padding: 8px 14px;
            font-size: 12px;
            font-weight: 700;
            border-radius: 8px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            border: none;
        }

        .btn-view {
            background: linear-gradient(135deg, #bfdbfe 0%, #93c5fd 100%);
            color: #1e3a8a;
            border: none;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.2);
        }

        .btn-view:hover {
            background: linear-gradient(135deg, #93c5fd 0%, #60a5fa 100%);
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
            color: #1e3a8a;
        }

        .btn-recommend {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: #92400e;
            border: none;
            box-shadow: 0 2px 8px rgba(217, 119, 6, 0.2);
        }

        .btn-recommend:hover {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(217, 119, 6, 0.35);
            color: #92400e;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #9ca3af;
            font-size: 14px;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            opacity: 0.3;
            color: #d1d5db;
        }

        .empty-state p {
            margin: 1rem 0 0.5rem;
            font-weight: 700;
            color: #6b7280;
            font-size: 18px;
        }

        .empty-state small {
            color: #a1a5ab;
            display: block;
            margin-top: 0.5rem;
        }

        .dashboard-card {
            background: linear-gradient(135deg, #ffffff 0%, #fafbfc 100%);
            border-radius: 16px;
            padding: 2.25rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.12), 0 1px 3px rgba(0, 0, 0, 0.08);
            border: 2px solid #d1d5db;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .dashboard-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #1f2937 0%, #374151 100%);
            border-radius: 16px 16px 0 0;
        }

        .dashboard-card:hover {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2), 0 4px 12px rgba(0, 0, 0, 0.15);
            border-color: rgba(0, 0, 0, 0.2);
            transform: translateY(-8px);
        }

        .dashboard-card h5 {
            color: #1f2937;
            font-weight: 800;
            margin-bottom: 1.75rem;
            margin-top: 0;
            padding-bottom: 1.25rem;
            border-bottom: 2px solid #d1d5db;
            font-size: 18px;
            letter-spacing: -0.3px;
        }
        
        .dashboard-card h5 i {
            color: #374151;
            margin-right: 0.5rem;
        }

        .pagination {
            justify-content: center;
            margin-top: 3rem;
            gap: 0.5rem;
        }

        .pagination .page-link {
            color: #1f2937;
            border-color: #d1d5db;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 8px;
        }

        .pagination .page-link:hover {
            background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
            border-color: #1f2937;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
            border-color: #1f2937;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        }
    </style>

    <div class="approval-header">
        <div class="approval-stat">
            <div class="approval-stat-label">Total Jobseekers</div>
            <div class="approval-stat-value">{{ $jobseekers->total() }}</div>
            <i class="bi bi-people approval-stat-icon"></i>
        </div>
        <div class="approval-stat">
            <div class="approval-stat-label">Available Jobs</div>
            <div class="approval-stat-value">{{ $availableJobs->count() }}</div>
            <i class="bi bi-briefcase approval-stat-icon"></i>
        </div>
    </div>

    <div class="dashboard-card">
        <h5><i class="bi bi-people me-2"></i>Jobseeker Management</h5>
        
        @if($jobseekers->count() > 0)
            <div class="table-responsive">
                <table class="table data-table w-100">
                    <thead>
                        <tr>
                            <th>Jobseeker</th>
                            <th>Email</th>
                            <th>Applications</th>
                            <th>Member Since</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jobseekers as $jobseeker)
                            <tr>
                                <td>
                                    <div class="jobseeker-name">
                                        <div class="jobseeker-avatar">
                                            {{ strtoupper(substr($jobseeker->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <strong>{{ Str::limit($jobseeker->name ?? 'N/A', 25) }}</strong>
                                    </div>
                                </td>
                                <td>{{ Str::limit($jobseeker->email ?? 'N/A', 30) }}</td>
                                <td>
                                    <span class="badge-count">{{ $jobseeker->applications_count ?? 0 }} apps</span>
                                </td>
                                <td><small>{{ $jobseeker->created_at->format('d M, Y') }}</small></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.jobseekers.show', $jobseeker) }}" class="btn btn-sm btn-view">
                                            <i class="bi bi-eye"></i> View Profile
                                        </a>
                                        <button type="button" class="btn btn-sm btn-recommend" data-bs-toggle="modal" 
                                                data-bs-target="#recommendModal{{ $jobseeker->id }}" title="Recommend Job">
                                            <i class="bi bi-star"></i> Recommend
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Recommendation Modal -->
                            <div class="modal fade" id="recommendModal{{ $jobseeker->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background: linear-gradient(135deg, #0d1f3c 0%, #1a3a5c 100%); border-bottom: 2px solid #d72638;">
                                            <h5 class="modal-title" style="color: white; font-weight: 800;"><i class="bi bi-star-fill me-2"></i>Recommend a Job</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST" action="{{ route('admin.jobseekers.recommend-job', $jobseeker) }}">
                                            @csrf
                                            <div class="modal-body" style="padding: 2rem;">
                                                <p class="text-muted mb-3">Recommending a job to: <strong>{{ $jobseeker->name ?? 'N/A' }}</strong></p>
                                                <div class="mb-3">
                                                    <label for="job_{{ $jobseeker->id }}" class="form-label">
                                                        Select Job <span class="text-danger">*</span>
                                                    </label>
                                                    <select id="job_{{ $jobseeker->id }}" name="job_id" class="form-control" required>
                                                        <option value="">-- Choose a Job --</option>
                                                        @foreach($availableJobs as $job)
                                                            <option value="{{ $job->id }}">{{ $job->title }} - {{ $job->company->company_name ?? 'Unknown' }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="message_{{ $jobseeker->id }}" class="form-label">
                                                        Message (Optional)
                                                    </label>
                                                    <textarea id="message_{{ $jobseeker->id }}" name="message" class="form-control" rows="3" 
                                                              placeholder="Add a personal note about why this job is a good fit..."></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer" style="border-top: 1px solid #e5e7eb; padding: 1.5rem;">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-recommend"><i class="bi bi-star-fill me-2"></i>Send Recommendation</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav aria-label="Page navigation" class="mt-4">
                {{ $jobseekers->links('pagination::bootstrap-5') }}
            </nav>
        @else
            <div class="empty-state">
                <i class="bi bi-people"></i>
                <p>No Jobseekers Yet</p>
                <small>Jobseekers will appear here once they register on the platform</small>
            </div>
        @endif
    </div>
</div>

@endsection
