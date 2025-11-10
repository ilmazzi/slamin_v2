<?php

namespace App\Notifications;

use App\Models\GigApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class GigApplicationAccepted extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public GigApplication $application
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(object $notifiable): array
    {
        $gigOwner = $this->application->gig->requester ?? $this->application->gig->user;
        
        return [
            'type' => 'application_accepted',
            'title' => __('notifications.application_accepted_title'),
            'message' => __('notifications.application_accepted_message', [
                'gig' => $this->application->gig->title,
            ]),
            'url' => route('gigs.show', $this->application->gig),
            'application_id' => $this->application->id,
            'gig_id' => $this->application->gig->id,
            'sender_id' => $gigOwner?->id, // Gig owner who accepted
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'type' => 'application_accepted',
            'title' => __('notifications.application_accepted_title'),
            'message' => __('notifications.application_accepted_message', [
                'gig' => $this->application->gig->title,
            ]),
            'url' => route('gigs.show', $this->application->gig),
        ]);
    }
}
