@extends('layouts.admin-dashboard')

@section('title', $jobseeker->name . ' | Jobseeker Profile | PESO Admin')

<?php
    $pageTitle = $jobseeker->name;
    $pageSubtitle = 'Jobseeker Profile & Management';
    $pageIcon = 'bi-person-circle';
?>

@section('content')
<div class="admin-dashboard">
    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-bottom: 2rem; border-radius: 8px; border-left: 4px solid #10b981;">
            <i class="bi bi-check-circle me-2"></i>
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-bottom: 2rem; border-radius: 8px; border-left: 4px solid #ef4444;">
            <i class="bi bi-exclamation-circle me-2"></i>
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <style>
        .admin-dashboard {
            background:
                radial-gradient(900px 420px at 100% 0%, rgba(37, 99, 235, 0.14) 0%, rgba(37, 99, 235, 0) 60%),
                radial-gradient(700px 320px at 0% 0%, rgba(20, 184, 166, 0.12) 0%, rgba(20, 184, 166, 0) 52%),
                linear-gradient(180deg, #f8fbff 0%, #f3f7fb 100%);
            padding: 1.25rem;
            border-radius: 20px;
        }

        .profile-header {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 2rem;
            margin-bottom: 3rem;
            align-items: start;
        }

        .profile-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.98) 0%, #f8fafc 100%);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(148, 163, 184, 0.22);
            position: relative;
            overflow: hidden;
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        }

        .profile-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #2563eb 0%, #14b8a6 55%, #f59e0b 100%);
            border-radius: 24px 24px 0 0;
        }

        .profile-card:hover,
        .dashboard-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 22px 50px rgba(15, 23, 42, 0.12);
            border-color: rgba(37, 99, 235, 0.18);
        }

        .profile-avatar {
            width: 104px;
            height: 104px;
            border-radius: 28px;
            background: linear-gradient(135deg, #0f172a 0%, #2563eb 55%, #14b8a6 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            font-size: 40px;
            box-shadow: 0 18px 28px rgba(37, 99, 235, 0.25);
            margin-bottom: 1.5rem;
        }

        .profile-info h3 {
            margin: 0 0 0.5rem 0;
            color: #0f172a;
            font-weight: 800;
            font-size: 28px;
            letter-spacing: -0.5px;
        }

        .profile-info p {
            margin: 0.35rem 0;
            color: #475569;
            font-size: 14px;
        }

        .profile-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(148, 163, 184, 0.25);
        }

        .stat-item {
            text-align: center;
            padding: 1rem;
            border-radius: 18px;
            background: linear-gradient(180deg, rgba(248, 250, 252, 0.95) 0%, rgba(241, 245, 249, 0.85) 100%);
            border: 1px solid rgba(148, 163, 184, 0.16);
        }

        .stat-value {
            font-size: 30px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1;
        }

        .stat-label {
            font-size: 12px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 0.65rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.35rem;
        }

        .action-sidebar {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .btn-action {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 12px 16px;
            border-radius: 12px;
            border: none;
            font-weight: 700;
            font-size: 14px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-back {
            background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%);
            color: #374151;
        }

        .btn-back:hover {
            background: linear-gradient(135deg, #d1d5db 0%, #bfdbfe 100%);
            transform: translateY(-2px);
        }

        .btn-recommend {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: #92400e;
        }

        .btn-recommend:hover {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            transform: translateY(-2px);
        }

        .dashboard-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.98) 0%, #f8fafc 100%);
            border-radius: 22px;
            padding: 2.25rem;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(148, 163, 184, 0.22);
            position: relative;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .dashboard-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #2563eb 0%, #14b8a6 55%, #f59e0b 100%);
            border-radius: 22px 22px 0 0;
        }

        .dashboard-card h5 {
            color: #0f172a;
            font-weight: 800;
            margin: 0 0 1.75rem 0;
            padding-bottom: 1.25rem;
            border-bottom: 1px solid rgba(148, 163, 184, 0.25);
            font-size: 17px;
            letter-spacing: -0.3px;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .dashboard-card h5 i {
            color: #2563eb;
            font-size: 1.05rem;
        }

        .section-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.35rem 0.75rem;
            border-radius: 999px;
            background: #eff6ff;
            color: #1d4ed8;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin-left: auto;
        }

        .info-row {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .info-label {
            font-weight: 700;
            color: #6b7280;
            min-width: 120px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .info-value {
            color: #0f172a;
            font-weight: 600;
            line-height: 1.6;
        }

        .application-item {
            background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);
            border: 1px solid rgba(148, 163, 184, 0.2);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .application-item:hover {
            border-color: rgba(37, 99, 235, 0.25);
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.08);
            transform: translateY(-1px);
        }

        .application-title {
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.5rem;
        }

        .application-company {
            font-size: 13px;
            color: #475569;
            margin-bottom: 0.75rem;
        }

        .application-status {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-applied {
            background: #dbeafe;
            color: #1e40af;
        }

        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #9ca3af;
            background: linear-gradient(180deg, rgba(248, 250, 252, 0.65), rgba(241, 245, 249, 0.5));
            border-radius: 14px;
            border: 1px dashed rgba(148, 163, 184, 0.35);
        }

        .empty-state i {
            font-size: 3rem;
            opacity: 0.3;
            color: #d1d5db;
            margin-bottom: 1rem;
        }

        .empty-state p {
            margin: 0.5rem 0;
            font-weight: 700;
            color: #6b7280;
        }

        /* Modal Fixes */
        body.modal-open {
            overflow-y: scroll;
            padding-right: 0 !important;
        }

        .modal {
            z-index: 1050;
        }

        .modal-backdrop {
            z-index: 1040;
        }

        .modal.fade {
            transition: opacity 0.15s linear, transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .modal.show {
            transform: scale(1);
        }

        .modal-dialog {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .modal-content {
            border: none;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .modal-header {
            border-radius: 16px 16px 0 0;
            border: none;
        }

        .modal-body {
            max-height: 70vh;
            overflow-y: auto;
        }

        .modal-body::-webkit-scrollbar {
            width: 8px;
        }

        .modal-body::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .modal-body::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .modal-body::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .admin-dashboard {
            background:
                radial-gradient(900px 420px at 100% 0%, rgba(37, 99, 235, 0.14) 0%, rgba(37, 99, 235, 0) 60%),
                radial-gradient(700px 320px at 0% 0%, rgba(20, 184, 166, 0.12) 0%, rgba(20, 184, 166, 0) 52%),
                linear-gradient(180deg, #f8fbff 0%, #f3f7fb 100%);
            padding: 1.25rem;
            border-radius: 20px;
        }

        .top-action-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .btn-back-top {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            font-weight: 700;
            border-radius: 999px;
            padding: 0.65rem 1rem;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #fff;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.18);
            transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }

        .btn-back-top:hover {
            color: #fff;
            background: #1e293b;
            transform: translateY(-1px);
            box-shadow: 0 12px 26px rgba(15, 23, 42, 0.28);
        }

        .profile-card,
        .dashboard-card {
            border: 1px solid rgba(148, 163, 184, 0.22);
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
        }

        @media (max-width: 992px) {
            .profile-header {
                grid-template-columns: 1fr;
            }

            .action-sidebar {
                flex-direction: row;
            }
        }
    </style>

    @php
        $displayName = $personalInformation?->first_name
            ? trim(implode(' ', array_filter([
                $personalInformation?->first_name,
                $personalInformation?->middle_initial,
                $personalInformation?->surname,
                $personalInformation?->suffix,
            ])))
            : $jobseeker->name;

        $avatarLetter = strtoupper(substr($displayName ?: 'U', 0, 1));
        $presentAddressLine = trim(implode(', ', array_filter([
            $presentAddress?->house_no,
            $presentAddress?->barangay,
            $presentAddress?->municipality,
            $presentAddress?->province,
        ]))) ?: 'Not provided';

        $permanentAddressLine = trim(implode(', ', array_filter([
            $permanentAddress?->house_no,
            $permanentAddress?->barangay,
            $permanentAddress?->municipality,
            $permanentAddress?->province,
        ]))) ?: 'Not provided';

        $skillsCount = collect([
            $otherSkills['trade_manual'] ?? [],
            $otherSkills['it_technical'] ?? [],
            $otherSkills['soft_skills'] ?? [],
            [$otherSkills['other_text'] ?? ''],
        ])->flatten()->filter()->count();
    @endphp

    <div class="top-action-bar">
        <a href="{{ route('admin.jobseekers.index') }}" class="btn-back-top">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="profile-header">
        <div class="profile-card">
            <div class="profile-avatar">{{ $avatarLetter }}</div>
            <div class="profile-info">
                <h3>{{ $displayName }}</h3>
                <p><i class="bi bi-envelope-paper me-2"></i>{{ $jobseeker->email }}</p>
                <p><i class="bi bi-calendar3 me-2"></i>Member since {{ $jobseeker->created_at->format('M d, Y') }}</p>
                <p><i class="bi bi-geo-alt-fill me-2"></i>{{ $presentAddressLine }}</p>

                <div class="profile-stats">
                    <div class="stat-item">
                        <div class="stat-value">{{ $jobseeker->applications->count() }}</div>
                        <div class="stat-label"><i class="bi bi-send"></i>Applications</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $educationRows->count() }}</div>
                        <div class="stat-label"><i class="bi bi-mortarboard-fill"></i>Education</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $skillsCount }}</div>
                        <div class="stat-label"><i class="bi bi-stars"></i>Skills</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $availableJobs->count() }}</div>
                        <div class="stat-label"><i class="bi bi-briefcase-fill"></i>Jobs Available</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="action-sidebar">
            <button type="button" class="btn btn-action btn-recommend open-recommend-modal"
                    data-jobseeker-id="{{ $jobseeker->id }}"
                    data-jobseeker-name="{{ $displayName }}">
                <i class="bi bi-stars"></i> Recommend Job
            </button>
        </div>
    </div>

    <div class="dashboard-card">
        <h5><i class="bi bi-person-lines-fill"></i>Personal Information <span class="section-badge"><i class="bi bi-person-vcard"></i>Identity</span></h5>
        <div class="row g-3">
            <div class="col-md-4"><div class="info-row"><div class="info-label"><i class="bi bi-person-badge"></i>First Name</div><div class="info-value">{{ $personalInformation?->first_name ?: 'N/A' }}</div></div></div>
            <div class="col-md-4"><div class="info-row"><div class="info-label"><i class="bi bi-person-badge-fill"></i>Middle Initial</div><div class="info-value">{{ $personalInformation?->middle_initial ?: 'N/A' }}</div></div></div>
            <div class="col-md-4"><div class="info-row"><div class="info-label"><i class="bi bi-person-vcard-fill"></i>Surname</div><div class="info-value">{{ $personalInformation?->surname ?: 'N/A' }}</div></div></div>
            <div class="col-md-4"><div class="info-row"><div class="info-label"><i class="bi bi-award"></i>Suffix</div><div class="info-value">{{ $personalInformation?->suffix ?: 'N/A' }}</div></div></div>
            <div class="col-md-4"><div class="info-row"><div class="info-label"><i class="bi bi-calendar-heart"></i>Date of Birth</div><div class="info-value">{{ $personalInformation?->date_of_birth ?: 'N/A' }}</div></div></div>
            <div class="col-md-4"><div class="info-row"><div class="info-label"><i class="bi bi-gender-ambiguous"></i>Sex</div><div class="info-value">{{ $personalInformation?->sex ?: 'N/A' }}</div></div></div>
            <div class="col-md-4"><div class="info-row"><div class="info-label"><i class="bi bi-heart-pulse"></i>Civil Status</div><div class="info-value">{{ $personalInformation?->civil_status ?: 'N/A' }}</div></div></div>
            <div class="col-md-4"><div class="info-row"><div class="info-label"><i class="bi bi-stars"></i>Religion</div><div class="info-value">{{ $personalInformation?->religion ?: 'N/A' }}</div></div></div>
            <div class="col-md-4"><div class="info-row"><div class="info-label"><i class="bi bi-rulers"></i>Height</div><div class="info-value">{{ $personalInformation?->height ?: 'N/A' }}</div></div></div>
            <div class="col-md-4"><div class="info-row"><div class="info-label"><i class="bi bi-upc-scan"></i>TIN</div><div class="info-value">{{ $personalInformation?->tin ?: 'N/A' }}</div></div></div>
            <div class="col-md-4"><div class="info-row"><div class="info-label"><i class="bi bi-telephone"></i>Contact Number</div><div class="info-value">{{ $personalInformation?->contact_number ?: 'N/A' }}</div></div></div>
            <div class="col-md-4"><div class="info-row"><div class="info-label"><i class="bi bi-envelope-at"></i>Email Address</div><div class="info-value">{{ $personalInformation?->email_address ?: $jobseeker->email }}</div></div></div>
            <div class="col-md-4"><div class="info-row"><div class="info-label"><i class="bi bi-journal-check"></i>In School</div><div class="info-value">{{ ($personalInformation?->currently_in_school ?? false) ? 'Yes' : 'No' }}</div></div></div>
        </div>
    </div>

    <div class="dashboard-card">
        <h5><i class="bi bi-geo-alt-fill"></i>Address Information <span class="section-badge"><i class="bi bi-map"></i>Location</span></h5>
        <div class="row g-3">
            <div class="col-md-6">
                <div class="info-row">
                    <div class="info-label"><i class="bi bi-house-door"></i>Present Address</div>
                    <div class="info-value">{{ $presentAddressLine }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-row">
                    <div class="info-label"><i class="bi bi-house-heart"></i>Permanent Address</div>
                    <div class="info-value">{{ $permanentAddressLine }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-card">
        <h5><i class="bi bi-mortarboard"></i>Education <span class="section-badge"><i class="bi bi-book-half"></i>Learning</span></h5>
        @forelse($educationRows as $education)
            <div class="info-row">
                <div class="info-label"><i class="bi bi-building"></i>{{ $education->school ?: 'Record ' . $loop->iteration }}</div>
                <div class="info-value">
                    {{ $education->course ?: 'N/A' }} @if($education->year) | {{ $education->year }} @endif
                </div>
            </div>
        @empty
            <div class="empty-state"><p>No education records available.</p></div>
        @endforelse
    </div>

    <div class="dashboard-card">
        <h5><i class="bi bi-journal-bookmark"></i>Training <span class="section-badge"><i class="bi bi-award-fill"></i>Courses</span></h5>
        @forelse($trainingRows as $training)
            <div class="info-row">
                <div class="info-label"><i class="bi bi-patch-check"></i>{{ $training->course ?: 'Training ' . $loop->iteration }}</div>
                <div class="info-value">
                    {{ collect([$training->institution, $training->inclusive_dates, $training->skills_acquired, $training->certificates])->filter()->join(' | ') ?: 'N/A' }}
                </div>
            </div>
        @empty
            <div class="empty-state"><p>No training records available.</p></div>
        @endforelse
    </div>

    <div class="dashboard-card">
        <h5><i class="bi bi-briefcase"></i>Work Experience <span class="section-badge"><i class="bi bi-clipboard2-data"></i>History</span></h5>
        @forelse($experienceRows as $experience)
            <div class="info-row">
                <div class="info-label"><i class="bi bi-building-check"></i>{{ $experience->company ?: 'Experience ' . $loop->iteration }}</div>
                <div class="info-value">
                    {{ collect([$experience->title, $experience->location, $experience->status, $experience->from_date . ($experience->to_date ? ' - ' . $experience->to_date : ''), $experience->salary_amount ? 'Salary: ' . $experience->salary_amount : null, $experience->salary_type, $experience->details])->filter()->join(' | ') ?: 'N/A' }}
                </div>
            </div>
        @empty
            <div class="empty-state"><p>No work experience records available.</p></div>
        @endforelse
    </div>

    <div class="dashboard-card">
        <h5><i class="bi bi-patch-check"></i>Eligibility <span class="section-badge"><i class="bi bi-shield-check"></i>Credentials</span></h5>
        @forelse($eligibilityRows as $eligibility)
            <div class="info-row">
                <div class="info-label"><i class="bi bi-award"></i>{{ $eligibility->eligibility ?: 'Eligibility ' . $loop->iteration }}</div>
                <div class="info-value">
                    {{ collect([$eligibility->date_taken, $eligibility->license, $eligibility->valid_until])->filter()->join(' | ') ?: 'N/A' }}
                </div>
            </div>
        @empty
            <div class="empty-state"><p>No eligibility records available.</p></div>
        @endforelse
    </div>

    <div class="dashboard-card">
        <h5><i class="bi bi-stars"></i>Skills <span class="section-badge"><i class="bi bi-lightning-charge"></i>Capabilities</span></h5>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="info-row"><div class="info-label"><i class="bi bi-tools"></i>Trade / Manual</div><div class="info-value">{{ collect($otherSkills['trade_manual'] ?? [])->filter()->join(', ') ?: 'N/A' }}</div></div>
            </div>
            <div class="col-md-4">
                <div class="info-row"><div class="info-label"><i class="bi bi-cpu"></i>IT / Technical</div><div class="info-value">{{ collect($otherSkills['it_technical'] ?? [])->filter()->join(', ') ?: 'N/A' }}</div></div>
            </div>
            <div class="col-md-4">
                <div class="info-row"><div class="info-label"><i class="bi bi-chat-square-heart"></i>Soft Skills</div><div class="info-value">{{ collect($otherSkills['soft_skills'] ?? [])->filter()->join(', ') ?: 'N/A' }}</div></div>
            </div>
            <div class="col-md-4">
                <div class="info-row"><div class="info-label"><i class="bi bi-chat-square-text"></i>Other Skill</div><div class="info-value">{{ $otherSkills['other_text'] ?? 'N/A' }}</div></div>
            </div>
            <div class="col-md-4">
                <div class="info-row"><div class="info-label"><i class="bi bi-patch-check-fill"></i>With Certificate</div><div class="info-value">{{ !is_null($otherSkills['with_certificate'] ?? null) ? (($otherSkills['with_certificate'] ? 'Yes' : 'No')) : 'N/A' }}</div></div>
            </div>
            <div class="col-md-4">
                <div class="info-row"><div class="info-label"><i class="bi bi-clock-history"></i>By Experience</div><div class="info-value">{{ !is_null($otherSkills['by_experience'] ?? null) ? (($otherSkills['by_experience'] ? 'Yes' : 'No')) : 'N/A' }}</div></div>
            </div>
        </div>
    </div>

    <div class="dashboard-card">
        <h5><i class="bi bi-person-check"></i>Employment & Preferences <span class="section-badge"><i class="bi bi-funnel"></i>Match</span></h5>
        <div class="row g-3">
            <div class="col-md-4"><div class="info-row"><div class="info-label"><i class="bi bi-briefcase"></i>Has Work Experience</div><div class="info-value">{{ !is_null($employmentStatus?->has_work_experience) ? ($employmentStatus->has_work_experience ? 'Yes' : 'No') : 'N/A' }}</div></div></div>
            <div class="col-md-4"><div class="info-row"><div class="info-label"><i class="bi bi-cash-stack"></i>Wage Employed</div><div class="info-value">{{ $employmentStatus?->wage_employed ? 'Yes' : 'No' }}</div></div></div>
            <div class="col-md-4"><div class="info-row"><div class="info-label"><i class="bi bi-person-workspace"></i>Self Employed</div><div class="info-value">{{ $employmentStatus?->self_employed ? 'Yes' : 'No' }}</div></div></div>
            <div class="col-md-4"><div class="info-row"><div class="info-label"><i class="bi bi-search"></i>Unemployed</div><div class="info-value">{{ $employmentStatus?->unemployed ? 'Yes' : 'No' }}</div></div></div>
            <div class="col-md-4"><div class="info-row"><div class="info-label"><i class="bi bi-diagram-3"></i>Occupation</div><div class="info-value">{{ $jobPreferences?->occupation_text ?: 'N/A' }}</div></div></div>
            <div class="col-md-4"><div class="info-row"><div class="info-label"><i class="bi bi-flag"></i>Work Preference</div><div class="info-value">{{ collect([$jobPreferences?->part_time ? 'Part Time' : null, $jobPreferences?->full_time ? 'Full Time' : null])->filter()->join(', ') ?: 'N/A' }}</div></div></div>
            <div class="col-md-4"><div class="info-row"><div class="info-label"><i class="bi bi-pin-map"></i>Location Preference</div><div class="info-value">{{ collect([$jobPreferences?->local ? 'Local' : null, $jobPreferences?->overseas ? 'Overseas' : null])->filter()->join(', ') ?: 'N/A' }}</div></div></div>
        </div>
    </div>

    <div class="dashboard-card">
        <h5><i class="bi bi-translate"></i>Languages <span class="section-badge"><i class="bi bi-chat-dots"></i>Fluency</span></h5>
        @forelse($languages as $language)
            <div class="info-row">
                <div class="info-label"><i class="bi bi-globe2"></i>{{ $language->language ?: 'Language ' . $loop->iteration }}</div>
                <div class="info-value">
                    {{ collect([
                        $language->can_read ? 'Read' : null,
                        $language->can_write ? 'Write' : null,
                        $language->can_speak ? 'Speak' : null,
                        $language->can_understand ? 'Understand' : null,
                        $language->other_specify ?: null,
                    ])->filter()->join(', ') ?: 'N/A' }}
                </div>
            </div>
        @empty
            <div class="empty-state"><p>No language records available.</p></div>
        @endforelse
    </div>

    <div class="dashboard-card">
        <h5><i class="bi bi-universal-access"></i>Disability <span class="section-badge"><i class="bi bi-heart-pulse"></i>Support</span></h5>
        <div class="row g-3">
            <div class="col-md-4"><div class="info-row"><div class="info-label"><i class="bi bi-eye"></i>Visual</div><div class="info-value">{{ $disability?->visual ? 'Yes' : 'No' }}</div></div></div>
            <div class="col-md-4"><div class="info-row"><div class="info-label"><i class="bi bi-chat-right-text"></i>Speech</div><div class="info-value">{{ $disability?->speech ? 'Yes' : 'No' }}</div></div></div>
            <div class="col-md-4"><div class="info-row"><div class="info-label"><i class="bi bi-brain"></i>Mental</div><div class="info-value">{{ $disability?->mental ? 'Yes' : 'No' }}</div></div></div>
            <div class="col-md-4"><div class="info-row"><div class="info-label"><i class="bi bi-ear"></i>Hearing</div><div class="info-value">{{ $disability?->hearing ? 'Yes' : 'No' }}</div></div></div>
            <div class="col-md-4"><div class="info-row"><div class="info-label"><i class="bi bi-person-walking"></i>Physical</div><div class="info-value">{{ $disability?->physical ? 'Yes' : 'No' }}</div></div></div>
            <div class="col-md-4"><div class="info-row"><div class="info-label"><i class="bi bi-question-circle"></i>Other</div><div class="info-value">{{ $disability?->other ? 'Yes' : 'No' }}</div></div></div>
            <div class="col-md-12"><div class="info-row"><div class="info-label"><i class="bi bi-card-text"></i>Other Text</div><div class="info-value">{{ $disability?->other_text ?: 'N/A' }}</div></div></div>
        </div>
    </div>

    <div class="dashboard-card">
        <h5><i class="bi bi-file-earmark-text"></i>Applications History <span class="section-badge"><i class="bi bi-timeline"></i>Timeline</span></h5>

        @if($jobseeker->applications->count() > 0)
            @foreach($jobseeker->applications as $application)
                <div class="application-item">
                    <div class="application-title"><i class="bi bi-briefcase-fill me-2 text-primary"></i>{{ $application->job->title ?? 'N/A' }}</div>
                    <div class="application-company">
                        <i class="bi bi-building me-1"></i>{{ $application->job->employer->companyProfile->company_name ?? $application->job->employer->name ?? 'Unknown Company' }}
                    </div>
                    <div>
                        <span class="application-status status-applied">{{ ucfirst($application->status ?? 'pending') }}</span>
                        <span style="font-size: 12px; color: #9ca3af; margin-left: 1rem;">
                            <i class="bi bi-calendar2-event me-1"></i>Applied on {{ $application->created_at->format('M d, Y') }}
                        </span>
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <p>No Applications Yet</p>
                <small>This jobseeker hasn't applied to any positions</small>
            </div>
        @endif
    </div>
                <form id="recommendForm" method="POST">
                    @csrf
                    <div class="modal-body" style="padding: 2.5rem; background: #ffffff;">
                        <p style="font-size: 1.1rem; color: #0d1f3c; margin-bottom: 1.5rem;">Recommending: <span id="jobseekerName" style="color: #d72638; font-weight: 700; font-size: 1.3rem;">N/A</span></p>
                        
                        <div class="row mb-3">
                            <!-- Step 1: Select Employer -->
                            <div class="col-md-6">
                                <label for="employerSelect" class="form-label" style="font-weight: 700; color: #0d1f3c; margin-bottom: 0.5rem; font-size: 1rem;">
                                    Employer <span class="text-danger">*</span>
                                </label>
                                <select id="employerSelect" name="employer_id" class="form-control" required style="border-radius: 8px; border: 2px solid #d72638; padding: 0.75rem; font-size: 1rem; color: #0d1f3c;">
                                    <option value="" style="color: #999;">-- Select Employer --</option>
                                    @php
                                        // Get all employers, not just those with active jobs
                                        $employers = \App\Models\User::where('role', 'employer')
                                            ->with('companyProfile')
                                            ->orderBy('name')
                                            ->get()
                                            ->map(function($user) {
                                                return [
                                                    'id' => $user->id,
                                                    'name' => $user->name,
                                                    'company_name' => $user->companyProfile?->company_name ?? $user->name
                                                ];
                                            });
                                    @endphp
                                    @foreach($employers as $employer)
                                        <option value="{{ $employer['id'] }}">{{ $employer['company_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Step 2: Select Job -->
                            <div class="col-md-6">
                                <label for="jobSelect" class="form-label" style="font-weight: 700; color: #0d1f3c; margin-bottom: 0.5rem; font-size: 1rem;">
                                    Job Position <span class="text-danger">*</span>
                                </label>
                                <select id="jobSelect" name="job_id" class="form-control" required disabled style="border-radius: 8px; border: 2px solid #d72638; padding: 0.75rem; font-size: 1rem; color: #0d1f3c;">
                                    <option value="" style="color: #999;">-- Select Job --</option>
                                </select>
                            </div>
                        </div>
                        
                        <hr style="margin: 2rem 0; border: none; border-top: 2px solid #e5e7eb;">
                        
                        <!-- Job Details Display (Facebook-like post) -->
                        <div id="jobDetailsSection" style="display: none; background: #f8f9fa; padding: 1.5rem; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 2rem; border: 1px solid #e5e7eb;">
                            <!-- Post Header -->
                            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #0d1f3c 0%, #1a3a5c 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="bi bi-building" style="color: white; font-size: 1.8rem;"></i>
                                </div>
                                <div>
                                    <div style="font-weight: 700; color: #0d1f3c; font-size: 1.2rem;" id="displayEmployerCompany"></div>
                                    <div style="color: #6b7280; font-size: 0.95rem;" id="displayEmployerName"></div>
                                </div>
                            </div>
                            
                            <!-- Job Title -->
                            <h3 style="font-size: 1.6rem; font-weight: 800; color: #0d1f3c; margin: 0 0 1.5rem 0;" id="displayJobTitle"></h3>
                            
                            <!-- Job Details Grid -->
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                                <!-- Location -->
                                <div style="display: flex; gap: 1rem;">
                                    <div style="color: #d72638; font-size: 1.5rem; flex-shrink: 0;">
                                        <i class="bi bi-geo-alt-fill"></i>
                                    </div>
                                    <div>
                                        <div style="font-size: 0.85rem; color: #6b7280; font-weight: 600; text-transform: uppercase; margin-bottom: 0.25rem;">Location</div>
                                        <div style="font-size: 1.1rem; color: #0d1f3c; font-weight: 600;" id="displayLocation"></div>
                                    </div>
                                </div>
                                
                                <!-- Salary -->
                                <div style="display: flex; gap: 1rem;">
                                    <div style="color: #d72638; font-size: 1.5rem; flex-shrink: 0;">
                                        <i class="bi bi-cash-coin"></i>
                                    </div>
                                    <div>
                                        <div style="font-size: 0.85rem; color: #6b7280; font-weight: 600; text-transform: uppercase; margin-bottom: 0.25rem;">Salary Range</div>
                                        <div style="font-size: 1.1rem; color: #0d1f3c; font-weight: 600;" id="displaySalary"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Divider -->
                            <hr style="margin: 1.5rem 0; border: none; border-top: 1px solid #e5e7eb;">
                            
                            <!-- Job Description -->
                            <div style="margin-bottom: 1.5rem;">
                                <div style="font-size: 0.85rem; color: #6b7280; font-weight: 600; text-transform: uppercase; margin-bottom: 0.75rem;">About This Job</div>
                                <div style="font-size: 1rem; color: #1f2937; line-height: 1.6; background: white; padding: 1rem; border-radius: 8px; border-left: 3px solid #d72638;" id="displayJobDescription">No description provided</div>
                            </div>
                            
                            <!-- More Details Button -->
                            <button type="button" id="moreDetailsBtn" class="btn" style="width: 100%; border-radius: 8px; padding: 0.75rem 1.5rem; font-weight: 600; font-size: 1rem; background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); border: none; color: white; cursor: pointer; margin-bottom: 1.5rem;"><i class="bi bi-info-circle me-2"></i>More Details</button>
                        </div>
                        
                        <!-- Message/Note Section -->
                        <div class="mb-0">
                            <label for="messageInput" class="form-label" style="font-weight: 700; color: #0d1f3c; margin-bottom: 0.75rem; font-size: 1rem;">
                                <i class="bi bi-chat-dots me-2" style="color: #d72638;"></i>Personal Message (Optional)
                            </label>
                            <textarea id="messageInput" name="message" class="form-control" rows="4" 
                                      placeholder="Write a personal message to the applicant about this opportunity..." 
                                      style="border-radius: 8px; border: 2px solid #d72638; padding: 1rem; font-size: 1rem; color: #0d1f3c; font-family: inherit;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: 2px solid #e5e7eb; padding: 1.5rem; background: #f8f9fa; border-radius: 0 0 12px 12px; display: flex; gap: 1rem; justify-content: flex-end;">
                        <button type="button" class="btn" data-bs-dismiss="modal" style="border-radius: 8px; padding: 0.75rem 2rem; font-weight: 600; font-size: 1rem; background: #e5e7eb; color: #0d1f3c; border: none; cursor: pointer;">Cancel</button>
                        <button type="submit" class="btn" style="border-radius: 8px; padding: 0.75rem 2rem; font-weight: 600; font-size: 1rem; background: linear-gradient(135deg, #d72638 0%, #c91f32 100%); border: none; color: white; cursor: pointer;"><i class="bi bi-check-circle me-2"></i>Recommend Applicant</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Detailed Job Modal -->
    <style>
        .job-detail-modal .modal-content {
            border: none;
            border-radius: 16px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .job-detail-modal .modal-header {
            background: linear-gradient(135deg, #0d1f3c 0%, #1a3a52 100%);
            border-bottom: none;
            border-radius: 16px 16px 0 0;
            padding: 2rem;
        }

        .job-detail-modal .modal-title {
            font-size: 1.8rem;
            font-weight: 800;
            color: white;
            letter-spacing: -0.5px;
        }

        .job-detail-modal .modal-body {
            padding: 2rem;
            background: #f9fafb;
        }

        .detail-section {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid #2563eb;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .detail-section h5 {
            font-size: 1.1rem;
            font-weight: 800;
            color: #0d1f3c;
            margin-bottom: 1.2rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .detail-section h5 i {
            color: #2563eb;
            font-size: 1.2rem;
        }

        .detail-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1rem;
        }

        .detail-row.full {
            grid-template-columns: 1fr;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
        }

        .detail-label {
            font-size: 0.85rem;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin-bottom: 0.5rem;
        }

        .detail-value {
            font-size: 1rem;
            color: #1f2937;
            font-weight: 600;
            line-height: 1.5;
        }

        .detail-value.description {
            font-size: 0.95rem;
            color: #374151;
            line-height: 1.7;
            padding: 1rem;
            background: #f3f4f6;
            border-radius: 8px;
            border-left: 3px solid #d72638;
        }

        .bullet-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .bullet-list li {
            font-size: 0.95rem;
            color: #374151;
            margin-bottom: 0.6rem;
            padding-left: 1.5rem;
            position: relative;
        }

        .bullet-list li:before {
            content: "•";
            color: #2563eb;
            font-weight: bold;
            position: absolute;
            left: 0;
        }

        .badge-inline {
            display: inline-block;
            padding: 0.4rem 0.9rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid rgba(6, 95, 70, 0.2);
        }
    </style>
    
    <div class="modal fade job-detail-modal" id="jobDetailModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="jobDetailTitle">Job Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Basic Information -->
                    <div class="detail-section">
                        <h5><i class="bi bi-briefcase"></i>Job Overview</h5>
                        <div class="detail-row">
                            <div class="detail-item">
                                <span class="detail-label">Job Title</span>
                                <span class="detail-value" id="detailTitle">-</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Company</span>
                                <span class="detail-value" id="detailCompany">-</span>
                            </div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-item">
                                <span class="detail-label">Location</span>
                                <span class="detail-value" id="detailLocation">-</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Job Type</span>
                                <span class="detail-value" id="detailJobType">-</span>
                            </div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-item">
                                <span class="detail-label">Salary Range</span>
                                <span class="detail-value" id="detailSalary" style="color: #059669;">-</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Vacancies</span>
                                <span class="detail-value" id="detailVacancies">-</span>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="detail-section" id="descriptionSection" style="display: none;">
                        <h5><i class="bi bi-text-left"></i>Description</h5>
                        <div class="detail-value description" id="detailDescription">-</div>
                    </div>

                    <!-- Requirements -->
                    <div class="detail-section" id="requirementsSection" style="display: none;">
                        <h5><i class="bi bi-list-check"></i>Requirements</h5>
                        <div class="detail-value" id="detailRequirements">-</div>
                    </div>

                    <!-- Qualifications -->
                    <div class="detail-section" id="qualificationsSection" style="display: none;">
                        <h5><i class="bi bi-mortarboard"></i>Qualifications</h5>
                        <ul class="bullet-list" id="detailQualifications">
                            <li>-</li>
                        </ul>
                    </div>

                    <!-- Key Responsibilities -->
                    <div class="detail-section" id="responsibilitiesSection" style="display: none;">
                        <h5><i class="bi bi-list-task"></i>Key Responsibilities</h5>
                        <ul class="bullet-list" id="detailResponsibilities">
                            <li>-</li>
                        </ul>
                    </div>

                    <!-- Preferred Skills -->
                    <div class="detail-section" id="skillsSection" style="display: none;">
                        <h5><i class="bi bi-star"></i>Preferred Skills</h5>
                        <ul class="bullet-list" id="detailSkills">
                            <li>-</li>
                        </ul>
                    </div>

                    <!-- Experience & Education -->
                    <div class="detail-section" id="experienceSection" style="display: none;">
                        <h5><i class="bi bi-person-workspace"></i>Experience & Education</h5>
                        <div class="detail-row">
                            <div class="detail-item" id="experienceItem" style="display: none;">
                                <span class="detail-label">Experience Required</span>
                                <div class="detail-value" id="detailExperience">-</div>
                            </div>
                            <div class="detail-item" id="educationItem" style="display: none;">
                                <span class="detail-label">Education Required</span>
                                <div class="detail-value" id="detailEducation">-</div>
                            </div>
                        </div>
                    </div>

                    <!-- Benefits -->
                    <div class="detail-section" id="benefitsSection" style="display: none;">
                        <h5><i class="bi bi-gift"></i>Benefits</h5>
                        <ul class="bullet-list" id="detailBenefits">
                            <li>-</li>
                        </ul>
                    </div>

                    <!-- Application Dates -->
                    <div class="detail-section">
                        <h5><i class="bi bi-calendar-event"></i>Application Period</h5>
                        <div class="detail-row">
                            <div class="detail-item">
                                <span class="detail-label">Start Date</span>
                                <span class="detail-value" id="detailStartDate">-</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">End Date</span>
                                <span class="detail-value" id="detailEndDate">-</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const jobsByEmployer = {
            @foreach($availableJobs->groupBy('employer_id') as $employerId => $jobs)
                {{ $employerId }}: [
                    @foreach($jobs as $job)
                        {
                            id: {{ $job->id }},
                            title: '{{ addslashes($job->title) }}',
                            employerName: '{{ addslashes($job->employer?->name ?? 'Unknown') }}',
                            companyName: '{{ addslashes($job->employer?->companyProfile?->company_name ?? $job->employer?->name ?? 'Unknown Company') }}',
                            location: '{{ addslashes($job->location ?? 'N/A') }}',
                            salary: '{{ addslashes($job->salary_range ?? 'Not specified') }}',
                            description: '{{ addslashes($job->description ?? 'No description provided') }}',
                            jobType: '{{ addslashes($job->job_type ?? 'N/A') }}',
                            vacancies: {{ $job->vacancies ?? 0 }},
                            qualifications: '{{ addslashes($job->qualifications ?? '') }}',
                            keyResponsibilities: '{{ addslashes($job->key_responsibilities ?? '') }}',
                            preferredSkills: '{{ addslashes($job->preferred_skills ?? '') }}',
                            experience: '{{ addslashes($job->experience ?? '') }}',
                            education: '{{ addslashes($job->education ?? '') }}',
                            benefits: '{{ addslashes($job->benefits ?? '') }}',
                            requirements: '{{ addslashes($job->requirements ?? '') }}',
                            applicationStartDate: '{{ $job->application_start_date?->format('Y-m-d') ?? '' }}',
                            applicationEndDate: '{{ $job->application_end_date?->format('Y-m-d') ?? '' }}'
                        },
                    @endforeach
                ],
            @endforeach
        };
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const openModalButtons = document.querySelectorAll('.open-recommend-modal');
            const recommendModal = document.getElementById('recommendModal');
            const recommendForm = document.getElementById('recommendForm');
            const jobseekerNameSpan = document.getElementById('jobseekerName');
            const employerSelect = document.getElementById('employerSelect');
            const jobSelect = document.getElementById('jobSelect');
            const jobDetailsSection = document.getElementById('jobDetailsSection');
            const displayJobTitle = document.getElementById('displayJobTitle');
            const displayEmployerCompany = document.getElementById('displayEmployerCompany');
            const displayEmployerName = document.getElementById('displayEmployerName');
            const displayLocation = document.getElementById('displayLocation');
            const displaySalary = document.getElementById('displaySalary');
            let currentJobseekerId = null;

            // Handle employer selection change - populate jobs
            employerSelect.addEventListener('change', function() {
                jobSelect.innerHTML = '<option value="">-- Choose a Job --</option>';
                jobDetailsSection.style.display = 'none';
                jobSelect.value = '';
                
                if (this.value && jobsByEmployer[this.value]) {
                    jobSelect.disabled = false;
                    jobsByEmployer[this.value].forEach(job => {
                        const option = document.createElement('option');
                        option.value = job.id;
                        option.textContent = job.title;
                        option.dataset.jobTitle = job.title;
                        option.dataset.employerName = job.employerName;
                        option.dataset.companyName = job.companyName;
                        option.dataset.location = job.location;
                        option.dataset.salary = job.salary;
                        option.dataset.description = job.description;
                        option.dataset.jobType = job.jobType;
                        option.dataset.vacancies = job.vacancies;
                        option.dataset.qualifications = job.qualifications;
                        option.dataset.keyResponsibilities = job.keyResponsibilities;
                        option.dataset.preferredSkills = job.preferredSkills;
                        option.dataset.experience = job.experience;
                        option.dataset.education = job.education;
                        option.dataset.benefits = job.benefits;
                        option.dataset.requirements = job.requirements;
                        option.dataset.applicationStartDate = job.applicationStartDate;
                        option.dataset.applicationEndDate = job.applicationEndDate;
                        jobSelect.appendChild(option);
                    });
                } else {
                    jobSelect.disabled = true;
                }
            });

            // Handle job selection change to display details
            jobSelect.addEventListener('change', function() {
                if (this.value) {
                    const selectedOption = this.options[this.selectedIndex];
                    const jobTitle = selectedOption.dataset.jobTitle;
                    const employerName = selectedOption.dataset.employerName;
                    const companyName = selectedOption.dataset.companyName;
                    const location = selectedOption.dataset.location;
                    const salary = selectedOption.dataset.salary;
                    const description = selectedOption.dataset.description;
                    
                    displayJobTitle.textContent = jobTitle;
                    displayEmployerCompany.textContent = companyName;
                    displayEmployerName.textContent = employerName !== companyName ? employerName : 'Employer profile';
                    displayLocation.textContent = location;
                    displaySalary.textContent = salary;
                    document.getElementById('displayJobDescription').textContent = description || 'No description provided';
                    
                    jobDetailsSection.style.display = 'block';
                } else {
                    jobDetailsSection.style.display = 'none';
                }
            });

            openModalButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const jobseekerId = this.dataset.jobseekerId;
                    const jobseekerName = this.dataset.jobseekerName;

                    currentJobseekerId = jobseekerId;
                    jobseekerNameSpan.textContent = jobseekerName;

                    // Update form action for applicant recommendation
                    recommendForm.action = '/admin/jobseekers/' + jobseekerId + '/recommend-applicant';
                    console.log('Form action set to:', recommendForm.action);
                    console.log('Jobseeker:', jobseekerId, jobseekerName);
                    
                    // Reset form fields
                    employerSelect.value = '';
                    jobSelect.value = '';
                    jobSelect.disabled = true;
                    jobSelect.innerHTML = '<option value="">-- Choose a Job --</option>';
                    document.getElementById('messageInput').value = '';
                    jobDetailsSection.style.display = 'none';

                    // Show modal using Bootstrap
                    const modal = new bootstrap.Modal(recommendModal, {
                        keyboard: false,
                        backdrop: 'static'
                    });
                    modal.show();
                });
            });

            // Handle More Details button click
            document.getElementById('moreDetailsBtn').addEventListener('click', function() {
                const selectedJobId = jobSelect.value;
                if (!selectedJobId) {
                    alert('Please select a job first');
                    return;
                }

                // Find the selected job data
                let selectedJob = null;
                for (let employerId in jobsByEmployer) {
                    const jobs = jobsByEmployer[employerId];
                    selectedJob = jobs.find(j => j.id == selectedJobId);
                    if (selectedJob) break;
                }

                if (!selectedJob) return;

                // Populate and show detailed modal
                showJobDetailsModal(selectedJob);
            });

            function parseList(text) {
                if (!text || text === '' || text === 'NULL') return [];
                return text.split('\\n').filter(item => item.trim() !== '');
            }

            function showJobDetailsModal(jobData) {
                // Basic info
                document.getElementById('jobDetailTitle').textContent = jobData.title;
                document.getElementById('detailTitle').textContent = jobData.title;
                document.getElementById('detailCompany').textContent = jobData.companyName;
                document.getElementById('detailLocation').textContent = jobData.location;
                document.getElementById('detailJobType').textContent = (jobData.jobType || 'N/A').replace(/_/g, ' ').charAt(0).toUpperCase() + (jobData.jobType || 'N/A').replace(/_/g, ' ').slice(1);
                document.getElementById('detailSalary').textContent = jobData.salary || 'Not specified';
                document.getElementById('detailVacancies').textContent = jobData.vacancies || '0';

                // Description
                if (jobData.description && jobData.description !== 'NULL' && jobData.description !== '') {
                    document.getElementById('descriptionSection').style.display = 'block';
                    document.getElementById('detailDescription').textContent = jobData.description;
                } else {
                    document.getElementById('descriptionSection').style.display = 'none';
                }

                // Requirements
                if (jobData.requirements && jobData.requirements !== 'NULL' && jobData.requirements !== '') {
                    document.getElementById('requirementsSection').style.display = 'block';
                    document.getElementById('detailRequirements').textContent = jobData.requirements;
                } else {
                    document.getElementById('requirementsSection').style.display = 'none';
                }

                // Qualifications
                const qualifications = parseList(jobData.qualifications);
                if (qualifications.length > 0) {
                    document.getElementById('qualificationsSection').style.display = 'block';
                    const qualList = document.getElementById('detailQualifications');
                    qualList.innerHTML = qualifications.map(q => `<li>${q}</li>`).join('');
                } else {
                    document.getElementById('qualificationsSection').style.display = 'none';
                }

                // Responsibilities
                const responsibilities = parseList(jobData.keyResponsibilities);
                if (responsibilities.length > 0) {
                    document.getElementById('responsibilitiesSection').style.display = 'block';
                    const respList = document.getElementById('detailResponsibilities');
                    respList.innerHTML = responsibilities.map(r => `<li>${r}</li>`).join('');
                } else {
                    document.getElementById('responsibilitiesSection').style.display = 'none';
                }

                // Skills
                const skills = parseList(jobData.preferredSkills);
                if (skills.length > 0) {
                    document.getElementById('skillsSection').style.display = 'block';
                    const skillsList = document.getElementById('detailSkills');
                    skillsList.innerHTML = skills.map(s => `<li>${s}</li>`).join('');
                } else {
                    document.getElementById('skillsSection').style.display = 'none';
                }

                // Experience & Education
                const hasExperience = jobData.experience && jobData.experience !== 'NULL' && jobData.experience !== '';
                const hasEducation = jobData.education && jobData.education !== 'NULL' && jobData.education !== '';
                
                if (hasExperience || hasEducation) {
                    document.getElementById('experienceSection').style.display = 'block';
                    if (hasExperience) {
                        document.getElementById('experienceItem').style.display = 'block';
                        const expList = parseList(jobData.experience);
                        document.getElementById('detailExperience').innerHTML = expList.length > 0 
                            ? expList.map(e => `<div style="margin-bottom: 0.5rem;">${e}</div>`).join('')
                            : jobData.experience;
                    } else {
                        document.getElementById('experienceItem').style.display = 'none';
                    }
                    
                    if (hasEducation) {
                        document.getElementById('educationItem').style.display = 'block';
                        const eduList = parseList(jobData.education);
                        document.getElementById('detailEducation').innerHTML = eduList.length > 0 
                            ? eduList.map(e => `<div style="margin-bottom: 0.5rem;">${e}</div>`).join('')
                            : jobData.education;
                    } else {
                        document.getElementById('educationItem').style.display = 'none';
                    }
                } else {
                    document.getElementById('experienceSection').style.display = 'none';
                }

                // Benefits
                const benefits = parseList(jobData.benefits);
                if (benefits.length > 0) {
                    document.getElementById('benefitsSection').style.display = 'block';
                    const benefitsList = document.getElementById('detailBenefits');
                    benefitsList.innerHTML = benefits.map(b => `<li>${b}</li>`).join('');
                } else {
                    document.getElementById('benefitsSection').style.display = 'none';
                }

                // Dates
                document.getElementById('detailStartDate').textContent = jobData.applicationStartDate 
                    ? new Date(jobData.applicationStartDate).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })
                    : 'Not specified';
                document.getElementById('detailEndDate').textContent = jobData.applicationEndDate 
                    ? new Date(jobData.applicationEndDate).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })
                    : 'Not specified';

                // Show modal
                const detailModal = new bootstrap.Modal(document.getElementById('jobDetailModal'));
                detailModal.show();
            }
        });

        // Debug: Form submission listener
        recommendForm.addEventListener('submit', function(e) {
            console.log('✅ FORM SUBMIT EVENT FIRED!');
            console.log('Form Action:', this.action);
            console.log('Employer ID:', document.getElementById('employerSelect').value);
            console.log('Job ID:', document.getElementById('jobSelect').value);
            console.log('Message:', document.getElementById('messageInput').value);
            console.log('CSRF Token:', document.querySelector('[name="_token"]')?.value);
            console.log('Full form data:', new FormData(this));
        });
    </script>
</div>

@endsection
