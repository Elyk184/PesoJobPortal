@extends('dashboard.employer.layout')

@section('title', 'Manage Jobs - PESO')
@section('hide_header')@endsection

@section('content')
<style>
    .manage-jobs-wrap {
        background: #eff1f6;
        margin: -1rem;
        padding: 1.3rem;
        min-height: 100vh;
    }
    .manage-jobs-head {
        background: #ffffff;
        border: 1px solid #e3e8f3;
        border-radius: 12px;
        padding: 1.2rem 1.4rem;
        margin-bottom: 1rem;
    }
    .manage-jobs-head h3 {
        margin: 0;
        font-size: 1.9rem;
        font-weight: 700;
        color: #16233a;
    }
    .manage-jobs-head p {
        margin: 0.2rem 0 0;
        color: #5a667a;
    }
    .manage-jobs-card {
        background: #ffffff;
        border: 1px solid #dfe5f1;
        border-radius: 12px;
        padding: 1.35rem;
    }
    .manage-title {
        font-size: 2rem;
        margin: 0;
        font-weight: 700;
        color: #16233a;
    }
    .jobs-tabbar {
        display: flex;
        gap: 0.4rem;
        flex-wrap: wrap;
        border-bottom: 1px solid #e5eaf4;
        margin-top: 1.2rem;
        margin-bottom: 1.2rem;
    }
    .jobs-tab {
        color: #3f4f68;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 0.85rem;
        border-bottom: 2px solid transparent;
        font-weight: 500;
    }
    .jobs-tab i {
        font-size: 1rem;
    }
    .jobs-tab.active {
        color: #2360f1;
        border-bottom-color: #2360f1;
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
    .jobs-grid th {
        font-size: 0.83rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: #4f5f78;
        border-bottom: 1px solid #dfe6f3;
        background: #f7f9fc;
        white-space: nowrap;
    }
    .jobs-grid td {
        border-bottom: 1px solid #e7ecf5;
        vertical-align: middle;
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
        justify-content: flex-end;
        gap: 0.3rem;
        flex-wrap: wrap;
    }
    .icon-btn {
        width: 30px;
        height: 30px;
        padding: 0;
        border-radius: 7px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #cfd8ea;
        background: #fff;
        color: #2a5fdf;
    }
    .icon-btn:hover {
        background: #f0f5ff;
        color: #1347c0;
    }
    @media (max-width: 1200px) {
        .jobs-grid {
            min-width: 1180px;
        }
    }
    @media (max-width: 768px) {
        .manage-jobs-wrap {
            margin: -0.7rem;
            padding: 0.75rem;
        }
        .manage-jobs-head,
        .manage-jobs-card {
            padding: 1rem;
        }
        .manage-title {
            font-size: 1.5rem;
        }
    }
</style>

<div class="manage-jobs-wrap">
    <div class="manage-jobs-head d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div>
            <h3>Dashboard</h3>
            <p>Manage your job postings and applicants</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-building text-primary"></i>
            <strong>{{ auth()->user()->profile->company_name ?? auth()->user()->name }}</strong>
        </div>
    </div>

    <div class="manage-jobs-card">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
            <h4 class="manage-title">Manage Jobs</h4>
            <a href="{{ route('employer.jobs.post') }}" class="btn btn-primary">
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

        <div class="table-responsive">
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
                    @foreach($jobs as $job)
                        @php
                            [$statusClass, $statusLabel] = $resolveStatus($job);
                        @endphp
                        <tr>
                            <td>
                                <div class="job-title">{{ $job->title ?: ($job->position ?: 'Untitled Job') }}</div>
                                <div class="job-sub">{{ $formatEmployment($job->job_type) }}</div>
                            </td>
                            <td>{{ $job->employer_name ?: (auth()->user()->profile->company_name ?? auth()->user()->name) }}</td>
                            <td>{{ $job->location ?: 'No location' }}</td>
                            <td><span class="employment-pill">{{ $formatEmployment($job->job_type) }}</span></td>
                            <td>{{ $formatSalary($job) }}</td>
                            <td>{{ $job->vacancies ?? 0 }}</td>
                            <td><span class="apps-pill">{{ $job->applications_count ?? 0 }}</span></td>
                            <td>{{ $job->views ?? $job->view_count ?? 0 }}</td>
                            <td>{{ optional($job->application_end_date)->format('M d, Y') ?: 'No deadline' }}</td>
                            <td>
                                <span class="status-chip {{ $statusClass }}">{{ $statusLabel }}</span>
                            </td>
                            <td class="text-end">
                                <div class="action-row">
                                    <a href="{{ route('employer.applicants.index') }}" class="icon-btn" title="View Applicants" aria-label="View Applicants">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <form action="{{ route('employer.jobs.duplicate', $job) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="icon-btn" title="Duplicate Job" aria-label="Duplicate Job">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    </form>

                                    @if(($job->status ?? null) !== 'closed')
                                        <form action="{{ route('employer.jobs.filled', $job) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="icon-btn" title="Mark as Filled" aria-label="Mark as Filled">
                                                <i class="bi bi-check2-square"></i>
                                            </button>
                                        </form>
                                    @endif

                                    @if(($job->status ?? null) !== 'closed')
                                        <form action="{{ route('employer.jobs.archive', $job) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="icon-btn" title="Archive Job" aria-label="Archive Job">
                                                <i class="bi bi-archive"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
