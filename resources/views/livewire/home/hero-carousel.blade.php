<div>
    @php
    $carouselSlides = $carousels ?? collect();
    $recentUsers = \App\Models\User::whereNotNull('profile_photo')->latest()->limit(7)->get();
    @endphp
    
    @if ($carouselSlides->count() > 0 || $recentUsers->count() > 0)
    <section id="hero" class="relative h-screen overflow-hidden"
             x-data="{
                 currentSlide: 0,
                 slides: {{ $carouselSlides->count() + 1 }},
                 autoplayInterval: null
             }"
             x-init="
                 autoplayInterval = setInterval(() => {
                     currentSlide = (currentSlide + 1) % slides;
                 }, 8000);
             "
             @mouseenter="clearInterval(autoplayInterval)"
             @mouseleave="autoplayInterval = setInterval(() => { currentSlide = (currentSlide + 1) % slides; }, 8000)">
        
        <!-- Slides Database -->
        @foreach($carouselSlides as $index => $carousel)
        <div class="absolute inset-0 transition-all duration-1000"
             :class="currentSlide === {{ $index }} ? 'opacity-100 z-10' : 'opacity-0 z-0'">
            
            <div class="absolute inset-0" x-data :style="`transform: translateY(${scrollY * 0.5}px) scale(1.1)`">
                @if($carousel->video_path && $carousel->videoUrl)
                    <video class="w-full h-full object-cover" autoplay muted loop playsinline>
                        <source src="{{ $carousel->videoUrl }}" type="video/mp4">
                    </video>
                @elseif($carousel->image_path && $carousel->imageUrl)
                    <img src="{{ $carousel->imageUrl }}" alt="{{ $carousel->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-primary-600 to-primary-800"></div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-br from-primary-900/90 via-primary-800/80 to-primary-700/75"></div>
            </div>
            
            <div class="absolute inset-0 flex items-center justify-center" x-data :style="`transform: translateY(${scrollY * 0.3}px); opacity: ${1 - (scrollY / 600)}`">
                <div class="text-center px-4 md:px-6 max-w-5xl mx-auto text-white"
                     x-show="currentSlide === {{ $index }}"
                     x-transition:enter="transition ease-out duration-700 delay-300"
                     x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100">
                    <h1 class="text-4xl md:text-6xl lg:text-8xl font-bold mb-6 md:mb-8 leading-tight" style="font-family: 'Crimson Pro', serif;">
                        {!! $carousel->content_title ?? $carousel->title !!}
                    </h1>
                    @if($carousel->content_description ?? $carousel->description)
                    <p class="text-lg md:text-2xl lg:text-3xl font-light mb-8 md:mb-12 text-white/90">
                        {{ $carousel->content_description ?? $carousel->description }}
                    </p>
                    @endif
                    @if($carousel->content_url ?? $carousel->link_url)
                    <x-ui.buttons.primary :href="$carousel->content_url ?? $carousel->link_url" size="lg" class="animate-bounce-slow">
                        {{ $carousel->link_text ?? 'Scopri di più' }}
                    </x-ui.buttons.primary>
                    @endif
                </div>
            </div>
        </div>
        @endforeach

        <!-- Slide Community (Video/Foto Utenti) -->
        @if($recentUsers->count() > 0)
        <div class="absolute inset-0 transition-all duration-1000"
             :class="currentSlide === {{ $carouselSlides->count() }} ? 'opacity-100 z-10' : 'opacity-0 z-0'">
            
            <div class="absolute inset-0 bg-gradient-to-br from-primary-800/85 via-primary-700/75 to-primary-600/70 animate-gradient-shift"></div>
            
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="particle particle-1"></div>
                <div class="particle particle-2"></div>
                <div class="particle particle-3"></div>
            </div>
            
            <div class="absolute inset-0 flex items-center justify-center p-4 md:p-8"
                 x-show="currentSlide === {{ $carouselSlides->count() }}"
                 x-transition:enter="transition ease-out duration-700 delay-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100">
                
                <div class="w-full max-w-7xl mx-auto">
                    <div class="text-center mb-8 md:mb-12">
                        <h1 class="text-4xl md:text-5xl lg:text-7xl font-bold mb-4 md:mb-6 text-white leading-tight" style="font-family: 'Crimson Pro', serif;">
                            La Voce della <span class="italic text-primary-200">Community</span>
                        </h1>
                        <p class="text-lg md:text-xl lg:text-2xl font-light text-white/90">
                            Migliaia di poeti, un'unica passione
                        </p>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 md:gap-4 max-w-6xl mx-auto">
                        @foreach($recentUsers as $i => $user)
                        <div class="rounded-xl md:rounded-2xl overflow-hidden shadow-2xl group animate-fade-in-up bg-white/5 backdrop-blur-sm"
                             style="animation-delay: {{ $i * 0.1 }}s">
                            <div class="relative aspect-square">
                                <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-2 md:p-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <p class="text-white text-xs md:text-sm font-semibold truncate">{{ $user->name }}</p>
                                    <p class="text-white/80 text-xs">{{ $user->poems()->count() }} poesie</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="text-center mt-8 md:mt-12">
                        <x-ui.buttons.primary href="#" size="lg">Esplora la Community</x-ui.buttons.primary>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Navigation & Indicators -->
        @if($carouselSlides->count() + 1 > 1)
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

        <div class="absolute bottom-16 md:bottom-24 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2 md:gap-3">
            @for($i = 0; $i < $carouselSlides->count() + 1; $i++)
                <button @click="currentSlide = {{ $i }}" class="group relative">
                    <div class="h-1 md:h-1.5 rounded-full bg-white/30 overflow-hidden transition-all duration-300"
                         :class="currentSlide === {{ $i }} ? 'w-12 md:w-16' : 'w-6 md:w-8'">
                        <div x-show="currentSlide === {{ $i }}" class="h-full bg-white" style="animation: progress 8s linear;"></div>
                    </div>
                </button>
            @endfor
        </div>
        @endif

        <div class="hidden md:flex absolute bottom-8 left-1/2 -translate-x-1/2 z-20 animate-bounce">
            <div class="flex flex-col items-center gap-2">
                <span class="text-white/80 text-xs md:text-sm font-light tracking-wider">SCROLL</span>
                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </div>
        </div>
    </section>
    @endif
    
    <style>
        @keyframes progress { from { width: 0%; } to { width: 100%; } }
        @keyframes bounce-slow { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        .animate-bounce-slow { animation: bounce-slow 2s ease-in-out infinite; }
        @keyframes gradient-shift { 0%, 100% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } }
        .animate-gradient-shift { background-size: 200% 200%; animation: gradient-shift 15s ease infinite; }
        .particle { position: absolute; width: 4px; height: 4px; background: rgba(255, 255, 255, 0.3); border-radius: 50%; animation: float 20s ease-in-out infinite; }
        .particle-1 { top: 20%; left: 10%; animation-delay: 0s; }
        .particle-2 { top: 60%; right: 20%; animation-delay: 7s; }
        .particle-3 { bottom: 30%; left: 30%; animation-delay: 14s; }
        @keyframes float { 0%, 100% { transform: translate(0, 0) scale(1); opacity: 0; } 10% { opacity: 0.8; } 50% { transform: translate(100px, -100px) scale(2); opacity: 0.5; } 90% { opacity: 0.8; } }
        @keyframes fade-in-up { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in-up { animation: fade-in-up 0.6s ease-out forwards; opacity: 0; }
    </style>
</div>
