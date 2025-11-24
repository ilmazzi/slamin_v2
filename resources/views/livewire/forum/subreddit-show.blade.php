<div>
    @vite(['resources/css/forum.css', 'resources/js/forum.js'])

    <div class="min-h-screen bg-neutral-50 dark:bg-neutral-950">
        {{-- Subreddit Header --}}
        <div class="relative h-48 overflow-hidden" style="background: linear-gradient(135deg, {{ $subreddit->color }} 0%, {{ $subreddit->color }}dd 100%);">
            @if($subreddit->banner)
                <img src="{{ Storage::url($subreddit->banner) }}" alt="{{ $subreddit->name }}" class="absolute inset-0 w-full h-full object-cover opacity-40">
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
            
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-end pb-6">
                <div class="flex items-center gap-4 flex-1">
                    @if($subreddit->icon)
                        <img src="{{ Storage::url($subreddit->icon) }}" alt="{{ $subreddit->name }}" class="w-20 h-20 rounded-full border-4 border-white shadow-lg">
                    @else
                        <div class="w-20 h-20 rounded-full border-4 border-white shadow-lg flex items-center justify-center text-3xl font-bold text-white" style="background: {{ $subreddit->color }};">
                            {{ substr($subreddit->name, 0, 1) }}
                        </div>
                    @endif
                    
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-white mb-1">r/{{ $subreddit->name }}</h1>
                        <p class="text-white/90">{{ $subreddit->description }}</p>
                    </div>
                </div>

                <div class="flex gap-3">
                    @auth
                        <button wire:click="subscribe" 
                                class="px-6 py-3 rounded-xl font-semibold transition-all {{ $isSubscribed ? 'bg-white text-gray-900' : 'bg-white/20 text-white border-2 border-white backdrop-blur-sm' }}">
                            {{ $isSubscribed ? __('forum.subscribed') : __('forum.subscribe') }}
                        </button>
                        
                        @if($isModerator)
                            <a href="{{ route('forum.subreddit.settings', $subreddit) }}" wire:navigate
                               class="px-6 py-3 bg-white/20 text-white border-2 border-white backdrop-blur-sm rounded-xl font-semibold hover:bg-white hover:text-gray-900 transition-all">
                                {{ __('forum.settings') }}
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            {{-- Stats Bar --}}
            <div class="bg-white dark:bg-neutral-900 rounded-xl p-4 mb-6 flex items-center justify-between">
                <div class="flex gap-6">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($subreddit->subscribers_count) }}</span>
                        <span class="text-gray-500">{{ __('forum.subscribers') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                        </svg>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($subreddit->posts_count) }}</span>
                        <span class="text-gray-500">{{ __('forum.posts') }}</span>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button wire:click="$set('sortBy', 'hot')" 
                            class="px-4 py-2 rounded-lg font-semibold transition-all {{ $sortBy === 'hot' ? 'bg-gradient-to-r from-orange-500 to-red-500 text-white' : 'bg-gray-100 dark:bg-neutral-800 text-gray-700 dark:text-gray-300' }}">
                        {{ __('forum.hot') }}
                    </button>
                    <button wire:click="$set('sortBy', 'new')" 
                            class="px-4 py-2 rounded-lg font-semibold transition-all {{ $sortBy === 'new' ? 'bg-gradient-to-r from-orange-500 to-red-500 text-white' : 'bg-gray-100 dark:bg-neutral-800 text-gray-700 dark:text-gray-300' }}">
                        {{ __('forum.new') }}
                    </button>
                    <button wire:click="$set('sortBy', 'top')" 
                            class="px-4 py-2 rounded-lg font-semibold transition-all {{ $sortBy === 'top' ? 'bg-gradient-to-r from-orange-500 to-red-500 text-white' : 'bg-gray-100 dark:bg-neutral-800 text-gray-700 dark:text-gray-300' }}">
                        {{ __('forum.top') }}
                    </button>
                </div>

                @auth
                    <a href="{{ route('forum.post.create', $subreddit) }}" wire:navigate
                       class="px-6 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-lg font-semibold hover:shadow-lg transition-all">
                        + {{ __('forum.create_post') }}
                    </a>
                @endauth
            </div>

            {{-- Moderator Panel --}}
            @if($isModerator)
                <div class="mod-panel mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold">{{ __('forum.moderation') }}</h3>
                        <div class="mod-tabs">
                            <a href="{{ route('forum.mod.queue', $subreddit) }}" wire:navigate class="mod-tab">
                                {{ __('forum.moderation_queue') }}
                            </a>
                            <a href="{{ route('forum.mod.reports', $subreddit) }}" wire:navigate class="mod-tab">
                                {{ __('forum.reports') }}
                            </a>
                            <a href="{{ route('forum.mod.bans', $subreddit) }}" wire:navigate class="mod-tab">
                                {{ __('forum.bans') }}
                            </a>
                            <a href="{{ route('forum.mod.moderators', $subreddit) }}" wire:navigate class="mod-tab">
                                {{ __('forum.moderators') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Posts List --}}
            <div class="space-y-4">
                @forelse($posts as $post)
                    <div class="post-card fade-in-up" wire:key="post-{{ $post->id }}">
                        {{-- Vote Section --}}
                        <div class="post-vote">
                            @livewire('forum.vote-button', ['voteable' => $post], key('vote-post-'.$post->id))
                        </div>

                        {{-- Post Content --}}
                        <div class="post-content">
                            <div class="post-header">
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

                            <h2 class="post-title">
                                <a href="{{ route('forum.post.show', [$subreddit, $post]) }}" wire:navigate>
                                    {{ $post->title }}
                                </a>
                            </h2>

                            @if($post->type === 'text' && $post->content)
                                <p class="post-text">{{ $post->content }}</p>
                            @elseif($post->type === 'image' && $post->image_path)
                                <img src="{{ Storage::url($post->image_path) }}" alt="{{ $post->title }}" class="post-image">
                            @elseif($post->type === 'link' && $post->url)
                                <a href="{{ $post->url }}" target="_blank" class="post-link">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                    {{ $post->url }}
                                </a>
                            @endif

                            <div class="post-footer">
                                <a href="{{ route('forum.post.show', [$subreddit, $post]) }}" wire:navigate class="post-action">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                    </svg>
                                    {{ $post->comments_count }} {{ __('forum.comments') }}
                                </a>
                                <button class="post-action">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                    </svg>
                                    {{ __('forum.share') }}
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 bg-white dark:bg-neutral-900 rounded-xl">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <p class="text-gray-500 text-lg">Nessun post ancora</p>
                        @auth
                            <a href="{{ route('forum.post.create', $subreddit) }}" wire:navigate
                               class="inline-block mt-4 px-6 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-lg font-semibold">
                                Sii il primo a postare!
                            </a>
                        @endauth
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</div>

