<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600&family=Crimson+Pro:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="h-full bg-neutral-50 dark:bg-neutral-950 text-neutral-900 dark:text-neutral-100 overflow-hidden" 
      x-data="{ 
          scrollY: 0,
          mouseX: 0,
          mouseY: 0,
          activePoem: null,
          expanded: false
      }"
      @scroll.window="scrollY = window.scrollY"
      @mousemove.window="mouseX = $event.clientX; mouseY = $event.clientY">
    
    <!-- Cursor personalizzato -->
    <div class="fixed pointer-events-none z-[100] mix-blend-difference transition-all duration-300 ease-out"
         :style="`left: ${mouseX}px; top: ${mouseY}px; transform: translate(-50%, -50%);`">
        <div class="w-8 h-8 border-2 border-white rounded-full"></div>
    </div>

    <!-- Background con gradient animato -->
    <div class="fixed inset-0 pointer-events-none">
        <div class="absolute inset-0 bg-gradient-to-br from-accent-100/30 via-neutral-50 to-secondary-100/30 dark:from-accent-950/30 dark:via-neutral-950 dark:to-secondary-950/30"></div>
        
        <!-- Blob animati -->
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-accent-300/20 dark:bg-accent-700/10 rounded-full blur-3xl animate-blob"></div>
        <div class="absolute top-1/3 right-1/4 w-80 h-80 bg-secondary-300/20 dark:bg-secondary-700/10 rounded-full blur-3xl animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-1/4 left-1/3 w-72 h-72 bg-primary-300/20 dark:bg-primary-700/10 rounded-full blur-3xl animate-blob animation-delay-4000"></div>
    </div>

    <!-- Navigation Minimal Top -->
    <nav class="fixed top-0 left-0 right-0 z-50 mix-blend-difference">
        <div class="flex items-center justify-between p-8">
            <!-- Logo Minimal -->
            <a href="{{ route('home') }}" class="text-white font-light text-2xl tracking-widest hover:tracking-[0.3em] transition-all duration-500">
                SLAMIN
            </a>

            <!-- Menu Minimal -->
            <div class="flex items-center gap-12 text-white font-light text-sm">
                <a href="{{ route('poems.index') }}" class="hover:tracking-widest transition-all duration-300">VERSI</a>
                <a href="{{ route('events.index') }}" class="hover:tracking-widest transition-all duration-300">EVENTI</a>
                <a href="{{ route('profile') }}" class="hover:tracking-widest transition-all duration-300">PROFILO</a>
            </div>
        </div>
    </nav>

    <!-- Main Content - Layout Fluido -->
    <div class="h-screen overflow-y-scroll snap-y snap-mandatory scrollbar-hide" id="main-scroll">
        {{ $slot }}
    </div>

    <!-- Floating Action - Minimal -->
    <button class="fixed bottom-12 right-12 z-40 w-16 h-16 text-neutral-900 dark:text-white mix-blend-difference"
            @click="expanded = !expanded">
        <div class="relative w-full h-full">
            <span class="absolute top-1/2 left-0 right-0 h-px bg-current transition-all duration-500"
                  :class="expanded ? 'rotate-45' : ''"></span>
            <span class="absolute top-1/2 left-0 right-0 h-px bg-current transition-all duration-500"
                  :class="expanded ? '-rotate-45' : 'rotate-90'"></span>
        </div>
    </button>

    @livewireScripts

    <style>
        /* Hide scrollbar */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Cursor personalizzato */
        * {
            cursor: none !important;
        }

        /* Blob animation */
        @keyframes blob {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            25% {
                transform: translate(20px, -50px) scale(1.1);
            }
            50% {
                transform: translate(-20px, 20px) scale(0.9);
            }
            75% {
                transform: translate(50px, 50px) scale(1.05);
            }
        }

        .animate-blob {
            animation: blob 20s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        /* Smooth font rendering */
        body {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Selection */
        ::selection {
            background-color: rgba(224, 97, 85, 0.3);
            color: inherit;
        }
    </style>
</body>
</html>

