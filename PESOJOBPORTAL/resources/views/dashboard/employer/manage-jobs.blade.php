@extends('dashboard.employer.layout')

@section('title', 'Manage Jobs - PESO')
@section('hide_header', true)

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

    .manage-jobs-wrap {
        background:
            radial-gradient(circle at top right, rgba(84, 133, 255, 0.12), transparent 48%),
            radial-gradient(circle at left bottom, rgba(14, 165, 198, 0.08), transparent 42%),
            var(--mj-bg);
        margin: -1rem;
        padding: 1.5rem;
        min-height: 100vh;
    }

    .manage-jobs-card {
        background: var(--mj-card);
        border: 1px solid var(--mj-line);
        border-radius: 16px;
        padding: 1.45rem;
        box-shadow: 0 16px 30px rgba(15, 23, 42, 0.06);
    }

    .manage-hero {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        position: relative;
        overflow: hidden;
        border-radius: 14px;
        padding: 1.2rem 1.25rem;
        background: linear-gradient(135deg, #2d5da9 0%, #3e76ca 52%, #5f99e3 100%);
        box-shadow: 0 14px 28px rgba(31, 79, 151, 0.28);
    }

    .manage-hero::after {
        content: "";
        position: absolute;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.14);
        right: -70px;
        top: -86px;
    }

    .manage-heading {
        display: grid;
        gap: 6px;
        position: relative;
        z-index: 1;
    }

    .manage-title {
        font-size: 2rem;
        margin: 0;
        font-weight: 700;
        color: #ffffff;
        letter-spacing: -0.01em;
    }

    .manage-subtitle {
        margin: 0;
        color: rgba(255, 255, 255, 0.92);
        font-size: 0.95rem;
    }

    .manage-hero-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.45rem;
        margin-top: 0.25rem;
    }

    .hero-chip {
        border: 1px solid rgba(255, 255, 255, 0.38);
        border-radius: 999px;
        padding: 0.28rem 0.7rem;
        font-size: 0.82rem;
        font-weight: 600;
        color: #ffffff;
        background: rgba(255, 255, 255, 0.14);
        backdrop-filter: blur(3px);
    }

    .btn-post-job {
        border: 0;
        border-radius: 11px;
        padding: 0.6rem 0.95rem;
        font-weight: 700;
        color: #1f4f97;
        text-decoration: none;
        background: #ffffff;
        box-shadow: 0 10px 20px rgba(15, 23, 42, 0.2);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        position: relative;
        z-index: 1;
    }

    .btn-post-job:hover {
        transform: translateY(-1px);
        box-shadow: 0 14px 24px rgba(15, 23, 42, 0.28);
        color: #173d77;
    }

    .jobs-tabbar {
        display: flex;
        gap: 0.45rem;
        flex-wrap: wrap;
        border: 1px solid var(--mj-line);
        border-radius: 12px;
        background: #f8faff;
        padding: 0.45rem;
        margin-top: 1rem;
        margin-bottom: 1.2rem;
    }

    .jobs-tab {
        color: #3f4f68;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border-radius: 10px;
        padding: 0.55rem 0.75rem;
        font-weight: 600;
        transition: background-color 0.15s ease, color 0.15s ease;
    }

    .jobs-tab:hover {
        background: #eef3fb;
        color: #1f3c70;
    }

    .jobs-tab i {
        font-size: 1rem;
    }

    .jobs-tab.active {
        color: #0f3fa8;
        background: var(--mj-accent-soft);
        box-shadow: inset 0 0 0 1px #c6d6fb;
        font-weight: 700;
    }

    .jobs-tab-badge {
        font-size: 0.73rem;
        font-weight: 700;
        line-height: 1;
        border-radius: 999px;
        padding: 0.25rem 0.45rem;
        color: #fff;
        background: #2360f1;
    }
    .jobs-tab-badge.gray { background: #6b778c; }
    .jobs-tab-badge.yellow { background: #f5b700; }
    .jobs-tab-badge.teal { background: #0ea5c6; }

    .jobs-table-wrap {
        border: 1px solid var(--mj-line);
        border-radius: 12px;
        overflow: hidden;
        background: #fff;
    }

    .jobs-grid th {
        font-size: 0.83rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: #4f5f78;
        border-bottom: 1px solid #dfe6f3;
        background: linear-gradient(180deg, #f8fbff 0%, #f3f7fc 100%);
        white-space: normal;
        padding: 0.75rem 0.7rem;
        line-height: 1.15;
        text-align: center;
    }

    .jobs-grid td {
        border-bottom: 1px solid #e7ecf5;
        vertical-align: middle;
        padding: 0.72rem 0.7rem;
        font-size: 0.9rem;
    }

    .jobs-grid {
        width: 100%;
        min-width: 0;
        table-layout: fixed;
    }

    .jobs-grid tbody tr {
        transition: background-color 0.15s ease;
    }

    .jobs-grid tbody tr:hover {
        background: #f9fbff;
    }

    .job-title {
        font-size: 1.08rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.18rem;
    }
    .job-sub {
        color: #596680;
        font-size: 0.88rem;
    }
    .cell-company,
    .cell-location {
        color: #334155;
        line-height: 1.35;
        white-space: normal;
        word-break: break-word;
    }
    .cell-num,
    .cell-date,
    .cell-status {
        white-space: nowrap;
        text-align: center;
    }
    .cell-actions {
        white-space: nowrap;
        min-width: 0;
        text-align: center;
    }
    .employment-pill {
        display: inline-block;
        background: #6b778c;
        color: #fff;
        border-radius: 8px;
        font-size: 0.78rem;
        font-weight: 700;
        padding: 0.22rem 0.5rem;
        text-transform: capitalize;
        white-space: nowrap;
    }
    .status-chip {
        display: inline-flex;
        align-items: center;
        border-radius: 999px;
        padding: 0.2rem 0.55rem;
        font-size: 0.77rem;
        font-weight: 700;
        line-height: 1.2;
        white-space: nowrap;
    }
    .status-chip.active { background: #e6f9ee; color: #0f8c4a; }
    .status-chip.pending { background: #fff6dc; color: #946200; }
    .status-chip.draft { background: #edf2f9; color: #46546d; }
    .status-chip.archived { background: #f5f7fb; color: #5f6e86; }
    .status-chip.filled { background: #e7f7ff; color: #0f7fa0; }
    .apps-pill {
        background: #2360f1;
        color: #fff;
        border-radius: 8px;
        min-width: 1.5rem;
        display: inline-flex;
        justify-content: center;
        padding: 0.08rem 0.38rem;
        font-size: 0.77rem;
        font-weight: 700;
    }
    .action-row {
        display: flex;
        justify-content: center;
        gap: 0.35rem;
        flex-wrap: nowrap;
    }

    .icon-btn {
        width: 30px;
        height: 30px;
        padding: 0;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #cfd8ea;
        background: #fff;
        color: #2a5fdf;
        box-shadow: 0 3px 6px rgba(15, 23, 42, 0.06);
        transition: transform 0.15s ease, box-shadow 0.15s ease, background-color 0.15s ease;
    }

    .icon-btn:hover {
        background: #f0f5ff;
        color: #1347c0;
        transform: translateY(-1px);
        box-shadow: 0 6px 12px rgba(15, 23, 42, 0.1);
    }

    .icon-btn.view {
        color: #2563eb;
        border-color: #c7dbff;
        background: #f5f9ff;
    }

    .icon-btn.duplicate {
        color: #7c3aed;
        border-color: #dfceff;
        background: #f8f5ff;
    }

    .icon-btn.filled {
        color: #0f8c4a;
        border-color: #c6efd6;
        background: #f0fbf5;
    }

    .icon-btn.archive {
        color: #b45309;
        border-color: #fde3c1;
        background: #fff9f0;
    }

    .action-icon {
        width: 15px;
        height: 15px;
        stroke: currentColor;
        fill: none;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }
    .empty-jobs-row {
        text-align: center;
        color: #64748b;
        padding: 1.3rem !important;
        font-weight: 600;
        background: #fbfdff;
    }

    @media (max-width: 1200px) {
        .jobs-grid {
            font-size: 0.85rem;
        }
        .jobs-grid th,
        .jobs-grid td {
            padding: 0.58rem 0.45rem;
        }
        .job-title {
            font-size: 0.98rem;
        }
    }
    @media (max-width: 768px) {
        .manage-jobs-wrap {
            margin: -0.7rem;
            padding: 0.75rem;
        }
        .manage-jobs-card {
            padding: 1rem;
        }
        .manage-title {
            font-size: 1.5rem;
        }
        .manage-subtitle {
            font-size: 0.88rem;
        }
        .manage-hero {
            padding: 1rem;
        }
        .btn-post-job {
            width: 100%;
            text-align: center;
        }
    }
</style>

<div class="manage-jobs-wrap">
    <div class="manage-jobs-card">
        <div class="manage-hero">
            <div class="manage-heading">
                <h4 class="manage-title">Manage Jobs</h4>
                <p class="manage-subtitle">Monitor posting status, application flow, and hiring momentum in one view.</p>
                <div class="manage-hero-meta">
                    <span class="hero-chip">Employer Portal</span>
                </div>
            </div>
            <a href="{{ route('employer.jobs.post') }}" class="btn-post-job">
                <i class="bi bi-plus-lg me-1"></i> Post New Job
            </a>
        </div>

        <div class="jobs-tabbar">
            <a class="jobs-tab {{ $selectedTab === 'active' ? 'active' : '' }}" href="{{ route('employer.jobs.manage', ['status' => 'active']) }}">
                <i class="bi bi-briefcase"></i> Active Jobs
                <span class="jobs-tab-badge">{{ $tabCounts['active'] ?? 0 }}</span>
            </a>
            <a class="jobs-tab {{ $selectedTab === 'pending' ? 'active' : '' }}" href="{{ route('employer.jobs.manage', ['status' => 'pending']) }}">
                <i class="bi bi-hourglass-split"></i> Pending Approval
                <span class="jobs-tab-badge gray">{{ $tabCounts['pending'] ?? 0 }}</span>
            </a>
            <a class="jobs-tab {{ $selectedTab === 'draft' ? 'active' : '' }}" href="{{ route('employer.jobs.manage', ['status' => 'draft']) }}">
                <i class="bi bi-file-earmark"></i> Drafts
                <span class="jobs-tab-badge gray">{{ $tabCounts['draft'] ?? 0 }}</span>
            </a>
            <a class="jobs-tab {{ $selectedTab === 'archived' ? 'active' : '' }}" href="{{ route('employer.jobs.manage', ['status' => 'archived']) }}">
                <i class="bi bi-archive"></i> Archived
                <span class="jobs-tab-badge yellow">{{ $tabCounts['archived'] ?? 0 }}</span>
            </a>
            <a class="jobs-tab {{ $selectedTab === 'filled' ? 'active' : '' }}" href="{{ route('employer.jobs.manage', ['status' => 'filled']) }}">
                <i class="bi bi-check2-square"></i> Position Filled
                <span class="jobs-tab-badge teal">{{ $tabCounts['filled'] ?? 0 }}</span>
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success mb-3">
                <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mb-3">
                <i class="bi bi-exclamation-triangle me-1"></i>{{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger mb-3">
                <i class="bi bi-exclamation-circle me-1"></i>{{ $errors->first() }}
            </div>
        @endif

        @php
            $formatEmployment = fn ($type) => ucfirst(str_replace('_', '-', (string) ($type ?: 'n-a')));
            $formatSalary = function ($job) {
                $raw = trim((string) ($job->salary ?: $job->salary_range ?: ''));
                if ($raw === '') {
                    return 'Not specified';
                }

                if (preg_match('/^\s*(\d+(?:\.\d+)?)\s*-\s*(\d+(?:\.\d+)?)\s*$/', $raw, $matches)) {
                    $min = number_format((float) $matches[1], 0);
                    $max = number_format((float) $matches[2], 0);

                    return 'PHP '.$min.' - PHP '.$max;
                }

                if (is_numeric($raw)) {
                    return 'PHP '.number_format((float) $raw, 0);
                }

                return $raw;
            };
            $resolveStatus = function ($job) {
                if ($job->is_filled) {
                    return ['filled', 'Position Filled'];
                }

                return match ($job->status) {
                    'active' => ['active', 'Active'],
                    'pending' => ['pending', 'Pending'],
                    'draft' => ['draft', 'Draft'],
                    'closed' => ['archived', 'Archived'],
                    default => ['draft', ucfirst((string) $job->status)],
                };
            };
        @endphp

        <div class="table-responsive jobs-table-wrap">
            <table class="table align-middle jobs-grid mb-0">
                <thead>
                    <tr>
                        <th>Job Title</th>
                        <th>Company</th>
                        <th>Location</th>
                        <th>Employment</th>
                        <th>Salary</th>
                        <th>Vacancies</th>
                        <th>Applications</th>
                        <th>Views</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jobs as $job)
                        @php
                            [$statusClass, $statusLabel] = $resolveStatus($job);
                        @endphp
                        <tr>
                            <td>
                                <div class="job-title">{{ $job->title ?: ($job->position ?: 'Untitled Job') }}</div>
                                <div class="job-sub">{{ $formatEmployment($job->job_type) }}</div>
                            </td>
                            <td class="cell-company">{{ $job->employer_name ?: (auth()->user()->profile->company_name ?? auth()->user()->name) }}</td>
                            <td class="cell-location">{{ $job->location ?: 'No location' }}</td>
                            <td><span class="employment-pill">{{ $formatEmployment($job->job_type) }}</span></td>
                            <td>{{ $formatSalary($job) }}</td>
                            <td class="cell-num">{{ $job->vacancies ?? 0 }}</td>
                            <td class="cell-num"><span class="apps-pill">{{ $job->applications_count ?? 0 }}</span></td>
                            <td class="cell-num">{{ $job->views ?? $job->view_count ?? 0 }}</td>
                            <td class="cell-date">{{ optional($job->application_end_date)->format('M d, Y') ?: 'No deadline' }}</td>
                            <td class="cell-status">
                                <span class="status-chip {{ $statusClass }}">{{ $statusLabel }}</span>
                            </td>
                            <td class="text-end cell-actions">
                                <div class="action-row">
                                    <a href="{{ route('employer.applicants.index') }}" class="icon-btn view" title="View Applicants" aria-label="View Applicants">
                                        <svg class="action-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    </a>

                                    <form action="{{ route('employer.jobs.duplicate', $job) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="icon-btn duplicate" title="Duplicate Job" aria-label="Duplicate Job">
                                            <svg class="action-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 20h9"></path><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"></path></svg>
                                        </button>
                                    </form>

                                    @if(($job->status ?? null) !== 'closed')
                                        <form action="{{ route('employer.jobs.filled', $job) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="icon-btn filled" title="Mark as Filled" aria-label="Mark as Filled">
                                                <svg class="action-icon" viewBox="0 0 24 24" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                            </button>
                                        </form>
                                    @endif

                                    @if(($job->status ?? null) !== 'closed')
                                        <form action="{{ route('employer.jobs.archive', $job) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="icon-btn archive" title="Archive Job" aria-label="Archive Job">
                                                <svg class="action-icon" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="4" width="18" height="4"></rect><path d="M5 8v12h14V8"></path><path d="M10 12h4"></path></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="empty-jobs-row">No jobs found in this tab yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
