<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobseekerEmploymentStatus extends Model
{
    use HasFactory;

    protected $table = 'jobseeker_employment_status';

    protected $fillable = [
        'user_id',
        'has_work_experience',
        'wage_employed',
        'wage_employed_specify',
        'self_employed',
        'self_employed_specify',
        'unemployed',
    ];

    protected $casts = [
        'has_work_experience' => 'boolean',
        'wage_employed' => 'boolean',
        'self_employed' => 'boolean',
        'unemployed' => 'boolean',
    ];
}