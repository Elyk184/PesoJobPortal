<?php $__env->startSection('title', 'PESO Clearance Request | Admin'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $status = strtolower($clearance->status ?? 'pending');
    $statusLabel = ucfirst($status);
    $statusClass = match ($status) {
        'pending' => 'bg-warning text-dark',
        'approved', 'active', 'issued' => 'bg-success',
        'rejected', 'declined' => 'bg-danger',
        default => 'bg-secondary',
    };
?>

<div class="admin-dashboard">
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4 p-lg-5">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start gap-3 mb-4">
                <div>
                    <div class="text-uppercase text-muted small fw-semibold mb-1">PESO Clearance</div>
                    <h3 class="mb-2">Request Details</h3>
                    <div class="text-muted">Review the uploaded documents and issue the clearance from the same page.</div>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <span class="badge <?php echo e($statusClass); ?> px-3 py-2"><?php echo e($statusLabel); ?></span>
                    <span class="badge bg-light text-dark border px-3 py-2">Request #<?php echo e($clearance->id); ?></span>
                </div>
            </div>

            <div class="row g-4 align-items-start">
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-4">Request Details</h5>

                            <dl class="row mb-0 gy-2">
                                <dt class="col-sm-4 text-muted fw-normal">Requester</dt>
                                <dd class="col-sm-8 mb-0 fw-semibold"><?php echo e($clearance->user?->name ?? 'Unknown'); ?></dd>

                                <dt class="col-sm-4 text-muted fw-normal">Requested</dt>
                                <dd class="col-sm-8 mb-0"><?php echo e($clearance->request_date ? $clearance->request_date->format('F d, Y h:i A') : 'N/A'); ?></dd>

                                <dt class="col-sm-4 text-muted fw-normal">Status</dt>
                                <dd class="col-sm-8 mb-0"><span class="badge <?php echo e($statusClass); ?>"><?php echo e($statusLabel); ?></span></dd>

                                <?php if($clearance->remarks): ?>
                                    <dt class="col-sm-4 text-muted fw-normal">Remarks</dt>
                                    <dd class="col-sm-8 mb-0"><?php echo e($clearance->remarks); ?></dd>
                                <?php endif; ?>
                            </dl>

                            <div class="mt-4">
                                <?php if($clearance->peso_clearance_assurance_receipt_path): ?>
                                    <div class="mb-4 p-3 border rounded-3 bg-light">
                                        <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
                                            <strong>Assurance Receipt</strong>
                                            <a href="<?php echo e(asset('storage/' . $clearance->peso_clearance_assurance_receipt_path)); ?>" target="_blank" class="small text-decoration-none">Open in new tab</a>
                                        </div>
                                        <?php
                                            $assuranceUrl = asset('storage/' . $clearance->peso_clearance_assurance_receipt_path);
                                            $assuranceExt = strtolower(pathinfo($clearance->peso_clearance_assurance_receipt_path, PATHINFO_EXTENSION));
                                        ?>

                                        <div>
                                            <?php if(in_array($assuranceExt, ['jpg','jpeg','png','gif'])): ?>
                                                <a href="<?php echo e($assuranceUrl); ?>" target="_blank" class="d-block text-center"><img src="<?php echo e($assuranceUrl); ?>" alt="Assurance Receipt" class="img-fluid rounded-3 border bg-white" style="max-height:300px; object-fit:contain;"></a>
                                            <?php elseif($assuranceExt === 'pdf'): ?>
                                                <div class="border rounded-3 overflow-hidden bg-white"><iframe src="<?php echo e($assuranceUrl); ?>" style="width:100%; height:320px;" frameborder="0"></iframe></div>
                                            <?php else: ?>
                                                <a href="<?php echo e($assuranceUrl); ?>" target="_blank" class="btn btn-outline-secondary btn-sm">Open File</a>
                                            <?php endif; ?>
                                        </div>

                                        <a href="<?php echo e($assuranceUrl); ?>" download class="small d-inline-block mt-3">Download file</a>
                                    </div>
                                <?php endif; ?>

                                <?php if($clearance->barangay_clearance_path): ?>
                                    <div class="mb-0 p-3 border rounded-3 bg-light">
                                        <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
                                            <strong>Barangay Clearance</strong>
                                            <a href="<?php echo e(asset('storage/' . $clearance->barangay_clearance_path)); ?>" target="_blank" class="small text-decoration-none">Open in new tab</a>
                                        </div>
                                        <?php
                                            $barangayUrl = asset('storage/' . $clearance->barangay_clearance_path);
                                            $barangayExt = strtolower(pathinfo($clearance->barangay_clearance_path, PATHINFO_EXTENSION));
                                        ?>

                                        <div>
                                            <?php if(in_array($barangayExt, ['jpg','jpeg','png','gif'])): ?>
                                                <a href="<?php echo e($barangayUrl); ?>" target="_blank" class="d-block text-center"><img src="<?php echo e($barangayUrl); ?>" alt="Barangay Clearance" class="img-fluid rounded-3 border bg-white" style="max-height:300px; object-fit:contain;"></a>
                                            <?php elseif($barangayExt === 'pdf'): ?>
                                                <div class="border rounded-3 overflow-hidden bg-white"><iframe src="<?php echo e($barangayUrl); ?>" style="width:100%; height:320px;" frameborder="0"></iframe></div>
                                            <?php else: ?>
                                                <a href="<?php echo e($barangayUrl); ?>" target="_blank" class="btn btn-outline-secondary btn-sm">Open File</a>
                                            <?php endif; ?>
                                        </div>

                                        <a href="<?php echo e($barangayUrl); ?>" download class="small d-inline-block mt-3">Download file</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm position-sticky" style="top: 1rem;">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-2">Issue Clearance</h5>
                            <p class="text-muted small mb-4">Fill in the clearance details before issuing the document.</p>

                            <form method="POST" action="<?php echo e(route('admin.peso-clearances.issue', $clearance)); ?>">
                                <?php echo csrf_field(); ?>

                                <div class="mb-3">
                                    <label class="form-label">Clearance Number</label>
                                    <input type="text" name="clearance_number" class="form-control" value="<?php echo e(old('clearance_number', $clearance->clearance_number ?? '')); ?>" placeholder="00000">
                                    <?php $__errorArgs = ['clearance_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Issue Date</label>
                                    <input type="datetime-local" name="issue_date" class="form-control" value="<?php echo e(old('issue_date') ?? (\Carbon\Carbon::now()->format('Y-m-d\\TH:i'))); ?>">
                                    <?php $__errorArgs = ['issue_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Expiry Date</label>
                                    <input type="date" name="expiry_date" class="form-control" value="<?php echo e(old('expiry_date') ?? (\Carbon\Carbon::now()->addYear()->format('Y-m-d'))); ?>">
                                    <?php $__errorArgs = ['expiry_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-3">
                                    <a href="<?php echo e(route('admin.peso-clearances')); ?>" class="btn btn-outline-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Issue Clearance</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\admin\peso-clearance-show.blade.php ENDPATH**/ ?>