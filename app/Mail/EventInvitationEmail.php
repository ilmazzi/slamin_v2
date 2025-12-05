<?php

namespace App\Mail;

use App\Models\Event;
use App\Models\EventInvitation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventInvitationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public EventInvitation $invitation;
    public Event $event;

    /**
     * Create a new message instance.
     */
    public function __construct(EventInvitation $invitation, Event $event)
    {
        $this->invitation = $invitation;
        $this->event = $event;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Sei stato invitato all\'evento "' . $this->event->title . '" su Slamin',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.event-invitation',
            with: [
                'invitation' => $this->invitation,
                'event' => $this->event,
                'inviter' => $this->invitation->inviter,
            ],
        );
    }
}

