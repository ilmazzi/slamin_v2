<?php

namespace App\Notifications;

use App\Models\GroupJoinRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GroupJoinRequestNotification extends Notification // Rimosso ShouldQueue per invio immediato
{
    use Queueable;

    public function __construct(
        public GroupJoinRequest $request
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => __('groups.notification.join_request_received'),
            'message' => __('groups.notification.join_request_message', [
                'user' => $this->request->user->name,
                'group' => $this->request->group->name
            ]),
            'icon' => '👋',
            'url' => route('groups.requests.pending', $this->request->group),
            'sender_name' => $this->request->user->name,
            'group_name' => $this->request->group->name,
        ];
    }
}

