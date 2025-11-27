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
                
                {{-- Categories Grid - Simple Icons with Section Themes --}}
                <div class="pt-8 flex md:flex-wrap justify-start md:justify-center gap-4 max-w-6xl mx-auto overflow-x-auto md:overflow-x-visible scrollbar-hide px-4 md:px-0"
                     style="-webkit-overflow-scrolling: touch; isolation: isolate; transform: translateZ(0);">
                    
                    {{-- Poetry - Mini Paper Sheet --}}
                    <?php $paperRotation = rand(-2, 2); ?>
                    <div class="hero-card-container flex-shrink-0">
                        <div class="hero-paper-wrapper cursor-pointer"
                             @click="document.querySelector('.wooden-desk-section').scrollIntoView({ behavior: 'smooth' })"
                             style="transform: rotate({{ $paperRotation }}deg);">
                            <div class="hero-paper-sheet">
                                <div class="flex items-center justify-center h-full">
                                    <h3 class="hero-paper-title">
                                        "{{ __('home.hero_category_poems') }}"
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="hero-card-label">{{ strip_tags(__('home.poetry_section_title')) }}</div>
                    </div>
                    
                    {{-- Articles - Mini Magazine --}}
                    <?php 
                        $rotation = rand(-3, 3);
                        $pinColor = ['#e53e3e', '#3182ce', '#38a169', '#d69e2e', '#805ad5'][rand(0, 4)];
                        $pinRotation = rand(-15, 15);
                    ?>
                    <div class="hero-card-container flex-shrink-0">
                        <div class="hero-magazine-wrapper cursor-pointer"
                             @click="document.querySelector('.articles-newspaper-section').scrollIntoView({ behavior: 'smooth' })">
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
                        </div>
                        <div class="hero-card-label">{{ strip_tags(__('home.articles_section_title')) }}</div>
                    </div>
                    
                    {{-- Gigs - Mini Notice Board --}}
                    <?php
                        $tapeWidth = rand(80, 100);
                        $tapeRotation = rand(-4, 4);
                        $paperRotation = rand(-2, 2);
                        $tapeBottomRotation = rand(-4, 4);
                    ?>
                    <div class="hero-card-container flex-shrink-0">
                        <div class="hero-notice-wrapper cursor-pointer"
                             @click="document.querySelector('.cork-board-section').scrollIntoView({ behavior: 'smooth' })">
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
                        </div>
                        <div class="hero-card-label">{{ strip_tags(__('home.gigs_section_title')) }}</div>
                    </div>
                    
                    {{-- Events - Mini Cinema Ticket --}}
                    <?php 
                        $tilt = rand(-3, 3);
                        $selectedColors = [
                            ['#fefaf3', '#fdf8f0', '#faf5ec'],
                            ['#fef9f1', '#fdf7ef', '#faf4ea'],
                            ['#fffbf5', '#fef9f3', '#fdf7f1']
                        ][rand(0, 2)];
                    ?>
                    <div class="hero-card-container flex-shrink-0">
                        <div class="hero-ticket-wrapper cursor-pointer"
                             @click="document.querySelector('.cinema-wall-section').scrollIntoView({ behavior: 'smooth' })"
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
                        </div>
                        <div class="hero-card-label">{{ strip_tags(__('home.events_section_title')) }}</div>
                    </div>
                    
                    {{-- Videos - Mini Film Strip --}}
                    <?php $tilt = rand(-2, 2); ?>
                    <div class="hero-card-container flex-shrink-0">
                        <div class="hero-film-wrapper cursor-pointer"
                             @click="document.querySelector('.film-studio-section').scrollIntoView({ behavior: 'smooth' })"
                             style="transform: rotate({{ $tilt }}deg);">
                            <div class="hero-film-strip">
                                <!-- Film codes -->
                                <div class="hero-film-code-top">SLAMIN</div>
                                <div class="hero-film-code-bottom">ISO 400</div>
                                
                                <!-- Film frame with thumbnail -->
                                <div class="hero-film-frame">
                                    <!-- Left perforation -->
                                    <div class="hero-film-perf-left">
                                        @for($h = 0; $h < 8; $h++)
                                        <div class="hero-perf-hole"></div>
                                        @endfor
                                    </div>
                                    
                                    <!-- Right perforation -->
                                    <div class="hero-film-perf-right">
                                        @for($h = 0; $h < 8; $h++)
                                        <div class="hero-perf-hole"></div>
                                        @endfor
                                    </div>
                                    
                                    <div class="hero-frame-number-tl">///01</div>
                                    <div class="hero-frame-number-tr">01A</div>
                                    <div class="hero-frame-number-bl">35MM</div>
                                    <div class="hero-frame-number-br">{{ rand(1, 9) }}</div>
                                    
                                    <!-- Thumbnail background with random image -->
                                    <div class="hero-film-thumbnail" style="background: url('<?php echo [
                                        'https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?w=400',
                                        'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?w=400',
                                        'https://images.unsplash.com/photo-1514320291840-2e0a9bf2a9ae?w=400',
                                        'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?w=400',
                                        'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=400',
                                        'https://images.unsplash.com/photo-1501612780327-45045538702b?w=400'
                                    ][rand(0, 5)]; ?>') center/cover;">
                                    </div>
                                    
                                    <!-- Media text overlay -->
                                    <div class="hero-film-text">
                                        {{ __('home.hero_category_videos') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hero-card-label">{{ strip_tags(__('home.videos_section_title')) }}</div>
                    </div>
                    
                    {{-- New Users - Mini Polaroid --}}
                    <?php 
                        $rotation = rand(-3, 3);
                        $tapeRotation = rand(-8, 8);
                        $tapeWidth = rand(60, 80);
                        $tapeColors = [
                            ['rgba(255, 220, 0, 0.95)', 'rgba(255, 230, 50, 0.93)', 'rgba(255, 240, 100, 0.95)'],
                            ['rgba(255, 105, 180, 0.92)', 'rgba(255, 130, 200, 0.90)', 'rgba(255, 150, 215, 0.92)'],
                            ['rgba(0, 150, 255, 0.90)', 'rgba(50, 170, 255, 0.88)', 'rgba(100, 190, 255, 0.90)'],
                            ['rgba(50, 255, 50, 0.88)', 'rgba(80, 255, 80, 0.86)', 'rgba(110, 255, 110, 0.88)'],
                        ];
                        $selectedTape = $tapeColors[array_rand($tapeColors)];
                    ?>
                    <div class="hero-card-container flex-shrink-0">
                        <div class="hero-polaroid-wrapper cursor-pointer"
                             @click="document.querySelector('.polaroid-wall-section').scrollIntoView({ behavior: 'smooth' })"
                             style="transform: rotate({{ $rotation }}deg);">
                            <!-- Tape -->
                            <div class="hero-polaroid-tape" 
                                 style="width: {{ $tapeWidth }}px; 
                                        transform: rotate({{ $tapeRotation }}deg);
                                        background: linear-gradient(135deg, {{ $selectedTape[0] }}, {{ $selectedTape[1] }}, {{ $selectedTape[2] }});"></div>
                            
                            <!-- Polaroid Card -->
                            <div class="hero-polaroid-card">
                                <div class="hero-polaroid-photo" style="background: linear-gradient(135deg, <?php echo [
                                    '#4a7c59 0%, #2d5a3f 100%',
                                    '#0369a1 0%, #0284c7 100%',
                                    '#d97706 0%, #ea580c 100%',
                                    '#7c3aed 0%, #5b21b6 100%'
                                ][rand(0, 3)]; ?>);">
                                    <svg class="w-12 h-12 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div class="hero-polaroid-caption">
                                    {{ __('home.hero_category_users') }}
                                </div>
                            </div>
                        </div>
                        <div class="hero-card-label">{{ strip_tags(__('home.new_users_title')) }}</div>
                    </div>
                    
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

    {{-- Carousel Section --}}
    <livewire:home.hero-carousel />

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
                inset 0 0 0 2px rgba(180, 120, 70, 0.6),
                0 4px 12px rgba(0, 0, 0, 0.15);
            transition: box-shadow 0.3s ease;
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
        }
        
        .hero-thumbtack {
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 20px;
            border-radius: 50%;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.25);
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
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: box-shadow 0.3s ease;
        }
        
        .hero-magazine-inner {
            padding: 1rem 0.75rem;
            height: 150px;
            display: flex;
            flex-direction: column;
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
        }
        
        .hero-washi-tape {
            position: absolute;
            left: 50%;
            height: 24px;
            border-radius: 1px;
            background: linear-gradient(180deg, 
                rgba(240, 210, 100, 0.92) 0%, 
                rgba(245, 220, 120, 0.90) 50%, 
                rgba(250, 230, 140, 0.92) 100%
            );
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
            z-index: 10;
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
            left: 50%;
        }
        
        .hero-washi-bottom {
            bottom: -12px;
            left: 50%;
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
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: box-shadow 0.3s ease;
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
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }
        
        /* Events - Mini Cinema Ticket */
        .hero-ticket-wrapper {
            display: block;
            width: 130px;
        }
        
        .hero-cinema-ticket {
            display: flex;
            background: #fef7e6;
            border-radius: 6px;
            height: 150px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
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
        }
        
        /* Videos - Mini Film Strip */
        .hero-film-wrapper {
            display: block;
            width: 130px;
        }
        
        .hero-film-strip {
            position: relative;
            background: linear-gradient(180deg, 
                rgba(80, 55, 35, 0.95) 0%,
                rgba(70, 48, 30, 0.97) 50%,
                rgba(80, 55, 35, 0.95) 100%
            );
            padding: 1rem 0.5rem;
            height: 150px;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        /* Film codes */
        .hero-film-code-top,
        .hero-film-code-bottom {
            position: absolute;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 0.5rem;
            font-weight: 700;
            color: white;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
            letter-spacing: 0.1em;
            z-index: 2;
        }
        
        .hero-film-code-top { top: 0.25rem; }
        .hero-film-code-bottom { bottom: 0.25rem; }
        
        /* Film frame */
        .hero-film-frame {
            position: relative;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 2px;
            overflow: hidden;
        }
        
        /* Perforations - INSIDE frame */
        .hero-film-perf-left,
        .hero-film-perf-right {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 0.85rem;
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
            align-items: center;
            background: linear-gradient(180deg, 
                rgba(80, 55, 35, 0.98) 0%,
                rgba(70, 48, 30, 1) 50%,
                rgba(80, 55, 35, 0.98) 100%
            );
            z-index: 3;
        }
        
        .hero-film-perf-left { left: 0; }
        .hero-film-perf-right { right: 0; }
        
        .hero-perf-hole {
            width: 10px;
            height: 8px;
            background: rgba(240, 235, 228, 0.95);
            border-radius: 1px;
            box-shadow: 
                inset 0 2px 3px rgba(0, 0, 0, 0.4),
                inset 0 1px 2px rgba(0, 0, 0, 0.3);
        }
        
        /* Thumbnail background */
        .hero-film-thumbnail {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1;
        }
        
        /* Media text overlay */
        .hero-film-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-family: 'Crimson Pro', serif;
            font-size: 1.25rem;
            font-weight: 700;
            color: white;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.8);
            z-index: 10;
            white-space: nowrap;
            letter-spacing: 0.05em;
        }
        
        /* Frame numbers */
        .hero-frame-number-tl,
        .hero-frame-number-tr,
        .hero-frame-number-bl,
        .hero-frame-number-br {
            position: absolute;
            font-size: 0.5rem;
            font-weight: 700;
            color: white;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
            z-index: 4;
        }
        
        .hero-frame-number-tl { top: 0.25rem; left: 1.1rem; }
        .hero-frame-number-tr { top: 0.25rem; right: 1.1rem; }
        .hero-frame-number-bl { bottom: 0.25rem; left: 1.1rem; }
        .hero-frame-number-br { bottom: 0.25rem; right: 1.1rem; }
        
        /* Hero Card Container with Label */
        .hero-card-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s ease;
            width: 130px;
            min-width: 130px;
            max-width: 130px;
        }
        
        .hero-card-container:hover > div:first-child {
            transform: scale(1.08) translateZ(0) !important;
            z-index: 10;
        }
        
        /* Hero Card Label - Appears below on hover */
        .hero-card-label {
            font-family: 'Crimson Pro', serif;
            font-size: 1.125rem;
            font-weight: 600;
            color: white;
            text-align: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
            white-space: nowrap;
            pointer-events: none;
        }
        
        .hero-card-container:hover .hero-card-label {
            opacity: 1;
        }
        
        /* Enhanced hover for all card wrappers */
        .hero-paper-wrapper,
        .hero-magazine-wrapper,
        .hero-notice-wrapper,
        .hero-ticket-wrapper,
        .hero-film-wrapper {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
        }
        
        /* New Users - Mini Polaroid */
        .hero-polaroid-wrapper {
            display: block;
            width: 130px;
            position: relative;
            transition: transform 0.3s ease;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
        }
        
        .hero-polaroid-tape {
            position: absolute;
            top: -8px;
            left: 50%;
            transform-origin: center;
            height: 20px;
            border-radius: 2px;
            box-shadow: 
                0 2px 4px rgba(0, 0, 0, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            z-index: 2;
        }
        
        .hero-polaroid-card {
            background: linear-gradient(135deg, 
                #ffffff 0%,
                #fafafa 50%,
                #f5f5f5 100%
            );
            padding: 0.5rem 0.5rem 0.75rem 0.5rem;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .hero-polaroid-photo {
            width: 100%;
            height: 110px;
            background-color: #e5e5e5;
            border-radius: 2px;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .hero-polaroid-caption {
            font-family: 'Crimson Pro', serif;
            font-size: 0.75rem;
            font-weight: 600;
            color: #2d2d2d;
            text-align: center;
            line-height: 1.2;
        }
        
    </style>
</div>
