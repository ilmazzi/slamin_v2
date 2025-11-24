<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupAnnouncement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupAnnouncementController extends Controller
{
    /**
     * Crea un nuovo annuncio
     */
    public function store(Request $request, Group $group)
    {
        // Verifica che l'utente sia moderatore o admin
        if (!$group->hasModerator(Auth::user())) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:5000',
            'is_pinned' => 'boolean',
        ]);

        GroupAnnouncement::create([
            'group_id' => $group->id,
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'is_pinned' => $request->boolean('is_pinned', false),
        ]);

        return back()->with('success', __('groups.announcement_created'));
    }

    /**
     * Aggiorna un annuncio
     */
    public function update(Request $request, Group $group, GroupAnnouncement $announcement)
    {
        // Verifica che l'utente sia moderatore, admin o l'autore
        if (!$group->hasModerator(Auth::user()) && $announcement->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:5000',
            'is_pinned' => 'boolean',
        ]);

        $announcement->update([
            'title' => $request->title,
            'content' => $request->content,
            'is_pinned' => $request->boolean('is_pinned', $announcement->is_pinned),
        ]);

        return back()->with('success', __('groups.announcement_updated'));
    }

    /**
     * Elimina un annuncio
     */
    public function destroy(Group $group, GroupAnnouncement $announcement)
    {
        // Verifica che l'utente sia moderatore, admin o l'autore
        if (!$group->hasModerator(Auth::user()) && $announcement->user_id !== Auth::id()) {
            abort(403);
        }

        $announcement->delete();

        return back()->with('success', __('groups.announcement_deleted'));
    }
}
