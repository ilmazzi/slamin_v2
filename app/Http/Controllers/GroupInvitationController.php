<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupInvitation;
use App\Models\GroupMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupInvitationController extends Controller
{
    /**
     * Mostra gli inviti ricevuti dall'utente
     */
    public function index()
    {
        $user = Auth::user();

        $invitations = GroupInvitation::where('user_id', $user->id)
                           ->with(['group', 'invitedBy'])
                           ->orderBy('created_at', 'desc')
                           ->paginate(10);

        return view('groups.invitations.index', compact('invitations'));
    }

    /**
     * Mostra gli inviti inviati dall'utente
     */
    public function sent()
    {
        $user = Auth::user();

        $invitations = GroupInvitation::where('invited_by', $user->id)
                           ->with(['group', 'user'])
                           ->orderBy('created_at', 'desc')
                           ->paginate(10);

        return view('groups.invitations.sent', compact('invitations'));
    }

    /**
     * Mostra il form per creare un nuovo invito
     */
    public function create(Group $group)
    {
        $user = Auth::user();

        if (!$group->hasModerator($user)) {
            abort(403, __('groups.no_permission_invite'));
        }

        return view('groups.invitations.create', compact('group'));
    }

    /**
     * Crea un nuovo invito
     */
    public function store(Request $request, Group $group)
    {
        $user = Auth::user();

        if (!$group->hasModerator($user)) {
            abort(403, __('groups.no_permission_invite'));
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $invitedUser = \App\Models\User::findOrFail($request->user_id);

        // Verifica che l'utente non sia già membro del gruppo
        if ($group->hasMember($invitedUser)) {
            return back()->with('error', __('groups.user_already_member'));
        }

        // Verifica che non ci sia già un invito pendente
        $existingInvitation = GroupInvitation::where('group_id', $group->id)
                                            ->where('user_id', $invitedUser->id)
                                            ->where('status', 'pending')
                                            ->first();

        if ($existingInvitation) {
            return back()->with('error', __('groups.invitation_already_sent'));
        }

        // Crea l'invito
        GroupInvitation::create([
            'group_id' => $group->id,
            'user_id' => $invitedUser->id,
            'invited_by' => $user->id,
            'status' => 'pending',
            'expires_at' => now()->addDays(7),
        ]);

        return back()->with('success', __('groups.invitation_sent'));
    }

    /**
     * Mostra gli inviti pendenti di un gruppo (per admin/moderatori)
     */
    public function pending(Group $group)
    {
        $user = Auth::user();

        if (!$group->hasModerator($user)) {
            abort(403, __('groups.no_permission_view_invitations'));
        }

        $invitations = $group->getPendingInvitations()
                           ->with(['user', 'invitedBy'])
                           ->paginate(10);

        return view('groups.invitations.pending', compact('group', 'invitations'));
    }

    /**
     * Accetta un invito
     */
    public function accept(GroupInvitation $invitation)
    {
        $user = Auth::user();

        // Verifica che l'invito sia per l'utente corrente
        if ($invitation->user_id !== $user->id) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => __('groups.cannot_accept_others_invitation')], 403);
            }
            abort(403, __('groups.cannot_accept_others_invitation'));
        }

        // Verifica che l'invito sia pendente
        if (!$invitation->isPending()) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => __('groups.invitation_not_valid')], 400);
            }
            return back()->with('error', __('groups.invitation_not_valid'));
        }

        // Verifica che l'invito non sia scaduto
        if ($invitation->isExpired()) {
            $invitation->markAsExpired();
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => __('groups.invitation_expired')], 400);
            }
            return back()->with('error', __('groups.invitation_expired'));
        }

        // Verifica che l'utente non sia già membro del gruppo
        if ($invitation->group->hasMember($user)) {
            $invitation->update(['status' => 'accepted']);
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => __('groups.already_member')], 400);
            }
            return back()->with('error', __('groups.already_member'));
        }

        // Accetta l'invito (il metodo accept crea automaticamente il GroupMember)
        $invitation->accept();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('groups.invitation_accepted'),
                'redirect_url' => route('groups.show', $invitation->group)
            ]);
        }

        return redirect()->route('groups.show', $invitation->group)
                        ->with('success', __('groups.invitation_accepted'));
    }

    /**
     * Rifiuta un invito
     */
    public function decline(GroupInvitation $invitation)
    {
        $user = Auth::user();

        // Verifica che l'invito sia per l'utente corrente
        if ($invitation->user_id !== $user->id) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => __('groups.cannot_decline_others_invitation')], 403);
            }
            abort(403, __('groups.cannot_decline_others_invitation'));
        }

        // Verifica che l'invito sia pendente
        if (!$invitation->isPending()) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => __('groups.invitation_not_valid')], 400);
            }
            return back()->with('error', __('groups.invitation_not_valid'));
        }

        // Rifiuta l'invito
        $invitation->decline();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('groups.invitation_declined')
            ]);
        }

        return back()->with('success', __('groups.invitation_declined'));
    }

    /**
     * Cancella un invito (per chi l'ha inviato)
     */
    public function cancel(GroupInvitation $invitation)
    {
        $user = Auth::user();

        // Verifica che l'utente sia chi ha inviato l'invito o admin del gruppo
        if ($invitation->invited_by !== $user->id && !$invitation->group->hasAdmin($user)) {
            abort(403, __('groups.cannot_cancel_others_invitation'));
        }

        // Verifica che l'invito sia pendente
        if (!$invitation->isPending()) {
            return back()->with('error', __('groups.invitation_not_valid'));
        }

        $invitation->delete();

        return back()->with('success', __('groups.invitation_cancelled'));
    }

    /**
     * Rinvia un invito scaduto
     */
    public function resend(GroupInvitation $invitation)
    {
        $user = Auth::user();

        // Verifica che l'utente sia chi ha inviato l'invito o admin del gruppo
        if ($invitation->invited_by !== $user->id && !$invitation->group->hasAdmin($user)) {
            abort(403, __('groups.cannot_resend_others_invitation'));
        }

        // Verifica che l'invito sia scaduto
        if (!$invitation->isExpired()) {
            return back()->with('error', __('groups.invitation_not_expired'));
        }

        // Verifica che l'utente non sia già membro del gruppo
        if ($invitation->group->hasMember($invitation->user)) {
            $invitation->delete();
            return back()->with('error', __('groups.user_already_member'));
        }

        // Rinvia l'invito
        $invitation->update([
            'status' => 'pending',
            'expires_at' => now()->addDays(7),
        ]);

        return back()->with('success', __('groups.invitation_resent'));
    }

    /**
     * Mostra i dettagli di un invito
     */
    public function show(GroupInvitation $invitation)
    {
        $user = Auth::user();

        // Verifica che l'utente sia il destinatario dell'invito o chi l'ha inviato
        if ($invitation->user_id !== $user->id && $invitation->invited_by !== $user->id) {
            abort(403, __('groups.no_permission_view_invitation'));
        }

        $invitation->load(['group', 'user', 'invitedBy']);

        return view('groups.invitations.show', compact('invitation'));
    }
}
