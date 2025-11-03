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
                   class="font-medium text-neutral-700 dark:text-neutral-300 transition-colors hover:text-primary-600">
                    Home
                </a>
                <a href="{{ route('events.index') }}" 
                   class="font-medium text-neutral-700 dark:text-neutral-300 transition-colors hover:text-primary-600">
                    Eventi
                </a>
                <a href="{{ route('poems.index') }}" 
                   class="font-medium text-neutral-700 dark:text-neutral-300 transition-colors hover:text-primary-600">
                    Poesie
                </a>
                <a href="{{ route('articles.index') }}" 
                   class="font-medium text-neutral-700 dark:text-neutral-300 transition-colors hover:text-primary-600">
                    Articoli
                </a>
                <a href="{{ route('gallery.index') }}" 
                   class="font-medium text-neutral-700 dark:text-neutral-300 transition-colors hover:text-primary-600">
                    Galleria
                </a>
                @auth
                <a href="#" 
                   class="font-medium text-neutral-700 dark:text-neutral-300 transition-colors hover:text-primary-600">
                    Gruppi
                </a>
                <a href="#" 
                   class="font-medium text-neutral-700 dark:text-neutral-300 transition-colors hover:text-primary-600">
                    Forum
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
