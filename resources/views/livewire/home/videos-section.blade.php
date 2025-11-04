<div x-data="{ 
    showVideoModal: false, 
    currentVideo: null,
    openVideo(video) {
        this.currentVideo = video;
        this.showVideoModal = true;
        document.body.style.overflow = 'hidden';
    },
    closeVideo() {
        this.showVideoModal = false;
        this.currentVideo = null;
        document.body.style.overflow = '';
    }
}">
    @if($videos && $videos->count() > 0)
    <section class="py-12 md:py-16 bg-neutral-50 dark:bg-neutral-950">
        <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-10" 
                 x-data="{ visible: false }" 
                 x-intersect.once="visible = true">
                <div x-show="visible"
                     x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0">
                    <h2 class="text-3xl md:text-4xl font-bold text-neutral-900 dark:text-white mb-2"
                        style="font-family: 'Crimson Pro', serif;">
                        {{ __('home.videos_section_title') }}
                    </h2>
                    <p class="text-neutral-600 dark:text-neutral-400">{{ __('home.videos_section_subtitle') }}</p>
                </div>
            </div>

            <!-- Video Slider -->
            <div class="relative" 
                 x-data="{ 
                     currentSlide: 0, 
                     totalSlides: {{ $videos->count() }},
                     autoplayInterval: null,
                     startAutoplay() {
                         this.autoplayInterval = setInterval(() => {
                             this.next();
                         }, 5000);
                     },
                     stopAutoplay() {
                         if (this.autoplayInterval) {
                             clearInterval(this.autoplayInterval);
                         }
                     },
                     next() {
                         this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
                     },
                     prev() {
                         this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
                     }
                 }"
                 x-init="startAutoplay()"
                 @mouseenter="stopAutoplay()"
                 @mouseleave="startAutoplay()">
                
                <!-- Slides Container with aspect ratio wrapper -->
                <div class="relative aspect-video overflow-hidden rounded-3xl shadow-2xl bg-neutral-900">
                    @foreach($videos as $index => $video)
                    <div @click="openVideo({ 
                            id: {{ $video->id }},
                            title: {{ Js::from($video->title) }},
                            url: {{ Js::from($video->video_url) }},
                            user: {{ Js::from([
                                'name' => $video->user->name,
                                'avatar' => $video->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($video->user->name) . '&background=059669&color=fff'
                            ]) }},
                            created_at: {{ Js::from($video->created_at->diffForHumans()) }}
                         })"
                         x-show="currentSlide === {{ $index }}"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 translate-x-full"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100 translate-x-0"
                         x-transition:leave-end="opacity-0 -translate-x-full"
                         class="absolute inset-0 w-full h-full cursor-pointer"
                         style="{{ $index !== 0 ? 'display: none;' : '' }}">
                        
                        <!-- Video Thumbnail - Uses getThumbnailUrlAttribute accessor -->
                        <img src="{{ $video->thumbnail_url }}" 
                             alt="{{ $video->title }}" 
                             class="w-full h-full object-cover"
                             onerror="this.src='{{ asset('assets/images/placeholder/placholder-1.jpg') }}'">
                        
                        <!-- Dark Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent pointer-events-none"></div>
                        
                        <!-- Play Button -->
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <div class="w-20 h-20 bg-white/95 backdrop-blur-sm rounded-full flex items-center justify-center shadow-2xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-10 h-10 text-primary-600 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Video Info Overlay (Bottom) - pointer-events-none to allow link click -->
                        <div class="absolute bottom-0 left-0 right-0 p-6 md:p-8 text-white pointer-events-none">
                            <h3 class="text-2xl md:text-3xl font-bold mb-3 drop-shadow-lg" style="font-family: 'Crimson Pro', serif;">
                                {{ $video->title }}
                            </h3>
                            
                            <!-- Author Info -->
                            <div class="flex items-center gap-3 mb-4">
                                <img src="{{ $video->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($video->user->name) . '&background=059669&color=fff' }}" 
                                     alt="{{ $video->user->name }}" 
                                     class="w-12 h-12 rounded-full object-cover ring-2 ring-white/50">
                                <div>
                                    <p class="font-semibold text-white drop-shadow">{{ $video->user->name }}</p>
                                    <p class="text-sm text-white/80 drop-shadow">{{ $video->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            
                            <!-- Stats - Using Reusable Components with pointer-events-auto -->
                            <div class="flex items-center gap-6 text-white/90 pointer-events-auto">
                                <!-- Views -->
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <span class="font-medium">{{ number_format($video->view_count ?? 0) }}</span>
                                </div>
                                
                                <!-- Like Button Component -->
                                <div class="[&_button]:!text-white/90 [&_button:hover]:!text-white [&_span]:!text-white/90" @click.prevent>
                                    <x-like-button 
                                        :itemId="$video->id"
                                        itemType="video"
                                        :isLiked="false"
                                        :likesCount="$video->like_count ?? 0"
                                        size="md" />
                                </div>
                                
                                <!-- Comment Button Component -->
                                <div class="[&_button]:!text-white/90 [&_button:hover]:!text-white [&_span]:!text-white/90" @click.prevent>
                                    <x-comment-button 
                                        :itemId="$video->id"
                                        itemType="video"
                                        :commentsCount="$video->comment_count ?? 0"
                                        size="md" />
                                </div>
                                
                                <!-- Share Button Component -->
                                <div class="[&_button]:!text-white/90 [&_button:hover]:!text-white [&_button]:hover:!opacity-100" @click.prevent>
                                    <x-share-button 
                                        :itemId="$video->id"
                                        itemType="video"
                                        size="md" />
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Navigation Arrows -->
                <button @click="prev()" 
                        class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/95 dark:bg-neutral-800/95 backdrop-blur-sm rounded-full shadow-xl hover:scale-110 transition-all duration-300 flex items-center justify-center text-neutral-900 dark:text-white group z-10">
                    <svg class="w-6 h-6 transform group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                
                <button @click="next()" 
                        class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/95 dark:bg-neutral-800/95 backdrop-blur-sm rounded-full shadow-xl hover:scale-110 transition-all duration-300 flex items-center justify-center text-neutral-900 dark:text-white group z-10">
                    <svg class="w-6 h-6 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
                
                <!-- Dots Indicators -->
                <div class="flex items-center justify-center gap-2 mt-6">
                    @foreach($videos as $index => $video)
                    <button @click="currentSlide = {{ $index }}; stopAutoplay();"
                            class="h-2 rounded-full transition-all duration-300"
                            :class="currentSlide === {{ $index }} ? 'bg-primary-600 w-8' : 'bg-neutral-300 dark:bg-neutral-700 w-2 hover:w-4'">
                    </button>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Video Modal -->
    <div x-show="showVideoModal"
         x-cloak
         @click.self="closeVideo()"
         @keydown.escape.window="closeVideo()"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-black/90 backdrop-blur-sm">
        
        <div x-show="showVideoModal"
             x-transition:enter="transition ease-out duration-300 delay-100"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-90"
             class="relative w-full max-w-6xl bg-neutral-900 rounded-2xl overflow-hidden shadow-2xl">
            
            <!-- Close Button -->
            <button @click="closeVideo()"
                    class="absolute top-4 right-4 z-10 w-10 h-10 bg-white/10 hover:bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white transition-all duration-300 hover:scale-110 hover:rotate-90">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            
            <!-- Video Player -->
            <div class="aspect-video bg-black">
                <iframe x-show="currentVideo"
                        :src="currentVideo ? currentVideo.url.replace('watch?v=', 'embed/').replace('youtu.be/', 'youtube.com/embed/') : ''"
                        class="w-full h-full"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                </iframe>
            </div>
            
            <!-- Video Info -->
            <div class="p-6 bg-neutral-900 text-white">
                <h3 class="text-2xl font-bold mb-3" style="font-family: 'Crimson Pro', serif;" x-text="currentVideo?.title"></h3>
                
                <div class="flex items-center gap-3 mb-4">
                    <img :src="currentVideo?.user.avatar" 
                         :alt="currentVideo?.user.name"
                         class="w-12 h-12 rounded-full object-cover ring-2 ring-primary-500">
                    <div>
                        <p class="font-semibold" x-text="currentVideo?.user.name"></p>
                        <p class="text-sm text-neutral-400" x-text="currentVideo?.created_at"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
