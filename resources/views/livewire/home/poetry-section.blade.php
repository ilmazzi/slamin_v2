<div>
    @if($poems && $poems->count() > 0)
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="text-center mb-12">
            <h2 class="text-4xl md:text-5xl font-bold mb-3 text-white" style="font-family: 'Crimson Pro', serif; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                {!! __('home.poetry_section_title') !!}
            </h2>
            <p class="text-lg text-neutral-100">
                {{ __('home.poetry_section_subtitle') }}
            </p>
        </div>

        {{-- Poetry Cards Grid --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10 pt-8 pb-4">
            @foreach($poems->take(3) as $i => $poem)
            <?php
                $paperRotation = rand(-2, 2); // Slight random rotation
            ?>
            <div class="poetry-card-container" 
                 x-data 
                 x-intersect.once="$el.classList.add('animate-fade-in')" 
                 style="animation-delay: {{ $i * 0.1 }}s">
                
                {{-- Paper Sheet on Desk --}}
                <a href="{{ route('poems.show', $poem->slug) }}" 
                   class="paper-sheet group"
                   style="transform: rotate({{ $paperRotation }}deg);">
                    
                    {{-- Author name (small, top right) --}}
                    <div class="paper-author">
                        {{ $poem->user->name }}
                    </div>
                    
                    {{-- Poem Title --}}
                    <h3 class="paper-title">
                        "{{ $poem->title ?: __('poems.untitled') }}"
                    </h3>
                    
                    {{-- Poem Content --}}
                    <div class="paper-content">
                        {{ $poem->description ?? Str::limit(strip_tags($poem->content), 180) }}
                    </div>
                    
                    {{-- Read more hint --}}
                    <div class="paper-readmore">
                        {{ __('common.read_more') }} →
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        {{-- CTA Button --}}
        <div class="text-center mt-12">
            <a href="{{ route('poems.index') }}" 
               class="inline-flex items-center gap-2 px-8 py-4 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white border-2 border-neutral-800 dark:border-neutral-300 rounded-lg font-semibold text-lg hover:bg-neutral-800 hover:text-white dark:hover:bg-white dark:hover:text-neutral-900 transition-all duration-300 shadow-lg hover:shadow-xl">
                {{ __('home.all_poems_button') }}
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
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
            padding-top: 20px;
        }
        
        /* VINTAGE PAPER SHEET */
        .paper-sheet {
            display: block;
            position: relative;
            /* Vintage aged paper color */
            background: 
                /* Paper texture overlay */
                linear-gradient(135deg, 
                    rgba(255,253,245,0) 0%, 
                    rgba(250,240,220,0.4) 25%, 
                    rgba(245,235,215,0.3) 50%, 
                    rgba(240,230,210,0.4) 75%, 
                    rgba(255,250,240,0) 100%),
                /* Aged paper stains */
                radial-gradient(circle at 20% 30%, rgba(210,180,140,0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(205,175,135,0.12) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(200,170,130,0.1) 0%, transparent 40%),
                /* Base vintage paper color */
                #faf6ed;
            padding: 2.5rem 2rem 2rem 2rem;
            min-height: 420px;
            /* Irregular torn edges */
            clip-path: polygon(
                0% 1%, 2% 0.5%, 4% 1.5%, 6% 0.8%, 8% 1.2%, 10% 0.5%, 
                12% 1%, 15% 0.5%, 18% 1.5%, 20% 0.8%, 25% 1%, 30% 0.5%, 
                35% 1.2%, 40% 0.8%, 45% 1%, 50% 0.5%, 55% 1.5%, 60% 0.8%, 
                65% 1%, 70% 0.5%, 75% 1.2%, 80% 0.8%, 85% 1%, 88% 0.5%, 
                90% 1.5%, 92% 0.8%, 94% 1%, 96% 0.5%, 98% 1.2%, 100% 1%,
                100% 5%, 99.5% 10%, 100% 15%, 99.5% 20%, 100% 25%, 99.5% 30%,
                100% 35%, 99.5% 40%, 100% 45%, 99.5% 50%, 100% 55%, 99.5% 60%,
                100% 65%, 99.5% 70%, 100% 75%, 99.5% 80%, 100% 85%, 99.5% 90%,
                100% 95%, 99.5% 97%, 100% 99%,
                98% 99.5%, 96% 99%, 94% 99.5%, 92% 99%, 90% 99.5%, 88% 99%,
                85% 99.5%, 80% 99%, 75% 99.5%, 70% 99%, 65% 99.5%, 60% 99%,
                55% 99.5%, 50% 99%, 45% 99.5%, 40% 99%, 35% 99.5%, 30% 99%,
                25% 99.5%, 20% 99%, 15% 99.5%, 10% 99%, 5% 99.5%, 2% 99%,
                0% 99%, 0.5% 95%, 0% 90%, 0.5% 85%, 0% 80%, 0.5% 75%,
                0% 70%, 0.5% 65%, 0% 60%, 0.5% 55%, 0% 50%, 0.5% 45%,
                0% 40%, 0.5% 35%, 0% 30%, 0.5% 25%, 0% 20%, 0.5% 15%,
                0% 10%, 0.5% 5%
            );
            /* Worn brown edges + shadow underneath */
            box-shadow: 
                /* Brown worn edges (inset) */
                inset 0 0 0 1px rgba(139, 115, 85, 0.3),
                inset 0 0 8px 2px rgba(139, 115, 85, 0.15),
                inset 0 0 15px 4px rgba(120, 100, 75, 0.08),
                /* Shadow underneath - realistic paper on desk */
                0 4px 6px rgba(0, 0, 0, 0.1),
                0 8px 12px rgba(0, 0, 0, 0.12),
                0 12px 20px rgba(0, 0, 0, 0.14),
                0 16px 28px rgba(0, 0, 0, 0.15);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
        }
        
        /* Vintage paper texture overlay */
        .paper-sheet::before {
            content: '';
            position: absolute;
            inset: 0;
            background: 
                repeating-linear-gradient(
                    0deg,
                    transparent,
                    transparent 2px,
                    rgba(210, 180, 140, 0.03) 2px,
                    rgba(210, 180, 140, 0.03) 4px
                );
            pointer-events: none;
            z-index: 1;
        }
        
        /* Paper crease/fold */
        .paper-sheet::after {
            content: '';
            position: absolute;
            top: 15%;
            right: 10%;
            width: 80%;
            height: 1px;
            background: linear-gradient(
                90deg,
                transparent 0%,
                rgba(180, 150, 120, 0.15) 30%,
                rgba(180, 150, 120, 0.2) 50%,
                rgba(180, 150, 120, 0.15) 70%,
                transparent 100%
            );
            transform: rotate(-2deg);
            pointer-events: none;
            z-index: 1;
        }
        
        
        
        .paper-sheet:hover {
            transform: translateY(-8px) scale(1.02);
            /* Brown worn edges + stronger shadow on hover */
            box-shadow: 
                /* Brown worn edges (inset) - same as normal */
                inset 0 0 0 1px rgba(139, 115, 85, 0.3),
                inset 0 0 8px 2px rgba(139, 115, 85, 0.15),
                inset 0 0 15px 4px rgba(120, 100, 75, 0.08),
                /* Stronger shadow - paper lifting */
                0 12px 20px rgba(0, 0, 0, 0.18),
                0 20px 36px rgba(0, 0, 0, 0.22),
                0 28px 50px rgba(0, 0, 0, 0.25),
                0 36px 70px rgba(0, 0, 0, 0.28);
        }
        
        :is(.dark .paper-sheet) {
            background: 
                linear-gradient(135deg, 
                    rgba(60,55,50,0) 0%, 
                    rgba(50,45,40,0.4) 25%, 
                    rgba(45,40,35,0.3) 50%, 
                    rgba(40,35,30,0.4) 75%, 
                    rgba(55,50,45,0) 100%),
                radial-gradient(circle at 20% 30%, rgba(35,30,25,0.2) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(30,25,20,0.15) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(25,20,15,0.12) 0%, transparent 40%),
                #2a2520;
            /* Dark mode brown worn edges + shadow */
            box-shadow: 
                /* Darker brown worn edges (inset) */
                inset 0 0 0 1px rgba(80, 65, 50, 0.4),
                inset 0 0 8px 2px rgba(80, 65, 50, 0.25),
                inset 0 0 15px 4px rgba(70, 55, 40, 0.15),
                /* Shadow underneath */
                0 4px 6px rgba(0, 0, 0, 0.2),
                0 8px 12px rgba(0, 0, 0, 0.22),
                0 12px 20px rgba(0, 0, 0, 0.24),
                0 16px 28px rgba(0, 0, 0, 0.26);
        }
        
        :is(.dark .paper-sheet:hover) {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 
                /* Darker brown worn edges (inset) - same as normal */
                inset 0 0 0 1px rgba(80, 65, 50, 0.4),
                inset 0 0 8px 2px rgba(80, 65, 50, 0.25),
                inset 0 0 15px 4px rgba(70, 55, 40, 0.15),
                /* Stronger shadow on hover */
                0 12px 20px rgba(0, 0, 0, 0.3),
                0 20px 36px rgba(0, 0, 0, 0.35),
                0 28px 50px rgba(0, 0, 0, 0.4),
                0 36px 70px rgba(0, 0, 0, 0.45);
        }
        
        /* Author name */
        .paper-author {
            position: absolute;
            top: 1rem;
            right: 1.5rem;
            font-size: 0.75rem;
            color: #8b7355;
            font-style: italic;
            z-index: 10;
        }
        
        :is(.dark .paper-author) {
            color: #a89580;
        }
        
        /* Title */
        .paper-title {
            position: relative;
            font-family: 'Crimson Pro', serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: #2d2520;
            margin-bottom: 1.5rem;
            line-height: 1.4;
            transition: color 0.3s ease;
            z-index: 10;
        }
        
        .group:hover .paper-title {
            color: #4a7c59;
        }
        
        :is(.dark .paper-title) {
            color: #e8e0d5;
        }
        
        :is(.dark .group:hover .paper-title) {
            color: #6fa881;
        }
        
        /* Content */
        .paper-content {
            position: relative;
            font-family: 'Crimson Pro', serif;
            font-size: 1rem;
            line-height: 1.8;
            color: #4a4035;
            font-style: italic;
            margin-bottom: 1.5rem;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 6;
            -webkit-box-orient: vertical;
            z-index: 10;
        }
        
        :is(.dark .paper-content) {
            color: #c8bfb0;
        }
        
        /* Read more */
        .paper-readmore {
            position: relative;
            font-size: 0.875rem;
            color: #6b5d4f;
            font-weight: 500;
            opacity: 0;
            transform: translateY(8px);
            transition: all 0.3s ease;
            z-index: 10;
        }
        
        .group:hover .paper-readmore {
            opacity: 1;
            transform: translateY(0);
        }
        
        :is(.dark .paper-readmore) {
            color: #9d8f7f;
        }
        
    </style>
    @endif
</div>
