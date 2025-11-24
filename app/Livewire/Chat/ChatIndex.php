<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;

class ChatIndex extends Component
{
    public $selectedConversation = null;
    public $search = '';
    public $showMobileChat = false;

    protected $listeners = [
        'conversationSelected' => 'handleConversationSelected',
        'backToList' => 'backToList',
    ];

    public function mount()
    {
        // Ottieni il parametro conversation dalla route manualmente
        $conversationId = request()->route('conversation');
        
        if ($conversationId) {
            $conversation = Conversation::find($conversationId);
            
            if ($conversation && $conversation->hasParticipant(Auth::user())) {
                $this->selectedConversation = $conversation;
                $conversation->markAsRead(Auth::user());
            }
        }
    }

    public function handleConversationSelected($conversationId = null)
    {
        if ($conversationId) {
            $this->selectConversation($conversationId);
        }
    }

    public function selectConversation($conversationId = null)
    {
        if (!$conversationId) {
            return;
        }
        
        $conversation = Conversation::find($conversationId);
        
        if (!$conversation || !$conversation->hasParticipant(Auth::user())) {
            return;
        }
        
        $this->selectedConversation = $conversation;
        $this->showMobileChat = true;
        
        // Mark as read
        $conversation->markAsRead(Auth::user());
        
        // Update URL
        $this->dispatch('url-change', ['url' => route('chat.show', $conversation)]);
    }

    public function backToList()
    {
        $this->selectedConversation = null;
        $this->showMobileChat = false;
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
