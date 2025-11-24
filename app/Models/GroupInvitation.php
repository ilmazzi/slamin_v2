<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupInvitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'user_id',
        'invited_by',
        'status',
        'message',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function invitedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function accept()
    {
        $this->update([
            'status' => 'accepted',
        ]);

        // Aggiungi l'utente al gruppo
        GroupMember::create([
            'group_id' => $this->group_id,
            'user_id' => $this->user_id,
            'role' => 'member',
        ]);
    }

    public function decline()
    {
        $this->update([
            'status' => 'declined',
        ]);
    }

    /**
     * Verifica se l'invito è scaduto
     */
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Marca l'invito come scaduto
     */
    public function markAsExpired(): void
    {
        $this->update(['status' => 'expired']);
    }
}
