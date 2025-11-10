<div>
    @if($poems && $poems->count() > 0)
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
    
    <style>
        @keyframes fade-in { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        .animate-fade-in { animation: fade-in 0.5s ease-out forwards; opacity: 0; }
        
        /* ============================================
           ARCHIVE PERSONAL EFFECT - PAPER CLIPS
           ============================================ */
        
        .poetry-card-container {
            position: relative;
            padding-top: 20px;
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
        
        /* Paper Clip Effect */
        .paper-clip {
            position: absolute;
            top: -5px;
            left: 50%;
            width: 48px;
            height: 60px;
            z-index: 10;
            pointer-events: none;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .poetry-card-container:hover .paper-clip {
            transform: translate(-50%, 0) rotate(0deg) !important;
        }
        
        /* Silver Clip */
        .paper-clip-silver {
            background: 
                /* Inner wire loop (darker) */
                radial-gradient(ellipse 8px 18px at 50% 30%, transparent 70%, rgba(140, 150, 160, 0.95) 71%, rgba(140, 150, 160, 0.95) 100%),
                radial-gradient(ellipse 8px 18px at 50% 70%, transparent 70%, rgba(140, 150, 160, 0.95) 71%, rgba(140, 150, 160, 0.95) 100%),
                /* Outer wire body */
                radial-gradient(ellipse 14px 22px at 50% 30%, transparent 65%, rgba(180, 190, 200, 0.9) 66%, rgba(200, 210, 220, 0.92) 80%, rgba(180, 190, 200, 0.9) 100%),
                radial-gradient(ellipse 14px 22px at 50% 70%, transparent 65%, rgba(180, 190, 200, 0.9) 66%, rgba(200, 210, 220, 0.92) 80%, rgba(180, 190, 200, 0.9) 100%),
                /* Center bar */
                linear-gradient(180deg,
                    rgba(200, 210, 220, 0.95) 0%,
                    rgba(220, 230, 240, 0.92) 20%,
                    rgba(180, 190, 200, 0.9) 50%,
                    rgba(220, 230, 240, 0.92) 80%,
                    rgba(200, 210, 220, 0.95) 100%
                );
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
        }
        
        /* Gold/Brass Clip */
        .paper-clip-gold {
            background: 
                /* Inner wire loop */
                radial-gradient(ellipse 8px 18px at 50% 30%, transparent 70%, rgba(160, 130, 70, 0.95) 71%, rgba(160, 130, 70, 0.95) 100%),
                radial-gradient(ellipse 8px 18px at 50% 70%, transparent 70%, rgba(160, 130, 70, 0.95) 71%, rgba(160, 130, 70, 0.95) 100%),
                /* Outer wire body */
                radial-gradient(ellipse 14px 22px at 50% 30%, transparent 65%, rgba(200, 170, 90, 0.9) 66%, rgba(220, 190, 110, 0.92) 80%, rgba(200, 170, 90, 0.9) 100%),
                radial-gradient(ellipse 14px 22px at 50% 70%, transparent 65%, rgba(200, 170, 90, 0.9) 66%, rgba(220, 190, 110, 0.92) 80%, rgba(200, 170, 90, 0.9) 100%),
                /* Center bar */
                linear-gradient(180deg,
                    rgba(210, 180, 100, 0.95) 0%,
                    rgba(230, 200, 120, 0.92) 20%,
                    rgba(190, 160, 80, 0.9) 50%,
                    rgba(230, 200, 120, 0.92) 80%,
                    rgba(210, 180, 100, 0.95) 100%
                );
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
        }
        
        /* Dark mode adjustments */
        :is(.dark .paper-clip-silver) {
            background: 
                radial-gradient(ellipse 8px 18px at 50% 30%, transparent 70%, rgba(120, 130, 140, 0.9) 71%, rgba(120, 130, 140, 0.9) 100%),
                radial-gradient(ellipse 8px 18px at 50% 70%, transparent 70%, rgba(120, 130, 140, 0.9) 71%, rgba(120, 130, 140, 0.9) 100%),
                radial-gradient(ellipse 14px 22px at 50% 30%, transparent 65%, rgba(160, 170, 180, 0.85) 66%, rgba(180, 190, 200, 0.88) 80%, rgba(160, 170, 180, 0.85) 100%),
                radial-gradient(ellipse 14px 22px at 50% 70%, transparent 65%, rgba(160, 170, 180, 0.85) 66%, rgba(180, 190, 200, 0.88) 80%, rgba(160, 170, 180, 0.85) 100%),
                linear-gradient(180deg,
                    rgba(180, 190, 200, 0.9) 0%,
                    rgba(200, 210, 220, 0.88) 20%,
                    rgba(160, 170, 180, 0.85) 50%,
                    rgba(200, 210, 220, 0.88) 80%,
                    rgba(180, 190, 200, 0.9) 100%
                );
        }
        
        :is(.dark .paper-clip-gold) {
            background: 
                radial-gradient(ellipse 8px 18px at 50% 30%, transparent 70%, rgba(140, 110, 60, 0.9) 71%, rgba(140, 110, 60, 0.9) 100%),
                radial-gradient(ellipse 8px 18px at 50% 70%, transparent 70%, rgba(140, 110, 60, 0.9) 71%, rgba(140, 110, 60, 0.9) 100%),
                radial-gradient(ellipse 14px 22px at 50% 30%, transparent 65%, rgba(180, 150, 80, 0.85) 66%, rgba(200, 170, 100, 0.88) 80%, rgba(180, 150, 80, 0.85) 100%),
                radial-gradient(ellipse 14px 22px at 50% 70%, transparent 65%, rgba(180, 150, 80, 0.85) 66%, rgba(200, 170, 100, 0.88) 80%, rgba(180, 150, 80, 0.85) 100%),
                linear-gradient(180deg,
                    rgba(190, 160, 90, 0.9) 0%,
                    rgba(210, 180, 110, 0.88) 20%,
                    rgba(170, 140, 70, 0.85) 50%,
                    rgba(210, 180, 110, 0.88) 80%,
                    rgba(190, 160, 90, 0.9) 100%
                );
        }
    </style>
    @endif
</div>
