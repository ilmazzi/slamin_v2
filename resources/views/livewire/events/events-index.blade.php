<div class="min-h-screen bg-gradient-to-br from-neutral-50 via-white to-primary-50/30 dark:from-neutral-900 dark:via-neutral-800 dark:to-neutral-900 overflow-hidden">
    
    <!-- Hero Search Section with Parallax -->
    <div class="relative bg-gradient-to-r from-primary-600 via-primary-500 to-accent-500 py-20 overflow-hidden" 
         x-data="{ showFilters: false, scrollY: 0 }"
         @scroll.window="scrollY = window.scrollY">
        
        <!-- Animated Background Shapes -->
        <div class="absolute inset-0 overflow-hidden">
            <!-- Floating circles with parallax -->
            <div class="absolute top-10 left-10 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-pulse" 
                 :style="`transform: translateY(${scrollY * 0.3}px)`"></div>
            <div class="absolute top-40 right-20 w-96 h-96 bg-accent-400/20 rounded-full blur-3xl animate-pulse" 
                 style="animation-delay: 1s"
                 :style="`transform: translateY(${scrollY * 0.5}px)`"></div>
            <div class="absolute bottom-20 left-1/3 w-80 h-80 bg-primary-400/20 rounded-full blur-3xl animate-pulse" 
                 style="animation-delay: 2s"
                 :style="`transform: translateY(${scrollY * 0.2}px)`"></div>
            
            <!-- Floating particles -->
            @for($i = 0; $i < 20; $i++)
            <div class="absolute w-2 h-2 bg-white/30 rounded-full animate-float"
                 style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ $i * 0.2 }}s; animation-duration: {{ 3 + ($i % 3) }}s;"></div>
            @endfor
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Title & Intro -->
            <div class="text-center text-white mb-8"
                 x-data="{ visible: false }"
                 x-init="setTimeout(() => visible = true, 100)"
                 x-show="visible"
                 x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0 -translate-y-10"
                 x-transition:enter-end="opacity-100 translate-y-0">
                <h1 class="text-4xl md:text-5xl font-bold mb-4 bg-clip-text text-transparent bg-gradient-to-r from-white via-white to-accent-200 animate-gradient">
                    {{ __('events.discover_events') }}
                </h1>
                <p class="text-xl text-white/90 italic">
                    {{ __('events.where_poetry_lives') }}
                </p>
            </div>

            <!-- Search Bar -->
            <div class="max-w-4xl mx-auto"
                 x-data="{ visible: false }"
                 x-init="setTimeout(() => visible = true, 200)"
                 x-show="visible"
                 x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100">
                <div class="relative">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input 
                        type="text" 
                        wire:model.live.debounce.500ms="search"
                        placeholder="{{ __('events.search_placeholder') }}"
                        class="w-full pl-12 pr-4 py-4 rounded-full bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white border-0 shadow-xl focus:ring-2 focus:ring-accent-400 transition-all">
                </div>
            </div>

            <!-- Quick Filters -->
            <div class="mt-6 flex flex-wrap justify-center gap-2"
                 x-data="{ visible: false }"
                 x-init="setTimeout(() => visible = true, 300)"
                 x-show="visible"
                 x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0">
                <button 
                    wire:click="applyQuickFilter('today')"
                    class="px-4 py-2 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white text-sm font-medium transition-all hover:scale-110 hover:shadow-lg hover:shadow-white/20 active:scale-95">
                    <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ __('events.today') }}
                </button>
                <button 
                    wire:click="applyQuickFilter('tomorrow')"
                    class="px-4 py-2 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white text-sm font-medium transition-all hover:scale-110 hover:shadow-lg hover:shadow-white/20 active:scale-95">
                    <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ __('events.tomorrow') }}
                </button>
                <button 
                    wire:click="applyQuickFilter('weekend')"
                    class="px-4 py-2 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white text-sm font-medium transition-all hover:scale-110 hover:shadow-lg hover:shadow-white/20 active:scale-95">
                    <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                    {{ __('events.weekend') }}
                </button>
                <button 
                    wire:click="applyQuickFilter('free')"
                    class="px-4 py-2 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white text-sm font-medium transition-all hover:scale-110 hover:shadow-lg hover:shadow-white/20 active:scale-95">
                    <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                    </svg>
                    {{ __('events.free') }}
                </button>
                @auth
                <button 
                    wire:click="applyQuickFilter('my')"
                    class="px-4 py-2 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white text-sm font-medium transition-all hover:scale-110 hover:shadow-lg hover:shadow-white/20 active:scale-95">
                    <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    {{ __('events.my_events') }}
                </button>
                @endauth
                <button 
                    wire:click="resetFilters"
                    class="px-4 py-2 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white text-sm font-medium transition-all hover:scale-110 hover:shadow-lg hover:shadow-white/20 active:scale-95">
                    <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    {{ __('events.reset') }}
                </button>
            </div>

            <!-- Advanced Filters Toggle -->
            <div class="mt-4 text-center">
                <button 
                    @click="showFilters = !showFilters"
                    class="text-white text-sm font-medium hover:text-white/80 transition">
                    <svg class="inline w-5 h-5 mr-1 transition-transform" :class="{ 'rotate-180': showFilters }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                    {{ __('events.advanced_filters') }}
                </button>
            </div>

            <!-- Advanced Filters Panel -->
            <div 
                x-show="showFilters"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-4"
                class="mt-6 bg-white/10 backdrop-blur-md rounded-2xl p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- City Filter -->
                    <div>
                        <label class="block text-white text-sm font-medium mb-2">{{ __('events.city') }}</label>
                        <select wire:model.live="city" class="w-full px-4 py-2 rounded-lg bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white border-0 focus:ring-2 focus:ring-accent-400">
                            <option value="">{{ __('events.all_cities') }}</option>
                            @foreach($cities as $cityOption)
                                <option value="{{ $cityOption }}">{{ $cityOption }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Type Filter -->
                    <div>
                        <label class="block text-white text-sm font-medium mb-2">{{ __('events.type') }}</label>
                        <select wire:model.live="type" class="w-full px-4 py-2 rounded-lg bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white border-0 focus:ring-2 focus:ring-accent-400">
                            <option value="">{{ __('events.all_types') }}</option>
                            <option value="public">{{ __('events.public') }}</option>
                            <option value="private">{{ __('events.private') }}</option>
                        </select>
                    </div>

                    <!-- Free Only -->
                    <div>
                        <label class="block text-white text-sm font-medium mb-2">{{ __('events.price') }}</label>
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" wire:model.live="freeOnly" class="mr-2 rounded text-accent-500 focus:ring-accent-400">
                            <span class="text-white">{{ __('events.free_only') }}</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Create Event Button -->
            @auth
                @can('create', App\Models\Event::class)
                    <div class="mt-6 text-center">
                        <a href="{{ route('events.create') }}" 
                           class="inline-flex items-center px-6 py-3 bg-white text-primary-600 rounded-full font-semibold hover:bg-white/90 transition-all hover:scale-105 shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            {{ __('events.create_event') }}
                        </a>
                    </div>
                @endcan
            @endauth
        </div>
    </div>

    <!-- Statistics Section - Modern Floating Style -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 relative z-20 mb-16"
         x-data="{ scrollY: 0 }"
         @scroll.window="scrollY = window.scrollY">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            @foreach([
                ['label' => 'total_events', 'value' => $statistics['total_events'], 'gradient' => 'from-primary-400 to-primary-600', 'delay' => 0],
                ['label' => 'public_events', 'value' => $statistics['public_events'], 'gradient' => 'from-accent-400 to-accent-600', 'delay' => 100],
                ['label' => 'upcoming_events', 'value' => $statistics['upcoming_events'], 'gradient' => 'from-primary-500 to-accent-500', 'delay' => 200],
                ['label' => 'venues_count', 'value' => $statistics['venues_count'], 'gradient' => 'from-accent-500 to-primary-600', 'delay' => 300]
            ] as $stat)
            <div 
                class="group relative"
                x-data="{ count: 0, target: {{ $stat['value'] }}, visible: false }"
                x-init="setTimeout(() => { visible = true; let duration = 2000; let increment = target / (duration / 16); let timer = setInterval(() => { count += increment; if (count >= target) { count = target; clearInterval(timer); } }, 16); }, {{ $stat['delay'] }})"
                x-show="visible"
                x-transition:enter="transition ease-out duration-1000"
                x-transition:enter-start="opacity-0 scale-50 -translate-y-10"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                :style="`transform: translateY(${scrollY * 0.03}px)`">
                
                <!-- Floating Number Container -->
                <div class="relative p-8 rounded-2xl bg-white/80 dark:bg-neutral-800/80 backdrop-blur-xl shadow-2xl hover:shadow-3xl transition-all duration-500 hover:-translate-y-3 hover:scale-105 cursor-pointer border border-primary-200/50 dark:border-primary-800/50">
                    <!-- Gradient Glow Effect -->
                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-br {{ $stat['gradient'] }} opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
                    
                    <!-- Number -->
                    <div class="relative text-center">
                        <div class="text-5xl md:text-6xl font-black bg-gradient-to-br {{ $stat['gradient'] }} bg-clip-text text-transparent mb-2"
                             x-text="Math.floor(count).toLocaleString()">
                            0
                        </div>
                        
                        <!-- Label -->
                        <div class="text-xs md:text-sm font-medium text-neutral-600 dark:text-neutral-400 uppercase tracking-wider">
                            {{ __('events.' . $stat['label']) }}
                        </div>
                    </div>
                    
                    <!-- Decorative Corner Element -->
                    <div class="absolute top-3 right-3 w-3 h-3 rounded-full bg-gradient-to-br {{ $stat['gradient'] }} opacity-50 group-hover:opacity-100 transition-opacity"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Dynamic Bento Box Layout -->
    <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        @if($events->count() > 0)
            @php
                // Pattern di dimensioni per creare varietà visiva
                $sizes = [
                    'xl' => 'col-span-2 row-span-2 min-h-[500px]',  // Extra large
                    'lg' => 'col-span-2 row-span-1 min-h-[280px]',  // Large horizontal
                    'md' => 'col-span-1 row-span-2 min-h-[450px]',  // Medium vertical
                    'sm' => 'col-span-1 row-span-1 min-h-[280px]',  // Small square
                ];
                
                // Pattern: XL, SM, SM, LG, MD, SM, SM, LG, XL... (si ripete)
                $pattern = ['xl', 'sm', 'sm', 'lg', 'md', 'sm', 'sm', 'lg'];
            @endphp
            
            <!-- Grid Fluido Bento Style -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 auto-rows-auto">
                @foreach($events as $index => $event)
                    @php
                        $sizeKey = $pattern[$index % count($pattern)];
                        $sizeClass = $sizes[$sizeKey];
                        $isLarge = in_array($sizeKey, ['xl', 'lg', 'md']);
                    @endphp
                    
                    <article 
                        x-data="{ 
                            visible: false,
                            isHovered: false
                        }"
                        x-init="setTimeout(() => visible = true, {{ 50 + ($index * 60) }})"
                        x-show="visible"
                        @mouseenter="isHovered = true"
                        @mouseleave="isHovered = false"
                        x-transition:enter="transition ease-out duration-800"
                        x-transition:enter-start="opacity-0 scale-90 {{ $isLarge ? 'rotate-2' : '-rotate-1' }}"
                        x-transition:enter-end="opacity-100 scale-100 rotate-0"
                        class="{{ $sizeClass }} group relative overflow-hidden rounded-3xl cursor-pointer"
                        :class="isHovered ? 'z-20' : 'z-10'">
                        
                        <!-- Event Image Background -->
                        <div class="absolute inset-0">
                            @if($event->image_url)
                            <img src="{{ $event->image_url }}" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" 
                                 alt="{{ $event->title }}">
                            @else
                            <div class="w-full h-full bg-gradient-to-br from-primary-400 via-primary-500 to-accent-600"></div>
                            @endif
                            
                            <!-- Gradient Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent opacity-80 group-hover:opacity-90 transition-opacity duration-500"></div>
                        </div>
                        
                        <!-- Floating Category Badge -->
                        <div class="absolute top-4 right-4 z-10">
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-md text-white text-xs font-bold uppercase rounded-full border border-white/30">
                                {{ str_replace('_', ' ', $event->category ?? 'Event') }}
                            </span>
                        </div>
                        
                        <!-- Content -->
                        <div class="relative h-full flex flex-col justify-end p-6 {{ $isLarge ? 'p-8' : 'p-6' }}">
                            <!-- Date Badge -->
                            <div class="mb-3">
                                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-primary-500/90 backdrop-blur-sm rounded-full">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-white text-sm font-semibold">
                                        {{ $event->start_datetime->format('d M') }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Title -->
                            <h3 class="text-white font-bold mb-2 {{ $isLarge ? 'text-3xl' : 'text-xl' }} line-clamp-2 group-hover:text-primary-300 transition-colors">
                                {{ $event->title }}
                            </h3>
                            
                            <!-- Location -->
                            <div class="flex items-center gap-2 text-white/80 text-sm mb-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span>{{ $event->city }}</span>
                            </div>
                            
                            @if($isLarge)
                            <!-- Description (only for large cards) -->
                            <p class="text-white/70 text-sm mb-4 line-clamp-2">
                                {{ Str::limit($event->description, 100) }}
                            </p>
                            @endif
                            
                            <!-- Social Actions -->
                            <div class="flex items-center gap-3" @click.stop>
                                <x-like-button 
                                    :itemId="$event->id"
                                    itemType="event"
                                    :isLiked="$event->is_liked ?? false"
                                    :likesCount="$event->like_count ?? 0"
                                    size="sm"
                                    class="text-white" />
                                
                                <x-comment-button 
                                    :itemId="$event->id"
                                    itemType="event"
                                    :commentsCount="$event->comment_count ?? 0"
                                    size="sm"
                                    class="text-white" />
                            </div>
                            
                            <!-- Hover Reveal: View Button -->
                            <div class="mt-4 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                                <a href="{{ route('events.show', $event) }}" 
                                   class="inline-flex items-center gap-2 px-4 py-2 bg-white text-primary-600 rounded-full font-semibold hover:bg-primary-50 transition-colors text-sm">
                                    {{ __('events.view_details') }}
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Animated Border on Hover -->
                        <div class="absolute inset-0 border-4 border-primary-400 opacity-0 group-hover:opacity-100 rounded-3xl transition-opacity duration-300 pointer-events-none"></div>
                        
                        <!-- Click Overlay -->
                        <a href="{{ route('events.show', $event) }}" class="absolute inset-0 z-5"></a>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
    
    @if($events->count() === 0)
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <!-- Empty State -->
        <div class="text-center py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-neutral-100 dark:bg-neutral-800 mb-4">
                    <svg class="w-10 h-10 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-2">
                    {{ __('events.no_events_found') }}
                </h3>
                <p class="text-neutral-600 dark:text-neutral-400 mb-6">
                    {{ __('events.try_adjusting_filters') }}
                </p>
                <button 
                    wire:click="resetFilters"
                    class="inline-flex items-center px-6 py-3 bg-primary-600 text-white rounded-full font-semibold hover:bg-primary-700 transition-all hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    {{ __('events.reset_filters') }}
                </button>
        </div>
    </div>
    @endif

    <!-- Loading Overlay -->
    <div wire:loading wire:target="search,city,type,freeOnly,quickFilter,applyQuickFilter,resetFilters" 
         class="fixed inset-0 bg-black/20 backdrop-blur-sm z-50 flex items-center justify-center">
        <div class="bg-white dark:bg-neutral-800 rounded-xl p-6 shadow-2xl">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary-600 mx-auto"></div>
            <p class="mt-4 text-neutral-900 dark:text-white font-medium">{{ __('events.loading') }}...</p>
        </div>
    </div>
</div>
