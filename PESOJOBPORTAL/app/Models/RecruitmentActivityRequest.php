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
        'approved_at',
        'approved_by',
        // SRA specific fields
        'dmw_certificate_path',
        'recruitment_officer_id_path',
        'job_order_balance_path',
        'deployment_report_path',
        'affidavit_undertaking_path',
        'sra_authority_file_path',
        // LRA specific fields
        'business_permit_path',
        'lra_recruitment_officer_id_path',
        'job_vacancies_path',
        'job_vacancies_text',
    ];

    protected $attributes = [
        'status' => 'pending', // Default status for admin approval
    ];

    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
