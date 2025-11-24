<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupJoinRequest;
use App\Models\GroupMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupJoinRequestController extends Controller
{
    /**
     * Approva una richiesta di accesso
     */
    public function approve(Group $group, GroupJoinRequest $request)
    {
        // Verifica che l'utente sia moderatore o admin
        if (!$group->hasModerator(Auth::user())) {
            abort(403);
        }

        // Verifica che la richiesta sia ancora pendente
        if ($request->status !== 'pending') {
            return back()->with('error', __('groups.request_not_valid'));
        }

        // Aggiungi l'utente al gruppo
        GroupMember::create([
            'group_id' => $group->id,
            'user_id' => $request->user_id,
            'role' => 'member',
        ]);

        // Aggiorna lo stato della richiesta
        $request->update(['status' => 'accepted']);

        return back()->with('success', __('groups.request_approved'));
    }

    /**
     * Rifiuta una richiesta di accesso
     */
    public function decline(Group $group, GroupJoinRequest $request)
    {
        // Verifica che l'utente sia moderatore o admin
        if (!$group->hasModerator(Auth::user())) {
            abort(403);
        }

        $request->update(['status' => 'declined']);

        return back()->with('success', __('groups.request_declined'));
    }
}
