<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\JobApplication;
use Illuminate\Database\Eloquent\Model;

class PesoJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'employer_name',
        'location',
        'salary_range',
        'requirements',
        'status',
    ];

    protected $casts = [
        'requirements' => 'array',
    ];

    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'peso_job_id');
    }
}
?>

