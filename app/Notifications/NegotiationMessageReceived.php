<?php

namespace App\Notifications;

use App\Models\PoemTranslationNegotiation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class NegotiationMessageReceived extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public PoemTranslationNegotiation $negotiation
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'negotiation_message',
            'title' => __('notifications.negotiation_message_title'),
            'message' => __('notifications.negotiation_message_message', [
                'user' => $this->negotiation->user->name,
                'gig' => $this->negotiation->gigApplication->gig->title,
            ]),
            'url' => route('gigs.show', $this->negotiation->gigApplication->gig),
            'negotiation_id' => $this->negotiation->id,
            'application_id' => $this->negotiation->gig_application_id,
            'gig_id' => $this->negotiation->gigApplication->gig->id,
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'type' => 'negotiation_message',
            'title' => __('notifications.negotiation_message_title'),
            'message' => __('notifications.negotiation_message_message', [
                'user' => $this->negotiation->user->name,
                'gig' => $this->negotiation->gigApplication->gig->title,
            ]),
            'url' => route('gigs.show', $this->negotiation->gigApplication->gig),
        ]);
    }
}
