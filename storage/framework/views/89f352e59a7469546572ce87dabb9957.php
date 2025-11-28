<?php
    $isLarge = $isLarge ?? false;
    $index = $index ?? 0;
?>

<article 
    x-data="{ 
        visible: false,
        isHovered: false,
        tiltX: 0,
        tiltY: 0
    }"
    x-init="setTimeout(() => visible = true, <?php echo e(50 + ($index * 60)); ?>)"
    x-show="visible"
    @mouseenter="isHovered = true"
    @mouseleave="isHovered = false; tiltX = 0; tiltY = 0"
    @mousemove="
        if (isHovered) {
            const rect = $el.getBoundingClientRect();
            const x = $event.clientX - rect.left;
            const y = $event.clientY - rect.top;
            tiltX = ((y / rect.height) - 0.5) * -10;
            tiltY = ((x / rect.width) - 0.5) * 10;
        }
    "
    x-transition:enter="transition ease-out duration-800"
    x-transition:enter-start="opacity-0 scale-90 <?php echo e($isLarge ? 'rotate-2' : '-rotate-1'); ?>"
    x-transition:enter-end="opacity-100 scale-100 rotate-0"
    class="group relative overflow-hidden rounded-2xl cursor-pointer transition-all duration-300 h-full w-full"
    :class="isHovered ? 'z-20 shadow-2xl' : 'z-10 shadow-lg'"
    :style="`transform: ${isHovered ? `perspective(1000px) rotateX(${tiltX}deg) rotateY(${tiltY}deg) scale(1.05)` : 'none'}`">
    
    <!-- Event Image Background -->
    <div class="absolute inset-0">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->image_url): ?>
        <img src="<?php echo e($event->image_url); ?>" 
             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" 
             alt="<?php echo e($event->title); ?>">
        <?php else: ?>
        <div class="w-full h-full bg-gradient-to-br from-red-600 via-red-700 to-amber-700"></div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        
        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent opacity-80 group-hover:opacity-90 transition-opacity duration-500"></div>
    </div>
    
    <!-- Sparkle Effect on Hover -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-white rounded-full opacity-0 group-hover:opacity-100 group-hover:animate-ping"></div>
        <div class="absolute top-1/3 right-1/3 w-1.5 h-1.5 bg-red-300 rounded-full opacity-0 group-hover:opacity-100 group-hover:animate-ping" style="animation-delay: 0.1s"></div>
        <div class="absolute bottom-1/3 left-1/3 w-2 h-2 bg-amber-300 rounded-full opacity-0 group-hover:opacity-100 group-hover:animate-ping" style="animation-delay: 0.2s"></div>
        <div class="absolute top-1/2 right-1/4 w-1 h-1 bg-white rounded-full opacity-0 group-hover:opacity-100 group-hover:animate-ping" style="animation-delay: 0.15s"></div>
    </div>
    
    <!-- Floating Category Badge -->
    <div class="absolute top-4 right-4 z-10 flex flex-col gap-2 items-end">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->status === \App\Models\Event::STATUS_COMPLETED || ($event->end_datetime && $event->end_datetime->isPast())): ?>
        <div class="transform transition-all duration-300 group-hover:scale-110 group-hover:-rotate-3">
            <span class="px-3 py-1 bg-gradient-to-r from-amber-500/90 to-amber-600/90 backdrop-blur-md text-white text-xs font-bold uppercase rounded-full border border-amber-400/50 shadow-lg flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
                <?php echo e(__('events.completed')); ?>

            </span>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <div class="transform transition-all duration-300 group-hover:scale-110 group-hover:-rotate-3">
            <span class="px-3 py-1 bg-white/20 backdrop-blur-md text-white text-xs font-bold uppercase rounded-full border border-white/30 shadow-lg">
                <?php echo e(str_replace('_', ' ', $event->category ?? 'Event')); ?>

            </span>
        </div>
    </div>
    
    <!-- Content -->
    <div class="relative h-full flex flex-col justify-end <?php echo e($isLarge ? 'p-6' : 'p-4'); ?>">
        <!-- Date Badge -->
        <div class="mb-2">
            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-700/90 backdrop-blur-sm rounded-full">
                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="text-white text-xs font-semibold">
                    <?php echo e($event->start_datetime ? $event->start_datetime->format('d M') : 'TBD'); ?>

                </span>
            </div>
        </div>
        
        <!-- Title -->
        <h3 class="text-white font-bold mb-1.5 <?php echo e($isLarge ? 'text-2xl' : 'text-lg'); ?> line-clamp-2 group-hover:text-red-300 transition-colors">
            <?php echo e($event->title); ?>

        </h3>
        
        <!-- Location -->
        <div class="flex items-center gap-1.5 text-white/80 text-xs mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span><?php echo e($event->city); ?></span>
        </div>
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isLarge): ?>
        <!-- Description (only for large cards) -->
        <p class="text-white/70 text-xs mb-3 line-clamp-2">
            <?php echo e(Str::limit($event->description, 100)); ?>

        </p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        
        <!-- Social Actions -->
        <div class="flex items-center gap-2" @click.stop>
            <?php if (isset($component)) { $__componentOriginal332a28e2e55aa3574ada95b4497eb0b2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal332a28e2e55aa3574ada95b4497eb0b2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.like-button','data' => ['itemId' => $event->id,'itemType' => 'event','isLiked' => $event->is_liked ?? false,'likesCount' => $event->like_count ?? 0,'size' => 'sm','class' => 'text-white']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('like-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($event->id),'itemType' => 'event','isLiked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($event->is_liked ?? false),'likesCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($event->like_count ?? 0),'size' => 'sm','class' => 'text-white']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.comment-button','data' => ['itemId' => $event->id,'itemType' => 'event','commentsCount' => $event->comment_count ?? 0,'size' => 'sm','class' => 'text-white']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('comment-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($event->id),'itemType' => 'event','commentsCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($event->comment_count ?? 0),'size' => 'sm','class' => 'text-white']); ?>
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
        </div>
        
        <!-- Hover Reveal: View Button -->
        <div class="mt-2 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
            <a href="<?php echo e(route('events.show', $event)); ?>" 
               class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white text-red-700 rounded-full font-semibold hover:bg-red-50 transition-colors text-xs">
                <?php echo e(__('events.view_details')); ?>

                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
    
    <!-- Animated Border on Hover -->
    <div class="absolute inset-0 border-3 border-red-400/60 opacity-0 group-hover:opacity-100 rounded-2xl transition-opacity duration-300 pointer-events-none"></div>
    
    <!-- Shine Effect on Hover -->
    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none overflow-hidden">
        <div class="absolute -inset-full bg-gradient-to-r from-transparent via-white/20 to-transparent skew-x-12 group-hover:animate-shine"></div>
    </div>
    
    <!-- Glow Effect Under Card -->
    <div class="absolute -inset-4 bg-gradient-to-r from-red-600/0 via-red-600/20 to-amber-600/0 blur-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 -z-10"></div>
    
    <!-- Click Overlay -->
    <a href="<?php echo e(route('events.show', $event)); ?>" class="absolute inset-0 z-5"></a>
</article>

<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/livewire/events/partials/event-card.blade.php ENDPATH**/ ?>