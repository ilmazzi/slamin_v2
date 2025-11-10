<div>
    {{-- Hero Carousel --}}
    <livewire:home.hero-carousel />

    {{-- Video/Foto Community - SEZIONE SEPARATA --}}
    <livewire:home.videos-section />

    {{-- Eventi --}}
    <div class="py-16 md:py-20 bg-gradient-to-b from-white via-primary-50/20 to-white dark:from-neutral-900 dark:via-primary-950/10 dark:to-neutral-900">
        <livewire:home.events-slider />
    </div>

    {{-- Top Gigs - CORK BOARD SECTION --}}
    <div class="py-16 md:py-20 cork-board-section">
        <livewire:home.gigs-section />
    </div>

    {{-- Nuovi Poeti --}}
    <div class="py-12 md:py-16 bg-white dark:bg-neutral-900">
        <livewire:home.new-users-section />
    </div>

    {{-- Poesie - WOODEN DESK SECTION --}}
    <div class="py-16 md:py-20 wooden-desk-section">
        <livewire:home.poetry-section />
    </div>

    {{-- Articoli --}}
    <div class="py-16 md:py-20 bg-gradient-to-b from-white via-neutral-50 to-primary-50/20 dark:from-neutral-900 dark:via-neutral-950 dark:to-primary-950/10">
        <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
            <div>
                <div class="text-center mb-12">
                    <h2 class="text-4xl md:text-5xl font-bold mb-3 text-neutral-900 dark:text-white" style="font-family: 'Crimson Pro', serif;">
                        {!! __('home.articles_section_title') !!}
                    </h2>
                    <p class="text-lg text-neutral-600 dark:text-neutral-400">{{ __('home.articles_section_subtitle') }}</p>
                </div>
                <livewire:home.articles-section />
            </div>
        </div>
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
    
    <style>
        @keyframes float-slow { 0%, 100% { transform: translate(0, 0) scale(1); } 50% { transform: translate(30px, -30px) scale(1.1); } }
        .animate-float-slow { animation: float-slow 15s ease-in-out infinite; }
        
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
        
        /* Wooden Desk Background */
        .wooden-desk-section {
            position: relative;
            background: 
                /* Wood grain texture (more visible) */
                url("data:image/svg+xml,%3Csvg width='600' height='600' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='wood'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.015 1.2' numOctaves='6' seed='3' /%3E%3CfeColorMatrix type='saturate' values='0.4'/%3E%3C/filter%3E%3Crect width='600' height='600' filter='url(%23wood)' opacity='0.35'/%3E%3C/svg%3E"),
                /* Horizontal wood grain lines */
                repeating-linear-gradient(
                    180deg,
                    transparent 0px,
                    rgba(90, 70, 50, 0.08) 1px,
                    transparent 2px,
                    transparent 80px
                ),
                /* Fine vertical texture */
                repeating-linear-gradient(
                    90deg,
                    rgba(120, 90, 60, 0.04) 0px,
                    transparent 1px,
                    transparent 3px
                ),
                /* Rich wood color gradient */
                radial-gradient(ellipse at 50% 50%, #d4b896 0%, #c9a87c 20%, #b89968 40%, #a88a5c 60%, #9d7a50 80%, #8f6f48 100%),
                linear-gradient(160deg, #c9a87c 0%, #b89968 25%, #a88a5c 50%, #b89968 75%, #c9a87c 100%);
            box-shadow: 
                inset 0 6px 20px rgba(0, 0, 0, 0.12),
                inset 0 -6px 20px rgba(0, 0, 0, 0.1),
                inset 0 0 80px rgba(120, 90, 60, 0.15);
        }
        
        :is(.dark .wooden-desk-section) {
            background: 
                url("data:image/svg+xml,%3Csvg width='600' height='600' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='wood'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.015 1.2' numOctaves='6' seed='3' /%3E%3CfeColorMatrix type='saturate' values='0.4'/%3E%3C/filter%3E%3Crect width='600' height='600' filter='url(%23wood)' opacity='0.45'/%3E%3C/svg%3E"),
                repeating-linear-gradient(
                    180deg,
                    transparent 0px,
                    rgba(40, 30, 20, 0.15) 1px,
                    transparent 2px,
                    transparent 80px
                ),
                repeating-linear-gradient(
                    90deg,
                    rgba(60, 45, 30, 0.08) 0px,
                    transparent 1px,
                    transparent 3px
                ),
                radial-gradient(ellipse at 50% 50%, #544638 0%, #4a3f32 20%, #3d342a 40%, #352d24 60%, #2d261f 80%, #251f19 100%),
                linear-gradient(160deg, #4a3f32 0%, #3d342a 25%, #352d24 50%, #3d342a 75%, #4a3f32 100%);
            box-shadow: 
                inset 0 6px 20px rgba(0, 0, 0, 0.3),
                inset 0 -6px 20px rgba(0, 0, 0, 0.25),
                inset 0 0 80px rgba(0, 0, 0, 0.4);
        }
    </style>
</div>
