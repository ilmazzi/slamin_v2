<div>
    @if($videos && $videos->count() > 0)
    <section>
        <div class="max-w-[90rem] mx-auto px-4 md:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-12 section-title-fade">
                <h2 class="text-4xl md:text-5xl font-bold mb-3 text-neutral-900 dark:text-white" style="font-family: 'Crimson Pro', serif;">
                    {!! __('home.videos_section_title') !!}
                </h2>
                <p class="text-lg text-neutral-600 dark:text-neutral-200 font-medium">{{ __('home.videos_section_subtitle') }}</p>
            </div>

            <!-- Film Strip Horizontal Scroll with Desktop Navigation -->
            <div class="relative" x-data="{ 
                scroll(direction) {
                    const container = this.$refs.scrollContainer;
                    const cards = container.children;
                    if (cards.length === 0) return;
                    
                    const containerRect = container.getBoundingClientRect();
                    const scrollLeft = container.scrollLeft;
                    
                    // Find current visible card
                    let targetCard = null;
                    for (let i = 0; i < cards.length; i++) {
                        const card = cards[i];
                        const cardRect = card.getBoundingClientRect();
                        const cardLeft = card.offsetLeft;
                        
                        if (direction > 0) {
                            // Scroll right: find first card that's partially or fully off-screen to the right
                            if (cardLeft > scrollLeft + containerRect.width - 100) {
                                targetCard = card;
                                break;
                            }
                        } else {
                            // Scroll left: find card to the left of current view
                            if (cardLeft < scrollLeft - 50) {
                                targetCard = card;
                            }
                        }
                    }
                    
                    if (targetCard) {
                        targetCard.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'start' });
                    }
                }
            }">
                <!-- Left Arrow (Desktop Only) - OUTSIDE content -->
                <button @click="scroll(-1)" 
                        class="hidden md:flex absolute -left-16 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white/95 dark:bg-neutral-800/95 backdrop-blur-sm rounded-full shadow-xl hover:scale-110 transition-all duration-300 items-center justify-center text-neutral-900 dark:text-white group">
                    <svg class="w-6 h-6 transform group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                
                <!-- Right Arrow (Desktop Only) - OUTSIDE content -->
                <button @click="scroll(1)" 
                        class="hidden md:flex absolute -right-16 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white/95 dark:bg-neutral-800/95 backdrop-blur-sm rounded-full shadow-xl hover:scale-110 transition-all duration-300 items-center justify-center text-neutral-900 dark:text-white group">
                    <svg class="w-6 h-6 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
                
            <!-- Mobile Scroll Indicator -->
            <div class="md:hidden relative mb-4">
                <div class="flex items-center justify-center gap-2 text-neutral-600 dark:text-neutral-300 text-sm">
                    <svg class="w-5 h-5 animate-bounce-horizontal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                    </svg>
                    <span>Scorri per vedere altro</span>
                </div>
            </div>
            
            <div x-ref="scrollContainer" class="flex gap-6 overflow-x-auto pb-16 pt-12 px-8 md:px-12 scrollbar-hide"
                 style="-webkit-overflow-scrolling: touch;">
                @foreach($videos as $i => $video)
                <?php
                    // Random film strip tilt
                    $tilt = rand(-1, 1);
                ?>
                <div class="w-[92vw] md:w-[700px] flex-shrink-0 fade-scale-item"
                     x-data
                     x-intersect.once="$el.classList.add('animate-fade-in')"
                     style="animation-delay: {{ $i * 0.1 }}s;">
                    
                    <!-- Film Strip Container -->
                    <div class="film-strip-container" style="transform: rotate({{ $tilt }}deg);">
                        <!-- Film Perforations Left - Brown strip -->
                        <div class="film-perforation film-perforation-left">
                            @for($h = 0; $h < 12; $h++)
                            <div class="perforation-hole"></div>
                            @endfor
                        </div>
                        
                        <!-- Film Perforations Right - Brown strip -->
                        <div class="film-perforation film-perforation-right">
                            @for($h = 0; $h < 12; $h++)
                            <div class="perforation-hole"></div>
                            @endfor
                        </div>
                        
                        <!-- Film Edge Codes -->
                        <div class="film-edge-code-top">SLAMIN</div>
                        <div class="film-edge-code-bottom">ISO 400</div>
                        
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
        </div>
    </section>
    
    <style>
    /* ========================================
       PHOTO NEGATIVE FILM ROLL - REALISTIC & TRANSPARENT
       ======================================== */
    
    /* Main Film Strip Container - Brown Amber Semi-Transparent with Glossy Finish */
    .film-strip-container {
        position: relative;
        padding: 3rem 4.5rem;
        /* Semi-transparent brown/amber film with glossy highlights */
        background: 
            /* Glossy highlight (top light reflection) */
            linear-gradient(180deg, 
                rgba(255, 255, 255, 0.15) 0%,
                transparent 15%,
                transparent 85%,
                rgba(0, 0, 0, 0.2) 100%
            ),
            /* Subtle diagonal light streaks (glossy effect) */
            linear-gradient(120deg, 
                transparent 0%,
                transparent 40%,
                rgba(255, 255, 255, 0.08) 48%,
                rgba(255, 255, 255, 0.12) 50%,
                rgba(255, 255, 255, 0.08) 52%,
                transparent 60%,
                transparent 100%
            ),
            /* Film base - semi-transparent brown/amber */
            linear-gradient(135deg, 
                rgba(120, 80, 50, 0.85) 0%,
                rgba(100, 65, 40, 0.88) 25%,
                rgba(110, 72, 45, 0.86) 50%,
                rgba(95, 60, 38, 0.89) 75%,
                rgba(115, 75, 48, 0.87) 100%
            );
        padding: 2.5rem 4rem; /* Increased horizontal padding from 2.5rem to 4rem to accommodate wider strips */
        /* Irregular torn/cut edges at top and bottom */
        clip-path: polygon(
            0% 2%,
            3% 0.5%,
            6% 1.5%,
            10% 0.8%,
            15% 1.2%,
            20% 0.5%,
            25% 1%,
            30% 0.3%,
            35% 0.8%,
            40% 0.5%,
            45% 1%,
            50% 0.4%,
            55% 0.9%,
            60% 0.6%,
            65% 1.2%,
            70% 0.5%,
            75% 0.8%,
            80% 0.4%,
            85% 1%,
            90% 0.6%,
            95% 1.2%,
            100% 0.8%,
            100% 99.2%,
            97% 100%,
            94% 99.5%,
            90% 99.8%,
            85% 100%,
            80% 99.4%,
            75% 99.6%,
            70% 100%,
            65% 99.5%,
            60% 99.8%,
            55% 100%,
            50% 99.4%,
            45% 99.7%,
            40% 100%,
            35% 99.6%,
            30% 99.9%,
            25% 100%,
            20% 99.5%,
            15% 99.8%,
            10% 100%,
            5% 99.6%,
            0% 98.5%
        );
        box-shadow: 
            /* Strong shadows for depth */
            0 20px 50px rgba(0, 0, 0, 0.7),
            0 10px 25px rgba(80, 50, 30, 0.3),
            /* Glossy edge highlights */
            inset 0 1px 0 rgba(255, 255, 255, 0.2),
            inset 0 -1px 0 rgba(0, 0, 0, 0.3),
            /* Inner shadows */
            inset 0 0 40px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        border: none;
        border-left: 2px solid rgba(70, 45, 28, 0.6);
        border-right: 2px solid rgba(70, 45, 28, 0.6);
        backdrop-filter: blur(1px);
        overflow: visible;
    }
    
    /* Light background behind film to show transparency */
    .film-strip-container::after {
        content: '';
        position: absolute;
        inset: -20px;
        background: 
            /* Backlight effect (like lightbox for viewing negatives) */
            radial-gradient(ellipse at center, 
                rgba(255, 255, 240, 0.15) 0%,
                rgba(230, 230, 220, 0.1) 40%,
                transparent 70%
            );
        z-index: -1;
        border-radius: 1rem;
        pointer-events: none;
    }
    
    .film-strip-container:hover {
        transform: translateY(-4px);
        box-shadow: 
            0 25px 60px rgba(0, 0, 0, 0.8),
            0 15px 30px rgba(80, 50, 30, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.25),
            inset 0 -1px 0 rgba(0, 0, 0, 0.35),
            inset 0 0 40px rgba(0, 0, 0, 0.25);
    }
    
    /* Film Edge Markers - Dark BROWN strips with individual holes */
    .film-perforation {
        position: absolute;
        top: -20px;
        bottom: -20px;
        width: 3rem;
        display: flex;
        flex-direction: column;
        justify-content: space-evenly;
        align-items: center;
        padding: 1rem 0;
        /* Dark BROWN edge strip matching film */
        background: 
            linear-gradient(90deg, 
                rgba(255, 255, 255, 0.12) 0%,
                transparent 30%
            ),
            linear-gradient(180deg, 
                rgba(80, 55, 35, 0.95) 0%,
                rgba(70, 48, 30, 0.97) 50%,
                rgba(80, 55, 35, 0.95) 100%
            );
    }
    
    /* Individual hole - LIGHT rectangle with SUBTLE shadows */
    .perforation-hole {
        width: 22px;
        height: 18px;
        /* LIGHT color matching lightbox */
        background: #f0ebe8;
        border-radius: 2px;
        flex-shrink: 0;
        /* SUBTLE shadows for gentle recessed effect */
        box-shadow: 
            /* Lighter shadows - more subtle */
            inset 0 3px 6px rgba(0, 0, 0, 0.35),
            inset 0 1px 3px rgba(0, 0, 0, 0.25),
            inset 0 -1px 2px rgba(0, 0, 0, 0.15),
            /* Softer border */
            inset 0 0 0 1px rgba(0, 0, 0, 0.25);
    }
    
    /* Dark mode - darker hole color */
    :is(.dark .perforation-hole) {
        background: #2a2826;
    }
    
    .film-perforation-left {
        left: 0;
    }
    
    .film-perforation-right {
        right: 0;
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
    
    /* Frame Numbers - Stamped/Marked on film (NO BACKGROUND BOX) */
    .film-frame-number {
        position: absolute;
        font-family: 'Courier New', monospace;
        font-size: 0.7rem;
        font-weight: 900;
        /* White text stamped on film */
        color: rgba(255, 255, 255, 0.95);
        letter-spacing: 0.1em;
        z-index: 20;
        /* NO background - just stamped text */
        background: none;
        padding: 0;
        border: none;
        /* Stamped/embossed effect */
        text-shadow: 
            /* Main shadow for legibility */
            0 1px 3px rgba(0, 0, 0, 0.8),
            /* Subtle emboss effect */
            0 -1px 1px rgba(0, 0, 0, 0.3),
            1px 0 1px rgba(0, 0, 0, 0.2),
            /* Glow for visibility */
            0 0 8px rgba(255, 255, 255, 0.3);
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
    
    /* Film edge codes - White stamped text (NO BACKGROUND) */
    .film-strip-container .film-edge-code-top {
        position: absolute;
        top: 0.5rem;
        left: 50%;
        transform: translateX(-50%);
        font-family: 'Arial', sans-serif;
        font-size: 0.7rem;
        font-weight: 900;
        /* White stamped text */
        color: rgba(255, 255, 255, 0.9);
        letter-spacing: 0.3em;
        z-index: 5;
        /* Stamped effect */
        text-shadow: 
            0 1px 3px rgba(0, 0, 0, 0.8),
            0 0 6px rgba(255, 255, 255, 0.2);
    }
    
    .film-strip-container .film-edge-code-bottom {
        position: absolute;
        bottom: 0.5rem;
        left: 50%;
        transform: translateX(-50%);
        font-family: 'Arial', sans-serif;
        font-size: 0.65rem;
        font-weight: 900;
        /* White stamped text */
        color: rgba(255, 255, 255, 0.9);
        letter-spacing: 0.25em;
        z-index: 5;
        /* Stamped effect */
        text-shadow: 
            0 1px 3px rgba(0, 0, 0, 0.8),
            0 0 6px rgba(255, 255, 255, 0.2);
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .film-strip-container {
            padding: 2.5rem 3.5rem;
        }
        
        .film-perforation {
            width: 2.5rem; /* Increased from 1.5rem to 2.5rem for mobile */
        }
        
        .film-perforation::before {
            width: 16px; /* Increased from 8px to 16px */
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
    
    /* Dark mode - same transparent look, darker tones */
    :is(.dark .film-strip-container) {
        background: 
            linear-gradient(180deg, 
                rgba(255, 255, 255, 0.12) 0%,
                transparent 15%,
                transparent 85%,
                rgba(0, 0, 0, 0.25) 100%
            ),
            linear-gradient(120deg, 
                transparent 0%,
                transparent 40%,
                rgba(255, 255, 255, 0.06) 48%,
                rgba(255, 255, 255, 0.1) 50%,
                rgba(255, 255, 255, 0.06) 52%,
                transparent 60%,
                transparent 100%
            ),
            linear-gradient(135deg, 
                rgba(90, 60, 38, 0.88) 0%,
                rgba(75, 50, 32, 0.9) 25%,
                rgba(82, 55, 35, 0.89) 50%,
                rgba(70, 45, 30, 0.91) 75%,
                rgba(85, 58, 37, 0.9) 100%
            );
        border-color: rgba(50, 35, 22, 0.95);
        box-shadow: 
            0 20px 50px rgba(0, 0, 0, 0.95),
            0 10px 25px rgba(60, 40, 25, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.15),
            inset 0 -1px 0 rgba(0, 0, 0, 0.4),
            inset 0 0 40px rgba(0, 0, 0, 0.3);
    }
    
    :is(.dark .film-strip-container:hover) {
        box-shadow: 
            0 25px 60px rgba(0, 0, 0, 1),
            0 15px 30px rgba(60, 40, 25, 0.5),
            inset 0 1px 0 rgba(255, 255, 255, 0.2),
            inset 0 -1px 0 rgba(0, 0, 0, 0.45),
            inset 0 0 40px rgba(0, 0, 0, 0.35);
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
    
    /* Smaller play button for film strips */
    .film-frame .plyr__control--overlaid {
        transform: scale(0.5) !important;
        opacity: 0.9 !important;
    }
    
    .film-frame .plyr__control--overlaid:hover {
        transform: scale(0.55) !important;
        opacity: 1 !important;
    }
    </style>
    @endif
</div>
