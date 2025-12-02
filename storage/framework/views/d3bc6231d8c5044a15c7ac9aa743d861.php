<div>
    <div class="max-w-[90rem] mx-auto px-4 md:px-6 lg:px-8">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($completedEvents && $completedEvents->count() > 0): ?>
        
        
        <div class="text-center mb-12 section-title-fade">
            <h2 class="text-4xl md:text-5xl font-bold mb-3 text-white" style="font-family: 'Crimson Pro', serif;">
                <?php echo __('home.completed_events_title'); ?>

            </h2>
            <p class="text-lg text-neutral-200 font-medium">
                <?php echo e(__('home.completed_events_subtitle')); ?>

            </p>
        </div>

        
        <div class="relative" x-data="{ 
            scroll(direction) {
                const container = this.$refs.scrollContainer;
                const cards = container.children;
                if (cards.length === 0) return;
                
                const containerRect = container.getBoundingClientRect();
                const scrollLeft = container.scrollLeft;
                
                let targetCard = null;
                for (let i = 0; i < cards.length; i++) {
                    const card = cards[i];
                    const cardLeft = card.offsetLeft;
                    
                    if (direction > 0) {
                        if (cardLeft > scrollLeft + containerRect.width - 100) {
                            targetCard = card;
                            break;
                        }
                    } else {
                        if (cardLeft < scrollLeft - 50) {
                            targetCard = card;
                        }
                    }
                }
                
                if (targetCard) {
                    targetCard.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'start' });
                }
            }
        }">
            <!-- Left Arrow (Desktop Only) -->
            <button @click="scroll(-1)" 
                    class="hidden md:flex absolute -left-16 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white/95 dark:bg-neutral-800/95 backdrop-blur-sm rounded-full shadow-xl hover:scale-110 transition-all duration-300 items-center justify-center text-neutral-900 dark:text-white group">
                <svg class="w-6 h-6 transform group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            
            <!-- Right Arrow (Desktop Only) -->
            <button @click="scroll(1)" 
                    class="hidden md:flex absolute -right-16 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white/95 dark:bg-neutral-800/95 backdrop-blur-sm rounded-full shadow-xl hover:scale-110 transition-all duration-300 items-center justify-center text-neutral-900 dark:text-white group">
                <svg class="w-6 h-6 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
            
            <!-- Mobile Scroll Indicator -->
            <div class="md:hidden relative mb-4">
                <div class="flex items-center justify-center gap-2 text-neutral-300 text-sm">
                    <svg class="w-5 h-5 animate-bounce-horizontal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                    </svg>
                    <span>Scorri per vedere altro</span>
                </div>
            </div>
            
        <div x-ref="scrollContainer" class="flex gap-6 overflow-x-auto pb-16 pt-12 px-8 md:px-12 scrollbar-hide"
             style="-webkit-overflow-scrolling: touch;">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $completedEvents->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                // Random ticket tilt
                $tilt = rand(-3, 3);
                // Random ticket color (vintage paper tones)
                $ticketColors = [
                    ['#fef7e6', '#fdf3d7', '#fcf0cc'], // Cream
                    ['#fff5e1', '#fff0d4', '#ffecc7'], // Peach cream
                    ['#f5f5dc', '#f0f0d0', '#ebebc4'], // Beige
                    ['#fffaf0', '#fff5e6', '#fff0dc'], // Floral white
                ];
                $selectedColors = $ticketColors[array_rand($ticketColors)];
                // Random stamp position
                $stampRotation = rand(-8, 8);
                $stampOffsetX = rand(-15, 15);
                $stampOffsetY = rand(-10, 10);
                
                // Random wear/damage effects
                $wearOpacity = rand(4, 8) / 10; // 0.4 to 0.8
                $spot1X = rand(5, 95);
                $spot1Y = rand(5, 95);
                $spot2X = rand(5, 95);
                $spot2Y = rand(5, 95);
                $spot3X = rand(5, 95);
                $spot3Y = rand(5, 95);
                $spot4X = rand(5, 95);
                $spot4Y = rand(5, 95);
                
                // Check if Poetry Slam with rankings
                $isPoetrySlam = $event->category === \App\Models\Event::CATEGORY_POETRY_SLAM;
                $hasRankings = $isPoetrySlam && $event->rankings && $event->rankings->where('position', '<=', 3)->count() > 0;
                $top3 = $hasRankings ? $event->rankings->where('position', '<=', 3)->sortBy('position') : collect();
            ?>
            <div class="w-80 md:w-96 flex-shrink-0 fade-scale-item"
                 x-data
                 x-intersect.once="$el.classList.add('animate-fade-in')"
                 style="animation-delay: <?php echo e($i * 0.1); ?>s">
                
                
                <div class="cinema-ticket group ticket-worn"
                     style="transform: rotate(<?php echo e($tilt); ?>deg); 
                            background: linear-gradient(135deg, <?php echo e($selectedColors[0]); ?> 0%, <?php echo e($selectedColors[1]); ?> 50%, <?php echo e($selectedColors[2]); ?> 100%);
                            --wear-opacity: <?php echo e($wearOpacity); ?>;
                            --spot1-x: <?php echo e($spot1X); ?>%;
                            --spot1-y: <?php echo e($spot1Y); ?>%;
                            --spot2-x: <?php echo e($spot2X); ?>%;
                            --spot2-y: <?php echo e($spot2Y); ?>%;
                            --spot3-x: <?php echo e($spot3X); ?>%;
                            --spot3-y: <?php echo e($spot3Y); ?>%;
                            --spot4-x: <?php echo e($spot4X); ?>%;
                            --spot4-y: <?php echo e($spot4Y); ?>%;">
                    
                    
                    <div class="ticket-perforation"></div>
                    
                    
                    <div class="ticket-watermark">
                        <img src="<?php echo e(asset('assets/images/filigrana.png')); ?>" 
                             alt="Slamin" 
                             class="w-32 h-auto md:w-40">
                    </div>
                    
                    
                    <div class="ticket-content">
                        
                        
                        <a href="<?php echo e(route('events.show', $event)); ?>" class="ticket-clickable-area">
                        
                        
                        <div class="ticket-header">
                            <div class="ticket-admit"><?php echo e(strtoupper($event->category ?? 'Evento')); ?></div>
                            <div class="ticket-serial">#<?php echo e(str_pad($event->id, 4, '0', STR_PAD_LEFT)); ?></div>
                        </div>
                        
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->image_url): ?>
                        <div class="ticket-image">
                            <img src="<?php echo e($event->image_url); ?>" 
                                 alt="<?php echo e($event->title); ?>"
                                 class="w-full h-full object-cover">
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        
                        
                        <h3 class="ticket-title"><?php echo e($event->title); ?></h3>
                        
                        
                        <div class="ticket-price"
                             style="transform: rotate(<?php echo e($stampRotation); ?>deg) translateX(<?php echo e($stampOffsetX); ?>px) translateY(<?php echo e($stampOffsetY); ?>px);">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->entry_fee && $event->entry_fee > 0): ?>
                                <?php echo e(number_format($event->entry_fee, 2, ',', '.')); ?> €
                            <?php else: ?>
                                <?php echo e(__('events.free')); ?>

                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasRankings): ?>
                        <div class="ticket-rankings">
                            <div class="ticket-rankings-title">🏆 <?php echo e(__('home.podium')); ?></div>
                            <div class="ticket-rankings-list">
                                <?php
                                    $first = $top3->where('position', 1)->first();
                                    $second = $top3->where('position', 2)->first();
                                    $third = $top3->where('position', 3)->first();
                                ?>
                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($first): ?>
                                <div class="ticket-ranking-item ticket-ranking-first">
                                    <span class="ticket-ranking-medal">🥇</span>
                                    <span class="ticket-ranking-name"><?php echo e(Str::limit($first->participant->display_name ?? '-', 20)); ?></span>
                                    <span class="ticket-ranking-score"><?php echo e(number_format($first->total_score, 1)); ?></span>
                                </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($second): ?>
                                <div class="ticket-ranking-item ticket-ranking-second">
                                    <span class="ticket-ranking-medal">🥈</span>
                                    <span class="ticket-ranking-name"><?php echo e(Str::limit($second->participant->display_name ?? '-', 20)); ?></span>
                                    <span class="ticket-ranking-score"><?php echo e(number_format($second->total_score, 1)); ?></span>
                                </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($third): ?>
                                <div class="ticket-ranking-item ticket-ranking-third">
                                    <span class="ticket-ranking-medal">🥉</span>
                                    <span class="ticket-ranking-name"><?php echo e(Str::limit($third->participant->display_name ?? '-', 20)); ?></span>
                                    <span class="ticket-ranking-score"><?php echo e(number_format($third->total_score, 1)); ?></span>
                                </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        
                        
                        <div class="ticket-details">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->end_datetime): ?>
                            <div class="ticket-detail-item">
                                <div class="ticket-detail-label">DATA</div>
                                <div class="ticket-detail-value"><?php echo e($event->end_datetime->locale('it')->isoFormat('D MMM YYYY')); ?></div>
                            </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->city): ?>
                            <div class="ticket-detail-item">
                                <div class="ticket-detail-label">LUOGO</div>
                                <div class="ticket-detail-value ticket-location">
                                    <svg class="location-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    <span><?php echo e($event->city); ?></span>
                                </div>
                            </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->organizer): ?>
                            <div class="ticket-detail-item">
                                <div class="ticket-detail-label">ORGANIZZATO DA</div>
                                <a href="<?php echo e(route('user.show', $event->organizer)); ?>" 
                                   class="ticket-detail-value hover:underline transition-colors">
                                    <?php echo e(Str::limit($event->organizer->name ?? __('events.organizer'), 20)); ?>

                                </a>
                            </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        
                        
                        <div class="ticket-barcode-wrapper" x-data="{ showDetails: false }">
                            <div class="ticket-barcode" 
                                 @mouseenter="showDetails = true" 
                                 @mouseleave="showDetails = false">
                                <div class="barcode-lines">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($j = 0; $j < 40; $j++): ?>
                                    <div class="barcode-line" style="width: <?php echo e(rand(1, 3)); ?>px; height: <?php echo e(rand(35, 45)); ?>px;"></div>
                                    <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <div class="barcode-number"><?php echo e(str_pad($event->id, 12, '0', STR_PAD_LEFT)); ?></div>
                            </div>
                            
                            
                            <div class="barcode-tooltip" 
                                 x-show="showDetails"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 style="display: none;">
                                <div class="tooltip-title"><?php echo e(__('events.event_details')); ?></div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->description): ?>
                                <div class="tooltip-description"><?php echo e(Str::limit(strip_tags($event->description), 120)); ?></div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->venue_name): ?>
                                <div class="tooltip-row">
                                    <span class="tooltip-label"><?php echo e(__('events.venue')); ?>:</span>
                                    <span class="tooltip-value"><?php echo e($event->venue_name); ?></span>
                                </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasRankings): ?>
                                <div class="tooltip-row">
                                    <span class="tooltip-label"><?php echo e(__('home.view_full_rankings')); ?>:</span>
                                    <span class="tooltip-value"><a href="<?php echo e(route('events.show', $event)); ?>#rankings" class="underline"><?php echo e(__('events.view')); ?></a></span>
                                </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                        </a>
                        
                        
                        <div class="ticket-social">
                            <?php if (isset($component)) { $__componentOriginal332a28e2e55aa3574ada95b4497eb0b2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal332a28e2e55aa3574ada95b4497eb0b2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.like-button','data' => ['itemId' => $event->id,'itemType' => 'event','isLiked' => $event->is_liked ?? false,'likesCount' => $event->like_count ?? 0,'size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('like-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($event->id),'itemType' => 'event','isLiked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($event->is_liked ?? false),'likesCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($event->like_count ?? 0),'size' => 'sm']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal332a28e2e55aa3574ada95b4497eb0b2)): ?>
<?php $attributes = $__attributesOriginal332a28e2e55aa3574ada95b4497eb0b2; ?>
<?php unset($__attributesOriginal332a28e2e55aa3574ada95b4497eb0b2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal332a28e2e55aa3574ada95b4497eb0b2)): ?>
<?php $component = $__componentOriginal332a28e2e55aa3574ada95b4497eb0b2; ?>
<?php unset($__componentOriginal332a28e2e55aa3574ada95b4497eb0b2); ?>
<?php endif; ?>
                            
                            <?php if (isset($component)) { $__componentOriginale34ce5ad0385b05e8d24b4bea6ec4cfd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale34ce5ad0385b05e8d24b4bea6ec4cfd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.comment-button','data' => ['itemId' => $event->id,'itemType' => 'event','commentsCount' => $event->comment_count ?? 0,'size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('comment-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($event->id),'itemType' => 'event','commentsCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($event->comment_count ?? 0),'size' => 'sm']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale34ce5ad0385b05e8d24b4bea6ec4cfd)): ?>
