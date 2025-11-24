<?php

namespace App\Notifications\Forum;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\ForumComment;

class NewReplyNotification extends Notification
{
    use Queueable;

    public function __construct(
        public ForumComment $reply
    ) {}

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'forum_new_reply',
            'reply_id' => $this->reply->id,
            'parent_comment_id' => $this->reply->parent_id,
            'post_id' => $this->reply->post_id,
            'post_title' => $this->reply->post->title,
            'subreddit_slug' => $this->reply->post->subreddit->slug,
            'replier_id' => $this->reply->user_id,
            'replier_name' => $this->reply->user->name,
            'replier_avatar' => $this->reply->user->avatar,
            'reply_excerpt' => \Str::limit($this->reply->content, 100),
            'url' => route('forum.post.show', [$this->reply->post->subreddit, $this->reply->post]),
            'created_at' => $this->reply->created_at->toISOString(),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
