<div>
    @php
    $newUsers = \App\Models\User::latest()->limit(4)->get();
    @endphp
    
    @if($newUsers && $newUsers->count() > 0)
    <div class="max-w-[90rem] mx-auto px-4 md:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="text-center mb-12 section-title-fade">
            <h2 class="text-4xl md:text-5xl font-bold mb-3 text-neutral-900 dark:text-white" style="font-family: 'Crimson Pro', serif;">
                {!! __('home.new_users_title') !!}
            </h2>
            <p class="text-lg text-neutral-800 dark:text-neutral-300 font-medium">
                {{ __('home.new_users_subtitle') }}
            </p>
        </div>

        {{-- Polaroid Wall - Horizontal Scroll with Desktop Navigation --}}
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
                <div class="flex items-center justify-center gap-2 text-neutral-700 dark:text-neutral-300 text-sm">
                    <svg class="w-5 h-5 animate-bounce-horizontal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                    </svg>
                    <span>Scorri per vedere altro</span>
                </div>
            </div>
            
            <div x-ref="scrollContainer" class="flex gap-6 overflow-x-auto pb-12 pt-16 px-8 md:px-12 scrollbar-hide"
                 style="-webkit-overflow-scrolling: touch; overflow-y: visible;">
            @foreach($newUsers as $i => $user)
            <?php
                // Random rotation for each polaroid
                $rotation = rand(-3, 3);
                $tapeRotation = rand(-8, 8);
                $tapeWidth = rand(70, 100);
                // Random tape colors - VIVID/BRIGHT
                $tapeColors = [
                    // Bright Yellow
                    ['rgba(255, 220, 0, 0.95)', 'rgba(255, 230, 50, 0.93)', 'rgba(255, 240, 100, 0.95)'],
                    // Hot Pink
                    ['rgba(255, 105, 180, 0.92)', 'rgba(255, 130, 200, 0.90)', 'rgba(255, 150, 215, 0.92)'],
                    // Electric Blue
                    ['rgba(0, 150, 255, 0.90)', 'rgba(50, 170, 255, 0.88)', 'rgba(100, 190, 255, 0.90)'],
                    // Lime Green
                    ['rgba(50, 255, 50, 0.88)', 'rgba(80, 255, 80, 0.86)', 'rgba(110, 255, 110, 0.88)'],
                    // Purple
                    ['rgba(180, 100, 255, 0.90)', 'rgba(190, 130, 255, 0.88)', 'rgba(200, 160, 255, 0.90)'],
                    // Orange
                    ['rgba(255, 140, 0, 0.92)', 'rgba(255, 160, 50, 0.90)', 'rgba(255, 180, 100, 0.92)'],
                ];
                $selectedTape = $tapeColors[array_rand($tapeColors)];
                
                // Fake bio for users without one
                $fakeBios = [
                    'Appassionato di poesia e letteratura 📖',
                    'Scrittore emergente e lettore vorace 🖋️',
                    'Amante delle parole e dell\'arte ✨',
                    'Poeta urbano e sognatore notturno 🌙',
                    'Creativo multimediale e storyteller 🎨',
                ];
                $userBio = $user->bio ?? $fakeBios[array_rand($fakeBios)];
            ?>
            <div class="w-72 md:w-80 flex-shrink-0 polaroid-wrapper fade-scale-item" 
                 x-data 
                 x-intersect.once="$el.classList.add('animate-fade-in')" 
                 style="animation-delay: {{ $i * 0.1 }}s">
                
                {{-- Colorful Washi Tape on top --}}
                <div class="polaroid-tape tape-{{ $i }}" 
                     style="width: {{ $tapeWidth }}px; 
                            --tape-rotation: {{ $tapeRotation }}deg; 
                            transform: translateX(-50%) rotate({{ $tapeRotation }}deg);
                            background: 
                                linear-gradient(105deg, rgba(255, 255, 255, 0.25) 0%, transparent 30%, transparent 70%, rgba(255, 255, 255, 0.25) 100%),
                                linear-gradient(180deg, {{ $selectedTape[0] }} 0%, {{ $selectedTape[1] }} 50%, {{ $selectedTape[2] }} 100%);"></div>
                
                {{-- Polaroid Card (link will be added when profile.show route exists) --}}
                <div class="polaroid-card"
                     style="transform: rotate({{ $rotation }}deg);">
                    
                    {{-- Photo --}}
                    <div class="polaroid-photo">
                        <img src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($user, 400) }}" 
                             alt="{{ $user->name }}"
                             class="polaroid-img">
                    </div>
                    
                    {{-- Caption with Enhanced INFO --}}
                    <div class="polaroid-caption">
                        <div class="polaroid-name-large">{{ $user->name }}</div>
                        
                        {{-- Bio --}}
                        <div class="polaroid-bio">{{ $userBio }}</div>
                        
                        {{-- Follow Button --}}
                        <button class="polaroid-follow-btn">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            {{ __('home.follow_user') }}
                        </button>
                        
                        {{-- Stats Grid --}}
                        <div class="polaroid-stats">
                            <div class="polaroid-stat">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                <span>{{ $user->poems()->count() }}</span>
                            </div>
                            <div class="polaroid-stat">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                </svg>
                                <span>{{ $user->articles()->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            </div>
        </div>

        {{-- CTA - Simple Text --}}
        <div class="text-center mt-12">
            <div class="inline-block text-2xl md:text-3xl font-bold text-neutral-900 dark:text-white hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-300 cursor-pointer"
                 style="font-family: 'Crimson Pro', serif;">
                → {{ __('home.all_users_button') }}
            </div>
        </div>
    </div>
    
    <style>
        @keyframes fade-in { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in { animation: fade-in 0.6s ease-out forwards; opacity: 0; }
        
        /* ============================================
           POLAROID WALL
           ============================================ */
        
        .polaroid-wrapper {
            position: relative;
            padding-top: 20px;
        }
        
        /* Washi Tape on top - COLORFUL WITH SERRATED EDGES */
        .polaroid-tape {
            position: absolute;
            top: 8px;
            left: 50%;
            /* Width and background colors set inline (random) */
            height: 28px;
            box-shadow: 
                0 3px 8px rgba(0, 0, 0, 0.35),
                0 1px 4px rgba(0, 0, 0, 0.25),
                inset 0 2px 5px rgba(255, 255, 255, 0.9),
                inset 0 -1px 3px rgba(0, 0, 0, 0.2);
            z-index: 10;
            border-top: 1px solid rgba(255, 255, 255, 0.8);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            /* SERRATED EDGES */
            clip-path: polygon(
                0% 0%, 2% 5%, 0% 10%, 2% 15%, 0% 20%, 2% 25%, 0% 30%, 2% 35%, 
                0% 40%, 2% 45%, 0% 50%, 2% 55%, 0% 60%, 2% 65%, 0% 70%, 2% 75%, 
                0% 80%, 2% 85%, 0% 90%, 2% 95%, 0% 100%,
                100% 100%,
                98% 95%, 100% 90%, 98% 85%, 100% 80%, 98% 75%, 100% 70%, 98% 65%, 
                100% 60%, 98% 55%, 100% 50%, 98% 45%, 100% 40%, 98% 35%, 100% 30%, 
                98% 25%, 100% 20%, 98% 15%, 100% 10%, 98% 5%, 100% 0%
            );
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* ============================================
           POLAROID CARD - APPROCCIO COMPLETAMENTE NUOVO
           ============================================ */
        
        .polaroid-card {
            display: block;
            position: relative;
            /* VERO cartoncino bianco spesso */
            background: linear-gradient(135deg, #ffffff 0%, #fefefe 50%, #fcfcfc 100%);
            /* BORDI FISICI ENORMI - come vere Polaroid! */
            border: 24px solid #ffffff;
            border-bottom-width: 88px; /* FONDO ENORME! */
            /* Bordo ESTERNO grigio per simulare lo spessore del cartoncino */
            outline: 1px solid #e0e0e0;
            outline-offset: 0;
            /* Ombre MASSICCE per profondità */
            box-shadow: 
                /* Spessore visibile del cartoncino (lato destro e inferiore) */
                8px 0 0 -2px #e8e8e8,
                10px 0 0 -2px #dedede,
                12px 0 0 -2px #d4d4d4,
                0 8px 0 -2px #e8e8e8,
                0 10px 0 -2px #dedede,
                0 12px 0 -2px #d4d4d4,
                /* Ombra proiettata sul tavolo */
                0 20px 50px rgba(0, 0, 0, 0.35),
                0 35px 85px rgba(0, 0, 0, 0.25),
                0 50px 120px rgba(0, 0, 0, 0.18);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            text-decoration: none;
            cursor: pointer;
            border-radius: 6px;
            /* Texture carta VISIBILE */
            background-image: 
                /* Grana carta */
                url("data:image/svg+xml,%3Csvg width='300' height='300' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='texture'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='2.5' numOctaves='6' /%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23texture)' opacity='0.15'/%3E%3C/svg%3E"),
                /* Superficie leggermente lucida */
                radial-gradient(ellipse at 30% 30%, rgba(255,255,255,0.4) 0%, transparent 50%),
                /* Base bianca */
                linear-gradient(135deg, #ffffff 0%, #fefefe 50%, #fcfcfc 100%);
        }
        
        :is(.dark .polaroid-card) {
            background: linear-gradient(135deg, #fafafa 0%, #f8f8f8 50%, #f6f6f6 100%);
            border-color: #fafafa;
        }
        
        /* HOVER - Sollevamento drammatico */
        .polaroid-wrapper:hover .polaroid-card {
            transform: translateY(-24px) scale(1.08) rotate(0deg) !important;
            box-shadow: 
                /* Spessore ancora più marcato */
                10px 0 0 -2px #e0e0e0,
                12px 0 0 -2px #d5d5d5,
                14px 0 0 -2px #cacaca,
                16px 0 0 -2px #c0c0c0,
                0 10px 0 -2px #e0e0e0,
                0 12px 0 -2px #d5d5d5,
                0 14px 0 -2px #cacaca,
                0 16px 0 -2px #c0c0c0,
                /* Ombra MOLTO più profonda */
                0 35px 80px rgba(0, 0, 0, 0.45),
                0 55px 130px rgba(0, 0, 0, 0.35),
                0 80px 180px rgba(0, 0, 0, 0.25);
        }
        
        .polaroid-wrapper:hover .polaroid-tape {
            top: -10px;
            filter: brightness(1.1);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.35);
        }
        
        /* FOTO - Incassata PROFONDAMENTE nel cartoncino */
        .polaroid-photo {
            position: relative;
            aspect-ratio: 1;
            overflow: hidden;
            /* Area NERA intorno alla foto (tipico delle Polaroid) */
            background: #1a1a1a;
            padding: 6px;
            margin: 0;
            border-radius: 2px;
            /* INCASSO profondo - sembra premuta dentro! */
            box-shadow: 
                /* Bordo interno scuro */
                inset 0 0 0 1px rgba(0, 0, 0, 0.6),
                /* Ombre interne PROFONDE (incasso) */
                inset 0 3px 12px rgba(0, 0, 0, 0.6),
                inset 0 6px 20px rgba(0, 0, 0, 0.5),
                inset 3px 3px 12px rgba(0, 0, 0, 0.4),
                inset -3px -3px 12px rgba(0, 0, 0, 0.3),
                /* Luce riflessa dal basso (bevel) */
                inset 0 -2px 4px rgba(255, 255, 255, 0.08);
        }
        
        /* Cornice interna sottile (dettaglio realistico) */
        .polaroid-photo::before {
            content: '';
            position: absolute;
            inset: 6px;
            border: 2px solid rgba(255, 255, 255, 0.12);
            pointer-events: none;
            z-index: 1;
            border-radius: 1px;
            box-shadow: 
                0 1px 3px rgba(0, 0, 0, 0.3),
                inset 0 -1px 1px rgba(255, 255, 255, 0.1);
        }
        
        /* Glossy finish sulla superficie (riflessione luce) */
        .polaroid-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.5) 0%,
                rgba(255, 255, 255, 0.1) 20%,
                transparent 40%,
                transparent 100%
            );
            pointer-events: none;
            border-radius: 6px;
            mix-blend-mode: overlay;
        }
        
        .polaroid-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .polaroid-wrapper:hover .polaroid-img {
            transform: scale(1.08);
        }
        
        /* Caption area - NEL BORDO INFERIORE SPESSO */
        .polaroid-caption {
            text-align: center;
            /* Posizionato SOTTO la foto, nel bordo spesso */
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1rem 0.75rem 0.5rem 0.75rem;
            /* Altezza del caption = border-bottom (88px) */
            height: 88px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            gap: 0.5rem;
        }
        
        .polaroid-name {
            font-family: 'Crimson Pro', serif;
            font-size: 0.875rem;
            font-weight: 600;
            color: #2d2d2d;
            margin-bottom: 0.25rem;
            line-height: 1.3;
        }
        
        /* Larger name for enhanced cards */
        .polaroid-name-large {
            font-family: 'Crimson Pro', serif;
            font-size: 1.125rem;
            font-weight: 700;
            color: #2d2d2d;
            margin-bottom: 0.5rem;
            line-height: 1.2;
        }
        
        /* User bio */
        .polaroid-bio {
            font-size: 0.75rem;
            color: #4a4a4a;
            line-height: 1.4;
            margin-bottom: 0.75rem;
            font-style: italic;
        }
        
        /* Follow button */
        .polaroid-follow-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.5rem 1rem;
            background: #10b981;
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 0.375rem;
            transition: all 0.3s ease;
            margin-bottom: 0.75rem;
            box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
        }
        
        .polaroid-follow-btn:hover {
            background: #059669;
            box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
            transform: translateY(-1px);
        }
        
        .polaroid-info {
            font-family: 'Crimson Pro', serif;
            font-size: 0.75rem;
            color: #666;
            font-style: italic;
        }
    </style>
    @endif
</div>
