<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyProfile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        // Company Basic Information
        'company_name',
        'business_name',
        'trade_name',
        'acronym_abbreviation',

        // Company Type & Classification
        'office_type',
        'employer_type_detail',
        'workforce_size',

        // Business Details
        'tin',
        'line_of_business',

        // Establishment Address
        'street_village',
        'barangay',
        'city_municipality',
        'province',

        // Establishment Contact Information
        'establishment_contact_person',
        'establishment_contact_position',
        'establishment_email',
        'establishment_phone',

        // Alternative Contact Information
        'contact_person_name',
        'contact_person_phone',

        // Company Documents & Media
        'logo_path',
        'business_permit_path',
        'dti_sec_registration_path',

        // Verification & Status
        'verification_status',
        'verification_notes',
        'verified_at',
        'verified_by',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the employer (user) who owns this company profile
     */
    public function employer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the admin who verified this company profile
     */
    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Get full address as a single string
     */
    public function getFullAddressAttribute(): string
    {
        return trim(implode(', ', array_filter([
            $this->street_village ?? null,
            $this->barangay ?? null,
            $this->city_municipality ?? null,
            $this->province ?? null,
        ]))) ?: 'Address not provided';
    }

    /**
     * Get full contact details
     */
    public function getFullContactAttribute(): string
    {
        $parts = [];
        if ($this->contact_person_name) {
            $parts[] = $this->contact_person_name;
        }
        if ($this->establishment_contact_position) {
            $parts[] = "({$this->establishment_contact_position})";
        }
        return implode(' ', $parts) ?: 'Contact information not provided';
    }
}
