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
    public $showBanModal = false;
    public $banUserId = null;
    public $banReason = '';
    public $banType = 'temporary';
    public $banDuration = 7; // days

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
            ->with(['user', 'bannedBy'])
            ->where('is_active', true)
            ->latest()
            ->paginate(20);
    }

    public function openBanModal($userId)
    {
        $this->banUserId = $userId;
        $this->showBanModal = true;
    }

    public function closeBanModal()
    {
        $this->showBanModal = false;
        $this->banUserId = null;
        $this->banReason = '';
        $this->banType = 'temporary';
        $this->banDuration = 7;
    }

    public function createBan()
    {
        $this->validate([
            'banReason' => 'required|string|min:10|max:500',
            'banType' => 'required|in:temporary,permanent',
            'banDuration' => 'required_if:banType,temporary|integer|min:1|max:365',
        ]);

        $expiresAt = null;
        if ($this->banType === 'temporary') {
            $expiresAt = now()->addDays($this->banDuration);
        }

        ForumBan::create([
            'user_id' => $this->banUserId,
            'subreddit_id' => $this->subreddit->id,
            'reason' => $this->banReason,
            'type' => $this->banType,
            'expires_at' => $expiresAt,
            'banned_by' => Auth::id(),
        ]);

        $this->closeBanModal();
        session()->flash('success', 'Utente bannato');
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

