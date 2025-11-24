@php
    $displayName = $conversation->getDisplayName(auth()->user());
    $displayAvatar = $conversation->getDisplayAvatar(auth()->user());
    $otherUser = $conversation->getOtherParticipant(auth()->user());
@endphp

<div class="flex flex-col h-full">
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
                <p class="chat-header-status">
                    {{ $otherUser->is_online ? __('chat.online') : __('chat.offline') }}
                </p>
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
            <button class="chat-header-btn" title="{{ __('chat.info') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </button>
        </div>
    </div>
    
    <!-- Messages -->
    <div class="chat-messages" id="chat-messages-{{ $conversation->id }}" wire:poll.5s="loadMessages">
        @foreach($messages as $message)
            <div class="chat-message {{ $message->user_id === auth()->id() ? 'sent' : 'received' }}">
                <!-- Avatar (only for received messages) -->
                @if($message->user_id !== auth()->id())
                    @if($message->user->profile_photo)
                        <img src="{{ $message->user->profile_photo }}" 
                             alt="{{ $message->user->name }}" 
                             class="chat-message-avatar">
                    @else
                        <div class="chat-avatar-placeholder" style="width: 36px; height: 36px; font-size: 0.9rem;">
                            {{ strtoupper(substr($message->user->name, 0, 2)) }}
                        </div>
                    @endif
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
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
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
                
                <button class="chat-input-btn" title="{{ __('chat.emoji') }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </button>
            </div>
            
            <!-- Text input -->
            <textarea 
                wire:model="newMessage" 
                wire:keydown.enter.prevent="sendMessage"
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

<script>
    // Auto-scroll to bottom on new messages
    document.addEventListener('livewire:load', function () {
        const messagesContainer = document.getElementById('chat-messages-{{ $conversation->id }}');
        if (messagesContainer) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    });
    
    // Mark as read when viewing
    @this.on('messagesLoaded', () => {
        const messagesContainer = document.getElementById('chat-messages-{{ $conversation->id }}');
        if (messagesContainer) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    });
</script>
