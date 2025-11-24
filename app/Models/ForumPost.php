<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ForumPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'subreddit_id',
        'user_id',
        'title',
        'content',
        'type',
        'url',
        'image_path',
        'original_image_name',
        'upvotes',
        'downvotes',
        'score',
        'comments_count',
        'views_count',
        'is_sticky',
        'is_locked',
        'is_archived',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'upvotes' => 'integer',
        'downvotes' => 'integer',
        'score' => 'integer',
        'comments_count' => 'integer',
        'views_count' => 'integer',
        'is_sticky' => 'boolean',
        'is_locked' => 'boolean',
        'is_archived' => 'boolean',
        'approved_at' => 'datetime',
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

    public function comments(): HasMany
    {
        return $this->hasMany(ForumComment::class, 'post_id');
    }

    public function rootComments(): HasMany
    {
        return $this->comments()->whereNull('parent_id')->orderBy('score', 'desc');
    }

    public function votes(): MorphMany
    {
        return $this->morphMany(ForumVote::class, 'voteable');
    }

    public function reports(): MorphMany
    {
        return $this->morphMany(ForumReport::class, 'target');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Helper methods
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    public function incrementCommentsCount(): void
    {
        $this->increment('comments_count');
    }

    public function decrementCommentsCount(): void
    {
        $this->decrement('comments_count');
    }

    public function updateScore(): void
    {
        $this->score = $this->upvotes - $this->downvotes;
        $this->save();
    }

    public function getUserVote(User $user): ?string
    {
        $vote = $this->votes()->where('user_id', $user->id)->first();
        return $vote ? $vote->vote_type : null;
    }

    public function canEdit(User $user): bool
    {
        if ($user->id === $this->user_id) {
            return true;
        }

        return $this->subreddit->isModerator($user);
    }

    public function canDelete(User $user): bool
    {
        if ($user->id === $this->user_id) {
            return true;
        }

        return $this->subreddit->isModerator($user);
    }

    public function isApproved(): bool
    {
        return !is_null($this->approved_at);
    }

    public function approve(User $user): void
    {
        $this->approved_at = now();
        $this->approved_by = $user->id;
        $this->save();
    }
}

