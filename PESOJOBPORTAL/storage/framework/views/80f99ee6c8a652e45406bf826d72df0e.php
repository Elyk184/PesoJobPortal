<?php $__env->startSection('title', ($job->title ?? 'Job Details') . ' | PESO'); ?>
<?php $__env->startSection('page-title', 'Job Details'); ?>
<?php $__env->startSection('page-subtitle', 'View the full job post'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $currentUser = auth()->user();
    $profile = $currentUser?->profile ?? $currentUser?->userProfile;
    $hasResumeBuilderData = ! empty($profile?->resume_name) && ! empty($profile?->resume_email);
    $defaultResumeType = old('resume_type', $hasResumeBuilderData ? 'builder' : 'upload');
    if (! in_array($defaultResumeType, ['upload', 'builder'], true)) {
        $defaultResumeType = 'upload';
    }
?>
<section aria-label="Job details" class="job-detail-page">
    <style>
        .job-detail-page {
            display: grid;
            gap: 1rem;
        }

        .job-detail-card,
        .job-summary-card {
            background: #fff;
            border: 1px solid rgba(15, 45, 82, 0.08);
            border-radius: 18px;
            box-shadow: 0 12px 28px rgba(15, 45, 82, 0.06);
        }

        .job-detail-card {
            padding: 1.25rem;
        }

        .job-detail-header {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .job-title {
            margin: 0;
            font-size: clamp(1.5rem, 2vw, 2rem);
            font-weight: 900;
            color: #17365d;
            line-height: 1.15;
        }

        .job-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 0.8rem;
        }

        .job-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.45rem 0.7rem;
            border-radius: 999px;
            background: #f3f7ff;
            color: #325c91;
            border: 1px solid #d8e4f6;
            font-size: 0.85rem;
            font-weight: 700;
        }

        .job-section {
            margin-top: 1.25rem;
        }

        .job-section h3 {
            margin: 0 0 0.75rem;
            font-size: 0.92rem;
            font-weight: 900;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: #5f728b;
        }

        .job-text {
            color: #4f6178;
            line-height: 1.7;
            white-space: pre-line;
        }

        .job-summary-card {
            padding: 1rem;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            padding: 0.85rem 0.95rem;
            border-radius: 14px;
            background: #f8fbff;
            border: 1px solid #e5edf8;
            margin-bottom: 0.75rem;
        }

        .summary-label {
            color: #6d7f98;
            font-size: 0.86rem;
            font-weight: 700;
        }

        .summary-value {
            color: #17365d;
            font-weight: 800;
            text-align: right;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            color: #2f6fd5;
            text-decoration: none;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .btn {
            border-radius: 12px;
            font-weight: 800;
        }

        .job-summary-mini {
            background: #f8fbff;
            border: 1px solid #e5edf8;
            border-radius: 14px;
            padding: 1rem;
            margin-top: 1.5rem;
        }

        .job-summary-mini h4 {
            margin: 0 0 0.75rem;
            font-size: 0.92rem;
            font-weight: 900;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: #5f728b;
        }

        .mini-row {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            font-size: 0.88rem;
            border-bottom: 1px solid #e5edf8;
        }

        .mini-row:last-child {
            border-bottom: none;
        }

        .mini-label {
            color: #6d7f98;
            font-weight: 600;
        }

        .mini-value {
            color: #17365d;
            font-weight: 700;
        }

        .application-form-card {
            background: linear-gradient(135deg, #2f6fd5 0%, #1e4fa6 100%);
            border-radius: 16px;
            padding: 1.5rem;
            color: white;
            position: sticky;
            top: 2rem;
        }

        .form-section-title {
            margin: 1rem 0 0.75rem;
            font-size: 0.9rem;
            font-weight: 900;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.95);
        }

        .form-section-title:first-child {
            margin-top: 0;
        }

        .resume-options {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.55rem;
            margin-bottom: 0.85rem;
        }

        .resume-btn {
            padding: 0.65rem 0.75rem;
            border: 1.5px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-radius: 10px;
            font-size: 0.8rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            min-height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            text-decoration: none;
            width: 100%;
        }

        .resume-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
        }

        .resume-btn.active {
            background: rgba(255, 255, 255, 0.95);
            color: #2f6fd5;
            border-color: rgba(255, 255, 255, 0.95);
        }

        @media (max-width: 420px) {
            .resume-options {
                grid-template-columns: 1fr;
            }
        }

        .file-upload-wrapper {
            position: relative;
            margin-bottom: 1rem;
        }

        .file-upload-input {
            display: none;
        }

        .file-upload-label {
            display: block;
            padding: 1rem;
            border: 2px dashed rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.05);
        }

        .file-upload-label:hover {
            border-color: rgba(255, 255, 255, 0.6);
            background: rgba(255, 255, 255, 0.1);
        }

        .file-upload-label i {
            display: block;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .file-upload-label .file-text {
            display: block;
            font-size: 0.85rem;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.9);
        }

        .file-upload-label .file-size {
            display: block;
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.7);
            margin-top: 0.25rem;
        }

        .file-name-display {
            margin-top: 0.5rem;
            padding: 0.5rem;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 8px;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.9);
            word-break: break-word;
        }

        @media (min-width: 992px) {
            .job-detail-grid {
                display: grid;
                grid-template-columns: minmax(0, 1.65fr) minmax(300px, 0.85fr);
                gap: 1rem;
            }
        }
    </style>

    <a href="<?php echo e(route('jobseeker.browse-jobs')); ?>" class="back-link">
        <i class="bi bi-arrow-left"></i>
        Back to Browse Jobs
    </a>

    <div class="job-detail-grid">
        <article class="job-detail-card">
            <div class="job-detail-header">
                <div>
                    <h1 class="job-title"><?php echo e($job->title); ?></h1>
                    <div class="job-meta">
                        <span class="job-pill"><i class="bi bi-building"></i><?php echo e($job->employer_name ?? $job->employer?->name ?? 'Company'); ?></span>
                        <span class="job-pill"><i class="bi bi-geo-alt"></i><?php echo e($job->location ?? 'Location not listed'); ?></span>
                        <span class="job-pill"><i class="bi bi-clock"></i><?php echo e(ucfirst(str_replace('_', ' ', $job->job_type ?? $job->employment_type ?? 'N/A'))); ?></span>
                        <?php if($job->salary_range): ?>
                            <span class="job-pill"><i class="bi bi-cash-stack"></i><?php echo e($job->salary_range); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="text-md-end">
                    <div class="text-muted small">Posted <?php echo e($job->created_at?->diffForHumans()); ?></div>
                    <?php if($job->application_end_date): ?>
                        <div class="mt-1 fw-bold <?php echo e($job->application_end_date->isPast() ? 'text-danger' : 'text-success'); ?>">
                            <?php echo e($job->application_end_date->isPast() ? 'Expired' : 'Expires ' . $job->application_end_date->format('M d, Y')); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="job-section">
                <h3>Job Description</h3>
                <div class="job-text"><?php echo e($job->description ?? 'No description provided.'); ?></div>
            </div>

            <div class="job-section">
                <h3>Qualifications</h3>
                <div class="job-text"><?php echo e($job->qualifications ?? 'No qualifications listed.'); ?></div>
            </div>

            <?php if(! empty($job->key_responsibilities)): ?>
                <div class="job-section">
                    <h3>Key Responsibilities</h3>
                    <div class="job-text"><?php echo e($job->key_responsibilities); ?></div>
                </div>
            <?php endif; ?>

            <?php if(! empty($job->preferred_skills)): ?>
                <div class="job-section">
                    <h3>Preferred Skills</h3>
                    <div class="job-text"><?php echo e($job->preferred_skills); ?></div>
                </div>
            <?php endif; ?>

            <!-- Job Summary Mini Section -->
            <div class="job-summary-mini">
                <h4>Quick Info</h4>
                <div class="mini-row">
                    <span class="mini-label">Company</span>
                    <span class="mini-value"><?php echo e($job->employer_name ?? $job->employer?->name ?? 'Company'); ?></span>
                </div>
                <div class="mini-row">
                    <span class="mini-label">Vacancies</span>
                    <span class="mini-value"><?php echo e($job->vacancies ?? 1); ?></span>
                </div>
                <div class="mini-row">
                    <span class="mini-label">Employment Type</span>
                    <span class="mini-value"><?php echo e(ucfirst(str_replace('_', ' ', $job->job_type ?? $job->employment_type ?? 'N/A'))); ?></span>
                </div>
                <?php if($job->salary_range): ?>
                <div class="mini-row">
                    <span class="mini-label">Salary Range</span>
                    <span class="mini-value"><?php echo e($job->salary_range); ?></span>
                </div>
                <?php endif; ?>
            </div>
        </article>

        <aside>
            <!-- Application Form Card -->
            <div class="application-form-card">
                <h4 style="margin: 0 0 0.5rem; font-size: 1rem; font-weight: 900;">Apply Now</h4>
                <p style="margin: 0 0 1rem; font-size: 0.88rem; opacity: 0.9;">Submit your application and resume to get started.</p>

                <form action="<?php echo e(route('jobseeker.submit-application', $job)); ?>" method="POST" enctype="multipart/form-data" id="applicationForm">
                    <?php echo csrf_field(); ?>

                    <?php if($errors->any()): ?>
                        <div style="background: rgba(220, 53, 69, 0.2); border: 1px solid rgba(220, 53, 69, 0.4); color: #ffebee; padding: 0.75rem; border-radius: 10px; margin-bottom: 1rem; font-size: 0.85rem;">
                            <strong style="display: block; margin-bottom: 0.5rem;">⚠️ Please fix errors:</strong>
                            <ul style="margin: 0; padding-left: 1.5rem;">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <!-- Resume Section -->
                    <div class="form-section-title">📄 Your Resume</div>
                    <div class="resume-options">
                        <button type="button" class="resume-btn <?php echo e($defaultResumeType === 'upload' ? 'active' : ''); ?>" data-resume-type="upload" onclick="switchResumeType(this)">
                            <i class="bi bi-upload"></i> Upload
                        </button>

                        <?php if($hasResumeBuilderData): ?>
                            <button type="button" class="resume-btn <?php echo e($defaultResumeType === 'builder' ? 'active' : ''); ?>" data-resume-type="builder" onclick="switchResumeType(this)">
                                <i class="bi bi-file-earmark-text"></i> Use Resume Builder
                            </button>
                        <?php else: ?>
                            <a href="<?php echo e(route('jobseeker.resume-builder')); ?>" class="resume-btn">
                                <i class="bi bi-file-earmark-text"></i> Create in Builder
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- Upload Resume -->
                    <div id="uploadSection" class="file-upload-wrapper" style="<?php echo e($defaultResumeType === 'upload' ? '' : 'display:none;'); ?>">
                        <label for="resume" class="file-upload-label">
                            <i class="bi bi-cloud-arrow-up"></i>
                            <span class="file-text">Click to upload or drag & drop</span>
                            <span class="file-size">PDF, DOC, DOCX (Max 5MB)</span>
                        </label>
                        <input
                            type="file"
                            id="resume"
                            name="resume"
                            class="file-upload-input"
                            accept=".pdf,.doc,.docx"
                            <?php echo e($defaultResumeType === 'upload' ? 'required' : ''); ?>

                        >
                        <div id="fileName" class="file-name-display" style="display:none;"></div>
                    </div>

                    <!-- Hidden inputs for other resume types -->
                    <input type="hidden" id="resumeType" name="resume_type" value="<?php echo e($defaultResumeType); ?>">
                    <input type="hidden" id="resumeBuilderSelect" name="use_resume_builder" value="<?php echo e($defaultResumeType === 'builder' ? '1' : '0'); ?>">

                    <!-- Cover Letter Section -->
                    <div class="form-section-title" style="margin-top: 1.25rem;">✍️ Cover Letter / Letter of Intent</div>
                    <div class="mb-3">
                        <label for="letter" style="display: block; color: rgba(255, 255, 255, 0.9); font-weight: 700; font-size: 0.85rem; margin-bottom: 0.5rem;">Tell us why you're interested</label>
                        <textarea
                            id="letter"
                            name="letter"
                            class="form-control <?php $__errorArgs = ['letter'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            rows="4"
                            placeholder="Briefly explain your interest and why you're a great fit..."
                            style="border-radius: 10px; border: 1px solid rgba(255, 255, 255, 0.2); background: rgba(255, 255, 255, 0.95); color: #17365d; font-size: 0.9rem; resize: vertical;"
                            maxlength="2000"><?php echo e(old('letter')); ?></textarea>
                        <small style="display: block; margin-top: 0.4rem; opacity: 0.85; font-size: 0.8rem;">
                            <span id="char-count">0</span>/2000 characters
                        </small>
                        <?php $__errorArgs = ['letter'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-2" style="background: rgba(220, 53, 69, 0.2); padding: 0.5rem; border-radius: 8px; color: #ffcdd2;"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn w-100" style="background: rgba(255, 255, 255, 0.95); color: #2f6fd5; font-weight: 900; border-radius: 12px; padding: 0.85rem; margin-top: 1.25rem; transition: all 0.3s ease; border: none;">
                        <i class="bi bi-send-fill"></i> Submit Application
                    </button>
                    <p style="text-align: center; font-size: 0.75rem; opacity: 0.75; margin-top: 0.75rem;">
                        ✓ Secure submission • Your data is protected
                    </p>
                </form>
            </div>
        </aside>
    </div>
</section>

<script>
    // Character counter for cover letter
    const letterField = document.getElementById('letter');
    const charCount = document.getElementById('char-count');

    if (letterField && charCount) {
        letterField.addEventListener('input', function() {
            charCount.textContent = this.value.length;
        });
        charCount.textContent = letterField.value.length;
    }

    // Resume upload handling
    const resumeInput = document.getElementById('resume');
    const fileNameDisplay = document.getElementById('fileName');
    const fileUploadLabel = document.querySelector('.file-upload-label');

    if (resumeInput) {
        resumeInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                fileNameDisplay.textContent = '✓ ' + file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
                fileNameDisplay.style.display = 'block';
            }
        });

        // Drag and drop
        fileUploadLabel.addEventListener('dragover', (e) => {
            e.preventDefault();
            fileUploadLabel.style.background = 'rgba(255, 255, 255, 0.15)';
            fileUploadLabel.style.borderColor = 'rgba(255, 255, 255, 0.6)';
        });

        fileUploadLabel.addEventListener('dragleave', () => {
            fileUploadLabel.style.background = 'rgba(255, 255, 255, 0.05)';
            fileUploadLabel.style.borderColor = 'rgba(255, 255, 255, 0.3)';
        });

        fileUploadLabel.addEventListener('drop', (e) => {
            e.preventDefault();
            fileUploadLabel.style.background = 'rgba(255, 255, 255, 0.05)';
            fileUploadLabel.style.borderColor = 'rgba(255, 255, 255, 0.3)';
            if (e.dataTransfer.files && e.dataTransfer.files[0]) {
                resumeInput.files = e.dataTransfer.files;
                const event = new Event('change', { bubbles: true });
                resumeInput.dispatchEvent(event);
            }
        });
    }

    // Resume type switching
    function switchResumeType(button) {
        // Remove active state from all buttons
        document.querySelectorAll('.resume-btn').forEach(btn => {
            btn.classList.remove('active');
        });

        // Add active state to clicked button
        button.classList.add('active');

        const resumeType = button.getAttribute('data-resume-type');
        document.getElementById('resumeType').value = resumeType;

        const uploadSection = document.getElementById('uploadSection');
        const resumeInput = document.getElementById('resume');

        if (resumeType === 'upload') {
            uploadSection.style.display = 'block';
            document.getElementById('resumeBuilderSelect').value = '0';
            resumeInput.required = true;
        } else {
            uploadSection.style.display = 'none';
            resumeInput.value = '';
            document.getElementById('fileName').style.display = 'none';
            document.getElementById('resumeBuilderSelect').value = '0';
            resumeInput.required = false;

            if (resumeType === 'builder') {
                document.getElementById('resumeBuilderSelect').value = '1';
            }
        }
    }

    // Keep visual state in sync with selected resume type after validation errors.
    (() => {
        const selectedType = document.getElementById('resumeType').value;
        const selectedButton = document.querySelector(`.resume-btn[data-resume-type="${selectedType}"]`);
        if (selectedButton) {
            switchResumeType(selectedButton);
        }
    })();

    // Form submission validation
    document.getElementById('applicationForm').addEventListener('submit', function(e) {
        const resumeType = document.getElementById('resumeType').value;
        const resumeInput = document.getElementById('resume');

        if (resumeType === 'upload' && !resumeInput.files.length) {
            e.preventDefault();
            alert('Please upload a resume or select another resume option.');
            return false;
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views/dashboard/jobseeker/apply-job.blade.php ENDPATH**/ ?>