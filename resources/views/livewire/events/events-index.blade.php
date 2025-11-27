<div class="min-h-screen bg-gradient-to-br from-neutral-50 via-white to-amber-50/20 dark:from-neutral-900 dark:via-neutral-800 dark:to-neutral-900 overflow-hidden">
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
                                          bg-gradient-to-r from-red-700 to-red-800 
                                          hover:from-red-800 hover:to-red-900
                                          text-white font-bold shadow-xl shadow-red-700/30
                                          hover:shadow-2xl hover:shadow-red-800/40 hover:-translate-y-1
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

    <!-- Interactive Map Section -->
    <div class="mb-16 mt-12">
        <div class="max-w-[95rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-3xl font-bold text-red-700 dark:text-red-400" style="font-family: 'Crimson Pro', serif;">
                    {{ __('events.events_map') }}
                </h2>
                <button 
                    onclick="if(window.map) { window.map.setView([41.9028, 12.4964], 5); }"
                    class="px-4 py-2 bg-red-700/90 hover:bg-red-800 dark:bg-red-600/90 dark:hover:bg-red-700 text-white rounded-full text-sm font-semibold transition-all hover:scale-105 shadow-lg shadow-red-700/20">
                    <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ __('events.center_map') }}
                </button>
            </div>
            
            <div class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-amber-200/40 dark:border-amber-800/30">
                <!-- Map Container (always visible) -->
                <div id="eventsMap" 
                     wire:ignore
                     class="h-[650px] w-full bg-neutral-100 dark:bg-neutral-800">
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
                        onclick="if(window.map) window.map.setView([41.9028, 12.4964], 5)"
                        class="p-3 bg-white dark:bg-neutral-800 rounded-full shadow-lg hover:shadow-xl transition-all hover:scale-110 group"
                        title="Centra mappa sull'Italia">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-500 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </button>
                    
                    <!-- Map Style Selector -->
                    <div class="bg-white dark:bg-neutral-800 rounded-full shadow-lg p-2 flex flex-col gap-2">
                        <button 
                            onclick="changeMapStyle('standard')"
                            id="style-standard"
                            class="map-style-btn p-2.5 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20 transition-all"
                            title="Mappa Standard">
                            <svg class="w-4 h-4 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>
                        </button>
                        <button 
                            onclick="changeMapStyle('satellite')"
                            id="style-satellite"
                            class="map-style-btn p-2.5 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20 transition-all"
                            title="Vista Satellite">
                            <svg class="w-4 h-4 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </button>
                        <button 
                            onclick="changeMapStyle('dark')"
                            id="style-dark"
                            class="map-style-btn p-2.5 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20 transition-all"
                            title="Mappa Scura">
                            <svg class="w-4 h-4 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                        </button>
                        <button 
                            onclick="changeMapStyle('voyager')"
                            id="style-voyager"
                            class="map-style-btn active p-2.5 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20 transition-all"
                            title="Mappa Colorata">
                            <svg class="w-4 h-4 text-red-600 dark:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                            </svg>
                        </button>
                        <button 
                            onclick="changeMapStyle('positron')"
                            id="style-positron"
                            class="map-style-btn p-2.5 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20 transition-all"
                            title="Mappa Chiara Minimal">
                            <svg class="w-4 h-4 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </button>
                        <button 
                            onclick="changeMapStyle('topo')"
                            id="style-topo"
                            class="map-style-btn p-2.5 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20 transition-all"
                            title="Mappa Topografica">
                            <svg class="w-4 h-4 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Legend -->
                <div class="absolute bottom-4 left-4 z-[1000] bg-white/95 dark:bg-neutral-800/95 backdrop-blur-md rounded-2xl p-4 shadow-xl border border-amber-200/40 dark:border-amber-800/30 max-w-xs">
                    <h4 class="text-xs font-bold text-neutral-700 dark:text-neutral-300 mb-3 uppercase tracking-wider">{{ __('events.legend') }}</h4>
                    <div class="grid grid-cols-2 gap-x-3 gap-y-2">
                        @php
                            $eventCategories = [
                                'poetry_slam' => '#DC2626',
                                'workshop' => '#2563EB',
                                'open_mic' => '#16A34A',
                                'reading' => '#9333EA',
                                'festival' => '#EA580C',
                                'concert' => '#DB2777',
                                'book_presentation' => '#0891B2',
                                'conference' => '#65A30D',
                                'contest' => '#C026D3',
                                'poetry_art' => '#0D9488',
                                'residency' => '#CA8A04',
                                'spoken_word' => '#7C3AED',
                                'other' => '#64748B'
                            ];
                        @endphp
                        @foreach($eventCategories as $cat => $color)
                        <div class="flex items-center gap-1.5">
                            <div class="w-3 h-3 rounded-full flex-shrink-0" style="background-color: {{ $color }}"></div>
                            <span class="text-xs text-neutral-600 dark:text-neutral-400 truncate">{{ __('events.category_' . $cat) }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Statistics Section --}}
    <x-events-stats-section :statistics="$statistics" />
    
    {{-- Search Section --}}
    <x-events-search-section 
        :search="$search" 
        :cities="$cities" 
        :city="$city" 
        :type="$type" 
        :freeOnly="$freeOnly" />

    {{-- Filtered Events Section (only when filters are active) --}}
    @if($hasActiveFilters && $events->count() > 0)
    <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-12 border-b-2 border-red-300/50 dark:border-red-700/50">
        <div class="mb-10">
            <h2 class="text-3xl md:text-4xl font-bold text-red-700 dark:text-red-400 mb-2" style="font-family: 'Crimson Pro', serif;">
                {{ __('events.filtered_events') }}
            </h2>
            <p class="text-neutral-600 dark:text-neutral-400">
                {{ __('events.filtered_events_description', ['count' => $events->count()]) }}
            </p>
        </div>
        
        {{-- Asymmetric Bento Style Layout --}}
        @php
            $sizes = [
                'xl' => 'col-span-2 row-span-2 min-h-[500px]',
                'lg' => 'col-span-2 row-span-1 min-h-[280px]',
                'md' => 'col-span-1 row-span-2 min-h-[450px]',
                'sm' => 'col-span-1 row-span-1 min-h-[280px]',
            ];
            $pattern = ['xl', 'sm', 'sm', 'lg', 'md', 'sm', 'sm', 'lg'];
        @endphp
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-4 auto-rows-auto">
            @foreach($events as $index => $event)
                @php
                    $sizeKey = $pattern[$index % count($pattern)];
                    $sizeClass = $sizes[$sizeKey];
                    $isLarge = in_array($sizeKey, ['xl', 'lg', 'md']);
                @endphp
                
                <div class="{{ $sizeClass }}">
                    @include('livewire.events.partials.event-card', ['event' => $event, 'index' => $index, 'isLarge' => $isLarge])
                </div>
            @endforeach
        </div>
    </div>
    @elseif($hasActiveFilters && $events->count() === 0)
    <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-12 border-b-2 border-red-300/50 dark:border-red-700/50">
        <div class="text-center py-16">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-red-100 dark:bg-red-900/30 mb-4">
                <svg class="w-10 h-10 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-2">
                {{ __('events.no_filtered_events') }}
            </h3>
            <p class="text-neutral-600 dark:text-neutral-400 mb-6 max-w-md mx-auto">
                {{ __('events.no_filtered_events_description') }}
            </p>
            <button wire:click="resetFilters" 
                    class="inline-flex items-center px-6 py-3 bg-red-700 text-white rounded-full font-semibold hover:bg-red-800 transition-all hover:scale-105">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                {{ __('events.reset_filters') }}
            </button>
        </div>
    </div>
    @endif

    {{-- Upcoming Events Section --}}
    <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-12">
        @if($upcomingEvents->count() > 0)
        <div class="mb-10">
            <h2 class="text-3xl md:text-4xl font-bold text-red-700 dark:text-red-400 mb-2" style="font-family: 'Crimson Pro', serif;">
                {{ __('events.upcoming_events') }}
            </h2>
            <p class="text-neutral-600 dark:text-neutral-400">
                {{ __('events.upcoming_soon') }}
            </p>
        </div>
        
        {{-- Asymmetric Bento Style Layout --}}
        @php
            $sizes = [
                'xl' => 'col-span-2 row-span-2 min-h-[500px]',
                'lg' => 'col-span-2 row-span-1 min-h-[280px]',
                'md' => 'col-span-1 row-span-2 min-h-[450px]',
                'sm' => 'col-span-1 row-span-1 min-h-[280px]',
            ];
            $pattern = ['xl', 'sm', 'sm', 'lg', 'md', 'sm', 'sm', 'lg'];
        @endphp
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-4 auto-rows-auto">
            @foreach($upcomingEvents->take(10) as $index => $event)
                @php
                    $sizeKey = $pattern[$index % count($pattern)];
                    $sizeClass = $sizes[$sizeKey];
                    $isLarge = in_array($sizeKey, ['xl', 'lg', 'md']);
                @endphp
                
                <div class="{{ $sizeClass }}">
                    @include('livewire.events.partials.event-card', ['event' => $event, 'index' => $index, 'isLarge' => $isLarge])
                </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-16">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-red-100 dark:bg-red-900/30 mb-4">
                <svg class="w-10 h-10 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-2">
                {{ __('events.no_upcoming_events') }}
            </h3>
            <p class="text-neutral-600 dark:text-neutral-400">
                {{ __('events.no_upcoming_events_description') }}
            </p>
        </div>
        @endif
    </div>

    {{-- Personalized Events Section --}}
    <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-12 border-t-2 border-amber-300/50 dark:border-amber-700/50 bg-gradient-to-b from-transparent via-amber-50/20 to-transparent dark:via-amber-900/10">
        <div class="mb-10">
            <h2 class="text-3xl md:text-4xl font-bold text-red-700 dark:text-red-400 mb-2" style="font-family: 'Crimson Pro', serif;">
                {{ __('events.personalized_events') }}
            </h2>
            <p class="text-neutral-600 dark:text-neutral-400">
                {{ __('events.personalized_events_description') }}
            </p>
        </div>
        
        @auth
            @if($personalizedEvents->count() > 0)
                {{-- Asymmetric Bento Style Layout --}}
                @php
                    $sizes = [
                        'xl' => 'col-span-2 row-span-2 min-h-[500px]',
                        'lg' => 'col-span-2 row-span-1 min-h-[280px]',
                        'md' => 'col-span-1 row-span-2 min-h-[450px]',
                        'sm' => 'col-span-1 row-span-1 min-h-[280px]',
                    ];
                    $pattern = ['xl', 'sm', 'sm', 'lg', 'md', 'sm', 'sm', 'lg'];
                @endphp
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-4 auto-rows-auto">
                    @foreach($personalizedEvents->take(10) as $index => $event)
                        @php
                            $sizeKey = $pattern[$index % count($pattern)];
                            $sizeClass = $sizes[$sizeKey];
                            $isLarge = in_array($sizeKey, ['xl', 'lg', 'md']);
                        @endphp
                        
                        <div class="{{ $sizeClass }}">
                            @include('livewire.events.partials.event-card', ['event' => $event, 'index' => $index, 'isLarge' => $isLarge])
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-amber-100 dark:bg-amber-900/30 mb-4">
                        <svg class="w-10 h-10 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-2">
                        {{ __('events.no_personalized_events') }}
                    </h3>
                    <p class="text-neutral-600 dark:text-neutral-400 mb-6 max-w-md mx-auto">
                        {{ __('events.personalized_events_empty_description') }}
                    </p>
                </div>
            @endif
        @else
            <div class="text-center py-16">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-amber-100 dark:bg-amber-900/30 mb-4">
                    <svg class="w-10 h-10 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-2">
                    {{ __('events.login_to_see_personalized') }}
                </h3>
                <p class="text-neutral-600 dark:text-neutral-400 mb-6 max-w-md mx-auto">
                    {{ __('events.personalized_events_login_description') }}
                </p>
                @if(Route::has('login'))
                <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 bg-red-700 text-white rounded-full font-semibold hover:bg-red-800 transition-all hover:scale-105">
                    {{ __('auth.login') ?? 'Accedi' }}
                </a>
                @endif
            </div>
        @endauth
    </div>


    <!-- Loading Overlay -->
    <div wire:loading wire:target="search,city,type,freeOnly,quickFilter,applyQuickFilter,resetFilters" 
         class="fixed inset-0 bg-black/20 backdrop-blur-sm z-50 flex items-center justify-center">
        <div class="bg-white dark:bg-neutral-800 rounded-xl p-6 shadow-2xl">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-red-700 mx-auto"></div>
            <p class="mt-4 text-neutral-900 dark:text-white font-medium">{{ __('events.loading') }}...</p>
        </div>
    </div>
</div>
