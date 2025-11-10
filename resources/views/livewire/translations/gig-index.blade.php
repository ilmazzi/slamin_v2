<div class="min-h-screen bg-gradient-to-br from-neutral-50 via-white to-primary-50/30 dark:from-neutral-900 dark:via-neutral-800 dark:to-neutral-900 overflow-hidden">
    
    <!-- Hero Section with Magical Background -->
    <div class="relative bg-gradient-to-r from-primary-600 via-primary-500 to-accent-500 py-32 overflow-hidden" 
         x-data="{ scrollY: 0 }"
         @scroll.window="scrollY = window.scrollY">
        
        <!-- Animated Background Shapes -->
        <div class="absolute inset-0 overflow-hidden">
            <!-- Floating blur circles with parallax -->
            <div class="absolute top-10 left-10 w-72 h-72 bg-white/10 rounded-full blur-3xl animate-pulse" 
                 :style="`transform: translateY(${scrollY * 0.3}px)`"></div>
            <div class="absolute top-40 right-20 w-96 h-96 bg-accent-400/20 rounded-full blur-3xl animate-pulse" 
                 style="animation-delay: 1s"
                 :style="`transform: translateY(${scrollY * 0.5}px)`"></div>
            <div class="absolute bottom-20 left-1/3 w-80 h-80 bg-primary-400/20 rounded-full blur-3xl animate-pulse" 
                 style="animation-delay: 2s"
                 :style="`transform: translateY(${scrollY * 0.2}px)`"></div>
            
            <!-- Floating particles -->
            @for($i = 0; $i < 30; $i++)
            <div class="absolute w-1.5 h-1.5 bg-white/40 rounded-full"
                 style="left: {{ rand(0, 100) }}%; 
                        top: {{ rand(0, 100) }}%; 
                        animation: float-particle {{ 3 + ($i % 5) }}s ease-in-out infinite {{ $i * 0.12 }}s;"></div>
            @endfor
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Title -->
            <div class="text-center text-white mb-12"
                 x-data="{ visible: false }"
                 x-init="setTimeout(() => visible = true, 100)"
                 x-show="visible"
                 x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0 -translate-y-10"
                 x-transition:enter-end="opacity-100 translate-y-0">
                
                <h1 class="text-5xl md:text-7xl font-bold mb-6 drop-shadow-2xl leading-tight">
                    {{ __('gigs.title') }}
                </h1>
                <p class="text-xl md:text-2xl text-white/90 italic font-light max-w-3xl mx-auto leading-relaxed">
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
                    <svg class="absolute left-6 top-1/2 -translate-y-1/2 w-6 h-6 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input 
                        type="text" 
                        wire:model.live.debounce.500ms="search"
                        placeholder="{{ __('gigs.filters.search') }}"
                        class="w-full pl-16 pr-6 py-5 rounded-full bg-white/95 dark:bg-neutral-800/95 backdrop-blur-xl text-neutral-900 dark:text-white text-lg border-0 shadow-2xl focus:ring-4 focus:ring-accent-400/50 transition-all placeholder:text-neutral-400">
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
                
                <button wire:click="$toggle('show_featured')"
                        class="px-6 py-3 rounded-full backdrop-blur-md text-white text-sm font-bold transition-all hover:scale-110 hover:shadow-xl hover:shadow-white/30 active:scale-95
                               {{ $show_featured ? 'bg-white/30 shadow-lg shadow-white/20 ring-2 ring-white/50' : 'bg-white/10 hover:bg-white/20' }}">
                    <svg class="inline w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    {{ __('gigs.filters.featured_only') }}
                </button>

                <button wire:click="$toggle('show_urgent')"
                        class="px-6 py-3 rounded-full backdrop-blur-md text-white text-sm font-bold transition-all hover:scale-110 hover:shadow-xl hover:shadow-white/30 active:scale-95
                               {{ $show_urgent ? 'bg-white/30 shadow-lg shadow-white/20 ring-2 ring-white/50' : 'bg-white/10 hover:bg-white/20' }}">
                    <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    {{ __('gigs.filters.urgent_only') }}
                </button>

                <button wire:click="$toggle('show_remote')"
                        class="px-6 py-3 rounded-full backdrop-blur-md text-white text-sm font-bold transition-all hover:scale-110 hover:shadow-xl hover:shadow-white/30 active:scale-95
                               {{ $show_remote ? 'bg-white/30 shadow-lg shadow-white/20 ring-2 ring-white/50' : 'bg-white/10 hover:bg-white/20' }}">
                    <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ __('gigs.filters.remote_only') }}
                </button>

                <button wire:click="clearFilters"
                        class="px-6 py-3 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-md text-white text-sm font-bold transition-all hover:scale-110 hover:shadow-xl hover:shadow-white/30 active:scale-95">
                    <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    {{ __('common.clear_all') }}
                </button>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 pb-20 relative z-20">
        
        <!-- Advanced Filters - Elegant Collapsible -->
        <div class="bg-white/95 dark:bg-neutral-800/95 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/50 dark:border-neutral-700/50 p-8 mb-12"
             x-data="{ visible: false, showAdvanced: false }"
             x-init="setTimeout(() => visible = true, 400)"
             x-show="visible"
             x-transition:enter="transition ease-out duration-700"
             x-transition:enter-start="opacity-0 translate-y-8"
             x-transition:enter-end="opacity-100 translate-y-0">
            
            <button @click="showAdvanced = !showAdvanced"
                    class="w-full flex items-center justify-between group">
                <h3 class="text-lg font-bold text-neutral-900 dark:text-white flex items-center gap-3">
                    <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                    </svg>
                    {{ __('gigs.filters.advanced') }}
                </h3>
                
                <div class="flex items-center gap-2 text-primary-600 dark:text-primary-400">
                    <span class="text-sm font-semibold" x-text="showAdvanced ? '{{ __('common.hide') }}' : '{{ __('common.show') }}'"></span>
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" 
                         :class="showAdvanced ? 'rotate-180' : ''"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </button>

            <!-- Advanced Filters Grid -->
            <div x-show="showAdvanced"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 -translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8 pt-8 border-t-2 border-dashed border-neutral-200 dark:border-neutral-700">
                
                <!-- Category -->
                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-3">
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
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-3">
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
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-3">
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

        <!-- Gigs Grid - Elegant Social Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-12">
            @forelse($gigs as $index => $gig)
                <article class="group relative"
                         x-data="{ visible: false }"
                         x-init="setTimeout(() => visible = true, {{ 600 + ($index * 80) }})"
                         x-show="visible"
                         x-transition:enter="transition ease-out duration-700"
                         x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100">
                    
                    <a href="{{ route('gigs.show', $gig) }}" 
                       class="block h-full bg-white dark:bg-neutral-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 border border-neutral-100 dark:border-neutral-700 overflow-hidden group-hover:-translate-y-3 group-hover:border-primary-300 dark:group-hover:border-primary-700">
                        
                        <!-- Gradient Top Bar (appears on hover) -->
                        <div class="h-1.5 bg-gradient-to-r from-primary-500 via-accent-500 to-primary-500 opacity-0 group-hover:opacity-100 transition-all duration-500 shadow-lg"></div>
                        
                        <div class="p-6">
                            <!-- Status Badges (only if has special status) -->
                            @if($gig->is_featured || $gig->is_urgent || $gig->is_remote || $gig->is_closed)
                                <div class="flex flex-wrap gap-2 mb-4">
                                    @if($gig->is_featured)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-md">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                            </svg>
                                            {{ __('gigs.status.featured') }}
                                        </span>
                                    @endif
                                    
                                    @if($gig->is_urgent)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-gradient-to-r from-orange-500 to-red-600 text-white shadow-md animate-pulse">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                            </svg>
                                            {{ __('gigs.status.urgent') }}
                                        </span>
                                    @endif

                                    @if($gig->is_remote)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-gradient-to-r from-emerald-500 to-teal-600 text-white shadow-md">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ __('gigs.remote') }}
                                        </span>
                                    @endif

                                    @if($gig->is_closed)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-neutral-400 dark:bg-neutral-600 text-white">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                            </svg>
                                            {{ __('gigs.status.closed') }}
                                        </span>
                                    @endif
                                </div>
                            @endif

                            <!-- Title -->
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4 line-clamp-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors leading-snug">
                                {{ $gig->title }}
                            </h3>

                            <!-- Category & Type Pills -->
                            <div class="flex items-center gap-2 mb-5">
                                <span class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-neutral-100 dark:bg-neutral-700/50 text-neutral-700 dark:text-neutral-300 border border-neutral-200/50 dark:border-neutral-600/50 shadow-sm">
                                    {{ __('gigs.categories.' . $gig->category) }}
                                </span>
                                <span class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-400 border border-primary-100 dark:border-primary-800/50 shadow-sm">
                                    {{ __('gigs.types.' . $gig->type) }}
                                </span>
                            </div>

                            <!-- Description -->
                            <p class="text-sm text-neutral-600 dark:text-neutral-400 line-clamp-3 mb-6 leading-relaxed">
                                {{ Str::limit(strip_tags($gig->description), 160) }}
                            </p>

                            <!-- Divider -->
                            <div class="border-t border-neutral-200 dark:border-neutral-700 mb-5"></div>

                            <!-- Meta Information -->
                            <div class="space-y-3 mb-6">
                                @if($gig->location)
                                    <div class="flex items-center gap-2.5 text-sm text-neutral-600 dark:text-neutral-400">
                                        <svg class="w-4 h-4 text-primary-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        </svg>
                                        <span class="truncate">{{ $gig->location }}</span>
                                    </div>
                                @endif

                                @if($gig->deadline)
                                    <div class="flex items-center justify-between text-sm">
                                        <div class="flex items-center gap-2.5 text-neutral-600 dark:text-neutral-400">
                                            <svg class="w-4 h-4 text-primary-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span>{{ $gig->deadline->format('d M Y') }}</span>
                                        </div>
                                        @if($gig->days_until_deadline !== null && $gig->days_until_deadline >= 0)
                                            <span class="px-2.5 py-1 rounded-lg text-xs font-bold
                                                {{ $gig->days_until_deadline <= 3 
                                                    ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 animate-pulse' 
                                                    : 'bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300' }}">
                                                {{ $gig->days_until_deadline }} {{ $gig->days_until_deadline == 1 ? __('common.day') : __('common.days') }}
                                            </span>
                                        @endif
                                    </div>
                                @endif

                                @if($gig->compensation)
                                    <div class="flex items-center gap-2.5 text-sm font-bold text-primary-600 dark:text-primary-400">
                                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="truncate">{{ $gig->compensation }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Footer with Applications -->
                            <div class="flex items-center justify-between pt-5 border-t-2 border-dashed border-neutral-200 dark:border-neutral-700">
                                <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-neutral-400">
                                    <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <span class="font-bold text-neutral-900 dark:text-white">{{ $gig->application_count }}</span>
                                    <span>{{ __('gigs.applications.applications') }}</span>
                                </div>

                                <div class="flex items-center gap-2 text-primary-600 dark:text-primary-400 font-bold text-sm group-hover:gap-3 transition-all">
                                    <span>{{ __('gigs.view') }}</span>
                                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                </article>
            @empty
                <div class="col-span-full">
                    <div class="bg-white/95 dark:bg-neutral-800/95 backdrop-blur-xl rounded-3xl border border-white/50 dark:border-neutral-700/50 p-20 text-center shadow-2xl">
                        <div class="w-32 h-32 mx-auto mb-8 rounded-full bg-gradient-to-br from-primary-100 to-accent-100 dark:from-primary-900/30 dark:to-accent-900/30 flex items-center justify-center transform group-hover:scale-110 transition-transform">
                            <svg class="w-16 h-16 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-neutral-900 dark:text-white mb-4">
                            {{ __('gigs.no_gigs_found') }}
                        </h3>
                        <p class="text-neutral-600 dark:text-neutral-400 mb-10 text-lg max-w-md mx-auto">
                            {{ __('gigs.no_gigs_description') }}
                        </p>
                        <button wire:click="clearFilters" 
                                class="inline-flex items-center gap-3 px-10 py-4 rounded-xl bg-gradient-to-r from-primary-500 to-accent-500 hover:from-primary-600 hover:to-accent-600 text-white font-bold text-lg shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            {{ __('common.clear_all') }}
                        </button>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-16">
            {{ $gigs->links() }}
        </div>

    </div>
    
    <!-- Animations -->
    <style>
        @keyframes float-particle {
            0%, 100% { 
                transform: translateY(0) translateX(0); 
                opacity: 0.4;
            }
            25% { 
                transform: translateY(-20px) translateX(10px); 
                opacity: 0.6;
            }
            50% { 
                transform: translateY(-40px) translateX(-10px); 
                opacity: 0.8;
            }
            75% { 
                transform: translateY(-20px) translateX(10px); 
                opacity: 0.6;
            }
        }
    </style>
    
</div>
