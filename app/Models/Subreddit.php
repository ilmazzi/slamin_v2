<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Subreddit extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'rules',
        'icon',
        'banner',
        'color',
        'created_by',
        'is_active',
        'is_private',
        'subscribers_count',
        'posts_count',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_private' => 'boolean',
        'subscribers_count' => 'integer',
        'posts_count' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($subreddit) {
            if (empty($subreddit->slug)) {
                $subreddit->slug = Str::slug($subreddit->name);
            }
        });
    }

    // Relationships
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(ForumPost::class);
    }

    public function moderators(): HasMany
    {
        return $this->hasMany(ForumModerator::class);
    }

    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'subreddit_subscribers')
            ->withTimestamps();
    }

    public function bans(): HasMany
    {
        return $this->hasMany(ForumBan::class);
    }

    // Helper methods
    public function isModerator(User $user): bool
    {
        return $this->moderators()->where('user_id', $user->id)->exists();
    }

    public function isAdmin(User $user): bool
    {
        return $this->moderators()
            ->where('user_id', $user->id)
            ->where('role', 'admin')
            ->exists();
    }

    public function isSubscribed(User $user): bool
    {
        return $this->subscribers()->where('user_id', $user->id)->exists();
    }

    public function isBanned(User $user): bool
    {
        return $this->bans()
            ->where('user_id', $user->id)
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->exists();
    }

    public function canPost(User $user): bool
    {
        if ($this->isBanned($user)) {
            return false;
        }

        if ($this->is_private && !$this->isSubscribed($user) && !$this->isModerator($user)) {
            return false;
        }

        return true;
    }

    public function incrementPostsCount(): void
    {
        $this->increment('posts_count');
    }

    public function decrementPostsCount(): void
    {
        $this->decrement('posts_count');
    }

    public function incrementSubscribersCount(): void
    {
        $this->increment('subscribers_count');
    }

    public function decrementSubscribersCount(): void
    {
        $this->decrement('subscribers_count');
    }
}

