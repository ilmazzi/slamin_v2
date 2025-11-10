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
        
        /* Wooden Desk Background with REAL IMAGE */
        .wooden-desk-section {
            position: relative;
            background: 
                /* Overlay for text readability */
                linear-gradient(180deg, 
                    rgba(201, 168, 124, 0.85) 0%, 
                    rgba(184, 153, 104, 0.80) 30%,
                    rgba(168, 138, 92, 0.75) 60%,
                    rgba(184, 153, 104, 0.80) 100%
                ),
                /* Wood desk image (placeholder - replace with your image) */
                url('https://images.unsplash.com/photo-1604881991720-f91add269bed?w=1920&q=80&auto=format') center/cover no-repeat,
                /* Fallback color */
                #b89968;
            box-shadow: 
                inset 0 4px 20px rgba(0, 0, 0, 0.15),
                inset 0 -4px 20px rgba(0, 0, 0, 0.1);
        }
        
        :is(.dark .wooden-desk-section) {
            background: 
                linear-gradient(180deg, 
                    rgba(58, 49, 40, 0.90) 0%, 
                    rgba(48, 39, 32, 0.85) 30%,
                    rgba(42, 35, 28, 0.80) 60%,
                    rgba(48, 39, 32, 0.85) 100%
                ),
                url('https://images.unsplash.com/photo-1604881991720-f91add269bed?w=1920&q=80&auto=format') center/cover no-repeat,
                #3a3128;
            box-shadow: 
                inset 0 4px 20px rgba(0, 0, 0, 0.4),
                inset 0 -4px 20px rgba(0, 0, 0, 0.3);
        }
    </style>
</div>
