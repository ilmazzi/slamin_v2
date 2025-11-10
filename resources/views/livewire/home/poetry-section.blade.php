<div>
    @if($poems && $poems->count() > 0)
    {{-- Wooden Desk Background Section --}}
    <div class="wooden-desk-section -mx-4 md:-mx-6 lg:-mx-8 px-4 md:px-6 lg:px-8 py-12">
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 pt-8 pb-4">
        @foreach($poems->take(3) as $i => $poem)
        <?php
            // Random clip properties per card
            $clipRotation = rand(-8, 8);
            $clipOffsetX = rand(-15, 15);
            $clipType = rand(0, 1) ? 'silver' : 'gold'; // Alternate silver/gold clips
        ?>
        <div class="h-full poetry-card-container" 
             x-data 
             x-intersect.once="$el.classList.add('animate-fade-in')" 
             style="animation-delay: {{ $i * 0.1 }}s">
            
            {{-- Paper Clip at top --}}
            <div class="paper-clip paper-clip-{{ $clipType }}" 
                 style="transform: translate(calc(-50% + {{ $clipOffsetX }}px), 0) rotate({{ $clipRotation }}deg);"></div>
            
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
    
    <div class="text-center mt-10">
        <x-ui.buttons.primary :href="route('poems.index')" variant="outline" size="md" icon="M9 5l7 7-7 7">
            {{ __('home.all_poems_button') }}
        </x-ui.buttons.primary>
    </div>
    </div>
    
    <style>
        @keyframes fade-in { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        .animate-fade-in { animation: fade-in 0.5s ease-out forwards; opacity: 0; }
        
        /* ============================================
           WOODEN DESK BACKGROUND
           ============================================ */
        
        .wooden-desk-section {
            position: relative;
            background: 
                /* Wood grain texture (SVG pattern) */
                url("data:image/svg+xml,%3Csvg width='400' height='400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='wood'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.02 0.8' numOctaves='5' seed='2' /%3E%3CfeColorMatrix type='saturate' values='0.3'/%3E%3C/filter%3E%3Crect width='400' height='400' filter='url(%23wood)' opacity='0.15'/%3E%3C/svg%3E"),
                /* Fine wood texture overlay */
                repeating-linear-gradient(
                    90deg,
                    rgba(120, 90, 60, 0.03) 0px,
                    transparent 1px,
                    transparent 2px,
                    rgba(120, 90, 60, 0.03) 3px
                ),
                /* Wood color gradient */
                linear-gradient(160deg,
                    #c9a87c 0%,
                    #b89968 20%,
                    #a88a5c 40%,
                    #b89968 60%,
                    #c9a87c 80%,
                    #d4b58a 100%
                );
            box-shadow: 
                inset 0 4px 12px rgba(0, 0, 0, 0.1),
                inset 0 -4px 12px rgba(0, 0, 0, 0.08);
        }
        
        :is(.dark .wooden-desk-section) {
            background: 
                url("data:image/svg+xml,%3Csvg width='400' height='400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='wood'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.02 0.8' numOctaves='5' seed='2' /%3E%3CfeColorMatrix type='saturate' values='0.3'/%3E%3C/filter%3E%3Crect width='400' height='400' filter='url(%23wood)' opacity='0.2'/%3E%3C/svg%3E"),
                repeating-linear-gradient(
                    90deg,
                    rgba(80, 60, 40, 0.05) 0px,
                    transparent 1px,
                    transparent 2px,
                    rgba(80, 60, 40, 0.05) 3px
                ),
                linear-gradient(160deg,
                    #6b5542 0%,
                    #5a4636 20%,
                    #4a3a2e 40%,
                    #5a4636 60%,
                    #6b5542 80%,
                    #7a6450 100%
                );
        }
        
        /* ============================================
           ARCHIVE PERSONAL EFFECT - PAPER CLIPS
           ============================================ */
        
        .poetry-card-container {
            position: relative;
            padding-top: 32px;
        }
        
        .archive-paper {
            position: relative;
            height: 100%;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .poetry-card-container:hover .archive-paper {
            transform: translateY(-8px);
            filter: drop-shadow(0 12px 24px rgba(0, 0, 0, 0.25));
        }
        
        /* Paper Clip Effect - LARGE & VISIBLE */
        .paper-clip {
            position: absolute;
            top: -8px;
            left: 50%;
            width: 70px;
            height: 90px;
            z-index: 10;
            pointer-events: none;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .poetry-card-container:hover .paper-clip {
            transform: translate(-50%, 0) rotate(0deg) !important;
        }
        
        /* Silver Clip - LARGE & BRIGHT */
        .paper-clip-silver {
            background: 
                /* Inner wire loop (darker) */
                radial-gradient(ellipse 12px 26px at 50% 28%, transparent 70%, rgba(110, 120, 135, 1) 71%, rgba(110, 120, 135, 1) 100%),
                radial-gradient(ellipse 12px 26px at 50% 72%, transparent 70%, rgba(110, 120, 135, 1) 71%, rgba(110, 120, 135, 1) 100%),
                /* Outer wire body */
                radial-gradient(ellipse 20px 32px at 50% 28%, transparent 65%, rgba(170, 180, 195, 0.98) 66%, rgba(210, 220, 235, 1) 80%, rgba(170, 180, 195, 0.98) 100%),
                radial-gradient(ellipse 20px 32px at 50% 72%, transparent 65%, rgba(170, 180, 195, 0.98) 66%, rgba(210, 220, 235, 1) 80%, rgba(170, 180, 195, 0.98) 100%),
                /* Center bar */
                linear-gradient(180deg,
                    rgba(190, 200, 215, 1) 0%,
                    rgba(220, 230, 245, 1) 20%,
                    rgba(160, 170, 185, 0.98) 50%,
                    rgba(220, 230, 245, 1) 80%,
                    rgba(190, 200, 215, 1) 100%
                );
            filter: drop-shadow(0 3px 6px rgba(0, 0, 0, 0.4));
        }
        
        /* Gold/Brass Clip - LARGE & BRIGHT */
        .paper-clip-gold {
            background: 
                /* Inner wire loop */
                radial-gradient(ellipse 12px 26px at 50% 28%, transparent 70%, rgba(145, 115, 55, 1) 71%, rgba(145, 115, 55, 1) 100%),
                radial-gradient(ellipse 12px 26px at 50% 72%, transparent 70%, rgba(145, 115, 55, 1) 71%, rgba(145, 115, 55, 1) 100%),
                /* Outer wire body */
                radial-gradient(ellipse 20px 32px at 50% 28%, transparent 65%, rgba(200, 165, 80, 0.98) 66%, rgba(235, 200, 115, 1) 80%, rgba(200, 165, 80, 0.98) 100%),
                radial-gradient(ellipse 20px 32px at 50% 72%, transparent 65%, rgba(200, 165, 80, 0.98) 66%, rgba(235, 200, 115, 1) 80%, rgba(200, 165, 80, 0.98) 100%),
                /* Center bar */
                linear-gradient(180deg,
                    rgba(215, 175, 90, 1) 0%,
                    rgba(240, 205, 125, 1) 20%,
                    rgba(185, 150, 70, 0.98) 50%,
                    rgba(240, 205, 125, 1) 80%,
                    rgba(215, 175, 90, 1) 100%
                );
            filter: drop-shadow(0 3px 6px rgba(0, 0, 0, 0.4));
        }
        
        /* Dark mode adjustments */
        :is(.dark .paper-clip-silver) {
            background: 
                radial-gradient(ellipse 12px 26px at 50% 28%, transparent 70%, rgba(100, 110, 125, 0.95) 71%, rgba(100, 110, 125, 0.95) 100%),
                radial-gradient(ellipse 12px 26px at 50% 72%, transparent 70%, rgba(100, 110, 125, 0.95) 71%, rgba(100, 110, 125, 0.95) 100%),
                radial-gradient(ellipse 20px 32px at 50% 28%, transparent 65%, rgba(150, 160, 175, 0.92) 66%, rgba(180, 190, 205, 0.95) 80%, rgba(150, 160, 175, 0.92) 100%),
                radial-gradient(ellipse 20px 32px at 50% 72%, transparent 65%, rgba(150, 160, 175, 0.92) 66%, rgba(180, 190, 205, 0.95) 80%, rgba(150, 160, 175, 0.92) 100%),
                linear-gradient(180deg,
                    rgba(170, 180, 195, 0.95) 0%,
                    rgba(200, 210, 225, 0.95) 20%,
                    rgba(150, 160, 175, 0.92) 50%,
                    rgba(200, 210, 225, 0.95) 80%,
                    rgba(170, 180, 195, 0.95) 100%
                );
        }
        
        :is(.dark .paper-clip-gold) {
            background: 
                radial-gradient(ellipse 12px 26px at 50% 28%, transparent 70%, rgba(125, 95, 50, 0.95) 71%, rgba(125, 95, 50, 0.95) 100%),
                radial-gradient(ellipse 12px 26px at 50% 72%, transparent 70%, rgba(125, 95, 50, 0.95) 71%, rgba(125, 95, 50, 0.95) 100%),
                radial-gradient(ellipse 20px 32px at 50% 28%, transparent 65%, rgba(170, 140, 70, 0.92) 66%, rgba(200, 170, 95, 0.95) 80%, rgba(170, 140, 70, 0.92) 100%),
                radial-gradient(ellipse 20px 32px at 50% 72%, transparent 65%, rgba(170, 140, 70, 0.92) 66%, rgba(200, 170, 95, 0.95) 80%, rgba(170, 140, 70, 0.92) 100%),
                linear-gradient(180deg,
                    rgba(180, 150, 80, 0.95) 0%,
                    rgba(210, 180, 105, 0.95) 20%,
                    rgba(160, 130, 65, 0.92) 50%,
                    rgba(210, 180, 105, 0.95) 80%,
                    rgba(180, 150, 80, 0.95) 100%
                );
        }
    </style>
    @endif
</div>
