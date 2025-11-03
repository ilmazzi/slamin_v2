<x-layouts.parallax>
    <x-slot name="title">Poetry Social - Enhanced</x-slot>

    <!-- Hero Slider Enhanced -->
    <section id="hero" class="relative h-screen overflow-hidden"
             x-data="{
                 currentSlide: 0,
                 slides: [
                     {
                         type: 'image',
                         image: 'https://images.unsplash.com/photo-1455390582262-044cdead277a?w=1920&q=80',
                         title: 'Condividi i tuoi <span class=\'italic text-primary-300\'>versi</span>',
                         subtitle: 'La community poetica più innovativa d\'Italia',
                         cta: 'Inizia Ora',
                         gradient: 'from-primary-900/90 via-primary-800/80 to-primary-700/70'
                     },
                     {
                         type: 'user_content',
                         title: 'La Voce della <span class=\'italic text-primary-200\'>Community</span>',
                         subtitle: 'Migliaia di poeti, un\'unica passione',
                         cta: 'Esplora',
                         gradient: 'from-primary-800/85 via-primary-700/75 to-primary-600/70'
                     },
                     {
                         type: 'image',
                         image: 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=1920&q=80',
                         title: '<span class=\'italic text-primary-300\'>Eventi</span> dal Vivo',
                         subtitle: 'Poetry slam, workshop e reading in tutta Italia',
                         cta: 'Scopri Eventi',
                         gradient: 'from-primary-900/90 via-primary-700/80 to-primary-600/70'
                     },
                     {
                         type: 'image',
                         image: 'https://images.unsplash.com/photo-1519682337058-a94d519337bc?w=1920&q=80',
                         title: 'La tua <span class=\'italic text-primary-300\'>voce</span> conta',
                         subtitle: 'Pubblica, condividi, connettiti',
                         cta: 'Unisciti',
                         gradient: 'from-primary-900/90 via-primary-800/80 to-primary-700/75'
                     }
                 ],
                 autoplayInterval: null
             }"
             x-init="
                 autoplayInterval = setInterval(() => {
                     currentSlide = (currentSlide + 1) % slides.length;
                 }, 8000);
             "
             @mouseenter="clearInterval(autoplayInterval)"
             @mouseleave="autoplayInterval = setInterval(() => { currentSlide = (currentSlide + 1) % slides.length; }, 8000)">
        
        <!-- Slides -->
        <template x-for="(slide, index) in slides" :key="index">
            <div class="absolute inset-0 transition-all duration-1000"
                 :class="currentSlide === index ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                
                <!-- Image Slide -->
                <template x-if="slide.type === 'image'">
                    <div class="absolute inset-0">
                        <!-- Parallax Background -->
                        <div class="absolute inset-0"
                             x-data
                             :style="`transform: translateY(${scrollY * 0.5}px) scale(1.1)`">
                            <img :src="slide.image" 
                                 alt="Hero" 
                                 class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-br"
                                 :class="slide.gradient"></div>
                        </div>
                        
                        <!-- Content -->
                        <div class="absolute inset-0 flex items-center justify-center"
                             x-data
                             :style="`transform: translateY(${scrollY * 0.3}px); opacity: ${1 - (scrollY / 600)}`">
                            <div class="text-center px-6 max-w-5xl mx-auto text-white"
                                 x-show="currentSlide === index"
                                 x-transition:enter="transition ease-out duration-700 delay-300"
                                 x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                                 x-transition:enter-end="opacity-100 translate-y-0 scale-100">
                                <h1 class="text-5xl md:text-6xl lg:text-8xl font-bold mb-6 md:mb-8 leading-tight" 
                                    style="font-family: 'Crimson Pro', serif;"
                                    x-html="slide.title"></h1>
                                <p class="text-xl md:text-2xl lg:text-3xl font-light mb-8 md:mb-12 text-white/90"
                                   x-text="slide.subtitle"></p>
                                <button class="px-8 md:px-10 py-4 md:py-5 bg-white text-primary-700 rounded-2xl font-bold text-base md:text-lg hover:shadow-2xl hover:scale-105 transition-all duration-300 animate-bounce-slow">
                                    <span x-text="slide.cta"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- User Content Slide (Video & Photos Grid) -->
                <template x-if="slide.type === 'user_content'">
                    <div class="absolute inset-0">
                        <!-- Animated Background Gradient -->
                        <div class="absolute inset-0 bg-gradient-to-br animate-gradient-shift"
                             :class="slide.gradient"></div>
                        
                        <!-- Floating Particles Animation -->
                        <div class="absolute inset-0 overflow-hidden pointer-events-none">
                            <div class="particle particle-1"></div>
                            <div class="particle particle-2"></div>
                            <div class="particle particle-3"></div>
                        </div>
                        
                        <!-- Content Grid -->
                        <div class="absolute inset-0 flex items-center justify-center p-4 md:p-8"
                             x-show="currentSlide === index"
                             x-transition:enter="transition ease-out duration-700 delay-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100">
                            
                            <div class="w-full max-w-7xl mx-auto">
                                <!-- Title -->
                                <div class="text-center mb-8 md:mb-12">
                                    <h1 class="text-4xl md:text-5xl lg:text-7xl font-bold mb-4 md:mb-6 text-white leading-tight" 
                                        style="font-family: 'Crimson Pro', serif;"
                                        x-html="slide.title"></h1>
                                    <p class="text-lg md:text-xl lg:text-2xl font-light text-white/90"
                                       x-text="slide.subtitle"></p>
                                </div>

                                <!-- Bento Grid (Video + Photos) -->
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-2 md:gap-4 max-w-6xl mx-auto">
                                    <!-- Large Video (Mobile: full width, Desktop: 2 cols) -->
                                    <div class="col-span-2 row-span-2 rounded-2xl md:rounded-3xl overflow-hidden shadow-2xl group animate-fade-in-up"
                                         style="animation-delay: 0.1s">
                                        <div class="relative h-64 md:h-96 bg-primary-900/20 backdrop-blur-sm">
                                            <!-- Video Placeholder -->
                                            <img src="https://images.unsplash.com/photo-1�504805572947-34fad45aed93?w=600&q=80" 
                                                 alt="User video" 
                                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                            
                                            <!-- Play Button -->
                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <div class="w-16 h-16 md:w-20 md:h-20 bg-white/90 rounded-full flex items-center justify-center group-hover:scale-110 transition-all shadow-xl">
                                                    <svg class="w-8 h-8 md:w-10 md:h-10 text-primary-600 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M8 5v14l11-7z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            
                                            <div class="absolute bottom-0 left-0 right-0 p-3 md:p-4">
                                                <p class="text-white font-semibold text-sm md:text-base">Reading di @MarcoPoeta</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Photo Grid Items -->
                                    @php
                                        $userPhotos = [
                                            'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400&q=80',
                                            'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&q=80',
                                            'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=400&q=80',
                                            'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&q=80',
                                            'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=400&q=80',
                                            'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=400&q=80',
                                        ];
                                        $userNames = ['@sofia', '@luca', '@elena', '@andrea', '@giulia', '@paolo'];
                                    @endphp
                                    
                                    @foreach($userPhotos as $i => $photo)
                                    <div class="rounded-xl md:rounded-2xl overflow-hidden shadow-lg group animate-fade-in-up"
                                         style="animation-delay: {{ ($i + 1) * 0.1 }}s">
                                        <div class="relative aspect-square bg-primary-900/20">
                                            <img src="{{ $photo }}" 
                                                 alt="User {{ $i }}" 
                                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                            <div class="absolute bottom-0 left-0 right-0 p-2 md:p-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                <p class="text-white text-xs md:text-sm font-semibold">{{ $userNames[$i] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <!-- CTA Button -->
                                <div class="text-center mt-8 md:mt-12">
                                    <button class="px-8 md:px-10 py-4 md:py-5 bg-white text-primary-700 rounded-2xl font-bold text-base md:text-lg hover:shadow-2xl hover:scale-105 transition-all duration-300">
                                        <span x-text="slide.cta"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </template>

        <!-- Navigation Arrows (Hidden on mobile) -->
        <button @click="currentSlide = (currentSlide - 1 + slides.length) % slides.length"
                class="hidden md:flex absolute left-4 md:left-8 top-1/2 -translate-y-1/2 z-20 w-12 h-12 md:w-14 md:h-14 bg-white/10 backdrop-blur-md border border-white/30 rounded-full items-center justify-center text-white hover:bg-white/20 transition-all duration-300 group">
            <svg class="w-5 h-5 md:w-6 md:h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        
        <button @click="currentSlide = (currentSlide + 1) % slides.length"
                class="hidden md:flex absolute right-4 md:right-8 top-1/2 -translate-y-1/2 z-20 w-12 h-12 md:w-14 md:h-14 bg-white/10 backdrop-blur-md border border-white/30 rounded-full items-center justify-center text-white hover:bg-white/20 transition-all duration-300 group">
            <svg class="w-5 h-5 md:w-6 md:h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>

        <!-- Slide Indicators (Mobile-friendly) -->
        <div class="absolute bottom-16 md:bottom-24 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2 md:gap-3">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="currentSlide = index"
                        class="group relative">
                    <div class="h-1 md:h-1.5 rounded-full bg-white/30 overflow-hidden transition-all duration-300"
                         :class="currentSlide === index ? 'w-12 md:w-16' : 'w-6 md:w-8'">
                        <div x-show="currentSlide === index"
                             class="h-full bg-white"
                             style="animation: progress 8s linear;"></div>
                    </div>
                </button>
            </template>
        </div>

        <!-- Scroll Indicator (Hidden on mobile) -->
        <div class="hidden md:flex absolute bottom-8 left-1/2 -translate-x-1/2 z-20 animate-bounce">
            <div class="flex flex-col items-center gap-2">
                <span class="text-white/80 text-xs md:text-sm font-light tracking-wider">SCROLL</span>
                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </div>
        </div>
    </section>

    <!-- Animated Stats Section -->
    <section class="py-12 md:py-20 bg-white dark:bg-neutral-950">
        <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
                @foreach([
                    ['number' => '10k+', 'label' => 'Poeti', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                    ['number' => '50k+', 'label' => 'Poesie', 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
                    ['number' => '200+', 'label' => 'Eventi', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                    ['number' => '95%', 'label' => 'Soddisfazione', 'icon' => 'M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5']
                ] as $i => $stat)
                <div class="text-center group"
                     x-data="{ count: 0, target: {{ (int)filter_var($stat['number'], FILTER_SANITIZE_NUMBER_INT) }}, started: false }"
                     x-intersect.once="started = true; 
                         let duration = 2000;
                         let start = Date.now();
                         let animate = () => {
                             let now = Date.now();
                             let progress = Math.min((now - start) / duration, 1);
                             count = Math.floor(progress * target);
                             if (progress < 1) requestAnimationFrame(animate);
                         };
                         animate();">
                    <div class="inline-flex items-center justify-center w-16 h-16 md:w-20 md:h-20 bg-primary-100 dark:bg-primary-900/30 rounded-2xl md:rounded-3xl mb-3 md:mb-4 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <svg class="w-8 h-8 md:w-10 md:h-10 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/>
                        </svg>
                    </div>
                    <div class="text-3xl md:text-4xl lg:text-5xl font-bold text-primary-700 dark:text-primary-400 mb-1 md:mb-2">
                        <span x-text="count.toLocaleString()"></span><span>{{ str_contains($stat['number'], 'k') ? 'k' : '' }}{{ str_contains($stat['number'], '%') ? '%' : '' }}{{ str_contains($stat['number'], '+') ? '+' : '' }}</span>
                    </div>
                    <div class="text-sm md:text-base text-neutral-600 dark:text-neutral-400 font-medium">{{ $stat['label'] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Mobile-Optimized Feed Section -->
    <section id="feed" class="py-12 md:py-20 bg-neutral-50 dark:bg-neutral-950">
        <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="mb-8 md:mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-neutral-900 dark:text-white mb-2">Il Tuo Feed</h2>
                <p class="text-neutral-600 dark:text-neutral-400">Gli ultimi versi dalla community</p>
            </div>

            <!-- Feed Posts (Stack on Mobile, Grid on Desktop) -->
            <div class="space-y-6">
                @for($i = 1; $i <= 3; $i++)
                <article class="group bg-white dark:bg-neutral-900 rounded-2xl md:rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500"
                         x-data
                         x-intersect.half="$el.classList.add('animate-slide-up')">
                    <!-- Post Header -->
                    <div class="flex items-center justify-between p-4 md:p-6">
                        <div class="flex items-center gap-3">
                            <img src="https://i.pravatar.cc/150?img={{ $i }}" 
                                 alt="Avatar" 
                                 class="w-10 h-10 md:w-12 md:h-12 rounded-full object-cover ring-2 ring-primary-200 dark:ring-primary-900">
                            <div>
                                <div class="font-semibold text-sm md:text-base text-neutral-900 dark:text-white">{{ ['Alessandro Manzoni', 'Laura Bianchi', 'Marco Rossi'][$i-1] }}</div>
                                <div class="text-xs md:text-sm text-neutral-500 dark:text-neutral-400">{{ $i }}h fa</div>
                            </div>
                        </div>
                    </div>

                    <!-- Post Image (if applicable) -->
                    @if($i % 2 == 0)
                    <div class="relative aspect-[4/3] overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=800&q=80" 
                             alt="Post" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    </div>
                    @endif

                    <!-- Post Content -->
                    <div class="p-4 md:p-6">
                        <h3 class="text-lg md:text-xl font-semibold text-neutral-900 dark:text-white mb-3" style="font-family: 'Crimson Pro', serif;">
                            "{{ ['Sussurri del Vento', 'Nel Silenzio', 'Danza di Stelle'][$i-1] }}"
                        </h3>
                        <p class="text-sm md:text-base leading-relaxed text-neutral-700 dark:text-neutral-300 italic line-clamp-3">
                            Nel vento che sussurra antiche storie, trovo la forza di continuare a sognare...
                        </p>
                    </div>

                    <!-- Post Actions (Mobile-optimized) -->
                    <div class="px-4 md:px-6 pb-4 md:pb-6 flex items-center justify-between border-t border-neutral-100 dark:border-neutral-800 pt-4">
                        <div class="flex items-center gap-4 md:gap-6">
                            <button class="flex items-center gap-1.5 md:gap-2 text-neutral-600 dark:text-neutral-400 hover:text-primary-600 transition-colors">
                                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                <span class="text-sm md:text-base font-semibold">{{ rand(20, 150) }}</span>
                            </button>
                            <button class="flex items-center gap-1.5 md:gap-2 text-neutral-600 dark:text-neutral-400 hover:text-primary-600 transition-colors">
                                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                                <span class="text-sm md:text-base font-semibold">{{ rand(5, 40) }}</span>
                            </button>
                        </div>
                        <button class="text-neutral-600 dark:text-neutral-400 hover:text-primary-600 transition-colors">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                            </svg>
                        </button>
                    </div>
                </article>
                @endfor
            </div>
        </div>
    </section>

    <!-- Events Section (Mobile-optimized) -->
    <section id="events" class="py-12 md:py-20 bg-white dark:bg-neutral-900">
        <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 md:mb-12 gap-4">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-neutral-900 dark:text-white mb-2">Eventi in Arrivo</h2>
                    <p class="text-neutral-600 dark:text-neutral-400">Non perdere i prossimi appuntamenti poetici</p>
                </div>
                <a href="#" class="text-primary-600 hover:text-primary-700 font-medium flex items-center gap-2 group self-start md:self-auto">
                    Vedi tutti
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <!-- Events Grid (Stack on Mobile, Grid on Desktop) -->
            <div class="space-y-6 md:space-y-0 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-6">
                @php
                    $eventImages = [
                        'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=800&q=80',
                        'https://images.unsplash.com/photo-1475721027785-f74eccf877e2?w=800&q=80',
                        'https://images.unsplash.com/photo-1471922694854-ff1b63b20054?w=800&q=80'
                    ];
                    $eventTitles = [
                        'Notte di Versi Liberi',
                        'Workshop di Scrittura Creativa',
                        'Reading Poetico al Tramonto'
                    ];
                    $eventDescriptions = [
                        'Un evento imperdibile per tutti gli amanti della poesia contemporanea.',
                        'Impara le tecniche dei grandi poeti in un workshop interattivo.',
                        'Un pomeriggio di letture poetiche in un\'atmosfera magica.'
                    ];
                    $eventTypes = ['Poetry Slam', 'Workshop', 'Reading'];
                    $eventLocations = ['Milano', 'Roma', 'Firenze'];
                @endphp
                
                @for($i = 1; $i <= 3; $i++)
                <article class="group cursor-pointer overflow-hidden rounded-2xl md:rounded-3xl bg-white dark:bg-neutral-800 shadow-lg hover:shadow-2xl transition-all duration-500"
                         x-data="{ hovered: false }"
                         @mouseenter="hovered = true"
                         @mouseleave="hovered = false"
                         x-intersect.half="$el.classList.add('animate-slide-up')"
                         style="animation-delay: {{ $i * 0.1 }}s">
                    
                    <!-- Event Image -->
                    <div class="relative h-56 md:h-64 overflow-hidden">
                        <img src="{{ $eventImages[$i-1] }}" 
                             alt="Event" 
                             class="w-full h-full object-cover transition-transform duration-700"
                             :class="hovered && 'scale-110'">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
                        
                        <!-- Date Badge (Top Left) -->
                        <div class="absolute top-4 left-4 bg-white/95 backdrop-blur-md px-4 py-3 rounded-xl shadow-lg transition-transform duration-300"
                             :class="hovered && 'scale-110'">
                            <div class="text-2xl md:text-3xl font-bold text-primary-700">{{ now()->addDays($i * 5)->format('d') }}</div>
                            <div class="text-xs md:text-sm text-neutral-600 font-medium uppercase">{{ now()->addDays($i * 5)->format('M') }}</div>
                        </div>

                        <!-- Category Badge (Top Right) -->
                        <div class="absolute top-4 right-4 transition-transform duration-300"
                             :class="hovered && 'scale-110'">
                            <span class="px-3 md:px-4 py-1.5 md:py-2 bg-primary-600 text-white rounded-full text-xs font-bold uppercase tracking-wider shadow-lg">
                                {{ $eventTypes[$i-1] }}
                            </span>
                        </div>

                        <!-- Event Title & Quick Info (Overlay on Image) -->
                        <div class="absolute bottom-0 left-0 right-0 p-4 md:p-6 text-white">
                            <h3 class="text-xl md:text-2xl font-bold mb-2 line-clamp-2" style="font-family: 'Crimson Pro', serif;">
                                {{ $eventTitles[$i-1] }}
                            </h3>
                            <div class="flex items-center gap-2 text-white/90 text-sm mb-3">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                                <span>{{ $eventLocations[$i % 3] }}</span>
                                <span class="mx-2">•</span>
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ ['19:00', '15:00', '18:30'][$i-1] }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Event Details (Below Image) -->
                    <div class="p-4 md:p-6">
                        <p class="text-sm md:text-base text-neutral-600 dark:text-neutral-400 mb-4 line-clamp-2">
                            {{ $eventDescriptions[$i-1] }}
                        </p>
                        
                        <!-- Attendees Preview -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="flex -space-x-2">
                                    @for($j = 0; $j < 4; $j++)
                                    <img src="https://i.pravatar.cc/150?img={{ ($i * 10) + $j }}" 
                                         alt="Attendee" 
                                         class="w-8 h-8 rounded-full border-2 border-white dark:border-neutral-800 object-cover">
                                    @endfor
                                </div>
                                <span class="text-xs md:text-sm text-neutral-600 dark:text-neutral-400 font-medium">
                                    +{{ rand(20, 80) }} partecipanti
                                </span>
                            </div>
                            
                            <button class="px-4 md:px-6 py-2 md:py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-full font-bold text-sm transition-all duration-300 hover:scale-105 shadow-md">
                                Partecipa
                            </button>
                        </div>
                    </div>
                </article>
                @endfor
            </div>
        </div>
    </section>

    <!-- CTA Parallax (Mobile-optimized) -->
    <section class="relative py-24 md:py-32 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800"
             x-data
             :style="`transform: translateY(${(scrollY - 1000) * 0.4}px)`">
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
            <button class="px-8 md:px-10 py-4 md:py-5 bg-white text-primary-700 rounded-xl md:rounded-2xl font-bold text-base md:text-lg hover:shadow-2xl hover:scale-105 transition-all duration-300 animate-fade-in"
                    style="animation-delay: 0.4s">
                Inizia Gratuitamente
            </button>
        </div>
    </section>

    <style>
        @keyframes progress {
            from { width: 0%; }
            to { width: 100%; }
        }

        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.6s ease-out forwards;
            opacity: 0;
        }

        @keyframes slide-up {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-up {
            animation: slide-up 0.8s ease-out forwards;
        }

        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .animate-gradient-shift {
            background-size: 200% 200%;
            animation: gradient-shift 15s ease infinite;
        }

        @keyframes bounce-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .animate-bounce-slow {
            animation: bounce-slow 2s ease-in-out infinite;
        }

        /* Floating Particles */
        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            animation: float 20s ease-in-out infinite;
        }

        .particle-1 {
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .particle-2 {
            top: 60%;
            right: 20%;
            animation-delay: 7s;
        }

        .particle-3 {
            bottom: 30%;
            left: 30%;
            animation-delay: 14s;
        }

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) scale(1);
                opacity: 0;
            }
            10% {
                opacity: 0.8;
            }
            50% {
                transform: translate(100px, -100px) scale(2);
                opacity: 0.5;
            }
            90% {
                opacity: 0.8;
            }
        }

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

        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Mobile optimizations */
        @media (max-width: 768px) {
            .line-clamp-3 {
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
        }
    </style>
</x-layouts.parallax>

