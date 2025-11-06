<div class="min-h-screen">
    
    {{-- HERO FULL-WIDTH con Parallax --}}
    <section class="relative h-[70vh] flex items-center justify-center overflow-hidden bg-gradient-to-br from-neutral-900 via-neutral-800 to-neutral-900"
             x-data="{ scrollY: 0 }"
             @scroll.window="scrollY = window.pageYOffset">
        
        {{-- Animated Orbs --}}
        <div class="absolute inset-0 overflow-hidden opacity-30">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-primary-600 rounded-full blur-3xl animate-blob"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-accent-600 rounded-full blur-3xl animate-blob-slow"></div>
        </div>

        <div class="relative z-10 text-center px-4" :style="`transform: translateY(${scrollY * 0.3}px)`">
            <div class="inline-block px-8 py-3 bg-white/10 backdrop-blur-md border border-white/20 rounded-full mb-8">
                <span class="text-white/90 text-sm font-black tracking-[0.3em] uppercase">Gallery</span>
            </div>
            <h1 class="text-7xl md:text-9xl font-black text-white mb-6 leading-none" style="font-family: 'Crimson Pro', serif;">
                Media
            </h1>
            <p class="text-xl md:text-2xl text-white/70 max-w-2xl mx-auto font-light">
                Video e fotografia dalla community
            </p>
        </div>

        {{-- Scroll Arrow --}}
        <div class="absolute bottom-12 left-1/2 -translate-x-1/2 animate-bounce">
            <svg class="w-8 h-8 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
    </section>

    {{-- VIDEO MASONRY LAYOUT --}}
    <section class="relative py-20 bg-white dark:bg-neutral-900">
        <div class="max-w-[1800px] mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header con Toggle Floating --}}
            <div class="flex items-center justify-between mb-16">
                <div class="flex items-baseline gap-6">
                    <h2 class="text-6xl md:text-7xl font-black text-neutral-900 dark:text-white" style="font-family: 'Crimson Pro', serif;">
                        Video
                    </h2>
                    <div class="text-primary-600 dark:text-primary-400 text-4xl font-black">
                        {{ $videoType === 'popular' ? ($popularVideos->count() + 1) : ($recentVideos->count() + 1) }}
                    </div>
                </div>

                {{-- Minimal Toggle --}}
                <div class="flex items-center gap-1 bg-neutral-100 dark:bg-neutral-800 p-1 rounded-full">
                    <button wire:click="toggleVideoType('popular')"
                            class="px-3 md:px-6 py-2 md:py-3 rounded-full font-black text-xs md:text-sm transition-all {{ $videoType === 'popular' ? 'bg-primary-600 text-white shadow-lg' : 'text-neutral-600 dark:text-neutral-400' }}">
                        POPOLARI
                    </button>
                    <button wire:click="toggleVideoType('recent')"
                            class="px-3 md:px-6 py-2 md:py-3 rounded-full font-black text-xs md:text-sm transition-all {{ $videoType === 'recent' ? 'bg-accent-600 text-white shadow-lg' : 'text-neutral-600 dark:text-neutral-400' }}">
                        RECENTI
                    </button>
                </div>
            </div>

            {{-- Masonry Grid Videos --}}
            @if($mostPopularVideo)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 auto-rows-auto">
                    
                    {{-- Video Hero (span 2 cols + 2 rows) --}}
                    <div class="md:col-span-2 md:row-span-2 group cursor-pointer relative overflow-hidden bg-neutral-900"
                         onclick="Livewire.dispatch('openVideoModal', { videoId: {{ $mostPopularVideo->id }} })"
                         x-data="{ visible: false }" 
                         x-intersect.once="visible = true">
                        <div x-show="visible"
                             x-transition:enter="transition ease-out duration-1000"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="h-full relative">
                            
                            <img src="{{ $mostPopularVideo->thumbnail_url }}" 
                                 onerror="this.src='https://images.unsplash.com/photo-1574375927938-d5a98e8ffe85?w=1200&q=80'"
                                 class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000">
                            <div class="absolute inset-0 bg-gradient-to-tr from-black/90 via-black/40 to-transparent"></div>

                            {{-- Play Overlay --}}
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="transform group-hover:scale-110 transition-all duration-500">
                                    <div class="w-28 h-28 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30">
                                        <svg class="w-14 h-14 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="absolute bottom-0 left-0 right-0 p-10">
                                <div class="inline-block px-4 py-1.5 bg-primary-600 rounded-full mb-4">
                                    <span class="text-white text-xs font-black tracking-wider">IN EVIDENZA</span>
                                </div>
                                <h3 class="text-4xl md:text-5xl font-black text-white mb-4 leading-tight" style="font-family: 'Crimson Pro', serif;">
                                    {{ $mostPopularVideo->title }}
                                </h3>
                                @if($mostPopularVideo->user)
                                    <div class="flex items-center gap-3">
                                        <x-ui.user-avatar :user="$mostPopularVideo->user" size="md" :showName="false" />
                                        <div>
                                            <div class="text-white font-bold">{{ $mostPopularVideo->user->name }}</div>
                                            <div class="text-white/70 text-sm flex items-center gap-2">
                                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                <span>{{ number_format($mostPopularVideo->view_count ?? 0) }} {{ __('media.views') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Video Grid (6 video) --}}
                    @php $videos = $videoType === 'popular' ? $popularVideos : $recentVideos; @endphp
                    @foreach($videos->take(6) as $index => $video)
                        <div class="group cursor-pointer relative overflow-hidden bg-neutral-900"
                             onclick="Livewire.dispatch('openVideoModal', { videoId: {{ $video->id }} })"
                             x-data="{ visible: false }" 
                             x-intersect.once="visible = true">
                            <div x-show="visible"
                                 x-transition:enter="transition ease-out duration-700"
                                 x-transition:enter-start="opacity-0 translate-y-8"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 style="transition-delay: {{ $index * 100 }}ms"
                                 class="aspect-[4/3] relative">
                                
                                <img src="{{ $video->thumbnail_url }}" 
                                     onerror="this.src='https://images.unsplash.com/photo-1574375927938-d5a98e8ffe85?w=800&q=80'"
                                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                <div class="absolute inset-0 bg-black/50 group-hover:bg-black/30 transition-colors"></div>

                                {{-- Play Icon Small --}}
                                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                                    <svg class="w-12 h-12 text-white group-hover:scale-125 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                </div>

                                {{-- Title Bottom --}}
                                <div class="absolute bottom-0 left-0 right-0 p-5 bg-gradient-to-t from-black/90 to-transparent">
                                    <h4 class="text-white font-black text-lg line-clamp-2 mb-2">
                                        {{ $video->title }}
                                    </h4>
                                    @if($video->user)
                                        <div class="flex items-center gap-2 mb-2">
                                            <x-ui.user-avatar :user="$video->user" size="xs" :showName="false" />
                                            <span class="text-white/90 text-sm font-medium">{{ $video->user->name }}</span>
                                        </div>
                                    @endif
                                    <div class="flex items-center gap-2 text-white/70 text-sm">
                                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <span>{{ number_format($video->view_count ?? 0) }} {{ __('media.views') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- PHOTO SECTION - Alternated Layout --}}
    <section class="relative py-20 bg-gradient-to-br from-neutral-50 via-primary-50/20 to-accent-50/20 dark:from-neutral-800 dark:via-neutral-900 dark:to-neutral-900">
        <div class="max-w-[1800px] mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header --}}
            <div class="flex items-center justify-between mb-16">
                <div class="flex items-baseline gap-6">
                    <h2 class="text-6xl md:text-7xl font-black text-neutral-900 dark:text-white" style="font-family: 'Crimson Pro', serif;">
                        Foto
                    </h2>
                    <div class="text-accent-600 dark:text-accent-400 text-4xl font-black">
                        {{ $photoType === 'popular' ? ($popularPhotos->count() + 1) : ($recentPhotos->count() + 1) }}
                    </div>
                </div>

                {{-- Toggle --}}
                <div class="flex items-center gap-1 bg-white dark:bg-neutral-800 p-1 rounded-full shadow-xl">
                    <button wire:click="togglePhotoType('popular')"
                            class="px-3 md:px-6 py-2 md:py-3 rounded-full font-black text-xs md:text-sm transition-all {{ $photoType === 'popular' ? 'bg-accent-600 text-white shadow-lg' : 'text-neutral-600 dark:text-neutral-400' }}">
                        POPOLARI
                    </button>
                    <button wire:click="togglePhotoType('recent')"
                            class="px-3 md:px-6 py-2 md:py-3 rounded-full font-black text-xs md:text-sm transition-all {{ $photoType === 'recent' ? 'bg-primary-600 text-white shadow-lg' : 'text-neutral-600 dark:text-neutral-400' }}">
                        RECENTI
                    </button>
                </div>
            </div>

            {{-- Photo Masonry --}}
            @if($mostPopularPhoto)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 auto-rows-auto">
                    
                    {{-- Foto Hero (span 2 cols + 2 rows) --}}
                    <div class="md:col-span-2 md:row-span-2 group cursor-pointer relative overflow-hidden bg-neutral-100 dark:bg-neutral-800"
                         onclick="Livewire.dispatch('openPhotoModal', { photoId: {{ $mostPopularPhoto->id }} })"
                         x-data="{ visible: false }" 
                         x-intersect.once="visible = true">
                        <div x-show="visible"
                             x-transition:enter="transition ease-out duration-1000"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="h-full relative">
                            
                            <img src="{{ $mostPopularPhoto->image_url }}" 
                                 onerror="this.src='https://images.unsplash.com/photo-1452587925148-ce544e77e70d?w=1200&q=80'"
                                 class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000">
                            <div class="absolute inset-0 bg-gradient-to-tl from-black/90 via-black/40 to-transparent"></div>

                            {{-- Zoom Overlay --}}
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                <div class="w-28 h-28 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30">
                                    <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/>
                                    </svg>
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="absolute bottom-0 left-0 right-0 p-10">
                                <div class="inline-block px-4 py-1.5 bg-accent-600 rounded-full mb-4">
                                    <span class="text-white text-xs font-black tracking-wider">{{ __('media.featured') }}</span>
                                </div>
                                <h3 class="text-4xl md:text-5xl font-black text-white mb-4 leading-tight" style="font-family: 'Crimson Pro', serif;">
                                    {{ $mostPopularPhoto->title ?? __('media.untitled') }}
                                </h3>
                                @if($mostPopularPhoto->user)
                                    <div class="flex items-center gap-3">
                                        <x-ui.user-avatar :user="$mostPopularPhoto->user" size="md" :showName="false" />
                                        <div>
                                            <div class="text-white font-bold">{{ $mostPopularPhoto->user->name }}</div>
                                            <div class="text-white/70 text-sm flex items-center gap-2">
                                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                <span>{{ number_format($mostPopularPhoto->view_count ?? 0) }} {{ __('media.views') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Foto Grid --}}
                    @php $photos = $photoType === 'popular' ? $popularPhotos : $recentPhotos; @endphp
                    @foreach($photos->take(6) as $index => $photo)
                        <div class="group cursor-pointer relative overflow-hidden bg-neutral-100 dark:bg-neutral-800"
                             onclick="Livewire.dispatch('openPhotoModal', { photoId: {{ $photo->id }} })"
                             x-data="{ visible: false }" 
                             x-intersect.once="visible = true">
                            <div x-show="visible"
                                 x-transition:enter="transition ease-out duration-700"
                                 x-transition:enter-start="opacity-0 translate-y-8"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 style="transition-delay: {{ $index * 100 }}ms"
                                 class="aspect-square relative">
                                
                                <img src="{{ $photo->image_url }}" 
                                     onerror="this.src='https://images.unsplash.com/photo-1452587925148-ce544e77e70d?w=800&q=80'"
                                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                <div class="absolute inset-0 bg-black/40 group-hover:bg-black/20 transition-colors"></div>

                                {{-- Zoom Icon --}}
                                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>

                                {{-- Title Bottom --}}
                                <div class="absolute bottom-0 left-0 right-0 p-5 bg-gradient-to-t from-black/90 to-transparent">
                                    <h4 class="text-white font-black text-lg line-clamp-2 mb-2">
                                        {{ $photo->title ?? __('media.untitled') }}
                                    </h4>
                                    @if($photo->user)
                                        <div class="flex items-center gap-2 mb-2">
                                            <x-ui.user-avatar :user="$photo->user" size="xs" :showName="false" />
                                            <span class="text-white/90 text-sm font-medium">{{ $photo->user->name }}</span>
                                        </div>
                                    @endif
                                    <div class="flex items-center gap-2 text-white/70 text-sm">
                                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <span>{{ number_format($photo->view_count ?? 0) }} {{ __('media.views') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- SEARCH SECTION - Full Width Dark --}}
    <section class="relative py-20 bg-neutral-900 dark:bg-black">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle, #10b981 1px, transparent 1px); background-size: 40px 40px;"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            
            {{-- Header --}}
            <div class="text-center mb-12">
                <h2 class="text-6xl md:text-7xl font-black text-white mb-4" style="font-family: 'Crimson Pro', serif;">
                    Ricerca
                </h2>
                <p class="text-white/60 text-xl">Trova ciò che cerchi</p>
            </div>

            {{-- Search Bar Prominent --}}
            <div class="max-w-4xl mx-auto mb-12">
                <div class="relative">
                    <input type="text"
                           wire:model.live.debounce.300ms="searchQuery"
                           placeholder="{{ __('media.search_placeholder') }}"
                           class="w-full px-8 py-6 pl-16 bg-white/10 backdrop-blur-lg border-2 border-white/20 text-white placeholder:text-white/40 rounded-2xl
                                  focus:border-primary-500 focus:bg-white/15 transition-all text-xl font-bold">
                    <svg class="absolute left-6 top-1/2 -translate-y-1/2 w-6 h-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>

            {{-- Advanced Filters --}}
            <div class="grid md:grid-cols-5 gap-4 mb-16 max-w-5xl mx-auto">
                <div class="relative">
                    <select wire:model.live="mediaType"
                            class="w-full px-5 py-4 bg-white/5 border border-white/10 text-white appearance-none rounded-xl font-bold
                                   focus:border-primary-500 transition-all">
                        <option value="" class="bg-neutral-900">Tutti i Media</option>
                        <option value="video" class="bg-neutral-900">Solo Video</option>
                        <option value="photo" class="bg-neutral-900">Solo Foto</option>
                    </select>
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 text-white/50 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>

                <input type="text"
                       wire:model.live.debounce.300ms="userId"
                       placeholder="Utente..."
                       class="px-5 py-4 bg-white/5 border border-white/10 text-white placeholder:text-white/30 rounded-xl font-bold
                              focus:border-primary-500 transition-all">

                <input type="date"
                       wire:model.live="dateFrom"
                       class="px-5 py-4 bg-white/5 border border-white/10 text-white rounded-xl font-bold
                              focus:border-primary-500 transition-all">

                <input type="date"
                       wire:model.live="dateTo"
                       class="px-5 py-4 bg-white/5 border border-white/10 text-white rounded-xl font-bold
                              focus:border-primary-500 transition-all">

                <button wire:click="clearSearch"
                        class="px-5 py-4 bg-white/10 hover:bg-white/20 border border-white/20 text-white font-black rounded-xl transform hover:scale-105 transition-all">
                    <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Results --}}
            @if($hasActiveSearch && $searchResults['total'] > 0)
                <div class="mb-12 flex items-center justify-center gap-4">
                    <div class="h-px w-32 bg-gradient-to-r from-transparent to-primary-600"></div>
                    <div class="px-6 py-3 bg-primary-600 rounded-full">
                        <span class="text-white font-black text-xl">{{ $searchResults['total'] }} RISULTATI</span>
                    </div>
                    <div class="h-px w-32 bg-gradient-to-l from-transparent to-primary-600"></div>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($searchResults['videos'] as $video)
                        <div class="group cursor-pointer relative overflow-hidden" 
                             onclick="Livewire.dispatch('openVideoModal', { videoId: {{ $video->id }} })">
                            <div class="aspect-[3/4] relative bg-neutral-800">
                                <img src="{{ $video->thumbnail_url }}" 
                                     onerror="this.src='https://images.unsplash.com/photo-1574375927938-d5a98e8ffe85?w=800&q=80'"
                                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 to-transparent"></div>
                                
                                <div class="absolute top-4 right-4">
                                    <span class="px-3 py-1.5 bg-primary-600 text-white text-xs font-black rounded-full">VIDEO</span>
                                </div>
                                
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-white/80 group-hover:scale-125 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                </div>

                                <div class="absolute bottom-0 left-0 right-0 p-5">
                                    <h4 class="text-xl font-black text-white mb-2 line-clamp-2">{{ $video->title }}</h4>
                                    @if($video->user)
                                        <div class="text-white/80 text-sm font-medium">{{ $video->user->name }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @foreach($searchResults['photos'] as $photo)
                        <div class="group cursor-pointer relative overflow-hidden" 
                             onclick="Livewire.dispatch('openPhotoModal', { photoId: {{ $photo->id }} })">
                            <div class="aspect-[3/4] relative bg-neutral-800">
                                <img src="{{ $photo->image_url }}" 
                                     onerror="this.src='https://images.unsplash.com/photo-1452587925148-ce544e77e70d?w=800&q=80'"
                                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 to-transparent"></div>
                                
                                <div class="absolute top-4 right-4">
                                    <span class="px-3 py-1.5 bg-accent-600 text-white text-xs font-black rounded-full">FOTO</span>
                                </div>
                                
                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <svg class="w-16 h-16 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>

                                <div class="absolute bottom-0 left-0 right-0 p-5">
                                    <h4 class="text-xl font-black text-white mb-2 line-clamp-2">{{ $photo->title ?? __('media.untitled') }}</h4>
                                    @if($photo->user)
                                        <div class="text-white/80 text-sm font-medium">{{ $photo->user->name }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @elseif($hasActiveSearch)
                <div class="text-center py-20">
                    <div class="w-32 h-32 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-16 h-16 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <p class="text-3xl text-white/70 font-black mb-2">Nessun risultato</p>
                    <p class="text-white/50">Prova con altri filtri</p>
                </div>
            @endif
        </div>
    </section>

    {{-- Modals --}}
    <livewire:media.video-modal />
    <livewire:media.photo-modal />

    @push('styles')
    <style>
        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -30px) scale(1.05); }
            66% { transform: translate(-20px, 20px) scale(0.95); }
        }
        
        .animate-blob { animation: blob 8s ease-in-out infinite; }
        .animate-blob-slow { animation: blob 12s ease-in-out infinite; }
    </style>
    @endpush
</div>
