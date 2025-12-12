<div class="min-h-screen bg-neutral-50 dark:bg-neutral-950"
     x-data="{ scrollY: 0 }" 
     @scroll.window="scrollY = window.scrollY">
    
    <!-- WELCOME SECTION - Stesso stile della homepage -->
    <section class="relative h-[70vh] overflow-hidden mb-12">
        
        <!-- Banner Background con Parallax (come homepage) -->
        <div class="absolute inset-0" :style="`transform: translateY(${scrollY * 0.5}px) scale(1.1)`">
            <?php
                $bannerUrl = \App\Helpers\AvatarHelper::getUserBannerUrl($user);
                $hasCustomBanner = !empty($bannerUrl);
                if (!$bannerUrl) {
                    $bannerUrl = 'https://images.unsplash.com/photo-1519681393784-d120267933ba?w=1920&auto=format&fit=crop&q=80';
                }
            ?>
            <img src="<?php echo e($bannerUrl); ?>" alt="Banner" class="w-full h-full object-cover">
            
            <!-- Overlay gradient - Trasparente per far vedere il banner -->
            <div class="absolute inset-0 bg-gradient-to-br from-black/30 via-black/20 to-black/25"></div>
        </div>
        
        <!-- Content con fade on scroll (come homepage) -->
        <div class="absolute inset-0 flex items-center justify-center" 
             :style="`transform: translateY(${scrollY * 0.3}px); opacity: ${Math.max(0, 1 - (scrollY / 1200))}`">
            <div class="text-center px-4 md:px-6 max-w-5xl mx-auto text-white"
                 x-data="{ visible: false }"
                 x-init="setTimeout(() => visible = true, 300)"
                 x-show="visible"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100">
                
                <!-- Avatar -->
                <div class="mb-6">
                    <div class="w-32 h-32 md:w-40 md:h-40 mx-auto rounded-full bg-white dark:bg-neutral-800 p-2 shadow-2xl">
                        <img src="<?php echo e(\App\Helpers\AvatarHelper::getUserAvatarUrl($user, 200)); ?>" 
                             alt="<?php echo e($user->name); ?>"
                             class="w-full h-full rounded-full object-cover">
                    </div>
                </div>
                
                <!-- Nome (stesso font della homepage) -->
                <h1 class="text-5xl md:text-6xl lg:text-8xl font-bold mb-6 leading-tight" 
                    style="font-family: 'Crimson Pro', serif;">
                    <?php echo e($user->name); ?>

                </h1>
                
                <!-- Nickname -->
                <p class="text-xl md:text-2xl lg:text-3xl font-light mb-8 text-white/90">
                    <?php echo e($user->nickname ?? '@' . explode('@', $user->email)[0]); ?>

                </p>
                
                <!-- Badges -->
                <div class="flex flex-wrap items-center justify-center gap-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $user->getRoleNames(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="px-5 py-2 bg-white/20 backdrop-blur-md border border-white/30 text-white font-semibold rounded-full text-base hover:bg-white/30 transition-all duration-300">
                            <?php echo e(ucfirst($role)); ?>

                        </span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <span class="px-5 py-2 bg-accent/80 backdrop-blur-md text-white font-semibold rounded-full text-base">
                        <?php echo e(__('dashboard.member_since')); ?> <?php echo e($stats['member_since']); ?>

                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Grid -->
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8 pb-12 space-y-12">
        
        <!-- 📊 Stats - Numeri Animati con Counter (Grid 2x2 su mobile!) -->
        <div x-data="{ visible: false }" 
             x-intersect.once="visible = true"
             class="relative py-8 md:py-12">
            
            <!-- Grid 2x2 su mobile, flex su desktop -->
            <div class="grid grid-cols-2 md:flex md:flex-wrap items-baseline justify-center gap-x-6 gap-y-6 md:gap-x-12 md:gap-y-8">
                <?php
                $statsData = [
                    ['label' => __('dashboard.poems'), 'value' => $stats['total_poems']],
                    ['label' => __('dashboard.events'), 'value' => $stats['organized_events']],
                    ['label' => __('dashboard.views'), 'value' => $stats['total_views']],
                    ['label' => __('dashboard.likes'), 'value' => $stats['total_likes']],
                ];
                ?>
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $statsData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div x-show="visible"
                         x-transition:enter="transition ease-out duration-700"
                         x-transition:enter-start="opacity-0 translate-y-8"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         style="transition-delay: <?php echo e($index * 100); ?>ms"
                         class="group cursor-default"
                         x-data="{
                             count: 0,
                             target: <?php echo e($stat['value']); ?>,
                             animate() {
                                 setTimeout(() => {
                                     let duration = 2000;
                                     let start = 0;
                                     let range = this.target - start;
                                     let increment = this.target / (duration / 16);
                                     let timer = setInterval(() => {
                                         this.count += increment;
                                         if (this.count >= this.target) {
                                             this.count = this.target;
                                             clearInterval(timer);
                                         }
                                     }, 16);
                                 }, <?php echo e($index * 100); ?>);
                             }
                         }"
                         x-init="animate()">
                        <div class="flex flex-col items-center">
                            <!-- Numeri più piccoli su mobile: text-4xl vs text-7xl -->
                            <span class="text-4xl md:text-7xl font-black text-transparent bg-clip-text bg-gradient-to-br from-primary-600 to-primary-800 group-hover:scale-110 transition-transform duration-300"
                                  x-text="Math.floor(count).toLocaleString()">
                            </span>
                            <span class="text-[10px] md:text-sm font-bold text-neutral-600 dark:text-neutral-400 uppercase tracking-wider md:tracking-widest mt-1 md:mt-2 text-center">
                                <?php echo e($stat['label']); ?>

                            </span>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <!-- ⚡ Quick Actions - Pills Colorate Ottimizzate per Mobile -->
        <div class="relative py-6 md:py-8" 
             x-data="{ visible: false }" 
             x-intersect.once="visible = true">
            
            <!-- Grid 2x2 su mobile, flex wrap su desktop -->
            <div class="grid grid-cols-2 md:flex md:flex-wrap items-center justify-center gap-2.5 md:gap-4">
                <?php
                $colors = [
                    ['from' => 'from-primary-500', 'to' => 'to-primary-600', 'hover_from' => 'hover:from-primary-600', 'hover_to' => 'hover:to-primary-700'],
                    ['from' => 'from-emerald-500', 'to' => 'to-teal-600', 'hover_from' => 'hover:from-emerald-600', 'hover_to' => 'hover:to-teal-700'],
                    ['from' => 'from-green-600', 'to' => 'to-emerald-700', 'hover_from' => 'hover:from-green-700', 'hover_to' => 'hover:to-emerald-800'],
                    ['from' => 'from-teal-500', 'to' => 'to-cyan-600', 'hover_from' => 'hover:from-teal-600', 'hover_to' => 'hover:to-cyan-700'],
                    ['from' => 'from-blue-500', 'to' => 'to-indigo-600', 'hover_from' => 'hover:from-blue-600', 'hover_to' => 'hover:to-indigo-700'],
                ];
                ?>
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $quickActions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e($action['url']); ?>"
                       x-show="visible"
                       x-transition:enter="transition ease-out duration-700"
                       x-transition:enter-start="opacity-0 scale-90 rotate-12"
                       x-transition:enter-end="opacity-100 scale-100 rotate-0"
                       style="transition-delay: <?php echo e($index * 100); ?>ms"
                       class="group flex items-center justify-center gap-2 md:gap-3 px-3 py-3 md:px-8 md:py-4 rounded-xl md:rounded-2xl bg-gradient-to-r <?php echo e($colors[$index]['from']); ?> <?php echo e($colors[$index]['to']); ?> <?php echo e($colors[$index]['hover_from']); ?> <?php echo e($colors[$index]['hover_to']); ?> text-white font-semibold shadow-lg hover:shadow-2xl transform hover:scale-105 hover:-rotate-1 transition-all duration-300">
                        
                        <!-- SVG Icons - più piccole su mobile -->
                        <svg class="w-5 h-5 md:w-6 md:h-6 flex-shrink-0 group-hover:scale-125 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loop->index === 0): ?>
                                <!-- Pen/Write Icon -->
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            <?php elseif($loop->index === 1): ?>
                                <!-- Calendar Icon -->
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            <?php elseif($loop->index === 2): ?>
                                <!-- Video Icon -->
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            <?php elseif($loop->index === 3): ?>
                                <!-- Article/Newspaper Icon -->
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            <?php else: ?>
                                <!-- Compass/Explore Icon -->
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </svg>
                        
                        <!-- Testo più piccolo su mobile, break-words per andare a capo se necessario -->
                        <span class="text-xs md:text-base font-medium md:font-semibold leading-tight text-center flex-1"><?php echo e($action['title']); ?></span>
                        
                        <!-- Arrow animata - nascosta su mobile per risparmiare spazio -->
                        <svg class="hidden md:block w-5 h-5 flex-shrink-0 transform group-hover:translate-x-1 transition-transform duration-300" 
                             fill="none" 
                             stroke="currentColor" 
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <!-- 📅 CALENDARIO EVENTI -->
        <div x-data="{ visible: false }" 
             x-intersect.once="visible = true">
            
            <!-- Header con animazione -->
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-8"
                 x-show="visible"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 translate-y-8"
                 x-transition:enter-end="opacity-100 translate-y-0">
                <div class="flex-1">
                    <h2 class="text-3xl md:text-4xl font-bold text-neutral-900 dark:text-white mb-2"
                        style="font-family: 'Crimson Pro', serif;">
                        📅 <?php echo e(__('dashboard.my_calendar')); ?>

                    </h2>
                    <p class="text-neutral-600 dark:text-neutral-400"><?php echo e(__('dashboard.calendar_subtitle')); ?></p>
                </div>
                
                <!-- Toggle Calendar Button -->
                <button 
                    @click="$wire.toggleCalendar()"
                    class="flex items-center gap-2 px-4 py-2 rounded-xl bg-white dark:bg-neutral-800 border-2 border-primary-600 text-primary-600 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all duration-300 font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!<?php echo e($calendarVisible ? 'true' : 'false'); ?>">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="<?php echo e($calendarVisible ? 'true' : 'false'); ?>">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                    <span class="text-sm"><?php echo e($calendarVisible ? __('dashboard.hide') : __('dashboard.show')); ?></span>
                </button>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($calendarVisible): ?>
            <div x-data="{ calendarVisible: false }" 
                 x-init="setTimeout(() => calendarVisible = true, 100)"
                 x-show="calendarVisible"
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 translate-y-4">
                
                <!-- MOBILE: VIEW SWITCHER - Inside Header for better visibility -->
                <div class="flex md:hidden gap-2 w-full md:w-auto order-first md:order-none mb-4 md:mb-0">
                    <button 
                        @click="$wire.switchView('list')"
                        class="flex-1 px-3 py-2.5 rounded-xl <?php echo e($currentView === 'list' ? 'bg-primary-600 text-white shadow-lg shadow-primary-600/30' : 'bg-white dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400 border border-neutral-200 dark:border-neutral-700'); ?> font-medium transition-all duration-300 flex items-center justify-center gap-1.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <span class="text-xs font-semibold">Lista</span>
                    </button>
                    <button 
                        @click="$wire.switchView('week')"
                        class="flex-1 px-3 py-2.5 rounded-xl <?php echo e($currentView === 'week' ? 'bg-primary-600 text-white shadow-lg shadow-primary-600/30' : 'bg-white dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400 border border-neutral-200 dark:border-neutral-700'); ?> font-medium transition-all duration-300 flex items-center justify-center gap-1.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-xs font-semibold">Sett</span>
                    </button>
                    <button 
                        @click="$wire.switchView('month')"
                        class="flex-1 px-3 py-2.5 rounded-xl <?php echo e($currentView === 'month' ? 'bg-primary-600 text-white shadow-lg shadow-primary-600/30' : 'bg-white dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400 border border-neutral-200 dark:border-neutral-700'); ?> font-medium transition-all duration-300 flex items-center justify-center gap-1.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <span class="text-xs font-semibold">Mese</span>
                    </button>
                </div>
                
                <!-- Navigation (hidden on mobile for list/week views) -->
                <div class="flex items-center gap-3 <?php echo e($currentView !== 'month' ? 'hidden md:flex' : 'flex'); ?>">
                    <button wire:click="previousMonth"
                            class="w-10 h-10 rounded-xl bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 flex items-center justify-center hover:bg-primary-50 dark:hover:bg-primary-900/20 hover:border-primary-500 transition-all duration-300 group">
                        <svg class="w-5 h-5 text-neutral-600 dark:text-neutral-400 group-hover:text-primary-600 transition-colors" 
                             wire:loading.remove wire:target="previousMonth"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <svg class="w-5 h-5 text-primary-600 animate-spin" 
                             wire:loading wire:target="previousMonth"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </button>
                    <div class="px-6 py-2 bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl min-w-[180px] text-center">
                        <span class="font-semibold text-neutral-900 dark:text-white"><?php echo e($calendarData['monthName']); ?></span>
                    </div>
                    <button wire:click="nextMonth"
                            class="w-10 h-10 rounded-xl bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 flex items-center justify-center hover:bg-primary-50 dark:hover:bg-primary-900/20 hover:border-primary-500 transition-all duration-300 group">
                        <svg class="w-5 h-5 text-neutral-600 dark:text-neutral-400 group-hover:text-primary-600 transition-colors"
                             wire:loading.remove wire:target="nextMonth"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        <svg class="w-5 h-5 text-primary-600 animate-spin"
                             wire:loading wire:target="nextMonth" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- MOBILE: LIST VIEW -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentView === 'list'): ?>
            <div class="md:hidden mb-6" x-data="{ visible: false }" x-init="setTimeout(() => visible = true, 100)">
                <!-- Navigation -->
                <div class="flex items-center justify-between mb-6">
                    <button 
                        wire:click="previousListPage"
                        <?php if($listPage <= 1): ?> disabled <?php endif; ?>
                        class="w-12 h-12 rounded-full border-2 border-primary-600 flex items-center justify-center text-primary-600 transition-all disabled:opacity-30 disabled:cursor-not-allowed hover:bg-primary-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <span class="text-sm text-neutral-600 dark:text-neutral-400 font-medium">
                        Pagina <?php echo e($listPage); ?>

                    </span>
                    <button 
                        wire:click="nextListPage"
                        class="w-12 h-12 rounded-full border-2 border-primary-600 flex items-center justify-center text-primary-600 transition-all hover:bg-primary-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>

                <!-- Events List -->
                <?php
                    $allEvents = collect($calendarEvents);
                    $groupedEvents = $allEvents->groupBy(function($event) {
                        return \Carbon\Carbon::parse($event['start'])->format('Y-m-d');
                    });
                    $eventsPerPage = 3;
                    $startIndex = ($listPage - 1) * $eventsPerPage;
                    $paginatedEvents = $groupedEvents->slice($startIndex, $eventsPerPage);
                ?>

                <div class="space-y-6"
                     x-show="visible"
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $paginatedEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $events): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <!-- Date Header -->
                        <div class="relative">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="flex-shrink-0 w-16 h-16 rounded-2xl bg-primary-600 dark:bg-primary-700 flex flex-col items-center justify-center text-white shadow-lg">
                                    <span class="text-2xl font-bold leading-none"><?php echo e(\Carbon\Carbon::parse($date)->format('d')); ?></span>
                                    <span class="text-xs uppercase"><?php echo e(\Carbon\Carbon::parse($date)->isoFormat('MMM')); ?></span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white" style="font-family: 'Crimson Pro', serif;">
                                        <?php echo e(\Carbon\Carbon::parse($date)->isoFormat('dddd')); ?>

                                    </h3>
                                    <p class="text-sm text-neutral-600 dark:text-neutral-400">
                                        <?php echo e($events->count()); ?> <?php echo e($events->count() === 1 ? __('dashboard.event') : __('dashboard.events_count')); ?>

                                    </p>
                                </div>
                            </div>

                            <!-- Eventi del giorno -->
                            <div class="space-y-4">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <article class="group cursor-pointer overflow-hidden rounded-2xl bg-white dark:bg-neutral-800 shadow-lg hover:shadow-2xl transition-all duration-500"
                                             x-data="{ hovered: false }"
                                             @mouseenter="hovered = true"
                                             @mouseleave="hovered = false">
                                        <!-- Event Image with Overlay -->
                                        <div class="relative h-48 overflow-hidden">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($event['image'])): ?>
                                                <img src="<?php echo e($event['image']); ?>" 
                                                     alt="<?php echo e($event['title']); ?>" 
                                                     class="w-full h-full object-cover transition-transform duration-700"
                                                     :class="hovered && 'scale-110'">
                                                <!-- Elegant dark overlay for readability -->
                                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                                            <?php else: ?>
                                                <div class="w-full h-full <?php echo e($event['type'] === 'wishlist' ? 'bg-accent-600 dark:bg-accent-700' : 'bg-primary-600 dark:bg-primary-700'); ?>"></div>
                                                <!-- Lighter overlay for solid background -->
                                                <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            
                                            <!-- Wishlist Badge -->
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event['type'] === 'wishlist'): ?>
                                                <div class="absolute top-4 right-4 px-2 py-1 bg-accent-600 text-white text-xs font-bold rounded-lg shadow-lg">
                                                    <svg class="w-3 h-3 inline" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                                    </svg>
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            
                                            <!-- Time Badge -->
                                            <div class="absolute top-4 left-4 px-3 py-1.5 bg-white/90 backdrop-blur-sm rounded-full transition-transform duration-300"
                                                 :class="hovered && 'scale-110'">
                                                <div class="flex items-center gap-1.5">
                                                    <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <span class="text-sm font-semibold text-neutral-900">
                                                        <?php echo e(\Carbon\Carbon::parse($event['start'])->format('H:i')); ?>

                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Title & Location -->
                                            <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                                                <h4 class="text-xl font-bold mb-2 line-clamp-2" style="font-family: 'Crimson Pro', serif;">
                                                    <?php echo e($event['title']); ?>

                                                </h4>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($event['location'])): ?>
                                                <div class="flex items-center gap-2 text-white/90 text-sm">
                                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    </svg>
                                                    <span class="line-clamp-1"><?php echo e($event['location']); ?></span>
                                                </div>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                    </article>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center py-16">
                            <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-neutral-100 dark:bg-neutral-800 flex items-center justify-center">
                                <svg class="w-10 h-10 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <p class="text-neutral-500 dark:text-neutral-400">Nessun evento in questa pagina</p>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- MOBILE: WEEK VIEW -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentView === 'week'): ?>
            <div class="md:hidden mb-6" x-data="{ visible: false }" x-init="setTimeout(() => visible = true, 100)">
                <!-- Navigation -->
                <div class="flex items-center justify-between mb-6">
                    <button 
                        wire:click="previousWeek"
                        class="w-12 h-12 rounded-full border-2 border-primary-600 flex items-center justify-center text-primary-600 transition-all hover:bg-primary-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <span class="text-sm text-neutral-600 dark:text-neutral-400 font-medium">
                        Settimana <?php echo e(abs($weekPage) + 1); ?>

                    </span>
                    <button 
                        wire:click="nextWeek"
                        class="w-12 h-12 rounded-full border-2 border-primary-600 flex items-center justify-center text-primary-600 transition-all hover:bg-primary-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>

                <!-- Week Days -->
                <?php
                    $startOfWeek = \Carbon\Carbon::now()->addWeeks($weekPage)->startOfWeek(\Carbon\Carbon::MONDAY);
                ?>

                <div class="space-y-4"
                     x-show="visible"
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 0; $i < 7; $i++): ?>
                        <?php
                            $day = $startOfWeek->copy()->addDays($i);
                            $dayEvents = collect($calendarEvents)->filter(function($event) use ($day) {
                                return \Carbon\Carbon::parse($event['start'])->isSameDay($day);
                            });
                        ?>
                        
                        <!-- Day Container -->
                        <div class="overflow-hidden rounded-2xl <?php echo e($day->isToday() ? 'ring-2 ring-primary-500 shadow-xl shadow-primary-500/20' : ''); ?>">
                            <!-- Day Header -->
                            <div class="relative h-24 overflow-hidden bg-primary-600 dark:bg-primary-700">
                                <!-- Pattern overlay -->
                                <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Ik0zNiAxOGMzLjMxNCAwIDYgMi42ODYgNiA2cy0yLjY4NiA2LTYgNi02LTIuNjg2LTYtNiAyLjY4Ni02IDYtNnpNNiA2YzMuMzE0IDAgNiAyLjY4NiA2IDZzLTIuNjg2IDYtNiA2LTYtMi42ODYtNi02IDIuNjg2LTYgNi02eiIgc3Ryb2tlPSIjZmZmIiBzdHJva2Utb3BhY2l0eT0iLjEiLz48L2c+PC9zdmc+')] opacity-30"></div>
                                
                                <div class="relative h-full flex items-center justify-between px-5">
                                    <div>
                                        <h3 class="text-2xl font-bold text-white mb-1" style="font-family: 'Crimson Pro', serif;">
                                            <?php echo e($day->isoFormat('dddd')); ?>

                                        </h3>
                                        <p class="text-white/90 text-sm font-medium">
                                            <?php echo e($day->isoFormat('D MMMM YYYY')); ?>

                                        </p>
                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($day->isToday()): ?>
                                        <span class="px-4 py-2 bg-white/20 backdrop-blur-sm text-white rounded-full text-sm font-bold shadow-lg">
                                            Oggi
                                        </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                            
                            <!-- Events for this day -->
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dayEvents->count() > 0): ?>
                                <div class="bg-white dark:bg-neutral-800 p-4 space-y-3">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $dayEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="<?php echo e($event['url'] ?? '#'); ?>" class="block">
                                            <article class="group cursor-pointer overflow-hidden rounded-xl bg-white dark:bg-neutral-800 shadow-md hover:shadow-xl transition-all duration-300"
                                                     x-data="{ hovered: false }"
                                                     @mouseenter="hovered = true"
                                                     @mouseleave="hovered = false">
                                                <div class="relative h-32 overflow-hidden">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($event['image'])): ?>
                                                    <img src="<?php echo e($event['image']); ?>" 
                                                         alt="<?php echo e($event['title']); ?>" 
                                                         class="w-full h-full object-cover transition-transform duration-500"
                                                         :class="hovered && 'scale-110'">
                                                    <!-- Elegant dark overlay for readability -->
                                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                                                <?php else: ?>
                                                    <div class="w-full h-full bg-primary-600 dark:bg-primary-700"></div>
                                                    <!-- Lighter overlay for solid background -->
                                                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                
                                                <!-- Time Badge -->
                                                <div class="absolute top-2 right-2 flex items-center gap-2">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event['type'] === 'wishlist'): ?>
                                                        <span class="px-2 py-1 bg-accent-600 text-white text-xs font-bold rounded-lg shadow-lg" title="<?php echo e(__('events.in_wishlist')); ?>">
                                                            <svg class="w-3 h-3 inline" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                                            </svg>
                                                        </span>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    <div class="px-2.5 py-1 bg-white/90 backdrop-blur-sm rounded-lg">
                                                        <span class="text-xs font-bold text-neutral-900">
                                                            <?php echo e(\Carbon\Carbon::parse($event['start'])->format('H:i')); ?>

                                                        </span>
                                                    </div>
                                                </div>
                                                
                                                <!-- Title -->
                                                <div class="absolute bottom-0 left-0 right-0 p-3">
                                                    <h4 class="text-base font-bold text-white line-clamp-2" style="font-family: 'Crimson Pro', serif;">
                                                        <?php echo e($event['title']); ?>

                                                    </h4>
                                                </div>
                                            </div>
                                        </article>
                                        </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            <?php else: ?>
                                <div class="bg-white dark:bg-neutral-800 p-8 text-center">
                                    <svg class="w-12 h-12 mx-auto text-neutral-300 dark:text-neutral-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                    </svg>
                                    <p class="text-sm text-neutral-400 dark:text-neutral-500">Nessun evento</p>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- Calendar Grid con animazione (Desktop + Mobile Month View) -->
            <div class="<?php echo e($currentView === 'month' ? 'block' : 'hidden md:block'); ?> bg-white dark:bg-neutral-900 rounded-3xl shadow-xl overflow-hidden"
                 wire:key="calendar-<?php echo e($currentMonth); ?>-<?php echo e($currentYear); ?>"
                 x-show="visible"
                 x-transition:enter="transition ease-out duration-700 delay-200"
                 x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100">
                
                <!-- Days Header -->
                <div class="grid grid-cols-7 border-b border-neutral-200 dark:border-neutral-800 bg-neutral-50 dark:bg-neutral-800/50">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['Lun', 'Mar', 'Mer', 'Gio', 'Ven', 'Sab', 'Dom']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="text-center py-4 text-sm font-semibold text-neutral-600 dark:text-neutral-400">
                            <?php echo e($day); ?>

                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <!-- Calendar Days -->
                <div class="p-2" wire:loading.class="opacity-50 pointer-events-none" wire:target="previousMonth,nextMonth">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $calendarData['weeks']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $weekIndex => $week): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="grid grid-cols-7 gap-3 mb-3">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $week; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dayIndex => $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="relative rounded-2xl transition-all duration-300 overflow-hidden group cursor-pointer
                                            <?php echo e($day['isCurrentMonth'] ? 'bg-white dark:bg-neutral-800 hover:shadow-xl hover:scale-105 hover:-translate-y-1' : 'opacity-40 bg-neutral-50 dark:bg-neutral-900'); ?>

                                            <?php echo e($day['isToday'] ? 'ring-2 ring-primary-500 shadow-xl shadow-primary-500/30' : 'shadow-md'); ?>"
                                     style="height: 140px;">
                                    
                                    <!-- Numero giorno - PULITO senza sfondo -->
                                    <div class="absolute top-2 left-2 z-30">
                                        <span class="font-bold text-base drop-shadow-lg
                                                    <?php echo e($day['isToday'] ? 'text-primary-600' : 'text-neutral-900 dark:text-white group-hover:text-primary-600 transition-colors'); ?>"
                                              style="<?php echo e($day['isToday'] ? 'text-shadow: 0 0 15px rgba(5, 150, 105, 1), 0 0 8px rgba(5, 150, 105, 0.8), 0 2px 4px rgba(0,0,0,0.3);' : 'text-shadow: 0 2px 4px rgba(0,0,0,0.15);'); ?>">
                                            <?php echo e($day['date']->day); ?>

                                        </span>
                                    </div>
                                    
                                    <!-- Eventi del giorno con Slider -->
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($day['events']->count() > 0): ?>
                                        <div class="absolute inset-0"
                                             x-data="{ 
                                                 currentSlide: 0, 
                                                 totalSlides: <?php echo e($day['events']->count()); ?>,
                                                 interval: null,
                                                 startAutoplay() {
                                                     if(this.totalSlides > 1) {
                                                         this.interval = setInterval(() => {
                                                             this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
                                                         }, 3000);
                                                     }
                                                 },
                                                 stopAutoplay() {
                                                     if(this.interval) clearInterval(this.interval);
                                                 }
                                             }"
                                             x-init="startAutoplay()"
                                             @mouseenter="stopAutoplay()"
                                             @mouseleave="startAutoplay()">
                                            
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $day['events']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eventIndex => $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <!-- Event Card - Con immagine o pulito -->
                                                <a href="<?php echo e($event['url'] ?? '#'); ?>" 
                                                   class="absolute inset-0 transition-all duration-500 cursor-pointer block"
                                                   x-show="currentSlide === <?php echo e($eventIndex); ?>"
                                                   x-transition:enter="transition ease-out duration-500"
                                                   x-transition:enter-start="opacity-0 scale-95"
                                                   x-transition:enter-end="opacity-100 scale-100"
                                                   x-transition:leave="transition ease-in duration-300"
                                                   x-transition:leave-start="opacity-100"
                                                   x-transition:leave-end="opacity-0 scale-95">
                                                    
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event['image'] ?? false): ?>
                                                        <!-- Evento con IMMAGINE -->
                                                        <img src="<?php echo e($event['image']); ?>" alt="<?php echo e($event['title']); ?>" class="absolute inset-0 w-full h-full object-cover">
                                                        <!-- Elegant dark overlay for readability -->
                                                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                                                    <?php else: ?>
                                                        <!-- Evento senza immagine - Sfondo pulito -->
                                                        <div class="absolute inset-0 <?php echo e($event['type'] === 'wishlist' ? 'bg-accent-50 dark:bg-accent-900/20' : 'bg-primary-50 dark:bg-primary-900/20'); ?>"></div>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    
                                                    <!-- Wishlist Badge -->
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event['type'] === 'wishlist'): ?>
                                                        <div class="absolute top-2 left-2 px-2 py-1 bg-accent-600 text-white text-xs font-bold rounded-lg shadow-lg">
                                                            <svg class="w-3 h-3 inline" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                                            </svg>
                                                        </div>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    
                                                    <!-- Content -->
                                                    <div class="absolute inset-0 flex flex-col justify-end p-3">
                                                        <div class="text-xs font-bold mb-1 line-clamp-2 <?php echo e($event['image'] ?? false ? 'text-white drop-shadow-lg' : 'text-neutral-900 dark:text-white'); ?>">
                                                            <?php echo e($event['title']); ?>

                                                        </div>
                                                        <div class="text-xs font-medium <?php echo e($event['image'] ?? false ? 'text-white/90 drop-shadow' : ($event['type'] === 'wishlist' ? 'text-accent-600 dark:text-accent-400' : 'text-primary-600 dark:text-primary-400')); ?>">
                                                            🕐 <?php echo e($event['time']); ?>

                                                        </div>
                                                        
                                                        <!-- Indicators -->
                                                        <?php if($day['events']->count() > 1): ?>
                                                            <div class="flex justify-center gap-1.5 mt-2">
                                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $day['events']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <div class="h-1 rounded-full transition-all duration-300"
                                                                         :class="currentSlide === <?php echo e($idx); ?> ? '<?php echo e($event['image'] ?? false ? 'bg-white' : 'bg-primary-600'); ?> w-6' : '<?php echo e($event['image'] ?? false ? 'bg-white/40' : 'bg-neutral-300'); ?> w-1.5'">
                                                                    </div>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                            </div>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </div>
                                                </a>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <!-- Giorno vuoto con hover colorato e link per creare evento -->
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->canCreateEvent()): ?>
                                            <a href="<?php echo e(route('events.create')); ?>?date=<?php echo e($day['date']->format('Y-m-d')); ?>" 
                                               class="absolute inset-0 flex items-center justify-center bg-neutral-50 dark:bg-neutral-800 group-hover:bg-primary-50 dark:group-hover:bg-primary-900/20 transition-all duration-300">
                                                <div class="transform transition-all duration-300 opacity-0 group-hover:opacity-100 group-hover:scale-110">
                                                    <div class="w-8 h-8 rounded-lg bg-primary-500 flex items-center justify-center shadow-lg">
                                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </a>
                                            <?php else: ?>
                                            <div class="absolute inset-0 flex items-center justify-center bg-neutral-50 dark:bg-neutral-800">
                                            </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php else: ?>
                                        <div class="absolute inset-0 flex items-center justify-center bg-neutral-50 dark:bg-neutral-800">
                                        </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <!-- Legenda -->
            <div class="flex flex-wrap items-center justify-center gap-6 mt-6"
                 x-show="visible"
                 x-transition:enter="transition ease-out duration-700 delay-400"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-primary-500"></div>
                    <span class="text-sm text-neutral-600 dark:text-neutral-400"><?php echo e(__('dashboard.organized_events')); ?></span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-accent-500"></div>
                    <span class="text-sm text-neutral-600 dark:text-neutral-400"><?php echo e(__('dashboard.wishlist_events')); ?></span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-accent"></div>
                    <span class="text-sm text-neutral-600 dark:text-neutral-400"><?php echo e(__('dashboard.today')); ?></span>
                </div>
            </div>
            
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        
        <!-- 👥 ATTIVITÀ SOCIALI - BENTO BOX STYLE -->
        <div class="py-12 md:py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="relative overflow-hidden" 
                     x-data="{ visible: false, activeIndex: 0 }" 
                     x-intersect.once="visible = true"
                     x-init="setInterval(() => { activeIndex = (activeIndex + 1) % 4 }, 3000)">
                    
                    <!-- Background Gradient Blobs -->
                    <div class="absolute inset-0 overflow-hidden pointer-events-none">
                        <div class="absolute -top-40 -right-40 w-80 h-80 bg-primary-500/10 rounded-full blur-3xl"></div>
                        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-accent/10 rounded-full blur-3xl"></div>
                    </div>

                    <div class="relative">
                    <!-- Header Minimal -->
                    <div class="mb-8"
                         x-show="visible"
                         x-transition:enter="transition ease-out duration-700"
                         x-transition:enter-start="opacity-0 translate-y-8"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <h2 class="text-2xl md:text-3xl font-bold text-neutral-900 dark:text-white mb-2"
                            style="font-family: 'Crimson Pro', serif;">
                            <?php echo e(__('dashboard.social_activities')); ?>

                        </h2>
                        <p class="text-neutral-600 dark:text-neutral-400">
                            <?php echo e(__('dashboard.social_activities_subtitle')); ?>

                        </p>
                    </div>

                <!-- BENTO BOX LAYOUT - Asimmetrico e Moderno -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                    
                    <!-- AMICI ONLINE - Grande, 2 colonne su mobile -->
                    <a href="<?php echo e($socialActivities[0]['url']); ?>" 
                       <?php if($socialActivities[0]['url'] === 'javascript:void(0)'): ?> onclick="event.preventDefault(); alert('<?php echo e(__('dashboard.friends_coming_soon')); ?>');" <?php endif; ?>
                       class="col-span-2 row-span-2 group relative overflow-hidden rounded-3xl bg-primary-600 dark:bg-primary-700 p-8 shadow-xl hover:shadow-2xl transition-all duration-500 hover:scale-[1.02]"
                       x-show="visible"
                       x-transition:enter="transition ease-out duration-700 delay-100"
                       x-transition:enter-start="opacity-0 scale-90"
                       x-transition:enter-end="opacity-100 scale-100">
                        
                        <!-- Glassmorphism overlay -->
                        <div class="absolute inset-0 bg-white/10 backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        <div class="relative h-full flex flex-col justify-between">
                            <div>
                                <i class="ph ph-user-circle text-6xl text-white/90 mb-4 block"></i>
                                <h3 class="text-2xl font-bold text-white mb-2"><?php echo e($socialActivities[0]['title']); ?></h3>
                                <p class="text-white/80 text-sm"><?php echo e($socialActivities[0]['description']); ?></p>
                            </div>
                            
                            <!-- Numero grande e elegante -->
                            <div class="text-right">
                                <span class="text-7xl font-black text-white/20 group-hover:text-white/30 transition-colors duration-500"><?php echo e($socialActivities[0]['count']); ?></span>
                            </div>
                        </div>
                    </a>

                    <!-- GRUPPI - Medio, 1 colonna -->
                    <a href="<?php echo e($socialActivities[1]['url']); ?>"
                       class="col-span-1 row-span-1 group relative overflow-hidden rounded-3xl bg-white dark:bg-neutral-800 p-6 shadow-lg hover:shadow-xl transition-all duration-500 hover:-translate-y-2 border-2 border-primary-200 dark:border-primary-900/50"
                       x-show="visible"
                       x-transition:enter="transition ease-out duration-700 delay-200"
                       x-transition:enter-start="opacity-0 scale-90"
                       x-transition:enter-end="opacity-100 scale-100">
                        
                        <div class="absolute top-0 right-0 w-20 h-20 bg-primary-500/10 rounded-full -mr-10 -mt-10"></div>
                        
                        <div class="relative">
                            <i class="ph ph-users-three text-4xl text-primary-600 mb-3 block"></i>
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-1"><?php echo e($socialActivities[1]['title']); ?></h3>
                                    <p class="text-xs text-neutral-600 dark:text-neutral-400"><?php echo e($socialActivities[1]['count']); ?> <?php echo e(__('dashboard.active')); ?></p>
                                </div>
                            </div>
                        </div>
                    </a>

                    <!-- INVITI - Medio, 1 colonna -->
                    <a href="<?php echo e($socialActivities[2]['url']); ?>"
                       class="col-span-1 row-span-1 group relative overflow-hidden rounded-3xl bg-primary-500 dark:bg-primary-600 p-6 shadow-lg hover:shadow-xl transition-all duration-500 hover:-translate-y-2"
                       x-show="visible"
                       x-transition:enter="transition ease-out duration-700 delay-300"
                       x-transition:enter-start="opacity-0 scale-90"
                       x-transition:enter-end="opacity-100 scale-100">
                        
                        <div class="relative h-full flex flex-col justify-between">
                            <i class="ph ph-envelope text-4xl text-white/90 block"></i>
                            
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-3xl font-black text-white"><?php echo e($socialActivities[2]['count']); ?></span>
                                </div>
                                <h3 class="text-sm font-bold text-white/90"><?php echo e($socialActivities[2]['title']); ?></h3>
                            </div>
                        </div>
                    </a>

                    <!-- MESSAGGI - Grande orizzontale, 2 colonne -->
                    <a href="<?php echo e($socialActivities[3]['url']); ?>"
                       class="col-span-2 row-span-1 group relative overflow-hidden rounded-3xl bg-primary-900 dark:bg-primary-950 p-6 shadow-xl hover:shadow-2xl transition-all duration-500 hover:scale-[1.02] border-2 border-primary-800 dark:border-primary-900"
                       x-show="visible"
                       x-transition:enter="transition ease-out duration-700 delay-400"
                       x-transition:enter-start="opacity-0 scale-90"
                       x-transition:enter-end="opacity-100 scale-100">
                        
                        <!-- Animated pulse -->
                        <div class="absolute top-4 right-4 w-3 h-3 bg-accent rounded-full animate-pulse"></div>
                        
                        <div class="relative flex items-center justify-between h-full">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 rounded-2xl bg-primary-800/50 dark:bg-primary-800/30 flex items-center justify-center">
                                    <i class="ph ph-chat-circle text-3xl text-accent"></i>
                                </div>
