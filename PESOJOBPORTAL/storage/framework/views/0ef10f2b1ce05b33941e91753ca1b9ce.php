<?php $__env->startSection('title', 'QR Verification | PESO Admin'); ?>

<?php
    $pageTitle = 'QR Verification';
    $pageSubtitle = 'Verify QR codes and authentication tokens';
    $pageIcon = 'bi-qr-code';
?>

<?php $__env->startSection('content'); ?>
<div class="admin-dashboard">
    <style>
        .qr-container { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 500px; }
        .qr-scanner { width: 300px; height: 300px; border: 3px dashed #0d1f3c; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin: 1.5rem 0; flex-direction: column; }
        .qr-placeholder { font-size: 80px; color: #d1d5db; margin-bottom: 1rem; }
        .qr-info-box { background: #f3f4f6; padding: 1.5rem; border-radius: 10px; margin-top: 1.5rem; text-align: center; }
        .qr-info-title { font-weight: 700; color: #0d1f3c; margin-bottom: 0.5rem; }
        .qr-info-text { color: #6b7280; font-size: 14px; }
        .btn-primary { background: #0d1f3c; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; margin-top: 1rem; }
        .btn-primary:hover { background: #152d52; }
        .scan-result { background: white; padding: 1.5rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); margin-top: 2rem; }
        .result-status { display: flex; align-items: center; gap: 1rem; padding: 1rem; background: #d1fae5; border-radius: 6px; border-left: 4px solid #10b981; }
        .result-status i { color: #10b981; font-size: 24px; }
    </style>

    <div class="qr-container">
        <h5><i class="bi bi-qr-code me-2"></i>QR Code Scanner</h5>
        
        <div class="qr-scanner">
            <div class="qr-placeholder"><i class="bi bi-qr-code"></i></div>
            <p style="color: #9ca3af; font-size: 14px; text-align: center;">Position QR code in the scanner</p>
        </div>

        <button class="btn-primary"><i class="bi bi-camera me-1"></i>Start Camera</button>

        <div class="qr-info-box">
            <div class="qr-info-title">How to Use</div>
            <div class="qr-info-text">
                Position the QR code from a document within the scanner frame. The system will automatically detect and verify the QR code.
            </div>
        </div>
    </div>

    <div class="scan-result">
        <h6 style="margin-top: 0; margin-bottom: 1rem;">Recent Scan: CLR-2026-001</h6>
        <div class="result-status">
            <i class="bi bi-check-circle-fill"></i>
            <div>
                <strong>Verification Successful</strong>
                <p style="margin: 0.25rem 0 0 0; color: #065f46; font-size: 14px;">Document is valid and authentic</p>
            </div>
        </div>
        <div style="margin-top: 1rem; padding: 1rem; background: #f3f4f6; border-radius: 6px;">
            <p style="margin: 0; font-size: 14px;"><strong>Document Type:</strong> PESO Clearance</p>
            <p style="margin: 0.5rem 0 0 0; font-size: 14px;"><strong>Issued to:</strong> Carlo Rodriguez</p>
            <p style="margin: 0.5rem 0 0 0; font-size: 14px;"><strong>Issued Date:</strong> 10 Apr 2026</p>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\admin\qr-verification.blade.php ENDPATH**/ ?>