<?php

namespace App\Livewire\Forum\Moderation;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Subreddit;
use App\Models\ForumModerator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Moderators extends Component
{
    public Subreddit $subreddit;
    public $searchUser = '';
    public $searchResults = [];
    public $selectedUserId = null;
    public $newModeratorRole = 'moderator';

    public function mount(Subreddit $subreddit)
    {
        // Only admins can manage moderators
        if (!$subreddit->isAdmin(Auth::user())) {
            abort(403, 'Solo gli admin possono gestire i moderatori');
        }

        $this->subreddit = $subreddit;
    }

    public function title(): string
    {
        return 'Moderatori - ' . $this->subreddit->name;
    }

    public function updatedSearchUser()
    {
        if (strlen($this->searchUser) >= 2) {
            $this->searchResults = User::where('name', 'like', '%' . $this->searchUser . '%')
                ->orWhere('email', 'like', '%' . $this->searchUser . '%')
                ->whereNotIn('id', $this->subreddit->moderators()->pluck('user_id'))
                ->limit(10)
                ->get();
        } else {
            $this->searchResults = [];
        }
    }

    public function getModeratorsProperty()
    {
        return $this->subreddit->moderators()
            ->with(['user', 'addedBy'])
            ->orderByRaw("FIELD(role, 'admin', 'moderator')")
            ->latest()
            ->get();
    }

    public function addModerator($userId)
    {
        $this->validate([
            'newModeratorRole' => 'required|in:moderator,admin',
        ]);

        ForumModerator::create([
            'subreddit_id' => $this->subreddit->id,
            'user_id' => $userId,
            'role' => $this->newModeratorRole,
            'added_by' => Auth::id(),
        ]);

        $this->searchUser = '';
        $this->searchResults = [];
        
        session()->flash('success', 'Moderatore aggiunto');
    }

    public function removeModerator($moderatorId)
    {
        $moderator = ForumModerator::findOrFail($moderatorId);
        
        if ($moderator->subreddit_id !== $this->subreddit->id) {
            return;
        }

        // Cannot remove last admin
        if ($moderator->role === 'admin') {
            $adminCount = $this->subreddit->moderators()->where('role', 'admin')->count();
            if ($adminCount === 1) {
                session()->flash('error', 'Non puoi rimuovere l\'ultimo admin');
                return;
            }
        }

        $moderator->delete();
        session()->flash('success', 'Moderatore rimosso');
    }

    public function updateRole($moderatorId, $newRole)
    {
        $moderator = ForumModerator::findOrFail($moderatorId);
        
        if ($moderator->subreddit_id !== $this->subreddit->id) {
            return;
        }

        // Cannot demote last admin
        if ($moderator->role === 'admin' && $newRole === 'moderator') {
            $adminCount = $this->subreddit->moderators()->where('role', 'admin')->count();
            if ($adminCount === 1) {
                session()->flash('error', 'Non puoi retrocedere l\'ultimo admin');
                return;
            }
        }

        $moderator->update(['role' => $newRole]);
        session()->flash('success', 'Ruolo aggiornato');
    }

    public function render()
    {
        return view('livewire.forum.moderation.moderators', [
            'moderators' => $this->moderators,
        ]);
    }
}

