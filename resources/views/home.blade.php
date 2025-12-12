<x-layouts.app>
    <x-slot name="title">Home</x-slot>

    <!-- Hero Section con Animazione -->
    <section class="relative overflow-hidden bg-gradient-to-br from-primary-900 to-primary-800 text-white">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-10 w-72 h-72 bg-accent-500 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-secondary-500 rounded-full blur-3xl animate-pulse delay-700"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32">
            <div class="text-center space-y-6">
                <h1 class="text-5xl md:text-7xl font-bold tracking-tight opacity-0 animate-fade-in">
                    Benvenuto su <span class="text-gradient-light">SLAMIN</span>
                </h1>
                <p class="text-xl md:text-2xl text-primary-100 max-w-3xl mx-auto opacity-0 animate-fade-in-delay-1">
                    Il portale dove la poesia incontra la community. Condividi le tue opere, 
                    partecipa ad eventi e connettiti con poeti da tutto il mondo.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4 pt-4 opacity-0 animate-fade-in-delay-2">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-4 bg-accent-500 hover:bg-accent-600 text-white font-medium rounded-xl transition-all duration-300 hover:scale-105 hover:shadow-xl">
                        Inizia Ora
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                    <a href="{{ route('about') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white font-medium rounded-xl border-2 border-white/30 transition-all duration-300 hover:scale-105">
                        Scopri di Più
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Stats -->
    <section class="bg-white dark:bg-neutral-900 border-b border-neutral-200 dark:border-neutral-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center group cursor-pointer">
                    <div class="text-4xl md:text-5xl font-bold text-accent-600 mb-2 transition-transform duration-300 group-hover:scale-110">
                        1,234
                    </div>
                    <div class="text-sm text-neutral-600 dark:text-neutral-400">Poeti Attivi</div>
                </div>
                <div class="text-center group cursor-pointer">
                    <div class="text-4xl md:text-5xl font-bold text-secondary-600 mb-2 transition-transform duration-300 group-hover:scale-110">
                        5,678
                    </div>
                    <div class="text-sm text-neutral-600 dark:text-neutral-400">Poesie</div>
                </div>
                <div class="text-center group cursor-pointer">
                    <div class="text-4xl md:text-5xl font-bold text-primary-600 mb-2 transition-transform duration-300 group-hover:scale-110">
                        234
                    </div>
                    <div class="text-sm text-neutral-600 dark:text-neutral-400">Eventi</div>
                </div>
                @if(!auth()->check() || !auth()->user()->hasRole('audience'))
                <div class="text-center group cursor-pointer">
                    <div class="text-4xl md:text-5xl font-bold text-accent-500 mb-2 transition-transform duration-300 group-hover:scale-110">
                        89
                    </div>
                    <div class="text-sm text-neutral-600 dark:text-neutral-400">Gigs Aperti</div>
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Ultimi Eventi -->
    <section class="py-16 bg-neutral-50 dark:bg-neutral-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl md:text-4xl font-bold text-neutral-900 dark:text-white">
                    Prossimi Eventi
                </h2>
                <a href="{{ route('events.index') }}" class="text-accent-600 hover:text-accent-700 font-medium flex items-center gap-2 transition-colors">
                    Vedi tutti
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @for($i = 1; $i <= 3; $i++)
                <div class="group bg-white dark:bg-neutral-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 hover:-translate-y-2 cursor-pointer">
                    <div class="h-48 bg-gradient-to-br from-primary-400 to-primary-600 relative overflow-hidden">
                        <div class="absolute inset-0 bg-primary-900/20 group-hover:bg-primary-900/0 transition-all duration-500"></div>
                        <div class="absolute bottom-4 left-4 bg-accent-500 text-white px-4 py-2 rounded-lg text-sm font-medium">
                            {{ now()->addDays($i * 3)->format('d M Y') }}
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-neutral-900 dark:text-white mb-2 group-hover:text-accent-600 transition-colors">
                            Poetry Reading Night #{{ $i }}
                        </h3>
                        <p class="text-neutral-600 dark:text-neutral-300 text-sm mb-4">
                            Un serata dedicata alla poesia contemporanea con letture e performance live.
                        </p>
                        <div class="flex items-center gap-4 text-sm text-neutral-500 dark:text-neutral-400">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Milano
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                {{ 20 + $i * 5 }} partecipanti
                            </span>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </section>
    @endif

    <!-- Ultime Poesie -->
    <section class="py-16 bg-white dark:bg-neutral-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl md:text-4xl font-bold text-neutral-900 dark:text-white">
                    Ultime Poesie
                </h2>
                <a href="{{ route('poems.index') }}" class="text-accent-600 hover:text-accent-700 font-medium flex items-center gap-2 transition-colors">
                    Leggi tutte
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @for($i = 1; $i <= 4; $i++)
                <div class="group bg-neutral-50 dark:bg-neutral-900 rounded-2xl p-6 hover:bg-accent-50 dark:hover:bg-accent-900/10 transition-all duration-300 cursor-pointer border border-neutral-200 dark:border-neutral-700 hover:border-accent-200 dark:hover:border-accent-800">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-accent-400 to-accent-600 flex items-center justify-center text-white font-bold flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                            {{ chr(64 + $i) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="font-semibold text-neutral-900 dark:text-white group-hover:text-accent-700 dark:group-hover:text-accent-400 transition-colors">
                                    Poeta {{ $i }}
                                </h3>
                                <span class="text-xs text-neutral-500 dark:text-neutral-400">· {{ $i }}h fa</span>
                            </div>
                            <h4 class="text-lg font-medium text-neutral-800 dark:text-neutral-200 mb-2 italic">
                                "{{ ['Il Silenzio della Luna', 'Vento tra i Rami', 'Alba Nascente', 'Echi Lontani'][$i-1] }}"
                            </h4>
                            <p class="text-neutral-600 dark:text-neutral-400 text-sm line-clamp-2">
                                Nel silenzio della notte, le parole danzano leggere come foglie al vento, 
                                portando con sé il peso delle emozioni non dette...
                            </p>
                            <div class="flex items-center gap-4 mt-4 text-sm text-neutral-500 dark:text-neutral-400">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"/>
                                    </svg>
                                    {{ 15 + $i * 8 }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ 3 + $i * 2 }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </section>

    <!-- Ultimi Articoli -->
    <section class="py-16 bg-neutral-50 dark:bg-neutral-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl md:text-4xl font-bold text-neutral-900 dark:text-white">
                    Ultimi Articoli
                </h2>
                <a href="{{ route('articles.index') }}" class="text-accent-600 hover:text-accent-700 font-medium flex items-center gap-2 transition-colors">
                    Leggi tutti
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @for($i = 1; $i <= 3; $i++)
                <article class="group bg-white dark:bg-neutral-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 cursor-pointer">
                    <div class="h-56 bg-gradient-to-br {{ ['from-accent-400 to-accent-600', 'from-secondary-400 to-secondary-600', 'from-primary-400 to-primary-600'][$i-1] }} relative overflow-hidden">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-all duration-500"></div>
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-medium text-neutral-700">
                            {{ ['Cultura', 'Storia', 'Letteratura'][$i-1] }}
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="text-xs text-neutral-500 dark:text-neutral-400 mb-2">{{ now()->subDays($i)->format('d M Y') }}</div>
                        <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3 group-hover:text-accent-600 dark:group-hover:text-accent-400 transition-colors">
                            {{ ['L\'evoluzione della Poesia Italiana', 'Poeti del Novecento', 'Il Verso Libero Moderno'][$i-1] }}
                        </h3>
                        <p class="text-neutral-600 dark:text-neutral-300 text-sm mb-4 line-clamp-3">
                            Un viaggio attraverso le correnti letterarie che hanno definito la poesia 
                            contemporanea italiana, dalle avanguardie storiche ai giorni nostri.
                        </p>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-neutral-300 to-neutral-400"></div>
                            <div class="text-sm">
                                <div class="font-medium text-neutral-900 dark:text-white">Autore {{ $i }}</div>
                                <div class="text-neutral-500 dark:text-neutral-400 text-xs">{{ $i * 2 }} min lettura</div>
                            </div>
                        </div>
                    </div>
                </article>
                @endfor
            </div>
        </div>
    </section>

    <!-- Gigs Disponibili -->
    @if(!auth()->check() || !auth()->user()->hasRole('audience'))
    <section class="py-16 bg-white dark:bg-neutral-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-neutral-900 dark:text-white mb-2">
                        Gigs Disponibili
                    </h2>
                    <p class="text-neutral-600 dark:text-neutral-300">Opportunità per poeti e scrittori</p>
                </div>
                <a href="#" class="hidden md:inline-flex items-center gap-2 px-6 py-3 bg-secondary-600 hover:bg-secondary-700 text-white font-medium rounded-xl transition-all duration-300 hover:scale-105">
                    Pubblica Gig
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @for($i = 1; $i <= 4; $i++)
                <div class="group bg-neutral-50 dark:bg-neutral-900 rounded-2xl p-6 hover:bg-gradient-to-br hover:from-secondary-50 hover:to-accent-50 dark:hover:from-secondary-900/20 dark:hover:to-accent-900/20 transition-all duration-500 cursor-pointer border border-neutral-200 dark:border-neutral-700">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-2 group-hover:text-secondary-700 dark:group-hover:text-secondary-400 transition-colors">
                                {{ ['Poeta per evento aziendale', 'Scrittore per antologia', 'Performance slam poetry', 'Contributor rivista letteraria'][$i-1] }}
                            </h3>
                            <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-neutral-400">
                                <span class="px-3 py-1 bg-secondary-100 dark:bg-secondary-900 text-secondary-800 dark:text-secondary-200 rounded-full text-xs font-medium">
                                    {{ ['Freelance', 'Contratto', 'Una Tantum', 'Collaborazione'][$i-1] }}
                                </span>
                                <span>· Pubblicato {{ $i }}h fa</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-accent-600">€{{ [150, 300, 200, 500][$i-1] }}</div>
                            <div class="text-xs text-neutral-500 dark:text-neutral-400">{{ ['per evento', 'fisso', 'per serata', 'mensile'][$i-1] }}</div>
                        </div>
                    </div>
                    <p class="text-neutral-600 dark:text-neutral-300 text-sm mb-4">
                        Cerchiamo un poeta per un evento speciale. Esperienza in performance live richiesta.
                    </p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 text-xs text-neutral-500 dark:text-neutral-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Scadenza: {{ now()->addDays(7 + $i)->format('d/m/Y') }}
                        </div>
                        <button class="px-4 py-2 bg-secondary-600 hover:bg-secondary-700 text-white text-sm font-medium rounded-lg transition-all duration-300 hover:scale-105">
                            Candidati
                        </button>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </section>

    <!-- Nuovi Membri -->
    <section class="py-16 bg-neutral-50 dark:bg-neutral-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl md:text-4xl font-bold text-neutral-900 dark:text-white mb-8">
                Nuovi nella Community
            </h2>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
                @for($i = 1; $i <= 6; $i++)
                <div class="group text-center cursor-pointer">
                    <div class="relative mb-3">
                        <div class="w-full aspect-square rounded-2xl bg-gradient-to-br {{ ['from-accent-400 to-accent-600', 'from-primary-400 to-primary-600', 'from-secondary-400 to-secondary-600', 'from-accent-300 to-accent-500', 'from-primary-300 to-primary-500', 'from-secondary-300 to-secondary-500'][$i-1] }} mb-2 group-hover:scale-110 transition-all duration-500 group-hover:rotate-3 flex items-center justify-center text-white text-2xl font-bold shadow-lg group-hover:shadow-2xl">
                            {{ chr(64 + $i) }}
                        </div>
                        <div class="absolute -bottom-2 -right-2 w-6 h-6 bg-green-500 border-4 border-white dark:border-neutral-900 rounded-full"></div>
                    </div>
                    <h4 class="font-semibold text-neutral-900 dark:text-white mb-1 group-hover:text-accent-600 dark:group-hover:text-accent-400 transition-colors">
                        Poeta {{ $i }}
                    </h4>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400">{{ ['Milano', 'Roma', 'Firenze', 'Napoli', 'Bologna', 'Torino'][$i-1] }}</p>
                </div>
                @endfor
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="relative py-20 bg-gradient-to-br from-accent-600 to-accent-800 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-white rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-white rounded-full blur-3xl animate-pulse delay-1000"></div>
        </div>
        
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-5xl font-bold text-white mb-6">
                Unisciti alla Community di Poeti
            </h2>
            <p class="text-xl text-accent-100 mb-8 max-w-2xl mx-auto">
                Condividi le tue poesie, partecipa ad eventi, trova opportunità e 
                connettiti con altri appassionati di letteratura.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white text-accent-700 font-semibold rounded-xl hover:bg-accent-50 transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                    Registrati Gratis
                </a>
                <a href="{{ route('about') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white/10 backdrop-blur-sm text-white font-semibold rounded-xl border-2 border-white/50 hover:bg-white/20 transition-all duration-300 hover:scale-105">
                    Scopri di Più
                </a>
            </div>
        </div>
    </section>

    <!-- Custom Animations -->
    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.8s ease-out forwards;
        }

        .animate-fade-in-delay-1 {
            animation: fade-in 0.8s ease-out 0.3s forwards;
        }

        .animate-fade-in-delay-2 {
            animation: fade-in 0.8s ease-out 0.6s forwards;
        }

        .delay-700 {
            animation-delay: 700ms;
        }

        .delay-1000 {
            animation-delay: 1000ms;
        }

        .text-gradient-light {
            background: linear-gradient(135deg, #fce8e6, #f9d5d2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
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
</x-layouts.app>
