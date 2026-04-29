@extends('layouts.dashboard')

@section('title', 'Skill Gap Analysis | Jobseeker')

@push('styles')
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
        padding: 1.35rem;
        box-shadow: 0 14px 34px rgba(17, 30, 52, 0.08);
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
    }

    .skillgap-cta:hover {
        background: #eff6ff;
        color: #102f59;
    }

    .skillgap-metric {
        border: 1px solid #d8e4f5;
        border-radius: 16px;
        background: linear-gradient(180deg, #ffffff 0%, #f7fbff 100%);
        transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
    }

    .skillgap-metric:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 22px rgba(20, 49, 86, 0.1);
        border-color: #c7d8f5;
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
        gap: 8px;
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

    .skillgap-analytics-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .skillgap-chart-shell {
        border: 1px solid #d8e4f5;
        border-radius: 18px;
        background: #ffffff;
        padding: 16px;
        box-shadow: 0 8px 18px rgba(17, 30, 52, 0.05);
    }

    .skillgap-chart-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
        align-items: end;
        min-height: 240px;
    }

    .skillgap-chart-item {
        display: flex;
        flex-direction: column;
        gap: 8px;
        align-items: stretch;
        justify-content: end;
        min-height: 220px;
    }

    .skillgap-chart-track {
        position: relative;
        flex: 1 1 auto;
        border: 1px solid #d8e4f5;
        border-radius: 16px;
        background: linear-gradient(180deg, #f8fbff 0%, #eef4ff 100%);
        min-height: 150px;
        overflow: hidden;
        display: flex;
        align-items: flex-end;
        padding: 10px;
    }

    .skillgap-chart-bar {
        width: 100%;
        border-radius: 12px 12px 8px 8px;
        background: linear-gradient(180deg, #1e40af 0%, #3b82f6 52%, #bfdbfe 100%);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.35);
        min-height: 18px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .skillgap-chart-item:hover .skillgap-chart-bar {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(30, 64, 175, 0.18);
    }

    .skillgap-chart-bar.coverage {
        background: linear-gradient(180deg, #1e3a8a 0%, #1e40af 52%, #93c5fd 100%);
    }

    .skillgap-chart-bar.matched {
        background: linear-gradient(180deg, #1e40af 0%, #3b82f6 52%, #bfdbfe 100%);
    }

    .skillgap-chart-bar.missing {
        background: linear-gradient(180deg, #3b82f6 0%, #93c5fd 52%, #dbeafe 100%);
    }

    .skillgap-chart-bar.market {
        background: linear-gradient(180deg, #1e3a8a 0%, #60a5fa 52%, #bfdbfe 100%);
    }

    .skillgap-chart-value {
        font-size: 1.15rem;
        font-weight: 800;
        color: #1e3a8a;
        line-height: 1;
    }

    .skillgap-chart-label {
        font-size: 0.8rem;
        font-weight: 700;
        color: #0a3764;
        text-align: center;
    }

    .skillgap-chart-meta {
        font-size: 0.72rem;
        color: #60758e;
        text-align: center;
    }

    .skillgap-analytics-bar-group {
        border: 1px solid #d8e4f5;
        border-radius: 16px;
        background: #ffffff;
        padding: 20px;
        box-shadow: 0 8px 18px rgba(17, 30, 52, 0.05);
        position: relative;
    }

    .skillgap-analytics-bar-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 1.5rem;
    }

    .skillgap-analytics-bar-title {
        font-size: 0.84rem;
        font-weight: 700;
        color: #0a3764;
        margin-bottom: 0;
    }

    .skillgap-chart-container {
        position: relative;
        height: 280px;
        display: flex;
        align-items: flex-end;
        gap: 16px;
        padding: 20px 0;
        overflow-x: auto;
    }

    .skillgap-column-group {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-end;
        flex: 0 0 auto;
        gap: 8px;
        min-width: 80px;
    }

    .skillgap-bars-wrapper {
        display: flex;
        gap: 8px;
        align-items: flex-end;
        height: 200px;
    }

    .skillgap-column {
        width: 32px;
        border-radius: 8px 8px 0 0;
        position: relative;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .skillgap-column:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(30, 64, 175, 0.2);
    }

    .skillgap-column.matched {
        background: linear-gradient(180deg, #1e40af 0%, #3b82f6 100%);
    }

    .skillgap-column.missing {
        background: linear-gradient(180deg, #06b6d4 0%, #22d3ee 100%);
    }

    .skillgap-column-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: #0a3764;
        white-space: nowrap;
        text-align: center;
    }

    .skillgap-trend-line {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 200px;
        pointer-events: none;
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
            padding: 1rem;
        }

        .skillgap-panel {
            border-radius: 16px;
        }
    }
</style>
@endpush

@section('content')
<section class="skill-gap-page" aria-label="Skill gap analysis">
    <div class="skillgap-hero mb-4">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 position-relative">
            <div>
                <div class="skillgap-kicker">Career Intelligence</div>
                <h1 class="skillgap-title">Skill Gap Analysis</h1>
                <p class="skillgap-subtitle">Compare your skills with market demand and prioritize what to learn next.</p>
            </div>
            <div class="d-flex flex-wrap align-items-center justify-content-lg-end gap-2">
                <span class="skillgap-chip"><i class="bi bi-person"></i>{{ auth()->user()->name ?? 'Jobseeker' }}</span>
                <a href="{{ route('jobseeker.profile') }}" class="btn skillgap-cta px-3 shadow-sm">
                    <i class="bi bi-person-gear me-2"></i>Update Profile Skills
                </a>
            </div>
        </div>
    </div>

    @if (($skillGapAnalysis['hasData'] ?? false) && ($skillGapAnalysis['totalMarketSkills'] ?? 0) > 0)
        @php
            $coveragePercent = (int) ($skillGapAnalysis['coveragePercent'] ?? 0);
            $matchedCount = count($skillGapAnalysis['matchedSkills'] ?? []);
            $missingCount = count($skillGapAnalysis['missingSkills'] ?? []);
            $marketSkillsCount = (int) ($skillGapAnalysis['totalMarketSkills'] ?? 0);
            $unmatchedRate = max(0, 100 - $coveragePercent);
            $matchedShare = $matchedCount + $missingCount > 0 ? ($matchedCount / max(1, $matchedCount + $missingCount)) * 100 : 0;
            $missingShare = $matchedCount + $missingCount > 0 ? ($missingCount / max(1, $matchedCount + $missingCount)) * 100 : 0;
            $topMissingSkill = collect($skillGapAnalysis['missingSkills'] ?? [])->first();
            $topMatchedSkill = collect($skillGapAnalysis['matchedSkills'] ?? [])->first();
        @endphp

        <div class="skillgap-analytics-shell p-3 p-lg-4 mb-4">
            <div class="skillgap-analytics-head d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-2">
                <div>
                    <div class="skillgap-analytics-title"><i class="bi bi-graph-up-arrow me-2"></i>Analytics Snapshot</div>
                    <p class="skillgap-analytics-subtitle">A quick view of your current market alignment and the skills most likely to move the needle.</p>
                </div>
                <span class="skillgap-stat-pill">Updated from active postings</span>
            </div>

            @php
                $chartMax = max(100, $marketSkillsCount, $matchedCount + $missingCount, 1);
                $coverageBarHeight = max(18, ($coveragePercent / $chartMax) * 100);
                $matchedBarHeight = max(18, ($matchedCount / $chartMax) * 100);
                $missingBarHeight = max(18, ($missingCount / $chartMax) * 100);
                $marketBarHeight = max(18, ($marketSkillsCount / $chartMax) * 100);
            @endphp



            <div class="row g-3">
                <div class="col-12 col-lg-8">
                    <div class="skillgap-analytics-bar-group h-100">
                        <div class="skillgap-analytics-bar-head">
                            <h4 class="skillgap-analytics-bar-title">Skill Profile Overview</h4>
                            <span class="skillgap-stat-pill">{{ $matchedCount + $missingCount }} total skills</span>
                        </div>

                        <svg class="skillgap-trend-line" preserveAspectRatio="none" style="position: absolute; top: 40px; left: 20px; right: 20px; height: 210px;">
                            <defs>
                                <style>
                                    .trend { stroke: #60a5fa; stroke-width: 2; fill: none; stroke-dasharray: 6,4; }
                                </style>
                            </defs>
                            <polyline class="trend" points="0,180 40,160 80,140 120,120 160,100 200,80 240,60 280,40"></polyline>
                        </svg>

                        <div class="skillgap-chart-container">
                            @php
                                $categories = ['Current', 'Target', 'Market', 'Growth'];
                                $dataPoints = [
                                    ['label' => 'Current', 'matched' => $matchedCount, 'missing' => $missingCount],
                                    ['label' => 'Target', 'matched' => ceil($matchedCount * 1.15), 'missing' => max(0, $missingCount - 2)],
                                    ['label' => 'Market', 'matched' => $marketSkillsCount, 'missing' => max(2, $missingCount)],
                                    ['label' => 'Growth', 'matched' => ceil($matchedCount * 1.3), 'missing' => max(0, $missingCount - 4)],
                                ];
                                $maxVal = max(array_map(fn($d) => max($d['matched'], $d['missing']), $dataPoints));
                            @endphp

                            @foreach ($dataPoints as $point)
                                @php
                                    $matchedHeight = ($point['matched'] / max(1, $maxVal)) * 100;
                                    $missingHeight = ($point['missing'] / max(1, $maxVal)) * 100;
                                @endphp
                                <div class="skillgap-column-group">
                                    <div class="skillgap-bars-wrapper">
                                        <div class="skillgap-column matched" style="height: {{ $matchedHeight }}%;" title="Matched: {{ $point['matched'] }}"></div>
                                        <div class="skillgap-column missing" style="height: {{ $missingHeight }}%;" title="Missing: {{ $point['missing'] }}"></div>
                                    </div>
                                    <div class="skillgap-column-label">{{ $point['label'] }}</div>
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex flex-wrap justify-content-center gap-4 mt-3 small">
                            <span style="display: flex; align-items: center; gap: 6px;">
                                <span style="width: 16px; height: 16px; background: linear-gradient(180deg, #1e40af 0%, #3b82f6 100%); border-radius: 2px;"></span>
                                <strong style="color: #0a3764;">Matched Skills</strong>
                            </span>
                            <span style="display: flex; align-items: center; gap: 6px;">
                                <span style="width: 16px; height: 16px; background: linear-gradient(180deg, #06b6d4 0%, #22d3ee 100%); border-radius: 2px;"></span>
                                <strong style="color: #0a3764;">Missing Skills</strong>
                            </span>
                            <span style="display: flex; align-items: center; gap: 6px;">
                                <span style="width: 16px; height: 16px; border: 2px dashed #60a5fa; border-radius: 2px;"></span>
                                <strong style="color: #0a3764;">Progression Trend</strong>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="skillgap-analytics-insight">
                        <div class="skillgap-analytics-insight-title">Best next move</div>
                        <div class="skillgap-analytics-insight-value mb-2">
                            {{ $topMissingSkill ? ucwords($topMissingSkill) : 'Keep building momentum' }}
                        </div>
                        <p class="skillgap-analytics-insight-text mb-3">
                            {{ $topMissingSkill ? 'This is one of the strongest gaps to close for a better match rate.' : 'Your profile is already covering the market well. Keep your skills current as job demand changes.' }}
                        </p>
                        <div class="skillgap-analytics-insight-title">Strongest current match</div>
                        <div class="skillgap-analytics-insight-value mb-2">
                            {{ $topMatchedSkill ? ucwords($topMatchedSkill) : 'Profile ready' }}
                        </div>
                        <p class="skillgap-analytics-insight-text mb-0">
                            {{ $topMatchedSkill ? 'A good signal that your profile already aligns with active jobs.' : 'Add more skills to surface your strongest matches.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-12 col-md-4">
                <div class="dashboard-stat-card skillgap-metric p-3 d-flex align-items-center gap-3">
                    <div class="dashboard-stat-icon" style="background: rgba(191, 219, 254, 0.5); color: #1e40af;"><i class="bi bi-bullseye"></i></div>
                    <div>
                        <div class="dashboard-stat-number">{{ $skillGapAnalysis['coveragePercent'] }}%</div>
                        <div class="dashboard-stat-label">Market Coverage</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="dashboard-stat-card skillgap-metric p-3 d-flex align-items-center gap-3">
                    <div class="dashboard-stat-icon" style="background: rgba(219, 234, 254, 0.72); color: #2563eb;"><i class="bi bi-check-circle"></i></div>
                    <div>
                        <div class="dashboard-stat-number">{{ count($skillGapAnalysis['matchedSkills'] ?? []) }}</div>
                        <div class="dashboard-stat-label">Matched Skills</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="dashboard-stat-card skillgap-metric p-3 d-flex align-items-center gap-3">
                    <div class="dashboard-stat-icon" style="background: rgba(224, 242, 254, 0.86); color: #1e3a8a;"><i class="bi bi-exclamation-triangle"></i></div>
                    <div>
                        <div class="dashboard-stat-number">{{ count($skillGapAnalysis['missingSkills'] ?? []) }}</div>
                        <div class="dashboard-stat-label">Skills to Consider</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="skillgap-progress-shell p-3 p-lg-4 mb-4">
            @php
                $coveragePercent = (int) ($skillGapAnalysis['coveragePercent'] ?? 0);
            @endphp
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mb-3">
                <div>
                    <div class="skillgap-kicker mb-1" style="color: #2d65b1;">Overall Market Alignment</div>
                    <div class="fw-bold" style="color: #0a3764;">How your profile compares to active job demand</div>
                </div>
                <span class="skillgap-stat-pill">{{ $coveragePercent }}% coverage</span>
            </div>
            <div class="progress" style="height: 12px; border-radius: 999px; background: #e8eef6;">
                <div class="progress-bar" role="progressbar" style="width: {{ $coveragePercent }}%; background: linear-gradient(90deg, var(--skill-blue-900) 0%, var(--skill-blue-800) 60%, var(--skill-blue-300) 100%);" aria-valuenow="{{ $coveragePercent }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="small text-muted mt-2">
                Based on the top {{ $skillGapAnalysis['totalMarketSkills'] }} most in-demand skills from active job postings.
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-12 col-lg-5">
                <div class="skillgap-panel p-3 p-lg-4 h-100">
                    <div class="skillgap-panel-header d-flex align-items-center justify-content-between gap-2">
                        <h3 class="h5 fw-bold mb-0"><i class="bi bi-person-badge me-2"></i>Your Current Skills</h3>
                        <span class="skillgap-stat-pill">{{ count($skillGapAnalysis['userSkills'] ?? []) }} skills</span>
                    </div>
                    @if (! empty($skillGapAnalysis['userSkills']))
                        <div class="skillgap-chip-grid">
                            @foreach ($skillGapAnalysis['userSkills'] as $skill)
                                <span class="badge rounded-pill skill-badge skill-badge-current">{{ ucwords($skill) }}</span>
                            @endforeach
                        </div>
                    @else
                        <div class="text-muted small mb-0">No skills found in your profile. Add skills to see the comparison.</div>
                    @endif
                </div>
            </div>

            <div class="col-12 col-lg-7">
                <div class="skillgap-panel p-3 p-lg-4 h-100">
                    <div class="skillgap-panel-header d-flex align-items-center justify-content-between gap-2">
                        <h3 class="h5 fw-bold mb-0"><i class="bi bi-lightning-charge me-2" style="color: #1e40af;"></i>Skills In Demand</h3>
                        <span class="skillgap-stat-pill">{{ count($skillGapAnalysis['marketSkills'] ?? []) }} market skills</span>
                    </div>

                    @if (! empty($skillGapAnalysis['missingSkills']))
                        <h4 class="h6 fw-bold mb-3"><i class="bi bi-exclamation-circle me-2" style="color: #1e40af;"></i>Skills in Demand You May Be Missing</h4>
                        <div class="skillgap-chip-grid">
                            @foreach ($skillGapAnalysis['missingSkills'] as $skill)
                                <span class="badge rounded-pill skill-badge skill-badge-missing"><i class="bi bi-plus-circle me-1"></i>{{ ucwords($skill) }}</span>
                            @endforeach
                        </div>
                        <div class="alert alert-info mt-3 mb-0 small">
                            <i class="bi bi-lightbulb me-1"></i> Consider upskilling in these areas to improve your job match rate.
                        </div>
                    @else
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-check-circle-fill" style="color: #1e40af; font-size: 1.3rem;"></i>
                            <span class="fw-bold h5 mb-0" style="color: #1e3a8a;">Excellent Coverage!</span>
                        </div>
                        <p class="text-muted mb-0">Your skillset covers all top market demands. Keep your profile updated as new roles are posted.</p>
                    @endif

                    @if (! empty($skillGapAnalysis['matchedSkills']))
                        <h4 class="h6 fw-bold mb-3 mt-4"><i class="bi bi-check-circle-fill me-2" style="color: #1e40af;"></i>Skills You Have That Are In Demand</h4>
                        <div class="skillgap-chip-grid">
                            @foreach ($skillGapAnalysis['matchedSkills'] as $skill)
                                <span class="badge rounded-pill skill-badge skill-badge-matched"><i class="bi bi-check2 me-1"></i>{{ ucwords($skill) }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @if (! empty($skillGapAnalysis['marketSkills']))
            <div class="skillgap-panel p-3 p-lg-4 mb-4">
                <div class="skillgap-panel-header d-flex align-items-center justify-content-between gap-2">
                    <h3 class="h5 fw-bold mb-0"><i class="bi bi-briefcase me-2"></i>Top Market Skills</h3>
                    <span class="skillgap-stat-pill">Trending now</span>
                </div>
                <p class="small text-muted mb-3">These are the most frequently requested skills across all active job postings.</p>
                <div class="skillgap-chip-grid">
                    @foreach ($skillGapAnalysis['marketSkills'] as $skill)
                        @php
                            $isMatched = in_array($skill, $skillGapAnalysis['matchedSkills'] ?? []);
                        @endphp
                        <span class="badge rounded-pill skill-badge {{ $isMatched ? 'skill-badge-matched' : 'skill-badge-current' }}">
                            @if ($isMatched)
                                <i class="bi bi-check2 me-1"></i>
                            @else
                                <i class="bi bi-plus-circle me-1"></i>
                            @endif
                            {{ ucwords($skill) }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif
    @else
        <div class="skillgap-panel p-3 p-lg-4">
            <div class="text-center py-5 px-3">
                <div class="mb-3" style="width: 68px; height: 68px; border-radius: 18px; background: #eff6ff; display: grid; place-items: center; margin: 0 auto; color: #1e40af; font-size: 1.5rem; box-shadow: 0 8px 18px rgba(30, 58, 138, 0.08);">
                    <i class="bi bi-diagram-3"></i>
                </div>
                <div class="fw-bold text-secondary h5">No skill data available yet.</div>
                <p class="text-muted small mb-3">Complete your profile and add skills to see how you compare with current market demand.</p>
                <a href="{{ route('jobseeker.profile') }}" class="btn btn-primary px-4">Go to Profile</a>
            </div>
        </div>
    @endif
</section>
@endsection

