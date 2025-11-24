<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Conversation extends Model
{
    protected $fillable = [
        'type',
        'name',
        'description',
        'avatar',
    ];

    /**
     * Get all messages for the conversation
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'asc');
    }

    /**
     * Get all participants in the conversation
     */
    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }

    /**
     * Get all users in the conversation
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'participants')
            ->withPivot('role', 'last_read_at')
            ->withTimestamps();
    }

    /**
     * Get the latest message
     */
    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    /**
     * Get unread messages count for a user
     */
    public function unreadCount(User $user): int
    {
        $participant = $this->participants()
            ->where('user_id', $user->id)
            ->first();

        if (!$participant || !$participant->last_read_at) {
            return $this->messages()->count();
        }

        return $this->messages()
            ->where('created_at', '>', $participant->last_read_at)
            ->where('user_id', '!=', $user->id)
            ->count();
    }

    /**
     * Mark conversation as read for a user
     */
    public function markAsRead(User $user): void
    {
        $this->participants()
            ->where('user_id', $user->id)
            ->update(['last_read_at' => now()]);
    }

    /**
     * Check if user is participant
     */
    public function hasParticipant(User $user): bool
    {
        return $this->participants()
            ->where('user_id', $user->id)
            ->exists();
    }

    /**
     * Get other participant (for private conversations)
     */
    public function getOtherParticipant(User $currentUser)
    {
        if ($this->type !== 'private') {
            return null;
        }

        return $this->users()
            ->where('users.id', '!=', $currentUser->id)
            ->first();
    }

    /**
     * Get conversation name for display
     */
    public function getDisplayName(User $currentUser): string
    {
        if ($this->type === 'group') {
            return $this->name ?? 'Gruppo';
        }

        $otherUser = $this->getOtherParticipant($currentUser);
        return $otherUser ? $otherUser->name : 'Utente';
    }

    /**
     * Get conversation avatar
     */
    public function getDisplayAvatar(User $currentUser): ?string
    {
        if ($this->type === 'group' && $this->avatar) {
            return $this->avatar;
        }

        if ($this->type === 'private') {
            $otherUser = $this->getOtherParticipant($currentUser);
            return $otherUser ? $otherUser->profile_photo : null;
        }

        return null;
    }

    /**
     * Create or get private conversation between two users
     */
    public static function createOrGetPrivate(User $user1, User $user2): self
    {
        // Check if conversation already exists
        $conversation = self::whereHas('participants', function ($query) use ($user1) {
            $query->where('user_id', $user1->id);
        })
        ->whereHas('participants', function ($query) use ($user2) {
            $query->where('user_id', $user2->id);
        })
        ->where('type', 'private')
        ->first();

        if ($conversation) {
            return $conversation;
        }

        // Create new conversation
        $conversation = self::create(['type' => 'private']);
        
        $conversation->participants()->createMany([
            ['user_id' => $user1->id, 'role' => 'member'],
            ['user_id' => $user2->id, 'role' => 'member'],
        ]);

        return $conversation;
    }
}
