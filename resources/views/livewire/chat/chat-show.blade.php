@php
    $displayName = $conversation->getDisplayName(auth()->user());
    $otherUser = $conversation->getOtherParticipant(auth()->user());
    // Usa AvatarHelper per l'avatar
    if ($conversation->type === 'private' && $otherUser) {
        $displayAvatar = \App\Helpers\AvatarHelper::getUserAvatarUrl($otherUser, 80);
    } else {
        $displayAvatar = $conversation->avatar;
    }
@endphp

<div class="flex flex-col h-full" 
     x-data="{
         showInfo: false,
         typingUsers: [],
         typingTimeout: null,
         isOtherUserOnline: {{ $isOnline ? 'true' : 'false' }},
         init() {
             // Update online status every 30 seconds
             @if($conversation->type === 'private' && $otherUser)
             setInterval(() => {
                 fetch('{{ route('api.users.check-online', $otherUser->id) }}', {
                     method: 'GET',
                     headers: {
                         'X-CSRF-TOKEN': '{{ csrf_token() }}'
                     }
                 })
                 .then(response => response.json())
                 .then(data => {
                     this.isOtherUserOnline = data.online || false;
                 })
                 .catch(error => console.error('Error checking online status:', error));
             }, 30000);
             @endif
             
             // Listen for typing events via Echo
             if (window.Echo) {
                 window.Echo.private('conversation.{{ $conversation->id }}')
                     .listen('.user.started.typing', (e) => {
                         if (e.user_id !== {{ auth()->id() }}) {
                             this.typingUsers.push(e.user_name);
                             this.typingUsers = [...new Set(this.typingUsers)]; // Remove duplicates
                             
                             // Clear timeout if exists
                             if (this.typingTimeout) {
                                 clearTimeout(this.typingTimeout);
                             }
                             
                             // Auto-hide after 3 seconds of inactivity
                             this.typingTimeout = setTimeout(() => {
                                 this.typingUsers = this.typingUsers.filter(u => u !== e.user_name);
                             }, 3000);
                         }
                     })
                     .listen('.user.stopped.typing', (e) => {
                         if (e.user_id !== {{ auth()->id() }}) {
                             this.typingUsers = this.typingUsers.filter(u => u !== e.user_name);
                         }
                     });
             }
         }
     }"
     wire:poll.5s="loadMessages">
    <!-- Chat Header -->
    <div class="chat-header">
        <!-- Back button (mobile) -->
        <button class="chat-header-btn lg:hidden" wire:click="$dispatch('backToList')">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        
        <!-- Avatar -->
        @if($displayAvatar)
            <img src="{{ $displayAvatar }}" alt="{{ $displayName }}" class="chat-avatar">
        @else
            <div class="chat-avatar-placeholder">{{ strtoupper(substr($displayName, 0, 2)) }}</div>
        @endif
        
        <!-- Info -->
        <div class="chat-header-info">
            <h2 class="chat-header-name">{{ $displayName }}</h2>
            @if($conversation->type === 'private' && $otherUser)
                <p class="chat-header-status" x-text="isOtherUserOnline ? '{{ __('chat.online') }}' : '{{ __('chat.offline') }}'"></p>
            @else
                <p class="chat-header-status">
                    {{ $conversation->participants()->count() }} {{ __('chat.participants') }}
                </p>
            @endif
        </div>
        
        <!-- Actions -->
        <div class="chat-header-actions">
            <button class="chat-header-btn" title="{{ __('chat.search') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>
            <button @click="showInfo = !showInfo" class="chat-header-btn" title="{{ __('chat.info') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </button>
        </div>
    </div>
    
    <!-- Info Panel (Sidebar) -->
    <div x-show="showInfo" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-x-full"
         x-transition:enter-end="opacity-100 translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-x-0"
         x-transition:leave-end="opacity-0 translate-x-full"
         class="fixed right-0 top-0 h-full w-80 bg-white dark:bg-neutral-900 shadow-2xl z-50 overflow-y-auto border-l border-neutral-200 dark:border-neutral-800"
         style="display: none;">
        
        <!-- Header -->
        <div class="p-6 border-b border-neutral-200 dark:border-neutral-800 flex items-center justify-between">
            <h3 class="text-xl font-bold text-neutral-900 dark:text-white">{{ __('chat.conversation_info') }}</h3>
            <button @click="showInfo = false" class="text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <!-- Content -->
        <div class="p-6 space-y-6">
            <!-- Avatar & Name -->
            <div class="text-center">
                @if($displayAvatar)
                    <img src="{{ $displayAvatar }}" alt="{{ $displayName }}" class="w-24 h-24 rounded-full mx-auto mb-4 object-cover">
                @else
                    <div class="w-24 h-24 rounded-full mx-auto mb-4 bg-neutral-200 dark:bg-neutral-700 flex items-center justify-center text-2xl font-bold text-neutral-600 dark:text-neutral-400">
                        {{ strtoupper(substr($displayName, 0, 2)) }}
                    </div>
                @endif
                <h4 class="text-lg font-bold text-neutral-900 dark:text-white">{{ $displayName }}</h4>
                @if($conversation->type === 'private' && $otherUser)
                    <p class="text-sm text-neutral-500 dark:text-neutral-400" x-text="isOtherUserOnline ? '{{ __('chat.online') }}' : '{{ __('chat.offline') }}'"></p>
                    @if($otherUser->nickname)
                        <p class="text-sm text-neutral-500 dark:text-neutral-400">@\{{ $otherUser->nickname }}</p>
                    @endif
                @endif
            </div>
            
            <!-- Actions -->
            @if($conversation->type === 'private' && $otherUser)
                <div class="space-y-2">
                    <a href="{{ route('user.show', $otherUser) }}" 
                       class="flex items-center gap-3 p-3 rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors">
                        <svg class="w-5 h-5 text-neutral-600 dark:text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span class="text-sm font-medium text-neutral-900 dark:text-white">{{ __('chat.view_profile') }}</span>
                    </a>
                    
                    <button class="flex items-center gap-3 p-3 rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors w-full text-left">
                        <svg class="w-5 h-5 text-neutral-600 dark:text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <span class="text-sm font-medium text-neutral-900 dark:text-white">{{ __('chat.search_in_conversation') }}</span>
                    </button>
                    
                    <button class="flex items-center gap-3 p-3 rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors w-full text-left">
                        <svg class="w-5 h-5 text-neutral-600 dark:text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm font-medium text-neutral-900 dark:text-white">{{ __('chat.mute_notifications') }}</span>
                    </button>
                </div>
            @endif
            
            <!-- Conversation Stats -->
            <div class="border-t border-neutral-200 dark:border-neutral-800 pt-6">
                <h5 class="text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-3">{{ __('chat.conversation_details') }}</h5>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-neutral-600 dark:text-neutral-400">{{ __('chat.messages') }}</span>
                        <span class="font-medium text-neutral-900 dark:text-white">{{ $conversation->messages()->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-neutral-600 dark:text-neutral-400">{{ __('chat.created') }}</span>
                        <span class="font-medium text-neutral-900 dark:text-white">{{ $conversation->created_at->diffForHumans() }}</span>
                    </div>
                    @if($conversation->type === 'group')
                        <div class="flex justify-between">
                            <span class="text-neutral-600 dark:text-neutral-400">{{ __('chat.members') }}</span>
                            <span class="font-medium text-neutral-900 dark:text-white">{{ $conversation->participants()->count() }}</span>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Danger Zone -->
            <div class="border-t border-neutral-200 dark:border-neutral-800 pt-6">
                <button class="flex items-center gap-3 p-3 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors w-full text-left text-red-600 dark:text-red-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    <span class="text-sm font-medium">{{ __('chat.delete_conversation') }}</span>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Messages -->
    <div class="chat-messages" id="chat-messages-{{ $conversation->id }}">
        @foreach($messages as $message)
            <div class="chat-message {{ $message->user_id === auth()->id() ? 'sent' : 'received' }}">
                <!-- Avatar (only for received messages) -->
                @if($message->user_id !== auth()->id())
                    <img src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($message->user, 72) }}" 
                         alt="{{ $message->user->name }}" 
                         class="chat-message-avatar">
                @endif
                
                <div class="chat-message-content">
                    <!-- Reply indicator -->
                    @if($message->reply_to)
                        @php
                            $replyTo = $messages->firstWhere('id', $message->reply_to);
                        @endphp
                        @if($replyTo)
                            <div class="chat-message-reply">
                                <strong>{{ $replyTo->user->name }}</strong>
                                <p>{{ Str::limit($replyTo->body, 50) }}</p>
                            </div>
                        @endif
                    @endif
                    
                    <!-- Message bubble -->
                    <div class="chat-message-bubble">
                        @if($message->type === 'text')
                            <p class="chat-message-text">{{ $message->body }}</p>
                        @elseif($message->type === 'image')
                            <img src="{{ $message->metadata['url'] ?? '' }}" 
                                 alt="Image" 
                                 class="chat-message-image"
                                 onclick="window.open(this.src, '_blank')">
                            @if($message->body)
                                <p class="chat-message-text mt-2">{{ $message->body }}</p>
                            @endif
                        @elseif($message->type === 'file')
                            <div class="chat-message-file">
                                <div class="chat-message-file-icon">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="chat-message-file-info">
                                    <p class="chat-message-file-name">{{ $message->metadata['filename'] ?? 'File' }}</p>
                                    <p class="chat-message-file-size">{{ $message->metadata['size'] ?? '' }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Meta -->
                    <div class="chat-message-meta">
                        <span>{{ $message->created_at->format('H:i') }}</span>
                        @if($message->user_id === auth()->id())
                            <div class="flex items-center gap-0.5" title="{{ $message->status === 'read' ? __('chat.read') : ($message->status === 'delivered' ? __('chat.delivered') : __('chat.sent')) }}">
                                @if($message->isRead())
                                    <!-- Double checkmark (read) - blue -->
                                    <svg class="w-4 h-4 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 13l4 4L23 7"/>
                                    </svg>
                                @elseif($message->isDelivered())
                                    <!-- Double checkmark (delivered) - gray -->
                                    <svg class="w-4 h-4 text-neutral-400 dark:text-neutral-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 13l4 4L23 7"/>
                                    </svg>
                                @else
                                    <!-- Single checkmark (sent) - gray -->
                                    <svg class="w-4 h-4 text-neutral-400 dark:text-neutral-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
        
        <!-- Typing Indicator -->
        <div x-show="typingUsers.length > 0" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-2"
             class="chat-message received">
            <img src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($conversation->getOtherParticipant(auth()->user()), 48) }}" 
                 alt="Typing" 
                 class="chat-message-avatar">
            <div class="chat-message-content">
                <div class="chat-message-bubble">
                    <div class="flex items-center gap-1 px-2 py-1">
                        <span class="text-sm text-neutral-600 dark:text-neutral-400">
                            <span x-text="typingUsers.length === 1 ? typingUsers[0] : typingUsers.join(', ')" class="font-semibold"></span>
                            <span>{{ __('chat.typing') }}</span>
                        </span>
                        <div class="flex gap-1">
                            <div class="w-2 h-2 bg-neutral-400 dark:bg-neutral-500 rounded-full animate-bounce" style="animation-delay: 0s;"></div>
                            <div class="w-2 h-2 bg-neutral-400 dark:bg-neutral-500 rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
                            <div class="w-2 h-2 bg-neutral-400 dark:bg-neutral-500 rounded-full animate-bounce" style="animation-delay: 0.4s;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Input -->
    <div class="chat-input-container">
        <!-- Reply indicator -->
        @if($replyTo)
            <div class="chat-input-reply">
                <div>
                    <strong>{{ __('chat.replying_to') }} {{ $replyTo->user->name }}</strong>
                    <p class="text-sm">{{ Str::limit($replyTo->body, 50) }}</p>
                </div>
                <button wire:click="cancelReply" class="text-neutral-500 hover:text-neutral-700">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        @endif
        
        <!-- Attachment preview -->
        @if($attachment)
            <div class="chat-input-attachment-preview">
                @if(str_starts_with($attachment->getMimeType(), 'image/'))
                    <img src="{{ $attachment->temporaryUrl() }}" alt="Preview">
                @else
                    <div class="p-4 bg-neutral-100 dark:bg-neutral-800 rounded-lg">
                        <p class="font-medium">{{ $attachment->getClientOriginalName() }}</p>
                        <p class="text-sm text-neutral-500">{{ number_format($attachment->getSize() / 1024, 2) }} KB</p>
                    </div>
                @endif
                <button wire:click="removeAttachment" class="chat-input-attachment-remove">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        @endif
        
        <!-- Input wrapper -->
        <div class="chat-input-wrapper">
            <!-- Actions -->
            <div class="chat-input-actions">
                <label class="chat-input-btn" title="{{ __('chat.attach_file') }}">
                    <input type="file" wire:model="attachment" class="hidden" accept="image/*,application/pdf,.doc,.docx">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                    </svg>
                </label>
                
                <button class="chat-input-btn emoji-picker-btn" title="Emoji" data-emoji-picker>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </button>
            </div>
            
            <!-- Text input -->
            <textarea 
                wire:model="newMessage" 
                wire:keydown.enter.prevent="sendMessage"
                x-on:input.debounce.500ms="
                    if ($event.target.value.trim().length > 0) {
                        fetch('{{ route('api.chat.typing.start') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                conversation_id: {{ $conversation->id }}
                            })
                        });
                    }
                "
                x-on:keyup.enter="
                    fetch('{{ route('api.chat.typing.stop') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            conversation_id: {{ $conversation->id }}
                        })
                    });
                "
                x-on:blur="
                    fetch('{{ route('api.chat.typing.stop') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            conversation_id: {{ $conversation->id }}
                        })
                    });
                "
                class="chat-input-field"
                placeholder="{{ __('chat.type_message') }}"
                rows="1"></textarea>
            
            <!-- Send button -->
            <button wire:click="sendMessage" 
                    class="chat-send-btn"
                    :disabled="!$wire.newMessage && !$wire.attachment">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/>
                </svg>
            </button>
        </div>
    </div>
