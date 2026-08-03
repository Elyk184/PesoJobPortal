<?php

namespace App\Models;

use App\Models\JobApplication;
use App\Models\EmployerNotification;
use App\Models\PesoJob;
use App\Models\PesoClearance;
use App\Models\RecruitmentActivityRequest;
use App\Models\UserProfile;
use App\Models\UserNotification;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'role',
        'profile_photo',
        'is_approved',
        'approved_at',
        'approved_by',
        'rejection_reason',
        'rejected_at',
        'rejected_by',
    ];

    public function redirectToDashboard(): string
    {
        return match($this->role) {
            'admin'    => route('admin.dashboard'),
            'employer' => route('employer.dashboard'),
            'ofw'      => route('ofw.dashboard'),
            default    => route('jobseeker.dashboard'),
        };
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_approved' => 'boolean',
            'approved_at' => 'datetime',
            'rejected_at' => 'datetime',
        ];
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function companyProfile()
    {
        return $this->hasOne(CompanyProfile::class);
    }

    public function jobseekerProfile()
    {
        return $this->hasOne(JobseekerProfile::class);
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    public function employerNotifications(): HasMany
    {
        return $this->hasMany(EmployerNotification::class, 'employer_id');
    }

    public function userNotifications(): HasMany
    {
        return $this->hasMany(UserNotification::class);
    }

    public function pesoClearances(): HasMany
    {
        return $this->hasMany(PesoClearance::class);
    }
}

