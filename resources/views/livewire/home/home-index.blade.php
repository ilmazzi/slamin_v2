<div>
    {{-- Statistiche Compatte Sotto Nav --}}
    <div class="relative z-40 pt-16 md:pt-20">
        <livewire:home.statistics-section />
    </div>

    {{-- Hero Carousel --}}
    <livewire:home.hero-carousel />

    {{-- Video/Foto Community - SEZIONE SEPARATA --}}
    <livewire:home.videos-section />

    {{-- Eventi --}}
    <div class="py-16 md:py-20 bg-gradient-to-b from-white via-primary-50/20 to-white dark:from-neutral-900 dark:via-primary-950/10 dark:to-neutral-900">
        <livewire:home.events-slider />
    </div>

    {{-- Nuovi Poeti --}}
    <div class="py-12 md:py-16 bg-white dark:bg-neutral-900">
        <livewire:home.new-users-section />
    </div>

    {{-- Poesie & Articoli --}}
    <div class="py-16 md:py-20 bg-gradient-to-b from-white via-neutral-50 to-primary-50/20 dark:from-neutral-900 dark:via-neutral-950 dark:to-primary-950/10">
        <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
            {{-- Poesie --}}
            <div class="mb-20">
                <div class="text-center mb-12">
                    <h2 class="text-4xl md:text-5xl font-bold mb-3 text-neutral-900 dark:text-white" style="font-family: 'Crimson Pro', serif;">
                        Versi della <span class="italic text-primary-600">Community</span>
                    </h2>
                    <p class="text-lg text-neutral-600 dark:text-neutral-400">Le poesie più recenti e amate</p>
                </div>
                <livewire:home.poetry-section />
            </div>

            {{-- Articoli --}}
            <div>
                <div class="text-center mb-12">
                    <h2 class="text-4xl md:text-5xl font-bold mb-3 text-neutral-900 dark:text-white" style="font-family: 'Crimson Pro', serif;">
                        Storie & <span class="italic text-primary-600">Riflessioni</span>
                    </h2>
                    <p class="text-lg text-neutral-600 dark:text-neutral-400">Articoli dalla community poetica</p>
                </div>
                <livewire:home.articles-section />
            </div>
        </div>
    </div>

    {{-- CTA Finale --}}
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
                La tua <span class="italic">voce</span> conta
            </h2>
            <p class="text-xl md:text-2xl mb-10 text-white max-w-2xl mx-auto">
                Unisciti alla community poetica più innovativa d'Italia
            </p>
            <x-ui.buttons.primary href="{{ route('register') }}" size="lg">
                Inizia Gratuitamente →
            </x-ui.buttons.primary>
        </div>
    </section>
    
    <style>
        @keyframes float-slow { 0%, 100% { transform: translate(0, 0) scale(1); } 50% { transform: translate(30px, -30px) scale(1.1); } }
        .animate-float-slow { animation: float-slow 15s ease-in-out infinite; }
    </style>
</div>
