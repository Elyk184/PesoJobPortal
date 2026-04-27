<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesoClearance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'clearance_number',
        'issue_date',
        'expiry_date',
        'status',
        'remarks',
    ];

    protected $casts = [
        'issue_date' => 'datetime',
        'expiry_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

