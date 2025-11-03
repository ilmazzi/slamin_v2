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
<body class="bg-neutral-50 dark:bg-neutral-950 text-neutral-900 dark:text-neutral-100" 
      x-data="{ 
          scrollY: 0,
          showMobileMenu: false,
          activeSection: 'feed'
      }"
      @scroll.window="scrollY = window.scrollY">
    
    <!-- Fixed Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
         :class="scrollY > 50 ? 'bg-white/80 dark:bg-neutral-900/80 backdrop-blur-xl shadow-sm' : 'bg-transparent'">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 rounded-2xl flex items-center justify-center text-white font-bold text-lg shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-110">
                        S
                    </div>
                    <div>
                        <div class="font-bold text-lg text-neutral-900 dark:text-white">SLAMIN</div>
                        <div class="text-xs text-neutral-500 dark:text-neutral-400 -mt-1">Poetry Network</div>
                    </div>
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="#feed" class="text-neutral-700 dark:text-neutral-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors font-medium">Feed</a>
                    <a href="#discover" class="text-neutral-700 dark:text-neutral-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors font-medium">Scopri</a>
                    <a href="{{ route('events.index') }}" class="text-neutral-700 dark:text-neutral-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors font-medium">Eventi</a>
                    <a href="{{ route('poems.index') }}" class="text-neutral-700 dark:text-neutral-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors font-medium">Poesie</a>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-4">
                    <button class="hidden md:flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-primary-500 to-primary-700 hover:from-primary-600 hover:to-primary-800 text-white rounded-xl font-medium transition-all duration-300 hover:shadow-lg hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Crea
                    </button>
                    <button class="relative p-2 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-xl transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-primary-500 rounded-full"></span>
                    </button>
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-400 to-primary-600 cursor-pointer hover:scale-110 transition-transform"></div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-20">
        {{ $slot }}
    </main>

    <!-- Floating Create Button (Mobile) -->
    <button class="md:hidden fixed bottom-6 right-6 z-40 w-14 h-14 bg-gradient-to-br from-primary-500 to-primary-700 rounded-full shadow-2xl flex items-center justify-center text-white hover:scale-110 transition-transform">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
    </button>

    @livewireScripts
</body>
</html>

