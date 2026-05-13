@extends('dashboard.employer.layout')

@section('title', 'Recommended Applicants - PESO')
@section('hide_header')
@endsection

@section('content')

<style>
    .recommended-page {
        --ap-primary: #075cb2;
        --ap-primary-soft: #ecf3ff;
        --ap-border: #d9e6f6;
        --ap-shadow: 0 12px 26px rgba(21, 61, 117, 0.08);
        --ap-landing-blue: #075cb2;
        --ap-landing-blue-soft: #3498db;
        --ap-landing-blue-deep: #2980b9;
    }
    .page-hero {
        background: linear-gradient(135deg, #16a34a 0%, #22c55e 100%);
        border: 2px solid rgba(22, 163, 74, 0.5);
        border-radius: 18px;
        padding: 2rem;
        box-shadow: 0 12px 24px rgba(22, 163, 74, 0.28);
        margin-bottom: 2rem;
    }
    .page-hero-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .hero-copy h1 {
        color: white;
        font-size: 1.75rem;
        margin: 0;
        font-weight: 700;
    }
    .hero-copy p {
        color: rgba(255, 255, 255, 0.9);
        margin: 0.5rem 0 0 0;
        font-size: 0.95rem;
    }
    .hero-meta {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        background: rgba(255, 255, 255, 0.16);
        border: 1px solid rgba(255, 255, 255, 0.4);
        color: #ffffff;
        border-radius: 999px;
        padding: 0.55rem 1rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-top: 1.5rem;
    }
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border-left: 4px solid;
    }
    .stat-card.pending {
        border-left-color: #f59e0b;
    }
    .stat-card.accepted {
        border-left-color: #10b981;
    }
    .stat-card.rejected {
        border-left-color: #ef4444;
    }
    .stat-card.hired {
        border-left-color: #3b82f6;
    }
    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937;
    }
    .stat-label {
        font-size: 0.85rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }

    .filter-section {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
    }
    .filter-title {
        font-size: 1rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 1rem;
    }
    .filter-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        align-items: flex-end;
    }
    .filter-group {
        display: flex;
        flex-direction: column;
    }
    .filter-group label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .filter-group select,
    .filter-group input {
        padding: 0.6rem 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 0.9rem;
    }
    .filter-buttons {
        display: flex;
        gap: 0.75rem;
    }
    .btn-filter {
        background: #075cb2;
        color: white;
        border: none;
        padding: 0.6rem 1.5rem;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s;
    }
    .btn-filter:hover {
        background: #054a8a;
    }
    .btn-reset {
        background: #e5f3ff;
        color: #075cb2;
        border: 1px solid #075cb2;
        padding: 0.6rem 1.5rem;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    .btn-reset:hover {
        background: #075cb2;
        color: white;
    }

    .results-section {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }
    .results-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e5e7eb;
    }
    .results-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1f2937;
    }
    .results-count {
        background: #075cb2;
        color: white;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .recommendations-table {
        width: 100%;
        border-collapse: collapse;
    }
    .recommendations-table thead th {
        background: #f9fafb;
        padding: 1rem;
        text-align: left;
        font-size: 0.85rem;
        font-weight: 600;
        color: #374151;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e5e7eb;
    }
    .recommendations-table tbody td {
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb;
        color: #374151;
        font-size: 0.9rem;
    }
    .recommendations-table tbody tr:hover {
        background: #f9fafb;
    }

    .applicant-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .applicant-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #075cb2;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1rem;
    }
    .applicant-details h4 {
        margin: 0;
        font-size: 0.9rem;
        font-weight: 600;
        color: #1f2937;
    }
    .applicant-details p {
        margin: 0.25rem 0 0 0;
        font-size: 0.8rem;
        color: #6b7280;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.4rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        white-space: nowrap;
    }
    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }
    .status-accepted {
        background: #d1fae5;
        color: #065f46;
    }
    .status-rejected {
        background: #fee2e2;
        color: #7f1d1d;
    }
    .status-hired {
        background: #dbeafe;
        color: #1e40af;
    }

    .recommender-info {
        font-size: 0.85rem;
        color: #6b7280;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    .btn-action {
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        border: none;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }
    .btn-view {
        background: #16a34a;
        color: white;
    }
    .btn-view:hover {
        background: #15803d;
    }
    .btn-accept {
        background: #10b981;
        color: white;
    }
    .btn-accept:hover {
        background: #059669;
    }
    .btn-reject {
        background: #ef4444;
        color: white;
    }
    .btn-reject:hover {
        background: #dc2626;
    }
    .btn-hire {
        background: #3b82f6;
        color: white;
    }
    .btn-hire:hover {
        background: #2563eb;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #6b7280;
    }
    .empty-state-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }
    .empty-state-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }
    .modal.active {
        display: flex;
    }
    .modal-content {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        max-width: 500px;
        width: 90%;
        box-shadow: 0 20px 25px rgba(0, 0, 0, 0.15);
    }
    .modal-header {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 1rem;
    }
    .modal-body {
        margin-bottom: 1.5rem;
    }
    .modal-form-group {
        margin-bottom: 1rem;
    }
    .modal-label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }
    .modal-input {
        width: 100%;
        padding: 0.6rem;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 0.9rem;
    }
    .modal-footer {
        display: flex;
        gap: 0.75rem;
        justify-content: flex-end;
    }
    .btn-modal {
        padding: 0.6rem 1.5rem;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    .btn-modal-primary {
        background: #075cb2;
        color: white;
    }
    .btn-modal-primary:hover {
        background: #054a8a;
    }
    .btn-modal-secondary {
        background: #e5e7eb;
        color: #374151;
    }
    .btn-modal-secondary:hover {
        background: #d1d5db;
    }
</style>

<div class="recommended-page">
    <div class="page-hero">
        <div class="page-hero-content">
            <div class="hero-copy">
                <h1>Recommended Applicants</h1>
                <p>View and manage applicants recommended to you by other employers or PESO staff.</p>
            </div>
            <div class="hero-meta">
                {{ count($recommendations) }} Recommendations
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    @if(count($recommendations) > 0)
    <div class="stats-grid">
        <div class="stat-card pending">
            <div class="stat-number">{{ $pendingCount ?? 0 }}</div>
            <div class="stat-label">Pending Review</div>
        </div>
        <div class="stat-card accepted">
            <div class="stat-number">{{ $acceptedCount ?? 0 }}</div>
            <div class="stat-label">Accepted</div>
        </div>
        <div class="stat-card rejected">
            <div class="stat-number">{{ $rejectedCount ?? 0 }}</div>
            <div class="stat-label">Rejected</div>
        </div>
        <div class="stat-card hired">
            <div class="stat-number">{{ $hiredCount ?? 0 }}</div>
            <div class="stat-label">Hired</div>
        </div>
    </div>
    @endif

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-title">Filter Recommendations</div>
        <form method="GET" action="{{ route('employer.recommendations.received') }}" id="filterForm">
            <div class="filter-row">
                <div class="filter-group">
                    <label for="status-filter">Recommendation Status</label>
                    <select id="status-filter" name="status" onchange="document.getElementById('filterForm').submit()">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="hired" {{ request('status') === 'hired' ? 'selected' : '' }}>Hired</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="search">Search by Name</label>
                    <input type="text" id="search" name="search" placeholder="Applicant name..." value="{{ request('search') }}">
                </div>

                <div class="filter-buttons">
                    <button type="submit" class="btn-filter">Filter</button>
                    <a href="{{ route('employer.recommendations.received') }}" class="btn-reset">Reset</a>
                </div>
            </div>
        </form>
    </div>

    <!-- Results Section -->
    <div class="results-section">
        <div class="results-header">
            <div class="results-title">Recommendation Results</div>
            <div class="results-count">{{ count($recommendations) }} records</div>
        </div>

        @if(count($recommendations) > 0)
            <table class="recommendations-table">
                <thead>
                    <tr>
                        <th>Applicant</th>
                        <th>Position</th>
                        <th>Recommended By</th>
                        <th>Status</th>
                        <th>Date Received</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recommendations as $recommendation)
                    <tr>
                        <td>
                            <div class="applicant-info">
                                <div class="applicant-avatar">
                                    {{ substr($recommendation->jobApplication->user->name, 0, 1) }}
                                </div>
                                <div class="applicant-details">
                                    <h4>{{ $recommendation->jobApplication->user->name }}</h4>
                                    <p>{{ $recommendation->jobApplication->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <strong>{{ $recommendation->job->title }}</strong>
                            <br>
                            <small style="color: #6b7280;">{{ $recommendation->job->location }}</small>
                        </td>
                        <td>
                            <div class="recommender-info">
                                <strong>{{ $recommendation->recommendedBy->name }}</strong>
                                <br>
                                <small>{{ $recommendation->recommendedBy->companyProfile?->company_name ?? 'PESO Staff' }}</small>
                            </div>
                        </td>
                        <td>
                            @php
                                $statusClass = 'status-' . $recommendation->status;
                                $statusLabel = ucfirst($recommendation->status);
                            @endphp
                            <span class="status-badge {{ $statusClass }}">{{ $statusLabel }}</span>
                            @if($recommendation->isNew())
                                <div style="margin-top: 0.5rem;">
                                    <span style="background: #fef3c7; color: #92400e; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">NEW</span>
                                </div>
                            @endif
                        </td>
                        <td>
                            {{ $recommendation->created_at->format('M d, Y') }}
                            <br>
                            <small style="color: #6b7280;">{{ $recommendation->created_at->diffForHumans() }}</small>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action btn-view" onclick="openRecommendationModal({{ $recommendation->id }})">View Details</button>
                                
                                @if($recommendation->status === 'pending')
                                    <form method="POST" action="{{ route('employer.recommendations.accept', $recommendation) }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-action btn-accept">Accept</button>
                                    </form>
                                    <button class="btn-action btn-reject" onclick="openRejectModal({{ $recommendation->id }})">Reject</button>
                                @elseif($recommendation->status === 'accepted')
                                    <form method="POST" action="{{ route('employer.recommendations.hire', $recommendation) }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-action btn-hire">Mark Hired</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div style="margin-top: 2rem; display: flex; justify-content: center;">
                {{ $recommendations->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">📭</div>
                <div class="empty-state-title">No Recommendations Yet</div>
                <p>You don't have any applicant recommendations at the moment. Other employers or PESO staff will send you recommendations here.</p>
            </div>
        @endif
    </div>
</div>

<!-- Recommendation Details Modal -->
<div id="detailsModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">Recommendation Details</div>
        <div class="modal-body" id="detailsContent">
            <!-- Loaded via JavaScript -->
        </div>
        <div class="modal-footer">
            <button class="btn-modal btn-modal-secondary" onclick="closeModal('detailsModal')">Close</button>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">Reject Recommendation</div>
        <form id="rejectForm" method="POST">
            @csrf
            <div class="modal-body">
                <div class="modal-form-group">
                    <label class="modal-label">Reason (optional)</label>
                    <textarea class="modal-input" name="response_notes" rows="4" placeholder="Explain why you're rejecting this recommendation..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal btn-modal-secondary" onclick="closeModal('rejectModal')">Cancel</button>
                <button type="submit" class="btn-modal btn-modal-primary">Reject Recommendation</button>
            </div>
        </form>
    </div>
</div>

<script>
function openRecommendationModal(recommendationId) {
    // Fetch recommendation details
    fetch(`/employer/api/recommendations/${recommendationId}`)
        .then(response => response.json())
        .then(data => {
            const html = `
                <div style="margin-bottom: 1.5rem;">
                    <h4 style="margin: 0 0 0.5rem 0; color: #1f2937;">Applicant</h4>
                    <p style="margin: 0; font-weight: 600;">${data.applicant_name}</p>
                    <p style="margin: 0.25rem 0 0 0; color: #6b7280; font-size: 0.9rem;">${data.applicant_email}</p>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <h4 style="margin: 0 0 0.5rem 0; color: #1f2937;">Position</h4>
                    <p style="margin: 0; font-weight: 600;">${data.job_title}</p>
                    <p style="margin: 0.25rem 0 0 0; color: #6b7280; font-size: 0.9rem;">${data.job_location}</p>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <h4 style="margin: 0 0 0.5rem 0; color: #1f2937;">Recommended By</h4>
                    <p style="margin: 0; font-weight: 600;">${data.recommender_name}</p>
                    <p style="margin: 0.25rem 0 0 0; color: #6b7280; font-size: 0.9rem;">${data.recommender_company || 'PESO Staff'}</p>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <h4 style="margin: 0 0 0.5rem 0; color: #1f2937;">Recommendation Reason</h4>
                    <p style="margin: 0; color: #6b7280;">${data.reason || 'No reason provided'}</p>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <h4 style="margin: 0 0 0.5rem 0; color: #1f2937;">Status</h4>
                    <p style="margin: 0; font-weight: 600; color: #16a34a;">${data.status}</p>
                </div>

                <div>
                    <h4 style="margin: 0 0 0.5rem 0; color: #1f2937;">Date Received</h4>
                    <p style="margin: 0; color: #6b7280;">${data.created_at}</p>
                </div>
            `;
            document.getElementById('detailsContent').innerHTML = html;
        });
    
    document.getElementById('detailsModal').classList.add('active');
}

function openRejectModal(recommendationId) {
    document.getElementById('rejectForm').action = `/employer/recommendations/${recommendationId}/reject`;
    document.getElementById('rejectModal').classList.add('active');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('active');
}

// Close modal when clicking outside
document.querySelectorAll('.modal').forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.remove('active');
        }
    });
});
</script>

@endsection
