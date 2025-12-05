<div class="min-h-screen bg-gradient-to-br from-neutral-50 via-white to-amber-50/20 dark:from-neutral-900 dark:via-neutral-800 dark:to-neutral-900 overflow-hidden">
    
    <div class="relative pt-16 pb-12 md:pb-20 overflow-hidden bg-neutral-900 dark:bg-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center gap-6 md:flex-row md:justify-center md:gap-12">
                
                <!-- TICKET (dalla home) - Dimensione maggiorata -->
                <?php 
                    $tilt = rand(-3, 3);
                    $selectedColors = [
                        ['#fefaf3', '#fdf8f0', '#faf5ec'],
                        ['#fef9f1', '#fdf7ef', '#faf4ea'],
                        ['#fffbf5', '#fef9f3', '#fdf7f1']
                    ][rand(0, 2)];
                ?>
                <div class="hero-ticket-wrapper-large">
                    <div class="hero-ticket-wrapper" style="transform: rotate(<?php echo e($tilt); ?>deg);">
                        <div class="hero-cinema-ticket"
                             style="background: linear-gradient(135deg, <?php echo e($selectedColors[0]); ?> 0%, <?php echo e($selectedColors[1]); ?> 50%, <?php echo e($selectedColors[2]); ?> 100%);">
                            <div class="hero-ticket-perforation"></div>
                            <div class="hero-ticket-content">
                                <div class="ticket-mini-header">
                                    <div class="text-[8px] font-black tracking-wider text-red-700">TICKET</div>
                                    <div class="text-[7px] font-bold text-amber-700">#0<?php echo e(rand(1, 9)); ?><?php echo e(rand(0, 9)); ?><?php echo e(rand(0, 9)); ?></div>
                                </div>
                                <div class="flex-1 flex items-center justify-center">
                                    <div class="hero-ticket-stamp"><?php echo e(strtoupper(__('home.hero_category_events'))); ?></div>
                                </div>
                                <div class="ticket-mini-barcode">
                                    <div class="flex justify-center gap-[1px]">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($j = 0; $j < 20; $j++): ?>
                                        <div style="width: <?php echo e(rand(1, 2)); ?>px; height: <?php echo e(rand(12, 18)); ?>px; background: #2d2520;"></div>
                                        <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- TITOLO A FIANCO -->
                <div class="text-center md:text-left">
                    <h1 class="text-5xl md:text-7xl lg:text-8xl font-black text-white leading-tight" style="font-family: 'Playfair Display', serif;">
                        <?php echo e(__('events.discover_events')); ?>

                    </h1>
                    <p class="text-xl md:text-2xl text-white/80 mt-4 font-medium">
                        <?php echo e(__('events.where_poetry_lives')); ?>

                    </p>
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->canOrganizeEvents()): ?>
                            <div class="mt-6">
                                <a href="<?php echo e(route('events.create')); ?>" 
                                   class="group inline-flex items-center gap-3 px-6 py-3 rounded-xl
                                          bg-gradient-to-r from-red-700 to-red-800 
                                          hover:from-red-800 hover:to-red-900
                                          text-white font-bold shadow-xl shadow-red-700/30
                                          hover:shadow-2xl hover:shadow-red-800/40 hover:-translate-y-1
                                          transition-all duration-300">
                                    <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" 
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M12 4v16m8-8H4"/>
                                    </svg>
                                    <span><?php echo e(__('events.create_event')); ?></span>
                                </a>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Interactive Map Section -->
    <div class="mb-16 mt-12">
        <div class="max-w-[95rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-3xl font-bold text-red-700 dark:text-red-400" style="font-family: 'Crimson Pro', serif;">
                    <?php echo e(__('events.events_map')); ?>

                </h2>
                <button 
                    onclick="if(window.map) { window.map.setView([41.9028, 12.4964], 5); }"
                    class="px-4 py-2 bg-red-700/90 hover:bg-red-800 dark:bg-red-600/90 dark:hover:bg-red-700 text-white rounded-full text-sm font-semibold transition-all hover:scale-105 shadow-lg shadow-red-700/20">
                    <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <?php echo e(__('events.center_map')); ?>

                </button>
            </div>
            
            <div class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-amber-200/40 dark:border-amber-800/30">
                <!-- Map Container (always visible) -->
                <div id="eventsMap" 
                     wire:ignore
                     class="h-[650px] w-full bg-neutral-100 dark:bg-neutral-800">
                </div>
                
                <!-- Hidden data container that updates with Livewire -->
                <div id="mapEventsData" 
                     class="hidden"
                     data-events='<?php echo json_encode($mapData, 15, 512) ?>'
                     data-total-count="<?php echo e($events->count()); ?>">
                </div>
                
                <!-- Hidden translation text for popup -->
                <div data-view-details-text="<?php echo e(__('events.view_details')); ?>" class="hidden"></div>
                
                <!-- Map Controls Overlay -->
                <div class="absolute top-4 right-4 z-[1000] flex flex-col gap-3">
                    <!-- Reset View -->
                    <button 
                        onclick="if(window.map) window.map.setView([41.9028, 12.4964], 5)"
                        class="p-3 bg-white dark:bg-neutral-800 rounded-full shadow-lg hover:shadow-xl transition-all hover:scale-110 group"
                        title="Centra mappa sull'Italia">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-500 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </button>
                    
                    <!-- Map Style Selector -->
                    <div class="bg-white dark:bg-neutral-800 rounded-full shadow-lg p-2 flex flex-col gap-2">
                        <button 
                            onclick="changeMapStyle('standard')"
                            id="style-standard"
                            class="map-style-btn p-2.5 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20 transition-all"
                            title="Mappa Standard">
                            <svg class="w-4 h-4 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>
                        </button>
                        <button 
                            onclick="changeMapStyle('satellite')"
                            id="style-satellite"
                            class="map-style-btn p-2.5 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20 transition-all"
                            title="Vista Satellite">
                            <svg class="w-4 h-4 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </button>
                        <button 
                            onclick="changeMapStyle('dark')"
                            id="style-dark"
                            class="map-style-btn p-2.5 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20 transition-all"
                            title="Mappa Scura">
                            <svg class="w-4 h-4 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                        </button>
                        <button 
                            onclick="changeMapStyle('voyager')"
                            id="style-voyager"
                            class="map-style-btn active p-2.5 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20 transition-all"
                            title="Mappa Colorata">
                            <svg class="w-4 h-4 text-red-600 dark:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                            </svg>
                        </button>
                        <button 
                            onclick="changeMapStyle('positron')"
                            id="style-positron"
                            class="map-style-btn p-2.5 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20 transition-all"
                            title="Mappa Chiara Minimal">
                            <svg class="w-4 h-4 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </button>
                        <button 
                            onclick="changeMapStyle('topo')"
                            id="style-topo"
                            class="map-style-btn p-2.5 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20 transition-all"
                            title="Mappa Topografica">
                            <svg class="w-4 h-4 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Legend -->
                <div class="absolute bottom-4 left-4 z-[1000] bg-white/95 dark:bg-neutral-800/95 backdrop-blur-md rounded-2xl p-4 shadow-xl border border-amber-200/40 dark:border-amber-800/30 max-w-xs">
                    <h4 class="text-xs font-bold text-neutral-700 dark:text-neutral-300 mb-3 uppercase tracking-wider"><?php echo e(__('events.legend')); ?></h4>
                    <div class="grid grid-cols-2 gap-x-3 gap-y-2">
                        <?php
                            $eventCategories = [
                                'poetry_slam' => '#DC2626',
                                'workshop' => '#2563EB',
                                'open_mic' => '#16A34A',
                                'reading' => '#9333EA',
                                'festival' => '#EA580C',
                                'concert' => '#DB2777',
                                'book_presentation' => '#0891B2',
                                'conference' => '#65A30D',
                                'contest' => '#C026D3',
                                'poetry_art' => '#0D9488',
                                'residency' => '#CA8A04',
                                'spoken_word' => '#7C3AED',
                                'other' => '#64748B'
                            ];
                        ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $eventCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat => $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center gap-1.5">
                            <div class="w-3 h-3 rounded-full flex-shrink-0" style="background-color: <?php echo e($color); ?>"></div>
                            <span class="text-xs text-neutral-600 dark:text-neutral-400 truncate"><?php echo e(__('events.category_' . $cat)); ?></span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <?php if (isset($component)) { $__componentOriginaldf8ab9716e070c0be0571d5979408477 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldf8ab9716e070c0be0571d5979408477 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.events-stats-section','data' => ['statistics' => $statistics]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('events-stats-section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['statistics' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($statistics)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldf8ab9716e070c0be0571d5979408477)): ?>
