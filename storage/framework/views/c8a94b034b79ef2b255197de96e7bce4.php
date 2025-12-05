<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['event']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['event']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

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
?>


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
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->start_date ?? $event->start_datetime): ?>
            <div class="ticket-serial">#<?php echo e(str_pad($event->id, 4, '0', STR_PAD_LEFT)); ?></div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($event->entry_fee ?? 0) > 0): ?>
                <?php echo e(number_format($event->entry_fee, 2, ',', '.')); ?> €
            <?php else: ?>
                <?php echo e(__('events.free')); ?>

            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        
        
        <div class="ticket-details">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->start_date ?? $event->start_datetime): ?>
            <div class="ticket-detail-item">
                <div class="ticket-detail-label">DATA</div>
                <div class="ticket-detail-value">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->start_date): ?>
                        <?php echo e($event->start_date->locale('it')->isoFormat('D MMM YYYY')); ?>

                    <?php elseif($event->start_datetime): ?>
                        <?php echo e($event->start_datetime->locale('it')->isoFormat('D MMM YYYY')); ?>

                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->start_time ?? $event->start_datetime): ?>
            <div class="ticket-detail-item">
                <div class="ticket-detail-label">ORARIO</div>
                <div class="ticket-detail-value">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->start_time): ?>
                        <?php echo e(\Carbon\Carbon::parse($event->start_time)->format('H:i')); ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->end_time): ?>
                        - <?php echo e(\Carbon\Carbon::parse($event->end_time)->format('H:i')); ?>

                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php elseif($event->start_datetime): ?>
                        <?php echo e($event->start_datetime->format('H:i')); ?>

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
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->user ?? $event->organizer): ?>
            <div class="ticket-detail-item">
                <div class="ticket-detail-label">ORGANIZZATO DA</div>
                <?php
                    $organizer = $event->user ?? $event->organizer;
                ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($organizer): ?>
                    <a href="<?php echo e(\App\Helpers\AvatarHelper::getUserProfileUrl($organizer)); ?>" 
                       class="ticket-detail-value hover:underline transition-colors">
                        <?php echo e(Str::limit(\App\Helpers\AvatarHelper::getDisplayName($organizer), 20)); ?>

                    </a>
                <?php else: ?>
                    <div class="ticket-detail-value">N/A</div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->max_participants): ?>
                <div class="tooltip-row">
                    <span class="tooltip-label"><?php echo e(__('events.max_participants')); ?>:</span>
                    <span class="tooltip-value"><?php echo e($event->max_participants); ?></span>
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
        </div>
    </div>
    
    
    <div class="ticket-stub">
        <div class="stub-perforation"></div>
        <div class="stub-content">
            <div class="stub-date">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->start_date ?? $event->start_datetime): ?>
                <?php echo e(($event->start_date ?? $event->start_datetime)->format('d/m')); ?>

                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <div class="stub-serial">#<?php echo e(str_pad($event->id, 4, '0', STR_PAD_LEFT)); ?></div>
        </div>
    </div>
</div>

<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/components/event-ticket.blade.php ENDPATH**/ ?>