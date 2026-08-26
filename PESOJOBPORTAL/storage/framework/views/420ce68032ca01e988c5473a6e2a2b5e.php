<?php $__env->startSection('title', strtoupper($activityRequest->activity_type) . ' Request - Review'); ?>

<?php
    $pageTitle = strtoupper($activityRequest->activity_type) . ' Request Review';
    $pageSubtitle = 'Review and ' . ($activityRequest->status === 'pending' ? 'approve or reject' : 'view') . ' the LRA/SRA request documents';
    $pageIcon = 'bi-clipboard-check';
?>

<?php $__env->startSection('content'); ?>
<div class="admin-dashboard">
    <div class="dashboard-card">

        
        <div class="lra-topbar">
            <div>
                <h1 class="lra-page-title"><?php echo e(strtoupper($activityRequest->activity_type)); ?> Request Review</h1>
                <p class="lra-page-sub">
                    Review and <?php echo e($activityRequest->status === 'pending' ? 'approve or reject' : 'view'); ?> the LRA/SRA request documents
                </p>
            </div>
            <a href="<?php echo e(route('admin.lra-sra-approvals')); ?>" class="lra-back-btn">
                <i class="bi bi-arrow-left"></i> Back to Approvals
            </a>
        </div>

        
        <div class="lra-layout">

            
            <div class="lra-main">

                
                <div class="lra-card lra-card--flush mb-card">
                    <div class="lra-meta-strip">
                        <div class="lra-meta-cell">
                            <div class="lra-meta-label"><i class="bi bi-tag me-1"></i>Activity type</div>
                            <span class="lra-badge lra-badge--<?php echo e($activityRequest->activity_type); ?>">
                                <i class="bi bi-file-earmark me-1"></i><?php echo e(strtoupper($activityRequest->activity_type)); ?>

                            </span>
                        </div>
                        <div class="lra-meta-cell">
                            <div class="lra-meta-label"><i class="bi bi-building me-1"></i>Employer</div>
                            <div class="lra-meta-val"><?php echo e($activityRequest->employer?->name ?? 'N/A'); ?></div>
                        </div>
                        <div class="lra-meta-cell">
                            <div class="lra-meta-label"><i class="bi bi-calendar me-1"></i>Submitted</div>
                            <div class="lra-meta-val"><?php echo e($activityRequest->created_at->format('M d, Y')); ?></div>
                        </div>
                        <div class="lra-meta-cell">
                            <div class="lra-meta-label"><i class="bi bi-info-circle me-1"></i>Status</div>
                            <span class="lra-badge lra-badge--status-<?php echo e($activityRequest->status); ?>">
                                <?php echo e(ucfirst($activityRequest->status)); ?>

                            </span>
                        </div>
                    </div>

                    
                    <div class="lra-card-body">
                        <div class="lra-section-tag lra-section-tag--red">
                            <i class="bi bi-file-earmark-pdf me-1"></i> Required documents
                        </div>
                        <div class="lra-doc-grid">
                            <div class="lra-doc-item">
                                <i class="bi bi-file-pdf lra-doc-icon lra-doc-icon--red"></i>
                                <p class="lra-doc-name">Letter of Intent</p>
                                <?php if($activityRequest->letter_of_intent_path): ?>
                                    <a href="<?php echo e(route('admin.lra-sra.download-file', [$activityRequest, 'letter_of_intent_path'])); ?>"
                                       class="lra-dl-btn" target="_blank">
                                        <i class="bi bi-download me-1"></i>Download
                                    </a>
                                <?php else: ?>
                                    <span class="lra-doc-missing">Not provided</span>
                                <?php endif; ?>
                            </div>
                            <div class="lra-doc-item">
                                <i class="bi bi-file-pdf lra-doc-icon lra-doc-icon--red"></i>
                                <p class="lra-doc-name">Company Profile</p>
                                <?php if($activityRequest->company_profile_path): ?>
                                    <a href="<?php echo e(route('admin.lra-sra.download-file', [$activityRequest, 'company_profile_path'])); ?>"
                                       class="lra-dl-btn" target="_blank">
                                        <i class="bi bi-download me-1"></i>Download
                                    </a>
                                <?php else: ?>
                                    <span class="lra-doc-missing">Not provided</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                
                <?php if($activityRequest->activity_type === 'sra'): ?>
                <div class="lra-card mb-card">
                    <div class="lra-card-head">
                        <i class="bi bi-file-earmark"></i>
                        <span class="lra-card-head-label">SRA-specific documents</span>
                    </div>
                    <div class="lra-card-body">
                        <div class="lra-section-tag lra-section-tag--purple">
                            <i class="bi bi-file-earmark me-1"></i> SRA documents
                        </div>
                        <?php
                            $sraDocuments = [
                                ['name' => 'DMW Certificate',         'field' => 'dmw_certificate_path'],
                                ['name' => 'Recruitment Officer ID',  'field' => 'recruitment_officer_id_path'],
                                ['name' => 'Job Order Balance',       'field' => 'job_order_balance_path'],
                                ['name' => 'Deployment Report',       'field' => 'deployment_report_path'],
                                ['name' => 'Affidavit of Undertaking','field' => 'affidavit_undertaking_path'],
                                ['name' => 'SRA Authority',           'field' => 'sra_authority_file_path'],
                            ];
                        ?>
                        <div class="lra-doc-grid">
                            <?php $__currentLoopData = $sraDocuments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="lra-doc-item">
                                <i class="bi bi-file-pdf lra-doc-icon lra-doc-icon--purple"></i>
                                <p class="lra-doc-name"><?php echo e($doc['name']); ?></p>
                                <?php if($activityRequest->{$doc['field']}): ?>
                                    <a href="<?php echo e(route('admin.lra-sra.download-file', [$activityRequest, $doc['field']])); ?>"
                                       class="lra-dl-btn" target="_blank">
                                        <i class="bi bi-download me-1"></i>Download
                                    </a>
                                <?php else: ?>
                                    <span class="lra-doc-missing">Not provided</span>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                
                <?php if($activityRequest->activity_type === 'lra'): ?>
                <div class="lra-card mb-card">
                    <div class="lra-card-head">
                        <i class="bi bi-file-earmark"></i>
                        <span class="lra-card-head-label">LRA-specific documents</span>
                    </div>
                    <div class="lra-card-body">
                        <div class="lra-section-tag lra-section-tag--teal">
                            <i class="bi bi-file-earmark me-1"></i> LRA documents
                        </div>
                        <div class="lra-doc-grid">
                            <div class="lra-doc-item">
                                <i class="bi bi-file-pdf lra-doc-icon lra-doc-icon--teal"></i>
                                <p class="lra-doc-name">Business Permit</p>
                                <?php if($activityRequest->business_permit_path): ?>
                                    <a href="<?php echo e(route('admin.lra-sra.download-file', [$activityRequest, 'business_permit_path'])); ?>"
                                       class="lra-dl-btn" target="_blank">
                                        <i class="bi bi-download me-1"></i>Download
                                    </a>
                                <?php else: ?>
                                    <span class="lra-doc-missing">Not provided</span>
                                <?php endif; ?>
                            </div>
                            <div class="lra-doc-item">
                                <i class="bi bi-file-pdf lra-doc-icon lra-doc-icon--teal"></i>
                                <p class="lra-doc-name">Recruitment Officer ID</p>
                                <?php if($activityRequest->lra_recruitment_officer_id_path): ?>
                                    <a href="<?php echo e(route('admin.lra-sra.download-file', [$activityRequest, 'lra_recruitment_officer_id_path'])); ?>"
                                       class="lra-dl-btn" target="_blank">
                                        <i class="bi bi-download me-1"></i>Download
                                    </a>
                                <?php else: ?>
                                    <span class="lra-doc-missing">Not provided</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div id="job-vacancies" class="lra-card mb-card">
                    <div class="lra-card-head">
                        <i class="bi bi-briefcase"></i>
                        <span class="lra-card-head-label">Job vacancies</span>
                    </div>
                    <div class="lra-card-body">
                        <?php if($activityRequest->job_vacancies_path && $activityRequest->job_vacancies_text): ?>
                            <div class="lra-jv-split">
                                <div class="lra-doc-item">
                                    <i class="bi bi-file-pdf lra-doc-icon lra-doc-icon--blue"></i>
                                    <p class="lra-doc-name">Job Vacancies File</p>
                                    <a href="<?php echo e(route('admin.lra-sra.download-file', [$activityRequest, 'job_vacancies_path'])); ?>"
                                       class="lra-dl-btn" target="_blank">
                                        <i class="bi bi-download me-1"></i>Download
                                    </a>
                                </div>
                                <div class="lra-vacancies-text"><?php echo e($activityRequest->job_vacancies_text); ?></div>
                            </div>
                        <?php elseif($activityRequest->job_vacancies_path): ?>
                            <div class="lra-doc-grid">
                                <div class="lra-doc-item">
                                    <i class="bi bi-file-pdf lra-doc-icon lra-doc-icon--blue"></i>
                                    <p class="lra-doc-name">Job Vacancies File</p>
                                    <a href="<?php echo e(asset('storage/' . $activityRequest->job_vacancies_path)); ?>"
                                       class="lra-dl-btn" target="_blank">
                                        <i class="bi bi-download me-1"></i>Download
                                    </a>
                                </div>
                            </div>
                        <?php elseif($activityRequest->job_vacancies_text): ?>
                            <div class="lra-vacancies-text"><?php echo e($activityRequest->job_vacancies_text); ?></div>
                        <?php else: ?>
                            <div class="lra-empty">
                                <i class="bi bi-inbox"></i>
                                <span>Not provided</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

            </div>

            
            <div class="lra-sidebar">

                
                <div class="lra-card mb-card">
                    <div class="lra-card-head">
                        <i class="bi bi-building"></i>
                        <span class="lra-card-head-label">Company</span>
                    </div>
                    <div class="lra-card-body lra-card-body--compact">
                        <div class="lra-info-row">
                            <span class="lra-info-key"><i class="bi bi-globe me-1"></i>Business</span>
                            <span class="lra-info-val"><?php echo e($activityRequest->employer->profile?->line_of_business ?? 'N/A'); ?></span>
                        </div>
                        <div class="lra-info-row">
                            <span class="lra-info-key"><i class="bi bi-people me-1"></i>Workforce</span>
                            <span class="lra-info-val"><?php echo e($activityRequest->employer->profile?->workforce_size ?? 'N/A'); ?></span>
                        </div>
                        <div class="lra-info-row lra-info-row--last">
                            <span class="lra-info-key"><i class="bi bi-telephone me-1"></i>Contact</span>
                            <span class="lra-info-val"><?php echo e($activityRequest->employer->profile?->establishment_phone ?? 'N/A'); ?></span>
                        </div>
                    </div>
                </div>

                <?php if($activityRequest->status === 'pending'): ?>

                    
                    <div class="lra-card mb-card">
                        <div class="lra-card-head">
                            <i class="bi bi-certificate"></i>
                            <span class="lra-card-head-label">Certification</span>
                        </div>
                        <div class="lra-card-body lra-card-body--compact">
                            <?php if($activityRequest->certification_path): ?>
                                <div class="lra-cert-status lra-cert-status--ok">
                                    <div class="lra-cert-title">
                                        <i class="bi bi-check-circle-fill me-1"></i>Certification generated
                                    </div>
                                    <div class="lra-cert-sub">
                                        
                                        <?php echo e(\Carbon\Carbon::parse($activityRequest->certification_generated_at)->timezone('Asia/Manila')->format('M d, Y H:i')); ?>

                                        &mdash; <?php echo e($activityRequest->certificationGeneratedBy?->name ?? 'System'); ?>

                                    </div>
                                </div>
                                <a href="<?php echo e(route('admin.lra-sra.view-certification', $activityRequest)); ?>"
                                   class="lra-action-btn lra-action-btn--view" target="_blank">
                                    <i class="bi bi-eye me-1"></i>View certification
                                </a>
                                <form method="POST" action="<?php echo e(route('admin.lra-sra.generate-certification', $activityRequest)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="lra-action-btn lra-action-btn--generate w-100">
                                        <i class="bi bi-arrow-repeat me-1"></i>Regenerate
                                    </button>
                                </form>
                            <?php else: ?>
                                <div class="lra-cert-status lra-cert-status--pending">
                                    <div class="lra-cert-title">
                                        <i class="bi bi-exclamation-circle-fill me-1"></i>Not yet generated
                                    </div>
                                    <div class="lra-cert-sub">
                                        Generate a certification document before approving this request.
                                    </div>
                                </div>
                                <form method="POST" action="<?php echo e(route('admin.lra-sra.generate-certification', $activityRequest)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="lra-action-btn lra-action-btn--generate w-100">
                                        <i class="bi bi-file-earmark-plus me-1"></i>Generate certification
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="lra-card lra-sidebar-sticky">
                        <div class="lra-card-head">
                            <i class="bi bi-shield-check"></i>
                            <span class="lra-card-head-label">Review</span>
                        </div>
                        <div class="lra-card-body lra-card-body--compact">
                            <div class="lra-notice">
                                <i class="bi bi-info-circle me-1"></i>
                                Generate certification first, then approve.
                            </div>
                            <form method="POST" class="d-grid gap-2">
                                <?php echo csrf_field(); ?>
                                <button type="submit"
                                        formaction="<?php echo e(route('admin.lra-sra.approve', $activityRequest)); ?>"
                                        class="lra-action-btn lra-action-btn--approve w-100"
                                        <?php echo e(!$activityRequest->certification_path ? 'disabled' : ''); ?>>
                                    <i class="bi bi-check-circle me-1"></i>Approve
                                </button>
                            </form>
                            <button type="button"
                                    class="lra-action-btn lra-action-btn--reject w-100 mt-2"
                                    data-bs-toggle="modal"
                                    data-bs-target="#rejectModal">
                                <i class="bi bi-x-circle me-1"></i>Reject request
                            </button>
                        </div>
                    </div>

                <?php else: ?>

                    
                    <div class="lra-card">
                        <div class="lra-card-head">
                            <i class="bi bi-info-circle"></i>
                            <span class="lra-card-head-label">Status</span>
                        </div>
                        <div class="lra-card-body--flush">
                            <?php if($activityRequest->status === 'approved'): ?>
                                <div class="lra-status-block lra-status-block--approved">
                                    <i class="bi bi-check-circle-fill lra-status-icon"></i>
                                    <div>
                                        <div class="lra-status-title">Approved</div>
                                        <div class="lra-status-detail">
                                            <span><?php echo e(optional($activityRequest->approved_at)->format('M d, Y')); ?></span>
                                            <span>&mdash; <?php echo e($activityRequest->approvedBy?->name ?? 'System'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php elseif($activityRequest->status === 'rejected'): ?>
                                <div class="lra-status-block lra-status-block--rejected">
                                    <i class="bi bi-x-circle-fill lra-status-icon"></i>
                                    <div>
                                        <div class="lra-status-title">Rejected</div>
                                        <div class="lra-status-reason">
                                            <?php echo e($activityRequest->notes ?? 'No reason provided'); ?>

                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if($activityRequest->certification_path): ?>
                        <div class="lra-card mt-3">
                            <div class="lra-card-head">
                                <i class="bi bi-certificate"></i>
                                <span class="lra-card-head-label">Certificate Given</span>
                            </div>
                            <div class="lra-card-body lra-card-body--compact">
                                <div class="lra-cert-status lra-cert-status--ok">
                                    <div class="lra-cert-title">
                                        <i class="bi bi-check-circle-fill me-1"></i>Certification available
                                    </div>
                                    <div class="lra-cert-sub">
                                        <?php if($activityRequest->certification_generated_at): ?>
                                            <?php echo e(\Carbon\Carbon::parse($activityRequest->certification_generated_at)->timezone('Asia/Manila')->format('M d, Y H:i')); ?>

                                            &mdash;
                                        <?php endif; ?>
                                        <?php echo e($activityRequest->certificationGeneratedBy?->name ?? 'System'); ?>

                                    </div>
                                </div>
                                <a href="<?php echo e(route('admin.lra-sra.view-certification', $activityRequest)); ?>"
                                   class="lra-action-btn lra-action-btn--view"
                                   target="_blank">
                                    <i class="bi bi-eye me-1"></i>View certificate
                                </a>
                                <a href="<?php echo e(route('admin.lra-sra.download-certification', $activityRequest)); ?>"
                                   class="lra-action-btn lra-action-btn--generate">
                                    <i class="bi bi-download me-1"></i>Download certificate
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                <?php endif; ?>

            </div>

        </div>
    </div>
</div>


<?php if($activityRequest->status === 'pending'): ?>
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="<?php echo e(route('admin.lra-sra.reject', $activityRequest)); ?>">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <small class="text-muted">
                        <?php echo e(strtoupper($activityRequest->activity_type)); ?> &mdash; <?php echo e($activityRequest->employer?->name); ?>

                    </small>
                    <div class="mb-0 mt-3">
                        <label for="rejection_notes" class="form-label">
                            Reason <span class="text-danger">*</span>
                        </label>
                        <textarea id="rejection_notes" name="notes" class="form-control" rows="4"
                                  placeholder="Explain why this request is being rejected..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>


<style>
:root {
    --bg: #ffffff;
    --surface: #f8fafc;
    --surface-strong: #eef6ff;
    --muted: #64748b;
    --text: #0f172a;
    --primary: #0369a1;
    --primary-soft: rgba(3, 105, 161, 0.08);
    --teal: #0ea5a4;
    --purple: #7c3aed;
    --red: #ef4444;
    --red-soft: rgba(239, 68, 68, 0.08);
    --success: #16a34a;
    --success-soft: rgba(22, 163, 74, 0.08);
    --amber: #d97706;
    --amber-soft: rgba(217, 119, 6, 0.08);
    --card-border: #e5edf7;
    --shadow: 0 14px 28px rgba(15, 23, 42, 0.06);
}

.admin-dashboard {
    background: linear-gradient(180deg, #f8fbff 0%, #ffffff 100%);
    border-radius: 18px;
}

.lra-topbar {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 1.35rem;
    flex-wrap: wrap;
    padding-bottom: 1rem;
    border-bottom: 1px solid #edf2f7;
}

.lra-page-title {
    margin: 0 0 0.35rem;
    font-size: 1.18rem;
    font-weight: 800;
    letter-spacing: -0.02em;
    color: var(--text);
}

.lra-page-sub {
    margin: 0;
    font-size: 0.82rem;
    color: var(--muted);
}

.lra-back-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.45rem;
    min-height: 36px;
    padding: 0.5rem 0.9rem;
    border-radius: 10px;
    border: 1px solid var(--card-border);
    background: #f8fafc;
    color: var(--primary);
    font-size: 0.85rem;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.15s ease;
    white-space: nowrap;
}

.lra-back-btn:hover {
    background: var(--surface-strong);
    border-color: #cfe3f7;
    transform: translateY(-1px);
    color: var(--primary);
}

.lra-layout {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 320px;
    gap: 1.3rem;
    align-items: start;
}

.mb-card {
    margin-bottom: 1rem;
}

.lra-card {
    background: var(--bg);
    border: 1px solid var(--card-border);
    border-radius: 14px;
    overflow: hidden;
    box-shadow: var(--shadow);
}

.lra-card--flush {
    padding: 0;
}

.lra-card-head {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    min-height: 46px;
    padding: 0.75rem 1.1rem;
    background: linear-gradient(180deg, #f8fafc 0%, #f3f7fb 100%);
    border-bottom: 1px solid rgba(15, 23, 42, 0.04);
    font-size: 0.8rem;
    color: var(--muted);
}

.lra-card-head-label {
    font-size: 0.85rem;
    font-weight: 800;
    color: var(--text);
}

.lra-card-body {
    padding: 1.1rem;
}

.lra-card-body--compact {
    padding: 0.9rem 1rem;
}

.lra-card-body--flush {
    padding: 0;
}

.lra-meta-strip {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    background: #fff;
    border-bottom: 1px solid rgba(15, 23, 42, 0.04);
}

.lra-meta-cell {
    min-width: 0;
    padding: 0.95rem 1rem;
    border-right: 1px solid rgba(15, 23, 42, 0.04);
}

.lra-meta-cell:last-child {
    border-right: none;
}

.lra-meta-label {
    margin-bottom: 0.4rem;
    color: var(--muted);
    font-size: 0.68rem;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.lra-meta-val {
    color: var(--text);
    font-size: 0.9rem;
    font-weight: 700;
    word-break: break-word;
}

.lra-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.42rem 0.8rem;
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 800;
}

.lra-badge--lra {
    background: rgba(59, 130, 246, 0.08);
    color: #1e40af;
}

.lra-badge--sra {
    background: rgba(124, 58, 237, 0.08);
    color: #6d28d9;
}

.lra-badge--status-pending {
    background: rgba(245, 158, 11, 0.08);
    color: #92400e;
}

.lra-badge--status-approved {
    background: var(--success-soft);
    color: var(--success);
}

.lra-badge--status-rejected {
    background: var(--red-soft);
    color: var(--red);
}

.lra-section-tag {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.32rem 0.7rem;
    margin-bottom: 0.75rem;
    border-radius: 999px;
    font-size: 0.72rem;
    font-weight: 800;
}

.lra-section-tag--red {
    background: var(--red-soft);
    color: var(--red);
}

.lra-section-tag--purple {
    background: rgba(124, 58, 237, 0.08);
    color: var(--purple);
}

.lra-section-tag--teal {
    background: rgba(14, 165, 164, 0.08);
    color: var(--teal);
}

.lra-section-tag--blue {
    background: var(--primary-soft);
    color: var(--primary);
}

.lra-doc-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(165px, 1fr));
    gap: 0.85rem;
}

