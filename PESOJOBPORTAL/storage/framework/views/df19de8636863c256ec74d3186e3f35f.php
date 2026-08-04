<?php $__env->startSection('title', 'Settings | PESO Admin'); ?>

<?php
    $pageTitle = 'Settings';
    $pageSubtitle = 'Configure system settings';
    $pageIcon = 'bi-gear';
?>

<?php $__env->startSection('content'); ?>
<div class="admin-dashboard">
    <style>
        .settings-form { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); margin-bottom: 2rem; }
        .settings-section { margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid #e5e7eb; }
        .settings-section:last-child { border-bottom: none; }
        .form-group { margin-bottom: 1.5rem; }
        .form-label { display: block; font-weight: 600; color: #0d1f3c; margin-bottom: 0.5rem; font-size: 14px; }
        .form-control { width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; }
        .toggle-switch { display: inline-block; width: 50px; height: 28px; background: #d1d5db; border-radius: 14px; cursor: pointer; position: relative; }
        .toggle-switch.active { background: #10b981; }
        .toggle-switch::after { content: ''; position: absolute; width: 24px; height: 24px; background: white; border-radius: 50%; top: 2px; left: 2px; transition: all 0.2s ease; }
        .toggle-switch.active::after { left: 24px; }
        .btn-primary { background: #0d1f3c; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; }
        .btn-primary:hover { background: #152d52; }
    </style>

    <div class="settings-form">
        <div class="settings-section">
            <h5><i class="bi bi-gear me-2"></i>System Configuration</h5>
            <div class="form-group">
                <label class="form-label">System Name</label>
                <input type="text" class="form-control" value="PESO Job Portal" />
            </div>
            <div class="form-group">
                <label class="form-label">Admin Email</label>
                <input type="email" class="form-control" value="admin@peso.gov.ph" />
            </div>
            <div class="form-group">
                <label class="form-label">Support Email</label>
                <input type="email" class="form-control" value="support@peso.gov.ph" />
            </div>
        </div>

        <div class="settings-section">
            <h5><i class="bi bi-bell me-2"></i>Notification Settings</h5>
            <div class="form-group">
                <label class="form-label">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span>Email Notifications</span>
                        <div class="toggle-switch active"></div>
                    </div>
                </label>
            </div>
            <div class="form-group">
                <label class="form-label">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span>SMS Notifications</span>
                        <div class="toggle-switch"></div>
                    </div>
                </label>
            </div>
        </div>

        <div class="settings-section">
            <h5><i class="bi bi-shield-lock me-2"></i>Security Settings</h5>
            <div class="form-group">
                <label class="form-label">Session Timeout (minutes)</label>
                <input type="number" class="form-control" value="30" />
            </div>
            <div class="form-group">
                <label class="form-label">Max Login Attempts</label>
                <input type="number" class="form-control" value="5" />
            </div>
        </div>

        <button class="btn-primary"><i class="bi bi-check-lg me-1"></i>Save Settings</button>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\admin\settings.blade.php ENDPATH**/ ?>