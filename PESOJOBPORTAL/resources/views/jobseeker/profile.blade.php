@extends('layouts.dashboard')

@section('title', 'Profile | Jobseeker | PESO Job Portal')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush

@section('content')
@php
    $profile = $profile ?? null;
    $nameParts = $nameParts ?? ['surname' => '', 'first_name' => '', 'middle_name' => '', 'suffix' => ''];
    $addressParts = $addressParts ?? ['house_no' => '', 'barangay' => '', 'municipality' => '', 'province' => ''];
    $educationRows = $educationRows ?? [];
    $workExperienceRows = $workExperienceRows ?? ($profile->experience ?? []);
    $resumeFileName = $resumeFileName ?? null;
    $resumeFileUrl = $resumeFileUrl ?? null;

    if (empty($workExperienceRows)) {
        $workExperienceRows = [[
            'company' => '',
            'title' => '',
            'period' => '',
            'details' => '',
        ]];
    }

    $trainingRows = $trainingRows ?? [[
        'course' => '',
        'hours' => '',
        'institution' => '',
        'dates' => '',
        'skills' => '',
        'certificates' => '',
    ]];

    $eligibilityRows = $eligibilityRows ?? [[
        'eligibility' => '',
        'date_taken' => '',
        'license' => '',
        'valid_until' => '',
    ]];

    $educationPreview = [
        [
            'label' => 'Elementary',
            'school' => $educationRows[0]['school'] ?? '',
            'year' => $educationRows[0]['year'] ?? '',
            'level_reached' => '',
            'last_attended' => '',
        ],
        [
            'label' => 'Secondary (Non-K12)',
            'school' => $educationRows[1]['school'] ?? '',
            'year' => $educationRows[1]['year'] ?? '',
            'level_reached' => '',
            'last_attended' => '',
        ],
        [
            'label' => 'Secondary (K-12)',
            'school' => $educationRows[1]['school'] ?? '',
            'year' => $educationRows[1]['year'] ?? '',
            'level_reached' => '',
            'last_attended' => '',
        ],
        [
            'label' => 'Senior High Strand',
            'school' => $educationRows[1]['course'] ?? '',
            'year' => '',
            'level_reached' => '',
            'last_attended' => '',
        ],
        [
            'label' => 'Tertiary',
            'school' => $educationRows[2]['school'] ?? '',
            'year' => $educationRows[2]['year'] ?? '',
            'level_reached' => '',
            'last_attended' => '',
        ],
        [
            'label' => 'Course',
            'school' => $educationRows[2]['course'] ?? '',
            'year' => '',
            'level_reached' => '',
            'last_attended' => '',
        ],
        [
            'label' => 'Graduate Studies/Post-graduate',
            'school' => $educationRows[3]['school'] ?? '',
            'year' => $educationRows[3]['year'] ?? '',
            'level_reached' => '',
            'last_attended' => '',
        ],
    ];

    $resumeLabel = $resumeFileName ?: 'No file uploaded yet';
@endphp

