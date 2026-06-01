<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobseekerSkill extends Model
{
    use HasFactory;

    protected $table = 'jobseeker_skills';

    protected $fillable = [
        'user_id',
        'category',
        'skill',
    ];
}