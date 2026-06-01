<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobseekerEducation extends Model
{
    use HasFactory;

    protected $table = 'jobseeker_education';

    protected $fillable = [
        'user_id',
        'sort_order',
        'school',
        'course',
        'year',
    ];
}