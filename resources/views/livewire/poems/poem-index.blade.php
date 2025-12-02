<div class="min-h-screen">
    
    {{-- HERO con Paper Sheet + Titolo (come media page) --}}
    <section class="relative pt-16 pb-12 md:pb-20 overflow-hidden wooden-desk-section">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center gap-6 md:flex-row md:justify-center md:gap-12">
                
                <!-- PAPER SHEET (dalla home) - Dimensione maggiorata -->
                <div class="hero-paper-wrapper">
                    <div class="hero-paper-sheet">
                        <div class="flex items-center justify-center h-full">
                            <h3 class="hero-paper-title">
                                "{{ __('home.hero_category_poems') }}"
                            </h3>
                        </div>
                    </div>
                </div>
                
                <!-- TITOLO A FIANCO -->
                <div class="text-center md:text-left">
                    <h1 class="text-5xl md:text-7xl lg:text-8xl font-black text-white leading-tight" style="font-family: 'Crimson Pro', serif;">
                        {!! __('poems.index.hero_title', ['highlight' => '<span class="italic text-accent-400">'.__('poems.index.hero_title_highlight').'</span>']) !!}
                    </h1>
                    <p class="text-xl md:text-2xl text-white/80 mt-4 font-medium">
                        {{ __('poems.index.hero_subtitle') }}
                    </p>
                    
                    @auth
                        @can('create.poem')
                        <div class="mt-6">
                            <a href="{{ route('poems.create') }}" 
                               class="group inline-flex items-center gap-3 px-6 py-3 rounded-xl
                                      bg-gradient-to-r from-accent-500 to-accent-600 
                                      hover:from-accent-600 hover:to-accent-700
                                      text-white font-bold shadow-xl shadow-accent-500/30
                                      hover:shadow-2xl hover:shadow-accent-500/40 hover:-translate-y-1
                                      transition-all duration-300">
                                <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M12 4v16m8-8H4"/>
                                </svg>
                                <span>{{ __('poems.create.write_poem') }}</span>
                            </a>
                        </div>
                        @endcan
                    @endauth
                </div>
            </div>
        </div>
    </section>
    
    {{-- POEMS CONTENT SECTION --}}
    <div class="poems-poetic-background">
        
        <!-- Pattern calligrafico decorativo -->
        <div class="fixed inset-0 pointer-events-none overflow-hidden opacity-30" style="z-index: 1;" aria-hidden="true">
            <svg class="absolute top-1/4 right-1/4 w-96 h-96 text-accent-200/30 dark:text-accent-900/20" viewBox="0 0 200 200" fill="none">
                <path d="M50 100 Q75 50 100 100 T150 100" stroke="currentColor" stroke-width="0.5" opacity="0.3"/>
                <path d="M40 80 Q90 40 140 80" stroke="currentColor" stroke-width="0.3" opacity="0.2"/>
                <circle cx="100" cy="50" r="30" stroke="currentColor" stroke-width="0.3" opacity="0.15"/>
            </svg>
            <svg class="absolute bottom-1/4 left-1/4 w-96 h-96 text-accent-200/30 dark:text-accent-900/20" viewBox="0 0 200 200" fill="none">
                <path d="M100 50 Q50 75 100 100 T100 150" stroke="currentColor" stroke-width="0.5" opacity="0.3"/>
                <path d="M80 40 Q40 90 80 140" stroke="currentColor" stroke-width="0.3" opacity="0.2"/>
                <circle cx="50" cy="100" r="35" stroke="currentColor" stroke-width="0.3" opacity="0.15"/>
            </svg>
        </div>
        
        <!-- Ink bleed effect on scroll -->
        <div class="ink-reveal-container"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" style="z-index: 10;">
        
        <!-- Poetic Search - Minimal & Elegant -->
        <div class="mb-16 animate-fade-in-delay-1">
           
           
            
            <div class="max-w-xl mx-auto">
                <!-- Poetic Search Input -->
                <div class="relative group">
                    <input wire:model.live.debounce.500ms="search"
                           type="text"
                           placeholder="{{ __('poems.index.search_placeholder') }}"
                           class="w-full px-6 py-4 rounded-full 
                                  border-2 border-neutral-300/50 dark:border-neutral-700/50 
                                  bg-white/60 dark:bg-neutral-800/60
                                  backdrop-blur-sm
                                  text-neutral-900 dark:text-white placeholder:text-neutral-500
                                  focus:border-accent-400 focus:ring-4 focus:ring-accent-400/20 focus:bg-white dark:focus:bg-neutral-800
                                  transition-all duration-300 
                                  text-center italic"
                           style="font-family: 'Crimson Pro', serif; font-size: 1.125rem;">
                    
                    @if($search)
                        <button wire:click="$set('search', '')" 
                                class="absolute right-6 top-1/2 -translate-y-1/2
                                       text-neutral-400 hover:text-accent-600
                                       hover:scale-110 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    @endif
                </div>
                
                <!-- Minimal Filters - Hidden by default, expandable -->
                <details class="mt-6">
                    <summary class="text-center text-sm text-neutral-500 hover:text-accent-600 cursor-pointer transition-colors font-poem">
                        {{ __('poems.index.filters_summary') }}
                    </summary>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-3">
                        <!-- Category -->
                        <div class="relative">
                            <select wire:model.live="category"
                                    class="w-full appearance-none px-4 py-3 rounded-xl 
                                           bg-white/60 dark:bg-neutral-800/60
                                           border border-neutral-300/50 dark:border-neutral-700/50
                                           text-neutral-900 dark:text-white text-sm
                                           focus:border-accent-400 focus:ring-2 focus:ring-accent-400/20
                                           transition-all cursor-pointer font-poem">
                                <option value="">{{ __('poems.filters.all_categories_plain') }}</option>
                                @foreach($categories as $key => $name)
                                    <option value="{{ $key }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Language -->
                        <div class="relative">
                            <select wire:model.live="language"
                                    class="w-full appearance-none px-4 py-3 rounded-xl 
                                           bg-white/60 dark:bg-neutral-800/60
                                           border border-neutral-300/50 dark:border-neutral-700/50
                                           text-neutral-900 dark:text-white text-sm
                                           focus:border-accent-400 focus:ring-2 focus:ring-accent-400/20
                                           transition-all cursor-pointer font-poem">
                                <option value="">{{ __('poems.filters.all_languages_plain') }}</option>
                                @foreach($languages as $code => $name)
                                    <option value="{{ $code }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Sort -->
                        <div class="relative">
                            <select wire:model.live="sort"
                                    class="w-full appearance-none px-4 py-3 rounded-xl 
                                           bg-white/60 dark:bg-neutral-800/60
                                           border border-neutral-300/50 dark:border-neutral-700/50
                                           text-neutral-900 dark:text-white text-sm
                                           focus:border-accent-400 focus:ring-2 focus:ring-accent-400/20
                                           transition-all cursor-pointer font-poem">
                                <option value="recent">{{ __('poems.filters.recent') }}</option>
                                <option value="popular">{{ __('poems.filters.popular') }}</option>
                                <option value="oldest">{{ __('poems.filters.oldest') }}</option>
                                <option value="alphabetical">{{ __('poems.filters.alphabetical') }}</option>
                            </select>
                        </div>
                    </div>
                </details>
            </div>
        </div>
        
        <!-- Poems Grid - Poetic Style -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($poems && $poems->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                    @foreach($poems as $index => $poem)
                    <?php $paperRotation = rand(-2, 2); ?>
                    <div class="poetry-card-wrapper"
                         x-data="{ visible: false }" 
                         x-intersect.once="visible = true">
                        <div x-show="visible"
                             x-transition:enter="transition ease-out duration-700"
                             x-transition:enter-start="opacity-0 translate-y-8"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             style="transition-delay: {{ ($index % 9) * 100 }}ms">
                            
                            {{-- COPIATO ESATTAMENTE DALLA HOMEPAGE --}}
                            <div class="paper-sheet-wrapper" style="transform: rotate({{ $paperRotation }}deg);">
                                <div class="paper-sheet group">
                                    
                                    {{-- Content cliccabile --}}
                                    <div class="block cursor-pointer hover:opacity-90 transition-opacity" 
                                         onclick="Livewire.dispatch('openPoemModal', { poemId: {{ $poem->id }} })">
                                        
                                        {{-- Date in alto a destra --}}
                                        <div class="absolute top-3 right-3 text-xs text-neutral-500 dark:text-neutral-400 bg-white/80 dark:bg-neutral-800/80 backdrop-blur-sm px-2 py-1 rounded-full z-10">
                                            {{ $poem->created_at->diffForHumans() }}
                                        </div>
                                        
                                        <div class="paper-author-info">
                                            <img src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($poem->user, 80) }}" 
                                                 alt="{{ $poem->user->name }}"
                                                 class="paper-avatar">
                                            <a href="{{ \App\Helpers\AvatarHelper::getUserProfileUrl($poem->user) }}" 
                                               class="paper-author-name hover:underline transition-colors"
                                               onclick="event.stopPropagation();">
                                                {{ \App\Helpers\AvatarHelper::getDisplayName($poem->user) }}
                                            </a>
                                        </div>
                                        
                                        {{-- Poem Title --}}
                                        <h3 class="paper-title">
                                            "{{ $poem->title ?: __('poems.untitled') }}"
                                        </h3>
                                        
                                        {{-- Poem Content --}}
                                        <div class="paper-content">
                                            {{ \App\Helpers\PlaceholderHelper::cleanHtmlContent($poem->description ?? $poem->content, 180) }}
                                        </div>
                                        
                                        {{-- Read more hint --}}
                                        <div class="paper-readmore">
                                            {{ __('common.read_more') }} →
                                        </div>
                                    </div>
                                    
                                    {{-- Social Actions - ESATTAMENTE COME HOMEPAGE --}}
                                    <div class="paper-actions-integrated" @click.stop>
                                        <x-like-button 
                                            :itemId="$poem->id"
                                            itemType="poem"
                                            :isLiked="false"
                                            :likesCount="$poem->like_count ?? 0"
                                            size="sm" />
                                        
                                        <x-comment-button 
                                            :itemId="$poem->id"
                                            itemType="poem"
                                            :commentsCount="$poem->comment_count ?? 0"
                                            size="sm" />
                                        
                                        <x-share-button 
                                            :itemId="$poem->id"
                                            itemType="poem"
                                            size="sm" />
                                        
                                        <x-report-button 
                                            :itemId="$poem->id"
                                            itemType="poem"
                                            size="sm" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                
                <!-- Pagination -->
                <div class="flex justify-center mt-12">
                    {{ $poems->links('components.pagination.poetic') }}
                </div>
            @else
                <!-- Empty State - Poetic -->
                <div class="text-center py-20">
                    <div class="inline-flex items-center justify-center w-32 h-32 rounded-full 
                               bg-gradient-to-br from-accent-100 to-accent-50 
                               dark:from-accent-900/20 dark:to-accent-900/10
                               mb-8">
                        <svg class="w-16 h-16 text-accent-500" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    
                    <h3 class="text-3xl font-bold text-neutral-900 dark:text-white mb-4" style="font-family: 'Crimson Pro', serif;">
                        {{ __('poems.index.no_poems_title') }}
                    </h3>
                    
                    <p class="text-lg text-neutral-600 dark:text-neutral-400 mb-8 italic font-poem">
                        {{ __('poems.index.empty_quote') }}
                    </p>
                    
                    @if($search || $category || $language)
                        <button wire:click="resetFilters"
                                class="inline-flex items-center gap-3 px-8 py-4 rounded-2xl
                                       bg-gradient-to-r from-accent-500 to-accent-600 
                                       hover:from-accent-600 hover:to-accent-700
                                       text-white font-semibold shadow-lg
                                       hover:-translate-y-1 transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            <span>{{ __('poems.index.reset_filters_button') }}</span>
                        </button>
                    @endif
                </div>
            @endif
        </div>
        </div>
    </div>
    
    {{-- Poem Modal with Book Opening Effect --}}
    <livewire:poems.poem-modal />
    
    <style>
        /* ========================================
           POETIC BACKGROUND & ANIMATIONS
           ======================================== */
        
        .poems-poetic-background {
            position: relative;
            background: 
                /* Texture carta antica */
                url("data:image/svg+xml,%3Csvg width='200' height='200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='paper'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.05' numOctaves='4' seed='3' /%3E%3CfeColorMatrix type='saturate' values='0'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23paper)' opacity='0.04'/%3E%3C/svg%3E"),
                /* Gradient animato poetico - Aurora letteraria */
                radial-gradient(ellipse 80% 50% at 50% 0%, 
                    rgba(251, 207, 232, 0.15) 0%,
                    transparent 50%
                ),
                radial-gradient(ellipse 80% 50% at 50% 100%, 
                    rgba(254, 215, 170, 0.12) 0%,
                    transparent 50%
                ),
                linear-gradient(135deg, 
                    #faf8f5 0%,
                    #fff9f3 20%,
                    #fef5ed 40%,
                    #fdf3eb 60%,
                    #fcf1e9 80%,
                    #fbefe7 100%
                );
            min-height: 100vh;
            animation: poetry-aurora 15s ease-in-out infinite;
        }
        
        @keyframes poetry-aurora {
            0%, 100% {
                background-position: 0% 0%, 0% 100%, 0% 0%;
            }
            50% {
                background-position: 100% 0%, 100% 100%, 100% 100%;
            }
        }
        
        :is(.dark .poems-poetic-background) {
            background: 
                url("data:image/svg+xml,%3Csvg width='200' height='200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='paper'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.05' numOctaves='4' seed='3' /%3E%3CfeColorMatrix type='saturate' values='0'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23paper)' opacity='0.06'/%3E%3C/svg%3E"),
                radial-gradient(ellipse 80% 50% at 50% 0%, 
                    rgba(139, 92, 46, 0.08) 0%,
                    transparent 50%
                ),
                radial-gradient(ellipse 80% 50% at 50% 100%, 
                    rgba(212, 165, 116, 0.06) 0%,
                    transparent 50%
                ),
                linear-gradient(135deg, 
                    #1a1816 0%,
                    #1e1c19 25%,
                    #1c1a17 50%,
                    #1f1d1a 75%,
                    #1b1916 100%
                );
            animation: poetry-aurora 15s ease-in-out infinite;
        }
        
        
        /* ========================================
           POETRY PAGE HERO - Paper Sheet (ESATTO dalla home, ingrandito)
           ======================================== */
        
        .hero-paper-wrapper {
            display: block;
            width: 200px;
            transition: all 0.3s ease;
        }
        
        .hero-paper-wrapper:hover {
            transform: translateY(-6px) scale(1.05);
        }
        
        .hero-paper-sheet {
            background: 
                linear-gradient(135deg, 
                    rgba(255,253,245,0) 0%, 
                    rgba(250,240,220,0.4) 25%, 
                    rgba(245,235,215,0.3) 50%, 
                    rgba(240,230,210,0.4) 75%, 
                    rgba(255,250,240,0) 100%),
                radial-gradient(circle at 20% 30%, rgba(210,180,140,0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(205,175,135,0.12) 0%, transparent 50%),
                #faf6ed;
            padding: 2rem 1.5rem;
            height: 260px;
            border-radius: 3px;
            box-shadow: 
                inset 0 0 0 2px rgba(180, 120, 70, 0.7),
                inset 0 0 12px 4px rgba(160, 100, 60, 0.4),
                inset 0 0 20px 7px rgba(140, 90, 50, 0.25),
                0 6px 10px rgba(0, 0, 0, 0.2),
                0 12px 20px rgba(0, 0, 0, 0.15),
                0 18px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .hero-paper-wrapper:hover .hero-paper-sheet {
            box-shadow: 
                inset 0 0 0 3px rgba(180, 120, 70, 0.85),
                inset 0 0 18px 7px rgba(160, 100, 60, 0.55),
                inset 0 0 28px 11px rgba(140, 90, 50, 0.35),
                0 10px 16px rgba(0, 0, 0, 0.3),
                0 20px 30px rgba(0, 0, 0, 0.25),
                0 30px 45px rgba(0, 0, 0, 0.2);
        }
        
        .hero-paper-title {
            font-family: 'Crimson Pro', serif;
            font-size: 1.75rem;
            font-weight: 600;
            color: #2d2520;
            line-height: 1.4;
            text-align: center;
            transition: color 0.3s ease;
        }
        
        .hero-paper-wrapper:hover .hero-paper-title {
            color: #4a7c59;
        }
        
        @media (max-width: 768px) {
            .hero-paper-wrapper {
                width: 180px;
            }
            
            .hero-paper-sheet {
                padding: 1.75rem 1.25rem;
                height: 240px;
            }
            
            .hero-paper-title {
                font-size: 1.5rem;
            }
        }
        
        
        /* ========================================
           POETRY CARDS - Grid Items
           ======================================== */
        
        .poetry-card-wrapper {
            position: relative;
        }
        
        .poetry-paper-card {
            position: relative;
            background: 
                /* Gradient di luce poetica */
                radial-gradient(circle at top left, 
                    rgba(255, 255, 255, 0.6) 0%,
                    transparent 40%
                ),
                radial-gradient(circle at bottom right, 
                    rgba(254, 243, 199, 0.4) 0%,
                    transparent 40%
                ),
                linear-gradient(135deg, 
                    rgba(255,253,245,0) 0%, 
                    rgba(250,240,220,0.3) 25%, 
                    rgba(245,235,215,0.2) 50%, 
                    rgba(240,230,210,0.3) 75%, 
                    rgba(255,250,240,0) 100%),
                #fffef9;
            padding: 2rem;
            border-radius: 6px;
            box-shadow: 
                inset 0 0 0 1.5px rgba(180, 120, 70, 0.5),
                inset 0 0 8px 3px rgba(160, 100, 60, 0.3),
                inset 0 0 16px 6px rgba(140, 90, 50, 0.2),
                0 4px 8px rgba(0, 0, 0, 0.1),
                0 8px 16px rgba(0, 0, 0, 0.08),
                0 12px 24px rgba(0, 0, 0, 0.06);
            transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
            border: 1px solid rgba(205, 180, 140, 0.25);
            min-height: 320px;
            display: flex;
            flex-direction: column;
            transform-style: preserve-3d;
            perspective: 1000px;
        }
        
        .poetry-card-wrapper:hover .poetry-paper-card {
            transform: translateY(-12px) scale(1.04) rotateX(2deg) !important;
            box-shadow: 
                inset 0 0 0 2.5px rgba(180, 120, 70, 0.9),
                inset 0 0 16px 6px rgba(251, 191, 36, 0.3),
                inset 0 0 24px 10px rgba(254, 215, 170, 0.2),
                0 16px 32px rgba(0, 0, 0, 0.2),
                0 32px 64px rgba(0, 0, 0, 0.18),
                0 48px 96px rgba(0, 0, 0, 0.15),
                /* Glow letterario dorato */
                0 0 60px rgba(251, 191, 36, 0.3),
                0 0 100px rgba(254, 215, 170, 0.2);
        }
        
        .poetry-card-author {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
            font-size: 0.875rem;
            color: rgba(45, 37, 32, 0.8);
            font-family: 'Crimson Pro', serif;
        }
        
        .poetry-card-title {
            font-family: 'Crimson Pro', serif;
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1.3;
            color: #2d2520;
            margin-bottom: 1rem;
            font-style: italic;
            transition: all 0.5s ease;
            position: relative;
            background: linear-gradient(
                90deg,
                #2d2520 0%,
                #2d2520 50%,
                #4a7c59 50%,
                #4a7c59 100%
            );
            background-size: 200% 100%;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .poetry-card-wrapper:hover .poetry-card-title {
            background-position: -100% 0;
            text-shadow: 0 0 20px rgba(74, 124, 89, 0.3);
        }
        
        .poetry-card-excerpt {
            flex: 1;
            font-family: 'Crimson Pro', serif;
            font-size: 0.9375rem;
            line-height: 1.8;
            color: #4a4a4a;
            font-style: italic;
            margin-bottom: 1.5rem;
            transition: all 0.4s ease;
            position: relative;
        }
        
        .poetry-card-wrapper:hover .poetry-card-excerpt {
            color: #2d2520;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }
        
        /* Decorative flourish che appare al hover */
        .poetry-paper-card::before {
            content: '';
            position: absolute;
            top: 1.5rem;
            left: 1.5rem;
            right: 1.5rem;
            bottom: 1.5rem;
            border: 2px solid transparent;
            border-radius: 4px;
            transition: all 0.6s ease;
            opacity: 0;
        }
        
        .poetry-card-wrapper:hover .poetry-paper-card::before {
            border-color: rgba(251, 191, 36, 0.3);
            opacity: 1;
            box-shadow: 
                inset 0 0 20px rgba(251, 191, 36, 0.1),
                0 0 30px rgba(251, 191, 36, 0.15);
        }
        
        .poetry-card-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid rgba(180, 120, 70, 0.2);
            color: rgba(45, 37, 32, 0.6);
            margin-top: auto;
        }
        
        .poetry-card-cover {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            margin: 0.5rem 0 1rem;
            box-shadow:
                0 6px 14px rgba(0, 0, 0, 0.12),
                inset 0 0 0 1px rgba(180, 120, 70, 0.1);
            transform: translateZ(0);
            height: 110px;
        }
        
        .poetry-card-cover-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }
        
        .poetry-card-cover--placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                linear-gradient(135deg, rgba(255, 255, 255, 0.8) 0%, rgba(249, 245, 235, 0.9) 50%, rgba(244, 236, 220, 0.95) 100%),
                url("data:image/svg+xml,%3Csvg width='200' height='200' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 200c0-110 90-200 200-200' fill='none' stroke='rgba(183, 140, 88, 0.15)' stroke-width='6'/%3E%3C/svg%3E");
            background-size: cover;
        }

        .poetry-card-cover-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            color: rgba(70, 55, 40, 0.5);
            font-style: italic;
            letter-spacing: 0.02em;
        }

        .poetry-card-cover-shadow {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(0,0,0,0) 40%, rgba(0,0,0,0.15) 100%);
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.6s ease;
        }
        
        .poetry-card-wrapper:hover .poetry-card-cover-image {
            transform: scale(1.05);
        }
        
        .poetry-card-wrapper:hover .poetry-card-cover-shadow {
            opacity: 1;
        }
        
        @media (max-width: 768px) {
            .poetry-paper-card {
                padding: 1.5rem;
                min-height: 280px;
            }
            
            .poetry-card-title {
                font-size: 1.25rem;
            }
            
            .poetry-card-excerpt {
                font-size: 0.875rem;
            }
            
            .poetry-card-cover {
                height: 95px;
            }
        }
    </style>
</div>
