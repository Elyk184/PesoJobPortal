@extends('layouts.admin-dashboard')

@section('title', 'Jobseekers | PESO Admin')

<?php
    $pageTitle = 'Jobseekers';
    $pageSubtitle = 'Manage jobseekers and recommend jobs';
    $pageIcon = 'bi-people';
?>

@section('content')
<div class="admin-dashboard">
    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-bottom: 2rem; border-radius: 8px; border-left: 4px solid #10b981;">
            <i class="bi bi-check-circle me-2"></i>
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-bottom: 2rem; border-radius: 8px; border-left: 4px solid #ef4444;">
            <i class="bi bi-exclamation-circle me-2"></i>
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

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

        /* Modal Fixes */
        body.modal-open {
            overflow-y: scroll;
            padding-right: 0 !important;
        }

        .modal {
            z-index: 1050;
        }

        .modal-backdrop {
            z-index: 1040;
        }

        .modal.fade {
            transition: opacity 0.15s linear, transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .modal.show {
            transform: scale(1);
        }

        .modal-dialog {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .modal-content {
            border: none;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .modal-header {
            border-radius: 16px 16px 0 0;
            border: none;
        }

        .modal-body {
            max-height: 70vh;
            overflow-y: auto;
        }

        .modal-body::-webkit-scrollbar {
            width: 8px;
        }

        .modal-body::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .modal-body::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .modal-body::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
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
                                        <button type="button" class="btn btn-sm btn-recommend open-recommend-modal" 
                                                data-jobseeker-id="{{ $jobseeker->id }}" 
                                                data-jobseeker-name="{{ $jobseeker->name ?? 'N/A' }}" 
                                                title="Recommend Job">
                                            <i class="bi bi-star"></i> Recommend
                                        </button>
                                    </div>
                                </td>
                            </tr>
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

    <!-- Single Reusable Recommendation Modal -->
    <div class="modal fade" id="recommendModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border: none; border-radius: 12px;">
                <div class="modal-header" style="background: linear-gradient(135deg, #0d1f3c 0%, #1a3a5c 100%); border-bottom: none; border-radius: 12px 12px 0 0; padding: 1.5rem;">
                    <h5 class="modal-title" style="color: white; font-weight: 800; font-size: 1.5rem;"><i class="bi bi-briefcase me-2"></i>Recommend Applicant to Employer</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="recommendForm" method="POST" action="">
                    @csrf
                    <div class="modal-body" style="padding: 2.5rem; background: #ffffff;">
                        <p style="font-size: 1.1rem; color: #0d1f3c; margin-bottom: 1.5rem;">Recommending: <span id="jobseekerName" style="color: #d72638; font-weight: 700; font-size: 1.3rem;">N/A</span></p>
                        
                        <div class="row mb-3">
                            <!-- Step 1: Select Employer -->
                            <div class="col-md-6">
                                <label for="employerSelect" class="form-label" style="font-weight: 700; color: #0d1f3c; margin-bottom: 0.5rem; font-size: 1rem;">
                                    Employer <span class="text-danger">*</span>
                                </label>
                                <select id="employerSelect" name="employer_id" class="form-control" required style="border-radius: 8px; border: 2px solid #d72638; padding: 0.75rem; font-size: 1rem; color: #0d1f3c;">
                                    <option value="" style="color: #999;">-- Select Employer --</option>
                                    @php
                                        // Get all employers, not just those with active jobs
                                        $employers = \App\Models\User::where('role', 'employer')
                                            ->with('companyProfile')
                                            ->orderBy('name')
                                            ->get()
                                            ->map(function($user) {
                                                return [
                                                    'id' => $user->id,
                                                    'name' => $user->name,
                                                    'company_name' => $user->companyProfile?->company_name ?? $user->name
                                                ];
                                            });
                                    @endphp
                                    @foreach($employers as $employer)
                                        <option value="{{ $employer['id'] }}">{{ $employer['company_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Step 2: Select Job -->
                            <div class="col-md-6">
                                <label for="jobSelect" class="form-label" style="font-weight: 700; color: #0d1f3c; margin-bottom: 0.5rem; font-size: 1rem;">
                                    Job Position <span class="text-danger">*</span>
                                </label>
                                <select id="jobSelect" name="job_id" class="form-control" required disabled style="border-radius: 8px; border: 2px solid #d72638; padding: 0.75rem; font-size: 1rem; color: #0d1f3c;">
                                    <option value="" style="color: #999;">-- Select Job --</option>
                                </select>
                            </div>
                        </div>
                        
                        <hr style="margin: 2rem 0; border: none; border-top: 2px solid #e5e7eb;">
                        
                        <!-- Job Details Display (Facebook-like post) -->
                        <div id="jobDetailsSection" style="display: none; background: #f8f9fa; padding: 1.5rem; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 2rem; border: 1px solid #e5e7eb;">
                            <!-- Post Header -->
                            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #0d1f3c 0%, #1a3a5c 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="bi bi-building" style="color: white; font-size: 1.8rem;"></i>
                                </div>
                                <div>
                                    <div style="font-weight: 700; color: #0d1f3c; font-size: 1.2rem;" id="displayEmployerCompany"></div>
                                    <div style="color: #6b7280; font-size: 0.95rem;" id="displayEmployerName"></div>
                                </div>
                            </div>
                            
                            <!-- Job Title -->
                            <h3 style="font-size: 1.6rem; font-weight: 800; color: #0d1f3c; margin: 0 0 1.5rem 0;" id="displayJobTitle"></h3>
                            
                            <!-- Job Details Grid -->
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                                <!-- Location -->
                                <div style="display: flex; gap: 1rem;">
                                    <div style="color: #d72638; font-size: 1.5rem; flex-shrink: 0;">
                                        <i class="bi bi-geo-alt-fill"></i>
                                    </div>
                                    <div>
                                        <div style="font-size: 0.85rem; color: #6b7280; font-weight: 600; text-transform: uppercase; margin-bottom: 0.25rem;">Location</div>
                                        <div style="font-size: 1.1rem; color: #0d1f3c; font-weight: 600;" id="displayLocation"></div>
                                    </div>
                                </div>
                                
                                <!-- Salary -->
                                <div style="display: flex; gap: 1rem;">
                                    <div style="color: #d72638; font-size: 1.5rem; flex-shrink: 0;">
                                        <i class="bi bi-cash-coin"></i>
                                    </div>
                                    <div>
                                        <div style="font-size: 0.85rem; color: #6b7280; font-weight: 600; text-transform: uppercase; margin-bottom: 0.25rem;">Salary Range</div>
                                        <div style="font-size: 1.1rem; color: #0d1f3c; font-weight: 600;" id="displaySalary"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Divider -->
                            <hr style="margin: 1.5rem 0; border: none; border-top: 1px solid #e5e7eb;">
                            
                            <!-- Job Description -->
                            <div style="margin-bottom: 1.5rem;">
                                <div style="font-size: 0.85rem; color: #6b7280; font-weight: 600; text-transform: uppercase; margin-bottom: 0.75rem;">About This Job</div>
                                <div style="font-size: 1rem; color: #1f2937; line-height: 1.6; background: white; padding: 1rem; border-radius: 8px; border-left: 3px solid #d72638;" id="displayJobDescription">No description provided</div>
                            </div>
                            
                            <!-- More Details Button -->
                            <button type="button" id="moreDetailsBtn" class="btn" style="width: 100%; border-radius: 8px; padding: 0.75rem 1.5rem; font-weight: 600; font-size: 1rem; background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); border: none; color: white; cursor: pointer; margin-bottom: 1.5rem;"><i class="bi bi-info-circle me-2"></i>More Details</button>
                        </div>
                        
                        <!-- Message/Note Section -->
                        <div class="mb-0">
                            <label for="messageInput" class="form-label" style="font-weight: 700; color: #0d1f3c; margin-bottom: 0.75rem; font-size: 1rem;">
                                <i class="bi bi-chat-dots me-2" style="color: #d72638;"></i>Personal Message (Optional)
                            </label>
                            <textarea id="messageInput" name="message" class="form-control" rows="4" 
                                      placeholder="Write a personal message to the applicant about this opportunity..." 
                                      style="border-radius: 8px; border: 2px solid #d72638; padding: 1rem; font-size: 1rem; color: #0d1f3c; font-family: inherit;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: 2px solid #e5e7eb; padding: 1.5rem; background: #f8f9fa; border-radius: 0 0 12px 12px; display: flex; gap: 1rem; justify-content: flex-end;">
                        <button type="button" class="btn" data-bs-dismiss="modal" style="border-radius: 8px; padding: 0.75rem 2rem; font-weight: 600; font-size: 1rem; background: #e5e7eb; color: #0d1f3c; border: none; cursor: pointer;">Cancel</button>
                        <button type="submit" class="btn" style="border-radius: 8px; padding: 0.75rem 2rem; font-weight: 600; font-size: 1rem; background: linear-gradient(135deg, #d72638 0%, #c91f32 100%); border: none; color: white; cursor: pointer;"><i class="bi bi-check-circle me-2"></i>Recommend Applicant</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Detailed Job Modal -->
    <style>
        .job-detail-modal .modal-content {
            border: none;
            border-radius: 16px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .job-detail-modal .modal-header {
            background: linear-gradient(135deg, #0d1f3c 0%, #1a3a52 100%);
            border-bottom: none;
            border-radius: 16px 16px 0 0;
            padding: 2rem;
        }

        .job-detail-modal .modal-title {
            font-size: 1.8rem;
            font-weight: 800;
            color: white;
            letter-spacing: -0.5px;
        }

        .job-detail-modal .modal-body {
            padding: 2rem;
            background: #f9fafb;
        }

        .detail-section {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid #2563eb;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .detail-section h5 {
            font-size: 1.1rem;
            font-weight: 800;
            color: #0d1f3c;
            margin-bottom: 1.2rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .detail-section h5 i {
            color: #2563eb;
            font-size: 1.2rem;
        }

        .detail-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1rem;
        }

        .detail-row.full {
            grid-template-columns: 1fr;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
        }

        .detail-label {
            font-size: 0.85rem;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin-bottom: 0.5rem;
        }

        .detail-value {
            font-size: 1rem;
            color: #1f2937;
            font-weight: 600;
            line-height: 1.5;
        }

        .detail-value.description {
            font-size: 0.95rem;
            color: #374151;
            line-height: 1.7;
            padding: 1rem;
            background: #f3f4f6;
            border-radius: 8px;
            border-left: 3px solid #d72638;
        }

        .bullet-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .bullet-list li {
            font-size: 0.95rem;
            color: #374151;
            margin-bottom: 0.6rem;
            padding-left: 1.5rem;
            position: relative;
        }

        .bullet-list li:before {
            content: "•";
            color: #2563eb;
            font-weight: bold;
            position: absolute;
            left: 0;
        }

        .badge-inline {
            display: inline-block;
            padding: 0.4rem 0.9rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid rgba(6, 95, 70, 0.2);
        }
    </style>
    
    <div class="modal fade job-detail-modal" id="jobDetailModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="jobDetailTitle">Job Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Basic Information -->
                    <div class="detail-section">
                        <h5><i class="bi bi-briefcase"></i>Job Overview</h5>
                        <div class="detail-row">
                            <div class="detail-item">
                                <span class="detail-label">Job Title</span>
                                <span class="detail-value" id="detailTitle">-</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Company</span>
                                <span class="detail-value" id="detailCompany">-</span>
                            </div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-item">
                                <span class="detail-label">Location</span>
                                <span class="detail-value" id="detailLocation">-</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Job Type</span>
                                <span class="detail-value" id="detailJobType">-</span>
                            </div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-item">
                                <span class="detail-label">Salary Range</span>
                                <span class="detail-value" id="detailSalary" style="color: #059669;">-</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Vacancies</span>
                                <span class="detail-value" id="detailVacancies">-</span>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="detail-section" id="descriptionSection" style="display: none;">
                        <h5><i class="bi bi-text-left"></i>Description</h5>
                        <div class="detail-value description" id="detailDescription">-</div>
                    </div>

                    <!-- Requirements -->
                    <div class="detail-section" id="requirementsSection" style="display: none;">
                        <h5><i class="bi bi-list-check"></i>Requirements</h5>
                        <div class="detail-value" id="detailRequirements">-</div>
                    </div>

                    <!-- Qualifications -->
                    <div class="detail-section" id="qualificationsSection" style="display: none;">
                        <h5><i class="bi bi-mortarboard"></i>Qualifications</h5>
                        <ul class="bullet-list" id="detailQualifications">
                            <li>-</li>
                        </ul>
                    </div>

                    <!-- Key Responsibilities -->
                    <div class="detail-section" id="responsibilitiesSection" style="display: none;">
                        <h5><i class="bi bi-list-task"></i>Key Responsibilities</h5>
                        <ul class="bullet-list" id="detailResponsibilities">
                            <li>-</li>
                        </ul>
                    </div>

                    <!-- Preferred Skills -->
                    <div class="detail-section" id="skillsSection" style="display: none;">
                        <h5><i class="bi bi-star"></i>Preferred Skills</h5>
                        <ul class="bullet-list" id="detailSkills">
                            <li>-</li>
                        </ul>
                    </div>

                    <!-- Experience & Education -->
                    <div class="detail-section" id="experienceSection" style="display: none;">
                        <h5><i class="bi bi-person-workspace"></i>Experience & Education</h5>
                        <div class="detail-row">
                            <div class="detail-item" id="experienceItem" style="display: none;">
                                <span class="detail-label">Experience Required</span>
                                <div class="detail-value" id="detailExperience">-</div>
                            </div>
                            <div class="detail-item" id="educationItem" style="display: none;">
                                <span class="detail-label">Education Required</span>
                                <div class="detail-value" id="detailEducation">-</div>
                            </div>
                        </div>
                    </div>

                    <!-- Benefits -->
                    <div class="detail-section" id="benefitsSection" style="display: none;">
                        <h5><i class="bi bi-gift"></i>Benefits</h5>
                        <ul class="bullet-list" id="detailBenefits">
                            <li>-</li>
                        </ul>
                    </div>

                    <!-- Application Dates -->
                    <div class="detail-section">
                        <h5><i class="bi bi-calendar-event"></i>Application Period</h5>
                        <div class="detail-row">
                            <div class="detail-item">
                                <span class="detail-label">Start Date</span>
                                <span class="detail-value" id="detailStartDate">-</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">End Date</span>
                                <span class="detail-value" id="detailEndDate">-</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const jobsByEmployer = {
            @foreach($availableJobs->groupBy('employer_id') as $employerId => $jobs)
                {{ $employerId }}: [
                    @foreach($jobs as $job)
                        {
                            id: {{ $job->id }},
                            title: '{{ addslashes($job->title) }}',
                            employerName: '{{ addslashes($job->employer?->name ?? 'Unknown') }}',
                            companyName: '{{ addslashes($job->employer?->companyProfile?->company_name ?? $job->employer?->name ?? 'Unknown Company') }}',
                            location: '{{ addslashes($job->location ?? 'N/A') }}',
                            salary: '{{ addslashes($job->salary_range ?? 'Not specified') }}',
                            description: '{{ addslashes($job->description ?? 'No description provided') }}',
                            jobType: '{{ addslashes($job->job_type ?? 'N/A') }}',
                            vacancies: {{ $job->vacancies ?? 0 }},
                            qualifications: '{{ addslashes($job->qualifications ?? '') }}',
                            keyResponsibilities: '{{ addslashes($job->key_responsibilities ?? '') }}',
                            preferredSkills: '{{ addslashes($job->preferred_skills ?? '') }}',
                            experience: '{{ addslashes($job->experience ?? '') }}',
                            education: '{{ addslashes($job->education ?? '') }}',
                            benefits: '{{ addslashes($job->benefits ?? '') }}',
                            requirements: '{{ addslashes($job->requirements ?? '') }}',
                            applicationStartDate: '{{ $job->application_start_date?->format('Y-m-d') ?? '' }}',
                            applicationEndDate: '{{ $job->application_end_date?->format('Y-m-d') ?? '' }}'
                        },
                    @endforeach
                ],
            @endforeach
        };
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const openModalButtons = document.querySelectorAll('.open-recommend-modal');
            const recommendModal = document.getElementById('recommendModal');
            const recommendForm = document.getElementById('recommendForm');
            const jobseekerNameSpan = document.getElementById('jobseekerName');
            const employerSelect = document.getElementById('employerSelect');
            const jobSelect = document.getElementById('jobSelect');
            const jobDetailsSection = document.getElementById('jobDetailsSection');
            const displayJobTitle = document.getElementById('displayJobTitle');
            const displayEmployerCompany = document.getElementById('displayEmployerCompany');
            const displayEmployerName = document.getElementById('displayEmployerName');
            const displayLocation = document.getElementById('displayLocation');
            const displaySalary = document.getElementById('displaySalary');
            let currentJobseekerId = null;

            // Handle employer selection change - populate jobs
            employerSelect.addEventListener('change', function() {
                jobSelect.innerHTML = '<option value="">-- Choose a Job --</option>';
                jobDetailsSection.style.display = 'none';
                jobSelect.value = '';
                
                if (this.value && jobsByEmployer[this.value]) {
                    jobSelect.disabled = false;
                    jobsByEmployer[this.value].forEach(job => {
                        const option = document.createElement('option');
                        option.value = job.id;
                        option.textContent = job.title;
                        option.dataset.jobTitle = job.title;
                        option.dataset.employerName = job.employerName;
                        option.dataset.companyName = job.companyName;
                        option.dataset.location = job.location;
                        option.dataset.salary = job.salary;
                        jobSelect.appendChild(option);
                    });
                } else {
                    jobSelect.disabled = true;
                }
            });

            // Handle job selection change to display details
            jobSelect.addEventListener('change', function() {
                if (this.value) {
                    const selectedOption = this.options[this.selectedIndex];
                    const jobTitle = selectedOption.dataset.jobTitle;
                    const employerName = selectedOption.dataset.employerName;
                    const companyName = selectedOption.dataset.companyName;
                    const location = selectedOption.dataset.location;
                    const salary = selectedOption.dataset.salary;
                    const description = selectedOption.dataset.description;
                    
                    displayJobTitle.textContent = jobTitle;
                    displayEmployerCompany.textContent = companyName;
                    displayEmployerName.textContent = employerName !== companyName ? employerName : '';
                    displayLocation.textContent = location;
                    displaySalary.textContent = salary;
                    document.getElementById('displayJobDescription').textContent = description || 'No description provided';
                    
                    jobDetailsSection.style.display = 'block';
                } else {
                    jobDetailsSection.style.display = 'none';
                }
            });

            openModalButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const jobseekerId = this.dataset.jobseekerId;
                    const jobseekerName = this.dataset.jobseekerName;

                    currentJobseekerId = jobseekerId;
                    jobseekerNameSpan.textContent = jobseekerName;

                    // Update form action for applicant recommendation
                    recommendForm.action = @json(route('admin.jobseekers.recommend-applicant', ['jobseeker' => '__JOBSEEKER_ID__'])).replace('__JOBSEEKER_ID__', jobseekerId);
                    console.log('Form action set to:', recommendForm.action);
                    console.log('Jobseeker:', jobseekerId, jobseekerName);
                    
                    // Reset form fields
                    employerSelect.value = '';
                    jobSelect.value = '';
                    jobSelect.disabled = true;
                    jobSelect.innerHTML = '<option value="">-- Choose a Job --</option>';
                    document.getElementById('messageInput').value = '';
                    jobDetailsSection.style.display = 'none';

                    // Show modal using Bootstrap
                    const modal = new bootstrap.Modal(recommendModal, {
                        keyboard: false,
                        backdrop: 'static'
                    });
                    modal.show();
                });
            });

            // Handle More Details button click
            document.getElementById('moreDetailsBtn').addEventListener('click', function() {
                const selectedJobId = jobSelect.value;
                if (!selectedJobId) {
                    alert('Please select a job first');
                    return;
                }

                // Find the selected job data
                let selectedJob = null;
                for (let employerId in jobsByEmployer) {
                    const jobs = jobsByEmployer[employerId];
                    selectedJob = jobs.find(j => j.id == selectedJobId);
                    if (selectedJob) break;
                }

                if (!selectedJob) return;

                // Populate and show detailed modal
                showJobDetailsModal(selectedJob);
            });

            function parseList(text) {
                if (!text || text === '' || text === 'NULL') return [];
                return text.split('\\n').filter(item => item.trim() !== '');
            }

            function showJobDetailsModal(jobData) {
                // Basic info
                document.getElementById('jobDetailTitle').textContent = jobData.title;
                document.getElementById('detailTitle').textContent = jobData.title;
                document.getElementById('detailCompany').textContent = jobData.companyName;
                document.getElementById('detailLocation').textContent = jobData.location;
                document.getElementById('detailJobType').textContent = (jobData.jobType || 'N/A').replace(/_/g, ' ').charAt(0).toUpperCase() + (jobData.jobType || 'N/A').replace(/_/g, ' ').slice(1);
                document.getElementById('detailSalary').textContent = jobData.salary || 'Not specified';
                document.getElementById('detailVacancies').textContent = jobData.vacancies || '0';

                // Description
                if (jobData.description && jobData.description !== 'NULL' && jobData.description !== '') {
                    document.getElementById('descriptionSection').style.display = 'block';
                    document.getElementById('detailDescription').textContent = jobData.description;
                } else {
                    document.getElementById('descriptionSection').style.display = 'none';
                }

                // Requirements
                if (jobData.requirements && jobData.requirements !== 'NULL' && jobData.requirements !== '') {
                    document.getElementById('requirementsSection').style.display = 'block';
                    document.getElementById('detailRequirements').textContent = jobData.requirements;
                } else {
                    document.getElementById('requirementsSection').style.display = 'none';
                }

                // Qualifications
                const qualifications = parseList(jobData.qualifications);
                if (qualifications.length > 0) {
                    document.getElementById('qualificationsSection').style.display = 'block';
                    const qualList = document.getElementById('detailQualifications');
                    qualList.innerHTML = qualifications.map(q => `<li>${q}</li>`).join('');
                } else {
                    document.getElementById('qualificationsSection').style.display = 'none';
                }

                // Responsibilities
                const responsibilities = parseList(jobData.keyResponsibilities);
                if (responsibilities.length > 0) {
                    document.getElementById('responsibilitiesSection').style.display = 'block';
                    const respList = document.getElementById('detailResponsibilities');
                    respList.innerHTML = responsibilities.map(r => `<li>${r}</li>`).join('');
                } else {
                    document.getElementById('responsibilitiesSection').style.display = 'none';
                }

                // Skills
                const skills = parseList(jobData.preferredSkills);
                if (skills.length > 0) {
                    document.getElementById('skillsSection').style.display = 'block';
                    const skillsList = document.getElementById('detailSkills');
                    skillsList.innerHTML = skills.map(s => `<li>${s}</li>`).join('');
                } else {
                    document.getElementById('skillsSection').style.display = 'none';
                }

                // Experience & Education
                const hasExperience = jobData.experience && jobData.experience !== 'NULL' && jobData.experience !== '';
                const hasEducation = jobData.education && jobData.education !== 'NULL' && jobData.education !== '';
                
                if (hasExperience || hasEducation) {
                    document.getElementById('experienceSection').style.display = 'block';
                    if (hasExperience) {
                        document.getElementById('experienceItem').style.display = 'block';
                        const expList = parseList(jobData.experience);
                        document.getElementById('detailExperience').innerHTML = expList.length > 0 
                            ? expList.map(e => `<div style="margin-bottom: 0.5rem;">${e}</div>`).join('')
                            : jobData.experience;
                    } else {
                        document.getElementById('experienceItem').style.display = 'none';
                    }
                    
                    if (hasEducation) {
                        document.getElementById('educationItem').style.display = 'block';
                        const eduList = parseList(jobData.education);
                        document.getElementById('detailEducation').innerHTML = eduList.length > 0 
                            ? eduList.map(e => `<div style="margin-bottom: 0.5rem;">${e}</div>`).join('')
                            : jobData.education;
                    } else {
                        document.getElementById('educationItem').style.display = 'none';
                    }
                } else {
                    document.getElementById('experienceSection').style.display = 'none';
                }

                // Benefits
                const benefits = parseList(jobData.benefits);
                if (benefits.length > 0) {
                    document.getElementById('benefitsSection').style.display = 'block';
                    const benefitsList = document.getElementById('detailBenefits');
                    benefitsList.innerHTML = benefits.map(b => `<li>${b}</li>`).join('');
                } else {
                    document.getElementById('benefitsSection').style.display = 'none';
                }

                // Dates
                document.getElementById('detailStartDate').textContent = jobData.applicationStartDate 
                    ? new Date(jobData.applicationStartDate).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })
                    : 'Not specified';
                document.getElementById('detailEndDate').textContent = jobData.applicationEndDate 
                    ? new Date(jobData.applicationEndDate).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })
                    : 'Not specified';

                // Show modal
                const detailModal = new bootstrap.Modal(document.getElementById('jobDetailModal'));
                detailModal.show();
            }
        });

        // Debug: Form submission listener
        recommendForm.addEventListener('submit', function(e) {
            console.log('✅ FORM SUBMIT EVENT FIRED!');
            console.log('Form Action:', this.action);
            console.log('Employer ID:', document.getElementById('employerSelect').value);
            console.log('Job ID:', document.getElementById('jobSelect').value);
            console.log('Message:', document.getElementById('messageInput').value);
            console.log('CSRF Token:', document.querySelector('[name="_token"]')?.value);
            console.log('Full form data:', new FormData(this));
        });
    </script>
</div>

@endsection
