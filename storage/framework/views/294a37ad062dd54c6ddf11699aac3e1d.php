<header class="fixed top-0 left-0 right-0 z-50 bg-white/95 dark:bg-neutral-900/95 backdrop-blur-md border-b border-neutral-200 dark:border-neutral-800 shadow-sm"
        x-data="{ 
            searchOpen: false,
            shortcutsOpen: false,
            notificationsOpen: false,
            profileOpen: false,
            langOpen: false
        }">
    <div class="flex items-center justify-between h-16 px-3 lg:px-6">
        <!-- Left Side -->
        <div class="flex items-center gap-2 md:gap-4 flex-1">
            <!-- Sidebar Toggle (Mobile Only) -->
            <button @click="$dispatch('toggle-sidebar')" 
                    class="lg:hidden p-2 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-lg transition-colors">
                <svg class="w-6 h-6 text-neutral-700 dark:!text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <!-- Logo (Responsive: piccolo su mobile, orizzontale su desktop) -->
            <a href="<?php echo e(route('home')); ?>" data-tutorial-focus="logo-link" class="flex items-center">
                <!-- Logo piccolo mobile - Light mode (più grande) -->
                <img src="<?php echo e(asset('assets/images/loghino-biancosunero.png')); ?>" 
                     alt="<?php echo e(config('app.name')); ?>" 
                     class="h-12 w-auto md:hidden dark:hidden object-contain">
                <!-- Logo piccolo mobile - Dark mode (più grande) -->
                <img src="<?php echo e(asset('assets/images/loghino-nerosubianco.png')); ?>" 
                     alt="<?php echo e(config('app.name')); ?>" 
                     class="h-12 w-auto hidden dark:block md:dark:hidden object-contain">
                <!-- Logo orizzontale desktop - Light mode -->
                <img src="<?php echo e(asset('assets/images/Logo_orizzontale_nerosubianco.png')); ?>" 
                     alt="<?php echo e(config('app.name')); ?>" 
                     class="hidden md:block dark:hidden h-8 w-auto">
                <!-- Logo orizzontale desktop - Dark mode -->
                <img src="<?php echo e(asset('assets/images/Logo_orizzontale_bianco.png')); ?>" 
                     alt="<?php echo e(config('app.name')); ?>" 
                     class="hidden dark:md:block h-8 w-auto">
            </a>

            <!-- Search Bar (Desktop) -->
            <div class="hidden md:flex flex-1 max-w-2xl">
                <form action="<?php echo e(route('search')); ?>" method="GET" class="relative w-full">
                    <input type="search" 
                           name="q"
                           value="<?php echo e(request('q')); ?>"
                           placeholder="<?php echo e(__('search.placeholder')); ?>"
                           class="w-full px-4 py-2 pl-10 bg-neutral-50 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all">
                    <svg class="absolute left-3 top-2.5 w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </form>
            </div>
        </div>

        <!-- Right Side - Utilities -->
        <div class="flex items-center gap-1">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
            <!-- Dashboard Direct Link -->
            <a href="<?php echo e(route('dashboard.index')); ?>" 
               data-tutorial-focus="dashboard-link"
               class="p-2 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-lg transition-colors relative"
               title="Dashboard">
                <svg class="w-6 h-6 text-neutral-700 dark:!text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-3zM14 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1h-4a1 1 0 01-1-1v-3z"/>
                </svg>
            </a>

            <!-- Shortcuts Dropdown -->
            <div class="relative" @click.away="shortcutsOpen = false">
                <button @click="shortcutsOpen = !shortcutsOpen"
                        class="p-2 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-lg transition-colors relative">
                    <svg class="w-6 h-6 text-neutral-700 dark:!text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </button>
                <div x-show="shortcutsOpen"
                     x-transition
                     class="absolute left-0 sm:left-auto sm:right-0 mt-2 w-64 bg-white dark:bg-neutral-800 rounded-xl shadow-xl border border-neutral-200 dark:border-neutral-700 py-2 z-[60]">
                    <div class="px-4 py-2 border-b border-neutral-200 dark:border-neutral-700">
                        <p class="font-semibold text-sm text-neutral-900 dark:text-white"><?php echo e(__('common.quick_actions')); ?></p>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->canCreatePoem()): ?>
                    <a href="<?php echo e(route('poems.create')); ?>" class="flex items-center gap-3 px-4 py-3 hover:bg-neutral-50 dark:hover:bg-neutral-700 transition-colors">
                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        <span class="text-sm text-neutral-700 dark:!text-white"><?php echo e(__('dashboard.write_poem')); ?></span>
                    </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(auth()->user()->canCreateEvent()): ?>
                    <a href="<?php echo e(route('events.create')); ?>" class="flex items-center gap-3 px-4 py-3 hover:bg-neutral-50 dark:hover:bg-neutral-700 transition-colors">
                        <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-sm text-neutral-700 dark:!text-white"><?php echo e(__('dashboard.create_event')); ?></span>
                    </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(auth()->user()->canUploadVideo()): ?>
                    <a href="<?php echo e(route('media.upload.video')); ?>" class="flex items-center gap-3 px-4 py-3 hover:bg-neutral-50 dark:hover:bg-neutral-700 transition-colors">
                        <svg class="w-5 h-5 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-sm text-neutral-700 dark:!text-white"><?php echo e(__('dashboard.upload_video')); ?></span>
                    </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(auth()->user()->canCreateArticle()): ?>
                    <a href="<?php echo e(route('articles.create')); ?>" class="flex items-center gap-3 px-4 py-3 hover:bg-neutral-50 dark:hover:bg-neutral-700 transition-colors">
                        <svg class="w-5 h-5 text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                        <span class="text-sm text-neutral-700 dark:!text-white"><?php echo e(__('dashboard.publish_article')); ?></span>
                    </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <!-- Notifications - Livewire Components -->
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('components.notification-center', []);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3106664494-0', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            
            <!-- Notification Animation (always visible for testing) -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('components.notification-animation', []);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3106664494-1', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('notifications.notification-modal', []);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3106664494-2', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- Language Selector -->
            <div class="relative" @click.away="langOpen = false">
                <button @click="langOpen = !langOpen"
                        class="flex items-center gap-1 p-2 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-lg transition-colors">
                    <span class="text-sm font-medium text-neutral-700 dark:!text-white uppercase"><?php echo e(strtoupper(app()->getLocale())); ?></span>
                    <svg class="w-4 h-4 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="langOpen"
                     x-transition
                     class="absolute right-0 mt-2 w-40 bg-white dark:bg-neutral-800 rounded-xl shadow-xl border border-neutral-200 dark:border-neutral-700 py-2 mr-0 sm:mr-auto z-[60]">
                    <a href="<?php echo e(request()->fullUrlWithQuery(['lang' => 'it'])); ?>" 
                       class="flex items-center gap-3 px-4 py-2 hover:bg-neutral-50 dark:hover:bg-neutral-700 <?php echo e(app()->getLocale() === 'it' ? 'bg-primary-50 dark:bg-primary-900/20' : ''); ?>">
                        <span class="text-sm">🇮🇹 Italiano</span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(app()->getLocale() === 'it'): ?>
                            <span class="ml-auto text-primary-600">✓</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </a>
                    <a href="<?php echo e(request()->fullUrlWithQuery(['lang' => 'en'])); ?>" 
                       class="flex items-center gap-3 px-4 py-2 hover:bg-neutral-50 dark:hover:bg-neutral-700 <?php echo e(app()->getLocale() === 'en' ? 'bg-primary-50 dark:bg-primary-900/20' : ''); ?>">
                        <span class="text-sm">🇬🇧 English</span>
                        <?php if(app()->getLocale() === 'en'): ?>
                            <span class="ml-auto text-primary-600">✓</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </a>
                    <a href="<?php echo e(request()->fullUrlWithQuery(['lang' => 'fr'])); ?>" 
                       class="flex items-center gap-3 px-4 py-2 hover:bg-neutral-50 dark:hover:bg-neutral-700 <?php echo e(app()->getLocale() === 'fr' ? 'bg-primary-50 dark:bg-primary-900/20' : ''); ?>">
                        <span class="text-sm">🇫🇷 Français</span>
                        <?php if(app()->getLocale() === 'fr'): ?>
                            <span class="ml-auto text-primary-600">✓</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </a>
                </div>
            </div>

            <!-- Dark Mode Toggle -->
            <button class="p-2 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-lg transition-colors"
                    @click="window.toggleDarkMode()">
                <!-- Sun icon - shown in dark mode -->
                <svg class="w-6 h-6 text-neutral-700 dark:!text-white hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <!-- Moon icon - shown in light mode -->
                <svg class="w-6 h-6 text-neutral-700 dark:!text-white dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
            </button>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
            <!-- Profile Menu -->
            <div class="relative" @click.away="profileOpen = false">
                <button @click="profileOpen = !profileOpen"
                        data-tutorial-focus="user-menu"
                        class="flex items-center gap-2 p-1 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-lg transition-colors">
                    <img src="<?php echo e(auth()->user()->profile_photo_url); ?>" 
                         alt="<?php echo e(auth()->user()->name); ?>" 
                         class="w-9 h-9 rounded-full object-cover ring-2 ring-primary-200">
                    <span class="hidden lg:block text-sm font-medium text-neutral-700 dark:!text-white max-w-[120px] truncate">
                        <?php echo e(auth()->user()->name); ?>

                    </span>
                    <svg class="hidden lg:block w-4 h-4 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="profileOpen"
                     x-transition
                     class="absolute right-0 mt-2 w-56 bg-white dark:bg-neutral-800 rounded-xl shadow-xl border border-neutral-200 dark:border-neutral-700 py-2 mr-0 z-[60]">
                    <div class="px-4 py-3 border-b border-neutral-200 dark:border-neutral-700">
                        <p class="font-semibold text-sm text-neutral-900 dark:text-white truncate"><?php echo e(auth()->user()->name); ?></p>
                        <p class="text-xs text-neutral-500 truncate"><?php echo e(auth()->user()->email); ?></p>
                    </div>
                    <a href="<?php echo e(route('profile.show')); ?>" class="flex items-center gap-3 px-4 py-2 hover:bg-neutral-50 dark:hover:bg-neutral-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span class="text-sm text-neutral-700 dark:!text-white"><?php echo e(__('profile.nav.my_profile')); ?></span>
                    </a>
                    <a href="<?php echo e(route('profile.edit')); ?>" class="flex items-center gap-3 px-4 py-2 hover:bg-neutral-50 dark:hover:bg-neutral-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="text-sm text-neutral-700 dark:!text-white"><?php echo e(__('profile.settings.edit_profile')); ?></span>
                    </a>
                    <div class="border-t border-neutral-200 dark:border-neutral-700 my-2"></div>
                    <form action="<?php echo e(route('logout')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 hover:bg-red-50 dark:hover:bg-red-900/20 text-red-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span class="text-sm">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
            <?php else: ?>
            <!-- Login/Register (Not Auth) -->
            <a href="<?php echo e(route('login')); ?>" class="text-sm font-medium text-neutral-700 dark:!text-white hover:text-primary-600">
                Accedi
            </a>
            <a href="<?php echo e(route('register')); ?>" class="px-4 py-2 bg-primary-600 text-white rounded-lg text-sm font-medium hover:bg-primary-700 transition-colors">
                Registrati
            </a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <!-- Mobile Search Bar (sotto la topbar, z-index inferiore) -->
    <div class="md:hidden bg-white/95 dark:bg-neutral-900/95 backdrop-blur-md border-b border-neutral-200 dark:border-neutral-800 px-3 py-2 relative z-40">
        <form action="<?php echo e(route('search')); ?>" method="GET" class="relative w-full">
            <input type="search" 
                   name="q"
                   value="<?php echo e(request('q')); ?>"
                   placeholder="<?php echo e(__('search.placeholder')); ?>"
                   class="w-full px-4 py-2 pl-10 bg-neutral-50 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
            <svg class="absolute left-3 top-2.5 w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </form>
    </div>
</header>

<?php /**PATH /Users/mazzi/slamin_v2/resources/views/components/layouts/topbar.blade.php ENDPATH**/ ?>