<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'peso_job_id',
        'is_referred',
        'status',
        'employer_status',
        'final_decision',
        'notes',
        'employer_feedback',
        'admin_status',
        'admin_approved_at',
        'admin_approved_by',
        'admin_notes',
    ];

    protected $casts = [
        'applied_at' => 'datetime',
        'admin_approved_at' => 'datetime',
        'is_referred' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function job()
    {
        return $this->belongsTo(PesoJob::class, 'peso_job_id');
    }

    public function jobPost()
    {
        return $this->belongsTo(PesoJob::class, 'peso_job_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'admin_approved_by');
    }
}
?>

