<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="h-full bg-neutral-50 dark:bg-neutral-950 antialiased" x-data="{ 
    sidebarOpen: true, 
    notificationsOpen: false,
    messagesOpen: false,
    createPostOpen: false 
}">
    <div class="flex h-full">
        <!-- Sidebar Sinistra - Navigazione Principale -->
        <aside class="hidden lg:flex lg:flex-col lg:w-72 xl:w-80 bg-white dark:bg-neutral-900 border-r border-neutral-200 dark:border-neutral-800 fixed h-full z-30">
            <!-- Logo -->
            <div class="flex items-center justify-between px-6 py-5 border-b border-neutral-200 dark:border-neutral-800">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-accent-500 to-accent-700 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                        S
                    </div>
                    <span class="text-xl font-bold text-neutral-900 dark:text-white">SLAMIN</span>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                <!-- Home -->
                <a href="{{ route('home') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-all duration-200 group">
                    <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="font-medium">Home</span>
                </a>

                <!-- Esplora -->
                <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-xl text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-all duration-200 group">
                    <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                    </svg>
                    <span class="font-medium">Esplora</span>
                </a>

                <!-- Poesie -->
                <a href="{{ route('poems.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-all duration-200 group">
                    <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="font-medium">Le Mie Poesie</span>
                </a>

                <!-- Eventi -->
                <a href="{{ route('events.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-all duration-200 group relative">
                    <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="font-medium">Eventi</span>
                    <span class="ml-auto bg-accent-500 text-white text-xs font-bold px-2 py-1 rounded-full">3</span>
                </a>

                <!-- Articoli -->
                <a href="{{ route('articles.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-all duration-200 group">
                    <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    <span class="font-medium">Articoli</span>
                </a>

                <!-- Galleria -->
                <a href="{{ route('gallery.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-all duration-200 group">
                    <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="font-medium">Galleria</span>
                </a>

                <!-- Gigs -->
                <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-xl text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-all duration-200 group">
                    <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="font-medium">Gigs</span>
                </a>

                <div class="border-t border-neutral-200 dark:border-neutral-800 my-4"></div>

                <!-- Messaggi -->
                <a href="#" @click.prevent="messagesOpen = true" class="flex items-center gap-4 px-4 py-3 rounded-xl text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-all duration-200 group relative">
                    <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                    <span class="font-medium">Messaggi</span>
                    <span class="ml-auto bg-accent-500 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full">5</span>
                </a>

                <!-- Notifiche -->
                <a href="#" @click.prevent="notificationsOpen = true" class="flex items-center gap-4 px-4 py-3 rounded-xl text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-all duration-200 group relative">
                    <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="font-medium">Notifiche</span>
                    <span class="ml-auto bg-secondary-600 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full">12</span>
                </a>

                <!-- Salvati -->
                <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-xl text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-all duration-200 group">
                    <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                    </svg>
                    <span class="font-medium">Salvati</span>
                </a>

                <!-- Profilo -->
                <a href="{{ route('profile') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-all duration-200 group">
                    <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span class="font-medium">Profilo</span>
                </a>
            </nav>

            <!-- Create Post Button -->
            <div class="p-4 border-t border-neutral-200 dark:border-neutral-800">
                <button @click="createPostOpen = true" class="w-full bg-accent-500 hover:bg-accent-600 text-white font-semibold py-3 rounded-xl transition-all duration-300 hover:scale-105 hover:shadow-lg flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Crea Post
                </button>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 lg:ml-72 xl:ml-80 lg:mr-80 xl:mr-96">
            <!-- Top Bar Mobile/Tablet -->
            <header class="sticky top-0 z-20 bg-white/80 dark:bg-neutral-900/80 backdrop-blur-lg border-b border-neutral-200 dark:border-neutral-800 lg:hidden">
                <div class="flex items-center justify-between px-4 py-3">
                    <button class="p-2 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <div class="text-xl font-bold">SLAMIN</div>
                    <button @click="notificationsOpen = true" class="p-2 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-lg relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-accent-500 rounded-full"></span>
                    </button>
                </div>
            </header>

            <!-- Content -->
            <div class="min-h-screen">
                {{ $slot }}
            </div>
        </main>

        <!-- Sidebar Destra - Widgets -->
        <aside class="hidden lg:flex lg:flex-col lg:w-80 xl:w-96 bg-white dark:bg-neutral-900 border-l border-neutral-200 dark:border-neutral-800 fixed right-0 h-full overflow-y-auto z-20">
            <div class="p-6 space-y-6">
                <!-- Search -->
                <div class="relative">
                    <input type="text" placeholder="Cerca poeti, poesie, eventi..." class="w-full pl-12 pr-4 py-3 bg-neutral-100 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-500 text-neutral-900 dark:text-white placeholder-neutral-500 transition-all">
                    <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>

                <!-- Trending Topics -->
                <div class="bg-neutral-50 dark:bg-neutral-800 rounded-2xl p-5">
                    <h3 class="font-bold text-neutral-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-accent-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                        </svg>
                        Trending
                    </h3>
                    <div class="space-y-3">
                        @foreach(['#PoesiaContemporanea', '#SlamPoetry', '#VersiLiberi', '#Haiku', '#SonnettoModerno'] as $index => $tag)
                        <div class="flex items-center justify-between py-2 hover:bg-white dark:hover:bg-neutral-900 px-3 rounded-lg transition-colors cursor-pointer">
                            <div>
                                <div class="font-semibold text-neutral-900 dark:text-white text-sm">{{ $tag }}</div>
                                <div class="text-xs text-neutral-500 dark:text-neutral-400">{{ rand(100, 999) }} post</div>
                            </div>
                            <div class="text-xs font-bold text-accent-600">{{ $index + 1 }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Suggested Poets -->
                <div class="bg-neutral-50 dark:bg-neutral-800 rounded-2xl p-5">
                    <h3 class="font-bold text-neutral-900 dark:text-white mb-4">Poeti Suggeriti</h3>
                    <div class="space-y-4">
                        @for($i = 1; $i <= 4; $i++)
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br {{ ['from-accent-400 to-accent-600', 'from-primary-400 to-primary-600', 'from-secondary-400 to-secondary-600', 'from-accent-300 to-accent-500'][$i-1] }} flex-shrink-0"></div>
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-neutral-900 dark:text-white text-sm">Poeta {{ $i }}</div>
                                <div class="text-xs text-neutral-500 dark:text-neutral-400">{{ rand(100, 999) }} followers</div>
                            </div>
                            <button class="px-4 py-2 bg-accent-500 hover:bg-accent-600 text-white text-xs font-medium rounded-lg transition-colors">
                                Segui
                            </button>
                        </div>
                        @endfor
                    </div>
                </div>

                <!-- Active Now -->
                <div class="bg-neutral-50 dark:bg-neutral-800 rounded-2xl p-5">
                    <h3 class="font-bold text-neutral-900 dark:text-white mb-4 flex items-center gap-2">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                        </span>
                        Online Ora
                    </h3>
                    <div class="space-y-3">
                        @for($i = 1; $i <= 5; $i++)
                        <div class="flex items-center gap-3 hover:bg-white dark:hover:bg-neutral-900 p-2 rounded-lg transition-colors cursor-pointer">
                            <div class="relative">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-secondary-400 to-secondary-600"></div>
                                <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white dark:border-neutral-800 rounded-full"></span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-medium text-neutral-900 dark:text-white text-sm">User {{ $i }}</div>
                                <div class="text-xs text-neutral-500 dark:text-neutral-400 truncate">Scrivendo...</div>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>

                <!-- Footer Links -->
                <div class="text-xs text-neutral-500 dark:text-neutral-400 space-y-2 px-2">
                    <div class="flex flex-wrap gap-x-3 gap-y-1">
                        <a href="{{ route('about') }}" class="hover:underline">Chi Siamo</a>
                        <a href="{{ route('terms') }}" class="hover:underline">Termini</a>
                        <a href="{{ route('privacy') }}" class="hover:underline">Privacy</a>
                        <a href="{{ route('contact') }}" class="hover:underline">Contatti</a>
                    </div>
                    <div class="text-neutral-400 dark:text-neutral-500">
                        © {{ date('Y') }} SLAMIN. Tutti i diritti riservati.
                    </div>
                </div>
            </div>
        </aside>
    </div>

    <!-- Modal Crea Post -->
    <div x-show="createPostOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4"
         @click.self="createPostOpen = false"
         style="display: none;">
        <div class="bg-white dark:bg-neutral-800 rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-90">
            <div class="flex items-center justify-between p-6 border-b border-neutral-200 dark:border-neutral-700">
                <h3 class="text-xl font-bold text-neutral-900 dark:text-white">Crea Nuovo Post</h3>
                <button @click="createPostOpen = false" class="p-2 hover:bg-neutral-100 dark:hover:bg-neutral-700 rounded-lg transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <textarea rows="6" placeholder="Condividi una poesia, un pensiero, una storia..." class="w-full p-4 bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-500 text-neutral-900 dark:text-white resize-none"></textarea>
                <div class="flex items-center gap-2 mt-4">
                    <button class="p-3 hover:bg-neutral-100 dark:hover:bg-neutral-700 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </button>
                    <button class="p-3 hover:bg-neutral-100 dark:hover:bg-neutral-700 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                    </button>
                    <button class="p-3 hover:bg-neutral-100 dark:hover:bg-neutral-700 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                        </svg>
                    </button>
                    <button class="ml-auto px-6 py-3 bg-accent-500 hover:bg-accent-600 text-white font-semibold rounded-xl transition-colors">
                        Pubblica
                    </button>
                </div>
            </div>
        </div>
    </div>

    @livewireScripts
</body>
</html>

