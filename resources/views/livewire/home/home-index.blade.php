<div>
    {{-- Hero Carousel con Slide Community --}}
    <livewire:home.hero-carousel />

    {{-- Statistiche Flottanti (overlay sul hero) --}}
    <div class="relative -mt-32 z-30">
        <livewire:home.statistics-section />
    </div>

    {{-- Eventi - Design Fluido --}}
    <section class="relative py-20 md:py-32 bg-gradient-to-b from-white via-primary-50/30 to-white dark:from-neutral-950 dark:via-primary-950/20 dark:to-neutral-900 overflow-hidden">
        <livewire:home.events-slider />
    </section>

    {{-- Nuovi Poeti - Seamless --}}
    <section class="relative py-12 md:py-20 bg-white dark:bg-neutral-900">
        <livewire:home.new-users-section />
    </section>

    {{-- Poesie & Articoli - Layout Masonry --}}
    <section class="relative py-20 md:py-32 bg-gradient-to-b from-white via-neutral-50 to-primary-50/30 dark:from-neutral-900 dark:via-neutral-950 dark:to-primary-950/20">
        <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
            {{-- Poesie Highlight --}}
            <div class="mb-16 md:mb-24">
                <div class="text-center mb-12 md:mb-16">
                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 text-neutral-900 dark:text-white" style="font-family: 'Crimson Pro', serif;">
                        Versi della <span class="italic text-primary-600">Community</span>
                    </h2>
                    <p class="text-lg md:text-xl text-neutral-600 dark:text-neutral-400">Le poesie più recenti e amate</p>
                </div>
                <livewire:home.poetry-section />
            </div>

            {{-- Articoli Highlight --}}
            <div>
                <div class="text-center mb-12 md:mb-16">
                    <h2 class="text-4xl md:text-5xl font-bold mb-4 text-neutral-900 dark:text-white" style="font-family: 'Crimson Pro', serif;">
                        Storie & <span class="italic text-primary-600">Riflessioni</span>
                    </h2>
                    <p class="text-lg md:text-xl text-neutral-600 dark:text-neutral-400">Articoli dalla community poetica</p>
                </div>
                <livewire:home.articles-section />
            </div>
        </div>
    </section>

    {{-- CTA Finale Integrato --}}
    <section class="relative py-32 md:py-40 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800" x-data :style="`transform: translateY(${(scrollY - 2000) * 0.4}px)`"></div>
        
        <div class="absolute inset-0 overflow-hidden pointer-events-none opacity-20">
            <div class="absolute w-96 h-96 bg-white/10 rounded-full top-0 right-0 -translate-y-1/2 translate-x-1/2 animate-float-slow"></div>
            <div class="absolute w-64 h-64 bg-white/10 rounded-full bottom-0 left-0 translate-y-1/2 -translate-x-1/2 animate-float-slow" style="animation-delay: 2s;"></div>
        </div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 md:px-6 text-center text-white">
            <h2 class="text-5xl md:text-6xl lg:text-7xl font-bold mb-6 leading-tight" style="font-family: 'Crimson Pro', serif;">
                La tua <span class="italic">voce</span> conta
            </h2>
            <p class="text-xl md:text-2xl mb-10 text-white/90 max-w-2xl mx-auto">
                Unisciti alla community poetica più innovativa d'Italia. Condividi, scopri, connettiti.
            </p>
            <x-ui.buttons.primary href="{{ route('register') }}" size="lg" class="animate-bounce-slow">
                Inizia Gratuitamente →
            </x-ui.buttons.primary>
        </div>
    </section>
    
    <style>
        @keyframes float-slow {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(30px, -30px) scale(1.1); }
        }
        .animate-float-slow { animation: float-slow 15s ease-in-out infinite; }
        @keyframes bounce-slow { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        .animate-bounce-slow { animation: bounce-slow 2s ease-in-out infinite; }
    </style>
</div>
