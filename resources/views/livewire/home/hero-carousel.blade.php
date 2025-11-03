<div>
    @if ($carousels && $carousels->count() > 0)
    <section id="hero" class="relative h-screen overflow-hidden"
             x-data="{
                 currentSlide: 0,
                 slides: {{ $carousels->count() }},
                 autoplayInterval: null
             }"
             x-init="
                 autoplayInterval = setInterval(() => {
                     currentSlide = (currentSlide + 1) % slides;
                 }, 8000);
             "
             @mouseenter="clearInterval(autoplayInterval)"
             @mouseleave="autoplayInterval = setInterval(() => { currentSlide = (currentSlide + 1) % slides; }, 8000)">
        
        <!-- Slides -->
        @foreach($carousels as $index => $carousel)
        <div class="absolute inset-0 transition-all duration-1000"
             :class="currentSlide === {{ $index }} ? 'opacity-100 z-10' : 'opacity-0 z-0'">
            
            <!-- Background -->
            <div class="absolute inset-0"
                 x-data
                 :style="`transform: translateY(${scrollY * 0.5}px) scale(1.1)`">
                @if($carousel->video_path && $carousel->videoUrl)
                    <video class="w-full h-full object-cover" autoplay muted loop>
                        <source src="{{ $carousel->videoUrl }}" type="video/mp4">
                    </video>
                @elseif($carousel->image_path && $carousel->imageUrl)
                    <img src="{{ $carousel->imageUrl }}" 
                         alt="{{ $carousel->title }}" 
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-primary-600 to-primary-800"></div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-br from-primary-900/90 via-primary-800/80 to-primary-700/75"></div>
            </div>
            
            <!-- Content -->
            <div class="absolute inset-0 flex items-center justify-center"
                 x-data
                 :style="`transform: translateY(${scrollY * 0.3}px); opacity: ${1 - (scrollY / 600)}`">
                <div class="text-center px-4 md:px-6 max-w-5xl mx-auto text-white"
                     x-show="currentSlide === {{ $index }}"
                     x-transition:enter="transition ease-out duration-700 delay-300"
                     x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100">
                    <h1 class="text-4xl md:text-6xl lg:text-8xl font-bold mb-6 md:mb-8 leading-tight" 
                        style="font-family: 'Crimson Pro', serif;">
                        {!! $carousel->content_title ?? $carousel->title !!}
                    </h1>
                    
                    @if($carousel->content_description ?? $carousel->description)
                    <p class="text-lg md:text-2xl lg:text-3xl font-light mb-8 md:mb-12 text-white/90">
                        {{ $carousel->content_description ?? $carousel->description }}
                    </p>
                    @endif
                    
                    @if($carousel->content_url ?? $carousel->link_url)
                    <x-ui.buttons.primary 
                        :href="$carousel->content_url ?? $carousel->link_url"
                        size="lg"
                        class="animate-bounce-slow">
                        {{ $carousel->link_text ?? 'Scopri di più' }}
                    </x-ui.buttons.primary>
                    @endif
                </div>
            </div>
        </div>
        @endforeach

        <!-- Navigation Arrows (Hidden on mobile) -->
        <button @click="currentSlide = (currentSlide - 1 + slides) % slides"
                class="hidden md:flex absolute left-4 md:left-8 top-1/2 -translate-y-1/2 z-20 w-12 h-12 md:w-14 md:h-14 bg-white/10 backdrop-blur-md border border-white/30 rounded-full items-center justify-center text-white hover:bg-white/20 transition-all duration-300 group">
            <svg class="w-5 h-5 md:w-6 md:h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        
        <button @click="currentSlide = (currentSlide + 1) % slides"
                class="hidden md:flex absolute right-4 md:right-8 top-1/2 -translate-y-1/2 z-20 w-12 h-12 md:w-14 md:h-14 bg-white/10 backdrop-blur-md border border-white/30 rounded-full items-center justify-center text-white hover:bg-white/20 transition-all duration-300 group">
            <svg class="w-5 h-5 md:w-6 md:h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>

        <!-- Slide Indicators -->
        @if($carousels->count() > 1)
        <div class="absolute bottom-16 md:bottom-24 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2 md:gap-3">
            @foreach($carousels as $index => $carousel)
                <button @click="currentSlide = {{ $index }}"
                        class="group relative">
                    <div class="h-1 md:h-1.5 rounded-full bg-white/30 overflow-hidden transition-all duration-300"
                         :class="currentSlide === {{ $index }} ? 'w-12 md:w-16' : 'w-6 md:w-8'">
                        <div x-show="currentSlide === {{ $index }}"
                             class="h-full bg-white"
                             style="animation: progress 8s linear;"></div>
                    </div>
                </button>
            @endforeach
        </div>
        @endif

        <!-- Scroll Indicator -->
        <div class="hidden md:flex absolute bottom-8 left-1/2 -translate-x-1/2 z-20 animate-bounce">
            <div class="flex flex-col items-center gap-2">
                <span class="text-white/80 text-xs md:text-sm font-light tracking-wider">SCROLL</span>
                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </div>
        </div>
    </section>
    
    <style>
        @keyframes progress {
            from { width: 0%; }
            to { width: 100%; }
        }
        
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .animate-bounce-slow {
            animation: bounce-slow 2s ease-in-out infinite;
        }
    </style>
    @endif
</div>
