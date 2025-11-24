<?php

namespace App\Notifications\Forum;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\ForumComment;

class NewCommentNotification extends Notification
{
    use Queueable;

    public function __construct(
        public ForumComment $comment
    ) {}

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'forum_new_comment',
            'comment_id' => $this->comment->id,
            'post_id' => $this->comment->post_id,
            'post_title' => $this->comment->post->title,
            'subreddit_slug' => $this->comment->post->subreddit->slug,
            'commenter_id' => $this->comment->user_id,
            'commenter_name' => $this->comment->user->name,
            'commenter_avatar' => $this->comment->user->avatar,
            'comment_excerpt' => \Str::limit($this->comment->content, 100),
            'url' => route('forum.post.show', [$this->comment->post->subreddit, $this->comment->post]),
            'created_at' => $this->comment->created_at->toISOString(),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
