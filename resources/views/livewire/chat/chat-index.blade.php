<div class="-mt-16">
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
                <button @click="$dispatch('open-new-chat-modal')" class="chat-new-btn">
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
    
    <!-- New Conversation Modal -->
    <div x-data="{ 
        showModal: false,
        searchQuery: '',
        searchResults: [],
        searching: false,
        
        searchUsers() {
            if (this.searchQuery.length < 2) {
                this.searchResults = [];
                return;
            }
            
            this.searching = true;
            fetch(`/api/users/search?q=${encodeURIComponent(this.searchQuery)}`)
                .then(res => res.json())
                .then(data => {
                    this.searchResults = data.users || [];
                    this.searching = false;
                });
        },
        
        startConversation(userId) {
            $wire.startConversation(userId);
            this.showModal = false;
            this.searchQuery = '';
            this.searchResults = [];
        }
    }"
    @open-new-chat-modal.window="showModal = true"
    x-show="showModal"
    x-cloak
    class="fixed inset-0 z-[10000] flex items-center justify-center p-4"
    style="display: none;">
        <!-- Backdrop -->
        <div @click="showModal = false" 
             x-show="showModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
        
        <!-- Modal -->
        <div x-show="showModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="relative bg-white dark:bg-neutral-900 rounded-2xl shadow-2xl w-full max-w-md max-h-[80vh] flex flex-col">
            
            <!-- Header -->
            <div class="p-6 border-b border-neutral-200 dark:border-neutral-800 flex items-center justify-between">
                <h3 class="text-xl font-bold text-neutral-900 dark:text-white">{{ __('chat.new_conversation') }}</h3>
                <button @click="showModal = false" class="text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Search -->
            <div class="p-6">
                <div class="relative">
                    <input type="text" 
                           x-model="searchQuery"
                           @input.debounce.300ms="searchUsers()"
                           placeholder="{{ __('chat.search_users') }}"
                           class="w-full px-4 py-3 pl-10 border border-neutral-300 dark:border-neutral-700 rounded-lg bg-neutral-50 dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>
            
            <!-- Results -->
            <div class="flex-1 overflow-y-auto px-6 pb-6">
                <template x-if="searching">
                    <div class="text-center py-8 text-neutral-500">{{ __('common.loading') }}...</div>
                </template>
                
                <template x-if="!searching && searchQuery.length >= 2 && searchResults.length === 0">
                    <div class="text-center py-8 text-neutral-500">{{ __('chat.no_users_found') }}</div>
                </template>
                
                <template x-if="searchQuery.length < 2">
                    <div class="text-center py-8 text-neutral-500">{{ __('chat.type_to_search') }}</div>
                </template>
                
                <div class="space-y-2">
                    <template x-for="user in searchResults" :key="user.id">
                        <div @click="startConversation(user.id)" 
                             class="flex items-center gap-3 p-3 rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-800 cursor-pointer transition-colors">
                            <img :src="user.avatar" 
                                 :alt="user.name" 
                                 class="w-12 h-12 rounded-full object-cover">
                            <div class="flex-1">
                                <h4 class="font-semibold text-neutral-900 dark:text-white" x-text="user.name"></h4>
                                <p class="text-sm text-neutral-500" x-text="user.nickname || user.email"></p>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
    
    @assets
        @vite(['resources/css/chat.css', 'resources/js/chat.js'])
    @endassets
</div>
