<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\JobApplication;
use Illuminate\Database\Eloquent\Model;

class PesoJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'employer_id',
        'employer_name',
        'title',
        'position',
        'description',
        'qualifications',
        'key_responsibilities',
        'preferred_skills',
        'experience',
        'education',
        'benefits',
        'location',
        'salary_range',
        'salary',
        'job_type',
        'vacancies',
        'application_start_date',
        'application_end_date',
        'archived_at',
        'is_filled',
        'filled_at',
        'source_job_id',
        'requirements',
        'status',
        'approved_at',
        'approved_by',
        'rejection_reason',
    ];
    
    protected $attributes = [
        'status' => 'pending', // Default status for admin approval
    ];

    protected $casts = [
        'application_start_date' => 'datetime',
        'application_end_date' => 'datetime',
        'archived_at' => 'datetime',
        'filled_at' => 'datetime',
        'approved_at' => 'datetime',
        'is_filled' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'peso_job_id');
    }

    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function sourceJob()
    {
        return $this->belongsTo(self::class, 'source_job_id');
    }

    /**
     * Get the company profile for this job's employer
     */
    public function companyProfile()
    {
        return $this->employer()?->first()?->companyProfile();
    }
}
?>

