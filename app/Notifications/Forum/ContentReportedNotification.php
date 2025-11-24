<?php

namespace App\Notifications\Forum;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\ForumReport;

class ContentReportedNotification extends Notification
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
        $target = $this->report->target;
        $isPost = $target instanceof \App\Models\ForumPost;
        
        return [
            'type' => 'forum_content_reported',
            'report_id' => $this->report->id,
            'content_type' => $isPost ? 'post' : 'comment',
            'content_id' => $target->id,
            'content_title' => $isPost ? $target->title : null,
            'content_excerpt' => $isPost ? \Str::limit($target->content ?? '', 100) : \Str::limit($target->content, 100),
            'subreddit_name' => $isPost ? $target->subreddit->name : $target->post->subreddit->name,
            'subreddit_slug' => $isPost ? $target->subreddit->slug : $target->post->subreddit->slug,
            'reason' => $this->report->reason,
            // NO reporter info - anonymous to author
            'url' => $isPost 
                ? route('forum.post.show', [$target->subreddit, $target])
                : route('forum.post.show', [$target->post->subreddit, $target->post]),
            'created_at' => $this->report->created_at->toISOString(),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
