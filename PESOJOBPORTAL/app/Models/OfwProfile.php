<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OfwProfile extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'birthdate',
        'sex',
        'civil_status',
        'religion',
        'contact_number',
        'email',
        'passport_number',
        'facebook_name',
        'address_philippines',
        'address_abroad',
        'employer_name',
        'jobsite_country',
        'monthly_salary',
        'local_agency',
        'foreign_agency',
    ];

    protected $casts = [
        'birthdate' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
