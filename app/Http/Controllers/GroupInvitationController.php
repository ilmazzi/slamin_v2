<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupInvitation;
use App\Models\GroupMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupInvitationController extends Controller
{
    /**
     * Invia un invito a un utente
     */
    public function store(Request $request, Group $group)
    {
        // Verifica che l'utente sia moderatore o admin
        if (!$group->hasModerator(Auth::user())) {
            abort(403);
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);

        // Verifica se l'utente è già membro
        if ($group->hasMember($user)) {
            return back()->with('error', __('groups.user_already_member'));
        }

        // Verifica se c'è già un invito pendente
        if ($group->hasPendingInvitation($user)) {
            return back()->with('error', __('groups.invitation_already_sent'));
        }

        GroupInvitation::create([
            'group_id' => $group->id,
            'user_id' => $user->id,
            'invited_by' => Auth::id(),
            'status' => 'pending',
            'expires_at' => now()->addDays(7),
        ]);

        return back()->with('success', __('groups.invitation_sent'));
    }

    /**
     * Accetta un invito
     */
    public function accept(GroupInvitation $invitation)
    {
        // Verifica che l'invito sia per l'utente autenticato
        if ($invitation->user_id !== Auth::id()) {
            abort(403);
        }

        // Verifica che l'invito sia ancora pendente
        if ($invitation->status !== 'pending') {
            return back()->with('error', __('groups.invitation_not_valid'));
        }

        // Verifica che l'invito non sia scaduto
        if ($invitation->expires_at && $invitation->expires_at->isPast()) {
            $invitation->update(['status' => 'expired']);
            return back()->with('error', __('groups.invitation_expired'));
        }

        // Aggiungi l'utente al gruppo
        GroupMember::create([
            'group_id' => $invitation->group_id,
            'user_id' => Auth::id(),
            'role' => 'member',
        ]);

        // Aggiorna lo stato dell'invito
        $invitation->update(['status' => 'accepted']);

        return redirect()->route('groups.show', $invitation->group_id)
            ->with('success', __('groups.invitation_accepted'));
    }

    /**
     * Rifiuta un invito
     */
    public function decline(GroupInvitation $invitation)
    {
        // Verifica che l'invito sia per l'utente autenticato
        if ($invitation->user_id !== Auth::id()) {
            abort(403);
        }

        $invitation->update(['status' => 'declined']);

        return back()->with('success', __('groups.invitation_declined'));
    }
}
