<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Dashboard</title>
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
            width: min(1200px, 94vw);
            margin: 24px auto 40px;
        }

        .header {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
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
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 12px;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1>Employer Dashboard</h1>
                <p>Welcome, {{ auth()->user()->name ?? 'Employer' }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-secondary" type="submit">Logout</button>
            </form>
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

        <div class="panel">
            <h2>Post Job Vacancies</h2>
            <p>Only verified employers can create or duplicate vacancies.</p>
            @if ($isVerifiedEmployer)
                <span class="pill">Verified Employer</span>
            @else
                <span class="pill" style="background:#fef2f2;color:#b91c1c;">Not Verified</span>
            @endif

            <form method="POST" action="{{ route('employer.jobs.store') }}">
                @csrf
                <div class="grid">
                    <div>
                        <label>Position</label>
                        <input type="text" name="position" value="{{ old('position') }}" required>
                    </div>
                    <div>
                        <label>Salary</label>
                        <input type="text" name="salary" value="{{ old('salary') }}" placeholder="PHP 20,000 - 30,000">
                    </div>
                    <div>
                        <label>Location</label>
                        <input type="text" name="location" value="{{ old('location') }}" required>
                    </div>
                    <div>
                        <label>Type</label>
                        <select name="job_type" required>
                            <option value="">Select</option>
                            <option value="Full-time" @selected(old('job_type') === 'Full-time')>Full-time</option>
                            <option value="Part-time" @selected(old('job_type') === 'Part-time')>Part-time</option>
                            <option value="Contract" @selected(old('job_type') === 'Contract')>Contract</option>
                            <option value="Project-based" @selected(old('job_type') === 'Project-based')>Project-based</option>
                        </select>
                    </div>
                    <div>
                        <label>Vacancies</label>
                        <input type="number" min="1" name="vacancies" value="{{ old('vacancies', 1) }}" required>
                    </div>
                    <div>
                        <label>Application Start Date</label>
                        <input type="date" name="application_start_date" value="{{ old('application_start_date') }}" required>
                    </div>
                    <div>
                        <label>Application End Date</label>
                        <input type="date" name="application_end_date" value="{{ old('application_end_date') }}" required>
                    </div>
                </div>

                <label>Qualifications</label>
                <textarea name="qualifications" required>{{ old('qualifications') }}</textarea>

                <button class="btn" type="submit" @disabled(! $isVerifiedEmployer)>Post Vacancy</button>
            </form>
        </div>

        <div class="panel">
            <h2>Manage Job Postings</h2>
            <div class="list">
                @forelse ($jobs as $job)
                    <div class="item">
                        <h3>{{ $job->position ?? $job->title }}</h3>
                        <p>{{ $job->location }} | {{ $job->job_type ?? 'N/A' }} | Vacancies: {{ $job->vacancies ?? 1 }}</p>
                        <span class="pill">Status: {{ strtoupper($job->status) }}</span>
                        @if ($job->is_filled)
                            <span class="pill" style="background:#fee2e2;color:#991b1b;">Filled</span>
                        @endif
                        @if ($job->archived_at)
                            <span class="pill" style="background:#e2e8f0;color:#334155;">Archived</span>
                        @endif

                        <div class="actions">
                            <form method="POST" action="{{ route('employer.jobs.extend', $job) }}">
                                @csrf
                                @method('PATCH')
                                <input type="date" name="application_end_date" required>
                                <button class="btn" type="submit">Extend Posting</button>
                            </form>

                            <form method="POST" action="{{ route('employer.jobs.archive', $job) }}">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-danger" type="submit">Archive</button>
                            </form>

                            <form method="POST" action="{{ route('employer.jobs.duplicate', $job) }}">
                                @csrf
                                <button class="btn btn-secondary" type="submit" @disabled(! $isVerifiedEmployer)>Duplicate</button>
                            </form>

                            @if (! $job->is_filled)
                                <form method="POST" action="{{ route('employer.jobs.filled', $job) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn" type="submit">Mark as Filled</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <p>No postings yet.</p>
                @endforelse
            </div>
        </div>

        <div class="panel">
            <h2>Request Local / Special Recruitment Activities (LRA/SRA)</h2>
            <form method="POST" action="{{ route('employer.recruitment.request') }}" enctype="multipart/form-data">
                @csrf
                <div class="grid">
                    <div>
                        <label>Activity Type</label>
                        <select name="activity_type" required>
                            <option value="">Select</option>
                            <option value="lra" @selected(old('activity_type') === 'lra')>LRA</option>
                            <option value="sra" @selected(old('activity_type') === 'sra')>SRA</option>
                        </select>
                    </div>
                    <div>
                        <label>Letter of Intent</label>
                        <input type="file" name="letter_of_intent" required>
                    </div>
                    <div>
                        <label>Company Profile</label>
                        <input type="file" name="company_profile" required>
                    </div>
                    <div>
                        <label>Job Advertisement (Facebook/Social Media Ready)</label>
                        <input type="file" name="job_advertisement" required>
                    </div>
                </div>
                <button class="btn" type="submit">Submit LRA/SRA Request</button>
            </form>

            <div class="list" style="margin-top: 12px;">
                @forelse ($recruitmentRequests as $request)
                    <div class="item">
                        <strong>{{ strtoupper($request->activity_type) }}</strong>
                        <p>Status: {{ strtoupper($request->status) }}</p>
                    </div>
                @empty
                    <p>No LRA/SRA requests submitted yet.</p>
                @endforelse
            </div>
        </div>

        <div class="panel">
            <h2>Referred Applicants</h2>
            <p>Only referred applicants for your vacancies are shown below.</p>
            <div class="list">
                @forelse ($referredApplications as $application)
                    <div class="item">
                        <h3>{{ $application->user->name ?? 'Applicant' }}</h3>
                        <p>Email: {{ $application->user->email ?? 'N/A' }}</p>
                        <p>Job: {{ $application->job->position ?? $application->job->title ?? 'N/A' }}</p>
                        <p>Phone: {{ $application->user->profile->phone ?? 'N/A' }}</p>
                        <p>Address: {{ $application->user->profile->address ?? 'N/A' }}</p>
                        <p>Objective: {{ $application->user->profile->objective ?? 'N/A' }}</p>
                        <p>Skills: {{ is_array($application->user->profile->skills ?? null) ? implode(', ', $application->user->profile->skills) : 'N/A' }}</p>

                        <form method="POST" action="{{ route('employer.applications.update', $application) }}">
                            @csrf
                            @method('PATCH')
                            <div class="grid">
                                <div>
                                    <label>Status</label>
                                    <select name="employer_status" required>
                                        <option value="interview_scheduled" @selected($application->employer_status === 'interview_scheduled')>Interview Scheduled</option>
                                        <option value="hired" @selected($application->employer_status === 'hired')>Hired</option>
                                        <option value="not_selected" @selected($application->employer_status === 'not_selected')>Not Selected</option>
                                    </select>
                                </div>
                                <div>
                                    <label>Final Decision</label>
                                    <select name="final_decision" required>
                                        <option value="pending" @selected($application->final_decision === 'pending')>Pending</option>
                                        <option value="hired" @selected($application->final_decision === 'hired')>Hired</option>
                                        <option value="not_selected" @selected($application->final_decision === 'not_selected')>Not Selected</option>
                                    </select>
                                </div>
                            </div>
                            <label>Feedback for Jobseeker (Optional)</label>
                            <textarea name="employer_feedback">{{ $application->employer_feedback }}</textarea>
                            <button class="btn" type="submit">Update Applicant Decision</button>
                        </form>
                    </div>
                @empty
                    <p>No referred applicants yet.</p>
                @endforelse
            </div>
        </div>

        <div class="panel">
            <h2>Notifications</h2>
            <p>Job fair invites and referral updates appear here.</p>
            <div class="list">
                @forelse ($notifications as $notification)
                    <div class="item">
                        <strong>{{ $notification->title }}</strong>
                        <p>{{ $notification->message }}</p>
                        <span class="pill">{{ strtoupper(str_replace('_', ' ', $notification->type)) }}</span>
                        @if (! $notification->is_read)
                            <form method="POST" action="{{ route('employer.notifications.read', $notification) }}">
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
    </div>
</body>
</html>
