<div class="comment {{ $depth ?? 0 > 0 ? 'ml-8 border-l-2 border-gray-200 dark:border-gray-700 pl-4' : '' }}" 
     wire:key="comment-{{ $comment->id }}"
     x-data="{ showReply: false, editing: false }">
    
    <div class="flex gap-3 mb-3">
        {{-- Vote Section --}}
        <div class="flex-shrink-0">
            @livewire('forum.vote-button', ['voteable' => $comment], key('vote-comment-'.$comment->id))
        </div>

        {{-- Comment Content --}}
        <div class="flex-1">
            <div class="flex items-center gap-2 mb-2">
                <a href="{{ route('profile.show', $comment->user) }}" class="font-semibold text-gray-900 dark:text-white hover:underline">
                    u/{{ $comment->user->name }}
                </a>
                <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                
                @if($comment->is_edited)
                    <span class="text-xs text-gray-400">(edited)</span>
                @endif

                @if($comment->deleted_at)
                    <span class="text-xs text-red-500">[deleted]</span>
                @endif
            </div>

            @if($comment->deleted_at)
                <p class="text-gray-400 italic">[{{ __('forum.comment_deleted') }}]</p>
            @else
                <div x-show="!editing">
                    <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line mb-3">{{ $comment->content }}</p>
                </div>

                <div x-show="editing" x-cloak>
                    <textarea wire:model="editingContent" 
                              rows="3" 
                              class="w-full px-3 py-2 rounded border border-gray-300 dark:border-gray-700 bg-white dark:bg-neutral-800 text-gray-900 dark:text-white text-sm"></textarea>
                    <div class="flex gap-2 mt-2">
                        <button wire:click="updateComment({{ $comment->id }})" 
                                @click="editing = false"
                                class="px-3 py-1 bg-orange-500 text-white rounded text-sm font-semibold">
                            {{ __('forum.save') }}
                        </button>
                        <button @click="editing = false" class="px-3 py-1 bg-gray-200 dark:bg-neutral-700 text-gray-700 dark:text-gray-300 rounded text-sm">
                            {{ __('forum.cancel') }}
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-4 text-sm">
                    @auth
                        @if(!$post->is_locked)
                            <button wire:click="replyTo({{ $comment->id }})" 
                                    @click="showReply = !showReply"
                                    class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 font-semibold">
                                <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                </svg>
                                {{ __('forum.reply') }}
                            </button>
                        @endif

                        @if($comment->user_id === auth()->id())
                            <button @click="editing = true" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 font-semibold">
                                {{ __('forum.edit') }}
                            </button>
                            <button wire:click="deleteComment({{ $comment->id }})" 
                                    wire:confirm="Sei sicuro di voler eliminare questo commento?"
                                    class="text-red-500 hover:text-red-700 font-semibold">
                                {{ __('forum.delete') }}
                            </button>
                        @endif

                        <button wire:click="openReportModal('App\\Models\\ForumComment', {{ $comment->id }})" 
                                class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 font-semibold">
                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>
                            </svg>
                            {{ __('forum.report') }}
                        </button>
                    @endauth
                </div>

                {{-- Reply Form --}}
                <div x-show="showReply" x-cloak class="mt-3">
                    <textarea wire:model="commentContent" 
                              rows="3" 
                              class="w-full px-3 py-2 rounded border border-gray-300 dark:border-gray-700 bg-white dark:bg-neutral-800 text-gray-900 dark:text-white text-sm"
                              placeholder="Scrivi una risposta..."></textarea>
                    <div class="flex gap-2 mt-2">
                        <button wire:click="postComment" 
                                @click="showReply = false"
                                class="px-3 py-1 bg-orange-500 text-white rounded text-sm font-semibold">
                            {{ __('forum.reply') }}
                        </button>
                        <button wire:click="cancelReply" 
                                @click="showReply = false"
                                class="px-3 py-1 bg-gray-200 dark:bg-neutral-700 text-gray-700 dark:text-gray-300 rounded text-sm">
                            {{ __('forum.cancel') }}
                        </button>
                    </div>
                </div>
            @endif

            {{-- Nested Comments --}}
            @if($comment->children && $comment->children->count() > 0)
                <div class="mt-4">
                    @foreach($comment->children as $childComment)
                        @include('livewire.forum.partials.comment', ['comment' => $childComment, 'depth' => ($depth ?? 0) + 1])
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

