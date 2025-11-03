<nav class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
     x-data="{ isOpen: false, scrolled: false }"
     @scroll.window="scrolled = window.scrollY > 50"
     :class="scrolled ? 'bg-white/95 dark:bg-neutral-900/95 backdrop-blur-md shadow-lg' : 'bg-transparent'">
    
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 md:h-20">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="relative">
                    <div class="absolute -inset-1 bg-gradient-to-r from-primary-500 to-primary-700 rounded-lg blur opacity-25 group-hover:opacity-75 transition duration-300"></div>
                    <div class="relative w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-primary-500 to-primary-700 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-xl md:text-2xl">S</span>
                    </div>
                </div>
                <span class="text-xl md:text-2xl font-bold"
                      :class="scrolled ? 'text-neutral-900 dark:text-white' : 'text-white'">
                    {{ config('app.name') }}
                </span>
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('home') }}" 
                   class="font-medium transition-colors hover:text-primary-600"
                   :class="scrolled ? 'text-neutral-700 dark:text-neutral-300' : 'text-white/90'">
                    Home
                </a>
                <a href="{{ route('events.index') }}" 
                   class="font-medium transition-colors hover:text-primary-600"
                   :class="scrolled ? 'text-neutral-700 dark:text-neutral-300' : 'text-white/90'">
                    Eventi
                </a>
                <a href="{{ route('poems.index') }}" 
                   class="font-medium transition-colors hover:text-primary-600"
                   :class="scrolled ? 'text-neutral-700 dark:text-neutral-300' : 'text-white/90'">
                    Poesie
                </a>
                <a href="{{ route('articles.index') }}" 
                   class="font-medium transition-colors hover:text-primary-600"
                   :class="scrolled ? 'text-neutral-700 dark:text-neutral-300' : 'text-white/90'">
                    Articoli
                </a>
            </div>

            <!-- Actions -->
            <div class="hidden md:flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard.index') }}" 
                       class="px-6 py-2.5 rounded-full font-semibold transition-all hover:scale-105"
                       :class="scrolled ? 'bg-primary-600 text-white' : 'bg-white/20 backdrop-blur-md text-white border border-white/30'">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                       class="font-medium transition-colors hover:text-primary-600"
                       :class="scrolled ? 'text-neutral-700 dark:text-neutral-300' : 'text-white/90'">
                        Accedi
                    </a>
                    <a href="{{ route('register') }}" 
                       class="px-6 py-2.5 rounded-full font-semibold transition-all hover:scale-105"
                       :class="scrolled ? 'bg-primary-600 text-white' : 'bg-white/20 backdrop-blur-md text-white border border-white/30'">
                        Registrati
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <button @click="isOpen = !isOpen" 
                    class="md:hidden p-2 rounded-lg"
                    :class="scrolled ? 'text-neutral-900 dark:text-white' : 'text-white'">
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
             class="md:hidden py-4 space-y-3">
            <a href="{{ route('home') }}" class="block px-4 py-2 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">Home</a>
            <a href="{{ route('events.index') }}" class="block px-4 py-2 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">Eventi</a>
            <a href="{{ route('poems.index') }}" class="block px-4 py-2 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">Poesie</a>
            <a href="{{ route('articles.index') }}" class="block px-4 py-2 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">Articoli</a>
            @auth
                <a href="{{ route('dashboard.index') }}" class="block px-4 py-2 bg-primary-600 text-white rounded-lg text-center font-semibold">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="block px-4 py-2 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">Accedi</a>
                <a href="{{ route('register') }}" class="block px-4 py-2 bg-primary-600 text-white rounded-lg text-center font-semibold">Registrati</a>
            @endauth
        </div>
    </div>
</nav>

<!-- Spacer to prevent content from going under fixed nav -->
<div class="h-16 md:h-20"></div>

