<?php

namespace App\Notifications\Forum;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\ForumComment;
use App\Models\User;

class CommentVotedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public ForumComment $comment,
        public User $voter,
        public string $voteType
    ) {}

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'forum_comment_voted',
            'comment_id' => $this->comment->id,
            'post_id' => $this->comment->post_id,
            'post_title' => $this->comment->post->title,
            'subreddit_slug' => $this->comment->post->subreddit->slug,
            'voter_id' => $this->voter->id,
            'voter_name' => $this->voter->name,
            'voter_avatar' => $this->voter->avatar,
            'vote_type' => $this->voteType,
            'comment_excerpt' => \Str::limit($this->comment->content, 100),
            'current_score' => $this->comment->score,
            'url' => route('forum.post.show', [$this->comment->post->subreddit, $this->comment->post]),
            'created_at' => now()->toISOString(),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
