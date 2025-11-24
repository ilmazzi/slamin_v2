<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ForumBan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subreddit_id',
        'reason',
        'type',
        'expires_at',
        'banned_by',
        'is_active',
        'lifted_at',
        'lifted_by',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'lifted_at' => 'datetime',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subreddit(): BelongsTo
    {
        return $this->belongsTo(Subreddit::class);
    }

    public function bannedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'banned_by');
    }

    public function liftedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'lifted_by');
    }

    // Helper methods
    public function isPermanent(): bool
    {
        return $this->type === 'permanent';
    }

    public function isTemporary(): bool
    {
        return $this->type === 'temporary';
    }

    public function isExpired(): bool
    {
        if ($this->isPermanent()) {
            return false;
        }

        return $this->expires_at && $this->expires_at->isPast();
    }

    public function isGlobal(): bool
    {
        return is_null($this->subreddit_id);
    }

    public function lift(User $user): void
    {
        $this->is_active = false;
        $this->lifted_at = now();
        $this->lifted_by = $user->id;
        $this->save();
    }
}

