<?php

namespace App\Services;

use App\Models\JobApplication;
use App\Models\PesoJob;
use App\Models\SavedJob;
use App\Models\User;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class JobMatchingService
{
    public function __construct(private SkillGapService $skillGapService)
    {
    }

    public function recommendForUser(User $user, int $limit = 12): Collection
    {
        $profile = $user->profile;

        if (! $profile instanceof UserProfile) {
            return collect();
        }

        $appliedJobIds = JobApplication::query()
            ->where('user_id', $user->id)
            ->pluck('peso_job_id')
            ->all();

        return PesoJob::query()
            ->activeApproved()
            ->whereNotIn('id', $appliedJobIds)
            ->latest('id')
            ->get()
            ->map(fn (PesoJob $job) => $this->matchJob($job, $profile, $user))
            ->filter(fn (array $match) => (int) ($match['match_score'] ?? 0) > 0)
            ->sortByDesc('match_score')
            ->take($limit)
            ->values();
    }

    public function matchJob(PesoJob $job, ?UserProfile $profile = null, ?User $user = null): array
    {
        $profile ??= $user?->profile;

        $actualSkills = $this->skillGapService->extractActualSkills($profile);
        $skillAnalysis = $this->skillGapService->analyzeJobVsSkills($job, $actualSkills);

        $skillsScore = (int) round(((int) ($skillAnalysis['coverage_percent'] ?? 0) / 100) * 40);
        $skillsScore = max(0, min(40, $skillsScore));

        $experienceAnalysis = $this->scoreExperience($job, $profile);
        $educationAnalysis = $this->scoreEducation($job, $profile);
        $interestAnalysis = $this->scoreInterests($job, $profile, $user);
        $locationAnalysis = $this->scoreLocation($job, $profile);
        $salaryAnalysis = $this->scoreSalary($job, $profile);

        $rawScore = $skillsScore
            + $experienceAnalysis['score']
            + $educationAnalysis['score']
            + $interestAnalysis['score']
            + $locationAnalysis['score']
            + $salaryAnalysis['score'];

        $matchScore = (int) round(max(0, min(100, $rawScore)));

        $matchReasons = array_values(array_filter(array_merge(
            $this->buildSkillReasons($skillAnalysis, $skillsScore),
            $experienceAnalysis['reasons'],
            $educationAnalysis['reasons'],
            $interestAnalysis['reasons'],
            $locationAnalysis['reasons'],
            $salaryAnalysis['reasons']
        )));

        if ($matchReasons === []) {
            $matchReasons[] = 'General fit based on the available profile and job data.';
        }

        return [
            'job' => $job,
            'match_score' => $matchScore,
            'match_level' => $this->matchLevelForScore($matchScore),
            'matching_skills' => $this->formatSkillList($skillAnalysis['matched'] ?? []),
            'missing_skills' => $this->formatSkillList($skillAnalysis['missing'] ?? []),
            'match_reasons' => $matchReasons,
            'requirements_list' => $this->extractJobRequirements($job),
            'compatibility' => [
                'skills' => [
                    'score' => $skillsScore,
                    'coverage_percent' => (int) ($skillAnalysis['coverage_percent'] ?? 0),
                ],
                'experience' => $experienceAnalysis,
                'education' => $educationAnalysis,
                'interest' => $interestAnalysis,
                'location' => $locationAnalysis,
                'salary' => $salaryAnalysis,
            ],
        ];
    }

    private function matchLevelForScore(int $score): string
    {
        return match (true) {
            $score >= 90 => 'Excellent Match',
            $score >= 75 => 'Strong Match',
            $score >= 60 => 'Moderate Match',
            $score >= 40 => 'Weak Match',
            default => 'Poor Match',
        };
    }

    /**
     * @param array<string,mixed> $skillAnalysis
     * @return array<int,string>
     */
    private function buildSkillReasons(array $skillAnalysis, int $skillsScore): array
    {
        $reasons = [];
        $matchedSkills = array_slice((array) ($skillAnalysis['matched'] ?? []), 0, 3);
        $missingSkills = array_slice((array) ($skillAnalysis['missing'] ?? []), 0, 3);

        if ($matchedSkills !== []) {
            $reasons[] = 'Relevant skills matched: ' . implode(', ', array_map([$this, 'displaySkill'], $matchedSkills));
        }

        if ($skillsScore >= 24) {
            $reasons[] = 'Skills are the strongest part of this match.';
        }

        if ($missingSkills !== []) {
            $reasons[] = 'Missing skills to review: ' . implode(', ', array_map([$this, 'displaySkill'], $missingSkills));
        }

        return $reasons;
    }

    private function scoreExperience(PesoJob $job, ?UserProfile $profile): array
    {
        $profileExperience = collect((array) ($profile?->experience ?? []))
            ->filter(fn ($row) => is_array($row))
            ->values();

        if ($profileExperience->isEmpty()) {
            return [
                'score' => 0,
                'reasons' => [],
                'matched_roles' => [],
                'required_years' => null,
                'years_of_experience' => 0,
            ];
        }

        $jobText = mb_strtolower(implode(' ', array_filter([
            (string) $job->title,
            (string) $job->description,
            (string) $job->requirements,
            (string) $job->preferred_skills,
            (string) $job->experience,
            (string) $job->qualifications,
        ])));

        $jobKeywords = $this->extractKeywords([$job->title, $job->description, $job->requirements, $job->preferred_skills, $job->experience, $job->qualifications]);
        $matchedRoles = [];
        $totalMonths = 0;

        foreach ($profileExperience as $row) {
            $rowText = implode(' ', array_filter([
                (string) data_get($row, 'company', ''),
                (string) data_get($row, 'title', ''),
                (string) data_get($row, 'location', ''),
                (string) data_get($row, 'details', ''),
                (string) data_get($row, 'status', ''),
            ]));

            $rowKeywords = $this->extractKeywords([$rowText]);
            if ($this->hasKeywordOverlap($jobKeywords, $rowKeywords, $jobText, $rowText)) {
                $matchedRoles[] = trim((string) data_get($row, 'title', '')) ?: trim((string) data_get($row, 'company', ''));
            }

            $months = $this->monthsBetweenDates(
                (string) data_get($row, 'from_date', ''),
                (string) data_get($row, 'to_date', '')
            );

            if ($months !== null) {
                $totalMonths += $months;
            }
        }

        $requiredYears = $this->extractRequiredYears($jobText);
        $yearsOfExperience = $totalMonths > 0 ? round($totalMonths / 12, 1) : 0;

        if ($requiredYears !== null && $requiredYears > 0) {
            $yearsRatio = min($yearsOfExperience / $requiredYears, 1);
            $roleRatio = min(count(array_unique($matchedRoles)) / max($profileExperience->count(), 1), 1);
            $score = (int) round(min(1, ($yearsRatio * 0.7) + ($roleRatio * 0.3)) * 25);
        } else {
            $roleRatio = min(count(array_unique($matchedRoles)) / max($profileExperience->count(), 1), 1);
            $yearsBoost = min($yearsOfExperience / 10, 1);
            $score = (int) round(min(1, ($roleRatio * 0.6) + ($yearsBoost * 0.4)) * 25);
        }

        $reasons = [];

        if ($matchedRoles !== []) {
            $reasons[] = 'Relevant experience in ' . implode(', ', array_map([$this, 'displaySkill'], array_slice(array_unique($matchedRoles), 0, 2))) . '.';
        }

        if ($requiredYears !== null) {
            $reasons[] = 'Experience level is compared against the role requirement of about ' . rtrim(rtrim(number_format($requiredYears, 1), '0'), '.') . ' years.';
        }

        return [
            'score' => max(0, min(25, $score)),
            'reasons' => $reasons,
            'matched_roles' => array_values(array_unique(array_filter($matchedRoles))),
            'required_years' => $requiredYears,
            'years_of_experience' => $yearsOfExperience,
        ];
    }

    private function scoreEducation(PesoJob $job, ?UserProfile $profile): array
    {
        $educationRows = collect((array) ($profile?->education ?? []))
            ->filter(fn ($row) => is_array($row))
            ->values();

        if ($educationRows->isEmpty()) {
            return [
                'score' => 0,
                'reasons' => [],
                'matched_terms' => [],
            ];
        }

        $jobEducationTerms = $this->extractKeywords([
            $job->education,
            $job->qualifications,
            $job->description,
        ]);

        $profileTerms = [];

        foreach ($educationRows as $row) {
            $profileTerms = array_merge($profileTerms, $this->extractKeywords([
                (string) data_get($row, 'school', ''),
                (string) data_get($row, 'course', ''),
                (string) data_get($row, 'year', ''),
            ]));
        }

        $matchedTerms = array_values(array_unique(array_intersect($jobEducationTerms, $profileTerms)));

        if ($jobEducationTerms === [] && $matchedTerms === []) {
            return [
                'score' => 0,
                'reasons' => [],
                'matched_terms' => [],
            ];
        }

        $score = (int) round(min(1, count($matchedTerms) / max(count($jobEducationTerms), 1)) * 10);

        $reasons = [];
        if ($matchedTerms !== []) {
            $reasons[] = 'Educational background aligns with ' . implode(', ', array_map([$this, 'displaySkill'], array_slice($matchedTerms, 0, 2))) . '.';
        }

        return [
            'score' => max(0, min(10, $score)),
            'reasons' => $reasons,
            'matched_terms' => $matchedTerms,
        ];
    }

    private function scoreInterests(PesoJob $job, ?UserProfile $profile, ?User $user): array
    {
        if (! $profile && ! $user) {
            return [
                'score' => 0,
                'reasons' => [],
                'signals' => [],
            ];
        }

        $interestSignals = $this->extractKeywords([
            data_get($profile, 'job_preferences.occupation_text', ''),
            data_get($profile, 'objective', ''),
        ]);

        if ($user) {
            $interestSignals = array_merge($interestSignals, $this->extractHistorySignals($user));
        }

        $jobSignals = $this->extractKeywords([
            $job->title,
            $job->description,
            $job->preferred_skills,
            $job->requirements,
        ]);

        $signalMatches = array_values(array_unique(array_intersect($interestSignals, $jobSignals)));
        $score = (int) round(min(1, count($signalMatches) / max(count($jobSignals), 1)) * 10);

        $reasons = [];
        if ($signalMatches !== []) {
            $reasons[] = 'Preferred role or job history aligns with ' . implode(', ', array_map([$this, 'displaySkill'], array_slice($signalMatches, 0, 2))) . '.';
        }

        return [
            'score' => max(0, min(10, $score)),
            'reasons' => $reasons,
            'signals' => $signalMatches,
        ];
    }

    private function scoreLocation(PesoJob $job, ?UserProfile $profile): array
    {
        $jobLocation = trim(mb_strtolower((string) $job->location));

        if ($jobLocation === '') {
            return [
                'score' => 0,
                'reasons' => [],
                'matched_locations' => [],
            ];
        }

        $profileLocations = $this->extractProfileLocations($profile);
        $matchedLocations = [];
        $score = 0;

        foreach ($profileLocations as $location) {
            if ($location === '') {
                continue;
            }

            if (str_contains($jobLocation, $location) || str_contains($location, $jobLocation)) {
                $matchedLocations[] = $location;
                $score = 10;
                break;
            }
        }

        if ($score === 0) {
            $remoteKeywords = ['remote', 'work from home', 'wfh', 'online'];

            foreach ($remoteKeywords as $keyword) {
                if (str_contains($jobLocation, $keyword)) {
                    $score = 6;
                    break;
                }
            }
        }

        $reasons = [];
        if ($score > 0 && $matchedLocations !== []) {
            $reasons[] = 'Location matches your profile address: ' . implode(', ', array_map([$this, 'displaySkill'], array_slice(array_unique($matchedLocations), 0, 2))) . '.';
        } elseif ($score > 0) {
            $reasons[] = 'Location is flexible or remote-friendly.';
        }

        return [
            'score' => max(0, min(10, $score)),
            'reasons' => $reasons,
            'matched_locations' => $matchedLocations,
        ];
    }

    private function scoreSalary(PesoJob $job, ?UserProfile $profile): array
    {
        $expectedSalary = $this->extractExpectedSalary($profile);
        $jobSalary = $this->extractJobSalaryBounds($job);

        if ($expectedSalary === null || $jobSalary === null) {
            return [
                'score' => 0,
                'reasons' => [],
                'expected_salary' => $expectedSalary,
                'job_salary_min' => $jobSalary['min'] ?? null,
                'job_salary_max' => $jobSalary['max'] ?? null,
            ];
        }

        $min = (float) $jobSalary['min'];
        $max = (float) $jobSalary['max'];
        $expected = (float) $expectedSalary;

        $score = 0;

        if ($expected >= $min && $expected <= $max) {
            $score = 5;
        } elseif ($expected >= ($min * 0.85) && $expected <= ($max * 1.15)) {
            $score = 3;
        }

        $reasons = [];
        if ($score > 0) {
            $reasons[] = 'Salary expectation fits the posted range.';
        }

        return [
            'score' => $score,
            'reasons' => $reasons,
            'expected_salary' => $expectedSalary,
            'job_salary_min' => $jobSalary['min'],
            'job_salary_max' => $jobSalary['max'],
        ];
    }

    /**
     * @return array<int,string>
     */
    private function extractProfileLocations(?UserProfile $profile): array
    {
        if (! $profile) {
            return [];
        }

        return $this->extractKeywords([
            data_get($profile, 'present_address.barangay', ''),
            data_get($profile, 'present_address.municipality', ''),
            data_get($profile, 'present_address.city', ''),
            data_get($profile, 'present_address.province', ''),
            data_get($profile, 'permanent_address.barangay', ''),
            data_get($profile, 'permanent_address.municipality', ''),
            data_get($profile, 'permanent_address.city', ''),
            data_get($profile, 'permanent_address.province', ''),
            data_get($profile, 'job_preferences.location_text', ''),
        ]);
    }

    private function extractExpectedSalary(?UserProfile $profile): ?float
    {
        if (! $profile) {
            return null;
        }

        $candidates = [
            data_get($profile, 'job_preferences.expected_salary', ''),
            data_get($profile, 'job_preferences.desired_salary', ''),
            data_get($profile, 'job_preferences.salary', ''),
            data_get($profile, 'personal_information.expected_salary', ''),
            data_get($profile, 'personal_information.desired_salary', ''),
            data_get($profile, 'employment_status.expected_salary', ''),
        ];

        foreach ($candidates as $candidate) {
            $salary = $this->parseSalaryText((string) $candidate, false);
            if ($salary !== null) {
                return $salary;
            }
        }

        return null;
    }

    /**
     * @return array{min:float,max:float}|null
     */
    private function extractJobSalaryBounds(PesoJob $job): ?array
    {
        $salary = $this->parseSalaryText((string) $job->salary_range, true)
            ?? $this->parseSalaryText((string) $job->salary, true);

        if ($salary === null) {
            return null;
        }

        return [
            'min' => $salary,
            'max' => $salary,
        ];
    }

    private function parseSalaryText(string $text, bool $convertDailyToMonthly): ?float
    {
        $normalized = mb_strtolower(trim($text));

        if ($normalized === '') {
            return null;
        }

        $normalized = str_replace([',', '₱', 'php', 'peso', 'pesos'], '', $normalized);
        $numbers = [];

        if (preg_match_all('/(\d+(?:\.\d+)?)(\s*k)?/', $normalized, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $value = (float) $match[1];
                if (! empty($match[2])) {
                    $value *= 1000;
                }
                $numbers[] = $value;
            }
        }

        if ($numbers === []) {
            return null;
        }

        $salary = count($numbers) > 1 ? (array_sum($numbers) / count($numbers)) : $numbers[0];

        if ($convertDailyToMonthly && preg_match('/\b(day|daily|per day|\/day)\b/', $normalized)) {
            $salary *= 26;
        }

        if ($convertDailyToMonthly && preg_match('/\b(hour|hourly|per hour|\/hour)\b/', $normalized)) {
            $salary *= 208;
        }

        return $salary;
    }

    /**
     * @return array<int,string>
     */
    private function extractHistorySignals(User $user): array
    {
        $savedJobs = SavedJob::query()
            ->where('user_id', $user->id)
            ->with(['job:id,title,description,location,requirements,preferred_skills'])
            ->latest('id')
            ->limit(20)
            ->get()
            ->pluck('job');

        $applications = JobApplication::query()
            ->where('user_id', $user->id)
            ->with(['job:id,title,description,location,requirements,preferred_skills'])
            ->latest('id')
            ->limit(20)
            ->get()
            ->pluck('job');

        return $savedJobs
            ->merge($applications)
            ->filter()
            ->flatMap(fn ($job) => $this->extractKeywords([
                (string) data_get($job, 'title', ''),
                (string) data_get($job, 'description', ''),
                (string) data_get($job, 'requirements', ''),
                (string) data_get($job, 'preferred_skills', ''),
            ]))
            ->values()
            ->all();
    }

    /**
     * @param array<int,string|mixed> $values
     * @return array<int,string>
     */
    private function extractKeywords(array $values): array
    {
        $tokens = [];

        foreach ($values as $value) {
            $text = mb_strtolower(trim((string) $value));
            if ($text === '') {
                continue;
            }

            $parts = preg_split('/[^a-z0-9\+\.#]+/i', $text) ?: [];

            foreach ($parts as $part) {
                $part = trim((string) $part);
                if ($part === '' || mb_strlen($part) < 2) {
                    continue;
                }

                if (in_array($part, ['and', 'the', 'for', 'with', 'from', 'that', 'this', 'are', 'your', 'you', 'job', 'work', 'skills', 'skill', 'experience', 'required'], true)) {
                    continue;
                }

                $tokens[] = $part;
            }
        }

        return collect($tokens)
            ->unique()
            ->values()
            ->all();
    }

    /**
     * @param array<int,string> $left
     * @param array<int,string> $right
     */
    private function hasKeywordOverlap(array $left, array $right, string $leftText = '', string $rightText = ''): bool
    {
        if (array_intersect($left, $right) !== []) {
            return true;
        }

        foreach ($left as $keyword) {
            if ($keyword === '') {
                continue;
            }

            if (str_contains($rightText, $keyword) || str_contains($leftText, $keyword)) {
                return true;
            }
        }

        return false;
    }

    private function extractRequiredYears(string $text): ?float
    {
        if (preg_match('/(\d+(?:\.\d+)?)\s*\+?\s*(?:years?|yrs?|yr)\b/i', $text, $matches)) {
            return (float) $matches[1];
        }

        return null;
    }

    private function monthsBetweenDates(string $from, string $to): ?int
    {
        try {
            $from = trim($from);
            $to = trim($to);

            if ($from === '') {
                return null;
            }

            $start = Carbon::parse($from);
            $end = $to !== '' ? Carbon::parse($to) : now();

            if ($end->lessThan($start)) {
                return null;
            }

            return max(0, $start->diffInMonths($end));
        } catch (\Throwable) {
            return null;
        }
    }

    /**
     * @return array<int,string>
     */
    private function extractJobRequirements(PesoJob $job): array
    {
        $requirements = $job->requirements;

        if (is_array($requirements) && ! empty($requirements)) {
            return collect($requirements)
                ->map(fn ($item) => trim((string) $item))
                ->filter()
                ->values()
                ->all();
        }

        $rawRequirements = trim((string) $job->getRawOriginal('requirements'));

        if ($rawRequirements === '') {
            return [];
        }

        return collect(preg_split('/[\r\n,]+/', $rawRequirements) ?: [])
            ->map(fn ($item) => trim((string) $item))
            ->filter()
            ->values()
            ->all();
    }

    /**
     * @param array<int,string> $skills
     * @return array<int,string>
     */
    private function formatSkillList(array $skills): array
    {
        return collect($skills)
            ->filter(fn ($skill) => trim((string) $skill) !== '')
            ->map(fn ($skill) => $this->displaySkill((string) $skill))
            ->unique()
            ->values()
            ->all();
    }

    private function displaySkill(string $skill): string
    {
        $skill = trim($skill);

        if ($skill === '') {
            return $skill;
        }

        return ucwords($skill);
    }
}