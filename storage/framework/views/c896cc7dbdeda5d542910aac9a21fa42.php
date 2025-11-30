<!-- Navigation only for GUEST users - logged users have sidebar -->
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->guest()): ?>
<nav class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 bg-white/95 dark:bg-neutral-900/95 backdrop-blur-md shadow-lg"
     x-data="{ isOpen: false }">
    
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 md:h-20">
            <!-- Logo -->
            <a href="<?php echo e(route('home')); ?>" class="flex items-center group">
                <img src="<?php echo e(asset('assets/images/Logo_orizzontale_nerosubianco.png')); ?>" 
                     alt="<?php echo e(config('app.name')); ?>" 
                     class="h-8 md:h-10 w-auto group-hover:scale-105 transition-transform">
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center gap-6">
                <a href="<?php echo e(route('home')); ?>" 
                   class="group flex items-center gap-2 font-medium text-neutral-700 dark:text-neutral-300 transition-all hover:text-primary-600 relative py-1">
                    <svg class="w-4 h-4 transition-transform group-hover:scale-110 group-hover:-rotate-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="relative">
                        Home
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary-600 transition-all duration-300 group-hover:w-full"></span>
                    </span>
                </a>
                <a href="<?php echo e(route('events.index')); ?>" 
                   class="group flex items-center gap-2 font-medium text-neutral-700 dark:text-neutral-300 transition-all hover:text-primary-600 relative py-1">
                    <svg class="w-4 h-4 transition-transform group-hover:scale-110 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="relative">
                        Eventi
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary-600 transition-all duration-300 group-hover:w-full"></span>
                    </span>
                </a>
                <a href="<?php echo e(route('media.index')); ?>" 
                   class="group flex items-center gap-2 font-medium text-neutral-700 dark:text-neutral-300 transition-all hover:text-primary-600 relative py-1">
                    <svg class="w-4 h-4 transition-transform group-hover:scale-110 group-hover:-rotate-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    <span class="relative">
                        Media
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary-600 transition-all duration-300 group-hover:w-full"></span>
                    </span>
                </a>
                <a href="<?php echo e(route('poems.index')); ?>" 
                   class="group flex items-center gap-2 font-medium text-neutral-700 dark:text-neutral-300 transition-all hover:text-primary-600 relative py-1">
                    <svg class="w-4 h-4 transition-transform group-hover:scale-110 group-hover:-rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    <span class="relative">
                        Poesie
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary-600 transition-all duration-300 group-hover:w-full"></span>
                    </span>
                </a>
                <a href="<?php echo e(route('articles.index')); ?>" 
                   class="group flex items-center gap-2 font-medium text-neutral-700 dark:text-neutral-300 transition-all hover:text-primary-600 relative py-1">
                    <svg class="w-4 h-4 transition-transform group-hover:scale-110 group-hover:rotate-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    <span class="relative">
                        Articoli
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary-600 transition-all duration-300 group-hover:w-full"></span>
                    </span>
                </a>
            </div>

            <!-- Actions - Only Login/Register for guests -->
            <div class="hidden md:flex items-center gap-4">
                    <a href="<?php echo e(route('login')); ?>" 
                       class="font-medium text-neutral-700 dark:text-neutral-300 transition-colors hover:text-primary-600">
                        Accedi
                    </a>
                    <a href="<?php echo e(route('register')); ?>" 
                       class="px-6 py-2.5 bg-primary-600 text-white rounded-full font-semibold transition-all hover:scale-105">
                        Registrati
                    </a>
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
             @click.away="isOpen = false"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="lg:hidden py-4 space-y-2 bg-white dark:bg-neutral-900 border-t border-neutral-200 dark:border-neutral-800">
            <a href="<?php echo e(route('home')); ?>" class="block px-4 py-2 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">Home</a>
            <a href="<?php echo e(route('events.index')); ?>" class="block px-4 py-2 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">Eventi</a>
            <a href="<?php echo e(route('media.index')); ?>" class="block px-4 py-2 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">Media</a>
            <a href="<?php echo e(route('poems.index')); ?>" class="block px-4 py-2 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">Poesie</a>
            <a href="<?php echo e(route('articles.index')); ?>" class="block px-4 py-2 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">Articoli</a>
            <div class="pt-2 mt-2 border-t border-neutral-200 dark:border-neutral-700 space-y-2">
                <a href="<?php echo e(route('login')); ?>" class="block px-4 py-2 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">Accedi</a>
                <a href="<?php echo e(route('register')); ?>" class="block px-4 py-2 bg-primary-600 text-white rounded-lg text-center font-semibold">Registrati</a>
            </div>
        </div>
    </div>
</nav>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH /Users/mazzi/slamin_v2/resources/views/components/layouts/navigation-modern.blade.php ENDPATH**/ ?>