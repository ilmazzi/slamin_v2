<?php

namespace App\Notifications\Forum;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\ForumReport;

class CommentReportedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public ForumReport $report
    ) {}

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable): array
    {
        $comment = $this->report->target;
        
        return [
            'type' => 'forum_comment_reported',
            'report_id' => $this->report->id,
            'comment_id' => $comment->id,
            'post_id' => $comment->post_id,
            'post_title' => $comment->post->title,
            'subreddit_slug' => $comment->post->subreddit->slug,
            'reporter_id' => $this->report->reporter_id,
            'reporter_name' => $this->report->reporter->name,
            'reason' => $this->report->reason,
            'comment_excerpt' => \Str::limit($comment->content, 100),
            'url' => route('forum.moderation.reports', $comment->post->subreddit),
            'created_at' => $this->report->created_at->toISOString(),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
