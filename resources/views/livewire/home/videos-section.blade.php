<div>
    @if($videos && $videos->count() > 0)
    <section class="py-12 md:py-16 bg-neutral-50 dark:bg-neutral-950">
        <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-10 section-title-fade">
                <h2 class="text-4xl md:text-5xl font-bold mb-3 text-neutral-900 dark:text-white" style="font-family: 'Crimson Pro', serif;">
                    {!! __('home.videos_section_title') !!}
                </h2>
                <p class="text-lg text-neutral-600 dark:text-neutral-400 font-medium">{{ __('home.videos_section_subtitle') }}</p>
            </div>

            <!-- Film Strip Container -->
            <div class="film-strip-container">
                <!-- Film Perforations Left -->
                <div class="film-perforation film-perforation-left"></div>
                
                <!-- Film Perforations Right -->
                <div class="film-perforation film-perforation-right"></div>
                
                <!-- Video Slider -->
                <div class="film-frame" 
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
                    
                    <!-- Frame Number Top Left -->
                    <div class="film-frame-number film-frame-number-tl" x-text="'///' + (currentSlide + 1).toString().padStart(2, '0')"></div>
                    
                    <!-- Frame Number Top Right -->
                    <div class="film-frame-number film-frame-number-tr" x-text="(currentSlide + 1).toString().padStart(2, '0') + 'A'"></div>
                    
                    <!-- Frame Number Bottom Left -->
                    <div class="film-frame-number film-frame-number-bl" x-text="'35MM'"></div>
                    
                    <!-- Frame Number Bottom Right -->
                    <div class="film-frame-number film-frame-number-br" x-text="'{{ $videos->count() }}'"></div>
                
                    <!-- Slides Container with aspect ratio wrapper -->
                    <div class="relative aspect-video overflow-hidden bg-black">
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
                                        :directUrl="$video->direct_url ?? null"
                                        :showStats="true" 
                                        :showAuthor="true"
                                        :showSnaps="true"
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
        </div>
    </section>
    
    <style>
    /* ========================================
       FILM STRIP / PELLICOLA CINEMATOGRAFICA
       ======================================== */
    
    /* Main Film Strip Container */
    .film-strip-container {
        position: relative;
        background: #0a0a0a;
        padding: 2rem 5rem;
        border-radius: 1rem;
        box-shadow: 
            0 20px 60px rgba(0, 0, 0, 0.5),
            inset 0 0 30px rgba(0, 0, 0, 0.3);
    }
    
    /* Film Perforations (holes on sides) */
    .film-perforation {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 3rem;
        background: 
            repeating-linear-gradient(
                0deg,
                transparent,
                transparent 8px,
                #0a0a0a 8px,
                #0a0a0a 18px
            );
    }
    
    .film-perforation::before {
        content: '';
        position: absolute;
        top: 13px;
        width: 100%;
        height: calc(100% - 26px);
        background: 
            radial-gradient(circle at center, transparent 6px, #1a1a1a 6px, #1a1a1a 8px, transparent 8px) 
            center / 100% 26px repeat-y;
    }
    
    .film-perforation-left {
        left: 0;
        border-right: 2px solid #2a2a2a;
    }
    
    .film-perforation-right {
        right: 0;
        border-left: 2px solid #2a2a2a;
    }
    
    /* Film Frame (central area) */
    .film-frame {
        position: relative;
        border: 4px solid #1a1a1a;
        border-radius: 0.5rem;
        background: #000;
        box-shadow: 
            0 0 0 2px #2a2a2a,
            inset 0 0 20px rgba(0, 0, 0, 0.8);
    }
    
    /* Frame Numbers (35mm style) */
    .film-frame-number {
        position: absolute;
        font-family: 'Courier New', monospace;
        font-size: 0.75rem;
        font-weight: 700;
        color: #ff6b00;
        letter-spacing: 0.1em;
        z-index: 20;
        text-shadow: 0 0 4px rgba(255, 107, 0, 0.5);
        padding: 0.25rem 0.5rem;
        background: rgba(0, 0, 0, 0.6);
        border-radius: 3px;
    }
    
    .film-frame-number-tl {
        top: 0.5rem;
        left: 0.5rem;
    }
    
    .film-frame-number-tr {
        top: 0.5rem;
        right: 0.5rem;
    }
    
    .film-frame-number-bl {
        bottom: 0.5rem;
        left: 0.5rem;
    }
    
    .film-frame-number-br {
        bottom: 0.5rem;
        right: 0.5rem;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .film-strip-container {
            padding: 1.5rem 3rem;
        }
        
        .film-perforation {
            width: 2rem;
        }
        
        .film-perforation::before {
            background-size: 100% 20px;
        }
        
        .film-frame-number {
            font-size: 0.625rem;
            padding: 0.2rem 0.4rem;
        }
    }
    
    /* Dark mode adjustments */
    :is(.dark .film-strip-container) {
        background: #000000;
        box-shadow: 
            0 20px 60px rgba(0, 0, 0, 0.8),
            inset 0 0 30px rgba(0, 0, 0, 0.5);
    }
    
    :is(.dark .film-frame) {
        border-color: #0a0a0a;
        box-shadow: 
            0 0 0 2px #1a1a1a,
            inset 0 0 20px rgba(0, 0, 0, 0.9);
    }
    </style>
    @endif
</div>
