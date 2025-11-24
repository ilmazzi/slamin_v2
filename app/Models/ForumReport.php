<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ForumReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'reporter_id',
        'reportable_type',
        'reportable_id',
        'reason',
        'description',
        'status',
        'handled_by',
        'resolved_at',
        'moderator_notes',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    // Relationships
    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function reportable(): MorphTo
    {
        return $this->morphTo();
    }

    public function target(): MorphTo
    {
        return $this->reportable();
    }

    public function handler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    public function handledBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    // Helper methods
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isReviewed(): bool
    {
        return $this->status === 'reviewed';
    }

    public function isResolved(): bool
    {
        return $this->status === 'resolved';
    }

    public function isDismissed(): bool
    {
        return $this->status === 'dismissed';
    }

    public function markAsReviewed(User $user): void
    {
        $this->status = 'reviewed';
        $this->handled_by = $user->id;
        $this->handled_at = now();
        $this->save();
    }

    public function resolve(User $user, ?string $notes = null): void
    {
        $this->status = 'resolved';
        $this->handled_by = $user->id;
        $this->resolved_at = now();
        if ($notes) {
            $this->moderator_notes = $notes;
        }
        $this->save();
    }

    public function dismiss(User $user, ?string $notes = null): void
    {
        $this->status = 'dismissed';
        $this->handled_by = $user->id;
        $this->resolved_at = now();
        if ($notes) {
            $this->moderator_notes = $notes;
        }
        $this->save();
    }
}

