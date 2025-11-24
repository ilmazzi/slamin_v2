<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\Group;
use App\Models\User;

class GroupMemberRemovedNotification extends Notification
{
    use Queueable;

    protected $group;
    protected $removedBy;

    public function __construct(Group $group, User $removedBy)
    {
        $this->group = $group;
        $this->removedBy = $removedBy;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'group_member_removed',
            'group_id' => $this->group->id,
            'group_name' => $this->group->name,
            'removed_by' => $this->removedBy->name,
            'message' => "Sei stato rimosso dal gruppo \"{$this->group->name}\" da {$this->removedBy->name}",
            'url' => route('groups.index'),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}

