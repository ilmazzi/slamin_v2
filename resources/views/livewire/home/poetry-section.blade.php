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
        
        /* Inkwell (calamaio) */
        .inkwell {
            position: absolute;
            top: 10%;
            right: 8%;
            width: 60px;
            height: 70px;
            background: 
                /* Glass reflection */
                radial-gradient(ellipse 15px 20px at 30% 30%, rgba(255, 255, 255, 0.4) 0%, transparent 50%),
                /* Ink inside */
                radial-gradient(ellipse 20px 15px at 50% 60%, rgba(20, 30, 50, 0.9) 0%, rgba(30, 40, 60, 0.8) 100%),
                /* Glass body */
                linear-gradient(180deg, 
                    rgba(100, 120, 140, 0.3) 0%,
                    rgba(80, 100, 120, 0.4) 30%,
                    rgba(60, 80, 100, 0.5) 70%,
                    rgba(40, 60, 80, 0.6) 100%
                );
            border-radius: 30% 30% 40% 40% / 25% 25% 50% 50%;
            box-shadow: 
                0 4px 8px rgba(0, 0, 0, 0.3),
                inset 0 2px 4px rgba(255, 255, 255, 0.2);
            opacity: 0.7;
        }
        
        /* Ink stains */
        .ink-stain {
            position: absolute;
            background: radial-gradient(ellipse at center, 
                rgba(20, 30, 50, 0.4) 0%, 
                rgba(30, 40, 60, 0.25) 40%, 
                rgba(40, 50, 70, 0.1) 70%, 
                transparent 100%);
            border-radius: 50%;
            filter: blur(1px);
        }
        
        .ink-stain-1 {
            top: 25%;
            left: 15%;
            width: 40px;
            height: 45px;
            transform: rotate(-25deg);
        }
        
        .ink-stain-2 {
            bottom: 30%;
            right: 20%;
            width: 30px;
            height: 35px;
            transform: rotate(40deg);
        }
        
        .ink-stain-3 {
            top: 60%;
            left: 10%;
            width: 25px;
            height: 30px;
            transform: rotate(-15deg);
        }
        
        /* Quill pen */
        .quill-pen {
            position: absolute;
            bottom: 15%;
            right: 12%;
            width: 120px;
            height: 8px;
            background: linear-gradient(90deg,
                rgba(180, 140, 100, 0.6) 0%,
                rgba(160, 120, 80, 0.5) 40%,
                rgba(140, 100, 60, 0.4) 70%,
                rgba(100, 70, 40, 0.3) 85%,
                transparent 100%
            );
            border-radius: 50% 0 0 50%;
            transform: rotate(-35deg);
            opacity: 0.6;
        }
        
        .quill-pen::before {
            content: '';
            position: absolute;
            right: -10px;
            top: -8px;
            width: 0;
            height: 0;
            border-left: 12px solid rgba(100, 70, 40, 0.35);
            border-top: 12px solid transparent;
            border-bottom: 12px solid transparent;
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
        
        /* SVG Paper Clip */
        .paper-clip {
            position: absolute;
            top: -15px;
            left: 50%;
            width: 50px;
            height: 70px;
            z-index: 10;
            pointer-events: none;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .poetry-card-container:hover .paper-clip {
            transform: translate(-50%, -2px) rotate(0deg) translateX(0px) !important;
        }
    </style>
    @endif
</div>
