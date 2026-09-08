<?php $__env->startSection('title', 'Company Preview - PESO'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<style>
    body{
        background: #eef2f7;
        color:#23374f;
    }

    .company-preview-wrap {
        max-width: 980px;
        margin: 28px auto;
        padding: 0 12px;
    }
    .preview-card {
        background: #fff;
        border: 1px solid #dbe4ee;
        border-radius: 16px;
        box-shadow: 0 14px 28px rgba(15, 23, 42, 0.05);
        overflow: hidden;
    }
.preview-hero{
        padding:22px 22px 18px;
        background:linear-gradient(120deg,#0f2d52 0%,#1f4b8f 100%);
        color:#fff;
        display:flex;
        gap:16px;
        align-items:center;
        flex-wrap:wrap;
        box-shadow:0 12px 30px rgba(10,35,80,.15);
    }
    .logo {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        background: rgba(255,255,255,.18);
        border: 1px solid rgba(255,255,255,.35);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
    }
    .logo img { width: 100%; height: 100%; object-fit: cover; }

    .preview-title {
        font-size: 1.6rem;
        font-weight: 900;
        margin: 0;
        line-height: 1.2;
    }
    .preview-sub {
        margin-top: 8px;
        opacity: .95;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: center;
        font-weight: 700;
        font-size: 13px;
    }

    .chip {
        background: rgba(255,255,255,.14);
        border: 1px solid rgba(255,255,255,.28);
        padding: 6px 10px;
        border-radius: 999px;
        display: inline-flex;
        gap: 6px;
        align-items: center;
        white-space: nowrap;
    }

    .preview-body { padding: 18px 22px 22px; }
    .section {
        border: 1px solid #dbe4ee;
        border-radius: 14px;
        padding: 14px 14px;
        background: #fbfdff;
        margin-top: 14px;
    }
    .section h5 {
        margin: 0 0 10px;
        font-size: 14px;
        font-weight: 900;
        color: #10243f;
        display: flex;
        gap: 10px;
        align-items: center;
    }
    .section h5 i {
        width: 30px;
        height: 30px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #eef7f6;
        color: #0f766e;
    }

    .kv {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px 16px;
    }
    @media (max-width: 768px){ .kv { grid-template-columns: 1fr; } }
    .kv .item {
        background: #fff;
        border: 1px solid #e7eef7;
        border-radius: 12px;
        padding: 12px;
    }
    .kv .k { color: #64748b; font-size: 12px; font-weight: 800; margin-bottom: 6px; }
    .kv .v { color: #10243f; font-size: 13px; font-weight: 700; }

    .muted { color: #64748b; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="company-preview-wrap">
    <div class="preview-card">
        <div class="preview-hero">
            <div class="logo" aria-hidden="true">
                <?php if($logoUrl): ?>
                    <img src="<?php echo e($logoUrl); ?>" alt="<?php echo e($companyName); ?> logo">
                <?php else: ?>
                    <i class="bi bi-building"></i>
                <?php endif; ?>
            </div>

            <div>
                <h1 class="preview-title"><?php echo e($companyName); ?></h1>
                <div class="preview-sub">
                    <span class="chip"><i class="bi bi-shield-check"></i>
                        <?php echo e($companyProfile?->verification_status ? ucwords(str_replace('_',' ', $companyProfile->verification_status)) : 'Pending'); ?>

                    </span>
                    <?php if($companyProfile?->establishment_email): ?>
                        <span class="chip"><i class="bi bi-envelope"></i> <?php echo e($companyProfile->establishment_email); ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="preview-body">
            <div class="section">
                <h5><i class="bi bi-info-circle"></i> Company Overview</h5>
                    <div class="muted" style="font-weight:700; line-height:1.6; white-space:pre-wrap;">
                    <?php echo e($companyInformationPreview ?? 'No company information provided yet.'); ?>

                </div>

            </div>

            <div class="section">
                <h5><i class="bi bi-geo-alt"></i> Contact & Location</h5>
                <div class="kv">
                    <div class="item">
                        <div class="k">Address</div>
                        <div class="v">
                            <?php echo e(trim(implode(', ', array_filter([
                                $companyProfile?->street_village,
                                $companyProfile?->barangay,
                                $companyProfile?->city_municipality,
                                $companyProfile?->province,
                            ]))) ?: 'Address not provided'); ?>

                        </div>
                    </div>
                    <div class="item">
                        <div class="k">Contact Person</div>
                        <div class="v"><?php echo e($companyProfile?->contact_person_name ?? $companyProfile?->establishment_contact_person ?? '—'); ?></div>
                    </div>
                    <div class="item">
                        <div class="k">Contact Position</div>
                        <div class="v"><?php echo e($companyProfile?->establishment_contact_position ?? '—'); ?></div>
                    </div>
                    <div class="item">
                        <div class="k">Mobile Number</div>
                        <div class="v"><?php echo e($companyProfile?->contact_person_phone ?? $companyProfile?->establishment_phone ?? '—'); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\dashboard\employer\companies\preview.blade.php ENDPATH**/ ?>