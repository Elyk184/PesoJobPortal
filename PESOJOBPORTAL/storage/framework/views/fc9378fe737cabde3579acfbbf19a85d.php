<?php $__env->startSection('title', 'Best Fit | Jobseeker'); ?>

<?php $__env->startSection('content'); ?>
<section aria-label="Job recommendations">

	<div class="dashboard-section-card p-3 p-lg-4 mb-4">
		<div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
			<div>
				<h2 class="h4 mb-1 fw-bold">Your Best Fit Job Opportunities</h2>
				<p class="mb-0 text-muted">Jobs matched to your profile and personally picked by the admin for you.</p>
			</div>
			<a href="<?php echo e(route('jobseeker.profile')); ?>" class="btn btn-primary px-3 shadow-sm">
				<i class="bi bi-person-gear me-2"></i>Update Profile Skills
			</a>
		</div>
	</div>

	<div class="row g-3 mb-4">
		<div class="col-12 col-md-4">
			<div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
				<div class="dashboard-stat-icon"><i class="bi bi-stars"></i></div>
				<div>
					<div class="dashboard-stat-number"><?php echo e($recommendedCount); ?></div>
					<div class="dashboard-stat-label">Best Fit Matches</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-4">
			<div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
				<div class="dashboard-stat-icon" style="background: rgba(45, 107, 224, 0.12); color: #2d6be0;"><i class="bi bi-briefcase"></i></div>
				<div>
					<div class="dashboard-stat-number"><?php echo e($activeJobsCount); ?></div>
					<div class="dashboard-stat-label">Active Job Posts</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-4">
			<div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
				<div class="dashboard-stat-icon" style="background: rgba(47, 157, 98, 0.12); color: var(--dash-success);"><i class="bi bi-send"></i></div>
				<div>
					<div class="dashboard-stat-number"><?php echo e($appliedJobsCount); ?></div>
					<div class="dashboard-stat-label">Applications Sent</div>
				</div>
			</div>
		</div>
	</div>

	<?php if(! $profileHasSkills): ?>
		<div class="dashboard-section-card p-3 p-lg-4 mb-4" style="border-left: 4px solid var(--dash-warning);">
			<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
				<div>
					<h3 class="h6 fw-bold mb-1 text-dark">Add your skills to unlock better recommendations</h3>
					<p class="mb-0 text-muted">No profile skill data found yet. Add your skills, training, or preferred occupations so the matching engine can suggest the best jobs for you.</p>
				</div>
				<a href="<?php echo e(route('jobseeker.profile')); ?>" class="btn btn-outline-primary">Go to Profile</a>
			</div>
		</div>
	<?php endif; ?>

	<div class="dashboard-section-card p-3 p-lg-4">
		<div class="d-flex align-items-center justify-content-between gap-3 mb-3 border-bottom pb-3">
			<h3 class="h5 mb-0 fw-bold"><i class="bi bi-lightning-charge me-2"></i>Profile-Matched Jobs</h3>
			<a href="<?php echo e(route('jobseeker.browse-jobs')); ?>" class="btn btn-sm btn-outline-primary">Browse All Jobs</a>
		</div>

		<?php if($recommendations->isEmpty() && $adminRecommendations->isEmpty()): ?>
			<div class="dashboard-empty-state">
				<div>
					<div class="fs-1 mb-2">✦</div>
					<div class="fw-semibold text-secondary">No best fit jobs found yet.</div>
					<div class="small">Try updating your skills and preferred occupation, then check again.</div>
				</div>
			</div>
		<?php else: ?>
			<?php if($recommendations->isNotEmpty()): ?>
				<div class="row g-3">
					<?php $__currentLoopData = $recommendations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php
							$job = data_get($item, 'job');
							$score = (int) data_get($item, 'score', 0);
							$badgeClass = $score >= 80 ? 'success' : ($score >= 60 ? 'primary' : 'warning');
						?>

						<?php if($job): ?>
						<div class="col-12 col-xl-6">
							<article class="dashboard-stat-card p-3 h-100 d-flex flex-column gap-3">
								<div class="d-flex flex-wrap align-items-start justify-content-between gap-2">
									<div>
										<h4 class="h6 mb-1 fw-bold text-dark"><?php echo e($job->title); ?></h4>
										<div class="small text-muted">
											<i class="bi bi-building me-1"></i><?php echo e($job->employer_name); ?>

											<span class="mx-1">|</span>
											<i class="bi bi-geo-alt me-1"></i><?php echo e($job->location); ?>

										</div>
									</div>
									<span class="badge text-bg-<?php echo e($badgeClass); ?>"><?php echo e($score); ?>% Match</span>
								</div>

								<?php if(! empty($job->salary_range)): ?>
									<div class="small text-secondary">
										<i class="bi bi-cash-stack me-1"></i><?php echo e($job->salary_range); ?>

									</div>
								<?php endif; ?>

								<p class="mb-0 small text-muted"><?php echo e(\Illuminate\Support\Str::limit($job->description, 150)); ?></p>

								<?php if(! empty(data_get($item, 'matched_skills'))): ?>
									<div class="d-flex flex-wrap gap-2">
										<?php $__currentLoopData = data_get($item, 'matched_skills', []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<span class="badge rounded-pill text-bg-light border"><?php echo e($skill); ?></span>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</div>
								<?php endif; ?>

								<?php if(! empty(data_get($item, 'reasons'))): ?>
									<ul class="small text-muted mb-0 ps-3">
										<?php $__currentLoopData = data_get($item, 'reasons', []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reason): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<li><?php echo e($reason); ?></li>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</ul>
								<?php endif; ?>

								<div class="mt-auto">
									<a href="<?php echo e(route('jobseeker.apply-job', $job->id)); ?>" class="btn btn-sm btn-primary">
										<i class="bi bi-send me-1"></i>Apply Now
									</a>
								</div>
							</article>
						</div>
						<?php endif; ?>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</div>
			<?php endif; ?>

			<?php if($adminRecommendations->isNotEmpty()): ?>
				<div class="<?php echo e($recommendations->isNotEmpty() ? 'mt-4 pt-4 border-top' : ''); ?>">
					<div class="d-flex align-items-center justify-content-between gap-3 mb-3">
						<h3 class="h5 mb-0 fw-bold"><i class="bi bi-megaphone me-2"></i>Picked for You by Admin</h3>
						<a href="<?php echo e(route('jobseeker.notifications')); ?>" class="btn btn-sm btn-outline-primary">View Notifications</a>
					</div>
					<div class="row g-3">
						<?php $__currentLoopData = $adminRecommendations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<div class="col-12 col-xl-6">
								<article class="dashboard-stat-card p-3 h-100 d-flex flex-column gap-2 border-start border-4" style="border-color: #2d6be0;">
									<div class="d-flex align-items-start justify-content-between gap-2">
										<div>
											<h4 class="h6 mb-1 fw-bold text-dark"><?php echo e($rec['job_title'] ?: $rec['title']); ?></h4>
											<?php if($rec['job']): ?>
												<div class="small text-muted">
													<i class="bi bi-building me-1"></i><?php echo e($rec['job']->employer_name); ?>

													<span class="mx-1">|</span>
													<i class="bi bi-geo-alt me-1"></i><?php echo e($rec['job']->location); ?>

												</div>
											<?php else: ?>
												<div class="small text-muted">Recommended by admin</div>
											<?php endif; ?>
										</div>
										<span class="badge text-bg-info">Admin Pick</span>
									</div>

									<?php if($rec['job'] && $rec['job']->salary_range): ?>
										<div class="small text-secondary">
											<i class="bi bi-cash-stack me-1"></i><?php echo e($rec['job']->salary_range); ?>

										</div>
									<?php endif; ?>

									<p class="mb-0 small text-muted"><?php echo e($rec['message']); ?></p>

									<?php if($rec['job']): ?>
										<p class="mb-0 small text-muted"><?php echo e(\Illuminate\Support\Str::limit($rec['job']->description, 120)); ?></p>
									<?php endif; ?>

									<div class="small text-secondary"><?php echo e(optional($rec['created_at'])->format('M d, Y h:i A')); ?></div>

									<?php if($rec['job']): ?>
										<div class="mt-auto d-flex gap-2">
											<?php if($rec['already_applied']): ?>
												<span class="btn btn-sm btn-success disabled">
													<i class="bi bi-check-circle me-1"></i>Applied
												</span>
												<a href="<?php echo e(route('jobseeker.applications')); ?>" class="btn btn-sm btn-outline-secondary">
													<i class="bi bi-eye me-1"></i>View Application
												</a>
											<?php else: ?>
												<a href="<?php echo e(route('jobseeker.apply-job', $rec['job']->id)); ?>" class="btn btn-sm btn-primary">
													<i class="bi bi-send me-1"></i>Apply Now
												</a>
											<?php endif; ?>
										</div>
									<?php endif; ?>
								</article>
							</div>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	</div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views/dashboard/jobseeker/recommendations.blade.php ENDPATH**/ ?>