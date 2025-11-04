<div>
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
                
                <!-- Slides Container -->
                <div class="relative overflow-hidden rounded-3xl shadow-2xl">
                    @foreach($videos as $index => $video)
                    <div x-show="currentSlide === {{ $index }}"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 translate-x-full"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100 translate-x-0"
                         x-transition:leave-end="opacity-0 -translate-x-full"
                         class="relative aspect-video bg-neutral-900"
                         style="{{ $index !== 0 ? 'display: none;' : '' }}">
                        
                        <!-- Video Thumbnail -->
                        @if($video->thumbnail)
                        <img src="{{ $video->thumbnail }}" 
                             alt="{{ $video->title }}" 
                             class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full bg-gradient-to-br from-primary-600 to-primary-800 flex items-center justify-center">
                            <svg class="w-24 h-24 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        @endif
                        
                        <!-- Dark Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                        
                        <!-- Play Button -->
                        <div class="absolute inset-0 flex items-center justify-center group cursor-pointer">
                            <div class="w-20 h-20 bg-white/95 backdrop-blur-sm rounded-full flex items-center justify-center shadow-2xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-10 h-10 text-primary-600 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Video Info Overlay (Bottom) -->
                        <div class="absolute bottom-0 left-0 right-0 p-6 md:p-8 text-white">
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
                            
                            <!-- Stats - Using Reusable Components -->
                            <div class="flex items-center gap-6 text-white/90">
                                <!-- Views -->
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <span class="font-medium">{{ number_format($video->view_count ?? 0) }}</span>
                                </div>
                                
                                <!-- Like Button Component -->
                                <div class="[&_button]:!text-white/90 [&_button:hover]:!text-white [&_span]:!text-white/90">
                                    <x-like-button 
                                        :itemId="$video->id"
                                        itemType="video"
                                        :isLiked="false"
                                        :likesCount="$video->like_count ?? 0"
                                        size="md" />
                                </div>
                                
                                <!-- Comment Button Component -->
                                <div class="[&_button]:!text-white/90 [&_button:hover]:!text-white [&_span]:!text-white/90">
                                    <x-comment-button 
                                        :itemId="$video->id"
                                        itemType="video"
                                        :commentsCount="$video->comment_count ?? 0"
                                        size="md" />
                                </div>
                                
                                <!-- Share Button Component -->
                                <div class="[&_button]:!text-white/90 [&_button:hover]:!text-white [&_button]:hover:!opacity-100">
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
</div>
