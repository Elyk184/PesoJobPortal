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
        'first_name',
        'last_name',
        'middle_initial',
        'suffix',
        'bio',
        'phone',
        'date_of_birth',
        'religion',
        'civil_status',
        'height',
        'tin',
        'email_address',
        'gender',
        'address',
        'city',
        'province',
        'postal_code',
        'skills',
        'years_of_experience',
        'education',
        'training',
        'work_experience',
        'employment_status',
        'job_preference',
        'disability',
        'avatar_path',
        'certifications',
        'languages',
    ];

    protected $casts = [
        'education' => 'array',
        'training' => 'array',
        'work_experience' => 'array',
        'employment_status' => 'array',
        'job_preference' => 'array',
        'disability' => 'array',
        'languages' => 'array',
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
