<div class="chat-conversations">
    @forelse($conversations as $conversation)
        <div wire:click="$dispatch('conversationSelected', { conversationId: {{ $conversation->id }} })" 
             class="chat-conversation-item {{ $selectedConversation && $selectedConversation->id === $conversation->id ? 'active' : '' }}">
            
            <!-- Avatar -->
            @php
                $name = $conversation->getDisplayName(auth()->user());
                // Per conversazioni private, ottieni l'altro utente
                if ($conversation->type === 'private') {
                    $otherUser = $conversation->users->where('id', '!=', auth()->id())->first();
                    $avatar = $otherUser ? \App\Helpers\AvatarHelper::getUserAvatarUrl($otherUser, 80) : null;
                } else {
                    // Per gruppi, usa avatar del gruppo o default
                    $avatar = $conversation->avatar;
                }
            @endphp
            
            <img src="{{ $avatar }}" alt="{{ $name }}" class="chat-avatar">
            
            <!-- Info -->
            <div class="chat-conversation-info">
                <div class="chat-conversation-header">
                    <span class="chat-conversation-name">{{ $name }}</span>
                    @if($conversation->latestMessage)
                        <span class="chat-conversation-time">
                            {{ $conversation->latestMessage->created_at->diffForHumans() }}
                        </span>
                    @endif
                </div>
                
                @if($conversation->latestMessage)
                    <p class="chat-conversation-preview">
                        @if($conversation->latestMessage->user_id === auth()->id())
                            <span class="font-medium">{{ __('chat.you') }}:</span>
                        @endif
                        {{ Str::limit($conversation->latestMessage->body, 50) }}
                    </p>
                @else
                    <p class="chat-conversation-preview">{{ __('chat.no_messages') }}</p>
                @endif
            </div>
            
            <!-- Unread Badge -->
            @php
                $unread = $conversation->unreadCount(auth()->user());
            @endphp
            @if($unread > 0)
                <span class="chat-unread-badge">{{ $unread > 99 ? '99+' : $unread }}</span>
            @endif
        </div>
    @empty
        <div class="p-8 text-center text-neutral-500 dark:text-neutral-400">
            <p>{{ __('chat.no_conversations') }}</p>
        </div>
    @endforelse
</div>
