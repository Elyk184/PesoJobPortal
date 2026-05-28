<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobseekerExperience extends Model
{
    use HasFactory;

    protected $table = 'jobseeker_experience';

    protected $fillable = [
        'user_id',
        'sort_order',
        'company',
        'title',
        'location',
        'status',
        'from_date',
        'to_date',
        'salary_amount',
        'salary_type',
        'details',
    ];
}