<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruitmentActivityRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'employer_id',
        'activity_type',
        'letter_of_intent_path',
        'company_profile_path',
        'job_advertisement_path',
        'status',
        'notes',
    ];

    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }
}
