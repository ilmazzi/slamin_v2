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

    <!-- Main Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <x-layouts.footer-modern />

    <!-- Scripts -->
    @livewireScripts
    
    <!-- Additional Body Scripts -->
    {{ $scripts ?? '' }}
</body>
</html>

