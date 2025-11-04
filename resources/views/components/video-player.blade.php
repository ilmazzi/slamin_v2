@props([
    'video',
    'showStats' => true,
    'showAuthor' => true,
    'autoplay' => false,
    'size' => 'full', // full, large, medium, small
    'directUrl' => null, // Direct file URL for PeerTube videos
])

@php
$sizeClasses = [
    'full' => 'aspect-video',
    'large' => 'aspect-video max-w-4xl',
    'medium' => 'aspect-video max-w-2xl',
    'small' => 'aspect-video max-w-xl',
];
$containerClass = $sizeClasses[$size] ?? $sizeClasses['full'];
@endphp

<div x-data="{ 
    showModal: false,
    videoData: null,
    
    init() {
        this.videoData = {
            id: {{ $video->id }},
            title: {{ Js::from($video->title) }},
            url: {{ Js::from($video->video_url) }},
            directUrl: {{ Js::from($directUrl) }},
            thumbnail: {{ Js::from($video->thumbnail_url) }},
            user: {
                name: {{ Js::from($video->user->name) }},
                avatar: {{ Js::from($video->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($video->user->name) . '&background=059669&color=fff') }}
            },
            created_at: {{ Js::from($video->created_at->diffForHumans()) }},
            stats: {
                views: {{ $video->view_count ?? 0 }},
                likes: {{ $video->like_count ?? 0 }},
                comments: {{ $video->comment_count ?? 0 }}
            }
        };
    },
    
    openModal() {
        this.showModal = true;
        document.body.style.overflow = 'hidden';
    },
    
    closeModal() {
        this.showModal = false;
        document.body.style.overflow = '';
    },
    
    isPeerTube(url) {
        return url && (url.includes('video.slamin.it') || url.includes('peertube'));
    },
    
    isYouTube(url) {
        return url && (url.includes('youtube.com') || url.includes('youtu.be'));
    },
    
    getYouTubeEmbedUrl(url) {
        if (url.includes('youtube.com/watch')) {
            let videoId = url.match(/[?&]v=([^&]+)/)?.[1];
            if (videoId) return `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0`;
        }
        if (url.includes('youtu.be/')) {
            let videoId = url.match(/youtu\.be\/([^?]+)/)?.[1];
            if (videoId) return `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0`;
        }
        return url;
    }
}" 
{{ $attributes->merge(['class' => $containerClass]) }}>
    
    <!-- Video Thumbnail (Clickable) -->
    <div @click="openModal()" class="relative w-full h-full cursor-pointer group overflow-hidden rounded-xl">
        <!-- Thumbnail Image -->
        <img :src="videoData.thumbnail" 
             :alt="videoData.title" 
             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
             onerror="this.src='{{ asset('assets/images/placeholder/placholder-1.jpg') }}'">
        
        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent group-hover:from-black/90 transition-all duration-300"></div>
        
        <!-- Play Button -->
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="w-16 h-16 md:w-20 md:h-20 bg-white/95 backdrop-blur-sm rounded-full flex items-center justify-center shadow-2xl group-hover:scale-110 transition-all duration-300">
                <svg class="w-8 h-8 md:w-10 md:h-10 text-primary-600 ml-1" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8 5v14l11-7z"/>
                </svg>
            </div>
        </div>
        
        @if($showAuthor || $showStats)
        <!-- Video Info Overlay -->
        <div class="absolute bottom-0 left-0 right-0 p-4 md:p-6 text-white pointer-events-none">
            <h3 class="text-lg md:text-xl font-bold mb-2 drop-shadow-lg line-clamp-2" 
                style="font-family: 'Crimson Pro', serif;"
                x-text="videoData.title"></h3>
            
            @if($showAuthor)
            <!-- Author Info -->
            <div class="flex items-center gap-2 mb-3">
                <img :src="videoData.user.avatar" 
                     :alt="videoData.user.name"
                     class="w-8 h-8 md:w-10 md:h-10 rounded-full object-cover ring-2 ring-white/50">
                <div>
                    <p class="font-semibold text-sm drop-shadow" x-text="videoData.user.name"></p>
                    <p class="text-xs text-white/80 drop-shadow" x-text="videoData.created_at"></p>
                </div>
            </div>
            @endif
            
            @if($showStats)
            <!-- Stats - Using Reusable Components -->
            <div class="flex items-center gap-4 text-sm text-white/90 pointer-events-auto">
                <!-- Views -->
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <span class="font-medium" x-text="videoData.stats.views.toLocaleString()"></span>
                </div>
                
                <!-- Like Button Component -->
                <div class="[&_button]:!text-white/90 [&_button:hover]:!text-white [&_span]:!text-white/90" @click.stop>
                    <x-like-button 
                        :itemId="$video->id"
                        itemType="video"
                        :isLiked="false"
                        :likesCount="$video->like_count ?? 0"
                        size="sm" />
                </div>
                
                <!-- Comment Button Component -->
                <div class="[&_button]:!text-white/90 [&_button:hover]:!text-white [&_span]:!text-white/90" @click.stop>
                    <x-comment-button 
                        :itemId="$video->id"
                        itemType="video"
                        :commentsCount="$video->comment_count ?? 0"
                        size="sm" />
                </div>
                
                <!-- Share Button Component -->
                <div class="[&_button]:!text-white/90 [&_button:hover]:!text-white" @click.stop>
                    <x-share-button 
                        :itemId="$video->id"
                        itemType="video"
                        size="sm" />
                </div>
            </div>
            @endif
        </div>
        @endif
    </div>

    <!-- Video Modal - Teleported to body to avoid slide transitions -->
    <template x-teleport="body">
        <div x-show="showModal"
             x-cloak
             @click.self="closeModal()"
             @keydown.escape.window="closeModal()"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-black/90 backdrop-blur-sm"
             style="display: none;">
        
        <div x-show="showModal"
             x-transition:enter="transition ease-out duration-300 delay-100"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-90"
             class="relative w-full max-w-6xl bg-neutral-900 rounded-2xl overflow-hidden shadow-2xl">
            
            <!-- Close Button -->
            <button @click="closeModal()"
                    class="absolute top-4 right-4 z-10 w-10 h-10 bg-white/10 hover:bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white transition-all duration-300 hover:scale-110 hover:rotate-90">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            
            <!-- Video Player -->
            <div class="aspect-video bg-black">
                <!-- PeerTube: Use native HTML5 video tag with DIRECT file URL -->
                <template x-if="showModal && (isPeerTube(videoData.url) || videoData.directUrl)">
                    <video controls 
                           autoplay
                           playsinline
                           webkit-playsinline
                           preload="metadata"
                           class="w-full h-full"
                           :src="videoData.directUrl || videoData.url">
                        Your browser does not support the video tag.
                    </video>
                </template>
                
                <!-- YouTube: Use iframe embed -->
                <template x-if="showModal && isYouTube(videoData.url) && !videoData.directUrl">
                    <iframe :src="getYouTubeEmbedUrl(videoData.url)"
                            class="w-full h-full"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                    </iframe>
                </template>
                
                <!-- Other: Fallback iframe -->
                <template x-if="showModal && !isPeerTube(videoData.url) && !isYouTube(videoData.url) && !videoData.directUrl">
                    <iframe :src="videoData.url"
                            class="w-full h-full"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                    </iframe>
                </template>
            </div>
            
            <!-- Video Info Footer -->
            <div class="p-6 bg-neutral-900 text-white">
                <h3 class="text-2xl font-bold mb-3" style="font-family: 'Crimson Pro', serif;" x-text="videoData.title"></h3>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <img :src="videoData.user.avatar" 
                             :alt="videoData.user.name"
                             class="w-12 h-12 rounded-full object-cover ring-2 ring-primary-500">
                        <div>
                            <p class="font-semibold" x-text="videoData.user.name"></p>
                            <p class="text-sm text-neutral-400" x-text="videoData.created_at"></p>
                        </div>
                    </div>
                    
                    <!-- Stats in Modal -->
                    <div class="flex items-center gap-4 text-sm">
                        <div class="flex items-center gap-1.5 text-neutral-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <span x-text="videoData.stats.views.toLocaleString()"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </template>
</div>

