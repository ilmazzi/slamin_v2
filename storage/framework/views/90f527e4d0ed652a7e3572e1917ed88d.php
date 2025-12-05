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
     style="animation-delay: <?php echo e($index * 0.1); ?>s">
    
    
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
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->start_datetime): ?>
                <div class="ticket-detail-item">
                    <div class="ticket-detail-label">DATA</div>
                    <div class="ticket-detail-value"><?php echo e($event->start_datetime->locale('it')->isoFormat('D MMM YYYY')); ?></div>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->start_datetime && $event->start_datetime->format('H:i') !== '00:00'): ?>
                <div class="ticket-detail-item">
                    <div class="ticket-detail-label">ORARIO</div>
                    <div class="ticket-detail-value">
                        <?php echo e($event->start_datetime->format('H:i')); ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->end_datetime): ?>
                        - <?php echo e($event->end_datetime->format('H:i')); ?>

                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
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
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->start_datetime): ?>
                    <?php echo e($event->start_datetime->format('d/m')); ?>

                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div class="stub-serial">#<?php echo e(str_pad($event->id, 4, '0', STR_PAD_LEFT)); ?></div>
            </div>
        </div>
    </div>
</div>

<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/livewire/events/partials/timeline-ticket.blade.php ENDPATH**/ ?>