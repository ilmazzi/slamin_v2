<div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($topGigs && $topGigs->count() > 0): ?>
    <div class="max-w-[90rem] mx-auto px-4 md:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-12 section-title-fade">
            <h2 class="text-4xl md:text-5xl font-bold mb-3 text-neutral-900 dark:text-white" style="font-family: 'Crimson Pro', serif;">
                <?php echo __('home.gigs_section_title'); ?>

            </h2>
            <p class="text-lg text-neutral-600 dark:text-neutral-100 font-medium">
                <?php echo e(__('home.gigs_section_subtitle')); ?>

            </p>
        </div>

        <!-- Gigs - Horizontal Scroll with Desktop Navigation -->
        <div class="relative" x-data="{ 
            scrollHorizontal(direction) {
                const container = $refs.scrollContainer;
                const scrollAmount = container.offsetWidth * 0.8;
                container.scrollBy({ 
                    left: direction * scrollAmount, 
                    behavior: 'smooth' 
                });
            }
        }">
            <!-- Left Arrow (Desktop Only) - OUTSIDE content -->
            <button @click="scrollHorizontal(-1)" 
                    class="hidden md:flex absolute -left-16 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white/95 dark:bg-neutral-800/95 backdrop-blur-sm rounded-full shadow-xl hover:scale-110 transition-all duration-300 items-center justify-center text-neutral-900 dark:text-white group">
                <svg class="w-6 h-6 transform group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            
            <!-- Right Arrow (Desktop Only) - OUTSIDE content -->
            <button @click="scrollHorizontal(1)" 
                    class="hidden md:flex absolute -right-16 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white/95 dark:bg-neutral-800/95 backdrop-blur-sm rounded-full shadow-xl hover:scale-110 transition-all duration-300 items-center justify-center text-neutral-900 dark:text-white group">
                <svg class="w-6 h-6 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
            
            <!-- Mobile Scroll Indicator -->
            <div class="md:hidden relative mb-4">
                <div class="flex items-center justify-center gap-2 text-neutral-700 dark:text-neutral-300 text-sm">
                    <svg class="w-5 h-5 animate-bounce-horizontal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                    </svg>
                    <span>Scorri per vedere altro</span>
                </div>
            </div>
            
            <div x-ref="scrollContainer" class="flex gap-6 overflow-x-auto pb-20 pt-20 px-8 md:px-12 scrollbar-hide"
                 style="-webkit-overflow-scrolling: touch; overflow-y: visible;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $topGigs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $gig): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    // Random tape properties per card
                    $tapeWidth = rand(110, 150);
                    $tapeRotation = rand(-4, 4);
                    $tapeOffsetX = rand(-10, 10);
                    $tapeBottomRotation = rand(-4, 4);
                    $tapeBottomOffsetX = rand(-10, 10);
                ?>
                <div class="w-80 md:w-96 flex-shrink-0 fade-scale-item"
                     x-data
                     x-intersect.once="$el.classList.add('animate-fade-in')"
                     style="animation-delay: <?php echo e($i * 0.1); ?>s">
                    
                    
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
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        
        <div class="text-center mt-8">
            <a href="<?php echo e(route('gigs.index')); ?>" 
               class="inline-block text-2xl md:text-3xl font-bold text-neutral-800 dark:text-white hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-300"
               style="font-family: 'Crimson Pro', serif;">
                → <?php echo e(__('home.see_all_gigs')); ?>

            </a>
        </div>
    </div>
    
    <style>
        @keyframes fade-in { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        .animate-fade-in { animation: fade-in 0.5s ease-out forwards; opacity: 0; }
        
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
            /* Width is set inline per card (random) */
            height: 32px;
            background: 
                /* Subtle shine (light yellow to slightly lighter) */
                linear-gradient(
                    105deg,
                    rgba(255, 255, 255, 0.25) 0%,
                    transparent 30%,
                    transparent 70%,
                    rgba(255, 255, 255, 0.25) 100%
                ),
                /* SOFT YELLOW scotch - darker to lighter gradient */
                linear-gradient(180deg, 
                    rgba(240, 210, 100, 0.92) 0%, 
                    rgba(245, 220, 120, 0.90) 50%, 
                    rgba(250, 230, 140, 0.92) 100%
                );
            box-shadow: 
                /* Strong shadow for depth */
                0 3px 8px rgba(0, 0, 0, 0.35),
                0 1px 4px rgba(0, 0, 0, 0.25),
                /* Glossy highlights */
                inset 0 2px 5px rgba(255, 255, 255, 0.9),
                inset 0 -1px 3px rgba(0, 0, 0, 0.2);
            z-index: 5;
            border-top: 1px solid rgba(255, 255, 255, 0.8);
            border-bottom: 1px solid rgba(200, 180, 100, 0.4);
            /* SERRATED EDGES (bordi seghettati) */
            clip-path: polygon(
                /* Left edge - serrated */
                0% 0%,
                2% 5%,
                0% 10%,
                2% 15%,
                0% 20%,
                2% 25%,
                0% 30%,
                2% 35%,
                0% 40%,
                2% 45%,
                0% 50%,
                2% 55%,
                0% 60%,
                2% 65%,
                0% 70%,
                2% 75%,
                0% 80%,
                2% 85%,
                0% 90%,
                2% 95%,
                0% 100%,
                /* Bottom */
                100% 100%,
                /* Right edge - serrated */
                98% 95%,
                100% 90%,
                98% 85%,
                100% 80%,
                98% 75%,
                100% 70%,
                98% 65%,
                100% 60%,
                98% 55%,
                100% 50%,
                98% 45%,
                100% 40%,
                98% 35%,
                100% 30%,
                98% 25%,
                100% 20%,
                98% 15%,
                100% 10%,
                98% 5%,
                100% 0%
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
        
        .notice-urgent-flag {
            font-size: 0.625rem;
            font-weight: 900;
            color: #dc2626;
            transform: rotate(-3deg);
            animation: pulse 2s infinite;
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
    </style>
    <?php else: ?>
    
    <div class="max-w-[90rem] mx-auto px-4 md:px-6 lg:px-8">
        <div class="text-center mb-12 section-title-fade">
            <h2 class="text-4xl md:text-5xl font-bold mb-3 text-neutral-900 dark:text-white" style="font-family: 'Crimson Pro', serif;">
                <?php echo __('home.gigs_section_title'); ?>

            </h2>
            <p class="text-lg text-neutral-600 dark:text-neutral-100 font-medium">
                <?php echo e(__('home.gigs_section_subtitle')); ?>

            </p>
        </div>
        
        <div class="flex flex-col items-center justify-center py-20 px-4">
            <div class="text-center max-w-md">
                <svg class="w-24 h-24 mx-auto mb-6 text-dark dark:text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <h3 class="text-2xl font-bold text-neutral-900 dark:text-white mb-3" style="font-family: 'Crimson Pro', serif;">
                    <?php echo e(__('home.no_gigs_title')); ?>

                </h3>
                <p class="text-neutral-600 dark:text-neutral-400">
                    <?php echo e(__('home.no_gigs_subtitle')); ?>

                </p>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/livewire/home/gigs-section.blade.php ENDPATH**/ ?>