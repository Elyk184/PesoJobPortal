<?php $__env->startSection('title', 'Request LRA/SRA'); ?>
<?php $__env->startSection('hide_header', true); ?>

<?php $__env->startSection('content'); ?>
    <style>
        .lra-page {
            margin: -1rem;
            padding: 1.2rem;
            min-height: 100vh;
            display: grid;
            gap: 16px;
            align-content: start;
            grid-auto-rows: max-content;
            background:
                radial-gradient(circle at top right, rgba(45, 101, 177, 0.12), transparent 45%),
                radial-gradient(circle at bottom left, rgba(215, 38, 56, 0.08), transparent 40%),
                #eef3fb;
        }

        .lra-hero {
            position: relative;
            overflow: hidden;
            border-radius: 18px;
            padding: 1.4rem;
            color: #fff;
            background: linear-gradient(135deg, #1f4f97 0%, #2f6ec8 48%, #5ca2ff 100%);
            box-shadow: 0 14px 28px rgba(31, 79, 151, 0.24);
        }

        .lra-hero::after {
            content: "";
            position: absolute;
            width: 230px;
            height: 230px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.14);
            right: -65px;
            top: -82px;
        }

        .lra-kicker {
            position: relative;
            z-index: 1;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.28rem 0.7rem;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.35);
            background: rgba(255, 255, 255, 0.14);
            font-size: 0.8rem;
            font-weight: 600;
        }

        .lra-hero h1 {
            position: relative;
            z-index: 1;
            margin: 0.7rem 0 0.3rem;
            font-size: 1.78rem;
            font-weight: 800;
        }

        .lra-hero p {
            position: relative;
            z-index: 1;
            margin: 0;
            max-width: 760px;
            color: rgba(255, 255, 255, 0.92);
            line-height: 1.55;
        }

        .lra-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .lra-card {
            background: #fff;
            border: 1px solid #d8e2f1;
            border-radius: 16px;
            box-shadow: 0 12px 26px rgba(15, 23, 42, 0.06);
            padding: 1.2rem;
        }

        .lra-card h2 {
            margin: 0 0 0.35rem;
            color: #12243f;
            font-size: 1.2rem;
            font-weight: 800;
        }

        .lra-card p {
            color: #5f6f86;
            margin: 0 0 0.9rem;
        }

        .lra-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.65rem;
        }

        .lra-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            border-radius: 11px;
            padding: 0.72rem 0.95rem;
            font-weight: 700;
            text-decoration: none;
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }

        .lra-btn:hover {
            transform: translateY(-1px);
        }

        .lra-btn.primary {
            color: #fff;
            border: 0;
            background: linear-gradient(135deg, #1f4f97 0%, #2f6ec8 100%);
            box-shadow: 0 10px 20px rgba(31, 79, 151, 0.22);
        }

        .lra-btn.secondary {
            color: #1f4f97;
            border: 1px solid #c7dcff;
            background: #edf4ff;
        }

        .lra-note {
            margin-top: 0.9rem;
            color: #6b778c;
            font-size: 0.9rem;
        }

        .request-list {
            display: grid;
            gap: 0.7rem;
        }

        .request-item {
            border: 1px solid #e3eaf4;
            border-radius: 14px;
            padding: 0.95rem 1rem;
            background: linear-gradient(180deg, #fbfdff 0%, #f7faff 100%);
        }

        .request-item-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.7rem;
            margin-bottom: 0.35rem;
            flex-wrap: wrap;
        }

        .request-type {
            color: #12243f;
            font-weight: 800;
            letter-spacing: 0.02em;
        }

        .request-status {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            padding: 0.25rem 0.6rem;
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 0.03em;
            color: #fff;
        }

        .request-status.pending {
            background: #f59e0b;
        }

        .request-status.approved {
            background: #10b981;
        }

        .request-status.rejected {
            background: #ef4444;
        }

        .request-approval-info {
            font-size: 0.85rem;
            color: #5f6f86;
            margin-top: 0.4rem;
        }

        .request-approval-info strong {
            color: #12243f;
        }

        .request-meta {
            margin: 0;
            color: #60708a;
            font-size: 0.92rem;
        }

        @media (max-width: 992px) {
            .lra-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .lra-page {
                margin: -0.7rem;
                padding: 0.8rem;
            }

            .lra-hero {
                padding: 1.15rem;
            }

            .lra-hero h1 {
                font-size: 1.45rem;
            }
        }
    </style>

    <div class="lra-page">
        <section class="lra-hero">
            <span class="lra-kicker"><i class="bi bi-clipboard-check"></i> Compliance</span>
            <h1>Request LRA/SRA</h1>
            <p>Choose your activity type, then continue to document submission. Keep all recruitment activity requests organized in one place.</p>
        </section>

        <div class="lra-grid">
            <section class="lra-card">
                <h2>Recruitment Activity Requests</h2>
                <p>Start with an activity type, then submit your required files.</p>
                <div class="lra-actions">
                    <a class="lra-btn primary" href="<?php echo e(route('employer.documents.index', ['activity_type' => 'lra'])); ?>">
                        <i class="bi bi-folder-plus"></i> Start LRA Request
                    </a>
                    <a class="lra-btn secondary" href="<?php echo e(route('employer.documents.index', ['activity_type' => 'sra'])); ?>">
                        <i class="bi bi-folder2-open"></i> Start SRA Request
                    </a>
                </div>
                <p class="lra-note">Document uploads are handled in the Submit Documents page.</p>
            </section>

            <section class="lra-card">
                <h2>Submitted Requests</h2>
                <div class="request-list">
                    <?php $__empty_1 = true; $__currentLoopData = $recruitmentRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <article class="request-item">
                            <div class="request-item-top">
                                <span class="request-type"><?php echo e(strtoupper($request->activity_type)); ?></span>
                                <span class="request-status <?php echo e($request->status); ?>"><?php echo e(strtoupper($request->status)); ?></span>
                            </div>
                            <p class="request-meta">Submitted: <?php echo e(optional($request->created_at)->format('M d, Y h:i A')); ?></p>

                            <?php if($request->status === 'approved'): ?>
                                <div class="request-approval-info">
                                    <i class="bi bi-check-circle-fill" style="color: #10b981;"></i>
                                    <strong>Approved on:</strong> <?php echo e(optional($request->approved_at)->format('M d, Y h:i A')); ?>

                                    <?php if($request->approvedBy): ?>
                                        <br><strong>By:</strong> <?php echo e($request->approvedBy->name); ?>

                                    <?php endif; ?>
                                </div>
                            <?php elseif($request->status === 'rejected'): ?>
                                <div class="request-approval-info">
                                    <i class="bi bi-x-circle-fill" style="color: #ef4444;"></i>
                                    <strong>Rejected on:</strong> <?php echo e(optional($request->created_at)->format('M d, Y h:i A')); ?>

                                    <?php if($request->notes): ?>
                                        <br><strong>Reason:</strong> <?php echo e($request->notes); ?>

                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <!-- Action Buttons -->
                            <div style="display: flex; gap: 8px; margin-top: 12px;">
                                <a href="<?php echo e(route('employer.recruitment.show', $request)); ?>"
                                   style="background: #6366f1; color: white; border: none; padding: 8px 12px; border-radius: 6px; font-size: 0.85rem; font-weight: 600; text-decoration: none; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                                    <i class="bi bi-eye"></i> View Details
                                </a>
                                <?php if($request->status === 'approved' && $request->certification_path): ?>
                                    <a href="<?php echo e(route('employer.recruitment.download-certificate', $request)); ?>"
                                       style="background: #10b981; color: white; border: none; padding: 8px 12px; border-radius: 6px; font-size: 0.85rem; font-weight: 600; text-decoration: none; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                                        <i class="bi bi-download"></i> Download Certificate
                                    </a>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="mb-0">No LRA/SRA requests submitted yet.</p>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.employer.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\dashboard\employer\request-lra-sra.blade.php ENDPATH**/ ?>