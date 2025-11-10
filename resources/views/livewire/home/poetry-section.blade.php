<div>
    @if($poems && $poems->count() > 0)
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="text-center mb-12">
            <h2 class="text-4xl md:text-5xl font-bold mb-3 text-neutral-900 dark:text-white" style="font-family: 'Crimson Pro', serif; text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">
                {!! __('home.poetry_section_title') !!}
            </h2>
            <p class="text-lg text-neutral-700 dark:text-neutral-300">
                {{ __('home.poetry_section_subtitle') }}
            </p>
        </div>

        {{-- Decorative Elements (Inkwell & Ink Stains) --}}
        <div class="decorative-elements">
            {{-- Inkwell --}}
            <div class="inkwell"></div>
            {{-- Ink stains scattered --}}
            <div class="ink-stain ink-stain-1"></div>
            <div class="ink-stain ink-stain-2"></div>
            <div class="ink-stain ink-stain-3"></div>
            {{-- Quill pen --}}
            <div class="quill-pen"></div>
        </div>

        {{-- Poetry Cards Grid --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10 pt-8 pb-4">
            @foreach($poems->take(3) as $i => $poem)
            <?php
                // Random clip properties per card
                $clipRotation = rand(-12, 12);
                $clipOffsetX = rand(-20, 20);
                $clipType = rand(0, 1) ? 'silver' : 'gold'; // Alternate silver/gold clips
            ?>
            <div class="poetry-card-container" 
                 x-data 
                 x-intersect.once="$el.classList.add('animate-fade-in')" 
                 style="animation-delay: {{ $i * 0.1 }}s">
                
                {{-- METAL Paper Clip at top --}}
                <svg class="paper-clip paper-clip-{{ $clipType }}" 
                     style="transform: translate(-50%, 0) rotate({{ $clipRotation }}deg) translateX({{ $clipOffsetX }}px);"
                     viewBox="0 0 40 60" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="metal-{{ $clipType }}-{{ $i }}" x1="0%" y1="0%" x2="100%" y2="0%">
                            @if($clipType === 'silver')
                                <stop offset="0%" style="stop-color:#b0b8c0;stop-opacity:1" />
                                <stop offset="30%" style="stop-color:#e8f0f8;stop-opacity:1" />
                                <stop offset="50%" style="stop-color:#c0c8d0;stop-opacity:1" />
                                <stop offset="70%" style="stop-color:#e8f0f8;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#b0b8c0;stop-opacity:1" />
                            @else
                                <stop offset="0%" style="stop-color:#c89860;stop-opacity:1" />
                                <stop offset="30%" style="stop-color:#f0d890;stop-opacity:1" />
                                <stop offset="50%" style="stop-color:#d8b070;stop-opacity:1" />
                                <stop offset="70%" style="stop-color:#f0d890;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#c89860;stop-opacity:1" />
                            @endif
                        </linearGradient>
                        <filter id="shadow-{{ $i }}">
                            <feDropShadow dx="0" dy="2" stdDeviation="2" flood-opacity="0.4"/>
                        </filter>
                    </defs>
                    <path d="M 15,10 Q 10,10 10,15 L 10,35 Q 10,45 15,45 L 25,45 Q 30,45 30,35 L 30,20 Q 30,10 20,10 L 18,10 Q 15,10 15,13 L 15,32 Q 15,37 18,37 L 22,37 Q 25,37 25,32 L 25,20" 
                          fill="none" 
                          stroke="url(#metal-{{ $clipType }}-{{ $i }})" 
                          stroke-width="3.5" 
                          stroke-linecap="round"
                          filter="url(#shadow-{{ $i }})" />
                </svg>
                
                {{-- Poem Card with archive paper effect --}}
                <div class="archive-paper">
                    <livewire:poems.poem-card 
                        :poem="$poem" 
                        :show-actions="true"
                        :key="'home-poem-'.$poem->id" 
                        wire:key="home-poem-{{ $poem->id }}" />
                </div>
            </div>
            @endforeach
        </div>

        {{-- CTA Button --}}
        <div class="text-center mt-12">
            <x-ui.buttons.primary :href="route('poems.index')" variant="outline" size="md" icon="M9 5l7 7-7 7">
                {{ __('home.all_poems_button') }}
            </x-ui.buttons.primary>
        </div>
    </div>
    
    <style>
        @keyframes fade-in { 
            from { opacity: 0; transform: translateY(20px); } 
            to { opacity: 1; transform: translateY(0); } 
        }
        .animate-fade-in { 
            animation: fade-in 0.6s ease-out forwards; 
            opacity: 0; 
        }
        
        /* ============================================
           DECORATIVE POETIC ELEMENTS
           ============================================ */
        
        .decorative-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
        }
        
        /* Inkwell (calamaio) - 3D REALISTIC */
        .inkwell {
            position: absolute;
            top: 8%;
            right: 10%;
            width: 80px;
            height: 90px;
            background: 
                /* Strong white reflection */
                radial-gradient(ellipse 20px 25px at 35% 25%, rgba(255, 255, 255, 0.85) 0%, rgba(255, 255, 255, 0.3) 40%, transparent 60%),
                /* Dark ink inside (VERY visible) */
                radial-gradient(ellipse 28px 20px at 50% 55%, rgba(10, 15, 30, 1) 0%, rgba(15, 20, 35, 0.95) 60%, transparent 80%),
                /* Glass tint */
                radial-gradient(ellipse 35px 40px at 50% 50%, rgba(100, 140, 180, 0.15) 0%, rgba(80, 120, 160, 0.2) 50%, transparent 100%),
                /* Main glass body with borders */
                linear-gradient(180deg, 
                    rgba(60, 80, 100, 0.7) 0%,
                    rgba(70, 90, 110, 0.8) 20%,
                    rgba(50, 70, 90, 0.85) 50%,
                    rgba(40, 60, 80, 0.9) 80%,
                    rgba(30, 50, 70, 0.95) 100%
                );
            border-radius: 35% 35% 45% 45% / 30% 30% 50% 50%;
            box-shadow: 
                0 6px 12px rgba(0, 0, 0, 0.5),
                0 3px 6px rgba(0, 0, 0, 0.3),
                inset 0 3px 8px rgba(255, 255, 255, 0.3),
                inset 0 -3px 8px rgba(0, 0, 0, 0.4);
            border: 2px solid rgba(40, 60, 80, 0.6);
        }
        
        .inkwell::after {
            content: '';
            position: absolute;
            top: 15%;
            left: 15%;
            width: 25px;
            height: 30px;
            background: radial-gradient(ellipse at center, rgba(255, 255, 255, 0.6) 0%, transparent 60%);
            border-radius: 50%;
            transform: rotate(-20deg);
        }
        
        /* Ink stains - VERY VISIBLE */
        .ink-stain {
            position: absolute;
            background: 
                /* Dark core */
                radial-gradient(ellipse at 40% 40%, 
                    rgba(15, 20, 35, 0.85) 0%,
                    rgba(20, 30, 50, 0.75) 25%,
                    rgba(30, 40, 60, 0.55) 50%,
                    rgba(40, 50, 70, 0.35) 70%,
                    rgba(50, 60, 80, 0.15) 85%,
                    transparent 100%
                ),
                /* Splatter texture */
                radial-gradient(circle at 70% 30%, rgba(10, 15, 25, 0.6) 0%, transparent 40%),
                radial-gradient(circle at 20% 70%, rgba(10, 15, 25, 0.5) 0%, transparent 35%);
            border-radius: 50%;
            filter: blur(0.5px);
        }
        
        .ink-stain::before {
            content: '';
            position: absolute;
            top: 20%;
            left: 20%;
            width: 35%;
            height: 35%;
            background: radial-gradient(circle, rgba(5, 10, 20, 0.7) 0%, transparent 60%);
            border-radius: 50%;
        }
        
        .ink-stain-1 {
            top: 20%;
            left: 12%;
            width: 55px;
            height: 60px;
            transform: rotate(-25deg);
        }
        
        .ink-stain-2 {
            bottom: 25%;
            right: 18%;
            width: 45px;
            height: 50px;
            transform: rotate(40deg);
        }
        
        .ink-stain-3 {
            top: 55%;
            left: 8%;
            width: 35px;
            height: 40px;
            transform: rotate(-15deg);
        }
        
        /* Quill pen - MORE VISIBLE */
        .quill-pen {
            position: absolute;
            bottom: 12%;
            right: 10%;
            width: 140px;
            height: 10px;
            background: linear-gradient(90deg,
                rgba(160, 120, 85, 0.85) 0%,
                rgba(140, 100, 70, 0.75) 30%,
                rgba(120, 85, 60, 0.65) 60%,
                rgba(90, 65, 45, 0.5) 80%,
                rgba(70, 50, 35, 0.3) 90%,
                transparent 100%
            );
            border-radius: 50% 0 0 50%;
            transform: rotate(-35deg);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .quill-pen::before {
            content: '';
            position: absolute;
            right: -12px;
            top: -10px;
            width: 0;
            height: 0;
            border-left: 15px solid rgba(80, 60, 40, 0.65);
            border-top: 15px solid transparent;
            border-bottom: 15px solid transparent;
        }
        
        .quill-pen::after {
            content: '';
            position: absolute;
            left: 10%;
            top: 50%;
            transform: translateY(-50%);
            width: 60%;
            height: 2px;
            background: linear-gradient(90deg, rgba(100, 70, 50, 0.4) 0%, transparent 100%);
        }
        
        /* ============================================
           POETRY CARDS WITH METAL CLIPS
           ============================================ */
        
        .poetry-card-container {
            position: relative;
            padding-top: 40px;
        }
        
        .archive-paper {
            position: relative;
            height: 100%;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .poetry-card-container:hover .archive-paper {
            transform: translateY(-12px) scale(1.02);
            filter: drop-shadow(0 16px 32px rgba(0, 0, 0, 0.3));
        }
        
        /* SVG Paper Clip - OVERLAPPING CARD */
        .paper-clip {
            position: absolute;
            top: 10px; /* Overlaps card top */
            left: 50%;
            width: 55px;
            height: 75px;
            z-index: 20; /* Above card */
            pointer-events: none;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.35));
        }
        
        .poetry-card-container:hover .paper-clip {
            transform: translate(-50%, -2px) rotate(0deg) translateX(0px) scale(1.05) !important;
            filter: drop-shadow(0 6px 12px rgba(0, 0, 0, 0.4));
        }
        
        /* Card z-index */
        .archive-paper {
            z-index: 10;
        }
    </style>
    @endif
</div>
