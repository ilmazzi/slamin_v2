<div class="min-h-screen">
    
    {{-- HERO con Film Card + Titolo --}}
    <section class="relative pt-16 pb-12 md:pb-20 overflow-hidden bg-neutral-900 dark:bg-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center gap-6 md:flex-row md:justify-center md:gap-12">
                
                <!-- FILM CARD (come homepage, ma più grande) -->
                <div class="media-page-film-card">
                    <!-- Film codes -->
                    <div class="media-page-film-code-top">SLAMIN</div>
                    <div class="media-page-film-code-bottom">ISO 400</div>
                    
                    <!-- Film frame -->
                    <div class="media-page-film-frame">
                        <!-- Perforations -->
                        <div class="media-page-film-perf-left">
                            @for($h = 0; $h < 10; $h++)
                            <div class="media-page-perf-hole"></div>
                            @endfor
                        </div>
                        
                        <div class="media-page-film-perf-right">
                            @for($h = 0; $h < 10; $h++)
                            <div class="media-page-perf-hole"></div>
                            @endfor
                        </div>
                        
                        <!-- Frame numbers -->
                        <div class="media-page-frame-number-tl">///01</div>
                        <div class="media-page-frame-number-tr">01A</div>
                        <div class="media-page-frame-number-bl">35MM</div>
                        <div class="media-page-frame-number-br">1</div>
                        
                        <!-- Thumbnail with random image -->
                        <div class="media-page-film-thumbnail" style="background: url('<?php echo [
                            'https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?w=600',
                            'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?w=600',
                            'https://images.unsplash.com/photo-1514320291840-2e0a9bf2a9ae?w=600',
                            'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?w=600'
                        ][rand(0, 3)]; ?>') center/cover;"></div>
                        
                        <!-- Media text overlay -->
                        <div class="media-page-film-text">
                            Media
                        </div>
                    </div>
                </div>
                
                <!-- TITOLO A FIANCO -->
                <div class="text-center md:text-left">
                    <h1 class="text-5xl md:text-7xl lg:text-8xl font-black text-white leading-tight" style="font-family: 'Crimson Pro', serif;">
                        Video & <span class="italic text-primary-400">Foto</span>
                    </h1>
                    <p class="text-xl md:text-2xl text-white/80 mt-4 font-medium">
                        Dalla community Slamin
                    </p>
                    
                    {{-- Upload Buttons --}}
                    @auth
                        <div class="flex flex-col sm:flex-row gap-3 mt-6 justify-center md:justify-start">
                            @can('upload.video')
                                <button type="button"
                                        wire:click="navigateToVideoUpload"
                                        class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-semibold shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                    <span>{{ __('media.upload_video') }}</span>
                                </button>
                            @endcan
                            
                            @can('upload.photo')
                                <a href="{{ route('media.upload.photo') }}" 
                                   class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-accent-600 hover:bg-accent-700 text-white font-semibold shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span>{{ __('media.upload_photo') }}</span>
                                </a>
                            @endcan
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    {{-- VIDEO MASONRY LAYOUT --}}
    <section class="relative py-12 md:py-16 film-studio-section">
        <div class="max-w-[1800px] mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header con Toggle Floating --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-10">
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

            {{-- Video Layout: Hero + 2 laterali + 3 sotto --}}
            @if($mostPopularVideo)
                @php $videos = $videoType === 'popular' ? $popularVideos : $recentVideos; @endphp
                
                {{-- Sezione Superiore: Hero + 2 Video Laterali --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
                    {{-- Video Hero (2 colonne) --}}
                    <div class="lg:col-span-2 group cursor-pointer rounded-lg overflow-hidden bg-black"
                         onclick="Livewire.dispatch('openVideoModal', { videoId: {{ $mostPopularVideo->id }} })"
                         x-data="{ visible: false }" 
                         x-intersect.once="visible = true">
                        <div x-show="visible"
                             x-transition:enter="transition ease-out duration-1000"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="relative aspect-video">
                            
                            <img src="{{ $mostPopularVideo->thumbnail_url }}" 
                                 onerror="this.src='https://images.unsplash.com/photo-1574375927938-d5a98e8ffe85?w=1200&q=80'"
                                 class="absolute inset-0 w-full h-full object-cover"
                                 style="object-position: 50% 35%;">
                            <div class="absolute inset-0 bg-gradient-to-tr from-black/80 via-black/40 to-transparent"></div>

                            {{-- Play Button --}}
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-20 h-20 md:w-24 md:h-24 bg-white/95 backdrop-blur-sm rounded-full flex items-center justify-center shadow-2xl group-hover:scale-110 transition-all">
                                    <svg class="w-12 h-12 text-primary-600 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                </div>
                            </div>

                            {{-- Content Overlay --}}
                            <div class="absolute bottom-0 left-0 right-0 p-4 md:p-6 bg-gradient-to-t from-black/95 to-transparent">
                                <div class="inline-block px-3 py-1 bg-primary-600 rounded-full mb-2 md:mb-3">
                                    <span class="text-white text-xs font-bold tracking-wider">IN EVIDENZA</span>
                                </div>
                                <h3 class="text-xl md:text-3xl font-bold text-white mb-2 md:mb-3 line-clamp-2" style="font-family: 'Crimson Pro', serif;">
                                    {{ $mostPopularVideo->title }}
                                </h3>
                                @if($mostPopularVideo->user)
                                    <div class="flex items-center gap-2 mb-3">
                                        <img src="{{ $mostPopularVideo->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($mostPopularVideo->user->name) . '&background=059669&color=fff' }}" 
                                             alt="{{ $mostPopularVideo->user->name }}"
                                             class="w-7 h-7 md:w-8 md:h-8 rounded-full object-cover ring-2 ring-white/30">
                                        <a href="{{ \App\Helpers\AvatarHelper::getUserProfileUrl($mostPopularVideo->user) }}" 
                                           class="text-white hover:text-white/80 font-semibold text-sm md:text-base hover:underline transition-colors">
                                            {{ \App\Helpers\AvatarHelper::getDisplayName($mostPopularVideo->user) }}
                                        </a>
                                        <span class="text-white/70 text-xs md:text-sm ml-1">{{ number_format($mostPopularVideo->view_count ?? 0) }} views</span>
                                    </div>
                                    
                                    {{-- Social Buttons --}}
                                    <div class="flex items-center gap-3" @click.stop>
                                        <x-like-button 
                                            :itemId="$mostPopularVideo->id"
                                            itemType="video"
                                            :isLiked="false"
                                            :likesCount="$mostPopularVideo->like_count ?? 0"
                                            size="sm"
                                            class="[&_span]:!text-white/90 [&_svg]:!text-white/90 [&_svg]:w-5 [&_svg]:h-5 md:[&_svg]:w-6 md:[&_svg]:h-6" />
                                        
                                        <x-comment-button 
                                            :itemId="$mostPopularVideo->id"
                                            itemType="video"
                                            :commentsCount="$mostPopularVideo->comment_count ?? 0"
                                            size="sm"
                                            class="[&_button]:!text-white/90 [&_span]:!text-white/90 [&_svg]:!stroke-white [&_svg]:w-5 [&_svg]:h-5 md:[&_svg]:w-6 md:[&_svg]:h-6" />
                                        
                                        <x-share-button 
                                            :itemId="$mostPopularVideo->id"
                                            itemType="video"
                                            size="sm"
                                            class="[&_button]:!text-white/90 [&_svg]:!stroke-white [&_svg]:w-5 [&_svg]:h-5 md:[&_svg]:w-6 md:[&_svg]:h-6" />
                                        
                                        <x-report-button 
                                            :itemId="$mostPopularVideo->id"
                                            itemType="video"
                                            size="sm"
                                            class="[&_button]:!text-white/90 [&_svg]:!stroke-white [&_svg]:w-4 [&_svg]:h-4" />
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- 2 Video Laterali (1 colonna, impilati) --}}
                    <div class="grid grid-cols-2 lg:grid-cols-1 gap-4">
                        @foreach($videos->take(2) as $index => $video)
                            <x-video-frame-light :video="$video" :index="$index + 2" />
                        @endforeach
                    </div>
                </div>

                {{-- Sezione Inferiore: 3 Video Orizzontali - FULL WIDTH --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($videos->skip(2)->take(3) as $index => $video)
                        <x-video-frame-light :video="$video" :index="$index + 4" />
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- PHOTO SECTION - Alternated Layout --}}
    <section class="relative py-12 md:py-16 bg-white dark:bg-neutral-900">
        <div class="max-w-[1800px] mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-10">
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

            {{-- Photo Layout: Hero + 2 laterali + 3 sotto --}}
            @if($mostPopularPhoto)
                @php $photos = $photoType === 'popular' ? $popularPhotos : $recentPhotos; @endphp
                
                {{-- Sezione Superiore: Hero + 2 Foto Laterali --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
                    {{-- Foto Hero (2 colonne) --}}
                    <div class="lg:col-span-2 group cursor-pointer rounded-lg overflow-hidden bg-neutral-100 dark:bg-neutral-800"
                         onclick="Livewire.dispatch('openPhotoModal', { photoId: {{ $mostPopularPhoto->id }} })"
                         x-data="{ visible: false }" 
                         x-intersect.once="visible = true">
                        <div x-show="visible"
                             x-transition:enter="transition ease-out duration-1000"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="h-full relative aspect-square lg:aspect-[4/3]">
                            
                            <img src="{{ $mostPopularPhoto->image_url }}" 
                                 onerror="this.src='https://images.unsplash.com/photo-1452587925148-ce544e77e70d?w=1200&q=80'"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 filter grayscale hover:grayscale-0"
                                 style="object-position: center 35%;">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>

                            {{-- Zoom Icon --}}
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                <div class="w-16 h-16 md:w-20 md:h-20 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-2xl">
                                    <svg class="w-8 h-8 md:w-10 md:h-10 text-neutral-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/>
                                    </svg>
                                </div>
                            </div>

                            {{-- Content Overlay --}}
                            <div class="absolute bottom-0 left-0 right-0 p-4 md:p-6 bg-gradient-to-t from-black/95 to-transparent">
                                <div class="inline-block px-3 py-1 bg-accent-600 rounded-full mb-2 md:mb-3">
                                    <span class="text-white text-xs font-bold tracking-wider">IN EVIDENZA</span>
                                </div>
                                <h3 class="text-xl md:text-3xl font-bold text-white mb-2 md:mb-3 line-clamp-2" style="font-family: 'Crimson Pro', serif;">
                                    {{ $mostPopularPhoto->title ?? __('media.untitled') }}
                                </h3>
                                @if($mostPopularPhoto->user)
                                    <div class="flex items-center gap-2 mb-3">
                                        <img src="{{ $mostPopularPhoto->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($mostPopularPhoto->user->name) . '&background=059669&color=fff' }}" 
                                             alt="{{ $mostPopularPhoto->user->name }}"
                                             class="w-7 h-7 md:w-8 md:h-8 rounded-full object-cover ring-2 ring-white/30">
                                        <a href="{{ \App\Helpers\AvatarHelper::getUserProfileUrl($mostPopularPhoto->user) }}" 
                                           class="text-white hover:text-white/80 font-semibold text-sm md:text-base hover:underline transition-colors">
                                            {{ \App\Helpers\AvatarHelper::getDisplayName($mostPopularPhoto->user) }}
                                        </a>
                                        <span class="text-white/70 text-xs md:text-sm ml-1">{{ number_format($mostPopularPhoto->view_count ?? 0) }} views</span>
                                    </div>
                                    
                                    {{-- Social Buttons --}}
                                    <div class="flex items-center gap-3" @click.stop>
                                        <x-like-button 
                                            :itemId="$mostPopularPhoto->id"
                                            itemType="photo"
                                            :isLiked="false"
                                            :likesCount="$mostPopularPhoto->like_count ?? 0"
                                            size="sm"
                                            class="[&_span]:!text-white/90 [&_svg]:!text-white/90 [&_svg]:w-5 [&_svg]:h-5 md:[&_svg]:w-6 md:[&_svg]:h-6" />
                                        
                                        <x-comment-button 
                                            :itemId="$mostPopularPhoto->id"
                                            itemType="photo"
                                            :commentsCount="$mostPopularPhoto->comment_count ?? 0"
                                            size="sm"
                                            class="[&_button]:!text-white/90 [&_span]:!text-white/90 [&_svg]:!stroke-white [&_svg]:w-5 [&_svg]:h-5 md:[&_svg]:w-6 md:[&_svg]:h-6" />
                                        
                                        <x-share-button 
                                            :itemId="$mostPopularPhoto->id"
                                            itemType="photo"
                                            size="sm"
                                            class="[&_button]:!text-white/90 [&_svg]:!stroke-white [&_svg]:w-5 [&_svg]:h-5 md:[&_svg]:w-6 md:[&_svg]:h-6" />
                                        
                                        <x-report-button 
                                            :itemId="$mostPopularPhoto->id"
                                            itemType="photo"
                                            size="sm"
                                            class="[&_button]:!text-white/90 [&_svg]:!stroke-white [&_svg]:w-4 [&_svg]:h-4" />
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- 2 Foto Laterali (1 colonna, impilate) --}}
                    <div class="grid grid-cols-2 lg:grid-cols-1 gap-4">
                        @foreach($photos->take(2) as $index => $photo)
                            <x-photo-frame-light :photo="$photo" :index="$index + 2" />
                        @endforeach
                    </div>
                </div>

                {{-- Sezione Inferiore: 3 Foto Orizzontali --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($photos->skip(2)->take(3) as $index => $photo)
                        <x-photo-frame-light :photo="$photo" :index="$index + 4" />
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
                                        <a href="{{ \App\Helpers\AvatarHelper::getUserProfileUrl($video->user) }}" 
                                           class="text-white/80 hover:text-white text-sm font-medium hover:underline transition-colors">
                                            {{ \App\Helpers\AvatarHelper::getDisplayName($video->user) }}
                                        </a>
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
                                        <a href="{{ \App\Helpers\AvatarHelper::getUserProfileUrl($photo->user) }}" 
                                           class="text-white/80 hover:text-white text-sm font-medium hover:underline transition-colors">
                                            {{ \App\Helpers\AvatarHelper::getDisplayName($photo->user) }}
                                        </a>
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

    <style>
        /* Updated: 1762971590 */
        .featured-hero-media {
            object-position: 50% 35% !important;
        }

        @media (max-width: 1024px) {
            .featured-hero-media {
                object-position: 50% 38% !important;
            }
        }

        /* ========================================
           MEDIA PAGE HERO - Film Card (come homepage)
           ======================================== */
        
        .media-page-film-card {
            position: relative;
            background: linear-gradient(90deg, 
                rgba(255, 255, 255, 0.08) 0%,
                transparent 30%
            ),
            linear-gradient(180deg, 
                rgba(80, 55, 35, 0.95) 0%,
                rgba(70, 48, 30, 0.97) 50%,
                rgba(80, 55, 35, 0.95) 100%
            );
            padding: 1.75rem 0.75rem;
            height: 250px;
            width: 200px;
            border-radius: 6px;
            box-shadow: 
                0 8px 16px rgba(0, 0, 0, 0.35),
                0 16px 32px rgba(0, 0, 0, 0.3),
                inset 0 2px 4px rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .media-page-film-card:hover {
            transform: translateY(-6px) scale(1.03);
            box-shadow: 
                0 12px 24px rgba(0, 0, 0, 0.4),
                0 20px 40px rgba(0, 0, 0, 0.35);
        }
        
        /* Film codes */
        .media-page-film-code-top,
        .media-page-film-code-bottom {
            position: absolute;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 0.65rem;
            font-weight: 700;
            color: white;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
            letter-spacing: 0.1em;
            z-index: 2;
        }
        
        .media-page-film-code-top { top: 0.4rem; }
        .media-page-film-code-bottom { bottom: 0.4rem; }
        
        /* Film frame */
        .media-page-film-frame {
            position: relative;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 2px;
            overflow: hidden;
        }
        
        /* Perforations */
        .media-page-film-perf-left,
        .media-page-film-perf-right {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 1.25rem;
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
            align-items: center;
            background: linear-gradient(180deg, 
                rgba(80, 55, 35, 0.98) 0%,
                rgba(70, 48, 30, 1) 50%,
                rgba(80, 55, 35, 0.98) 100%
            );
            z-index: 3;
        }
        
        .media-page-film-perf-left { left: 0; }
        .media-page-film-perf-right { right: 0; }
        
        .media-page-perf-hole {
            width: 14px;
            height: 12px;
            background: rgba(240, 235, 228, 0.95);
            border-radius: 1px;
            box-shadow: 
                inset 0 2px 3px rgba(0, 0, 0, 0.4),
                inset 0 1px 2px rgba(0, 0, 0, 0.3);
        }
        
        .dark .media-page-perf-hole {
            background: #1a1a1a;
        }
        
        /* Thumbnail */
        .media-page-film-thumbnail {
            position: absolute;
            inset: 0;
            z-index: 1;
        }
        
        /* Media text overlay */
        .media-page-film-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-family: 'Crimson Pro', serif;
            font-size: 2rem;
            font-weight: 900;
            color: white;
            text-shadow: 
                0 0 25px rgba(16, 185, 129, 0.9),
                0 0 50px rgba(16, 185, 129, 0.7),
                0 0 75px rgba(16, 185, 129, 0.5),
                0 4px 8px rgba(0, 0, 0, 0.9);
            z-index: 10;
            white-space: nowrap;
            letter-spacing: 0.05em;
            animation: media-glow 2s ease-in-out infinite alternate;
        }
        
        @keyframes media-glow {
            0% {
                text-shadow: 
                    0 0 25px rgba(16, 185, 129, 0.9),
                    0 0 50px rgba(16, 185, 129, 0.7),
                    0 0 75px rgba(16, 185, 129, 0.5),
                    0 4px 8px rgba(0, 0, 0, 0.9);
            }
            100% {
                text-shadow: 
                    0 0 35px rgba(16, 185, 129, 1),
                    0 0 60px rgba(16, 185, 129, 0.9),
                    0 0 95px rgba(16, 185, 129, 0.7),
                    0 6px 12px rgba(0, 0, 0, 0.9);
            }
        }
        
        /* Frame numbers */
        .media-page-frame-number-tl,
        .media-page-frame-number-tr,
        .media-page-frame-number-bl,
        .media-page-frame-number-br {
            position: absolute;
            font-size: 0.65rem;
            font-weight: 700;
            color: white;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
            z-index: 4;
        }
        
        .media-page-frame-number-tl { top: 0.4rem; left: 1.5rem; }
        .media-page-frame-number-tr { top: 0.4rem; right: 1.5rem; }
        .media-page-frame-number-bl { bottom: 0.4rem; left: 1.5rem; }
        .media-page-frame-number-br { bottom: 0.4rem; right: 1.5rem; }
        
        @media (max-width: 768px) {
            .media-page-film-card {
                width: 180px;
                height: 220px;
                padding: 1.5rem 0.7rem;
            }
            
            .media-page-film-perf-left,
            .media-page-film-perf-right {
                width: 1.1rem;
            }
            
            .media-page-perf-hole {
                width: 12px;
                height: 10px;
            }
            
            .media-page-film-text {
                font-size: 1.75rem;
            }
        }
        
        
        /* ========================================
           BACKGROUND - Lightbox per Film
           ======================================== */
        
        .film-studio-section {
            position: relative;
            background: 
                /* Lightbox pattern */
                repeating-linear-gradient(
                    0deg,
                    rgba(240, 240, 235, 0.5),
                    rgba(240, 240, 235, 0.5) 1px,
                    rgba(230, 230, 225, 0.4) 1px,
                    rgba(230, 230, 225, 0.4) 2px
                ),
                repeating-linear-gradient(
                    90deg,
                    rgba(240, 240, 235, 0.5),
                    rgba(240, 240, 235, 0.5) 1px,
                    rgba(230, 230, 225, 0.4) 1px,
                    rgba(230, 230, 225, 0.4) 2px
                ),
                url("data:image/svg+xml,%3Csvg width='100' height='100' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='grain'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='1.5' numOctaves='3' seed='5' /%3E%3C/filter%3E%3Crect width='100' height='100' filter='url(%23grain)' opacity='0.05'/%3E%3C/svg%3E"),
                radial-gradient(ellipse at center, 
                    rgba(255, 250, 240, 0.8) 0%,
                    rgba(245, 240, 230, 0.7) 50%,
                    rgba(235, 230, 220, 0.6) 100%
                ),
                linear-gradient(135deg, 
                    #f0ede8 0%,
                    #e8e5e0 25%,
                    #ece9e4 50%,
                    #e5e2dd 75%,
                    #eae7e2 100%
                );
            box-shadow: 
                inset 0 0 100px rgba(255, 250, 240, 0.3),
                inset 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        :is(.dark .film-studio-section) {
            background: 
                repeating-linear-gradient(
                    0deg,
                    rgba(40, 40, 38, 0.6),
                    rgba(40, 40, 38, 0.6) 1px,
                    rgba(35, 35, 33, 0.5) 1px,
                    rgba(35, 35, 33, 0.5) 2px
                ),
                repeating-linear-gradient(
                    90deg,
                    rgba(40, 40, 38, 0.6),
                    rgba(40, 40, 38, 0.6) 1px,
                    rgba(35, 35, 33, 0.5) 1px,
                    rgba(35, 35, 33, 0.5) 2px
                ),
                url("data:image/svg+xml,%3Csvg width='100' height='100' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='grain'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='1.5' numOctaves='3' seed='5' /%3E%3C/filter%3E%3Crect width='100' height='100' filter='url(%23grain)' opacity='0.08'/%3E%3C/svg%3E"),
                radial-gradient(ellipse at center, 
                    rgba(60, 58, 55, 0.7) 0%,
                    rgba(50, 48, 45, 0.6) 50%,
                    rgba(40, 38, 35, 0.5) 100%
                ),
                linear-gradient(135deg, 
                    #2a2826 0%,
                    #252321 25%,
                    #282624 50%,
                    #232120 75%,
                    #272523 100%
                );
            box-shadow: 
                inset 0 0 80px rgba(0, 0, 0, 0.4),
                inset 0 2px 10px rgba(0, 0, 0, 0.3);
        }
        
    </style>
</div>
