<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContactSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_code',
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'last_message_at',
        'replied_at',
        'portal_notification_id',
    ];

    protected function casts(): array
    {
        return [
            'last_message_at' => 'datetime',
            'replied_at' => 'datetime',
        ];
    }

    public function portalNotification(): BelongsTo
    {
        return $this->belongsTo(PortalNotification::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ContactSubmissionMessage::class)->orderBy('created_at');
    }
}
