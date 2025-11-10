<?php

namespace App\Notifications;

use App\Models\GigApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class GigApplicationReceived extends Notification implements ShouldQueue
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
        return [
            'type' => 'gig_application',
            'title' => __('notifications.gig_application_received_title'),
            'message' => __('notifications.gig_application_received_message', [
                'user' => $this->application->user->name,
                'gig' => $this->application->gig->title,
            ]),
            'url' => route('gigs.applications', $this->application->gig),
            'application_id' => $this->application->id,
            'gig_id' => $this->application->gig->id,
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'type' => 'gig_application',
            'title' => __('notifications.gig_application_received_title'),
            'message' => __('notifications.gig_application_received_message', [
                'user' => $this->application->user->name,
                'gig' => $this->application->gig->title,
            ]),
            'url' => route('gigs.applications', $this->application->gig),
        ]);
    }
}
