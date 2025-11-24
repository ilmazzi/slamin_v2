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

    public function mount()
    {
        // Se c'è una conversazione nell'URL, selezionala
        if (request()->has('conversation')) {
            $this->selectConversation(request()->get('conversation'));
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

    public function render()
    {
        return view('livewire.chat.chat-index')
            ->layout('components.layouts.app');
    }
}
