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

    {{ $head ?? '' }}
</head>
<body class="antialiased bg-neutral-50 dark:bg-neutral-950 text-neutral-900 dark:text-neutral-100 overflow-x-hidden" 
      x-data="{ scrollY: 0, sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true' }" 
      @scroll.window="scrollY = window.scrollY"
      @sidebar-changed.window="sidebarCollapsed = $event.detail.collapsed">
    
    <!-- Top Bar -->
    <x-layouts.topbar />

    <!-- Sidebar -->
    <x-layouts.sidebar />

    <!-- Main Content Area -->
    <main class="pt-16 transition-all duration-300 lg:ml-0 overflow-x-hidden"
          :class="sidebarCollapsed ? 'lg:ml-20' : 'lg:ml-64'">
        <div class="min-h-screen overflow-visible">
            {{ $slot }}
        </div>

        <!-- Footer -->
        <x-layouts.footer-modern />
    </main>

    @livewireScripts
    
    {{ $scripts ?? '' }}
</body>
</html>
