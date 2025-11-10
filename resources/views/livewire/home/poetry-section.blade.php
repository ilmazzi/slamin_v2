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
        
        /* ULTRA REALISTIC Paper Sheet */
        .paper-sheet {
            display: block;
            position: relative;
            background: 
                /* Fine paper grain */
                repeating-linear-gradient(0deg, transparent, transparent 1px, rgba(0,0,0,0.015) 1px, rgba(0,0,0,0.015) 2px),
                repeating-linear-gradient(90deg, transparent, transparent 1px, rgba(0,0,0,0.01) 1px, rgba(0,0,0,0.01) 2px),
                /* Paper fiber texture */
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='400'%3E%3Cfilter id='n'%3E%3CfeTurbulence baseFrequency='0.9' numOctaves='5' seed='4'/%3E%3CfeColorMatrix values='1 0 0 0 0, 0 1 0 0 0, 0 0 1 0 0, 0 0 0 0.05 0'/%3E%3C/filter%3E%3Crect width='400' height='400' filter='url(%23n)'/%3E%3C/svg%3E"),
                /* Coffee stains and marks */
                radial-gradient(ellipse 60px 80px at 85% 15%, rgba(101, 67, 33, 0.04) 0%, transparent 70%),
                radial-gradient(circle 40px at 12% 88%, rgba(101, 67, 33, 0.03) 0%, transparent 70%),
                radial-gradient(ellipse 50px 40px at 70% 90%, rgba(101, 67, 33, 0.02) 0%, transparent 70%),
                /* Aged paper color */
                linear-gradient(140deg, 
                    #fffffb 0%,
                    #fffef8 25%,
                    #fefcf4 50%,
                    #fdfaf0 75%,
                    #fcf8ec 100%
                );
            padding: 2.5rem 2rem 2rem 2rem;
            min-height: 420px;
            border-radius: 1px;
            /* Real paper shadow on wood */
            box-shadow: 
                0 1px 1px rgba(0, 0, 0, 0.08),
                0 2px 4px rgba(0, 0, 0, 0.12),
                0 4px 8px rgba(0, 0, 0, 0.14),
                0 8px 16px rgba(0, 0, 0, 0.16),
                0 12px 24px rgba(0, 0, 0, 0.18);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            /* Paper thickness edge */
            border-right: 1px solid rgba(210, 180, 140, 0.15);
            border-bottom: 1px solid rgba(210, 180, 140, 0.2);
        }
        
        /* Paper fold corner (dog-ear) */
        .paper-sheet::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 0 20px 20px 0;
            border-color: transparent #f5f1e8 transparent transparent;
            filter: drop-shadow(-1px 1px 1px rgba(0,0,0,0.1));
            z-index: 1;
        }
        
        /* Paper texture overlay */
        .paper-sheet::after {
            content: '';
            position: absolute;
            inset: 0;
            background: 
                linear-gradient(
                    to bottom,
                    rgba(255,255,255,0.3) 0%,
                    transparent 50%,
                    rgba(0,0,0,0.02) 100%
                );
            pointer-events: none;
            z-index: 1;
        }
        
        .paper-sheet:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 
                0 16px 32px rgba(0, 0, 0, 0.2),
                0 8px 16px rgba(0, 0, 0, 0.15),
                0 4px 8px rgba(0, 0, 0, 0.12),
                inset 0 1px 0 rgba(255, 255, 255, 0.6);
        }
        
        :is(.dark .paper-sheet) {
            background: 
                url("data:image/svg+xml,%3Csvg width='200' height='200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='paper'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' /%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23paper)' opacity='0.06'/%3E%3C/svg%3E"),
                linear-gradient(145deg, #2a2520 0%, #241f1c 50%, #1f1a17 100%);
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
