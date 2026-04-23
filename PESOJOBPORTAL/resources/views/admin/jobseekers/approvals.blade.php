@extends('layouts.admin')

@section('title', 'Jobseeker Approvals | PESO Admin')

@section('admin-content')
@include('admin.layouts.topbar', ['title' => 'Jobseeker Approvals', 'subtitle' => 'Review and approve pending jobseeker registrations', 'icon' => 'bi-person-check'])

<div class="admin-dashboard">
    <style>
        .approval-header {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .approval-stat {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-left: 5px solid #0d1f3c;
            border-radius: 12px;
            padding: 1.75rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .approval-stat:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .approval-stat-label {
            font-size: 12px;
            color: #6b7280;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin-bottom: 0.5rem;
        }

        .approval-stat-value {
            font-size: 36px;
            font-weight: 800;
            color: #0d1f3c;
            letter-spacing: -0.5px;
        }

        .approval-stat-icon {
            font-size: 2.5rem;
            opacity: 0.1;
            position: absolute;
            right: 15px;
            top: 15px;
        }

        .approval-stat {
            position: relative;
            overflow: hidden;
        }

        .approval-stat::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, rgba(215, 38, 56, 0.08) 0%, rgba(215, 38, 56, 0) 100%);
            border-radius: 50%;
            transform: translate(30%, -30%);
        }

        .data-table { 
            font-size: 13px; 
        }
        
        .data-table thead { 
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        }
        
        .data-table th { 
            color: #0d1f3c; 
            font-weight: 800; 
            border-bottom: 2px solid #d72638; 
            font-size: 11px; 
            text-transform: uppercase; 
            letter-spacing: 0.8px;
            padding: 1rem !important;
        }
        
        .data-table td { 
            padding: 1rem !important; 
            vertical-align: middle; 
            font-weight: 500;
        }
        
        .data-table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .data-table tbody tr:hover { 
            background: linear-gradient(90deg, #f9fafb 0%, #f0f1f3 100%);
            box-shadow: inset 0 0 0 1px rgba(215, 38, 56, 0.1);
        }

        .jobseeker-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, #d72638 0%, #ff6b7a 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            font-size: 16px;
            margin-right: 0.75rem;
            box-shadow: 0 2px 8px rgba(215, 38, 56, 0.2);
        }

        .jobseeker-name {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .badge-apps {
            background: linear-gradient(135deg, #bfdbfe 0%, #93c5fd 100%);
            color: #1e3a8a;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.2);
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 700;
            border-radius: 6px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .btn-view {
            background: linear-gradient(135deg, #bfdbfe 0%, #93c5fd 100%);
            color: #1e3a8a;
            border: none;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.2);
        }

        .btn-view:hover {
            background: linear-gradient(135deg, #93c5fd 0%, #60a5fa 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
            color: #1e3a8a;
        }

        .btn-approve {
            background: linear-gradient(135deg, #86efac 0%, #4ade80 100%);
            color: #15803d;
            border: none;
            box-shadow: 0 2px 8px rgba(34, 197, 94, 0.2);
        }

        .btn-approve:hover {
            background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
            color: #15803d;
        }

        .btn-reject {
            background: linear-gradient(135deg, #fecaca 0%, #fca5a5 100%);
            color: #7c2d12;
            border: none;
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.2);
        }

        .btn-reject:hover {
            background: linear-gradient(135deg, #fca5a5 0%, #f87171 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
            color: #7c2d12;
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
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
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

        .pagination {
            justify-content: center;
            margin-top: 2rem;
        }

        .pagination .page-link {
            color: #0d1f3c;
            border-color: #e5e7eb;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .pagination .page-link:hover {
            background: linear-gradient(135deg, #d72638 0%, #ff6b7a 100%);
            border-color: #d72638;
            color: white;
            transform: translateY(-2px);
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #d72638 0%, #ff6b7a 100%);
            border-color: #d72638;
            box-shadow: 0 4px 12px rgba(215, 38, 56, 0.3);
        }

        .modal-header {
            background: linear-gradient(135deg, #0d1f3c 0%, #1a3a5c 100%);
            border-bottom: 2px solid #d72638;
        }

        .modal-header .modal-title {
            color: white;
            font-weight: 800;
            font-size: 18px;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-footer {
            border-top: 1px solid #e5e7eb;
            padding: 1.5rem;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #374151;
            border: none;
            font-weight: 700;
        }

        .btn-secondary:hover {
            background: #d1d5db;
            color: #374151;
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
            color: white;
            border: none;
            font-weight: 700;
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #b91c1c 0%, #dc2626 100%);
            color: white;
        }
    </style>

    <!-- Stats Section -->
    <div class="approval-header">
        <div class="approval-stat">
            <i class="bi bi-hourglass-split approval-stat-icon"></i>
            <div class="approval-stat-label">Pending Approvals</div>
            <div class="approval-stat-value">{{ $jobseekers->total() }}</div>
        </div>
        <div class="approval-stat" style="border-left-color: #3b82f6;">
            <i class="bi bi-person-check approval-stat-icon" style="color: #3b82f6; opacity: 0.15;"></i>
            <div class="approval-stat-label">Page</div>
            <div class="approval-stat-value">{{ $jobseekers->currentPage() }} of {{ $jobseekers->lastPage() }}</div>
        </div>
    </div>

    <div class="dashboard-card">
        <h5><i class="bi bi-person-check me-2"></i>Pending Jobseeker Approvals</h5>
        
        @if($jobseekers->count() > 0)
            <div class="table-responsive">
                <table class="table data-table w-100">
                    <thead>
                        <tr>
                            <th>Jobseeker</th>
                            <th>Email</th>
                            <th>Registered</th>
                            <th>Applications</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jobseekers as $jobseeker)
                            <tr>
                                <td>
                                    <div class="jobseeker-name">
                                        <div class="jobseeker-avatar">
                                            {{ strtoupper(substr($jobseeker->name, 0, 1)) }}
                                        </div>
                                        <strong>{{ Str::limit($jobseeker->name, 25) }}</strong>
                                    </div>
                                </td>
                                <td>{{ Str::limit($jobseeker->email, 22) }}</td>
                                <td><small>{{ $jobseeker->created_at->format('d M, Y') }}</small></td>
                                <td>
                                    <span class="badge-apps">{{ $jobseeker->applications->count() ?? 0 }} apps</span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.jobseekers.show', $jobseeker) }}" class="btn btn-sm btn-view">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                        <form method="POST" action="{{ route('admin.jobseekers.approve', $jobseeker) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-approve" title="Approve">
                                                <i class="bi bi-check-circle"></i> Approve
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-sm btn-reject" data-bs-toggle="modal" 
                                                data-bs-target="#rejectModal{{ $jobseeker->id }}" title="Reject">
                                            <i class="bi bi-x-circle"></i> Reject
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Rejection Modal -->
                            <div class="modal fade" id="rejectModal{{ $jobseeker->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Reject Registration</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST" action="{{ route('admin.jobseekers.reject', $jobseeker) }}">
                                            @csrf
                                            <div class="modal-body">
                                                <p class="text-muted mb-3">You are rejecting: <strong>{{ $jobseeker->name }}</strong></p>
                                                <div class="mb-3">
                                                    <label for="reason_{{ $jobseeker->id }}" class="form-label">
                                                        Rejection Reason <span class="text-danger">*</span>
                                                    </label>
                                                    <textarea id="reason_{{ $jobseeker->id }}" name="reason" class="form-control" rows="5" 
                                                              placeholder="Please provide a clear reason for rejecting this registration..." required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger"><i class="bi bi-x-circle me-2"></i>Reject Registration</button>
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
                <i class="bi bi-check-circle"></i>
                <p>All Caught Up!</p>
                <small>No pending jobseeker approvals at this time</small>
                <small style="display: block; margin-top: 1rem; font-size: 12px; color: #9ca3af;">
                    New registration requests will appear here when jobseekers sign up
                </small>
            </div>
        @endif
    </div>
</div>

@endsection
