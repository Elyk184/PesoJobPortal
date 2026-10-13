<?php $__env->startSection('title', 'Contact Messages | PESO Admin'); ?>

<?php
    $pageTitle = 'Contact Messages';
    $pageSubtitle = 'View and reply to contact form submissions';
    $pageIcon = 'bi-envelope';
?>

<?php $__env->startSection('content'); ?>
<div class="admin-dashboard">
<style>
    .cm-shell { display: grid; gap: 1rem; }
    .cm-summary { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; }
    .cm-stat { background: white; border-radius: 16px; padding: 1.25rem; box-shadow: 0 6px 18px rgba(13,31,60,0.06); border: 1px solid #e7edf5; }
    .cm-stat-label { font-size: 12px; text-transform: uppercase; letter-spacing: 0.6px; color: #6b7280; font-weight: 700; margin-bottom: 0.35rem; }
    .cm-stat-value { font-size: 2rem; font-weight: 800; color: #0d1f3c; line-height: 1; }
    .cm-panel { background: white; border-radius: 18px; border: 1px solid #e7edf5; box-shadow: 0 6px 18px rgba(13,31,60,0.05); overflow: hidden; }
    .cm-panel-head { padding: 1.15rem 1.25rem; border-bottom: 1px solid #edf2f7; display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap; }
    .cm-panel-head h3 { margin: 0; font-size: 1rem; font-weight: 800; color: #0d1f3c; }
    .cm-table { width: 100%; border-collapse: collapse; font-size: 14px; }
    .cm-table th { padding: 0.75rem 1rem; background: #f8fafc; font-weight: 700; color: #374151; text-align: left; border-bottom: 1px solid #e5e7eb; }
    .cm-table td { padding: 0.85rem 1rem; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    .cm-table tr:last-child td { border-bottom: none; }
    .cm-table tr:hover td { background: #f8fafc; }
    .badge-unread { background: #dbeafe; color: #1d4ed8; }
    .badge-read { background: #f1f5f9; color: #64748b; }
    .badge-replied { background: #dcfce7; color: #16a34a; }
    .filter-tabs { display: flex; gap: 0.4rem; flex-wrap: wrap; }
    .filter-tab { padding: 0.35rem 0.85rem; border-radius: 999px; font-size: 13px; font-weight: 600; text-decoration: none; border: 1px solid #e5e7eb; color: #374151; background: white; transition: all 0.15s; }
    .filter-tab.active, .filter-tab:hover { background: #0d1f3c; color: white; border-color: #0d1f3c; }
</style>

<div class="cm-shell">
    <div class="cm-summary">
        <div class="cm-stat">
            <div class="cm-stat-label">Total Messages</div>
            <div class="cm-stat-value"><?php echo e($stats['all']); ?></div>
        </div>
        <div class="cm-stat">
            <div class="cm-stat-label">Unread</div>
            <div class="cm-stat-value" style="color:#1d4ed8;"><?php echo e($stats['unread']); ?></div>
        </div>
        <div class="cm-stat">
            <div class="cm-stat-label">Replied</div>
            <div class="cm-stat-value" style="color:#16a34a;"><?php echo e($stats['replied']); ?></div>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success rounded-3 border-0 mb-0"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger rounded-3 border-0 mb-0"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <div class="cm-panel">
        <div class="cm-panel-head">
            <h3><i class="bi bi-envelope me-2"></i>Messages</h3>
            <div class="filter-tabs">
                <a href="<?php echo e(route('admin.contact-messages', ['filter' => 'all'])); ?>" class="filter-tab <?php echo e($filter === 'all' ? 'active' : ''); ?>">All (<?php echo e($stats['all']); ?>)</a>
                <a href="<?php echo e(route('admin.contact-messages', ['filter' => 'unread'])); ?>" class="filter-tab <?php echo e($filter === 'unread' ? 'active' : ''); ?>">Unread (<?php echo e($stats['unread']); ?>)</a>
                <a href="<?php echo e(route('admin.contact-messages', ['filter' => 'replied'])); ?>" class="filter-tab <?php echo e($filter === 'replied' ? 'active' : ''); ?>">Replied (<?php echo e($stats['replied']); ?>)</a>
            </div>
        </div>

        <?php if($messages->isEmpty()): ?>
            <div class="p-4 text-center text-muted">No messages found.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="cm-table">
                    <thead>
                        <tr>
                            <th>From</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Received</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <div class="fw-bold"><?php echo e($msg->name); ?></div>
                                <div class="text-muted small"><?php echo e($msg->email); ?></div>
                                <?php if($msg->phone): ?><div class="text-muted small"><?php echo e($msg->phone); ?></div><?php endif; ?>
                            </td>
                            <td class="fw-semibold"><?php echo e($msg->subject); ?></td>
                            <td style="max-width:260px;">
                                <div class="text-truncate" style="max-width:240px;" title="<?php echo e($msg->message); ?>"><?php echo e($msg->message); ?></div>
                            </td>
                            <td>
                                <span class="badge rounded-pill px-3 py-1 badge-<?php echo e($msg->status); ?>"><?php echo e(ucfirst($msg->status)); ?></span>
                            </td>
                            <td class="text-muted small"><?php echo e($msg->created_at->diffForHumans()); ?></td>
                            <td>
                                <button class="btn btn-sm btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#replyModal<?php echo e($msg->id); ?>">
                                    <i class="bi bi-reply me-1"></i><?php echo e($msg->status === 'replied' ? 'View/Reply' : 'Reply'); ?>

                                </button>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <div class="p-3"><?php echo e($messages->links()); ?></div>
        <?php endif; ?>
    </div>
</div>


<?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="replyModal<?php echo e($msg->id); ?>" tabindex="-1" aria-labelledby="replyModalLabel<?php echo e($msg->id); ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="replyModalLabel<?php echo e($msg->id); ?>">
                    <i class="bi bi-envelope-open me-2 text-primary"></i>Message from <?php echo e($msg->name); ?>

                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="bg-light rounded-3 p-3 mb-3" style="font-size:14px;">
                    <div class="row g-2 mb-2">
                        <div class="col-sm-6"><span class="text-muted">From:</span> <strong><?php echo e($msg->name); ?></strong> &lt;<?php echo e($msg->email); ?>&gt;</div>
                        <div class="col-sm-6"><span class="text-muted">Phone:</span> <?php echo e($msg->phone ?: 'N/A'); ?></div>
                        <div class="col-12"><span class="text-muted">Subject:</span> <strong><?php echo e($msg->subject); ?></strong></div>
                    </div>
                    <div class="border-top pt-2" style="white-space:pre-line;"><?php echo e($msg->message); ?></div>
                </div>

                <?php if($msg->admin_reply): ?>
                    <div class="alert alert-success rounded-3 border-0 mb-3" style="font-size:13px;">
                        <div class="fw-bold mb-1"><i class="bi bi-check-circle me-1"></i>Reply sent <?php echo e($msg->replied_at?->diffForHumans()); ?></div>
                        <div style="white-space:pre-line;"><?php echo e($msg->admin_reply); ?></div>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('admin.contact-messages.reply', $msg)); ?>">
                    <?php echo csrf_field(); ?>
                    <label class="form-label fw-semibold">Your Reply <span class="text-danger">*</span></label>
                    <textarea name="reply" class="form-control rounded-3" rows="5" required maxlength="5000" placeholder="Type your reply here..."><?php echo e(old('reply')); ?></textarea>
                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-send me-2"></i>Send Reply via Brevo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views/admin/contact-messages.blade.php ENDPATH**/ ?>