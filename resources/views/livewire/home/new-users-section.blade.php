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
            
            <!-- FILO CON CURVATURA SVG -->
            <div class="clothesline-container">
                <svg class="clothesline-svg" viewBox="0 0 1200 80" preserveAspectRatio="none">
                    <defs>
                        <linearGradient id="ropeGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" style="stop-color:#8B7355;stop-opacity:1" />
                            <stop offset="50%" style="stop-color:#6B563F;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#5A4A35;stop-opacity:1" />
                        </linearGradient>
                        <filter id="ropeShadow">
                            <feGaussianBlur in="SourceAlpha" stdDeviation="2"/>
                            <feOffset dx="0" dy="2" result="offsetblur"/>
                            <feComponentTransfer>
                                <feFuncA type="linear" slope="0.4"/>
                            </feComponentTransfer>
                            <feMerge>
                                <feMergeNode/>
                                <feMergeNode in="SourceGraphic"/>
                            </feMerge>
                        </filter>
                    </defs>
                    <!-- Filo curvo naturale (parabola) -->
                    <path d="M 0,20 Q 300,50 600,55 T 1200,20" 
                          stroke="url(#ropeGradient)" 
                          stroke-width="4" 
                          fill="none"
                          stroke-linecap="round"
                          filter="url(#ropeShadow)"/>
                </svg>
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
                
                {{-- Molletta da bucato --}}
                <div class="clothespin">
                    <div class="clothespin-top"></div>
                    <div class="clothespin-bottom"></div>
                    <div class="clothespin-spring"></div>
                </div>
                
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
            /* Spazio per filo, molletta e connessione */
            padding-top: 100px;
        }
        
        /* FILO SVG - VISIBILMENTE CURVO */
        .clothesline-container {
            position: absolute;
            top: 0;
            left: -50px;
            right: -50px;
            z-index: 5;
            height: 70px;
            pointer-events: none;
            overflow: visible;
        }
        
        .clothesline-svg {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }
        
        /* Molletta da bucato - AGGANCIATA AL FILO */
        .clothespin {
            position: absolute;
            /* Posizione che segue la curvatura del filo */
            top: 30px; /* Circa al centro della curvatura */
            left: 50%;
            transform: translateX(-50%);
            width: 36px;
            height: 60px;
            z-index: 15;
            transition: all 0.3s ease;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3));
        }
        
        /* Filo virtuale che connette molletta al filo principale */
        .clothespin::before {
            content: '';
            position: absolute;
            top: -18px;
            left: 50%;
            transform: translateX(-50%);
            width: 2px;
            height: 18px;
            background: linear-gradient(to bottom,
                #8B7355 0%,
                #6B563F 100%
            );
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
            z-index: -1;
        }
        
        .clothespin-top,
        .clothespin-bottom {
            position: absolute;
            width: 16px;
            height: 32px;
            left: 50%;
            /* Legno chiaro realistico */
            background: 
                linear-gradient(135deg, 
                    #E8C9A0 0%,
                    #D4A574 25%,
                    #C89968 50%,
                    #B88B5C 75%,
                    #A67B4F 100%
                );
            border-radius: 3px 3px 8px 8px;
            box-shadow: 
                0 4px 8px rgba(0, 0, 0, 0.3),
                inset 2px 0 2px rgba(255, 255, 255, 0.4),
                inset -2px 0 2px rgba(0, 0, 0, 0.25);
        }
        
        .clothespin-top {
            top: 0;
            transform: translateX(-56%) rotate(-12deg);
            transform-origin: bottom center;
        }
        
        .clothespin-bottom {
            top: 0;
            transform: translateX(-44%) rotate(12deg);
            transform-origin: bottom center;
        }
        
        /* Molla centrale metallica */
        .clothespin-spring {
            position: absolute;
            width: 18px;
            height: 12px;
            left: 50%;
            top: 12px;
            transform: translateX(-50%);
            background: 
                repeating-linear-gradient(
                    to bottom,
                    #999 0px,
                    #bbb 1.5px,
                    #888 3px,
                    #aaa 4.5px,
                    #999 6px
                );
            border-radius: 3px;
            box-shadow: 
                0 2px 4px rgba(0, 0, 0, 0.3),
                inset 0 1px 2px rgba(255, 255, 255, 0.5),
                inset 0 -1px 1px rgba(0, 0, 0, 0.3);
        }
        
        /* ============================================
           POLAROID CARD - STILE PULITO E REALISTICO
           ============================================ */
        
        .polaroid-card {
            display: block;
            position: relative;
            /* Bianco puro come vera Polaroid */
            background: #ffffff;
            /* Bordi bianchi - proporzioni classiche Polaroid */
            padding: 20px 20px 70px 20px;
            /* Ombra elegante e realistica */
            box-shadow: 
                0 2px 4px rgba(0, 0, 0, 0.1),
                0 4px 8px rgba(0, 0, 0, 0.08),
                0 8px 16px rgba(0, 0, 0, 0.06),
                0 16px 32px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
            text-decoration: none;
            cursor: pointer;
            border-radius: 2px;
        }
        
        :is(.dark .polaroid-card) {
            background: #fafafa;
        }
        
        /* HOVER - Oscillazione naturale */
        .polaroid-wrapper:hover .polaroid-card {
            /* Leggera oscillazione come se fosse appesa */
            transform: translateY(-6px) scale(1.02) rotate(0deg) !important;
            box-shadow: 
                0 6px 12px rgba(0, 0, 0, 0.15),
                0 12px 24px rgba(0, 0, 0, 0.12),
                0 20px 40px rgba(0, 0, 0, 0.09);
            animation: swing 0.5s ease-in-out;
        }
        
        @keyframes swing {
            0%, 100% { transform: translateY(-6px) rotate(0deg); }
            25% { transform: translateY(-8px) rotate(1deg); }
            75% { transform: translateY(-8px) rotate(-1deg); }
        }
        
        .polaroid-wrapper:hover .clothespin-top {
            transform: translateX(-55%) rotate(-15deg);
        }
        
        .polaroid-wrapper:hover .clothespin-bottom {
            transform: translateX(-45%) rotate(15deg);
        }
        
        .polaroid-wrapper:hover .clothespin {
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3));
        }
        
        /* FOTO - Stile pulito */
        .polaroid-photo {
            position: relative;
            aspect-ratio: 1;
            overflow: hidden;
            background: #f5f5f5;
            margin-bottom: 0;
            border-radius: 1px;
            box-shadow: 
                inset 0 0 0 1px rgba(0, 0, 0, 0.1),
                inset 0 2px 4px rgba(0, 0, 0, 0.06);
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
        
        /* Caption area - elegante e spaziosa */
        .polaroid-caption {
            text-align: center;
            padding: 1rem 0.75rem 0 0.75rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.625rem;
        }
        
        .polaroid-name {
            font-family: 'Crimson Pro', serif;
            font-size: 0.875rem;
            font-weight: 600;
            color: #2d2d2d;
            margin-bottom: 0.25rem;
            line-height: 1.3;
        }
        
        /* Nome - Pulito e leggibile */
        .polaroid-name-large {
            font-family: 'Crimson Pro', serif;
            font-size: 1.05rem;
            font-weight: 600;
            color: #1a1a1a;
            line-height: 1.3;
            margin: 0;
            padding: 0;
            max-width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        /* Bio - Nascosta */
        .polaroid-bio {
            display: none;
        }
        
        /* Follow button - Elegante */
        .polaroid-follow-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.45rem 0.875rem;
            background: #10b981;
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 0.375rem;
            transition: all 0.2s ease;
            box-shadow: 0 1px 2px rgba(16, 185, 129, 0.2);
        }
        
        .polaroid-follow-btn svg {
            width: 0.875rem;
            height: 0.875rem;
        }
        
        .polaroid-follow-btn:hover {
            background: #059669;
            box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);
            transform: translateY(-1px);
        }
        
        /* Stats row */
        .polaroid-stats {
            display: flex;
            gap: 1rem;
            justify-content: center;
            color: #666666;
            font-size: 0.75rem;
        }
        
        .polaroid-stat {
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }
        
        .polaroid-stat svg {
            width: 0.875rem;
            height: 0.875rem;
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
