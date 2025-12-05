<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventInvitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'invited_user_id',
        'invited_email',
        'invited_name',
        'inviter_id',
        'role',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function invitedUser()
    {
        return $this->belongsTo(User::class, 'invited_user_id');
    }

    /**
     * Check if invitation is for a registered user
     */
    public function isForRegisteredUser(): bool
    {
        return !is_null($this->invited_user_id);
    }

    /**
     * Check if invitation is for a non-registered user (email only)
     */
    public function isForNonRegisteredUser(): bool
    {
        return is_null($this->invited_user_id) && !is_null($this->invited_email);
    }

    /**
     * Get the email of the invited person
     */
    public function getInvitedEmailAttribute($value)
    {
        if ($value) {
            return $value;
        }
        return $this->invitedUser?->email;
    }

    /**
     * Get the name of the invited person
     */
    public function getInvitedNameAttribute($value)
    {
        if ($value) {
            return $value;
        }
        return $this->invitedUser?->name;
    }

    public function inviter()
    {
        return $this->belongsTo(User::class, 'inviter_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    public function scopeDeclined($query)
    {
        return $query->where('status', 'declined');
    }

    // Helpers
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isAccepted()
    {
        return $this->status === 'accepted';
    }

    public function isDeclined()
    {
        return $this->status === 'declined';
    }
}

