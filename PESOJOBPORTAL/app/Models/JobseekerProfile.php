<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobseekerProfile extends Model
{
    use HasFactory;

    protected $table = 'jobseeker_profiles';

    protected $fillable = [
        'user_id',
        'personal_information',
        'present_address',
        'permanent_address',
        'resume_name',
        'resume_email',
        'phone',
        'address',
        'resume_path',
        'photo_path',
        'skills',
        'education',
        'training',
        'experience',
        'eligibility',
        'other_skills',
        'languages',
        'employment_status',
        'job_preferences',
        'disability',
        'objective',
        'profile_completed',
        'completion_percentage',
    ];

    protected $casts = [
        'personal_information' => 'array',
        'present_address' => 'array',
        'permanent_address' => 'array',
        'skills' => 'array',
        'education' => 'array',
        'training' => 'array',
        'experience' => 'array',
        'eligibility' => 'array',
        'other_skills' => 'array',
        'languages' => 'array',
        'employment_status' => 'array',
        'job_preferences' => 'array',
        'disability' => 'array',
        'profile_completed' => 'boolean',
        'completion_percentage' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the jobseeker profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
