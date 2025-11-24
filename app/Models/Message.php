<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Message extends Model
{
    protected $fillable = [
        'conversation_id',
        'user_id',
        'body',
        'type',
        'metadata',
        'reply_to',
    ];

    protected $casts = [
        'metadata' => 'array',
        'created_at' => 'datetime',
    ];

    /**
     * Get the conversation that owns the message
     */
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * Get the user that sent the message
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the message this is replying to
     */
    public function replyTo(): BelongsTo
    {
        return $this->belongsTo(Message::class, 'reply_to');
    }

    /**
     * Get all replies to this message
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Message::class, 'reply_to');
    }

    /**
     * Check if message is from user
     */
    public function isFromUser(User $user): bool
    {
        return $this->user_id === $user->id;
    }

    /**
     * Get formatted time
     */
    public function getFormattedTimeAttribute(): string
    {
        $now = now();
        $created = $this->created_at;

        if ($created->isToday()) {
            return $created->format('H:i');
        }

        if ($created->isYesterday()) {
            return 'Ieri ' . $created->format('H:i');
        }

        if ($created->diffInDays($now) < 7) {
            return $created->locale('it')->isoFormat('dddd H:mm');
        }

        return $created->format('d/m/Y H:i');
    }

    /**
     * Get attachment URL if exists
     */
    public function getAttachmentUrl(): ?string
    {
        if ($this->type === 'image' && isset($this->metadata['path'])) {
            return \Storage::url($this->metadata['path']);
        }

        if ($this->type === 'file' && isset($this->metadata['path'])) {
            return \Storage::url($this->metadata['path']);
        }

        return null;
    }

    /**
     * Get file name if exists
     */
    public function getFileName(): ?string
    {
        return $this->metadata['filename'] ?? null;
    }

    /**
     * Get file size if exists
     */
    public function getFileSize(): ?string
    {
        if (!isset($this->metadata['size'])) {
            return null;
        }

        $bytes = $this->metadata['size'];
        
        if ($bytes < 1024) {
            return $bytes . ' B';
        } elseif ($bytes < 1048576) {
            return round($bytes / 1024, 2) . ' KB';
        } else {
            return round($bytes / 1048576, 2) . ' MB';
        }
    }
}
