<div class="min-h-screen bg-gradient-to-br from-neutral-50 via-primary-50/30 to-accent-50/20 dark:from-neutral-900 dark:via-primary-950/50 dark:to-accent-950/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
        
        <!-- Header -->
        <div class="text-center mb-8 md:mb-12">
            <h1 class="text-4xl md:text-6xl font-bold text-neutral-900 dark:text-white mb-4" style="font-family: 'Crimson Pro', serif;">
                {{ __('search.title') }}
            </h1>
            
            <!-- Search Bar -->
            <div class="max-w-2xl mx-auto mt-6">
                <div class="relative">
                    <input type="text" 
                           wire:model.live.debounce.500ms="query"
                           placeholder="{{ __('search.placeholder') }}"
                           class="w-full px-6 py-4 pl-12 rounded-full 
                                  border-2 border-neutral-300 dark:border-neutral-700 
                                  bg-white dark:bg-neutral-800
                                  text-neutral-900 dark:text-white placeholder:text-neutral-500
                                  focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20
                                  transition-all duration-300
                                  text-lg">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-6 h-6 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    @if($query)
                        <button wire:click="$set('query', '')" 
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-neutral-400 hover:text-primary-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    @endif
                </div>
            </div>

            <!-- Filter Tabs -->
            @if($query)
            <div class="flex flex-wrap items-center justify-center gap-2 mt-6">
                <button wire:click="$set('type', 'all')"
                        class="px-4 py-2 rounded-full text-sm font-medium transition-all
                               {{ $type === 'all' ? 'bg-primary-600 text-white shadow-lg' : 'bg-white dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700' }}">
                    {{ __('search.all') }}
                </button>
                <button wire:click="$set('type', 'poems')"
                        class="px-4 py-2 rounded-full text-sm font-medium transition-all
                               {{ $type === 'poems' ? 'bg-primary-600 text-white shadow-lg' : 'bg-white dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700' }}">
                    {{ __('search.poems') }}
                </button>
                <button wire:click="$set('type', 'articles')"
                        class="px-4 py-2 rounded-full text-sm font-medium transition-all
                               {{ $type === 'articles' ? 'bg-primary-600 text-white shadow-lg' : 'bg-white dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700' }}">
                    {{ __('search.articles') }}
                </button>
                <button wire:click="$set('type', 'events')"
                        class="px-4 py-2 rounded-full text-sm font-medium transition-all
                               {{ $type === 'events' ? 'bg-primary-600 text-white shadow-lg' : 'bg-white dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700' }}">
                    {{ __('search.events') }}
                </button>
                <button wire:click="$set('type', 'users')"
                        class="px-4 py-2 rounded-full text-sm font-medium transition-all
                               {{ $type === 'users' ? 'bg-primary-600 text-white shadow-lg' : 'bg-white dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700' }}">
                    {{ __('search.users') }}
                </button>
                <button wire:click="$set('type', 'videos')"
                        class="px-4 py-2 rounded-full text-sm font-medium transition-all
                               {{ $type === 'videos' ? 'bg-primary-600 text-white shadow-lg' : 'bg-white dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700' }}">
                    {{ __('search.videos') }}
                </button>
                <button wire:click="$set('type', 'gigs')"
                        class="px-4 py-2 rounded-full text-sm font-medium transition-all
                               {{ $type === 'gigs' ? 'bg-primary-600 text-white shadow-lg' : 'bg-white dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700' }}">
                    {{ __('search.gigs') }}
                </button>
            </div>
            @endif
        </div>

        <!-- Results -->
        @if(empty($query))
            <div class="text-center py-16">
                <svg class="w-24 h-24 mx-auto text-neutral-300 dark:text-neutral-700 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <p class="text-xl text-neutral-600 dark:text-neutral-400">{{ __('search.start_searching') }}</p>
            </div>
        @elseif($totalResults === 0)
            <div class="text-center py-16">
                <svg class="w-24 h-24 mx-auto text-neutral-300 dark:text-neutral-700 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-xl text-neutral-600 dark:text-neutral-400 mb-2">{{ __('search.no_results') }}</p>
                <p class="text-neutral-500 dark:text-neutral-500">{{ __('search.try_different') }}</p>
            </div>
        @else
            <div class="space-y-8">
                <!-- Results Summary -->
                <div class="text-center">
                    <p class="text-lg text-neutral-600 dark:text-neutral-400">
                        {{ __('search.found_results', ['count' => $totalResults, 'query' => $query]) }}
                    </p>
                </div>

                <!-- Poesie -->
                @if(($type === 'all' || $type === 'poems') && $results['poems']->count() > 0)
                <div class="bg-white/80 dark:bg-neutral-800/80 backdrop-blur-xl rounded-3xl shadow-xl border border-neutral-200 dark:border-neutral-700 p-6 md:p-8">
                    <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-6 flex items-center gap-3">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        {{ __('search.poems') }} ({{ $results['poems']->count() }})
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($results['poems'] as $poem)
                            <a href="{{ route('poems.show', $poem->slug ?? $poem->id) }}" 
                               class="block p-4 rounded-xl bg-neutral-50 dark:bg-neutral-900 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors border border-neutral-200 dark:border-neutral-700">
                                <h3 class="font-semibold text-neutral-900 dark:text-white mb-2 line-clamp-2">{{ $poem->title }}</h3>
                                <p class="text-sm text-neutral-600 dark:text-neutral-400 line-clamp-2">{{ Str::limit(strip_tags($poem->content), 100) }}</p>
                                <p class="text-xs text-neutral-500 dark:text-neutral-500 mt-2">{{ $poem->user->name }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Articoli -->
                @if(($type === 'all' || $type === 'articles') && $results['articles']->count() > 0)
                <div class="bg-white/80 dark:bg-neutral-800/80 backdrop-blur-xl rounded-3xl shadow-xl border border-neutral-200 dark:border-neutral-700 p-6 md:p-8">
                    <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-6 flex items-center gap-3">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                        {{ __('search.articles') }} ({{ $results['articles']->count() }})
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($results['articles'] as $article)
                            <a href="{{ route('articles.show', $article->slug ?? $article->id) }}" 
                               class="block p-4 rounded-xl bg-neutral-50 dark:bg-neutral-900 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors border border-neutral-200 dark:border-neutral-700">
                                <h3 class="font-semibold text-neutral-900 dark:text-white mb-2 line-clamp-2">{{ $article->title }}</h3>
                                <p class="text-sm text-neutral-600 dark:text-neutral-400 line-clamp-2">{{ Str::limit($article->excerpt ?? strip_tags($article->content), 100) }}</p>
                                <p class="text-xs text-neutral-500 dark:text-neutral-500 mt-2">{{ $article->user->name }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Eventi -->
                @if(($type === 'all' || $type === 'events') && $results['events']->count() > 0)
                <div class="bg-white/80 dark:bg-neutral-800/80 backdrop-blur-xl rounded-3xl shadow-xl border border-neutral-200 dark:border-neutral-700 p-6 md:p-8">
                    <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-6 flex items-center gap-3">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ __('search.events') }} ({{ $results['events']->count() }})
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($results['events'] as $event)
                            <a href="{{ route('events.show', $event) }}" 
                               class="block p-4 rounded-xl bg-neutral-50 dark:bg-neutral-900 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors border border-neutral-200 dark:border-neutral-700">
                                <h3 class="font-semibold text-neutral-900 dark:text-white mb-2 line-clamp-2">{{ $event->title }}</h3>
                                <p class="text-sm text-neutral-600 dark:text-neutral-400 line-clamp-2">{{ Str::limit($event->description, 100) }}</p>
                                <p class="text-xs text-neutral-500 dark:text-neutral-500 mt-2">{{ $event->location }} • {{ $event->start_datetime->format('d/m/Y') }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Utenti -->
                @if(($type === 'all' || $type === 'users') && $results['users']->count() > 0)
                <div class="bg-white/80 dark:bg-neutral-800/80 backdrop-blur-xl rounded-3xl shadow-xl border border-neutral-200 dark:border-neutral-700 p-6 md:p-8">
                    <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-6 flex items-center gap-3">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        {{ __('search.users') }} ({{ $results['users']->count() }})
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach($results['users'] as $user)
                            <div class="block p-4 rounded-xl bg-neutral-50 dark:bg-neutral-900 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors border border-neutral-200 dark:border-neutral-700 text-center">
                                <a href="{{ \App\Helpers\AvatarHelper::getUserProfileUrl($user) }}" 
                                   class="block">
                                    <img src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($user, 64) }}" 
                                         alt="{{ $user->name }}"
                                         class="w-16 h-16 rounded-full mx-auto mb-3 object-cover">
                                    <h3 class="font-semibold text-neutral-900 dark:text-white">{{ $user->name }}</h3>
                                    @if($user->nickname)
                                        <p class="text-sm text-neutral-500 dark:text-neutral-500">{{ '@' . $user->nickname }}</p>
                                    @endif
                                </a>
                                <div class="mt-3">
                                    <livewire:components.follow-button :userId="$user->id" size="sm" variant="outline" />
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Video -->
                @if(($type === 'all' || $type === 'videos') && $results['videos']->count() > 0)
                <div class="bg-white/80 dark:bg-neutral-800/80 backdrop-blur-xl rounded-3xl shadow-xl border border-neutral-200 dark:border-neutral-700 p-6 md:p-8">
                    <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-6 flex items-center gap-3">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        {{ __('search.videos') }} ({{ $results['videos']->count() }})
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($results['videos'] as $video)
                            <a href="{{ route('videos.show', $video) }}" 
                               class="block rounded-xl bg-neutral-50 dark:bg-neutral-900 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors border border-neutral-200 dark:border-neutral-700 overflow-hidden">
                                @if($video->thumbnail_path)
                                    <img src="{{ $video->thumbnail_path }}" 
                                         alt="{{ $video->title }}"
                                         class="w-full h-48 object-cover">
                                @endif
                                <div class="p-4">
                                    <h3 class="font-semibold text-neutral-900 dark:text-white mb-2 line-clamp-2">{{ $video->title }}</h3>
                                    <p class="text-xs text-neutral-500 dark:text-neutral-500">{{ $video->user->name }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Ingaggi -->
                @if(($type === 'all' || $type === 'gigs') && $results['gigs']->count() > 0)
                <div class="bg-white/80 dark:bg-neutral-800/80 backdrop-blur-xl rounded-3xl shadow-xl border border-neutral-200 dark:border-neutral-700 p-6 md:p-8">
                    <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-6 flex items-center gap-3">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        {{ __('search.gigs') }} ({{ $results['gigs']->count() }})
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($results['gigs'] as $gig)
                            <a href="{{ route('gigs.show', $gig) }}" 
                               class="block p-4 rounded-xl bg-neutral-50 dark:bg-neutral-900 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors border border-neutral-200 dark:border-neutral-700">
                                <h3 class="font-semibold text-neutral-900 dark:text-white mb-2 line-clamp-2">{{ $gig->title }}</h3>
                                <p class="text-sm text-neutral-600 dark:text-neutral-400 line-clamp-2">{{ Str::limit($gig->description, 100) }}</p>
                                <p class="text-xs text-neutral-500 dark:text-neutral-500 mt-2">{{ $gig->location }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        @endif
    </div>
</div>

