@extends('layouts.dashboard')

@section('title', 'Skill Gap Analysis | Jobseeker')

@section('content')
<section aria-label="Skill gap analysis">
    <div class="dashboard-topbar">
        <div>
            <div class="dashboard-topbar-title">Skill Gap Analysis</div>
            <div class="dashboard-topbar-subtitle">Compare your skills with market demand</div>
        </div>
        <div class="d-none d-md-block text-end">
            <div class="fw-semibold text-secondary">{{ auth()->user()->name ?? 'Jobseeker' }}</div>
            <div class="dashboard-topbar-subtitle">Market vs Current Skills</div>
        </div>
    </div>

    <div class="dashboard-section-card p-3 p-lg-4 mb-4">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
            <div>
                <h2 class="h4 mb-1 fw-bold">Your Skills vs Market Demand</h2>
                <p class="mb-0 text-muted">See how your current skillset aligns with what employers are looking for right now.</p>
            </div>
            <a href="{{ route('jobseeker.profile') }}" class="btn btn-primary px-3 shadow-sm">
                <i class="bi bi-person-gear me-2"></i>Update Profile Skills
            </a>
        </div>
    </div>

    @if (($skillGapAnalysis['hasData'] ?? false) && ($skillGapAnalysis['totalMarketSkills'] ?? 0) > 0)
        <div class="row g-3 mb-4">
            <div class="col-12 col-md-4">
                <div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
                    <div class="dashboard-stat-icon" style="background: rgba(63, 142, 252, 0.12); color: #2d65b1;"><i class="bi bi-bullseye"></i></div>
                    <div>
                        <div class="dashboard-stat-number">{{ $skillGapAnalysis['coveragePercent'] }}%</div>
                        <div class="dashboard-stat-label">Market Coverage</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
                    <div class="dashboard-stat-icon" style="background: rgba(47, 157, 98, 0.12); color: #277b49;"><i class="bi bi-check-circle"></i></div>
                    <div>
                        <div class="dashboard-stat-number">{{ count($skillGapAnalysis['matchedSkills'] ?? []) }}</div>
                        <div class="dashboard-stat-label">Matched Skills</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
                    <div class="dashboard-stat-icon" style="background: rgba(204, 141, 36, 0.14); color: #a06d19;"><i class="bi bi-exclamation-triangle"></i></div>
                    <div>
                        <div class="dashboard-stat-number">{{ count($skillGapAnalysis['missingSkills'] ?? []) }}</div>
                        <div class="dashboard-stat-label">Skills to Consider</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-section-card p-3 p-lg-4 mb-4">
            @php
                $progressClass = ($skillGapAnalysis['coveragePercent'] ?? 0) >= 70 ? 'bg-success' : (($skillGapAnalysis['coveragePercent'] ?? 0) >= 40 ? 'bg-warning' : 'bg-danger');
            @endphp
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="fw-bold">Overall Market Alignment</span>
                <span class="fw-bold" style="color: #2f4561;">{{ $skillGapAnalysis['coveragePercent'] }}%</span>
            </div>
            <div class="progress" style="height: 12px; border-radius: 999px;">
                <div class="progress-bar {{ $progressClass }}" role="progressbar" style="width: {{ $skillGapAnalysis['coveragePercent'] }}%;" aria-valuenow="{{ $skillGapAnalysis['coveragePercent'] }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="small text-muted mt-2">
                Based on the top {{ $skillGapAnalysis['totalMarketSkills'] }} most in-demand skills from active job postings.
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-12 col-lg-5">
                <div class="dashboard-section-card p-3 p-lg-4 h-100">
                    <h3 class="h5 fw-bold mb-3"><i class="bi bi-person-badge me-2"></i>Your Current Skills</h3>
                    @if (! empty($skillGapAnalysis['userSkills']))
                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($skillGapAnalysis['userSkills'] as $skill)
                                <span class="badge rounded-pill text-bg-primary" style="font-size: 0.8rem; padding: 6px 12px;">{{ ucwords($skill) }}</span>
                            @endforeach
                        </div>
                    @else
                        <div class="text-muted small">No skills found in your profile. Add skills to see the comparison.</div>
                    @endif
                </div>
            </div>

            <div class="col-12 col-lg-7">
                <div class="dashboard-section-card p-3 p-lg-4 h-100">
                    @if (! empty($skillGapAnalysis['missingSkills']))
                        <h3 class="h5 fw-bold mb-3"><i class="bi bi-exclamation-triangle-fill me-2" style="color: #b54708;"></i>Skills in Demand You May Be Missing</h3>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($skillGapAnalysis['missingSkills'] as $skill)
                                <span class="badge rounded-pill text-bg-danger" style="font-size: 0.8rem; padding: 6px 12px; background-color: #fff5f5 !important; color: #b54708 !important; border: 1px solid #fcd5d5;">
                                    <i class="bi bi-plus-circle me-1"></i>{{ ucwords($skill) }}
                                </span>
                            @endforeach
                        </div>
                        <div class="alert alert-warning mt-3 mb-0 small">
                            <i class="bi bi-lightbulb me-1"></i> Consider upskilling in these areas to improve your job match rate.
                        </div>
                    @else
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-check-circle-fill" style="color: #277b49; font-size: 1.3rem;"></i>
                            <span class="fw-bold h5 mb-0" style="color: #277b49;">Excellent Coverage!</span>
                        </div>
                        <p class="text-muted mb-0">Your skillset covers all top market demands. Keep your profile updated as new roles are posted.</p>
                    @endif

                    @if (! empty($skillGapAnalysis['matchedSkills']))
                        <h3 class="h5 fw-bold mb-3 mt-4"><i class="bi bi-check-circle-fill me-2" style="color: #277b49;"></i>Skills You Have That Are In Demand</h3>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($skillGapAnalysis['matchedSkills'] as $skill)
                                <span class="badge rounded-pill" style="font-size: 0.8rem; padding: 6px 12px; background-color: #f0fbf5 !important; color: #277b49 !important; border: 1px solid #c8e9d9;">
                                    <i class="bi bi-check2 me-1"></i>{{ ucwords($skill) }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @if (! empty($skillGapAnalysis['marketSkills']))
            <div class="dashboard-section-card p-3 p-lg-4 mb-4">
                <h3 class="h5 fw-bold mb-3"><i class="bi bi-briefcase me-2"></i>Top Market Skills</h3>
                <p class="small text-muted mb-3">These are the most frequently requested skills across all active job postings.</p>
                <div class="d-flex flex-wrap gap-2">
                    @foreach ($skillGapAnalysis['marketSkills'] as $skill)
                        @php
                            $isMatched = in_array($skill, $skillGapAnalysis['matchedSkills'] ?? []);
                        @endphp
                        <span class="badge rounded-pill" style="font-size: 0.8rem; padding: 6px 12px; {{ $isMatched ? 'background-color: #f0fbf5 !important; color: #277b49 !important; border: 1px solid #c8e9d9;' : 'background-color: #fff5f5 !important; color: #b54708 !important; border: 1px solid #fcd5d5;' }}">
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
        <div class="dashboard-section-card p-3 p-lg-4">
            <div class="text-center py-5">
                <div class="mb-3" style="width: 64px; height: 64px; border-radius: 16px; background: #edf3fa; display: grid; place-items: center; margin: 0 auto; color: #456487; font-size: 1.5rem;">
                    <i class="bi bi-diagram-3"></i>
                </div>
                <div class="fw-bold text-secondary h5">No skill data available yet.</div>
                <p class="text-muted small mb-3">Complete your profile and add skills to see how you compare with current market demand.</p>
                <a href="{{ route('jobseeker.profile') }}" class="btn btn-primary">Go to Profile</a>
            </div>
        </div>
    @endif
</section>
@endsection

