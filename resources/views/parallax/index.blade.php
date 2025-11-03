<x-layouts.parallax>
    <x-slot name="title">Poetry Social</x-slot>

    <!-- Hero Slider -->
    <section id="hero" class="relative h-screen overflow-hidden"
             x-data="{
                 currentSlide: 0,
                slides: [
                    {
                        image: 'https://images.unsplash.com/photo-1455390582262-044cdead277a?w=1920&q=80',
                        title: 'Condividi i tuoi <span class=\'italic text-primary-300\'>versi</span><br>con il mondo',
                        subtitle: 'La community poetica più innovativa d\'Italia',
                        gradient: 'from-primary-900/80 via-primary-800/70 to-primary-700/80'
                    },
                    {
                        image: 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=1920&q=80',
                        title: 'Scopri <span class=\'italic text-primary-200\'>poeti</span><br>straordinari',
                        subtitle: 'Connettiti con migliaia di appassionati di poesia',
                        gradient: 'from-primary-800/80 via-primary-700/70 to-primary-600/80'
                    },
                    {
                        image: 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=1920&q=80',
                        title: 'Partecipa agli <span class=\'italic text-primary-300\'>eventi</span><br>dal vivo',
                        subtitle: 'Poetry slam, workshop e reading in tutta Italia',
                        gradient: 'from-primary-900/80 via-primary-700/70 to-primary-600/80'
                    },
                    {
                        image: 'https://images.unsplash.com/photo-1519682337058-a94d519337bc?w=1920&q=80',
                        title: 'La tua <span class=\'italic text-primary-300\'>voce</span><br>merita di essere ascoltata',
                        subtitle: 'Pubblica le tue poesie e ricevi feedback dalla community',
                        gradient: 'from-primary-900/80 via-primary-800/70 to-primary-700/80'
                    }
                ],
                 autoplayInterval: null
             }"
             x-init="
                 autoplayInterval = setInterval(() => {
                     currentSlide = (currentSlide + 1) % slides.length;
                 }, 7000);
             "
             @mouseenter="clearInterval(autoplayInterval)"
             @mouseleave="autoplayInterval = setInterval(() => { currentSlide = (currentSlide + 1) % slides.length; }, 7000)">
        
        <!-- Slides -->
        <template x-for="(slide, index) in slides" :key="index">
            <div class="absolute inset-0 transition-opacity duration-1000"
                 :class="currentSlide === index ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                <!-- Parallax Background Image -->
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
                         x-transition:enter-start="opacity-0 translate-y-8"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <h1 class="text-6xl lg:text-8xl font-bold mb-8 leading-[0.95]" 
                            style="font-family: 'Crimson Pro', serif;"
                            x-html="slide.title"></h1>
                        <p class="text-2xl lg:text-3xl font-light mb-12 text-white/90"
                           x-text="slide.subtitle"></p>
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                            <button class="px-10 py-5 bg-white text-primary-700 rounded-2xl font-bold text-lg hover:shadow-2xl hover:scale-105 transition-all duration-300">
                                Inizia Ora
                            </button>
                            <button class="px-10 py-5 bg-white/10 backdrop-blur-sm border-2 border-white/50 text-white rounded-2xl font-bold text-lg hover:bg-white/20 transition-all duration-300">
                                Scopri di Più
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <!-- Navigation Arrows -->
        <button @click="currentSlide = (currentSlide - 1 + slides.length) % slides.length"
                class="absolute left-8 top-1/2 -translate-y-1/2 z-20 w-14 h-14 bg-white/10 backdrop-blur-md border border-white/30 rounded-full flex items-center justify-center text-white hover:bg-white/20 transition-all duration-300 group">
            <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        
        <button @click="currentSlide = (currentSlide + 1) % slides.length"
                class="absolute right-8 top-1/2 -translate-y-1/2 z-20 w-14 h-14 bg-white/10 backdrop-blur-md border border-white/30 rounded-full flex items-center justify-center text-white hover:bg-white/20 transition-all duration-300 group">
            <svg class="w-6 h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>

        <!-- Slide Indicators -->
        <div class="absolute bottom-24 left-1/2 -translate-x-1/2 z-20 flex items-center gap-3">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="currentSlide = index"
                        class="group relative">
                    <!-- Progress bar for active slide -->
                    <div class="h-1 rounded-full bg-white/30 overflow-hidden"
                         :class="currentSlide === index ? 'w-16' : 'w-8'">
                        <div x-show="currentSlide === index"
                             class="h-full bg-white"
                             :style="`animation: progress 7s linear;`"></div>
                    </div>
                </button>
            </template>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-20 animate-bounce">
            <div class="flex flex-col items-center gap-2">
                <span class="text-white/80 text-sm font-light tracking-wider">SCROLL</span>
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </div>
        </div>
    </section>

    <style>
        @keyframes progress {
            from {
                width: 0%;
            }
            to {
                width: 100%;
            }
        }
    </style>

    <!-- Feed Section -->
    <section id="feed" class="py-20 bg-neutral-50 dark:bg-neutral-950">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <!-- Section Header -->
            <div class="flex items-center justify-between mb-12">
                <div>
                    <h2 class="text-4xl font-bold text-neutral-900 dark:text-white mb-2">Il Tuo Feed</h2>
                    <p class="text-neutral-600 dark:text-neutral-400">Gli ultimi versi dalla community</p>
                </div>
                <div class="flex items-center gap-3">
                    <button class="px-4 py-2 bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-400 rounded-lg font-medium hover:bg-primary-200 dark:hover:bg-primary-900/50 transition-colors">
                        Tutti
                    </button>
                    <button class="px-4 py-2 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-lg font-medium transition-colors">
                        Seguiti
                    </button>
                    <button class="px-4 py-2 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-lg font-medium transition-colors">
                        Trending
                    </button>
                </div>
            </div>

            <!-- Feed Grid -->
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Main Feed Column -->
                <div class="lg:col-span-2 space-y-6">
                    @for($i = 1; $i <= 5; $i++)
                    <!-- Post -->
                    <article class="group mb-8"
                             x-data
                             x-intersect.half="$el.classList.add('animate-fade-in-up')">
                        <!-- Post Header -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <img src="https://i.pravatar.cc/150?img={{ $i }}" 
                                     alt="Avatar" 
                                     class="w-12 h-12 rounded-full object-cover ring-2 ring-white dark:ring-neutral-900">
                                <div>
                                    <div class="font-semibold text-neutral-900 dark:text-white">{{ ['Alessandro Manzoni', 'Laura Bianchi', 'Marco Rossi', 'Elena Ferrari', 'Luca Verdi'][($i-1) % 5] }}</div>
                                    <div class="text-sm text-neutral-500 dark:text-neutral-400">{{ $i }}h fa</div>
                                </div>
                            </div>
                            <button class="p-2 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-lg transition-colors">
                                <svg class="w-5 h-5 text-neutral-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Post Content -->
                        <div class="bg-white dark:bg-neutral-900 rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500">
                            @php
                                $images = [
                                    'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=800&q=80',
                                    'https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?w=800&q=80',
                                    'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=800&q=80',
                                    'https://images.unsplash.com/photo-1519682337058-a94d519337bc?w=800&q=80',
                                    'https://images.unsplash.com/photo-1506880018603-83d5b814b5a6?w=800&q=80'
                                ];
                            @endphp
                            
                            @if($i % 3 == 2 || $i % 5 == 0)
                                <!-- Post con Immagine -->
                                <div class="relative aspect-[4/3] overflow-hidden">
                                    <img src="{{ $images[($i-1) % 5] }}" 
                                         alt="Post image" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                                        <h3 class="text-2xl font-bold mb-2" style="font-family: 'Crimson Pro', serif;">
                                            "{{ ['Sussurri del Vento', 'Nel Silenzio', 'Danza di Stelle', 'Echi Lontani', 'Ombre del Tempo'][($i-1) % 5] }}"
                                        </h3>
                                        <p class="text-white/90 italic">Un momento catturato tra versi e immagini...</p>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <p class="text-lg leading-relaxed text-neutral-700 dark:text-neutral-300 italic mb-4" style="font-family: 'Crimson Pro', serif;">
                                        {{ ['Nel vento che sussurra antiche storie, trovo la forza di continuare a sognare...', 
                                            'Le parole sono ponti tra anime distanti, unite dall\'arte di sentire profondamente.',
                                            'Tra le righe di un verso dimenticato, scopro mondi che non sapevo esistessero.',
                                            'La poesia è il linguaggio dell\'anima, quella parte di noi che non conosce confini.',
                                            'Nel silenzio trovo le parole più vere, quelle che il cuore sa dire senza voce.'][($i-1) % 5] }}
                                    </p>
                                </div>
                            @else
                                <!-- Post solo testo -->
                                <div class="p-8">
                                    <h3 class="text-2xl font-semibold text-neutral-900 dark:text-white mb-4" style="font-family: 'Crimson Pro', serif;">
                                        "{{ ['Sussurri del Vento', 'Nel Silenzio', 'Danza di Stelle', 'Echi Lontani', 'Ombre del Tempo'][($i-1) % 5] }}"
                                    </h3>
                                    <p class="text-xl leading-relaxed text-neutral-700 dark:text-neutral-300 italic" style="font-family: 'Crimson Pro', serif;">
                                        {{ ['Nel vento che sussurra antiche storie, trovo la forza di continuare a sognare. Ogni parola è un respiro, ogni verso un battito del cuore che risuona nell\'eternità.', 
                                            'Le parole sono ponti tra anime distanti, unite dall\'arte di sentire profondamente. Nella poesia troviamo casa, un rifugio dove il tempo si ferma.',
                                            'Tra le righe di un verso dimenticato, scopro mondi che non sapevo esistessero. La bellezza nascosta tra le parole emerge come luce nell\'oscurità.',
                                            'La poesia è il linguaggio dell\'anima, quella parte di noi che non conosce confini. Ogni strofa è un viaggio, ogni rima una scoperta.',
                                            'Nel silenzio trovo le parole più vere, quelle che il cuore sa dire senza voce. Il poeta ascolta ciò che gli altri non sentono.'][($i-1) % 5] }}
                                    </p>
                                </div>
                            @endif

                            <!-- Post Actions -->
                            <div class="px-6 pb-6 flex items-center justify-between pt-2">
                                <div class="flex items-center gap-6">
                    <button class="flex items-center gap-2 text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-500 transition-colors group/btn">
                        <svg class="w-6 h-6 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span class="font-semibold">{{ rand(20, 150) }}</span>
                    </button>
                    <button class="flex items-center gap-2 text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-500 transition-colors group/btn">
                        <svg class="w-6 h-6 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <span class="font-semibold">{{ rand(5, 40) }}</span>
                    </button>
                    <button class="flex items-center gap-2 text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-500 transition-colors group/btn">
                        <svg class="w-6 h-6 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                        </svg>
                    </button>
                </div>
                <button class="text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-500 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                    </svg>
                </button>
                            </div>
                        </div>
                    </article>
                    @endfor
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Trending -->
                    <div class="bg-white/60 dark:bg-neutral-900/60 backdrop-blur-xl rounded-3xl p-6 shadow-sm sticky top-24">
                        <h3 class="font-bold text-lg mb-6 text-neutral-900 dark:text-white">Trending</h3>
                        <div class="space-y-4">
                            @foreach(['#PoesiaContemporanea' => '2.3k', '#VersiLiberi' => '1.8k', '#SlamPoetry' => '1.2k', '#Emozioni' => '945'] as $tag => $count)
                            <div class="group cursor-pointer hover:bg-primary-50 dark:hover:bg-primary-900/20 -mx-2 px-2 py-2 rounded-xl transition-colors">
                                <div class="font-semibold text-primary-700 dark:text-primary-400 group-hover:text-primary-800 dark:group-hover:text-primary-300 transition-colors">{{ $tag }}</div>
                                <div class="text-sm text-neutral-500 dark:text-neutral-400">{{ $count }} post oggi</div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Poeti Suggeriti -->
                    <div class="bg-white/60 dark:bg-neutral-900/60 backdrop-blur-xl rounded-3xl p-6 shadow-sm">
                        <h3 class="font-bold text-lg mb-6 text-neutral-900 dark:text-white">Chi Seguire</h3>
                        <div class="space-y-5">
                            @for($i = 1; $i <= 3; $i++)
                            <div class="flex items-center justify-between group">
                                <div class="flex items-center gap-3">
                                    <img src="https://i.pravatar.cc/150?img={{ $i + 10 }}" 
                                         alt="Avatar" 
                                         class="w-12 h-12 rounded-full object-cover ring-2 ring-white dark:ring-neutral-800 group-hover:ring-primary-400 transition-all">
                                    <div>
                                        <div class="font-semibold text-neutral-900 dark:text-white text-sm">{{ ['Sofia Greco', 'Andrea Neri', 'Chiara Blu'][($i-1) % 3] }}</div>
                                        <div class="text-xs text-neutral-500 dark:text-neutral-400">{{ rand(100, 999) }} followers</div>
                                    </div>
                                </div>
                                <button class="px-5 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold rounded-full transition-all hover:scale-105">
                                    Segui
                                </button>
                            </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Discover Section con Parallax -->
    <section id="discover" class="relative py-32 overflow-hidden">
        <!-- Parallax Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-primary-100 to-primary-200 dark:from-primary-900/20 dark:to-primary-800/20"
             x-data
             :style="`transform: translateY(${(scrollY - 800) * 0.3}px)`">
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-bold text-neutral-900 dark:text-white mb-4" style="font-family: 'Crimson Pro', serif;">
                    Scopri Nuovi <span class="italic text-primary-700 dark:text-primary-400">Talenti</span>
                </h2>
                <p class="text-xl text-neutral-600 dark:text-neutral-400">Poeti emergenti che stanno conquistando la community</p>
            </div>

            <!-- Poet Cards Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $poetImages = [
                        'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&q=80',
                        'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400&q=80',
                        'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&q=80',
                        'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=400&q=80',
                        'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&q=80',
                        'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=400&q=80',
                        'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=400&q=80',
                        'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?w=400&q=80'
                    ];
                @endphp
                @for($i = 1; $i <= 8; $i++)
                <div class="group cursor-pointer"
                     x-data
                     x-intersect.half="$el.classList.add('animate-fade-in-up')"
                     style="animation-delay: {{ $i * 100 }}ms;">
                    <div class="relative overflow-hidden rounded-3xl hover:shadow-2xl hover:-translate-y-3 transition-all duration-500">
                        <!-- Image -->
                        <div class="aspect-square overflow-hidden">
                            <img src="{{ $poetImages[$i-1] }}" 
                                 alt="Poet" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                        </div>
                        
                        <!-- Content Overlay -->
                        <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                            <h3 class="font-bold text-xl mb-1">{{ ['Sofia Martini', 'Luca Romano', 'Elena Conti', 'Marco Ricci', 'Giulia Neri', 'Andrea Bianchi', 'Chiara Rossi', 'Paolo Verdi'][$i-1] }}</h3>
                            <p class="text-white/80 text-sm mb-4">{{ rand(50, 500) }} followers · {{ rand(10, 100) }} poesie</p>
                            <button class="w-full py-3 bg-white/20 backdrop-blur-md hover:bg-white hover:text-neutral-900 text-white rounded-full font-semibold transition-all duration-300 border border-white/30">
                                Segui
                            </button>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </section>

    <!-- Events Section -->
    <section id="events" class="py-20 bg-white dark:bg-neutral-900">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between mb-12">
                <div>
                    <h2 class="text-4xl font-bold text-neutral-900 dark:text-white mb-2">Eventi in Arrivo</h2>
                    <p class="text-neutral-600 dark:text-neutral-400">Non perdere i prossimi appuntamenti poetici</p>
                </div>
                <a href="{{ route('events.index') }}" class="text-primary-600 hover:text-primary-700 font-medium flex items-center gap-2 group">
                    Vedi tutti
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $eventImages = [
                        'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=800&q=80',
                        'https://images.unsplash.com/photo-1475721027785-f74eccf877e2?w=800&q=80',
                        'https://images.unsplash.com/photo-1471922694854-ff1b63b20054?w=800&q=80'
                    ];
                @endphp
                @for($i = 1; $i <= 3; $i++)
                <div class="group cursor-pointer overflow-hidden rounded-3xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-500"
                     x-data
                     x-intersect.half="$el.classList.add('animate-fade-in-up')">
                    <!-- Image -->
                    <div class="relative h-64 overflow-hidden">
                        <img src="{{ $eventImages[$i-1] }}" 
                             alt="Event" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                        
                        <!-- Date Badge -->
                        <div class="absolute top-6 left-6 bg-white/90 backdrop-blur-md px-5 py-3 rounded-2xl shadow-lg">
                            <div class="text-3xl font-bold text-primary-700">{{ now()->addDays($i * 5)->format('d') }}</div>
                            <div class="text-sm text-neutral-600 font-medium">{{ now()->addDays($i * 5)->format('M') }}</div>
                        </div>

                        <!-- Category -->
                        <div class="absolute top-6 right-6">
                            <span class="px-4 py-2 bg-primary-600 text-white rounded-full text-xs font-bold uppercase tracking-wider">
                                {{ ['Poetry Slam', 'Workshop', 'Reading'][($i-1) % 3] }}
                            </span>
                        </div>

                        <!-- Bottom Content -->
                        <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                            <h3 class="text-2xl font-bold mb-2" style="font-family: 'Crimson Pro', serif;">
                                {{ ['Notte di Versi Liberi', 'Workshop di Scrittura Creativa', 'Reading Poetico al Tramonto'][$i-1] }}
                            </h3>
                            <p class="text-white/90 text-sm mb-4">
                                {{ ['Un evento imperdibile per tutti gli amanti della poesia contemporanea.', 
                                    'Impara le tecniche dei grandi poeti in un workshop interattivo.', 
                                    'Un pomeriggio di letture poetiche in un\'atmosfera magica.'][$i-1] }}
                            </p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2 text-white/90 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    </svg>
                                    {{ ['Milano', 'Roma', 'Firenze'][$i % 3] }}
                                </div>
                                <button class="px-6 py-2.5 bg-white text-neutral-900 rounded-full font-bold text-sm hover:scale-105 transition-transform">
                                    Partecipa
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </section>

    <!-- CTA Section con Parallax -->
    <section class="relative py-32 overflow-hidden">
        <!-- Parallax Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800"
             x-data
             :style="`transform: translateY(${(scrollY - 2000) * 0.4}px)`">
        </div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center text-white">
            <h2 class="text-5xl lg:text-6xl font-bold mb-6 leading-tight" style="font-family: 'Crimson Pro', serif;">
                Pronto a condividere<br>
                la tua <span class="italic">voce</span>?
            </h2>
            <p class="text-xl mb-10 text-white/90">
                Unisciti a migliaia di poeti che hanno già trovato la loro community
            </p>
            <button class="px-10 py-5 bg-white text-primary-700 rounded-xl font-bold text-lg hover:shadow-2xl hover:scale-105 transition-all duration-300">
                Inizia Gratuitamente
            </button>
        </div>
    </section>

    <style>
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
        }

        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }
    </style>
</x-layouts.parallax>

