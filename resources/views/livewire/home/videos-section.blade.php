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
       FILM STRIP V2 - MORE VISIBLE & REALISTIC
       ======================================== */
    
    /* Main Film Strip Container */
    .film-strip-container {
        position: relative;
        background: linear-gradient(135deg, #1a1a1a 0%, #0d0d0d 100%);
        padding: 3rem 4rem;
        border-radius: 0.75rem;
        box-shadow: 
            0 20px 50px rgba(0, 0, 0, 0.8),
            0 10px 25px rgba(0, 0, 0, 0.6);
        transition: all 0.3s ease;
        border: 1px solid #2a2a2a;
    }
    
    .film-strip-container:hover {
        transform: translateY(-4px);
        box-shadow: 
            0 25px 60px rgba(0, 0, 0, 0.9),
            0 15px 30px rgba(0, 0, 0, 0.7);
    }
    
    /* Film Perforations - LARGER & MORE VISIBLE */
    .film-perforation {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 3rem;
        background: #2a2a2a;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-around;
        padding: 1rem 0;
    }
    
    /* Create actual hole elements */
    .film-perforation::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 100%;
        height: 100%;
        background-image: 
            repeating-linear-gradient(
                to bottom,
                transparent 0px,
                transparent 8px,
                rgba(0, 0, 0, 0.9) 8px,
                rgba(0, 0, 0, 0.9) 10px,
                transparent 10px,
                transparent 25px
            );
    }
    
    .film-perforation::after {
        content: '';
        position: absolute;
        top: 12.5px;
        left: 50%;
        transform: translateX(-50%);
        width: 14px;
        height: calc(100% - 25px);
        background-image: 
            repeating-linear-gradient(
                to bottom,
                #0a0a0a 0px,
                #0a0a0a 6px,
                transparent 6px,
                transparent 25px
            );
        border-radius: 2px;
        box-shadow: 
            inset 0 0 3px rgba(0, 0, 0, 0.8),
            0 0 0 1px rgba(255, 255, 255, 0.05);
    }
    
    .film-perforation-left {
        left: 0;
        border-top-left-radius: 0.75rem;
        border-bottom-left-radius: 0.75rem;
        border-right: 2px solid #0a0a0a;
    }
    
    .film-perforation-right {
        right: 0;
        border-top-right-radius: 0.75rem;
        border-bottom-right-radius: 0.75rem;
        border-left: 2px solid #0a0a0a;
    }
    
    /* Film Frame (central area) */
    .film-frame {
        position: relative;
        border: 4px solid #2a2a2a;
        border-radius: 0.5rem;
        background: #000;
        box-shadow: 
            0 0 0 2px #1a1a1a,
            inset 0 0 30px rgba(0, 0, 0, 0.9);
        overflow: hidden;
    }
    
    /* Add film grain overlay */
    .film-frame::before {
        content: '';
        position: absolute;
        inset: 0;
        background: 
            repeating-linear-gradient(
                0deg,
                transparent,
                transparent 2px,
                rgba(255, 255, 255, 0.02) 2px,
                rgba(255, 255, 255, 0.02) 4px
            ),
            repeating-linear-gradient(
                90deg,
                transparent,
                transparent 2px,
                rgba(255, 255, 255, 0.01) 2px,
                rgba(255, 255, 255, 0.01) 4px
            );
        pointer-events: none;
        z-index: 10;
    }
    
    /* Frame Numbers - LARGER & MORE VISIBLE */
    .film-frame-number {
        position: absolute;
        font-family: 'Courier New', monospace;
        font-size: 0.875rem;
        font-weight: 900;
        color: #ff8c00;
        letter-spacing: 0.15em;
        z-index: 20;
        text-shadow: 
            0 0 8px rgba(255, 140, 0, 0.8),
            0 0 4px rgba(255, 140, 0, 0.6),
            0 2px 4px rgba(0, 0, 0, 0.8);
        padding: 0.4rem 0.7rem;
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.85) 0%, rgba(0, 0, 0, 0.7) 100%);
        border-radius: 4px;
        border: 1px solid rgba(255, 140, 0, 0.3);
        backdrop-filter: blur(4px);
    }
    
    .film-frame-number-tl {
        top: 0.75rem;
        left: 0.75rem;
    }
    
    .film-frame-number-tr {
        top: 0.75rem;
        right: 0.75rem;
    }
    
    .film-frame-number-bl {
        bottom: 0.75rem;
        left: 0.75rem;
    }
    
    .film-frame-number-br {
        bottom: 0.75rem;
        right: 0.75rem;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .film-strip-container {
            padding: 2.5rem 3rem;
        }
        
        .film-perforation {
            width: 2.5rem;
        }
        
        .film-perforation::after {
            width: 12px;
            background-size: 100% 20px;
        }
        
        .film-frame-number {
            font-size: 0.75rem;
            padding: 0.3rem 0.5rem;
        }
    }
    
    /* Dark mode adjustments */
    :is(.dark .film-strip-container) {
        background: linear-gradient(135deg, #0a0a0a 0%, #000000 100%);
        border-color: #1a1a1a;
        box-shadow: 
            0 20px 50px rgba(0, 0, 0, 0.95),
            0 10px 25px rgba(0, 0, 0, 0.8);
    }
    
    :is(.dark .film-strip-container:hover) {
        box-shadow: 
            0 25px 60px rgba(0, 0, 0, 1),
            0 15px 30px rgba(0, 0, 0, 0.9);
    }
    
    :is(.dark .film-perforation) {
        background: #1a1a1a;
    }
    
    :is(.dark .film-frame) {
        border-color: #1a1a1a;
        box-shadow: 
            0 0 0 2px #0a0a0a,
            inset 0 0 30px rgba(0, 0, 0, 0.95);
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
