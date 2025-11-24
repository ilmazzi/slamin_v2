<?php

namespace App\Notifications\Forum;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\ForumPost;
use App\Models\User;

class PostApprovedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public ForumPost $post,
        public User $moderator
    ) {}

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'forum_post_approved',
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
            'subreddit_slug' => $this->post->subreddit->slug,
            'moderator_id' => $this->moderator->id,
            'moderator_name' => $this->moderator->name,
            'url' => route('forum.post.show', [$this->post->subreddit, $this->post]),
            'created_at' => now()->toISOString(),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
