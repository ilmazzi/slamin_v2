<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;

class ChatList extends Component
{
    public $conversations;
    public $selectedConversationId;
    public $search = '';

    protected $listeners = [
        'conversationSelected' => 'updateSelected',
        'messageSent' => 'refreshList',
    ];

    public function mount($selectedId = null)
    {
        $this->selectedConversationId = $selectedId;
        $this->loadConversations();
    }

    public function loadConversations()
    {
        $this->conversations = Auth::user()
            ->conversations()
            ->with(['latestMessage.user', 'users'])
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhereHas('users', function($userQuery) {
                          $userQuery->where('name', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->get();
    }

    public function updatedSearch()
    {
        $this->loadConversations();
    }

    public function selectConversation($conversationId)
    {
        $this->selectedConversationId = $conversationId;
        $this->dispatch('conversationSelected', conversationId: $conversationId);
    }

    public function updateSelected($conversationId)
    {
        $this->selectedConversationId = $conversationId;
    }

    public function refreshList()
    {
        $this->loadConversations();
    }

    public function deleteConversation($conversationId)
    {
        $conversation = Conversation::find($conversationId);
        
        if ($conversation && $conversation->hasParticipant(Auth::user())) {
            // Remove user from conversation
            $conversation->participants()
                ->where('user_id', Auth::id())
                ->delete();
            
            // If no more participants, delete conversation
            if ($conversation->participants()->count() === 0) {
                $conversation->delete();
            }
            
            $this->loadConversations();
            
            if ($this->selectedConversationId === $conversationId) {
                $this->selectedConversationId = null;
                $this->dispatch('conversationSelected', conversationId: null);
            }
        }
    }

    public function render()
    {
        return view('livewire.chat.chat-list');
    }
}
