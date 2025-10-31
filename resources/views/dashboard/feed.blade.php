<x-layouts.social>
    <x-slot name="title">Feed</x-slot>

    <div class="max-w-3xl mx-auto px-4 py-6 space-y-6">
        <!-- Stories/Highlights -->
        <div class="bg-white dark:bg-neutral-900 rounded-2xl p-6 border border-neutral-200 dark:border-neutral-800">
            <div class="flex gap-4 overflow-x-auto pb-2 scrollbar-hide">
                <!-- Add Story -->
                <div class="flex flex-col items-center gap-2 flex-shrink-0 cursor-pointer group">
                    <div class="w-20 h-20 rounded-full border-2 border-dashed border-neutral-300 dark:border-neutral-700 flex items-center justify-center group-hover:border-accent-500 transition-colors">
                        <svg class="w-8 h-8 text-neutral-400 group-hover:text-accent-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <span class="text-xs text-neutral-600 dark:text-neutral-400 font-medium">La Tua</span>
                </div>

                <!-- Stories -->
                @for($i = 1; $i <= 8; $i++)
                <div class="flex flex-col items-center gap-2 flex-shrink-0 cursor-pointer group">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br {{ ['from-accent-400 to-accent-600', 'from-primary-400 to-primary-600', 'from-secondary-400 to-secondary-600'][$i % 3] }} p-1 ring-4 ring-accent-500/20 group-hover:ring-accent-500/40 transition-all">
                        <div class="w-full h-full rounded-full bg-neutral-200 dark:bg-neutral-700"></div>
                    </div>
                    <span class="text-xs text-neutral-600 dark:text-neutral-400 font-medium">Poeta {{ $i }}</span>
                </div>
                @endfor
            </div>
        </div>

        <!-- Create Post Quick -->
        <div class="bg-white dark:bg-neutral-900 rounded-2xl p-6 border border-neutral-200 dark:border-neutral-800">
            <div class="flex gap-4">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-accent-500 to-accent-700 flex-shrink-0"></div>
                <button @click="createPostOpen = true" class="flex-1 text-left px-4 py-3 bg-neutral-100 dark:bg-neutral-800 rounded-xl text-neutral-500 dark:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-neutral-700 transition-colors">
                    Cosa stai scrivendo oggi?
                </button>
            </div>
            <div class="flex gap-4 mt-4 pt-4 border-t border-neutral-200 dark:border-neutral-700">
                <button class="flex-1 flex items-center justify-center gap-2 py-2 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-lg transition-colors text-neutral-600 dark:text-neutral-400 hover:text-accent-600 dark:hover:text-accent-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="text-sm font-medium">Poesia</span>
                </button>
                <button class="flex-1 flex items-center justify-center gap-2 py-2 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-lg transition-colors text-neutral-600 dark:text-neutral-400 hover:text-secondary-600 dark:hover:text-secondary-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm font-medium">Foto</span>
                </button>
                <button class="flex-1 flex items-center justify-center gap-2 py-2 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-lg transition-colors text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm font-medium">Evento</span>
                </button>
            </div>
        </div>

        <!-- Feed Posts -->
        @for($p = 1; $p <= 5; $p++)
        <article class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 overflow-hidden hover:border-neutral-300 dark:hover:border-neutral-700 transition-colors">
            <!-- Post Header -->
            <div class="p-6 pb-4">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br {{ ['from-accent-400 to-accent-600', 'from-primary-400 to-primary-600', 'from-secondary-400 to-secondary-600'][$p % 3] }} flex items-center justify-center text-white font-bold cursor-pointer hover:scale-110 transition-transform">
                            {{ chr(64 + $p) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h4 class="font-semibold text-neutral-900 dark:text-white hover:underline cursor-pointer">Poeta {{ $p }}</h4>
                                @if($p <= 2)
                                <svg class="w-5 h-5 text-accent-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                @endif
                            </div>
                            <div class="text-sm text-neutral-500 dark:text-neutral-400">{{ $p }}h fa · 📍 {{ ['Milano', 'Roma', 'Firenze', 'Bologna', 'Napoli'][$p % 5] }}</div>
                        </div>
                    </div>
                    <button class="p-2 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-lg transition-colors">
                        <svg class="w-5 h-5 text-neutral-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                        </svg>
                    </button>
                </div>

                <!-- Post Content -->
                <div class="mb-4">
                    @if($p % 3 == 1)
                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-2 italic">"{{ ['Il Silenzio della Luna', 'Vento tra i Rami', 'Alba Nascente'][$p % 3] }}"</h3>
                    <p class="text-neutral-700 dark:text-neutral-300 leading-relaxed">
                        Nel silenzio della notte eterna,<br>
                        dove le stelle danzano lente,<br>
                        il cuore trova la sua poesia,<br>
                        tra versi d'amore e malinconia.<br>
                        <br>
                        Le parole fluiscono come fiume,<br>
                        portando con sé emozioni profonde,<br>
                        in questo spazio infinito di luce,<br>
                        dove l'anima finalmente si apre.
                    </p>
                    @else
                    <p class="text-neutral-700 dark:text-neutral-300 leading-relaxed">
                        Oggi voglio condividere con voi una riflessione sulla bellezza della poesia contemporanea 
                        e su come questa forma d'arte continui a evolversi, portando con sé nuove voci e prospettive. 
                        🌟 #poesia #riflessioni #letteratura
                    </p>
                    @endif
                </div>

                <!-- Post Image (se presente) -->
                @if($p % 2 == 0)
                <div class="mb-4 -mx-6">
                    <div class="h-96 bg-gradient-to-br {{ ['from-accent-300 to-accent-500', 'from-primary-300 to-primary-500', 'from-secondary-300 to-secondary-500'][$p % 3] }} cursor-pointer hover:opacity-90 transition-opacity"></div>
                </div>
                @endif

                <!-- Post Stats -->
                <div class="flex items-center justify-between text-sm text-neutral-500 dark:text-neutral-400 pb-4">
                    <div class="flex items-center gap-1">
                        <div class="flex -space-x-2">
                            <div class="w-6 h-6 rounded-full bg-accent-500 border-2 border-white dark:border-neutral-900"></div>
                            <div class="w-6 h-6 rounded-full bg-secondary-500 border-2 border-white dark:border-neutral-900"></div>
                            <div class="w-6 h-6 rounded-full bg-primary-500 border-2 border-white dark:border-neutral-900"></div>
                        </div>
                        <span class="ml-2">{{ rand(50, 300) }} reactions</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <span>{{ rand(10, 50) }} commenti</span>
                        <span>{{ rand(5, 30) }} condivisioni</span>
                    </div>
                </div>

                <!-- Post Actions -->
                <div class="flex items-center border-t border-neutral-200 dark:border-neutral-700 pt-2 -mx-6 px-6">
                    <button class="flex-1 flex items-center justify-center gap-2 py-3 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-lg transition-all duration-200 text-neutral-600 dark:text-neutral-400 hover:text-accent-600 dark:hover:text-accent-400 group">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span class="font-medium">Mi piace</span>
                    </button>
                    <button class="flex-1 flex items-center justify-center gap-2 py-3 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-lg transition-all duration-200 text-neutral-600 dark:text-neutral-400 hover:text-secondary-600 dark:hover:text-secondary-400 group">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <span class="font-medium">Commenta</span>
                    </button>
                    <button class="flex-1 flex items-center justify-center gap-2 py-3 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-lg transition-all duration-200 text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-400 group">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                        </svg>
                        <span class="font-medium">Condividi</span>
                    </button>
                    <button class="flex items-center justify-center gap-2 px-4 py-3 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-lg transition-all duration-200 text-neutral-600 dark:text-neutral-400 group">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </article>
        @endfor

        <!-- Load More -->
        <div class="flex justify-center py-8">
            <button class="px-8 py-3 bg-white dark:bg-neutral-900 border-2 border-neutral-200 dark:border-neutral-700 rounded-xl font-medium text-neutral-700 dark:text-neutral-300 hover:border-accent-500 hover:text-accent-600 dark:hover:text-accent-400 transition-all duration-300 hover:scale-105">
                Carica Altri Post
            </button>
        </div>
    </div>

    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</x-layouts.social>

