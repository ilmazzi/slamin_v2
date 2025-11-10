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
