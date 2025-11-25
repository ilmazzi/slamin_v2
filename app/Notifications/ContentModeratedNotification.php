<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContentModeratedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $contentType;
    public $contentTitle;
    public $contentUrl;
    public $reason;
    public $notes;

    /**
     * Create a new notification instance.
     */
    public function __construct($contentType, $contentTitle, $contentUrl, $reason, $notes = null)
    {
        $this->contentType = $contentType;
        $this->contentTitle = $contentTitle;
        $this->contentUrl = $contentUrl;
        $this->reason = $reason;
        $this->notes = $notes;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        $contentTypeKey = strtolower($this->contentType);
        
        return [
            'type' => 'content_moderated',
            'content_type' => $this->contentType,
            'content_title' => $this->contentTitle,
            'content_url' => $this->contentUrl,
            'reason' => $this->reason,
            'notes' => $this->notes,
            'title' => __('notifications.content_moderated_title'),
            'message' => __('notifications.content_moderated_message', [
                'type' => __('common.' . $contentTypeKey),
                'title' => $this->contentTitle
            ]),
            'icon' => '⚠️',
        ];
    }
}
