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
       PHOTO NEGATIVE FILM ROLL / RULLINO FOTOGRAFICO
       ======================================== */
    
    /* Main Film Strip Container - Orange/Amber Film Border */
    .film-strip-container {
        position: relative;
        background: 
            /* Film base gradient (orange/amber) */
            linear-gradient(135deg, 
                #d97a2c 0%,
                #c86820 25%,
                #d97a2c 50%,
                #c86820 75%,
                #d97a2c 100%
            );
        padding: 2.5rem 2.5rem;
        border-radius: 0.5rem;
        box-shadow: 
            0 20px 50px rgba(0, 0, 0, 0.7),
            0 10px 25px rgba(217, 122, 44, 0.2),
            inset 0 0 40px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
        border: 3px solid #a85818;
        /* Subtle film texture */
        background-size: 100% 100%;
    }
    
    .film-strip-container:hover {
        transform: translateY(-4px);
        box-shadow: 
            0 25px 60px rgba(0, 0, 0, 0.8),
            0 15px 30px rgba(217, 122, 44, 0.3),
            inset 0 0 40px rgba(0, 0, 0, 0.2);
    }
    
    /* Film Edge Markers (simulating sprocket holes area) */
    .film-perforation {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 2rem;
        background: linear-gradient(180deg, 
            rgba(0, 0, 0, 0.3) 0%,
            rgba(0, 0, 0, 0.2) 50%,
            rgba(0, 0, 0, 0.3) 100%
        );
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    
    /* Sprocket holes pattern */
    .film-perforation::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 10px;
        height: 100%;
        background-image: 
            repeating-linear-gradient(
                to bottom,
                transparent 0px,
                transparent 10px,
                rgba(0, 0, 0, 0.6) 10px,
                rgba(0, 0, 0, 0.6) 18px,
                transparent 18px,
                transparent 35px
            );
        border-radius: 1px;
    }
    
    .film-perforation-left {
        left: 0;
        border-top-left-radius: 0.5rem;
        border-bottom-left-radius: 0.5rem;
        border-right: 1px solid rgba(0, 0, 0, 0.4);
    }
    
    .film-perforation-right {
        right: 0;
        border-top-right-radius: 0.5rem;
        border-bottom-right-radius: 0.5rem;
        border-left: 1px solid rgba(0, 0, 0, 0.4);
    }
    
    /* Film Frame (negative area) */
    .film-frame {
        position: relative;
        border: 2px solid rgba(0, 0, 0, 0.5);
        border-radius: 0.25rem;
        background: #000;
        box-shadow: 
            inset 0 0 20px rgba(0, 0, 0, 0.8),
            0 4px 12px rgba(0, 0, 0, 0.4);
        overflow: hidden;
    }
    
    /* Film grain and scratches overlay */
    .film-frame::before {
        content: '';
        position: absolute;
        inset: 0;
        background: 
            /* Fine scratches */
            repeating-linear-gradient(
                45deg,
                transparent,
                transparent 100px,
                rgba(255, 255, 255, 0.02) 100px,
                rgba(255, 255, 255, 0.02) 101px
            ),
            repeating-linear-gradient(
                -45deg,
                transparent,
                transparent 150px,
                rgba(255, 255, 255, 0.015) 150px,
                rgba(255, 255, 255, 0.015) 151px
            ),
            /* Film grain */
            repeating-linear-gradient(
                0deg,
                transparent,
                transparent 2px,
                rgba(255, 255, 255, 0.01) 2px,
                rgba(255, 255, 255, 0.01) 4px
            );
        pointer-events: none;
        z-index: 10;
    }
    
    /* Frame Numbers - Photo Negative Style */
    .film-frame-number {
        position: absolute;
        font-family: 'Courier New', monospace;
        font-size: 0.7rem;
        font-weight: 700;
        color: #000;
        letter-spacing: 0.05em;
        z-index: 20;
        background: linear-gradient(135deg, 
            rgba(217, 122, 44, 0.95) 0%,
            rgba(200, 104, 32, 0.95) 100%
        );
        padding: 0.25rem 0.5rem;
        border-radius: 2px;
        box-shadow: 
            0 2px 4px rgba(0, 0, 0, 0.3),
            inset 0 0 8px rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(0, 0, 0, 0.3);
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
        font-size: 0.65rem;
        opacity: 0.8;
    }
    
    .film-frame-number-br {
        bottom: 0.5rem;
        right: 0.5rem;
        font-size: 0.65rem;
        opacity: 0.8;
    }
    
    /* Film edge codes (like real negatives) */
    .film-strip-container::before {
        content: 'KODAK';
        position: absolute;
        top: 0.5rem;
        left: 50%;
        transform: translateX(-50%);
        font-family: 'Arial', sans-serif;
        font-size: 0.65rem;
        font-weight: 900;
        color: rgba(0, 0, 0, 0.4);
        letter-spacing: 0.3em;
    }
    
    .film-strip-container::after {
        content: 'ISO 400';
        position: absolute;
        bottom: 0.5rem;
        left: 50%;
        transform: translateX(-50%);
        font-family: 'Arial', sans-serif;
        font-size: 0.6rem;
        font-weight: 700;
        color: rgba(0, 0, 0, 0.4);
        letter-spacing: 0.2em;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .film-strip-container {
            padding: 2rem 2rem;
        }
        
        .film-perforation {
            width: 1.5rem;
        }
        
        .film-perforation::before {
            width: 8px;
        }
        
        .film-frame-number {
            font-size: 0.65rem;
            padding: 0.2rem 0.4rem;
        }
        
        .film-strip-container::before,
        .film-strip-container::after {
            font-size: 0.55rem;
        }
    }
    
    /* Dark mode - slightly different amber tone */
    :is(.dark .film-strip-container) {
        background: 
            linear-gradient(135deg, 
                #b86820 0%,
                #a85818 25%,
                #b86820 50%,
                #a85818 75%,
                #b86820 100%
            );
        border-color: #8a4810;
        box-shadow: 
            0 20px 50px rgba(0, 0, 0, 0.95),
            0 10px 25px rgba(184, 104, 32, 0.3),
            inset 0 0 40px rgba(0, 0, 0, 0.25);
    }
    
    :is(.dark .film-strip-container:hover) {
        box-shadow: 
            0 25px 60px rgba(0, 0, 0, 1),
            0 15px 30px rgba(184, 104, 32, 0.4),
            inset 0 0 40px rgba(0, 0, 0, 0.3);
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
