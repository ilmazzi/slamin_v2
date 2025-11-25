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
         @keydown.escape.window="$wire.closeModal()"
         x-init="$watch('show', value => { if (value) { document.querySelectorAll('[x-data]').forEach(el => { if (el.__x && el.__x.$data.showMenu !== undefined) el.__x.$data.showMenu = false; }); } })"
         x-effect="show ? document.body.style.overflow = 'hidden' : document.body.style.overflow = ''">
        
        <!-- Dark Backdrop -->
        <div class="absolute inset-0 bg-black/80 z-0"
             @click="$wire.closeModal()"></div>
        
        <!-- Book Container -->
        <div class="relative z-10 flex items-center justify-center py-8 md:py-12 px-4 md:px-8 w-full min-h-full overflow-y-auto overflow-x-hidden">
            
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
                            <div class="poem-left-meta">
                                <div class="poem-left-header">
                                    <img src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($poem->user, 120) }}" 
                                         alt="{{ $poem->user->name }}"
                                         class="poem-left-avatar">

                                    <div class="poem-left-header-info">
                                        <div class="poem-left-author">
                                            <a href="{{ \App\Helpers\AvatarHelper::getUserProfileUrl($poem->user) }}" 
                                               class="hover:underline transition-colors">
                                                <h3>{{ \App\Helpers\AvatarHelper::getDisplayName($poem->user) }}</h3>
                                            </a>
                                            <p>Poeta</p>
                                        </div>
                                        
                                        <div class="poem-left-stats-inline">
                                            <div class="poem-left-stats">
                                                <p class="count">{{ $poem->like_count ?? 0 }}</p>
                                                <p class="label">Mi piace</p>
                                            </div>
                                            <div class="poem-left-divider-vertical"></div>
                                            <div class="poem-left-date">
                                                {{ $poem->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if($poem->thumbnail_url)
                                    <div class="poem-modal-cover poem-modal-cover-left">
                                        <img src="{{ $poem->thumbnail_url }}"
                                             alt="{{ $poem->title ?: __('poems.untitled') }}"
                                             class="poem-modal-cover-image">
                                        <span class="poem-modal-cover-shadow"></span>
                                    </div>
                                @endif

                                @auth
                                    @if(auth()->id() === $poem->user_id)
                                        <div class="poem-owner-actions-bar">
                                            <div class="poem-owner-actions">
                                                <a href="{{ route('poems.edit', $poem->slug) }}" class="poem-owner-action">
                                                    <svg class="poem-owner-action-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.5 2.5l3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                                    </svg>
                                                    <span>{{ __('poems.show.edit_poem') }}</span>
                                                </a>
                                                <button type="button" wire:click="emitTranslationRequest" class="poem-owner-action">
                                                    <svg class="poem-owner-action-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
                                                    </svg>
                                                    <span>{{ __('translations.request_translation') }}</span>
                                                </button>
                                                <a href="{{ route('poems.my-poems') }}" class="poem-owner-action">
                                                    <svg class="poem-owner-action-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    <span>{{ __('poems.my_poems.title') }}</span>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pagina Destra -->
                    <div class="poem-page poem-page-right"
                         x-bind:class="rightOpen ? 'poem-page-open-right' : 'poem-page-closed-right'">
                        
                        <div class="poem-page-content">
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
                                        :isLiked="$poem->is_liked ?? false"
                                        :likesCount="$poem->like_count ?? 0"
                                        size="md" />
                                    
                                    <x-comment-button 
                                        :itemId="$poem->id"
                                        itemType="poem"
                                        :commentsCount="$poem->comment_count ?? 0"
                                        size="md" />
                                    
                                    <x-share-button 
                                        :url="route('poems.show', $poem->slug)"
                                        :title="$poem->title ?: __('poems.untitled')"
                                        size="md" />
                                    
                                    <x-report-button 
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

    @if($poem)
        <livewire:translations.translation-request :poem="$poem" :key="'translation-request-'.$poem->id" />
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
            z-index: 20;
        }
        
        .poem-page-left {
            border-radius: 12px 0 0 12px;
            box-shadow: 
                inset -4px 0 12px rgba(180, 120, 70, 0.3),
                inset 0 0 40px rgba(160, 100, 60, 0.15);
            transform-origin: right center;
        }
        
        .poem-page-right {
            border-radius: 0 12px 12px 0;
            box-shadow: 
                inset 4px 0 12px rgba(180, 120, 70, 0.3),
                inset 0 0 40px rgba(160, 100, 60, 0.15);
            transform-origin: left center;
        }
        
        .poem-page-open-left {
            transform: perspective(1200px) rotateY(7deg);
            opacity: 1;
            pointer-events: auto;
        }
        
        .poem-page-open-right {
            transform: perspective(1200px) rotateY(-7deg);
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
            overflow-x: hidden;
            position: relative;
            z-index: 10;
        }
        
        .poem-modal-cover {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            margin: 0 auto 2rem;
            max-width: 420px;
            aspect-ratio: 4 / 3;
            background: #f7f0e1;
            box-shadow:
                0 18px 30px rgba(0, 0, 0, 0.18),
                inset 0 0 0 1px rgba(180, 120, 70, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .poem-modal-cover-left {
            max-width: 200px;
            width: 200px;
            margin: 0 auto 1rem;
            aspect-ratio: 3 / 4;
        }
        
        .poem-modal-cover-left .poem-modal-cover-image {
            height: 100%;
        }
 
        .poem-left-meta {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 0.75rem;
        }

        .poem-left-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            width: 100%;
        }

        .poem-left-avatar {
            width: 4.5rem;
            height: 4.5rem;
            border-radius: 9999px;
            object-fit: cover;
            flex-shrink: 0;
            box-shadow:
                0 12px 25px rgba(0, 0, 0, 0.18),
                0 0 0 4px rgba(155, 214, 173, 0.6);
        }

        .poem-left-header-info {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            flex: 1;
            text-align: left;
        }

        .poem-left-author h3 {
            font-family: 'Crimson Pro', serif;
            font-size: 1rem;
            font-weight: 700;
            color: #2d2520;
            margin: 0;
        }

        .poem-left-author p {
            font-size: 0.7rem;
            color: #7a6d62;
            font-style: italic;
            margin: 0;
        }

        .poem-left-stats-inline {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .poem-left-divider-vertical {
            width: 1px;
            height: 1.5rem;
            background: rgba(190, 140, 90, 0.3);
        }

        .poem-left-stats {
            text-align: left;
        }

        .poem-left-stats .count {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1a9e6a;
            margin: 0;
            line-height: 1;
        }

        .poem-left-stats .label {
            font-size: 0.6rem;
            color: #7a6d62;
            margin: 0;
            line-height: 1.2;
        }

        .poem-left-date {
            font-size: 0.65rem;
            color: #9a8e81;
            line-height: 1.3;
        }

        .poem-owner-actions-bar {
            width: 100%;
            display: flex;
            justify-content: center;
            margin-top: 0.5rem;
        }

        .poem-owner-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            flex-wrap: wrap;
            position: relative;
            z-index: 30;
        }

        .poem-owner-action {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.38rem 0.95rem;
            border-radius: 9999px;
            font-size: 0.78rem;
            font-weight: 600;
            color: #2c251f;
            background: #fdf5e2;
            border: 1px solid rgba(180, 120, 70, 0.38);
            box-shadow:
                0 6px 14px rgba(0, 0, 0, 0.08),
                inset 0 0 12px rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: box-shadow 0.2s ease, border-color 0.2s ease;
            white-space: nowrap;
            flex: 0 0 auto;
            overflow: visible;
        }

        .poem-owner-action:hover {
            transform: translateY(-1px);
            color: #215c4a;
            border-color: rgba(60, 120, 90, 0.3);
            box-shadow:
                0 8px 18px rgba(0, 0, 0, 0.12),
                inset 0 0 16px rgba(255, 255, 255, 0.9);
        }

        .poem-owner-action:active {
            transform: translateY(0);
        }

        .poem-owner-action-icon {
            width: 1rem;
            height: 1rem;
        }

        .poem-modal-cover-image {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
            object-position: center;
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
            z-index: 25;
            pointer-events: none;
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
            .absolute.inset-0.flex {
                align-items: flex-start !important;
                padding-top: 2rem !important;
            }
            
            .poem-book-container {
                height: auto;
                min-height: 90vh;
                max-height: none;
                width: 95%;
                max-width: none;
                padding-top: 0;
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
                padding-top: 25px;
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
                ) !important;
                overflow: visible !important;
            }
            
            /* BUCHI nel foglio per la spirale - con profondità */
            .poem-page-left::before {
                content: '';
                position: absolute;
                left: 0;
                right: 0;
                top: 0;
                height: 20px;
                pointer-events: none;
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
                padding: 0.5rem 1rem 1.5rem 1rem !important;
                overflow: visible !important;
                position: relative !important;
                z-index: 10 !important;
            }
            
            .poem-left-meta {
                gap: 0.75rem !important;
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
                position: relative !important;
                z-index: 10 !important;
            }
            
            .poem-left-avatar {
                width: 5rem !important;
                height: 5rem !important;
                display: block !important;
                position: relative !important;
                z-index: 10 !important;
            }
            
            .poem-left-author {
                position: relative !important;
                z-index: 10 !important;
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
            
            /* Rimosso: tutte le regole vecchie del layout precedente */
            
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

            .poem-modal-cover-left {
                max-width: 100%;
                width: 100%;
                aspect-ratio: 16 / 9;
                margin: 0 auto 1.5rem;
            }

            .poem-modal-cover-left .poem-modal-cover-image {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .poem-owner-actions {
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
                gap: 0.45rem;
            }
            
            .poem-owner-action {
                font-size: 0.78rem;
                padding: 0.4rem 0.9rem;
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
