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
                
                {{-- REALISTIC Paper Clip at top --}}
                <div class="paper-clip paper-clip-{{ $clipType }}" 
                     style="transform: translate(-50%, 0) rotate({{ $clipRotation }}deg) translateX({{ $clipOffsetX }}px);"></div>
                
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
        
        /* REALISTIC Paper Clip Effect */
        .paper-clip {
            position: absolute;
            top: -8px;
            left: 50%;
            width: 80px;
            height: 100px;
            z-index: 10;
            pointer-events: none;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 40% 40% 50% 50% / 30% 30% 70% 70%;
        }
        
        .poetry-card-container:hover .paper-clip {
            transform: translate(-50%, -2px) rotate(0deg) translateX(0px) !important;
        }
        
        /* SILVER CLIP - Realistic metal */
        .paper-clip-silver {
            background: 
                /* Top loop shadow */
                radial-gradient(ellipse 14px 30px at 50% 25%, transparent 65%, rgba(80, 90, 105, 1) 66%, rgba(80, 90, 105, 1) 100%),
                /* Bottom loop shadow */
                radial-gradient(ellipse 14px 30px at 50% 75%, transparent 65%, rgba(80, 90, 105, 1) 66%, rgba(80, 90, 105, 1) 100%),
                /* Top loop metal */
                radial-gradient(ellipse 24px 38px at 50% 25%, transparent 60%, rgba(150, 160, 175, 1) 61%, rgba(210, 220, 235, 1) 75%, rgba(180, 190, 205, 1) 90%, rgba(150, 160, 175, 1) 100%),
                /* Bottom loop metal */
                radial-gradient(ellipse 24px 38px at 50% 75%, transparent 60%, rgba(150, 160, 175, 1) 61%, rgba(210, 220, 235, 1) 75%, rgba(180, 190, 205, 1) 90%, rgba(150, 160, 175, 1) 100%),
                /* Center bar with gradient */
                linear-gradient(180deg,
                    rgba(170, 180, 195, 1) 0%,
                    rgba(220, 230, 245, 1) 15%,
                    rgba(190, 200, 215, 1) 30%,
                    rgba(160, 170, 185, 1) 50%,
                    rgba(190, 200, 215, 1) 70%,
                    rgba(220, 230, 245, 1) 85%,
                    rgba(170, 180, 195, 1) 100%
                );
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.4)) drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
        }
        
        /* GOLD CLIP - Realistic brass/gold */
        .paper-clip-gold {
            background: 
                /* Top loop shadow */
                radial-gradient(ellipse 14px 30px at 50% 25%, transparent 65%, rgba(110, 85, 45, 1) 66%, rgba(110, 85, 45, 1) 100%),
                /* Bottom loop shadow */
                radial-gradient(ellipse 14px 30px at 50% 75%, transparent 65%, rgba(110, 85, 45, 1) 66%, rgba(110, 85, 45, 1) 100%),
                /* Top loop metal */
                radial-gradient(ellipse 24px 38px at 50% 25%, transparent 60%, rgba(180, 145, 75, 1) 61%, rgba(240, 210, 130, 1) 75%, rgba(210, 175, 95, 1) 90%, rgba(180, 145, 75, 1) 100%),
                /* Bottom loop metal */
                radial-gradient(ellipse 24px 38px at 50% 75%, transparent 60%, rgba(180, 145, 75, 1) 61%, rgba(240, 210, 130, 1) 75%, rgba(210, 175, 95, 1) 90%, rgba(180, 145, 75, 1) 100%),
                /* Center bar with gradient */
                linear-gradient(180deg,
                    rgba(200, 165, 85, 1) 0%,
                    rgba(245, 215, 135, 1) 15%,
                    rgba(215, 180, 100, 1) 30%,
                    rgba(185, 150, 75, 1) 50%,
                    rgba(215, 180, 100, 1) 70%,
                    rgba(245, 215, 135, 1) 85%,
                    rgba(200, 165, 85, 1) 100%
                );
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.4)) drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
        }
        
        /* Dark mode adjustments */
        :is(.dark .paper-clip-silver) {
            background: 
                radial-gradient(ellipse 14px 30px at 50% 25%, transparent 65%, rgba(70, 80, 95, 0.98) 66%, rgba(70, 80, 95, 0.98) 100%),
                radial-gradient(ellipse 14px 30px at 50% 75%, transparent 65%, rgba(70, 80, 95, 0.98) 66%, rgba(70, 80, 95, 0.98) 100%),
                radial-gradient(ellipse 24px 38px at 50% 25%, transparent 60%, rgba(130, 140, 155, 0.95) 61%, rgba(190, 200, 215, 0.98) 75%, rgba(160, 170, 185, 0.96) 90%, rgba(130, 140, 155, 0.95) 100%),
                radial-gradient(ellipse 24px 38px at 50% 75%, transparent 60%, rgba(130, 140, 155, 0.95) 61%, rgba(190, 200, 215, 0.98) 75%, rgba(160, 170, 185, 0.96) 90%, rgba(130, 140, 155, 0.95) 100%),
                linear-gradient(180deg,
                    rgba(150, 160, 175, 0.96) 0%,
                    rgba(200, 210, 225, 0.98) 15%,
                    rgba(170, 180, 195, 0.96) 30%,
                    rgba(140, 150, 165, 0.95) 50%,
                    rgba(170, 180, 195, 0.96) 70%,
                    rgba(200, 210, 225, 0.98) 85%,
                    rgba(150, 160, 175, 0.96) 100%
                );
        }
        
        :is(.dark .paper-clip-gold) {
            background: 
                radial-gradient(ellipse 14px 30px at 50% 25%, transparent 65%, rgba(95, 75, 40, 0.98) 66%, rgba(95, 75, 40, 0.98) 100%),
                radial-gradient(ellipse 14px 30px at 50% 75%, transparent 65%, rgba(95, 75, 40, 0.98) 66%, rgba(95, 75, 40, 0.98) 100%),
                radial-gradient(ellipse 24px 38px at 50% 25%, transparent 60%, rgba(160, 130, 65, 0.95) 61%, rgba(220, 190, 115, 0.98) 75%, rgba(190, 155, 85, 0.96) 90%, rgba(160, 130, 65, 0.95) 100%),
                radial-gradient(ellipse 24px 38px at 50% 75%, transparent 60%, rgba(160, 130, 65, 0.95) 61%, rgba(220, 190, 115, 0.98) 75%, rgba(190, 155, 85, 0.96) 90%, rgba(160, 130, 65, 0.95) 100%),
                linear-gradient(180deg,
                    rgba(180, 150, 75, 0.96) 0%,
                    rgba(225, 195, 120, 0.98) 15%,
                    rgba(195, 165, 90, 0.96) 30%,
                    rgba(165, 135, 65, 0.95) 50%,
                    rgba(195, 165, 90, 0.96) 70%,
                    rgba(225, 195, 120, 0.98) 85%,
                    rgba(180, 150, 75, 0.96) 100%
                );
        }
    </style>
    @endif
</div>
