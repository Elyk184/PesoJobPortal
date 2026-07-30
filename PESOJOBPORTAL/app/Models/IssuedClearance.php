<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssuedClearance extends Model
{
    use HasFactory;

    protected $table = 'issued_clearances';

    protected $fillable = [
        'peso_clearance_id',
        'user_id',
        'clearance_number',
        'company_name',
        'residence_address',
        'document_path',
        'status',
        'issued_at',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
    ];

    public function pesoClearance()
    {
        return $this->belongsTo(PesoClearance::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}