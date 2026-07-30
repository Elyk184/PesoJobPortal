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
        // Original uploaded filenames
        'letter_of_intent_original_name',
        'dmw_certificate_original_name',
        'recruitment_officer_id_original_name',
        'job_order_balance_original_name',
        'deployment_report_original_name',
        'affidavit_undertaking_original_name',
        'sra_authority_file_original_name',
        'business_permit_original_name',
        'lra_recruitment_officer_id_original_name',
        'job_vacancies_original_name',
        // Recruitment schedule fields (Confirm & Submit modal)
        'recruitment_start_date',
        'recruitment_end_date',
        'recruitment_days',
        'submitted_by_employer_at',
        // Certification fields
        'certification_path',

        'certification_generated_at',
        'certification_generated_by',
    ];

    protected $attributes = [
        'status' => 'pending', // Default status for admin approval
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'certification_generated_at' => 'datetime',
        'recruitment_start_date' => 'date',
        'recruitment_end_date' => 'date',
        'submitted_by_employer_at' => 'datetime',
    ];

    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function certificationGeneratedBy()
    {
        return $this->belongsTo(User::class, 'certification_generated_by');
    }
}
