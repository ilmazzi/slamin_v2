<?php

namespace App\Livewire\Home;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NewUsersSection extends Component
{
    public function render()
    {
        $newUsers = User::withCount(['poems', 'articles', 'likes', 'comments', 'views', 'followers', 'following'])
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        
        return view('livewire.home.new-users-section', [
            'newUsers' => $newUsers
        ]);
    }
}
