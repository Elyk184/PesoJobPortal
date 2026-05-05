<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Employer Dashboard')</title>
    <style>
        :root {
            --bg: #f8fafc;
            --panel: #ffffff;
            --line: #dbe4ee;
            --title: #0f172a;
            --muted: #4b5563;
            --primary: #0f766e;
            --primary-soft: #e6fffb;
            --danger: #b91c1c;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: radial-gradient(circle at top right, #d9f2ff 0%, var(--bg) 40%, #eef6ff 100%);
            color: var(--title);
        }

        .container {
            width: 100%;
            margin: 0;
            min-height: 100vh;
        }

        .dashboard-layout {
            display: block;
            min-height: 100vh;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 270px;
            height: 100vh;
            display: flex;
            flex-direction: column;
            background: linear-gradient(90deg, #0f2d52, #1f4b8f);
            border-right: 3px solid #d72638;
            border-radius: 0;
            padding: 0;
            box-shadow: 0 14px 30px rgba(15, 35, 64, 0.28);
            color: #dfe7f5;
            overflow: hidden;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px;
            border-bottom: 1px solid rgba(215, 38, 56, 0.3);
        }

        .sidebar-logo {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.28);
            flex-shrink: 0;
            object-fit: cover;
            display: block;
        }

        .sidebar-brand-title {
            margin: 0;
            color: #f5f7fb;
            font-size: 17px;
            font-weight: 700;
            line-height: 1.2;
        }

        .sidebar-brand-subtitle {
            margin: 0;
            color: #b8c6d8;
            font-size: 12px;
        }

        .sidebar-inner {
            padding: 6px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex: 1;
            min-height: 0;
        }

        .sidebar-group-title {
            margin: 6px 8px 2px;
            color: #a5b4c4;
            font-size: 10px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-weight: 700;
        }

        .sidebar-nav {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            gap: 2px;
        }

        .sidebar a,
        .sidebar-logout {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #dfe7f5;
            background: transparent;
            border: 0;
            border-radius: 9px;
            padding: 8px 9px;
            font-weight: 500;
            font-size: 13px;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .sidebar a:hover,
        .sidebar-logout:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
        }

        .sidebar a.active {
            background: rgba(215, 38, 56, 0.16);
            color: #ffffff;
            box-shadow: inset 0 0 0 1px rgba(215, 38, 56, 0.6);
        }

        .nav-icon {
            width: 30px;
            height: 30px;
            border-radius: 6px;
            display: grid;
            place-items: center;
            background: rgba(255, 255, 255, 0.12);
            color: #e2e8f0;
            flex-shrink: 0;
        }

        .nav-icon svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .sidebar a:hover .nav-icon,
        .sidebar-logout:hover .nav-icon,
        .sidebar a.active .nav-icon {
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
        }

        .sidebar-footer {
            margin-top: auto;
            padding-top: 6px;
            border-top: 1px solid rgba(215, 38, 56, 0.2);
            background: linear-gradient(180deg, rgba(15, 45, 82, 0) 0%, rgba(15, 45, 82, 0.7) 18%, rgba(15, 45, 82, 1) 100%);
        }

        .content {
            min-width: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin-left: 270px;
        }

        .fill-remaining {
            flex: 1;
            margin-bottom: 0;
        }

        .header {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .panel {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 16px;
            margin-bottom: 16px;
            box-shadow: 0 12px 25px rgba(15, 23, 42, 0.05);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 12px;
        }

        .list {
            display: grid;
            gap: 10px;
        }

        .item {
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 12px;
            background: #fcfdff;
        }

        h1, h2, h3 {
            margin-top: 0;
            margin-bottom: 10px;
        }

        p {
            margin-top: 0;
            color: var(--muted);
        }

        label {
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            display: block;
            margin-bottom: 4px;
        }

        input, select, textarea {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 9px 11px;
            font-size: 14px;
            margin-bottom: 9px;
            background: #fff;
        }

        textarea {
            min-height: 90px;
            resize: vertical;
        }

        .btn {
            border: 0;
            border-radius: 10px;
            padding: 9px 12px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            color: #fff;
            background: var(--primary);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn:disabled {
            cursor: not-allowed;
            opacity: 0.6;
        }

        .btn-secondary {
            background: #0f172a;
        }

        .btn-danger {
            background: var(--danger);
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 8px;
        }

        .pill {
            display: inline-block;
            font-size: 12px;
            font-weight: 700;
            border-radius: 999px;
            padding: 4px 9px;
            background: var(--primary-soft);
            color: var(--primary);
            margin-right: 6px;
            margin-bottom: 4px;
        }

        .alert {
            border-radius: 12px;
            padding: 10px 12px;
            margin-bottom: 12px;
            border: 1px solid;
        }

        .alert-success {
            background: #ecfdf5;
            border-color: #10b981;
            color: #065f46;
        }

        .alert-error {
            background: #fef2f2;
            border-color: #f87171;
            color: #7f1d1d;
        }

        .metric-card {
            padding: 12px;
            border-radius: 12px;
            border: 1px solid var(--line);
            background: #f8fbff;
        }

        .metric-value {
            font-size: 32px;
            margin: 0;
            color: #1e3a8a;
        }

        .metric-label {
            margin: 4px 0 0;
            color: #475569;
            font-size: 13px;
            font-weight: 600;
        }

        .placeholder-note {
            font-size: 13px;
            color: #64748b;
            margin-top: 8px;
        }

        @media (max-width: 960px) {
            .sidebar {
                position: static;
                width: 100%;
                height: auto;
            }

            .content {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="container">
        <div class="dashboard-layout">
            <aside class="sidebar">
                <div class="sidebar-brand">
                    <img class="sidebar-logo" src="{{ asset('images/logo.png') }}" alt="PESO Logo">
                    <div>
                        <p class="sidebar-brand-title">PESO Employer</p>
                        <p class="sidebar-brand-subtitle">Dashboard</p>
                    </div>
                </div>

                <div class="sidebar-inner">
                    @php
                        $currentEmployerUser = auth()->check() ? auth()->user() : null;
                        $sidebarApplicantsTotalCount = $currentEmployerUser
                            ? \App\Models\JobApplication::query()
                                ->whereHas('job', function ($query) use ($currentEmployerUser) {
                                    $query->where('employer_id', $currentEmployerUser->id);
                                })
                                ->whereNull('employer_status')
                                ->count()
                            : 0;
                    @endphp
                    <ul class="sidebar-nav">
                        <li>
                            <a class="{{ request()->routeIs('employer.dashboard') ? 'active' : '' }}" href="{{ route('employer.dashboard') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="4"></rect><rect x="14" y="10" width="7" height="11"></rect><rect x="3" y="14" width="7" height="7"></rect></svg></span><span>Dashboard</span></a>
                        </li>
                    </ul>

                    <p class="sidebar-group-title">Job Management</p>
                    <ul class="sidebar-nav">
                        <li>
                            <a class="{{ request()->routeIs('employer.jobs.post') ? 'active' : '' }}" href="{{ route('employer.jobs.post') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14"></path><path d="M5 12h14"></path></svg></span><span>Post New Job</span></a>
                        </li>
                        <li>
                            <a class="{{ request()->routeIs('employer.jobs.manage') ? 'active' : '' }}" href="{{ route('employer.jobs.manage') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M10 3H5a2 2 0 0 0-2 2v5"></path><path d="M14 3h5a2 2 0 0 1 2 2v5"></path><path d="M10 21H5a2 2 0 0 1-2-2v-5"></path><path d="M14 21h5a2 2 0 0 0 2-2v-5"></path><path d="M8 12h8"></path></svg></span><span>Manage Jobs</span></a>
                        </li>
                        <li>
                            <a class="{{ request()->routeIs('employer.applicants.index') ? 'active' : '' }}" href="{{ route('employer.applicants.index') }}">
                                <span class="nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg></span>
                                <span>View Applicants</span>
                                @if($sidebarApplicantsTotalCount > 0)
                                    <span style="margin-left:auto; display:inline-flex; align-items:center; gap:6px;">
                                        <span style="min-width:22px; height:22px; padding:0 6px; border-radius:999px; display:inline-flex; align-items:center; justify-content:center; background:#ef4444; color:#fff; font-size:11px; font-weight:700; line-height:1;">{{ $sidebarApplicantsTotalCount }}</span>
                                    </span>
                                @endif
                            </a>
                        </li>
                    </ul>

                    <p class="sidebar-group-title">Compliance</p>
                    <ul class="sidebar-nav">
                        <li>
                            <a class="{{ request()->routeIs('employer.recruitment.index') ? 'active' : '' }}" href="{{ route('employer.recruitment.index') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><path d="M14 2v6h6"></path><path d="M16 13H8"></path><path d="M16 17H8"></path></svg></span><span>Request LRA/SRA</span></a>
                        </li>
                        <li>
                            <a class="{{ request()->routeIs('employer.documents.index') ? 'active' : '' }}" href="{{ route('employer.documents.index') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h16"></path><path d="M7 3h10l1 4H6z"></path><path d="M6 7l1 14h10l1-14"></path></svg></span><span>Submit Documents</span></a>
                        </li>
                    </ul>

                    <p class="sidebar-group-title">Account</p>
                    <ul class="sidebar-nav">
                        @php
                            $sidebarNotifications = $currentEmployerUser
                                ? $currentEmployerUser->employerNotifications()->get()
                                : collect();
                            $sidebarUnreadTotalCount = $sidebarNotifications->where('is_read', false)->count();
                        @endphp
                        <li>
                            <a class="{{ request()->routeIs('employer.company-profile') ? 'active' : '' }}" href="{{ route('employer.company-profile') }}"><span class="nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 21h18"></path><path d="M5 21V7l7-4 7 4v14"></path><path d="M9 10h6"></path><path d="M9 14h6"></path></svg></span><span>Company Profile</span></a>
                        </li>
                        <li>
                            <a class="{{ request()->routeIs('employer.notifications.index') ? 'active' : '' }}" href="{{ route('employer.notifications.index') }}">
                                <span class="nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 7h18s-3 0-3-7"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg></span>
                                <span>Notifications</span>
                                @if($sidebarUnreadTotalCount > 0)
                                    <span style="margin-left:auto; display:inline-flex; align-items:center; gap:6px;">
                                        <span style="min-width:22px; height:22px; padding:0 6px; border-radius:999px; display:inline-flex; align-items:center; justify-content:center; background:#ef4444; color:#fff; font-size:11px; font-weight:700; line-height:1;">{{ $sidebarUnreadTotalCount }}</span>
                                    </span>
                                @endif
                            </a>
                        </li>
                    </ul>

                    <div class="sidebar-footer">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="sidebar-logout" type="submit">
                                <span class="nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><path d="M16 17l5-5-5-5"></path><path d="M21 12H9"></path></svg></span>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            <main class="content">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-error">{{ session('error') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-error">
                        <strong>Please fix the following:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
