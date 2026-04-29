<?php

namespace App\Services;

use App\Models\JobApplication;
use App\Models\PesoJob;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Collection;

class JobRecommendationService
{
    public function recommendForUser(User $user, int $limit = 12): Collection
    {
        $profile = $user->profile;

        if (! $profile instanceof UserProfile) {
            return collect();
        }

        $profileSkills = $this->extractProfileSkills($profile);

        if (empty($profileSkills)) {
            return collect();
        }

        $appliedJobIds = JobApplication::query()
            ->where('user_id', $user->id)
            ->pluck('peso_job_id')
            ->all();

        $jobs = PesoJob::query()
            ->where('status', 'active')
            ->whereNotIn('id', $appliedJobIds)
            ->latest('id')
            ->get();

        return $jobs
            ->map(function (PesoJob $job) use ($profile, $profileSkills) {
                return $this->scoreJobForProfile($job, $profile, $profileSkills);
            })
            ->filter(fn (array $item) => $item['score'] >= 25)
            ->sortByDesc('score')
            ->values()
            ->take($limit);
    }

    private function scoreJobForProfile(PesoJob $job, UserProfile $profile, array $profileSkills): array
    {
        $jobKeywords = $this->extractJobKeywords($job);

        $matchedSkills = [];
        foreach ($profileSkills as $skill) {
            foreach ($jobKeywords as $keyword) {
                if ($this->isSkillMatch($skill, $keyword)) {
                    $matchedSkills[] = $skill;
                    break;
                }
            }
        }

        $matchedSkills = array_values(array_unique($matchedSkills));

        $jobKeywordCount = max(count($jobKeywords), 1);
        $coverageRatio = min(count($matchedSkills) / $jobKeywordCount, 1);
        $skillScore = (int) round($coverageRatio * 70);

        $titleTokens = $this->tokenizeText((string) $job->title);
        $titleBoost = count(array_intersect($profileSkills, $titleTokens)) > 0 ? 15 : 0;

        $preferenceScore = 0;
        $locationText = strtolower((string) $job->location);
        $prefersLocal = (bool) data_get($profile, 'job_preferences.local', false);
        $prefersOverseas = (bool) data_get($profile, 'job_preferences.overseas', false);

        if ($prefersLocal && ! str_contains($locationText, 'overseas')) {
            $preferenceScore += 8;
        }

        if ($prefersOverseas && str_contains($locationText, 'overseas')) {
            $preferenceScore += 8;
        }

        $occupationPreferences = $this->tokenizeText((string) data_get($profile, 'job_preferences.occupation_text', ''));
        if (count(array_intersect($occupationPreferences, $jobKeywords)) > 0) {
            $preferenceScore += 7;
        }

        $score = min($skillScore + $titleBoost + $preferenceScore, 100);

        return [
            'job' => $job,
            'score' => $score,
            'matched_skills' => array_slice($matchedSkills, 0, 6),
            'matched_count' => count($matchedSkills),
            'job_keyword_count' => $jobKeywordCount,
            'reasons' => $this->buildReasons($matchedSkills, $titleBoost > 0, $preferenceScore > 0),
        ];
    }

    private function buildReasons(array $matchedSkills, bool $titleMatched, bool $preferenceMatched): array
    {
        $reasons = [];

        if (! empty($matchedSkills)) {
            $reasons[] = 'Skills matched: ' . implode(', ', array_slice($matchedSkills, 0, 3));
        }

        if ($titleMatched) {
            $reasons[] = 'Your skill keywords align with the job title.';
        }

        if ($preferenceMatched) {
            $reasons[] = 'Matches your location or occupation preferences.';
        }

        if (empty($reasons)) {
            $reasons[] = 'General profile fit based on available details.';
        }

        return $reasons;
    }

    private function extractProfileSkills(UserProfile $profile): array
    {
        $skills = [];

        $baseSkills = $profile->skills ?? [];
        if (is_array($baseSkills)) {
            $skills = array_merge($skills, $baseSkills);
        }

        $otherSkills = $profile->other_skills ?? [];
        $skills = array_merge(
            $skills,
            is_array(data_get($otherSkills, 'trade_manual')) ? data_get($otherSkills, 'trade_manual') : [],
            is_array(data_get($otherSkills, 'it_technical')) ? data_get($otherSkills, 'it_technical') : [],
            is_array(data_get($otherSkills, 'soft_skills')) ? data_get($otherSkills, 'soft_skills') : []
        );

        $experienceTitles = collect($profile->experience ?? [])
            ->map(fn ($row) => (string) data_get($row, 'title', ''))
            ->all();

        $trainingSkills = collect($profile->training ?? [])
            ->map(fn ($row) => (string) data_get($row, 'skills', ''))
            ->all();

        $occupationText = (string) data_get($profile, 'job_preferences.occupation_text', '');

        $skills = array_merge($skills, $experienceTitles, $trainingSkills, [$occupationText]);

        return collect($skills)
            ->flatMap(fn ($item) => $this->tokenizeText((string) $item))
            ->unique()
            ->values()
            ->all();
    }

    private function extractJobKeywords(PesoJob $job): array
    {
        $skills = [];

        $requirements = $job->requirements;

        if (is_array($requirements)) {
            $skills = array_merge($skills, $requirements);
        } elseif (is_string($requirements) && $requirements !== '') {
            $decoded = json_decode($requirements, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $skills = array_merge($skills, $decoded);
            } else {
                $skills[] = $requirements;
            }
        }

        $skills[] = (string) $job->title;
        $skills[] = (string) $job->description;

        return collect($skills)
            ->flatMap(fn ($item) => $this->tokenizeText((string) $item))
            ->unique()
            ->values()
            ->all();
    }

    private function isSkillMatch(string $profileSkill, string $jobKeyword): bool
    {
        if ($profileSkill === $jobKeyword) {
            return true;
        }

        return str_contains($profileSkill, $jobKeyword) || str_contains($jobKeyword, $profileSkill);
    }

    private function tokenizeText(string $text): array
    {
        $text = strtolower(trim($text));

        if ($text === '') {
            return [];
        }

        $tokens = preg_split('/[^a-z0-9\+\.#]+/i', $text) ?: [];

        $stopWords = [
            'and', 'the', 'with', 'for', 'from', 'that', 'this', 'are', 'will', 'can', 'your', 'you', 'our', 'have',
            'has', 'was', 'were', 'job', 'jobs', 'work', 'year', 'years', 'month', 'months', 'must', 'able', 'good',
            'required', 'requirement', 'requirements', 'experience', 'knowledge', 'skills', 'skill', 'position',
        ];

        return collect($tokens)
            ->map(fn ($token) => trim($token))
            ->filter(fn ($token) => strlen($token) >= 2 && ! in_array($token, $stopWords, true))
            ->values()
            ->all();
    }
}
