@extends('dashboard.employer.layout')

@section('title', 'Notifications')
@section('page_title', 'Notifications')
@section('page_subtitle', 'Track job fair invites and referral updates.')

@section('content')
    <div class="panel">
        <h2>Inbox</h2>
        <p>Total unread: <strong>{{ $unreadCount }}</strong></p>

        <div class="list">
            @forelse ($notifications as $notification)
                <div class="item">
                    <strong>{{ $notification->title }}</strong>
                    <p>{{ $notification->message }}</p>
                    <span class="pill">{{ strtoupper(str_replace('_', ' ', $notification->type)) }}</span>
                    @if ($notification->is_read)
                        <span class="pill" style="background:#e2e8f0;color:#334155;">Read</span>
                    @else
                        <span class="pill" style="background:#dcfce7;color:#166534;">Unread</span>
                        <form method="POST" action="{{ route('employer.notifications.read', $notification) }}" style="margin-top: 8px;">
                            @csrf
                            @method('PATCH')
                            <button class="btn" type="submit">Mark as Read</button>
                        </form>
                    @endif
                </div>
            @empty
                <p>No notifications yet.</p>
            @endforelse
        </div>
    </div>
@endsection
