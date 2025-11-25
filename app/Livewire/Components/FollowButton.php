<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\User;
use App\Services\ActivityService;
use Illuminate\Support\Facades\Auth;

class FollowButton extends Component
{
    public $userId;
    public $isFollowing = false;
    public $size = 'md'; // sm, md, lg
    public $variant = 'default'; // default, outline, ghost

    public function mount($userId, $size = 'md', $variant = 'default')
    {
        $this->userId = $userId;
        $this->size = $size;
        $this->variant = $variant;
        
        if (Auth::check()) {
            $this->isFollowing = Auth::user()->isFollowing(User::find($userId));
        }
    }

    public function toggleFollow()
    {
        if (!Auth::check()) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => __('follow.must_login')
            ]);
            return;
        }

        $user = User::find($this->userId);
        $currentUser = Auth::user();

        if (!$user) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => __('follow.user_not_found')
            ]);
            return;
        }

        if ($user->id === $currentUser->id) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => __('follow.cannot_follow_self')
            ]);
            return;
        }

        if ($this->isFollowing) {
            // Unfollow
            if ($currentUser->unfollow($user)) {
                $this->isFollowing = false;
                ActivityService::logUnfollow($currentUser, $user);
                $this->dispatch('follow-updated', ['userId' => $this->userId, 'isFollowing' => false]);
            }
        } else {
            // Follow
            if ($currentUser->follow($user)) {
                $this->isFollowing = true;
                ActivityService::logFollow($currentUser, $user);
                $this->dispatch('follow-updated', ['userId' => $this->userId, 'isFollowing' => true]);
            }
        }
    }

    public function render()
    {
        return view('livewire.components.follow-button');
    }
}