.lra-doc-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    min-height: 150px;
    padding: 1rem 0.75rem;
    border-radius: 12px;
    border: 1px solid rgba(15, 23, 42, 0.05);
    background: linear-gradient(180deg, rgba(248, 250, 252, 0.9) 0%, rgba(255, 255, 255, 1) 100%);
    text-align: center;
    transition: transform 0.15s ease, box-shadow 0.15s ease;
}

.lra-doc-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 18px rgba(15, 23, 42, 0.05);
}

.lra-doc-icon {
    display: block;
    margin-bottom: 0.7rem;
    font-size: 1.8rem;
}

.lra-doc-icon--red { color: var(--red); }
.lra-doc-icon--purple { color: var(--purple); }
.lra-doc-icon--teal { color: var(--teal); }
.lra-doc-icon--blue { color: var(--primary); }

.lra-doc-name {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 2.3rem;
    margin: 0 0 0.7rem;
    color: var(--text);
    font-size: 0.78rem;
    font-weight: 700;
    line-height: 1.35;
}

.lra-doc-missing {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 31px;
    margin-top: auto;
    color: var(--muted);
    font-size: 0.72rem;
    font-style: italic;
}

.lra-dl-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 31px;
    margin-top: auto;
    padding: 0.42rem 0.7rem;
    border: 1px solid rgba(15, 23, 42, 0.08);
    border-radius: 9px;
    background: #fff;
    color: var(--text);
    font-size: 0.73rem;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.15s ease;
}

