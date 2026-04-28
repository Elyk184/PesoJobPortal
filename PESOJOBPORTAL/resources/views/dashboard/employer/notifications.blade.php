@extends('dashboard.employer.layout')

@section('title', 'Notifications')
@section('hide_header')
@endsection

@section('content')
    <style>
        .notifications-page {
            background:
                radial-gradient(circle at top right, rgba(72, 121, 205, 0.1), transparent 45%),
                radial-gradient(circle at left bottom, rgba(43, 103, 177, 0.08), transparent 42%),
                #f3f7fd;
            border-radius: 16px;
            padding: 1.15rem;
        }

        .gmail-shell {
            border: 1px solid #d9e3f1;
            border-radius: 18px;
            overflow: hidden;
            background: #ffffff;
            box-shadow: 0 16px 32px rgba(17, 39, 76, 0.08);
        }

        .gmail-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            padding: 1.05rem 1.25rem;
            background: linear-gradient(135deg, #075cb2 0%, #3498db 100%);
            border-bottom: 1px solid rgba(7, 92, 178, 0.35);
        }

        .gmail-toolbar-left {
            display: inline-flex;
            align-items: center;
            gap: 0.65rem;
            min-width: 0;
        }

        .gmail-title {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 800;
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
        }

        .gmail-toolbar-counts {
            display: inline-flex;
            gap: 0.45rem;
            align-items: center;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .gmail-meta {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.46);
            background: rgba(255, 255, 255, 0.14);
            color: #ffffff;
            font-size: 0.78rem;
            font-weight: 700;
            padding: 0.38rem 0.8rem;
            white-space: nowrap;
            box-shadow: 0 6px 14px rgba(6, 42, 92, 0.12);
        }

        .gmail-meta.all {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.55);
            color: #ffffff;
        }

        .gmail-meta.job {
            background: rgba(14, 165, 233, 0.18);
            border-color: rgba(14, 165, 233, 0.55);
            color: #ffffff;
        }

        .gmail-meta.verification {
            background: rgba(34, 197, 94, 0.18);
            border-color: rgba(34, 197, 94, 0.55);
            color: #ffffff;
        }

        .gmail-list-head {
            display: grid;
            grid-template-columns: 20px 32px minmax(160px, 1.1fr) minmax(240px, 1.9fr) 112px 120px 92px;
            gap: 0.85rem;
            align-items: center;
            padding: 0.65rem 1.15rem;
            background: #fbfdff;
            border-bottom: 1px solid #e8eff8;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #6d7f98;
            font-weight: 700;
        }

        .gmail-list {
            background: #fff;
        }

        .gmail-row {
            display: grid;
            grid-template-columns: 20px 32px minmax(160px, 1.1fr) minmax(240px, 1.9fr) 112px 120px 92px;
            align-items: center;
            gap: 0.85rem;
            padding: 0.95rem 1.15rem;
            border-bottom: 1px solid #ecf1f8;
            transition: background-color 0.16s ease, box-shadow 0.16s ease;
        }

        .gmail-row:hover {
            background: #f8fbff;
            box-shadow: inset 0 1px 0 rgba(56, 101, 179, 0.05), inset 0 -1px 0 rgba(56, 101, 179, 0.05);
        }

        .gmail-row.unread {
            background: #ffffff;
        }

        .gmail-row.unread .gmail-subject,
        .gmail-row.unread .gmail-message,
        .gmail-row.unread .gmail-time {
            font-weight: 700;
            color: #0f2340;
        }

        .unread-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #1a73e8;
            box-shadow: 0 0 0 4px rgba(26, 115, 232, 0.16);
        }

        .read-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            border: 2px solid #c4cedd;
            background: #ffffff;
        }

        .gmail-type-icon {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #315d95;
            border: 1px solid #d8e5f8;
            background: #eff5ff;
            font-size: 0.86rem;
        }

        .gmail-subject {
            min-width: 0;
            color: #1a3356;
            font-size: 0.93rem;
            font-weight: 700;
            line-height: 1.35;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .gmail-message {
            min-width: 0;
            font-size: 0.9rem;
            color: #53657d;
            line-height: 1.4;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .gmail-time {
            color: #667994;
            font-size: 0.82rem;
            white-space: nowrap;
            justify-self: end;
        }

        .gmail-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            padding: 0.34rem 0.7rem;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            color: #315d95;
            background: #e9f2ff;
            border: 1px solid #cfe1fb;
            white-space: nowrap;
            justify-self: start;
        }

        .gmail-read-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            color: #6a7d97;
            font-size: 0.76rem;
            font-weight: 700;
            white-space: nowrap;
            justify-self: end;
        }

        .mark-read-btn {
            border: 1px solid #cfe0f9;
            background: #f2f7ff;
            color: #23579c;
            border-radius: 8px;
            padding: 0.32rem 0.58rem;
            font-size: 0.75rem;
            font-weight: 700;
            transition: all 0.16s ease;
            white-space: nowrap;
        }

        .mark-read-btn:hover {
            background: #e6f1ff;
            border-color: #acc8ef;
            color: #17457d;
        }

        .gmail-action {
            justify-self: end;
        }

        .gmail-row .unread-dot,
        .gmail-row .read-dot {
            justify-self: center;
        }

        .gmail-row .gmail-type-icon {
            justify-self: center;
        }

        .gmail-row .gmail-time {
            justify-self: start;
        }

        .gmail-row .gmail-action .mark-read-btn {
            min-height: 34px;
            padding-inline: 0.75rem;
        }

        .empty-mail {
            padding: 2.5rem 1rem;
            text-align: center;
            color: #6b7f98;
            font-weight: 600;
        }

        .empty-mail i {
            display: block;
            font-size: 2.1rem;
            margin-bottom: 0.6rem;
            color: #a4b3c7;
        }

        @media (max-width: 992px) {
            .gmail-list-head {
                display: none;
            }

            .gmail-row {
                grid-template-columns: auto auto minmax(0, 1fr) auto;
                grid-template-areas:
                    "dot icon subject time"
                    "dot icon message message"
                    "dot icon meta action";
                gap: 0.5rem 0.7rem;
            }

            .unread-dot,
            .read-dot {
                grid-area: dot;
            }

            .gmail-type-icon {
                grid-area: icon;
            }

            .gmail-subject {
                grid-area: subject;
            }

            .gmail-message {
                grid-area: message;
                white-space: normal;
                overflow: visible;
                text-overflow: initial;
            }

            .gmail-time {
                grid-area: time;
            }

            .gmail-badge {
                grid-area: meta;
                justify-self: start;
            }

            .gmail-action {
                grid-area: action;
                justify-self: end;
            }
        }

        @media (max-width: 576px) {
            .notifications-page {
                padding: 0.65rem;
            }

            .gmail-toolbar {
                padding: 0.9rem 0.9rem;
                flex-direction: column;
                align-items: flex-start;
            }

            .gmail-toolbar-counts {
                justify-content: flex-start;
            }

            .gmail-row {
                padding: 0.75rem 0.8rem;
            }
        }
    </style>

    <div class="notifications-page">
        <div class="gmail-shell">
            <div class="gmail-toolbar">
                <div class="gmail-toolbar-left">
                    <h2 class="gmail-title"><i class="bi bi-envelope"></i>Inbox</h2>
                </div>
                <div class="gmail-toolbar-counts">
                    <span class="gmail-meta"><i class="bi bi-circle-fill"></i>{{ $unreadCount }} unread</span>
                </div>
            </div>

            <div class="gmail-list-head">
                <span></span>
                <span></span>
                <span>Subject</span>
                <span>Message</span>
                <span>Time</span>
                <span>Type</span>
                <span>Action</span>
            </div>

            @php
                $notificationTypeIcons = [
                    'job_fair_invite' => 'bi-calendar-event',
                    'referral_update' => 'bi-arrow-repeat',
                    'job_update' => 'bi-briefcase',
                    'verification_update' => 'bi-shield-check',
                ];
            @endphp

            <div class="gmail-list">
                @forelse ($notifications as $notification)
                    @php
                        $typeKey = strtolower((string) $notification->type);
                        $title = strtolower((string) $notification->title);
                        $message = strtolower((string) $notification->message);

                        if ($typeKey === 'job_update' || str_contains($title, 'job') || str_contains($message, 'job post')) {
                            $typeIcon = $notificationTypeIcons['job_update'];
                        } elseif ($typeKey === 'verification_update' || str_contains($title, 'verification') || str_contains($message, 'verification')) {
                            $typeIcon = $notificationTypeIcons['verification_update'];
                        } else {
                            $typeIcon = $notificationTypeIcons[$typeKey] ?? 'bi-bell';
                        }

                        if ($typeKey === 'job_update' || str_contains($title, 'job') || str_contains($message, 'job post')) {
                            $badgeLabel = 'JOB UPDATE';
                        } elseif ($typeKey === 'verification_update' || str_contains($title, 'verification') || str_contains($message, 'verification')) {
                            $badgeLabel = 'VERIFICATION UPDATE';
                        } else {
                            $badgeLabel = strtoupper(str_replace('_', ' ', $notification->type));
                        }
                    @endphp
                    <div class="gmail-row {{ $notification->is_read ? 'read' : 'unread' }}">
                        @if ($notification->is_read)
                            <span class="read-dot" aria-hidden="true"></span>
                        @else
                            <span class="unread-dot" aria-hidden="true"></span>
                        @endif

                        <span class="gmail-type-icon" aria-hidden="true"><i class="bi {{ $typeIcon }}"></i></span>
                        <div class="gmail-subject">{{ $notification->title }}</div>
                        <div class="gmail-message">{{ $notification->message }}</div>
                        <span class="gmail-time">{{ optional($notification->created_at)->diffForHumans() ?? 'Now' }}</span>
                        <span class="gmail-badge">{{ $badgeLabel }}</span>

                        @if (! $notification->is_read)
                            <form class="gmail-action" method="POST" action="{{ route('employer.notifications.read', $notification) }}">
                                @csrf
                                @method('PATCH')
                                <button class="mark-read-btn" type="submit">Mark Read</button>
                            </form>
                        @else
                            <span class="gmail-read-tag"><i class="bi bi-check2-circle"></i>Read</span>
                        @endif
                    </div>
                @empty
                    <div class="empty-mail">
                        <i class="bi bi-envelope-open"></i>
                        No notifications yet.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
