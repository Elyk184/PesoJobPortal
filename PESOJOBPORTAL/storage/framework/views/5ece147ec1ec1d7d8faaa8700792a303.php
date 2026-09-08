<?php $__env->startSection('title', 'Jobs Management | PESO Admin'); ?>

<?php
    $pageTitle = 'Jobs Management';
    $pageSubtitle = 'Manage all job postings in the system';
    $pageIcon = 'bi-briefcase';
?>

<?php $__env->startSection('content'); ?>
<div class="admin-dashboard">
    <style>
        .admin-dashboard {
            padding: 1.5rem;
        }

        .management-table {
            width: 100%;
            background: white;
            border-radius: 18px;
            box-shadow: 0 20px 40px rgba(17, 39, 76, 0.1);
            overflow-x: auto;
            overflow-y: hidden;
            border: 1px solid #e5e7eb;
            margin-top: 0;
        }

        .management-table table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1400px;
        }

        .management-table thead {
            background: linear-gradient(135deg, #fbfdff 0%, #f3f7fc 100%);
            border-bottom: 2px solid #e5e7eb;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .management-table th {
            padding: 1.2rem 1rem;
            text-align: left;
            font-weight: 800;
            color: #0d1f3c;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            word-spacing: 1px;
            white-space: nowrap;
        }

        .management-table td {
            padding: 1.2rem 1rem;
            vertical-align: middle;
            font-size: 13px;
            border-bottom: 1px solid #f3f4f6;
            line-height: 1.4;
        }

        .management-table tbody tr {
            transition: all 0.2s ease;
        }

        .management-table tbody tr:hover {
            background: #f8fbff;
            box-shadow: inset 0 2px 8px rgba(56, 101, 179, 0.08);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            white-space: nowrap;
        }

        .status-active {
            background: linear-gradient(135deg, #d1fae5 0%, #c0f3d6 100%);
            color: #065f46;
            border: 1px solid rgba(6, 95, 70, 0.2);
        }

        .status-closed {
            background: linear-gradient(135deg, #fee2e2 0%, #fdd8d8 100%);
            color: #991b1b;
            border: 1px solid rgba(153, 27, 27, 0.2);
        }

        .job-type-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.35rem 0.7rem;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            background: #eff6ff;
            color: #0369a1;
            border: 1px solid rgba(3, 105, 161, 0.2);
            white-space: nowrap;
        }

        .btn-small {
            padding: 0.45rem 0.95rem;
            border: none;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.35rem;
            white-space: nowrap;
            width: 95px;
            height: 34px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            letter-spacing: 0.2px;
        }

        .btn-view {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .btn-view:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
            transform: translateY(-2px);
        }

        .btn-close {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .btn-close:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            box-shadow: 0 8px 20px rgba(220, 38, 38, 0.3);
            transform: translateY(-2px);
        }

        .job-title {
            font-weight: 800;
            color: #0f1729;
            letter-spacing: 0.2px;
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .job-company {
            color: #475569;
            font-weight: 600;
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .job-date {
            color: #64748b;
            font-weight: 500;
            white-space: nowrap;
        }

        .job-location {
            color: #475569;
            font-weight: 500;
            max-width: 120px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .job-salary {
            color: #059669;
            font-weight: 700;
            white-space: nowrap;
        }

        .job-applications {
            font-weight: 700;
            color: #1f2937;
            text-align: center;
            white-space: nowrap;
        }

        .job-vacancies {
            font-weight: 600;
            color: #1f2937;
            text-align: center;
            white-space: nowrap;
        }

        .job-deadline {
            color: #64748b;
            font-weight: 500;
            white-space: nowrap;
            font-size: 12px;
        }

        .job-requirements {
            color: #475569;
            font-weight: 500;
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-size: 12px;
        }

        .actions-cell {
            display: flex;
            gap: 0.6rem;
            align-items: center;
            justify-content: flex-start;
            white-space: nowrap;
        }

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

        .badge-filled {
            background: #fef08a;
            color: #713f12;
            border: 1px solid rgba(113, 63, 18, 0.2);
        }

        .job-detail-modal .modal-close-btn {
            background: white;
            color: #6b7280;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .job-detail-modal .modal-close-btn:hover {
            background: #f3f4f6;
            color: #1f2937;
        }
    </style>

    <div class="management-table">
        <table>
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Company</th>
                    <th>Location</th>
                    <th>Job Type</th>
                    <th>Vacancies</th>
                    <th>Salary Range</th>
                    <th>Apps</th>
                    <th>Deadline</th>
                    <th>Requirements</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr data-job-id="<?php echo e($job->id); ?>" 
                        data-job-title="<?php echo e($job->title); ?>"
                        data-job-position="<?php echo e($job->position); ?>"
                        data-job-description="<?php echo e(addslashes($job->description)); ?>"
                        data-job-qualifications="<?php echo e(addslashes($job->qualifications)); ?>"
                        data-job-responsibilities="<?php echo e(addslashes($job->key_responsibilities)); ?>"
                        data-job-skills="<?php echo e(addslashes($job->preferred_skills)); ?>"
                        data-job-experience="<?php echo e(addslashes($job->experience)); ?>"
                        data-job-education="<?php echo e(addslashes($job->education)); ?>"
                        data-job-benefits="<?php echo e(addslashes($job->benefits)); ?>"
                        data-job-company="<?php echo e($job->employer?->companyProfile?->company_name ?? $job->employer_name ?? 'N/A'); ?>"
                        data-job-location="<?php echo e($job->location); ?>"
                        data-job-type="<?php echo e($job->job_type); ?>"
                        data-job-vacancies="<?php echo e($job->vacancies); ?>"
                        data-job-salary="<?php echo e($job->salary_range ?? $job->salary); ?>"
                        data-job-requirements="<?php echo e(addslashes($job->requirements)); ?>"
                        data-job-start-date="<?php echo e($job->application_start_date?->format('Y-m-d')); ?>"
                        data-job-end-date="<?php echo e($job->application_end_date?->format('Y-m-d')); ?>"
                        data-job-applications="<?php echo e($job->applications?->count() ?? 0); ?>"
                        data-job-filled="<?php echo e($job->is_filled ? '1' : '0'); ?>"
                        data-job-status="<?php echo e($job->status); ?>">
                        <td class="job-title"><?php echo e($job->title); ?></td>
                        <td class="job-company"><?php echo e($job->employer?->companyProfile?->company_name ?? $job->employer_name ?? 'N/A'); ?></td>
                        <td class="job-location"><?php echo e($job->location ?? 'N/A'); ?></td>
                        <td><span class="job-type-badge"><i class="bi bi-clock-history"></i><?php echo e(ucfirst(str_replace('_', ' ', $job->job_type ?? 'N/A'))); ?></span></td>
                        <td class="job-vacancies"><?php echo e($job->vacancies ?? 0); ?></td>
                        <td class="job-salary"><?php echo e($job->salary_range ?? $job->salary ?? 'N/A'); ?></td>
                        <td class="job-applications"><?php echo e($job->applications?->count() ?? 0); ?></td>
                        <td class="job-deadline"><?php echo e($job->application_end_date?->format('d M Y') ?? 'N/A'); ?></td>
                        <td class="job-requirements" title="<?php echo e($job->requirements ?? ''); ?>"><?php echo e($job->requirements ?? 'N/A'); ?></td>
                        <td><span class="status-badge status-active"><i class="bi bi-check-circle me-1"></i>Active</span></td>
                        <td class="actions-cell">
                            <button class="btn-small btn-view open-job-details"><i class="bi bi-eye me-1"></i>View</button>
                            <button class="btn-small btn-close"><i class="bi bi-x-lg me-1"></i>Close</button>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="11" style="text-align: center; padding: 2rem; color: #6b7280;">
                            <i class="bi bi-inbox" style="font-size: 2rem; display: block; margin-bottom: 0.5rem;"></i>
                            No active jobs at the moment.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Job Details Modal -->
    <div class="modal fade job-detail-modal" id="jobDetailModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="jobDetailTitle">Job Details</h5>
                    <button type="button" class="modal-close-btn" data-dismiss="modal">
                        <i class="bi bi-x-lg"></i>
                    </button>
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

                    <!-- Requirements & Skills -->
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

                    <!-- Statistics -->
                    <div class="detail-section">
                        <h5><i class="bi bi-graph-up"></i>Statistics</h5>
                        <div class="detail-row">
                            <div class="detail-item">
                                <span class="detail-label">Applications Received</span>
                                <span class="detail-value" id="detailApplications">0</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Status</span>
                                <span class="detail-value">
                                    <span class="badge-inline badge-success" id="detailStatusBadge">Active</span>
                                    <span class="badge-inline badge-filled" id="detailFilledBadge" style="display: none;">Filled</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle View button clicks
        document.querySelectorAll('.open-job-details').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('tr');
                const jobData = row.dataset;
                openJobDetailModal(jobData);
            });
        });
    });

    function parseList(text) {
        if (!text || text === 'NULL' || text === '') return [];
        return text.split('\\n').filter(item => item.trim() !== '');
    }

    function openJobDetailModal(jobData) {
        // Basic info
        document.getElementById('jobDetailTitle').textContent = jobData.jobTitle;
        document.getElementById('detailTitle').textContent = jobData.jobTitle;
        document.getElementById('detailCompany').textContent = jobData.jobCompany;
        document.getElementById('detailLocation').textContent = jobData.jobLocation;
        document.getElementById('detailJobType').textContent = (jobData.jobType || 'N/A').replace(/_/g, ' ').charAt(0).toUpperCase() + (jobData.jobType || 'N/A').replace(/_/g, ' ').slice(1);
        document.getElementById('detailSalary').textContent = jobData.jobSalary || 'Not specified';
        document.getElementById('detailVacancies').textContent = jobData.jobVacancies || '0';

        // Description
        const description = jobData.jobDescription;
        if (description && description !== 'NULL' && description !== '') {
            document.getElementById('descriptionSection').style.display = 'block';
            document.getElementById('detailDescription').textContent = description;
        } else {
            document.getElementById('descriptionSection').style.display = 'none';
        }

        // Requirements
        const requirements = jobData.jobRequirements;
        if (requirements && requirements !== 'NULL' && requirements !== '') {
            document.getElementById('requirementsSection').style.display = 'block';
            document.getElementById('detailRequirements').textContent = requirements;
        } else {
            document.getElementById('requirementsSection').style.display = 'none';
        }

        // Qualifications
        const qualifications = parseList(jobData.jobQualifications);
        if (qualifications.length > 0) {
            document.getElementById('qualificationsSection').style.display = 'block';
            const qualList = document.getElementById('detailQualifications');
            qualList.innerHTML = qualifications.map(q => `<li>${q}</li>`).join('');
        } else {
            document.getElementById('qualificationsSection').style.display = 'none';
        }

        // Responsibilities
        const responsibilities = parseList(jobData.jobResponsibilities);
        if (responsibilities.length > 0) {
            document.getElementById('responsibilitiesSection').style.display = 'block';
            const respList = document.getElementById('detailResponsibilities');
            respList.innerHTML = responsibilities.map(r => `<li>${r}</li>`).join('');
        } else {
            document.getElementById('responsibilitiesSection').style.display = 'none';
        }

        // Skills
        const skills = parseList(jobData.jobSkills);
        if (skills.length > 0) {
            document.getElementById('skillsSection').style.display = 'block';
            const skillsList = document.getElementById('detailSkills');
            skillsList.innerHTML = skills.map(s => `<li>${s}</li>`).join('');
        } else {
            document.getElementById('skillsSection').style.display = 'none';
        }

        // Experience & Education
        const hasExperience = jobData.jobExperience && jobData.jobExperience !== 'NULL' && jobData.jobExperience !== '';
        const hasEducation = jobData.jobEducation && jobData.jobEducation !== 'NULL' && jobData.jobEducation !== '';
        
        if (hasExperience || hasEducation) {
            document.getElementById('experienceSection').style.display = 'block';
            if (hasExperience) {
                document.getElementById('experienceItem').style.display = 'block';
                const expList = parseList(jobData.jobExperience);
                document.getElementById('detailExperience').innerHTML = expList.length > 0 
                    ? expList.map(e => `<div style="margin-bottom: 0.5rem;">${e}</div>`).join('')
                    : jobData.jobExperience;
            } else {
                document.getElementById('experienceItem').style.display = 'none';
            }
            
            if (hasEducation) {
                document.getElementById('educationItem').style.display = 'block';
                const eduList = parseList(jobData.jobEducation);
                document.getElementById('detailEducation').innerHTML = eduList.length > 0 
                    ? eduList.map(e => `<div style="margin-bottom: 0.5rem;">${e}</div>`).join('')
                    : jobData.jobEducation;
            } else {
                document.getElementById('educationItem').style.display = 'none';
            }
        } else {
            document.getElementById('experienceSection').style.display = 'none';
        }

        // Benefits
        const benefits = parseList(jobData.jobBenefits);
        if (benefits.length > 0) {
            document.getElementById('benefitsSection').style.display = 'block';
            const benefitsList = document.getElementById('detailBenefits');
            benefitsList.innerHTML = benefits.map(b => `<li>${b}</li>`).join('');
        } else {
            document.getElementById('benefitsSection').style.display = 'none';
        }

        // Dates
        document.getElementById('detailStartDate').textContent = jobData.jobStartDate ? new Date(jobData.jobStartDate).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }) : 'Not specified';
        document.getElementById('detailEndDate').textContent = jobData.jobEndDate ? new Date(jobData.jobEndDate).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }) : 'Not specified';

        // Statistics
        document.getElementById('detailApplications').textContent = jobData.jobApplications || '0';
        
        const filledBadge = document.getElementById('detailFilledBadge');
        if (jobData.jobFilled === '1') {
            filledBadge.style.display = 'inline-block';
        } else {
            filledBadge.style.display = 'none';
        }

        // Show modal
        $('#jobDetailModal').modal('show');
    }
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\admin\jobs-management.blade.php ENDPATH**/ ?>