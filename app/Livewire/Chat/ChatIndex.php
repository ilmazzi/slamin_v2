<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;

class ChatIndex extends Component
{
    public $selectedConversation = null;
    public $search = '';

    protected $listeners = [
        'conversationSelected' => 'selectConversation',
        'backToList' => 'backToList',
    ];

    public function mount($conversation = null)
    {
        // Se c'è una conversazione nell'URL (route parameter), selezionala
        if ($conversation) {
            if (is_numeric($conversation)) {
                $this->selectConversation($conversation);
            } elseif ($conversation instanceof Conversation) {
                $this->selectedConversation = $conversation;
                $conversation->markAsRead(Auth::user());
            }
        }
    }

    public function selectConversation($conversationId)
    {
        $conversation = Conversation::find($conversationId);
        
        if (!$conversation || !$conversation->hasParticipant(Auth::user())) {
            return;
        }
        
        $this->selectedConversation = $conversation;
        
        // Mark as read
        $conversation->markAsRead(Auth::user());
        
        // Update URL
        $this->dispatch('url-change', ['url' => route('chat.show', $conversation)]);
    }

    public function backToList()
    {
        $this->selectedConversation = null;
    }

    public function startConversation($userId)
    {
        $otherUser = \App\Models\User::find($userId);
        
        if (!$otherUser) {
            return;
        }

        // Create or get existing private conversation
        $conversation = Conversation::createOrGetPrivate(Auth::user(), $otherUser);
        
        $this->selectedConversation = $conversation;
        
        // Mark as read
        $conversation->markAsRead(Auth::user());
        
        // Redirect to conversation
        return $this->redirect(route('chat.show', $conversation), navigate: true);
    }

    public function render()
    {
        return view('livewire.chat.chat-index')
            ->layout('components.layouts.app');
    }
}
