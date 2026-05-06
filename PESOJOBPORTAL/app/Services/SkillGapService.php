<?php

namespace App\Services;

use App\Models\PesoJob;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class SkillGapService
{
    /**
     * Skill levels used for rough proficiency comparison.
     */
    private const LEVEL_SCORES = [
        'unknown' => 0,
        'beginner' => 1,
        'basic' => 1,
        'intermediate' => 2,
        'proficient' => 2,
        'advanced' => 3,
        'expert' => 4,
    ];

    /**
     * @return array<string, array{level:int,label:string,sources:string[]}>
     */
    public function extractActualSkills(?UserProfile $profile): array
    {
        if (! $profile) {
            return [];
        }

        $skills = [];

        $addSkill = function (string $name, string $levelLabel, string $source) use (&$skills): void {
            $normalized = $this->normalizeSkillName($name);
            if ($normalized === '') {
                return;
            }

            $levelScore = $this->levelScore($levelLabel);

            if (! isset($skills[$normalized])) {
                $skills[$normalized] = [
                    'level' => $levelScore,
                    'label' => $this->levelLabelFromScore($levelScore),
                    'sources' => [$source],
                ];
                return;
            }

            $skills[$normalized]['level'] = max($skills[$normalized]['level'], $levelScore);
            $skills[$normalized]['label'] = $this->levelLabelFromScore($skills[$normalized]['level']);

            if (! in_array($source, $skills[$normalized]['sources'], true)) {
                $skills[$normalized]['sources'][] = $source;
            }
        };

        // Primary skills (supports array of strings OR array of objects with name/level)
        foreach (($profile->skills ?? []) as $item) {
            if (is_string($item)) {
                $addSkill($item, 'unknown', 'profile');
                continue;
            }

            if (is_array($item)) {
                $name = (string) ($item['name'] ?? $item['skill'] ?? '');
                $level = (string) ($item['level'] ?? $item['proficiency'] ?? 'unknown');
                $addSkill($name, $level, 'profile');
            }
        }

        // Other skills (checkbox groups)
        $otherSkills = $profile->other_skills ?? [];
        $hasCertificate = (bool) data_get($otherSkills, 'with_certificate', false);
        $byExperience = (bool) data_get($otherSkills, 'by_experience', false);

        $defaultOtherLevel = ($hasCertificate && $byExperience) ? 'advanced' : (($hasCertificate || $byExperience) ? 'intermediate' : 'beginner');

        foreach ((array) data_get($otherSkills, 'trade_manual', []) as $skillName) {
            $addSkill((string) $skillName, $defaultOtherLevel, 'other_skills');
        }
        foreach ((array) data_get($otherSkills, 'it_technical', []) as $skillName) {
            $addSkill((string) $skillName, $defaultOtherLevel, 'other_skills');
        }
        foreach ((array) data_get($otherSkills, 'soft_skills', []) as $skillName) {
            $addSkill((string) $skillName, $defaultOtherLevel, 'other_skills');
        }

        $otherText = (string) data_get($otherSkills, 'other_text', '');
        foreach ($this->extractSkillCandidatesFromText($otherText) as $candidate) {
            $addSkill($candidate, $defaultOtherLevel, 'other_skills_text');
        }

        // Training: use hours to estimate proficiency
        foreach (($profile->training ?? []) as $row) {
            $skillsText = (string) data_get($row, 'skills', '');
            $hoursText = (string) data_get($row, 'hours', '');

            $hours = $this->extractFirstInt($hoursText);
            $level = $this->levelFromTrainingHours($hours);

            foreach ($this->extractSkillCandidatesFromText($skillsText) as $candidate) {
                $addSkill($candidate, $level, 'training');
            }
        }

        // Experience: use duration to estimate proficiency for the job title keyword
        foreach (($profile->experience ?? []) as $row) {
            $title = (string) data_get($row, 'title', '');
            if (trim($title) === '') {
                continue;
            }

            $months = $this->monthsBetweenDates(
                (string) data_get($row, 'from_date', ''),
                (string) data_get($row, 'to_date', '')
            );

            $level = $this->levelFromExperienceMonths($months);
            $addSkill($title, $level, 'experience');
        }

        // Job preference occupation text
        $occupationPref = (string) data_get($profile, 'job_preferences.occupation_text', '');
        foreach ($this->extractSkillCandidatesFromText($occupationPref) as $candidate) {
            $addSkill($candidate, 'unknown', 'job_preferences');
        }

        return $skills;
    }

    /**
     * @return array{required:array<int,array{name:string,level:int,label:string}>, matched:array<int,string>, missing:array<int,string>, proficiency_gaps:array<int,array{name:string,required:string,actual:string}>, recommended_actions:array<int,array{skill:string,actions:array<int,string>}>, coverage_percent:int}
     */
    public function analyzeJobVsSkills(PesoJob $job, array $actualSkills): array
    {
        $required = $this->extractRequiredSkillsFromJob($job);

        $matched = [];
        $missing = [];
        $proficiencyGaps = [];

        foreach ($required as $req) {
            $matchKey = $this->findBestMatchKey($req['name'], $actualSkills);

            if ($matchKey === null) {
                $missing[] = $req['name'];
                continue;
            }

            $matched[] = $req['name'];

            $actualLevel = (int) data_get($actualSkills, $matchKey . '.level', 0);
            if ($req['level'] > 0 && $actualLevel > 0 && $actualLevel < $req['level']) {
                $proficiencyGaps[] = [
                    'name' => $req['name'],
                    'required' => $this->levelLabelFromScore($req['level']),
                    'actual' => $this->levelLabelFromScore($actualLevel),
                ];
            }
        }

        $total = max(count($required), 1);
        $coverage = (int) round((count($matched) / $total) * 100);

        $recommended = $this->buildRecommendedActions($missing, $proficiencyGaps);

        return [
            'required' => $required,
            'matched' => array_values(array_unique($matched)),
            'missing' => array_values(array_unique($missing)),
            'proficiency_gaps' => $proficiencyGaps,
            'recommended_actions' => $recommended,
            'coverage_percent' => $coverage,
        ];
    }

    /**
     * @return array{required_skills:int,missing_skills:array<int,string>,proficiency_gaps:array<int,array{name:string,required:string,actual:string}>,recommended_actions:array<int,array{skill:string,actions:array<int,string>}>}
     */
    public function aggregateJobsAnalysis(Collection $jobs, array $actualSkills, int $limitSkills = 10): array
    {
        $missingFreq = [];
        $gapFreq = [];
        $gapRows = [];
        $requiredCount = 0;

        foreach ($jobs as $job) {
            if (! $job instanceof PesoJob) {
                continue;
            }

            $analysis = $this->analyzeJobVsSkills($job, $actualSkills);
            $requiredCount += count($analysis['required'] ?? []);

            foreach (($analysis['missing'] ?? []) as $skillName) {
                $key = $this->normalizeSkillName($skillName);
                $missingFreq[$key] = ($missingFreq[$key] ?? 0) + 1;
            }

            foreach (($analysis['proficiency_gaps'] ?? []) as $gap) {
                $key = $this->normalizeSkillName((string) ($gap['name'] ?? ''));
                $gapFreq[$key] = ($gapFreq[$key] ?? 0) + 1;
                $gapRows[$key] = $gap; // keep one representative row
            }
        }

        arsort($missingFreq);
        arsort($gapFreq);

        $missingSkills = collect(array_keys($missingFreq))
            ->filter()
            ->take($limitSkills)
            ->values()
            ->all();

        $proficiencyGaps = collect(array_keys($gapFreq))
            ->filter()
            ->take($limitSkills)
            ->map(fn ($k) => $gapRows[$k] ?? null)
            ->filter()
            ->values()
            ->all();

        $recommended = $this->buildRecommendedActions($missingSkills, $proficiencyGaps);

        return [
            'required_skills' => $requiredCount,
            'missing_skills' => $missingSkills,
            'proficiency_gaps' => $proficiencyGaps,
            'recommended_actions' => $recommended,
        ];
    }

    /**
     * @return array<int,array{name:string,level:int,label:string}>
     */
    private function extractRequiredSkillsFromJob(PesoJob $job): array
    {
        $text = implode("\n", array_filter([
            (string) $job->getRawOriginal('requirements'),
            (string) $job->preferred_skills,
        ]));

        $rows = preg_split('#[\r\n]+#', $text) ?: [];

        $required = [];
        foreach ($rows as $row) {
            $row = trim((string) $row);
            if ($row === '') {
                continue;
            }

            $requiredLevel = $this->inferLevelFromText($row);
            $candidates = $this->extractSkillCandidatesFromText($row);

            foreach ($candidates as $candidate) {
                $normalized = $this->normalizeSkillName($candidate);
                if ($normalized === '') {
                    continue;
                }

                // Skip overly generic items
                if (in_array($normalized, ['communication', 'teamwork', 'responsible'], true)) {
                    continue;
                }

                $required[$normalized] = [
                    'name' => $normalized,
                    'level' => $requiredLevel,
                    'label' => $this->levelLabelFromScore($requiredLevel),
                ];
            }
        }

        return collect($required)
            ->values()
            ->take(12)
            ->all();
    }

    private function normalizeSkillName(string $text): string
    {
        $text = mb_strtolower(trim($text));
        $text = preg_replace('/\s+/', ' ', $text) ?? $text;
        $text = trim($text, " \t\n\r\0\x0B.-_()[]{}\"'“”‘’");

        return $text;
    }

    private function levelScore(string $label): int
    {
        $label = $this->normalizeSkillName($label);
        return self::LEVEL_SCORES[$label] ?? 0;
    }

    private function levelLabelFromScore(int $score): string
    {
        $score = max(0, min(4, $score));
        return match ($score) {
            1 => 'beginner',
            2 => 'intermediate',
            3 => 'advanced',
            4 => 'expert',
            default => 'unknown',
        };
    }

    private function inferLevelFromText(string $text): int
    {
        $t = mb_strtolower($text);

        if (preg_match('/\b(expert|expertise)\b/', $t)) {
            return 4;
        }
        if (preg_match('/\b(advanced)\b/', $t)) {
            return 3;
        }
        if (preg_match('/\b(intermediate|proficient)\b/', $t)) {
            return 2;
        }
        if (preg_match('/\b(basic|beginner|entry\s*level)\b/', $t)) {
            return 1;
        }

        return 0;
    }

    private function levelFromTrainingHours(?int $hours): string
    {
        if (! $hours || $hours <= 0) {
            return 'unknown';
        }

        if ($hours >= 120) {
            return 'advanced';
        }

        if ($hours >= 40) {
            return 'intermediate';
        }

        return 'beginner';
    }

    private function levelFromExperienceMonths(?int $months): string
    {
        if (! $months || $months <= 0) {
            return 'unknown';
        }

        if ($months >= 24) {
            return 'advanced';
        }

        if ($months >= 6) {
            return 'intermediate';
        }

        return 'beginner';
    }

    private function extractFirstInt(string $text): ?int
    {
        if (preg_match('/(\d{1,4})/', $text, $m)) {
            return (int) $m[1];
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
     * Extract skill-ish terms and phrases from arbitrary text.
     *
     * @return array<int,string>
     */
    private function extractSkillCandidatesFromText(string $text): array
    {
        $text = mb_strtolower((string) $text);
        $text = str_replace(["\t"], ' ', $text);

        $delimiters = '#[\r\n,;·•|/\\\\]+#u';
        $parts = preg_split($delimiters, $text) ?: [$text];

        $stopWords = [
            'and', 'the', 'for', 'with', 'from', 'that', 'this', 'are', 'your', 'you', 'job', 'work',
            'must', 'should', 'will', 'can', 'able', 'years', 'year', 'months', 'month', 'experience',
            'required', 'preferred', 'qualification', 'qualifications', 'responsibilities', 'duties',
            'knowledge', 'skills', 'skill', 'good', 'strong', 'excellent', 'basic', 'intermediate', 'advanced',
        ];

        $candidates = [];

        foreach ($parts as $part) {
            $part = trim((string) $part);
            if ($part === '') {
                continue;
            }

            $clean = trim(preg_replace('/^[-\s•·]+/', '', $part) ?? $part);
            $clean = trim($clean, " \t\n\r\0\x0B.-_()[]{}\"'");

            if (mb_strlen($clean) >= 3 && mb_strlen($clean) <= 60) {
                $words = preg_split('/\s+/', $clean) ?: [];
                $meaningful = collect($words)->reject(fn ($w) => in_array($w, $stopWords, true))->count() > 0;
                if ($meaningful) {
                    $candidates[] = $clean;
                }
            }
        }

        // Individual words
        $words = preg_split('/[^a-z0-9\+\.#]+/i', $text) ?: [];
        foreach ($words as $word) {
            $word = trim((string) $word, " \t\n\r\0\x0B.-_()[]{}");
            if ($word === '' || mb_strlen($word) < 4 || mb_strlen($word) > 25) {
                continue;
            }
            if (in_array($word, $stopWords, true)) {
                continue;
            }
            $candidates[] = $word;
        }

        return collect($candidates)
            ->map(fn ($c) => $this->normalizeSkillName((string) $c))
            ->filter(fn ($c) => $c !== '' && mb_strlen($c) >= 3)
            ->unique()
            ->values()
            ->all();
    }

    /**
     * Returns the normalized key in $actualSkills that best matches $requiredName.
     */
    private function findBestMatchKey(string $requiredName, array $actualSkills): ?string
    {
        $requiredKey = $this->normalizeSkillName($requiredName);

        if ($requiredKey === '') {
            return null;
        }

        if (array_key_exists($requiredKey, $actualSkills)) {
            return $requiredKey;
        }

        foreach ($actualSkills as $key => $_) {
            if ($key === '') {
                continue;
            }

            if (str_contains($requiredKey, (string) $key) || str_contains((string) $key, $requiredKey)) {
                return (string) $key;
            }
        }

        return null;
    }

    /**
     * @param array<int,string> $missing
     * @param array<int,array{name:string,required:string,actual:string}> $proficiencyGaps
     * @return array<int,array{skill:string,actions:array<int,string>}>
     */
    private function buildRecommendedActions(array $missing, array $proficiencyGaps): array
    {
        $skills = collect($missing)
            ->merge(collect($proficiencyGaps)->pluck('name'))
            ->map(fn ($s) => $this->normalizeSkillName((string) $s))
            ->filter()
            ->unique()
            ->take(8)
            ->values();

        return $skills
            ->map(function (string $skill) {
                return [
                    'skill' => $skill,
                    'actions' => $this->recommendedActionsForSkill($skill),
                ];
            })
            ->values()
            ->all();
    }

    /**
     * @return array<int,string>
     */
    private function recommendedActionsForSkill(string $skill): array
    {
        $skillKey = $this->normalizeSkillName($skill);

        $certMap = [
            'microsoft office' => 'Microsoft Office Specialist (MOS)',
            'excel' => 'Microsoft Office Specialist: Excel Associate',
            'word' => 'Microsoft Office Specialist: Word Associate',
            'powerpoint' => 'Microsoft Office Specialist: PowerPoint Associate',
            'network' => 'CompTIA Network+',
            'networking' => 'CompTIA Network+',
            'linux' => 'Linux Essentials (LPI)',
            'cybersecurity' => 'CompTIA Security+',
            'customer service' => 'Customer Service Certification (entry-level)',
            'driving' => 'Professional Driver Training / Defensive Driving Certificate',
            'driver' => 'Professional Driver Training / Defensive Driving Certificate',
        ];

        $courseTitle = ucwords($skillKey) . ' Fundamentals';

        $actions = [
            'Course: ' . $courseTitle,
            'Training: Ask PESO/TESDA about local training for ' . ucwords($skillKey) . '.',
        ];

        foreach ($certMap as $needle => $cert) {
            if (str_contains($skillKey, $needle)) {
                $actions[] = 'Certification: ' . $cert;
                break;
            }
        }

        // Keep it short
        return array_values(array_slice(array_unique($actions), 0, 3));
    }
}
