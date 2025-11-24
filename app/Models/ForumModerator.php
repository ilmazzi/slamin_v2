<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ForumModerator extends Model
{
    use HasFactory;

    protected $fillable = [
        'subreddit_id',
        'user_id',
        'role',
        'permissions',
        'added_by',
    ];

    protected $casts = [
        'permissions' => 'array',
    ];

    // Relationships
    public function subreddit(): BelongsTo
    {
        return $this->belongsTo(Subreddit::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    // Helper methods
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isModerator(): bool
    {
        return $this->role === 'moderator';
    }

    public function hasPermission(string $permission): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        return in_array($permission, $this->permissions ?? []);
    }
}

