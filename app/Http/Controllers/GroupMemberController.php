<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupMemberController extends Controller
{
    /**
     * Mostra la lista dei membri di un gruppo
     */
    public function index(Group $group)
    {
        $user = Auth::user();

        // Verifica se l'utente può visualizzare i membri
        if ($group->visibility === 'private' && !$group->hasMember($user) && !$user->hasRole('admin')) {
            abort(403, __('groups.no_permission_view_members'));
        }

        $members = $group->members()
                        ->with('user')
                        ->orderByRaw("FIELD(role, 'admin', 'moderator', 'member')")
                        ->orderBy('joined_at', 'asc')
                        ->paginate(20);

        $isAdmin = $group->hasAdmin($user);
        $isModerator = $group->hasModerator($user);

        return view('groups.members.index', compact('group', 'members', 'isAdmin', 'isModerator'));
    }

    /**
     * Promuovi un membro ad admin
     */
    public function promote(Group $group, GroupMember $member)
    {
        // Verifica che l'utente sia admin
        if (!$group->hasAdmin(Auth::user())) {
            abort(403);
        }

        if ($member->role === 'admin') {
            return back()->with('error', __('groups.already_admin'));
        }

        $member->update(['role' => 'admin']);

        // Invia notifica
        $member->user->notify(new \App\Notifications\GroupMemberPromotedNotification($member, 'admin'));

        return back()->with('success', __('groups.member_promoted'));
    }

    /**
     * Retrocedi un admin a moderatore
     */
    public function demote(Group $group, GroupMember $member)
    {
        // Verifica che l'utente sia admin
        if (!$group->hasAdmin(Auth::user())) {
            abort(403);
        }

        if ($member->role !== 'admin') {
            return back()->with('error', __('groups.not_admin'));
        }

        // Non permettere di degradare l'ultimo admin
        if ($group->members()->where('role', 'admin')->count() === 1) {
            return back()->with('error', __('groups.cannot_demote_last_admin'));
        }

        $member->update(['role' => 'moderator']);

        // Invia notifica
        $member->user->notify(new \App\Notifications\GroupMemberDemotedNotification($member, 'moderator'));

        return back()->with('success', __('groups.member_demoted'));
    }

    /**
     * Promuovi un membro a moderatore
     */
    public function promoteToModerator(Group $group, GroupMember $member)
    {
        // Verifica che l'utente sia admin
        if (!$group->hasAdmin(Auth::user())) {
            abort(403);
        }

        if (in_array($member->role, ['admin', 'moderator'])) {
            return back()->with('error', __('groups.already_moderator'));
        }

        $member->update(['role' => 'moderator']);

        // Invia notifica
        $member->user->notify(new \App\Notifications\GroupMemberPromotedNotification($member, 'moderator'));

        return back()->with('success', __('groups.promoted_to_moderator'));
    }

    /**
     * Retrocedi un moderatore a membro
     */
    public function demoteToMember(Group $group, GroupMember $member)
    {
        // Verifica che l'utente sia admin
        if (!$group->hasAdmin(Auth::user())) {
            abort(403);
        }

        if ($member->role !== 'moderator') {
            return back()->with('error', __('groups.not_moderator'));
        }

        $member->update(['role' => 'member']);

        // Invia notifica
        $member->user->notify(new \App\Notifications\GroupMemberDemotedNotification($member, 'member'));

        return back()->with('success', __('groups.demoted_to_member'));
    }

    /**
     * Rimuovi un membro dal gruppo
     */
    public function remove(Group $group, GroupMember $member)
    {
        // Verifica che l'utente sia moderatore o admin
        if (!$group->hasModerator(Auth::user())) {
            abort(403);
        }

        // Non permettere di rimuovere se stessi
        if ($member->user_id === Auth::id()) {
            return back()->with('error', __('groups.cannot_remove_yourself'));
        }

        // Non permettere di rimuovere admin se non sei admin
        if ($member->role === 'admin' && !$group->hasAdmin(Auth::user())) {
            return back()->with('error', __('groups.cannot_remove_admin'));
        }

        // Non permettere di rimuovere l'ultimo admin
        if ($member->role === 'admin' && $group->members()->where('role', 'admin')->count() === 1) {
            return back()->with('error', __('groups.cannot_remove_last_admin'));
        }

        // Salva l'utente prima di eliminare il membro
        $user = $member->user;

        $member->delete();

        // Invia notifica
        $user->notify(new \App\Notifications\GroupMemberRemovedNotification($group, Auth::user()));

        return back()->with('success', __('groups.member_removed'));
    }

    /**
     * Cerca utenti per invitare al gruppo
     */
    public function searchUsers(Group $group, Request $request)
    {
        $user = Auth::user();

        if (!$group->hasModerator($user)) {
            abort(403);
        }

        $search = $request->get('search', '');

        $users = User::where(function($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('nickname', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        })
        ->whereNotIn('id', $group->members()->pluck('user_id'))
        ->whereNotIn('id', $group->invitations()->where('status', 'pending')->pluck('user_id'))
        ->limit(10)
        ->get()
        ->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'nickname' => $user->nickname,
                'email' => $user->email,
                'avatar_url' => \App\Helpers\AvatarHelper::getUserAvatarUrl($user),
            ];
        });

        return response()->json($users);
    }

    /**
     * Invita un utente al gruppo
     */
    public function invite(Group $group, Request $request)
    {
        $user = Auth::user();

        if (!$group->hasModerator($user)) {
            abort(403);
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $invitedUser = User::findOrFail($request->user_id);

        // Verifica se l'utente è già membro
        if ($group->hasMember($invitedUser)) {
            return back()->with('error', __('groups.user_already_member'));
        }

        // Verifica se l'utente ha già un invito pendente
        if ($group->hasPendingInvitation($invitedUser)) {
            return back()->with('error', __('groups.invitation_already_sent'));
        }

        // Verifica se l'utente ha già una richiesta pendente
        if ($group->hasPendingJoinRequest($invitedUser)) {
            return back()->with('error', __('groups.user_has_pending_request'));
        }

        // Crea l'invito
        $group->invitations()->create([
            'user_id' => $invitedUser->id,
            'invited_by' => $user->id,
            'status' => 'pending',
            'expires_at' => now()->addDays(7),
        ]);

        return back()->with('success', __('groups.invitation_sent'));
    }
}
