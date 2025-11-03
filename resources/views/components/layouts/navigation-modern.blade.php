<nav class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 bg-white/95 dark:bg-neutral-900/95 backdrop-blur-md shadow-lg"
     x-data="{ isOpen: false }">
    
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 md:h-20">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center group">
                <img src="{{ asset('assets/images/Logo_orizzontale_nerosubianco.png') }}" 
                     alt="{{ config('app.name') }}" 
                     class="h-8 md:h-10 w-auto group-hover:scale-105 transition-transform">
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center gap-6">
                <a href="{{ route('home') }}" 
                   class="flex items-center gap-2 font-medium text-neutral-700 dark:text-neutral-300 transition-colors hover:text-primary-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Home</span>
                </a>
                <a href="{{ route('events.index') }}" 
                   class="flex items-center gap-2 font-medium text-neutral-700 dark:text-neutral-300 transition-colors hover:text-primary-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Eventi</span>
                </a>
                <a href="{{ route('poems.index') }}" 
                   class="flex items-center gap-2 font-medium text-neutral-700 dark:text-neutral-300 transition-colors hover:text-primary-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    <span>Poesie</span>
                </a>
                <a href="{{ route('articles.index') }}" 
                   class="flex items-center gap-2 font-medium text-neutral-700 dark:text-neutral-300 transition-colors hover:text-primary-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    <span>Articoli</span>
                </a>
                <a href="{{ route('gallery.index') }}" 
                   class="flex items-center gap-2 font-medium text-neutral-700 dark:text-neutral-300 transition-colors hover:text-primary-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Galleria</span>
                </a>
                @auth
                <a href="#" 
                   class="flex items-center gap-2 font-medium text-neutral-700 dark:text-neutral-300 transition-colors hover:text-primary-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span>Gruppi</span>
                </a>
                <a href="#" 
                   class="flex items-center gap-2 font-medium text-neutral-700 dark:text-neutral-300 transition-colors hover:text-primary-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <span>Forum</span>
                </a>
                @endauth
            </div>

            <!-- Actions -->
            <div class="hidden md:flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard.index') }}" 
                       class="px-6 py-2.5 bg-primary-600 text-white rounded-full font-semibold transition-all hover:scale-105">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                       class="font-medium text-neutral-700 dark:text-neutral-300 transition-colors hover:text-primary-600">
                        Accedi
                    </a>
                    <a href="{{ route('register') }}" 
                       class="px-6 py-2.5 bg-primary-600 text-white rounded-full font-semibold transition-all hover:scale-105">
                        Registrati
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <button @click="isOpen = !isOpen" 
                    class="lg:hidden p-2 rounded-lg text-neutral-900 dark:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!isOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="isOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div x-show="isOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="lg:hidden py-4 space-y-2">
            <a href="{{ route('home') }}" class="block px-4 py-2 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">Home</a>
            <a href="{{ route('events.index') }}" class="block px-4 py-2 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">Eventi</a>
            <a href="{{ route('poems.index') }}" class="block px-4 py-2 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">Poesie</a>
            <a href="{{ route('articles.index') }}" class="block px-4 py-2 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">Articoli</a>
            <a href="{{ route('gallery.index') }}" class="block px-4 py-2 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">Galleria</a>
            @auth
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">Gruppi</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">Forum</a>
                <div class="pt-2 mt-2 border-t border-neutral-200 dark:border-neutral-700">
                    <a href="{{ route('dashboard.index') }}" class="block px-4 py-2 bg-primary-600 text-white rounded-lg text-center font-semibold">Dashboard</a>
                </div>
            @else
                <div class="pt-2 mt-2 border-t border-neutral-200 dark:border-neutral-700 space-y-2">
                    <a href="{{ route('login') }}" class="block px-4 py-2 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">Accedi</a>
                    <a href="{{ route('register') }}" class="block px-4 py-2 bg-primary-600 text-white rounded-lg text-center font-semibold">Registrati</a>
                </div>
            @endauth
        </div>
    </div>
</nav>
