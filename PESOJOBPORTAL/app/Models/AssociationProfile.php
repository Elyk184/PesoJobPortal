<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssociationProfile extends Model
{
    protected $fillable = [
        'user_id',
        'association_name',
        'contact_person',
        'phone',
        'email',
        'address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
