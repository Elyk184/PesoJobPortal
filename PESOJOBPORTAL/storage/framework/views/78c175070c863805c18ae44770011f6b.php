<?php $__env->startSection('title', 'Skill Gap Analysis | Jobseeker'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap');

    .jobseeker-dashboard {
        font-family: 'Poppins', 'Segoe UI', sans-serif;
    }

    .skill-gap-page {
        --skill-blue-900: #1e3a8a;
        --skill-blue-800: #1e40af;
        --skill-blue-500: #3b82f6;
        --skill-blue-300: #93c5fd;
        --skill-blue-200: #bfdbfe;
        color: #1e2b3a;
    }

    .skillgap-hero {
        position: relative;
        overflow: hidden;
        border-radius: 18px;
        border: 1px solid #d8e4f5;
        background: linear-gradient(135deg, #ffffff 0%, #f7fbff 48%, #edf4ff 100%);
        color: #0a3764;
        padding: 1.5rem;
        box-shadow: 0 20px 40px rgba(17, 30, 52, 0.12);
        margin-bottom: 2.5rem;
        animation: fadeInUp 0.6s ease-out;
    }

    .skillgap-hero::before {
        content: '';
        position: absolute;
        inset: 0 auto auto 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--skill-blue-900) 0%, var(--skill-blue-800) 58%, var(--skill-blue-300) 100%);
    }

    .skillgap-kicker {
        font-size: 0.72rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #2d65b1;
        margin-bottom: 0.35rem;
        font-weight: 700;
    }

    .skillgap-title {
        font-size: clamp(1.25rem, 2.2vw, 1.75rem);
        line-height: 1.2;
        font-weight: 800;
        margin-bottom: 0.35rem;
        color: #0a3764;
    }

    .skillgap-subtitle {
        color: #60758e;
        margin-bottom: 0;
    }

    .skillgap-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        border-radius: 999px;
        padding: 0.36rem 0.7rem;
        background: #ffffff;
        border: 1px solid #cfe0f5;
        color: #1e40af;
        font-size: 0.8rem;
        font-weight: 600;
        box-shadow: 0 6px 16px rgba(30, 58, 138, 0.08);
    }

    .skillgap-cta {
        border-radius: 999px;
        background: #ffffff;
        color: #183f73;
        border: 1px solid #cfe0f5;
        font-weight: 700;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .skillgap-cta:hover {
        background: #eff6ff;
        color: #102f59;
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(30, 64, 175, 0.2);
    }

    .skillgap-cta:active {
        transform: translateY(0);
    }

    .skillgap-metric {
        border: 1px solid #d8e4f5;
        border-radius: 14px;
        background: linear-gradient(180deg, #ffffff 0%, #f7fbff 100%);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        min-height: 102px;
        display: flex;
        align-items: center;
    }

    .skillgap-metric:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 35px rgba(20, 49, 86, 0.15);
        border-color: #b3d4fc;
    }

    .skill-badge {
        font-size: 0.8rem;
        padding: 8px 12px;
    }

    .skill-badge-current {
        background-color: #edf4ff !important;
        color: #1e40af !important;
        border: 1px solid #cddff7;
    }

    .skill-badge-missing {
        background-color: #f8fbff !important;
        color: #2563eb !important;
        border: 1px solid #dbeafe;
    }

    .skill-badge-matched {
        background-color: #eff6ff !important;
        color: #1e40af !important;
        border: 1px solid #bfdbfe;
    }

    .skillgap-panel {
        border: 1px solid #d8e4f5;
        border-radius: 18px;
        background: #ffffff;
        box-shadow: 0 10px 24px rgba(17, 30, 52, 0.06);
    }

    .skillgap-panel-header {
        border-bottom: 1px solid #e3ebf5;
        padding-bottom: 0.9rem;
        margin-bottom: 1rem;
    }

    .skillgap-progress-shell {
        border: 1px solid #d8e4f5;
        border-radius: 16px;
        background: linear-gradient(135deg, #f8fbff 0%, #eef4ff 100%);
    }

    .skillgap-stat-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 999px;
        padding: 0.35rem 0.7rem;
        font-size: 0.76rem;
        font-weight: 700;
        border: 1px solid #cfe0f5;
        background: #ffffff;
        color: #1e40af;
    }

    .skillgap-chip-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        max-height: 200px;
        overflow-y: auto;
        padding: 0.25rem 0;
        scrollbar-width: thin;
        scrollbar-color: rgba(96, 117, 142, 0.3) transparent;
    }

    .skillgap-chip-grid::-webkit-scrollbar {
        width: 6px;
    }

    .skillgap-chip-grid::-webkit-scrollbar-thumb {
        background: rgba(96, 117, 142, 0.3);
        border-radius: 3px;
    }

    @media (max-width: 576px) {
        .skillgap-chip-grid {
            gap: 0.5rem;
        }
    }

    .skillgap-analytics-shell {
        border: 1px solid #d8e4f5;
        border-radius: 18px;
        background: linear-gradient(135deg, #ffffff 0%, #f7fbff 48%, #edf4ff 100%);
        box-shadow: 0 12px 28px rgba(17, 30, 52, 0.07);
    }

    .skillgap-analytics-head {
        border-bottom: 1px solid #e3ebf5;
        padding-bottom: 0.9rem;
        margin-bottom: 1rem;
    }

    .skillgap-analytics-title {
        font-size: 1rem;
        font-weight: 800;
        color: #0a3764;
        margin-bottom: 0.15rem;
    }

    .skillgap-analytics-subtitle {
        font-size: 0.82rem;
        color: #60758e;
        margin-bottom: 0;
    }

    .skillgap-summary-card {
        border: 1px solid #d8e4f5;
        border-radius: 16px;
        background: linear-gradient(180deg, #ffffff 0%, #f7fbff 100%);
        box-shadow: 0 8px 18px rgba(17, 30, 52, 0.05);
        height: 100%;
    }

    .skillgap-summary-label {
        font-size: 0.78rem;
        font-weight: 800;
        color: #2d65b1;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-bottom: 0.35rem;
    }

    .skillgap-summary-value {
        font-size: 1.15rem;
        font-weight: 800;
        color: #0a3764;
        line-height: 1.2;
        margin-bottom: 0.35rem;
    }

    .skillgap-summary-text {
        font-size: 0.9rem;
        color: #60758e;
        margin-bottom: 0;
    }

    .skillgap-next-step-list {
        list-style: none;
        padding-left: 0;
        margin-bottom: 0;
        display: grid;
        gap: 0.75rem;
    }

    .skillgap-next-step-item {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.8rem 0.9rem;
        border-radius: 14px;
        background: #f8fbff;
        border: 1px solid #e3ebf5;
    }

    .skillgap-next-step-icon {
        width: 30px;
        height: 30px;
        border-radius: 999px;
        display: grid;
        place-items: center;
        flex: 0 0 auto;
        background: #eaf2ff;
        color: #1e40af;
    }

    .skillgap-next-step-title {
        font-weight: 700;
        color: #0a3764;
        margin-bottom: 0.1rem;
    }

    .skillgap-next-step-text {
        font-size: 0.88rem;
        color: #60758e;
        margin-bottom: 0;
    }

    .skillgap-analytics-track {
        height: 12px;
        border-radius: 999px;
        overflow: hidden;
        background: #e8eef6;
        display: flex;
    }

    .skillgap-analytics-fill.matched {
        background: linear-gradient(90deg, #1e3a8a 0%, #3b82f6 100%);
    }

    .skillgap-analytics-fill.missing {
        background: linear-gradient(90deg, #06b6d4 0%, #22d3ee 100%);
    }

    .skillgap-analytics-fill.market {
        background: linear-gradient(90deg, #dbeafe 0%, #bfdbfe 100%);
    }

    .skillgap-analytics-insight {
        border: 1px solid #d8e4f5;
        border-radius: 16px;
        background: #ffffff;
        padding: 14px;
        height: 100%;
        box-shadow: 0 8px 18px rgba(17, 30, 52, 0.05);
    }

    .skillgap-analytics-insight-title {
        font-size: 0.82rem;
        font-weight: 800;
        color: #2d65b1;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-bottom: 0.35rem;
    }

    .skillgap-analytics-insight-value {
        font-size: 1.1rem;
        font-weight: 800;
        color: #0a3764;
        line-height: 1.2;
    }

    .skillgap-analytics-insight-text {
        font-size: 0.84rem;
        color: #60758e;
        margin-bottom: 0;
    }

    @media (max-width: 767.98px) {
        .skillgap-hero {
            padding: 1.25rem;
        }

        .skillgap-panel {
            border-radius: 16px;
        }
    }

    @media (max-width: 576px) {
        .skillgap-analytics-shell,
        .skillgap-panel,
        .skillgap-progress-shell {
            margin-left: -1rem;
            margin-right: -1rem;
        }

        .skillgap-chart-container {
            justify-content: center;
        }
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fadeInUp 0.6s ease-out;
    }

    .animated-progress {
        transition: width 1.8s cubic-bezier(0.25, 0.46, 0.45, 0.94) !important;
    }

    /* Focus states */
    .skillgap-cta:focus-visible {
        outline: 2px solid #3b82f6;
        outline-offset: 2px;
    }

    .skillgap-metric:focus-within {
        outline: 2px solid #3b82f6;
        outline-offset: 2px;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<section class="skill-gap-page" aria-label="Skill gap analysis">


    <!-- Hero Section (unchanged) -->
    <div class="skillgap-hero mb-4">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 position-relative">
            <div>
                <div class="skillgap-kicker">Career Intelligence</div>
                <h1 class="skillgap-title">Skill Gap Analysis</h1>
                <p class="skillgap-subtitle">Compare your skills with market demand and prioritize what to learn next.</p>
            </div>
            <div class="d-flex flex-wrap align-items-center justify-content-lg-end gap-2">
                <span class="skillgap-chip"><i class="bi bi-person"></i><?php echo e(auth()->user()->name ?? 'Jobseeker'); ?></span>
                <a href="<?php echo e(route('jobseeker.profile')); ?>" class="btn skillgap-cta px-3 shadow-sm">
                    <i class="bi bi-person-gear me-2"></i>Update Profile Skills
                </a>
            </div>
        </div>
    </div>

    <?php if(($skillGapAnalysis['hasData'] ?? false) && ($skillGapAnalysis['totalMarketSkills'] ?? 0) > 0): ?>
        <?php
            $coveragePercent = (int) ($skillGapAnalysis['coveragePercent'] ?? 0);
            $matchedCount = count($skillGapAnalysis['matchedSkills'] ?? []);
            $missingCount = count($skillGapAnalysis['missingSkills'] ?? []);
            $marketSkillsCount = (int) ($skillGapAnalysis['totalMarketSkills'] ?? 0);
            $unmatchedRate = max(0, 100 - $coveragePercent);
            $matchedShare = $matchedCount + $missingCount > 0 ? ($matchedCount / max(1, $matchedCount + $missingCount)) * 100 : 0;
            $missingShare = $matchedCount + $missingCount > 0 ? ($missingCount / max(1, $matchedCount + $missingCount)) * 100 : 0;
            $topMissingSkill = collect($skillGapAnalysis['missingSkills'] ?? [])->first();
            $topMatchedSkill = collect($skillGapAnalysis['matchedSkills'] ?? [])->first();
        ?>

        <div class="skillgap-analytics-shell p-4 mb-5 animate-fade-in" style="animation-delay: 0.1s;">
            <div class="skillgap-analytics-head pb-4 mb-4 border-bottom" style="border-color: #e3ebf5 !important;">
                <div>
                    <div class="skillgap-analytics-title"><i class="bi bi-list-check me-2"></i>Simple Skill Summary</div>
                    <p class="skillgap-analytics-subtitle">A plain-language summary of what matches, what is missing, and what to do next.</p>
                </div>
                <span class="skillgap-stat-pill">Updated from active postings</span>
            </div>

            <?php
                $savedMatched = (int) data_get($savedJobsGap, 'matched_skills_unique_count', 0);
                $savedMissing = is_array(data_get($savedJobsGap, 'missing_skills'))
                    ? count((array) data_get($savedJobsGap, 'missing_skills'))
                    : 0;

                $projectionLearn = $missingCount > 0 ? max(1, (int) ceil($missingCount * 0.25)) : 0;
                $goalMatched = min($matchedCount + $projectionLearn, $marketSkillsCount);
                $goalMissing = max(0, $missingCount - $projectionLearn);
                $topMissingSkills = array_slice($skillGapAnalysis['missingSkills'] ?? [], 0, 3);
            ?>

            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <div class="skillgap-summary-card p-3 h-100">
                        <div class="skillgap-summary-label">Current coverage</div>
                        <div class="skillgap-summary-value"><?php echo e($coveragePercent); ?>% of in-demand skills</div>
                        <p class="skillgap-summary-text mb-0">You match <?php echo e($matchedCount); ?> out of <?php echo e($matchedCount + $missingCount); ?> skills we found in active job posts.</p>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="skillgap-summary-card p-3 h-100">
                        <div class="skillgap-summary-label">Best fit now</div>
                        <div class="skillgap-summary-value"><?php echo e($topMatchedSkill ? ucwords($topMatchedSkill) : 'No clear match yet'); ?></div>
                        <p class="skillgap-summary-text mb-0"><?php echo e($topMatchedSkill ? 'This is one of the strongest signals in your profile.' : 'Add more skills to highlight your strongest matches.'); ?></p>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="skillgap-summary-card p-3 h-100">
                        <div class="skillgap-summary-label">Next skill to learn</div>
                        <div class="skillgap-summary-value"><?php echo e($topMissingSkill ? ucwords($topMissingSkill) : 'Keep your profile updated'); ?></div>
                        <p class="skillgap-summary-text mb-0"><?php echo e($topMissingSkill ? 'Start with this skill to improve your job match rate.' : 'Your current profile already aligns well with the market.'); ?></p>
                    </div>
                </div>
            </div>

            <div class="row g-3 mt-1">
                <div class="col-12 col-lg-7">
                    <div class="skillgap-summary-card p-3 p-lg-4 h-100">
                        <div class="skillgap-summary-label mb-2">What this means</div>
                        <ul class="skillgap-next-step-list">
                            <li class="skillgap-next-step-item">
                                <span class="skillgap-next-step-icon"><i class="bi bi-check2"></i></span>
                                <div>
                                    <div class="skillgap-next-step-title">Skills already matching</div>
                                    <p class="skillgap-next-step-text"><?php echo e($matchedCount); ?> skill<?php echo e($matchedCount === 1 ? '' : 's'); ?> already line up with active job postings.</p>
                                </div>
                            </li>
                            <li class="skillgap-next-step-item">
                                <span class="skillgap-next-step-icon"><i class="bi bi-lightbulb"></i></span>
                                <div>
                                    <div class="skillgap-next-step-title">Skills to improve</div>
                                    <p class="skillgap-next-step-text">Learning <?php echo e($projectionLearn); ?> more relevant skill<?php echo e($projectionLearn === 1 ? '' : 's'); ?> could move your profile closer to the market.</p>
                                </div>
                            </li>
                            <li class="skillgap-next-step-item">
                                <span class="skillgap-next-step-icon"><i class="bi bi-flag"></i></span>
                                <div>
                                    <div class="skillgap-next-step-title">Saved jobs reference</div>
                                    <p class="skillgap-next-step-text"><?php echo e($savedMatched); ?> matched skills and <?php echo e($savedMissing); ?> missing skills were found from your saved jobs.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-lg-5">
                    <div class="skillgap-summary-card p-3 p-lg-4 h-100">
                        <div class="skillgap-summary-label mb-2">Easy next steps</div>
                        <ul class="skillgap-next-step-list">
                            <li class="skillgap-next-step-item">
                                <span class="skillgap-next-step-icon"><i class="bi bi-person-gear"></i></span>
                                <div>
                                    <div class="skillgap-next-step-title">Update your profile</div>
                                    <p class="skillgap-next-step-text">Add more skills to your profile so the system can find better matches.</p>
                                </div>
                            </li>
                            <li class="skillgap-next-step-item">
                                <span class="skillgap-next-step-icon"><i class="bi bi-book"></i></span>
                                <div>
                                    <div class="skillgap-next-step-title">Focus on one missing skill</div>
                                    <p class="skillgap-next-step-text">Start with <?php echo e($topMissingSkill ? ucwords($topMissingSkill) : 'the first missing skill'); ?> and build from there.</p>
                                </div>
                            </li>
                            <li class="skillgap-next-step-item">
                                <span class="skillgap-next-step-icon"><i class="bi bi-graph-up"></i></span>
                                <div>
                                    <div class="skillgap-next-step-title">Review market demand</div>
                                    <p class="skillgap-next-step-text">The list below shows the most common skills employers ask for.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="small text-muted mt-3">Possible alternatives to charts: a checklist, a plain text summary, or a progress bar. This page now uses the checklist and summary view because it is easier to scan.</div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-12 col-md-4">
                <div class="dashboard-stat-card skillgap-metric p-3 d-flex align-items-center gap-3">
                    <div class="dashboard-stat-icon" style="background: rgba(191, 219, 254, 0.5); color: #1e40af;"><i class="bi bi-bullseye"></i></div>
                    <div>
                        <div class="dashboard-stat-number"><?php echo e($skillGapAnalysis['coveragePercent']); ?>%</div>
                        <div class="dashboard-stat-label">Market Coverage</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="dashboard-stat-card skillgap-metric p-3 d-flex align-items-center gap-3">
                    <div class="dashboard-stat-icon" style="background: rgba(219, 234, 254, 0.72); color: #2563eb;"><i class="bi bi-check-circle"></i></div>
                    <div>
                        <div class="dashboard-stat-number"><?php echo e(count($skillGapAnalysis['matchedSkills'] ?? [])); ?></div>
                        <div class="dashboard-stat-label">Matched Skills</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="dashboard-stat-card skillgap-metric p-3 d-flex align-items-center gap-3">
                    <div class="dashboard-stat-icon" style="background: rgba(224, 242, 254, 0.86); color: #1e3a8a;"><i class="bi bi-exclamation-triangle"></i></div>
                    <div>
                        <div class="dashboard-stat-number"><?php echo e(count($skillGapAnalysis['missingSkills'] ?? [])); ?></div>
                        <div class="dashboard-stat-label">Skills to Consider</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="skillgap-progress-shell p-3 p-lg-4 mb-4">
            <?php
                $coveragePercent = (int) ($skillGapAnalysis['coveragePercent'] ?? 0);
            ?>
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mb-3">
                <div>
                    <div class="skillgap-kicker mb-1" style="color: #2d65b1;">Overall Market Alignment</div>
                    <div class="fw-bold" style="color: #0a3764;">How your profile compares to active job demand</div>
                </div>
                <span class="skillgap-stat-pill"><?php echo e($coveragePercent); ?>% coverage</span>
            </div>
            <div class="progress" style="height: 12px; border-radius: 999px; background: #e8eef6;">
                <div class="progress-bar" role="progressbar" style="width: <?php echo e($coveragePercent); ?>%; background: linear-gradient(90deg, var(--skill-blue-900) 0%, var(--skill-blue-800) 60%, var(--skill-blue-300) 100%);" aria-valuenow="<?php echo e($coveragePercent); ?>" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="small text-muted mt-2">
                Based on the top <?php echo e($skillGapAnalysis['totalMarketSkills']); ?> most in-demand skills from active job postings.
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-12 col-lg-5">
                <div class="skillgap-panel p-3 p-lg-4 h-100">
                    <div class="skillgap-panel-header d-flex align-items-center justify-content-between gap-2">
                        <h3 class="h5 fw-bold mb-0"><i class="bi bi-person-badge me-2"></i>Your Current Skills</h3>
                        <span class="skillgap-stat-pill"><?php echo e(count($skillGapAnalysis['userSkills'] ?? [])); ?> skills</span>
                    </div>
                    <?php if(! empty($skillGapAnalysis['userSkills'])): ?>
                        <div class="skillgap-chip-grid">
                            <?php $__currentLoopData = $skillGapAnalysis['userSkills']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="badge rounded-pill skill-badge skill-badge-current"><?php echo e(ucwords($skill)); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-muted small mb-0">No skills found in your profile. Add skills to see the comparison.</div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-12 col-lg-7">
                <div class="skillgap-panel p-3 p-lg-4 h-100">
                    <div class="skillgap-panel-header d-flex align-items-center justify-content-between gap-2">
                        <h3 class="h5 fw-bold mb-0"><i class="bi bi-lightning-charge me-2" style="color: #1e40af;"></i>Skills In Demand</h3>
                        <span class="skillgap-stat-pill"><?php echo e(count($skillGapAnalysis['marketSkills'] ?? [])); ?> market skills</span>
                    </div>

                    <?php if(! empty($skillGapAnalysis['missingSkills'])): ?>
                        <h4 class="h6 fw-bold mb-3"><i class="bi bi-exclamation-circle me-2" style="color: #1e40af;"></i>Skills in Demand You May Be Missing</h4>
                        <div class="skillgap-chip-grid">
                            <?php $__currentLoopData = $skillGapAnalysis['missingSkills']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="badge rounded-pill skill-badge skill-badge-missing"><i class="bi bi-plus-circle me-1"></i><?php echo e(ucwords($skill)); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="alert alert-info mt-3 mb-0 small">
                            <i class="bi bi-lightbulb me-1"></i> Consider upskilling in these areas to improve your job match rate.
                        </div>
                    <?php else: ?>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-check-circle-fill" style="color: #1e40af; font-size: 1.3rem;"></i>
                            <span class="fw-bold h5 mb-0" style="color: #1e3a8a;">Excellent Coverage!</span>
                        </div>
                        <p class="text-muted mb-0">Your skillset covers all top market demands. Keep your profile updated as new roles are posted.</p>
                    <?php endif; ?>

                    <?php if(! empty($skillGapAnalysis['matchedSkills'])): ?>
                        <h4 class="h6 fw-bold mb-3 mt-4"><i class="bi bi-check-circle-fill me-2" style="color: #1e40af;"></i>Skills You Have That Are In Demand</h4>
                        <div class="skillgap-chip-grid">
                            <?php $__currentLoopData = $skillGapAnalysis['matchedSkills']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="badge rounded-pill skill-badge skill-badge-matched"><i class="bi bi-check2 me-1"></i><?php echo e(ucwords($skill)); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if(! empty($skillGapAnalysis['marketSkills'])): ?>
            <div class="skillgap-panel p-3 p-lg-4 mb-4">
                <div class="skillgap-panel-header d-flex align-items-center justify-content-between gap-2">
                    <h3 class="h5 fw-bold mb-0"><i class="bi bi-briefcase me-2"></i>Top Market Skills</h3>
                    <span class="skillgap-stat-pill">Trending now</span>
                </div>
                <p class="small text-muted mb-3">These are the most frequently requested skills across all active job postings.</p>
                <div class="skillgap-chip-grid">
                    <?php $__currentLoopData = $skillGapAnalysis['marketSkills']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $isMatched = in_array($skill, $skillGapAnalysis['matchedSkills'] ?? []);
                        ?>
                        <span class="badge rounded-pill skill-badge <?php echo e($isMatched ? 'skill-badge-matched' : 'skill-badge-current'); ?>">
                            <?php if($isMatched): ?>
                                <i class="bi bi-check2 me-1"></i>
                            <?php else: ?>
                                <i class="bi bi-plus-circle me-1"></i>
                            <?php endif; ?>
                            <?php echo e(ucwords($skill)); ?>

                        </span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>

    <?php else: ?>
        <div class="skillgap-panel p-3 p-lg-4">
            <div class="text-center py-5 px-3">
                <div class="mb-3" style="width: 68px; height: 68px; border-radius: 18px; background: #eff6ff; display: grid; place-items: center; margin: 0 auto; color: #1e40af; font-size: 1.5rem; box-shadow: 0 8px 18px rgba(30, 58, 138, 0.08);">
                    <i class="bi bi-diagram-3"></i>
                </div>
                <div class="fw-bold text-secondary h5">No skill data available yet.</div>
                <p class="text-muted small mb-3">Complete your profile and add skills to see how you compare with current market demand.</p>
                <a href="<?php echo e(route('jobseeker.profile')); ?>" class="btn btn-primary px-4">Go to Profile</a>
            </div>
        </div>
    <?php endif; ?>
</section>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views/dashboard/jobseeker/skill-gap.blade.php ENDPATH**/ ?>