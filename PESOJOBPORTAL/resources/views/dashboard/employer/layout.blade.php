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
            width: min(1280px, 96vw);
            margin: 20px auto 34px;
        }

        .dashboard-layout {
            display: grid;
            grid-template-columns: 270px minmax(0, 1fr);
            gap: 18px;
            align-items: start;
        }

        .sidebar {
            position: sticky;
            top: 16px;
            background: linear-gradient(180deg, #0b1228 0%, #16213f 100%);
            border: 1px solid rgba(148, 163, 184, 0.22);
            border-radius: 16px;
            padding: 0;
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.28);
            color: #cbd5e1;
            overflow: hidden;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 14px 12px;
            border-bottom: 1px solid rgba(148, 163, 184, 0.2);
        }

        .sidebar-logo {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-size: 13px;
            font-weight: 800;
            color: #ffffff;
            background: linear-gradient(140deg, #0ea5a8 0%, #0f766e 100%);
            border: 2px solid rgba(255, 255, 255, 0.28);
            flex-shrink: 0;
        }

        .sidebar-brand-title {
            margin: 0;
            color: #f8fafc;
            font-size: 18px;
            font-weight: 700;
            line-height: 1.2;
        }

        .sidebar-brand-subtitle {
            margin: 0;
            color: #94a3b8;
            font-size: 12px;
        }

        .sidebar-inner {
            padding: 8px;
            display: grid;
            gap: 12px;
        }

        .sidebar-group-title {
            margin: 8px 10px 6px;
            color: #7d8ba5;
            font-size: 11px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-weight: 700;
        }

        .sidebar-nav {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            gap: 4px;
        }

        .sidebar a,
        .sidebar-logout {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #cbd5e1;
            background: transparent;
            border: 0;
            border-radius: 10px;
            padding: 10px 10px;
            font-weight: 500;
            font-size: 14px;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .sidebar a:hover,
        .sidebar-logout:hover,
        .sidebar a.active {
            background: rgba(14, 165, 168, 0.22);
            color: #f8fafc;
        }

        .nav-icon {
            width: 22px;
            height: 22px;
            border-radius: 7px;
            display: grid;
            place-items: center;
            background: rgba(148, 163, 184, 0.18);
            color: #e2e8f0;
            font-size: 11px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .sidebar a:hover .nav-icon,
        .sidebar-logout:hover .nav-icon,
        .sidebar a.active .nav-icon {
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
        }

        .sidebar-footer {
            margin-top: 4px;
            padding-top: 8px;
            border-top: 1px solid rgba(148, 163, 184, 0.2);
        }

        .content {
            min-width: 0;
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
            .dashboard-layout {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: static;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="dashboard-layout">
            <aside class="sidebar">
                <div class="sidebar-brand">
                    <div class="sidebar-logo">{{ strtoupper(substr(auth()->user()->name ?? 'E', 0, 1)) }}</div>
                    <div>
                        <p class="sidebar-brand-title">PESO Employer</p>
                        <p class="sidebar-brand-subtitle">Dashboard</p>
                    </div>
                </div>

                <div class="sidebar-inner">
                    <ul class="sidebar-nav">
                        <li>
                            <a class="{{ request()->routeIs('employer.dashboard') ? 'active' : '' }}" href="{{ route('employer.dashboard') }}"><span class="nav-icon">D</span><span>Dashboard</span></a>
                        </li>
                    </ul>

                    <p class="sidebar-group-title">Job Management</p>
                    <ul class="sidebar-nav">
                        <li>
                            <a class="{{ request()->routeIs('employer.jobs.post') ? 'active' : '' }}" href="{{ route('employer.jobs.post') }}"><span class="nav-icon">P</span><span>Post New Job</span></a>
                        </li>
                        <li>
                            <a class="{{ request()->routeIs('employer.jobs.manage') ? 'active' : '' }}" href="{{ route('employer.jobs.manage') }}"><span class="nav-icon">M</span><span>Manage Jobs</span></a>
                        </li>
                        <li>
                            <a class="{{ request()->routeIs('employer.applicants.index') ? 'active' : '' }}" href="{{ route('employer.applicants.index') }}"><span class="nav-icon">V</span><span>View Applicants</span></a>
                        </li>
                    </ul>

                    <p class="sidebar-group-title">Compliance</p>
                    <ul class="sidebar-nav">
                        <li>
                            <a class="{{ request()->routeIs('employer.recruitment.index') ? 'active' : '' }}" href="{{ route('employer.recruitment.index') }}"><span class="nav-icon">R</span><span>Request LRA/SRA</span></a>
                        </li>
                        <li>
                            <a class="{{ request()->routeIs('employer.documents.index') ? 'active' : '' }}" href="{{ route('employer.documents.index') }}"><span class="nav-icon">S</span><span>Submit Documents</span></a>
                        </li>
                    </ul>

                    <p class="sidebar-group-title">Account</p>
                    <ul class="sidebar-nav">
                        <li>
                            <a class="{{ request()->routeIs('employer.company-profile') ? 'active' : '' }}" href="{{ route('employer.company-profile') }}"><span class="nav-icon">C</span><span>Company Profile</span></a>
                        </li>
                        <li>
                            <a class="{{ request()->routeIs('employer.notifications.index') ? 'active' : '' }}" href="{{ route('employer.notifications.index') }}"><span class="nav-icon">N</span><span>Notifications</span></a>
                        </li>
                    </ul>

                    <div class="sidebar-footer">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="sidebar-logout" type="submit">
                                <span class="nav-icon">L</span>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            <main class="content">
                <div class="header panel">
                    <div>
                        <h1>@yield('page_title', 'Employer Dashboard')</h1>
                        <p>@yield('page_subtitle', 'Manage your employer account activity.')</p>
                    </div>
                    @hasSection('header_actions')
                        <div>@yield('header_actions')</div>
                    @endif
                </div>

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
</body>
</html>
