@extends('layouts.dashboard')

@section('title', 'Jobseeker | Link Job Resource Portal')

@section('content')
<section aria-label="Jobseeker notifications">
	<div class="dashboard-topbar">
		<div>
			<div class="dashboard-topbar-title">Notifications</div>
			<div class="dashboard-topbar-subtitle">Updates from PESO Manolo Fortich</div>
		</div>
		<div class="text-end">
			<span class="badge text-bg-primary" id="notificationUnreadBadge">{{ $unreadCount }} unread</span>
		</div>
	</div>

	<div class="dashboard-section-card p-3 p-lg-4">
		<div class="d-flex align-items-center justify-content-between gap-3 mb-3 border-bottom pb-3">
			<h3 class="h5 mb-0 fw-bold"><i class="bi bi-bell me-2"></i>Recent Notifications</h3>
			<small class="text-muted">Auto-refresh every 5 seconds</small>
		</div>

		<div id="notificationsList" class="d-flex flex-column gap-3" data-latest-id="{{ $latestNotificationId }}">
			@forelse ($notifications as $notification)
				@php
					$isUnread = is_null($notification->read_at);
				@endphp
				<article
					class="border rounded p-3 {{ $isUnread ? 'border-primary bg-primary-subtle' : 'bg-white' }}"
					data-notification-id="{{ $notification->id }}"
				>
					<div class="d-flex align-items-start justify-content-between gap-2">
						<div>
							<div class="fw-semibold mb-1">{{ $notification->portalNotification?->title ?? 'Notification' }}</div>
							<p class="mb-2 text-muted">{{ $notification->portalNotification?->message }}</p>
							<div class="small text-secondary">{{ $notification->portalNotification?->created_at?->diffForHumans() }}</div>
						</div>
						@if ($isUnread)
							<button
								type="button"
								class="btn btn-sm btn-outline-primary"
								data-mark-read
								data-id="{{ $notification->id }}"
							>
								Mark as read
							</button>
						@else
							<span class="badge text-bg-light border">Read</span>
						@endif
					</div>
				</article>
			@empty
				<div class="dashboard-empty-state border rounded p-4" id="notificationsEmptyState">
					<div>
						<div class="fs-1 mb-2"><i class="bi bi-bell"></i></div>
						<div class="fw-semibold text-secondary">No notifications yet.</div>
						<div class="small">Admin announcements will appear here.</div>
					</div>
				</div>
			@endforelse
		</div>
	</div>
</section>
@endsection

@push('scripts')
<script>
	(function () {
		const list = document.getElementById('notificationsList');
		const unreadBadge = document.getElementById('notificationUnreadBadge');
		const csrfToken = '{{ csrf_token() }}';

		if (!list || !unreadBadge) {
			return;
		}

		function updateUnreadCount(unreadCount) {
			unreadBadge.textContent = `${unreadCount} unread`;
		}

		function markRead(id, button) {
			fetch(`{{ url('/jobseeker/notifications') }}/${id}/read`, {
				method: 'POST',
				headers: {
					'X-CSRF-TOKEN': csrfToken,
					'X-Requested-With': 'XMLHttpRequest',
					'Accept': 'application/json',
				},
			})
				.then(response => response.json())
				.then(data => {
					const card = list.querySelector(`[data-notification-id="${id}"]`);

					if (card) {
						card.classList.remove('border-primary', 'bg-primary-subtle');
						card.classList.add('bg-white');
					}

					if (button) {
						const readBadge = document.createElement('span');
						readBadge.className = 'badge text-bg-light border';
						readBadge.textContent = 'Read';
						button.replaceWith(readBadge);
					}

					updateUnreadCount(data.unread_count ?? 0);
				})
				.catch(() => {
					// Ignore network errors; next poll will retry.
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

		function escapeHtml(value) {
			return value
				.replaceAll('&', '&amp;')
				.replaceAll('<', '&lt;')
				.replaceAll('>', '&gt;')
				.replaceAll('"', '&quot;')
				.replaceAll("'", '&#039;');
		}

		function renderNotification(item) {
			const article = document.createElement('article');
			article.className = 'border rounded p-3 border-primary bg-primary-subtle';
			article.setAttribute('data-notification-id', item.id);

			article.innerHTML = `
				<div class="d-flex align-items-start justify-content-between gap-2">
					<div>
						<div class="fw-semibold mb-1">${escapeHtml(item.title || 'Notification')}</div>
						<p class="mb-2 text-muted">${escapeHtml(item.message || '')}</p>
						<div class="small text-secondary">Just now</div>
					</div>
					<button
						type="button"
						class="btn btn-sm btn-outline-primary"
						data-mark-read
						data-id="${item.id}"
					>
						Mark as read
					</button>
				</div>
			`;

			return article;
		}

		function pollNotifications() {
			const afterId = Number(list.dataset.latestId || 0);

			fetch(`{{ route('jobseeker.notifications.feed') }}?after_id=${afterId}`, {
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
@endpush
