<?php

namespace App\Helpers;

use App\Models\Group;
use App\Models\User;

class GroupHelper
{
    /**
     * Verifica se un utente può visualizzare un gruppo
     */
    public static function canView(Group $group, ?User $user = null): bool
    {
        if ($group->visibility === 'public') {
            return true;
        }

        if (!$user) {
            return false;
        }

        return $group->hasMember($user) || $user->hasRole('admin');
    }

    /**
     * Verifica se un utente può modificare un gruppo
     */
    public static function canEdit(Group $group, ?User $user = null): bool
    {
        if (!$user) {
            return false;
        }

        return $group->hasAdmin($user) || $user->hasRole('admin');
    }

    /**
     * Verifica se un utente può eliminare un gruppo
     */
    public static function canDelete(Group $group, ?User $user = null): bool
    {
        if (!$user) {
            return false;
        }

        return $group->created_by === $user->id || $user->hasRole('admin');
    }

    /**
     * Verifica se un utente può invitare membri
     */
    public static function canInviteMembers(Group $group, ?User $user = null): bool
    {
        if (!$user) {
            return false;
        }

        return $group->hasModerator($user) || $user->hasRole('admin');
    }

    /**
     * Verifica se un utente può gestire i membri
     */
    public static function canManageMembers(Group $group, ?User $user = null): bool
    {
        if (!$user) {
            return false;
        }

        return $group->hasModerator($user) || $user->hasRole('admin');
    }

    /**
     * Verifica se un utente può creare annunci
     */
    public static function canCreateAnnouncements(Group $group, ?User $user = null): bool
    {
        if (!$user) {
            return false;
        }

        return $group->hasModerator($user) || $user->hasRole('admin');
    }

    /**
     * Ottieni il badge del ruolo
     */
    public static function getRoleBadge(string $role): string
    {
        return match($role) {
            'admin' => '<span class="px-2 py-1 bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300 text-xs font-semibold rounded">Admin</span>',
            'moderator' => '<span class="px-2 py-1 bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300 text-xs font-semibold rounded">Moderatore</span>',
            'member' => '<span class="px-2 py-1 bg-neutral-100 text-neutral-700 dark:bg-neutral-800 dark:text-neutral-300 text-xs font-semibold rounded">Membro</span>',
            default => '',
        };
    }

    /**
     * Ottieni statistiche del gruppo
     */
    public static function getGroupStats(Group $group): array
    {
        return [
            'total_members' => $group->members()->count(),
            'admins' => $group->members()->where('role', 'admin')->count(),
            'moderators' => $group->members()->where('role', 'moderator')->count(),
            'members' => $group->members()->where('role', 'member')->count(),
            'pending_requests' => $group->joinRequests()->where('status', 'pending')->count(),
            'pending_invitations' => $group->invitations()->where('status', 'pending')->count(),
            'total_announcements' => $group->announcements()->count(),
            'pinned_announcements' => $group->announcements()->where('is_pinned', true)->count(),
        ];
    }
}

