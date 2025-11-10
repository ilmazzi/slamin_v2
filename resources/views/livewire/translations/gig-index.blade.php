<div class="min-h-screen bg-gradient-to-br from-neutral-50 via-primary-50/30 to-neutral-50 dark:from-neutral-900 dark:via-primary-950/20 dark:to-neutral-900">
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-5xl md:text-6xl font-bold text-neutral-900 dark:text-white mb-4 font-poem">
                {{ __('gigs.title') }}
            </h1>
            <p class="text-lg text-neutral-600 dark:text-neutral-400 max-w-2xl mx-auto">
                {{ __('gigs.browse_all') }}
            </p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-2xl p-6 text-center border border-white/20 dark:border-neutral-700/50">
                <div class="text-3xl font-bold text-primary-600 dark:text-primary-400 mb-2">
                    {{ number_format($stats['total_gigs']) }}
                </div>
                <div class="text-sm text-neutral-600 dark:text-neutral-400">
                    {{ __('gigs.stats.total_gigs') }}
                </div>
            </div>
            
            <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-2xl p-6 text-center border border-white/20 dark:border-neutral-700/50">
                <div class="text-3xl font-bold text-green-600 dark:text-green-400 mb-2">
                    {{ number_format($stats['open_gigs_count']) }}
                </div>
                <div class="text-sm text-neutral-600 dark:text-neutral-400">
                    {{ __('gigs.stats.open_gigs_count') }}
                </div>
            </div>
            
            <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-2xl p-6 text-center border border-white/20 dark:border-neutral-700/50">
                <div class="text-3xl font-bold text-orange-600 dark:text-orange-400 mb-2">
                    {{ number_format($stats['urgent_gigs_count']) }}
                </div>
                <div class="text-sm text-neutral-600 dark:text-neutral-400">
                    {{ __('gigs.stats.urgent_gigs_count') }}
                </div>
            </div>
            
            <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-2xl p-6 text-center border border-white/20 dark:border-neutral-700/50">
                <div class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-2">
                    {{ number_format($stats['featured_gigs_count']) }}
                </div>
                <div class="text-sm text-neutral-600 dark:text-neutral-400">
                    {{ __('gigs.stats.featured_gigs_count') }}
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-3xl shadow-2xl border border-white/20 dark:border-neutral-700/50 p-6 mb-8">
            
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-neutral-900 dark:text-white">
                    {{ __('gigs.filters.title') }}
                </h3>
                
                <button wire:click="clearFilters" 
                        class="text-sm text-primary-600 dark:text-primary-400 hover:underline">
                    {{ __('common.clear_all') }}
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <!-- Search -->
                <div class="md:col-span-3">
                    <input type="text" 
                           wire:model.live.debounce.500ms="search"
                           placeholder="{{ __('gigs.filters.search') }}"
                           class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                </div>

                <!-- Category -->
                <div>
                    <select wire:model.live="category" 
                            class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white">
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
                    <select wire:model.live="type" 
                            class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white">
                        <option value="">{{ __('gigs.filters.select_type') }}</option>
                        <option value="paid">{{ __('gigs.types.paid') }}</option>
                        <option value="volunteer">{{ __('gigs.types.volunteer') }}</option>
                        <option value="collaboration">{{ __('gigs.types.collaboration') }}</option>
                    </select>
                </div>

                <!-- Language -->
                <div>
                    <select wire:model.live="language" 
                            class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white">
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

            <!-- Checkboxes -->
            <div class="flex flex-wrap gap-4">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" wire:model.live="show_featured" 
                           class="rounded border-neutral-300 dark:border-neutral-600 text-primary-600 focus:ring-primary-500">
                    <span class="text-sm text-neutral-700 dark:text-neutral-300">{{ __('gigs.filters.featured_only') }}</span>
                </label>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" wire:model.live="show_urgent" 
                           class="rounded border-neutral-300 dark:border-neutral-600 text-primary-600 focus:ring-primary-500">
                    <span class="text-sm text-neutral-700 dark:text-neutral-300">{{ __('gigs.filters.urgent_only') }}</span>
                </label>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" wire:model.live="show_remote" 
                           class="rounded border-neutral-300 dark:border-neutral-600 text-primary-600 focus:ring-primary-500">
                    <span class="text-sm text-neutral-700 dark:text-neutral-300">{{ __('gigs.filters.remote_only') }}</span>
                </label>
            </div>
        </div>

        <!-- Gigs Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($gigs as $gig)
                <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-2xl p-6 border border-white/20 dark:border-neutral-700/50 hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                    
                    <!-- Badges -->
                    <div class="flex flex-wrap gap-2 mb-4">
                        @if($gig->is_featured)
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                {{ __('gigs.status.featured') }}
                            </span>
                        @endif
                        
                        @if($gig->is_urgent)
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200">
                                {{ __('gigs.status.urgent') }}
                            </span>
                        @endif

                        @if($gig->is_remote)
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                {{ __('gigs.remote') }}
                            </span>
                        @endif
                    </div>

                    <!-- Title -->
                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-2 line-clamp-2">
                        {{ $gig->title }}
                    </h3>

                    <!-- Category & Type -->
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-sm text-neutral-600 dark:text-neutral-400">
                            {{ __('gigs.categories.' . $gig->category) }}
                        </span>
                        <span class="text-neutral-400 dark:text-neutral-600">•</span>
                        <span class="text-sm text-neutral-600 dark:text-neutral-400">
                            {{ __('gigs.types.' . $gig->type) }}
                        </span>
                    </div>

                    <!-- Location -->
                    @if($gig->location)
                        <div class="flex items-center gap-2 mb-3 text-sm text-neutral-600 dark:text-neutral-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $gig->location }}
                        </div>
                    @endif

                    <!-- Deadline -->
                    @if($gig->deadline)
                        <div class="flex items-center gap-2 mb-3 text-sm text-neutral-600 dark:text-neutral-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $gig->deadline->format('d M Y') }}
                            @if($gig->days_until_deadline !== null && $gig->days_until_deadline >= 0)
                                <span class="text-xs">({{ $gig->days_until_deadline }} {{ __('gigs.days_left') }})</span>
                            @endif
                        </div>
                    @endif

                    <!-- Compensation -->
                    @if($gig->compensation)
                        <div class="mb-4 text-sm font-semibold text-primary-600 dark:text-primary-400">
                            {{ $gig->compensation }}
                        </div>
                    @endif

                    <!-- Applications Count -->
                    <div class="text-sm text-neutral-500 dark:text-neutral-400 mb-4">
                        {{ $gig->application_count }} {{ __('gigs.applications.applications') }}
                    </div>

                    <!-- Action Button -->
                    <a href="{{ route('gigs.show', $gig) }}" 
                       class="block w-full text-center px-4 py-2 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-semibold transition-colors">
                        {{ __('gigs.view') }}
                    </a>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-neutral-600 dark:text-neutral-400 text-lg">
                        {{ __('gigs.no_gigs_found') }}
                    </p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $gigs->links() }}
        </div>

    </div>
</div>
