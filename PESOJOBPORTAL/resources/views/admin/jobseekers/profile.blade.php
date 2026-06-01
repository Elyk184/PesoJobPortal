@extends('layouts.admin-dashboard')

@section('title', $jobseeker->name . ' | Jobseeker Profile | PESO Admin')

<?php
    $pageTitle = $jobseeker->name;
    $pageSubtitle = 'Jobseeker Profile & Management';
    $pageIcon = 'bi-person-circle';
    $hideAdminTopbar = true;
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
            background: linear-gradient(180deg, #f7f8fa 0%, #eef1f5 100%);
            padding: 1.25rem;
            border-radius: 18px;
        }

        .profile-header {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            margin-bottom: 3rem;
            align-items: start;
        }

        .profile-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
            border: 1px solid #dce3ea;
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
            height: 4px;
            background: #243447;
            border-radius: 20px 20px 0 0;
        }

        .profile-card:hover,
        .dashboard-card:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 32px rgba(15, 23, 42, 0.08);
            border-color: #c8d2dc;
        }

        .profile-avatar {
            width: 88px;
            height: 88px;
            border-radius: 18px;
            background: #1f2937;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            font-size: 34px;
            box-shadow: 0 10px 18px rgba(15, 23, 42, 0.12);
            margin-bottom: 1.5rem;
        }

        .profile-info h3 {
            margin: 0 0 0.5rem 0;
            color: #0f172a;
            font-weight: 800;
            font-size: 26px;
            letter-spacing: -0.4px;
        }

        .profile-info p {
            margin: 0.35rem 0;
            color: #52606d;
            font-size: 14px;
        }

        .profile-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 0.85rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #e3e8ee;
        }

        .stat-item {
            text-align: center;
            padding: 0.95rem 1rem;
            border-radius: 14px;
            background: #f8fafc;
            border: 1px solid #e3e8ee;
        }

        .stat-value {
            font-size: 26px;
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
            background: #1f2937;
            color: #ffffff;
        }

        .btn-recommend:hover {
            background: #111827;
            transform: translateY(-2px);
        }

        .dashboard-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 1.6rem 1.75rem;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
            border: 1px solid #dce3ea;
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
            height: 3px;
            background: #334155;
            border-radius: 18px 18px 0 0;
        }

        .dashboard-card h5 {
            color: #0f172a;
            font-weight: 800;
            margin: 0 0 1.25rem 0;
            padding-bottom: 0.85rem;
            border-bottom: 1px solid #e3e8ee;
            font-size: 16px;
            letter-spacing: -0.3px;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .dashboard-card h5 i {
            color: #475569;
            font-size: 1rem;
        }

        .section-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.35rem 0.75rem;
            border-radius: 999px;
            background: #f1f5f9;
            color: #475569;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin-left: auto;
        }

        .info-row {
            display: flex;
            flex-direction: column;
            align-items: stretch;
            gap: 0.45rem;
            margin-bottom: 0.85rem;
            padding: 0;
            border: none;
            border-radius: 0;
            background: transparent;
        }

        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .info-label {
            font-weight: 800;
            color: #64748b;
            min-width: 0;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.9px;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            line-height: 1.3;
            margin-bottom: 0.05rem;
        }

        .info-label i {
            color: #718096;
            font-size: 13px;
        }

        .info-value {
            color: #0b1a33;
            font-weight: 700;
            font-size: 1.12rem;
            line-height: 1.35;
            background: #ffffff;
            border: 1px solid #dbe4ef;
            border-radius: 10px;
            padding: 0.62rem 0.85rem;
            display: block;
            width: 100%;
            word-break: break-word;
        }

        .application-item {
            background: #f8fafc;
            border: 1px solid #e3e8ee;
            border-radius: 14px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .application-item:hover {
            border-color: #c8d2dc;
            box-shadow: 0 10px 22px rgba(15, 23, 42, 0.06);
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
            background: #f8fafc;
            border-radius: 14px;
            border: 1px dashed #d7dee6;
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
            border: 1px solid #d8dee6;
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.18);
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
            background: linear-gradient(180deg, #f7f8fa 0%, #eef1f5 100%);
            padding: 1.25rem;
            border-radius: 18px;
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
            background: #243447;
            color: #fff;
            box-shadow: 0 10px 18px rgba(15, 23, 42, 0.12);
            transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }

        .btn-back-top:hover {
            color: #fff;
            background: #111827;
            transform: translateY(-1px);
            box-shadow: 0 12px 26px rgba(15, 23, 42, 0.2);
        }

        .profile-summary-layout {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .profile-card,
        .dashboard-card {
            border: 1px solid #dce3ea;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
        }

        .profile-meta-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.9rem;
            margin-top: 1.25rem;
        }

        .profile-meta-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.85rem 0.95rem;
            border-radius: 14px;
            background: #f8fafc;
            border: 1px solid #e3e8ee;
            color: #334155;
            font-size: 14px;
        }

        .profile-meta-item i {
            color: #475569;
            font-size: 1rem;
        }

        .section-grid {
            display: grid;
            grid-template-columns: repeat(12, minmax(0, 1fr));
            gap: 1.25rem;
        }

        .section-span-6 {
            grid-column: span 6;
        }

        .section-span-12 {
            grid-column: span 12;
        }

        .compact-section .info-row {
            margin-bottom: 0.72rem;
            padding: 0;
        }

        .header-stack {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .header-stack .profile-heading {
            max-width: 100%;
        }

        .profile-heading .profile-kicker {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            margin-bottom: 0.4rem;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            color: #64748b;
        }

        @media (max-width: 992px) {
            .section-span-6 {
                grid-column: span 12;
            }
        }

        @media (max-width: 768px) {
            .profile-card,
            .dashboard-card {
                border-radius: 16px;
            }

            .info-row {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }

            .info-value {
                font-size: 1.02rem;
            }

            .profile-meta-grid {
                grid-template-columns: 1fr;
            }

            .section-grid {
                gap: 1rem;
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
            <div class="header-stack">
                <div class="profile-heading">
                    <div class="profile-kicker"><i class="bi bi-person-badge"></i>Jobseeker profile</div>
                    <div class="profile-avatar">{{ $avatarLetter }}</div>
                    <div class="profile-info">
                        <h3>{{ $displayName }}</h3>
                        <p><i class="bi bi-envelope-paper me-2"></i>{{ $jobseeker->email }}</p>
                        <p><i class="bi bi-calendar3 me-2"></i>Member since {{ $jobseeker->created_at->format('M d, Y') }}</p>
                        <p><i class="bi bi-geo-alt-fill me-2"></i>{{ $presentAddressLine }}</p>
                    </div>
                </div>
            </div>

            <div class="profile-meta-grid">
                <div class="profile-meta-item"><i class="bi bi-send"></i><span>{{ $jobseeker->applications->count() }} Applications</span></div>
                <div class="profile-meta-item"><i class="bi bi-mortarboard-fill"></i><span>{{ $educationRows->count() }} Education Records</span></div>
                <div class="profile-meta-item"><i class="bi bi-stars"></i><span>{{ $skillsCount }} Skills Listed</span></div>
                <div class="profile-meta-item"><i class="bi bi-briefcase-fill"></i><span>{{ $availableJobs->count() }} Jobs Available</span></div>
            </div>
        </div>
    </div>

    <div class="section-grid">
        <div class="dashboard-card section-span-12 compact-section">
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

        <div class="dashboard-card section-span-6 compact-section">
            <h5><i class="bi bi-geo-alt-fill"></i>Address Information <span class="section-badge"><i class="bi bi-map"></i>Location</span></h5>
            <div class="row g-3">
                <div class="col-12">
                    <div class="info-row">
                        <div class="info-label"><i class="bi bi-house-door"></i>Present Address</div>
                        <div class="info-value">{{ $presentAddressLine }}</div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="info-row">
                        <div class="info-label"><i class="bi bi-house-heart"></i>Permanent Address</div>
                        <div class="info-value">{{ $permanentAddressLine }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-card section-span-6 compact-section">
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

        <div class="dashboard-card section-span-6 compact-section">
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

        <div class="dashboard-card section-span-6 compact-section">
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

        <div class="dashboard-card section-span-6 compact-section">
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

        <div class="dashboard-card section-span-6 compact-section">
            <h5><i class="bi bi-stars"></i>Skills <span class="section-badge"><i class="bi bi-lightning-charge"></i>Capabilities</span></h5>
            <div class="row g-3">
                <div class="col-12"><div class="info-row"><div class="info-label"><i class="bi bi-tools"></i>Trade / Manual</div><div class="info-value">{{ collect($otherSkills['trade_manual'] ?? [])->filter()->join(', ') ?: 'N/A' }}</div></div></div>
                <div class="col-12"><div class="info-row"><div class="info-label"><i class="bi bi-cpu"></i>IT / Technical</div><div class="info-value">{{ collect($otherSkills['it_technical'] ?? [])->filter()->join(', ') ?: 'N/A' }}</div></div></div>
                <div class="col-12"><div class="info-row"><div class="info-label"><i class="bi bi-chat-square-heart"></i>Soft Skills</div><div class="info-value">{{ collect($otherSkills['soft_skills'] ?? [])->filter()->join(', ') ?: 'N/A' }}</div></div></div>
                <div class="col-12"><div class="info-row"><div class="info-label"><i class="bi bi-chat-square-text"></i>Other Skill</div><div class="info-value">{{ $otherSkills['other_text'] ?? 'N/A' }}</div></div></div>
                <div class="col-12"><div class="info-row"><div class="info-label"><i class="bi bi-patch-check-fill"></i>With Certificate</div><div class="info-value">{{ !is_null($otherSkills['with_certificate'] ?? null) ? (($otherSkills['with_certificate'] ? 'Yes' : 'No')) : 'N/A' }}</div></div></div>
                <div class="col-12"><div class="info-row"><div class="info-label"><i class="bi bi-clock-history"></i>By Experience</div><div class="info-value">{{ !is_null($otherSkills['by_experience'] ?? null) ? (($otherSkills['by_experience'] ? 'Yes' : 'No')) : 'N/A' }}</div></div></div>
            </div>
        </div>

        <div class="dashboard-card section-span-6 compact-section">
            <h5><i class="bi bi-person-check"></i>Employment & Preferences <span class="section-badge"><i class="bi bi-funnel"></i>Match</span></h5>
            <div class="row g-3">
                <div class="col-12"><div class="info-row"><div class="info-label"><i class="bi bi-briefcase"></i>Has Work Experience</div><div class="info-value">{{ !is_null($employmentStatus?->has_work_experience) ? ($employmentStatus->has_work_experience ? 'Yes' : 'No') : 'N/A' }}</div></div></div>
                <div class="col-12"><div class="info-row"><div class="info-label"><i class="bi bi-cash-stack"></i>Wage Employed</div><div class="info-value">{{ $employmentStatus?->wage_employed ? 'Yes' : 'No' }}</div></div></div>
                <div class="col-12"><div class="info-row"><div class="info-label"><i class="bi bi-person-workspace"></i>Self Employed</div><div class="info-value">{{ $employmentStatus?->self_employed ? 'Yes' : 'No' }}</div></div></div>
                <div class="col-12"><div class="info-row"><div class="info-label"><i class="bi bi-search"></i>Unemployed</div><div class="info-value">{{ $employmentStatus?->unemployed ? 'Yes' : 'No' }}</div></div></div>
                <div class="col-12"><div class="info-row"><div class="info-label"><i class="bi bi-diagram-3"></i>Occupation</div><div class="info-value">{{ $jobPreferences?->occupation_text ?: 'N/A' }}</div></div></div>
                <div class="col-12"><div class="info-row"><div class="info-label"><i class="bi bi-flag"></i>Work Preference</div><div class="info-value">{{ collect([$jobPreferences?->part_time ? 'Part Time' : null, $jobPreferences?->full_time ? 'Full Time' : null])->filter()->join(', ') ?: 'N/A' }}</div></div></div>
                <div class="col-12"><div class="info-row"><div class="info-label"><i class="bi bi-pin-map"></i>Location Preference</div><div class="info-value">{{ collect([$jobPreferences?->local ? 'Local' : null, $jobPreferences?->overseas ? 'Overseas' : null])->filter()->join(', ') ?: 'N/A' }}</div></div></div>
            </div>
        </div>

        <div class="dashboard-card section-span-6 compact-section">
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

        <div class="dashboard-card section-span-12 compact-section">
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

        <div class="dashboard-card section-span-12 compact-section">
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
    </div>
                <form id="recommendForm" method="POST">
                    @csrf
                    <div class="modal-body" style="padding: 2rem; background: #ffffff;">
                        <p style="font-size: 1rem; color: #334155; margin-bottom: 1.25rem;">Recommending: <span id="jobseekerName" style="color: #111827; font-weight: 700; font-size: 1.1rem;">N/A</span></p>
                        
                        <div class="row mb-3">
                            <!-- Step 1: Select Employer -->
                            <div class="col-md-6">
                                <label for="employerSelect" class="form-label" style="font-weight: 700; color: #334155; margin-bottom: 0.5rem; font-size: 1rem;">
                                    Employer <span class="text-danger">*</span>
                                </label>
                                <select id="employerSelect" name="employer_id" class="form-control" required style="border-radius: 10px; border: 1px solid #cbd5e1; padding: 0.75rem; font-size: 1rem; color: #0f172a; background: #fff;">
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
                                <label for="jobSelect" class="form-label" style="font-weight: 700; color: #334155; margin-bottom: 0.5rem; font-size: 1rem;">
                                    Job Position <span class="text-danger">*</span>
                                </label>
                                <select id="jobSelect" name="job_id" class="form-control" required disabled style="border-radius: 10px; border: 1px solid #cbd5e1; padding: 0.75rem; font-size: 1rem; color: #0f172a; background: #fff;">
                                    <option value="" style="color: #999;">-- Select Job --</option>
                                </select>
                            </div>
                        </div>
                        
                        <hr style="margin: 1.5rem 0; border: none; border-top: 1px solid #e5e7eb;">
                        
                        <!-- Job Details Display (Facebook-like post) -->
                        <div id="jobDetailsSection" style="display: none; background: #f8fafc; padding: 1.25rem; border-radius: 14px; overflow: hidden; box-shadow: 0 1px 3px rgba(15,23,42,0.06); margin-bottom: 1.5rem; border: 1px solid #e5e7eb;">
                            <!-- Post Header -->
                            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                                <div style="width: 56px; height: 56px; background: #243447; border-radius: 14px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="bi bi-building" style="color: white; font-size: 1.5rem;"></i>
                                </div>
                                <div>
                                    <div style="font-weight: 700; color: #0f172a; font-size: 1.05rem;" id="displayEmployerCompany"></div>
                                    <div style="color: #6b7280; font-size: 0.92rem;" id="displayEmployerName"></div>
                                </div>
                            </div>
                            
                            <!-- Job Title -->
                            <h3 style="font-size: 1.35rem; font-weight: 800; color: #0f172a; margin: 0 0 1.25rem 0;" id="displayJobTitle"></h3>
                            
                            <!-- Job Details Grid -->
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.25rem;">
                                <!-- Location -->
                                <div style="display: flex; gap: 1rem;">
                                    <div style="color: #475569; font-size: 1.3rem; flex-shrink: 0;">
                                        <i class="bi bi-geo-alt-fill"></i>
                                    </div>
                                    <div>
                                        <div style="font-size: 0.8rem; color: #6b7280; font-weight: 700; text-transform: uppercase; margin-bottom: 0.25rem;">Location</div>
                                        <div style="font-size: 1rem; color: #0f172a; font-weight: 600;" id="displayLocation"></div>
                                    </div>
                                </div>
                                
                                <!-- Salary -->
                                <div style="display: flex; gap: 1rem;">
                                    <div style="color: #475569; font-size: 1.3rem; flex-shrink: 0;">
                                        <i class="bi bi-cash-coin"></i>
                                    </div>
                                    <div>
                                        <div style="font-size: 0.8rem; color: #6b7280; font-weight: 700; text-transform: uppercase; margin-bottom: 0.25rem;">Salary Range</div>
                                        <div style="font-size: 1rem; color: #0f172a; font-weight: 600;" id="displaySalary"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Divider -->
                            <hr style="margin: 1.25rem 0; border: none; border-top: 1px solid #e5e7eb;">
                            
                            <!-- Job Description -->
                            <div style="margin-bottom: 1.5rem;">
                                <div style="font-size: 0.8rem; color: #6b7280; font-weight: 700; text-transform: uppercase; margin-bottom: 0.65rem;">About This Job</div>
                                <div style="font-size: 0.98rem; color: #334155; line-height: 1.65; background: white; padding: 1rem; border-radius: 10px; border: 1px solid #e5e7eb;" id="displayJobDescription">No description provided</div>
                            </div>
                            
                            <!-- More Details Button -->
                            <button type="button" id="moreDetailsBtn" class="btn" style="width: 100%; border-radius: 10px; padding: 0.75rem 1.5rem; font-weight: 700; font-size: 0.95rem; background: #243447; border: none; color: white; cursor: pointer; margin-bottom: 1rem;"><i class="bi bi-info-circle me-2"></i>More Details</button>
                        </div>
                        
                        <!-- Message/Note Section -->
                        <div class="mb-0">
                            <label for="messageInput" class="form-label" style="font-weight: 700; color: #334155; margin-bottom: 0.75rem; font-size: 0.95rem;">
                                <i class="bi bi-chat-dots me-2" style="color: #64748b;"></i>Personal Message (Optional)
                            </label>
                            <textarea id="messageInput" name="message" class="form-control" rows="4" 
                                      placeholder="Write a personal message to the applicant about this opportunity..." 
                                      style="border-radius: 10px; border: 1px solid #cbd5e1; padding: 1rem; font-size: 0.98rem; color: #0f172a; font-family: inherit;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: 1px solid #e5e7eb; padding: 1.25rem 1.5rem; background: #f8fafc; border-radius: 0 0 12px 12px; display: flex; gap: 0.75rem; justify-content: flex-end;">
                        <button type="button" class="btn" data-bs-dismiss="modal" style="border-radius: 10px; padding: 0.7rem 1.5rem; font-weight: 600; font-size: 0.95rem; background: #e2e8f0; color: #0f172a; border: none; cursor: pointer;">Cancel</button>
                        <button type="submit" class="btn" style="border-radius: 10px; padding: 0.7rem 1.5rem; font-weight: 700; font-size: 0.95rem; background: #243447; border: none; color: white; cursor: pointer;"><i class="bi bi-check-circle me-2"></i>Recommend Applicant</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Detailed Job Modal -->
    <style>
        .job-detail-modal .modal-content {
            border: 1px solid #d8dee6;
            border-radius: 16px;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.14);
        }

        .job-detail-modal .modal-header {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            border-radius: 16px 16px 0 0;
            padding: 1.5rem 2rem;
        }

        .job-detail-modal .modal-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.4px;
        }

        .job-detail-modal .modal-body {
            padding: 1.5rem;
            background: #f8fafc;
        }

        .detail-section {
            background: white;
            border-radius: 12px;
            padding: 1.35rem;
            margin-bottom: 1.25rem;
            border-left: 3px solid #cbd5e1;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
        }

        .detail-section h5 {
            font-size: 1rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .detail-section h5 i {
            color: #64748b;
            font-size: 1.1rem;
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
            color: #0f172a;
            font-weight: 600;
            line-height: 1.5;
        }

        .detail-value.description {
            font-size: 0.95rem;
            color: #374151;
            line-height: 1.7;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 8px;
            border-left: 3px solid #cbd5e1;
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
            color: #64748b;
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
            background: #e2e8f0;
            color: #334155;
            border: 1px solid #cbd5e1;
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
