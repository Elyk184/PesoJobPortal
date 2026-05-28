<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobseekerPersonalInformation extends Model
{
    use HasFactory;

    protected $table = 'jobseeker_personal_information';

    protected $fillable = [
        'user_id',
        'first_name',
        'middle_initial',
        'surname',
        'suffix',
        'date_of_birth',
        'sex',
        'religion',
        'civil_status',
        'height',
        'tin',
        'contact_number',
        'email_address',
        'currently_in_school',
    ];

    protected $casts = [
        'currently_in_school' => 'boolean',
    ];
}