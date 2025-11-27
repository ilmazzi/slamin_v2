<?php

namespace App\Notifications;

use App\Models\EventInvitation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class EventInvitationNotification extends Notification
{
    use Queueable;

    public function __construct(
        public EventInvitation $invitation
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(object $notifiable): array
    {
        $roleLabel = match($this->invitation->role) {
            'performer' => __('events.invitation.role_performer'),
            'organizer' => __('events.invitation.role_organizer'),
            'audience' => __('events.invitation.role_audience'),
            default => __('events.invitation.role_participant'),
        };

        return [
            'type' => 'event_invitation',
            'title' => __('events.invitation.notification_title'),
            'message' => __('events.invitation.notification_message', [
                'inviter' => $this->invitation->inviter->name,
                'event' => $this->invitation->event->title,
                'role' => $roleLabel
            ]),
            'icon' => '📅',
            'url' => route('events.show', $this->invitation->event),
            'sender_name' => $this->invitation->inviter->name,
            'event_title' => $this->invitation->event->title,
            'event_id' => $this->invitation->event->id,
            'invitation_id' => $this->invitation->id,
            'role' => $this->invitation->role,
        ];
    }
}

