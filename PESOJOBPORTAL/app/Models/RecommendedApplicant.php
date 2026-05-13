<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecommendedApplicant extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_application_id',
        'peso_job_id',
        'recommended_by_user_id',
        'recommended_to_user_id',
        'recommendation_reason',
        'recommendation_type',
        'status',
        'viewed_at',
        'responded_at',
        'response_notes',
        'followup_count',
        'first_followup_at',
        'last_followup_at',
        'email_sent_at',
        'last_email_sent_at',
        'is_reviewed',
        'is_shared',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the route key for implicit route model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'id';
    }

    /**
     * Get the job application that was recommended
     */
    public function jobApplication(): BelongsTo
    {
        return $this->belongsTo(JobApplication::class);
    }

    /**
     * Get the job position for which the applicant was recommended
     */
    public function job(): BelongsTo
    {
        return $this->belongsTo(PesoJob::class, 'peso_job_id');
    }

    /**
     * Get the user who made the recommendation
     */
    public function recommendedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recommended_by_user_id');
    }

    /**
     * Get the user to whom the recommendation was sent
     */
    public function recommendedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recommended_to_user_id');
    }

    /**
     * Get the applicant user
     */
    public function applicant(): BelongsTo
    {
        return $this->jobApplication()->first()?->user() ?? collect();
    }

    /**
     * Scope: Get pending recommendations
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Get recommendations for a specific user
     */
    public function scopeForUser($query, int $userId)
    {
        return $query->where('recommended_to_user_id', $userId)
            ->whereNotNull('recommended_to_user_id'); // Only specific recommendations
    }

    /**
     * Scope: Get recommendations by a specific user
     */
    public function scopeByUser($query, int $userId)
    {
        return $query->where('recommended_by_user_id', $userId);
    }

    /**
     * Scope: Get only recommendations that are specifically addressed to someone
     * (not general recommendations)
     */
    public function scopeSpecific($query)
    {
        return $query->whereNotNull('recommended_to_user_id');
    }

    /**
     * Scope: Get recommendations not addressed to anyone (general pool)
     */
    public function scopeGeneral($query)
    {
        return $query->whereNull('recommended_to_user_id');
    }

    /**
     * Check if this is a new recommendation (not yet viewed)
     */
    public function isNew(): bool
    {
        return is_null($this->viewed_at);
    }

    /**
     * Mark as viewed by recipient
     */
    public function markAsViewed(): bool
    {
        if (is_null($this->viewed_at)) {
            return $this->update(['viewed_at' => now()]);
        }
        return true;
    }

    /**
     * Mark as reviewed by recipient
     */
    public function markAsReviewed(): bool
    {
        return $this->update(['is_reviewed' => true]);
    }

    /**
     * Mark as shared/forwarded to others
     */
    public function markAsShared(): bool
    {
        return $this->update(['is_shared' => true]);
    }

    /**
     * Record a follow-up action
     */
    public function recordFollowup(): bool
    {
        $data = [
            'followup_count' => $this->followup_count + 1,
            'last_followup_at' => now(),
        ];

        if (is_null($this->first_followup_at)) {
            $data['first_followup_at'] = now();
        }

        return $this->update($data);
    }

    /**
     * Record email sent to recipient
     */
    public function recordEmailSent(): bool
    {
        return $this->update([
            'email_sent_at' => $this->email_sent_at ?? now(),
            'last_email_sent_at' => now(),
        ]);
    }

    /**
     * Check if follow-up should be sent (not responded for 3+ days)
     */
    public function isDueForFollowup(): bool
    {
        if ($this->status !== 'pending') {
            return false;
        }

        if (is_null($this->created_at)) {
            return false;
        }

        // Due if created 3+ days ago and no response
        $daysSinceCreation = $this->created_at->diffInDays(now());
        return $daysSinceCreation >= 3;
    }

    /**
     * Check if another follow-up can be sent
     */
    public function canSendAnotherFollowup(): bool
    {
        if ($this->status !== 'pending') {
            return false;
        }

        // Max 2 follow-ups
        if ($this->followup_count >= 2) {
            return false;
        }

        // Wait at least 3 days between follow-ups
        if (!is_null($this->last_followup_at)) {
            $daysSinceLastFollowup = $this->last_followup_at->diffInDays(now());
            return $daysSinceLastFollowup >= 3;
        }

        return true;
    }

    /**
     * Get days since creation
     */
    public function daysSinceCreation(): int
    {
        return $this->created_at->diffInDays(now());
    }

    /**
     * Get days since last viewed (or null if not viewed)
     */
    public function daysSinceViewed(): ?int
    {
        if (is_null($this->viewed_at)) {
            return null;
        }
        return $this->viewed_at->diffInDays(now());
    }

    /**
     * Mark as accepted by recipient
     */
    public function accept(string $notes = null): bool
    {
        $this->markAsViewed();
        $this->markAsReviewed();
        
        return $this->update([
            'status' => 'accepted',
            'responded_at' => now(),
            'response_notes' => $notes,
            'is_reviewed' => true,
        ]);
    }

    /**
     * Mark as rejected by recipient
     */
    public function reject(string $notes = null): bool
    {
        $this->markAsViewed();
        $this->markAsReviewed();
        
        return $this->update([
            'status' => 'rejected',
            'responded_at' => now(),
            'response_notes' => $notes,
            'is_reviewed' => true,
        ]);
    }

    /**
     * Mark as hired through this recommendation
     */
    public function markAsHired(string $notes = null): bool
    {
        $this->markAsViewed();
        $this->markAsReviewed();
        
        return $this->update([
            'status' => 'hired',
            'responded_at' => now(),
            'response_notes' => $notes,
            'is_reviewed' => true,
        ]);
    }
}