.lra-dl-btn:hover {
    background: var(--surface);
    border-color: var(--card-border);
    color: var(--text);
    text-decoration: none;
}

.lra-jv-split {
    display: grid;
    grid-template-columns: 170px minmax(0, 1fr);
    gap: 1rem;
    align-items: start;
}

.lra-vacancies-text {
    min-height: 160px;
    max-height: 260px;
    overflow-y: auto;
    padding: 0.95rem 1rem;
    border: 1px solid rgba(15, 23, 42, 0.05);
    border-radius: 10px;
    background: rgba(15, 23, 42, 0.02);
    color: var(--text);
    font-size: 0.85rem;
    line-height: 1.7;
    white-space: pre-wrap;
    word-break: break-word;
}

.lra-empty {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 1.1rem;
    color: var(--muted);
    font-size: 0.85rem;
}

.lra-info-row {
    display: grid;
    grid-template-columns: 110px minmax(0, 1fr);
    gap: 0.75rem;
    align-items: start;
    padding: 0.8rem 0;
    border-bottom: 1px solid rgba(15, 23, 42, 0.05);
}

.lra-info-row--last {
    border-bottom: none;
    padding-bottom: 0;
}

.lra-info-key {
    display: inline-flex;
    align-items: center;
    gap: 0.28rem;
    color: var(--muted);
    font-size: 0.76rem;
    font-weight: 700;
}

