<x-layouts.verse>
    <x-slot name="title">Verse - Poetry Network</x-slot>

    <!-- Card Grande Featured (Spanning 8 cols) -->
    <div class="col-span-12 lg:col-span-8 group cursor-pointer">
        <div class="relative h-[500px] bg-gradient-to-br from-accent-400 via-accent-600 to-accent-800 rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500">
            <!-- Overlay Pattern -->
            <div class="absolute inset-0 opacity-20">
                <div class="absolute inset-0" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 30px 30px;"></div>
            </div>
            
            <!-- Content -->
            <div class="relative h-full p-12 flex flex-col justify-between">
                <div>
                    <span class="inline-block px-4 py-2 bg-white/20 backdrop-blur-sm text-white rounded-full text-sm font-medium mb-4">
                        ✨ Poesia del Giorno
                    </span>
                    <h2 class="text-5xl font-bold text-white mb-6 leading-tight italic" style="font-family: 'Crimson Pro', serif;">
                        "Nel Silenzio<br>della Luna"
                    </h2>
                    <p class="text-2xl text-white/90 leading-relaxed mb-8" style="font-family: 'Crimson Pro', serif;">
                        Nel silenzio della notte eterna,<br>
                        dove le stelle danzano lente,<br>
                        il cuore trova la sua poesia...
                    </p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-sm border-2 border-white/40"></div>
                    <div class="text-white">
                        <div class="font-semibold text-lg">Alessandro Manzoni</div>
                        <div class="text-white/70 text-sm">2.3k followers · 142 poesie</div>
                    </div>
                </div>
            </div>

            <!-- Hover Effect -->
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-all duration-500"></div>
        </div>
    </div>

    <!-- Stats Vertical (Spanning 4 cols) -->
    <div class="col-span-12 lg:col-span-4 space-y-6">
        <!-- Active Poets -->
        <div class="bg-white dark:bg-neutral-900 rounded-3xl p-6 shadow-lg border border-neutral-200 dark:border-neutral-800 hover:scale-105 transition-transform duration-500">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-neutral-900 dark:text-white">Poeti Attivi</h3>
                <div class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                </div>
            </div>
            <div class="text-4xl font-bold text-accent-600 mb-1">1,234</div>
            <div class="text-sm text-neutral-500 dark:text-neutral-400">online in questo momento</div>
        </div>

        <!-- Quick Gig -->
        <div class="bg-gradient-to-br from-secondary-50 to-secondary-100 dark:from-secondary-900/20 dark:to-secondary-800/20 rounded-3xl p-6 border border-secondary-200 dark:border-secondary-800 hover:scale-105 transition-transform duration-500">
            <div class="text-xs font-bold text-secondary-700 dark:text-secondary-400 mb-2">🔥 GIG HOT</div>
            <h4 class="font-bold text-neutral-900 dark:text-white mb-2">Poeta per Evento</h4>
            <div class="text-2xl font-bold text-secondary-700 dark:text-secondary-400 mb-3">€300</div>
            <button class="w-full py-2 bg-secondary-600 hover:bg-secondary-700 text-white rounded-xl text-sm font-medium transition-colors">
                Candidati
            </button>
        </div>
    </div>

    <!-- Post Poesia Card Medium (6 cols) -->
    <div class="col-span-12 md:col-span-6 lg:col-span-6">
        <div class="bg-white dark:bg-neutral-900 rounded-3xl overflow-hidden shadow-lg border border-neutral-200 dark:border-neutral-800 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 group">
            <!-- Header -->
            <div class="p-6 pb-4 border-b border-neutral-100 dark:border-neutral-800">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary-400 to-primary-600"></div>
                    <div>
                        <div class="font-semibold text-neutral-900 dark:text-white">Poeta Emergente</div>
                        <div class="text-sm text-neutral-500 dark:text-neutral-400">3h fa</div>
                    </div>
                </div>
                <h3 class="text-xl font-semibold text-neutral-900 dark:text-white mb-3 italic group-hover:text-accent-600 transition-colors">"Versi al Tramonto"</h3>
            </div>

            <!-- Content -->
            <div class="p-6 pt-4">
                <p class="text-neutral-700 dark:text-neutral-300 leading-relaxed italic mb-4" style="font-family: 'Crimson Pro', serif;">
                    Quando il sole bacia l'orizzonte,<br>
                    e il cielo si tinge di mille colori,<br>
                    l'anima trova pace nei versi,<br>
                    tra sogni e antichi splendori.
                </p>
                
                <!-- Actions -->
                <div class="flex items-center gap-6 text-sm text-neutral-500 dark:text-neutral-400">
                    <button class="flex items-center gap-2 hover:text-accent-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span class="font-medium">42</span>
                    </button>
                    <button class="flex items-center gap-2 hover:text-secondary-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <span class="font-medium">18</span>
                    </button>
                    <button class="flex items-center gap-2 hover:text-primary-600 transition-colors ml-auto">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Evento Card (6 cols) -->
    <div class="col-span-12 md:col-span-6 lg:col-span-6">
        <div class="bg-white dark:bg-neutral-900 rounded-3xl overflow-hidden shadow-lg border border-neutral-200 dark:border-neutral-800 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
            <!-- Event Image -->
            <div class="h-48 bg-gradient-to-br from-secondary-400 to-secondary-600 relative overflow-hidden group">
                <div class="absolute inset-0 bg-black/20 group-hover:bg-black/0 transition-all duration-500"></div>
                <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-4 py-2 rounded-2xl">
                    <div class="text-xs text-neutral-600 font-medium">{{ now()->addDays(5)->format('d') }}</div>
                    <div class="text-xs text-neutral-500">{{ now()->addDays(5)->format('M') }}</div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <span class="inline-block px-3 py-1 bg-secondary-100 dark:bg-secondary-900/30 text-secondary-700 dark:text-secondary-300 rounded-full text-xs font-medium mb-3">
                    Poetry Slam
                </span>
                <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-2">
                    Notte di Versi Liberi
                </h3>
                <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-4">
                    Un evento imperdibile per tutti gli amanti della poesia contemporanea.
                </p>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2 text-sm text-neutral-500 dark:text-neutral-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        </svg>
                        Milano
                    </div>
                    <button class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-xl transition-all hover:scale-105">
                        Partecipa
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Masonry Layout - Posts Irregolari -->
    @php
        $heights = ['h-64', 'h-80', 'h-72', 'h-96', 'h-64', 'h-88'];
        $spans = [4, 4, 4, 6, 6, 3, 3, 3, 3];
    @endphp

    @for($i = 1; $i <= 6; $i++)
    <div class="col-span-12 md:col-span-6 lg:col-span-{{ $spans[$i-1] ?? 4 }}">
        <div class="bg-white dark:bg-neutral-900 rounded-3xl overflow-hidden shadow-lg border border-neutral-200 dark:border-neutral-800 hover:shadow-2xl hover:-translate-y-1 transition-all duration-500 {{ $heights[$i-1] ?? 'h-64' }} flex flex-col">
            <!-- Header -->
            <div class="p-6 pb-3 flex items-center gap-3 border-b border-neutral-100 dark:border-neutral-800">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-br {{ ['from-accent-400 to-accent-600', 'from-primary-400 to-primary-600', 'from-secondary-400 to-secondary-600'][$i % 3] }}"></div>
                <div>
                    <div class="font-semibold text-neutral-900 dark:text-white text-sm">Poeta {{ $i }}</div>
                    <div class="text-xs text-neutral-500 dark:text-neutral-400">{{ $i }}h fa</div>
                </div>
                <button class="ml-auto p-2 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-lg transition-colors">
                    <svg class="w-4 h-4 text-neutral-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                    </svg>
                </button>
            </div>

            <!-- Content -->
            <div class="flex-1 p-6 pt-4 overflow-hidden">
                @if($i % 3 == 1)
                    <p class="text-neutral-700 dark:text-neutral-300 leading-relaxed italic text-lg" style="font-family: 'Crimson Pro', serif;">
                        @php
                            $texts = [
                                'Nel vento che sussurra antiche storie, trovo la forza di continuare a sognare...', 
                                'Le parole sono ponti tra anime distanti, unite dall\'arte di sentire profondamente.',
                                'Tra le righe di un verso dimenticato, scopro mondi che non sapevo esistessero.',
                                'La poesia è il linguaggio dell\'anima, quella parte di noi che non conosce confini.',
                                'Nel silenzio trovo le parole più vere, quelle che il cuore sa dire senza voce.',
                                'Ogni verso è un passo verso l\'infinito, un viaggio senza fine né inizio.'
                            ];
                        @endphp
                        {{ $texts[($i-1) % 6] }}
                    </p>
                @else
                    <div class="h-32 bg-gradient-to-br {{ ['from-accent-200 to-accent-400', 'from-primary-200 to-primary-400', 'from-secondary-200 to-secondary-400'][$i % 3] }} rounded-2xl mb-3"></div>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">
                        Un'immagine che cattura l'essenza della poesia contemporanea...
                    </p>
                @endif
            </div>

            <!-- Footer Actions -->
            <div class="px-6 pb-6 flex items-center gap-4 text-sm">
                <button class="flex items-center gap-2 text-neutral-500 dark:text-neutral-400 hover:text-accent-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    {{ rand(20, 150) }}
                </button>
                <button class="flex items-center gap-2 text-neutral-500 dark:text-neutral-400 hover:text-secondary-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    {{ rand(5, 40) }}
                </button>
                <button class="ml-auto p-2 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    @endfor

    <!-- Trending Topics Widget (3 cols) -->
    <div class="col-span-12 md:col-span-6 lg:col-span-3">
        <div class="bg-gradient-to-br from-accent-50 to-accent-100 dark:from-accent-900/20 dark:to-accent-800/20 rounded-3xl p-6 border border-accent-200 dark:border-accent-800 hover:scale-105 transition-transform duration-500">
            <h3 class="font-bold text-neutral-900 dark:text-white mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-accent-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                </svg>
                Trending
            </h3>
            <div class="space-y-3">
                @foreach(['#PoesiaContemporanea', '#SlamPoetry', '#VersiLiberi'] as $tag)
                <div class="px-3 py-2 bg-white/60 dark:bg-neutral-900/60 backdrop-blur-sm rounded-xl hover:bg-white dark:hover:bg-neutral-900 transition-colors cursor-pointer">
                    <div class="font-semibold text-accent-700 dark:text-accent-400 text-sm">{{ $tag }}</div>
                    <div class="text-xs text-neutral-500 dark:text-neutral-400">{{ rand(100, 999) }} post oggi</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Articolo Highlight (3 cols) -->
    <div class="col-span-12 md:col-span-6 lg:col-span-3">
        <div class="h-full bg-white dark:bg-neutral-900 rounded-3xl overflow-hidden shadow-lg border border-neutral-200 dark:border-neutral-800 hover:shadow-2xl hover:-translate-y-1 transition-all duration-500 flex flex-col">
            <div class="h-40 bg-gradient-to-br from-primary-300 to-primary-500"></div>
            <div class="flex-1 p-6">
                <span class="inline-block px-3 py-1 bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 rounded-full text-xs font-medium mb-3">
                    Articolo
                </span>
                <h3 class="font-bold text-neutral-900 dark:text-white mb-2 line-clamp-2">
                    Storia della Poesia Italiana
                </h3>
                <p class="text-sm text-neutral-600 dark:text-neutral-400 line-clamp-3">
                    Un viaggio attraverso i secoli della letteratura poetica italiana...
                </p>
            </div>
        </div>
    </div>

    <!-- Nuovi Poeti - Carousel (12 cols) -->
    <div class="col-span-12">
        <div class="bg-white dark:bg-neutral-900 rounded-3xl p-8 shadow-lg border border-neutral-200 dark:border-neutral-800">
            <h3 class="text-2xl font-bold text-neutral-900 dark:text-white mb-6">Nuovi Poeti da Seguire</h3>
            <div class="flex gap-6 overflow-x-auto pb-4 scrollbar-hide">
                @for($i = 1; $i <= 10; $i++)
                <div class="flex-shrink-0 text-center group cursor-pointer">
                    <div class="relative mb-3">
                        <div class="w-24 h-24 rounded-3xl bg-gradient-to-br {{ ['from-accent-400 to-accent-600', 'from-primary-400 to-primary-600', 'from-secondary-400 to-secondary-600'][$i % 3] }} group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-lg"></div>
                        <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-green-500 border-4 border-white dark:border-neutral-900 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <div class="font-semibold text-neutral-900 dark:text-white text-sm mb-1 group-hover:text-accent-600 transition-colors">Poeta {{ $i }}</div>
                    <div class="text-xs text-neutral-500 dark:text-neutral-400 mb-2">{{ rand(50, 500) }} followers</div>
                    <button class="px-4 py-2 bg-accent-500 hover:bg-accent-600 text-white text-xs font-medium rounded-xl transition-all hover:scale-105">
                        Segui
                    </button>
                </div>
                @endfor
            </div>
        </div>
    </div>

    <!-- Post Cards Continui (varie dimensioni) -->
    @for($i = 1; $i <= 4; $i++)
    <div class="col-span-12 md:col-span-6 lg:col-span-{{ [6, 4, 4, 4][$i-1] }}">
        <div class="bg-white dark:bg-neutral-900 rounded-3xl p-6 shadow-lg border border-neutral-200 dark:border-neutral-800 hover:shadow-2xl hover:-translate-y-1 transition-all duration-500">
            <!-- Mini Header -->
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-br {{ ['from-accent-400 to-accent-600', 'from-primary-400 to-primary-600', 'from-secondary-400 to-secondary-600'][$i % 3] }}"></div>
                <div>
                    <div class="font-semibold text-neutral-900 dark:text-white text-sm">Autore {{ $i }}</div>
                    <div class="text-xs text-neutral-500 dark:text-neutral-400">{{ $i }}h fa</div>
                </div>
            </div>

            @if($i % 2 == 1)
                <!-- Poesia -->
                <p class="text-neutral-700 dark:text-neutral-300 leading-relaxed italic mb-4" style="font-family: 'Crimson Pro', serif;">
                    @php
                        $poemTexts = [
                            'Nel giardino segreto dei ricordi, ogni petalo è un verso che cade dolcemente nell\'oblio del tempo...', 
                            'Danzano le stelle nel cielo notturno, mentre io qui scrivo di te, amore perduto ma mai dimenticato.',
                            'Il poeta è un ladro di emozioni, che ruba al cielo le stelle per farne parole.',
                            'Tra le righe di un libro antico, trovo la voce di chi non c\'è più ma vive nei versi eterni.'
                        ];
                    @endphp
                    {{ $poemTexts[$i % 4] }}
                </p>
            @else
                <!-- Media -->
                <div class="h-48 bg-gradient-to-br {{ ['from-accent-200 to-accent-400', 'from-primary-200 to-primary-400', 'from-secondary-200 to-secondary-400'][$i % 3] }} rounded-2xl mb-4"></div>
            @endif

            <!-- Actions Minimal -->
            <div class="flex items-center gap-4 text-sm pt-4 border-t border-neutral-100 dark:border-neutral-800">
                <button class="flex items-center gap-2 text-neutral-500 dark:text-neutral-400 hover:text-accent-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    {{ rand(10, 100) }}
                </button>
                <button class="flex items-center gap-2 text-neutral-500 dark:text-neutral-400 hover:text-secondary-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    {{ rand(2, 30) }}
                </button>
            </div>
        </div>
    </div>
    @endfor

    <!-- Load More Floating -->
    <div class="col-span-12 flex justify-center py-8">
        <button class="group relative px-8 py-4 bg-gradient-to-r from-accent-500 to-secondary-500 hover:from-accent-600 hover:to-secondary-600 text-white font-semibold rounded-2xl transition-all duration-500 hover:scale-110 hover:shadow-2xl overflow-hidden">
            <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
            <span class="relative flex items-center gap-2">
                Scopri Altri Versi
                <svg class="w-5 h-5 group-hover:translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </span>
        </button>
    </div>

    <style>
        /* Custom Animations */
        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) scale(1);
                opacity: 0.3;
            }
            25% {
                transform: translate(30px, -30px) scale(1.2);
                opacity: 0.5;
            }
            50% {
                transform: translate(-20px, -60px) scale(0.8);
                opacity: 0.4;
            }
            75% {
                transform: translate(40px, -40px) scale(1.1);
                opacity: 0.6;
            }
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-layouts.verse>

