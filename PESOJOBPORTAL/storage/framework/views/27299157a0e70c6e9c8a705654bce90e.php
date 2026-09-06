<?php $__env->startSection('title', 'Notifications | Jobseeker'); ?>

<?php $__env->startPush('styles'); ?>
<style>
	.notifications-page {
		background:
			radial-gradient(circle at top right, rgba(72, 121, 205, 0.1), transparent 45%),
			radial-gradient(circle at left bottom, rgba(43, 103, 177, 0.08), transparent 42%),
			#f3f7fd;
		border-radius: 16px;
		padding: 1rem;
	}

	.gmail-shell {
		border: 1px solid #d9e3f1;
		border-radius: 14px;
		overflow: hidden;
		background: #ffffff;
		box-shadow: 0 12px 24px rgba(17, 39, 76, 0.06);
	}

	.gmail-toolbar {
		display: flex;
		justify-content: space-between;
		align-items: center;
		gap: 1rem;
		padding: 1rem 1.1rem;
		background: linear-gradient(135deg, #075cb2 0%, #3498db 100%);
		border-bottom: 1px solid rgba(7, 92, 178, 0.35);
	}

	.gmail-toolbar-left {
		display: inline-flex;
		align-items: center;
		gap: 0.65rem;
	}

	.gmail-title {
		margin: 0;
		font-size: 1.12rem;
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
		gap: 0.45rem;
		border-radius: 999px;
		border: 1px solid rgba(255, 255, 255, 0.46);
		background: rgba(255, 255, 255, 0.14);
		color: #ffffff;
		font-size: 0.78rem;
		font-weight: 700;
		padding: 0.35rem 0.7rem;
		white-space: nowrap;
	}

	.gmail-meta.all {
		background: rgba(255, 255, 255, 0.2);
		border-color: rgba(255, 255, 255, 0.55);
		color: #ffffff;
	}

	.gmail-list-head {
		display: grid;
		grid-template-columns: auto auto minmax(160px, 1fr) minmax(240px, 1.8fr) auto auto auto;
		gap: 0.8rem;
		align-items: center;
		padding: 0.55rem 1rem;
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
		grid-template-columns: auto auto minmax(160px, 1fr) minmax(240px, 1.8fr) auto auto auto;
		align-items: center;
		gap: 0.8rem;
		padding: 0.8rem 1rem;
		border-bottom: 1px solid #ecf1f8;
		transition: background-color 0.16s ease, box-shadow 0.16s ease;
	}

	.gmail-row:hover {
		background: #f8fbff;
		box-shadow: inset 0 1px 0 rgba(56, 101, 179, 0.05), inset 0 -1px 0 rgba(56, 101, 179, 0.05);
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
		line-height: 1.35;
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
	}

	.gmail-message {
		min-width: 0;
		font-size: 0.9rem;
		color: #53657d;
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
		padding: 0.28rem 0.58rem;
		font-size: 0.72rem;
		font-weight: 700;
		letter-spacing: 0.02em;
		text-transform: uppercase;
		color: #315d95;
		background: #e9f2ff;
		border: 1px solid #cfe1fb;
		white-space: nowrap;
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

	.gmail-action {
		justify-self: end;
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
			padding: 0.85rem 0.8rem;
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
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="notifications-page" aria-label="Jobseeker notifications">
	<div class="gmail-shell">
		<div class="gmail-toolbar">
			<div class="gmail-toolbar-left">
				<h2 class="gmail-title"><i class="bi bi-envelope"></i>Inbox</h2>
			</div>
			<div class="gmail-toolbar-counts">
				<span class="gmail-meta all"><i class="bi bi-inboxes"></i><span id="notificationsTotalMeta" data-count="<?php echo e($notifications->count()); ?>"><?php echo e($notifications->count()); ?> total</span></span>
				<span class="gmail-meta"><i class="bi bi-circle-fill"></i><span id="notificationsUnreadMeta"><?php echo e($unreadCount); ?> unread</span></span>
				<span class="gmail-meta"><i class="bi bi-arrow-repeat"></i>Auto-refresh 5s</span>
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

		<div id="notificationsList" class="gmail-list" data-latest-id="<?php echo e($latestNotificationId); ?>">
			<?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
				<?php
					$isUnread = is_null($notification->read_at);
					$title = (string) data_get($notification, 'portalNotification.title', 'Notification');
					$message = (string) data_get($notification, 'portalNotification.message', '');
					$createdAt = data_get($notification, 'portalNotification.created_at');
					$isAdminRecommendation = str_starts_with($title, 'Job Recommendation:');
				?>
				<div class="gmail-row <?php echo e($isUnread ? 'unread' : 'read'); ?>" data-notification-id="<?php echo e($notification->id); ?>">
					<?php if($isUnread): ?>
						<span class="unread-dot" aria-hidden="true"></span>
					<?php else: ?>
						<span class="read-dot" aria-hidden="true"></span>
					<?php endif; ?>

					<span class="gmail-type-icon" aria-hidden="true"><i class="bi bi-bell"></i></span>
					<div class="gmail-subject"><?php echo e($title); ?></div>
					<div class="gmail-message"><?php echo e($message); ?></div>
					<span class="gmail-time"><?php echo e(optional($createdAt)->diffForHumans() ?? 'Now'); ?></span>
					<span class="gmail-badge"><?php echo e($isAdminRecommendation ? 'RECOMMEND' : 'PESO'); ?></span>

					<?php
						// Try to detect job id from portalNotification data (if stored)
						$portalData = data_get($notification, 'portalNotification.data', null);
						$linkedJobId = null;
						if (is_array($portalData) && array_key_exists('peso_job_id', $portalData)) {
							$linkedJobId = $portalData['peso_job_id'];
						}
					?>

					<?php if($isUnread): ?>
						<?php if($linkedJobId): ?>
							<a href="<?php echo e(route('jobseeker.apply-job', $linkedJobId)); ?>" class="mark-read-btn gmail-action">View Job</a>
						<?php else: ?>
							<button type="button" class="mark-read-btn gmail-action" data-mark-read data-id="<?php echo e($notification->id); ?>">Mark Read</button>
						<?php endif; ?>
					<?php else: ?>
						<span class="gmail-read-tag gmail-action"><i class="bi bi-check2-circle"></i>Read</span>
					<?php endif; ?>
				</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
				<div class="empty-mail" id="notificationsEmptyState">
					<i class="bi bi-envelope-open"></i>
					No notifications yet.
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
	(function () {
		const list = document.getElementById('notificationsList');
		const unreadMeta = document.getElementById('notificationsUnreadMeta');
		const totalMeta = document.getElementById('notificationsTotalMeta');
		const sidebarUnread = document.getElementById('notificationUnreadBadge');
		const csrfToken = '<?php echo e(csrf_token()); ?>';

		if (!list) {
			return;
		}

		let totalCount = Number(totalMeta?.dataset.count || 0);

		function updateUnreadCount(unreadCount) {
			if (unreadMeta) {
				unreadMeta.textContent = `${unreadCount} unread`;
			}

			if (sidebarUnread) {
				if (Number(unreadCount) > 0) {
					sidebarUnread.textContent = String(unreadCount);
					sidebarUnread.classList.remove('visually-hidden');
					sidebarUnread.removeAttribute('aria-hidden');
				} else {
					sidebarUnread.textContent = '';
					sidebarUnread.classList.add('visually-hidden');
					sidebarUnread.setAttribute('aria-hidden', 'true');
				}

				// Toggle recommend marker if there are any unread admin recommendation rows.
				const unreadRecommendExists = Array.from(document.querySelectorAll('.gmail-row.unread .gmail-badge'))
					.some(el => (el.textContent || '').trim() === 'RECOMMEND');

				if (unreadRecommendExists) {
					sidebarUnread.classList.add('recommend');
				} else {
					sidebarUnread.classList.remove('recommend');
				}
			}
		}

		function updateTotalCount(count) {
			totalCount = count;

			if (totalMeta) {
				totalMeta.dataset.count = String(count);
				totalMeta.textContent = `${count} total`;
			}
		}

		function escapeHtml(value) {
			return String(value ?? '')
				.replaceAll('&', '&amp;')
				.replaceAll('<', '&lt;')
				.replaceAll('>', '&gt;')
				.replaceAll('"', '&quot;')
				.replaceAll("'", '&#039;');
		}

		function markRead(id, button) {
			fetch(`<?php echo e(url('/jobseeker/notifications')); ?>/${id}/read`, {
				method: 'POST',
				headers: {
					'X-CSRF-TOKEN': csrfToken,
					'X-Requested-With': 'XMLHttpRequest',
					'Accept': 'application/json',
				},
			})
				.then(response => response.json())
				.then(data => {
					const row = list.querySelector(`[data-notification-id="${id}"]`);

					if (row) {
						row.classList.remove('unread');
						row.classList.add('read');

						const dot = row.querySelector('.unread-dot');
						if (dot) {
							dot.className = 'read-dot';
						}
					}

					if (button) {
						const readTag = document.createElement('span');
						readTag.className = 'gmail-read-tag gmail-action';
						readTag.innerHTML = '<i class="bi bi-check2-circle"></i>Read';
						button.replaceWith(readTag);
					}

					updateUnreadCount(data.unread_count ?? 0);
				})
				.catch(() => {
					// Keep current state on transient errors.
				});
		}

		function bindReadButtons(scope = document) {
			scope.querySelectorAll('[data-mark-read]').forEach(button => {
				if (button.dataset.bound === '1') {
					return;
				}

				button.dataset.bound = '1';
				button.addEventListener('click', function () {
					markRead(this.dataset.id, this);
				});
			});
		}

		function renderNotification(item) {
			const row = document.createElement('div');
			row.className = 'gmail-row unread';
			row.setAttribute('data-notification-id', item.id);

			const badgeText = (item.title || '').startsWith('Job Recommendation:') ? 'RECOMMEND' : 'PESO';

			row.innerHTML = `
					<span class="unread-dot" aria-hidden="true"></span>
					<span class="gmail-type-icon" aria-hidden="true"><i class="bi bi-bell"></i></span>
					<div class="gmail-subject">${escapeHtml(item.title || 'Notification')}</div>
					<div class="gmail-message">${escapeHtml(item.message || '')}</div>
					<span class="gmail-time">Just now</span>
					<span class="gmail-badge">${escapeHtml(badgeText)}</span>
					<button type="button" class="mark-read-btn gmail-action" data-mark-read data-id="${item.id}">Mark Read</button>
				`;

			return row;
		}

		function pollNotifications() {
			const afterId = Number(list.dataset.latestId || 0);

			fetch(`<?php echo e(route('jobseeker.notifications.feed')); ?>?after_id=${afterId}`, {
				headers: {
					'X-Requested-With': 'XMLHttpRequest',
					'Accept': 'application/json',
				},
			})
				.then(response => response.json())
				.then(data => {
					const items = Array.isArray(data.items) ? data.items : [];

					if (items.length > 0) {
						const emptyState = document.getElementById('notificationsEmptyState');

						if (emptyState) {
							emptyState.remove();
						}

						items.slice().reverse().forEach(item => {
							const notificationNode = renderNotification(item);
							list.prepend(notificationNode);
							bindReadButtons(notificationNode);
						});

						// If any of the new items are admin recommendations, mark sidebar badge.
						if (items.some(i => (i.title || '').startsWith('Job Recommendation:'))) {
							if (sidebarUnread) sidebarUnread.classList.add('recommend');
						}

						updateTotalCount(totalCount + items.length);
					}

					list.dataset.latestId = String(data.latest_id ?? afterId);
					updateUnreadCount(data.unread_count ?? 0);
				})
				.catch(() => {
					// Keep polling on transient failures.
				});
		}

		bindReadButtons(list);
		setInterval(pollNotifications, 5000);
	})();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\dashboard\jobseeker\notifications.blade.php ENDPATH**/ ?>