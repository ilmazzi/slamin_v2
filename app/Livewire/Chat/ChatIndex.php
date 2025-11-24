<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatIndex extends Component
{
    public $selectedConversationId = null;
    public $search = '';
    public $showNewChatModal = false;
    public $userSearch = '';
    public $searchedUsers = [];

    protected $listeners = [
        'conversationSelected' => 'selectConversation',
        'messageSent' => 'refreshConversations',
    ];

    public function mount($conversationId = null)
    {
        if ($conversationId) {
            $conversation = Conversation::find($conversationId);
            if ($conversation && $conversation->hasParticipant(Auth::user())) {
                $this->selectedConversationId = $conversationId;
            }
        }
    }

    public function selectConversation($conversationId)
    {
        $conversation = Conversation::find($conversationId);
        
        if ($conversation && $conversation->hasParticipant(Auth::user())) {
            $this->selectedConversationId = $conversationId;
            $conversation->markAsRead(Auth::user());
        }
    }

    public function refreshConversations()
    {
        // Just refresh the component
        $this->dispatch('$refresh');
    }

    public function openNewChatModal()
    {
        $this->showNewChatModal = true;
        $this->userSearch = '';
        $this->searchedUsers = [];
    }

    public function closeNewChatModal()
    {
        $this->showNewChatModal = false;
        $this->userSearch = '';
        $this->searchedUsers = [];
    }

    public function updatedUserSearch()
    {
        if (strlen($this->userSearch) >= 2) {
            $this->searchedUsers = User::where('id', '!=', Auth::id())
                ->where(function($query) {
                    $query->where('name', 'like', '%' . $this->userSearch . '%')
                          ->orWhere('email', 'like', '%' . $this->userSearch . '%');
                })
                ->limit(10)
                ->get();
        } else {
            $this->searchedUsers = [];
        }
    }

    public function startConversation($userId)
    {
        $otherUser = User::find($userId);
        
        if (!$otherUser) {
            return;
        }

        $conversation = Conversation::createOrGetPrivate(Auth::user(), $otherUser);
        
        $this->selectedConversationId = $conversation->id;
        $this->closeNewChatModal();
        
        $this->dispatch('conversationSelected', conversationId: $conversation->id);
    }

    public function getConversationsProperty()
    {
        return Auth::user()
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

    public function render()
    {
        return view('livewire.chat.chat-index', [
            'conversations' => $this->conversations,
        ])->layout('components.layouts.app');
    }
}
