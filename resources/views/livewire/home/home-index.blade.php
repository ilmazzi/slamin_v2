<div>
    {{-- Hero Welcome Section --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-neutral-900 via-neutral-800 to-neutral-900 dark:from-black dark:via-neutral-900 dark:to-black">
        <!-- Animated Background Pattern -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: 
                repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(255,255,255,.03) 35px, rgba(255,255,255,.03) 70px),
                repeating-linear-gradient(-45deg, transparent, transparent 35px, rgba(255,255,255,.03) 35px, rgba(255,255,255,.03) 70px);
            "></div>
        </div>
        
        <!-- Animated Green Glow -->
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-primary-500/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 left-1/4 w-96 h-96 bg-primary-600/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
            <div class="text-center space-y-8">
                
                {{-- Welcome Text with Typewriter Effect --}}
                <div class="space-y-4">
                    <h1 class="text-5xl md:text-7xl font-bold text-white" style="font-family: 'Crimson Pro', serif;">
                        {{ __('home.hero_welcome') }} <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-400 to-primary-600">Slamin</span>
                    </h1>
                    <p class="text-xl md:text-2xl text-neutral-300 max-w-3xl mx-auto">
                        {{ __('home.hero_subtitle') }}
                    </p>
                </div>
                
                {{-- CTA Buttons --}}
                <div class="flex flex-wrap items-center justify-center gap-4">
                    @guest
                    <a href="{{ route('register') }}" 
                       class="px-8 py-4 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-xl shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-300">
                        {{ __('home.hero_cta_join') }}
                    </a>
                    <a href="#explore" 
                       class="px-8 py-4 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white font-semibold rounded-xl border-2 border-white/20 hover:border-white/40 transition-all duration-300">
                        {{ __('home.hero_cta_explore') }}
                    </a>
                    @else
                    <a href="{{ route('dashboard.index') }}" 
                       class="px-8 py-4 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-xl shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-300">
                        {{ __('home.hero_cta_dashboard') }}
                    </a>
                    <a href="#explore" 
                       class="px-8 py-4 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white font-semibold rounded-xl border-2 border-white/20 hover:border-white/40 transition-all duration-300">
                        {{ __('home.hero_cta_discover') }}
                    </a>
                    @endguest
                </div>
                
                {{-- Categories Grid with Themed Cards --}}
                <div class="pt-8 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 max-w-6xl mx-auto">
                    
                    {{-- Poetry - Paper Sheet Mini --}}
                    <a href="{{ route('poems.index') }}" 
                       class="group relative transform hover:scale-105 transition-all duration-300"
                       style="transform: rotate(<?php echo rand(-2, 2); ?>deg);">
                        <div class="paper-sheet-mini">
                            <div class="text-center space-y-2">
                                <svg class="w-8 h-8 mx-auto text-neutral-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                <span class="text-sm font-semibold text-neutral-800">{{ __('home.hero_category_poems') }}</span>
                            </div>
                        </div>
                    </a>
                    
                    {{-- Articles - Magazine Mini --}}
                    <a href="{{ route('articles.index') }}" 
                       class="group relative transform hover:scale-105 transition-all duration-300"
                       style="transform: rotate(<?php echo rand(-3, 3); ?>deg);">
                        {{-- Thumbtack --}}
                        <div class="thumbtack-mini" style="background: <?php echo ['#e53e3e', '#3182ce', '#38a169'][rand(0, 2)]; ?>; transform: rotate(<?php echo rand(-15, 15); ?>deg);"></div>
                        <div class="magazine-cover-mini">
                            <div class="text-center space-y-2 p-4">
                                <svg class="w-8 h-8 mx-auto text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                </svg>
                                <span class="text-xs font-bold text-neutral-900">{{ __('home.hero_category_articles') }}</span>
                            </div>
                        </div>
                    </a>
                    
                    {{-- Gigs - Notice Board Mini --}}
                    <a href="{{ route('gigs.index') }}" 
                       class="group relative transform hover:scale-105 transition-all duration-300">
                        {{-- Top Washi Tape --}}
                        <div class="washi-tape-mini-top" style="<?php 
                            $colors = [
                                ['rgba(255, 107, 107, 0.85)', 'rgba(255, 140, 140, 0.83)'],
                                ['rgba(78, 205, 196, 0.85)', 'rgba(110, 220, 210, 0.83)'],
                                ['rgba(255, 195, 0, 0.85)', 'rgba(255, 210, 50, 0.83)'],
                            ];
                            $selectedTape = $colors[array_rand($colors)];
                            echo 'background: linear-gradient(135deg, ' . $selectedTape[0] . ' 0%, ' . $selectedTape[1] . ' 100%);';
                            echo 'transform: rotate(' . rand(-4, 4) . 'deg);';
                        ?>"></div>
                        <div class="notice-board-card-mini">
                            <div class="text-center space-y-2 p-4">
                                <svg class="w-8 h-8 mx-auto text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-xs font-bold text-neutral-900">{{ __('home.hero_category_gigs') }}</span>
                            </div>
                        </div>
                    </a>
                    
                    {{-- Events - Cinema Ticket Mini --}}
                    <a href="{{ route('events.index') }}" 
                       class="group relative transform hover:scale-105 transition-all duration-300"
                       style="transform: rotate(<?php echo rand(-3, 3); ?>deg);">
                        <div class="cinema-ticket-mini">
                            <div class="text-center space-y-2 p-4">
                                <svg class="w-8 h-8 mx-auto text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-xs font-bold text-amber-900">{{ __('home.hero_category_events') }}</span>
                            </div>
                        </div>
                    </a>
                    
                    {{-- Videos - Film Strip Mini --}}
                    <div class="group relative transform hover:scale-105 transition-all duration-300 cursor-pointer"
                         onclick="document.querySelector('.film-studio-section').scrollIntoView({ behavior: 'smooth' })">
                        <div class="film-strip-mini">
                            <div class="text-center space-y-2 p-4">
                                <svg class="w-8 h-8 mx-auto text-amber-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-xs font-bold text-amber-900">{{ __('home.hero_category_videos') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Community - Polaroid Mini --}}
                    <a href="{{ route('dashboard.index') }}" 
                       class="group relative transform hover:scale-105 transition-all duration-300"
                       style="transform: rotate(<?php echo rand(-3, 3); ?>deg);">
                        {{-- Washi Tape --}}
                        <div class="washi-tape-mini-polaroid" style="<?php 
                            $colors = [
                                ['rgba(255, 107, 107, 0.85)', 'rgba(255, 140, 140, 0.83)'],
                                ['rgba(78, 205, 196, 0.85)', 'rgba(110, 220, 210, 0.83)'],
                            ];
                            $selectedTape = $colors[array_rand($colors)];
                            echo 'background: linear-gradient(135deg, ' . $selectedTape[0] . ' 0%, ' . $selectedTape[1] . ' 100%);';
                            echo 'transform: rotate(' . rand(-8, 8) . 'deg);';
                        ?>"></div>
                        <div class="polaroid-mini">
                            <div class="text-center space-y-2 p-4">
                                <svg class="w-8 h-8 mx-auto text-neutral-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <span class="text-xs font-bold text-neutral-800">{{ __('home.hero_category_community') }}</span>
                            </div>
                        </div>
                    </a>
                </div>
                
            </div>
        </div>
        
        {{-- Scroll Indicator --}}
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
    </section>

    {{-- Video/Foto Community - FILM STUDIO SECTION --}}
    <div class="py-20 md:py-24 film-studio-section">
        <livewire:home.videos-section />
    </div>

    {{-- Decorative Separator --}}
    <div class="py-12 md:py-16 bg-white dark:bg-neutral-900">
        <div class="section-separator"></div>
    </div>

    {{-- Eventi - CINEMA WALL --}}
    <div class="py-20 md:py-24 cinema-wall-section">
        <livewire:home.events-slider />
    </div>

    {{-- Decorative Separator --}}
    <div class="py-12 md:py-16 bg-white dark:bg-neutral-900">
        <div class="section-separator"></div>
    </div>

    {{-- Poesie - WOODEN DESK SECTION --}}
    <div class="py-20 md:py-24 wooden-desk-section">
        <livewire:home.poetry-section />
    </div>

    {{-- Decorative Separator --}}
    <div class="py-12 md:py-16 bg-white dark:bg-neutral-900">
        <div class="section-separator"></div>
    </div>

    {{-- Nuovi Utenti - POLAROID WALL --}}
    <div class="py-20 md:py-28 polaroid-wall-section">
        <livewire:home.new-users-section />
    </div>

    {{-- Decorative Separator --}}
    <div class="py-12 md:py-16 bg-white dark:bg-neutral-900">
        <div class="section-separator"></div>
    </div>

    {{-- Articoli - Newspaper Section --}}
    <div class="py-20 md:py-28 articles-newspaper-section">
        <div class="max-w-[90rem] mx-auto px-4 md:px-6 lg:px-8">
            <div>
                <div class="text-center mb-12 section-title-fade">
                    <h2 class="text-4xl md:text-5xl font-bold mb-3 text-neutral-900 dark:text-white" style="font-family: 'Crimson Pro', serif;">
                        {!! __('home.articles_section_title') !!}
                    </h2>
                    <p class="text-lg text-neutral-800 dark:text-neutral-300 font-medium">{{ __('home.articles_section_subtitle') }}</p>
                </div>
                <livewire:home.articles-section />
            </div>
        </div>
    </div>

    {{-- Decorative Separator --}}
    <div class="py-12 md:py-16 bg-white dark:bg-neutral-900">
        <div class="section-separator"></div>
    </div>

    {{-- Top Gigs - CORK BOARD SECTION --}}
    <div class="py-20 md:py-24 cork-board-section">
        <livewire:home.gigs-section />
    </div>

    {{-- Decorative Separator --}}
    <div class="py-12 md:py-16 bg-white dark:bg-neutral-900">
        <div class="section-separator"></div>
    </div>

    {{-- Statistiche Prima del Footer --}}
    <div class="py-12 md:py-16 bg-neutral-50 dark:bg-neutral-950">
        <livewire:home.statistics-section />
    </div>

    {{-- CTA Finale o Feed Personalizzato --}}
    @guest
        <section class="relative py-24 md:py-32 overflow-hidden bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800">
            <!-- Animated Background Layer -->
            <div class="absolute inset-0 bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800"></div>
            
            <!-- Floating Shapes -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none opacity-20">
                <div class="absolute w-96 h-96 bg-white/10 rounded-full -top-48 -right-48 animate-float-slow"></div>
                <div class="absolute w-64 h-64 bg-white/10 rounded-full -bottom-32 -left-32 animate-float-slow" style="animation-delay: 2s;"></div>
            </div>

            <div class="relative z-10 max-w-4xl mx-auto px-4 md:px-6 text-center text-white">
                <h2 class="text-5xl md:text-6xl font-bold mb-6 leading-tight text-white" style="font-family: 'Crimson Pro', serif;">
                    {!! __('home.cta_title') !!}
                </h2>
                <p class="text-xl md:text-2xl mb-10 text-white max-w-2xl mx-auto">
                    {{ __('home.cta_subtitle') }}
                </p>
                <x-ui.buttons.primary href="{{ route('register') }}" size="lg">
                    {{ __('home.cta_button') }}
                </x-ui.buttons.primary>
            </div>
        </section>
    @endguest

    @auth
        {{-- Feed Personalizzato per Utenti Loggati --}}
        <livewire:home.personalized-feed />
    @endauth
    
    <script>
        // Fade & Scale on Scroll - Intersection Observer
        document.addEventListener('DOMContentLoaded', function() {
            // Options for Intersection Observer
            const observerOptions = {
                root: null,
                rootMargin: '0px 0px -100px 0px', // Trigger 100px before element enters viewport
                threshold: 0.1 // 10% of element must be visible
            };
            
            // Callback when element enters viewport
            const observerCallback = (entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        // Optional: stop observing after animation (one-time effect)
                        observer.unobserve(entry.target);
                    }
                });
            };
            
            // Create observer
            const observer = new IntersectionObserver(observerCallback, observerOptions);
            
            // Observe all elements with fade-scale-item class
            const fadeElements = document.querySelectorAll('.fade-scale-item, .section-title-fade');
            fadeElements.forEach(element => {
                observer.observe(element);
            });
        });
    </script>
    
    <style>
        @keyframes float-slow { 0%, 100% { transform: translate(0, 0) scale(1); } 50% { transform: translate(30px, -30px) scale(1.1); } }
        .animate-float-slow { animation: float-slow 15s ease-in-out infinite; }
        
        /* Cinema/Theatre Wall - Dark Background */
        .cinema-wall-section {
            position: relative;
            background: 
                /* Subtle texture */
                url("data:image/svg+xml,%3Csvg width='200' height='200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='2.0' numOctaves='3' seed='12' /%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23noise)' opacity='0.06'/%3E%3C/svg%3E"),
                /* Dark gradient */
                linear-gradient(135deg, 
                    #1a1a1a 0%,
                    #1f1f1f 25%,
                    #1c1c1c 50%,
                    #181818 75%,
                    #1e1e1e 100%
                );
            box-shadow: 
                inset 0 0 100px rgba(0, 0, 0, 0.3),
                inset 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        
        :is(.dark .cinema-wall-section) {
            background: 
                url("data:image/svg+xml,%3Csvg width='200' height='200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='2.0' numOctaves='3' seed='12' /%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23noise)' opacity='0.08'/%3E%3C/svg%3E"),
                linear-gradient(135deg, 
                    #0a0a0a 0%,
                    #0f0f0f 25%,
                    #0c0c0c 50%,
                    #080808 75%,
                    #0e0e0e 100%
                );
            box-shadow: 
                inset 0 0 120px rgba(0, 0, 0, 0.5),
                inset 0 2px 10px rgba(0, 0, 0, 0.3);
        }
        
        /* Fade & Scale on Scroll Effect */
        .fade-scale-item {
            opacity: 0;
            transform: scale(0.95);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        
        .fade-scale-item.is-visible {
            opacity: 1;
            transform: scale(1);
        }
        
        /* Preserve random rotations for cards */
        .paper-sheet.fade-scale-item.is-visible,
        .notice-paper.fade-scale-item.is-visible,
        .magazine-article-wrapper.fade-scale-item.is-visible,
        .polaroid-wrapper.fade-scale-item.is-visible {
            /* Keep inline transform (rotation) and add scale */
            transform: scale(1) !important;
        }
        
        /* Section titles fade in */
        .section-title-fade {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }
        
        .section-title-fade.is-visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Cork Board Background */
        .cork-board-section {
            position: relative;
            background: 
                /* Cork texture pattern */
                url("data:image/svg+xml,%3Csvg width='200' height='200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='cork'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='1.5' numOctaves='5' seed='2' /%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23cork)' opacity='0.4'/%3E%3C/svg%3E"),
                /* Cork color gradient */
                radial-gradient(ellipse at center, #c19a6b 0%, #b08968 20%, #9d7a5e 40%, #8b6f54 60%, #7a5f47 80%, #6b4f3a 100%),
                linear-gradient(180deg, #a68868 0%, #8f7459 50%, #a68868 100%);
            box-shadow: inset 0 0 100px rgba(0, 0, 0, 0.15);
        }
        
        :is(.dark .cork-board-section) {
            background: 
                url("data:image/svg+xml,%3Csvg width='200' height='200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='cork'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='1.5' numOctaves='5' seed='2' /%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23cork)' opacity='0.4'/%3E%3C/svg%3E"),
                radial-gradient(ellipse at center, #4a3f32 0%, #3d342a 20%, #352d24 40%, #2d261f 60%, #251f19 80%, #1d1814 100%),
                linear-gradient(180deg, #3a3128 0%, #2d261e 50%, #3a3128 100%);
            box-shadow: inset 0 0 100px rgba(0, 0, 0, 0.5);
        }
        
        /* Wooden Desk Background with REAL IMAGE - NO OVERLAY (WebP optimized) */
        .wooden-desk-section {
            position: relative;
            background: 
                /* Poetry desk with inkwell, ink splatters, and quill pen - WebP (281KB) */
                url('/assets/images/poetry-desk-background.webp') center/cover no-repeat,
                /* Fallback color */
                #8b7355;
            box-shadow: 
                inset 0 2px 12px rgba(0, 0, 0, 0.1),
                inset 0 -2px 12px rgba(0, 0, 0, 0.08);
        }
        
        :is(.dark .wooden-desk-section) {
            background: 
                url('/assets/images/poetry-desk-background.webp') center/cover no-repeat,
                #3a3128;
            box-shadow: 
                inset 0 2px 12px rgba(0, 0, 0, 0.25),
                inset 0 -2px 12px rgba(0, 0, 0, 0.2);
        }
        
        /* Whitewashed Wood Panel Background - VISIBLE TEXTURE */
        .articles-newspaper-section {
            position: relative;
            background: 
                /* Strong wood grain texture (SVG) */
                url("data:image/svg+xml,%3Csvg width='200' height='200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='wood'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='1.2' numOctaves='5' seed='8' /%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23wood)' opacity='0.25'/%3E%3C/svg%3E"),
                /* Visible wood planks */
                repeating-linear-gradient(
                    0deg,
                    transparent,
                    transparent 150px,
                    rgba(200, 180, 160, 0.15) 150px,
                    rgba(200, 180, 160, 0.15) 152px
                ),
                /* Wood grain lines */
                repeating-linear-gradient(
                    90deg,
                    transparent,
                    transparent 4px,
                    rgba(180, 160, 140, 0.08) 4px,
                    rgba(180, 160, 140, 0.08) 5px
                ),
                /* Whitewashed wood gradient with variation */
                linear-gradient(180deg, 
                    #ebe5d9 0%, 
                    #e0dace 15%,
                    #ded8cc 30%,
                    #dcd6ca 45%,
                    #e2dcce 60%,
                    #e4ded2 75%,
                    #e8e2d6 90%,
                    #ebe5d9 100%
                );
            box-shadow: 
                inset 0 0 120px rgba(139, 115, 85, 0.06),
                inset 0 3px 15px rgba(0, 0, 0, 0.04),
                inset 0 -3px 15px rgba(0, 0, 0, 0.03);
        }
        
        :is(.dark .articles-newspaper-section) {
            background: 
                url("data:image/svg+xml,%3Csvg width='200' height='200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='wood'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='1.2' numOctaves='5' seed='8' /%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23wood)' opacity='0.3'/%3E%3C/svg%3E"),
                repeating-linear-gradient(
                    0deg,
                    transparent,
                    transparent 150px,
                    rgba(80, 70, 60, 0.2) 150px,
                    rgba(80, 70, 60, 0.2) 152px
                ),
                repeating-linear-gradient(
                    90deg,
                    transparent,
                    transparent 4px,
                    rgba(60, 55, 50, 0.15) 4px,
                    rgba(60, 55, 50, 0.15) 5px
                ),
                linear-gradient(180deg, 
                    #3a3632 0%, 
                    #2f2d28 15%,
                    #34322d 30%,
                    #2d2b26 45%,
                    #32302b 60%,
                    #35332e 75%,
                    #383630 90%,
                    #3a3632 100%
                );
            box-shadow: 
                inset 0 0 120px rgba(0, 0, 0, 0.2),
                inset 0 3px 15px rgba(0, 0, 0, 0.25),
                inset 0 -3px 15px rgba(0, 0, 0, 0.2);
        }
        
        /* Polaroid Wall - Vintage Painted Wall (Warm Beige with Character) */
        .polaroid-wall-section {
            position: relative;
            background: 
                /* Paint imperfections & age marks */
                radial-gradient(ellipse at 20% 30%, rgba(180, 150, 120, 0.08) 0%, transparent 40%),
                radial-gradient(ellipse at 80% 70%, rgba(160, 140, 110, 0.06) 0%, transparent 35%),
                radial-gradient(ellipse at 40% 80%, rgba(200, 170, 140, 0.07) 0%, transparent 38%),
                /* Strong plaster/stucco texture */
                url("data:image/svg+xml,%3Csvg width='280' height='280' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='stucco'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='1.8' numOctaves='6' seed='28' /%3E%3C/filter%3E%3Crect width='280' height='280' filter='url(%23stucco)' opacity='0.15'/%3E%3C/svg%3E"),
                /* Fine grain texture */
                repeating-linear-gradient(
                    45deg,
                    transparent,
                    transparent 2px,
                    rgba(0, 0, 0, 0.012) 2px,
                    rgba(0, 0, 0, 0.012) 3px
                ),
                repeating-linear-gradient(
                    -45deg,
                    transparent,
                    transparent 2px,
                    rgba(0, 0, 0, 0.01) 2px,
                    rgba(0, 0, 0, 0.01) 3px
                ),
                /* Warm beige base with subtle variation */
                linear-gradient(135deg, 
                    #f5f0e8 0%,
                    #f0ebe1 15%,
                    #f3ede5 30%,
                    #eee8df 45%,
                    #f1ebe3 60%,
                    #ede7dd 75%,
                    #f2ece4 90%,
                    #f4eee6 100%
                );
            box-shadow: 
                inset 0 0 120px rgba(139, 115, 85, 0.06),
                inset 0 3px 12px rgba(0, 0, 0, 0.04),
                inset 0 -3px 12px rgba(0, 0, 0, 0.035),
                inset 20px 20px 80px rgba(180, 150, 120, 0.03),
                inset -20px -20px 80px rgba(160, 130, 100, 0.03);
        }
        
        :is(.dark .polaroid-wall-section) {
            background: 
                /* Dark paint imperfections */
                radial-gradient(ellipse at 20% 30%, rgba(80, 70, 60, 0.12) 0%, transparent 40%),
                radial-gradient(ellipse at 80% 70%, rgba(70, 60, 50, 0.1) 0%, transparent 35%),
                radial-gradient(ellipse at 40% 80%, rgba(90, 75, 65, 0.11) 0%, transparent 38%),
                /* Strong texture */
                url("data:image/svg+xml,%3Csvg width='280' height='280' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='stucco'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='1.8' numOctaves='6' seed='28' /%3E%3C/filter%3E%3Crect width='280' height='280' filter='url(%23stucco)' opacity='0.18'/%3E%3C/svg%3E"),
                /* Dark warm grey */
                linear-gradient(135deg, 
                    #3a3530 0%,
                    #353128 15%,
                    #38342c 30%,
                    #332f26 45%,
                    #36322a 60%,
                    #312d24 75%,
                    #35312b 90%,
                    #37332d 100%
                );
            box-shadow: 
                inset 0 0 120px rgba(0, 0, 0, 0.25),
                inset 0 3px 12px rgba(0, 0, 0, 0.15),
                inset 0 -3px 12px rgba(0, 0, 0, 0.12),
                inset 20px 20px 80px rgba(0, 0, 0, 0.08),
                inset -20px -20px 80px rgba(0, 0, 0, 0.08);
        }
        
        /* Section Separator - STRONG Decorative divider */
        .section-separator {
            height: 2px;
            background: linear-gradient(
                90deg,
                transparent 0%,
                rgba(139, 115, 85, 0.3) 20%,
                rgba(139, 115, 85, 0.5) 50%,
                rgba(139, 115, 85, 0.3) 80%,
                transparent 100%
            );
            margin: 0 auto;
            max-width: 900px;
            position: relative;
            box-shadow: 
                0 1px 3px rgba(139, 115, 85, 0.2),
                0 -1px 3px rgba(139, 115, 85, 0.15);
        }
        
        /* Ornamental center piece */
        .section-separator::before {
            content: '✦';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 20px;
            color: #10b981;
            background: #ffffff;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            box-shadow: 
                0 0 0 8px rgba(255, 255, 255, 0.9),
                0 0 20px rgba(16, 185, 129, 0.3),
                0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        /* Side ornaments */
        .section-separator::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 120px;
            height: 60px;
            background: radial-gradient(ellipse, 
                rgba(16, 185, 129, 0.12) 0%, 
                rgba(16, 185, 129, 0.06) 40%, 
                transparent 70%
            );
            pointer-events: none;
        }
        
        .dark .section-separator {
            background: linear-gradient(
                90deg,
                transparent 0%,
                rgba(100, 85, 70, 0.4) 20%,
                rgba(100, 85, 70, 0.6) 50%,
                rgba(100, 85, 70, 0.4) 80%,
                transparent 100%
            );
            box-shadow: 
                0 1px 3px rgba(100, 85, 70, 0.3),
                0 -1px 3px rgba(100, 85, 70, 0.25);
        }
        
        .dark .section-separator::before {
            background: #ffffff;
            box-shadow: 
                0 0 0 8px rgba(255, 255, 255, 0.95),
                0 0 25px rgba(16, 185, 129, 0.4),
                0 4px 12px rgba(0, 0, 0, 0.3);
        }
        
        .dark .section-separator::after {
            background: radial-gradient(ellipse, 
                rgba(16, 185, 129, 0.18) 0%, 
                rgba(16, 185, 129, 0.1) 40%, 
                transparent 70%
            );
        }
        
        /* Film Studio Background - Lightbox/Viewing Table (to show transparency) */
        .film-studio-section {
            position: relative;
            background: 
                /* Lightbox pattern (like viewing negatives) */
                repeating-linear-gradient(
                    0deg,
                    rgba(240, 240, 235, 0.5),
                    rgba(240, 240, 235, 0.5) 1px,
                    rgba(230, 230, 225, 0.4) 1px,
                    rgba(230, 230, 225, 0.4) 2px
                ),
                repeating-linear-gradient(
                    90deg,
                    rgba(240, 240, 235, 0.5),
                    rgba(240, 240, 235, 0.5) 1px,
                    rgba(230, 230, 225, 0.4) 1px,
                    rgba(230, 230, 225, 0.4) 2px
                ),
                /* Subtle texture */
                url("data:image/svg+xml,%3Csvg width='100' height='100' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='grain'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='1.5' numOctaves='3' seed='5' /%3E%3C/filter%3E%3Crect width='100' height='100' filter='url(%23grain)' opacity='0.05'/%3E%3C/svg%3E"),
                /* Warm backlight gradient */
                radial-gradient(ellipse at center, 
                    rgba(255, 250, 240, 0.8) 0%,
                    rgba(245, 240, 230, 0.7) 50%,
                    rgba(235, 230, 220, 0.6) 100%
                ),
                /* Base light color */
                linear-gradient(135deg, 
                    #f0ede8 0%,
                    #e8e5e0 25%,
                    #ece9e4 50%,
                    #e5e2dd 75%,
                    #eae7e2 100%
                );
            box-shadow: 
                inset 0 0 100px rgba(255, 250, 240, 0.3),
                inset 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        :is(.dark .film-studio-section) {
            background: 
                repeating-linear-gradient(
                    0deg,
                    rgba(40, 40, 38, 0.6),
                    rgba(40, 40, 38, 0.6) 1px,
                    rgba(35, 35, 33, 0.5) 1px,
                    rgba(35, 35, 33, 0.5) 2px
                ),
                repeating-linear-gradient(
                    90deg,
                    rgba(40, 40, 38, 0.6),
                    rgba(40, 40, 38, 0.6) 1px,
                    rgba(35, 35, 33, 0.5) 1px,
                    rgba(35, 35, 33, 0.5) 2px
                ),
                url("data:image/svg+xml,%3Csvg width='100' height='100' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='grain'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='1.5' numOctaves='3' seed='5' /%3E%3C/filter%3E%3Crect width='100' height='100' filter='url(%23grain)' opacity='0.08'/%3E%3C/svg%3E"),
                radial-gradient(ellipse at center, 
                    rgba(60, 58, 55, 0.7) 0%,
                    rgba(50, 48, 45, 0.6) 50%,
                    rgba(40, 38, 35, 0.5) 100%
                ),
                linear-gradient(135deg, 
                    #2a2826 0%,
                    #252321 25%,
                    #282624 50%,
                    #222018 75%,
                    #272522 100%
                );
            box-shadow: 
                inset 0 0 100px rgba(0, 0, 0, 0.4),
                inset 0 2px 10px rgba(0, 0, 0, 0.3);
        }
        
        /* ========================================
           HERO MINI CARDS - Themed Category Cards
           ======================================== */
        
        /* Poetry - Paper Sheet Mini */
        .paper-sheet-mini {
            background: 
                linear-gradient(135deg, 
                    rgba(255,253,245,0) 0%, 
                    rgba(250,240,220,0.4) 25%, 
                    rgba(245,235,215,0.3) 50%, 
                    rgba(240,230,210,0.4) 75%, 
                    rgba(255,250,240,0) 100%),
                radial-gradient(circle at 20% 30%, rgba(210,180,140,0.15) 0%, transparent 50%),
                #faf6ed;
            padding: 1.5rem 1rem;
            border-radius: 4px;
            box-shadow: 
                inset 0 0 0 3px rgba(180, 120, 70, 0.8),
                inset 0 0 15px 6px rgba(160, 100, 60, 0.5),
                0 4px 8px rgba(0, 0, 0, 0.15),
                0 8px 16px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .paper-sheet-mini:hover {
            transform: translateY(-4px) scale(1.05);
            box-shadow: 
                inset 0 0 0 3px rgba(180, 120, 70, 0.8),
                inset 0 0 15px 6px rgba(160, 100, 60, 0.5),
                0 8px 16px rgba(0, 0, 0, 0.2),
                0 16px 32px rgba(0, 0, 0, 0.15);
        }
        
        /* Articles - Magazine Cover Mini */
        .magazine-cover-mini {
            background: linear-gradient(135deg, #fefefe 0%, #f8f8f8 100%);
            border: 2px solid #2d2d2d;
            border-radius: 4px;
            box-shadow: 
                0 4px 8px rgba(0, 0, 0, 0.2),
                0 8px 16px rgba(0, 0, 0, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.5);
            transition: all 0.3s ease;
        }
        
        .magazine-cover-mini:hover {
            transform: translateY(-4px);
            box-shadow: 
                0 8px 16px rgba(0, 0, 0, 0.25),
                0 16px 32px rgba(0, 0, 0, 0.2);
        }
        
        .thumbtack-mini {
            position: absolute;
            top: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 16px;
            height: 16px;
            border-radius: 50%;
            box-shadow: 
                0 2px 4px rgba(0, 0, 0, 0.3),
                inset 0 1px 2px rgba(255, 255, 255, 0.4);
            z-index: 10;
        }
        
        .thumbtack-mini::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 50%;
            transform: translateX(-50%);
            width: 2px;
            height: 4px;
            background: linear-gradient(to bottom, rgba(0,0,0,0.3), transparent);
        }
        
        /* Gigs - Notice Board Card Mini */
        .notice-board-card-mini {
            background: linear-gradient(135deg, #fffef5 0%, #fefce8 100%);
            border-radius: 4px;
            box-shadow: 
                0 4px 8px rgba(0, 0, 0, 0.15),
                0 8px 16px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
        }
        
        .notice-board-card-mini:hover {
            transform: translateY(-4px);
            box-shadow: 
                0 8px 16px rgba(0, 0, 0, 0.2),
                0 16px 32px rgba(0, 0, 0, 0.15);
        }
        
        .washi-tape-mini-top {
            position: absolute;
            top: -6px;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            height: 12px;
            border-radius: 1px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
            z-index: 10;
            clip-path: polygon(
                2% 0%, 5% 30%, 8% 0%, 12% 35%, 15% 0%, 
                18% 40%, 22% 0%, 25% 30%, 28% 0%, 32% 35%, 
                35% 0%, 38% 40%, 42% 0%, 45% 30%, 48% 0%, 
                52% 35%, 55% 0%, 58% 40%, 62% 0%, 65% 30%, 
                68% 0%, 72% 35%, 75% 0%, 78% 40%, 82% 0%, 
                85% 30%, 88% 0%, 92% 35%, 95% 0%, 98% 40%,
                100% 0%, 100% 100%, 0% 100%, 0% 0%
            );
        }
        
        /* Events - Cinema Ticket Mini */
        .cinema-ticket-mini {
            background: linear-gradient(135deg, 
                #fefaf3 0%,
                #fdf8f0 25%,
                #fcf7ef 50%,
                #fbf6ed 75%,
                #faf5ec 100%
            );
            border-radius: 4px;
            box-shadow: 
                0 4px 8px rgba(0, 0, 0, 0.3),
                0 8px 16px rgba(0, 0, 0, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.6);
            position: relative;
            transition: all 0.3s ease;
        }
        
        .cinema-ticket-mini:hover {
            transform: translateY(-4px);
            box-shadow: 
                0 8px 16px rgba(0, 0, 0, 0.35),
                0 16px 32px rgba(0, 0, 0, 0.25);
        }
        
        .cinema-ticket-mini::before,
        .cinema-ticket-mini::after {
            content: '';
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 12px;
            height: 12px;
            background: radial-gradient(circle, #2d2520 0%, #2d2520 45%, transparent 45%);
            border-radius: 50%;
        }
        
        .cinema-ticket-mini::before { left: -6px; }
        .cinema-ticket-mini::after { right: -6px; }
        
        /* Videos - Film Strip Mini */
        .film-strip-mini {
            background: 
                linear-gradient(90deg, 
                    rgba(255, 255, 255, 0.12) 0%,
                    transparent 30%
                ),
                linear-gradient(180deg, 
                    rgba(80, 55, 35, 0.95) 0%,
                    rgba(70, 48, 30, 0.97) 50%,
                    rgba(80, 55, 35, 0.95) 100%
                );
            border-radius: 4px;
            box-shadow: 
                0 4px 8px rgba(0, 0, 0, 0.3),
                inset 0 2px 4px rgba(255, 255, 255, 0.15);
            position: relative;
            padding: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .film-strip-mini:hover {
            transform: translateY(-4px);
            box-shadow: 
                0 8px 16px rgba(0, 0, 0, 0.4),
                inset 0 2px 4px rgba(255, 255, 255, 0.15);
        }
        
        .film-strip-mini::before,
        .film-strip-mini::after {
            content: '';
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 6px;
            height: 80%;
            background: repeating-linear-gradient(
                to bottom,
                transparent 0px,
                transparent 3px,
                rgba(240, 235, 228, 0.8) 3px,
                rgba(240, 235, 228, 0.8) 8px,
                transparent 8px,
                transparent 14px
            );
        }
        
        .film-strip-mini::before { left: 2px; }
        .film-strip-mini::after { right: 2px; }
        
        /* Community - Polaroid Mini */
        .polaroid-mini {
            background: linear-gradient(to bottom, 
                #ffffff 0%,
                #fafafa 70%,
                #f0f0f0 100%
            );
            padding: 0.75rem 0.75rem 1.25rem 0.75rem;
            border-radius: 4px;
            box-shadow: 
                0 4px 8px rgba(0, 0, 0, 0.2),
                0 8px 16px rgba(0, 0, 0, 0.15),
                inset 0 1px 2px rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
        }
        
        .polaroid-mini:hover {
            transform: translateY(-4px) rotate(2deg);
            box-shadow: 
                0 8px 16px rgba(0, 0, 0, 0.25),
                0 16px 32px rgba(0, 0, 0, 0.2);
        }
        
        .washi-tape-mini-polaroid {
            position: absolute;
            top: -6px;
            left: 50%;
            transform: translateX(-50%);
            width: 70%;
            height: 12px;
            border-radius: 1px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
            z-index: 10;
            clip-path: polygon(
                2% 0%, 5% 30%, 8% 0%, 12% 35%, 15% 0%, 
                18% 40%, 22% 0%, 25% 30%, 28% 0%, 32% 35%, 
                35% 0%, 38% 40%, 42% 0%, 45% 30%, 48% 0%, 
                52% 35%, 55% 0%, 58% 40%, 62% 0%, 65% 30%, 
                68% 0%, 72% 35%, 75% 0%, 78% 40%, 82% 0%, 
                85% 30%, 88% 0%, 92% 35%, 95% 0%, 98% 40%,
                100% 0%, 100% 100%, 0% 100%, 0% 0%
            );
        }
    </style>
</div>
