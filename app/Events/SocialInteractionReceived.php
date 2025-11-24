<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class SocialInteractionReceived implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $interaction;
    public $interactor;
    public $contentOwner;
    public $content;
    public $type; // 'comment' or 'like'

    /**
     * Create a new event instance.
     */
    public function __construct(Model $interaction, User $interactor, User $contentOwner, Model $content, string $type)
    {
        $this->interaction = $interaction;
        $this->interactor = $interactor;
        $this->contentOwner = $contentOwner;
        $this->content = $content;
        $this->type = $type;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('App.Models.User.' . $this->contentOwner->id),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'social-interaction';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        $contentType = $this->getContentTypeName();
        $contentTitle = $this->getContentTitle();

        return [
            'type' => $this->type,
            'interactor' => [
                'id' => $this->interactor->id,
                'name' => $this->interactor->name,
                'nickname' => $this->interactor->nickname,
                'avatar' => $this->interactor->profile_photo_url,
            ],
            'content' => [
                'type' => $contentType,
                'title' => $contentTitle,
                'url' => $this->getContentUrl(),
            ],
            'message' => $this->getNotificationMessage(),
        ];
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

    private function getNotificationMessage(): string
    {
        return match($this->type) {
            'comment' => __('notifications.comment_received_message', [
                'user' => $this->interactor->name,
                'type' => $this->getContentTypeName(),
                'title' => $this->getContentTitle()
            ]),
            'like' => __('notifications.like_received_message', [
                'user' => $this->interactor->name,
                'type' => $this->getContentTypeName(),
                'title' => $this->getContentTitle()
            ]),
            default => __('notifications.new_notification')
        };
    }
}