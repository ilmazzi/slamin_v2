<?php

namespace App\Mail;

use App\Models\NewsletterSubscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $content;
    public $subscriber;

    /**
     * Create a new message instance.
     */
    public function __construct($subject, $content, NewsletterSubscriber $subscriber = null)
    {
        $this->subject = $subject;
        $this->content = $content;
        $this->subscriber = $subscriber;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.newsletter',
            with: [
                'content' => $this->content,
                'subscriber' => $this->subscriber,
                'unsubscribeUrl' => $this->subscriber 
                    ? route('newsletter.unsubscribe', ['token' => $this->subscriber->unsubscribe_token])
                    : null,
            ],
        );
    }
}