<div>
                                    <h3 class="text-xl font-bold text-white mb-1"><?php echo e($socialActivities[3]['title']); ?></h3>
                                    <p class="text-primary-300 dark:text-primary-400 text-sm"><?php echo e($socialActivities[3]['description']); ?></p>
                                </div>
                            </div>
                            
                            <div class="text-right">
                                <span class="text-4xl font-black text-white"><?php echo e($socialActivities[3]['count']); ?></span>
                            </div>
                        </div>
                    </a>
                </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- 📅 EVENTI IN ARRIVO - Timeline Verticale Fluida -->
        <div class="py-12 md:py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="relative" 
                     x-data="{ visible: false }" 
                     x-intersect.once="visible = true">
                
                <!-- Header -->
                <div class="mb-12"
                     x-show="visible"
                     x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0">
                    <h2 class="text-2xl md:text-3xl font-bold text-neutral-900 dark:text-white mb-2"
                        style="font-family: 'Crimson Pro', serif;">
                        <?php echo e(__('dashboard.upcoming_events')); ?>

                    </h2>
                    <p class="text-neutral-600 dark:text-neutral-400">
                        <?php echo e(__('dashboard.upcoming_events_subtitle')); ?>

                    </p>
                </div>

            <!-- Timeline Container -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($upcomingEvents) > 0): ?>
                <div class="relative pl-8 md:pl-12 space-y-8">
                    <!-- Timeline Line -->
                    <div class="absolute left-4 md:left-6 top-0 bottom-0 w-0.5 bg-primary-200 dark:bg-primary-900"></div>
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $upcomingEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div x-show="visible"
                             x-transition:enter="transition ease-out duration-700"
                             x-transition:enter-start="opacity-0 translate-x-8"
                             x-transition:enter-end="opacity-100 translate-x-0"
                             style="transition-delay: <?php echo e($index * 150); ?>ms"
                             class="relative group">
                            
                            <!-- Timeline Dot -->
                            <div class="absolute -left-[1.85rem] md:-left-[2.35rem] top-6 w-3 h-3 rounded-full bg-primary-600 ring-4 ring-primary-100 dark:ring-primary-900 group-hover:scale-150 transition-transform duration-300"></div>
                            
                            <!-- Event Content -->
                            <a href="<?php echo e($event['url']); ?>" class="block">
                                <div class="relative overflow-hidden rounded-2xl bg-white dark:bg-neutral-800 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-1 border border-neutral-200 dark:border-neutral-700 hover:border-primary-500">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event['image']): ?>
                                        <!-- Con Immagine -->
                                        <div class="flex flex-col md:flex-row">
                                            <div class="relative w-full md:w-48 h-48 md:h-auto overflow-hidden">
                                                <img src="<?php echo e($event['image']); ?>" 
                                                     alt="<?php echo e($event['title']); ?>" 
                                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                                <div class="absolute inset-0 bg-gradient-to-t md:bg-gradient-to-r from-black/60 to-transparent"></div>
                                            </div>
                                            <div class="p-6 flex-1">
                                                <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3" style="font-family: 'Crimson Pro', serif;">
                                                    <?php echo e($event['title']); ?>

                                                </h3>
                                                <div class="space-y-2 text-sm text-neutral-600 dark:text-neutral-400">
                                                    <div class="flex items-center gap-2">
                                                        <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                        </svg>
                                                        <span><?php echo e($event['date']); ?> • <?php echo e($event['time']); ?></span>
                                                    </div>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event['venue'] || $event['city']): ?>
                                                        <div class="flex items-center gap-2">
                                                            <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                            </svg>
                                                            <span><?php echo e($event['venue']); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event['city']): ?>, <?php echo e($event['city']); ?><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></span>
                                                        </div>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <!-- Senza Immagine -->
                                        <div class="p-6">
                                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3" style="font-family: 'Crimson Pro', serif;">
                                                <?php echo e($event['title']); ?>

                                            </h3>
                                            <div class="space-y-2 text-sm text-neutral-600 dark:text-neutral-400">
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    <span><?php echo e($event['date']); ?> • <?php echo e($event['time']); ?></span>
                                                </div>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event['venue'] || $event['city']): ?>
                                                    <div class="flex items-center gap-2">
                                                        <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                        </svg>
                                                        <span><?php echo e($event['venue']); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event['city']): ?>, <?php echo e($event['city']); ?><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></span>
                                                    </div>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php else: ?>
                <!-- Empty State -->
                <div class="text-center py-16"
                     x-show="visible"
                     x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0 scale-90"
                     x-transition:enter-end="opacity-100 scale-100">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-primary-100 dark:bg-primary-900/20 mb-4">
                        <svg class="w-10 h-10 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-2"><?php echo e(__('dashboard.no_recent_activity')); ?></h3>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>

        <!-- 🕐 ATTIVITÀ RECENTE - Feed Orizzontale Scorrevole -->
        <div class="py-12 md:py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div x-data="{ visible: false }" 
                     x-intersect.once="visible = true">
                
                <!-- Header -->
                <div class="mb-8"
                     x-show="visible"
                     x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0">
                    <h2 class="text-2xl md:text-3xl font-bold text-neutral-900 dark:text-white mb-2"
                        style="font-family: 'Crimson Pro', serif;">
                        <?php echo e(__('dashboard.recent_activity_title')); ?>

                    </h2>
                    <p class="text-neutral-600 dark:text-neutral-400">
                        <?php echo e(__('dashboard.recent_activity_subtitle')); ?>

                    </p>
                </div>

            <!-- Horizontal Scroll Feed -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($recentActivity) > 0): ?>
                <div class="flex gap-6 overflow-x-auto pb-4 scrollbar-hide">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $recentActivity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($activity['url']) && $activity['url']): ?>
                    <a href="<?php echo e($activity['url']); ?>"
                       x-show="visible"
                       x-transition:enter="transition ease-out duration-700"
                       x-transition:enter-start="opacity-0 translate-x-8"
                       x-transition:enter-end="opacity-100 translate-x-0"
                       style="transition-delay: <?php echo e($index * 150); ?>ms"
                       class="group flex-shrink-0 w-72 relative overflow-hidden rounded-2xl bg-white dark:bg-neutral-800 p-6 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-neutral-200 dark:border-neutral-700 cursor-pointer">
                    <?php elseif(isset($activity['type']) && $activity['type'] === 'poem' && isset($activity['id'])): ?>
                    <div onclick="Livewire.dispatch('openPoemModal', { poemId: <?php echo e($activity['id']); ?> })"
                         x-show="visible"
                         x-transition:enter="transition ease-out duration-700"
                         x-transition:enter-start="opacity-0 translate-x-8"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         style="transition-delay: <?php echo e($index * 150); ?>ms"
                         class="group flex-shrink-0 w-72 relative overflow-hidden rounded-2xl bg-white dark:bg-neutral-800 p-6 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-neutral-200 dark:border-neutral-700 cursor-pointer">
                    <?php else: ?>
                    <div x-show="visible"
                         x-transition:enter="transition ease-out duration-700"
                         x-transition:enter-start="opacity-0 translate-x-8"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         style="transition-delay: <?php echo e($index * 150); ?>ms"
                         class="group flex-shrink-0 w-72 relative overflow-hidden rounded-2xl bg-white dark:bg-neutral-800 p-6 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-neutral-200 dark:border-neutral-700">
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        
                        <!-- Decorative corner -->
                        <div class="absolute top-0 right-0 w-24 h-24 bg-primary-500/5 rounded-full -mr-12 -mt-12 group-hover:scale-150 transition-transform duration-500"></div>
                        
                        <div class="relative">
                            <!-- Icon -->
                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-primary-100 dark:bg-primary-900/30 mb-4 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($activity['icon']) && $activity['icon'] === 'book'): ?>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    <?php elseif(isset($activity['icon']) && $activity['icon'] === 'calendar'): ?>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    <?php elseif(isset($activity['icon']) && $activity['icon'] === 'compass'): ?>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    <?php else: ?>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </svg>
                            </div>
                            
                            <!-- Content -->
                            <h3 class="font-bold text-neutral-900 dark:text-white mb-2"><?php echo e($activity['title']); ?></h3>
                            <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-3"><?php echo e($activity['description']); ?></p>
                            
                            <!-- Time -->
                            <div class="flex items-center gap-2 text-xs text-neutral-500 dark:text-neutral-500">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span><?php echo e($activity['time']); ?></span>
                            </div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($activity['url']) && $activity['url']): ?>
                    </a>
                    <?php else: ?>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php else: ?>
                <!-- Empty State -->
                <div class="text-center py-16"
                     x-show="visible"
                     x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0 scale-90"
                     x-transition:enter-end="opacity-100 scale-100">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-primary-100 dark:bg-primary-900/20 mb-4">
                        <svg class="w-10 h-10 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-2"><?php echo e(__('dashboard.no_recent_activity')); ?></h3>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /Users/mazzi/slamin_v2/resources/views/livewire/dashboard/dashboard-index.blade.php ENDPATH**/ ?>