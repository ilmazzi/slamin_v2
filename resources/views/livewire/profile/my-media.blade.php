<div class="min-h-screen">
    {{-- HERO con Film Card + Titolo --}}
    <section class="relative pt-16 pb-12 md:pb-20 overflow-hidden bg-neutral-900 dark:bg-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center gap-6 md:flex-row md:justify-center md:gap-12">
                <!-- FILM CARD -->
                <div class="media-page-film-card">
                    <div class="media-page-film-code-top">SLAMIN</div>
                    <div class="media-page-film-code-bottom">ISO 400</div>
                    <div class="media-page-film-frame">
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
                        <div class="media-page-frame-number-tl">///01</div>
                        <div class="media-page-frame-number-tr">01A</div>
                        <div class="media-page-frame-number-bl">35MM</div>
                        <div class="media-page-frame-number-br">1</div>
                        <div class="media-page-film-thumbnail" style="background: url('<?php echo [
                            'https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?w=600',
                            'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?w=600',
                            'https://images.unsplash.com/photo-1514320291840-2e0a9bf2a9ae?w=600',
                            'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?w=600'
                        ][rand(0, 3)]; ?>') center/cover;"></div>
                        <div class="media-page-film-text">{{ __('profile.my_media') }}</div>
                    </div>
                </div>
                
                <!-- TITOLO A FIANCO -->
                <div class="text-center md:text-left">
                    <h1 class="text-5xl md:text-7xl lg:text-8xl font-black text-white leading-tight" style="font-family: 'Crimson Pro', serif;">
                        {{ __('profile.my_media') }}
                    </h1>
                    <p class="text-xl md:text-2xl text-white/80 mt-4 font-medium">
                        {{ __('profile.my_media_description') }}
                    </p>
                    
                    <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                        @can('upload.video')
                            <a href="{{ route('media.upload.video') }}" class="btn-primary-lg">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                {{ __('media.upload_video') }}
                            </a>
                        @endcan
                        @can('upload.photo')
                            <button disabled class="btn-primary-lg opacity-50 cursor-not-allowed" title="{{ __('media.photo_upload_coming_soon') }}">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ __('media.upload_photo') }}
                            </button>
                        @endcan
                        <a href="{{ route('user.show', auth()->user()) }}" class="btn-secondary-lg">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            {{ __('common.back_to_profile') }}
                        </a>
                    </div>

                    {{-- Stats (only for videos) --}}
                    @if($activeTab === 'videos')
                    <div class="mt-8 flex items-center gap-6">
                        <div class="text-center">
                            <div class="text-3xl font-black text-primary-400 mb-1">{{ $currentVideoCount }}</div>
                            <div class="text-sm text-white/60">{{ __('media.videos_used') }}</div>
                        </div>
                        <div class="text-white/40">/</div>
                        <div class="text-center">
                            <div class="text-3xl font-black text-white mb-1">{{ $currentVideoLimit }}</div>
                            <div class="text-sm text-white/60">{{ __('media.video_limit') }}</div>
                        </div>
                        <div class="text-white/40">/</div>
                        <div class="text-center">
                            <div class="text-3xl font-black text-green-400 mb-1">{{ $remainingUploads }}</div>
                            <div class="text-sm text-white/60">{{ __('media.videos_remaining') }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- TABS --}}
    <section class="relative py-8 bg-white dark:bg-neutral-900 border-b border-neutral-200 dark:border-neutral-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-4">
                <button wire:click="switchTab('videos')"
                        class="px-6 py-3 rounded-xl font-black text-lg transition-all {{ $activeTab === 'videos' ? 'bg-primary-600 text-white shadow-lg' : 'bg-neutral-100 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-neutral-700' }}">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    {{ __('media.videos') }} ({{ $videos->total() }})
                </button>
                <button wire:click="switchTab('photos')"
                        class="px-6 py-3 rounded-xl font-black text-lg transition-all {{ $activeTab === 'photos' ? 'bg-primary-600 text-white shadow-lg' : 'bg-neutral-100 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-neutral-700' }}">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ __('media.photos') }} ({{ $photos->total() }})
                </button>
            </div>
        </div>
    </section>

    {{-- CONTENT --}}
    <section class="relative py-12 md:py-16 film-studio-section">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Search and Filters --}}
            <div class="mb-8 flex flex-col md:flex-row gap-4 items-center justify-between">
                <div class="flex-1 max-w-md w-full">
                    <div class="relative">
                        <input type="text"
                               wire:model.live.debounce.300ms="search"
                               placeholder="{{ $activeTab === 'videos' ? __('media.search_my_videos') : __('media.search_my_photos') }}"
                               class="w-full px-5 py-3 pl-12 bg-white dark:bg-neutral-800 border-2 border-neutral-300 dark:border-neutral-600 rounded-xl
                                      focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:text-white font-medium">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
                
                <div class="flex items-center gap-2 bg-white dark:bg-neutral-800 p-1 rounded-full shadow-lg">
                    @if($activeTab === 'videos')
                        <button wire:click="$set('videoFilter', 'all')"
                                class="px-4 py-2 rounded-full font-black text-sm transition-all {{ $videoFilter === 'all' ? 'bg-primary-600 text-white shadow-lg' : 'text-neutral-600 dark:text-neutral-400' }}">
                            {{ __('media.all') }}
                        </button>
                        <button wire:click="$set('videoFilter', 'approved')"
                                class="px-4 py-2 rounded-full font-black text-sm transition-all {{ $videoFilter === 'approved' ? 'bg-green-600 text-white shadow-lg' : 'text-neutral-600 dark:text-neutral-400' }}">
                            {{ __('media.approved') }}
                        </button>
                        <button wire:click="$set('videoFilter', 'pending')"
                                class="px-4 py-2 rounded-full font-black text-sm transition-all {{ $videoFilter === 'pending' ? 'bg-yellow-600 text-white shadow-lg' : 'text-neutral-600 dark:text-neutral-400' }}">
                            {{ __('media.pending') }}
                        </button>
                        <button wire:click="$set('videoFilter', 'rejected')"
                                class="px-4 py-2 rounded-full font-black text-sm transition-all {{ $videoFilter === 'rejected' ? 'bg-red-600 text-white shadow-lg' : 'text-neutral-600 dark:text-neutral-400' }}">
                            {{ __('media.rejected') }}
                        </button>
                    @else
                        <button wire:click="$set('photoFilter', 'all')"
                                class="px-4 py-2 rounded-full font-black text-sm transition-all {{ $photoFilter === 'all' ? 'bg-primary-600 text-white shadow-lg' : 'text-neutral-600 dark:text-neutral-400' }}">
                            {{ __('media.all') }}
                        </button>
                        <button wire:click="$set('photoFilter', 'approved')"
                                class="px-4 py-2 rounded-full font-black text-sm transition-all {{ $photoFilter === 'approved' ? 'bg-green-600 text-white shadow-lg' : 'text-neutral-600 dark:text-neutral-400' }}">
                            {{ __('media.approved') }}
                        </button>
                        <button wire:click="$set('photoFilter', 'pending')"
                                class="px-4 py-2 rounded-full font-black text-sm transition-all {{ $photoFilter === 'pending' ? 'bg-yellow-600 text-white shadow-lg' : 'text-neutral-600 dark:text-neutral-400' }}">
                            {{ __('media.pending') }}
                        </button>
                        <button wire:click="$set('photoFilter', 'rejected')"
                                class="px-4 py-2 rounded-full font-black text-sm transition-all {{ $photoFilter === 'rejected' ? 'bg-red-600 text-white shadow-lg' : 'text-neutral-600 dark:text-neutral-400' }}">
                            {{ __('media.rejected') }}
                        </button>
                    @endif
                </div>
            </div>

            {{-- VIDEOS TAB --}}
            @if($activeTab === 'videos')
                @if($videos->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($videos as $video)
                            <div class="group relative overflow-hidden rounded-2xl bg-white dark:bg-neutral-800 shadow-xl hover:shadow-2xl transition-all duration-300">
                                <div class="aspect-[3/4] relative bg-neutral-800">
                                    <img src="{{ $video->thumbnail_url }}" 
                                         onerror="this.src='https://images.unsplash.com/photo-1574375927938-d5a98e8ffe85?w=800&q=80'"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 to-transparent"></div>
                                    
                                    {{-- Status Badge --}}
                                    <div class="absolute top-4 right-4">
                                        @if($video->moderation_status === 'approved')
                                            <span class="px-3 py-1.5 bg-green-600 text-white text-xs font-black rounded-full">
                                                {{ __('media.approved') }}
                                            </span>
                                        @elseif($video->moderation_status === 'pending')
                                            <span class="px-3 py-1.5 bg-yellow-600 text-white text-xs font-black rounded-full">
                                                {{ __('media.pending') }}
                                            </span>
                                        @elseif($video->moderation_status === 'rejected')
                                            <span class="px-3 py-1.5 bg-red-600 text-white text-xs font-black rounded-full">
                                                {{ __('media.rejected') }}
                                            </span>
                                        @endif
                                    </div>
                                    
                                    {{-- Play Icon --}}
                                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('videos.show', $video) }}" 
                                           class="w-16 h-16 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-2xl">
                                            <svg class="w-8 h-8 text-neutral-900" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M8 5v14l11-7z"/>
                                            </svg>
                                        </a>
                                    </div>

                                    {{-- Info Overlay --}}
                                    <div class="absolute bottom-0 left-0 right-0 p-5">
                                        <h4 class="text-xl font-black text-white mb-2 line-clamp-2" style="font-family: 'Crimson Pro', serif;">
                                            {{ $video->title }}
                                        </h4>
                                        <div class="flex items-center justify-between text-white/80 text-sm">
                                            <span>{{ number_format($video->views_count ?? 0) }} {{ __('media.views') }}</span>
                                            <span>{{ $video->created_at->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                {{-- Actions --}}
                                <div class="p-4 flex items-center justify-between gap-3">
                                    <a href="{{ route('videos.show', $video) }}" 
                                       class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        {{ __('media.view') }}
                                    </a>
                                    <button wire:click="deleteVideo({{ $video->id }})"
                                            wire:confirm="{{ __('media.confirm_delete_video') }}"
                                            class="p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-8">
                        {{ $videos->links() }}
                    </div>
                @else
                    <div class="text-center py-20">
                        <div class="w-32 h-32 bg-neutral-200 dark:bg-neutral-800 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-16 h-16 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <p class="text-3xl font-black text-neutral-900 dark:text-white mb-2" style="font-family: 'Crimson Pro', serif;">
                            {{ __('media.no_videos_yet') }}
                        </p>
                        <p class="text-neutral-600 dark:text-neutral-400 mb-6">
                            {{ __('media.upload_your_first_video') }}
                        </p>
                        @can('upload.video')
                            <a href="{{ route('media.upload.video') }}" class="btn-primary-lg">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                {{ __('media.upload_video') }}
                            </a>
                        @endcan
                    </div>
                @endif
            @endif

            {{-- PHOTOS TAB --}}
            @if($activeTab === 'photos')
                @if($photos->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($photos as $photo)
                            <div class="group relative overflow-hidden rounded-2xl bg-white dark:bg-neutral-800 shadow-xl hover:shadow-2xl transition-all duration-300">
                                <div class="aspect-square relative bg-neutral-800">
                                    <img src="{{ $photo->image_url }}" 
                                         onerror="this.src='https://images.unsplash.com/photo-1574375927938-d5a98e8ffe85?w=800&q=80'"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 to-transparent"></div>
                                    
                                    {{-- Status Badge --}}
                                    <div class="absolute top-4 right-4">
                                        @if($photo->status === 'approved' && $photo->moderation_status === 'approved')
                                            <span class="px-3 py-1.5 bg-green-600 text-white text-xs font-black rounded-full">
                                                {{ __('media.approved') }}
                                            </span>
                                        @elseif($photo->status === 'pending' || $photo->moderation_status === 'pending')
                                            <span class="px-3 py-1.5 bg-yellow-600 text-white text-xs font-black rounded-full">
                                                {{ __('media.pending') }}
                                            </span>
                                        @elseif($photo->moderation_status === 'rejected')
                                            <span class="px-3 py-1.5 bg-red-600 text-white text-xs font-black rounded-full">
                                                {{ __('media.rejected') }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Info Overlay --}}
                                    @if($photo->title)
                                    <div class="absolute bottom-0 left-0 right-0 p-5">
                                        <h4 class="text-xl font-black text-white mb-2 line-clamp-2" style="font-family: 'Crimson Pro', serif;">
                                            {{ $photo->title }}
                                        </h4>
                                        <div class="flex items-center justify-between text-white/80 text-sm">
                                            <span>{{ number_format($photo->views_count ?? 0) }} {{ __('media.views') }}</span>
                                            <span>{{ $photo->created_at->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                
                                {{-- Actions --}}
                                <div class="p-4 flex items-center justify-between gap-3">
                                    <a href="{{ route('photos.show', $photo) }}" 
                                       class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        {{ __('media.view') }}
                                    </a>
                                    <button wire:click="deletePhoto({{ $photo->id }})"
                                            wire:confirm="{{ __('media.confirm_delete_photo') }}"
                                            class="p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-8">
                        {{ $photos->links() }}
                    </div>
                @else
                    <div class="text-center py-20">
                        <div class="w-32 h-32 bg-neutral-200 dark:bg-neutral-800 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-16 h-16 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <p class="text-3xl font-black text-neutral-900 dark:text-white mb-2" style="font-family: 'Crimson Pro', serif;">
                            {{ __('media.no_photos_yet') }}
                        </p>
                        <p class="text-neutral-600 dark:text-neutral-400 mb-6">
                            {{ __('media.upload_your_first_photo') }}
                        </p>
                        @can('upload.photo')
                            <button disabled class="btn-primary-lg opacity-50 cursor-not-allowed" title="{{ __('media.photo_upload_coming_soon') }}">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                {{ __('media.upload_photo') }}
                            </button>
                        @endcan
                    </div>
                @endif
            @endif
        </div>
    </section>

    {{-- Flash Messages --}}
    @if (session()->has('success'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 3000)"
             class="fixed bottom-4 right-4 bg-green-600 text-white px-6 py-3 rounded-xl shadow-lg z-50">
            {{ session('success') }}
        </div>
    @endif

    <style>
    /* Media Page Film Card Styles */
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
    
    .media-page-film-frame {
        position: relative;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        border-radius: 2px;
        overflow: hidden;
    }
    
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
    
    .media-page-film-thumbnail {
        position: absolute;
        inset: 0;
        z-index: 1;
    }
    
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
    
    /* Film Studio Section Background */
    .film-studio-section {
        position: relative;
        background: 
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
    }
    
    .dark .film-studio-section {
        background: 
            repeating-linear-gradient(
                0deg,
                rgba(30, 30, 30, 0.5),
                rgba(30, 30, 30, 0.5) 1px,
                rgba(20, 20, 20, 0.4) 1px,
                rgba(20, 20, 20, 0.4) 2px
            ),
            repeating-linear-gradient(
                90deg,
                rgba(30, 30, 30, 0.5),
                rgba(30, 30, 30, 0.5) 1px,
                rgba(20, 20, 20, 0.4) 1px,
                rgba(20, 20, 20, 0.4) 2px
            ),
            radial-gradient(ellipse at center, 
                rgba(20, 20, 20, 0.8) 0%,
                rgba(15, 15, 15, 0.7) 50%,
                rgba(10, 10, 10, 0.6) 100%
            ),
            linear-gradient(135deg, 
                #1a1a1a 0%,
                #151515 25%,
                #181818 50%,
                #141414 75%,
                #171717 100%
            );
    }
    </style>
</div>

