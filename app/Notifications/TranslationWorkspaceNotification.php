<?php

namespace App\Notifications;

use App\Models\PoemTranslation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TranslationWorkspaceNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $translation;
    protected $type;

    /**
     * Create a new notification instance.
     */
    public function __construct(PoemTranslation $translation, string $type)
    {
        $this->translation = $translation;
        $this->type = $type;
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
        $messages = [
            'translation_updated' => [
                'title' => '📝 Traduzione Aggiornata',
                'message' => 'La traduzione è stata modificata',
                'icon' => '✏️',
            ],
            'comment_added' => [
                'title' => '💬 Nuovo Commento',
                'message' => 'È stato aggiunto un commento alla traduzione',
                'icon' => '💬',
            ],
            'submitted_for_review' => [
                'title' => '📤 Traduzione Inviata',
                'message' => 'La traduzione è stata inviata per la tua revisione',
                'icon' => '📤',
            ],
            'translation_approved' => [
                'title' => '✅ Traduzione Approvata',
                'message' => 'La tua traduzione è stata approvata!',
                'icon' => '✅',
            ],
            'comment_resolved' => [
                'title' => '✓ Commento Risolto',
                'message' => 'Un commento è stato risolto',
                'icon' => '✓',
            ],
        ];

        $data = $messages[$this->type] ?? [
            'title' => 'Aggiornamento Traduzione',
            'message' => 'C\'è un aggiornamento sulla traduzione',
            'icon' => '🔔',
        ];

        return [
            'title' => $data['title'],
            'message' => $data['message'],
            'icon' => $data['icon'],
            'poem_title' => $this->translation->poem->title,
            'translation_id' => $this->translation->id,
            'application_id' => $this->translation->gig_application_id,
            'url' => route('gigs.workspace', $this->translation->gig_application_id),
            'type' => $this->type,
        ];
    }
}
