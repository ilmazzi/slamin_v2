<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'video',
    'index' => 0,
    'size' => 'normal' // 'normal', 'small', 'large'
]));

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

foreach (array_filter(([
    'video',
    'index' => 0,
    'size' => 'normal' // 'normal', 'small', 'large'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
$tilt = rand(-2, 2);
$sizeClasses = [
    'small' => 'w-full',
    'normal' => 'w-full',
    'large' => 'w-full'
];
?>

<div class="group cursor-pointer <?php echo e($sizeClasses[$size]); ?>"
     onclick="Livewire.dispatch('openVideoModal', { videoId: <?php echo e($video->id); ?> })"
     x-data="{ visible: false }" 
     x-intersect.once="visible = true">
    <div x-show="visible"
         x-transition:enter="transition ease-out duration-700"
         x-transition:enter-start="opacity-0 translate-y-8"
         x-transition:enter-end="opacity-100 translate-y-0"
         style="transition-delay: <?php echo e($index * 100); ?>ms">
        
        <div class="video-frame-light" style="transform: rotate(<?php echo e($tilt); ?>deg);">
            <!-- SOLO frame number, NO perforazioni -->
            <div class="video-frame-num"><?php echo e(str_pad($index + 1, 2, '0', STR_PAD_LEFT)); ?></div>
            
            <!-- Video Content -->
            <div class="relative aspect-[4/3] overflow-hidden bg-black">
                <img src="<?php echo e($video->thumbnail_url); ?>" 
                     alt="<?php echo e($video->title); ?>"
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-black/40 group-hover:bg-black/20 transition-colors"></div>

                
                <div class="absolute inset-0 flex items-center justify-center">
                    <svg class="w-12 h-12 text-white group-hover:scale-125 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z"/>
                    </svg>
                </div>

                
                <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/95 to-transparent">
                    <h4 class="text-white font-bold text-sm md:text-base line-clamp-2 mb-2" style="font-family: 'Crimson Pro', serif;">
                        <?php echo e($video->title); ?>

                    </h4>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($video->user): ?>
                        <div class="flex items-center gap-2 text-xs mb-2">
                            <span class="text-white/80"><?php echo e($video->user->name); ?></span>
                            <span class="text-white/60">• <?php echo e(number_format($video->view_count ?? 0)); ?></span>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    
                    
                    <div class="flex items-center gap-2.5">
                        <?php if (isset($component)) { $__componentOriginal332a28e2e55aa3574ada95b4497eb0b2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal332a28e2e55aa3574ada95b4497eb0b2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.like-button','data' => ['itemId' => $video->id,'itemType' => 'video','isLiked' => false,'likesCount' => $video->like_count ?? 0,'size' => 'sm','class' => '[&_span]:!text-white/90 [&_svg]:!text-white/90 [&_svg]:w-3.5 [&_svg]:h-3.5 [&_span]:text-xs']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('like-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($video->id),'itemType' => 'video','isLiked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'likesCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($video->like_count ?? 0),'size' => 'sm','class' => '[&_span]:!text-white/90 [&_svg]:!text-white/90 [&_svg]:w-3.5 [&_svg]:h-3.5 [&_span]:text-xs']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.comment-button','data' => ['itemId' => $video->id,'itemType' => 'video','commentsCount' => $video->comment_count ?? 0,'size' => 'sm','class' => '[&_button]:!text-white/90 [&_span]:!text-white/90 [&_svg]:!stroke-white [&_svg]:w-3.5 [&_svg]:h-3.5 [&_span]:text-xs']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('comment-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($video->id),'itemType' => 'video','commentsCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($video->comment_count ?? 0),'size' => 'sm','class' => '[&_button]:!text-white/90 [&_span]:!text-white/90 [&_svg]:!stroke-white [&_svg]:w-3.5 [&_svg]:h-3.5 [&_span]:text-xs']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.share-button','data' => ['itemId' => $video->id,'itemType' => 'video','size' => 'sm','class' => '[&_button]:!text-white/90 [&_svg]:!stroke-white [&_svg]:w-3.5 [&_svg]:h-3.5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('share-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($video->id),'itemType' => 'video','size' => 'sm','class' => '[&_button]:!text-white/90 [&_svg]:!stroke-white [&_svg]:w-3.5 [&_svg]:h-3.5']); ?>
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
            </div>
        </div>
    </div>
</div>

<style>
    /* Video Frame Light - ESSENZIALE */
    .video-frame-light {
        position: relative;
        background: transparent;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 
            0 4px 16px rgba(0, 0, 0, 0.15),
            0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .video-frame-light:hover {
        transform: translateY(-6px) scale(1.03) !important;
        box-shadow: 
            0 8px 24px rgba(0, 0, 0, 0.2),
            0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    /* Frame Number - Badge minimal */
    .video-frame-num {
        position: absolute;
        top: 1rem;
        left: 1rem;
        color: white;
        font-size: 0.7rem;
        font-weight: 700;
        font-family: 'Courier New', monospace;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.8);
        z-index: 3;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        padding: 0.35rem 0.65rem;
        border-radius: 4px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
</style>

<?php /**PATH /Users/mazzi/slamin_v2/resources/views/components/video-frame-light.blade.php ENDPATH**/ ?>