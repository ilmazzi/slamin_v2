<?php

namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class UserFollowing extends Component
{
    use WithPagination;

    public $userId;
    public $user;

    public function mount($user = null)
    {
        if (is_object($user) && isset($user->id)) {
            $this->userId = (int) $user->id;
        } else {
            $userModel = null;
            
            if (is_numeric($user)) {
                $userModel = User::find($user);
            }
            
            if (!$userModel) {
                $userModel = User::where('nickname', $user)->first();
            }
            
            if ($userModel) {
                $this->userId = (int) $userModel->id;
            } else {
                abort(404, 'User not found');
            }
        }

        $this->user = User::findOrFail($this->userId);
    }

    public function getFollowingProperty()
    {
        return $this->user->following()
            ->withCount(['poems', 'articles', 'followers', 'following'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
    }

    public function render()
    {
        return view('livewire.users.user-following', [
            'following' => $this->following,
        ]);
    }
}