<?php $attributes = $__attributesOriginale34ce5ad0385b05e8d24b4bea6ec4cfd; ?>
<?php unset($__attributesOriginale34ce5ad0385b05e8d24b4bea6ec4cfd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale34ce5ad0385b05e8d24b4bea6ec4cfd)): ?>
<?php $component = $__componentOriginale34ce5ad0385b05e8d24b4bea6ec4cfd; ?>
<?php unset($__componentOriginale34ce5ad0385b05e8d24b4bea6ec4cfd); ?>
<?php endif; ?>
                            
                            <?php if (isset($component)) { $__componentOriginalb32cd1c2ffd206a678a9d8db2f247966 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb32cd1c2ffd206a678a9d8db2f247966 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.share-button','data' => ['itemId' => $event->id,'itemType' => 'event','size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('share-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($event->id),'itemType' => 'event','size' => 'sm']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb32cd1c2ffd206a678a9d8db2f247966)): ?>
<?php $attributes = $__attributesOriginalb32cd1c2ffd206a678a9d8db2f247966; ?>
<?php unset($__attributesOriginalb32cd1c2ffd206a678a9d8db2f247966); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb32cd1c2ffd206a678a9d8db2f247966)): ?>
<?php $component = $__componentOriginalb32cd1c2ffd206a678a9d8db2f247966; ?>
<?php unset($__componentOriginalb32cd1c2ffd206a678a9d8db2f247966); ?>
<?php endif; ?>
                            
                            <?php if (isset($component)) { $__componentOriginalcab7032bfdfb17b0d85d7225950dd852 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcab7032bfdfb17b0d85d7225950dd852 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.report-button','data' => ['itemId' => $event->id,'itemType' => 'event','size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('report-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($event->id),'itemType' => 'event','size' => 'sm']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcab7032bfdfb17b0d85d7225950dd852)): ?>
<?php $attributes = $__attributesOriginalcab7032bfdfb17b0d85d7225950dd852; ?>
<?php unset($__attributesOriginalcab7032bfdfb17b0d85d7225950dd852); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcab7032bfdfb17b0d85d7225950dd852)): ?>
<?php $component = $__componentOriginalcab7032bfdfb17b0d85d7225950dd852; ?>
<?php unset($__componentOriginalcab7032bfdfb17b0d85d7225950dd852); ?>
<?php endif; ?>
                        </div>
                    </div>
                    
                    
                    <div class="ticket-stub">
                        <div class="stub-perforation"></div>
                        <div class="stub-content">
                            <div class="stub-date">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->end_datetime): ?>
                                <?php echo e($event->end_datetime->format('d/m')); ?>

                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <div class="stub-serial">#<?php echo e(str_pad($event->id, 4, '0', STR_PAD_LEFT)); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <!-- CTA -->
        <div class="text-center mt-12">
            <a href="<?php echo e(route('events.index', ['filter' => 'past'])); ?>" 
               class="inline-block text-2xl md:text-3xl font-bold text-white hover:text-primary-400 transition-colors duration-300"
               style="font-family: 'Crimson Pro', serif;">
                → <?php echo e(__('home.all_completed_events')); ?>

            </a>
        </div>
    </div>
    <?php else: ?>
        
        <div class="text-center py-16 md:py-24">
            <div class="max-w-2xl mx-auto">
                <div class="mb-8">
                    <svg class="w-24 h-24 mx-auto text-neutral-400 dark:text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold mb-4 text-white" style="font-family: 'Crimson Pro', serif;">
                    <?php echo __('home.completed_events_title'); ?>

                </h2>
                <p class="text-lg text-neutral-300 dark:text-neutral-400 mb-6">
                    <?php echo e(__('home.no_completed_events')); ?>

                </p>
                <a href="<?php echo e(route('events.index')); ?>" 
                   class="inline-block px-6 py-3 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-xl transition-colors backdrop-blur-sm border border-white/20">
                    <?php echo e(__('home.view_all_events')); ?>

                </a>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
    
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
</div>

<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/livewire/home/completed-poetry-slams.blade.php ENDPATH**/ ?>