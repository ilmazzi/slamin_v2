<?php

namespace App\Notifications;

use App\Models\GroupJoinRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class GroupJoinRequestResponseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public GroupJoinRequest $request,
        public string $response // 'accepted' or 'declined'
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $messageKey = $this->response === 'accepted' 
            ? 'groups.notification.request_accepted_message'
            : 'groups.notification.request_declined_message';

        return [
            'title' => __('groups.notification.request_response'),
            'message' => __($messageKey, [
                'group' => $this->request->group->name
            ]),
            'icon' => $this->response === 'accepted' ? '✅' : '❌',
            'url' => route('groups.show', $this->request->group),
            'group_name' => $this->request->group->name,
        ];
    }
}

