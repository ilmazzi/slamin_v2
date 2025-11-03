<div>
    {{-- Hero Carousel --}}
    <livewire:home.hero-carousel />

    {{-- Events Slider --}}
    <livewire:home.events-slider />

    {{-- Statistics Section --}}
    <livewire:home.statistics-section />

    {{-- Videos Section --}}
    <livewire:home.videos-section />

    {{-- New Users Section --}}
    <livewire:home.new-users-section />

    {{-- Poetry & Articles Grid --}}
    <section class="py-12 md:py-20 bg-neutral-50 dark:bg-neutral-950">
        <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-8 md:gap-12">
                {{-- Poetry Section --}}
                <div>
                    <livewire:home.poetry-section />
                </div>
                
                {{-- Articles Section --}}
                <div>
                    <livewire:home.articles-section />
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Parallax Section --}}
    <section class="relative py-24 md:py-32 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800"
             x-data
             :style="`transform: translateY(${(scrollY - 2000) * 0.4}px)`">
        </div>

        <!-- Animated Shapes -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none opacity-20">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 md:px-6 text-center text-white">
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 md:mb-6 leading-tight animate-fade-in" style="font-family: 'Crimson Pro', serif;">
                Pronto a condividere<br class="hidden md:block">
                la tua <span class="italic">voce</span>?
            </h2>
            <p class="text-lg md:text-xl mb-8 md:mb-10 text-white/90 animate-fade-in" style="animation-delay: 0.2s">
                Unisciti a migliaia di poeti che hanno già trovato la loro community
            </p>
            <x-ui.buttons.primary 
                href="{{ route('register') }}"
                size="lg"
                class="animate-fade-in"
                style="animation-delay: 0.4s">
                Inizia Gratuitamente
            </x-ui.buttons.primary>
        </div>
    </section>
</div>

<style>
    /* Animated Shapes for CTA */
    .shape {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .shape-1 {
        width: 300px;
        height: 300px;
        top: -100px;
        right: -100px;
        animation: float-shape 25s ease-in-out infinite;
    }

    .shape-2 {
        width: 200px;
        height: 200px;
        bottom: -50px;
        left: -50px;
        animation: float-shape 20s ease-in-out infinite reverse;
    }

    .shape-3 {
        width: 150px;
        height: 150px;
        top: 50%;
        left: 50%;
        animation: float-shape 30s ease-in-out infinite;
    }

    @keyframes float-shape {
        0%, 100% {
            transform: translate(0, 0) rotate(0deg);
        }
        33% {
            transform: translate(50px, -50px) rotate(120deg);
        }
        66% {
            transform: translate(-30px, 30px) rotate(240deg);
        }
    }
    
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fade-in {
        animation: fade-in 0.8s ease-out forwards;
    }
</style>
