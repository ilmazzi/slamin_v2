<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'photo',
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
    'photo',
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
$rotation = rand(-3, 3);
$tapeWidth = rand(60, 90);
$tapeRotation = rand(-8, 8);
$sizeClasses = [
    'small' => 'w-full',
    'normal' => 'w-full',
    'large' => 'w-full'
];
?>

<div class="group cursor-pointer <?php echo e($sizeClasses[$size]); ?>"
     onclick="Livewire.dispatch('openPhotoModal', { photoId: <?php echo e($photo->id); ?> })"
     x-data="{ visible: false }" 
     x-intersect.once="visible = true">
    <div x-show="visible"
         x-transition:enter="transition ease-out duration-700"
         x-transition:enter-start="opacity-0 translate-y-8"
         x-transition:enter-end="opacity-100 translate-y-0"
         style="transition-delay: <?php echo e($index * 100); ?>ms">
        
        <div class="photo-polaroid-wrapper">
            <!-- Washi Tape bianco trasparente -->
            <div class="photo-tape-white" 
                 style="width: <?php echo e($tapeWidth); ?>px; 
                        transform: translateX(-50%) rotate(<?php echo e($tapeRotation); ?>deg);"></div>
            
            <div class="photo-polaroid-card" style="transform: rotate(<?php echo e($rotation); ?>deg);">
                <div class="photo-polaroid-photo">
                    <img src="<?php echo e($photo->image_url); ?>" 
                         alt="<?php echo e($photo->title ?? __('media.untitled')); ?>"
                         class="photo-polaroid-img">
                </div>
                
                <div class="photo-polaroid-caption">
                    <div class="text-base font-bold text-neutral-900 line-clamp-2 mb-1" style="font-family: 'Crimson Pro', serif;">
                        <?php echo e($photo->title ?? __('media.untitled')); ?>

                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($photo->user): ?>
                        <div class="text-xs text-neutral-600 mb-1"><?php echo e($photo->user->name); ?></div>
                        <div class="text-xs text-neutral-500 mb-2"><?php echo e(number_format($photo->view_count ?? 0)); ?> views</div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    
                    
                    <div class="flex items-center justify-center gap-2.5 mt-1" @click.stop>
                        <?php if (isset($component)) { $__componentOriginal332a28e2e55aa3574ada95b4497eb0b2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal332a28e2e55aa3574ada95b4497eb0b2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.like-button','data' => ['itemId' => $photo->id,'itemType' => 'photo','isLiked' => false,'likesCount' => $photo->like_count ?? 0,'size' => 'sm','class' => '[&_span]:!text-neutral-700 [&_svg]:!text-neutral-700 [&_svg]:w-4 [&_svg]:h-4 md:[&_svg]:w-5 md:[&_svg]:h-5 [&_span]:text-xs']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('like-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($photo->id),'itemType' => 'photo','isLiked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'likesCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($photo->like_count ?? 0),'size' => 'sm','class' => '[&_span]:!text-neutral-700 [&_svg]:!text-neutral-700 [&_svg]:w-4 [&_svg]:h-4 md:[&_svg]:w-5 md:[&_svg]:h-5 [&_span]:text-xs']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.comment-button','data' => ['itemId' => $photo->id,'itemType' => 'photo','commentsCount' => $photo->comment_count ?? 0,'size' => 'sm','class' => '[&_button]:!text-neutral-700 [&_span]:!text-neutral-700 [&_svg]:!stroke-neutral-700 [&_svg]:w-4 [&_svg]:h-4 md:[&_svg]:w-5 md:[&_svg]:h-5 [&_span]:text-xs']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('comment-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($photo->id),'itemType' => 'photo','commentsCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($photo->comment_count ?? 0),'size' => 'sm','class' => '[&_button]:!text-neutral-700 [&_span]:!text-neutral-700 [&_svg]:!stroke-neutral-700 [&_svg]:w-4 [&_svg]:h-4 md:[&_svg]:w-5 md:[&_svg]:h-5 [&_span]:text-xs']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.share-button','data' => ['itemId' => $photo->id,'itemType' => 'photo','size' => 'sm','class' => '[&_button]:!text-neutral-700 [&_svg]:!stroke-neutral-700 [&_svg]:w-4 [&_svg]:h-4 md:[&_svg]:w-5 md:[&_svg]:h-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('share-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($photo->id),'itemType' => 'photo','size' => 'sm','class' => '[&_button]:!text-neutral-700 [&_svg]:!stroke-neutral-700 [&_svg]:w-4 [&_svg]:h-4 md:[&_svg]:w-5 md:[&_svg]:h-5']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.report-button','data' => ['itemId' => $photo->id,'itemType' => 'photo','size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('report-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($photo->id),'itemType' => 'photo','size' => 'sm']); ?>
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
            </div>
        </div>
    </div>
</div>

<style>
    /* Photo Polaroid Light - Minimal Style */
    .photo-polaroid-wrapper {
        position: relative;
        padding-top: 20px;
    }
    
    .photo-tape-white {
        position: absolute;
        top: -8px;
        left: 50%;
        height: 30px;
        background: rgba(255, 255, 255, 0.35);
        border: 1px solid rgba(255, 255, 255, 0.6);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        z-index: 10;
        transition: all 0.3s ease;
        clip-path: polygon(
            0% 0%, 2% 5%, 0% 10%, 2% 15%, 0% 20%, 2% 25%, 0% 30%, 2% 35%, 
            0% 40%, 2% 45%, 0% 50%, 2% 55%, 0% 60%, 2% 65%, 0% 70%, 2% 75%, 
            0% 80%, 2% 85%, 0% 90%, 2% 95%, 0% 100%,
            100% 100%,
            98% 95%, 100% 90%, 98% 85%, 100% 80%, 98% 75%, 100% 70%, 98% 65%, 
            100% 60%, 98% 55%, 100% 50%, 98% 45%, 100% 40%, 98% 35%, 100% 30%, 
            98% 25%, 100% 20%, 98% 15%, 100% 10%, 98% 5%, 100% 0%
        );
        backdrop-filter: blur(1px);
    }
    
    .photo-polaroid-card {
        display: block;
        position: relative;
        background: #ffffff;
        padding: 16px 16px 90px 16px;
        box-shadow: 
            0 2px 4px rgba(0, 0, 0, 0.1),
            0 4px 8px rgba(0, 0, 0, 0.08),
            0 8px 16px rgba(0, 0, 0, 0.06),
            0 16px 32px rgba(0, 0, 0, 0.04);
        transition: all 0.3s ease;
        border-radius: 2px;
    }
    
    .dark .photo-polaroid-card {
        background: #fafafa;
    }
    
    .photo-polaroid-card:hover {
        transform: translateY(-8px) scale(1.02) !important;
        box-shadow: 
            0 4px 8px rgba(0, 0, 0, 0.12),
            0 8px 16px rgba(0, 0, 0, 0.1),
            0 16px 32px rgba(0, 0, 0, 0.08),
            0 32px 64px rgba(0, 0, 0, 0.06);
    }
    
    .photo-polaroid-photo {
        position: relative;
        aspect-ratio: 1;
        overflow: hidden;
        background: #f5f5f5;
        border-radius: 1px;
        box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.1);
    }
    
    .photo-polaroid-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: grayscale(100%);
        transition: all 0.5s ease;
    }
    
    .photo-polaroid-card:hover .photo-polaroid-img {
        filter: grayscale(0%);
        transform: scale(1.05);
    }
    
    .photo-polaroid-caption {
        text-align: center;
        padding-top: 1rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.25rem;
    }
</style>

<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/components/photo-frame-light.blade.php ENDPATH**/ ?>