<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecommendedJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_id',
        'match_score',
        'reason',
    ];

    protected $casts = [
        'match_score' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function job()
    {
        return $this->belongsTo(PesoJob::class, 'job_id');
    }
}
