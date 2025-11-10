<div class="min-h-screen bg-gradient-to-br from-neutral-50 via-white to-primary-50/30 dark:from-neutral-900 dark:via-neutral-800 dark:to-neutral-900 overflow-hidden">
    
    <!-- Hero Section with Magical Background -->
    <div class="relative bg-gradient-to-r from-primary-600 via-primary-500 to-accent-500 py-24 overflow-hidden" 
         x-data="{ scrollY: 0 }"
         @scroll.window="scrollY = window.scrollY">
        
        <!-- Animated Background Shapes -->
        <div class="absolute inset-0 overflow-hidden">
            <!-- Floating circles with parallax -->
            <div class="absolute top-10 left-10 w-72 h-72 bg-white/10 rounded-full blur-3xl animate-pulse" 
                 :style="`transform: translateY(${scrollY * 0.3}px)`"></div>
            <div class="absolute top-40 right-20 w-96 h-96 bg-accent-400/20 rounded-full blur-3xl animate-pulse" 
                 style="animation-delay: 1s"
                 :style="`transform: translateY(${scrollY * 0.5}px)`"></div>
            <div class="absolute bottom-20 left-1/3 w-80 h-80 bg-primary-400/20 rounded-full blur-3xl animate-pulse" 
                 style="animation-delay: 2s"
                 :style="`transform: translateY(${scrollY * 0.2}px)`"></div>
            
            <!-- Floating particles -->
            @for($i = 0; $i < 25; $i++)
            <div class="absolute w-2 h-2 bg-white/30 rounded-full"
                 style="left: {{ rand(0, 100) }}%; 
                        top: {{ rand(0, 100) }}%; 
                        animation: float-particle {{ 3 + ($i % 4) }}s ease-in-out infinite {{ $i * 0.15 }}s;"></div>
            @endfor
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Title -->
            <div class="text-center text-white mb-10"
                 x-data="{ visible: false }"
                 x-init="setTimeout(() => visible = true, 100)"
                 x-show="visible"
                 x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0 -translate-y-10"
                 x-transition:enter-end="opacity-100 translate-y-0">
                
                <h1 class="text-5xl md:text-6xl font-bold mb-4 drop-shadow-2xl">
                    {{ __('gigs.title') }}
                </h1>
                <p class="text-xl md:text-2xl text-white/90 italic font-light">
                    {{ __('gigs.browse_all') }}
                </p>
            </div>

            <!-- Search Bar -->
            <div class="max-w-4xl mx-auto mb-8"
                 x-data="{ visible: false }"
                 x-init="setTimeout(() => visible = true, 200)"
                 x-show="visible"
                 x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100">
                <div class="relative">
                    <svg class="absolute left-5 top-1/2 -translate-y-1/2 w-6 h-6 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input 
                        type="text" 
                        wire:model.live.debounce.500ms="search"
                        placeholder="{{ __('gigs.filters.search') }}"
                        class="w-full pl-14 pr-6 py-5 rounded-full bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white text-lg border-0 shadow-2xl focus:ring-4 focus:ring-accent-400/50 transition-all placeholder:text-neutral-400">
                </div>
            </div>

            <!-- Quick Filters Pills -->
            <div class="flex flex-wrap justify-center gap-3"
                 x-data="{ visible: false }"
                 x-init="setTimeout(() => visible = true, 300)"
                 x-show="visible"
                 x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0">
                
                <button wire:click="$set('show_featured', {{ !$show_featured ? 'true' : 'false' }})"
                        class="px-5 py-2.5 rounded-full backdrop-blur-sm text-white text-sm font-semibold transition-all hover:scale-110 hover:shadow-xl active:scale-95
                               {{ $show_featured ? 'bg-white/30 shadow-lg shadow-white/20' : 'bg-white/10 hover:bg-white/20' }}">
                    <svg class="inline w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    {{ __('gigs.filters.featured_only') }}
                </button>

                <button wire:click="$set('show_urgent', {{ !$show_urgent ? 'true' : 'false' }})"
                        class="px-5 py-2.5 rounded-full backdrop-blur-sm text-white text-sm font-semibold transition-all hover:scale-110 hover:shadow-xl active:scale-95
                               {{ $show_urgent ? 'bg-white/30 shadow-lg shadow-white/20' : 'bg-white/10 hover:bg-white/20' }}">
                    <svg class="inline w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/>
                    </svg>
                    {{ __('gigs.filters.urgent_only') }}
                </button>

                <button wire:click="$set('show_remote', {{ !$show_remote ? 'true' : 'false' }})"
                        class="px-5 py-2.5 rounded-full backdrop-blur-sm text-white text-sm font-semibold transition-all hover:scale-110 hover:shadow-xl active:scale-95
                               {{ $show_remote ? 'bg-white/30 shadow-lg shadow-white/20' : 'bg-white/10 hover:bg-white/20' }}">
                    <svg class="inline w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ __('gigs.filters.remote_only') }}
                </button>

                <button wire:click="clearFilters"
                        class="px-5 py-2.5 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white text-sm font-semibold transition-all hover:scale-110 hover:shadow-xl hover:shadow-white/20 active:scale-95">
                    <svg class="inline w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    {{ __('common.clear_all') }}
                </button>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-20">
        
        <!-- Stats Row - Elegant Floating Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12">
            @php
                $statsData = [
                    ['value' => $stats['total_gigs'], 'label' => __('gigs.stats.total_gigs'), 'gradient' => 'from-violet-500 to-purple-600', 'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                    ['value' => $stats['open_gigs_count'], 'label' => __('gigs.stats.open_gigs_count'), 'gradient' => 'from-emerald-500 to-teal-600', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ['value' => $stats['urgent_gigs_count'], 'label' => __('gigs.stats.urgent_gigs_count'), 'gradient' => 'from-orange-500 to-red-600', 'icon' => 'M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z'],
                    ['value' => $stats['featured_gigs_count'], 'label' => __('gigs.stats.featured_gigs_count'), 'gradient' => 'from-blue-500 to-indigo-600', 'icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'],
                ];
            @endphp

            @foreach($statsData as $index => $stat)
                <div class="group"
                     x-data="{ visible: false }"
                     x-init="setTimeout(() => visible = true, {{ 400 + ($index * 100) }})"
                     x-show="visible"
                     x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100">
                    
                    <div class="relative bg-white dark:bg-neutral-800 rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-500 border border-neutral-100 dark:border-neutral-700 overflow-hidden group-hover:-translate-y-2">
                        <!-- Gradient overlay on hover -->
                        <div class="absolute inset-0 bg-gradient-to-br {{ $stat['gradient'] }} opacity-0 group-hover:opacity-5 transition-opacity duration-500"></div>
                        
                        <div class="relative">
                            <!-- Icon -->
                            <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-br {{ $stat['gradient'] }} mb-4 shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/>
                                </svg>
                            </div>
                            
                            <!-- Value -->
                            <div class="text-3xl md:text-4xl font-bold text-neutral-900 dark:text-white mb-2 group-hover:scale-105 transition-transform duration-300">
                                {{ number_format($stat['value']) }}
                            </div>
                            
                            <!-- Label -->
                            <div class="text-sm text-neutral-600 dark:text-neutral-400 font-medium">
                                {{ $stat['label'] }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Advanced Filters - Collapsible -->
        <div class="bg-white/95 dark:bg-neutral-800/95 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/50 dark:border-neutral-700/50 p-8 mb-12"
             x-data="{ visible: false, showAdvanced: false }"
             x-init="setTimeout(() => visible = true, 800)"
             x-show="visible"
             x-transition:enter="transition ease-out duration-700"
             x-transition:enter-start="opacity-0 translate-y-8"
             x-transition:enter-end="opacity-100 translate-y-0">
            
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-neutral-900 dark:text-white flex items-center gap-3">
                    <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                    </svg>
                    {{ __('gigs.filters.title') }}
                </h3>
                
                <button @click="showAdvanced = !showAdvanced"
                        class="text-sm font-semibold text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 transition-colors flex items-center gap-2">
                    <span x-text="showAdvanced ? '{{ __('common.hide') }}' : '{{ __('common.show_more') }}'"></span>
                    <svg class="w-4 h-4 transition-transform duration-300" 
                         :class="showAdvanced ? 'rotate-180' : ''"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
            </div>

            <!-- Advanced Filters Grid -->
            <div x-show="showAdvanced"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 -translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Category -->
                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                        {{ __('gigs.fields.category') }}
                    </label>
                    <select wire:model.live="category" 
                            class="w-full px-4 py-3 rounded-xl border-2 border-neutral-200 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 transition-all">
                        <option value="">{{ __('gigs.filters.select_category') }}</option>
                        <option value="performance">{{ __('gigs.categories.performance') }}</option>
                        <option value="hosting">{{ __('gigs.categories.hosting') }}</option>
                        <option value="judging">{{ __('gigs.categories.judging') }}</option>
                        <option value="technical">{{ __('gigs.categories.technical') }}</option>
                        <option value="translation">{{ __('gigs.categories.translation') }}</option>
                        <option value="other">{{ __('gigs.categories.other') }}</option>
                    </select>
                </div>

                <!-- Type -->
                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                        {{ __('gigs.fields.type') }}
                    </label>
                    <select wire:model.live="type" 
                            class="w-full px-4 py-3 rounded-xl border-2 border-neutral-200 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 transition-all">
                        <option value="">{{ __('gigs.filters.select_type') }}</option>
                        <option value="paid">{{ __('gigs.types.paid') }}</option>
                        <option value="volunteer">{{ __('gigs.types.volunteer') }}</option>
                        <option value="collaboration">{{ __('gigs.types.collaboration') }}</option>
                    </select>
                </div>

                <!-- Language -->
                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                        {{ __('gigs.fields.language') }}
                    </label>
                    <select wire:model.live="language" 
                            class="w-full px-4 py-3 rounded-xl border-2 border-neutral-200 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 transition-all">
                        <option value="">{{ __('gigs.filters.select_language') }}</option>
                        <option value="it">{{ __('gigs.languages.it') }}</option>
                        <option value="en">{{ __('gigs.languages.en') }}</option>
                        <option value="es">{{ __('gigs.languages.es') }}</option>
                        <option value="fr">{{ __('gigs.languages.fr') }}</option>
                        <option value="de">{{ __('gigs.languages.de') }}</option>
                        <option value="pt">{{ __('gigs.languages.pt') }}</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Gigs Grid - Elegant Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($gigs as $index => $gig)
                <article class="group relative"
                         x-data="{ visible: false }"
                         x-init="setTimeout(() => visible = true, {{ 1000 + ($index * 80) }})"
                         x-show="visible"
                         x-transition:enter="transition ease-out duration-700"
                         x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100">
                    
                    <a href="{{ route('gigs.show', $gig) }}" 
                       class="block h-full bg-white dark:bg-neutral-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 border border-neutral-100 dark:border-neutral-700 overflow-hidden group-hover:-translate-y-3 group-hover:border-primary-300 dark:group-hover:border-primary-700">
                        
                        <!-- Gradient Top Border on Hover -->
                        <div class="h-1 bg-gradient-to-r from-primary-500 via-accent-500 to-primary-500 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        <div class="p-6">
                            <!-- Status Badges -->
                            @if($gig->is_featured || $gig->is_urgent || $gig->is_remote || $gig->is_closed)
                                <div class="flex flex-wrap gap-2 mb-4">
                                    @if($gig->is_featured)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-bold bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                            </svg>
                                            {{ __('gigs.status.featured') }}
                                        </span>
                                    @endif
                                    
                                    @if($gig->is_urgent)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-bold bg-gradient-to-r from-orange-500 to-red-600 text-white shadow-lg animate-pulse">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                            </svg>
                                            {{ __('gigs.status.urgent') }}
                                        </span>
                                    @endif

                                    @if($gig->is_remote)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-bold bg-gradient-to-r from-emerald-500 to-teal-600 text-white shadow-lg">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ __('gigs.remote') }}
                                        </span>
                                    @endif

                                    @if($gig->is_closed)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-bold bg-neutral-400 dark:bg-neutral-600 text-white">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                            </svg>
                                            {{ __('gigs.status.closed') }}
                                        </span>
                                    @endif
                                </div>
                            @endif

                            <!-- Title -->
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3 line-clamp-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors leading-tight">
                                {{ $gig->title }}
                            </h3>

                            <!-- Category & Type -->
                            <div class="flex items-center gap-2 mb-4">
                                <span class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-neutral-100 dark:bg-neutral-700/50 text-neutral-700 dark:text-neutral-300 border border-neutral-200/50 dark:border-neutral-600/50">
                                    {{ __('gigs.categories.' . $gig->category) }}
                                </span>
                                <span class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-400 border border-primary-100 dark:border-primary-800/50">
                                    {{ __('gigs.types.' . $gig->type) }}
                                </span>
                            </div>

                            <!-- Description -->
                            <p class="text-sm text-neutral-600 dark:text-neutral-400 line-clamp-3 mb-6 leading-relaxed">
                                {{ Str::limit(strip_tags($gig->description), 150) }}
                            </p>

                            <!-- Meta Information -->
                            <div class="space-y-2.5 mb-6">
                                @if($gig->location)
                                    <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-neutral-400">
                                        <svg class="w-4 h-4 text-primary-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        </svg>
                                        <span class="truncate">{{ $gig->location }}</span>
                                    </div>
                                @endif

                                @if($gig->deadline)
                                    <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-neutral-400">
                                        <svg class="w-4 h-4 text-primary-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>{{ $gig->deadline->format('d M Y') }}</span>
                                        @if($gig->days_until_deadline !== null && $gig->days_until_deadline >= 0)
                                            <span class="ml-auto px-2.5 py-0.5 rounded-full text-xs font-bold
                                                {{ $gig->days_until_deadline <= 3 
                                                    ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400' 
                                                    : 'bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300' }}">
                                                {{ $gig->days_until_deadline }}d
                                            </span>
                                        @endif
                                    </div>
                                @endif

                                @if($gig->compensation)
                                    <div class="flex items-center gap-2 text-sm font-semibold text-primary-600 dark:text-primary-400">
                                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="truncate">{{ $gig->compensation }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Footer with Applications -->
                            <div class="flex items-center justify-between pt-4 border-t border-neutral-200 dark:border-neutral-700">
                                <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-neutral-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <span class="font-bold">{{ $gig->application_count }}</span>
                                    <span>{{ __('gigs.applications.applications') }}</span>
                                </div>

                                <div class="flex items-center gap-2 text-primary-600 dark:text-primary-400 font-semibold text-sm group-hover:gap-3 transition-all">
                                    <span>{{ __('gigs.view') }}</span>
                                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                </article>
            @empty
                <div class="col-span-full">
                    <div class="bg-white/95 dark:bg-neutral-800/95 backdrop-blur-xl rounded-3xl border border-white/50 dark:border-neutral-700/50 p-16 text-center shadow-2xl">
                        <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gradient-to-br from-primary-100 to-primary-200 dark:from-primary-900/30 dark:to-primary-800/30 flex items-center justify-center">
                            <svg class="w-12 h-12 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-neutral-900 dark:text-white mb-3">
                            {{ __('gigs.no_gigs_found') }}
                        </h3>
                        <p class="text-neutral-600 dark:text-neutral-400 mb-8 text-lg">
                            {{ __('gigs.no_gigs_description') }}
                        </p>
                        <button wire:click="clearFilters" 
                                class="inline-flex items-center gap-2 px-8 py-4 rounded-xl bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white font-bold shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            {{ __('common.clear_all') }}
                        </button>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $gigs->links() }}
        </div>

    </div>
    
    <!-- Animations -->
    <style>
        @keyframes float-particle {
            0%, 100% { transform: translateY(0) translateX(0); }
            25% { transform: translateY(-20px) translateX(10px); }
            50% { transform: translateY(-40px) translateX(-10px); }
            75% { transform: translateY(-20px) translateX(10px); }
        }
        
        @keyframes gradient {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
    </style>
    
</div>
