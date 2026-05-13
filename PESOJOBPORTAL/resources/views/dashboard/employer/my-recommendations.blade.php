@extends('dashboard.employer.layout')

@section('title', 'Sent Recommendations - PESO')
@section('hide_header')
@endsection

@section('content')

<style>
    .sent-recommendations-page {
        --ap-landing-blue: #075cb2;
        --ap-landing-blue-soft: #3498db;
    }
    .page-hero {
        background: linear-gradient(135deg, #7c3aed 0%, #a78bfa 100%);
        border: 2px solid rgba(124, 58, 237, 0.5);
        border-radius: 18px;
        padding: 2rem;
        box-shadow: 0 12px 24px rgba(124, 58, 237, 0.28);
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
        margin-bottom: 2rem;
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

    .table-container {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }
    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e5e7eb;
    }
    .table-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1f2937;
    }
    .table-count {
        background: #7c3aed;
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

    .recipient-info {
        font-size: 0.9rem;
        font-weight: 600;
        color: #1f2937;
    }
    .recipient-company {
        font-size: 0.8rem;
        color: #6b7280;
        margin-top: 0.25rem;
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

    .followup-badge {
        display: inline-block;
        background: #e0e7ff;
        color: #4338ca;
        padding: 0.3rem 0.6rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-top: 0.4rem;
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
    .btn-followup {
        background: #7c3aed;
        color: white;
    }
    .btn-followup:hover {
        background: #6d28d9;
    }
    .btn-followup:disabled {
        background: #d1d5db;
        color: #6b7280;
        cursor: not-allowed;
    }
    .btn-view {
        background: #6b7280;
        color: white;
    }
    .btn-view:hover {
        background: #4b5563;
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

    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }
    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }
    .alert-warning {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fcd34d;
    }
</style>

<div class="sent-recommendations-page">
    <div class="page-hero">
        <div class="page-hero-content">
            <div class="hero-copy">
                <h1>Sent Recommendations</h1>
                <p>Track applicant recommendations you've sent to other employers or PESO staff.</p>
            </div>
            <div class="hero-meta">
                {{ count($recommendations) }} Recommendations Sent
            </div>
        </div>
    </div>

    <!-- Success/Warning Messages -->
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-warning">
        {{ session('error') }}
    </div>
    @endif

    <!-- Stats Cards -->
    @if(count($recommendations) > 0)
    <div class="stats-grid">
        <div class="stat-card pending">
            <div class="stat-number">{{ $recommendations->where('status', 'pending')->count() }}</div>
            <div class="stat-label">Pending Response</div>
        </div>
        <div class="stat-card accepted">
            <div class="stat-number">{{ $recommendations->where('status', 'accepted')->count() }}</div>
            <div class="stat-label">Accepted</div>
        </div>
        <div class="stat-card rejected">
            <div class="stat-number">{{ $recommendations->where('status', 'rejected')->count() }}</div>
            <div class="stat-label">Rejected</div>
        </div>
        <div class="stat-card hired">
            <div class="stat-number">{{ $recommendations->where('status', 'hired')->count() }}</div>
            <div class="stat-label">Hired</div>
        </div>
    </div>
    @endif

    <!-- Results -->
    <div class="table-container">
        <div class="table-header">
            <div class="table-title">Recommendation Results</div>
            <div class="table-count">{{ count($recommendations) }} records</div>
        </div>

        @if(count($recommendations) > 0)
            <table class="recommendations-table">
                <thead>
                    <tr>
                        <th>Applicant</th>
                        <th>Position</th>
                        <th>Sent To</th>
                        <th>Status</th>
                        <th>Follow-ups</th>
                        <th>Date Sent</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recommendations as $recommendation)
                    <tr>
                        <td>
                            <strong>{{ $recommendation->jobApplication->user->name }}</strong>
                            <br>
                            <small style="color: #6b7280;">{{ $recommendation->jobApplication->user->email }}</small>
                        </td>
                        <td>
                            <strong>{{ $recommendation->job->title }}</strong>
                            <br>
                            <small style="color: #6b7280;">{{ $recommendation->job->location }}</small>
                        </td>
                        <td>
                            <div class="recipient-info">
                                {{ $recommendation->recommendedTo?->name ?? 'PESO Pool' }}
                                @if($recommendation->recommendedTo?->companyProfile)
                                <div class="recipient-company">{{ $recommendation->recommendedTo->companyProfile->company_name }}</div>
                                @endif
                            </div>
                        </td>
                        <td>
                            @php
                                $statusClass = 'status-' . $recommendation->status;
                                $statusLabel = match($recommendation->status) {
                                    'pending' => '⏳ Pending',
                                    'accepted' => '✓ Accepted',
                                    'rejected' => '✗ Rejected',
                                    'hired' => '🎉 Hired',
                                    default => ucfirst($recommendation->status)
                                };
                            @endphp
                            <span class="status-badge {{ $statusClass }}">{{ $statusLabel }}</span>
                        </td>
                        <td>
                            <div style="text-align: center;">
                                <div style="font-size: 1.1rem; font-weight: 700; color: #7c3aed;">{{ $recommendation->followup_count }}</div>
                                <small style="color: #6b7280;">followup{{ $recommendation->followup_count !== 1 ? 's' : '' }}</small>
                                @if($recommendation->last_followup_at)
                                <div class="followup-badge">
                                    Last: {{ $recommendation->last_followup_at->format('M d') }}
                                </div>
                                @endif
                            </div>
                        </td>
                        <td>
                            {{ $recommendation->created_at->format('M d, Y') }}
                            <br>
                            <small style="color: #6b7280;">{{ $recommendation->created_at->diffForHumans() }}</small>
                        </td>
                        <td>
                            <div class="action-buttons">
                                @if($recommendation->status === 'pending')
                                    @if($recommendation->canSendAnotherFollowup())
                                    <form method="POST" action="{{ route('employer.recommendations.followup', $recommendation) }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-action btn-followup" title="Send follow-up reminder">
                                            Follow-up
                                        </button>
                                    </form>
                                    @else
                                    <button class="btn-action btn-followup" disabled title="Maximum follow-ups reached or wait for next opportunity">
                                        Follow-up (Max)
                                    </button>
                                    @endif
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
                <div class="empty-state-icon">📤</div>
                <div class="empty-state-title">No Recommendations Sent Yet</div>
                <p>Start recommending great applicants to other employers or PESO staff! It's a great way to build professional relationships.</p>
            </div>
        @endif
    </div>
</div>

@endsection
