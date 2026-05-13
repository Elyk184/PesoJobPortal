@extends('dashboard.employer.layout')

@section('title', 'Pending Follow-ups - PESO')
@section('hide_header')
@endsection

@section('content')

<style>
    .followups-page {
        --accent: #f59e0b;
    }
    .page-hero {
        background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
        border: 2px solid rgba(245, 158, 11, 0.5);
        border-radius: 18px;
        padding: 2rem;
        box-shadow: 0 12px 24px rgba(245, 158, 11, 0.28);
        margin-bottom: 2rem;
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

    .alerts-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    .alert-box {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border-left: 4px solid;
    }
    .alert-box.warning {
        border-left-color: #f59e0b;
    }
    .alert-box.info {
        border-left-color: #3b82f6;
    }
    .alert-number {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1f2937;
    }
    .alert-label {
        font-size: 0.85rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }

    .tabs {
        display: flex;
        gap: 0.5rem;
        border-bottom: 2px solid #e5e7eb;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }
    .tab {
        padding: 0.75rem 1.5rem;
        border: none;
        background: none;
        cursor: pointer;
        font-size: 0.9rem;
        font-weight: 600;
        color: #6b7280;
        border-bottom: 3px solid transparent;
        transition: all 0.3s;
    }
    .tab.active {
        color: #f59e0b;
        border-bottom-color: #f59e0b;
    }

    .recommendations-list {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .recommendation-item {
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 1.25rem;
        margin-bottom: 1rem;
        transition: all 0.3s;
    }
    .recommendation-item:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-color: #f59e0b;
    }
    .recommendation-item:last-child {
        margin-bottom: 0;
    }

    .item-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    .item-info {
        flex: 1;
    }
    .item-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
    }
    .item-subtitle {
        font-size: 0.85rem;
        color: #6b7280;
        margin: 0.3rem 0 0 0;
    }

    .item-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #f3f4f6;
    }
    .detail {
        display: flex;
        flex-direction: column;
    }
    .detail-label {
        font-size: 0.75rem;
        color: #6b7280;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 0.25rem;
    }
    .detail-value {
        font-size: 0.9rem;
        color: #1f2937;
        font-weight: 500;
    }

    .urgency-indicator {
        display: inline-block;
        padding: 0.3rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
    }
    .urgency-high {
        background: #fee2e2;
        color: #7f1d1d;
    }
    .urgency-medium {
        background: #fef3c7;
        color: #92400e;
    }
    .urgency-low {
        background: #dbeafe;
        color: #1e40af;
    }

    .item-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 1rem;
    }
    .btn-action {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    .btn-send {
        background: #f59e0b;
        color: white;
    }
    .btn-send:hover {
        background: #d97706;
    }
    .btn-view {
        background: #3b82f6;
        color: white;
    }
    .btn-view:hover {
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

    .timeline {
        position: relative;
        padding-left: 2rem;
    }
    .timeline::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e5e7eb;
    }
    .timeline-item {
        position: relative;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -1.1rem;
        top: 0.2rem;
        width: 0.8rem;
        height: 0.8rem;
        background: #f59e0b;
        border: 2px solid white;
        border-radius: 50%;
        box-shadow: 0 0 0 2px #f59e0b;
    }
    .timeline-text {
        font-size: 0.9rem;
        color: #6b7280;
    }
    .timeline-text strong {
        color: #1f2937;
    }
</style>

<div class="followups-page">
    <div class="page-hero">
        <div class="hero-copy">
            <h1>Pending Follow-ups</h1>
            <p>Manage and track follow-ups for recommendations awaiting response.</p>
        </div>
    </div>

    <!-- Alert Boxes -->
    <div class="alerts-container">
        <div class="alert-box warning">
            <div class="alert-number">{{ $stats['total_pending'] }}</div>
            <div class="alert-label">Total Pending</div>
        </div>
        <div class="alert-box warning">
            <div class="alert-number">{{ $stats['due_for_followup'] }}</div>
            <div class="alert-label">Due for Follow-up</div>
        </div>
        <div class="alert-box info">
            <div class="alert-number">{{ $stats['can_send_followup'] }}</div>
            <div class="alert-label">Ready to Follow-up</div>
        </div>
        <div class="alert-box info">
            <div class="alert-number">{{ $stats['not_viewed'] }}</div>
            <div class="alert-label">Not Yet Viewed</div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="tabs">
        <button class="tab active" onclick="switchTab('all')">All Pending</button>
        <button class="tab" onclick="switchTab('due')">Due for Follow-up</button>
        <button class="tab" onclick="switchTab('no-view')">Not Yet Viewed</button>
    </div>

    <!-- All Pending Tab -->
    <div id="tab-all" class="recommendations-list">
        @if($allPending->count() > 0)
            @foreach($allPending as $recommendation)
            <div class="recommendation-item">
                <div class="item-header">
                    <div class="item-info">
                        <p class="item-title">{{ $recommendation->jobApplication->user->name }}</p>
                        <p class="item-subtitle">Applied for: {{ $recommendation->job->title }}</p>
                    </div>
                    @php
                        $daysSince = $recommendation->daysSinceCreation();
                        if ($daysSince >= 7) {
                            $urgency = 'high';
                            $urgencyLabel = 'High Priority';
                        } elseif ($daysSince >= 3) {
                            $urgency = 'medium';
                            $urgencyLabel = 'Medium Priority';
                        } else {
                            $urgency = 'low';
                            $urgencyLabel = 'Low Priority';
                        }
                    @endphp
                    <span class="urgency-indicator urgency-{{ $urgency }}">{{ $urgencyLabel }}</span>
                </div>
                
                <div class="item-details">
                    <div class="detail">
                        <span class="detail-label">Recipient</span>
                        <span class="detail-value">{{ $recommendation->recommendedTo?->name ?? 'PESO Pool' }}</span>
                    </div>
                    <div class="detail">
                        <span class="detail-label">Sent On</span>
                        <span class="detail-value">{{ $recommendation->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="detail">
                        <span class="detail-label">Status</span>
                        <span class="detail-value">
                            @if($recommendation->viewed_at)
                            ✓ Viewed on {{ $recommendation->viewed_at->format('M d') }}
                            @else
                            ⏳ Not yet opened
                            @endif
                        </span>
                    </div>
                    <div class="detail">
                        <span class="detail-label">Follow-ups Sent</span>
                        <span class="detail-value">{{ $recommendation->followup_count }} / 2</span>
                    </div>
                </div>

                <div class="item-actions">
                    @if($recommendation->status === 'pending' && $recommendation->canSendAnotherFollowup())
                    <form method="POST" action="{{ route('employer.recommendations.followup', $recommendation) }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-action btn-send">Send Follow-up</button>
                    </form>
                    @elseif($recommendation->status === 'pending' && !$recommendation->canSendAnotherFollowup())
                    <button class="btn-action btn-send" disabled>Max Follow-ups Reached</button>
                    @endif
                    <button class="btn-action btn-view" onclick="openDetails({{ $recommendation->id }})">View Details</button>
                </div>
            </div>
            @endforeach
        @else
            <div class="empty-state">
                <div class="empty-state-icon">✨</div>
                <div class="empty-state-title">All Clear!</div>
                <p>No pending recommendations that need follow-up. Great work staying on top of things!</p>
            </div>
        @endif
    </div>

    <!-- Due for Follow-up Tab -->
    <div id="tab-due" class="recommendations-list" style="display: none;">
        @if($dueForFollowup->count() > 0)
            @foreach($dueForFollowup as $recommendation)
            <div class="recommendation-item">
                <div class="item-header">
                    <div class="item-info">
                        <p class="item-title">{{ $recommendation->jobApplication->user->name }} — {{ $recommendation->job->title }}</p>
                        <p class="item-subtitle">
                            <strong style="color: #dc2626;">Due for follow-up</strong> · Sent {{ $recommendation->daysSinceCreation() }} days ago
                        </p>
                    </div>
                    <span class="urgency-indicator urgency-high">High Priority</span>
                </div>

                <div class="item-actions">
                    @if($recommendation->canSendAnotherFollowup())
                    <form method="POST" action="{{ route('employer.recommendations.followup', $recommendation) }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-action btn-send">Send Follow-up Now</button>
                    </form>
                    @endif
                    <button class="btn-action btn-view" onclick="openDetails({{ $recommendation->id }})">View Details</button>
                </div>
            </div>
            @endforeach
        @else
            <div class="empty-state">
                <div class="empty-state-icon">✓</div>
                <div class="empty-state-title">No Follow-ups Needed</div>
                <p>All recommendations have been followed up on or are within the follow-up window.</p>
            </div>
        @endif
    </div>

    <!-- Not Viewed Tab -->
    <div id="tab-no-view" class="recommendations-list" style="display: none;">
        @if($noResponse->count() > 0)
            @foreach($noResponse as $recommendation)
            <div class="recommendation-item">
                <div class="item-header">
                    <div class="item-info">
                        <p class="item-title">{{ $recommendation->jobApplication->user->name }} — {{ $recommendation->job->title }}</p>
                        <p class="item-subtitle">Sent to {{ $recommendation->recommendedTo?->name ?? 'PESO Pool' }}</p>
                    </div>
                    <span class="urgency-indicator urgency-medium">Awaiting Response</span>
                </div>

                <div class="item-details">
                    <div class="detail">
                        <span class="detail-label">Status</span>
                        <span class="detail-value" style="color: #dc2626;">Not yet opened</span>
                    </div>
                    <div class="detail">
                        <span class="detail-label">Days Since Sent</span>
                        <span class="detail-value">{{ $recommendation->daysSinceCreation() }} days</span>
                    </div>
                </div>

                <div class="item-actions">
                    @if($recommendation->status === 'pending' && $recommendation->isDueForFollowup() && $recommendation->canSendAnotherFollowup())
                    <form method="POST" action="{{ route('employer.recommendations.followup', $recommendation) }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-action btn-send">Send Reminder</button>
                    </form>
                    @endif
                    <button class="btn-action btn-view" onclick="openDetails({{ $recommendation->id }})">View Details</button>
                </div>
            </div>
            @endforeach
        @else
            <div class="empty-state">
                <div class="empty-state-icon">👁️</div>
                <div class="empty-state-title">All Recommendations Viewed</div>
                <p>Great! All your recommendations have been opened and reviewed.</p>
            </div>
        @endif
    </div>
</div>

<script>
function switchTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.recommendations-list').forEach(el => {
        el.style.display = 'none';
    });
    document.querySelectorAll('.tab').forEach(el => {
        el.classList.remove('active');
    });

    // Show selected tab
    document.getElementById(`tab-${tabName}`).style.display = 'block';
    event.target.classList.add('active');
}

function openDetails(recommendationId) {
    alert('Open recommendation details for ID: ' + recommendationId);
    // You can implement a modal here
}
</script>

@endsection
