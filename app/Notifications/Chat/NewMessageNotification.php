<?php

namespace App\Notifications\Chat;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use App\Models\Message;
use App\Models\User;

class NewMessageNotification extends Notification
{
    use Queueable;

    public $message;
    public $sender;

    public function __construct(Message $message, User $sender)
    {
        $this->message = $message;
        $this->sender = $sender;
    }

    public function via(object $notifiable): array
    {
        // Only broadcast, don't save to database
        // Chat messages are shown only in the chat widget badge
        return ['broadcast'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'chat_new_message',
            'message_id' => $this->message->id,
            'conversation_id' => $this->message->conversation_id,
            'sender_id' => $this->sender->id,
            'sender_name' => $this->sender->name,
            'sender_avatar' => $this->sender->profile_photo_url,
            'message_preview' => \Str::limit($this->message->body, 60),
            'message_type' => $this->message->type,
            'title' => __('chat.new_message_from', ['name' => $this->sender->name]),
            'message' => \Str::limit($this->message->body, 100),
            'icon' => '💬',
            'url' => route('chat.show', $this->message->conversation_id),
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'type' => 'chat_new_message',
            'message_id' => $this->message->id,
            'conversation_id' => $this->message->conversation_id,
            'sender_id' => $this->sender->id,
            'sender_name' => $this->sender->name,
            'sender_avatar' => $this->sender->profile_photo_url,
            'message_preview' => \Str::limit($this->message->body, 60),
            'message_type' => $this->message->type,
            'title' => __('chat.new_message_from', ['name' => $this->sender->name]),
            'message' => \Str::limit($this->message->body, 100),
            'icon' => '💬',
            'url' => route('chat.show', $this->message->conversation_id),
        ]);
    }
}
