@once
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@vite(['resources/css/events-map.css', 'resources/css/events-index.css'])
@endpush
@endonce

@once
@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@vite(['resources/js/events-map.js'])
@endpush
@endonce

<div class="min-h-screen bg-gradient-to-br from-neutral-50 via-white to-primary-50/30 dark:from-neutral-900 dark:via-neutral-800 dark:to-neutral-900 overflow-hidden">
    
    {{-- HERO con Ticket + Titolo (come poesie e articoli) --}}
    <div class="relative py-12 md:py-20 overflow-hidden bg-neutral-900 dark:bg-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center gap-6 md:flex-row md:justify-center md:gap-12">
                
                <!-- TICKET (dalla home) - Dimensione maggiorata -->
                <?php 
                    $tilt = rand(-3, 3);
                    $selectedColors = [
                        ['#fefaf3', '#fdf8f0', '#faf5ec'],
                        ['#fef9f1', '#fdf7ef', '#faf4ea'],
                        ['#fffbf5', '#fef9f3', '#fdf7f1']
                    ][rand(0, 2)];
                ?>
                <div class="hero-ticket-wrapper-large">
                    <div class="hero-ticket-wrapper" style="transform: rotate({{ $tilt }}deg);">
                        <div class="hero-cinema-ticket"
                             style="background: linear-gradient(135deg, {{ $selectedColors[0] }} 0%, {{ $selectedColors[1] }} 50%, {{ $selectedColors[2] }} 100%);">
                            <div class="hero-ticket-perforation"></div>
                            <div class="hero-ticket-content">
                                <div class="ticket-mini-header">
                                    <div class="text-[8px] font-black tracking-wider text-red-700">TICKET</div>
                                    <div class="text-[7px] font-bold text-amber-700">#0{{ rand(1, 9) }}{{ rand(0, 9) }}{{ rand(0, 9) }}</div>
                                </div>
                                <div class="flex-1 flex items-center justify-center">
                                    <div class="hero-ticket-stamp">{{ strtoupper(__('home.hero_category_events')) }}</div>
                                </div>
                                <div class="ticket-mini-barcode">
                                    <div class="flex justify-center gap-[1px]">
                                        @for($j = 0; $j < 20; $j++)
                                        <div style="width: {{ rand(1, 2) }}px; height: {{ rand(12, 18) }}px; background: #2d2520;"></div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- TITOLO A FIANCO -->
                <div class="text-center md:text-left">
                    <h1 class="text-5xl md:text-7xl lg:text-8xl font-black text-white leading-tight" style="font-family: 'Playfair Display', serif;">
                        {{ __('events.discover_events') }}
                    </h1>
                    <p class="text-xl md:text-2xl text-white/80 mt-4 font-medium">
                        {{ __('events.where_poetry_lives') }}
                    </p>
                    
                    @auth
                        @if(auth()->user()->canOrganizeEvents())
                            <div class="mt-6">
                                <a href="{{ route('events.create') }}" 
                                   class="group inline-flex items-center gap-3 px-6 py-3 rounded-xl
                                          bg-gradient-to-r from-primary-500 to-primary-600 
                                          hover:from-primary-600 hover:to-primary-700
                                          text-white font-bold shadow-xl shadow-primary-500/30
                                          hover:shadow-2xl hover:shadow-primary-500/40 hover:-translate-y-1
                                          transition-all duration-300">
                                    <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" 
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M12 4v16m8-8H4"/>
                                    </svg>
                                    <span>{{ __('events.create_event') }}</span>
                                </a>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
    
    {{-- Filtri e Ricerca --}}
    <div class="relative py-8 bg-gradient-to-b from-white to-gray-50 dark:from-gray-900 dark:to-gray-900/95">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div id="events-search-panel" class="relative">
                <div class="events-search-card">
                    <div class="relative">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input 
                            type="text" 
                            wire:model.live.debounce.500ms="search"
                            placeholder="{{ __('events.search_placeholder') }}"
                            class="w-full pl-12 pr-4 py-4 rounded-2xl bg-white/90 dark:bg-neutral-900/80 text-neutral-900 dark:text-white shadow-inner focus:ring-2 focus:ring-primary-400 transition-all">
                    </div>
                    
                    <div class="mt-6 flex flex-wrap gap-2">
                        <button wire:click="applyQuickFilter('today')" class="events-filter-chip">
                            <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ __('events.today') }}
                        </button>
                        <button wire:click="applyQuickFilter('tomorrow')" class="events-filter-chip">
                            <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            {{ __('events.tomorrow') }}
                        </button>
                        <button wire:click="applyQuickFilter('weekend')" class="events-filter-chip">
                            <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                            {{ __('events.weekend') }}
                        </button>
                        <button wire:click="applyQuickFilter('free')" class="events-filter-chip">
                            <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                            </svg>
                            {{ __('events.free') }}
                        </button>
                        @auth
                            <button wire:click="applyQuickFilter('my')" class="events-filter-chip">
                                <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                {{ __('events.my_events') }}
                            </button>
                        @endauth
                        <button wire:click="resetFilters" class="events-filter-chip events-filter-chip--ghost">
                            <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            {{ __('events.reset') }}
                        </button>
                    </div>
                    
                    <div class="mt-6 text-center">
                        <button @click="showFilters = !showFilters"
                                class="inline-flex items-center gap-2 text-sm font-semibold text-primary-600 hover:text-primary-700 transition">
                            <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': showFilters }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                            {{ __('events.advanced_filters') }}
                        </button>
                    </div>
                    
                    <div x-show="showFilters"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-4"
                         class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-neutral-600 dark:text-neutral-200 mb-2">{{ __('events.city') }}</label>
                            <select wire:model.live="city" class="events-select">
                                <option value="">{{ __('events.all_cities') }}</option>
                                @foreach($cities as $cityOption)
                                    <option value="{{ $cityOption }}">{{ $cityOption }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-neutral-600 dark:text-neutral-200 mb-2">{{ __('events.type') }}</label>
                            <select wire:model.live="type" class="events-select">
                                <option value="">{{ __('events.all_types') }}</option>
                                <option value="public">{{ __('events.public') }}</option>
                                <option value="private">{{ __('events.private') }}</option>
                            </select>
                        </div>
                        <div class="flex items-center justify-between md:justify-start md:gap-3 bg-white/60 dark:bg-neutral-900/70 px-4 py-3 rounded-xl border border-white/20 dark:border-neutral-700/60">
                            <div>
                                <div class="text-sm font-semibold text-neutral-600 dark:text-neutral-200">{{ __('events.price') }}</div>
                                <div class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('events.free_only') }}</div>
                            </div>
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" wire:model.live="freeOnly" class="rounded text-primary-500 focus:ring-primary-400">
                                <span class="text-sm text-neutral-600 dark:text-neutral-200">{{ __('events.free_only') }}</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
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

    <!-- Interactive Map Section -->
    <section class="mb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-3xl font-bold bg-gradient-to-r from-primary-600 to-accent-600 bg-clip-text text-transparent">
                    {{ __('events.events_map') }}
                </h2>
                <button 
                    @click="$refs.map.scrollIntoView({ behavior: 'smooth' })"
                    class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-full text-sm font-semibold transition-all hover:scale-105">
                    <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ __('events.center_map') }}
                </button>
            </div>
            
            <div class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-primary-200 dark:border-primary-800">
                <!-- Map Container (always visible) -->
                <div id="eventsMap" 
                     wire:ignore
                     class="h-[500px] w-full bg-neutral-100 dark:bg-neutral-800">
                </div>
                
                <!-- Hidden data container that updates with Livewire -->
                <div id="mapEventsData" 
                     class="hidden"
                     data-events='@json($mapData)'
                     data-total-count="{{ $events->count() }}">
                </div>
                
                <!-- Hidden translation text for popup -->
                <div data-view-details-text="{{ __('events.view_details') }}" class="hidden"></div>
                
                <!-- Map Controls Overlay -->
                <div class="absolute top-4 right-4 z-[1000] flex flex-col gap-3">
                    <!-- Reset View -->
                    <button 
                        onclick="map.setView([41.9028, 12.4964], 6)"
                        class="p-3 bg-white dark:bg-neutral-800 rounded-full shadow-lg hover:shadow-xl transition-all hover:scale-110 group"
                        title="Centra mappa sull'Italia">
                        <svg class="w-5 h-5 text-primary-600 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </button>
                    
                    <!-- Map Style Selector -->
                    <div class="bg-white dark:bg-neutral-800 rounded-full shadow-lg p-2 flex flex-col gap-2">
                        <button 
                            onclick="changeMapStyle('standard')"
                            id="style-standard"
                            class="map-style-btn p-2.5 rounded-full hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all"
                            title="Mappa Standard">
                            <svg class="w-4 h-4 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>
                        </button>
                        <button 
                            onclick="changeMapStyle('satellite')"
                            id="style-satellite"
                            class="map-style-btn p-2.5 rounded-full hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all"
                            title="Vista Satellite">
                            <svg class="w-4 h-4 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </button>
                        <button 
                            onclick="changeMapStyle('dark')"
                            id="style-dark"
                            class="map-style-btn p-2.5 rounded-full hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all"
                            title="Mappa Scura">
                            <svg class="w-4 h-4 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                        </button>
                        <button 
                            onclick="changeMapStyle('voyager')"
                            id="style-voyager"
                            class="map-style-btn active p-2.5 rounded-full hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all"
                            title="Mappa Colorata">
                            <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                            </svg>
                        </button>
                        <button 
                            onclick="changeMapStyle('positron')"
                            id="style-positron"
                            class="map-style-btn p-2.5 rounded-full hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all"
                            title="Mappa Chiara Minimal">
                            <svg class="w-4 h-4 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </button>
                        <button 
                            onclick="changeMapStyle('topo')"
                            id="style-topo"
                            class="map-style-btn p-2.5 rounded-full hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all"
                            title="Mappa Topografica">
                            <svg class="w-4 h-4 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Legend -->
                <div class="absolute bottom-4 left-4 z-[1000] bg-white/95 dark:bg-neutral-800/95 backdrop-blur-md rounded-2xl p-4 shadow-xl border border-primary-200 dark:border-primary-800">
                    <h4 class="text-xs font-bold text-neutral-700 dark:text-neutral-300 mb-2 uppercase tracking-wider">{{ __('events.legend') }}</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['poetry_slam' => '#EF4444', 'workshop' => '#F59E0B', 'open_mic' => '#10B981', 'reading' => '#3B82F6', 'other' => '#6B7280'] as $cat => $color)
                        <div class="flex items-center gap-1.5">
                            <div class="w-3 h-3 rounded-full" style="background-color: {{ $color }}"></div>
                            <span class="text-xs text-neutral-600 dark:text-neutral-400">{{ ucfirst(str_replace('_', ' ', $cat)) }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dynamic Bento Box Layout -->
    <div class="relative max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 pb-16"
         x-data="{ scrollY: 0, mouseX: 0, mouseY: 0 }"
         @scroll.window="scrollY = window.scrollY"
         @mousemove.window="mouseX = $event.clientX; mouseY = $event.clientY">
        
        <!-- Animated Floating Orbs Background -->
        <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none opacity-40">
            <div class="absolute w-[600px] h-[600px] rounded-full blur-3xl bg-gradient-to-br from-primary-300/40 to-accent-300/40"
                 :style="`transform: translate(${mouseX * 0.02}px, ${scrollY * 0.2 + mouseY * 0.02}px)`"
                 style="top: 10%; left: 10%;"></div>
            <div class="absolute w-[500px] h-[500px] rounded-full blur-3xl bg-gradient-to-br from-accent-300/40 to-primary-400/40 animate-pulse"
                 :style="`transform: translate(-${mouseX * 0.03}px, ${scrollY * 0.3 - mouseY * 0.02}px)`"
                 style="top: 50%; right: 10%; animation-delay: 1s;"></div>
            <div class="absolute w-[400px] h-[400px] rounded-full blur-3xl bg-gradient-to-br from-primary-400/40 to-accent-500/40 animate-pulse"
                 :style="`transform: translate(${mouseX * 0.025}px, ${scrollY * 0.15 + mouseY * 0.015}px)`"
                 style="bottom: 20%; left: 40%; animation-delay: 2s;"></div>
        </div>
        
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
                            isHovered: false,
                            tiltX: 0,
                            tiltY: 0
                        }"
                        x-init="setTimeout(() => visible = true, {{ 50 + ($index * 60) }})"
                        x-show="visible"
                        @mouseenter="isHovered = true"
                        @mouseleave="isHovered = false; tiltX = 0; tiltY = 0"
                        @mousemove="
                            if (isHovered) {
                                const rect = $el.getBoundingClientRect();
                                const x = $event.clientX - rect.left;
                                const y = $event.clientY - rect.top;
                                tiltX = ((y / rect.height) - 0.5) * -10;
                                tiltY = ((x / rect.width) - 0.5) * 10;
                            }
                        "
                        x-transition:enter="transition ease-out duration-800"
                        x-transition:enter-start="opacity-0 scale-90 {{ $isLarge ? 'rotate-2' : '-rotate-1' }}"
                        x-transition:enter-end="opacity-100 scale-100 rotate-0"
                        class="{{ $sizeClass }} group relative overflow-hidden rounded-3xl cursor-pointer transition-all duration-300"
                        :class="isHovered ? 'z-20 shadow-2xl' : 'z-10 shadow-lg'"
                        :style="`transform: ${isHovered ? `perspective(1000px) rotateX(${tiltX}deg) rotateY(${tiltY}deg) scale(1.05)` : 'none'}`">
                        
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
                        
                        <!-- Sparkle Effect on Hover -->
                        <div class="absolute inset-0 overflow-hidden pointer-events-none">
                            <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-white rounded-full opacity-0 group-hover:opacity-100 group-hover:animate-ping"></div>
                            <div class="absolute top-1/3 right-1/3 w-1.5 h-1.5 bg-primary-300 rounded-full opacity-0 group-hover:opacity-100 group-hover:animate-ping" style="animation-delay: 0.1s"></div>
                            <div class="absolute bottom-1/3 left-1/3 w-2 h-2 bg-accent-300 rounded-full opacity-0 group-hover:opacity-100 group-hover:animate-ping" style="animation-delay: 0.2s"></div>
                            <div class="absolute top-1/2 right-1/4 w-1 h-1 bg-white rounded-full opacity-0 group-hover:opacity-100 group-hover:animate-ping" style="animation-delay: 0.15s"></div>
                        </div>
                        
                        <!-- Floating Category Badge -->
                        <div class="absolute top-4 right-4 z-10 transform transition-all duration-300 group-hover:scale-110 group-hover:-rotate-3">
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-md text-white text-xs font-bold uppercase rounded-full border border-white/30 shadow-lg">
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
                                        {{ $event->start_datetime ? $event->start_datetime->format('d M') : 'TBD' }}
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
                        
                        <!-- Shine Effect on Hover -->
                        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none overflow-hidden">
                            <div class="absolute -inset-full bg-gradient-to-r from-transparent via-white/20 to-transparent skew-x-12 group-hover:animate-shine"></div>
                        </div>
                        
                        <!-- Glow Effect Under Card -->
                        <div class="absolute -inset-4 bg-gradient-to-r from-primary-500/0 via-primary-500/20 to-accent-500/0 blur-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 -z-10"></div>
                        
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
    
    @once
    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    @endpush
    @endonce

    @once
    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @vite(['resources/js/events-map.js'])
    @endpush
    @endonce
</div>
