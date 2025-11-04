<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Crimson+Pro:ital,wght@0,400;0,600;0,700;1,400;1,600&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <!-- Additional Head Content -->
    {{ $head ?? '' }}
</head>
<body class="antialiased bg-neutral-50 dark:bg-neutral-950 text-neutral-900 dark:text-neutral-100" 
      x-data="{ scrollY: 0 }" 
      @scroll.window="scrollY = window.scrollY">
    <!-- Navigation -->
    <x-layouts.navigation-modern />

    <!-- Main Content (no spacing) -->
    <main class="mt-0">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <x-layouts.footer-modern />

    <!-- Scripts -->
    @livewireScripts
    
    <!-- Additional Body Scripts -->
    {{ $scripts ?? '' }}

    <!-- Toast Notifications -->
    <div x-data="{ 
        show: false, 
        message: '', 
        type: 'success',
        showToast(data) {
            this.message = data.message;
            this.type = data.type || 'success';
            this.show = true;
            setTimeout(() => { this.show = false; }, 3000);
        }
    }"
    @notify.window="showToast($event.detail)"
    x-show="show"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-4"
    class="fixed bottom-4 right-4 z-50 max-w-sm">
        <div class="rounded-xl shadow-2xl overflow-hidden"
             :class="{
                'bg-green-500': type === 'success',
                'bg-blue-500': type === 'info',
                'bg-yellow-500': type === 'warning',
                'bg-red-500': type === 'error'
             }">
            <div class="p-4 flex items-center gap-3">
                <!-- Icon Success -->
                <svg x-show="type === 'success'" class="w-6 h-6 text-white flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <!-- Icon Warning -->
                <svg x-show="type === 'warning'" class="w-6 h-6 text-white flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <!-- Message -->
                <span x-text="message" class="text-white font-medium flex-1"></span>
                <!-- Close -->
                <button @click="show = false" class="text-white/80 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</body>
</html>

