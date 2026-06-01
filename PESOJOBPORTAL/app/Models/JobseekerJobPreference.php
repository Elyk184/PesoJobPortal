<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobseekerJobPreference extends Model
{
    use HasFactory;

    protected $table = 'jobseeker_job_preferences';

    protected $fillable = [
        'user_id',
        'part_time',
        'full_time',
        'occupation_text',
        'local',
        'overseas',
    ];

    protected $casts = [
        'part_time' => 'boolean',
        'full_time' => 'boolean',
        'local' => 'boolean',
        'overseas' => 'boolean',
    ];
}