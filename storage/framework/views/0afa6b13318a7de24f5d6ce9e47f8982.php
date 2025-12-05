<?php
    $article = $layouts[$position]['article'] ?? null;
    $sizeClasses = match($size) {
        'large' => 'min-h-64',
        'medium' => 'min-h-48',
        'small' => 'min-h-32',
        default => 'min-h-48',
    };
?>

<div class="bg-white dark:bg-gray-800 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 <?php echo e($sizeClasses); ?> p-4 transition-all duration-200 hover:border-accent-500">
    
    
    <div class="flex items-center justify-between mb-3">
        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">
            <?php echo e(__('articles.layout.' . $position)); ?>

        </span>
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($article): ?>
            <button wire:click="clearPosition('<?php echo e($position); ?>')"
                    class="text-red-500 hover:text-red-700 text-sm transition-colors duration-200">
                <?php echo e(__('articles.layout.clear')); ?>

            </button>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($article): ?>
        <div class="flex gap-4 items-start">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($article->featured_image_url): ?>
                <img src="<?php echo e($article->featured_image_url); ?>" 
                     alt="<?php echo e($article->title); ?>"
                     class="w-24 h-24 object-cover rounded flex-shrink-0">
            <?php else: ?>
                <div class="w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded flex items-center justify-center flex-shrink-0">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            
            <div class="flex-1 min-w-0">
                <h4 class="font-semibold text-gray-900 dark:text-white truncate">
                    <?php echo e($article->title); ?>

                </h4>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($article->category): ?>
                    <span class="inline-block px-2 py-1 text-xs rounded bg-accent-100 dark:bg-accent-900 text-accent-800 dark:text-accent-200 mt-1">
                        <?php echo e($article->category->name); ?>

                    </span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 line-clamp-2">
                    <?php echo e($article->excerpt); ?>

                </p>
            </div>
        </div>
    <?php else: ?>
        <button wire:click="openSearchModal('<?php echo e($position); ?>')"
                class="w-full h-full flex flex-col items-center justify-center text-gray-400 hover:text-accent-600 dark:hover:text-accent-400 transition-colors duration-200">
            <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span class="text-sm font-medium">
                <?php echo e(__('articles.layout.click_to_select')); ?>

            </span>
        </button>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>

<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/livewire/admin/partials/layout-position.blade.php ENDPATH**/ ?>