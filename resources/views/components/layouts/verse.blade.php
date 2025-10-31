<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Crimson+Pro:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="h-full bg-neutral-50 dark:bg-neutral-950 overflow-hidden" 
      x-data="{ 
          activePane: 'feed',
          expandedPost: null,
          createMode: false,
          cursorX: 0,
          cursorY: 0
      }"
      @mousemove="cursorX = $event.clientX; cursorY = $event.clientY">
    
    <!-- Floating Navigation Orb (Bottom Left) -->
    <nav class="fixed bottom-8 left-8 z-50">
        <div class="relative">
            <!-- Main Orb -->
            <button @click="activePane = activePane === 'menu' ? 'feed' : 'menu'" 
                    class="w-16 h-16 bg-gradient-to-br from-accent-500 to-accent-700 rounded-full shadow-2xl hover:scale-110 transition-all duration-500 flex items-center justify-center text-white relative overflow-hidden group">
                <div class="absolute inset-0 bg-white/20 rounded-full scale-0 group-hover:scale-100 transition-transform duration-500"></div>
                <svg class="w-8 h-8 relative z-10 transition-transform duration-500" :class="activePane === 'menu' ? 'rotate-45' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
            </button>

            <!-- Expanding Menu -->
            <div x-show="activePane === 'menu'" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="absolute bottom-20 left-0 bg-white dark:bg-neutral-900 rounded-3xl shadow-2xl p-4 min-w-[280px] border border-neutral-200 dark:border-neutral-800">
                <div class="space-y-2">
                    <a href="{{ route('home') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl hover:bg-accent-50 dark:hover:bg-accent-900/20 transition-all duration-300 group">
                        <div class="w-10 h-10 bg-gradient-to-br from-accent-400 to-accent-600 rounded-xl flex items-center justify-center text-white group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </div>
                        <span class="font-semibold text-neutral-900 dark:text-white">Home</span>
                    </a>
                    <a href="{{ route('poems.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl hover:bg-secondary-50 dark:hover:bg-secondary-900/20 transition-all duration-300 group">
                        <div class="w-10 h-10 bg-gradient-to-br from-secondary-400 to-secondary-600 rounded-xl flex items-center justify-center text-white group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <span class="font-semibold text-neutral-900 dark:text-white">Poesie</span>
                    </a>
                    <a href="{{ route('events.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all duration-300 group">
                        <div class="w-10 h-10 bg-gradient-to-br from-primary-400 to-primary-600 rounded-xl flex items-center justify-center text-white group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <span class="font-semibold text-neutral-900 dark:text-white">Eventi</span>
                        <span class="ml-auto bg-accent-500 text-white text-xs font-bold px-2 py-1 rounded-full">3</span>
                    </a>
                    <a href="{{ route('profile') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-all duration-300 group">
                        <div class="w-10 h-10 bg-gradient-to-br from-neutral-400 to-neutral-600 rounded-xl flex items-center justify-center text-white group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <span class="font-semibold text-neutral-900 dark:text-white">Profilo</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Floating Action Buttons (Right Side) -->
    <div class="fixed right-8 top-1/2 -translate-y-1/2 z-40 flex flex-col gap-4">
        <!-- Crea Poesia -->
        <button @click="createMode = !createMode" 
                class="group relative w-14 h-14 bg-gradient-to-br from-accent-500 to-accent-700 rounded-2xl shadow-lg hover:shadow-2xl hover:scale-110 transition-all duration-500 flex items-center justify-center text-white"
                :class="createMode ? 'rotate-45' : ''">
            <svg class="w-6 h-6 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span class="absolute right-16 bg-neutral-900 text-white text-sm px-3 py-2 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                Nuova Poesia
            </span>
        </button>

        <!-- Notifiche -->
        <button class="group relative w-14 h-14 bg-gradient-to-br from-secondary-500 to-secondary-700 rounded-2xl shadow-lg hover:shadow-2xl hover:scale-110 transition-all duration-500 flex items-center justify-center text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <span class="absolute -top-1 -right-1 w-5 h-5 bg-accent-500 rounded-full flex items-center justify-center text-xs font-bold animate-pulse">7</span>
            <span class="absolute right-16 bg-neutral-900 text-white text-sm px-3 py-2 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                Notifiche
            </span>
        </button>

        <!-- Messaggi -->
        <button class="group relative w-14 h-14 bg-gradient-to-br from-primary-500 to-primary-700 rounded-2xl shadow-lg hover:shadow-2xl hover:scale-110 transition-all duration-500 flex items-center justify-center text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
            </svg>
            <span class="absolute -top-1 -right-1 w-5 h-5 bg-accent-500 rounded-full flex items-center justify-center text-xs font-bold">3</span>
            <span class="absolute right-16 bg-neutral-900 text-white text-sm px-3 py-2 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                Messaggi
            </span>
        </button>
    </div>

    <!-- Main Container - Layout Asimmetrico -->
    <div class="h-full overflow-hidden relative">
        <!-- Background Animated Gradient -->
        <div class="absolute inset-0 bg-gradient-to-br from-neutral-50 via-accent-50/20 to-secondary-50/20 dark:from-neutral-950 dark:via-accent-950/20 dark:to-secondary-950/20"></div>
        
        <!-- Floating Particles Background -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            @for($i = 1; $i <= 20; $i++)
            <div class="particle absolute w-2 h-2 bg-accent-300/30 dark:bg-accent-700/30 rounded-full" 
                 style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation: float {{ rand(15, 30) }}s infinite linear {{ rand(0, 10) }}s;"></div>
            @endfor
        </div>

        <!-- Content Wrapper -->
        <div class="relative h-full overflow-y-auto custom-scrollbar">
            <!-- Top Floating Header -->
            <header class="sticky top-0 z-30 backdrop-blur-xl bg-white/60 dark:bg-neutral-900/60 border-b border-neutral-200/50 dark:border-neutral-800/50">
                <div class="max-w-7xl mx-auto px-8 py-4">
                    <div class="flex items-center justify-between">
                        <!-- Logo Animato -->
                        <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-br from-accent-500 to-accent-700 rounded-2xl blur group-hover:blur-xl transition-all duration-500 opacity-50"></div>
                                <div class="relative w-12 h-12 bg-gradient-to-br from-accent-500 to-accent-700 rounded-2xl flex items-center justify-center text-white font-bold text-xl shadow-lg group-hover:rotate-12 transition-transform duration-500">
                                    S
                                </div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-neutral-900 dark:text-white tracking-tight">SLAMIN</div>
                                <div class="text-xs text-neutral-500 dark:text-neutral-400">Poetry Network</div>
                            </div>
                        </a>

                        <!-- Search Centrale Floating -->
                        <div class="hidden md:flex items-center flex-1 max-w-xl mx-12">
                            <div class="relative w-full">
                                <input type="text" 
                                       placeholder="Cerca versi, poeti, emozioni..." 
                                       class="w-full pl-12 pr-4 py-3 bg-neutral-100/80 dark:bg-neutral-800/80 backdrop-blur-xl border border-neutral-300/50 dark:border-neutral-700/50 rounded-2xl focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-transparent text-neutral-900 dark:text-white placeholder-neutral-400 transition-all duration-300 focus:scale-105">
                                <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>

                        <!-- User Actions -->
                        <div class="flex items-center gap-3">
                            <button class="relative p-3 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-xl transition-colors group">
                                <svg class="w-6 h-6 text-neutral-600 dark:text-neutral-400 group-hover:text-accent-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                <span class="absolute top-2 right-2 w-2 h-2 bg-accent-500 rounded-full animate-pulse"></span>
                            </button>
                            <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-accent-400 to-accent-600 cursor-pointer hover:scale-110 transition-transform duration-300"></div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content - Layout a Mosaico Asimmetrico -->
            <div class="max-w-7xl mx-auto px-8 py-8">
                <div class="grid grid-cols-12 gap-6 auto-rows-auto">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Create Panel -->
    <div x-show="createMode" 
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 translate-x-full"
         x-transition:enter-end="opacity-100 translate-x-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-x-0"
         x-transition:leave-end="opacity-0 translate-x-full"
         class="fixed right-0 top-0 h-full w-full md:w-[500px] bg-white/95 dark:bg-neutral-900/95 backdrop-blur-2xl shadow-2xl z-50 border-l border-neutral-200 dark:border-neutral-800"
         style="display: none;">
        <div class="h-full flex flex-col">
            <!-- Header -->
            <div class="flex items-center justify-between p-6 border-b border-neutral-200 dark:border-neutral-800">
                <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">Componi</h2>
                <button @click="createMode = false" class="p-2 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-xl transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Content -->
            <div class="flex-1 overflow-y-auto p-6 space-y-6">
                <!-- Type Selector -->
                <div class="grid grid-cols-3 gap-3">
                    <button class="p-4 bg-accent-100 dark:bg-accent-900/30 border-2 border-accent-500 rounded-2xl flex flex-col items-center gap-2 hover:scale-105 transition-transform">
                        <svg class="w-8 h-8 text-accent-600 dark:text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span class="text-sm font-semibold text-accent-700 dark:text-accent-300">Poesia</span>
                    </button>
                    <button class="p-4 bg-neutral-100 dark:bg-neutral-800 rounded-2xl flex flex-col items-center gap-2 hover:scale-105 transition-transform hover:bg-secondary-100 dark:hover:bg-secondary-900/30">
                        <svg class="w-8 h-8 text-neutral-600 dark:text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                        <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">Articolo</span>
                    </button>
                    <button class="p-4 bg-neutral-100 dark:bg-neutral-800 rounded-2xl flex flex-col items-center gap-2 hover:scale-105 transition-transform hover:bg-primary-100 dark:hover:bg-primary-900/30">
                        <svg class="w-8 h-8 text-neutral-600 dark:text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">Media</span>
                    </button>
                </div>

                <!-- Textarea -->
                <div>
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Titolo</label>
                    <input type="text" placeholder='"Il tuo verso più bello..."' class="w-full px-4 py-3 bg-neutral-100 dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-500 text-neutral-900 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Versi</label>
                    <textarea rows="12" 
                              placeholder="Scrivi la tua poesia...&#10;&#10;Nel silenzio della notte,&#10;le parole danzano leggere..." 
                              class="w-full px-4 py-3 bg-neutral-100 dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-500 text-neutral-900 dark:text-white resize-none font-serif"
                              style="font-family: 'Crimson Pro', serif;"></textarea>
                </div>

                <!-- Tags -->
                <div>
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Tags</label>
                    <div class="flex flex-wrap gap-2 mb-2">
                        @foreach(['#amore', '#natura', '#malinconia', '#speranza'] as $tag)
                        <span class="px-3 py-1 bg-secondary-100 dark:bg-secondary-900/30 text-secondary-700 dark:text-secondary-300 rounded-full text-sm cursor-pointer hover:bg-secondary-200 dark:hover:bg-secondary-900/50 transition-colors">
                            {{ $tag }}
                        </span>
                        @endforeach
                    </div>
                    <input type="text" placeholder="Aggiungi tag..." class="w-full px-4 py-2 bg-neutral-100 dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-700 rounded-lg text-sm">
                </div>
            </div>

            <!-- Footer -->
            <div class="p-6 border-t border-neutral-200 dark:border-neutral-800 bg-white/50 dark:bg-neutral-900/50 backdrop-blur-xl">
                <button class="w-full py-4 bg-gradient-to-r from-accent-500 to-accent-700 hover:from-accent-600 hover:to-accent-800 text-white font-semibold rounded-2xl transition-all duration-300 hover:scale-105 hover:shadow-xl">
                    Pubblica Poesia
                </button>
            </div>
        </div>
    </div>

    @livewireScripts

    <style>
        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) scale(1);
                opacity: 0.3;
            }
            25% {
                transform: translate(30px, -30px) scale(1.1);
                opacity: 0.5;
            }
            50% {
                transform: translate(-20px, -60px) scale(0.9);
                opacity: 0.4;
            }
            75% {
                transform: translate(40px, -40px) scale(1.05);
                opacity: 0.6;
            }
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #e06155, #cc4237);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #cc4237, #ab352c);
        }
    </style>
</body>
</html>

