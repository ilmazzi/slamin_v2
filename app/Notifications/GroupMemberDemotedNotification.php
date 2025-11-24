<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\GroupMember;

class GroupMemberDemotedNotification extends Notification
{
    use Queueable;

    protected $member;
    protected $newRole;

    public function __construct(GroupMember $member, string $newRole)
    {
        $this->member = $member;
        $this->newRole = $newRole;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        $roleNames = [
            'admin' => 'Amministratore',
            'moderator' => 'Moderatore',
            'member' => 'Membro'
        ];

        return [
            'type' => 'group_member_demoted',
            'group_id' => $this->member->group_id,
            'group_name' => $this->member->group->name,
            'new_role' => $this->newRole,
            'new_role_name' => $roleNames[$this->newRole] ?? $this->newRole,
            'message' => "Il tuo ruolo nel gruppo \"{$this->member->group->name}\" è stato modificato a {$roleNames[$this->newRole]}",
            'url' => route('groups.show', $this->member->group_id),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}

