<?php

namespace App\Notifications\Forum;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\User;

class PostRemovedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $postTitle,
        public string $subredditName,
        public User $moderator,
        public ?string $reason = null
    ) {}

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'forum_post_removed',
            'post_title' => $this->postTitle,
            'subreddit_name' => $this->subredditName,
            'moderator_id' => $this->moderator->id,
            'moderator_name' => $this->moderator->name,
            'reason' => $this->reason,
            'created_at' => now()->toISOString(),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
