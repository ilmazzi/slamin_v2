<div>
    @if($isOpen && $poem)
    <!-- Modal Overlay -->
    <div x-data="{ show: @entangle('isOpen'), poem: @entangle('poem'), leftOpen: false, rightOpen: false }"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-hidden"
         @keydown.escape.window="$wire.closeModal()">
        
        <!-- Dark Backdrop -->
        <div class="absolute inset-0 bg-black/80 backdrop-blur-sm"
             @click="$wire.closeModal()"></div>
        
        <!-- Book Container -->
        <div class="absolute inset-0 flex items-center justify-center p-4 md:p-8 overflow-visible">
            
            <div class="poem-book-container"
                 x-show="show"
                 x-transition:enter="transition-all ease-out duration-1000"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition-all ease-in duration-500"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 x-effect="if (show) { leftOpen = false; rightOpen = false; requestAnimationFrame(() => { leftOpen = true; rightOpen = true; }); } else { leftOpen = false; rightOpen = false; }">
                
                <!-- Close Button -->
                <button wire:click="closeModal"
                        class="absolute -top-4 -right-4 z-50 w-12 h-12 bg-white dark:bg-neutral-800 rounded-full shadow-2xl
                               hover:scale-110 hover:rotate-90 transition-all duration-300
                               flex items-center justify-center text-neutral-600 dark:text-neutral-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
                
                <!-- Libro aperto con effetto 3D -->
                <div class="poem-book-opened">
                    
                    <!-- Pagina Sinistra -->
                    <div class="poem-page poem-page-left"
                         x-bind:class="leftOpen ? 'poem-page-open-left' : 'poem-page-closed-left'">
                        
                        <div class="poem-page-content">
                            <!-- Cover + Author Info -->
                            <div class="flex flex-col items-center justify-center h-full text-center space-y-6">
                                @if($poem->thumbnail_url)
                                    <div class="poem-modal-cover poem-modal-cover-left">
                                        <img src="{{ $poem->thumbnail_url }}"
                                             alt="{{ $poem->title ?: __('poems.untitled') }}"
                                             class="poem-modal-cover-image">
                                        <span class="poem-modal-cover-shadow"></span>
                                    </div>
                                @endif
                                <img src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($poem->user, 120) }}" 
                                     alt="{{ $poem->user->name }}"
                                     class="w-24 h-24 rounded-full object-cover ring-4 ring-accent-200 shadow-xl">
                                
                                <div>
                                    <h3 class="text-xl font-bold text-neutral-800 mb-1" style="font-family: 'Crimson Pro', serif;">
                                        {{ $poem->user->name }}
                                    </h3>
                                    <p class="text-xs text-neutral-600 italic">Poeta</p>
                                </div>
                                
                                <div class="w-12 h-0.5 bg-gradient-to-r from-transparent via-accent-400 to-transparent"></div>
                                
                                <div class="text-center text-neutral-600 space-y-1">
                                    <p class="text-2xl font-bold text-accent-600">{{ $poem->like_count ?? 0 }}</p>
                                    <p class="text-xs">Mi piace</p>
                                </div>
                                
                                <div class="text-xs text-neutral-500">
                                    {{ $poem->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pagina Destra -->
                    <div class="poem-page poem-page-right"
                         x-bind:class="rightOpen ? 'poem-page-open-right' : 'poem-page-closed-right'">
                        
                        <div class="poem-page-content overflow-y-auto">
                            @auth
                                @if(auth()->id() === $poem->user_id)
                                    <div class="flex justify-end mb-6 pt-2 pr-12 md:pr-20">
                                        <a href="{{ route('poems.edit', $poem->slug) }}"
                                           class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-accent-500 text-white text-sm font-semibold shadow-lg shadow-accent-500/30 hover:bg-accent-600 transition-all duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.5 2.5l3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                            </svg>
                                            <span>{{ __('poems.show.edit_poem') }}</span>
                                        </a>
                                    </div>
                                @endif
                            @endauth
                             <!-- Title -->
                             <h2 class="text-2xl md:text-3xl font-bold text-neutral-900 mb-4 text-center italic" 
                                 style="font-family: 'Crimson Pro', serif;">
                                 "{{ $poem->title ?: __('poems.untitled') }}"
                             </h2>
                            
                            <!-- Category Badge -->
                            <div class="flex justify-center mb-4">
                                <span class="px-3 py-1 bg-accent-100 text-accent-800 rounded-full text-xs font-medium">
                                    {{ config('poems.categories')[$poem->category] ?? $poem->category }}
                                </span>
                            </div>
                            
                            <!-- Poem Content -->
                            <div class="poem-modal-content">
                                {!! $poem->content !!}
                            </div>
                            
                            <!-- Social Actions -->
                            <div class="mt-8 pt-6 border-t border-neutral-300">
                                <div class="flex items-center justify-center gap-4">
                                    <x-like-button 
                                        :itemId="$poem->id"
                                        itemType="poem"
                                        :isLiked="false"
                                        :likesCount="$poem->like_count ?? 0"
                                        size="md" />
                                    
                                    <x-comment-button 
                                        :itemId="$poem->id"
                                        itemType="poem"
                                        :commentsCount="$poem->comment_count ?? 0"
                                        size="md" />
                                    
                                    <x-share-button 
                                        :itemId="$poem->id"
                                        itemType="poem"
                                        size="md" />
                                </div>
                                
                                <p class="text-sm text-neutral-500 italic text-center mt-4">
                                    {{ $poem->created_at->format('d M Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Centro libro (rilegatura) -->
                    <div class="poem-book-spine"></div>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    <style>
        /* ========================================
           POEM MODAL - Effetto Libro che si Apre
           ======================================== */
        
        .poem-book-container {
            position: relative;
            perspective: 2000px;
            max-width: 900px;
            width: 90%;
            height: 70vh;
            max-height: 600px;
        }
        
        .poem-book-opened {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            transform-style: preserve-3d;
        }
        
        .poem-page {
            width: 50%;
            height: 100%;
            background: 
                /* Texture carta */
                url("data:image/svg+xml,%3Csvg width='100' height='100' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='paper'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.04' numOctaves='5' seed='2' /%3E%3CfeColorMatrix type='saturate' values='0'/%3E%3C/filter%3E%3Crect width='100' height='100' filter='url(%23paper)' opacity='0.03'/%3E%3C/svg%3E"),
                linear-gradient(135deg, 
                    #fffef9 0%,
                    #fffdf7 50%,
                    #fffcf5 100%
                );
            box-shadow: 
                inset 0 0 0 2px rgba(180, 120, 70, 0.3),
                inset 0 0 40px rgba(160, 100, 60, 0.15);
            transform-style: preserve-3d;
            transform-origin: center;
            transition: transform 0.9s cubic-bezier(0.34, 1.56, 0.64, 1),
                        opacity 0.6s ease;
            position: relative;
        }
        
        .poem-page-left {
            border-radius: 12px 0 0 12px;
            box-shadow: 
                inset -4px 0 12px rgba(180, 120, 70, 0.3),
                inset 0 0 40px rgba(160, 100, 60, 0.15),
                -20px 0 40px rgba(0, 0, 0, 0.3);
            transform-origin: right center;
        }
        
        .poem-page-right {
            border-radius: 0 12px 12px 0;
            box-shadow: 
                inset 4px 0 12px rgba(180, 120, 70, 0.3),
                inset 0 0 40px rgba(160, 100, 60, 0.15),
                20px 0 40px rgba(0, 0, 0, 0.3);
            transform-origin: left center;
        }
        
        .poem-page-open-left {
            transform: perspective(1200px) rotateY(15deg);
            opacity: 1;
            pointer-events: auto;
        }
        
        .poem-page-open-right {
            transform: perspective(1200px) rotateY(-15deg);
            opacity: 1;
            pointer-events: auto;
        }
        
        .poem-page-closed-left {
            transform: perspective(1200px) rotateY(-110deg) !important;
            opacity: 0;
            pointer-events: none;
        }
        
        .poem-page-closed-right {
            transform: perspective(1200px) rotateY(110deg) !important;
            opacity: 0;
            pointer-events: none;
        }
        
        .poem-page-content {
            padding: 2rem;
            height: 100%;
            overflow-y: auto;
        }
        
        .poem-modal-cover {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            margin: 0 auto 2rem;
            max-width: 420px;
            box-shadow:
                0 18px 30px rgba(0, 0, 0, 0.18),
                inset 0 0 0 1px rgba(180, 120, 70, 0.2);
        }
        
        .poem-modal-cover-left {
            max-width: 320px;
            margin-bottom: 1.5rem;
        }
        
        .poem-modal-cover-left .poem-modal-cover-image {
            height: 220px;
        }
        
        .poem-modal-cover-image {
            display: block;
            width: 100%;
            height: 260px;
            object-fit: cover;
            transition: transform 0.6s ease;
        }
        
        .poem-modal-cover-shadow {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(0,0,0,0) 45%, rgba(0,0,0,0.3) 100%);
            mix-blend-mode: multiply;
            pointer-events: none;
        }
        
        .poem-page-left:hover .poem-modal-cover-image {
            transform: scale(1.03);
        }
        
        /* Rilegatura centrale */
        .poem-book-spine {
            position: absolute;
            left: 50%;
            top: 0;
            bottom: 0;
            width: 8px;
            transform: translateX(-50%);
            background: linear-gradient(
                180deg,
                rgba(139, 92, 46, 0.8) 0%,
                rgba(120, 80, 40, 0.9) 50%,
                rgba(139, 92, 46, 0.8) 100%
            );
            box-shadow: 
                inset 0 0 8px rgba(0, 0, 0, 0.5),
                0 0 20px rgba(0, 0, 0, 0.4);
            z-index: 10;
        }
        
        /* Contenuto poesia */
        .poem-modal-content {
            font-family: 'Crimson Pro', serif;
            font-size: 1rem;
            line-height: 1.8;
            color: #2d2520;
            white-space: pre-wrap;
            text-align: left;
        }
        
        .poem-modal-content p {
            margin-bottom: 1.5rem;
        }
        
        /* Scrollbar personalizzata */
        .poem-page-content::-webkit-scrollbar {
            width: 8px;
        }
        
        .poem-page-content::-webkit-scrollbar-track {
            background: rgba(180, 120, 70, 0.1);
            border-radius: 4px;
        }
        
        .poem-page-content::-webkit-scrollbar-thumb {
            background: rgba(180, 120, 70, 0.3);
            border-radius: 4px;
        }
        
        .poem-page-content::-webkit-scrollbar-thumb:hover {
            background: rgba(180, 120, 70, 0.5);
        }
        
        @media (max-width: 768px) {
            .poem-book-container {
                height: 90vh;
                max-height: none;
                width: 95%;
                max-width: none;
                padding-top: 30px;
            }
            
            .poem-book-opened {
                flex-direction: column;
                gap: 0;
                position: relative;
                overflow: visible;
            }
            
            .poem-page {
                width: 100%;
                transform: none !important;
                border-radius: 0;
            }
            
            /* MOBILE: Blocco Note - Header con BUCHI per spirale */
            .poem-page-left {
                height: auto;
                min-height: auto;
                padding: 0;
                padding-top: 20px;
                border-radius: 0;
                box-shadow: 
                    inset 0 0 30px rgba(160, 100, 60, 0.15),
                    0 2px 8px rgba(0, 0, 0, 0.15);
                border-bottom: 2px solid rgba(200, 40, 40, 0.15);
                position: relative;
                background: linear-gradient(
                    135deg,
                    #fffef9 0%,
                    #fffdf7 50%,
                    #fffcf5 100%
                );
            }
            
            /* BUCHI nel foglio per la spirale - con profondità */
            .poem-page-left::before {
                content: '';
                position: absolute;
                left: 0;
                right: 0;
                top: 0;
                height: 20px;
                background: 
                    /* Buchi ovali con ombra interna per profondità */
                    radial-gradient(ellipse 6px 8px at 40px 10px, 
                        rgba(0, 0, 0, 0.6) 0,
                        rgba(0, 0, 0, 0.4) 2px,
                        rgba(0, 0, 0, 0.2) 4px,
                        transparent 6px),
                    radial-gradient(ellipse 6px 8px at 90px 10px, 
                        rgba(0, 0, 0, 0.6) 0,
                        rgba(0, 0, 0, 0.4) 2px,
                        rgba(0, 0, 0, 0.2) 4px,
                        transparent 6px),
                    radial-gradient(ellipse 6px 8px at 140px 10px, 
                        rgba(0, 0, 0, 0.6) 0,
                        rgba(0, 0, 0, 0.4) 2px,
                        rgba(0, 0, 0, 0.2) 4px,
                        transparent 6px),
                    radial-gradient(ellipse 6px 8px at 190px 10px, 
                        rgba(0, 0, 0, 0.6) 0,
                        rgba(0, 0, 0, 0.4) 2px,
                        rgba(0, 0, 0, 0.2) 4px,
                        transparent 6px),
                    radial-gradient(ellipse 6px 8px at 240px 10px, 
                        rgba(0, 0, 0, 0.6) 0,
                        rgba(0, 0, 0, 0.4) 2px,
                        rgba(0, 0, 0, 0.2) 4px,
                        transparent 6px),
                    radial-gradient(ellipse 6px 8px at 290px 10px, 
                        rgba(0, 0, 0, 0.6) 0,
                        rgba(0, 0, 0, 0.4) 2px,
                        rgba(0, 0, 0, 0.2) 4px,
                        transparent 6px),
                    radial-gradient(ellipse 6px 8px at 340px 10px, 
                        rgba(0, 0, 0, 0.6) 0,
                        rgba(0, 0, 0, 0.4) 2px,
                        rgba(0, 0, 0, 0.2) 4px,
                        transparent 6px);
                z-index: 2;
            }
            
            .poem-page-left .poem-page-content {
                padding: 0.5rem 1rem 1rem 1rem;
            }
            
            /* SPIRALE METALLICA - highlight + shadow centrati nei buchi */
            .poem-book-opened::before {
                content: '';
                position: absolute;
                left: 0;
                right: 0;
                top: -8px;
                height: 16px;
                z-index: 101;
                pointer-events: none;
                background-image:
                    radial-gradient(circle at 25px 4px,
                        rgba(255, 255, 255, 0.98) 0,
                        rgba(230, 230, 230, 0.9) 4px,
                        rgba(220, 220, 220, 0.6) 5px,
                        transparent 6px),
                    radial-gradient(circle at 25px 12px,
                        rgba(0, 0, 0, 0.45) 0,
                        rgba(0, 0, 0, 0.35) 4px,
                        rgba(0, 0, 0, 0.15) 5px,
                        transparent 6px),
                    linear-gradient(to right,
                        transparent 0,
                        transparent 18px,
                        rgba(120, 120, 120, 0.85) 18px,
                        rgba(195, 195, 195, 0.95) 24px,
                        rgba(120, 120, 120, 0.85) 30px,
                        transparent 30px,
                        transparent 50px),
                    linear-gradient(to bottom,
                        rgba(255, 255, 255, 0.12),
                        rgba(0, 0, 0, 0.12));
                background-size:
                    50px 16px,
                    50px 16px,
                    50px 16px,
                    100% 16px;
                background-position:
                    15px 0,
                    15px 0,
                    15px 0,
                    0 0;
                background-repeat:
                    repeat-x,
                    repeat-x,
                    repeat-x,
                    no-repeat;
                filter: drop-shadow(0 3px 4px rgba(0, 0, 0, 0.42))
                        drop-shadow(0 6px 8px rgba(0, 0, 0, 0.22));
            }
            
            .poem-page-left .flex {
                flex-direction: row;
                align-items: center;
                justify-content: flex-start;
                gap: 1rem;
                text-align: left;
                height: auto;
            }
            
            .poem-page-left img {
                width: 3.5rem;
                height: 3.5rem;
                flex-shrink: 0;
            }
            
            .poem-page-left .w-12 {
                display: none;
            }
            
            .poem-page-left .space-y-6 > div:last-child {
                display: none;
            }
            
            .poem-page-left .text-center {
                text-align: left;
            }
            
            .poem-page-left h3 {
                font-size: 1.125rem;
                margin-bottom: 0.25rem;
            }
            
            .poem-page-left .space-y-1 {
                display: flex;
                flex-direction: row;
                align-items: center;
                gap: 0.5rem;
            }
            
            .poem-page-left .space-y-1 p:first-child {
                font-size: 1.25rem;
            }
            
            .poem-page-left .space-y-1 p:last-child {
                font-size: 0.75rem;
            }
            
            .poem-page-right {
                flex: 1;
                height: auto;
                border-radius: 0 0 12px 12px;
                box-shadow: 
                    inset 0 0 30px rgba(160, 100, 60, 0.15),
                    0 8px 16px rgba(0, 0, 0, 0.25);
                position: relative;
                display: flex;
                flex-direction: column;
                min-height: 0;
                /* Linee notebook orizzontali */
                background: 
                    /* Margine rosso verticale */
                    linear-gradient(
                        to right,
                        transparent 0,
                        transparent 2.5rem,
                        rgba(200, 40, 40, 0.1) 2.5rem,
                        rgba(200, 40, 40, 0.1) calc(2.5rem + 1px),
                        transparent calc(2.5rem + 1px)
                    ),
                    /* Linee orizzontali SOTTILI */
                    repeating-linear-gradient(
                        to bottom,
                        transparent 0,
                        transparent 1.8rem,
                        rgba(180, 150, 120, 0.06) 1.8rem,
                        rgba(180, 150, 120, 0.06) calc(1.8rem + 0.5px),
                        transparent calc(1.8rem + 0.5px)
                    ),
                    linear-gradient(
                        135deg,
                        #fffef9 0%,
                        #fffdf7 50%,
                        #fffcf5 100%
                    );
            }
            
            .poem-page-right .poem-page-content {
                padding: 2rem 1.5rem 1.5rem 3rem;
                flex: 1;
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
                overscroll-behavior: contain;
            }

            .poem-modal-cover {
                max-width: 100%;
                margin-bottom: 1.5rem;
            }

            .poem-modal-cover-image {
                height: 200px;
            }

            .poem-book-spine {
                display: none;
            }
            
            .poem-page-content {
                padding: 1.5rem;
            }
            
            .poem-modal-content {
                font-size: 0.9375rem;
                line-height: 1.8;
            }
            
            .poem-page-right h2 {
                font-size: 1.5rem;
                margin-bottom: 1rem;
            }
            
            .poem-page-right .px-3 {
                font-size: 0.75rem;
                padding: 0.25rem 0.75rem;
            }
            
            .poetry-giant-quote {
                font-size: 1.5rem;
            }
        }
    </style>
</div>
