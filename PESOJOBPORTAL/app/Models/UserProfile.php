<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'resume_name',
        'resume_email',
        'phone',
        'address',
        'resume_path',
        'skills',
        'education',
        'experience',
        'objective',
        'photo_path',
    ];

    protected $casts = [
        'skills' => 'array',
        'education' => 'array',
        'experience' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
?>

