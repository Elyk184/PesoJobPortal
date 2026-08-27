<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssociationRequest extends Model
{
    protected $fillable = [
        'user_id', 'subject', 'details', 'association_name',
        'contact_person', 'contact_number', 'email', 'address',
        'request_type', 'document_path', 'status', 'notes',
    ];

    protected $casts = ['notes' => 'array'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
