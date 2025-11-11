<div>
    @if($videos && $videos->count() > 0)
    <section>
        <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-12 section-title-fade">
                <h2 class="text-4xl md:text-5xl font-bold mb-3 text-white" style="font-family: 'Crimson Pro', serif;">
                    {!! __('home.videos_section_title') !!}
                </h2>
                <p class="text-lg text-neutral-200 font-medium">{{ __('home.videos_section_subtitle') }}</p>
            </div>

            <!-- Film Strip Horizontal Scroll -->
            <div class="flex gap-6 overflow-x-auto pb-12 pt-8 scrollbar-hide"
                 style="-webkit-overflow-scrolling: touch;">
                @foreach($videos as $i => $video)
                <?php
                    // Random film strip tilt
                    $tilt = rand(-1, 1);
                ?>
                <div class="w-[85vw] md:w-[600px] flex-shrink-0 fade-scale-item"
                     x-data
                     x-intersect.once="$el.classList.add('animate-fade-in')"
                     style="animation-delay: {{ $i * 0.1 }}s;">
                    
                    <!-- Film Strip Container -->
                    <div class="film-strip-container" style="transform: rotate({{ $tilt }}deg);">
                        <!-- Film Perforations Left -->
                        <div class="film-perforation film-perforation-left"></div>
                        
                        <!-- Film Perforations Right -->
                        <div class="film-perforation film-perforation-right"></div>
                        
                        <!-- Film Frame -->
                        <div class="film-frame">
                            <!-- Frame Numbers -->
                            <div class="film-frame-number film-frame-number-tl">///{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</div>
                            <div class="film-frame-number film-frame-number-tr">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}A</div>
                            <div class="film-frame-number film-frame-number-bl">35MM</div>
                            <div class="film-frame-number film-frame-number-br">{{ $videos->count() }}</div>
                        
                            <!-- Video Container -->
                            <div class="relative aspect-video overflow-hidden bg-black">
                                <!-- REUSABLE VIDEO PLAYER COMPONENT -->
                                <x-video-player :video="$video" 
                                                :directUrl="$video->direct_url ?? null"
                                                :showStats="true" 
                                                :showAuthor="true"
                                                :showSnaps="true"
                                                size="full"
                                                class="w-full h-full" />
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    
    <style>
    /* ========================================
       FILM STRIP / PELLICOLA CINEMATOGRAFICA
       HORIZONTAL SCROLL VERSION
       ======================================== */
    
    /* Main Film Strip Container */
    .film-strip-container {
        position: relative;
        background: #0a0a0a;
        padding: 1.5rem 3.5rem;
        border-radius: 1rem;
        box-shadow: 
            0 12px 40px rgba(0, 0, 0, 0.6),
            inset 0 0 30px rgba(0, 0, 0, 0.3);
        transition: all 0.3s ease;
    }
    
    .film-strip-container:hover {
        box-shadow: 
            0 16px 50px rgba(0, 0, 0, 0.7),
            inset 0 0 30px rgba(0, 0, 0, 0.4);
    }
    
    /* Film Perforations (holes on sides) */
    .film-perforation {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 2.5rem;
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
            radial-gradient(circle at center, transparent 5px, #1a1a1a 5px, #1a1a1a 7px, transparent 7px) 
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
        border: 3px solid #1a1a1a;
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
        font-size: 0.7rem;
        font-weight: 700;
        color: #ff6b00;
        letter-spacing: 0.1em;
        z-index: 20;
        text-shadow: 0 0 4px rgba(255, 107, 0, 0.5);
        padding: 0.2rem 0.5rem;
        background: rgba(0, 0, 0, 0.6);
        border-radius: 3px;
    }
    
    .film-frame-number-tl {
        top: 0.4rem;
        left: 0.4rem;
    }
    
    .film-frame-number-tr {
        top: 0.4rem;
        right: 0.4rem;
    }
    
    .film-frame-number-bl {
        bottom: 0.4rem;
        left: 0.4rem;
    }
    
    .film-frame-number-br {
        bottom: 0.4rem;
        right: 0.4rem;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .film-strip-container {
            padding: 1.2rem 2.5rem;
        }
        
        .film-perforation {
            width: 2rem;
        }
        
        .film-perforation::before {
            background-size: 100% 20px;
        }
        
        .film-frame-number {
            font-size: 0.6rem;
            padding: 0.15rem 0.35rem;
        }
    }
    
    /* Dark mode adjustments */
    :is(.dark .film-strip-container) {
        background: #000000;
        box-shadow: 
            0 12px 40px rgba(0, 0, 0, 0.8),
            inset 0 0 30px rgba(0, 0, 0, 0.5);
    }
    
    :is(.dark .film-strip-container:hover) {
        box-shadow: 
            0 16px 50px rgba(0, 0, 0, 0.9),
            inset 0 0 30px rgba(0, 0, 0, 0.6);
    }
    
    :is(.dark .film-frame) {
        border-color: #0a0a0a;
        box-shadow: 
            0 0 0 2px #1a1a1a,
            inset 0 0 20px rgba(0, 0, 0, 0.9);
    }
    
    /* Fade-in animation */
    @keyframes fade-in { 
        from { opacity: 0; transform: scale(0.95); } 
        to { opacity: 1; transform: scale(1); } 
    }
    .animate-fade-in { 
        animation: fade-in 0.5s ease-out forwards; 
        opacity: 0; 
    }
    </style>
    @endif
</div>
