<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ForumComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'parent_id',
        'user_id',
        'content',
        'original_language',
        'upvotes',
        'downvotes',
        'score',
        'depth',
        'is_deleted',
        'deleted_at',
        'deleted_by',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'upvotes' => 'integer',
        'downvotes' => 'integer',
        'score' => 'integer',
        'depth' => 'integer',
        'is_deleted' => 'boolean',
        'deleted_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    // Relationships
    public function post(): BelongsTo
    {
        return $this->belongsTo(ForumPost::class, 'post_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ForumComment::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(ForumComment::class, 'parent_id')->orderBy('score', 'desc');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function deleter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function votes(): MorphMany
    {
        return $this->morphMany(ForumVote::class, 'voteable');
    }

    public function reports(): MorphMany
    {
        return $this->morphMany(ForumReport::class, 'target');
    }

    // Helper methods
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
        if ($user->id === $this->user_id && !$this->is_deleted) {
            return true;
        }

        return false;
    }

    public function canDelete(User $user): bool
    {
        if ($user->id === $this->user_id) {
            return true;
        }

        return $this->post->subreddit->isModerator($user);
    }

    public function softDelete(User $user): void
    {
        $this->is_deleted = true;
        $this->deleted_at = now();
        $this->deleted_by = $user->id;
        $this->save();
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