.lra-info-val {
    color: var(--text);
    font-size: 0.86rem;
    font-weight: 700;
    text-align: right;
    word-break: break-word;
}

.lra-cert-status {
    margin-bottom: 0.8rem;
    padding: 0.8rem 0.9rem;
    border-radius: 10px;
}

.lra-cert-status--ok {
    background: var(--success-soft);
    border: 1px solid rgba(22, 163, 74, 0.12);
}

.lra-cert-status--pending {
    background: var(--amber-soft);
    border: 1px solid rgba(217, 119, 6, 0.12);
}

.lra-cert-title {
    margin-bottom: 0.32rem;
    font-size: 0.82rem;
    font-weight: 800;
}

.lra-cert-status--ok .lra-cert-title { color: var(--success); }
.lra-cert-status--pending .lra-cert-title { color: var(--amber); }

.lra-cert-sub {
    color: var(--muted);
    font-size: 0.75rem;
    line-height: 1.4;
}

.lra-notice {
    margin-bottom: 0.8rem;
    padding: 0.7rem 0.8rem;
    border-radius: 10px;
    background: var(--primary-soft);
    border: 1px solid rgba(3, 105, 161, 0.12);
    color: var(--primary);
    font-size: 0.78rem;
    line-height: 1.4;
}

.lra-action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    width: 100%;
    min-height: 38px;
    padding: 0.6rem 0.8rem;
    border: 1px solid transparent;
    border-radius: 10px;
    cursor: pointer;
    font-size: 0.86rem;
    font-weight: 800;
    text-decoration: none;
    text-align: center;
    transition: transform 0.15s ease, box-shadow 0.15s ease, opacity 0.15s ease;
}

