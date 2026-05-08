@extends('layouts.admin-dashboard')

@section('title', $jobseeker->name . ' | Jobseeker Profile | PESO Admin')

<?php
    $pageTitle = $jobseeker->name;
    $pageSubtitle = 'Jobseeker Profile & Management';
    $pageIcon = 'bi-person-circle';
?>

@section('content')
<div class="admin-dashboard">
    <style>
        .profile-header {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .profile-card {
            background: linear-gradient(135deg, #ffffff 0%, #fafbfc 100%);
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.12), 0 1px 3px rgba(0, 0, 0, 0.08);
            border: 2px solid #d1d5db;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .profile-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #1f2937 0%, #374151 100%);
            border-radius: 16px 16px 0 0;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 16px;
            background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            font-size: 40px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            margin-bottom: 1.5rem;
        }

        .profile-info h3 {
            margin: 0 0 0.5rem 0;
            color: #1f2937;
            font-weight: 800;
            font-size: 24px;
        }

        .profile-info p {
            margin: 0.25rem 0;
            color: #6b7280;
            font-size: 14px;
        }

        .profile-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid #e5e7eb;
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 800;
            color: #1f2937;
        }

        .stat-label {
            font-size: 12px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 0.5rem;
        }

        .action-sidebar {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .btn-action {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 12px 16px;
            border-radius: 12px;
            border: none;
            font-weight: 700;
            font-size: 14px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-back {
            background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%);
            color: #374151;
        }

        .btn-back:hover {
            background: linear-gradient(135deg, #d1d5db 0%, #bfdbfe 100%);
            transform: translateY(-2px);
        }

        .btn-recommend {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: #92400e;
        }

        .btn-recommend:hover {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            transform: translateY(-2px);
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
            margin-bottom: 2rem;
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

        .dashboard-card h5 {
            color: #1f2937;
            font-weight: 800;
            margin: 0 0 1.75rem 0;
            padding-bottom: 1.25rem;
            border-bottom: 2px solid #d1d5db;
            font-size: 18px;
            letter-spacing: -0.3px;
        }

        .dashboard-card h5 i {
            color: #374151;
            margin-right: 0.5rem;
        }

        .info-row {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .info-label {
            font-weight: 700;
            color: #6b7280;
            min-width: 120px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            color: #1f2937;
            font-weight: 600;
        }

        .application-item {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .application-item:hover {
            border-color: #d1d5db;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .application-title {
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .application-company {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 0.75rem;
        }

        .application-status {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-applied {
            background: #dbeafe;
            color: #1e40af;
        }

        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #9ca3af;
        }

        .empty-state i {
            font-size: 3rem;
            opacity: 0.3;
            color: #d1d5db;
            margin-bottom: 1rem;
        }

        .empty-state p {
            margin: 0.5rem 0;
            font-weight: 700;
            color: #6b7280;
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

    <div class="profile-header">
        <div class="profile-card">
            <div class="profile-avatar">{{ strtoupper(substr($jobseeker->name ?? 'U', 0, 1)) }}</div>
            <div class="profile-info">
                <h3>{{ $jobseeker->name }}</h3>
                <p><i class="bi bi-envelope me-2"></i>{{ $jobseeker->email }}</p>
                @if($jobseeker->profile?->phone)
                    <p><i class="bi bi-telephone me-2"></i>{{ $jobseeker->profile->phone }}</p>
                @endif
                <p><i class="bi bi-calendar me-2"></i>Member since {{ $jobseeker->created_at->format('M d, Y') }}</p>

                <div class="profile-stats">
                    <div class="stat-item">
                        <div class="stat-value">{{ $jobseeker->applications->count() }}</div>
                        <div class="stat-label">Applications</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $availableJobs->count() }}</div>
                        <div class="stat-label">Jobs Available</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="action-sidebar">
            <a href="{{ route('admin.jobseekers.index') }}" class="btn btn-action btn-back">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
            <button type="button" class="btn btn-action btn-recommend open-recommend-modal" 
                    data-jobseeker-id="{{ $jobseeker->id }}"
                    data-jobseeker-name="{{ $jobseeker->name }}">
                <i class="bi bi-star"></i> Recommend Job
            </button>
        </div>
    </div>

    @if($jobseeker->profile)
    <div class="dashboard-card">
        <h5><i class="bi bi-person-lines-fill me-2"></i>Profile Information</h5>
        
        @if($jobseeker->profile->about)
            <div class="info-row">
                <div class="info-label">About</div>
                <div class="info-value">{{ $jobseeker->profile->about }}</div>
            </div>
        @endif

        @if($jobseeker->profile->skills)
            <div class="info-row">
                <div class="info-label">Skills</div>
                <div class="info-value">{{ $jobseeker->profile->skills }}</div>
            </div>
        @endif

        @if($jobseeker->profile->location)
            <div class="info-row">
                <div class="info-label">Location</div>
                <div class="info-value">{{ $jobseeker->profile->location }}</div>
            </div>
        @endif

        @if($jobseeker->profile->preferred_job_title)
            <div class="info-row">
                <div class="info-label">Preferred Title</div>
                <div class="info-value">{{ $jobseeker->profile->preferred_job_title }}</div>
            </div>
        @endif
    </div>
    @endif

    <div class="dashboard-card">
        <h5><i class="bi bi-file-earmark-text me-2"></i>Applications History</h5>
        
        @if($jobseeker->applications->count() > 0)
            @foreach($jobseeker->applications as $application)
                <div class="application-item">
                    <div class="application-title">{{ $application->job->title ?? 'N/A' }}</div>
                    <div class="application-company">
                        <i class="bi bi-building me-1"></i>{{ $application->job->company->company_name ?? 'Unknown Company' }}
                    </div>
                    <div>
                        <span class="application-status status-applied">{{ ucfirst($application->status) }}</span>
                        <span style="font-size: 12px; color: #9ca3af; margin-left: 1rem;">
                            Applied on {{ $application->created_at->format('M d, Y') }}
                        </span>
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <p>No Applications Yet</p>
                <small>This jobseeker hasn't applied to any positions</small>
            </div>
        @endif
    </div>

    <!-- Single Reusable Recommendation Modal -->
    <div class="modal fade" id="recommendModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #0d1f3c 0%, #1a3a5c 100%); border-bottom: 2px solid #d72638;">
                    <h5 class="modal-title" style="color: white; font-weight: 800;"><i class="bi bi-star-fill me-2"></i>Recommend a Job</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="recommendForm" method="POST">
                    @csrf
                    <div class="modal-body" style="padding: 2rem;">
                        <p class="text-muted mb-3">Recommending a job to: <strong id="jobseekerName">N/A</strong></p>
                        
                        <!-- Step 1: Select Employer -->
                        <div class="mb-3">
                            <label for="employerSelect" class="form-label">
                                Select Employer <span class="text-danger">*</span>
                            </label>
                            <select id="employerSelect" class="form-control" required>
                                <option value="">-- Choose an Employer --</option>
                                @php
                                    $employers = $availableJobs->groupBy(function($job) {
                                        return $job->employer_id ?? 0;
                                    })->map(function($jobs) {
                                        return [
                                            'id' => $jobs->first()->employer_id,
                                            'name' => $jobs->first()->employer?->name ?? 'Unknown',
                                            'company_name' => $jobs->first()->employer?->companyProfile?->company_name ?? $jobs->first()->employer?->name ?? 'Unknown Company'
                                        ];
                                    });
                                @endphp
                                @foreach($employers as $employer)
                                    <option value="{{ $employer['id'] }}">{{ $employer['company_name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Step 2: Select Job (dynamically populated) -->
                        <div class="mb-3">
                            <label for="jobSelect" class="form-label">
                                Select Job <span class="text-danger">*</span>
                            </label>
                            <select id="jobSelect" name="job_id" class="form-control" required disabled>
                                <option value="">-- Choose a Job --</option>
                            </select>
                        </div>
                        
                        <!-- Job Details Display -->
                        <div id="jobDetailsSection" style="display: none; background: #f8f9fa; padding: 1rem; border-radius: 6px; margin-bottom: 1rem; border-left: 4px solid #d72638;">
                            <div class="mb-2">
                                <span style="font-size: 0.85rem; color: #6b7280; text-transform: uppercase; font-weight: 600;">Job Title</span>
                                <div style="font-size: 1rem; font-weight: 700; color: #0d1f3c;" id="displayJobTitle"></div>
                            </div>
                            <div class="mb-2">
                                <span style="font-size: 0.85rem; color: #6b7280; text-transform: uppercase; font-weight: 600;">Employer</span>
                                <div style="font-size: 0.95rem; color: #1f2937;" id="displayEmployerInfo"></div>
                            </div>
                            <div class="mb-2">
                                <span style="font-size: 0.85rem; color: #6b7280; text-transform: uppercase; font-weight: 600;">Location</span>
                                <div style="font-size: 0.95rem; color: #1f2937;" id="displayLocation"></div>
                            </div>
                            <div>
                                <span style="font-size: 0.85rem; color: #6b7280; text-transform: uppercase; font-weight: 600;">Salary Range</span>
                                <div style="font-size: 0.95rem; color: #1f2937;" id="displaySalary"></div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="messageInput" class="form-label">
                                Message (Optional)
                            </label>
                            <textarea id="messageInput" name="message" class="form-control" rows="3" 
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
    
    <!-- Hidden data storage for jobs by employer -->
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
                            salary: '{{ addslashes($job->salary_range ?? 'Not specified') }}'
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
            const displayEmployerInfo = document.getElementById('displayEmployerInfo');
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
                    
                    displayJobTitle.textContent = jobTitle;
                    displayEmployerInfo.textContent = `${companyName}` + (employerName !== companyName ? ` (${employerName})` : '');
                    displayLocation.textContent = location;
                    displaySalary.textContent = salary;
                    
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

                    // Update form action
                    recommendForm.action = '/admin/jobseekers/' + jobseekerId + '/recommend-job';
                    
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
        });
    </script>
</div>

@endsection
