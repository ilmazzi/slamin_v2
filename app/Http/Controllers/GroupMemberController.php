<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupMemberController extends Controller
{
    /**
     * Promuovi un membro a moderatore
     */
    public function promote(Group $group, GroupMember $member)
    {
        // Verifica che l'utente sia admin
        if (!$group->hasAdmin(Auth::user())) {
            abort(403);
        }

        $member->update(['role' => 'moderator']);

        return back()->with('success', __('groups.member_promoted'));
    }

    /**
     * Retrocedi un moderatore a membro
     */
    public function demote(Group $group, GroupMember $member)
    {
        // Verifica che l'utente sia admin
        if (!$group->hasAdmin(Auth::user())) {
            abort(403);
        }

        $member->update(['role' => 'member']);

        return back()->with('success', __('groups.member_demoted'));
    }

    /**
     * Rimuovi un membro dal gruppo
     */
    public function remove(Group $group, GroupMember $member)
    {
        // Verifica che l'utente sia admin o moderatore
        if (!$group->hasModerator(Auth::user())) {
            abort(403);
        }

        // Non permettere di rimuovere admin
        if ($member->role === 'admin') {
            return back()->with('error', __('groups.cannot_remove_admin'));
        }

        $member->delete();

        return back()->with('success', __('groups.member_removed'));
    }
}
