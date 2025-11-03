<div>
    @if ($carousels && $carousels->count() > 0)
    <section id="hero" class="relative h-[70vh] md:h-screen overflow-hidden">
        <!-- Carousel Background -->
        <div class="absolute inset-0">
            @if($carousels->first()->video_path && $carousels->first()->videoUrl)
                <video class="w-full h-full object-cover" autoplay muted loop>
                    <source src="{{ $carousels->first()->videoUrl }}" type="video/mp4">
                </video>
            @elseif($carousels->first()->image_path && $carousels->first()->imageUrl)
                <img src="{{ $carousels->first()->imageUrl }}" 
                     alt="{{ $carousels->first()->title }}" 
                     class="w-full h-full object-cover">
            @endif
            <div class="absolute inset-0 bg-gradient-to-br from-primary-900/90 via-primary-800/80 to-primary-700/75"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative z-10 h-full flex items-center justify-center">
            <div class="max-w-5xl mx-auto px-4 md:px-6 text-center text-white">
                <h1 class="text-4xl md:text-6xl lg:text-8xl font-bold mb-6 md:mb-8 leading-tight animate-fade-in" 
                    style="font-family: 'Crimson Pro', serif;">
                    {!! $carousels->first()->content_title ?? $carousels->first()->title !!}
                </h1>
                
                @if($carousels->first()->content_description ?? $carousels->first()->description)
                <p class="text-lg md:text-2xl lg:text-3xl font-light mb-8 md:mb-12 text-white/90 animate-fade-in" 
                   style="animation-delay: 0.2s">
                    {{ $carousels->first()->content_description ?? $carousels->first()->description }}
                </p>
                @endif
                
                @if($carousels->first()->content_url ?? $carousels->first()->link_url)
                <div class="animate-fade-in" style="animation-delay: 0.4s">
                    <x-ui.buttons.primary 
                        :href="$carousels->first()->content_url ?? $carousels->first()->link_url"
                        size="lg"
                        icon="M9 5l7 7-7 7">
                        {{ $carousels->first()->link_text ?? __('home.hero_carousel.view') }}
                    </x-ui.buttons.primary>
                </div>
                @endif
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-20 animate-bounce hidden md:flex flex-col items-center gap-2">
            <span class="text-white/80 text-xs md:text-sm font-light tracking-wider">SCROLL</span>
            <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
    </section>
    @endif
</div>
