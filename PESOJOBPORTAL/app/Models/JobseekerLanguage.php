<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobseekerLanguage extends Model
{
    use HasFactory;

    protected $table = 'jobseeker_languages';

    protected $fillable = [
        'user_id',
        'sort_order',
        'language',
        'other_specify',
        'can_read',
        'can_write',
        'can_speak',
        'can_understand',
    ];

    protected $casts = [
        'can_read' => 'boolean',
        'can_write' => 'boolean',
        'can_speak' => 'boolean',
        'can_understand' => 'boolean',
    ];
}