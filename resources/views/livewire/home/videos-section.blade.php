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
                
                <!-- Slides Container with aspect ratio wrapper -->
                <div class="relative aspect-video overflow-hidden rounded-3xl shadow-2xl bg-neutral-900">
                    @foreach($videos as $index => $video)
                    <div x-show="currentSlide === {{ $index }}"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 translate-x-full"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100 translate-x-0"
                         x-transition:leave-end="opacity-0 -translate-x-full"
                         class="absolute inset-0 w-full h-full"
                         style="{{ $index !== 0 ? 'display: none;' : '' }}">
                        
                        <!-- REUSABLE VIDEO PLAYER COMPONENT -->
                        <x-video-player :video="$video" 
                                        :showStats="true" 
                                        :showAuthor="true"
                                        size="full"
                                        class="w-full h-full" />
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
