<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobseekerSkillsMeta extends Model
{
    use HasFactory;

    protected $table = 'jobseeker_skills_meta';

    protected $fillable = [
        'user_id',
        'other_enabled',
        'other_text',
        'with_certificate',
        'by_experience',
    ];

    protected $casts = [
        'other_enabled' => 'boolean',
        'with_certificate' => 'boolean',
        'by_experience' => 'boolean',
    ];
}