<?php

namespace App\Notifications\Forum;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\ForumPost;
use App\Models\User;

class PostVotedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public ForumPost $post,
        public User $voter,
        public string $voteType // 'upvote' or 'downvote'
    ) {}

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'forum_post_voted',
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
            'subreddit_slug' => $this->post->subreddit->slug,
            'voter_id' => $this->voter->id,
            'voter_name' => $this->voter->name,
            'voter_avatar' => $this->voter->avatar,
            'vote_type' => $this->voteType,
            'current_score' => $this->post->score,
            'url' => route('forum.post.show', [$this->post->subreddit, $this->post]),
            'created_at' => now()->toISOString(),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
