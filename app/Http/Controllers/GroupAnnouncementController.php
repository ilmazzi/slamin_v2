<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupAnnouncement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupAnnouncementController extends Controller
{
    /**
     * Mostra gli annunci di un gruppo
     */
    public function index(Group $group)
    {
        $user = Auth::user();
        
        if ($group->visibility === 'private' && !$group->hasMember($user)) {
            abort(403, __('groups.no_permission_view_announcements'));
        }

        $announcements = $group->announcements()
            ->with(['user'])
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('groups.announcements.index', compact('group', 'announcements'));
    }

    /**
     * Mostra un annuncio specifico
     */
    public function show(Group $group, GroupAnnouncement $announcement)
    {
        $user = Auth::user();
        
        if ($announcement->group_id !== $group->id) {
            abort(404);
        }

        if ($group->visibility === 'private' && !$group->hasMember($user)) {
            abort(403, __('groups.no_permission_view_announcement'));
        }

        return view('groups.announcements.show', compact('group', 'announcement'));
    }

    /**
     * Mostra il form per creare un nuovo annuncio
     */
    public function create(Group $group)
    {
        $user = Auth::user();
        
        if (!$group->hasModerator($user)) {
            abort(403, __('groups.no_permission_create_announcement'));
        }

        return view('groups.announcements.create', compact('group'));
    }

    /**
     * Salva un nuovo annuncio
     */
    public function store(Request $request, Group $group)
    {
        $user = Auth::user();
        
        if (!$group->hasModerator($user)) {
            abort(403, __('groups.no_permission_create_announcement'));
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:5000',
            'is_pinned' => 'boolean',
        ]);

        $group->announcements()->create([
            'user_id' => $user->id,
            'title' => $request->title,
            'content' => $request->content,
            'is_pinned' => $request->boolean('is_pinned', false),
        ]);

        return redirect()->route('groups.announcements.index', $group)
                        ->with('success', __('groups.announcement_created'));
    }

    /**
     * Mostra il form per modificare un annuncio
     */
    public function edit(Group $group, GroupAnnouncement $announcement)
    {
        $user = Auth::user();
        
        if ($announcement->group_id !== $group->id) {
            abort(404);
        }

        if (!$group->hasModerator($user) && $announcement->user_id !== $user->id) {
            abort(403, __('groups.no_permission_edit_announcement'));
        }

        return view('groups.announcements.edit', compact('group', 'announcement'));
    }

    /**
     * Aggiorna un annuncio
     */
    public function update(Request $request, Group $group, GroupAnnouncement $announcement)
    {
        $user = Auth::user();
        
        if ($announcement->group_id !== $group->id) {
            abort(404);
        }

        if (!$group->hasModerator($user) && $announcement->user_id !== $user->id) {
            abort(403, __('groups.no_permission_edit_announcement'));
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:5000',
            'is_pinned' => 'boolean',
        ]);

        $announcement->update([
            'title' => $request->title,
            'content' => $request->content,
            'is_pinned' => $group->hasModerator($user) ? $request->boolean('is_pinned', $announcement->is_pinned) : $announcement->is_pinned,
        ]);

        return redirect()->route('groups.announcements.show', [$group, $announcement])
                        ->with('success', __('groups.announcement_updated'));
    }

    /**
     * Elimina un annuncio
     */
    public function destroy(Group $group, GroupAnnouncement $announcement)
    {
        $user = Auth::user();
        
        if ($announcement->group_id !== $group->id) {
            abort(404);
        }

        if (!$group->hasModerator($user) && $announcement->user_id !== $user->id) {
            abort(403, __('groups.no_permission_delete_announcement'));
        }

        $announcement->delete();

        return redirect()->route('groups.announcements.index', $group)
                        ->with('success', __('groups.announcement_deleted'));
    }
}
