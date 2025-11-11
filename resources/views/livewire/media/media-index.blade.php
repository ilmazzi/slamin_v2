<div class="min-h-screen">
    
    {{-- HERO con Film Strip Orizzontale --}}
    <section class="relative overflow-hidden film-studio-section">
        
        <!-- FILM STRIP ORIZZONTALE - Attraversa tutto -->
        <div class="film-strip-horizontal">
            <!-- Perforations Top -->
            <div class="film-perforation-horizontal film-perforation-top">
                @for($h = 0; $h < 40; $h++)
                <div class="perforation-hole-horizontal"></div>
                @endfor
            </div>
            
            <!-- Perforations Bottom -->
            <div class="film-perforation-horizontal film-perforation-bottom">
                @for($h = 0; $h < 40; $h++)
                <div class="perforation-hole-horizontal"></div>
                @endfor
            </div>
            
            <!-- Edge Codes Left -->
            <div class="film-edge-code-left">SLAMIN</div>
            
            <!-- Edge Codes Right -->
            <div class="film-edge-code-right">MEDIA</div>
            
            <!-- Content Centered -->
            <div class="film-strip-horizontal-content">
                <div class="film-frame-number-horizontal film-frame-number-horizontal-l">///01</div>
                <div class="film-frame-number-horizontal film-frame-number-horizontal-r">01A</div>
                
                <h1 class="text-5xl md:text-7xl font-black text-white text-center" style="font-family: 'Crimson Pro', serif;">
                    Video & <span class="italic text-primary-400">Foto</span>
                </h1>
                <p class="text-xl text-white/80 text-center mt-4 font-medium">
                    Dalla community Slamin
                </p>
            </div>
        </div>
    </section>

    {{-- VIDEO MASONRY LAYOUT --}}
    <section class="relative py-20 bg-white dark:bg-neutral-900">
        <div class="max-w-[1800px] mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header con Toggle Floating --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-16">
                <div class="flex items-baseline gap-4">
                    <h2 class="text-5xl md:text-7xl font-black text-neutral-900 dark:text-white" style="font-family: 'Crimson Pro', serif;">
                        Video
                    </h2>
                    <div class="text-primary-600 dark:text-primary-400 text-3xl md:text-4xl font-black">
                        {{ $videoType === 'popular' ? ($popularVideos->count() + 1) : ($recentVideos->count() + 1) }}
                    </div>
                </div>

                {{-- Minimal Toggle --}}
                <div class="flex items-center gap-1 bg-neutral-100 dark:bg-neutral-800 p-1 rounded-full self-start md:self-auto">
                    <button wire:click="toggleVideoType('popular')"
                            class="px-4 md:px-6 py-2 md:py-3 rounded-full font-black text-xs md:text-sm transition-all {{ $videoType === 'popular' ? 'bg-primary-600 text-white shadow-lg' : 'text-neutral-600 dark:text-neutral-400' }}">
                        POPOLARI
                    </button>
                    <button wire:click="toggleVideoType('recent')"
                            class="px-4 md:px-6 py-2 md:py-3 rounded-full font-black text-xs md:text-sm transition-all {{ $videoType === 'recent' ? 'bg-accent-600 text-white shadow-lg' : 'text-neutral-600 dark:text-neutral-400' }}">
                        RECENTI
                    </button>
                </div>
            </div>

            {{-- Masonry Grid Videos --}}
            @if($mostPopularVideo)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 auto-rows-auto">
                    
                    {{-- Video Hero (span 2 cols + 2 rows) - Film Strip Style --}}
                    <div class="md:col-span-2 md:row-span-2 group cursor-pointer"
                         onclick="Livewire.dispatch('openVideoModal', { videoId: {{ $mostPopularVideo->id }} })"
                         x-data="{ visible: false }" 
                         x-intersect.once="visible = true">
                        <div x-show="visible"
                             x-transition:enter="transition ease-out duration-1000"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="h-full">
                            
                            <div class="film-strip-container-hero">
                                <!-- Film Perforations -->
                                <div class="film-perforation film-perforation-left">
                                    @for($h = 0; $h < 16; $h++)
                                    <div class="perforation-hole"></div>
                                    @endfor
                                </div>
                                
                                <div class="film-perforation film-perforation-right">
                                    @for($h = 0; $h < 16; $h++)
                                    <div class="perforation-hole"></div>
                                    @endfor
                                </div>
                                
                                <!-- Film Edge Codes -->
                                <div class="film-edge-code-top">SLAMIN</div>
                                <div class="film-edge-code-bottom">HERO</div>
                                
                                <!-- Film Frame -->
                                <div class="film-frame-hero">
                                    <div class="film-frame-number film-frame-number-tl">///HE</div>
                                    <div class="film-frame-number film-frame-number-tr">ROA</div>
                                    
                                    <div class="relative aspect-video overflow-hidden bg-black">
                                        <img src="{{ $mostPopularVideo->thumbnail_url }}" 
                                             onerror="this.src='https://images.unsplash.com/photo-1574375927938-d5a98e8ffe85?w=1200&q=80'"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                        <div class="absolute inset-0 bg-gradient-to-tr from-black/70 via-black/30 to-transparent"></div>

                                        {{-- Play Button --}}
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <div class="w-20 h-20 bg-white/95 backdrop-blur-sm rounded-full flex items-center justify-center shadow-2xl group-hover:scale-110 transition-all">
                                                <svg class="w-10 h-10 text-primary-600 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M8 5v14l11-7z"/>
                                                </svg>
                                            </div>
                                        </div>

                                        {{-- Content Overlay --}}
                                        <div class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-black/90 to-transparent">
                                            <div class="inline-block px-3 py-1 bg-primary-600 rounded-full mb-3">
                                                <span class="text-white text-xs font-bold tracking-wider">IN EVIDENZA</span>
                                            </div>
                                            <h3 class="text-2xl md:text-3xl font-bold text-white mb-3 line-clamp-2" style="font-family: 'Crimson Pro', serif;">
                                                {{ $mostPopularVideo->title }}
                                            </h3>
                                            @if($mostPopularVideo->user)
                                                <div class="flex items-center gap-2">
                                                    <img src="{{ $mostPopularVideo->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($mostPopularVideo->user->name) . '&background=059669&color=fff' }}" 
                                                         alt="{{ $mostPopularVideo->user->name }}"
                                                         class="w-8 h-8 rounded-full object-cover ring-2 ring-white/30">
                                                    <span class="text-white font-semibold">{{ $mostPopularVideo->user->name }}</span>
                                                    <span class="text-white/70 text-sm ml-2">{{ number_format($mostPopularVideo->view_count ?? 0) }} views</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Video Grid (6 video) - Film Strip Style --}}
                    @php $videos = $videoType === 'popular' ? $popularVideos : $recentVideos; @endphp
                    @foreach($videos->take(6) as $index => $video)
                        <?php $tilt = rand(-2, 2); ?>
                        <div class="group cursor-pointer"
                             onclick="Livewire.dispatch('openVideoModal', { videoId: {{ $video->id }} })"
                             x-data="{ visible: false }" 
                             x-intersect.once="visible = true">
                            <div x-show="visible"
                                 x-transition:enter="transition ease-out duration-700"
                                 x-transition:enter-start="opacity-0 translate-y-8"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 style="transition-delay: {{ $index * 100 }}ms">
                                
                                <div class="film-strip-container-grid" style="transform: rotate({{ $tilt }}deg);">
                                    <!-- Perforations -->
                                    <div class="film-perforation-small film-perforation-left">
                                        @for($h = 0; $h < 10; $h++)
                                        <div class="perforation-hole-small"></div>
                                        @endfor
                                    </div>
                                    
                                    <div class="film-perforation-small film-perforation-right">
                                        @for($h = 0; $h < 10; $h++)
                                        <div class="perforation-hole-small"></div>
                                        @endfor
                                    </div>
                                    
                                    <div class="film-edge-code-small-top">{{ str_pad($index + 2, 2, '0', STR_PAD_LEFT) }}</div>
                                    
                                    <div class="film-frame-grid">
                                        <div class="relative aspect-[4/3] overflow-hidden bg-black">
                                            <img src="{{ $video->thumbnail_url }}" 
                                                 onerror="this.src='https://images.unsplash.com/photo-1574375927938-d5a98e8ffe85?w=800&q=80'"
                                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                            <div class="absolute inset-0 bg-black/40 group-hover:bg-black/20 transition-colors"></div>

                                            {{-- Play Icon --}}
                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <svg class="w-12 h-12 text-white group-hover:scale-125 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M8 5v14l11-7z"/>
                                                </svg>
                                            </div>

                                            {{-- Title --}}
                                            <div class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black/90 to-transparent">
                                                <h4 class="text-white font-bold text-sm md:text-base line-clamp-2 mb-1">
                                                    {{ $video->title }}
                                                </h4>
                                                @if($video->user)
                                                    <div class="flex items-center gap-2">
                                                        <span class="text-white/80 text-xs">{{ $video->user->name }}</span>
                                                        <span class="text-white/60 text-xs">• {{ number_format($video->view_count ?? 0) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
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
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-16">
                <div class="flex items-baseline gap-4">
                    <h2 class="text-5xl md:text-7xl font-black text-neutral-900 dark:text-white" style="font-family: 'Crimson Pro', serif;">
                        Foto
                    </h2>
                    <div class="text-accent-600 dark:text-accent-400 text-3xl md:text-4xl font-black">
                        {{ $photoType === 'popular' ? ($popularPhotos->count() + 1) : ($recentPhotos->count() + 1) }}
                    </div>
                </div>

                {{-- Toggle --}}
                <div class="flex items-center gap-1 bg-white dark:bg-neutral-800 p-1 rounded-full shadow-xl self-start md:self-auto">
                    <button wire:click="togglePhotoType('popular')"
                            class="px-4 md:px-6 py-2 md:py-3 rounded-full font-black text-xs md:text-sm transition-all {{ $photoType === 'popular' ? 'bg-accent-600 text-white shadow-lg' : 'text-neutral-600 dark:text-neutral-400' }}">
                        POPOLARI
                    </button>
                    <button wire:click="togglePhotoType('recent')"
                            class="px-4 md:px-6 py-2 md:py-3 rounded-full font-black text-xs md:text-sm transition-all {{ $photoType === 'recent' ? 'bg-primary-600 text-white shadow-lg' : 'text-neutral-600 dark:text-neutral-400' }}">
                        RECENTI
                    </button>
                </div>
            </div>

            {{-- Photo Masonry --}}
            @if($mostPopularPhoto)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 auto-rows-auto">
                    
                    {{-- Foto Hero (span 2 cols + 2 rows) - Polaroid Style --}}
                    <?php 
                        $heroRotation = rand(-2, 2);
                        $heroTapeWidth = rand(80, 120);
                        $heroTapeRotation = rand(-8, 8);
                    ?>
                    <div class="md:col-span-2 md:row-span-2 group cursor-pointer"
                         onclick="Livewire.dispatch('openPhotoModal', { photoId: {{ $mostPopularPhoto->id }} })"
                         x-data="{ visible: false }" 
                         x-intersect.once="visible = true">
                        <div x-show="visible"
                             x-transition:enter="transition ease-out duration-1000"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="h-full flex items-center justify-center">
                            
                            <div class="polaroid-wrapper-hero">
                                <!-- Washi Tape bianco trasparente -->
                                <div class="polaroid-tape-white-hero" 
                                     style="width: {{ $heroTapeWidth }}px; 
                                            transform: translateX(-50%) rotate({{ $heroTapeRotation }}deg);"></div>
                                
                                <div class="polaroid-card-hero" style="transform: rotate({{ $heroRotation }}deg);">
                                    <div class="polaroid-photo-hero">
                                        <img src="{{ $mostPopularPhoto->image_url }}" 
                                             onerror="this.src='https://images.unsplash.com/photo-1452587925148-ce544e77e70d?w=1200&q=80'"
                                             class="polaroid-img-hero">
                                    </div>
                                    
                                    <div class="polaroid-caption-hero">
                                        <div class="inline-block px-3 py-1 bg-accent-600 rounded-full mb-2">
                                            <span class="text-white text-xs font-bold tracking-wider">IN EVIDENZA</span>
                                        </div>
                                        <div class="text-lg md:text-xl font-bold text-neutral-900 line-clamp-2 mb-2" style="font-family: 'Crimson Pro', serif;">
                                            {{ $mostPopularPhoto->title ?? __('media.untitled') }}
                                        </div>
                                        @if($mostPopularPhoto->user)
                                            <div class="text-sm text-neutral-600 mb-2">{{ $mostPopularPhoto->user->name }}</div>
                                            <div class="text-xs text-neutral-500">{{ number_format($mostPopularPhoto->view_count ?? 0) }} views</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Foto Grid - Polaroid Style --}}
                    @php $photos = $photoType === 'popular' ? $popularPhotos : $recentPhotos; @endphp
                    @foreach($photos->take(6) as $index => $photo)
                        <?php 
                            $rotation = rand(-3, 3);
                            $tapeWidth = rand(60, 90);
                            $tapeRotation = rand(-8, 8);
                        ?>
                        <div class="group cursor-pointer"
                             onclick="Livewire.dispatch('openPhotoModal', { photoId: {{ $photo->id }} })"
                             x-data="{ visible: false }" 
                             x-intersect.once="visible = true">
                            <div x-show="visible"
                                 x-transition:enter="transition ease-out duration-700"
                                 x-transition:enter-start="opacity-0 translate-y-8"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 style="transition-delay: {{ $index * 100 }}ms">
                                
                                <div class="polaroid-wrapper-grid">
                                    <!-- Washi Tape bianco -->
                                    <div class="polaroid-tape-white-grid" 
                                         style="width: {{ $tapeWidth }}px; 
                                                transform: translateX(-50%) rotate({{ $tapeRotation }}deg);"></div>
                                    
                                    <div class="polaroid-card-grid" style="transform: rotate({{ $rotation }}deg);">
                                        <div class="polaroid-photo-grid">
                                            <img src="{{ $photo->image_url }}" 
                                                 onerror="this.src='https://images.unsplash.com/photo-1452587925148-ce544e77e70d?w=800&q=80'"
                                                 class="polaroid-img-grid">
                                        </div>
                                        
                                        <div class="polaroid-caption-grid">
                                            <div class="text-base font-bold text-neutral-900 line-clamp-2 mb-1" style="font-family: 'Crimson Pro', serif;">
                                                {{ $photo->title ?? __('media.untitled') }}
                                            </div>
                                            @if($photo->user)
                                                <div class="text-xs text-neutral-600 mb-1">{{ $photo->user->name }}</div>
                                                <div class="text-xs text-neutral-500">{{ number_format($photo->view_count ?? 0) }} views</div>
                                            @endif
                                        </div>
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
        /* ========================================
           FILM STRIP ORIZZONTALE - FULL WIDTH
           ======================================== */
        
        .film-strip-horizontal {
            position: relative;
            width: 100%;
            padding: 4rem 2rem;
            min-height: 300px;
            /* Film marrone lucido */
            background: 
                /* Glossy highlight */
                linear-gradient(to bottom, 
                    rgba(255, 255, 255, 0.15) 0%,
                    transparent 20%,
                    transparent 80%,
                    rgba(0, 0, 0, 0.2) 100%
                ),
                /* Diagonal light streak */
                linear-gradient(135deg, 
                    transparent 0%,
                    transparent 45%,
                    rgba(255, 255, 255, 0.1) 50%,
                    transparent 55%,
                    transparent 100%
                ),
                /* Film base */
                linear-gradient(to bottom, 
                    rgba(120, 80, 50, 0.85) 0%,
                    rgba(100, 65, 40, 0.88) 50%,
                    rgba(120, 80, 50, 0.85) 100%
                );
            box-shadow: 
                0 10px 40px rgba(0, 0, 0, 0.4),
                inset 0 2px 4px rgba(255, 255, 255, 0.1),
                inset 0 -2px 4px rgba(0, 0, 0, 0.2);
        }
        
        /* Perforazioni ORIZZONTALI (top e bottom) */
        .film-perforation-horizontal {
            position: absolute;
            left: 0;
            right: 0;
            height: 3rem;
            display: flex;
            flex-direction: row;
            justify-content: space-evenly;
            align-items: center;
            padding: 0 1rem;
            /* Brown strip matching film */
            background: 
                linear-gradient(to bottom, 
                    rgba(255, 255, 255, 0.12) 0%,
                    transparent 50%
                ),
                linear-gradient(to bottom, 
                    rgba(80, 55, 35, 0.95) 0%,
                    rgba(70, 48, 30, 0.97) 50%,
                    rgba(80, 55, 35, 0.95) 100%
                );
        }
        
        .film-perforation-top {
            top: 0;
        }
        
        .film-perforation-bottom {
            bottom: 0;
        }
        
        .perforation-hole-horizontal {
            width: 18px;
            height: 22px;
            background: #f0ebe8;
            border-radius: 2px;
            flex-shrink: 0;
            box-shadow: 
                inset 0 3px 6px rgba(0, 0, 0, 0.3),
                inset 0 -1px 2px rgba(0, 0, 0, 0.2),
                inset 2px 0 4px rgba(0, 0, 0, 0.15),
                inset -2px 0 4px rgba(0, 0, 0, 0.15);
        }
        
        .dark .perforation-hole-horizontal {
            background: #1a1a1a;
        }
        
        /* Edge Codes LATERALI */
        .film-edge-code-left,
        .film-edge-code-right {
            position: absolute;
            top: 50%;
            transform: translateY(-50%) rotate(-90deg);
            color: rgba(255, 255, 255, 0.35);
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.4em;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
            z-index: 3;
        }
        
        .film-edge-code-left {
            left: 1.5rem;
        }
        
        .film-edge-code-right {
            right: 1.5rem;
        }
        
        /* Content centrale */
        .film-strip-horizontal-content {
            position: relative;
            z-index: 2;
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .film-frame-number-horizontal {
            position: absolute;
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.85rem;
            font-weight: 700;
            font-family: 'Courier New', monospace;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
            z-index: 3;
        }
        
        .film-frame-number-horizontal-l {
            top: 50%;
            left: 5rem;
            transform: translateY(-50%);
        }
        
        .film-frame-number-horizontal-r {
            top: 50%;
            right: 5rem;
            transform: translateY(-50%);
        }
        
        /* ========================================
           FILM STRIP - VIDEO CARDS
           ======================================== */
        
        .film-strip-container-hero,
        .film-strip-container-grid {
            position: relative;
            background: 
                linear-gradient(180deg, rgba(255, 255, 255, 0.15) 0%, transparent 15%, transparent 85%, rgba(0, 0, 0, 0.2) 100%),
                linear-gradient(120deg, transparent 0%, transparent 40%, rgba(255, 255, 255, 0.08) 48%, rgba(255, 255, 255, 0.12) 50%, rgba(255, 255, 255, 0.08) 52%, transparent 60%, transparent 100%),
                linear-gradient(135deg, rgba(120, 80, 50, 0.85) 0%, rgba(100, 65, 40, 0.88) 25%, rgba(110, 72, 45, 0.86) 50%, rgba(95, 60, 38, 0.89) 75%, rgba(115, 75, 48, 0.87) 100%);
            border-radius: 6px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }
        
        .film-strip-container-hero {
            padding: 2.5rem 3.5rem;
        }
        
        .film-strip-container-grid {
            padding: 2rem 3rem;
        }
        
        .film-perforation-small {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 2rem;
            background: transparent;
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
            align-items: center;
            padding: 0.75rem 0;
        }
        
        .perforation-hole-small {
            width: 16px;
            height: 14px;
            background: #e8e5dc;
            border-radius: 2px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .dark .perforation-hole-small {
            background: #1a1a1a;
        }
        
        .film-edge-code-small-top {
            position: absolute;
            top: 0.5rem;
            left: 50%;
            transform: translateX(-50%);
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.6rem;
            font-weight: 700;
            letter-spacing: 0.2em;
        }
        
        .film-perforation {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
            align-items: center;
            padding: 1rem 0;
            background: 
                linear-gradient(90deg, rgba(255, 255, 255, 0.12) 0%, transparent 30%),
                linear-gradient(180deg, rgba(80, 55, 35, 0.95) 0%, rgba(70, 48, 30, 0.97) 50%, rgba(80, 55, 35, 0.95) 100%);
        }
        
        .film-perforation-left {
            left: 0;
        }
        
        .film-perforation-right {
            right: 0;
        }
        
        .perforation-hole {
            width: 22px;
            height: 18px;
            background: #f0ebe8;
            border-radius: 2px;
            flex-shrink: 0;
            box-shadow: 
                inset 0 3px 6px rgba(0, 0, 0, 0.3),
                inset 0 -1px 2px rgba(0, 0, 0, 0.2),
                inset 2px 0 4px rgba(0, 0, 0, 0.15),
                inset -2px 0 4px rgba(0, 0, 0, 0.15);
        }
        
        .dark .perforation-hole {
            background: #1a1a1a;
        }
        
        .film-edge-code-top,
        .film-edge-code-bottom {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            color: rgba(255, 255, 255, 0.35);
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.35em;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
            z-index: 3;
        }
        
        .film-edge-code-top {
            top: 0.5rem;
        }
        
        .film-edge-code-bottom {
            bottom: 0.5rem;
        }
        
        .film-frame-number {
            position: absolute;
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.75rem;
            font-weight: 700;
            font-family: 'Courier New', monospace;
            padding: 0.25rem 0.5rem;
            z-index: 3;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
        }
        
        .film-frame-number-tl {
            top: 1rem;
            left: 3.5rem;
        }
        
        .film-frame-number-tr {
            top: 1rem;
            right: 3.5rem;
        }
        
        .film-frame-hero,
        .film-frame-grid {
            position: relative;
            z-index: 2;
        }
        
        /* ========================================
           POLAROID - PHOTO CARDS
           ======================================== */
        
        .polaroid-wrapper-hero,
        .polaroid-wrapper-grid {
            position: relative;
            padding-top: 20px;
        }
        
        .polaroid-tape-white-hero,
        .polaroid-tape-white-grid {
            position: absolute;
            top: -8px;
            left: 50%;
            height: 30px;
            background: rgba(255, 255, 255, 0.35);
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            z-index: 10;
            transition: all 0.3s ease;
            clip-path: polygon(
                0% 0%, 2% 5%, 0% 10%, 2% 15%, 0% 20%, 2% 25%, 0% 30%, 2% 35%, 
                0% 40%, 2% 45%, 0% 50%, 2% 55%, 0% 60%, 2% 65%, 0% 70%, 2% 75%, 
                0% 80%, 2% 85%, 0% 90%, 2% 95%, 0% 100%,
                100% 100%,
                98% 95%, 100% 90%, 98% 85%, 100% 80%, 98% 75%, 100% 70%, 98% 65%, 
                100% 60%, 98% 55%, 100% 50%, 98% 45%, 100% 40%, 98% 35%, 100% 30%, 
                98% 25%, 100% 20%, 98% 15%, 100% 10%, 98% 5%, 100% 0%
            );
            backdrop-filter: blur(1px);
        }
        
        .polaroid-card-hero,
        .polaroid-card-grid {
            display: block;
            position: relative;
            background: #ffffff;
            box-shadow: 
                0 2px 4px rgba(0, 0, 0, 0.1),
                0 4px 8px rgba(0, 0, 0, 0.08),
                0 8px 16px rgba(0, 0, 0, 0.06),
                0 16px 32px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
            border-radius: 2px;
        }
        
        .polaroid-card-hero {
            padding: 25px 25px 100px 25px;
            max-width: 600px;
        }
        
        .polaroid-card-grid {
            padding: 16px 16px 70px 16px;
        }
        
        .dark .polaroid-card-hero,
        .dark .polaroid-card-grid {
            background: #fafafa;
        }
        
        .polaroid-photo-hero,
        .polaroid-photo-grid {
            position: relative;
            aspect-ratio: 1;
            overflow: hidden;
            background: #f5f5f5;
            border-radius: 1px;
            box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.1);
        }
        
        .polaroid-img-hero,
        .polaroid-img-grid {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: grayscale(100%);
            transition: all 0.5s ease;
        }
        
        .polaroid-card-hero:hover .polaroid-img-hero,
        .polaroid-card-grid:hover .polaroid-img-grid {
            filter: grayscale(0%);
            transform: scale(1.05);
        }
        
        .polaroid-caption-hero,
        .polaroid-caption-grid {
            text-align: center;
            padding-top: 1rem;
        }
        
        .polaroid-wrapper-hero:hover .polaroid-card-hero,
        .polaroid-wrapper-grid:hover .polaroid-card-grid {
            transform: translateY(-8px) scale(1.02) !important;
            box-shadow: 
                0 4px 8px rgba(0, 0, 0, 0.12),
                0 8px 16px rgba(0, 0, 0, 0.1),
                0 16px 32px rgba(0, 0, 0, 0.08),
                0 32px 64px rgba(0, 0, 0, 0.06);
        }
    </style>
    @endpush
</div>