.lra-action-btn:hover {
    transform: translateY(-1px);
}

.lra-action-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.lra-action-btn--approve {
    background: var(--success-soft);
    color: var(--success);
    border-color: rgba(22, 163, 74, 0.14);
}

.lra-action-btn--reject {
    background: var(--red-soft);
    color: var(--red);
    border-color: rgba(239, 68, 68, 0.14);
}

.lra-action-btn--generate {
    background: rgba(245, 158, 11, 0.08);
    color: #92400e;
    border-color: rgba(245, 158, 11, 0.12);
}

.lra-action-btn--view {
    background: var(--primary-soft);
    color: var(--primary);
    border-color: rgba(3, 105, 161, 0.12);
}

.lra-sidebar-sticky {
    position: sticky;
    top: 22px;
}

.lra-status-block {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 1rem 1.05rem;
}

.lra-status-block--approved {
    background: var(--success-soft);
    border-left: 4px solid var(--success);
}

.lra-status-block--rejected {
    background: var(--red-soft);
    border-left: 4px solid var(--red);
}

.lra-status-icon {
    font-size: 1.15rem;
    flex-shrink: 0;
    margin-top: 0.12rem;
}

.lra-status-block--approved .lra-status-icon { color: var(--success); }
.lra-status-block--rejected .lra-status-icon { color: var(--red); }

