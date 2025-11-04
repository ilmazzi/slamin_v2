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
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10"
             x-data="{ visible: false }"
             x-intersect.once="visible = true">
            <!-- Title & Intro -->
            <div class="text-center text-white mb-8"
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
                 x-show="visible"
                 x-transition:enter="transition ease-out duration-1000 delay-200"
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
                 x-show="visible"
                 x-transition:enter="transition ease-out duration-1000 delay-300"
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

    <!-- Statistics Section with Parallax -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 relative z-20 mb-12"
         x-data="{ scrollY: 0 }"
         @scroll.window="scrollY = window.scrollY">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach([
                ['icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'label' => 'total_events', 'value' => $statistics['total_events'], 'color' => 'primary', 'delay' => 0],
                ['icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'public_events', 'value' => $statistics['public_events'], 'color' => 'accent', 'delay' => 100],
                ['icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'upcoming_events', 'value' => $statistics['upcoming_events'], 'color' => 'primary', 'delay' => 200],
                ['icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'label' => 'venues_count', 'value' => $statistics['venues_count'], 'color' => 'accent', 'delay' => 300]
            ] as $stat)
            <div 
                class="bg-white dark:bg-neutral-800 rounded-xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 hover:rotate-1 cursor-pointer group"
                x-data="{ count: 0, target: {{ $stat['value'] }}, visible: false }"
                x-intersect.once="visible = true; let duration = 1500; let increment = target / (duration / 16); let timer = setInterval(() => { count += increment; if (count >= target) { count = target; clearInterval(timer); } }, 16);"
                x-show="visible"
                x-transition:enter="transition ease-out duration-700 delay-{{ $stat['delay'] }}"
                x-transition:enter-start="opacity-0 -translate-y-8 scale-90"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                :style="`transform: translateY(${scrollY * 0.05}px)`">
                <div class="flex items-center justify-center mb-3">
                    <div class="w-12 h-12 rounded-full bg-{{ $stat['color'] }}-100 dark:bg-{{ $stat['color'] }}-900/30 flex items-center justify-center">
                        <svg class="w-6 h-6 text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/>
                        </svg>
                    </div>
                </div>
                <h3 class="text-3xl font-bold text-center text-neutral-900 dark:text-white mb-1" x-text="Math.floor(count).toLocaleString()">0</h3>
                <p class="text-xs text-center text-neutral-600 dark:text-neutral-400">{{ __('events.' . $stat['label']) }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Events Grid with Staggered Animations -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        @if($events->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($events as $index => $event)
                    <div x-data="{ visible: false }"
                         x-intersect.once="visible = true"
                         x-show="visible"
                         x-transition:enter="transition ease-out duration-700 delay-{{ ($index % 6) * 100 }}"
                         x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         class="transform hover:scale-105 transition-transform duration-300">
                        <x-ui.cards.event :event="$event" />
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
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
        @endif
    </div>

    <!-- Loading Overlay -->
    <div wire:loading wire:target="search,city,type,freeOnly,quickFilter,applyQuickFilter,resetFilters" 
         class="fixed inset-0 bg-black/20 backdrop-blur-sm z-50 flex items-center justify-center">
        <div class="bg-white dark:bg-neutral-800 rounded-xl p-6 shadow-2xl">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary-600 mx-auto"></div>
            <p class="mt-4 text-neutral-900 dark:text-white font-medium">{{ __('events.loading') }}...</p>
        </div>
    </div>
</div>
