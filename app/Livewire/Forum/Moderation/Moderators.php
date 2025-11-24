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
    public $newModSearch = '';
    public $userSearchResults = [];
    public $newModUserId = null;
    public $newModRole = 'moderator';
    public $isOwner = false;

    public function mount(Subreddit $subreddit)
    {
        $this->subreddit = $subreddit;
        $this->isOwner = $subreddit->created_by === Auth::id();
        
        // Only owner or admins can manage moderators
        if (!$this->isOwner && !$subreddit->isAdmin(Auth::user())) {
            abort(403, 'Solo il creatore o gli admin possono gestire i moderatori');
        }
    }

    public function title(): string
    {
        return 'Moderatori - ' . $this->subreddit->name;
    }

    public function updatedNewModSearch()
    {
        if (strlen($this->newModSearch) >= 2) {
            $existingModIds = $this->subreddit->moderators()->pluck('user_id')->toArray();
            
            $this->userSearchResults = User::where('name', 'like', '%' . $this->newModSearch . '%')
                ->whereNotIn('id', $existingModIds)
                ->limit(10)
                ->get();
        } else {
            $this->userSearchResults = [];
        }
    }

    public function selectUser($userId)
    {
        $this->newModUserId = $userId;
        $user = User::find($userId);
        $this->newModSearch = $user->name;
        $this->userSearchResults = [];
    }

    public function getModeratorsProperty()
    {
        return $this->subreddit->moderators()
            ->with(['user', 'addedBy'])
            ->orderByRaw("FIELD(role, 'admin', 'moderator')")
            ->latest()
            ->get();
    }

    public function addModerator()
    {
        $this->validate([
            'newModUserId' => 'required|exists:users,id',
            'newModRole' => 'required|in:moderator,admin',
        ]);

        // Check if user is already a moderator
        $exists = ForumModerator::where('subreddit_id', $this->subreddit->id)
            ->where('user_id', $this->newModUserId)
            ->exists();

        if ($exists) {
            session()->flash('error', 'Questo utente è già un moderatore');
            return;
        }

        $moderator = ForumModerator::create([
            'subreddit_id' => $this->subreddit->id,
            'user_id' => $this->newModUserId,
            'role' => $this->newModRole,
            'added_by' => Auth::id(),
        ]);

        // Notify new moderator
        $newMod = User::find($this->newModUserId);
        $newMod->notify(new \App\Notifications\Forum\ModeratorAddedNotification($moderator));

        // Reset form
        $this->newModSearch = '';
        $this->newModUserId = null;
        $this->newModRole = 'moderator';
        $this->userSearchResults = [];
        
        session()->flash('success', 'Moderatore aggiunto con successo');
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

