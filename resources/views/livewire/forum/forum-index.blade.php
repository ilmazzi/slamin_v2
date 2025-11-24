<x-layouts.app>
    @vite(['resources/css/forum.css', 'resources/js/forum.js'])

    <div class="forum-container">
        {{-- Hero Header --}}
        <div class="forum-header">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <h1 class="forum-title">{{ __('forum.forum') }}</h1>
                <p class="forum-subtitle">Unisciti alla community, condividi idee e discuti</p>
                
                {{-- Search Bar --}}
                <div class="forum-search">
                    <input type="text" 
                           wire:model.live.debounce.300ms="search" 
                           placeholder="Cerca subreddit..."
                           class="w-full">
                    <svg class="forum-search-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {{-- Action Bar --}}
            <div class="flex items-center justify-between mb-6">
                <div class="flex gap-2">
                    <button wire:click="$set('sortBy', 'popular')" 
                            class="px-4 py-2 rounded-lg font-semibold transition-all {{ $sortBy === 'popular' ? 'bg-gradient-to-r from-orange-500 to-red-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                        {{ __('forum.popular') }}
                    </button>
                    <button wire:click="$set('sortBy', 'new')" 
                            class="px-4 py-2 rounded-lg font-semibold transition-all {{ $sortBy === 'new' ? 'bg-gradient-to-r from-orange-500 to-red-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                        {{ __('forum.new') }}
                    </button>
                    <button wire:click="$set('sortBy', 'active')" 
                            class="px-4 py-2 rounded-lg font-semibold transition-all {{ $sortBy === 'active' ? 'bg-gradient-to-r from-orange-500 to-red-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                        {{ __('forum.active') }}
                    </button>
                </div>

                @auth
                    <a href="{{ route('forum.subreddit.create') }}" wire:navigate
                       class="px-6 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-lg font-semibold hover:shadow-lg transition-all">
                        + {{ __('forum.create_subreddit') }}
                    </a>
                @endauth
            </div>

            {{-- My Subreddits (if logged in) --}}
            @auth
                @if($mySubreddits->count() > 0)
                    <div class="bg-white rounded-2xl p-6 mb-8 shadow-sm">
                        <h2 class="text-xl font-bold mb-4 text-gray-900">I Miei Subreddit</h2>
                        <div class="flex flex-wrap gap-3">
                            @foreach($mySubreddits as $sub)
                                <a href="{{ route('forum.subreddit.show', $sub) }}" wire:navigate
                                   class="inline-flex items-center gap-2 px-4 py-2 rounded-full transition-all"
                                   style="background: {{ $sub->color }}20; color: {{ $sub->color }}; border: 2px solid {{ $sub->color }};">
                                    @if($sub->icon)
                                        <img src="{{ Storage::url($sub->icon) }}" alt="" class="w-6 h-6 rounded-full">
                                    @else
                                        <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold" style="background: {{ $sub->color }}; color: white;">
                                            {{ substr($sub->name, 0, 1) }}
                                        </span>
                                    @endif
                                    <span class="font-semibold">r/{{ $sub->name }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endauth

            {{-- Subreddits Grid --}}
            <div class="subreddit-grid">
                @forelse($subreddits as $subreddit)
                    <div class="subreddit-card fade-in-up" wire:key="subreddit-{{ $subreddit->id }}">
                        <div class="subreddit-card-header" style="background: linear-gradient(135deg, {{ $subreddit->color }} 0%, {{ $subreddit->color }}dd 100%);">
                            @auth
                                <button wire:click="subscribe({{ $subreddit->id }})" 
                                        class="subscribe-btn {{ $subreddit->isSubscribed(auth()->user()) ? 'subscribed' : '' }}">
                                    {{ $subreddit->isSubscribed(auth()->user()) ? __('forum.subscribed') : __('forum.subscribe') }}
                                </button>
                            @endauth
                        </div>
                        
                        <div class="subreddit-icon" style="color: {{ $subreddit->color }};">
                            @if($subreddit->icon)
                                <img src="{{ Storage::url($subreddit->icon) }}" alt="{{ $subreddit->name }}" class="w-full h-full rounded-full object-cover">
                            @else
                                {{ substr($subreddit->name, 0, 1) }}
                            @endif
                        </div>

                        <a href="{{ route('forum.subreddit.show', $subreddit) }}" wire:navigate class="subreddit-card-body">
                            <h3 class="subreddit-name">r/{{ $subreddit->name }}</h3>
                            <p class="subreddit-description">{{ $subreddit->description }}</p>
                            
                            <div class="subreddit-stats">
                                <div class="subreddit-stat">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <strong>{{ number_format($subreddit->subscribers_count) }}</strong> {{ __('forum.subscribers') }}
                                </div>
                                <div class="subreddit-stat">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                    </svg>
                                    <strong>{{ number_format($subreddit->posts_count) }}</strong> {{ __('forum.posts') }}
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <p class="text-gray-500 text-lg">Nessun subreddit trovato</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $subreddits->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>

