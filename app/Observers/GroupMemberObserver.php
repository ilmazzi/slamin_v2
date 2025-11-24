<?php

namespace App\Observers;

use App\Models\GroupMember;
use Illuminate\Support\Facades\Log;

class GroupMemberObserver
{
    /**
     * Handle the GroupMember "created" event.
     */
    public function created(GroupMember $member): void
    {
        Log::info('Group member added', [
            'group_id' => $member->group_id,
            'user_id' => $member->user_id,
            'role' => $member->role
        ]);

        // TODO: Invia notifica al nuovo membro
        // TODO: Invia notifica agli admin del gruppo
    }

    /**
     * Handle the GroupMember "updated" event.
     */
    public function updated(GroupMember $member): void
    {
        if ($member->isDirty('role')) {
            Log::info('Group member role changed', [
                'group_id' => $member->group_id,
                'user_id' => $member->user_id,
                'old_role' => $member->getOriginal('role'),
                'new_role' => $member->role
            ]);

            // TODO: Invia notifica al membro per cambio ruolo
        }
    }

    /**
     * Handle the GroupMember "deleted" event.
     */
    public function deleted(GroupMember $member): void
    {
        Log::info('Group member removed', [
            'group_id' => $member->group_id,
            'user_id' => $member->user_id
        ]);

        // TODO: Invia notifica al membro rimosso
    }
}

