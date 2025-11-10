<div class="min-h-screen bg-gradient-to-br from-neutral-50 via-primary-50/30 to-neutral-50 dark:from-neutral-900 dark:via-primary-950/20 dark:to-neutral-900">
    
    <!-- Floating Background Elements -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden" style="z-index: 5;" aria-hidden="true">
        @for($i = 0; $i < 6; $i++)
            <div class="absolute text-6xl opacity-5 pointer-events-none select-none"
                 style="
                    top: {{ 10 + ($i * 15) }}%;
                    {{ $i % 2 === 0 ? 'left' : 'right' }}: {{ 5 + ($i * 2) }}%;
                    animation: float-gig-{{ $i }} {{ 25 + ($i * 3) }}s ease-in-out infinite;
                    animation-delay: {{ $i * 1.5 }}s;
                ">
                {{ ['💼', '🎭', '🎨', '🌟', '✨', '📝'][$i] }}
            </div>
            
            <style>
                @keyframes float-gig-{{ $i }} {
                    0%, 100% { transform: translateY(0) rotate({{ -5 + ($i * 2) }}deg); }
                    50% { transform: translateY(-30px) rotate({{ -2 + ($i * 2) }}deg); }
                }
            </style>
        @endfor
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" style="z-index: 10;">
        
        <!-- Poetic Header -->
        <div class="text-center mb-16 relative">
            <div class="absolute -top-8 left-1/2 -translate-x-1/2 text-primary-200 dark:text-primary-900/30 text-9xl leading-none pointer-events-none">
                💼
            </div>
            
            <div class="relative z-10">
                <h1 class="text-5xl md:text-7xl font-bold text-neutral-900 dark:text-white mb-4 tracking-tight animate-fade-in">
                    <span class="inline-block">{{ __('gigs.title') }}</span>
                </h1>
                <p class="text-lg md:text-xl text-neutral-600 dark:text-neutral-400 max-w-2xl mx-auto italic animate-fade-in-delay-1">
                    "{{ __('gigs.browse_all') }}"
                </p>
            </div>
        </div>

        <!-- Stats Cards - Animated -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12 animate-fade-in-delay-1">
            @php
                $statsConfig = [
                    ['key' => 'total_gigs', 'color' => 'primary', 'icon' => '💼'],
                    ['key' => 'open_gigs_count', 'color' => 'green', 'icon' => '✨'],
                    ['key' => 'urgent_gigs_count', 'color' => 'orange', 'icon' => '🔥'],
                    ['key' => 'featured_gigs_count', 'color' => 'blue', 'icon' => '⭐'],
                ];
            @endphp
            
            @foreach($statsConfig as $stat)
                <div class="group backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-2xl p-6 border border-white/20 dark:border-neutral-700/50 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                    <div class="text-center">
                        <div class="text-4xl mb-2 group-hover:scale-110 transition-transform duration-300">
                            {{ $stat['icon'] }}
                        </div>
                        <div class="text-3xl font-bold text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400 mb-2">
                            {{ number_format($stats[$stat['key']]) }}
                        </div>
                        <div class="text-sm text-neutral-600 dark:text-neutral-400">
                            {{ __('gigs.stats.' . $stat['key']) }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Filters - Modern Card -->
        <div class="mb-12 animate-fade-in-delay-2">
            <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-3xl shadow-2xl border border-white/20 dark:border-neutral-700/50 p-6 md:p-8">
                
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-neutral-900 dark:text-white flex items-center gap-2">
                        <span class="text-2xl">🔍</span>
                        {{ __('gigs.filters.title') }}
                    </h3>
                    
                    <button wire:click="clearFilters" 
                            class="text-sm font-medium text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 transition-colors">
                        {{ __('common.clear_all') }}
                    </button>
                </div>

                <div class="space-y-4">
                    <!-- Search -->
                    <div>
                        <input type="text" 
                               wire:model.live.debounce.500ms="search"
                               placeholder="{{ __('gigs.filters.search') }}"
                               class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white placeholder:text-neutral-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
                    </div>

                    <!-- Filters Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Category -->
                        <div>
                            <label class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('gigs.fields.category') }}
                            </label>
                            <select wire:model.live="category" 
                                    class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
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
                            <label class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('gigs.fields.type') }}
                            </label>
                            <select wire:model.live="type" 
                                    class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
                                <option value="">{{ __('gigs.filters.select_type') }}</option>
                                <option value="paid">{{ __('gigs.types.paid') }}</option>
                                <option value="volunteer">{{ __('gigs.types.volunteer') }}</option>
                                <option value="collaboration">{{ __('gigs.types.collaboration') }}</option>
                            </select>
                        </div>

                        <!-- Language -->
                        <div>
                            <label class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('gigs.fields.language') }}
                            </label>
                            <select wire:model.live="language" 
                                    class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
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
                    <div class="flex flex-wrap gap-4 pt-2">
                        <label class="group flex items-center gap-2 cursor-pointer px-4 py-2 rounded-xl hover:bg-neutral-50 dark:hover:bg-neutral-700/50 transition-colors">
                            <input type="checkbox" wire:model.live="show_featured" 
                                   class="rounded border-neutral-300 dark:border-neutral-600 text-blue-600 focus:ring-blue-500">
                            <span class="text-sm font-medium text-neutral-700 dark:text-neutral-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                ⭐ {{ __('gigs.filters.featured_only') }}
                            </span>
                        </label>

                        <label class="group flex items-center gap-2 cursor-pointer px-4 py-2 rounded-xl hover:bg-neutral-50 dark:hover:bg-neutral-700/50 transition-colors">
                            <input type="checkbox" wire:model.live="show_urgent" 
                                   class="rounded border-neutral-300 dark:border-neutral-600 text-orange-600 focus:ring-orange-500">
                            <span class="text-sm font-medium text-neutral-700 dark:text-neutral-300 group-hover:text-orange-600 dark:group-hover:text-orange-400 transition-colors">
                                🔥 {{ __('gigs.filters.urgent_only') }}
                            </span>
                        </label>

                        <label class="group flex items-center gap-2 cursor-pointer px-4 py-2 rounded-xl hover:bg-neutral-50 dark:hover:bg-neutral-700/50 transition-colors">
                            <input type="checkbox" wire:model.live="show_remote" 
                                   class="rounded border-neutral-300 dark:border-neutral-600 text-green-600 focus:ring-green-500">
                            <span class="text-sm font-medium text-neutral-700 dark:text-neutral-300 group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">
                                🌐 {{ __('gigs.filters.remote_only') }}
                            </span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gigs Grid - Beautiful Cards with Animations -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 animate-fade-in-delay-3">
            @forelse($gigs as $index => $gig)
                <article class="group h-full backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-2xl border border-white/20 dark:border-neutral-700/50 overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 cursor-pointer"
                         onclick="window.location='{{ route('gigs.show', $gig) }}'"
                         style="animation-delay: {{ $index * 0.1 }}s;">
                    
                    <!-- Header with Badges -->
                    <div class="p-6 pb-4">
                        <div class="flex flex-wrap gap-2 mb-4">
                            @if($gig->is_featured)
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg shadow-blue-500/30 animate-pulse">
                                    ⭐ {{ __('gigs.status.featured') }}
                                </span>
                            @endif
                            
                            @if($gig->is_urgent)
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-orange-500 to-orange-600 text-white shadow-lg shadow-orange-500/30">
                                    🔥 {{ __('gigs.status.urgent') }}
                                </span>
                            @endif

                            @if($gig->is_remote)
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg shadow-green-500/30">
                                    🌐 {{ __('gigs.remote') }}
                                </span>
                            @endif

                            @if($gig->is_closed)
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-neutral-400 dark:bg-neutral-600 text-white">
                                    🔒 {{ __('gigs.status.closed') }}
                                </span>
                            @endif
                        </div>

                        <!-- Title -->
                        <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3 line-clamp-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                            {{ $gig->title }}
                        </h3>

                        <!-- Category & Type Pills -->
                        <div class="flex items-center gap-2 mb-3">
                            <span class="px-3 py-1 rounded-lg text-xs font-semibold bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 border border-neutral-200 dark:border-neutral-600">
                                {{ __('gigs.categories.' . $gig->category) }}
                            </span>
                            <span class="px-3 py-1 rounded-lg text-xs font-semibold bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 border border-primary-200 dark:border-primary-800">
                                {{ __('gigs.types.' . $gig->type) }}
                            </span>
                        </div>

                        <!-- Description Preview -->
                        <p class="text-sm text-neutral-600 dark:text-neutral-400 line-clamp-3 mb-4">
                            {{ Str::limit(strip_tags($gig->description), 120) }}
                        </p>
                    </div>

                    <!-- Details Section -->
                    <div class="px-6 pb-4 space-y-2">
                        <!-- Location or Remote -->
                        @if($gig->location)
                            <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-neutral-400">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                                <span class="truncate">{{ $gig->location }}</span>
                            </div>
                        @endif

                        <!-- Deadline -->
                        @if($gig->deadline)
                            <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-neutral-400">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $gig->deadline->format('d M Y') }}</span>
                                @if($gig->days_until_deadline !== null && $gig->days_until_deadline >= 0)
                                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                                        {{ $gig->days_until_deadline <= 3 ? 'bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300' : 'bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300' }}">
                                        {{ $gig->days_until_deadline }} {{ __('gigs.days_left') }}
                                    </span>
                                @endif
                            </div>
                        @endif

                        <!-- Compensation -->
                        @if($gig->compensation)
                            <div class="flex items-center gap-2 text-sm font-semibold text-primary-600 dark:text-primary-400">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="truncate">{{ $gig->compensation }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Footer -->
                    <div class="px-6 py-4 bg-neutral-50 dark:bg-neutral-900/50 border-t border-neutral-200 dark:border-neutral-700 flex items-center justify-between">
                        <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-neutral-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <span class="font-semibold">{{ $gig->application_count }}</span>
                            <span>{{ __('gigs.applications.applications') }}</span>
                        </div>

                        <div class="flex items-center gap-2 text-primary-600 dark:text-primary-400 font-semibold group-hover:gap-3 transition-all">
                            <span class="text-sm">{{ __('gigs.view') }}</span>
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full">
                    <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-3xl border border-white/20 dark:border-neutral-700/50 p-12 text-center">
                        <div class="text-8xl mb-6 animate-bounce">📭</div>
                        <h3 class="text-2xl font-bold text-neutral-900 dark:text-white mb-2">
                            {{ __('gigs.no_gigs_found') }}
                        </h3>
                        <p class="text-neutral-600 dark:text-neutral-400 mb-6">
                            {{ __('gigs.no_gigs_description') }}
                        </p>
                        <button wire:click="clearFilters" 
                                class="px-6 py-3 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-semibold transition-colors">
                            {{ __('common.clear_all') }}
                        </button>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $gigs->links() }}
        </div>

    </div>
    
    <!-- Animations CSS -->
    <style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fade-in-delay-1 {
    0% { opacity: 0; transform: translateY(20px); }
    20% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
}

@keyframes fade-in-delay-2 {
    0% { opacity: 0; transform: translateY(20px); }
    40% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
}

@keyframes fade-in-delay-3 {
    0% { opacity: 0; transform: translateY(20px); }
    60% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
}

.animate-fade-in { animation: fade-in 0.8s ease-out; }
.animate-fade-in-delay-1 { animation: fade-in-delay-1 1.2s ease-out; }
.animate-fade-in-delay-2 { animation: fade-in-delay-2 1.6s ease-out; }
.animate-fade-in-delay-3 { animation: fade-in-delay-3 2s ease-out; }
</style>
