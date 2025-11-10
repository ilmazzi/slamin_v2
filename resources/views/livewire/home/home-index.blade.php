<div>
    {{-- Hero Carousel --}}
    <livewire:home.hero-carousel />

    {{-- Video/Foto Community - SEZIONE SEPARATA --}}
    <livewire:home.videos-section />

    {{-- Eventi --}}
    <div class="py-16 md:py-20 bg-gradient-to-b from-white via-primary-50/20 to-white dark:from-neutral-900 dark:via-primary-950/10 dark:to-neutral-900">
        <livewire:home.events-slider />
    </div>

    {{-- Poesie - WOODEN DESK SECTION --}}
    <div class="py-16 md:py-20 wooden-desk-section">
        <livewire:home.poetry-section />
    </div>

    {{-- Nuovi Utenti - POLAROID WALL --}}
    <div class="py-16 md:py-24 polaroid-wall-section">
        <livewire:home.new-users-section />
    </div>

    {{-- Decorative Separator --}}
    <div class="py-12 md:py-16 bg-white dark:bg-neutral-900">
        <div class="section-separator"></div>
    </div>

    {{-- Articoli - Newspaper Section --}}
    <div class="py-16 md:py-24 articles-newspaper-section">
        <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
            <div>
                <div class="text-center mb-12 section-title-fade">
                    <h2 class="text-4xl md:text-5xl font-bold mb-3 text-neutral-900 dark:text-white" style="font-family: 'Crimson Pro', serif; text-shadow: 2px 2px 4px rgba(255,255,255,0.8);">
                        {!! __('home.articles_section_title') !!}
                    </h2>
                    <p class="text-lg text-neutral-800 dark:text-neutral-300 font-medium" style="text-shadow: 1px 1px 2px rgba(255,255,255,0.6);">{{ __('home.articles_section_subtitle') }}</p>
                </div>
                <livewire:home.articles-section />
            </div>
        </div>
    </div>

    {{-- Top Gigs - CORK BOARD SECTION --}}
    <div class="py-16 md:py-20 cork-board-section">
        <livewire:home.gigs-section />
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
    </style>
</div>
