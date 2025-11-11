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
                
                {{-- Categories Grid - Simple Icons with Section Themes --}}
                <div class="pt-8 flex flex-wrap justify-center gap-6 max-w-5xl mx-auto">
                    
                    {{-- Poetry - Mini Paper Sheet --}}
                    <?php $paperRotation = rand(-2, 2); ?>
                    <a href="{{ route('poems.index') }}" 
                       class="hero-paper-wrapper"
                       style="transform: rotate({{ $paperRotation }}deg);">
                        <div class="hero-paper-sheet">
                            <div class="flex items-center justify-center h-full">
                                <h3 class="hero-paper-title">
                                    "{{ __('home.hero_category_poems') }}"
                                </h3>
                            </div>
                        </div>
                    </a>
                    
                    {{-- Articles - Mini Magazine --}}
                    <?php 
                        $rotation = rand(-3, 3);
                        $pinColor = ['#e53e3e', '#3182ce', '#38a169', '#d69e2e', '#805ad5'][rand(0, 4)];
                        $pinRotation = rand(-15, 15);
                    ?>
                    <a href="{{ route('articles.index') }}" 
                       class="hero-magazine-wrapper">
                        <div class="hero-thumbtack" 
                             style="background: {{ $pinColor }}; transform: rotate({{ $pinRotation }}deg);">
                            <div class="hero-thumbtack-needle"></div>
                        </div>
                        <div class="hero-magazine-cover" style="transform: rotate({{ $rotation }}deg);">
                            <div class="hero-magazine-inner">
                                <div class="flex justify-between items-start mb-1">
                                    <div class="text-xs font-bold text-neutral-900">SLAMIN</div>
                                    <div class="text-[8px] text-neutral-600">Vol. {{ date('Y') }} · N.{{ rand(10, 99) }}</div>
                                </div>
                                <div class="hero-magazine-image-area" style="background: url('<?php echo [
                                    'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400',
                                    'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400',
                                    'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=400',
                                    'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=400'
                                ][rand(0, 3)]; ?>') center/cover;">
                                </div>
                                <h3 class="hero-magazine-title mt-2">
                                    {{ __('home.hero_category_articles') }}
                                </h3>
                                <div class="h-[1px] bg-neutral-300 my-1"></div>
                                <p class="text-[7px] text-neutral-500 leading-[0.6rem]">
                                    Prtn b nsnt st ps dlrs dcms vntr
                                </p>
                            </div>
                        </div>
                    </a>
                    
                    {{-- Gigs - Mini Notice Board --}}
                    <?php
                        $tapeWidth = rand(80, 100);
                        $tapeRotation = rand(-4, 4);
                        $paperRotation = rand(-2, 2);
                        $tapeBottomRotation = rand(-4, 4);
                    ?>
                    <a href="{{ route('gigs.index') }}" 
                       class="hero-notice-wrapper">
                        <div class="hero-washi-tape hero-washi-top" 
                             style="width: {{ $tapeWidth }}px; 
                                    transform: translate(calc(-50%), 0) rotate({{ $tapeRotation }}deg);"></div>
                        <div class="hero-notice-paper" style="transform: rotate({{ $paperRotation }}deg);">
                            <div class="flex items-center justify-center h-full">
                                <div class="hero-notice-badge">{{ strtoupper(__('home.hero_category_gigs')) }}</div>
                            </div>
                        </div>
                        <div class="hero-washi-tape hero-washi-bottom" 
                             style="width: {{ $tapeWidth }}px; 
                                    transform: translate(calc(-50%), 0) rotate({{ $tapeBottomRotation }}deg);"></div>
                    </a>
                    
                    {{-- Events - Mini Cinema Ticket --}}
                    <?php 
                        $tilt = rand(-3, 3);
                        $selectedColors = [
                            ['#fefaf3', '#fdf8f0', '#faf5ec'],
                            ['#fef9f1', '#fdf7ef', '#faf4ea'],
                            ['#fffbf5', '#fef9f3', '#fdf7f1']
                        ][rand(0, 2)];
                    ?>
                    <a href="{{ route('events.index') }}" 
                       class="hero-ticket-wrapper"
                       style="transform: rotate({{ $tilt }}deg);">
                        <div class="hero-cinema-ticket"
                             style="background: linear-gradient(135deg, {{ $selectedColors[0] }} 0%, {{ $selectedColors[1] }} 50%, {{ $selectedColors[2] }} 100%);">
                            <div class="hero-ticket-perforation"></div>
                            <div class="hero-ticket-content">
                                <div class="ticket-mini-header">
                                    <div class="text-[8px] font-black tracking-wider text-red-700">TICKET</div>
                                    <div class="text-[7px] font-bold text-amber-700">#0{{ rand(1, 9) }}{{ rand(0, 9) }}{{ rand(0, 9) }}</div>
                                </div>
                                <div class="flex-1 flex items-center justify-center">
                                    <div class="hero-ticket-stamp">{{ strtoupper(__('home.hero_category_events')) }}</div>
                                </div>
                                <div class="ticket-mini-barcode">
                                    <div class="flex justify-center gap-[1px]">
                                        @for($j = 0; $j < 20; $j++)
                                        <div style="width: {{ rand(1, 2) }}px; height: {{ rand(12, 18) }}px; background: #2d2520;"></div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    
                    {{-- Videos --}}
                    <div class="group flex flex-col items-center gap-3 p-6 bg-white/5 hover:bg-white/10 backdrop-blur-sm rounded-2xl border border-white/10 hover:border-primary-500/50 transition-all duration-300 hover:scale-105 min-w-[140px] cursor-pointer"
                         onclick="document.querySelector('.film-studio-section').scrollIntoView({ behavior: 'smooth' })">
                        <svg class="w-12 h-12 text-primary-400 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-white font-medium text-sm">{{ __('home.hero_category_videos') }}</span>
                    </div>
                    
                    {{-- Community --}}
                    <a href="{{ route('dashboard.index') }}" 
                       class="group flex flex-col items-center gap-3 p-6 bg-white/5 hover:bg-white/10 backdrop-blur-sm rounded-2xl border border-white/10 hover:border-primary-500/50 transition-all duration-300 hover:scale-105 min-w-[140px]">
                        <svg class="w-12 h-12 text-primary-400 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span class="text-white font-medium text-sm">{{ __('home.hero_category_community') }}</span>
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
           HERO MINI CARDS - One by One
           ======================================== */
        
        /* Poetry - Mini Paper Sheet */
        .hero-paper-wrapper {
            display: block;
            width: 130px;
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
            padding: 1.5rem 1rem;
            height: 150px;
            border-radius: 3px;
            box-shadow: 
                /* Inset border (aged paper edge) */
                inset 0 0 0 3px rgba(180, 120, 70, 0.85),
                inset 0 0 18px 7px rgba(160, 100, 60, 0.55),
                inset 0 0 28px 11px rgba(140, 90, 50, 0.35),
                /* External shadows (3D depth) */
                0 5px 8px rgba(0, 0, 0, 0.25),
                0 10px 15px rgba(0, 0, 0, 0.2),
                0 15px 22px rgba(0, 0, 0, 0.15),
                0 20px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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
        
        /* Poetry Title - Same as sections */
        .hero-paper-title {
            font-family: 'Crimson Pro', serif;
            font-size: 1.125rem;
            font-weight: 600;
            color: #2d2520;
            line-height: 1.4;
            text-align: center;
            transition: color 0.3s ease;
        }
        
        .hero-paper-wrapper:hover .hero-paper-title {
            color: #4a7c59;
        }
        
        /* Articles - Mini Magazine */
        .hero-magazine-wrapper {
            display: block;
            width: 130px;
            position: relative;
            transition: all 0.3s ease;
        }
        
        .hero-magazine-wrapper:hover {
            transform: translateY(-6px);
        }
        
        .hero-thumbtack {
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 20px;
            border-radius: 50%;
            box-shadow: 
                0 3px 6px rgba(0, 0, 0, 0.35),
                inset 0 1px 3px rgba(255, 255, 255, 0.4),
                inset 0 -1px 2px rgba(0, 0, 0, 0.2);
            z-index: 10;
        }
        
        .hero-thumbtack-needle {
            position: absolute;
            top: 16px;
            left: 50%;
            transform: translateX(-50%);
            width: 2px;
            height: 6px;
            background: linear-gradient(to bottom, 
                rgba(0, 0, 0, 0.4),
                rgba(0, 0, 0, 0.2),
                transparent
            );
        }
        
        .hero-magazine-cover {
            background: linear-gradient(135deg, 
                #fefefe 0%,
                #fcfcfc 25%,
                #fafafa 50%,
                #f8f8f8 75%,
                #f6f6f6 100%
            );
            border: 2px solid #2d2d2d;
            border-radius: 4px;
            box-shadow: 
                /* Main depth */
                0 6px 10px rgba(0, 0, 0, 0.25),
                0 12px 20px rgba(0, 0, 0, 0.2),
                0 18px 30px rgba(0, 0, 0, 0.15),
                /* Glossy highlight */
                inset 0 1px 0 rgba(255, 255, 255, 0.6),
                inset 0 2px 4px rgba(255, 255, 255, 0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .hero-magazine-inner {
            padding: 1rem 0.75rem;
            height: 150px;
            display: flex;
            flex-direction: column;
        }
        
        .hero-magazine-wrapper:hover .hero-magazine-cover {
            box-shadow: 
                0 10px 16px rgba(0, 0, 0, 0.3),
                0 20px 32px rgba(0, 0, 0, 0.25),
                0 30px 48px rgba(0, 0, 0, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.6),
                inset 0 2px 4px rgba(255, 255, 255, 0.3);
        }
        
        /* Magazine Title - Same as sections */
        .hero-magazine-title {
            font-family: 'Crimson Pro', serif;
            font-size: 0.875rem;
            font-weight: 700;
            line-height: 1.3;
            color: #1a1a1a;
            text-align: left;
            transition: color 0.3s ease;
        }
        
        .hero-magazine-wrapper:hover .hero-magazine-title {
            color: #10b981;
        }
        
        /* Magazine Image Area */
        .hero-magazine-image-area {
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 3px;
            overflow: hidden;
        }
        
        /* Gigs - Mini Notice Board */
        .hero-notice-wrapper {
            display: block;
            width: 130px;
            position: relative;
            transition: all 0.3s ease;
        }
        
        .hero-notice-wrapper:hover {
            transform: translateY(-6px);
        }
        
        .hero-washi-tape {
            position: absolute;
            left: 50%;
            height: 24px;
            border-radius: 1px;
            background: 
                /* Subtle shine */
                linear-gradient(
                    105deg,
                    rgba(255, 255, 255, 0.25) 0%,
                    transparent 30%,
                    transparent 70%,
                    rgba(255, 255, 255, 0.25) 100%
                ),
                /* SOFT YELLOW scotch gradient (overwrites inline) */
                linear-gradient(180deg, 
                    rgba(240, 210, 100, 0.92) 0%, 
                    rgba(245, 220, 120, 0.90) 50%, 
                    rgba(250, 230, 140, 0.92) 100%
                );
            box-shadow: 
                /* Strong shadow for depth */
                0 3px 8px rgba(0, 0, 0, 0.35),
                0 1px 4px rgba(0, 0, 0, 0.25),
                /* Glossy highlights */
                inset 0 2px 5px rgba(255, 255, 255, 0.9),
                inset 0 -1px 3px rgba(0, 0, 0, 0.2);
            z-index: 10;
            border-top: 1px solid rgba(255, 255, 255, 0.8);
            border-bottom: 1px solid rgba(200, 180, 100, 0.4);
            /* SERRATED EDGES on LEFT and RIGHT sides */
            clip-path: polygon(
                /* Left edge - serrated */
                0% 0%,
                2% 5%,
                0% 10%,
                2% 15%,
                0% 20%,
                2% 25%,
                0% 30%,
                2% 35%,
                0% 40%,
                2% 45%,
                0% 50%,
                2% 55%,
                0% 60%,
                2% 65%,
                0% 70%,
                2% 75%,
                0% 80%,
                2% 85%,
                0% 90%,
                2% 95%,
                0% 100%,
                /* Bottom edge (smooth) */
                100% 100%,
                /* Right edge - serrated */
                98% 95%,
                100% 90%,
                98% 85%,
                100% 80%,
                98% 75%,
                100% 70%,
                98% 65%,
                100% 60%,
                98% 55%,
                100% 50%,
                98% 45%,
                100% 40%,
                98% 35%,
                100% 30%,
                98% 25%,
                100% 20%,
                98% 15%,
                100% 10%,
                98% 5%,
                100% 0%
            );
        }
        
        .hero-washi-top {
            top: -12px;
        }
        
        .hero-washi-bottom {
            bottom: -12px;
        }
        
        .hero-notice-paper {
            background: linear-gradient(135deg, 
                #fffef5 0%,
                #fffdf2 25%,
                #fefce8 50%,
                #fefbe5 75%,
                #fdfae3 100%
            );
            padding: 1.5rem 1rem;
            height: 150px;
            border-radius: 4px;
            box-shadow: 
                /* Paper shadows */
                0 5px 8px rgba(0, 0, 0, 0.2),
                0 10px 15px rgba(0, 0, 0, 0.15),
                0 15px 22px rgba(0, 0, 0, 0.1),
                /* Subtle inset highlight */
                inset 0 1px 0 rgba(255, 255, 255, 0.8),
                inset 0 2px 4px rgba(255, 255, 255, 0.4);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .hero-notice-wrapper:hover .hero-notice-paper {
            box-shadow: 
                0 8px 14px rgba(0, 0, 0, 0.25),
                0 16px 28px rgba(0, 0, 0, 0.2),
                0 24px 40px rgba(0, 0, 0, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.8),
                inset 0 2px 4px rgba(255, 255, 255, 0.4);
        }
        
        /* Gigs Category Badge */
        .hero-notice-badge {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: white;
            background: linear-gradient(135deg, #0369a1 0%, #0284c7 100%);
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            box-shadow: 
                0 3px 6px rgba(0, 0, 0, 0.25),
                inset 0 1px 2px rgba(255, 255, 255, 0.3);
        }
        
        /* Events - Mini Cinema Ticket */
        .hero-ticket-wrapper {
            display: block;
            width: 130px;
            transition: all 0.3s ease;
        }
        
        .hero-ticket-wrapper:hover {
            transform: translateY(-6px) scale(1.02);
        }
        
        .hero-cinema-ticket {
            display: flex;
            background: #fef7e6;
            border-radius: 6px;
            height: 150px;
            box-shadow: 
                0 6px 16px rgba(0, 0, 0, 0.4),
                0 12px 32px rgba(0, 0, 0, 0.3);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .hero-ticket-wrapper:hover .hero-cinema-ticket {
            box-shadow: 
                0 10px 20px rgba(0, 0, 0, 0.5),
                0 16px 40px rgba(0, 0, 0, 0.4),
                0 0 0 2px rgba(218, 165, 32, 0.4);
        }
        
        /* Perforated Left Edge - EXACT COPY */
        .hero-ticket-perforation {
            width: 16px;
            background: linear-gradient(135deg, 
                rgba(139, 115, 85, 0.15) 0%,
                rgba(160, 140, 110, 0.1) 100%
            );
            position: relative;
            flex-shrink: 0;
        }
        
        .hero-ticket-perforation::before {
            content: '';
            position: absolute;
            top: -5px;
            bottom: -5px;
            right: 0;
            width: 8px;
            background: 
                radial-gradient(circle at 0 6px, transparent 3px, currentColor 3px) 0 0 / 8px 12px repeat-y;
            color: inherit;
        }
        
        /* Ticket Content */
        .hero-ticket-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 0.75rem 0.5rem;
        }
        
        .ticket-mini-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 0.25rem;
            border-bottom: 1px dashed rgba(139, 115, 85, 0.3);
            margin-bottom: 0.5rem;
        }
        
        .ticket-mini-barcode {
            margin-top: 0.5rem;
            padding-top: 0.5rem;
            border-top: 1px dashed rgba(139, 115, 85, 0.3);
        }
        
        /* Events Stamp in Center */
        .hero-ticket-stamp {
            font-family: 'Special Elite', 'Courier New', monospace;
            text-align: center;
            font-size: 0.7rem;
            font-weight: 400;
            color: #b91c1c;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 0.375rem 0.75rem;
            border: 2px solid #b91c1c;
            border-radius: 3px;
            opacity: 0.7;
            position: relative;
            transform: rotate(<?php echo rand(-8, 8); ?>deg);
            box-shadow: 
                0 2px 4px rgba(185, 28, 28, 0.2),
                inset 0 1px 2px rgba(185, 28, 28, 0.1);
        }
        
        .hero-ticket-stamp::before {
            content: '';
            position: absolute;
            inset: -1px;
            border: 1px solid rgba(185, 28, 28, 0.12);
            border-radius: 2px;
            pointer-events: none;
        }
        
    </style>
</div>