<section class="container py-4" aria-label="Jobseeker profile">
    <div class="dashboard-topbar">
        <div>
            <div class="dashboard-topbar-title">My Profile</div>
            <div class="dashboard-topbar-subtitle">Manage your jobseeker profile</div>
        </div>
        <a href="{{ route('jobseeker.dashboard') }}" class="btn btn-outline-danger btn-sm">
            <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
        </a>
    </div>

    <div class="profile-sections vstack gap-3 mt-3">
        <div class="profile-section-card dashboard-section-card p-3 p-lg-4">
            <div class="profile-section-header">
                <div class="profile-section-icon"><i class="bi bi-person-circle"></i></div>
                <div>
                    <div class="profile-section-kicker">I.</div>
                    <h2 class="profile-section-title">Personal Information</h2>
                </div>
            </div>

            <div class="profile-section-rule"></div>

            <div class="row g-3">
                <div class="col-12 col-md-6 col-xl-3">
                    <label class="form-label fw-semibold">Surname <span class="text-danger">*</span></label>
                    <input class="form-control profile-input" value="{{ $nameParts['surname'] }}" disabled>
                </div>
                <div class="col-12 col-md-6 col-xl-3">
                    <label class="form-label fw-semibold">First Name <span class="text-danger">*</span></label>
                    <input class="form-control profile-input" value="{{ $nameParts['first_name'] }}" disabled>
                </div>
                <div class="col-12 col-md-6 col-xl-3">
                    <label class="form-label fw-semibold">Middle Name</label>
                    <input class="form-control profile-input" value="{{ $nameParts['middle_name'] }}" disabled>
                </div>
                <div class="col-12 col-md-6 col-xl-3">
                    <label class="form-label fw-semibold">Suffix</label>
                    <input class="form-control profile-input" value="{{ $nameParts['suffix'] }}" placeholder="Sr., Jr., II" disabled>
                </div>

                <div class="col-12 col-md-6 col-xl-3">
                    <label class="form-label fw-semibold">Date of Birth <span class="text-danger">*</span></label>
                    <input class="form-control profile-input" value="" placeholder="mm/dd/yyyy" disabled>
                </div>
                <div class="col-12 col-md-6 col-xl-3">
                    <label class="form-label fw-semibold">Sex</label>
                    <div class="profile-radio-stack">
                        <label class="profile-radio-item"><input type="radio" disabled> Male</label>
                        <label class="profile-radio-item"><input type="radio" checked disabled> Female</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-3">
                    <label class="form-label fw-semibold">Religion</label>
                    <input class="form-control profile-input" value="" placeholder="Roman Catholic" disabled>
                </div>
                <div class="col-12 col-md-6 col-xl-3">
                    <label class="form-label fw-semibold">Civil Status</label>
                    <input class="form-control profile-input" value="" placeholder="Single" disabled>
                </div>

                <div class="col-12 col-md-6 col-xl-3">
                    <label class="form-label fw-semibold">Height <span class="text-muted">(cm)</span></label>
                    <input class="form-control profile-input" value="" placeholder="160" disabled>
                </div>
                <div class="col-12 col-md-6 col-xl-3">
                    <label class="form-label fw-semibold">TIN</label>
                    <input class="form-control profile-input" value="" placeholder="123-456" disabled>
                </div>
                <div class="col-12 col-md-6 col-xl-3">
                    <label class="form-label fw-semibold">Contact Number/s</label>
                    <input class="form-control profile-input" value="{{ $profile->phone ?? '' }}" placeholder="0912-345-6789" disabled>
                </div>
                <div class="col-12 col-md-6 col-xl-3">
                    <label class="form-label fw-semibold">Email Address</label>
                    <input class="form-control profile-input" value="{{ $profile->resume_email ?? $user->email ?? '' }}" disabled>
                </div>
            </div>
        </div>

        <div class="profile-section-card dashboard-section-card p-3 p-lg-4">
            <div class="profile-section-header">
                <div class="profile-section-icon"><i class="bi bi-geo-alt"></i></div>
                <div>
                    <div class="profile-section-kicker">II.</div>
                    <h2 class="profile-section-title">Address</h2>
                </div>
            </div>

            <div class="profile-section-rule"></div>

            <div class="row g-3">
                <div class="col-12 col-xl-6">
                    <div class="profile-address-card">
                        <div class="profile-address-title">Present Address</div>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">House No./Street/Village</label>
                                <input class="form-control profile-input" value="{{ $addressParts['house_no'] }}" disabled>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Barangay</label>
                                <input class="form-control profile-input" value="{{ $addressParts['barangay'] }}" disabled>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Municipality/City</label>
                                <input class="form-control profile-input" value="{{ $addressParts['municipality'] }}" disabled>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Province</label>
                                <input class="form-control profile-input" value="{{ $addressParts['province'] }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-6">
                    <div class="profile-address-card">
                        <div class="profile-address-title">Permanent Address</div>
                        <label class="profile-check-label">
                            <input type="checkbox" disabled>
                            Same as present address
                        </label>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">House No./Street/Village</label>
                                <input class="form-control profile-input" value="{{ $addressParts['house_no'] }}" disabled>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Barangay</label>
                                <input class="form-control profile-input" value="{{ $addressParts['barangay'] }}" disabled>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Municipality/City</label>
                                <input class="form-control profile-input" value="{{ $addressParts['municipality'] }}" disabled>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Province</label>
                                <input class="form-control profile-input" value="{{ $addressParts['province'] }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="profile-section-card dashboard-section-card p-3 p-lg-4">
            <div class="profile-section-header">
                <div class="profile-section-icon"><i class="bi bi-upload"></i></div>
                <div>
                    <div class="profile-section-kicker">Resume Upload</div>
                    <h2 class="profile-section-title">Upload Resume</h2>
                </div>
            </div>

            <div class="profile-section-rule"></div>

            <div class="row g-3 align-items-end">
                <div class="col-12 col-lg-8">
                    <label class="form-label fw-semibold">Upload Resume (PDF, DOC, DOCX - max 5MB)</label>
                    <input type="file" class="form-control profile-file-input" disabled>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="profile-current-resume">
                        <div class="profile-summary-label">Current resume:</div>
                        @if ($resumeFileUrl)
                            <a href="{{ $resumeFileUrl }}" class="profile-resume-link" target="_blank" rel="noopener">
                                <i class="bi bi-file-earmark-text me-1"></i>{{ $resumeLabel }}
                            </a>
                        @else
                            <span class="text-muted">{{ $resumeLabel }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="profile-section-card dashboard-section-card p-3 p-lg-4">
            <div class="profile-section-header">
                <div class="profile-section-icon"><i class="bi bi-book"></i></div>
                <div>
                    <div class="profile-section-kicker">III.</div>
                    <h2 class="profile-section-title">Educational Background</h2>
                </div>
            </div>

            <div class="profile-section-rule"></div>

            <label class="profile-check-label mb-3">
                <input type="checkbox" disabled>
                Currently in school?
            </label>

            <div class="profile-education-table">
                <div class="profile-education-head">
                    <div>Level</div>
                    <div>Name of School</div>
                    <div>Year Graduated</div>
                    <div>If Undergraduate - Level Reached</div>
                    <div>If Undergraduate - Year Last Attended</div>
                </div>

                @foreach ($educationPreview as $row)
                    <div class="profile-education-row">
                        <div class="profile-education-level">{{ $row['label'] }}</div>
                        <input class="form-control profile-input profile-education-input" value="{{ $row['school'] }}" disabled>
                        <input class="form-control profile-input profile-education-input" value="{{ $row['year'] }}" disabled>
                        <input class="form-control profile-input profile-education-input" value="{{ $row['level_reached'] }}" disabled>
                        <input class="form-control profile-input profile-education-input" value="{{ $row['last_attended'] }}" disabled>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="profile-section-card dashboard-section-card p-3 p-lg-4">
            <div class="profile-section-header">
                <div class="profile-section-icon"><i class="bi bi-tools"></i></div>
                <div>
                    <div class="profile-section-kicker">IV.</div>
                    <h2 class="profile-section-title">Technical/Vocational and Other Training</h2>
                </div>
            </div>

            <div class="profile-section-rule"></div>

            @foreach ($trainingRows as $index => $row)
                <div class="profile-entry-card profile-entry-card--blue mb-3">
                    <div class="profile-entry-header">
                        <div>
                            <div class="profile-entry-kicker">Training #{{ $index + 1 }}</div>
                        </div>
                        <button type="button" class="btn btn-sm profile-remove-btn" disabled>
                            <i class="bi bi-trash3 me-1"></i>Remove
                        </button>
                    </div>

                    <div class="row g-3">
                        <div class="col-12 col-lg-5">
                            <label class="form-label fw-semibold">Training/Vocational Course</label>
                            <input class="form-control profile-input" value="{{ $row['course'] ?? '' }}" placeholder="Web Development Fundamentals" disabled>
                        </div>
                        <div class="col-12 col-md-6 col-lg-2">
                            <label class="form-label fw-semibold">Hours</label>
                            <input class="form-control profile-input" value="{{ $row['hours'] ?? '' }}" placeholder="80" disabled>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label fw-semibold">Training Institution</label>
                            <input class="form-control profile-input" value="{{ $row['institution'] ?? '' }}" placeholder="TESDA Training Center" disabled>
                        </div>
                        <div class="col-12 col-lg-2">
                            <label class="form-label fw-semibold">Inclusive Dates</label>
                            <input class="form-control profile-input" value="{{ $row['dates'] ?? '' }}" placeholder="01/2023 - 03/2023" disabled>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label class="form-label fw-semibold">Skills Acquired</label>
                            <input class="form-control profile-input" value="{{ $row['skills'] ?? '' }}" placeholder="HTML, CSS, JavaScript basics" disabled>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label class="form-label fw-semibold">Certificates (NC I, NCII, etc.)</label>
                            <input class="form-control profile-input" value="{{ $row['certificates'] ?? '' }}" placeholder="NC II - Web Development" disabled>
                        </div>
                    </div>
                </div>
            @endforeach

            <button type="button" class="btn btn-outline-primary profile-add-btn" disabled>
                <i class="bi bi-plus-circle me-1"></i>Add Training
            </button>
        </div>

        <div class="profile-section-card dashboard-section-card p-3 p-lg-4">
            <div class="profile-section-header">
                <div class="profile-section-icon"><i class="bi bi-briefcase"></i></div>
                <div>
                    <div class="profile-section-kicker">V.</div>
                    <h2 class="profile-section-title">Work Experience</h2>
                </div>
            </div>

            <div class="profile-section-rule"></div>

            <div class="profile-work-question mb-3">
                <span class="fw-semibold me-2">Do you have work experience?</span>
                <label class="profile-radio-inline me-3"><input type="radio" checked disabled> Yes</label>
                <label class="profile-radio-inline"><input type="radio" disabled> No</label>
                <span class="text-muted ms-2">If yes, please provide more information</span>
            </div>

            @foreach ($workExperienceRows as $index => $row)
                <div class="profile-entry-card profile-entry-card--teal mb-3">
                    <div class="profile-entry-header profile-entry-header--toolbar">
                        <div class="profile-entry-kicker">Work Experience #{{ $index + 1 }}</div>
                        <button type="button" class="btn btn-sm profile-remove-btn" disabled>
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    <div class="row g-3">
                        <div class="col-12 col-lg-4">
                            <label class="form-label fw-semibold">Company Name <span class="text-danger">*</span></label>
                            <input class="form-control profile-input" value="{{ $row['company'] ?? '' }}" placeholder="PixelCraft Web Services" disabled>
                        </div>
                        <div class="col-12 col-lg-4">
                            <label class="form-label fw-semibold">Position/Job Title <span class="text-danger">*</span></label>
                            <input class="form-control profile-input" value="{{ $row['title'] ?? '' }}" placeholder="Freelance Web Developer" disabled>
                        </div>
                        <div class="col-12 col-lg-3">
                            <label class="form-label fw-semibold">Location (City) <span class="text-danger">*</span></label>
                            <input class="form-control profile-input" value="" placeholder="Cagayan de Oro City" disabled>
                        </div>
                        <div class="col-12 col-lg-1">
                            <label class="form-label fw-semibold">Status</label>
                            <input class="form-control profile-input" value="" placeholder="Yes" disabled>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label fw-semibold">From Date</label>
                            <input class="form-control profile-input" value="{{ $row['period'] ?? '' }}" placeholder="June 2024" disabled>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label fw-semibold">To Date</label>
                            <input class="form-control profile-input" value="" placeholder="September 2024" disabled>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label fw-semibold">Salary Amount</label>
                            <input class="form-control profile-input" value="" placeholder="15000" disabled>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label fw-semibold">Salary Type</label>
                            <input class="form-control profile-input" value="" placeholder="Monthly" disabled>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Reason Left / Duties</label>
                            <textarea class="form-control profile-input" rows="4" disabled>{{ $row['details'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            @endforeach

            <button type="button" class="btn btn-outline-primary profile-add-btn" disabled>
                <i class="bi bi-plus-circle me-1"></i>Add Work Experience
            </button>
        </div>

        <div class="profile-section-card dashboard-section-card p-3 p-lg-4">
            <div class="profile-section-header">
                <div class="profile-section-icon"><i class="bi bi-award"></i></div>
                <div>
                    <div class="profile-section-kicker">VI.</div>
                    <h2 class="profile-section-title">Eligibility / Professional License</h2>
                </div>
            </div>

            <div class="profile-section-rule"></div>

            @foreach ($eligibilityRows as $index => $row)
                <div class="profile-entry-card profile-entry-card--orange mb-3">
                    <div class="profile-entry-header profile-entry-header--toolbar">
                        <div class="profile-entry-kicker">Eligibility #{{ $index + 1 }}</div>
                        <button type="button" class="btn btn-sm profile-remove-btn profile-remove-btn--danger" disabled>
                            <i class="bi bi-trash3 me-1"></i>Remove
                        </button>
                    </div>

                    <div class="row g-3">
                        <div class="col-12 col-lg-5">
                            <label class="form-label fw-semibold">Eligibility (Civil Service)</label>
                            <input class="form-control profile-input" value="{{ $row['eligibility'] ?? '' }}" placeholder="Civil Service Professional Eligibility (Sub-Professional)" disabled>
                        </div>
                        <div class="col-12 col-md-6 col-lg-2">
                            <label class="form-label fw-semibold">Date Taken</label>
                            <input class="form-control profile-input" value="{{ $row['date_taken'] ?? '' }}" placeholder="08/14/2023" disabled>
                        </div>
                        <div class="col-12 col-md-6 col-lg-5">
                            <label class="form-label fw-semibold">Professional License (PRC)</label>
                            <input class="form-control profile-input" value="{{ $row['license'] ?? '' }}" placeholder="" disabled>
                        </div>
                        <div class="col-12 col-lg-3">
                            <label class="form-label fw-semibold">Valid Until</label>
                            <input class="form-control profile-input" value="{{ $row['valid_until'] ?? '' }}" placeholder="mm/dd/yyyy" disabled>
                        </div>
                    </div>
                </div>
            @endforeach

            <button type="button" class="btn btn-outline-primary profile-add-btn" disabled>
                <i class="bi bi-plus-circle me-1"></i>Add License/Eligibility
            </button>
        </div>
    </div>
</section>
@endsection
