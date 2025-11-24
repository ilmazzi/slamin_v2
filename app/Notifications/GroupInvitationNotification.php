<?php

namespace App\Notifications;

use App\Models\GroupInvitation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GroupInvitationNotification extends Notification // Rimosso ShouldQueue per invio immediato
{
    use Queueable;

    public function __construct(
        public GroupInvitation $invitation
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => __('groups.notification.invitation_received'),
            'message' => __('groups.notification.invitation_message', [
                'inviter' => $this->invitation->invitedBy->name,
                'group' => $this->invitation->group->name
            ]),
            'icon' => '📨',
            'url' => route('group-invitations.show', $this->invitation),
            'sender_name' => $this->invitation->invitedBy->name,
            'group_name' => $this->invitation->group->name,
        ];
    }
}