.lra-status-title {
    margin-bottom: 0.3rem;
    font-size: 0.9rem;
    font-weight: 800;
}

.lra-status-block--approved .lra-status-title { color: var(--success); }
.lra-status-block--rejected .lra-status-title { color: var(--red); }

.lra-status-detail {
    display: flex;
    flex-wrap: wrap;
    gap: 0.35rem;
    color: var(--muted);
    font-size: 0.78rem;
}

.lra-status-reason {
    color: #7f1d1d;
    font-size: 0.8rem;
    line-height: 1.45;
    font-style: italic;
}

.dashboard-card {
    padding: 1.25rem;
    border-radius: 14px;
    border: 1px solid #e5ebf3;
    box-shadow: 0 12px 26px rgba(15, 23, 42, 0.05);
    background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
}

@media (max-width: 900px) {
    .lra-layout {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 640px) {
    .dashboard-card {
        padding: 1rem;
    }

    .lra-topbar {
        align-items: stretch;
    }

    .lra-back-btn {
        width: 100%;
    }

    .lra-meta-strip {
        grid-template-columns: 1fr;
    }

    .lra-meta-cell {
        border-right: none;
        border-bottom: 1px solid rgba(15, 23, 42, 0.04);
    }

    .lra-meta-cell:last-child {
        border-bottom: none;
    }

    .lra-jv-split {
        grid-template-columns: 1fr;
    }

    .lra-info-row {
        grid-template-columns: 1fr;
    }

    .lra-info-val {
        text-align: left;
    }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views/admin/approvals/lra-sra-detail.blade.php ENDPATH**/ ?>