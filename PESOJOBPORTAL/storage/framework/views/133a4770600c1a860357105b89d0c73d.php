<?php $__env->startSection('title', strtoupper($activityRequest->activity_type) . ' Request Details'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .detail-header {
        background: linear-gradient(135deg, #f0f4ff 0%, #f9f5ff 100%);
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
        border-left: 4px solid #6366f1;
    }

    .detail-header h1 {
        margin: 0 0 12px 0;
        color: #0f172a;
        font-size: 1.75rem;
        font-weight: 700;
    }

    .header-meta {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-top: 16px;
    }

    .meta-item {
        background: white;
        padding: 12px;
        border-radius: 8px;
        border-left: 3px solid <?php echo e($activityRequest->activity_type === 'lra' ? '#3b82f6' : '#ec4899'); ?>;
    }

    .meta-label {
        font-size: 0.75rem;
        color: #6b7280;
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .meta-value {
        color: #1f2937;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .status-approved {
        background: #d1fae5;
        color: #065f46;
    }

    .status-rejected {
        background: #fee2e2;
        color: #7f1d1d;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .document-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        padding: 16px;
        margin-bottom: 16px;
    }

    .document-card h3 {
        margin: 0 0 12px 0;
        color: #1f2937;
        font-size: 1rem;
        font-weight: 700;
    }

    .document-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 12px;
    }

    .document-item {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 12px;
        text-align: center;
    }

    .document-icon {
        font-size: 2rem;
        color: #ef4444;
        margin-bottom: 8px;
    }

    .document-name {
        font-size: 0.85rem;
        color: #1f2937;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .download-btn {
        background: #ef4444;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: background 0.2s;
    }

    .download-btn:hover {
        background: #dc2626;
    }

    .certificate-section {
        background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
        border: 1px solid #bbf7d0;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 24px;
        border-left: 4px solid #10b981;
    }

    .certificate-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
    }

    .certificate-header h2 {
        margin: 0;
        color: #065f46;
        font-size: 1.1rem;
        font-weight: 700;
    }

    .certificate-icon {
        font-size: 1.5rem;
        color: #10b981;
    }

    .certificate-info {
        background: white;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 12px;
    }

    .certificate-info p {
        margin: 6px 0;
        color: #1f2937;
        font-size: 0.9rem;
    }

    .certificate-actions {
        display: flex;
        gap: 12px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 10px 16px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: transform 0.2s;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #374151;
        padding: 10px 16px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: background 0.2s;
    }

    .btn-secondary:hover {
        background: #e5e7eb;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #6366f1;
        text-decoration: none;
        font-weight: 600;
        margin-bottom: 20px;
        transition: gap 0.2s;
    }

    .back-btn:hover {
        gap: 12px;
    }

    .approval-info {
        background: white;
        border-radius: 8px;
        padding: 12px;
        margin-top: 8px;
    }

    .approval-info p {
        margin: 6px 0;
        color: #374151;
        font-size: 0.9rem;
    }

    .rejection-reason {
        background: #fef2f2;
        border-left: 3px solid #ef4444;
        padding: 12px;
        border-radius: 8px;
        margin-top: 8px;
    }

    .rejection-reason p {
        margin: 6px 0;
        color: #7f1d1d;
        font-size: 0.9rem;
    }
</style>

<div style="padding: 20px;">
    <a href="<?php echo e(route('employer.recruitment.index')); ?>" class="back-btn">
        <i class="bi bi-arrow-left"></i> Back to Requests
    </a>

    <!-- Header -->
    <div class="detail-header">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <h1><?php echo e(strtoupper($activityRequest->activity_type)); ?> Request</h1>
                <span class="status-badge status-<?php echo e($activityRequest->status); ?>">
                    <?php echo e(ucfirst($activityRequest->status)); ?>

                </span>
            </div>
        </div>

        <div class="header-meta">
            <div class="meta-item">
                <div class="meta-label">Request ID</div>
                <div class="meta-value">#<?php echo e($activityRequest->id); ?></div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Activity Type</div>
                <div class="meta-value"><?php echo e(strtoupper($activityRequest->activity_type)); ?></div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Submitted</div>
                <div class="meta-value"><?php echo e($activityRequest->created_at->format('M d, Y')); ?></div>
            </div>
            <?php if($activityRequest->status !== 'pending'): ?>
                <div class="meta-item">
                    <div class="meta-label"><?php echo e($activityRequest->status === 'approved' ? 'Approved' : 'Rejected'); ?></div>
                    <div class="meta-value"><?php echo e(optional($activityRequest->updated_at)->format('M d, Y')); ?></div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Certificate Section -->
    <?php if($activityRequest->status === 'approved'): ?>
        <div class="certificate-section">
            <div class="certificate-header">
                <span class="certificate-icon"><i class="bi bi-file-pdf-fill"></i></span>
                <h2>Certificate</h2>
            </div>
            <div class="certificate-info">
                <p><strong>Status:</strong> <span style="color: #10b981;">✓ Generated and Approved</span></p>
                <p><strong>Generated:</strong> <?php echo e(optional($activityRequest->certification_generated_at)->format('M d, Y H:i A')); ?></p>
                <?php if($activityRequest->approvedBy): ?>
                    <p><strong>Approved by:</strong> <?php echo e($activityRequest->approvedBy->name); ?></p>
                <?php endif; ?>
            </div>
            <div class="certificate-actions">
                <a href="<?php echo e(route('employer.recruitment.view-certificate', $activityRequest)); ?>" target="_blank" class="btn-primary">
                    <i class="bi bi-eye me-2"></i>View Certificate
                </a>
                <a href="<?php echo e(route('employer.recruitment.download-certificate', $activityRequest)); ?>" class="btn-primary" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                    <i class="bi bi-download me-2"></i>Download Certificate
                </a>
            </div>
        </div>
    <?php elseif($activityRequest->status === 'rejected'): ?>
        <div style="background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%); border: 1px solid #fecaca; border-radius: 12px; padding: 20px; margin-bottom: 24px; border-left: 4px solid #ef4444;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                <span style="font-size: 1.5rem; color: #dc2626;"><i class="bi bi-x-circle-fill"></i></span>
                <h2 style="margin: 0; color: #7f1d1d; font-size: 1.1rem; font-weight: 700;">Request Rejected</h2>
            </div>
            <div class="rejection-reason">
                <p><strong>Reason:</strong></p>
                <p style="font-style: italic; margin-top: 8px;"><?php echo e($activityRequest->notes ?? 'No reason provided'); ?></p>
            </div>
        </div>
    <?php else: ?>
        <div style="background: linear-gradient(135deg, #fef3c7 0%, #fef08a 100%); border: 1px solid #fcd34d; border-radius: 12px; padding: 20px; margin-bottom: 24px; border-left: 4px solid #f59e0b;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <span style="font-size: 1.5rem; color: #b45309;"><i class="bi bi-clock-fill"></i></span>
                <h2 style="margin: 0; color: #92400e; font-size: 1.1rem; font-weight: 700;">Pending Review</h2>
            </div>
            <p style="color: #78350f; margin: 8px 0;">Your request is awaiting admin review and certification. You will be notified once the admin has reviewed your submission.</p>
        </div>
    <?php endif; ?>

    <!-- Documents -->
    <div class="document-card">
        <h3><i class="bi bi-file-earmark-pdf me-2"></i>Submitted Documents</h3>
        <div class="document-grid">
            <?php if($activityRequest->letter_of_intent_path): ?>
                <div class="document-item">
                    <div class="document-icon"><i class="bi bi-file-pdf"></i></div>
                    <div class="document-name">Letter of Intent</div>
                    <a href="<?php echo e(asset('storage/' . $activityRequest->letter_of_intent_path)); ?>" class="download-btn" target="_blank">Download</a>
                </div>
            <?php endif; ?>

            <?php if($activityRequest->activity_type === 'lra'): ?>
                <?php if($activityRequest->business_permit_path): ?>
                    <div class="document-item">
                        <div class="document-icon"><i class="bi bi-file-pdf"></i></div>
                        <div class="document-name">Business Permit</div>
                        <a href="<?php echo e(asset('storage/' . $activityRequest->business_permit_path)); ?>" class="download-btn" target="_blank">Download</a>
                    </div>
                <?php endif; ?>
                <?php if($activityRequest->lra_recruitment_officer_id_path): ?>
                    <div class="document-item">
                        <div class="document-icon"><i class="bi bi-file-pdf"></i></div>
                        <div class="document-name">Officer ID</div>
                        <a href="<?php echo e(asset('storage/' . $activityRequest->lra_recruitment_officer_id_path)); ?>" class="download-btn" target="_blank">Download</a>
                    </div>
                <?php endif; ?>
                <?php if($activityRequest->job_vacancies_path): ?>
                    <div class="document-item">
                        <div class="document-icon"><i class="bi bi-file-pdf"></i></div>
                        <div class="document-name">Job Vacancies</div>
                        <a href="<?php echo e(asset('storage/' . $activityRequest->job_vacancies_path)); ?>" class="download-btn" target="_blank">Download</a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <?php if($activityRequest->activity_type === 'sra'): ?>
                <?php if($activityRequest->dmw_certificate_path): ?>
                    <div class="document-item">
                        <div class="document-icon"><i class="bi bi-file-pdf"></i></div>
                        <div class="document-name">DMW Certificate</div>
                        <a href="<?php echo e(asset('storage/' . $activityRequest->dmw_certificate_path)); ?>" class="download-btn" target="_blank">Download</a>
                    </div>
                <?php endif; ?>
                <?php if($activityRequest->recruitment_officer_id_path): ?>
                    <div class="document-item">
                        <div class="document-icon"><i class="bi bi-file-pdf"></i></div>
                        <div class="document-name">Officer ID</div>
                        <a href="<?php echo e(asset('storage/' . $activityRequest->recruitment_officer_id_path)); ?>" class="download-btn" target="_blank">Download</a>
                    </div>
                <?php endif; ?>
                <?php if($activityRequest->job_order_balance_path): ?>
                    <div class="document-item">
                        <div class="document-icon"><i class="bi bi-file-pdf"></i></div>
                        <div class="document-name">Job Order Balance</div>
                        <a href="<?php echo e(asset('storage/' . $activityRequest->job_order_balance_path)); ?>" class="download-btn" target="_blank">Download</a>
                    </div>
                <?php endif; ?>
                <?php if($activityRequest->deployment_report_path): ?>
                    <div class="document-item">
                        <div class="document-icon"><i class="bi bi-file-pdf"></i></div>
                        <div class="document-name">Deployment Report</div>
                        <a href="<?php echo e(asset('storage/' . $activityRequest->deployment_report_path)); ?>" class="download-btn" target="_blank">Download</a>
                    </div>
                <?php endif; ?>
                <?php if($activityRequest->affidavit_undertaking_path): ?>
                    <div class="document-item">
                        <div class="document-icon"><i class="bi bi-file-pdf"></i></div>
                        <div class="document-name">Affidavit</div>
                        <a href="<?php echo e(asset('storage/' . $activityRequest->affidavit_undertaking_path)); ?>" class="download-btn" target="_blank">Download</a>
                    </div>
                <?php endif; ?>
                <?php if($activityRequest->sra_authority_file_path): ?>
                    <div class="document-item">
                        <div class="document-icon"><i class="bi bi-file-pdf"></i></div>
                        <div class="document-name">Authority</div>
                        <a href="<?php echo e(asset('storage/' . $activityRequest->sra_authority_file_path)); ?>" class="download-btn" target="_blank">Download</a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Job Vacancies Text (LRA only) -->
    <?php if($activityRequest->activity_type === 'lra' && $activityRequest->job_vacancies_text): ?>
        <div class="document-card">
            <h3><i class="bi bi-briefcase me-2"></i>Job Vacancies Details</h3>
            <div style="background: #f9fafb; padding: 12px; border-radius: 8px; border: 1px solid #e5e7eb; max-height: 300px; overflow-y: auto; white-space: pre-wrap; word-break: break-word; color: #1f2937; font-size: 0.9rem;">
                <?php echo e($activityRequest->job_vacancies_text); ?>

            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.employer.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views/dashboard/employer/recruitment-activity-detail.blade.php ENDPATH**/ ?>