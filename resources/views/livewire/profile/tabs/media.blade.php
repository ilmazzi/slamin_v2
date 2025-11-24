{{-- Media Tab - con riferimento grafico Film Card --}}
<div class="space-y-6">
    {{-- Header con Film Card --}}
    <div class="flex items-center gap-4 mb-6">
        <div class="media-page-film-card" style="width: 80px; height: 100px;">
            <div class="media-page-film-code-top" style="font-size: 0.5rem;">SLAMIN</div>
            <div class="media-page-film-code-bottom" style="font-size: 0.5rem;">ISO 400</div>
            <div class="media-page-film-frame">
                <div class="media-page-film-perf-left" style="width: 0.8rem;">
                    @for($h = 0; $h < 5; $h++)
                    <div class="media-page-perf-hole" style="width: 8px; height: 6px;"></div>
                    @endfor
                </div>
                <div class="media-page-film-perf-right" style="width: 0.8rem;">
                    @for($h = 0; $h < 5; $h++)
                    <div class="media-page-perf-hole" style="width: 8px; height: 6px;"></div>
                    @endfor
                </div>
                <div class="media-page-film-thumbnail" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
            </div>
        </div>
        <div>
            <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">
                {{ __('profile.media.title') }}
            </h2>
            <p class="text-neutral-600 dark:text-neutral-400">{{ __('profile.media.subtitle', ['photos' => $stats['photos'], 'videos' => $stats['videos']]) }}</p>
        </div>
    </div>

    {{-- Videos Section --}}
    @if($videos->count() > 0)
    <div class="mb-8">
        <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">{{ __('profile.media.videos') }}</h3>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($videos as $video)
                <a href="{{ $video->peertube_url ?? $video->video_url ?? '#' }}" target="_blank" class="group">
                    <div class="relative aspect-video bg-neutral-800 rounded-xl overflow-hidden border border-neutral-200 dark:border-neutral-700 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                        @if($video->thumbnail_url)
                        <img src="{{ $video->thumbnail_url }}" 
                             alt="{{ $video->title }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                        <div class="w-full h-full bg-gradient-to-br from-primary-600 to-accent-600 flex items-center justify-center">
                            <svg class="w-16 h-16 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent flex items-end p-4">
                            <div class="w-full">
                                <h4 class="text-white font-bold mb-1 line-clamp-2">{{ $video->title }}</h4>
                                <div class="flex items-center gap-3 text-white/80 text-xs">
                                    <span>{{ $video->created_at->format('d/m/Y') }}</span>
                                    @if($video->view_count > 0)
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        {{ $video->view_count }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <div class="bg-black/70 rounded-full p-4">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        @if($videos->hasPages())
        <div class="mt-4">
            {{ $videos->links() }}
        </div>
        @endif
    </div>
    @endif

    {{-- Photos Section --}}
    @if($photos->count() > 0)
    <div>
        <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">{{ __('profile.media.photos') }}</h3>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($photos as $photo)
                <a href="{{ $photo->image_url ?? '#' }}" target="_blank" class="group">
                    <div class="relative aspect-square bg-neutral-800 rounded-xl overflow-hidden border border-neutral-200 dark:border-neutral-700 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                        <img src="{{ $photo->image_url ?? $photo->thumbnail_url }}" 
                             alt="{{ $photo->title ?? __('media.untitled') }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-3">
                            <h4 class="text-white font-semibold text-sm line-clamp-2">{{ $photo->title ?? __('media.untitled') }}</h4>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        @if($photos->hasPages())
        <div class="mt-4">
            {{ $photos->links() }}
        </div>
        @endif
    </div>
    @endif

    @if($videos->count() === 0 && $photos->count() === 0)
    <div class="bg-white dark:bg-neutral-800 rounded-xl p-12 text-center border border-neutral-200 dark:border-neutral-700">
        <svg class="w-16 h-16 text-neutral-400 dark:text-neutral-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
        </svg>
        <p class="text-neutral-600 dark:text-neutral-400">{{ __('profile.media.empty') }}</p>
    </div>
    @endif
</div>

