<x-layouts.app>
    <div class="chat-container">
        <!-- Sidebar con lista conversazioni -->
        <div class="chat-sidebar" :class="{ 'hidden': selectedConversation && window.innerWidth < 768 }">
            <div class="chat-sidebar-header">
                <h1 class="chat-sidebar-title">{{ __('chat.messages') }}</h1>
                
                <!-- Search -->
                <div class="chat-search">
                    <svg class="chat-search-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" 
                           wire:model.live="search" 
                           placeholder="{{ __('chat.search_conversations') }}">
                </div>
                
                <!-- New Chat Button -->
                <button wire:click="$dispatch('openNewChatModal')" class="chat-new-btn">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ __('chat.new_conversation') }}
                </button>
            </div>
            
            <!-- Conversation List -->
            @livewire('chat.chat-list')
        </div>
        
        <!-- Main Chat Area -->
        <div class="chat-main">
            @if($selectedConversation)
                @livewire('chat.chat-show', ['conversation' => $selectedConversation], key($selectedConversation->id))
            @else
                <div class="chat-empty">
                    <svg class="chat-empty-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                              d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <p class="chat-empty-text">{{ __('chat.select_conversation') }}</p>
                </div>
            @endif
        </div>
    </div>
    
    @push('styles')
        @vite(['resources/css/chat.css'])
    @endpush
    
    @push('scripts')
        @vite(['resources/js/chat.js'])
    @endpush
</x-layouts.app>
