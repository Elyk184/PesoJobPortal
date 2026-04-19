@extends('layouts.dashboard')

@section('title', 'Profile | Jobseeker | PESO Job Portal')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush

@section('content')
@php
    $profile = $profile ?? null;

    $personalInformation = old('personal_information', $personalInformation ?? []);
    $presentAddress = old('present_address', $presentAddress ?? []);
    $permanentAddress = old('permanent_address', $permanentAddress ?? []);
    $educationRows = old('education', $educationRows ?? []);
    $trainingRows = old('training', $trainingRows ?? []);
    $experienceRows = old('experience', $experienceRows ?? []);
    $eligibilityRows = old('eligibility', $eligibilityRows ?? []);
    $otherSkills = old('other_skills', $otherSkills ?? []);
    $employmentStatus = old('employment_status', $employmentStatus ?? []);
    $jobPreferences = old('job_preferences', $jobPreferences ?? []);
    $languages = old('languages', $languages ?? []);
    $disability = old('disability', $disability ?? []);

    if (empty($educationRows)) {
        $educationRows = [['school' => '', 'course' => '', 'year' => '']];
    }

    if (empty($trainingRows)) {
        $trainingRows = [['course' => '', 'hours' => '', 'institution' => '', 'dates' => '', 'skills' => '', 'certificates' => '']];
    }

    if (empty($experienceRows)) {
        $experienceRows = [['company' => '', 'title' => '', 'location' => '', 'status' => '', 'from_date' => '', 'to_date' => '', 'salary_amount' => '', 'salary_type' => '', 'details' => '']];
    }

    if (empty($eligibilityRows)) {
        $eligibilityRows = [['eligibility' => '', 'date_taken' => '', 'license' => '', 'valid_until' => '']];
    }

    if (empty($languages)) {
        $languages = [
            ['language' => 'English', 'read' => true, 'write' => true, 'speak' => true, 'understand' => true, 'other' => ''],
            ['language' => 'Tagalog', 'read' => true, 'write' => true, 'speak' => true, 'understand' => true, 'other' => ''],
            ['language' => 'Visayan', 'read' => true, 'write' => true, 'speak' => true, 'understand' => true, 'other' => ''],
            ['language' => 'Others:', 'read' => false, 'write' => false, 'speak' => false, 'understand' => false, 'other' => ''],
        ];
    }

    $skillGroups = [
        'trade_manual' => [
            'label' => 'Trade & Manual Skills',
            'options' => ['Auto Mechanic', 'Beautician', 'Carpentry Work', 'Plumbing', 'Housekeeping', 'Electrician', 'Embroidery', 'Tailoring', 'Masonry', 'Painting Jobs', 'Gardening/Farming', 'Driver'],
        ],
        'it_technical' => [
            'label' => 'IT & Technical Skills',
            'options' => ['Computer Literate', 'Microsoft Office', 'Web Development', 'Programming', 'Database', 'JavaScript', 'HTML/CSS', 'Git', 'Database Management', 'Frontend Development (Web UI)', 'API Integration & Development', 'Software Development & Debugging', 'Network Configuration & Troubleshooting', 'Hardware Installation & Repair', 'Graphic Design', 'React.js', 'Node.js', 'REST API', 'Backend Development (Server-side)', 'Virtual Assistance', 'Data Entry and Record Keeping', 'Filing and Documentation', 'Scheduling and Calendar Management', 'MySQL (Database)', 'Flutter', 'Docker', 'Laravel (Backend)'],
        ],
        'soft_skills' => [
            'label' => 'Soft Skills',
            'options' => ['Critical Thinking', 'Problem-Solving', 'Adaptability', 'Time Management', 'Team Collaboration'],
        ],
    ];

    $selectedTradeSkills = data_get($otherSkills, 'trade_manual', []);
    $selectedItSkills = data_get($otherSkills, 'it_technical', []);
    $selectedSoftSkills = data_get($otherSkills, 'soft_skills', []);
    $otherSkillText = data_get($otherSkills, 'other_text', '');
    $withCertificate = data_get($otherSkills, 'with_certificate', false);
    $byExperience = data_get($otherSkills, 'by_experience', false);
    $workExperienceHas = old('work_experience_has', data_get($employmentStatus, 'has_work_experience', null));

    $employmentTypes = [
        'wage_employed' => 'Wage employed (Please specify)',
        'self_employed' => 'Self employed (Please specify)',
        'unemployed' => 'Unemployed',
    ];

    $jobPreferenceOccupations = data_get($jobPreferences, 'occupation_text', '');
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

    @if (session('status'))
        <div class="alert alert-success border-0 shadow-sm">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm">
            <div class="fw-semibold mb-1">Please fix the highlighted problems.</div>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('jobseeker.profile.save') }}" class="profile-form mt-3">
        @csrf

        <div class="profile-sections vstack gap-3">
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
                        <label class="form-label fw-semibold">First Name <span class="text-danger">*</span></label>
                        <input class="form-control profile-input" name="personal_information[first_name]" value="{{ old('personal_information.first_name', $personalInformation['first_name'] ?? '') }}">
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <label class="form-label fw-semibold">Middle Initial</label>
                        <input class="form-control profile-input" name="personal_information[middle_initial]" maxlength="5" placeholder="M."
                            value="{{ old('personal_information.middle_initial', $personalInformation['middle_initial'] ?? $personalInformation['middle_name'] ?? '') }}">
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <label class="form-label fw-semibold">Surname <span class="text-danger">*</span></label>
                        <input class="form-control profile-input" name="personal_information[surname]" value="{{ old('personal_information.surname', $personalInformation['surname'] ?? '') }}">
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <label class="form-label fw-semibold">Suffix</label>
                        <input class="form-control profile-input" name="personal_information[suffix]" placeholder="Sr., Jr., II" value="{{ old('personal_information.suffix', $personalInformation['suffix'] ?? '') }}">
                    </div>

                    <div class="col-12 col-md-6 col-xl-3">
                        <label class="form-label fw-semibold">Date of Birth <span class="text-danger">*</span></label>
                        <input type="date" class="form-control profile-input" name="personal_information[date_of_birth]" value="{{ old('personal_information.date_of_birth', $personalInformation['date_of_birth'] ?? '') }}">
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <label class="form-label fw-semibold d-block">Sex</label>
                        <div class="profile-radio-stack">
                            <label class="profile-radio-item"><input type="radio" name="personal_information[sex]" value="Male" @checked(old('personal_information.sex', $personalInformation['sex'] ?? '') === 'Male')> Male</label>
                            <label class="profile-radio-item"><input type="radio" name="personal_information[sex]" value="Female" @checked(old('personal_information.sex', $personalInformation['sex'] ?? '') === 'Female')> Female</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <label class="form-label fw-semibold">Religion</label>
                        <input class="form-control profile-input" name="personal_information[religion]" value="{{ old('personal_information.religion', $personalInformation['religion'] ?? '') }}">
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <label class="form-label fw-semibold">Civil Status</label>
                        <input class="form-control profile-input" name="personal_information[civil_status]" value="{{ old('personal_information.civil_status', $personalInformation['civil_status'] ?? '') }}">
                    </div>

                    <div class="col-12 col-md-6 col-xl-3">
                        <label class="form-label fw-semibold">Height <span class="text-muted">(cm)</span></label>
                        <input class="form-control profile-input" name="personal_information[height]" value="{{ old('personal_information.height', $personalInformation['height'] ?? '') }}">
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <label class="form-label fw-semibold">TIN</label>
                        <input class="form-control profile-input" name="personal_information[tin]" value="{{ old('personal_information.tin', $personalInformation['tin'] ?? '') }}">
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <label class="form-label fw-semibold">Contact Number/s</label>
                        <input class="form-control profile-input" name="personal_information[contact_number]" value="{{ old('personal_information.contact_number', $personalInformation['contact_number'] ?? '') }}">
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <label class="form-label fw-semibold">Email Address</label>
                        <input type="email" class="form-control profile-input" name="personal_information[email_address]" value="{{ old('personal_information.email_address', $personalInformation['email_address'] ?? '') }}">
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
                                    <input class="form-control profile-input" name="present_address[house_no]" data-address-source="present" data-address-field="house_no" value="{{ old('present_address.house_no', $presentAddress['house_no'] ?? '') }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Barangay</label>
                                    <input class="form-control profile-input" name="present_address[barangay]" data-address-source="present" data-address-field="barangay" value="{{ old('present_address.barangay', $presentAddress['barangay'] ?? '') }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Municipality/City</label>
                                    <input class="form-control profile-input" name="present_address[municipality]" data-address-source="present" data-address-field="municipality" value="{{ old('present_address.municipality', $presentAddress['municipality'] ?? '') }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Province</label>
                                    <input class="form-control profile-input" name="present_address[province]" data-address-source="present" data-address-field="province" value="{{ old('present_address.province', $presentAddress['province'] ?? '') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-xl-6">
                        <div class="profile-address-card">
                            <div class="profile-address-title">Permanent Address</div>
                            <label class="profile-check-label">
                                <input type="checkbox" name="permanent_address[same_as_present]" value="1" data-copy-present-address>
                                Same as present address
                            </label>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold">House No./Street/Village</label>
                                    <input class="form-control profile-input" name="permanent_address[house_no]" data-address-target="house_no" value="{{ old('permanent_address.house_no', $permanentAddress['house_no'] ?? '') }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Barangay</label>
                                    <input class="form-control profile-input" name="permanent_address[barangay]" data-address-target="barangay" value="{{ old('permanent_address.barangay', $permanentAddress['barangay'] ?? '') }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Municipality/City</label>
                                    <input class="form-control profile-input" name="permanent_address[municipality]" data-address-target="municipality" value="{{ old('permanent_address.municipality', $permanentAddress['municipality'] ?? '') }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Province</label>
                                    <input class="form-control profile-input" name="permanent_address[province]" data-address-target="province" value="{{ old('permanent_address.province', $permanentAddress['province'] ?? '') }}">
                                </div>
                            </div>
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

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="profile-check-label mb-0">
                        <input type="checkbox" name="education_currently_in_school" value="1" @checked(old('education_currently_in_school', data_get($personalInformation, 'currently_in_school', false)))>
                        Currently in school?
                    </label>
                    <button type="button" class="btn btn-sm btn-outline-primary" data-add-row="education">
                        <i class="bi bi-plus-lg me-1"></i>Add Education
                    </button>
                </div>

                <div class="vstack gap-3" id="education-rows">
                    @foreach ($educationRows as $index => $row)
                        <div class="profile-entry-card profile-entry-card--blue resume-row" data-row="education">
                            <div class="profile-entry-header">
                                <div class="profile-entry-kicker">Education {{ $index + 1 }}</div>
                                <button type="button" class="btn btn-sm profile-remove-btn" data-remove-row>
                                    <i class="bi bi-trash3 me-1"></i>Remove
                                </button>
                            </div>
                            <div class="row g-2">
                                <div class="col-12 col-lg-6"><input class="form-control profile-input" data-field="school" name="education[{{ $index }}][school]" placeholder="School / University" value="{{ $row['school'] ?? '' }}"></div>
                                <div class="col-12 col-lg-4"><input class="form-control profile-input" data-field="course" name="education[{{ $index }}][course]" placeholder="Course / Strand" value="{{ $row['course'] ?? '' }}"></div>
                                <div class="col-12 col-lg-2"><input class="form-control profile-input" data-field="year" name="education[{{ $index }}][year]" placeholder="Year" value="{{ $row['year'] ?? '' }}"></div>
                            </div>
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

                <div class="d-flex justify-content-end mb-2">
                    <button type="button" class="btn btn-sm btn-outline-primary" data-add-row="training">
                        <i class="bi bi-plus-lg me-1"></i>Add Training
                    </button>
                </div>

                <div class="vstack gap-3" id="training-rows">
                    @foreach ($trainingRows as $index => $row)
                        <div class="profile-entry-card profile-entry-card--blue resume-row" data-row="training">
                            <div class="profile-entry-header">
                                <div class="profile-entry-kicker">Training #{{ $index + 1 }}</div>
                                <button type="button" class="btn btn-sm profile-remove-btn" data-remove-row>
                                    <i class="bi bi-trash3 me-1"></i>Remove
                                </button>
                            </div>
                            <div class="row g-3">
                                <div class="col-12 col-lg-5"><label class="form-label fw-semibold">Training/Vocational Course</label><input class="form-control profile-input" data-field="course" name="training[{{ $index }}][course]" value="{{ $row['course'] ?? '' }}" placeholder=""></div>
                                <div class="col-12 col-md-6 col-lg-2"><label class="form-label fw-semibold">Hours</label><input class="form-control profile-input" data-field="hours" name="training[{{ $index }}][hours]" value="{{ $row['hours'] ?? '' }}" placeholder=""></div>
                                <div class="col-12 col-md-6 col-lg-3"><label class="form-label fw-semibold">Training Institution</label><input class="form-control profile-input" data-field="institution" name="training[{{ $index }}][institution]" value="{{ $row['institution'] ?? '' }}" placeholder=""></div>
                                <div class="col-12 col-lg-2"><label class="form-label fw-semibold">Inclusive Dates</label><input class="form-control profile-input" data-field="dates" name="training[{{ $index }}][dates]" value="{{ $row['dates'] ?? '' }}" placeholder=""></div>
                                <div class="col-12 col-lg-6"><label class="form-label fw-semibold">Skills Acquired</label><input class="form-control profile-input" data-field="skills" name="training[{{ $index }}][skills]" value="{{ $row['skills'] ?? '' }}" placeholder=""></div>
                                <div class="col-12 col-lg-6"><label class="form-label fw-semibold">Certificates (NC I, NCII, etc.)</label><input class="form-control profile-input" data-field="certificates" name="training[{{ $index }}][certificates]" value="{{ $row['certificates'] ?? '' }}" placeholder=""></div>
                            </div>
                        </div>
                    @endforeach
                </div>
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
                    <label class="profile-radio-inline me-3"><input type="radio" name="work_experience_has" value="1" @checked((string) $workExperienceHas === '1')> Yes</label>
                    <label class="profile-radio-inline"><input type="radio" name="work_experience_has" value="0" @checked((string) $workExperienceHas === '0')> No</label>
                    <span class="text-muted ms-2">If yes, please provide more information</span>
                </div>

                <div class="d-flex justify-content-end mb-2">
                    <button type="button" class="btn btn-sm btn-outline-primary" data-add-row="experience">
                        <i class="bi bi-plus-lg me-1"></i>Add Work Experience
                    </button>
                </div>

                <div class="vstack gap-3" id="experience-rows">
                    @foreach ($experienceRows as $index => $row)
                        <div class="profile-entry-card profile-entry-card--teal resume-row" data-row="experience">
                            <div class="profile-entry-header profile-entry-header--toolbar">
                                <div class="profile-entry-kicker">Work Experience #{{ $index + 1 }}</div>
                                <button type="button" class="btn btn-sm profile-remove-btn" data-remove-row><i class="bi bi-x-lg"></i></button>
                            </div>
                            <div class="row g-3">
                                <div class="col-12 col-lg-4"><label class="form-label fw-semibold">Company Name <span class="text-danger">*</span></label><input class="form-control profile-input" data-field="company" name="experience[{{ $index }}][company]" value="{{ $row['company'] ?? '' }}" placeholder="PixelCraft Web Services"></div>
                                <div class="col-12 col-lg-4"><label class="form-label fw-semibold">Position/Job Title <span class="text-danger">*</span></label><input class="form-control profile-input" data-field="title" name="experience[{{ $index }}][title]" value="{{ $row['title'] ?? '' }}" placeholder="Freelance Web Developer"></div>
                                <div class="col-12 col-lg-3"><label class="form-label fw-semibold">Location (City) <span class="text-danger">*</span></label><input class="form-control profile-input" data-field="location" name="experience[{{ $index }}][location]" value="{{ $row['location'] ?? '' }}" placeholder="Cagayan de Oro City"></div>
                                <div class="col-12 col-lg-1"><label class="form-label fw-semibold">Status</label><input class="form-control profile-input" data-field="status" name="experience[{{ $index }}][status]" value="{{ $row['status'] ?? '' }}" placeholder="Yes"></div>
                                <div class="col-12 col-md-6 col-lg-3"><label class="form-label fw-semibold">From Date</label><input class="form-control profile-input" data-field="from_date" name="experience[{{ $index }}][from_date]" value="{{ $row['from_date'] ?? ($row['period'] ?? '') }}" placeholder="June 2024"></div>
                                <div class="col-12 col-md-6 col-lg-3"><label class="form-label fw-semibold">To Date</label><input class="form-control profile-input" data-field="to_date" name="experience[{{ $index }}][to_date]" value="{{ $row['to_date'] ?? '' }}" placeholder="September 2024"></div>
                                <div class="col-12 col-md-6 col-lg-3"><label class="form-label fw-semibold">Salary Amount</label><input class="form-control profile-input" data-field="salary_amount" name="experience[{{ $index }}][salary_amount]" value="{{ $row['salary_amount'] ?? '' }}" placeholder="15000"></div>
                                <div class="col-12 col-md-6 col-lg-3"><label class="form-label fw-semibold">Salary Type</label><input class="form-control profile-input" data-field="salary_type" name="experience[{{ $index }}][salary_type]" value="" placeholder=""></div>
                                <div class="col-12"><label class="form-label fw-semibold">Reason Left / Duties</label><textarea class="form-control profile-input" rows="4" data-field="details" name="experience[{{ $index }}][details]">{{ $row['details'] ?? '' }}</textarea></div>
                            </div>
                        </div>
                    @endforeach
                </div>
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

                <div class="d-flex justify-content-end mb-2">
                    <button type="button" class="btn btn-sm btn-outline-primary" data-add-row="eligibility">
                        <i class="bi bi-plus-lg me-1"></i>Add License/Eligibility
                    </button>
                </div>

                <div class="vstack gap-3" id="eligibility-rows">
                    @foreach ($eligibilityRows as $index => $row)
                        <div class="profile-entry-card profile-entry-card--orange resume-row" data-row="eligibility">
                            <div class="profile-entry-header profile-entry-header--toolbar">
                                <div class="profile-entry-kicker">Eligibility #{{ $index + 1 }}</div>
                                <button type="button" class="btn btn-sm profile-remove-btn profile-remove-btn--danger" data-remove-row><i class="bi bi-trash3 me-1"></i>Remove</button>
                            </div>
                            <div class="row g-3">
                                <div class="col-12 col-lg-5"><label class="form-label fw-semibold">Eligibility (Civil Service)</label><input class="form-control profile-input" data-field="eligibility" name="eligibility[{{ $index }}][eligibility]" value="{{ $row['eligibility'] ?? '' }}" placeholder=""></div>
                                <div class="col-12 col-md-6 col-lg-2"><label class="form-label fw-semibold">Date Taken</label><input class="form-control profile-input" data-field="date_taken" name="eligibility[{{ $index }}][date_taken]" value="{{ $row['date_taken'] ?? '' }}" placeholder=""></div>
                                <div class="col-12 col-md-6 col-lg-5"><label class="form-label fw-semibold">Professional License (PRC)</label><input class="form-control profile-input" data-field="license" name="eligibility[{{ $index }}][license]" value="{{ $row['license'] ?? '' }}"></div>
                                <div class="col-12 col-lg-3"><label class="form-label fw-semibold">Valid Until</label><input class="form-control profile-input" data-field="valid_until" name="eligibility[{{ $index }}][valid_until]" value="{{ $row['valid_until'] ?? '' }}" placeholder=""></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="profile-section-card dashboard-section-card p-3 p-lg-4">
                <div class="profile-section-header">
                    <div class="profile-section-icon"><i class="bi bi-star"></i></div>
                    <div>
                        <div class="profile-section-kicker">VII.</div>
                        <h2 class="profile-section-title">Other Skills Acquired</h2>
                    </div>
                </div>
                <div class="profile-section-rule"></div>

                @foreach ($skillGroups as $key => $group)
                    @php $selectedSkills = data_get($otherSkills, $key, []); @endphp
                    <div class="profile-skill-group mb-3">
                        <div class="profile-skill-group-title">{{ $group['label'] }}</div>
                        <div class="profile-skill-grid">
                            @foreach ($group['options'] as $option)
                                <label class="profile-check-tile">
                                    <input type="checkbox" name="other_skills[{{ $key }}][]" value="{{ $option }}" @checked(in_array($option, $selectedSkills, true))>
                                    <span>{{ $option }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <div class="profile-skill-group pt-3 border-top">
                    <label class="profile-check-tile profile-check-tile--full mb-3">
                        <input type="checkbox" name="other_skills[other_enabled]" value="1" @checked((bool) data_get($otherSkills, 'other_enabled', false))>
                        <span><strong>Others (please specify):</strong></span>
                    </label>
                    <input class="form-control profile-input" name="other_skills[other_text]" value="{{ $otherSkillText }}" placeholder="Specify">
                    <div class="row g-3 mt-1">
                        <div class="col-12 col-md-6">
                            <div class="profile-inline-choice">
                                <span class="fw-semibold">With Certificate</span>
                                <label class="profile-radio-inline"><input type="radio" name="other_skills[with_certificate]" value="1" @checked((string) $withCertificate === '1')> Yes</label>
                                <label class="profile-radio-inline"><input type="radio" name="other_skills[with_certificate]" value="0" @checked((string) $withCertificate === '0')> No</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="profile-inline-choice">
                                <span class="fw-semibold">By Experience</span>
                                <label class="profile-radio-inline"><input type="radio" name="other_skills[by_experience]" value="1" @checked((string) $byExperience === '1')> Yes</label>
                                <label class="profile-radio-inline"><input type="radio" name="other_skills[by_experience]" value="0" @checked((string) $byExperience === '0')> No</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="profile-section-card dashboard-section-card p-3 p-lg-4">
                <div class="profile-section-header">
                    <div class="profile-section-icon"><i class="bi bi-briefcase-fill"></i></div>
                    <div>
                        <div class="profile-section-kicker">VIII.</div>
                        <h2 class="profile-section-title">Employment Status / Type</h2>
                    </div>
                </div>
                <div class="profile-section-rule"></div>

                <div class="row g-4">
                    <div class="col-12 col-lg-6">
                        <div class="profile-block-heading">Employed</div>
                        @foreach ($employmentTypes as $key => $label)
                            @if ($key !== 'unemployed')
                                <label class="profile-check-tile profile-check-tile--stacked">
                                    <input type="checkbox" name="employment_status[{{ $key }}]" value="1" @checked((bool) data_get($employmentStatus, $key, false))>
                                    <span>{{ $label }}</span>
                                </label>
                            @endif
                        @endforeach
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="profile-block-heading">Unemployed</div>
                        <label class="profile-check-tile profile-check-tile--stacked">
                            <input type="checkbox" name="employment_status[unemployed]" value="1" @checked((bool) data_get($employmentStatus, 'unemployed', false))>
                            <span>Unemployed</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="profile-section-card dashboard-section-card p-3 p-lg-4">
                <div class="profile-section-header">
                    <div class="profile-section-icon"><i class="bi bi-search"></i></div>
                    <div>
                        <div class="profile-section-kicker">IX.</div>
                        <h2 class="profile-section-title">Job Preference</h2>
                    </div>
                </div>
                <div class="profile-section-rule"></div>

                <div class="row g-4">
                    <div class="col-12 col-lg-6">
                        <div class="profile-block-heading">Preferred Occupation</div>
                        <label class="profile-check-tile profile-check-tile--stacked"><input type="checkbox" name="job_preferences[part_time]" value="1" @checked((bool) data_get($jobPreferences, 'part_time', false))><span>Part-time</span></label>
                        <label class="profile-check-tile profile-check-tile--stacked"><input type="checkbox" name="job_preferences[full_time]" value="1" @checked((bool) data_get($jobPreferences, 'full_time', false))><span>Full-time</span></label>
                        <textarea class="form-control profile-input profile-notes mt-3" name="job_preferences[occupation_text]" rows="4" placeholder="List preferred occupations">{{ $jobPreferenceOccupations }}</textarea>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="profile-block-heading">Preferred Work Location</div>
                        <label class="profile-check-tile profile-check-tile--stacked"><input type="checkbox" name="job_preferences[local]" value="1" @checked((bool) data_get($jobPreferences, 'local', false))><span>Local (specify cities/municipalities)</span></label>
                        <label class="profile-check-tile profile-check-tile--stacked"><input type="checkbox" name="job_preferences[overseas]" value="1" @checked((bool) data_get($jobPreferences, 'overseas', false))><span>Overseas (specify countries)</span></label>
                    </div>
                </div>
            </div>

            <div class="profile-section-card dashboard-section-card p-3 p-lg-4">
                <div class="profile-section-header">
                    <div class="profile-section-icon"><i class="bi bi-chat-square-dots"></i></div>
                    <div>
                        <div class="profile-section-kicker">X.</div>
                        <h2 class="profile-section-title">Language / Dialect Proficiency</h2>
                    </div>
                </div>
                <div class="profile-section-rule"></div>

                <div class="profile-language-table">
                    <div class="profile-language-head">
                        <div>Language/Dialect</div>
                        <div>Read</div>
                        <div>Write</div>
                        <div>Speak</div>
                        <div>Understand</div>
                    </div>

                    @foreach ($languages as $index => $row)
                        <div class="profile-language-row">
                            <div class="profile-language-name">
                                <input type="text" class="form-control profile-input profile-language-other mb-2" name="languages[{{ $index }}][language]" value="{{ $row['language'] ?? '' }}" placeholder="Language/Dialect">
                                @if (($row['language'] ?? '') === 'Others:')
                                    <input type="text" class="form-control profile-input" name="languages[{{ $index }}][other]" value="{{ $row['other'] ?? '' }}" placeholder="Specify">
                                @endif
                            </div>
                            <label class="profile-language-check"><input type="checkbox" name="languages[{{ $index }}][read]" value="1" @checked((bool) ($row['read'] ?? false))></label>
                            <label class="profile-language-check"><input type="checkbox" name="languages[{{ $index }}][write]" value="1" @checked((bool) ($row['write'] ?? false))></label>
                            <label class="profile-language-check"><input type="checkbox" name="languages[{{ $index }}][speak]" value="1" @checked((bool) ($row['speak'] ?? false))></label>
                            <label class="profile-language-check"><input type="checkbox" name="languages[{{ $index }}][understand]" value="1" @checked((bool) ($row['understand'] ?? false))></label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="profile-section-card dashboard-section-card p-3 p-lg-4">
                <div class="profile-section-header">
                    <div class="profile-section-icon"><i class="bi bi-universal-access"></i></div>
                    <div>
                        <div class="profile-section-kicker">XI.</div>
                        <h2 class="profile-section-title">Disability</h2>
                    </div>
                </div>
                <div class="profile-section-rule"></div>

                <div class="profile-disability-grid">
                    <label class="profile-check-tile profile-check-tile--stacked"><input type="checkbox" name="disability[visual]" value="1" @checked((bool) data_get($disability, 'visual', false))><span>Visual</span></label>
                    <label class="profile-check-tile profile-check-tile--stacked"><input type="checkbox" name="disability[speech]" value="1" @checked((bool) data_get($disability, 'speech', false))><span>Speech</span></label>
                    <label class="profile-check-tile profile-check-tile--stacked"><input type="checkbox" name="disability[mental]" value="1" @checked((bool) data_get($disability, 'mental', false))><span>Mental</span></label>
                    <label class="profile-check-tile profile-check-tile--stacked"><input type="checkbox" name="disability[hearing]" value="1" @checked((bool) data_get($disability, 'hearing', false))><span>Hearing</span></label>
                    <label class="profile-check-tile profile-check-tile--stacked"><input type="checkbox" name="disability[physical]" value="1" @checked((bool) data_get($disability, 'physical', false))><span>Physical</span></label>
                    <label class="profile-check-tile profile-check-tile--stacked"><input type="checkbox" name="disability[other]" value="1" @checked((bool) data_get($disability, 'other', false))><span>Others (please specify)</span></label>
                    <div class="col-12">
                        <input class="form-control profile-input" name="disability[other_text]" value="{{ data_get($disability, 'other_text', '') }}" placeholder="Specify">
                    </div>
                </div>
            </div>

            <div class="profile-save-wrap pb-1">
                <button type="submit" class="btn profile-save-btn">
                    <i class="bi bi-cloud-arrow-up me-2"></i>Save Profile
                </button>
            </div>
        </div>
    </form>
</section>

<template id="education-template">
    <div class="profile-entry-card profile-entry-card--blue resume-row" data-row="education">
        <div class="profile-entry-header">
            <div class="profile-entry-kicker">Education</div>
            <button type="button" class="btn btn-sm profile-remove-btn" data-remove-row><i class="bi bi-trash3 me-1"></i>Remove</button>
        </div>
        <div class="row g-2">
            <div class="col-12 col-lg-6"><input class="form-control profile-input" data-field="school" name="education[__INDEX__][school]" placeholder="School / University"></div>
            <div class="col-12 col-lg-4"><input class="form-control profile-input" data-field="course" name="education[__INDEX__][course]" placeholder="Course / Strand"></div>
            <div class="col-12 col-lg-2"><input class="form-control profile-input" data-field="year" name="education[__INDEX__][year]" placeholder="Year"></div>
        </div>
    </div>
</template>

<template id="training-template">
    <div class="profile-entry-card profile-entry-card--blue resume-row" data-row="training">
        <div class="profile-entry-header">
            <div class="profile-entry-kicker">Training</div>
            <button type="button" class="btn btn-sm profile-remove-btn" data-remove-row><i class="bi bi-trash3 me-1"></i>Remove</button>
        </div>
        <div class="row g-3">
            <div class="col-12 col-lg-5"><input class="form-control profile-input" data-field="course" name="training[__INDEX__][course]" placeholder=""></div>
            <div class="col-12 col-md-6 col-lg-2"><input class="form-control profile-input" data-field="hours" name="training[__INDEX__][hours]" placeholder=""></div>
            <div class="col-12 col-md-6 col-lg-3"><input class="form-control profile-input" data-field="institution" name="training[__INDEX__][institution]" placeholder=""></div>
            <div class="col-12 col-lg-2"><input class="form-control profile-input" data-field="dates" name="training[__INDEX__][dates]" placeholder=""></div>
            <div class="col-12 col-lg-6"><input class="form-control profile-input" data-field="skills" name="training[__INDEX__][skills]" placeholder=""></div>
            <div class="col-12 col-lg-6"><input class="form-control profile-input" data-field="certificates" name="training[__INDEX__][certificates]" placeholder=""></div>
        </div>
    </div>
</template>

<template id="experience-template">
    <div class="profile-entry-card profile-entry-card--teal resume-row" data-row="experience">
        <div class="profile-entry-header profile-entry-header--toolbar">
            <div class="profile-entry-kicker">Work Experience</div>
            <button type="button" class="btn btn-sm profile-remove-btn" data-remove-row><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="row g-3">
            <div class="col-12 col-lg-4"><input class="form-control profile-input" data-field="company" name="experience[__INDEX__][company]" placeholder="Company Name"></div>
            <div class="col-12 col-lg-4"><input class="form-control profile-input" data-field="title" name="experience[__INDEX__][title]" placeholder="Position/Job Title"></div>
            <div class="col-12 col-lg-3"><input class="form-control profile-input" data-field="location" name="experience[__INDEX__][location]" placeholder="Location (City)"></div>
            <div class="col-12 col-lg-1"><input class="form-control profile-input" data-field="status" name="experience[__INDEX__][status]" placeholder="Status"></div>
            <div class="col-12 col-md-6 col-lg-3"><input class="form-control profile-input" data-field="from_date" name="experience[__INDEX__][from_date]" placeholder="From Date"></div>
            <div class="col-12 col-md-6 col-lg-3"><input class="form-control profile-input" data-field="to_date" name="experience[__INDEX__][to_date]" placeholder="To Date"></div>
            <div class="col-12 col-md-6 col-lg-3"><input class="form-control profile-input" data-field="salary_amount" name="experience[__INDEX__][salary_amount]" placeholder="Salary Amount"></div>
            <div class="col-12 col-md-6 col-lg-3"><input class="form-control profile-input" data-field="salary_type" name="experience[__INDEX__][salary_type]" placeholder=""></div>
            <div class="col-12"><textarea class="form-control profile-input" rows="4" data-field="details" name="experience[__INDEX__][details]" placeholder="Reason Left / Duties"></textarea></div>
        </div>
    </div>
</template>

<template id="eligibility-template">
    <div class="profile-entry-card profile-entry-card--orange resume-row" data-row="eligibility">
        <div class="profile-entry-header profile-entry-header--toolbar">
            <div class="profile-entry-kicker">Eligibility</div>
            <button type="button" class="btn btn-sm profile-remove-btn profile-remove-btn--danger" data-remove-row><i class="bi bi-trash3 me-1"></i>Remove</button>
        </div>
        <div class="row g-3">
            <div class="col-12 col-lg-5"><input class="form-control profile-input" data-field="eligibility" name="eligibility[__INDEX__][eligibility]" placeholder="Eligibility (Civil Service)"></div>
            <div class="col-12 col-md-6 col-lg-2"><input class="form-control profile-input" data-field="date_taken" name="eligibility[__INDEX__][date_taken]" placeholder="Date Taken"></div>
            <div class="col-12 col-md-6 col-lg-5"><input class="form-control profile-input" data-field="license" name="eligibility[__INDEX__][license]" placeholder="Professional License (PRC)"></div>
            <div class="col-12 col-lg-3"><input class="form-control profile-input" data-field="valid_until" name="eligibility[__INDEX__][valid_until]" placeholder="Valid Until"></div>
        </div>
    </div>
</template>

@push('scripts')
<script>
    (function () {
        const counters = {
            education: document.querySelectorAll('#education-rows [data-row="education"]').length,
            training: document.querySelectorAll('#training-rows [data-row="training"]').length,
            experience: document.querySelectorAll('#experience-rows [data-row="experience"]').length,
            eligibility: document.querySelectorAll('#eligibility-rows [data-row="eligibility"]').length,
        };

        const permanentAddressCopyToggle = document.querySelector('[data-copy-present-address]');

        function copyPresentAddressToPermanent() {
            if (!permanentAddressCopyToggle || !permanentAddressCopyToggle.checked) {
                return;
            }

            document.querySelectorAll('[data-address-source="present"]').forEach(function (field) {
                const addressField = field.getAttribute('data-address-field');
                const target = document.querySelector('[data-address-target="' + addressField + '"]');

                if (target) {
                    target.value = field.value;
                }
            });
        }

        function addRow(type) {
            const template = document.getElementById(type + '-template');
            const container = document.getElementById(type + '-rows');

            if (!template || !container) {
                return;
            }

            const clone = template.content.cloneNode(true);
            const row = clone.querySelector('[data-row="' + type + '"]');
            const index = counters[type]++;

            row.querySelectorAll('[data-field]').forEach(function (field) {
                field.name = type + '[' + index + '][' + field.getAttribute('data-field') + ']';
                if (field.tagName === 'TEXTAREA') {
                    field.value = '';
                }
            });

            container.appendChild(clone);
        }

        document.querySelectorAll('[data-add-row]').forEach(function (button) {
            button.addEventListener('click', function () {
                addRow(button.getAttribute('data-add-row'));
            });
        });

        document.addEventListener('click', function (event) {
            if (event.target && event.target.matches('[data-remove-row]')) {
                const row = event.target.closest('[data-row]');
                if (row) {
                    row.remove();
                }
            }
        });

        if (permanentAddressCopyToggle) {
            permanentAddressCopyToggle.addEventListener('change', function () {
                copyPresentAddressToPermanent();
            });
        }

        document.querySelectorAll('[data-address-source="present"]').forEach(function (field) {
            field.addEventListener('input', function () {
                copyPresentAddressToPermanent();
            });
        });
    })();
</script>
@endpush
@endsection