@extends('layouts.dashboard')

@section('title', 'PESO Clearance | Jobseeker')

@section('content')
<section aria-label="PESO Clearance">
	<div class="dashboard-topbar">
		<div>
			<div class="dashboard-topbar-title">PESO Clearance</div>
			<div class="dashboard-topbar-subtitle">View or request your PESO clearance certificate</div>
		</div>
		<div class="d-none d-md-block text-end">
			<div class="fw-semibold text-secondary">{{ auth()->user()->name ?? 'Jobseeker' }}</div>
			<div class="dashboard-topbar-subtitle">Manolo Fortich PESO</div>
		</div>
	</div>

	<div class="row g-3 mb-4">
		<div class="col-12 col-md-4">
			<div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
				<div class="dashboard-stat-icon"><i class="bi bi-file-earmark-text"></i></div>
				<div>
					<div class="dashboard-stat-number">{{ $hasClearance ? '1' : '0' }}</div>
					<div class="dashboard-stat-label">Clearance(s)</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-4">
			<div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
				<div class="dashboard-stat-icon" style="background: rgba(47, 157, 98, 0.12); color: var(--dash-success);">
					<i class="bi bi-check-circle"></i>
				</div>
				<div>
					<div class="dashboard-stat-number">{{ $isActive ? 'Active' : 'Inactive' }}</div>
					<div class="dashboard-stat-label">Status</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-4">
			<div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
				<div class="dashboard-stat-icon" style="background: rgba(45, 107, 224, 0.12); color: #2d6be0;">
					<i class="bi bi-calendar-check"></i>
				</div>
				<div>
					<div class="dashboard-stat-number">{{ $hasClearance && $clearance->expiry_date ? $clearance->expiry_date->format('M d, Y') : 'N/A' }}</div>
					<div class="dashboard-stat-label">Validity</div>
				</div>
			</div>
		</div>
	</div>

	<div class="dashboard-section-card p-3 p-lg-4 mb-4">
		@if ($hasClearance)
			<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
				<div>
					<h2 class="h4 mb-1 fw-bold">Your PESO Clearance</h2>
					<p class="mb-0 text-muted">Details of your current clearance certificate.</p>
				</div>
			</div>

			<div class="mt-4">
				<div class="card border-0 shadow-sm">
					<div class="card-body p-4">
						<div class="row g-4">
							<div class="col-12 col-md-6">
								<div class="small text-muted mb-1">Clearance Number</div>
								<div class="fw-bold fs-5">{{ $clearance->clearance_number }}</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="small text-muted mb-1">Status</div>
								<div>
									@if ($isActive)
										<span class="badge text-bg-success">Active</span>
									@elseif ($isExpired)
										<span class="badge text-bg-danger">Expired</span>
									@else
										<span class="badge text-bg-secondary">{{ ucfirst($clearance->status) }}</span>
									@endif
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="small text-muted mb-1">Issue Date</div>
								<div class="fw-semibold">{{ $clearance->issue_date ? $clearance->issue_date->format('F d, Y') : 'N/A' }}</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="small text-muted mb-1">Expiry Date</div>
								<div class="fw-semibold">{{ $clearance->expiry_date ? $clearance->expiry_date->format('F d, Y') : 'N/A' }}</div>
							</div>
							@if ($clearance->remarks)
								<div class="col-12">
									<div class="small text-muted mb-1">Remarks</div>
									<div class="fw-semibold">{{ $clearance->remarks }}</div>
								</div>
							@endif
						</div>
					</div>
				</div>
			</div>
		@else
			<div class="dashboard-empty-state" style="min-height: 240px;">
				<div>
					<div class="fs-1 mb-2">📄</div>
					<div class="fw-semibold text-secondary mb-1">No PESO Clearance found</div>
					<div class="small text-muted mb-3">You do not have a PESO clearance certificate on record.</div>
					<div class="small text-muted">Visit your local PESO office to apply for a clearance certificate.</div>
				</div>
			</div>
		@endif
	</div>
</section>
@endsection

