<?php

namespace App\Observers;

use App\Models\Group;
use App\Models\GroupMember;
use Illuminate\Support\Facades\Log;

class GroupObserver
{
    /**
     * Handle the Group "created" event.
     */
    public function created(Group $group): void
    {
        Log::info('Group created', ['group_id' => $group->id, 'name' => $group->name]);

        // Aggiungi automaticamente il creatore come admin
        if ($group->created_by) {
            GroupMember::firstOrCreate([
                'group_id' => $group->id,
                'user_id' => $group->created_by,
            ], [
                'role' => 'admin',
                'joined_at' => now(),
            ]);
        }
    }

    /**
     * Handle the Group "updated" event.
     */
    public function updated(Group $group): void
    {
        Log::info('Group updated', ['group_id' => $group->id]);
    }

    /**
     * Handle the Group "deleted" event.
     */
    public function deleted(Group $group): void
    {
        Log::info('Group deleted', ['group_id' => $group->id]);

        // Elimina tutti i membri
        $group->members()->delete();

        // Elimina tutti gli inviti
        $group->invitations()->delete();

        // Elimina tutte le richieste
        $group->joinRequests()->delete();

        // Elimina tutti gli annunci
        $group->announcements()->delete();
    }

    /**
     * Handle the Group "force deleted" event.
     */
    public function forceDeleted(Group $group): void
    {
        Log::info('Group force deleted', ['group_id' => $group->id]);
    }
}

