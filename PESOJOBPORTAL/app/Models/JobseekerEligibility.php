<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobseekerEligibility extends Model
{
    use HasFactory;

    protected $table = 'jobseeker_eligibility';

    protected $fillable = [
        'user_id',
        'sort_order',
        'eligibility',
        'date_taken',
        'license',
        'valid_until',
    ];
}