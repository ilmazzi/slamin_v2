<?php

namespace App\Notifications;

use App\Models\GroupInvitation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class GroupInvitationResponseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public GroupInvitation $invitation,
        public string $response // 'accepted' or 'declined'
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $messageKey = $this->response === 'accepted' 
            ? 'groups.notification.invitation_accepted_message'
            : 'groups.notification.invitation_declined_message';

        return [
            'title' => __('groups.notification.invitation_response'),
            'message' => __($messageKey, [
                'user' => $this->invitation->user->name,
                'group' => $this->invitation->group->name
            ]),
            'icon' => $this->response === 'accepted' ? '✅' : '❌',
            'url' => route('groups.show', $this->invitation->group),
            'sender_name' => $this->invitation->user->name,
            'group_name' => $this->invitation->group->name,
        ];
    }
}

