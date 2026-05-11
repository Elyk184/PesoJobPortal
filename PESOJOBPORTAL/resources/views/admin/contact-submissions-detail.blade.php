@extends('layouts.admin-dashboard')

@section('title', 'Contact Submission | PESO Admin')

<?php
    $pageTitle = 'Contact Submission';
    $pageSubtitle = 'Review the full message and manage the record';
    $pageIcon = 'bi-envelope-open-text';
?>

@section('content')
<div class="admin-dashboard">
    <style>
        .detail-shell { display: grid; gap: 1rem; }
        .detail-panel { background: white; border-radius: 18px; border: 1px solid #e7edf5; box-shadow: 0 6px 18px rgba(13,31,60,0.05); overflow: hidden; }
        .detail-head { padding: 1.15rem 1.25rem; border-bottom: 1px solid #edf2f7; display: flex; justify-content: space-between; align-items: center; gap: 1rem; }
        .detail-head h3 { margin: 0; font-size: 1rem; font-weight: 800; color: #0d1f3c; }
        .detail-body { padding: 1.25rem; display: grid; gap: 1rem; }
        .detail-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; }
        .detail-card { background: #f8fbff; border: 1px solid #e7edf5; border-radius: 14px; padding: 1rem; }
        .detail-label { font-size: 12px; text-transform: uppercase; letter-spacing: 0.6px; color: #6b7280; font-weight: 700; margin-bottom: 0.3rem; }
        .detail-value { color: #0d1f3c; font-weight: 700; word-break: break-word; }
        .detail-message { background: #fff; border: 1px solid #e7edf5; border-radius: 14px; padding: 1rem; white-space: pre-line; color: #1f2937; line-height: 1.65; }
        .thread { display: grid; gap: 0.85rem; }
        .thread-message { display: grid; gap: 0.25rem; padding: 0.9rem 1rem; border-radius: 14px; border: 1px solid #e7edf5; background: #f8fbff; }
        .thread-message.admin { background: #f0f9ff; border-color: #bfdbfe; }
        .thread-message.user { background: #fff; }
        .thread-meta { font-size: 12px; color: #64748b; display: flex; justify-content: space-between; gap: 0.75rem; flex-wrap: wrap; }
        .reply-box { display: grid; gap: 0.75rem; padding: 1rem; border: 1px solid #e7edf5; border-radius: 14px; background: #f8fafc; }
        .reply-box textarea { width: 100%; min-height: 140px; border-radius: 12px; border: 1px solid #cbd5e1; padding: 0.85rem 1rem; font: inherit; resize: vertical; }
        .detail-actions { display: flex; gap: 0.75rem; flex-wrap: wrap; }
        .btn-small { padding: 0.55rem 0.9rem; border: none; border-radius: 999px; font-size: 12px; font-weight: 700; cursor: pointer; transition: all 0.2s ease; }
        .btn-danger-custom { background: #dc2626; color: #fff; text-decoration: none; }
        .btn-danger-custom:hover { background: #b91c1c; }
        .btn-light-custom { background: #eef2f7; color: #1f2937; text-decoration: none; }
        .btn-light-custom:hover { background: #dbe3ee; }
    </style>

    <div class="detail-shell">
        <div class="detail-panel">
            <div class="detail-head">
                <div>
                    <h3>{{ $contactSubmission->reference_code }} · {{ $contactSubmission->subject }}</h3>
                    <div class="small text-muted">Status: {{ ucfirst($contactSubmission->status ?? 'open') }} · Submitted {{ $contactSubmission->created_at?->diffForHumans() }}</div>
                </div>
                <div class="detail-actions">
                    <a href="{{ route('admin.contact-submissions') }}" class="btn-small btn-light-custom">Back to inbox</a>
                    <form method="POST" action="{{ route('admin.contact-submissions.destroy', $contactSubmission) }}" onsubmit="return confirm('Delete this contact submission?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-small btn-danger-custom">Delete</button>
                    </form>
                </div>
            </div>

            <div class="detail-body">
                <div class="detail-grid">
                    <div class="detail-card">
                        <div class="detail-label">Name</div>
                        <div class="detail-value">{{ $contactSubmission->name }}</div>
                    </div>
                    <div class="detail-card">
                        <div class="detail-label">Email</div>
                        <div class="detail-value">{{ $contactSubmission->email }}</div>
                    </div>
                    <div class="detail-card">
                        <div class="detail-label">Phone</div>
                        <div class="detail-value">{{ $contactSubmission->phone ?: 'N/A' }}</div>
                    </div>
                    <div class="detail-card">
                        <div class="detail-label">Received</div>
                        <div class="detail-value">{{ $contactSubmission->created_at?->format('M d, Y h:i A') }}</div>
                    </div>
                </div>

                <div>
                    <div class="detail-label mb-2">Conversation Thread</div>
                    <div class="thread">
                        @foreach(($contactSubmission->messages ?? collect()) as $message)
                            <div class="thread-message {{ $message->sender_type }}">
                                <div class="thread-meta">
                                    <strong>{{ $message->sender_type === 'admin' ? 'Admin Reply' : 'User Message' }}</strong>
                                    <span>{{ $message->created_at?->format('M d, Y h:i A') }}</span>
                                </div>
                                <div class="detail-message">{{ $message->message }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="reply-box">
                    <div class="detail-label">Reply to user</div>
                    <form method="POST" action="{{ route('admin.contact-submissions.reply', $contactSubmission) }}">
                        @csrf
                        <textarea name="reply_message" required maxlength="5000" placeholder="Write your reply to the user...">{{ old('reply_message') }}</textarea>
                        @error('reply_message')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn-small btn-danger-custom">Send Reply</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
