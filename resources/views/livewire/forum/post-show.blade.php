<div>
    @vite(['resources/css/forum.css', 'resources/js/forum.js'])

    <div class="min-h-screen bg-neutral-50 dark:bg-neutral-950 py-6">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Back Button --}}
            <a href="{{ route('forum.subreddit.show', $post->subreddit) }}" wire:navigate
               class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to r/{{ $post->subreddit->name }}
            </a>

            {{-- Post Card --}}
            <div class="post-card mb-6">
                <div class="post-vote">
                    @livewire('forum.vote-button', ['voteable' => $post], key('vote-post-'.$post->id))
                </div>

                <div class="post-content">
                    <div class="post-header">
                        <a href="{{ route('forum.subreddit.show', $post->subreddit) }}" wire:navigate class="post-subreddit">
                            r/{{ $post->subreddit->name }}
                        </a>
                        <span class="post-author">
                            Posted by <a href="{{ route('profile.show', $post->user) }}">u/{{ $post->user->name }}</a>
                        </span>
                        <span class="post-time">{{ $post->created_at->diffForHumans() }}</span>
                        
                        @if($post->is_sticky || $post->is_locked)
                            <div class="post-badges">
                                @if($post->is_sticky)
                                    <span class="post-badge sticky">{{ __('forum.stickied') }}</span>
                                @endif
                                @if($post->is_locked)
                                    <span class="post-badge locked">{{ __('forum.locked') }}</span>
                                @endif
                            </div>
                        @endif
                    </div>

                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">{{ $post->title }}</h1>

                    @if($post->type === 'text' && $post->content)
                        <div class="prose dark:prose-invert max-w-none mb-4">
                            <p class="whitespace-pre-line">{{ $post->content }}</p>
                        </div>
                    @elseif($post->type === 'image' && $post->image_path)
                        <img src="{{ Storage::url($post->image_path) }}" alt="{{ $post->title }}" class="max-w-full rounded-lg mb-4">
                    @elseif($post->type === 'link' && $post->url)
                        <a href="{{ $post->url }}" target="_blank" class="post-link inline-flex">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            {{ $post->url }}
                        </a>
                    @endif

                    <div class="post-footer">
                        <span class="post-action">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                            </svg>
                            {{ $post->comments_count }} {{ __('forum.comments') }}
                        </span>

                        @if($isModerator)
                            <button wire:click="$dispatch('lock-post', { postId: {{ $post->id }} })" class="post-action">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                {{ $post->is_locked ? __('forum.unlock_post') : __('forum.lock_post') }}
                            </button>
                            
                            <button wire:click="$dispatch('sticky-post', { postId: {{ $post->id }} })" class="post-action">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                </svg>
                                {{ $post->is_sticky ? __('forum.unsticky_post') : __('forum.sticky_post') }}
                            </button>
                        @endif

                        @auth
                            <button wire:click="openReportModal('App\\Models\\ForumPost', {{ $post->id }})" class="post-action">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>
                                </svg>
                                {{ __('forum.report') }}
                            </button>

                            @if($post->canDelete(auth()->user()))
                                <button wire:click="deletePost" wire:confirm="Sei sicuro di voler eliminare questo post?" class="post-action text-red-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    {{ __('forum.delete') }}
                                </button>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>

            {{-- Comment Form --}}
            @auth
                @if(!$post->is_locked)
                    <div class="comments-section mb-6">
                        <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-white">{{ __('forum.add_comment') }}</h3>
                        <form wire:submit="postComment">
                            <textarea wire:model="commentContent" 
                                      rows="4" 
                                      class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-neutral-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                      placeholder="Cosa ne pensi?"></textarea>
                            @error('commentContent') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            
                            <div class="flex justify-end mt-3">
                                @if($replyTo)
                                    <button type="button" wire:click="cancelReply" class="px-4 py-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white mr-2">
                                        {{ __('forum.cancel_reply') }}
                                    </button>
                                @endif
                                <button type="submit" class="px-6 py-2 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-lg font-semibold hover:shadow-lg transition-all">
                                    {{ __('forum.comment') }}
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4 mb-6">
                        <p class="text-yellow-800 dark:text-yellow-200">{{ __('forum.post_locked') }}</p>
                    </div>
                @endif
            @endauth

            {{-- Comments --}}
            <div class="comments-section">
                <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-white">
                    {{ __('forum.comments') }} ({{ $post->comments_count }})
                </h3>

                <div class="mb-4 flex gap-2">
                    <button wire:click="$set('sortComments', 'best')" 
                            class="px-3 py-1 rounded text-sm font-semibold {{ $sortComments === 'best' ? 'bg-orange-500 text-white' : 'bg-gray-100 dark:bg-neutral-800 text-gray-700 dark:text-gray-300' }}">
                        {{ __('forum.best') }}
                    </button>
                    <button wire:click="$set('sortComments', 'new')" 
                            class="px-3 py-1 rounded text-sm font-semibold {{ $sortComments === 'new' ? 'bg-orange-500 text-white' : 'bg-gray-100 dark:bg-neutral-800 text-gray-700 dark:text-gray-300' }}">
                        {{ __('forum.new') }}
                    </button>
                    <button wire:click="$set('sortComments', 'top')" 
                            class="px-3 py-1 rounded text-sm font-semibold {{ $sortComments === 'top' ? 'bg-orange-500 text-white' : 'bg-gray-100 dark:bg-neutral-800 text-gray-700 dark:text-gray-300' }}">
                        {{ __('forum.top') }}
                    </button>
                </div>

                @forelse($comments as $comment)
                    @include('livewire.forum.partials.comment', ['comment' => $comment])
                @empty
                    <p class="text-center text-gray-500 py-8">Nessun commento ancora. Sii il primo a commentare!</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Report Modal --}}
    @if($showReportModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: @entangle('showReportModal') }">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" wire:click="closeReportModal"></div>

                <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white dark:bg-neutral-900 rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="px-6 pt-5 pb-4">
                        <div class="flex items-start justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                {{ __('forum.report_content') }}
                            </h3>
                            <button wire:click="closeReportModal" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <form wire:submit="submitReport">
                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('forum.report_reason') }}
                                </label>
                                <select wire:model="reportReason" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-neutral-800 text-gray-900 dark:text-white">
                                    <option value="spam">Spam</option>
                                    <option value="harassment">Molestie</option>
                                    <option value="hate_speech">Incitamento all'odio</option>
                                    <option value="inappropriate_content">Contenuto inappropriato</option>
                                    <option value="misinformation">Disinformazione</option>
                                    <option value="violence">Violenza</option>
                                    <option value="self_harm">Autolesionismo</option>
                                    <option value="other">Altro</option>
                                </select>
                                @error('reportReason') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('forum.report_description') }} ({{ __('forum.optional') }})
                                </label>
                                <textarea wire:model="reportDescription" 
                                          rows="4" 
                                          maxlength="1000"
                                          class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-neutral-800 text-gray-900 dark:text-white"
                                          placeholder="Descrivi il problema..."></textarea>
                                @error('reportDescription') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex justify-end gap-3">
                                <button type="button" 
                                        wire:click="closeReportModal"
                                        class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-neutral-800 rounded-lg">
                                    {{ __('forum.cancel') }}
                                </button>
                                <button type="submit" 
                                        class="px-6 py-2 bg-red-500 text-white rounded-lg font-semibold hover:bg-red-600">
                                    {{ __('forum.submit_report') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

