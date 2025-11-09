<div class="min-h-screen bg-gradient-to-br from-neutral-50 via-primary-50/30 to-neutral-50 dark:from-neutral-900 dark:via-primary-950/20 dark:to-neutral-900">
    
    <!-- VERSI FLUTTUANTI IN BACKGROUND - Poetico -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden" style="z-index: 5;" aria-hidden="true">
        @php
            // Prendi 6 versi random dalle poesie
            $floatingVerses = \App\Models\Poem::published()
                ->inRandomOrder()
                ->limit(6)
                ->get()
                ->map(function($p) {
                    $content = strip_tags($p->content);
                    $lines = array_filter(explode("\n", $content));
                    if (empty($lines)) return null;
                    $verse = trim($lines[array_rand($lines)]);
                    return Str::limit($verse, 45);
                })
                ->filter()
                ->take(6);
        @endphp
        
        @foreach($floatingVerses as $idx => $verse)
            <div class="absolute font-poem text-xl md:text-2xl italic font-medium pointer-events-none select-none px-4"
                 style="
                    top: {{ 12 + ($idx * 13) }}%;
                    {{ $idx % 2 === 0 ? 'left' : 'right' }}: 8%;
                    color: #10b981;
                    opacity: 0.18;
                    animation: float-verse-{{ $idx }} {{ 30 + ($idx * 2) }}s ease-in-out infinite;
                    animation-delay: {{ $idx * 2 }}s;
                    z-index: 5;
                    max-width: 400px;
                ">
                "{{ $verse }}"
            </div>
            
            <style>
                @keyframes float-verse-{{ $idx }} {
                    0%, 100% { 
                        transform: translateY(0) rotate({{ -4 + ($idx * 1.5) }}deg);
                    }
                    50% { 
                        transform: translateY(-40px) rotate({{ -2 + ($idx * 1.5) }}deg);
                    }
                }
            </style>
        @endforeach
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" style="z-index: 10;">
        
        
        <!-- Poetic Header with animated quote marks -->
        <div class="text-center mb-16 relative">
            <!-- Decorative Quote Marks -->
            <div class="absolute -top-8 left-1/2 -translate-x-1/2 text-primary-200 dark:text-primary-900/30 text-9xl font-poem leading-none pointer-events-none">
                "
            </div>
            
            <div class="relative z-10">
                <h1 class="text-5xl md:text-7xl font-bold text-neutral-900 dark:text-white mb-4 font-poem tracking-tight">
                    <span class="inline-block animate-fade-in">{{ __('poems.index.title') }}</span>
                </h1>
                <p class="text-lg md:text-xl text-neutral-600 dark:text-neutral-400 max-w-2xl mx-auto font-poem italic animate-fade-in-delay-2">
                    "{{ __('poems.index.subtitle') }}"
                </p>
            </div>
            
            @auth
                <div class="mt-8 animate-fade-in-delay-2">
                    <a href="{{ route('poems.create') }}" 
                       class="group inline-flex items-center gap-3 px-8 py-4 rounded-2xl
                              bg-gradient-to-r from-primary-500 to-primary-600 
                              hover:from-primary-600 hover:to-primary-700
                              text-white font-semibold shadow-2xl shadow-primary-500/30
                              hover:shadow-3xl hover:shadow-primary-500/40 hover:-translate-y-1
                              transition-all duration-300">
                        <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-300" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M12 4v16m8-8H4"/>
                        </svg>
                        <span class="font-poem text-lg">{{ __('poems.create.write_poem') }}</span>
                    </a>
                </div>
            @endauth
        </div>
        
        <!-- Search & Filters - Modern Card -->
        <div class="mb-12 animate-fade-in-delay-1">
            <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 
                        rounded-3xl shadow-2xl border border-white/20 dark:border-neutral-700/50 
                        p-6 md:p-8">
                
                <!-- View Mode Toggle -->
                <div class="flex items-center justify-between mb-6 pb-6 border-b border-neutral-200 dark:border-neutral-700">
                    <h3 class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                        {{ __('poems.index.view_mode') }}
                    </h3>
                    <div class="flex gap-2">
                        <button wire:click="setViewMode('grid')"
                                class="p-3 rounded-xl transition-all duration-200
                                       {{ $viewMode === 'grid' 
                                          ? 'bg-primary-500 text-white shadow-lg' 
                                          : 'bg-neutral-100 dark:bg-neutral-700 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-neutral-600' }}"
                                title="{{ __('poems.index.view_grid') }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                        </button>
                        <button wire:click="setViewMode('list')"
                                class="p-3 rounded-xl transition-all duration-200
                                       {{ $viewMode === 'list' 
                                          ? 'bg-primary-500 text-white shadow-lg' 
                                          : 'bg-neutral-100 dark:bg-neutral-700 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-neutral-600' }}"
                                title="{{ __('poems.index.view_list') }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        <button wire:click="setViewMode('magazine')"
                                class="p-3 rounded-xl transition-all duration-200
                                       {{ $viewMode === 'magazine' 
                                          ? 'bg-primary-500 text-white shadow-lg' 
                                          : 'bg-neutral-100 dark:bg-neutral-700 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-neutral-600' }}"
                                title="{{ __('poems.index.view_magazine') }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    
                    <!-- Search with Icon -->
                    <div class="lg:col-span-2 relative group">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-neutral-400 group-focus-within:text-primary-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input wire:model.live.debounce.500ms="search"
                               type="text"
                               placeholder="{{ __('poems.index.search_placeholder') }}"
                               class="w-full pl-12 pr-4 py-4 rounded-2xl 
                                      border-2 border-neutral-200 dark:border-neutral-700 
                                      bg-white dark:bg-neutral-900
                                      text-neutral-900 dark:text-white placeholder:text-neutral-400
                                      focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20
                                      transition-all duration-300 font-poem">
                        
                        @if($search)
                            <button wire:click="$set('search', '')" 
                                    class="absolute right-4 top-1/2 -translate-y-1/2
                                           text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-200
                                           hover:scale-110 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        @endif
                    </div>
                    
                    <!-- Filters -->
                    <!-- Category -->
                    <div class="relative">
                        <select wire:model.live="category"
                                class="w-full appearance-none pl-4 pr-10 py-4 rounded-2xl 
                                       bg-gradient-to-br from-white to-neutral-50 
                                       dark:from-neutral-800 dark:to-neutral-900
                                       border border-neutral-300 dark:border-neutral-600
                                       text-neutral-900 dark:text-white
                                       focus:border-primary-500 focus:ring-2 focus:ring-primary-500/30
                                       hover:border-primary-400 dark:hover:border-primary-600
                                       hover:shadow-md
                                       transition-all duration-200 cursor-pointer 
                                       font-medium text-sm">
                            <option value="">{{ __('poems.filters.all_categories') }}</option>
                            @foreach($categories as $key => $name)
                                <option value="{{ $key }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                            <svg class="w-5 h-5 text-neutral-500 dark:text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Language -->
                    <div class="relative">
                        <select wire:model.live="language"
                                class="w-full appearance-none pl-4 pr-10 py-4 rounded-2xl 
                                       bg-gradient-to-br from-white to-neutral-50 
                                       dark:from-neutral-800 dark:to-neutral-900
                                       border border-neutral-300 dark:border-neutral-600
                                       text-neutral-900 dark:text-white
                                       focus:border-primary-500 focus:ring-2 focus:ring-primary-500/30
                                       hover:border-primary-400 dark:hover:border-primary-600
                                       hover:shadow-md
                                       transition-all duration-200 cursor-pointer 
                                       font-medium text-sm">
                            <option value="">{{ __('poems.filters.all_languages') }}</option>
                            @foreach($languages as $code => $name)
                                <option value="{{ $code }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                            <svg class="w-5 h-5 text-neutral-500 dark:text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Sort -->
                    <div class="relative">
                        <select wire:model.live="sort"
                                class="w-full appearance-none pl-4 pr-10 py-4 rounded-2xl 
                                       bg-gradient-to-br from-white to-neutral-50 
                                       dark:from-neutral-800 dark:to-neutral-900
                                       border border-neutral-300 dark:border-neutral-600
                                       text-neutral-900 dark:text-white
                                       focus:border-primary-500 focus:ring-2 focus:ring-primary-500/30
                                       hover:border-primary-400 dark:hover:border-primary-600
                                       hover:shadow-md
                                       transition-all duration-200 cursor-pointer 
                                       font-medium text-sm">
                            <option value="recent">{{ __('poems.filters.sort_recent') }}</option>
                            <option value="popular">{{ __('poems.filters.sort_popular') }}</option>
                            <option value="oldest">{{ __('poems.filters.sort_oldest') }}</option>
                            <option value="alphabetical">{{ __('poems.filters.sort_alphabetical') }}</option>
                        </select>
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                            <svg class="w-5 h-5 text-neutral-500 dark:text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Active Filters -->
                @if($search || $category || $language || $type || $sort !== 'recent')
                    <div class="mt-6 flex items-center justify-between gap-4 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                        <div class="flex flex-wrap gap-2">
                            @if($search)
                                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full
                                           bg-gradient-to-r from-primary-100 to-primary-50 
                                           dark:from-primary-900/30 dark:to-primary-900/20
                                           text-primary-700 dark:text-primary-300 text-sm font-medium
                                           border border-primary-200 dark:border-primary-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    "{{ Str::limit($search, 20) }}"
                                    <button wire:click="$set('search', '')" 
                                            class="hover:text-primary-900 dark:hover:text-primary-100 font-bold">×</button>
                                </span>
                            @endif
                            
                            @if($category)
                                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full
                                           bg-gradient-to-r from-primary-100 to-primary-50 
                                           dark:from-primary-900/30 dark:to-primary-900/20
                                           text-primary-700 dark:text-primary-300 text-sm font-medium
                                           border border-primary-200 dark:border-primary-800">
                                    {{ $categories[$category] }}
                                    <button wire:click="$set('category', '')" 
                                            class="hover:text-primary-900 dark:hover:text-primary-100 font-bold">×</button>
                                </span>
                            @endif
                            
                            @if($language)
                                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full
                                           bg-gradient-to-r from-primary-100 to-primary-50 
                                           dark:from-primary-900/30 dark:to-primary-900/20
                                           text-primary-700 dark:text-primary-300 text-sm font-medium
                                           border border-primary-200 dark:border-primary-800">
                                    {{ $languages[$language] }}
                                    <button wire:click="$set('language', '')" 
                                            class="hover:text-primary-900 dark:hover:text-primary-100 font-bold">×</button>
                                </span>
                            @endif
                        </div>
                        
                        <button wire:click="resetFilters"
                                class="px-4 py-2 text-sm text-neutral-600 dark:text-neutral-400
                                       hover:text-primary-600 dark:hover:text-primary-400 
                                       transition-colors font-medium whitespace-nowrap">
                            ✨ {{ __('poems.index.clear_filters') }}
                        </button>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Loading with Poetry -->
        <div wire:loading.delay class="mb-8 flex justify-center">
            <div class="inline-flex items-center gap-3 px-6 py-4 rounded-2xl
                        backdrop-blur-xl bg-primary-50/80 dark:bg-primary-900/20 
                        text-primary-600 dark:text-primary-400
                        border border-primary-200 dark:border-primary-800
                        shadow-lg">
                <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" 
                            stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" 
                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="font-medium font-poem">{{ __('poems.index.searching') }}</span>
            </div>
        </div>
        
        <!-- Poems Display -->
        @if($poems->count() > 0)
            
            <!-- GRID VIEW (Default) -->
            @if($viewMode === 'grid')
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                    @foreach($poems as $index => $poem)
                        <div style="animation-delay: {{ $index * 0.1 }}s" 
                             class="opacity-0 animate-fade-in">
                            <livewire:poems.poem-card 
                                :poem="$poem" 
                                :key="'poem-'.$poem->id" 
                                wire:key="poem-{{ $poem->id }}" />
                        </div>
                    @endforeach
                </div>
            @endif
            
            <!-- LIST VIEW -->
            @if($viewMode === 'list')
                <div class="space-y-6 mb-12">
                    @foreach($poems as $index => $poem)
                        <div style="animation-delay: {{ $index * 0.05 }}s" 
                             class="opacity-0 animate-fade-in">
                            <article class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 
                                           rounded-2xl shadow-lg hover:shadow-xl
                                           border border-white/50 dark:border-neutral-700/50
                                           overflow-hidden transition-all duration-300 hover:-translate-y-1
                                           cursor-pointer"
                                    onclick="window.location='{{ route('poems.show', $poem->slug) }}'">
                                <div class="flex flex-col md:flex-row">
                                    <!-- Thumbnail Small -->
                                    <div class="md:w-48 aspect-[4/3] md:aspect-square relative flex-shrink-0">
                                        @if($poem->thumbnail_url)
                                            <img src="{{ $poem->thumbnail_url }}" 
                                                 alt="{{ $poem->title ?: __('poems.untitled') }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center">
                                                <svg class="w-16 h-16 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                            </div>
                                        @endif
                                        
                                        @if($poem->is_featured)
                                            <div class="absolute top-2 right-2">
                                                <x-ui.badges.category label="⭐ Featured" color="warning" class="!text-xs" />
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Content -->
                                    <div class="flex-1 p-6 md:p-8 flex flex-col">
                                        <div class="flex items-start justify-between gap-4 mb-4">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-3">
                                                    <x-ui.badges.category 
                                                        :label="config('poems.categories')[$poem->category] ?? $poem->category" 
                                                        color="primary" 
                                                        class="!text-xs !px-3 !py-1" />
                                                </div>
                                                
                                                <h3 class="text-2xl font-bold text-neutral-900 dark:text-white mb-2 font-poem">
                                                    {{ $poem->title ? '"' . $poem->title . '"' : __('poems.untitled') }}
                                                </h3>
                                                
                                                <p class="text-neutral-600 dark:text-neutral-400 line-clamp-2 mb-4 font-poem italic">
                                                    {{ $poem->description ?? Str::limit(strip_tags($poem->content), 150) }}
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center justify-between mt-auto">
                                            <x-ui.user-avatar 
                                                :user="$poem->user" 
                                                size="sm" 
                                                :showName="true" 
                                                :link="false" />
                                            
                                            <div class="flex items-center gap-4" @click.stop>
                                                <x-like-button :itemId="$poem->id" itemType="poem" :isLiked="false" :likesCount="$poem->like_count ?? 0" size="sm" />
                                                <x-comment-button :itemId="$poem->id" itemType="poem" :commentsCount="$poem->comment_count ?? 0" size="sm" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            @endif
            
            <!-- MAGAZINE VIEW - BENTO GRID ASIMMETRICO -->
            @if($viewMode === 'magazine')
                @include('livewire.poems.poem-index-magazine')
            @endif
            
            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $poems->links() }}
            </div>
        @else
            <!-- Empty State - Poetic -->
            <div class="text-center py-20 animate-fade-in">
                <div class="inline-flex items-center justify-center w-32 h-32 rounded-full 
                           bg-gradient-to-br from-primary-100 to-primary-50 
                           dark:from-primary-900/20 dark:to-primary-900/10
                           mb-8 relative">
                    <!-- Animated circles -->
                    <div class="absolute inset-0 rounded-full border-2 border-primary-300 dark:border-primary-700 animate-ping opacity-20"></div>
                    <svg class="w-16 h-16 text-primary-500 dark:text-primary-400" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                
                <h3 class="text-3xl font-bold text-neutral-900 dark:text-white mb-4 font-poem">
                    {{ __('poems.index.no_poems_title') }}
                </h3>
                
                <p class="text-lg text-neutral-600 dark:text-neutral-400 mb-8 max-w-md mx-auto font-poem italic">
                    "{{ __('poems.index.no_poems_subtitle') }}"
                </p>
                
                @if($search || $category || $language || $type)
                    <button wire:click="resetFilters"
                            class="inline-flex items-center gap-3 px-8 py-4 rounded-2xl
                                   bg-gradient-to-r from-primary-500 to-primary-600 
                                   hover:from-primary-600 hover:to-primary-700
                                   text-white font-semibold shadow-lg
                                   hover:-translate-y-1 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <span class="font-poem">{{ __('poems.index.explore_all') }}</span>
                    </button>
                @endif
            </div>
        @endif
    </div>
</div>
