<?php $__env->startSection('title', 'Document Verification | PESO Admin'); ?>

<?php
    $pageTitle = 'Document Verification';
    $pageSubtitle = 'Review and verify employer-submitted documents';
    $pageIcon = 'bi-file-earmark';
?>

<?php $__env->startSection('content'); ?>
<div class="admin-dashboard">
    <style>
        .data-table { font-size: 13px; }
        .data-table thead { background: #f3f4f6; }
        .data-table th { color: #0d1f3c; font-weight: 700; border-bottom: 2px solid #e5e7eb; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
        .data-table td { padding: 13px 10px; vertical-align: middle; font-weight: 500; }
        .data-table tbody tr:hover { background: #f9fafb; }
    </style>

    <div class="dashboard-card">
            <?php if($pendingDocuments->count() > 0): ?>
                <!-- Verification Table -->
                <table class="table data-table w-100">
                    <thead>
                        <tr>
                            <th>Employer</th>
                            <th>Document Type</th>
                            <th>File</th>
                            <th>Submitted</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $pendingDocuments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><strong><?php echo e(Str::limit($doc->user?->name ?? 'N/A', 20)); ?></strong></td>
                                <td>
                                    <span class="badge badge-doctype bg-secondary"><?php echo e($doc->document_type); ?></span>
                                </td>
                                <td>
                                    <a href="<?php echo e(asset('storage/' . $doc->file_path)); ?>" target="_blank" class="link-primary d-inline-flex align-items-center gap-1">
                                        <i class="bi bi-file-earmark-pdf"></i> View File
                                    </a>
                                </td>
                                <td><small><?php echo e(\Carbon\Carbon::parse($doc->created_at)->format('d M, Y')); ?></small></td>
                                <td class="text-center">
                                    <form method="POST" class="d-inline-flex gap-2">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" formaction="<?php echo e(route('admin.documents.approve', $doc->id)); ?>"
                                                class="btn btn-sm btn-success" title="Approve this document">
                                            <i class="bi bi-check-circle"></i> Approve
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#rejectModal<?php echo e($doc->id); ?>" title="Reject this document">
                                            <i class="bi bi-x-circle"></i> Reject
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Rejection Modal -->
                            <div class="modal fade" id="rejectModal<?php echo e($doc->id); ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Reject Document</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST" action="<?php echo e(route('admin.documents.reject', $doc->id)); ?>">
                                            <?php echo csrf_field(); ?>
                                            <div class="modal-body">
                                                <p class="text-muted mb-3">Rejecting: <strong><?php echo e($doc->user?->name ?? 'N/A'); ?></strong> - <span class="text-uppercase fw-bold"><?php echo e($doc->document_type); ?></span></p>
                                                <div class="mb-3">
                                                    <label for="rejection_note_<?php echo e($doc->id); ?>" class="form-label">
                                                        Rejection Note <span class="text-danger">*</span>
                                                    </label>
                                                    <textarea
                                                        id="rejection_note_<?php echo e($doc->id); ?>"
                                                        name="notes"
                                                        class="form-control"
                                                        rows="4"
                                                        placeholder="Explain why this document is being rejected..."
                                                        required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Reject</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    <?php echo e($pendingDocuments->links('pagination::bootstrap-5')); ?>

                </div>
            <?php else: ?>
                <!-- Empty State -->
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <strong>All caught up!</strong> No pending documents to verify.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\admin\approvals\documents.blade.php ENDPATH**/ ?>