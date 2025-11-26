<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserStartedTyping implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $roomId;
    public $userId;
    public $userName;
    public $typingUsers;

    /**
     * Create a new event instance.
     */
    public function __construct($roomId, $userId, $userName, $typingUsers = [])
    {
        $this->roomId = $roomId;
        $this->userId = $userId;
        $this->userName = $userName;
        $this->typingUsers = $typingUsers;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('conversation.' . $this->roomId),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'user.started.typing';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'user_id' => $this->userId,
            'user_name' => $this->userName,
            'typing_users' => $this->typingUsers,
        ];
    }
}
