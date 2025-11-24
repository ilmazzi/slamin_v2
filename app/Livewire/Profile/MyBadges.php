<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\UserBadge;

class MyBadges extends Component
{
    public $user;
    public $badges;
    public $showProfileForm = false;
    public $selectedProfileBadges = [];
    public $showSidebarForm = false;
    public $selectedSidebarBadges = [];

    protected $rules = [
        'selectedProfileBadges' => 'array',
        'selectedProfileBadges.*' => 'integer|exists:user_badges,id',
        'selectedSidebarBadges' => 'array',
        'selectedSidebarBadges.*' => 'integer|exists:user_badges,id',
    ];

    public function mount()
    {
        $this->user = Auth::user();
        $this->loadBadges();
        $this->loadSelectedBadges();
    }

    public function loadBadges()
    {
        $this->badges = $this->user->userBadges()
            ->with('badge')
            ->orderBy('earned_at', 'desc')
            ->get();
    }

    public function loadSelectedBadges()
    {
        // Badge selezionati per il profilo
        $this->selectedProfileBadges = $this->user->userBadges()
            ->where('show_in_profile', true)
            ->orderBy('profile_order')
            ->pluck('id')
            ->toArray();

        // Badge selezionati per la sidebar
        $this->selectedSidebarBadges = $this->user->userBadges()
            ->where('show_in_sidebar', true)
            ->orderBy('sidebar_order')
            ->pluck('id')
            ->toArray();
    }

    public function toggleProfileForm()
    {
        $this->showProfileForm = !$this->showProfileForm;
        if (!$this->showProfileForm) {
            $this->loadSelectedBadges(); // Ricarica se chiuso
        }
    }

    public function toggleSidebarForm()
    {
        $this->showSidebarForm = !$this->showSidebarForm;
        if (!$this->showSidebarForm) {
            $this->loadSelectedBadges(); // Ricarica se chiuso
        }
    }

    public function updateProfileBadges()
    {
        $this->validate();

        // Reset tutti i badge del profilo
        $this->user->userBadges()->update(['show_in_profile' => false, 'profile_order' => null]);

        // Imposta i badge selezionati
        foreach ($this->selectedProfileBadges as $order => $badgeId) {
            $userBadge = $this->user->userBadges()->find($badgeId);
            if ($userBadge) {
                $userBadge->update([
                    'show_in_profile' => true,
                    'profile_order' => $order + 1
                ]);
            }
        }

        $this->showProfileForm = false;
        $this->loadSelectedBadges();

        $this->dispatch('notify', message: __('badge.profile_badges_updated'), type: 'success');
    }

    public function updateSidebarBadges()
    {
        $this->validate();

        // Reset tutti i badge della sidebar
        $this->user->userBadges()->update(['show_in_sidebar' => false, 'sidebar_order' => null]);

        // Imposta i badge selezionati
        foreach ($this->selectedSidebarBadges as $order => $badgeId) {
            $userBadge = $this->user->userBadges()->find($badgeId);
            if ($userBadge) {
                $userBadge->update([
                    'show_in_sidebar' => true,
                    'sidebar_order' => $order + 1
                ]);
            }
        }

        $this->showSidebarForm = false;
        $this->loadSelectedBadges();

        $this->dispatch('notify', message: __('badge.sidebar_badges_updated'), type: 'success');
    }

    public function hideAllProfileBadges()
    {
        $this->user->userBadges()->update(['show_in_profile' => false, 'profile_order' => null]);
        $this->selectedProfileBadges = [];
        $this->showProfileForm = false;

        $this->dispatch('notify', message: __('badge.all_profile_badges_hidden'), type: 'info');
    }

    public function hideAllSidebarBadges()
    {
        $this->user->userBadges()->update(['show_in_sidebar' => false, 'sidebar_order' => null]);
        $this->selectedSidebarBadges = [];
        $this->showSidebarForm = false;

        $this->dispatch('notify', message: __('badge.all_sidebar_badges_hidden'), type: 'info');
    }

    public function render()
    {
        return view('livewire.profile.my-badges', [
            'profileBadges' => $this->user->userBadges()->where('show_in_profile', true)->with('badge')->orderBy('profile_order')->get(),
            'sidebarBadges' => $this->user->userBadges()->where('show_in_sidebar', true)->with('badge')->orderBy('sidebar_order')->get(),
        ]);
    }
}

