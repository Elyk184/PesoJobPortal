@extends('layouts.admin-dashboard')

@section('title', strtoupper($activityRequest->activity_type) . ' Request - Review')

<?php
    $pageTitle = strtoupper($activityRequest->activity_type) . ' Request Review';
    $pageSubtitle = 'Review and ' . ($activityRequest->status === 'pending' ? 'approve or reject' : 'view') . ' the LRA/SRA request documents';
    $pageIcon = 'bi-clipboard-check';
?>

@section('content')
<div class="admin-dashboard">
    <div class="dashboard-card">

        {{-- Page Header --}}
        <div class="lra-topbar">
            <div>
                <h1 class="lra-page-title">{{ strtoupper($activityRequest->activity_type) }} Request Review</h1>
                <p class="lra-page-sub">
                    Review and {{ $activityRequest->status === 'pending' ? 'approve or reject' : 'view' }} the LRA/SRA request documents
                </p>
            </div>
            <a href="{{ route('admin.lra-sra-approvals') }}" class="lra-back-btn">
                <i class="bi bi-arrow-left"></i> Back to Approvals
            </a>
        </div>

        {{-- Two-column layout --}}
        <div class="lra-layout">

            {{-- ── MAIN COLUMN ── --}}
            <div class="lra-main">

                {{-- Meta strip --}}
                <div class="lra-card lra-card--flush mb-card">
                    <div class="lra-meta-strip">
                        <div class="lra-meta-cell">
                            <div class="lra-meta-label"><i class="bi bi-tag me-1"></i>Activity type</div>
                            <span class="lra-badge lra-badge--{{ $activityRequest->activity_type }}">
                                <i class="bi bi-file-earmark me-1"></i>{{ strtoupper($activityRequest->activity_type) }}
                            </span>
                        </div>
                        <div class="lra-meta-cell">
                            <div class="lra-meta-label"><i class="bi bi-building me-1"></i>Employer</div>
                            <div class="lra-meta-val">{{ $activityRequest->employer?->name ?? 'N/A' }}</div>
                        </div>
                        <div class="lra-meta-cell">
                            <div class="lra-meta-label"><i class="bi bi-calendar me-1"></i>Submitted</div>
                            <div class="lra-meta-val">{{ $activityRequest->created_at->format('M d, Y') }}</div>
                        </div>
                        <div class="lra-meta-cell">
                            <div class="lra-meta-label"><i class="bi bi-info-circle me-1"></i>Status</div>
                            <span class="lra-badge lra-badge--status-{{ $activityRequest->status }}">
                                {{ ucfirst($activityRequest->status) }}
                            </span>
                        </div>
                    </div>

                    {{-- Required Documents --}}
                    <div class="lra-card-body">
                        <div class="lra-section-tag lra-section-tag--red">
                            <i class="bi bi-file-earmark-pdf me-1"></i> Required documents
                        </div>
                        <div class="lra-doc-grid">
                            <div class="lra-doc-item">
                                <i class="bi bi-file-pdf lra-doc-icon lra-doc-icon--red"></i>
                                <p class="lra-doc-name">Letter of Intent</p>
                                @if($activityRequest->letter_of_intent_path)
                                    <a href="{{ asset('storage/' . $activityRequest->letter_of_intent_path) }}"
                                       class="lra-dl-btn" target="_blank">
                                        <i class="bi bi-download me-1"></i>Download
                                    </a>
                                @else
                                    <span class="lra-doc-missing">Not provided</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SRA Specific Documents --}}
                @if($activityRequest->activity_type === 'sra')
                <div class="lra-card mb-card">
                    <div class="lra-card-head">
                        <i class="bi bi-file-earmark"></i>
                        <span class="lra-card-head-label">SRA-specific documents</span>
                    </div>
                    <div class="lra-card-body">
                        <div class="lra-section-tag lra-section-tag--purple">
                            <i class="bi bi-file-earmark me-1"></i> SRA documents
                        </div>
                        @php
                            $sraDocuments = [
                                ['name' => 'DMW Certificate',         'field' => 'dmw_certificate_path'],
                                ['name' => 'Recruitment Officer ID',  'field' => 'recruitment_officer_id_path'],
                                ['name' => 'Job Order Balance',       'field' => 'job_order_balance_path'],
                                ['name' => 'Deployment Report',       'field' => 'deployment_report_path'],
                                ['name' => 'Affidavit of Undertaking','field' => 'affidavit_undertaking_path'],
                                ['name' => 'SRA Authority',           'field' => 'sra_authority_file_path'],
                            ];
                        @endphp
                        <div class="lra-doc-grid">
                            @foreach($sraDocuments as $doc)
                            <div class="lra-doc-item">
                                <i class="bi bi-file-pdf lra-doc-icon lra-doc-icon--purple"></i>
                                <p class="lra-doc-name">{{ $doc['name'] }}</p>
                                @if($activityRequest->{$doc['field']})
                                    <a href="{{ asset('storage/' . $activityRequest->{$doc['field']}) }}"
                                       class="lra-dl-btn" target="_blank">
                                        <i class="bi bi-download me-1"></i>Download
                                    </a>
                                @else
                                    <span class="lra-doc-missing">Not provided</span>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                {{-- LRA Specific Documents + Job Vacancies --}}
                @if($activityRequest->activity_type === 'lra')
                <div class="lra-card mb-card">
                    <div class="lra-card-head">
                        <i class="bi bi-file-earmark"></i>
                        <span class="lra-card-head-label">LRA-specific documents</span>
                    </div>
                    <div class="lra-card-body">
                        <div class="lra-section-tag lra-section-tag--teal">
                            <i class="bi bi-file-earmark me-1"></i> LRA documents
                        </div>
                        <div class="lra-doc-grid">
                            <div class="lra-doc-item">
                                <i class="bi bi-file-pdf lra-doc-icon lra-doc-icon--teal"></i>
                                <p class="lra-doc-name">Business Permit</p>
                                @if($activityRequest->business_permit_path)
                                    <a href="{{ asset('storage/' . $activityRequest->business_permit_path) }}"
                                       class="lra-dl-btn" target="_blank">
                                        <i class="bi bi-download me-1"></i>Download
                                    </a>
                                @else
                                    <span class="lra-doc-missing">Not provided</span>
                                @endif
                            </div>
                            <div class="lra-doc-item">
                                <i class="bi bi-file-pdf lra-doc-icon lra-doc-icon--teal"></i>
                                <p class="lra-doc-name">Recruitment Officer ID</p>
                                @if($activityRequest->lra_recruitment_officer_id_path)
                                    <a href="{{ asset('storage/' . $activityRequest->lra_recruitment_officer_id_path) }}"
                                       class="lra-dl-btn" target="_blank">
                                        <i class="bi bi-download me-1"></i>Download
                                    </a>
                                @else
                                    <span class="lra-doc-missing">Not provided</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Job Vacancies --}}
                <div class="lra-card mb-card">
                    <div class="lra-card-head">
                        <i class="bi bi-briefcase"></i>
                        <span class="lra-card-head-label">Job vacancies</span>
                    </div>
                    <div class="lra-card-body">
                        @if($activityRequest->job_vacancies_path && $activityRequest->job_vacancies_text)
                            <div class="lra-jv-split">
                                <div class="lra-doc-item">
                                    <i class="bi bi-file-pdf lra-doc-icon lra-doc-icon--blue"></i>
                                    <p class="lra-doc-name">Job Vacancies File</p>
                                    <a href="{{ asset('storage/' . $activityRequest->job_vacancies_path) }}"
                                       class="lra-dl-btn" target="_blank">
                                        <i class="bi bi-download me-1"></i>Download
                                    </a>
                                </div>
                                <div class="lra-vacancies-text">{{ $activityRequest->job_vacancies_text }}</div>
                            </div>
                        @elseif($activityRequest->job_vacancies_path)
                            <div class="lra-doc-grid">
                                <div class="lra-doc-item">
                                    <i class="bi bi-file-pdf lra-doc-icon lra-doc-icon--blue"></i>
                                    <p class="lra-doc-name">Job Vacancies File</p>
                                    <a href="{{ asset('storage/' . $activityRequest->job_vacancies_path) }}"
                                       class="lra-dl-btn" target="_blank">
                                        <i class="bi bi-download me-1"></i>Download
                                    </a>
                                </div>
                            </div>
                        @elseif($activityRequest->job_vacancies_text)
                            <div class="lra-vacancies-text">{{ $activityRequest->job_vacancies_text }}</div>
                        @else
                            <div class="lra-empty">
                                <i class="bi bi-inbox"></i>
                                <span>Not provided</span>
                            </div>
                        @endif
                    </div>
                </div>
                @endif

            </div>{{-- /main --}}

            {{-- ── SIDEBAR ── --}}
            <div class="lra-sidebar">

                {{-- Company info --}}
                <div class="lra-card mb-card">
                    <div class="lra-card-head">
                        <i class="bi bi-building"></i>
                        <span class="lra-card-head-label">Company</span>
                    </div>
                    <div class="lra-card-body lra-card-body--compact">
                        <div class="lra-info-row">
                            <span class="lra-info-key"><i class="bi bi-globe me-1"></i>Business</span>
                            <span class="lra-info-val">{{ $activityRequest->employer->profile?->line_of_business ?? 'N/A' }}</span>
                        </div>
                        <div class="lra-info-row">
                            <span class="lra-info-key"><i class="bi bi-people me-1"></i>Workforce</span>
                            <span class="lra-info-val">{{ $activityRequest->employer->profile?->workforce_size ?? 'N/A' }}</span>
                        </div>
                        <div class="lra-info-row lra-info-row--last">
                            <span class="lra-info-key"><i class="bi bi-telephone me-1"></i>Contact</span>
                            <span class="lra-info-val">{{ $activityRequest->employer->profile?->establishment_phone ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                @if($activityRequest->status === 'pending')

                    {{-- Certification --}}
                    <div class="lra-card mb-card">
                        <div class="lra-card-head">
                            <i class="bi bi-certificate"></i>
                            <span class="lra-card-head-label">Certification</span>
                        </div>
                        <div class="lra-card-body lra-card-body--compact">
                            @if($activityRequest->certification_path)
                                <div class="lra-cert-status lra-cert-status--ok">
                                    <div class="lra-cert-title">
                                        <i class="bi bi-check-circle-fill me-1"></i>Certification generated
                                    </div>
                                    <div class="lra-cert-sub">
                                        {{ \Carbon\Carbon::parse($activityRequest->certification_generated_at)->format('M d, Y H:i') }}
                                        &mdash; {{ $activityRequest->certificationGeneratedBy?->name ?? 'System' }}
                                    </div>
                                </div>
                                <a href="{{ route('admin.lra-sra.view-certification', $activityRequest) }}"
                                   class="lra-action-btn lra-action-btn--view" target="_blank">
                                    <i class="bi bi-eye me-1"></i>View certification
                                </a>
                                <form method="POST" action="{{ route('admin.lra-sra.generate-certification', $activityRequest) }}">
                                    @csrf
                                    <button type="submit" class="lra-action-btn lra-action-btn--generate w-100">
                                        <i class="bi bi-arrow-repeat me-1"></i>Regenerate
                                    </button>
                                </form>
                            @else
                                <div class="lra-cert-status lra-cert-status--pending">
                                    <div class="lra-cert-title">
                                        <i class="bi bi-exclamation-circle-fill me-1"></i>Not yet generated
                                    </div>
                                    <div class="lra-cert-sub">
                                        Generate a certification document before approving this request.
                                    </div>
                                </div>
                                <form method="POST" action="{{ route('admin.lra-sra.generate-certification', $activityRequest) }}">
                                    @csrf
                                    <button type="submit" class="lra-action-btn lra-action-btn--generate w-100">
                                        <i class="bi bi-file-earmark-plus me-1"></i>Generate certification
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    {{-- Review actions --}}
                    <div class="lra-card lra-sidebar-sticky">
                        <div class="lra-card-head">
                            <i class="bi bi-shield-check"></i>
                            <span class="lra-card-head-label">Review</span>
                        </div>
                        <div class="lra-card-body lra-card-body--compact">
                            <div class="lra-notice">
                                <i class="bi bi-info-circle me-1"></i>
                                Generate certification first, then approve.
                            </div>
                            <form method="POST" class="d-grid gap-2">
                                @csrf
                                <button type="submit"
                                        formaction="{{ route('admin.lra-sra.approve', $activityRequest) }}"
                                        class="lra-action-btn lra-action-btn--approve w-100"
                                        {{ !$activityRequest->certification_path ? 'disabled' : '' }}>
                                    <i class="bi bi-check-circle me-1"></i>Approve
                                </button>
                            </form>
                            <button type="button"
                                    class="lra-action-btn lra-action-btn--reject w-100 mt-2"
                                    data-bs-toggle="modal"
                                    data-bs-target="#rejectModal">
                                <i class="bi bi-x-circle me-1"></i>Reject request
                            </button>
                        </div>
                    </div>

                @else

                    {{-- Status info (approved / rejected) --}}
                    <div class="lra-card">
                        <div class="lra-card-head">
                            <i class="bi bi-info-circle"></i>
                            <span class="lra-card-head-label">Status</span>
                        </div>
                        <div class="lra-card-body--flush">
                            @if($activityRequest->status === 'approved')
                                <div class="lra-status-block lra-status-block--approved">
                                    <i class="bi bi-check-circle-fill lra-status-icon"></i>
                                    <div>
                                        <div class="lra-status-title">Approved</div>
                                        <div class="lra-status-detail">
                                            <span>{{ optional($activityRequest->approved_at)->format('M d, Y') }}</span>
                                            <span>&mdash; {{ $activityRequest->approvedBy?->name ?? 'System' }}</span>
                                        </div>
                                    </div>
                                </div>
                            @elseif($activityRequest->status === 'rejected')
                                <div class="lra-status-block lra-status-block--rejected">
                                    <i class="bi bi-x-circle-fill lra-status-icon"></i>
                                    <div>
                                        <div class="lra-status-title">Rejected</div>
                                        <div class="lra-status-reason">
                                            {{ $activityRequest->notes ?? 'No reason provided' }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                @endif

            </div>{{-- /sidebar --}}

        </div>{{-- /layout --}}
    </div>
</div>

{{-- Rejection Modal --}}
@if($activityRequest->status === 'pending')
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.lra-sra.reject', $activityRequest) }}">
                @csrf
                <div class="modal-body">
                    <small class="text-muted">
                        {{ strtoupper($activityRequest->activity_type) }} &mdash; {{ $activityRequest->employer?->name }}
                    </small>
                    <div class="mb-0 mt-3">
                        <label for="rejection_notes" class="form-label">
                            Reason <span class="text-danger">*</span>
                        </label>
                        <textarea id="rejection_notes" name="notes" class="form-control" rows="4"
                                  placeholder="Explain why this request is being rejected..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

{{-- ── Scoped styles ── --}}
<style>
/* Layout */
.lra-topbar {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 1.25rem;
    flex-wrap: wrap;
}
.lra-page-title {
    font-size: 1.15rem;
    font-weight: 600;
    color: #111827;
    margin: 0 0 3px;
}
.lra-page-sub {
    font-size: 0.8rem;
    color: #6b7280;
    margin: 0;
}
.lra-back-btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 0.8rem;
    color: #6b7280;
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    padding: 6px 12px;
    text-decoration: none;
    white-space: nowrap;
    flex-shrink: 0;
}
.lra-back-btn:hover { color: #374151; border-color: #d1d5db; background: #f3f4f6; }

.lra-layout {
    display: grid;
    grid-template-columns: 1fr 268px;
    gap: 1.25rem;
    align-items: start;
}
@media (max-width: 900px) {
    .lra-layout { grid-template-columns: 1fr; }
}

.mb-card { margin-bottom: 1rem; }

/* Card */
.lra-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    overflow: hidden;
}
.lra-card--flush { padding: 0; }

.lra-card-head {
    display: flex;
    align-items: center;
    gap: 7px;
    padding: 0.7rem 1.1rem;
    border-bottom: 1px solid #f3f4f6;
    background: #fafafa;
    font-size: 0.78rem;
    color: #6b7280;
}
.lra-card-head-label {
    font-size: 0.8rem;
    font-weight: 600;
    color: #374151;
}
.lra-card-body {
    padding: 1.1rem;
}
.lra-card-body--compact {
    padding: 0.9rem 1.1rem;
}
.lra-card-body--flush {
    padding: 0;
}

/* Meta strip */
.lra-meta-strip {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    border-bottom: 1px solid #f3f4f6;
}
@media (max-width: 640px) {
    .lra-meta-strip { grid-template-columns: repeat(2, 1fr); }
}
.lra-meta-cell {
    padding: 0.9rem 1.1rem;
    border-right: 1px solid #f3f4f6;
}
.lra-meta-cell:last-child { border-right: none; }
.lra-meta-label {
    font-size: 0.7rem;
    font-weight: 600;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    margin-bottom: 6px;
}
.lra-meta-val {
    font-size: 0.875rem;
    font-weight: 600;
    color: #1f2937;
}

/* Badges */
.lra-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 100px;
}
.lra-badge--lra   { background: #eff6ff; color: #1d4ed8; }
.lra-badge--sra   { background: #fdf2f8; color: #9d174d; }
.lra-badge--status-pending  { background: #fffbeb; color: #92400e; }
.lra-badge--status-approved { background: #f0fdf4; color: #166534; }
.lra-badge--status-rejected { background: #fef2f2; color: #991b1b; }

/* Section tags */
.lra-section-tag {
    display: inline-flex;
    align-items: center;
    font-size: 0.72rem;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 100px;
    margin-bottom: 0.875rem;
}
.lra-section-tag--red    { background: #fef2f2; color: #991b1b; }
.lra-section-tag--purple { background: #f5f3ff; color: #5b21b6; }
.lra-section-tag--teal   { background: #f0fdfa; color: #0f766e; }
.lra-section-tag--blue   { background: #eff6ff; color: #1d4ed8; }

/* Document grid */
.lra-doc-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
    gap: 10px;
}
.lra-doc-item {
    background: #f9fafb;
    border: 1px solid #f3f4f6;
    border-radius: 8px;
    padding: 1rem 0.75rem;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
}
.lra-doc-icon {
    font-size: 1.75rem;
    margin-bottom: 8px;
    display: block;
}
.lra-doc-icon--red    { color: #ef4444; }
.lra-doc-icon--purple { color: #8b5cf6; }
.lra-doc-icon--teal   { color: #14b8a6; }
.lra-doc-icon--blue   { color: #3b82f6; }
.lra-doc-name {
    font-size: 0.75rem;
    color: #374151;
    font-weight: 500;
    margin: 0 0 8px;
    line-height: 1.35;
}
.lra-doc-missing {
    font-size: 0.72rem;
    color: #9ca3af;
    font-style: italic;
}
.lra-dl-btn {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    font-size: 0.72rem;
    font-weight: 500;
    padding: 4px 10px;
    border-radius: 5px;
    border: 1px solid #e5e7eb;
    background: #fff;
    color: #374151;
    text-decoration: none;
    transition: border-color .15s, background .15s;
}
.lra-dl-btn:hover { border-color: #d1d5db; background: #f3f4f6; color: #111827; }

/* Job vacancies */
.lra-jv-split {
    display: grid;
    grid-template-columns: 140px 1fr;
    gap: 1rem;
    align-items: start;
}
@media (max-width: 500px) {
    .lra-jv-split { grid-template-columns: 1fr; }
}
.lra-vacancies-text {
    background: #f9fafb;
    border: 1px solid #f3f4f6;
    border-radius: 8px;
    padding: 0.875rem;
    font-size: 0.8rem;
    color: #374151;
    line-height: 1.6;
    max-height: 240px;
    overflow-y: auto;
    white-space: pre-wrap;
    word-break: break-word;
}
.lra-empty {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 1.5rem;
    justify-content: center;
    color: #9ca3af;
    font-size: 0.8rem;
}
.lra-empty i { font-size: 1.2rem; }

/* Sidebar info rows */
.lra-info-row {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 8px;
    padding: 7px 0;
    border-bottom: 1px solid #f3f4f6;
}
.lra-info-row--last { border-bottom: none; padding-bottom: 0; }
.lra-info-key {
    font-size: 0.75rem;
    color: #9ca3af;
    flex-shrink: 0;
    display: flex;
    align-items: center;
}
.lra-info-val {
    font-size: 0.78rem;
    font-weight: 600;
    color: #1f2937;
    text-align: right;
    word-break: break-word;
}

/* Certification status */
.lra-cert-status {
    border-radius: 7px;
    padding: 0.65rem 0.85rem;
    margin-bottom: 0.75rem;
}
.lra-cert-status--ok {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
}
.lra-cert-status--pending {
    background: #fffbeb;
    border: 1px solid #fde68a;
}
.lra-cert-title {
    font-size: 0.78rem;
    font-weight: 600;
    margin-bottom: 3px;
}
.lra-cert-status--ok .lra-cert-title      { color: #166534; }
.lra-cert-status--pending .lra-cert-title { color: #92400e; }
.lra-cert-sub {
    font-size: 0.72rem;
    color: #6b7280;
    line-height: 1.4;
}

/* Notice */
.lra-notice {
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    border-radius: 6px;
    padding: 7px 10px;
    margin-bottom: 0.75rem;
    font-size: 0.75rem;
    color: #1e40af;
    line-height: 1.4;
}

/* Action buttons */
.lra-action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    width: 100%;
    padding: 8px 14px;
    border-radius: 7px;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    border: 1px solid transparent;
    transition: opacity .15s, filter .15s;
    text-decoration: none;
    text-align: center;
    margin-bottom: 0;
}
.lra-action-btn + .lra-action-btn,
.lra-action-btn + form,
form + .lra-action-btn { margin-top: 0.5rem; }
.lra-action-btn:disabled { opacity: 0.45; cursor: not-allowed; }
.lra-action-btn--approve  { background: #dcfce7; color: #166534; border-color: #bbf7d0; }
.lra-action-btn--approve:hover:not(:disabled) { background: #bbf7d0; }
.lra-action-btn--reject   { background: #fef2f2; color: #991b1b; border-color: #fecaca; }
.lra-action-btn--reject:hover  { background: #fecaca; }
.lra-action-btn--generate { background: #fffbeb; color: #92400e; border-color: #fde68a; }
.lra-action-btn--generate:hover { background: #fde68a; }
.lra-action-btn--view     { background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }
.lra-action-btn--view:hover { background: #bfdbfe; }

/* Sidebar sticky */
.lra-sidebar-sticky { position: sticky; top: 20px; }

/* Status block (approved / rejected view) */
.lra-status-block {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 1rem 1.1rem;
}
.lra-status-block--approved { background: #f0fdf4; border-left: 3px solid #22c55e; }
.lra-status-block--rejected { background: #fef2f2; border-left: 3px solid #ef4444; }
.lra-status-icon { font-size: 1.1rem; flex-shrink: 0; margin-top: 2px; }
.lra-status-block--approved .lra-status-icon { color: #16a34a; }
.lra-status-block--rejected .lra-status-icon { color: #dc2626; }
.lra-status-title {
    font-size: 0.85rem;
    font-weight: 700;
    margin-bottom: 5px;
}
.lra-status-block--approved .lra-status-title { color: #166534; }
.lra-status-block--rejected .lra-status-title { color: #991b1b; }
.lra-status-detail {
    font-size: 0.75rem;
    color: #6b7280;
    display: flex;
    flex-wrap: wrap;
    gap: 3px;
}
.lra-status-reason {
    font-size: 0.75rem;
    color: #7f1d1d;
    font-style: italic;
    line-height: 1.4;
}
</style>
@endsection
