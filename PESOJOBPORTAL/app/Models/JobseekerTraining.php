<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobseekerTraining extends Model
{
    use HasFactory;

    protected $table = 'jobseeker_training';

    protected $fillable = [
        'user_id',
        'sort_order',
        'course',
        'hours',
        'institution',
        'inclusive_dates',
        'skills_acquired',
        'certificates',
    ];
}