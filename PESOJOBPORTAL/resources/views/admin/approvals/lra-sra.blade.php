@extends('layouts.admin-dashboard')

@section('title', 'LRA/SRA Approvals | PESO Admin')

<?php
    $pageTitle = 'LRA/SRA Approvals';
    $pageSubtitle = 'Review and approve LRA/SRA requests';
    $pageIcon = 'bi-clipboard-check';
?>

@section('content')
    <div class="admin-dashboard">
    <style>
        .lra-approval-stack { display: grid; gap: 1.5rem; }
        .dashboard-card {
            background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
            padding: 1.35rem 1.25rem;
            border-radius: 16px;
            border: 1px solid #e5edf7;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
        }
        .approval-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }
        .approval-card-title {
            margin: 0;
            font-size: 1.08rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
        }
        .approval-card-subtitle {
            margin: 0.35rem 0 0;
            color: #64748b;
            font-size: 0.82rem;
        }
        .approval-count {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            min-height: 36px;
            padding: 0 0.9rem;
            border-radius: 999px;
            background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%);
            color: #9a3d12;
            font-size: 0.78rem;
            font-weight: 800;
            white-space: nowrap;
            box-shadow: inset 0 0 0 1px rgba(154, 61, 18, 0.06);
        }
        .table-shell {
            width: 100%;
            overflow-x: auto;
            border: 1px solid #edf2f7;
            border-radius: 14px;
            background: #fff;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.8);
        }
        .data-table {
            min-width: 980px;
            margin: 0;
            font-size: 13px;
            border-collapse: separate;
            border-spacing: 0;
        }
        .data-table thead { background: #f8fafc; }
        .data-table th {
            color: #0f172a;
            font-weight: 800;
            border-bottom: 1px solid #e5eaf3;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            padding: 0.9rem 1rem;
            white-space: nowrap;
            text-align: left;
        }
        .data-table td {
            padding: 1rem;
            vertical-align: middle;
            font-weight: 500;
            background: #fff;
            border-bottom: 1px solid #eef3f8;
            color: #334155;
        }
        .data-table tbody tr:last-child td { border-bottom: 0; }
        .data-table tbody tr:hover td { background: #f8fbff; }
        .employer-cell {
            min-width: 200px;
            color: #0f172a;
            font-weight: 700;
        }
        .date-cell { color: #475569; white-space: nowrap; }
        .doc-col {
            width: 42%;
            min-width: 340px;
            word-break: break-word;
        }
        .docs-count {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            margin-bottom: 0.7rem;
            padding: 0.38rem 0.6rem;
            border-radius: 999px;
            background: #f1f5f9;
            color: #334155;
            font-size: 0.75rem;
            font-weight: 700;
        }
        .doc-chip-group {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            align-items: center;
        }
        .doc-badge,
        .doc-missing {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            min-height: 30px;
            margin: 0;
            padding: 0.42rem 0.7rem;
            border-radius: 10px;
            font-size: 0.74rem;
            line-height: 1;
            white-space: nowrap;
            font-weight: 700;
        }
        .doc-badge {
            text-decoration: none;
            border: 0;
            transition: transform .12s ease, box-shadow .12s ease, filter .12s ease;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #fff;
            box-shadow: 0 8px 18px rgba(5, 150, 105, 0.18);
        }
        .doc-badge i { font-size: 0.88rem; }
        .doc-badge:hover {
            transform: translateY(-1px);
            filter: brightness(1.02);
            box-shadow: 0 10px 20px rgba(15,23,42,0.08);
        }
        .doc-missing {
            background: #f8fafc;
            color: #94a3b8;
            border: 1px dashed #dbe4ee;
        }
        .action-cell { min-width: 250px; }
        .action-btns {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
        .action-btns .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.35rem;
            min-height: 36px;
            margin: 0;
            padding: 0.5rem 0.8rem;
            border-radius: 10px;
            font-weight: 700;
            white-space: nowrap;
            box-shadow: 0 6px 16px rgba(15, 23, 42, 0.04);
        }
        .action-btns .btn i { margin-right: 0; }
        .badge-activity {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 52px;
            padding: 0.5rem 0.7rem;
            border-radius: 999px;
            font-weight: 800;
            color: #fff;
            letter-spacing: 0.04em;
            box-shadow: inset 0 0 0 1px rgba(255,255,255,0.2);
        }
        .history-card { margin-top: 0; }
        .status-pill {
            display:inline-flex;
            align-items:center;
            gap:6px;
            padding:6px 10px;
            border-radius:999px;
            font-size:0.76rem;
            font-weight:800;
            text-transform:capitalize;
        }
        .status-pill--approved { background:#dcfce7; color:#166534; }
        .status-pill--rejected { background:#fee2e2; color:#991b1b; }
        .cert-link {
            display:inline-flex;
            align-items:center;
            gap:6px;
            text-decoration:none;
            font-weight:700;
            color:#15803d;
        }
        .cert-link:hover { color:#166534; }
        .cert-missing { color:#94a3b8; font-size:0.82rem; }

        /* Modal preview sizing */
        #docPreviewContainer { min-height: 40vh; }
        .empty-approval-state {
            display: flex;
            align-items: flex-start;
            gap: 0.85rem;
            padding: 1rem 1.1rem;
            border-radius: 12px;
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
            color: #166534;
            border: 1px solid #bbf7d0;
        }
        .empty-approval-state i { font-size: 1.25rem; margin-top: 0.12rem; }
        @media(max-width: 768px) {
            .dashboard-card { padding: 1rem; }
            .approval-card-header { align-items: flex-start; }
            .approval-count { width: 100%; justify-content: center; }
            .action-btns { justify-content: flex-start; }
        }
        @media(min-width:1200px){ #docPreviewContainer iframe { height:70vh; } }
    </style>

    <div class="lra-approval-stack">
        <div class="dashboard-card">
            <div class="approval-card-header">
                <div>
                    <h2 class="approval-card-title">Pending Requests</h2>
                    <p class="approval-card-subtitle">Review submitted documents and take action on active LRA/SRA requests.</p>
                </div>
                <span class="approval-count">
                    <i class="bi bi-hourglass-split"></i>
                    {{ $pendingRequests->count() }} pending
                </span>
            </div>
            @if($pendingRequests->count() > 0)
                <!-- Approvals Table -->
                <div class="table-shell">
                <table class="table data-table w-100">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Employer</th>
                            <th>Documents</th>
                            <th>Submitted</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingRequests as $request)
                            <tr>
                                <td>
                                    <span class="badge badge-activity bg-info">{{ strtoupper($request->activity_type) }}</span>
                                </td>
                                <td class="employer-cell"><strong>{{ Str::limit($request->employer?->name ?? 'N/A', 28) }}</strong></td>
                                <td class="doc-col">
                                    @php
                                        $commonDocs = [
                                            ['label' => 'LOI', 'field' => 'letter_of_intent_path'],
                                            ['label' => 'Company Profile', 'field' => 'company_profile_path'],
                                        ];

                                        $lraDocs = [
                                            ['label' => 'Business Permit', 'field' => 'business_permit_path'],
                                            ['label' => 'Recruitment Officer ID', 'field' => 'lra_recruitment_officer_id_path'],
                                            ['label' => 'Job Vacancies', 'field' => 'job_vacancies_path'],
                                        ];

                                        $sraDocs = [
                                            ['label' => 'DMW Certificate', 'field' => 'dmw_certificate_path'],
                                            ['label' => 'Recruitment Officer ID', 'field' => 'recruitment_officer_id_path'],
                                            ['label' => 'Job Order Balance', 'field' => 'job_order_balance_path'],
                                        ];

                                        $docsToShow = $commonDocs;
                                        if ($request->activity_type === 'lra') {
                                            $docsToShow = array_merge($docsToShow, $lraDocs);
                                        } elseif ($request->activity_type === 'sra') {
                                            $docsToShow = array_merge($docsToShow, $sraDocs);
                                        }

                                        $totalDocs = count($docsToShow);
                                        $present = array_filter($docsToShow, function($d) use ($request) {
                                            if ($d['field'] === 'job_vacancies_path') {
                                                return !empty($request->job_vacancies_path) || !empty($request->job_vacancies_text);
                                            }
                                            return !empty($request->{$d['field']});
                                        });
                                        $presentCount = count($present);
                                    @endphp

                                    <span class="docs-count"><i class="bi bi-paperclip"></i><strong>{{ $presentCount }}</strong>/{{ $totalDocs }} uploaded</span>

                                    <div class="doc-chip-group">
                                        @foreach($docsToShow as $doc)
                                            @if($doc['field'] === 'job_vacancies_path')
                                                @if(!empty($request->job_vacancies_path))
                                                    <button type="button"
                                                            class="doc-badge btn bg-success text-white"
                                                            data-type="file"
                                                            data-url="{{ asset('storage/' . $request->job_vacancies_path) }}"
                                                            title="Preview Job Vacancies PDF">
                                                        <i class="bi bi-download"></i>
                                                        {{ Str::limit($doc['label'], 18) }}
                                                    </button>
                                                @elseif(!empty($request->job_vacancies_text))
                                                    <button type="button"
                                                            class="doc-badge btn bg-primary text-white"
                                                            data-type="text"
                                                            data-vacancy-id="{{ $request->id }}"
                                                            title="View Job Vacancies (text)">
                                                        <i class="bi bi-card-text"></i>
                                                        {{ Str::limit($doc['label'], 18) }}
                                                    </button>
                                                @else
                                                    <span class="doc-missing">{{ Str::limit($doc['label'], 14) }}</span>
                                                @endif
                                            @else
                                                @if(!empty($request->{$doc['field']}))
                                                    <button type="button"
                                                            class="doc-badge btn bg-success text-white"
                                                            data-type="file"
                                                            data-url="{{ asset('storage/' . $request->{$doc['field']}) }}"
                                                            title="Preview {{ $doc['label'] }} PDF">
                                                        <i class="bi bi-download"></i>
                                                        {{ Str::limit($doc['label'], 18) }}
                                                    </button>
                                                @else
                                                    <span class="doc-missing">{{ Str::limit($doc['label'], 14) }}</span>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>

                                    {{-- Hidden vacancy text (for preview modal) --}}
                                    @if(!empty($request->job_vacancies_text))
                                        <div id="vacancy-text-{{ $request->id }}" class="d-none">
                                            {!! nl2br(e($request->job_vacancies_text)) !!}
                                        </div>
                                    @endif
                                </td>
                                <td class="date-cell"><small>{{ $request->created_at->format('d M, Y') }}</small></td>
                                <td class="text-center action-cell">
                                    <form method="POST" class="action-btns">
                                        @csrf
                                        <a href="{{ route('admin.lra-sra.review', $request) }}"
                                           class="btn btn-sm btn-info" title="Review this request">
                                            <i class="bi bi-eye"></i> Review
                                        </a>
                                        <button type="submit" formaction="{{ route('admin.lra-sra.approve', $request) }}"
                                                class="btn btn-sm btn-success" title="Approve this request">
                                            <i class="bi bi-check-circle"></i> Approve
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#rejectModal{{ $request->id }}" title="Reject this request">
                                            <i class="bi bi-x-circle"></i> Reject
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Rejection Modal -->
                            <div class="modal fade" id="rejectModal{{ $request->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Reject {{ strtoupper($request->activity_type) }} Request</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST" action="{{ route('admin.lra-sra.reject', $request) }}">
                                            @csrf
                                            <div class="modal-body">
                                                <p class="text-muted mb-3">Rejecting: <strong>{{ $request->employer?->name ?? 'N/A' }}</strong> - <span class="text-uppercase fw-bold">{{ $request->activity_type }}</span></p>
                                                <div class="mb-3">
                                                    <label for="rejection_note_{{ $request->id }}" class="form-label">
                                                        Rejection Note <span class="text-danger">*</span>
                                                    </label>
                                                    <textarea
                                                        id="rejection_note_{{ $request->id }}"
                                                        name="notes"
                                                        class="form-control"
                                                        rows="4"
                                                        placeholder="Explain why this request is being rejected..."
                                                        required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Reject</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $pendingRequests->links('pagination::bootstrap-5') }}
                </div>

                {{-- Document preview modal --}}
                <div class="modal fade" id="docPreviewModal" tabindex="-1">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Document preview</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div id="docPreviewContainer">
                                    <!-- iframe or text will be injected here -->
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="empty-approval-state" role="alert">
                    <i class="bi bi-check-circle-fill"></i>
                    <div>
                        <strong>All caught up!</strong>
                        <div>No pending LRA/SRA approvals to review.</div>
                    </div>
                </div>
            @endif
        </div>

        <div class="dashboard-card history-card">
            <div class="approval-card-header">
                <div>
                    <h2 class="approval-card-title">Recent Request History</h2>
                    <p class="approval-card-subtitle">Latest approved and rejected LRA/SRA requests, including issued certificates.</p>
                </div>
            </div>

            @if($recentRequests->count() > 0)
                <div class="table-shell">
                <table class="table data-table w-100">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Employer</th>
                            <th>Status</th>
                            <th>Certificate</th>
                            <th>Updated</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentRequests as $request)
                            <tr>
                                <td>
                                    <span class="badge badge-activity {{ $request->activity_type === 'sra' ? 'bg-primary' : 'bg-info' }}">
                                        {{ strtoupper($request->activity_type) }}
                                    </span>
                                </td>
                                <td>
                                    <strong>{{ Str::limit($request->employer?->name ?? 'N/A', 28) }}</strong>
                                    <div class="text-muted small">{{ $request->created_at->format('d M, Y') }}</div>
                                </td>
                                <td>
                                    <span class="status-pill status-pill--{{ $request->status }}">
                                        <i class="bi {{ $request->status === 'approved' ? 'bi-check-circle-fill' : 'bi-x-circle-fill' }}"></i>
                                        {{ $request->status }}
                                    </span>
                                </td>
                                <td>
                                    @if($request->certification_path)
                                        <a href="{{ route('admin.lra-sra.view-certification', $request) }}"
                                           class="cert-link"
                                           target="_blank">
                                            <i class="bi bi-file-earmark-pdf-fill"></i>
                                            View certificate
                                        </a>
                                        @if($request->certification_generated_at)
                                            <div class="text-muted small">
                                                {{ \Carbon\Carbon::parse($request->certification_generated_at)->timezone('Asia/Manila')->format('d M, Y') }}
                                            </div>
                                        @endif
                                    @else
                                        <span class="cert-missing">No certificate</span>
                                    @endif
                                </td>
                                <td>
                                    <small>{{ $request->updated_at->format('d M, Y') }}</small>
                                    @if($request->approvedBy)
                                        <div class="text-muted small">by {{ Str::limit($request->approvedBy->name, 22) }}</div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="action-btns">
                                    <a href="{{ route('admin.lra-sra.review', $request) }}"
                                       class="btn btn-sm btn-outline-primary"
                                       title="View request details">
                                        <i class="bi bi-eye"></i> Details
                                    </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            @else
                <div class="alert alert-light border mb-0" role="alert">
                    <i class="bi bi-clock-history me-2"></i>
                    No approved or rejected LRA/SRA requests yet.
                </div>
            @endif
        </div>
    </div>
    </div>

@endsection

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function(){
        const modalEl = document.getElementById('docPreviewModal');
        if (!modalEl) return;
        const bsModal = new bootstrap.Modal(modalEl);
        const container = modalEl.querySelector('#docPreviewContainer');

        document.querySelectorAll('.doc-badge').forEach(btn => {
            btn.addEventListener('click', function(e){
                const type = btn.getAttribute('data-type');
                container.innerHTML = '';
                if (type === 'file') {
                    const url = btn.getAttribute('data-url');
                    const iframe = document.createElement('iframe');
                    iframe.src = url;
                    iframe.style.width = '100%';
                    iframe.style.height = '70vh';
                    iframe.frameBorder = 0;
                    iframe.allowFullscreen = true;
                    container.appendChild(iframe);
                } else if (type === 'text') {
                    const vid = btn.getAttribute('data-vacancy-id');
                    const source = document.getElementById('vacancy-text-' + vid);
                    const div = document.createElement('div');
                    div.className = 'p-3';
                    div.innerHTML = source ? source.innerHTML : '<em>No text provided.</em>';
                    container.appendChild(div);
                }
                bsModal.show();
            });
        });
    });
    </script>
    @endpush
