<?php

namespace App\Notifications\Forum;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\ForumBan;

class UserBannedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public ForumBan $ban
    ) {}

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'forum_user_banned',
            'ban_id' => $this->ban->id,
            'subreddit_name' => $this->ban->subreddit->name,
            'subreddit_slug' => $this->ban->subreddit->slug,
            'reason' => $this->ban->reason,
            'is_permanent' => $this->ban->is_permanent,
            'expires_at' => $this->ban->expires_at?->toISOString(),
            'banned_by_name' => $this->ban->bannedBy->name,
            'created_at' => $this->ban->created_at->toISOString(),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