<?php $attributes = $__attributesOriginaldf8ab9716e070c0be0571d5979408477; ?>
<?php unset($__attributesOriginaldf8ab9716e070c0be0571d5979408477); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldf8ab9716e070c0be0571d5979408477)): ?>
<?php $component = $__componentOriginaldf8ab9716e070c0be0571d5979408477; ?>
<?php unset($__componentOriginaldf8ab9716e070c0be0571d5979408477); ?>
<?php endif; ?>
    
    
    <?php if (isset($component)) { $__componentOriginalb7f14c5b185b44e241c20786cffea746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb7f14c5b185b44e241c20786cffea746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.events-search-section','data' => ['search' => $search,'cities' => $cities,'city' => $city,'type' => $type,'freeOnly' => $freeOnly]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('events-search-section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['search' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($search),'cities' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($cities),'city' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($city),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($type),'freeOnly' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($freeOnly)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb7f14c5b185b44e241c20786cffea746)): ?>
<?php $attributes = $__attributesOriginalb7f14c5b185b44e241c20786cffea746; ?>
<?php unset($__attributesOriginalb7f14c5b185b44e241c20786cffea746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb7f14c5b185b44e241c20786cffea746)): ?>
<?php $component = $__componentOriginalb7f14c5b185b44e241c20786cffea746; ?>
<?php unset($__componentOriginalb7f14c5b185b44e241c20786cffea746); ?>
<?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasActiveFilters && $events->count() > 0): ?>
    <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-12 border-b-2 border-red-300/50 dark:border-red-700/50">
        <div class="mb-10">
            <h2 class="text-3xl md:text-4xl font-bold text-red-700 dark:text-red-400 mb-2" style="font-family: 'Crimson Pro', serif;">
                <?php echo e(__('events.filtered_events')); ?>

            </h2>
            <p class="text-neutral-600 dark:text-neutral-400">
                <?php echo e(__('events.filtered_events_description', ['count' => $events->count()])); ?>

            </p>
        </div>
        
        
        <?php
            $sizes = [
                'xl' => 'col-span-2 row-span-2 min-h-[500px]',
                'lg' => 'col-span-2 row-span-1 min-h-[280px]',
                'md' => 'col-span-1 row-span-2 min-h-[450px]',
                'sm' => 'col-span-1 row-span-1 min-h-[280px]',
            ];
            $pattern = ['xl', 'sm', 'sm', 'lg', 'md', 'sm', 'sm', 'lg'];
        ?>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-4 auto-rows-auto">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $sizeKey = $pattern[$index % count($pattern)];
                    $sizeClass = $sizes[$sizeKey];
                    $isLarge = in_array($sizeKey, ['xl', 'lg', 'md']);
                ?>
                
                <div class="<?php echo e($sizeClass); ?>">
                    <?php echo $__env->make('livewire.events.partials.event-card', ['event' => $event, 'index' => $index, 'isLarge' => $isLarge], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
    <?php elseif($hasActiveFilters && $events->count() === 0): ?>
    <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-12 border-b-2 border-red-300/50 dark:border-red-700/50">
        <div class="text-center py-16">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-red-100 dark:bg-red-900/30 mb-4">
                <svg class="w-10 h-10 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-2">
                <?php echo e(__('events.no_filtered_events')); ?>

            </h3>
            <p class="text-neutral-600 dark:text-neutral-400 mb-6 max-w-md mx-auto">
                <?php echo e(__('events.no_filtered_events_description')); ?>

            </p>
            <button wire:click="resetFilters" 
                    class="inline-flex items-center px-6 py-3 bg-red-700 text-white rounded-full font-semibold hover:bg-red-800 transition-all hover:scale-105">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <?php echo e(__('events.reset_filters')); ?>

            </button>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($todayEventsTimeline->count() > 0): ?>
    <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-12 bg-gradient-to-br from-red-50/50 via-white to-red-50/30 dark:from-red-900/10 dark:via-neutral-800 dark:to-red-900/10">
        <div class="mb-10">
            <h2 class="text-3xl md:text-4xl font-bold text-red-700 dark:text-red-400 mb-2" style="font-family: 'Crimson Pro', serif;">
                <?php echo e(__('events.today_events')); ?>

            </h2>
            <p class="text-neutral-600 dark:text-neutral-400">
                <?php echo e(__('events.today_events_description')); ?>

            </p>
        </div>
        
        <div class="relative" x-data="{ 
            scrollTimeline(direction) {
                const container = this.$refs.todayTimeline;
                if (!container) return;
                const containerRect = container.getBoundingClientRect();
                const scrollLeft = container.scrollLeft;
                const scrollAmount = containerRect.width * 0.8;
                const newScrollLeft = direction > 0 
                    ? Math.min(container.scrollWidth - containerRect.width, scrollLeft + scrollAmount)
                    : Math.max(0, scrollLeft - scrollAmount);
                container.scrollTo({ left: newScrollLeft, behavior: 'smooth' });
            }
        }">
            <!-- Left Arrow (Desktop Only) -->
            <button @click="scrollTimeline(-1)" 
                    class="hidden md:flex absolute -left-16 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white/95 dark:bg-neutral-800/95 backdrop-blur-sm rounded-full shadow-xl hover:scale-110 transition-all duration-300 items-center justify-center text-neutral-900 dark:text-white group">
                <svg class="w-6 h-6 transform group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            
            <!-- Right Arrow (Desktop Only) -->
            <button @click="scrollTimeline(1)" 
                    class="hidden md:flex absolute -right-16 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white/95 dark:bg-neutral-800/95 backdrop-blur-sm rounded-full shadow-xl hover:scale-110 transition-all duration-300 items-center justify-center text-neutral-900 dark:text-white group">
                <svg class="w-6 h-6 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
            
            <!-- Mobile Scroll Indicator -->
            <div class="md:hidden relative mb-4">
                <div class="flex items-center justify-center gap-2 text-neutral-600 dark:text-neutral-400 text-sm">
                    <svg class="w-5 h-5 animate-bounce-horizontal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                    </svg>
                    <span><?php echo e(__('events.scroll_to_see_more')); ?></span>
                </div>
            </div>
            
            <!-- Timeline with DeLorean -->
            <div class="relative mb-8" 
                 x-data="{
                    deloreanPosition: 0,
                    isDragging: false,
                    init() {
                        this.deloreanPosition = 0;
                    },
                    handleDragStart(e) {
                        this.isDragging = true;
                        e.preventDefault();
                        e.stopPropagation();
                    },
                    handleDrag(e) {
                        if (!this.isDragging) return;
                        const timelineContainer = this.$refs.todayTimelineContainer;
                        if (!timelineContainer) return;
                        const rect = timelineContainer.getBoundingClientRect();
                        const x = e.clientX - rect.left;
                        const maxX = rect.width - 48;
                        this.deloreanPosition = Math.max(0, Math.min(x, maxX));
                        this.scrollToPosition();
                    },
                    handleDragEnd() {
                        this.isDragging = false;
                    },
                    scrollToPosition() {
                        const eventsContainer = this.$refs.todayTimeline;
                        if (!eventsContainer) return;
                        
                        const containerWidth = eventsContainer.getBoundingClientRect().width;
                        const scrollWidth = eventsContainer.scrollWidth;
                        const maxScroll = scrollWidth - containerWidth;
                        
                        // Calculate scroll position based on DeLorean position
                        const scrollRatio = this.deloreanPosition / (containerWidth - 48);
                        const targetScroll = scrollRatio * maxScroll;
                        
                        eventsContainer.scrollLeft = Math.max(0, Math.min(maxScroll, targetScroll));
                    }
                 }">
                <!-- Timeline Line Container -->
                <div x-ref="todayTimelineContainer" class="relative h-12 px-8 md:px-12"
                     @mousemove="handleDrag($event)"
                     @mouseup="handleDragEnd()"
                     @mouseleave="handleDragEnd()">
                    <!-- Timeline Line -->
                    <div class="absolute top-6 left-8 right-8 h-1 bg-gradient-to-r from-red-600 via-primary-500 to-primary-600 dark:from-red-400 dark:via-primary-400 dark:to-primary-400 opacity-60"></div>
                    
                    <!-- DeLorean Time Machine -->
                    <img src="<?php echo e(asset('assets/images/delorean.png')); ?>" 
                         alt="DeLorean"
                         class="absolute w-12 h-auto z-20 cursor-grab active:cursor-grabbing pointer-events-auto"
                         style="top: 0px; will-change: left;"
                         :style="'left: ' + deloreanPosition + 'px; transform: translateX(-50%);'"
                         @mousedown="handleDragStart($event)"
                         draggable="false">
                </div>
            </div>
            
            <div x-ref="todayTimeline" class="flex gap-6 overflow-x-auto pb-16 pt-4 px-8 md:px-12 scrollbar-hide relative"
                 style="-webkit-overflow-scrolling: touch;"
                 x-init="
                    const container = $refs.todayTimeline;
                    const deloreanContainer = $refs.todayTimelineContainer;
                    if (container && deloreanContainer) {
                        container.addEventListener('scroll', () => {
                            const scrollRatio = container.scrollLeft / (container.scrollWidth - container.getBoundingClientRect().width);
                            const maxX = deloreanContainer.getBoundingClientRect().width - 48;
                            const newPosition = scrollRatio * maxX;
                            if (!$data.isDragging) {
                                $data.deloreanPosition = Math.max(0, Math.min(maxX, newPosition));
                            }
                        });
                    }
                 ">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $todayEventsTimeline; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex-shrink-0 timeline-event" 
                         data-event-index="<?php echo e($i); ?>" 
                         data-timeline-type="today">
                        <?php echo $__env->make('livewire.events.partials.timeline-ticket', ['event' => $event, 'index' => $i], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-12">
        <div class="mb-10">
            <h2 class="text-3xl md:text-4xl font-bold text-red-700 dark:text-red-400 mb-2" style="font-family: 'Crimson Pro', serif;">
                <?php echo e(__('events.upcoming_events')); ?>

            </h2>
            <p class="text-neutral-600 dark:text-neutral-400">
                <?php echo e(__('events.timeline_upcoming_description')); ?>

            </p>
        </div>
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($upcomingEventsTimeline->count() > 0): ?>
        <div class="relative" x-data="{ 
            scrollTimeline(direction) {
                const container = this.$refs.upcomingTimeline;
                if (!container) return;
                const containerRect = container.getBoundingClientRect();
                const scrollLeft = container.scrollLeft;
                const scrollAmount = containerRect.width * 0.8;
                const newScrollLeft = direction > 0 
                    ? Math.min(container.scrollWidth - containerRect.width, scrollLeft + scrollAmount)
                    : Math.max(0, scrollLeft - scrollAmount);
                container.scrollTo({ left: newScrollLeft, behavior: 'smooth' });
            }
        }">
            <!-- Left Arrow (Desktop Only) -->
            <button @click="scrollTimeline(-1)" 
                    class="hidden md:flex absolute -left-16 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white/95 dark:bg-neutral-800/95 backdrop-blur-sm rounded-full shadow-xl hover:scale-110 transition-all duration-300 items-center justify-center text-neutral-900 dark:text-white group">
                <svg class="w-6 h-6 transform group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            
            <!-- Right Arrow (Desktop Only) -->
            <button @click="scrollTimeline(1)" 
                    class="hidden md:flex absolute -right-16 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white/95 dark:bg-neutral-800/95 backdrop-blur-sm rounded-full shadow-xl hover:scale-110 transition-all duration-300 items-center justify-center text-neutral-900 dark:text-white group">
                <svg class="w-6 h-6 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
            
            <!-- Mobile Scroll Indicator -->
            <div class="md:hidden relative mb-4">
                <div class="flex items-center justify-center gap-2 text-neutral-600 dark:text-neutral-400 text-sm">
                    <svg class="w-5 h-5 animate-bounce-horizontal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                    </svg>
                    <span><?php echo e(__('events.scroll_to_see_more')); ?></span>
                </div>
            </div>
            
            <!-- Timeline with DeLorean -->
            <div class="relative mb-8" 
                 x-data="{
                    deloreanPosition: 0,
                    isDragging: false,
                    init() {
                        this.deloreanPosition = 0;
                    },
                    handleDragStart(e) {
                        this.isDragging = true;
                        e.preventDefault();
                        e.stopPropagation();
                    },
                    handleDrag(e) {
                        if (!this.isDragging) return;
                        const timelineContainer = this.$refs.upcomingTimelineContainer;
                        if (!timelineContainer) return;
                        const rect = timelineContainer.getBoundingClientRect();
                        const x = e.clientX - rect.left;
                        const maxX = rect.width - 48;
                        this.deloreanPosition = Math.max(0, Math.min(x, maxX));
                        this.scrollToPosition();
                    },
                    handleDragEnd() {
                        this.isDragging = false;
                    },
                    scrollToPosition() {
                        const eventsContainer = this.$refs.upcomingTimeline;
                        if (!eventsContainer) return;
                        
                        const containerWidth = eventsContainer.getBoundingClientRect().width;
                        const scrollWidth = eventsContainer.scrollWidth;
                        const maxScroll = scrollWidth - containerWidth;
                        
                        // Calculate scroll position based on DeLorean position
                        const scrollRatio = this.deloreanPosition / (containerWidth - 48);
                        const targetScroll = scrollRatio * maxScroll;
                        
                        eventsContainer.scrollLeft = Math.max(0, Math.min(maxScroll, targetScroll));
                    }
                 }">
                <!-- Timeline Line Container -->
                <div x-ref="upcomingTimelineContainer" class="relative h-12 px-8 md:px-12"
                     @mousemove="handleDrag($event)"
                     @mouseup="handleDragEnd()"
                     @mouseleave="handleDragEnd()">
                    <!-- Timeline Line -->
                    <div class="absolute top-6 left-8 right-8 h-1 bg-gradient-to-r from-red-600 via-primary-500 to-primary-600 dark:from-red-400 dark:via-primary-400 dark:to-primary-400 opacity-60"></div>
                    
                    <!-- DeLorean Time Machine -->
                    <img src="<?php echo e(asset('assets/images/delorean.png')); ?>" 
                         alt="DeLorean"
                         class="absolute w-12 h-auto z-20 cursor-grab active:cursor-grabbing pointer-events-auto"
                         style="top: 0px; will-change: left;"
                         :style="'left: ' + deloreanPosition + 'px; transform: translateX(-50%);'"
                         @mousedown="handleDragStart($event)"
                         draggable="false">
                </div>
            </div>
            
            <div x-ref="upcomingTimeline" class="flex gap-6 overflow-x-auto pb-16 pt-4 px-8 md:px-12 scrollbar-hide relative"
                 style="-webkit-overflow-scrolling: touch;"
                 x-init="
                    const container = $refs.upcomingTimeline;
                    const deloreanContainer = $refs.upcomingTimelineContainer;
                    if (container && deloreanContainer) {
                        container.addEventListener('scroll', () => {
                            const scrollRatio = container.scrollLeft / (container.scrollWidth - container.getBoundingClientRect().width);
                            const maxX = deloreanContainer.getBoundingClientRect().width - 48;
                            const newPosition = scrollRatio * maxX;
                            if (!$data.isDragging) {
                                $data.deloreanPosition = Math.max(0, Math.min(maxX, newPosition));
                            }
                        });
                    }
                 ">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $upcomingEventsTimeline; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex-shrink-0 timeline-event" 
                         data-event-index="<?php echo e($i); ?>" 
                         data-timeline-type="upcoming">
                        <?php echo $__env->make('livewire.events.partials.timeline-ticket', ['event' => $event, 'index' => $i], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
        <?php else: ?>
        <div class="text-center py-16">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-red-100 dark:bg-red-900/30 mb-4">
                <svg class="w-10 h-10 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-2">
                <?php echo e(__('events.no_upcoming_events')); ?>

            </h3>
            <p class="text-neutral-600 dark:text-neutral-400">
                <?php echo e(__('events.no_upcoming_events_description')); ?>

            </p>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-12 border-t-2 border-amber-300/50 dark:border-amber-700/50 bg-gradient-to-b from-transparent via-amber-50/20 to-transparent dark:via-amber-900/10">
        <div class="mb-10">
            <h2 class="text-3xl md:text-4xl font-bold text-red-700 dark:text-red-400 mb-2" style="font-family: 'Crimson Pro', serif;">
                <?php echo e(__('events.past_events')); ?>

            </h2>
            <p class="text-neutral-600 dark:text-neutral-400">
                <?php echo e(__('events.timeline_past_description')); ?>

            </p>
        </div>
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pastEventsTimeline->count() > 0): ?>
        <div class="relative" x-data="{ 
            scrollTimeline(direction) {
                const container = this.$refs.pastTimeline;
                if (!container) return;
                const containerRect = container.getBoundingClientRect();
                const scrollLeft = container.scrollLeft;
                const scrollAmount = containerRect.width * 0.8;
                const newScrollLeft = direction > 0 
                    ? Math.min(container.scrollWidth - containerRect.width, scrollLeft + scrollAmount)
                    : Math.max(0, scrollLeft - scrollAmount);
                container.scrollTo({ left: newScrollLeft, behavior: 'smooth' });
            }
        }">
            <!-- Left Arrow (Desktop Only) -->
            <button @click="scrollTimeline(-1)" 
                    class="hidden md:flex absolute -left-16 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white/95 dark:bg-neutral-800/95 backdrop-blur-sm rounded-full shadow-xl hover:scale-110 transition-all duration-300 items-center justify-center text-neutral-900 dark:text-white group">
                <svg class="w-6 h-6 transform group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            
            <!-- Right Arrow (Desktop Only) -->
            <button @click="scrollTimeline(1)" 
                    class="hidden md:flex absolute -right-16 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white/95 dark:bg-neutral-800/95 backdrop-blur-sm rounded-full shadow-xl hover:scale-110 transition-all duration-300 items-center justify-center text-neutral-900 dark:text-white group">
                <svg class="w-6 h-6 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
            
            <!-- Mobile Scroll Indicator -->
            <div class="md:hidden relative mb-4">
                <div class="flex items-center justify-center gap-2 text-neutral-600 dark:text-neutral-400 text-sm">
                    <svg class="w-5 h-5 animate-bounce-horizontal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                    </svg>
                    <span><?php echo e(__('events.scroll_to_see_more')); ?></span>
                </div>
            </div>
            
            <!-- Timeline with DeLorean -->
            <div class="relative mb-8"
                 x-data="{
                    deloreanPosition: 0,
                    isDragging: false,
                    init() {
                        this.deloreanPosition = 0;
                    },
                    handleDragStart(e) {
                        this.isDragging = true;
                        e.preventDefault();
                        e.stopPropagation();
                    },
                    handleDrag(e) {
                        if (!this.isDragging) return;
                        const timelineContainer = this.$refs.pastTimelineContainer;
                        if (!timelineContainer) return;
                        const rect = timelineContainer.getBoundingClientRect();
                        const x = e.clientX - rect.left;
                        const maxX = rect.width - 48;
                        this.deloreanPosition = Math.max(0, Math.min(x, maxX));
                        this.scrollToPosition();
                    },
                    handleDragEnd() {
                        this.isDragging = false;
                    },
                    scrollToPosition() {
                        const eventsContainer = this.$refs.pastTimeline;
                        if (!eventsContainer) return;
                        
                        const containerWidth = eventsContainer.getBoundingClientRect().width;
                        const scrollWidth = eventsContainer.scrollWidth;
                        const maxScroll = scrollWidth - containerWidth;
                        
                        // Calculate scroll position based on DeLorean position
                        const scrollRatio = this.deloreanPosition / (containerWidth - 48);
                        const targetScroll = scrollRatio * maxScroll;
                        
                        eventsContainer.scrollLeft = Math.max(0, Math.min(maxScroll, targetScroll));
                    }
                 }">
                <!-- Timeline Line Container -->
                <div x-ref="pastTimelineContainer" class="relative h-12 px-8 md:px-12"
                     @mousemove="handleDrag($event)"
                     @mouseup="handleDragEnd()"
                     @mouseleave="handleDragEnd()">
                    <!-- Timeline Line -->
                    <div class="absolute top-6 left-8 right-8 h-1 bg-gradient-to-r from-amber-600 via-amber-500 to-amber-600 dark:from-amber-400 dark:via-amber-400 dark:to-amber-400 opacity-60"></div>
                    
                    <!-- DeLorean Time Machine -->
                    <img src="<?php echo e(asset('assets/images/delorean.png')); ?>" 
                         alt="DeLorean"
                         class="absolute w-12 h-auto z-20 cursor-grab active:cursor-grabbing pointer-events-auto"
                         style="top: 0px; will-change: left;"
                         :style="'left: ' + deloreanPosition + 'px; transform: translateX(-50%);'"
                         @mousedown="handleDragStart($event)"
                         draggable="false">
                </div>
            </div>
            
            <div x-ref="pastTimeline" class="flex gap-6 overflow-x-auto pb-16 pt-4 px-8 md:px-12 scrollbar-hide relative"
                 style="-webkit-overflow-scrolling: touch;"
                 x-init="
                    const container = $refs.pastTimeline;
                    const deloreanContainer = $refs.pastTimelineContainer;
                    if (container && deloreanContainer) {
                        container.addEventListener('scroll', () => {
                            const scrollRatio = container.scrollLeft / (container.scrollWidth - container.getBoundingClientRect().width);
                            const maxX = deloreanContainer.getBoundingClientRect().width - 48;
                            const newPosition = scrollRatio * maxX;
                            if (!$data.isDragging) {
                                $data.deloreanPosition = Math.max(0, Math.min(maxX, newPosition));
                            }
                        });
                    }
                 ">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $pastEventsTimeline; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex-shrink-0 timeline-event" 
                         data-event-index="<?php echo e($i); ?>" 
                         data-timeline-type="past">
                        <?php echo $__env->make('livewire.events.partials.timeline-ticket', ['event' => $event, 'index' => $i], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
        <?php else: ?>
        <div class="text-center py-16">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-amber-100 dark:bg-amber-900/30 mb-4">
                <svg class="w-10 h-10 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-2">
                <?php echo e(__('events.no_past_events')); ?>

            </h3>
            <p class="text-neutral-600 dark:text-neutral-400">
                <?php echo e(__('events.no_past_events_description')); ?>

            </p>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-12 border-t-2 border-amber-300/50 dark:border-amber-700/50 bg-gradient-to-b from-transparent via-amber-50/20 to-transparent dark:via-amber-900/10">
        <div class="mb-10">
            <h2 class="text-3xl md:text-4xl font-bold text-red-700 dark:text-red-400 mb-2" style="font-family: 'Crimson Pro', serif;">
                <?php echo e(__('events.personalized_events')); ?>

            </h2>
            <p class="text-neutral-600 dark:text-neutral-400">
                <?php echo e(__('events.personalized_events_description')); ?>

            </p>
        </div>
        
        <?php if(auth()->guard()->check()): ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($personalizedEvents->count() > 0): ?>
                
                <?php
                    $sizes = [
                        'xl' => 'col-span-2 row-span-2 min-h-[500px]',
                        'lg' => 'col-span-2 row-span-1 min-h-[280px]',
                        'md' => 'col-span-1 row-span-2 min-h-[450px]',
                        'sm' => 'col-span-1 row-span-1 min-h-[280px]',
                    ];
                    $pattern = ['xl', 'sm', 'sm', 'lg', 'md', 'sm', 'sm', 'lg'];
                ?>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-4 auto-rows-auto">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $personalizedEvents->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $sizeKey = $pattern[$index % count($pattern)];
                            $sizeClass = $sizes[$sizeKey];
                            $isLarge = in_array($sizeKey, ['xl', 'lg', 'md']);
                        ?>
                        
                        <div class="<?php echo e($sizeClass); ?>">
                            <?php echo $__env->make('livewire.events.partials.event-card', ['event' => $event, 'index' => $index, 'isLarge' => $isLarge], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-16">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-amber-100 dark:bg-amber-900/30 mb-4">
                        <svg class="w-10 h-10 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-2">
                        <?php echo e(__('events.no_personalized_events')); ?>

                    </h3>
                    <p class="text-neutral-600 dark:text-neutral-400 mb-6 max-w-md mx-auto">
                        <?php echo e(__('events.personalized_events_empty_description')); ?>

                    </p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php else: ?>
            <div class="text-center py-16">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-amber-100 dark:bg-amber-900/30 mb-4">
                    <svg class="w-10 h-10 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-2">
                    <?php echo e(__('events.login_to_see_personalized')); ?>

                </h3>
                <p class="text-neutral-600 dark:text-neutral-400 mb-6 max-w-md mx-auto">
                    <?php echo e(__('events.personalized_events_login_description')); ?>

                </p>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Route::has('login')): ?>
                <a href="<?php echo e(route('login')); ?>" class="inline-flex items-center px-6 py-3 bg-red-700 text-white rounded-full font-semibold hover:bg-red-800 transition-all hover:scale-105">
                    <?php echo e(__('auth.login') ?? 'Accedi'); ?>

                </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>


    <!-- Loading Overlay -->
    <div wire:loading wire:target="search,city,type,freeOnly,quickFilter,applyQuickFilter,resetFilters" 
         class="fixed inset-0 bg-black/20 backdrop-blur-sm z-50 flex items-center justify-center">
        <div class="bg-white dark:bg-neutral-800 rounded-xl p-6 shadow-2xl">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-red-700 mx-auto"></div>
            <p class="mt-4 text-neutral-900 dark:text-white font-medium"><?php echo e(__('events.loading')); ?>...</p>
        </div>
    </div>
    
    <?php $__env->startPush('styles'); ?>
    <style>
    /* ========================================
       CINEMA TICKETS - REALISTIC DESIGN
       ======================================== */
    
    /* Cinema Ticket */
    .cinema-ticket {
        display: flex;
        background: #fef7e6;
        border-radius: 8px;
        box-shadow: 
            0 8px 24px rgba(0, 0, 0, 0.4),
            0 16px 48px rgba(0, 0, 0, 0.3);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    
    /* Heavy Worn/Vintage Effect */
    .ticket-worn::before {
        content: '';
        position: absolute;
        inset: 0;
        background: 
            url("data:image/svg+xml,%3Csvg width='100' height='100' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='1.2' numOctaves='5' /%3E%3C/filter%3E%3Crect width='100' height='100' filter='url(%23noise)' opacity='0.25'/%3E%3C/svg%3E"),
            radial-gradient(ellipse at var(--spot1-x) var(--spot1-y), 
                rgba(139, 115, 85, var(--wear-opacity)) 0%, 
                rgba(150, 120, 90, calc(var(--wear-opacity) * 0.6)) 15%,
                transparent 25%),
            radial-gradient(circle at var(--spot2-x) var(--spot2-y), 
                rgba(160, 130, 95, calc(var(--wear-opacity) * 0.7)) 0%, 
                transparent 18%),
            radial-gradient(ellipse at var(--spot3-x) var(--spot3-y), 
                rgba(145, 120, 88, calc(var(--wear-opacity) * 0.5)) 0%, 
                transparent 20%),
            radial-gradient(circle at var(--spot4-x) var(--spot4-y), 
                rgba(155, 125, 92, calc(var(--wear-opacity) * 0.4)) 0%, 
                transparent 12%),
            radial-gradient(ellipse at center, 
                transparent 40%,
                rgba(139, 115, 85, calc(var(--wear-opacity) * 0.15)) 100%);
        pointer-events: none;
        z-index: 1;
    }
    
    .ticket-worn::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: rgba(139, 115, 85, calc(var(--wear-opacity) * 0.5));
        transform: translateY(-50%);
        box-shadow: 
            0 1px 2px rgba(139, 115, 85, calc(var(--wear-opacity) * 0.3)),
            0 -1px 2px rgba(139, 115, 85, calc(var(--wear-opacity) * 0.3));
        pointer-events: none;
        z-index: 1;
    }
    
    .ticket-watermark {
        position: absolute;
        top: 20%;
        right: -3rem;
        transform: translateY(-50%) rotate(-90deg);
        transform-origin: center;
        z-index: 3;
        pointer-events: none;
    }
    
    .ticket-watermark img {
        opacity: 0.3;
    }
    
    .ticket-content {
        position: relative;
        z-index: 2;
        flex: 1;
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .cinema-ticket:hover {
        transform: translateY(-12px) scale(1.02) !important;
        box-shadow: 
            0 16px 32px rgba(0, 0, 0, 0.5),
            0 24px 64px rgba(0, 0, 0, 0.4),
            0 0 0 2px rgba(218, 165, 32, 0.4);
    }
    
    .ticket-clickable-area {
        display: block;
        color: inherit;
        text-decoration: none;
    }
    
    .ticket-perforation {
        width: 24px;
        background: linear-gradient(135deg, 
            rgba(139, 115, 85, 0.15) 0%,
            rgba(160, 140, 110, 0.1) 100%
        );
        position: relative;
        flex-shrink: 0;
    }
    
    .ticket-perforation::before {
        content: '';
        position: absolute;
        top: -5px;
        bottom: -5px;
        right: 0;
        width: 12px;
        background: 
            radial-gradient(circle at 0 8px, transparent 4px, currentColor 4px) 0 0 / 12px 16px repeat-y;
        color: inherit;
    }
    
    .ticket-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 0.75rem;
        border-bottom: 2px dashed rgba(139, 115, 85, 0.3);
    }
    
    .ticket-admit {
        font-size: 0.75rem;
        font-weight: 900;
        letter-spacing: 0.1em;
        color: #b91c1c;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }
    
    .ticket-serial {
        font-size: 0.65rem;
        font-weight: 700;
        color: #8b7355;
        font-family: 'Courier New', monospace;
    }
    
    .ticket-image {
        width: 100%;
        height: 140px;
        border-radius: 4px;
        overflow: hidden;
        border: 2px solid rgba(139, 115, 85, 0.2);
        margin: 0.5rem 0;
    }
    
    .ticket-title {
        font-family: 'Crimson Pro', serif;
        font-size: 1.25rem;
        font-weight: 700;
        color: #1a1a1a;
        line-height: 1.3;
        text-align: center;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin: 0.5rem 0;
    }
    
    /* Rankings Section */
    .ticket-rankings {
        margin: 0.75rem 0;
        padding: 0.75rem;
        background: rgba(139, 115, 85, 0.05);
        border-radius: 6px;
        border: 1px dashed rgba(139, 115, 85, 0.2);
    }
    
    .ticket-rankings-title {
        font-size: 0.75rem;
        font-weight: 900;
        color: #b91c1c;
        text-align: center;
        margin-bottom: 0.5rem;
        letter-spacing: 0.05em;
        font-family: 'Crimson Pro', serif;
    }
    
    .ticket-rankings-list {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .ticket-ranking-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.375rem;
        background: rgba(255, 255, 255, 0.5);
        border-radius: 4px;
        font-size: 0.75rem;
    }
    
    .ticket-ranking-first {
        background: linear-gradient(135deg, rgba(251, 191, 36, 0.2) 0%, rgba(245, 158, 11, 0.15) 100%);
        border: 1px solid rgba(217, 119, 6, 0.3);
    }
    
    .ticket-ranking-second {
        background: linear-gradient(135deg, rgba(229, 231, 235, 0.3) 0%, rgba(209, 213, 219, 0.2) 100%);
        border: 1px solid rgba(156, 163, 175, 0.3);
    }
    
    .ticket-ranking-third {
        background: linear-gradient(135deg, rgba(205, 127, 50, 0.2) 0%, rgba(184, 115, 51, 0.15) 100%);
        border: 1px solid rgba(160, 82, 45, 0.3);
    }
    
    .ticket-ranking-medal {
        font-size: 1.25rem;
        flex-shrink: 0;
    }
    
    .ticket-ranking-name {
        flex: 1;
        font-weight: 600;
        color: #1a1a1a;
        font-family: 'Crimson Pro', serif;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .ticket-ranking-score {
        font-weight: 900;
        color: #b91c1c;
        font-family: 'Crimson Pro', serif;
        flex-shrink: 0;
    }
    
    .ticket-price {
        text-align: center;
        font-size: 0.75rem;
        font-weight: 400;
        color: #b91c1c;
        font-family: 'Special Elite', 'Courier New', monospace;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 0.25rem 0.625rem;
        margin: 0.5rem auto;
        width: fit-content;
        border: 2px solid #b91c1c;
        border-radius: 3px;
        opacity: 0.75;
        position: relative;
        box-shadow: 
            0 1px 3px rgba(185, 28, 28, 0.15),
            inset 0 0 6px rgba(185, 28, 28, 0.04);
        background: 
            radial-gradient(ellipse at 30% 40%, rgba(185, 28, 28, 0.03) 0%, transparent 60%),
            radial-gradient(ellipse at 70% 70%, rgba(185, 28, 28, 0.025) 0%, transparent 50%);
        pointer-events: none;
    }
    
    .ticket-price::before {
        content: '';
        position: absolute;
        inset: -1px;
        border: 1px solid rgba(185, 28, 28, 0.12);
        border-radius: 2px;
        pointer-events: none;
    }
    
    .ticket-details {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
        padding: 1rem 0;
        border-top: 1px dashed rgba(139, 115, 85, 0.25);
        border-bottom: 1px dashed rgba(139, 115, 85, 0.25);
    }
    
    .ticket-detail-item {
        text-align: center;
    }
    
    .ticket-detail-label {
        font-size: 0.625rem;
        font-weight: 700;
        color: #8b7355;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.25rem;
    }
    
    .ticket-detail-value {
        font-size: 0.875rem;
        font-weight: 600;
        color: #2d2d2d;
        font-family: 'Crimson Pro', serif;
    }
    
    .ticket-location {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.375rem;
    }
    
    .location-icon {
        width: 14px;
        height: 14px;
        color: #8b7355;
        flex-shrink: 0;
    }
    
    .ticket-barcode-wrapper {
        position: relative;
        margin-top: 0.5rem;
    }
    
    .ticket-barcode {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.375rem;
        cursor: help;
        transition: all 0.3s ease;
    }
    
    .ticket-barcode:hover {
        transform: scale(1.05);
    }
    
    .barcode-lines {
        display: flex;
        align-items: flex-end;
        gap: 1px;
        height: 45px;
        padding: 0 1rem;
    }
    
    .barcode-line {
        background: #000;
        align-self: flex-end;
    }
    
    .barcode-number {
        font-size: 0.625rem;
        font-weight: 600;
        color: #666;
        font-family: 'Courier New', monospace;
        letter-spacing: 0.1em;
    }
    
    .barcode-tooltip {
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        margin-bottom: 0.75rem;
        background: linear-gradient(135deg, 
            #fef9f0 0%,
            #fdf5e6 50%,
            #fcf1dc 100%
        );
        color: #2d2d2d;
        padding: 1rem 1.25rem;
        border-radius: 6px;
        border: 2px solid rgba(139, 115, 85, 0.3);
        box-shadow: 
            0 8px 20px rgba(0, 0, 0, 0.3),
            0 4px 12px rgba(0, 0, 0, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.5);
        z-index: 50;
        min-width: 260px;
        max-width: 300px;
    }
    
    .barcode-tooltip::before {
        content: '';
        position: absolute;
        inset: 4px;
        border: 1px solid rgba(139, 115, 85, 0.15);
        border-radius: 4px;
        pointer-events: none;
    }
    
    .barcode-tooltip::after {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        border: 8px solid transparent;
        border-top-color: #fdf5e6;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
    }
    
    .tooltip-title {
        font-size: 0.75rem;
        font-weight: 900;
        color: #b91c1c;
        margin-bottom: 0.625rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        text-align: center;
        border-bottom: 2px solid rgba(185, 28, 28, 0.2);
        padding-bottom: 0.5rem;
    }
    
    .tooltip-description {
        font-size: 0.75rem;
        line-height: 1.5;
        color: #4a4035;
        margin-bottom: 0.75rem;
        font-style: italic;
        text-align: center;
    }
    
    .tooltip-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.6875rem;
        padding: 0.5rem 0;
        border-top: 1px dashed rgba(139, 115, 85, 0.2);
    }
    
    .tooltip-label {
        color: #8b7355;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        font-size: 0.625rem;
    }
    
    .tooltip-value {
        color: #2d2d2d;
        font-weight: 600;
        font-family: 'Crimson Pro', serif;
    }
    
    .ticket-social {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1.5rem;
        padding-top: 1rem;
        margin-top: 0.75rem;
        border-top: 1px dashed rgba(139, 115, 85, 0.25);
    }
    
    .ticket-stub {
        width: 80px;
        background: linear-gradient(180deg, 
            rgba(139, 115, 85, 0.08) 0%,
            rgba(160, 140, 110, 0.05) 100%
        );
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        border-left: 2px dashed rgba(139, 115, 85, 0.3);
        flex-shrink: 0;
    }
    
    .stub-perforation {
        position: absolute;
        top: -5px;
        bottom: -5px;
        left: -6px;
        width: 12px;
        background: 
            radial-gradient(circle at 12px 8px, transparent 4px, currentColor 4px) 0 0 / 12px 16px repeat-y;
    }
    
    .stub-content {
        writing-mode: vertical-rl;
        text-align: center;
        transform: rotate(180deg);
        padding: 1rem 0.5rem;
    }
    
    .stub-date {
        font-size: 1.25rem;
        font-weight: 900;
        color: #2d2d2d;
        font-family: 'Crimson Pro', serif;
        margin-bottom: 0.75rem;
    }
    
    .stub-serial {
        font-size: 0.625rem;
        font-weight: 700;
        color: #8b7355;
        font-family: 'Courier New', monospace;
        letter-spacing: 0.05em;
    }
    
    @keyframes fade-in { 
        from { opacity: 0; transform: scale(0.95); } 
        to { opacity: 1; transform: scale(1); } 
    }
    .animate-fade-in { 
        animation: fade-in 0.5s ease-out forwards; 
        opacity: 0; 
    }
    
    
    </style>
    <?php $__env->stopPush(); ?>
    
    <?php $__env->startPush('scripts'); ?>
    <?php $__env->stopPush(); ?>
</div>
<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/livewire/events/events-index.blade.php ENDPATH**/ ?>