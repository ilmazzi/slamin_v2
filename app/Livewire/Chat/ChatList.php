<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;

class ChatList extends Component
{
    public $search = '';
    public $selectedConversation = null;

    protected $listeners = [
        'conversationSelected' => 'updateSelected',
        'messageSent' => '$refresh',
    ];

    public function selectConversation($conversationId)
    {
        $this->dispatch('conversationSelected', conversationId: $conversationId);
    }

    public function updateSelected($conversationId)
    {
        $this->selectedConversation = Conversation::find($conversationId);
    }

    public function getConversationsProperty()
    {
        $query = Auth::user()->conversations()
            ->with(['latestMessage', 'participants', 'users']);

        if ($this->search) {
            $query->whereHas('users', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });
        }

        return $query->get();
    }

    public function render()
    {
        return view('livewire.chat.chat-list', [
            'conversations' => $this->conversations,
        ]);
    }
}
