<?php

namespace App\Notifications;

use App\Models\GroupAnnouncement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GroupAnnouncementNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public GroupAnnouncement $announcement
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => __('groups.notification.new_announcement'),
            'message' => __('groups.notification.announcement_message', [
                'group' => $this->announcement->group->name,
                'title' => $this->announcement->title
            ]),
            'icon' => '📢',
            'url' => route('groups.announcements.show', [$this->announcement->group, $this->announcement]),
            'sender_name' => $this->announcement->user->name,
            'group_name' => $this->announcement->group->name,
        ];
    }
}