</div>

@script
<script>
    const chatContainerId = 'chat-messages-{{ $conversation->id }}';
    
    function scrollChatToBottom() {
        const container = document.getElementById(chatContainerId);
        if (container) {
            requestAnimationFrame(() => {
                container.scrollTop = container.scrollHeight;
                console.log('📜 Scrolled chat to bottom');
            });
        }
    }
    
    // Scroll al caricamento
    scrollChatToBottom();
    
    // Listen for Livewire events
    $wire.on('scrollToBottom', () => {
        console.log('🔔 scrollToBottom event received');
        setTimeout(() => scrollChatToBottom(), 100);
    });
    
    // Intercetta anche gli aggiornamenti del wire
    Livewire.hook('morph.updated', ({ el, component }) => {
        // Controlla se l'elemento aggiornato è il nostro container
        if (el.id === chatContainerId || el.closest('#' + chatContainerId)) {
            console.log('🔄 Chat DOM updated');
            setTimeout(() => scrollChatToBottom(), 100);
        }
    });
    
    // Backup: scroll dopo ogni update Livewire
    Livewire.hook('commit', ({ component, commit, respond }) => {
        if (component.name === 'chat.chat-show') {
            setTimeout(() => scrollChatToBottom(), 150);
        }
    });
</script>
@endscript
