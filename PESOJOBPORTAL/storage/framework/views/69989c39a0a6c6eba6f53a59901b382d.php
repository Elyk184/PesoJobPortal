<?php $__env->startSection('title', 'Profile | Jobseeker'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/profile.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php
    $personalInformation = old('personal_information', $personalInformation ?? []);
    $presentAddress      = old('present_address',      $presentAddress      ?? []);
    $permanentAddress    = old('permanent_address',     $permanentAddress    ?? []);
    $educationRows       = old('education',             $educationRows       ?? []);
    $trainingRows        = old('training',              $trainingRows        ?? []);
    $experienceRows      = old('experience',            $experienceRows      ?? []);
    $eligibilityRows     = old('eligibility',           $eligibilityRows     ?? []);
    $otherSkills         = old('other_skills',          $otherSkills         ?? []);
    $employmentStatus    = old('employment_status',     $employmentStatus    ?? []);
    $jobPreferences      = old('job_preferences',       $jobPreferences      ?? []);
    $languages           = old('languages',             $languages           ?? []);
    $disability          = old('disability',            $disability          ?? []);

    // ── Normalise training rows: DB uses 'inclusive_dates' / 'skills_acquired',
    //    the form uses 'dates' / 'skills'. Map once here so the view works either way.
    $trainingRows = array_map(function ($row) {
        $row['dates']  = $row['dates']  ?? $row['inclusive_dates'] ?? '';
        $row['skills'] = $row['skills'] ?? $row['skills_acquired'] ?? '';
        return $row;
    }, $trainingRows);

    // ── Normalise language rows: DB uses 'can_read' etc., form uses 'read' etc.
    $languages = array_map(function ($row) {
        $row['read']       = $row['read']       ?? $row['can_read']       ?? false;
        $row['write']      = $row['write']      ?? $row['can_write']      ?? false;
        $row['speak']      = $row['speak']      ?? $row['can_speak']      ?? false;
        $row['understand'] = $row['understand'] ?? $row['can_understand'] ?? false;
        $row['other']      = $row['other']      ?? $row['other_specify']  ?? '';
        return $row;
    }, $languages);

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
            ['language' => 'English', 'read' => true,  'write' => true,  'speak' => true,  'understand' => true,  'other' => ''],
            ['language' => 'Tagalog', 'read' => true,  'write' => true,  'speak' => true,  'understand' => true,  'other' => ''],
            ['language' => 'Visayan', 'read' => true,  'write' => true,  'speak' => true,  'understand' => true,  'other' => ''],
            ['language' => 'Others:', 'read' => false, 'write' => false, 'speak' => false, 'understand' => false, 'other' => ''],
        ];
    }

    $skillGroups = [
        'trade_manual' => [
            'label'   => 'Trade & Manual Skills',
            'options' => ['Auto Mechanic','Beautician','Carpentry Work','Plumbing','Housekeeping','Electrician','Embroidery','Tailoring','Masonry','Painting Jobs','Gardening/Farming','Driver'],
        ],
        'it_technical' => [
            'label'   => 'IT & Technical Skills',
            'options' => ['Computer Literate','Microsoft Office','Web Development','Programming','Database','JavaScript','HTML/CSS','Git','Database Management','Frontend Development (Web UI)','API Integration & Development','Software Development & Debugging','Network Configuration & Troubleshooting','Hardware Installation & Repair','Graphic Design','React.js','Node.js','REST API','Backend Development (Server-side)','Virtual Assistance','Data Entry and Record Keeping','Filing and Documentation','Scheduling and Calendar Management','MySQL (Database)','Flutter','Docker','Laravel (Backend)'],
        ],
        'soft_skills' => [
            'label'   => 'Soft Skills',
            'options' => ['Critical Thinking','Problem-Solving','Adaptability','Time Management','Team Collaboration'],
        ],
    ];

    $otherSkillText  = data_get($otherSkills, 'other_text',       '');
    $withCertificate = data_get($otherSkills, 'with_certificate', false);
    $byExperience    = data_get($otherSkills, 'by_experience',    false);
    $workExperienceHas = old('work_experience_has', data_get($employmentStatus, 'has_work_experience', null));

    $employmentTypes = [
        'wage_employed' => 'Wage employed (Please specify)',
        'self_employed' => 'Self employed (Please specify)',
        'unemployed'    => 'Unemployed',
    ];

    $jobPreferenceOccupations = data_get($jobPreferences, 'occupation_text', '');
?>

