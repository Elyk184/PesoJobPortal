@extends('layouts.dashboard')

@section('title', 'Best Fit | Jobseeker')

@section('content')
<section aria-label="Job recommendations">

	<div class="dashboard-section-card p-3 p-lg-4 mb-4">
		<div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
			<div>
				<h2 class="h4 mb-1 fw-bold">Your Best Fit Job Opportunities</h2>
				<p class="mb-0 text-muted">Jobs matched to your profile and personally picked by the admin for you.</p>
			</div>
			<a href="{{ route('jobseeker.profile') }}" class="btn btn-primary px-3 shadow-sm">
				<i class="bi bi-person-gear me-2"></i>Update Profile Skills
			</a>
		</div>
	</div>

	<div class="row g-3 mb-4">
		<div class="col-12 col-md-4">
			<div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
				<div class="dashboard-stat-icon"><i class="bi bi-stars"></i></div>
				<div>
					<div class="dashboard-stat-number">{{ $recommendedCount }}</div>
					<div class="dashboard-stat-label">Best Fit Matches</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-4">
			<div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
				<div class="dashboard-stat-icon" style="background: rgba(45, 107, 224, 0.12); color: #2d6be0;"><i class="bi bi-briefcase"></i></div>
				<div>
					<div class="dashboard-stat-number">{{ $activeJobsCount }}</div>
					<div class="dashboard-stat-label">Active Job Posts</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-4">
			<div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
				<div class="dashboard-stat-icon" style="background: rgba(47, 157, 98, 0.12); color: var(--dash-success);"><i class="bi bi-send"></i></div>
				<div>
					<div class="dashboard-stat-number">{{ $appliedJobsCount }}</div>
					<div class="dashboard-stat-label">Applications Sent</div>
				</div>
			</div>
		</div>
	</div>

	@if (! $profileHasSkills)
		<div class="dashboard-section-card p-3 p-lg-4 mb-4" style="border-left: 4px solid var(--dash-warning);">
			<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
				<div>
					<h3 class="h6 fw-bold mb-1 text-dark">Add your skills to unlock better recommendations</h3>
					<p class="mb-0 text-muted">No profile skill data found yet. Add your skills, training, or preferred occupations so the matching engine can suggest the best jobs for you.</p>
				</div>
				<a href="{{ route('jobseeker.profile') }}" class="btn btn-outline-primary">Go to Profile</a>
			</div>
		</div>
	@endif

	<div class="dashboard-section-card p-3 p-lg-4">
		<div class="d-flex align-items-center justify-content-between gap-3 mb-3 border-bottom pb-3">
			<h3 class="h5 mb-0 fw-bold"><i class="bi bi-lightning-charge me-2"></i>Profile-Matched Jobs</h3>
			<a href="{{ route('jobseeker.browse-jobs') }}" class="btn btn-sm btn-outline-primary">Browse All Jobs</a>
		</div>

		@if ($recommendations->isEmpty() && $adminRecommendations->isEmpty())
			<div class="dashboard-empty-state">
				<div>
					<div class="fs-1 mb-2">✦</div>
					<div class="fw-semibold text-secondary">No best fit jobs found yet.</div>
					<div class="small">Try updating your skills and preferred occupation, then check again.</div>
				</div>
			</div>
		@else
			@if ($recommendations->isNotEmpty())
				<div class="row g-3">
					@foreach ($recommendations as $item)
						@php
							$job = data_get($item, 'job');
							$score = (int) data_get($item, 'score', 0);
							$badgeClass = $score >= 80 ? 'success' : ($score >= 60 ? 'primary' : 'warning');
						@endphp

						@if ($job)
						<div class="col-12 col-xl-6">
							<article class="dashboard-stat-card p-3 h-100 d-flex flex-column gap-3">
								<div class="d-flex flex-wrap align-items-start justify-content-between gap-2">
									<div>
										<h4 class="h6 mb-1 fw-bold text-dark">{{ $job->title }}</h4>
										<div class="small text-muted">
											<i class="bi bi-building me-1"></i>{{ $job->employer_name }}
											<span class="mx-1">|</span>
											<i class="bi bi-geo-alt me-1"></i>{{ $job->location }}
										</div>
									</div>
									<span class="badge text-bg-{{ $badgeClass }}">{{ $score }}% Match</span>
								</div>

								@if (! empty($job->salary_range))
									<div class="small text-secondary">
										<i class="bi bi-cash-stack me-1"></i>{{ $job->salary_range }}
									</div>
								@endif

								<p class="mb-0 small text-muted">{{ \Illuminate\Support\Str::limit($job->description, 150) }}</p>

								@if (! empty(data_get($item, 'matched_skills')))
									<div class="d-flex flex-wrap gap-2">
										@foreach (data_get($item, 'matched_skills', []) as $skill)
											<span class="badge rounded-pill text-bg-light border">{{ $skill }}</span>
										@endforeach
									</div>
								@endif

								@if (! empty(data_get($item, 'reasons')))
									<ul class="small text-muted mb-0 ps-3">
										@foreach (data_get($item, 'reasons', []) as $reason)
											<li>{{ $reason }}</li>
										@endforeach
									</ul>
								@endif

								<div class="mt-auto">
									<a href="{{ route('jobseeker.apply-job', $job->id) }}" class="btn btn-sm btn-primary">
										<i class="bi bi-send me-1"></i>Apply Now
									</a>
								</div>
							</article>
						</div>
						@endif
					@endforeach
				</div>
			@endif

			@if ($adminRecommendations->isNotEmpty())
				<div class="{{ $recommendations->isNotEmpty() ? 'mt-4 pt-4 border-top' : '' }}">
					<div class="d-flex align-items-center justify-content-between gap-3 mb-3">
						<h3 class="h5 mb-0 fw-bold"><i class="bi bi-megaphone me-2"></i>Picked for You by Admin</h3>
						<a href="{{ route('jobseeker.notifications') }}" class="btn btn-sm btn-outline-primary">View Notifications</a>
					</div>
					<div class="row g-3">
						@foreach ($adminRecommendations as $rec)
							<div class="col-12 col-xl-6">
								<article class="dashboard-stat-card p-3 h-100 d-flex flex-column gap-2 border-start border-4" style="border-color: #2d6be0;">
									<div class="d-flex align-items-start justify-content-between gap-2">
										<div>
											<h4 class="h6 mb-1 fw-bold text-dark">{{ $rec['job_title'] ?: $rec['title'] }}</h4>
											@if ($rec['job'])
												<div class="small text-muted">
													<i class="bi bi-building me-1"></i>{{ $rec['job']->employer_name }}
													<span class="mx-1">|</span>
													<i class="bi bi-geo-alt me-1"></i>{{ $rec['job']->location }}
												</div>
											@else
												<div class="small text-muted">Recommended by admin</div>
											@endif
										</div>
										<span class="badge text-bg-info">Admin Pick</span>
									</div>

									@if ($rec['job'] && $rec['job']->salary_range)
										<div class="small text-secondary">
											<i class="bi bi-cash-stack me-1"></i>{{ $rec['job']->salary_range }}
										</div>
									@endif

									<p class="mb-0 small text-muted">{{ $rec['message'] }}</p>

									@if ($rec['job'])
										<p class="mb-0 small text-muted">{{ \Illuminate\Support\Str::limit($rec['job']->description, 120) }}</p>
									@endif

									<div class="small text-secondary">{{ optional($rec['created_at'])->format('M d, Y h:i A') }}</div>

									@if ($rec['job'])
										<div class="mt-auto d-flex gap-2">
											@if ($rec['already_applied'])
												<span class="btn btn-sm btn-success disabled">
													<i class="bi bi-check-circle me-1"></i>Applied
												</span>
												<a href="{{ route('jobseeker.applications') }}" class="btn btn-sm btn-outline-secondary">
													<i class="bi bi-eye me-1"></i>View Application
												</a>
											@else
												<a href="{{ route('jobseeker.apply-job', $rec['job']->id) }}" class="btn btn-sm btn-primary">
													<i class="bi bi-send me-1"></i>Apply Now
												</a>
											@endif
										</div>
									@endif
								</article>
							</div>
						@endforeach
					</div>
				</div>
			@endif
		@endif
	</div>
</section>
@endsection
