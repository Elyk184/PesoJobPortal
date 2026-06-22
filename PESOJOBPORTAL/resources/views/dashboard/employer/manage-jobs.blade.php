@extends('dashboard.employer.layout')

@section('title', 'Manage Jobs - PESO')
@section('hide_header', true)

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endpush

@section('content')
<style>
    :root {
        --mj-bg: #edf2fb;
        --mj-card: #ffffff;
        --mj-line: #d8e2f1;
        --mj-ink: #12243f;
        --mj-muted: #5f6f86;
        --mj-accent: #215ae8;
        --mj-accent-soft: #eaf0ff;
    }

    /* ── Wrapper ── */
    .manage-jobs-wrap {
        background:
            radial-gradient(circle at top right, rgba(84,133,255,.12), transparent 48%),
            radial-gradient(circle at left bottom, rgba(14,165,198,.08), transparent 42%),
            var(--mj-bg);
        margin: -1rem;
        padding: 1.5rem;
        min-height: 100vh;
    }

    .manage-jobs-card {
        background: var(--mj-card);
        border: 1px solid var(--mj-line);
        border-radius: 18px;
        padding: 1.75rem;
        box-shadow: 0 16px 40px rgba(15,23,42,.07);
    }

    /* ── Hero ── */
    .manage-hero {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        position: relative;
        overflow: hidden;
        border-radius: 14px;
        padding: 1.4rem 1.6rem;
        background: linear-gradient(135deg, #1e4fa3 0%, #3571cc 55%, #5697e8 100%);
        box-shadow: 0 14px 32px rgba(26,74,157,.3);
        margin-bottom: 1.25rem;
    }

    .manage-hero::before {
        content: "";
        position: absolute;
        width: 260px; height: 260px;
        border-radius: 50%;
        background: rgba(255,255,255,.07);
        right: -80px; top: -100px;
        pointer-events: none;
    }

    .manage-hero::after {
        content: "";
        position: absolute;
        width: 140px; height: 140px;
        border-radius: 50%;
        background: rgba(255,255,255,.05);
        left: 40%; bottom: -60px;
        pointer-events: none;
    }

    .manage-heading { position: relative; z-index: 1; }

    .manage-title {
        font-size: 1.85rem;
        font-weight: 800;
        color: #fff;
        margin: 0 0 .3rem;
        letter-spacing: -.02em;
        line-height: 1.1;
    }

    .manage-subtitle {
        color: rgba(255,255,255,.88);
        font-size: .92rem;
        margin: 0 0 .65rem;
    }

    .hero-chip {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        border: 1px solid rgba(255,255,255,.3);
        border-radius: 999px;
        padding: .28rem .72rem;
        font-size: .78rem;
        font-weight: 700;
        color: #fff;
        background: rgba(255,255,255,.13);
        backdrop-filter: blur(4px);
    }

    .btn-post-job {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        border: none;
        border-radius: 11px;
        padding: .68rem 1.2rem;
        font-weight: 700;
        font-size: .88rem;
        color: #1a4f9c;
        background: #fff;
        box-shadow: 0 8px 20px rgba(15,23,42,.22);
        text-decoration: none;
        transition: transform .18s ease, box-shadow .18s ease, color .15s ease;
        position: relative;
        z-index: 1;
        white-space: nowrap;
    }

    .btn-post-job:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 28px rgba(15,23,42,.3);
        color: #133a7a;
    }

    /* ── Stats Row ── */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
        margin-bottom: 1.25rem;
    }

    .stat-card {
        background: #fff;
        border: 1px solid var(--mj-line);
        border-radius: 12px;
        padding: .85rem 1rem;
        transition: box-shadow .15s;
    }

    .stat-card:hover {
        box-shadow: 0 6px 18px rgba(15,23,42,.07);
    }

    .stat-label {
        font-size: .72rem;
        font-weight: 600;
        color: var(--mj-muted);
        margin-bottom: .3rem;
        display: flex;
        align-items: center;
        gap: .3rem;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .stat-label i { font-size: .8rem; }

    .stat-val {
        font-size: 1.55rem;
        font-weight: 800;
        color: var(--mj-ink);
        line-height: 1.1;
    }

    .stat-sub {
        font-size: .72rem;
        color: var(--mj-muted);
        margin-top: .18rem;
    }

    .stat-card.accent-blue  .stat-val { color: #1d4ed8; }
    .stat-card.accent-green .stat-val { color: #15803d; }
    .stat-card.accent-teal  .stat-val { color: #0e7490; }
    .stat-card.accent-amber .stat-val { color: #92400e; }

    /* ── Tab Bar ── */
    .jobs-tabbar {
        display: flex;
        gap: .3rem;
        flex-wrap: wrap;
        border: 1px solid var(--mj-line);
        border-radius: 12px;
        background: #f7f9fe;
        padding: .45rem;
        margin-bottom: 1.25rem;
    }

    .jobs-tab {
        display: inline-flex;
        align-items: center;
        gap: .38rem;
        border-radius: 8px;
        padding: .46rem .78rem;
        font-size: .83rem;
        font-weight: 600;
        color: #445066;
        text-decoration: none;
        transition: background .13s, color .13s, border-color .13s;
        white-space: nowrap;
        border: 1px solid transparent;
    }

    .jobs-tab:hover { background: #eef3fb; color: #1f3c70; }

    .jobs-tab.active {
        background: #fff;
        color: #1a4fa3;
        font-weight: 700;
        border-color: #b8d0fb;
        box-shadow: 0 1px 4px rgba(33,90,232,.1);
    }

    .jobs-tab-badge {
        font-size: .68rem;
        font-weight: 700;
        border-radius: 999px;
        padding: .15rem .42rem;
        color: #fff;
        background: #2360f1;
        line-height: 1.2;
    }

    .jobs-tab-badge.gray   { background: #6b778c; }
    .jobs-tab-badge.yellow { background: #e8a400; }
    .jobs-tab-badge.teal   { background: #0891b2; }

    /* ── Toolbar ── */
    .jobs-table-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .75rem;
        margin-bottom: .85rem;
        flex-wrap: wrap;
    }

    .toolbar-left {
        display: flex;
        align-items: center;
        gap: .55rem;
    }

    .jobs-table-title {
        margin: 0;
        font-size: .96rem;
        font-weight: 800;
        color: #1a3e76;
        display: inline-flex;
        align-items: center;
        gap: .42rem;
    }

    .jobs-table-meta {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        border-radius: 999px;
        border: 1px solid #ccdcf5;
        background: #eef4ff;
        color: #1e4a93;
        font-size: .76rem;
        font-weight: 700;
        padding: .26rem .62rem;
    }

    .jobs-search-wrap {
        display: flex;
        align-items: center;
        gap: .45rem;
        background: #fff;
        border: 1px solid var(--mj-line);
        border-radius: 9px;
        padding: .36rem .65rem;
        transition: border-color .15s, box-shadow .15s;
    }

    .jobs-search-wrap:focus-within {
        border-color: #93b4f5;
        box-shadow: 0 0 0 3px rgba(33,90,232,.08);
    }

    .jobs-search-wrap i {
        font-size: .82rem;
        color: var(--mj-muted);
    }

    .jobs-search-wrap input {
        border: none;
        outline: none;
        background: transparent;
        font-size: .82rem;
        color: var(--mj-ink);
        width: 175px;
    }

    .jobs-search-wrap input::placeholder { color: #aab4c4; }

    /* ── Table Container ── */
    .jobs-table-wrap {
        border: 1px solid var(--mj-line);
        border-radius: 14px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 4px 16px rgba(15,23,42,.04);
    }

    .table-responsive.jobs-table-wrap {
        overflow-x: hidden;
    }

    /* ── Table ── */
    .jobs-grid {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .jobs-grid thead tr {
        background: linear-gradient(180deg, #f8fbff 0%, #f2f6fc 100%);
    }

    .jobs-grid th {
        font-size: .7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .045em;
        color: #4c5e7a;
        border-bottom: 1px solid #dce6f4;
        padding: .7rem .55rem;
        white-space: nowrap;
        vertical-align: middle;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .jobs-grid th:first-child { padding-left: .85rem; }
    .jobs-grid th:last-child  { padding-right: .75rem; }

    .th-with-icon {
        display: inline-flex;
        align-items: center;
        gap: .26rem;
    }

    .th-with-icon i { font-size: .72rem; color: #6080a8; opacity: .9; }

    .jobs-grid td {
        border-bottom: 1px solid #edf2fb;
        vertical-align: middle;
        padding: .78rem .55rem;
        font-size: .82rem;
        color: #1e2d42;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .jobs-grid td:first-child { padding-left: .85rem; }
    .jobs-grid td:last-child  { padding-right: .75rem; }

    .jobs-grid tbody tr { transition: background .1s; }
    .jobs-grid tbody tr:hover { background: #f5f9ff; }
    .jobs-grid tbody tr:last-child td { border-bottom: none; }

    /* ── Cell: Job Title ── */
    .job-title-cell { min-width: 150px; }

    .job-title {
        font-size: .92rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.3;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* ── Cell: Company ── */
    .cell-company {
        color: #2d4060;
        font-weight: 500;
        font-size: .8rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* ── Cell: Location ── */
    .cell-location {
        color: #3a5070;
        font-size: .8rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: flex;
        align-items: center;
        gap: .22rem;
    }

    .cell-location i { font-size: .72rem; flex-shrink: 0; color: #7090b0; }

    /* ── Employment pill ── */
    .employment-pill {
        display: inline-flex;
        align-items: center;
        gap: .22rem;
        background: #eff6ff;
        color: #1d4ed8;
        border-radius: 6px;
        font-size: .72rem;
        font-weight: 700;
        padding: .22rem .5rem;
        white-space: nowrap;
        letter-spacing: .01em;
    }

    .employment-pill i { font-size: .7rem; }

    /* ── Cell: Salary ── */
    .cell-salary {
        white-space: nowrap;
        color: #1a3a60;
        font-weight: 600;
        font-size: .82rem;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .salary-currency {
        font-size: .7rem;
        font-weight: 700;
        color: #5a78a0;
        margin-right: .1rem;
    }

    /* ── Numeric / Center cells ── */
    .cell-num, .cell-status { text-align: center; white-space: nowrap; }

    .cell-date {
        white-space: nowrap;
        font-size: .8rem;
        color: #445070;
        display: flex;
        align-items: center;
        gap: .25rem;
    }

    .cell-date i { font-size: .76rem; color: #7090b0; }

    .date-past { color: #c0392b !important; font-weight: 600; }
    .date-past i { color: #c0392b !important; }

    /* ── Applications pill ── */
    .apps-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 26px;
        height: 22px;
        background: #2360f1;
        color: #fff;
        border-radius: 6px;
        font-size: .72rem;
        font-weight: 800;
        padding: 0 .4rem;
    }

    .apps-pill.zero { background: #e4e9f2; color: #7a8ea8; }

    /* ── Views ── */
    .views-num { color: #556880; font-weight: 600; font-size: .82rem; }

    /* ── Status chip ── */
    .status-chip {
        display: inline-flex;
        align-items: center;
        gap: .28rem;
        border-radius: 999px;
        padding: .22rem .6rem;
        font-size: .73rem;
        font-weight: 700;
        letter-spacing: .01em;
        white-space: nowrap;
    }

    .status-chip::before {
        content: "";
        width: 6px; height: 6px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .status-chip.active   { background: #dcfce7; color: #15803d; }
    .status-chip.active::before   { background: #16a34a; }
    .status-chip.pending  { background: #fef3c7; color: #92400e; }
    .status-chip.pending::before  { background: #f59e0b; }
    .status-chip.draft    { background: #f0f2f7; color: #4a5568; }
    .status-chip.draft::before    { background: #94a3b8; }
    .status-chip.archived { background: #f5f6fa; color: #5c687a; }
    .status-chip.archived::before { background: #9ca3af; }
    .status-chip.filled   { background: #cffafe; color: #0e7490; }
    .status-chip.filled::before   { background: #06b6d4; }

    /* ── Action buttons ── */
    .cell-actions { text-align: center; white-space: nowrap; }

    .action-row {
        display: inline-flex;
        align-items: center;
        gap: .28rem;
        justify-content: center;
        flex-wrap: nowrap;
    }

    .icon-btn {
        width: 32px;
        height: 32px;
        padding: 0;
        border-radius: 7px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #d4dcea;
        background: #fff;
        color: #4a6080;
        cursor: pointer;
        transition: transform .14s ease, box-shadow .14s ease, background .1s, border-color .1s, color .1s;
        flex-shrink: 0;
        font-size: 1rem;
        line-height: 1;
        text-decoration: none;
    }

    .icon-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(15,23,42,.1);
    }

    .icon-btn i {
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
        pointer-events: none;
    }

    .icon-btn.view      { color: #2563eb; border-color: #bfdbfe; background: #eff6ff; }
    .icon-btn.view:hover { background: #dbeafe; border-color: #93c5fd; color: #2563eb; }

    .icon-btn.duplicate { color: #7c3aed; border-color: #ddd6fe; background: #f5f3ff; }
    .icon-btn.duplicate:hover { background: #ede9fe; border-color: #c4b5fd; color: #7c3aed; }

    .icon-btn.filled-btn { color: #059669; border-color: #a7f3d0; background: #ecfdf5; }
    .icon-btn.filled-btn:hover { background: #d1fae5; border-color: #6ee7b7; color: #059669; }

    .icon-btn.archive   { color: #d97706; border-color: #fde68a; background: #fffbeb; }
    .icon-btn.archive:hover { background: #fef3c7; border-color: #fcd34d; color: #d97706; }

    /* ── Empty state ── */
    .empty-jobs-row td {
        text-align: center;
        padding: 3rem 1rem !important;
        background: #fbfcff;
    }

    .empty-state-inner {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: .6rem;
    }

    .empty-state-inner i { font-size: 2.2rem; color: #b0bfce; }

    .empty-state-inner p {
        margin: 0;
        font-size: .9rem;
        font-weight: 600;
        color: #64748b;
    }

    /* ── Alerts ── */
    .alert {
        border-radius: 10px;
        font-size: .875rem;
        font-weight: 500;
        padding: .75rem 1rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    /* ── Responsive ── */
    @media (max-width: 1280px) {
        .jobs-grid { font-size: .82rem; }
        .jobs-grid th, .jobs-grid td { padding: .68rem .5rem; }
        .stats-row { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 768px) {
        .manage-jobs-wrap  { margin: -.7rem; padding: .75rem; }
        .manage-jobs-card  { padding: 1rem; }
        .manage-title      { font-size: 1.4rem; }
        .manage-subtitle   { font-size: .85rem; }
        .manage-hero       { padding: 1rem 1.1rem; }
        .btn-post-job      { width: 100%; justify-content: center; }
        .jobs-table-head   { flex-direction: column; align-items: flex-start; }
        .stats-row         { grid-template-columns: repeat(2, 1fr); }
        .jobs-search-wrap  { width: 100%; }
        .jobs-search-wrap input { width: 100%; }
    }
</style>

<div class="manage-jobs-wrap">
    <div class="manage-jobs-card">

        {{-- Hero --}}
        <div class="manage-hero">
            <div class="manage-heading">
                <h4 class="manage-title">Manage Jobs</h4>
                <p class="manage-subtitle">Monitor posting status, application flow, and hiring momentum in one view.</p>
                <span class="hero-chip"><i class="bi bi-building"></i> Employer Portal</span>
            </div>
            <a href="{{ route('employer.jobs.post') }}" class="btn-post-job">
                <i class="bi bi-plus-lg"></i> Post New Job
            </a>
        </div>

        {{-- Stats Row --}}
        @php
            $totalApps = $jobs->sum(fn($j) => $j->applications_count ?? 0);
            $totalViews = $jobs->sum(fn($j) => $j->views ?? $j->view_count ?? 0);
            $expiringSoon = $jobs->filter(fn($j) =>
                $j->application_end_date &&
                \Carbon\Carbon::parse($j->application_end_date)->between(now(), now()->addDays(7))
            )->count();
        @endphp
        <div class="stats-row">
            <div class="stat-card accent-blue">
                <div class="stat-label"><i class="bi bi-briefcase-fill"></i> Active Jobs</div>
                <div class="stat-val">{{ $tabCounts['active'] ?? 0 }}</div>
                <div class="stat-sub">{{ $expiringSoon }} expiring within 7 days</div>
            </div>
            <div class="stat-card accent-green">
                <div class="stat-label"><i class="bi bi-person-lines-fill"></i> Total Applications</div>
                <div class="stat-val">{{ $totalApps }}</div>
                <div class="stat-sub">Across all active listings</div>
            </div>
            <div class="stat-card">
                <div class="stat-label"><i class="bi bi-eye-fill"></i> Total Views</div>
                <div class="stat-val">{{ $totalViews ?: '—' }}</div>
                <div class="stat-sub">{{ $totalViews ? 'Combined impressions' : 'Tracking pending' }}</div>
            </div>
            <div class="stat-card accent-teal">
                <div class="stat-label"><i class="bi bi-check2-circle"></i> Positions Filled</div>
                <div class="stat-val">{{ $tabCounts['filled'] ?? 0 }}</div>
                <div class="stat-sub">{{ ($tabCounts['archived'] ?? 0) }} archived</div>
            </div>
        </div>

        {{-- Tab Bar --}}
        <div class="jobs-tabbar">
            <a class="jobs-tab {{ $selectedTab === 'active'   ? 'active' : '' }}"
               href="{{ route('employer.jobs.manage', ['status' => 'active']) }}">
                <i class="bi bi-briefcase-fill"></i> Active Jobs
                <span class="jobs-tab-badge">{{ $tabCounts['active'] ?? 0 }}</span>
            </a>
            <a class="jobs-tab {{ $selectedTab === 'pending'  ? 'active' : '' }}"
               href="{{ route('employer.jobs.manage', ['status' => 'pending']) }}">
                <i class="bi bi-hourglass-split"></i> Pending Approval
                <span class="jobs-tab-badge gray">{{ $tabCounts['pending'] ?? 0 }}</span>
            </a>
            <a class="jobs-tab {{ $selectedTab === 'draft'    ? 'active' : '' }}"
               href="{{ route('employer.jobs.manage', ['status' => 'draft']) }}">
                <i class="bi bi-file-earmark-text"></i> Drafts
                <span class="jobs-tab-badge gray">{{ $tabCounts['draft'] ?? 0 }}</span>
            </a>
            <a class="jobs-tab {{ $selectedTab === 'archived' ? 'active' : '' }}"
               href="{{ route('employer.jobs.manage', ['status' => 'archived']) }}">
                <i class="bi bi-archive"></i> Archived
                <span class="jobs-tab-badge yellow">{{ $tabCounts['archived'] ?? 0 }}</span>
            </a>
            <a class="jobs-tab {{ $selectedTab === 'filled'   ? 'active' : '' }}"
               href="{{ route('employer.jobs.manage', ['status' => 'filled']) }}">
                <i class="bi bi-check2-circle"></i> Position Filled
                <span class="jobs-tab-badge teal">{{ $tabCounts['filled'] ?? 0 }}</span>
            </a>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success">
                <i class="bi bi-check-circle-fill"></i>{{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle-fill"></i>{{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-circle-fill"></i>{{ $errors->first() }}
            </div>
        @endif

        {{-- PHP helpers --}}
        @php
            $formatEmployment = fn ($type) =>
                ucfirst(str_replace('_', '-', (string)($type ?: 'n-a')));

            $formatSalary = function ($job) {
                $raw = trim((string)($job->salary ?: $job->salary_range ?: ''));
                if ($raw === '') return null;
                if (preg_match('/^\s*(\d+(?:\.\d+)?)\s*-\s*(\d+(?:\.\d+)?)\s*$/', $raw, $m))
                    return [number_format((float)$m[1], 0), number_format((float)$m[2], 0)];
                if (is_numeric($raw))
                    return [number_format((float)$raw, 0), null];
                return [$raw, null];
            };

            $resolveStatus = function ($job) {
                if ($job->is_filled) return ['filled', 'Filled'];
                return match ($job->status) {
                    'active'  => ['active',   'Active'],
                    'pending' => ['pending',  'Pending'],
                    'draft'   => ['draft',    'Draft'],
                    'closed'  => ['archived', 'Archived'],
                    default   => ['draft',    ucfirst((string)$job->status)],
                };
            };

            $isDeadlinePast = fn($date) => $date && \Carbon\Carbon::parse($date)->isPast();
        @endphp

        {{-- Table header / toolbar --}}
        <div class="jobs-table-head">
            <div class="toolbar-left">
                <h5 class="jobs-table-title">
                    <i class="bi bi-kanban-fill" style="color:#3571cc"></i> Job Listings
                </h5>
                <span class="jobs-table-meta">
                    <i class="bi bi-stack"></i> {{ $jobs->count() }} {{ Str::plural('job', $jobs->count()) }}
                </span>
            </div>
            <div class="jobs-search-wrap">
                <i class="bi bi-search"></i>
                <input
                    type="text"
                    id="jobs-search-input"
                    placeholder="Search listings…"
                    aria-label="Search job listings"
                    autocomplete="off"
                >
            </div>
        </div>

        {{-- Table --}}
        <div class="table-responsive jobs-table-wrap">
            <table class="jobs-grid mb-0" id="jobs-table">
                <colgroup>
                    <col style="width:13%">  {{-- Job Title --}}
                    <col style="width:10%">  {{-- Company --}}
                    <col style="width:10%">  {{-- Location --}}
                    <col style="width:8%">   {{-- Employment --}}
                    <col style="width:11%">  {{-- Salary --}}
                    <col style="width:5%">   {{-- Vacancies --}}
                    <col style="width:7%">   {{-- Applications --}}
                    <col style="width:5%">   {{-- Views --}}
                    <col style="width:9%">   {{-- Deadline --}}
                    <col style="width:7%">   {{-- Status --}}
                    <col style="width:15%">  {{-- Actions --}}
                </colgroup>
                <thead>
                    <tr>
                        <th><span class="th-with-icon"><i class="bi bi-briefcase"></i>Job Title</span></th>
                        <th><span class="th-with-icon"><i class="bi bi-building"></i>Company</span></th>
                        <th><span class="th-with-icon"><i class="bi bi-geo-alt"></i>Location</span></th>
                        <th><span class="th-with-icon"><i class="bi bi-person-workspace"></i>Employment</span></th>
                        <th><span class="th-with-icon"><i class="bi bi-cash-stack"></i>Salary</span></th>
                        <th class="text-center"><span class="th-with-icon"><i class="bi bi-people"></i>Vacancies</span></th>
                        <th class="text-center"><span class="th-with-icon"><i class="bi bi-person-lines-fill"></i>Applications</span></th>
                        <th class="text-center"><span class="th-with-icon"><i class="bi bi-eye"></i>Views</span></th>
                        <th><span class="th-with-icon"><i class="bi bi-calendar-event"></i>Deadline</span></th>
                        <th class="text-center"><span class="th-with-icon"><i class="bi bi-activity"></i>Status</span></th>
                        <th class="text-center"><span class="th-with-icon"><i class="bi bi-lightning-charge"></i>Actions</span></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jobs as $job)
                        @php
                            [$statusClass, $statusLabel] = $resolveStatus($job);
                            $salary = $formatSalary($job);
                            $appsCount = $job->applications_count ?? 0;
                            $viewCount = $job->views ?? $job->view_count ?? 0;
                            $deadline  = $job->application_end_date;
                            $isPast    = $isDeadlinePast($deadline);
                        @endphp
                        <tr>
                            {{-- Job Title --}}
                            <td class="job-title-cell">
                                <div class="job-title">{{ $job->title ?: ($job->position ?: 'Untitled Job') }}</div>
                            </td>

                            {{-- Company --}}
                            <td class="cell-company">
                                {{ $job->employer_name ?: (auth()->user()->profile?->company_name ?? auth()->user()->name) }}
                            </td>

                            {{-- Location --}}
                            <td>
                                <div class="cell-location">
                                    <i class="bi bi-geo-alt-fill"></i>
                                    {{ $job->location ?: '—' }}
                                </div>
                            </td>

                            {{-- Employment --}}
                            <td>
                                <span class="employment-pill">
                                    <i class="bi bi-clock"></i>
                                    {{ $formatEmployment($job->job_type) }}
                                </span>
                            </td>

                            {{-- Salary --}}
                            <td class="cell-salary">
                                @if($salary)
                                    <span class="salary-currency">PHP</span>
                                    {{ $salary[0] }}{{ $salary[1] ? ' – ' . $salary[1] : '' }}
                                @else
                                    <span style="color:#a0aec0;font-weight:500">Not specified</span>
                                @endif
                            </td>

                            {{-- Vacancies --}}
                            <td class="cell-num">
                                <span style="font-weight:700;color:#1e3a6e">{{ $job->vacancies ?? 0 }}</span>
                            </td>

                            {{-- Applications --}}
                            <td class="cell-num">
                                <span class="apps-pill {{ $appsCount === 0 ? 'zero' : '' }}">{{ $appsCount }}</span>
                            </td>

                            {{-- Views --}}
                            <td class="cell-num">
                                <span class="views-num">{{ $viewCount ?: '—' }}</span>
                            </td>

                            {{-- Deadline --}}
                            <td>
                                @if($deadline)
                                    <div class="cell-date {{ $isPast ? 'date-past' : '' }}">
                                        <i class="bi bi-calendar-event{{ $isPast ? '-fill' : '' }}"></i>
                                        {{ \Carbon\Carbon::parse($deadline)->format('M d, Y') }}
                                    </div>
                                @else
                                    <span style="color:#a0aec0;font-size:.8rem">No deadline</span>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td class="cell-status">
                                <span class="status-chip {{ $statusClass }}">{{ $statusLabel }}</span>
                            </td>

                            {{-- Actions --}}
                            <td class="cell-actions">
                                <div class="action-row">
                                    {{-- View Applicants --}}
                                    <a href="{{ route('employer.applicants.index') }}"
                                       class="icon-btn view"
                                       title="View Applicants"
                                       aria-label="View Applicants">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('employer.jobs.edit', $job) }}"
                                       class="icon-btn view"
                                       title="Edit Job"
                                       aria-label="Edit Job">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>




                                    {{-- Mark as Filled --}}
                                    @if(($job->status ?? null) !== 'closed')
                                        <form action="{{ route('employer.jobs.filled', $job) }}" method="POST" class="d-inline" style="display:contents">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                    class="icon-btn filled-btn"
                                                    title="Mark as Filled"
                                                    aria-label="Mark as Filled">
                                                <i class="bi bi-check-circle-fill"></i>
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Archive --}}
                                    @if(($job->status ?? null) !== 'closed')
                                        <form action="{{ route('employer.jobs.archive', $job) }}" method="POST" class="d-inline" style="display:contents">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                    class="icon-btn archive"
                                                    title="Archive Job"
                                                    aria-label="Archive Job">
                                                <i class="bi bi-archive-fill"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="empty-jobs-row">
                            <td colspan="11">
                                <div class="empty-state-inner">
                                    <i class="bi bi-inbox"></i>
                                    <p>No jobs found in this tab yet.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

<script>
    (function () {
        const input = document.getElementById('jobs-search-input');
        if (!input) return;
        input.addEventListener('input', function () {
            const q = this.value.trim().toLowerCase();
            const rows = document.querySelectorAll('#jobs-table tbody tr:not(.empty-jobs-row)');
            rows.forEach(function (row) {
                const text = row.textContent.toLowerCase();
                row.style.display = (!q || text.includes(q)) ? '' : 'none';
            });
        });
    })();
</script>
@endsection
