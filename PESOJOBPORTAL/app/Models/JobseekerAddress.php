<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobseekerAddress extends Model
{
    use HasFactory;

    protected $table = 'jobseeker_addresses';

    protected $fillable = [
        'user_id',
        'type',
        'house_no',
        'barangay',
        'municipality',
        'province',
    ];
}