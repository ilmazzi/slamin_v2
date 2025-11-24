<?php

namespace App\Livewire\Forum\Moderation;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use App\Models\Subreddit;
use App\Models\ForumBan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Bans extends Component
{
    use WithPagination;

    public Subreddit $subreddit;
    public $showBanForm = false;
    public $banUserId = null;
    public $banUserSearch = '';
    public $userSearchResults = [];
    public $banReason = '';
    public $banType = 'temporary';
    public $banExpiresAt = null;

    public function mount(Subreddit $subreddit)
    {
        if (!$subreddit->isModerator(Auth::user())) {
            abort(403, 'Non sei un moderatore di questo subreddit');
        }

        $this->subreddit = $subreddit;
    }

    public function title(): string
    {
        return 'Ban - ' . $this->subreddit->name;
    }

    public function getBansProperty()
    {
        return $this->subreddit->bans()
            ->with(['user', 'bannedBy', 'liftedBy'])
            ->latest()
            ->paginate(20);
    }

    public function updatedBanUserSearch()
    {
        if (strlen($this->banUserSearch) >= 2) {
            $this->userSearchResults = User::where('name', 'like', '%' . $this->banUserSearch . '%')
                ->limit(10)
                ->get();
        } else {
            $this->userSearchResults = [];
        }
    }

    public function selectUser($userId)
    {
        $this->banUserId = $userId;
        $user = User::find($userId);
        $this->banUserSearch = $user->name;
        $this->userSearchResults = [];
    }

    public function banUser()
    {
        $this->validate([
            'banUserId' => 'required|exists:users,id',
            'banReason' => 'required|string|min:10|max:500',
            'banType' => 'required|in:temporary,permanent',
            'banExpiresAt' => 'required_if:banType,temporary|nullable|date|after:now',
        ]);

        // Check if user is already banned
        $existingBan = ForumBan::where('user_id', $this->banUserId)
            ->where('subreddit_id', $this->subreddit->id)
            ->whereNull('lifted_at')
            ->first();

        if ($existingBan) {
            session()->flash('error', 'Questo utente è già bannato');
            return;
        }

        ForumBan::create([
            'user_id' => $this->banUserId,
            'subreddit_id' => $this->subreddit->id,
            'reason' => $this->banReason,
            'is_permanent' => $this->banType === 'permanent',
            'expires_at' => $this->banType === 'temporary' ? $this->banExpiresAt : null,
            'banned_by' => Auth::id(),
        ]);

        // Reset form
        $this->showBanForm = false;
        $this->banUserId = null;
        $this->banUserSearch = '';
        $this->banReason = '';
        $this->banType = 'temporary';
        $this->banExpiresAt = null;

        session()->flash('success', 'Utente bannato con successo');
    }

    public function liftBan($banId)
    {
        $ban = ForumBan::findOrFail($banId);
        
        if ($ban->subreddit_id !== $this->subreddit->id) {
            return;
        }

        $ban->lift(Auth::user());
        session()->flash('success', 'Ban rimosso');
    }

    public function render()
    {
        return view('livewire.forum.moderation.bans', [
            'bans' => $this->bans,
        ]);
    }
}

