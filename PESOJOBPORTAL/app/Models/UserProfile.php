<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

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
        'skills',
        'education',
        'experience',
        'training',
        'eligibility',
        'other_skills',
        'employment_status',
        'job_preferences',
        'languages',
        'disability',
        'objective',
        'photo_path',
    ];

    protected $casts = [
        'personal_information' => 'array',
        'present_address' => 'array',
        'permanent_address' => 'array',
        'skills' => 'array',
        'education' => 'array',
        'experience' => 'array',
        'training' => 'array',
        'eligibility' => 'array',
        'other_skills' => 'array',
        'employment_status' => 'array',
        'job_preferences' => 'array',
        'languages' => 'array',
        'disability' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
?>

