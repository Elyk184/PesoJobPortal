<?php

namespace App\Policies;

use App\Models\RecommendedApplicant;
use App\Models\User;

class RecommendedApplicantPolicy
{
    /**
     * Determine whether the user can view the recommendation.
     * Only the recommender or the recipient can view.
     */
    public function view(User $user, RecommendedApplicant $recommendation): bool
    {
        // Only the employer who recommended can see it OR the employer it was recommended to
        return $user->id === $recommendation->recommended_by_user_id 
            || $user->id === $recommendation->recommended_to_user_id;
    }

    /**
     * Determine whether the user can view sent recommendations.
     * Users can only see recommendations they sent.
     */
    public function viewSent(User $user): bool
    {
        return $user->role === 'employer' || $user->role === 'admin';
    }

    /**
     * Determine whether the user can view received recommendations.
     * Only employers can receive recommendations.
     */
    public function viewReceived(User $user): bool
    {
        return $user->role === 'employer';
    }

    /**
     * Determine whether the user can create a recommendation.
     * Only employers can recommend applicants.
     */
    public function create(User $user): bool
    {
        return $user->role === 'employer' || $user->role === 'admin';
    }

    /**
     * Determine whether the user can accept the recommendation.
     * Only the recipient (employer) can accept.
     */
    public function accept(User $user, RecommendedApplicant $recommendation): bool
    {
        // Only the employer the recommendation was sent to can accept it
        return $user->role === 'employer' 
            && $user->id === $recommendation->recommended_to_user_id;
    }

    /**
     * Determine whether the user can reject the recommendation.
     * Only the recipient (employer) can reject.
     */
    public function reject(User $user, RecommendedApplicant $recommendation): bool
    {
        // Only the employer the recommendation was sent to can reject it
        return $user->role === 'employer' 
            && $user->id === $recommendation->recommended_to_user_id;
    }

    /**
     * Determine whether the user can hire from the recommendation.
     * Only the recipient (employer) can hire.
     */
    public function hire(User $user, RecommendedApplicant $recommendation): bool
    {
        // Only the employer the recommendation was sent to can hire
        return $user->role === 'employer' 
            && $user->id === $recommendation->recommended_to_user_id;
    }

    /**
     * Verify that this recommendation is specifically for the employer.
     * Ensures they don't see general recommendations.
     */
    public function isForThisEmployer(User $user, RecommendedApplicant $recommendation): bool
    {
        return $user->id === $recommendation->recommended_to_user_id;
    }
}
