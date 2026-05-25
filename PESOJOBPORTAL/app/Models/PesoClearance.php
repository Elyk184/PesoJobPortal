<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesoClearance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'request_date',
        'clearance_number',
        'issue_date',
        'expiry_date',
        'status',
        'remarks',
        'peso_clearance_assurance_receipt_path',
        'barangay_clearance_path',
        'is_first_time_jobseeker',
        'first_time_jobseeker_document_path',
        'document_path',
    ];

    protected $casts = [
        'request_date' => 'datetime',
        'issue_date' => 'datetime',
        'expiry_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

