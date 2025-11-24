<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ChatButton extends Component
{
    public $unreadCount = 0;

    protected $listeners = [
        'messageSent' => 'updateUnreadCount',
        'conversationSelected' => 'updateUnreadCount',
    ];

    public function mount()
    {
        $this->updateUnreadCount();
    }

    public function updateUnreadCount()
    {
        if (!Auth::check()) {
            $this->unreadCount = 0;
            return;
        }

        $user = Auth::user();
        $conversations = $user->conversations()->with('messages', 'participants')->get();
        
        $totalUnread = 0;
        foreach ($conversations as $conversation) {
            $totalUnread += $conversation->unreadCount($user);
        }
        
        $this->unreadCount = $totalUnread;
    }

    public function render()
    {
        return view('livewire.chat.chat-button');
    }
}
