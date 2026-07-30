<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobseekerDisability extends Model
{
    use HasFactory;

    protected $table = 'jobseeker_disability';

    protected $fillable = [
        'user_id',
        'visual',
        'speech',
        'mental',
        'hearing',
        'physical',
        'other',
        'other_text',
    ];

    protected $casts = [
        'visual' => 'boolean',
        'speech' => 'boolean',
        'mental' => 'boolean',
        'hearing' => 'boolean',
        'physical' => 'boolean',
        'other' => 'boolean',
    ];
}