@extends('layouts.admin-dashboard')

@section('title', 'Contact Submissions | PESO Admin')

<?php
    $pageTitle = 'Contact Submissions';
    $pageSubtitle = 'Review messages sent from the landing page contact form';
    $pageIcon = 'bi-envelope-paper-fill';
?>

@section('content')
<div class="admin-dashboard">
    <style>
        .contact-shell { display: grid; gap: 1rem; }
        .contact-panel { background: white; border-radius: 18px; border: 1px solid #e7edf5; box-shadow: 0 6px 18px rgba(13,31,60,0.05); overflow: hidden; }
        .contact-panel-head { padding: 1.15rem 1.25rem; border-bottom: 1px solid #edf2f7; display: flex; justify-content: space-between; align-items: center; gap: 1rem; }
        .contact-panel-head h3 { margin: 0; font-size: 1rem; font-weight: 800; color: #0d1f3c; }
        .contact-panel-head p { margin: 0; color: #6b7280; font-size: 0.9rem; }
        .contact-list { display: grid; gap: 0.9rem; padding: 1rem 1.25rem 1.25rem; }
        .contact-item { background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%); padding: 1rem 1.1rem; border-radius: 14px; border: 1px solid #edf2f7; display: flex; gap: 1rem; align-items: flex-start; }
        .contact-icon { width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex: 0 0 auto; font-size: 1.05rem; background: rgba(220,38,38,0.12); color: #dc2626; }
        .contact-info { flex: 1; min-width: 0; }
        .contact-title { font-weight: 800; color: #0d1f3c; margin-bottom: 0.3rem; }
        .contact-message { color: #5f6c80; font-size: 14px; margin-bottom: 0.55rem; line-height: 1.55; }
        .contact-meta { display: flex; flex-wrap: wrap; gap: 0.5rem 1rem; align-items: center; font-size: 12px; color: #8b95a7; }
        .contact-actions { display: flex; gap: 0.5rem; align-items: flex-start; flex-shrink: 0; }
        .btn-small { padding: 0.55rem 0.9rem; border: none; border-radius: 999px; font-size: 12px; font-weight: 700; cursor: pointer; transition: all 0.2s ease; }
        .btn-primary-custom { background: #dc2626; color: #fff; text-decoration: none; }
        .btn-primary-custom:hover { background: #b91c1c; }
        .btn-secondary-custom { background: #eef2f7; color: #1f2937; text-decoration: none; }
        .btn-secondary-custom:hover { background: #dbe3ee; }
        .contact-empty { background: #fff; border: 1px dashed #dbe4ee; border-radius: 16px; padding: 2.25rem 1.5rem; text-align: center; color: #64748b; }
        .contact-filters { display: flex; gap: 0.75rem; flex-wrap: wrap; }
    </style>

    <div class="contact-shell">
        <div class="contact-panel">
            <div class="contact-panel-head">
                <div>
                    <h3>Contact Inbox</h3>
                    <p>All landing page inquiries saved to the database.</p>
                </div>
                <div class="contact-filters">
                    <span class="badge text-bg-danger rounded-pill px-3 py-2">{{ $submissionCount ?? 0 }} messages</span>
                </div>
            </div>

            <div class="contact-list">
                @forelse ($submissions as $submission)
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="bi bi-envelope-paper-fill"></i>
                        </div>
                        <div class="contact-info">
                            <div class="contact-title">{{ $submission->subject }}</div>
                            <div class="contact-message">{{ $submission->name }} &lt;{{ $submission->email }}&gt;{{ $submission->phone ? ' • ' . $submission->phone : '' }}</div>
                            <div class="contact-meta">
                                <span><i class="bi bi-clock me-1"></i>{{ $submission->created_at?->format('M d, Y h:i A') }}</span>
                                <span class="badge text-bg-light border rounded-pill">Stored</span>
                            </div>
                        </div>
                        <div class="contact-actions">
                            <a href="{{ route('admin.contact-submissions.show', $submission) }}" class="btn-small btn-primary-custom">View</a>
                        </div>
                    </div>
                @empty
                    <div class="contact-empty">
                        <div class="fw-semibold mb-1">No contact submissions yet</div>
                        <div class="small">Messages from the landing page will show here once users start sending them.</div>
                    </div>
                @endforelse
            </div>
        </div>

        <div>
            {{ $submissions->links() }}
        </div>
    </div>
</div>
@endsection
