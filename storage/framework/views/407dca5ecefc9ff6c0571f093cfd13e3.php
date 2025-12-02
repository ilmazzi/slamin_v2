<div class="min-h-screen bg-gradient-to-br from-neutral-50 via-white to-primary-50/30 dark:from-neutral-900 dark:via-neutral-800 dark:to-neutral-900 overflow-hidden">
    
    
    <section class="relative pt-16 pb-12 md:pb-20 overflow-hidden cork-board-section">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center gap-6 md:flex-row md:justify-center md:gap-12">
                
                <!-- CORK BOARD CARD (come homepage gigs section) -->
                <?php
                    $tapeWidth = rand(110, 150);
                    $tapeRotation = rand(-4, 4);
                    $tapeOffsetX = rand(-10, 10);
                    $tapeBottomRotation = rand(-4, 4);
                    $tapeBottomOffsetX = rand(-10, 10);
                ?>
                <div class="gigs-page-cork-card-wrapper">
                    <div class="gigs-page-cork-card">
                        
                        <div class="washi-tape washi-top" 
                             style="width: <?php echo e($tapeWidth); ?>px; transform: translate(calc(-50% + <?php echo e($tapeOffsetX); ?>px), 0) rotate(<?php echo e($tapeRotation); ?>deg);"></div>
                        
                        
                        <div class="notice-paper" style="transform: rotate(<?php echo e(rand(-2, 2)); ?>deg);">
                            <div class="notice-header-section">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="notice-category-badge">
                                        <?php echo e(__('gigs.title')); ?>

                                    </span>
                                </div>
                            </div>
                            
                            
                            <h3 class="notice-title">
                                <?php echo e(__('gigs.browse_all')); ?>

                            </h3>
                            
                            
                            <p class="notice-description">
                                <?php echo e(__('gigs.filters.search')); ?>

                            </p>
                            
                            
                            <div class="notice-footer-bar">
                                <div class="notice-author">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                    </svg>
                                    <span><?php echo e($stats['open_gigs_count'] ?? 0); ?> <?php echo e(__('gigs.applications.applications')); ?></span>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="washi-tape washi-bottom" 
                             style="width: <?php echo e($tapeWidth); ?>px; transform: translate(calc(-50% + <?php echo e($tapeBottomOffsetX); ?>px), 0) rotate(<?php echo e($tapeBottomRotation); ?>deg);"></div>
                    </div>
                </div>
                
                <!-- TITOLO A FIANCO -->
                <div class="text-center md:text-left">
                    <h1 class="text-5xl md:text-7xl lg:text-8xl font-black text-neutral-900 dark:text-white leading-tight drop-shadow-lg" style="font-family: 'Crimson Pro', serif;">
                        <?php echo e(__('gigs.title')); ?>

                    </h1>
                    <p class="text-xl md:text-2xl text-neutral-800 dark:text-neutral-200 mt-4 font-medium drop-shadow-md">
                        <?php echo e(__('gigs.browse_all')); ?>

                    </p>
                </div>
            </div>
            
            <!-- Search Bar -->
            <div class="max-w-4xl mx-auto mt-12"
                 x-data="{ visible: false }"
                 x-init="setTimeout(() => visible = true, 200)"
                 x-show="visible"
                 x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100">
                <div class="relative">
                    <svg class="absolute left-6 top-1/2 -translate-y-1/2 w-6 h-6 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input 
                        type="text" 
                        wire:model.live.debounce.500ms="search"
                        placeholder="<?php echo e(__('gigs.filters.search')); ?>"
                        class="w-full pl-16 pr-6 py-5 rounded-full bg-white/95 dark:bg-neutral-800/95 backdrop-blur-xl text-neutral-900 dark:text-white text-lg border-0 shadow-2xl focus:ring-4 focus:ring-accent-400/50 transition-all placeholder:text-neutral-400">
                </div>
            </div>

            <!-- Quick Filters Pills -->
            <div class="flex flex-wrap justify-center gap-3 mt-6"
                 x-data="{ visible: false }"
                 x-init="setTimeout(() => visible = true, 300)"
                 x-show="visible"
                 x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0">
                
                <button wire:click="$toggle('show_featured')"
                        class="px-6 py-3 rounded-full backdrop-blur-md text-neutral-900 dark:text-white text-sm font-bold transition-all hover:scale-110 hover:shadow-xl active:scale-95
                               <?php echo e($show_featured ? 'bg-white/90 dark:bg-white/30 shadow-lg ring-2 ring-neutral-300 dark:ring-white/50' : 'bg-white/70 dark:bg-white/10 hover:bg-white/90 dark:hover:bg-white/20'); ?>">
                    <svg class="inline w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    <?php echo e(__('gigs.filters.featured_only')); ?>

                </button>

                <button wire:click="$toggle('show_urgent')"
                        class="px-6 py-3 rounded-full backdrop-blur-md text-neutral-900 dark:text-white text-sm font-bold transition-all hover:scale-110 hover:shadow-xl active:scale-95
                               <?php echo e($show_urgent ? 'bg-white/90 dark:bg-white/30 shadow-lg ring-2 ring-neutral-300 dark:ring-white/50' : 'bg-white/70 dark:bg-white/10 hover:bg-white/90 dark:hover:bg-white/20'); ?>">
                    <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <?php echo e(__('gigs.filters.urgent_only')); ?>

                </button>

                <button wire:click="$toggle('show_remote')"
                        class="px-6 py-3 rounded-full backdrop-blur-md text-neutral-900 dark:text-white text-sm font-bold transition-all hover:scale-110 hover:shadow-xl active:scale-95
                               <?php echo e($show_remote ? 'bg-white/90 dark:bg-white/30 shadow-lg ring-2 ring-neutral-300 dark:ring-white/50' : 'bg-white/70 dark:bg-white/10 hover:bg-white/90 dark:hover:bg-white/20'); ?>">
                    <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <?php echo e(__('gigs.filters.remote_only')); ?>

                </button>

                <button wire:click="clearFilters"
                        class="px-6 py-3 rounded-full bg-white/70 dark:bg-white/10 hover:bg-white/90 dark:hover:bg-white/20 backdrop-blur-md text-neutral-900 dark:text-white text-sm font-bold transition-all hover:scale-110 hover:shadow-xl active:scale-95">
                    <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <?php echo e(__('common.clear_all')); ?>

                </button>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 pb-20 relative z-20">
        
        <!-- Advanced Filters - Elegant Collapsible -->
        <div class="bg-white/95 dark:bg-neutral-800/95 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/50 dark:border-neutral-700/50 p-8 mb-12"
             x-data="{ visible: false, showAdvanced: false }"
             x-init="setTimeout(() => visible = true, 400)"
             x-show="visible"
             x-transition:enter="transition ease-out duration-700"
             x-transition:enter-start="opacity-0 translate-y-8"
             x-transition:enter-end="opacity-100 translate-y-0">
            
            <button @click="showAdvanced = !showAdvanced"
                    class="w-full flex items-center justify-between group">
                <h3 class="text-lg font-bold text-neutral-900 dark:text-white flex items-center gap-3">
                    <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                    </svg>
                    <?php echo e(__('gigs.filters.advanced')); ?>

                </h3>
                
                <div class="flex items-center gap-2 text-primary-600 dark:text-primary-400">
                    <span class="text-sm font-semibold" x-text="showAdvanced ? '<?php echo e(__('common.hide')); ?>' : '<?php echo e(__('common.show')); ?>'"></span>
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" 
                         :class="showAdvanced ? 'rotate-180' : ''"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </button>

            <!-- Advanced Filters Grid -->
            <div x-show="showAdvanced"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 -translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8 pt-8 border-t-2 border-dashed border-neutral-200 dark:border-neutral-700">
                
                <!-- Category -->
                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-3">
                        <?php echo e(__('gigs.fields.category')); ?>

                    </label>
                    <select wire:model.live="category" 
                            class="w-full px-4 py-3 rounded-xl border-2 border-neutral-200 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 transition-all">
                        <option value=""><?php echo e(__('gigs.filters.select_category')); ?></option>
                        <option value="performance"><?php echo e(__('gigs.categories.performance')); ?></option>
                        <option value="hosting"><?php echo e(__('gigs.categories.hosting')); ?></option>
                        <option value="judging"><?php echo e(__('gigs.categories.judging')); ?></option>
                        <option value="technical"><?php echo e(__('gigs.categories.technical')); ?></option>
                        <option value="translation"><?php echo e(__('gigs.categories.translation')); ?></option>
                        <option value="other"><?php echo e(__('gigs.categories.other')); ?></option>
                    </select>
                </div>

                <!-- Type -->
                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-3">
                        <?php echo e(__('gigs.fields.type')); ?>

                    </label>
                    <select wire:model.live="type" 
                            class="w-full px-4 py-3 rounded-xl border-2 border-neutral-200 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 transition-all">
                        <option value=""><?php echo e(__('gigs.filters.select_type')); ?></option>
                        <option value="paid"><?php echo e(__('gigs.types.paid')); ?></option>
                        <option value="volunteer"><?php echo e(__('gigs.types.volunteer')); ?></option>
                        <option value="collaboration"><?php echo e(__('gigs.types.collaboration')); ?></option>
                    </select>
                </div>

                <!-- Language -->
                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-3">
                        <?php echo e(__('gigs.fields.language')); ?>

                    </label>
                    <select wire:model.live="language" 
                            class="w-full px-4 py-3 rounded-xl border-2 border-neutral-200 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 transition-all">
                        <option value=""><?php echo e(__('gigs.filters.select_language')); ?></option>
                        <option value="it"><?php echo e(__('gigs.languages.it')); ?></option>
                        <option value="en"><?php echo e(__('gigs.languages.en')); ?></option>
                        <option value="es"><?php echo e(__('gigs.languages.es')); ?></option>
                        <option value="fr"><?php echo e(__('gigs.languages.fr')); ?></option>
                        <option value="de"><?php echo e(__('gigs.languages.de')); ?></option>
                        <option value="pt"><?php echo e(__('gigs.languages.pt')); ?></option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Gigs Grid - Notice Board Cards (come homepage) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-12">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $gigs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $gig): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    // Random tape properties per card
                    $tapeWidth = rand(110, 150);
                    $tapeRotation = rand(-4, 4);
                    $tapeOffsetX = rand(-10, 10);
                    $tapeBottomRotation = rand(-4, 4);
                    $tapeBottomOffsetX = rand(-10, 10);
                ?>
                <div class="flex-shrink-0"
                     x-data="{ visible: false }"
                     x-init="setTimeout(() => visible = true, <?php echo e(600 + ($index * 80)); ?>)"
                     x-show="visible"
                     x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100">
                    
                    
                    <a href="<?php echo e(route('gigs.show', $gig)); ?>" 
                       class="group block h-full notice-card">
                        
                        
                        <div class="washi-tape washi-top" 
                             style="width: <?php echo e($tapeWidth); ?>px; transform: translate(calc(-50% + <?php echo e($tapeOffsetX); ?>px), 0) rotate(<?php echo e($tapeRotation); ?>deg);"></div>
                        
                        
                        <div class="notice-paper" style="transform: rotate(<?php echo e(rand(-2, 2)); ?>deg);">
                            
                            
                            <div class="notice-header-section">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="notice-category-badge">
                                        <?php echo e(__('gigs.categories.' . $gig->category)); ?>

                                    </span>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($gig->is_urgent): ?>
                                        <span class="notice-urgent-flag">!! URGENTE !!</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                            
                            
                            <h3 class="notice-title group-hover:text-accent-700 transition-colors">
                                <?php echo e($gig->title); ?>

                            </h3>
                            
                            
                            <p class="notice-description">
                                <?php echo e(Str::limit(strip_tags($gig->description), 100)); ?>

                            </p>
                            
                            
                            <div class="notice-details-list">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($gig->location): ?>
                                    <div class="notice-detail-row">
                                        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span><?php echo e($gig->location); ?></span>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($gig->deadline): ?>
                                    <div class="notice-detail-row">
                                        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                        <span>Scadenza: <?php echo e($gig->deadline->format('d M Y')); ?></span>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($gig->compensation): ?>
                                    <div class="notice-detail-row notice-compensation-row">
                                        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                        </svg>
                                        <span><?php echo e(Str::limit($gig->compensation, 35)); ?></span>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            
                            
                            <div class="notice-footer-bar">
                                <div class="notice-author">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                    </svg>
                                    <span><?php echo e($gig->user ? $gig->user->name : ($gig->requester ? $gig->requester->name : 'Organizzatore')); ?></span>
                                </div>
                                <div class="notice-applications-badge">
                                    <?php echo e($gig->application_count); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($gig->max_applications): ?>/<?php echo e($gig->max_applications); ?><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="washi-tape washi-bottom" 
                             style="width: <?php echo e($tapeWidth); ?>px; transform: translate(calc(-50% + <?php echo e($tapeBottomOffsetX); ?>px), 0) rotate(<?php echo e($tapeBottomRotation); ?>deg);"></div>
                    </a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-full">
                    <div class="bg-white/95 dark:bg-neutral-800/95 backdrop-blur-xl rounded-3xl border border-white/50 dark:border-neutral-700/50 p-20 text-center shadow-2xl">
                        <div class="w-32 h-32 mx-auto mb-8 rounded-full bg-gradient-to-br from-primary-100 to-accent-100 dark:from-primary-900/30 dark:to-accent-900/30 flex items-center justify-center transform group-hover:scale-110 transition-transform">
                            <svg class="w-16 h-16 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-neutral-900 dark:text-white mb-4">
                            <?php echo e(__('gigs.no_gigs_found')); ?>

                        </h3>
                        <p class="text-neutral-600 dark:text-neutral-400 mb-10 text-lg max-w-md mx-auto">
                            <?php echo e(__('gigs.no_gigs_description')); ?>

                        </p>
                        <button wire:click="clearFilters" 
                                class="inline-flex items-center gap-3 px-10 py-4 rounded-xl bg-gradient-to-r from-primary-500 to-accent-500 hover:from-primary-600 hover:to-accent-600 text-white font-bold text-lg shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            <?php echo e(__('common.clear_all')); ?>

                        </button>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- Pagination -->
        <div class="mt-16">
            <?php echo e($gigs->links()); ?>

        </div>

    </div>
    
    <!-- Animations & Styles -->
    <style>
        @keyframes float-particle {
            0%, 100% { 
                transform: translateY(0) translateX(0); 
                opacity: 0.4;
            }
            25% { 
                transform: translateY(-20px) translateX(10px); 
                opacity: 0.6;
            }
            50% { 
                transform: translateY(-40px) translateX(-10px); 
                opacity: 0.8;
            }
            75% { 
                transform: translateY(-20px) translateX(10px); 
                opacity: 0.6;
            }
        }
        
        /* ==========================================
           GIGS PAGE CORK BOARD CARD
           ========================================== */
        
        .gigs-page-cork-card-wrapper {
            position: relative;
            width: 100%;
            max-width: 320px;
            height: 280px;
        }
        
        .gigs-page-cork-card {
            position: relative;
            height: 100%;
            display: block;
            overflow: visible;
        }
        
        /* ==========================================
           NOTICE BOARD / BACHECA CARD
           ========================================== */
        
        .notice-card {
            position: relative;
            height: 100%;
            display: block;
            overflow: visible;
        }
        
        .notice-paper {
            position: relative;
            height: 100%;
            background: 
                /* Paper texture */
                url("data:image/svg+xml,%3Csvg width='150' height='150' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='paper'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='1.1' numOctaves='3' /%3E%3C/filter%3E%3Crect width='150' height='150' filter='url(%23paper)' opacity='0.08'/%3E%3C/svg%3E"),
                /* White/cream paper */
                linear-gradient(160deg, #fffef9 0%, #fffcf5 30%, #fefbef 70%, #fffef9 100%);
            padding: 2.25rem 1.5rem 2.25rem 1.5rem;
            box-shadow: 
                0 6px 18px rgba(0, 0, 0, 0.2),
                0 3px 8px rgba(0, 0, 0, 0.15);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        :is(.dark .notice-paper) {
            background: 
                url("data:image/svg+xml,%3Csvg width='150' height='150' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='paper'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='1.1' numOctaves='3' /%3E%3C/filter%3E%3Crect width='150' height='150' filter='url(%23paper)' opacity='0.08'/%3E%3C/svg%3E"),
                linear-gradient(160deg, #3f3f3a 0%, #38382f 30%, #323229 70%, #3f3f3a 100%);
        }
        
        /* Scotch tape - FULLY VISIBLE, YELLOW, SERRATED EDGES */
        .washi-tape {
            position: absolute;
            left: 50%;
            height: 32px;
            background: 
                /* Subtle shine */
                linear-gradient(
                    105deg,
                    rgba(255, 255, 255, 0.25) 0%,
                    transparent 30%,
                    transparent 70%,
                    rgba(255, 255, 255, 0.25) 100%
                ),
                /* SOFT YELLOW scotch */
                linear-gradient(180deg, 
                    rgba(240, 210, 100, 0.92) 0%, 
                    rgba(245, 220, 120, 0.90) 50%, 
                    rgba(250, 230, 140, 0.92) 100%
                );
            box-shadow: 
                0 3px 8px rgba(0, 0, 0, 0.35),
                0 1px 4px rgba(0, 0, 0, 0.25),
                inset 0 2px 5px rgba(255, 255, 255, 0.9),
                inset 0 -1px 3px rgba(0, 0, 0, 0.2);
            z-index: 5;
            border-top: 1px solid rgba(255, 255, 255, 0.8);
            border-bottom: 1px solid rgba(200, 180, 100, 0.4);
            /* SERRATED EDGES */
            clip-path: polygon(
                0% 0%, 2% 5%, 0% 10%, 2% 15%, 0% 20%, 2% 25%, 0% 30%, 2% 35%, 0% 40%, 2% 45%, 0% 50%, 2% 55%, 0% 60%, 2% 65%, 0% 70%, 2% 75%, 0% 80%, 2% 85%, 0% 90%, 2% 95%, 0% 100%,
                100% 100%,
                98% 95%, 100% 90%, 98% 85%, 100% 80%, 98% 75%, 100% 70%, 98% 65%, 100% 60%, 98% 55%, 100% 50%, 98% 45%, 100% 40%, 98% 35%, 100% 30%, 98% 25%, 100% 20%, 98% 15%, 100% 10%, 98% 5%, 100% 0%
            );
        }
        
        :is(.dark .washi-tape) {
            background: 
                linear-gradient(
                    105deg,
                    rgba(255, 255, 255, 0.15) 0%,
                    transparent 30%,
                    transparent 70%,
                    rgba(255, 255, 255, 0.15) 100%
                ),
                linear-gradient(180deg, 
                    rgba(210, 185, 90, 0.88) 0%, 
                    rgba(220, 195, 110, 0.86) 50%, 
                    rgba(230, 205, 130, 0.88) 100%
                );
            box-shadow: 
                0 3px 8px rgba(0, 0, 0, 0.6),
                0 1px 4px rgba(0, 0, 0, 0.5),
                inset 0 2px 5px rgba(255, 255, 255, 0.45),
                inset 0 -1px 3px rgba(0, 0, 0, 0.4);
        }
        
        .washi-top {
            top: -12px;
        }
        
        .washi-bottom {
            bottom: -12px;
        }
        
        /* Typography */
        .notice-category-badge {
            display: inline-block;
            font-size: 0.6875rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: white;
            background: linear-gradient(135deg, #0369a1 0%, #0284c7 100%);
            padding: 0.375rem 0.75rem;
            border-radius: 0.25rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        .notice-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: #1c1917;
            margin-bottom: 0.75rem;
            line-height: 1.25;
        }
        
        :is(.dark .notice-title) {
            color: #f5f5f4;
        }
        
        .notice-description {
            font-size: 0.875rem;
            color: #57534e;
            margin-bottom: 1.25rem;
            line-height: 1.5;
        }
        
        :is(.dark .notice-description) {
            color: #a8a29e;
        }
        
        /* Footer */
        .notice-footer-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 0.875rem;
            margin-top: 0.875rem;
            border-top: 2px dashed #d6d3d1;
            font-size: 0.75rem;
        }
        
        :is(.dark .notice-footer-bar) {
            border-top-color: #57534e;
        }
        
        .notice-author {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            color: #78716c;
            font-weight: 600;
        }
        
        :is(.dark .notice-author) {
            color: #a8a29e;
        }
        
        .notice-header-section {
            margin-bottom: 0.5rem;
        }
        
        /* Details list */
        .notice-details-list {
            background: rgba(34, 197, 94, 0.08);
            border-left: 4px solid #16a34a;
            padding: 0.875rem;
            margin-bottom: 1rem;
        }
        
        :is(.dark .notice-details-list) {
            background: rgba(34, 197, 94, 0.15);
            border-left-color: #22c55e;
        }
        
        .notice-detail-row {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            font-size: 0.8125rem;
            color: #44403c;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        
        .notice-detail-row:last-child {
            margin-bottom: 0;
        }
        
        :is(.dark .notice-detail-row) {
            color: #d6d3d1;
        }
        
        .notice-compensation-row {
            font-weight: 700;
            color: #15803d;
        }
        
        :is(.dark .notice-compensation-row) {
            color: #4ade80;
        }
        
        .notice-urgent-flag {
            font-size: 0.625rem;
            font-weight: 900;
            color: #dc2626;
            transform: rotate(-3deg);
            animation: pulse 2s infinite;
        }
        
        .notice-applications-badge {
            font-weight: 800;
            color: #0c4a6e;
            background: #e0f2fe;
            padding: 0.25rem 0.625rem;
            border-radius: 9999px;
            font-size: 0.6875rem;
        }
        
        :is(.dark .notice-applications-badge) {
            background: #075985;
            color: #7dd3fc;
        }
        
        /* Hover effects */
        .notice-card:hover .notice-paper {
            transform: rotate(0deg) translateY(-6px);
            box-shadow: 
                0 10px 30px rgba(0, 0, 0, 0.25),
                0 6px 15px rgba(0, 0, 0, 0.18);
        }
        
        .notice-card:hover .washi-tape {
            box-shadow: 
                0 3px 8px rgba(0, 0, 0, 0.3),
                inset 0 1px 4px rgba(255, 255, 255, 0.7),
                inset 0 -1px 3px rgba(0, 0, 0, 0.2);
        }
        
        /* Cork Board Background */
        .cork-board-section {
            position: relative;
            background: 
                /* Cork texture pattern */
                url("data:image/svg+xml,%3Csvg width='200' height='200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='cork'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='1.5' numOctaves='5' seed='2' /%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23cork)' opacity='0.4'/%3E%3C/svg%3E"),
                /* Cork color gradient */
                radial-gradient(ellipse at center, #c19a6b 0%, #b08968 20%, #9d7a5e 40%, #8b6f54 60%, #7a5f47 80%, #6b4f3a 100%),
                linear-gradient(180deg, #a68868 0%, #8f7459 50%, #a68868 100%);
            box-shadow: inset 0 0 100px rgba(0, 0, 0, 0.15);
        }
        
        :is(.dark .cork-board-section) {
            background: 
                url("data:image/svg+xml,%3Csvg width='200' height='200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='cork'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='1.5' numOctaves='5' seed='2' /%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23cork)' opacity='0.4'/%3E%3C/svg%3E"),
                radial-gradient(ellipse at center, #4a3f32 0%, #3d342a 20%, #352d24 40%, #2d261f 60%, #251f19 80%, #1d1814 100%),
                linear-gradient(180deg, #3a3128 0%, #2d261e 50%, #3a3128 100%);
            box-shadow: inset 0 0 100px rgba(0, 0, 0, 0.5);
        }
    </style>
    
</div>
<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/livewire/translations/gig-index.blade.php ENDPATH**/ ?>