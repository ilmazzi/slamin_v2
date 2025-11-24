<?php

namespace App\Notifications\Forum;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\ForumModerator;

class ModeratorAddedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public ForumModerator $moderator
    ) {}

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'forum_moderator_added',
            'moderator_id' => $this->moderator->id,
            'subreddit_name' => $this->moderator->subreddit->name,
            'subreddit_slug' => $this->moderator->subreddit->slug,
            'role' => $this->moderator->role,
            'added_by_name' => $this->moderator->addedBy->name,
            'url' => route('forum.subreddit.show', $this->moderator->subreddit),
            'created_at' => $this->moderator->created_at->toISOString(),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