<section class="container py-4" aria-label="Jobseeker profile">
    <style>
        .dashboard-section-card { background: #fff; border-radius: 12px; padding: 1.25rem; box-shadow: 0 6px 18px rgba(16,24,40,0.04); }
        .profile-section-header { display:flex; gap:12px; align-items:center; }
        .profile-section-icon { font-size:1.5rem; color:#667eea; width:44px; height:44px; display:inline-flex; align-items:center; justify-content:center; background:#f1f5ff; border-radius:8px; }
        .profile-section-title { margin:0; font-size:1.15rem; }
        .profile-section-kicker { font-weight:700; color:#6c757d; font-size:0.85rem; }
        .profile-input { height:44px; border-radius:8px; }
        .profile-entry-card { padding:12px; border-radius:10px; }
        .profile-save-wrap { position: sticky; bottom: 12px; display:flex; justify-content:flex-end; padding-top:8px; background:transparent; z-index:5; }
        .profile-save-btn { background: linear-gradient(90deg,#667eea,#764ba2); border:none; color:#fff; padding:10px 18px; border-radius:8px; box-shadow: 0 6px 18px rgba(102,126,234,0.12); }
        .profile-remove-btn { border-radius:6px; }
        .profile-section-rule { margin: 10px 0 14px; border-top: 1px solid rgba(0,0,0,0.04); }
        @media (max-width: 767px) { .profile-save-wrap { position: static; margin-top: 10px; } }
    </style>

    <?php if(session('status')): ?>
        <div class="alert alert-success border-0 shadow-sm"><?php echo e(session('status')); ?></div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger border-0 shadow-sm">
            <div class="fw-semibold mb-1">Please fix the highlighted problems.</div>
            <ul class="mb-0 ps-3">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('jobseeker.profile.save')); ?>" class="profile-form mt-3">
        <?php echo csrf_field(); ?>

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
                        <input class="form-control profile-input" name="personal_information[first_name]"
                            value="<?php echo e(old('personal_information.first_name', $personalInformation['first_name'] ?? '')); ?>">
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <label class="form-label fw-semibold">Middle Initial</label>
                        <input class="form-control profile-input" name="personal_information[middle_initial]" maxlength="5" placeholder="M."
                            value="<?php echo e(old('personal_information.middle_initial', $personalInformation['middle_initial'] ?? $personalInformation['middle_name'] ?? '')); ?>">
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <label class="form-label fw-semibold">Surname <span class="text-danger">*</span></label>
                        <input class="form-control profile-input" name="personal_information[surname]"
                            value="<?php echo e(old('personal_information.surname', $personalInformation['surname'] ?? '')); ?>">
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <label class="form-label fw-semibold">Suffix</label>
                        <input class="form-control profile-input" name="personal_information[suffix]" placeholder="Sr., Jr., II"
                            value="<?php echo e(old('personal_information.suffix', $personalInformation['suffix'] ?? '')); ?>">
                    </div>

                    <div class="col-12 col-md-6 col-xl-3">
                        <label class="form-label fw-semibold">Date of Birth <span class="text-danger">*</span></label>
                        <input type="date" class="form-control profile-input" name="personal_information[date_of_birth]"
                            value="<?php echo e(old('personal_information.date_of_birth', $personalInformation['date_of_birth'] ?? '')); ?>">
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <label class="form-label fw-semibold d-block">Sex</label>
                        <div class="profile-radio-stack">
                            <label class="profile-radio-item">
                                <input type="radio" name="personal_information[sex]" value="Male"
                                    <?php if(old('personal_information.sex', $personalInformation['sex'] ?? '') === 'Male'): echo 'checked'; endif; ?>> Male
                            </label>
                            <label class="profile-radio-item">
                                <input type="radio" name="personal_information[sex]" value="Female"
                                    <?php if(old('personal_information.sex', $personalInformation['sex'] ?? '') === 'Female'): echo 'checked'; endif; ?>> Female
                            </label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <label class="form-label fw-semibold">Religion</label>
                        <input class="form-control profile-input" name="personal_information[religion]"
                            value="<?php echo e(old('personal_information.religion', $personalInformation['religion'] ?? '')); ?>">
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <label class="form-label fw-semibold">Civil Status</label>
                        <input class="form-control profile-input" name="personal_information[civil_status]"
                            value="<?php echo e(old('personal_information.civil_status', $personalInformation['civil_status'] ?? '')); ?>">
                    </div>

                    <div class="col-12 col-md-6 col-xl-3">
                        <label class="form-label fw-semibold">Height <span class="text-muted">(cm)</span></label>
                        <input class="form-control profile-input" name="personal_information[height]"
                            value="<?php echo e(old('personal_information.height', $personalInformation['height'] ?? '')); ?>">
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <label class="form-label fw-semibold">TIN</label>
                        <input class="form-control profile-input" name="personal_information[tin]"
                            value="<?php echo e(old('personal_information.tin', $personalInformation['tin'] ?? '')); ?>">
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <label class="form-label fw-semibold">Contact Number/s</label>
                        <input class="form-control profile-input" name="personal_information[contact_number]"
                            value="<?php echo e(old('personal_information.contact_number', $personalInformation['contact_number'] ?? '')); ?>">
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <label class="form-label fw-semibold">Email Address</label>
                        <input type="email" class="form-control profile-input" name="personal_information[email_address]"
                            value="<?php echo e(old('personal_information.email_address', $personalInformation['email_address'] ?? '')); ?>">
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
                                    <input class="form-control profile-input" name="present_address[house_no]"
                                        data-address-source="present" data-address-field="house_no"
                                        value="<?php echo e(old('present_address.house_no', $presentAddress['house_no'] ?? '')); ?>">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Barangay</label>
                                    <input class="form-control profile-input" name="present_address[barangay]"
                                        data-address-source="present" data-address-field="barangay"
                                        value="<?php echo e(old('present_address.barangay', $presentAddress['barangay'] ?? '')); ?>">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Municipality/City</label>
                                    <input class="form-control profile-input" name="present_address[municipality]"
                                        data-address-source="present" data-address-field="municipality"
                                        value="<?php echo e(old('present_address.municipality', $presentAddress['municipality'] ?? '')); ?>">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Province</label>
                                    <input class="form-control profile-input" name="present_address[province]"
                                        data-address-source="present" data-address-field="province"
                                        value="<?php echo e(old('present_address.province', $presentAddress['province'] ?? '')); ?>">
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
                                    <input class="form-control profile-input" name="permanent_address[house_no]"
                                        data-address-target="house_no"
                                        value="<?php echo e(old('permanent_address.house_no', $permanentAddress['house_no'] ?? '')); ?>">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Barangay</label>
                                    <input class="form-control profile-input" name="permanent_address[barangay]"
                                        data-address-target="barangay"
                                        value="<?php echo e(old('permanent_address.barangay', $permanentAddress['barangay'] ?? '')); ?>">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Municipality/City</label>
                                    <input class="form-control profile-input" name="permanent_address[municipality]"
                                        data-address-target="municipality"
                                        value="<?php echo e(old('permanent_address.municipality', $permanentAddress['municipality'] ?? '')); ?>">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Province</label>
                                    <input class="form-control profile-input" name="permanent_address[province]"
                                        data-address-target="province"
                                        value="<?php echo e(old('permanent_address.province', $permanentAddress['province'] ?? '')); ?>">
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
                        <input type="checkbox" name="education_currently_in_school" value="1"
                            <?php if(old('education_currently_in_school', $personalInformation['currently_in_school'] ?? false)): echo 'checked'; endif; ?>>
                        Currently in school?
                    </label>
                    <button type="button" class="btn btn-sm btn-outline-primary" data-add-row="education">
                        <i class="bi bi-plus-lg me-1"></i>Add Education
                    </button>
                </div>

                <div class="vstack gap-3" id="education-rows">
                    <?php $__currentLoopData = $educationRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="profile-entry-card profile-entry-card--blue resume-row" data-row="education">
                            <div class="profile-entry-header">
                                <div class="profile-entry-kicker">Education <?php echo e($index + 1); ?></div>
                                <button type="button" class="btn btn-sm profile-remove-btn" data-remove-row>
                                    <i class="bi bi-trash3 me-1"></i>Remove
                                </button>
                            </div>
                            <div class="row g-2">
                                <div class="col-12 col-lg-6">
                                    <input class="form-control profile-input" data-field="school"
                                        name="education[<?php echo e($index); ?>][school]" placeholder="School / University"
                                        value="<?php echo e($row['school'] ?? ''); ?>">
                                </div>
                                <div class="col-12 col-lg-4">
                                    <input class="form-control profile-input" data-field="course"
                                        name="education[<?php echo e($index); ?>][course]" placeholder="Course / Strand"
                                        value="<?php echo e($row['course'] ?? ''); ?>">
                                </div>
                                <div class="col-12 col-lg-2">
                                    <input class="form-control profile-input" data-field="year"
                                        name="education[<?php echo e($index); ?>][year]" placeholder="Year"
                                        value="<?php echo e($row['year'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    <?php $__currentLoopData = $trainingRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="profile-entry-card profile-entry-card--blue resume-row" data-row="training">
                            <div class="profile-entry-header">
                                <div class="profile-entry-kicker">Training #<?php echo e($index + 1); ?></div>
                                <button type="button" class="btn btn-sm profile-remove-btn" data-remove-row>
                                    <i class="bi bi-trash3 me-1"></i>Remove
                                </button>
                            </div>
                            <div class="row g-3">
                                <div class="col-12 col-lg-5">
                                    <label class="form-label fw-semibold">Training/Vocational Course</label>
                                    <input class="form-control profile-input" data-field="course"
                                        name="training[<?php echo e($index); ?>][course]" value="<?php echo e($row['course'] ?? ''); ?>">
                                </div>
                                <div class="col-12 col-md-6 col-lg-2">
                                    <label class="form-label fw-semibold">Hours</label>
                                    <input class="form-control profile-input" data-field="hours"
                                        name="training[<?php echo e($index); ?>][hours]" value="<?php echo e($row['hours'] ?? ''); ?>">
                                </div>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <label class="form-label fw-semibold">Training Institution</label>
                                    <input class="form-control profile-input" data-field="institution"
                                        name="training[<?php echo e($index); ?>][institution]" value="<?php echo e($row['institution'] ?? ''); ?>">
                                </div>
                                <div class="col-12 col-lg-2">
                                    <label class="form-label fw-semibold">Inclusive Dates</label>
                                    <input class="form-control profile-input" data-field="dates"
                                        name="training[<?php echo e($index); ?>][dates]"
                                        value="<?php echo e($row['dates'] ?? ''); ?>">
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label class="form-label fw-semibold">Skills Acquired</label>
                                    <input class="form-control profile-input" data-field="skills"
                                        name="training[<?php echo e($index); ?>][skills]"
                                        value="<?php echo e($row['skills'] ?? ''); ?>">
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label class="form-label fw-semibold">Certificates (NC I, NCII, etc.)</label>
                                    <input class="form-control profile-input" data-field="certificates"
                                        name="training[<?php echo e($index); ?>][certificates]" value="<?php echo e($row['certificates'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    <label class="profile-radio-inline me-3">
                        <input type="radio" name="work_experience_has" value="1"
                            <?php if((string) $workExperienceHas === '1'): echo 'checked'; endif; ?>> Yes
                    </label>
                    <label class="profile-radio-inline">
                        <input type="radio" name="work_experience_has" value="0"
                            <?php if((string) $workExperienceHas === '0'): echo 'checked'; endif; ?>> No
                    </label>
                    <span class="text-muted ms-2">If yes, please provide more information</span>
                </div>

                <div class="d-flex justify-content-end mb-2">
                    <button type="button" class="btn btn-sm btn-outline-primary" data-add-row="experience">
                        <i class="bi bi-plus-lg me-1"></i>Add Work Experience
                    </button>
                </div>

                <div class="vstack gap-3" id="experience-rows">
                    <?php $__currentLoopData = $experienceRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="profile-entry-card profile-entry-card--teal resume-row" data-row="experience">
                            <div class="profile-entry-header profile-entry-header--toolbar">
                                <div class="profile-entry-kicker">Work Experience #<?php echo e($index + 1); ?></div>
                                <button type="button" class="btn btn-sm profile-remove-btn" data-remove-row>
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                            <div class="row g-3">
                                <div class="col-12 col-lg-4">
                                    <label class="form-label fw-semibold">Company Name <span class="text-danger">*</span></label>
                                    <input class="form-control profile-input" data-field="company"
                                        name="experience[<?php echo e($index); ?>][company]"
                                        value="<?php echo e($row['company'] ?? ''); ?>" placeholder="PixelCraft Web Services">
                                </div>
                                <div class="col-12 col-lg-4">
                                    <label class="form-label fw-semibold">Position/Job Title <span class="text-danger">*</span></label>
                                    <input class="form-control profile-input" data-field="title"
                                        name="experience[<?php echo e($index); ?>][title]"
                                        value="<?php echo e($row['title'] ?? ''); ?>" placeholder="Freelance Web Developer">
                                </div>
                                <div class="col-12 col-lg-3">
                                    <label class="form-label fw-semibold">Location (City) <span class="text-danger">*</span></label>
                                    <input class="form-control profile-input" data-field="location"
                                        name="experience[<?php echo e($index); ?>][location]"
                                        value="<?php echo e($row['location'] ?? ''); ?>" placeholder="Cagayan de Oro City">
                                </div>
                                <div class="col-12 col-lg-1">
                                    <label class="form-label fw-semibold">Status</label>
                                    <input class="form-control profile-input" data-field="status"
                                        name="experience[<?php echo e($index); ?>][status]"
                                        value="<?php echo e($row['status'] ?? ''); ?>" placeholder="Yes">
                                </div>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <label class="form-label fw-semibold">From Date</label>
                                    <input class="form-control profile-input" data-field="from_date"
                                        name="experience[<?php echo e($index); ?>][from_date]"
                                        value="<?php echo e($row['from_date'] ?? ''); ?>" placeholder="June 2024">
                                </div>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <label class="form-label fw-semibold">To Date</label>
                                    <input class="form-control profile-input" data-field="to_date"
                                        name="experience[<?php echo e($index); ?>][to_date]"
                                        value="<?php echo e($row['to_date'] ?? ''); ?>" placeholder="September 2024">
                                </div>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <label class="form-label fw-semibold">Salary Amount</label>
                                    <input class="form-control profile-input" data-field="salary_amount"
                                        name="experience[<?php echo e($index); ?>][salary_amount]"
                                        value="<?php echo e($row['salary_amount'] ?? ''); ?>" placeholder="15000">
                                </div>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <label class="form-label fw-semibold">Salary Type</label>
                                    <input class="form-control profile-input" data-field="salary_type"
                                        name="experience[<?php echo e($index); ?>][salary_type]"
                                        value="<?php echo e($row['salary_type'] ?? ''); ?>" placeholder="Monthly">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Reason Left / Duties</label>
                                    <textarea class="form-control profile-input" rows="4" data-field="details"
                                        name="experience[<?php echo e($index); ?>][details]"><?php echo e($row['details'] ?? ''); ?></textarea>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    <?php $__currentLoopData = $eligibilityRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="profile-entry-card profile-entry-card--orange resume-row" data-row="eligibility">
                            <div class="profile-entry-header profile-entry-header--toolbar">
                                <div class="profile-entry-kicker">Eligibility #<?php echo e($index + 1); ?></div>
                                <button type="button" class="btn btn-sm profile-remove-btn profile-remove-btn--danger" data-remove-row>
                                    <i class="bi bi-trash3 me-1"></i>Remove
                                </button>
                            </div>
                            <div class="row g-3">
                                <div class="col-12 col-lg-5">
                                    <label class="form-label fw-semibold">Eligibility (Civil Service)</label>
                                    <input class="form-control profile-input" data-field="eligibility"
                                        name="eligibility[<?php echo e($index); ?>][eligibility]"
                                        value="<?php echo e($row['eligibility'] ?? ''); ?>">
                                </div>
                                <div class="col-12 col-md-6 col-lg-2">
                                    <label class="form-label fw-semibold">Date Taken</label>
                                    <input class="form-control profile-input" data-field="date_taken"
                                        name="eligibility[<?php echo e($index); ?>][date_taken]"
                                        value="<?php echo e($row['date_taken'] ?? ''); ?>">
                                </div>
                                <div class="col-12 col-md-6 col-lg-5">
                                    <label class="form-label fw-semibold">Professional License (PRC)</label>
                                    <input class="form-control profile-input" data-field="license"
                                        name="eligibility[<?php echo e($index); ?>][license]"
                                        value="<?php echo e($row['license'] ?? ''); ?>">
                                </div>
                                <div class="col-12 col-lg-3">
                                    <label class="form-label fw-semibold">Valid Until</label>
                                    <input class="form-control profile-input" data-field="valid_until"
                                        name="eligibility[<?php echo e($index); ?>][valid_until]"
                                        value="<?php echo e($row['valid_until'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

                <?php $__currentLoopData = $skillGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $selectedSkills = data_get($otherSkills, $key, []); ?>
                    <div class="profile-skill-group mb-3">
                        <div class="profile-skill-group-title"><?php echo e($group['label']); ?></div>
                        <div class="profile-skill-grid">
                            <?php $__currentLoopData = $group['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label class="profile-check-tile">
                                    <input type="checkbox" name="other_skills[<?php echo e($key); ?>][]"
                                        value="<?php echo e($option); ?>"
                                        <?php if(in_array($option, (array) $selectedSkills, true)): echo 'checked'; endif; ?>>
                                    <span><?php echo e($option); ?></span>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <div class="profile-skill-group pt-3 border-top">
                    <label class="profile-check-tile profile-check-tile--full mb-3">
                        <input type="checkbox" name="other_skills[other_enabled]" value="1"
                            <?php if((bool) data_get($otherSkills, 'other_enabled', false)): echo 'checked'; endif; ?>>
                        <span><strong>Others (please specify):</strong></span>
                    </label>
                    <input class="form-control profile-input" name="other_skills[other_text]"
                        value="<?php echo e($otherSkillText); ?>" placeholder="Specify">
                    <div class="row g-3 mt-1">
                        <div class="col-12 col-md-6">
                            <div class="profile-inline-choice">
                                <span class="fw-semibold">With Certificate</span>
                                <label class="profile-radio-inline">
                                    <input type="radio" name="other_skills[with_certificate]" value="1"
                                        <?php if((string) $withCertificate === '1'): echo 'checked'; endif; ?>> Yes
                                </label>
                                <label class="profile-radio-inline">
                                    <input type="radio" name="other_skills[with_certificate]" value="0"
                                        <?php if((string) $withCertificate === '0'): echo 'checked'; endif; ?>> No
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="profile-inline-choice">
                                <span class="fw-semibold">By Experience</span>
                                <label class="profile-radio-inline">
                                    <input type="radio" name="other_skills[by_experience]" value="1"
                                        <?php if((string) $byExperience === '1'): echo 'checked'; endif; ?>> Yes
                                </label>
                                <label class="profile-radio-inline">
                                    <input type="radio" name="other_skills[by_experience]" value="0"
                                        <?php if((string) $byExperience === '0'): echo 'checked'; endif; ?>> No
                                </label>
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
                        <?php $__currentLoopData = $employmentTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($key !== 'unemployed'): ?>
                                <label class="profile-check-tile profile-check-tile--stacked">
                                    <input type="checkbox" name="employment_status[<?php echo e($key); ?>]" value="1"
                                        <?php if((bool) data_get($employmentStatus, $key, false)): echo 'checked'; endif; ?>>
                                    <span><?php echo e($label); ?></span>
                                </label>
                                <input type="text" class="form-control profile-input ms-4 mb-3"
                                    name="employment_status[<?php echo e($key); ?>_specify]"
                                    value="<?php echo e(old('employment_status.' . $key . '_specify', data_get($employmentStatus, $key . '_specify', ''))); ?>"
                                    placeholder="Please specify">
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="profile-block-heading">Unemployed</div>
                        <label class="profile-check-tile profile-check-tile--stacked">
                            <input type="checkbox" name="employment_status[unemployed]" value="1"
                                <?php if((bool) data_get($employmentStatus, 'unemployed', false)): echo 'checked'; endif; ?>>
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
                        <label class="profile-check-tile profile-check-tile--stacked">
                            <input type="checkbox" name="job_preferences[part_time]" value="1"
                                <?php if((bool) data_get($jobPreferences, 'part_time', false)): echo 'checked'; endif; ?>>
                            <span>Part-time</span>
                        </label>
                        <label class="profile-check-tile profile-check-tile--stacked">
                            <input type="checkbox" name="job_preferences[full_time]" value="1"
                                <?php if((bool) data_get($jobPreferences, 'full_time', false)): echo 'checked'; endif; ?>>
                            <span>Full-time</span>
                        </label>
                        <textarea class="form-control profile-input profile-notes mt-3"
                            name="job_preferences[occupation_text]" rows="4"
                            placeholder="List preferred occupations"><?php echo e($jobPreferenceOccupations); ?></textarea>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="profile-block-heading">Preferred Work Location</div>
                        <label class="profile-check-tile profile-check-tile--stacked">
                            <input type="checkbox" name="job_preferences[local]" value="1"
                                <?php if((bool) data_get($jobPreferences, 'local', false)): echo 'checked'; endif; ?>>
                            <span>Local (specify cities/municipalities)</span>
                        </label>
                        <label class="profile-check-tile profile-check-tile--stacked">
                            <input type="checkbox" name="job_preferences[overseas]" value="1"
                                <?php if((bool) data_get($jobPreferences, 'overseas', false)): echo 'checked'; endif; ?>>
                            <span>Overseas (specify countries)</span>
                        </label>
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

                    <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="profile-language-row">
                            <div class="profile-language-name">
                                <input type="text" class="form-control profile-input profile-language-other mb-2"
                                    name="languages[<?php echo e($index); ?>][language]"
                                    value="<?php echo e($row['language'] ?? ''); ?>" placeholder="Language/Dialect">
                                <?php if(($row['language'] ?? '') === 'Others:'): ?>
                                    <input type="text" class="form-control profile-input"
                                        name="languages[<?php echo e($index); ?>][other]"
                                        value="<?php echo e($row['other'] ?? ''); ?>" placeholder="Specify">
                                <?php endif; ?>
                            </div>
                            <label class="profile-language-check">
                                <input type="checkbox" name="languages[<?php echo e($index); ?>][read]" value="1"
                                    <?php if((bool) ($row['read'] ?? false)): echo 'checked'; endif; ?>>
                            </label>
                            <label class="profile-language-check">
                                <input type="checkbox" name="languages[<?php echo e($index); ?>][write]" value="1"
                                    <?php if((bool) ($row['write'] ?? false)): echo 'checked'; endif; ?>>
                            </label>
                            <label class="profile-language-check">
                                <input type="checkbox" name="languages[<?php echo e($index); ?>][speak]" value="1"
                                    <?php if((bool) ($row['speak'] ?? false)): echo 'checked'; endif; ?>>
                            </label>
                            <label class="profile-language-check">
                                <input type="checkbox" name="languages[<?php echo e($index); ?>][understand]" value="1"
                                    <?php if((bool) ($row['understand'] ?? false)): echo 'checked'; endif; ?>>
                            </label>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    <label class="profile-check-tile profile-check-tile--stacked">
                        <input type="checkbox" name="disability[visual]" value="1"
                            <?php if((bool) data_get($disability, 'visual', false)): echo 'checked'; endif; ?>>
                        <span>Visual</span>
                    </label>
                    <label class="profile-check-tile profile-check-tile--stacked">
                        <input type="checkbox" name="disability[speech]" value="1"
                            <?php if((bool) data_get($disability, 'speech', false)): echo 'checked'; endif; ?>>
                        <span>Speech</span>
                    </label>
                    <label class="profile-check-tile profile-check-tile--stacked">
                        <input type="checkbox" name="disability[mental]" value="1"
                            <?php if((bool) data_get($disability, 'mental', false)): echo 'checked'; endif; ?>>
                        <span>Mental</span>
                    </label>
                    <label class="profile-check-tile profile-check-tile--stacked">
                        <input type="checkbox" name="disability[hearing]" value="1"
                            <?php if((bool) data_get($disability, 'hearing', false)): echo 'checked'; endif; ?>>
                        <span>Hearing</span>
                    </label>
                    <label class="profile-check-tile profile-check-tile--stacked">
                        <input type="checkbox" name="disability[physical]" value="1"
                            <?php if((bool) data_get($disability, 'physical', false)): echo 'checked'; endif; ?>>
                        <span>Physical</span>
                    </label>
                    <label class="profile-check-tile profile-check-tile--stacked">
                        <input type="checkbox" name="disability[other]" value="1"
                            <?php if((bool) data_get($disability, 'other', false)): echo 'checked'; endif; ?>>
                        <span>Others (please specify)</span>
                    </label>
                    <div class="col-12">
                        <input class="form-control profile-input" name="disability[other_text]"
                            value="<?php echo e(data_get($disability, 'other_text', '')); ?>" placeholder="Specify">
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
            <button type="button" class="btn btn-sm profile-remove-btn" data-remove-row>
                <i class="bi bi-trash3 me-1"></i>Remove
            </button>
        </div>
        <div class="row g-2">
            <div class="col-12 col-lg-6"><input class="form-control profile-input" data-field="school" name="education[__INDEX__][school]" placeholder="School / University"></div>
            <div class="col-12 col-lg-4"><input class="form-control profile-input" data-field="course" name="education[__INDEX__][course]" placeholder="Course / Strand"></div>
            <div class="col-12 col-lg-2"><input class="form-control profile-input" data-field="year"   name="education[__INDEX__][year]"   placeholder="Year"></div>
        </div>
    </div>
</template>

<template id="training-template">
    <div class="profile-entry-card profile-entry-card--blue resume-row" data-row="training">
        <div class="profile-entry-header">
            <div class="profile-entry-kicker">Training</div>
            <button type="button" class="btn btn-sm profile-remove-btn" data-remove-row>
                <i class="bi bi-trash3 me-1"></i>Remove
            </button>
        </div>
        <div class="row g-3">
            <div class="col-12 col-lg-5"><input class="form-control profile-input" data-field="course"        name="training[__INDEX__][course]"       placeholder="Training/Vocational Course"></div>
            <div class="col-12 col-md-6 col-lg-2"><input class="form-control profile-input" data-field="hours" name="training[__INDEX__][hours]"        placeholder="Hours"></div>
            <div class="col-12 col-md-6 col-lg-3"><input class="form-control profile-input" data-field="institution" name="training[__INDEX__][institution]" placeholder="Training Institution"></div>
            <div class="col-12 col-lg-2"><input class="form-control profile-input" data-field="dates"        name="training[__INDEX__][dates]"         placeholder="Inclusive Dates"></div>
            <div class="col-12 col-lg-6"><input class="form-control profile-input" data-field="skills"       name="training[__INDEX__][skills]"        placeholder="Skills Acquired"></div>
            <div class="col-12 col-lg-6"><input class="form-control profile-input" data-field="certificates" name="training[__INDEX__][certificates]"  placeholder="Certificates (NC I, NCII, etc.)"></div>
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
            <div class="col-12 col-lg-4"><input class="form-control profile-input" data-field="company"       name="experience[__INDEX__][company]"       placeholder="Company Name"></div>
            <div class="col-12 col-lg-4"><input class="form-control profile-input" data-field="title"         name="experience[__INDEX__][title]"         placeholder="Position/Job Title"></div>
            <div class="col-12 col-lg-3"><input class="form-control profile-input" data-field="location"      name="experience[__INDEX__][location]"      placeholder="Location (City)"></div>
            <div class="col-12 col-lg-1"><input class="form-control profile-input" data-field="status"        name="experience[__INDEX__][status]"        placeholder="Status"></div>
            <div class="col-12 col-md-6 col-lg-3"><input class="form-control profile-input" data-field="from_date"     name="experience[__INDEX__][from_date]"     placeholder="From Date"></div>
            <div class="col-12 col-md-6 col-lg-3"><input class="form-control profile-input" data-field="to_date"       name="experience[__INDEX__][to_date]"       placeholder="To Date"></div>
            <div class="col-12 col-md-6 col-lg-3"><input class="form-control profile-input" data-field="salary_amount" name="experience[__INDEX__][salary_amount]" placeholder="Salary Amount"></div>
            <div class="col-12 col-md-6 col-lg-3"><input class="form-control profile-input" data-field="salary_type"   name="experience[__INDEX__][salary_type]"   placeholder="Monthly"></div>
            <div class="col-12"><textarea class="form-control profile-input" rows="4" data-field="details" name="experience[__INDEX__][details]" placeholder="Reason Left / Duties"></textarea></div>
        </div>
    </div>
</template>

<template id="eligibility-template">
    <div class="profile-entry-card profile-entry-card--orange resume-row" data-row="eligibility">
        <div class="profile-entry-header profile-entry-header--toolbar">
            <div class="profile-entry-kicker">Eligibility</div>
            <button type="button" class="btn btn-sm profile-remove-btn profile-remove-btn--danger" data-remove-row>
                <i class="bi bi-trash3 me-1"></i>Remove
            </button>
        </div>
        <div class="row g-3">
            <div class="col-12 col-lg-5"><input class="form-control profile-input" data-field="eligibility" name="eligibility[__INDEX__][eligibility]" placeholder="Eligibility (Civil Service)"></div>
            <div class="col-12 col-md-6 col-lg-2"><input class="form-control profile-input" data-field="date_taken"  name="eligibility[__INDEX__][date_taken]"  placeholder="Date Taken"></div>
            <div class="col-12 col-md-6 col-lg-5"><input class="form-control profile-input" data-field="license"     name="eligibility[__INDEX__][license]"     placeholder="Professional License (PRC)"></div>
            <div class="col-12 col-lg-3"><input class="form-control profile-input" data-field="valid_until" name="eligibility[__INDEX__][valid_until]" placeholder="Valid Until"></div>
        </div>
    </div>
</template>

<?php $__env->startPush('scripts'); ?>
<script>
(function () {
    const counters = {
        education:   document.querySelectorAll('#education-rows [data-row="education"]').length,
        training:    document.querySelectorAll('#training-rows [data-row="training"]').length,
        experience:  document.querySelectorAll('#experience-rows [data-row="experience"]').length,
        eligibility: document.querySelectorAll('#eligibility-rows [data-row="eligibility"]').length,
    };

    const permanentAddressCopyToggle = document.querySelector('[data-copy-present-address]');

    function copyPresentAddressToPermanent() {
        if (!permanentAddressCopyToggle || !permanentAddressCopyToggle.checked) return;
        document.querySelectorAll('[data-address-source="present"]').forEach(function (field) {
            const target = document.querySelector('[data-address-target="' + field.getAttribute('data-address-field') + '"]');
            if (target) target.value = field.value;
        });
    }

    function addRow(type) {
        const template  = document.getElementById(type + '-template');
        const container = document.getElementById(type + '-rows');
        if (!template || !container) return;

        const clone = template.content.cloneNode(true);
        const row   = clone.querySelector('[data-row="' + type + '"]');
        const index = counters[type]++;

        row.querySelectorAll('[data-field]').forEach(function (field) {
            field.name = type + '[' + index + '][' + field.getAttribute('data-field') + ']';
            if (field.tagName === 'TEXTAREA') field.value = '';
        });

        container.appendChild(clone);
    }

    document.querySelectorAll('[data-add-row]').forEach(function (btn) {
        btn.addEventListener('click', function () { addRow(btn.getAttribute('data-add-row')); });
    });

    document.addEventListener('click', function (e) {
        if (e.target && e.target.closest('[data-remove-row]')) {
            const row = e.target.closest('[data-row]');
            if (row) row.remove();
        }
    });

    if (permanentAddressCopyToggle) {
        permanentAddressCopyToggle.addEventListener('change', copyPresentAddressToPermanent);
    }

    document.querySelectorAll('[data-address-source="present"]').forEach(function (field) {
        field.addEventListener('input', copyPresentAddressToPermanent);
    });
})();
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\63965\PesoJobPortal\PESOJOBPORTAL\resources\views/jobseeker/profile.blade.php ENDPATH**/ ?>