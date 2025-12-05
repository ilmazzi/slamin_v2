<div class="min-h-screen bg-gradient-to-br from-neutral-50 via-primary-50/20 to-neutral-50 dark:from-neutral-900 dark:via-primary-950/10 dark:to-neutral-900">
    
    <!-- Decorative Background -->
    <div class="fixed inset-0 opacity-[0.02] pointer-events-none overflow-hidden">
        <div class="absolute top-20 left-10 text-primary-500 text-9xl font-poem">"</div>
        <div class="absolute bottom-20 right-10 text-primary-500 text-9xl font-poem">"</div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-primary-300 text-[20rem] font-poem opacity-10">✍</div>
    </div>
    
    <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Elegant Back Button -->
        <a href="{{ route('poems.index') }}" 
           class="group inline-flex items-center gap-3 mb-8
                  text-neutral-600 dark:text-neutral-400
                  hover:text-primary-600 dark:hover:text-primary-400 
                  transition-all duration-300">
            <div class="p-2 rounded-xl bg-white dark:bg-neutral-800 
                        shadow-lg group-hover:shadow-xl group-hover:-translate-x-1
                        transition-all duration-300 border border-neutral-200 dark:border-neutral-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </div>
            <span class="font-medium font-poem">Torna alle poesie</span>
        </a>
        
        <!-- Main Card - Poetic Design -->
        <article class="backdrop-blur-2xl bg-white/90 dark:bg-neutral-800/90 
                        rounded-[2rem] shadow-2xl overflow-hidden mb-12
                        border border-white/50 dark:border-neutral-700/50
                        animate-fade-in-scale">
            
            <!-- Header Image with Parallax Effect -->
            @if($poem->thumbnail_url)
                <div class="aspect-[21/9] relative overflow-hidden">
                    <img src="{{ $poem->thumbnail_url }}" 
                         alt="{{ $poem->title ?: __('poems.untitled') }}"
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                    
                    <!-- Floating quote decoration -->
                    <div class="absolute bottom-8 right-8 text-white/20 text-9xl font-poem leading-none pointer-events-none">
                        "
                    </div>
                </div>
            @endif
            
            <div class="p-8 md:p-12 lg:p-16">
                
                <!-- Header Section -->
                <div class="mb-12">
                    <!-- Badges with elegant spacing -->
                    <div class="flex flex-wrap items-center gap-3 mb-6">
                        <x-ui.badges.category 
                            :label="config('poems.categories')[$poem->category] ?? $poem->category" 
                            color="primary" 
                            class="!shadow-lg" />
                        
                        @if($poem->poem_type)
                            <x-ui.badges.category 
                                :label="config('poems.poem_types')[$poem->poem_type] ?? $poem->poem_type" 
                                color="info" 
                                class="!bg-neutral-100 dark:!bg-neutral-700 !text-neutral-700 dark:!text-neutral-300 !shadow-lg" />
                        @endif
                        
                        @if($poem->is_featured)
                            <x-ui.badges.category 
                                label="⭐ In Evidenza" 
                                color="warning" 
                                class="!shadow-lg animate-pulse" />
                        @endif
                    </div>
                    
                    <!-- Title with decorative quotes -->
                    <div class="relative">
                        <div class="absolute -left-8 -top-4 text-primary-200 dark:text-primary-900/30 text-8xl font-poem leading-none pointer-events-none">
                            ❝
                        </div>
                        <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold 
                                   text-neutral-900 dark:text-white mb-8 font-poem 
                                   leading-tight tracking-tight relative z-10">
                            {{ $poem->title ?: __('poems.untitled') }}
                        </h1>
                        <div class="absolute -right-8 -bottom-4 text-primary-200 dark:text-primary-900/30 text-8xl font-poem leading-none pointer-events-none">
                            ❞
                        </div>
                    </div>
                    
                    <!-- Author & Meta - Enhanced -->
                    <div class="flex items-center justify-between flex-wrap gap-6 
                                p-6 rounded-2xl bg-neutral-50/50 dark:bg-neutral-900/50 
                                border border-neutral-200 dark:border-neutral-700">
                        <x-ui.user-avatar 
                            :user="$poem->user" 
                            size="lg" 
                            :showName="true" 
                            :link="true"
                            class="hover:scale-105 transition-transform" />
                        
                        <!-- Stats Grid -->
                        <div class="flex items-center gap-8 text-sm">
                            <div class="text-center">
                                <div class="flex items-center justify-center gap-2 text-primary-600 dark:text-primary-400 mb-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <span class="font-bold text-lg">{{ number_format($poem->view_count ?? 0) }}</span>
                                </div>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400 font-medium">visualizzazioni</p>
                            </div>
                            
                            @if($poem->word_count)
                                <div class="text-center">
                                    <div class="flex items-center justify-center gap-2 text-primary-600 dark:text-primary-400 mb-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span class="font-bold text-lg">{{ number_format($poem->word_count) }}</span>
                                    </div>
                                    <p class="text-xs text-neutral-500 dark:text-neutral-400 font-medium">parole</p>
                                </div>
                            @endif
                            
                            <div class="text-center">
                                <div class="flex items-center justify-center gap-2 text-primary-600 dark:text-primary-400 mb-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="font-bold text-lg">{{ $poem->published_at?->format('d M Y') ?? $poem->created_at->format('d M Y') }}</span>
                                </div>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400 font-medium">pubblicata</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Language Selector - Elegant Pills -->
                @if($poem->poemTranslations && $poem->poemTranslations->count() > 0)
                    <div class="mb-12 pb-10 border-b-2 border-dashed border-neutral-200 dark:border-neutral-700">
                        <div class="flex items-center gap-3 mb-4">
                            <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                            </svg>
                            <p class="text-sm font-semibold text-neutral-700 dark:text-neutral-300 font-poem">
                                Leggi in un'altra lingua:
                            </p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <!-- Original Language -->
                            <button wire:click="switchLanguage('{{ $poem->language }}')"
                                    class="group px-6 py-3 rounded-2xl font-medium transition-all duration-300
                                           {{ $currentLanguage === $poem->language 
                                              ? 'bg-gradient-to-r from-primary-500 to-primary-600 text-white shadow-xl shadow-primary-500/30 scale-105' 
                                              : 'bg-white dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-600 shadow-lg hover:scale-105' }}">
                                <span class="flex items-center gap-2">
                                    <svg class="w-5 h-5 {{ $currentLanguage === $poem->language ? 'animate-pulse' : '' }}" 
                                         fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="font-poem">{{ config('poems.languages')[$poem->language] ?? $poem->language }}</span>
                                </span>
                            </button>
                            
                            <!-- Translations -->
                            @foreach($poem->poemTranslations as $translation)
                                @if($translation->status === 'approved')
                                    <button wire:click="switchLanguage('{{ $translation->language }}')"
                                            class="group px-6 py-3 rounded-2xl font-medium transition-all duration-300
                                                   {{ $currentLanguage === $translation->language 
                                                      ? 'bg-gradient-to-r from-primary-500 to-primary-600 text-white shadow-xl shadow-primary-500/30 scale-105' 
                                                      : 'bg-white dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-600 shadow-lg hover:scale-105' }}">
                                        <span class="flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                                            </svg>
                                            <span class="font-poem">{{ config('poems.languages')[$translation->language] ?? $translation->language }}</span>
                                        </span>
                                    </button>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <!-- Content - Poetic Typography -->
                <div class="mb-12">
                    @if($currentTranslation)
                        <!-- Translation Notice -->
                        <div class="mb-6 p-4 rounded-2xl bg-primary-50 dark:bg-primary-900/20 
                                    border-l-4 border-primary-500">
                            <p class="text-sm text-primary-700 dark:text-primary-300 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="font-medium">Stai leggendo la traduzione in {{ config('poems.languages')[$currentTranslation->language] }}</span>
                            </p>
                        </div>
                        
                        <!-- FOGLIO VINTAGE per Traduzione -->
                        <div class="relative vintage-paper-container" style="transform: perspective(1200px) rotateX(1deg);">
                            <div class="relative vintage-paper-sheet overflow-visible p-12 md:p-16">
                                <!-- Angolo piegato sinistra -->
                                <div class="vintage-corner-left"></div>
                                
                                <!-- Texture vintage -->
                                <div class="vintage-texture"></div>
                                
                                <!-- Macchie vintage -->
                                <div class="vintage-stains"></div>
                                
                                <!-- Contenuto Traduzione -->
                                <div class="poem-content relative z-30 text-neutral-900 dark:text-neutral-100 font-poem text-lg md:text-xl leading-relaxed" style="color: #1f2937 !important; text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);">
                                    <div style="position: relative; z-index: 100;">
                                        {!! $currentTranslation->content !!}
                                    </div>
                                </div>
                                
                                <!-- Translator Notes dentro foglio -->
                                @if($currentTranslation->translator_notes)
                                    <div class="mt-10 pt-8 border-t border-amber-300/30 relative z-20">
                                        <div class="flex items-start gap-3">
                                            <svg class="w-6 h-6 text-amber-700 dark:text-amber-400 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                            </svg>
                                            <div class="flex-1">
                                                <p class="text-sm font-bold text-amber-900 dark:text-amber-100 mb-2 font-poem">
                                                    Note del traduttore:
                                                </p>
                                                <p class="text-sm text-amber-800 dark:text-amber-200 italic font-poem">
                                                    "{{ $currentTranslation->translator_notes }}"
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <!-- FOGLIO VINTAGE REALISTICO -->
                        <div class="relative vintage-paper-container" style="transform: perspective(1200px) rotateX(1deg);">
                            <div class="relative vintage-paper-sheet overflow-visible p-12 md:p-16">
                                <!-- Angolo piegato sinistra -->
                                <div class="vintage-corner-left"></div>
                                
                                <!-- Texture vintage -->
                                <div class="vintage-texture"></div>
                                
                                <!-- Macchie vintage -->
                                <div class="vintage-stains"></div>
                                
                                <!-- Contenuto Poesia -->
                                <div class="poem-content relative z-30 text-neutral-900 dark:text-neutral-100 font-poem text-lg md:text-xl leading-relaxed" style="color: #1f2937 !important; text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);">
                                    <div style="position: relative; z-index: 100;">
                                        {!! $poem->content !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- STILE FOGLIO VINTAGE -->
                <style>
                    /* FOGLIO VINTAGE - Carta Antica */
                    .vintage-paper-sheet {
                        background: linear-gradient(135deg, 
                            #f5ead8 0%, 
                            #f9f3e8 20%, 
                            #f5ead8 40%,
                            #f9f3e8 60%,
                            #f5ead8 80%,
                            #f9f3e8 100%
                        );
                        position: relative;
                        border-radius: 3px 4px 2px 3px;
                        
                        /* Bordi consumati */
                        clip-path: polygon(
                            0.8% 0.4%, 2% 0.9%, 4% 0.3%, 6% 1.1%, 8% 0.6%, 10% 0.9%, 
                            15% 0.5%, 20% 1%, 25% 0.4%, 30% 0.8%, 35% 0.6%, 40% 1.2%, 
                            45% 0.5%, 50% 0.9%, 55% 0.7%, 60% 1.1%, 65% 0.5%, 70% 0.9%, 
                            75% 0.6%, 80% 1%, 85% 0.7%, 90% 1.1%, 95% 0.5%, 97% 0.9%, 99% 0.6%,
                            99.5% 5%, 99.2% 10%, 99.7% 15%, 99.4% 20%, 99.8% 25%, 99.5% 30%,
                            99.9% 35%, 99.4% 40%, 99.7% 45%, 99.5% 50%, 99.8% 55%, 99.4% 60%,
                            99.7% 65%, 99.5% 70%, 99.8% 75%, 99.4% 80%, 99.7% 85%, 99.5% 90%,
                            99.8% 95%, 99.2% 98%, 98% 99.5%, 95% 99.2%, 90% 99.6%, 85% 99.3%,
                            80% 99.7%, 75% 99.4%, 70% 99.8%, 65% 99.5%, 60% 99.9%, 55% 99.4%,
                            50% 99.7%, 45% 99.5%, 40% 99.8%, 35% 99.4%, 30% 99.7%, 25% 99.5%,
                            20% 99.8%, 15% 99.4%, 10% 99.7%, 5% 99.3%, 2% 98.5%, 0.7% 96%,
                            0.4% 90%, 0.8% 85%, 0.5% 80%, 0.9% 75%, 0.6% 70%, 1% 65%,
                            0.5% 60%, 0.8% 55%, 0.6% 50%, 0.9% 45%, 0.5% 40%, 0.8% 35%,
                            0.6% 30%, 0.9% 25%, 0.5% 20%, 0.8% 15%, 0.6% 10%, 0.9% 5%
                        );
                        
                        /* Ombre profonde vintage */
                        box-shadow: 
                            0 3px 6px rgba(139, 99, 61, 0.15),
                            0 6px 12px rgba(139, 99, 61, 0.12),
                            0 10px 25px rgba(139, 99, 61, 0.10),
                            0 20px 40px rgba(139, 99, 61, 0.08),
                            inset 3px 0 4px -2px rgba(139, 99, 61, 0.12),
                            inset -3px 0 4px -2px rgba(139, 99, 61, 0.12),
                            inset 0 3px 4px -2px rgba(255, 248, 230, 0.6),
                            inset 0 -3px 5px -2px rgba(139, 99, 61, 0.15);
                    }
                    
                    /* Angolo piegato SINISTRA-ALTO */
                    .vintage-corner-left {
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 0;
                        height: 0;
                        border-style: solid;
                        border-width: 55px 55px 0 0;
                        border-color: #e8d4b8 transparent transparent transparent;
                        z-index: 1;
                        filter: drop-shadow(2px 2px 4px rgba(139, 99, 61, 0.2));
                        pointer-events: none;
                    }
                    
                    /* Texture vintage */
                    .vintage-texture {
                        position: absolute;
                        inset: 0;
                        opacity: 0.2;
                        z-index: 1;
                        background-image: 
                            repeating-linear-gradient(
                                0deg,
                                transparent,
                                transparent 2px,
                                rgba(139, 99, 61, 0.01) 2px,
                                rgba(139, 99, 61, 0.01) 4px
                            ),
                            repeating-linear-gradient(
                                90deg,
                                transparent,
                                transparent 2px,
                                rgba(139, 99, 61, 0.01) 2px,
                                rgba(139, 99, 61, 0.01) 4px
                            );
                        background-size: 100% 100%, 100% 100%;
                        pointer-events: none;
                    }
                    
                    /* Macchie vintage */
                    .vintage-stains {
                        position: absolute;
                        inset: 0;
                        z-index: 1;
                        pointer-events: none;
                        opacity: 0.3;
                        background-image:
                            radial-gradient(
                                ellipse 180px 140px at 95% 8%,
                                rgba(139, 99, 61, 0.06) 0%,
                                rgba(139, 99, 61, 0.03) 30%,
                                transparent 60%
                            ),
                            radial-gradient(
                                ellipse 120px 160px at 12% 85%,
                                rgba(139, 99, 61, 0.04) 0%,
                                rgba(139, 99, 61, 0.02) 40%,
                                transparent 70%
                            ),
                            radial-gradient(
                                circle 40px at 75% 45%,
                                rgba(139, 99, 61, 0.03) 0%,
                                transparent 50%
                            );
                    }
                    
                    /* Assicura che il contenuto sia sempre sopra */
                    .poem-content {
                        position: relative !important;
                        z-index: 30 !important;
                    }
                    
                    .poem-content * {
                        position: relative;
                        z-index: 100 !important;
                        color: inherit !important;
                    }
                    
                    /* Dark mode - testo più chiaro */
                    @media (prefers-color-scheme: dark) {
                        .poem-content {
                            color: #f3f4f6 !important;
                            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);
                        }
                    }
                    
                    /* Mobile - testo ancora più visibile */
                    @media (max-width: 768px) {
                        .poem-content {
                            color: #111827 !important;
                            text-shadow: 0 1px 3px rgba(255, 255, 255, 0.9);
                            font-weight: 500;
                        }
                        
                        @media (prefers-color-scheme: dark) {
                            .poem-content {
                                color: #f9fafb !important;
                                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.8);
                            }
                        }
                    }
                    
                    @media (prefers-color-scheme: dark) {
                        .vintage-paper-sheet {
                            background: linear-gradient(135deg, 
                                #3a352f 0%, 
                                #453f38 20%, 
                                #3a352f 40%,
                                #453f38 60%,
                                #3a352f 80%,
                                #453f38 100%
                            );
                        }
                        .vintage-corner-left {
                            border-color: #2f2a24 transparent transparent transparent;
                        }
                    }
                    
                    /* Mobile - sfondo più chiaro per migliore leggibilità */
                    @media (max-width: 768px) {
                        .vintage-paper-sheet {
                            background: linear-gradient(135deg, 
                                #f9f7f4 0%, 
                                #fdfbf8 20%, 
                                #f9f7f4 40%,
                                #fdfbf8 60%,
                                #f9f7f4 80%,
                                #fdfbf8 100%
                            ) !important;
                        }
                        
                        @media (prefers-color-scheme: dark) {
                            .vintage-paper-sheet {
                                background: linear-gradient(135deg, 
                                    #4a453f 0%, 
                                    #554f48 20%, 
                                    #4a453f 40%,
                                    #554f48 60%,
                                    #4a453f 80%,
                                    #554f48 100%
                                ) !important;
                            }
                        }
                    }
                </style>
                
                <!-- Tags - Elegant Pills -->
                @if($poem->tags && count($poem->tags) > 0)
                    <div class="mb-10 pb-10 border-b-2 border-dashed border-neutral-200 dark:border-neutral-700">
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">Esplora:</span>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            @foreach($poem->tags as $tag)
                                <a href="{{ route('poems.index', ['search' => $tag]) }}" 
                                   class="group px-4 py-2 rounded-xl text-sm font-medium
                                          bg-gradient-to-r from-primary-50 to-primary-100/50
                                          dark:from-primary-900/30 dark:to-primary-900/20
                                          text-primary-700 dark:text-primary-300
                                          border border-primary-200 dark:border-primary-800
                                          hover:scale-110 hover:shadow-lg
                                          transition-all duration-300">
                                    <span class="font-poem">#{{ $tag }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <!-- Social Actions Bar - Modern Design -->
                <div class="flex items-center justify-between flex-wrap gap-6 
                            p-6 rounded-2xl bg-gradient-to-r from-neutral-50 to-primary-50/30 
                            dark:from-neutral-900/50 dark:to-primary-900/10
                            border border-neutral-200 dark:border-neutral-700">
                    <div class="flex items-center gap-4" @click.stop>
                        <!-- Like with enhanced styling -->
                        <div class="flex items-center gap-2 px-6 py-3 rounded-xl 
                                    bg-white dark:bg-neutral-800 shadow-lg
                                    hover:shadow-xl transition-all duration-300">
                            <x-like-button 
                                :itemId="$poem->id"
                                itemType="poem"
                                :isLiked="$isLiked"
                                :likesCount="$likeCount"
                                size="md" />
                        </div>
                        
                        <!-- Comment -->
                        <div class="flex items-center gap-2 px-6 py-3 rounded-xl 
                                    bg-white dark:bg-neutral-800 shadow-lg
                                    hover:shadow-xl transition-all duration-300">
                            <x-comment-button 
                                :itemId="$poem->id"
                                itemType="poem"
                                :commentsCount="$poem->comment_count ?? 0"
                                size="md" />
                        </div>
                        
                        <!-- Share -->
                        <div class="flex items-center gap-2 px-6 py-3 rounded-xl 
                                    bg-white dark:bg-neutral-800 shadow-lg
                                    hover:shadow-xl transition-all duration-300">
                            <x-share-button 
                                :itemId="$poem->id"
                                itemType="poem"
                                :url="route('poems.show', $poem->slug)"
                                :title="$poem->title"
                                size="md" />
                        </div>
                        
                        <!-- Add to Carousel -->
                        @auth
                            @if(auth()->user()->hasRole(['admin', 'editor']))
                                <div class="flex items-center gap-2 px-6 py-3 rounded-xl 
                                            bg-white dark:bg-neutral-800 shadow-lg
                                            hover:shadow-xl transition-all duration-300">
                                    <x-add-to-carousel-button 
                                        :contentId="$poem->id"
                                        contentType="poem"
                                        size="md" />
                                </div>
                            @endif
                        @endauth
                        
                        <!-- Report -->
                        <div class="flex items-center gap-2 px-6 py-3 rounded-xl 
                                    bg-white dark:bg-neutral-800 shadow-lg
                                    hover:shadow-xl transition-all duration-300">
                            <x-report-button 
                                :itemId="$poem->id"
                                itemType="poem"
                                size="md" />
                        </div>
                    </div>
                    
                    <!-- Edit Button (owner only) -->
                    @if(Auth::check() && $poem->canBeEditedBy(Auth::user()))
                        <a href="{{ route('poems.edit', $poem->slug) }}"
                           class="inline-flex items-center gap-2 px-6 py-3 rounded-xl
                                  bg-gradient-to-r from-primary-500 to-primary-600 
                                  hover:from-primary-600 hover:to-primary-700
                                  text-white font-semibold shadow-lg
                                  hover:shadow-xl hover:scale-105
                                  transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            <span class="font-poem">{{ __('poems.show.edit_poem') }}</span>
                        </a>
                        
                        <!-- Translation Request Button (owner only) -->
                        <livewire:translations.translation-request :poem="$poem" :key="'translation-request-'.$poem->id" />
                    @endif
                </div>
            </div>
        </article>
        
        <!-- Related Poems - Poetic Section -->
        @if($relatedPoems->count() > 0)
            <div class="animate-fade-in-delay-1">
                <div class="text-center mb-10">
                    <h2 class="text-3xl md:text-4xl font-bold text-neutral-900 dark:text-white font-poem inline-block relative">
                        {{ __('poems.show.related_poems') }}
                        <div class="absolute -bottom-2 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-primary-500 to-transparent rounded-full"></div>
                    </h2>
                    <p class="text-neutral-600 dark:text-neutral-400 mt-3 font-poem italic">
                        {{ __('poems.show.discover_more') }}
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedPoems as $index => $relatedPoem)
                        <div style="animation-delay: {{ $index * 0.15 }}s" class="opacity-0 animate-fade-in h-full">
                            <livewire:poems.poem-card 
                                :poem="$relatedPoem"
                                :showActions="true"
                                :key="'related-'.$relatedPoem->id"
                                wire:key="related-{{ $relatedPoem->id }}" />
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
