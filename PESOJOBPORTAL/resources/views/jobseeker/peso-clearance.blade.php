@extends('layouts.dashboard')

@section('title', 'PESO Clearance | Jobseeker')

@push('styles')
<style>
	.clearance-hero {
		border-radius: 18px;
		border: 1px solid #d8e3f2;
		background: linear-gradient(125deg, #102f55 0%, #1f4b84 55%, #2b63a9 100%);
		color: #f4f8ff;
		padding: 1.25rem;
		box-shadow: 0 14px 28px rgba(21, 49, 84, 0.2);
	}

	.clearance-kicker {
		font-size: 0.72rem;
		letter-spacing: 0.08em;
		text-transform: uppercase;
		font-weight: 700;
		color: #c9dcf6;
		margin-bottom: 0.35rem;
	}

	.clearance-title {
		font-size: clamp(1.25rem, 2.2vw, 1.75rem);
		line-height: 1.2;
		@extends('layouts.dashboard')

		@section('title', 'PESO Clearance | Jobseeker')

		@push('styles')
		<style>
			.clearance-shell {
				display: grid;
				gap: 1rem;
			}

			.clearance-hero {
				border-radius: 18px;
				border: 1px solid #d8e3f2;
				background: linear-gradient(125deg, #102f55 0%, #1f4b84 55%, #2b63a9 100%);
				color: #f4f8ff;
				padding: 1.25rem;
				box-shadow: 0 14px 28px rgba(21, 49, 84, 0.2);
			}

			.clearance-kicker {
				font-size: 0.72rem;
				letter-spacing: 0.08em;
				text-transform: uppercase;
				font-weight: 700;
				color: #c9dcf6;
				margin-bottom: 0.35rem;
			}

			.clearance-title {
				font-size: clamp(1.25rem, 2.2vw, 1.75rem);
				line-height: 1.2;
				font-weight: 800;
				margin-bottom: 0.35rem;
			}

			.clearance-subtitle {
				margin-bottom: 0;
				color: #dbe9fb;
			}

			.clearance-chip {
				display: inline-flex;
				align-items: center;
				gap: 0.35rem;
				border-radius: 999px;
				padding: 0.36rem 0.7rem;
				background: rgba(255, 255, 255, 0.14);
				border: 1px solid rgba(255, 255, 255, 0.22);
				color: #f5f9ff;
				font-size: 0.8rem;
				font-weight: 600;
			}

			.clearance-metric {
				border: 1px solid #dde8f4;
				border-radius: 14px;
				background: linear-gradient(180deg, #ffffff 0%, #f7faff 100%);
				transition: transform 0.18s ease, box-shadow 0.18s ease;
			}

			.clearance-metric:hover {
				transform: translateY(-2px);
				box-shadow: 0 10px 18px rgba(20, 49, 86, 0.1);
			}

			.clearance-panel {
				border: 1px solid #dce7f5;
				border-radius: 14px;
				background: #ffffff;
			}

			.clearance-item {
				padding: 0.85rem 1rem;
				border: 1px solid #e8eef7;
				border-radius: 12px;
				background: #f9fbff;
			}

			.clearance-empty {
				min-height: 260px;
				border: 1px dashed #cfdff3;
				border-radius: 16px;
				background: linear-gradient(180deg, #fbfdff 0%, #f3f8ff 100%);
			}

			.clearance-request-card {
				border: 1px solid #dce7f5;
				border-radius: 16px;
				background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
				overflow: hidden;
			}

			.clearance-request-header {
				padding: 1.25rem 1.25rem 0;
			}

			.clearance-request-body {
				padding: 1.25rem;
			}

			.clearance-upload-card {
				border: 1px solid #e5edf7;
				border-radius: 14px;
				background: linear-gradient(180deg, #ffffff 0%, #fafdff 100%);
				padding: 1rem;
			}

			.clearance-upload-label {
				font-size: 0.92rem;
				font-weight: 700;
				color: #183153;
				margin-bottom: 0.5rem;
			}

			.clearance-upload-help {
				font-size: 0.82rem;
				color: #6b7d93;
				margin-top: 0.4rem;
			}

			.clearance-note {
				border: 1px solid #d9e7fb;
				background: #eff6ff;
				color: #1e3a8a;
				border-radius: 12px;
				padding: 0.9rem 1rem;
			}

			.clearance-check {
				padding: 0.9rem 1rem;
				border: 1px solid #e5edf7;
				border-radius: 12px;
				background: #fff;
			}

			.clearance-cta {
				border-radius: 10px;
				font-weight: 700;
			}

			@media (max-width: 767.98px) {
				.clearance-hero {
					padding: 1rem;
				}
			}
		</style>
		@endpush

		@section('content')
		<section aria-label="PESO Clearance">
			<div class="clearance-shell">
				<div class="clearance-hero">
					<div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
						<div>
							<div class="clearance-kicker">Verification Center</div>
							<h1 class="clearance-title">PESO Clearance</h1>
							<p class="clearance-subtitle">View your clearance details or submit a request for admin processing.</p>
						</div>
						<div class="d-flex flex-wrap align-items-center justify-content-lg-end gap-2">
							<span class="clearance-chip"><i class="bi bi-person"></i>{{ auth()->user()->name ?? 'Jobseeker' }}</span>
							<span class="clearance-chip"><i class="bi bi-building"></i>Manolo Fortich PESO</span>
							@if ($canRequestClearance)
								<a href="#request-clearance" class="clearance-chip text-decoration-none">
									<i class="bi bi-send"></i>Request Clearance
								</a>
							@else
								<span class="clearance-chip">
									<i class="bi bi-info-circle"></i>Request Unavailable
								</span>
							@endif
						</div>
					</div>
				</div>

				<div class="row g-3">
					<div class="col-12 col-md-4">
						<div class="dashboard-stat-card clearance-metric p-3 d-flex align-items-center gap-3 h-100">
							<div class="dashboard-stat-icon"><i class="bi bi-file-earmark-text"></i></div>
							<div>
								<div class="dashboard-stat-number">{{ $hasClearance ? '1' : ($hasPendingRequest ? '1' : '0') }}</div>
								<div class="dashboard-stat-label">Clearance(s)</div>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-4">
						<div class="dashboard-stat-card clearance-metric p-3 d-flex align-items-center gap-3 h-100">
							<div class="dashboard-stat-icon" style="background: rgba(47, 157, 98, 0.12); color: var(--dash-success);">
								<i class="bi bi-check-circle"></i>
							</div>
							<div>
								<div class="dashboard-stat-number">{{ $hasPendingRequest ? 'Pending' : ($isActive ? 'Active' : 'Inactive') }}</div>
								<div class="dashboard-stat-label">Status</div>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-4">
						<div class="dashboard-stat-card clearance-metric p-3 d-flex align-items-center gap-3 h-100">
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

				<div class="dashboard-section-card p-3 p-lg-4">
					@if ($errors->any())
						<div class="alert alert-danger border-0 shadow-sm">
							<div class="fw-semibold mb-1">Please check your request details.</div>
							<ul class="mb-0 ps-3">
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					@if (session('status'))
						<div class="alert alert-success border-0 shadow-sm">{{ session('status') }}</div>
					@endif

					@if (session('warning'))
						<div class="alert alert-warning border-0 shadow-sm">{{ session('warning') }}</div>
					@endif

					@if ($hasPendingRequest)
						<div class="alert alert-info border-0 shadow-sm">
							<div class="fw-semibold mb-1">Your request is pending admin review.</div>
							<div class="small">Submitted on {{ $pendingRequest->request_date ? $pendingRequest->request_date->format('F d, Y h:i A') : 'recently' }}.</div>
						</div>
					@endif

					@if ($hasClearance)
						<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
							<div>
								<h2 class="h4 mb-1 fw-bold">Your PESO Clearance</h2>
								<p class="mb-0 text-muted">Details of your current clearance certificate.</p>
							</div>
						</div>

						<div class="mt-4">
							<div class="card border-0 shadow-sm clearance-panel">
								<div class="card-body p-4">
									<div class="row g-4">
										<div class="col-12 col-md-6">
											<div class="clearance-item h-100">
												<div class="small text-muted mb-1">Clearance Number</div>
												<div class="fw-bold fs-5">{{ $clearance->clearance_number }}</div>
											</div>
										</div>
										<div class="col-12 col-md-6">
											<div class="clearance-item h-100">
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
										</div>
										<div class="col-12 col-md-6">
											<div class="clearance-item h-100">
												<div class="small text-muted mb-1">Issue Date</div>
												<div class="fw-semibold">{{ $clearance->issue_date ? $clearance->issue_date->format('F d, Y') : 'N/A' }}</div>
											</div>
										</div>
										<div class="col-12 col-md-6">
											<div class="clearance-item h-100">
												<div class="small text-muted mb-1">Expiry Date</div>
												<div class="fw-semibold">{{ $clearance->expiry_date ? $clearance->expiry_date->format('F d, Y') : 'N/A' }}</div>
											</div>
										</div>
										@if ($clearance->remarks)
											<div class="col-12">
												<div class="clearance-item">
													<div class="small text-muted mb-1">Remarks</div>
													<div class="fw-semibold">{{ $clearance->remarks }}</div>
												</div>
											</div>
										@endif
									</div>
								</div>
							</div>
						</div>
					@else
						<div class="row g-3">
							<div class="col-12 col-lg-7">
								<div class="dashboard-empty-state clearance-empty d-flex align-items-center justify-content-center text-center p-4">
									<div>
										<div class="fs-1 mb-2">📄</div>
										<div class="fw-semibold text-secondary mb-1">No PESO Clearance found</div>
										<div class="small text-muted mb-3">You do not have a PESO clearance certificate on record.</div>
										<div class="small text-muted">Submit a request below and the admin will review it.</div>
									</div>
								</div>
							</div>

							<div class="col-12 col-lg-5" id="request-clearance">
								<div class="card border-0 shadow-sm h-100 clearance-request-card">
									<div class="clearance-request-header">
										<h3 class="h5 fw-bold mb-1">Request PESO Clearance</h3>
										<p class="text-muted small mb-0">Send your documents for admin review and issuance.</p>
									</div>
									<div class="clearance-request-body">
										<div class="clearance-note small mb-3">
											<i class="bi bi-info-circle me-2"></i>Prepare your receipt, barangay clearance, and first-time jobseeker document if applicable before submitting.
										</div>

										<form method="POST" action="{{ route('jobseeker.peso-clearance.request') }}" enctype="multipart/form-data">
											@csrf
											<div class="mb-3">
												<label class="form-label fw-semibold">Remarks / Purpose</label>
												<textarea name="remarks" class="form-control" rows="4" maxlength="500" placeholder="Optional: state why you need the clearance">{{ old('remarks') }}</textarea>
											</div>

											<div class="clearance-upload-card mb-3">
												<label class="clearance-upload-label" for="pesoClearanceReceipt">PESO Clearance Assurance Receipt <span class="text-danger">*</span></label>
												<input id="pesoClearanceReceipt" type="file" name="peso_clearance_assurance_receipt" class="form-control @error('peso_clearance_assurance_receipt') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png" required>
												<div class="clearance-upload-help">Upload a clear copy of the assurance receipt in PDF, JPG, or PNG format.</div>
												@error('peso_clearance_assurance_receipt')
													<div class="invalid-feedback d-block">{{ $message }}</div>
												@enderror
											</div>

											<div class="clearance-upload-card mb-3">
												<label class="clearance-upload-label" for="barangayClearance">Barangay Clearance <span class="text-danger">*</span></label>
												<input id="barangayClearance" type="file" name="barangay_clearance" class="form-control @error('barangay_clearance') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png" required>
												<div class="clearance-upload-help">This document confirms your barangay clearance and residency record.</div>
												@error('barangay_clearance')
													<div class="invalid-feedback d-block">{{ $message }}</div>
												@enderror
											</div>

											<div class="clearance-check mb-3 form-check">
												<input type="checkbox" name="is_first_time_jobseeker" class="form-check-input" id="isFirstTimeJobseeker" value="1" @checked(old('is_first_time_jobseeker'))>
												<label class="form-check-label fw-semibold" for="isFirstTimeJobseeker">I am a first-time jobseeker</label>
												<div class="clearance-upload-help mt-1">Check this if you are applying under the first-time jobseeker program.</div>
											</div>

											<div class="clearance-upload-card mb-3" id="firstTimeDocumentDiv" style="display: {{ old('is_first_time_jobseeker') ? 'block' : 'none' }};">
												<label class="clearance-upload-label" for="firstTimeJobseekerDocument">First-Time Jobseeker Document <span class="text-danger">*</span></label>
												<input type="file" name="first_time_jobseeker_document" id="firstTimeJobseekerDocument" class="form-control @error('first_time_jobseeker_document') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png" {{ old('is_first_time_jobseeker') ? 'required' : '' }}>
												<div class="clearance-upload-help">Required only when the first-time jobseeker box is checked.</div>
												@error('first_time_jobseeker_document')
													<div class="invalid-feedback d-block">{{ $message }}</div>
												@enderror
											</div>

											<div class="d-grid mt-4">
												<button type="submit" class="btn btn-primary clearance-cta py-2" {{ $canRequestClearance ? '' : 'disabled' }}>
													<i class="bi bi-send me-2"></i>Request PESO Clearance
												</button>
											</div>
										</form>

										<script>
											const firstTimeToggle = document.getElementById('isFirstTimeJobseeker');
											const firstTimePanel = document.getElementById('firstTimeDocumentDiv');
											const firstTimeInput = document.getElementById('firstTimeJobseekerDocument');

											if (firstTimeToggle && firstTimePanel && firstTimeInput) {
												firstTimeToggle.addEventListener('change', function () {
													const isChecked = this.checked;
													firstTimePanel.style.display = isChecked ? 'block' : 'none';
													firstTimeInput.required = isChecked;
													if (!isChecked) {
														firstTimeInput.value = '';
													}
												});
											}
										</script>
									</div>
								</div>
							</div>
						</div>
					@endif
				</div>
			</div>
		</section>
		@endsection

