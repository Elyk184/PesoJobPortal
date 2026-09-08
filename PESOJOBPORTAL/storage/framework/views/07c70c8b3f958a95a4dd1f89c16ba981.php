<?php $__env->startSection('title', 'Notifications'); ?>
<?php $__env->startSection('hide_header'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <style>
        .notifications-page {
            background:
                radial-gradient(circle at top right, rgba(72, 121, 205, 0.1), transparent 45%),
                radial-gradient(circle at left bottom, rgba(43, 103, 177, 0.08), transparent 42%),
                #f3f7fd;
            border-radius: 16px;
            padding: 1.15rem;
        }

        .gmail-shell {
            border: 1px solid #d9e3f1;
            border-radius: 18px;
            overflow: hidden;
            background: #ffffff;
            box-shadow: 0 16px 32px rgba(17, 39, 76, 0.08);
        }

        .gmail-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            padding: 1.05rem 1.25rem;
            background: linear-gradient(135deg, #075cb2 0%, #3498db 100%);
            border-bottom: 1px solid rgba(7, 92, 178, 0.35);
        }

        .gmail-toolbar-left {
            display: inline-flex;
            align-items: center;
            gap: 0.65rem;
            min-width: 0;
        }

        .gmail-title {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 800;
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
        }

        .gmail-toolbar-counts {
            display: inline-flex;
            gap: 0.45rem;
            align-items: center;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .gmail-meta {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.46);
            background: rgba(255, 255, 255, 0.14);
            color: #ffffff;
            font-size: 0.78rem;
            font-weight: 700;
            padding: 0.38rem 0.8rem;
            white-space: nowrap;
            box-shadow: 0 6px 14px rgba(6, 42, 92, 0.12);
        }

        .gmail-meta.all {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.55);
            color: #ffffff;
        }

        .gmail-meta.job {
            background: rgba(14, 165, 233, 0.18);
            border-color: rgba(14, 165, 233, 0.55);
            color: #ffffff;
        }

        .gmail-meta.verification {
            background: rgba(34, 197, 94, 0.18);
            border-color: rgba(34, 197, 94, 0.55);
            color: #ffffff;
        }

        .gmail-list-head {
            display: grid;
            grid-template-columns: 20px 32px minmax(160px, 1.1fr) minmax(240px, 1.9fr) 112px 120px 92px;
            gap: 0.85rem;
            align-items: center;
            padding: 0.65rem 1.15rem;
            background: #fbfdff;
            border-bottom: 1px solid #e8eff8;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #6d7f98;
            font-weight: 700;
        }

        .gmail-list {
            background: #fff;
        }

        .gmail-row {
            display: grid;
            grid-template-columns: 20px 32px minmax(160px, 1.1fr) minmax(240px, 1.9fr) 112px 120px 92px;
            align-items: center;
            gap: 0.85rem;
            padding: 1rem 1.15rem;
            border-bottom: 1px solid #ecf1f8;
            transition: background-color 0.16s ease, box-shadow 0.16s ease, transform 0.12s ease;
            cursor: pointer;
        }

        .gmail-row:hover {
            background: #f8fbff;
            box-shadow: 0 6px 18px rgba(17, 39, 76, 0.06), inset 0 1px 0 rgba(56, 101, 179, 0.03);
            transform: translateY(-2px);
        }

        .gmail-row.unread {
            background: #ffffff;
        }

        .gmail-row.unread .gmail-subject,
        .gmail-row.unread .gmail-message,
        .gmail-row.unread .gmail-time {
            font-weight: 700;
            color: #0f2340;
        }

        .unread-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #1a73e8;
            box-shadow: 0 0 0 4px rgba(26, 115, 232, 0.16);
        }

        .read-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            border: 2px solid #c4cedd;
            background: #ffffff;
        }

        .gmail-type-icon {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #315d95;
            border: 1px solid #d8e5f8;
            background: #eff5ff;
            font-size: 0.86rem;
        }

        .gmail-subject {
            min-width: 0;
            color: #1a3356;
            font-size: 0.93rem;
            font-weight: 700;
            line-height: 1.35;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .gmail-message {
            min-width: 0;
            font-size: 0.9rem;
            color: #53657d;
            line-height: 1.4;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .gmail-time {
            color: #667994;
            font-size: 0.82rem;
            white-space: nowrap;
            justify-self: end;
        }

        .gmail-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            padding: 0.28rem 0.6rem;
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            color: #234570;
            background: linear-gradient(180deg, #f7fbff 0%, #eaf5ff 100%);
            border: 1px solid #d6e9ff;
            white-space: nowrap;
            justify-self: start;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.06);
        }

        .gmail-read-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            color: #6a7d97;
            font-size: 0.76rem;
            font-weight: 700;
            white-space: nowrap;
            justify-self: end;
        }

        .mark-read-btn {
            border: 1px solid #cfe0f9;
            background: #f2f7ff;
            color: #23579c;
            border-radius: 8px;
            padding: 0.32rem 0.58rem;
            font-size: 0.75rem;
            font-weight: 700;
            transition: all 0.16s ease;
            white-space: nowrap;
        }

        .mark-read-btn:hover {
            background: #e6f1ff;
            border-color: #acc8ef;
            color: #17457d;
        }

        .gmail-view-btn {
            border: 1px solid #cfe0f9;
            background: #3b82f6;
            color: white;
            border-radius: 8px;
            padding: 0.32rem 0.58rem;
            font-size: 0.75rem;
            font-weight: 700;
            transition: all 0.16s ease;
            white-space: nowrap;
            cursor: pointer;
            margin-right: 0.25rem;
        }

        .gmail-view-btn:hover {
            background: #2563eb;
            border-color: #2563eb;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        /* Notification Detail Modal */
        .notification-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s ease;
        }

        .notification-modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .notification-modal-content {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            width: 95%;
            max-height: 80vh;
            overflow-y: auto;
            animation: slideUp 0.3s ease;
        }

        .notification-modal-header {
            padding: 1.5rem;
            border-bottom: 2px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(135deg, #075cb2 0%, #3498db 100%);
            color: white;
            border-radius: 16px 16px 0 0;
        }

        .notification-modal-header h3 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 800;
        }

        .notification-modal-close {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .notification-modal-close:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .notification-modal-body {
            padding: 2rem;
        }

        .notification-detail-section {
            margin-bottom: 1.5rem;
        }

        .notification-detail-label {
            font-size: 0.85rem;
            font-weight: 800;
            text-transform: uppercase;
            color: #6d7f98;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .notification-detail-value {
            font-size: 1rem;
            color: #1a3356;
            line-height: 1.6;
        }

        .notification-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            background: #e9f2ff;
            color: #315d95;
            border: 1px solid #cfe1fb;
            margin-top: 1rem;
        }

        .notification-modal-footer {
            padding: 1.5rem;
            border-top: 1px solid #f0f0f0;
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            background: #fbfdff;
            border-radius: 0 0 16px 16px;
        }

        .modal-btn {
            padding: 0.55rem 1.2rem;
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .modal-btn-close {
            background: #e5e7eb;
            color: #374151;
        }

        .modal-btn-close:hover {
            background: #d1d5db;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .gmail-action {
            justify-self: end;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        .gmail-row .unread-dot,
        .gmail-row .read-dot {
            justify-self: center;
        }

        .gmail-row .gmail-type-icon {
            justify-self: center;
        }

        .gmail-row .gmail-time {
            justify-self: start;
        }

        .gmail-row .gmail-action .mark-read-btn {
            min-height: 34px;
            padding-inline: 0.75rem;
        }

        .empty-mail {
            padding: 2.5rem 1rem;
            text-align: center;
            color: #6b7f98;
            font-weight: 600;
        }

        .empty-mail i {
            display: block;
            font-size: 2.1rem;
            margin-bottom: 0.6rem;
            color: #a4b3c7;
        }

        @media (max-width: 992px) {
            .gmail-list-head {
                display: none;
            }

            .gmail-row {
                grid-template-columns: auto auto minmax(0, 1fr) auto;
                grid-template-areas:
                    "dot icon subject time"
                    "dot icon message message"
                    "dot icon meta action";
                gap: 0.5rem 0.7rem;
            }

            .unread-dot,
            .read-dot {
                grid-area: dot;
            }

            .gmail-type-icon {
                grid-area: icon;
            }

            .gmail-subject {
                grid-area: subject;
            }

            .gmail-message {
                grid-area: message;
                white-space: normal;
                overflow: visible;
                text-overflow: initial;
            }

            .gmail-time {
                grid-area: time;
            }

            .gmail-badge {
                grid-area: meta;
                justify-self: start;
            }

            .gmail-action {
                grid-area: action;
                justify-self: end;
            }
        }

        @media (max-width: 576px) {
            .notifications-page {
                padding: 0.65rem;
            }

            .gmail-toolbar {
                padding: 0.9rem 0.9rem;
                flex-direction: column;
                align-items: flex-start;
            }

            .gmail-toolbar-counts {
                justify-content: flex-start;
            }

            .gmail-row {
                padding: 0.75rem 0.8rem;
            }
        }
    </style>

    <div class="notifications-page">
        <div class="gmail-shell">
            <div class="gmail-toolbar">
                <div class="gmail-toolbar-left">
                    <h2 class="gmail-title"><i class="bi bi-envelope"></i>Notifications</h2>
                </div>
                <div class="gmail-toolbar-counts">
                    <span class="gmail-meta"><i class="bi bi-circle-fill"></i><?php echo e($unreadCount); ?> unread</span>
                </div>
            </div>

            <div class="gmail-list-head">
                <span></span>
                <span></span>
                <span>Subject</span>
                <span>Message</span>
                <span>Time</span>
                <span>Type</span>
                <span>Action</span>
            </div>

            <?php
                $notificationTypeIcons = [
                    'job_fair_invite' => 'bi-calendar-event',
                    'referral_update' => 'bi-arrow-repeat',
                    'job_update' => 'bi-briefcase',
                    'verification_update' => 'bi-shield-check',
                ];
            ?>

            <div class="gmail-list">
                <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $typeKey = strtolower((string) $notification->type);
                        $title = strtolower((string) $notification->title);
                        $message = strtolower((string) $notification->message);

                        if ($typeKey === 'job_update' || str_contains($title, 'job') || str_contains($message, 'job post')) {
                            $typeIcon = $notificationTypeIcons['job_update'];
                        } elseif ($typeKey === 'verification_update' || str_contains($title, 'verification') || str_contains($message, 'verification')) {
                            $typeIcon = $notificationTypeIcons['verification_update'];
                        } else {
                            $typeIcon = $notificationTypeIcons[$typeKey] ?? 'bi-bell';
                        }

                        if ($typeKey === 'job_update' || str_contains($title, 'job') || str_contains($message, 'job post')) {
                            $badgeLabel = 'JOB UPDATE';
                        } elseif ($typeKey === 'verification_update' || str_contains($title, 'verification') || str_contains($message, 'verification')) {
                            $badgeLabel = 'VERIFICATION UPDATE';
                        } else {
                            $badgeLabel = strtoupper(str_replace('_', ' ', $notification->type));
                        }
                    ?>
                    <div class="gmail-row <?php echo e($notification->is_read ? 'read' : 'unread'); ?>"
                        data-id="<?php echo e($notification->id); ?>"
                        data-title="<?php echo e(e($notification->title)); ?>"
                        data-message="<?php echo e(e($notification->message)); ?>"
                        data-icon="<?php echo e($typeIcon); ?>"
                        data-badge="<?php echo e(e($badgeLabel)); ?>">
                        <?php if($notification->is_read): ?>
                            <span class="read-dot" aria-hidden="true"></span>
                        <?php else: ?>
                            <span class="unread-dot" aria-hidden="true"></span>
                        <?php endif; ?>

                        <span class="gmail-type-icon" aria-hidden="true"><i class="bi <?php echo e($typeIcon); ?>"></i></span>
                        <div class="gmail-subject"><?php echo e($notification->title); ?></div>
                        <div class="gmail-message"><?php echo e($notification->message); ?></div>
                        <span class="gmail-time"><?php echo e(optional($notification->created_at)->diffForHumans() ?? 'Now'); ?></span>
                        <span class="gmail-badge"><?php echo e($badgeLabel); ?></span>

                        <?php if(! $notification->is_read): ?>
                            <div class="gmail-action">
                                <button type="button" class="gmail-view-btn" onclick="event.stopPropagation(); viewNotification(<?php echo e($notification->id); ?>, '<?php echo e(addslashes($notification->title)); ?>', '<?php echo e(addslashes($notification->message)); ?>', '<?php echo e($typeIcon); ?>', '<?php echo e(addslashes($badgeLabel)); ?>')">
                                    <i class="bi bi-eye"></i> View
                                </button>
                                <form style="display: inline;" method="POST" action="<?php echo e(route('employer.notifications.read', $notification)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>
                                    <button class="mark-read-btn" type="submit" onclick="event.stopPropagation()">Mark Read</button>
                                </form>
                            </div>
                        <?php else: ?>
                            <span class="gmail-read-tag"><i class="bi bi-check2-circle"></i>Read</span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="empty-mail">
                        <i class="bi bi-envelope-open"></i>
                        No notifications yet.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Notification Detail Modal -->
    <div id="notificationModal" class="notification-modal">
        <div class="notification-modal-content">
            <div class="notification-modal-header">
                <h3>Notification Details</h3>
                <button class="notification-modal-close" onclick="closeNotificationModal()">&times;</button>
            </div>
            <div class="notification-modal-body">
                <div class="notification-detail-section">
                    <div class="notification-detail-label">Subject</div>
                    <div class="notification-detail-value" id="modal-title"></div>
                </div>

                <div class="notification-detail-section">
                    <div class="notification-detail-label">Message</div>
                    <div class="notification-detail-value" id="modal-message"></div>
                </div>

                <div class="notification-detail-section">
                    <div class="notification-detail-label">Type</div>
                    <div id="modal-type" class="notification-badge"></div>
                </div>
            </div>
            <div class="notification-modal-footer">
                <button class="modal-btn modal-btn-close" onclick="closeNotificationModal()">Close</button>
            </div>
        </div>
    </div>

    <script>
        function viewNotification(id, title, message, icon, badgeLabel) {
            // Populate modal
            document.getElementById('modal-title').textContent = title;
            document.getElementById('modal-message').textContent = message;
            document.getElementById('modal-type').innerHTML = '<i class="bi ' + icon + ' me-2"></i>' + badgeLabel;

            // Show modal
            document.getElementById('notificationModal').classList.add('show');

            // Mark as read via fetch
            fetch('<?php echo e(url("/employer/notifications")); ?>/' + id + '/read', {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'Content-Type': 'application/json'
                }
            }).then(response => {
                if (response.ok) {
                    // Reload page to update UI
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                }
            }).catch(error => console.error('Error:', error));
        }

        // Make entire row clickable and open notification modal
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.gmail-row').forEach(function (row) {
                row.addEventListener('click', function (e) {
                    // If the click originated from a button or form control, ignore
                    const tag = e.target.tagName.toLowerCase();
                    if (tag === 'button' || tag === 'a' || e.target.closest('form')) return;

                    const id = row.dataset.id;
                    const title = row.dataset.title || '';
                    const message = row.dataset.message || '';
                    const icon = row.dataset.icon || 'bi-bell';
                    const badge = row.dataset.badge || '';

                    if (id) {
                        viewNotification(id, title, message, icon, badge);
                    }
                });
            });
        });

        function closeNotificationModal() {
            document.getElementById('notificationModal').classList.remove('show');
        }

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            const modal = document.getElementById('notificationModal');
            if (event.target === modal) {
                modal.classList.remove('show');
            }
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeNotificationModal();
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.employer.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\dashboard\employer\notifications.blade.php ENDPATH**/ ?>