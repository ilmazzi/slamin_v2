<?php

namespace App\Notifications\Forum;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\ForumReport;

class PostReportedNotification extends Notification
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
        $post = $this->report->target;
        
        return [
            'type' => 'forum_post_reported',
            'report_id' => $this->report->id,
            'post_id' => $post->id,
            'post_title' => $post->title,
            'subreddit_slug' => $post->subreddit->slug,
            'reporter_id' => $this->report->reporter_id,
            'reporter_name' => $this->report->reporter->name,
            'reason' => $this->report->reason,
            'description' => $this->report->description,
            'url' => route('forum.mod.reports', ['subreddit' => $post->subreddit->slug]),
            'created_at' => $this->report->created_at->toISOString(),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
