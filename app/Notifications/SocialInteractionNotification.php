<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class SocialInteractionNotification extends Notification // implements ShouldQueue
{
    use Queueable;

    public $interaction;
    public $interactor;
    public $content;
    public $type;

    /**
     * Create a new notification instance.
     */
    public function __construct(Model $interaction, User $interactor, Model $content, string $type)
    {
        $this->interaction = $interaction;
        $this->interactor = $interactor;
        $this->content = $content;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        $contentType = $this->getContentTypeName();
        $contentTitle = $this->getContentTitle();

        return [
            'title' => $this->getNotificationTitle(),
            'message' => $this->getNotificationMessage(),
            'type' => 'social_interaction',
            'interaction_type' => $this->type,
            'sender_id' => $this->interactor->id,
            'content_type' => $contentType,
            'content_title' => $contentTitle,
            'url' => $this->getContentUrl(),
            'icon' => $this->type === 'comment' ? '💬' : '❤️',
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'title' => $this->getNotificationTitle(),
            'message' => $this->getNotificationMessage(),
            'type' => 'social_interaction',
            'interaction_type' => $this->type,
            'sender_id' => $this->interactor->id,
            'content_type' => $this->getContentTypeName(),
            'content_title' => $this->getContentTitle(),
            'url' => $this->getContentUrl(),
            'icon' => $this->type === 'comment' ? '💬' : '❤️',
        ]);
    }

    private function getContentTypeName(): string
    {
        return match(get_class($this->content)) {
            'App\Models\Poem' => 'poesia',
            'App\Models\Article' => 'articolo',
            'App\Models\Video' => 'video',
            'App\Models\Event' => 'evento',
            'App\Models\Photo' => 'foto',
            default => 'contenuto'
        };
    }

    private function getContentTitle(): string
    {
        return match(get_class($this->content)) {
            'App\Models\Poem' => $this->content->title ?: 'Senza titolo',
            'App\Models\Article' => $this->content->title,
            'App\Models\Video' => $this->content->title ?: 'Senza titolo',
            'App\Models\Event' => $this->content->title,
            'App\Models\Photo' => $this->content->title ?: 'Foto',
            default => 'Contenuto'
        };
    }

    private function getContentUrl(): string
    {
        return match(get_class($this->content)) {
            'App\Models\Poem' => route('poems.show', $this->content->slug),
            'App\Models\Article' => route('articles.show', $this->content->slug),
            'App\Models\Video' => route('videos.show', $this->content->uuid),
            'App\Models\Event' => route('events.show', $this->content->id),
            'App\Models\Photo' => route('photos.show', $this->content->id),
            default => '#'
        };
    }

    private function getNotificationTitle(): string
    {
        return match($this->type) {
            'comment' => __('notifications.comment_received_title'),
            'like' => __('notifications.like_received_title'),
            default => __('notifications.new_notification')
        };
    }

    private function getNotificationMessage(): string
    {
        $contentType = $this->getContentTypeName();
        $contentTitle = $this->getContentTitle();

        return match($this->type) {
            'comment' => __('notifications.comment_received_message', [
                'user' => $this->interactor->name,
                'type' => $contentType,
                'title' => $contentTitle
            ]),
            'like' => __('notifications.like_received_message', [
                'user' => $this->interactor->name,
                'type' => $contentType,
                'title' => $contentTitle
            ]),
            default => __('notifications.new_notification')
        };
    }
}