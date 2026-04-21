@extends('layouts.app')

@section('title', 'Admin Dashboard | PESO Job Portal')

@section('content')
<section class="container pt-5 mt-4 pb-4" aria-label="Admin dashboard">
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-lg-between gap-3 mb-3">
        <div>
            <h1 class="mb-1 fw-bold">Admin Dashboard</h1>
            <p class="mb-0 text-muted">Welcome, {{ auth()->user()->name ?? 'Admin' }}.</p>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="submit" class="btn btn-outline-danger">Logout</button>
        </form>
    </div>

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>

    @endif

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <div class="fw-semibold mb-1">Please check the form:</div>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-3">
        <div class="col-12 col-lg-7">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-1">Send Notification</h5>
                    <p class="text-muted small mb-3">This will be delivered to all jobseekers and reflected in their notification page in near real-time.</p>

                    <form method="POST" action="{{ route('admin.notifications.store') }}" class="d-flex flex-column gap-3">
                        @csrf
                        <div>
                            <label for="title" class="form-label fw-semibold">Title</label>
                            <input
                                type="text"
                                id="title"
                                name="title"
                                class="form-control"
                                maxlength="150"
                                value="{{ old('title') }}"
                                required
                            >
                        </div>

                        <div>
                            <label for="message" class="form-label fw-semibold">Message</label>
                            <textarea
                                id="message"
                                name="message"
                                rows="5"
                                class="form-control"
                                maxlength="2000"
                                required
                            >{{ old('message') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-megaphone me-2"></i>Send to All Jobseekers
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-5">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="card-title fw-semibold mb-0">Recent Notifications</h5>
                        <span class="badge text-bg-primary">{{ $jobseekerCount }} jobseekers</span>
                    </div>

                    @if ($recentNotifications->isEmpty())
                        <p class="text-muted mb-0">No notifications sent yet.</p>
                    @else
                        <div class="d-flex flex-column gap-2">
                            @foreach ($recentNotifications as $notification)
                                <article class="border rounded p-2">
                                    <div class="fw-semibold">{{ $notification->title }}</div>
                                    <p class="small text-muted mb-1">{{ \Illuminate\Support\Str::limit($notification->message, 120) }}</p>
                                    <div class="small text-secondary">
                                        Sent {{ $notification->created_at?->diffForHumans() }}
                                        @if ($notification->creator)
                                            by {{ $notification->creator->name }}
                                        @endif
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@include('components.footer')
@endsection
