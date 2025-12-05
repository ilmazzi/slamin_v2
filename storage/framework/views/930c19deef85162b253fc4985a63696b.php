<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                    <?php echo e(__('articles.layout.title')); ?>

                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    <?php echo e(__('articles.layout.description')); ?>

                </p>
            </div>
            <button wire:click="saveAllLayouts" 
                    class="px-6 py-3 bg-accent-600 hover:bg-accent-700 text-white rounded-lg shadow-lg transition-all duration-200">
                <?php echo e(__('articles.layout.save_all')); ?>

            </button>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('success')): ?>
            <div class="mb-6 p-4 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-lg">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(session()->has('error')): ?>
            <div class="mb-6 p-4 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded-lg">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            
            
            <div class="lg:col-span-3 space-y-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                    <?php echo e(__('articles.layout.main_area')); ?>

                </h2>

                
                <div class="w-full">
                    <?php echo $__env->make('livewire.admin.partials.layout-position', [
                        'position' => 'banner',
                        'size' => 'large'
                    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>

                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php echo $__env->make('livewire.admin.partials.layout-position', ['position' => 'column1', 'size' => 'medium'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php echo $__env->make('livewire.admin.partials.layout-position', ['position' => 'column2', 'size' => 'medium'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>

                
                <div class="w-full">
                    <?php echo $__env->make('livewire.admin.partials.layout-position', ['position' => 'horizontal1', 'size' => 'small'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>

                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php echo $__env->make('livewire.admin.partials.layout-position', ['position' => 'column3', 'size' => 'medium'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php echo $__env->make('livewire.admin.partials.layout-position', ['position' => 'column4', 'size' => 'medium'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>

                
                <div class="w-full">
                    <?php echo $__env->make('livewire.admin.partials.layout-position', ['position' => 'horizontal2', 'size' => 'small'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>

                
                <div class="w-full">
                    <?php echo $__env->make('livewire.admin.partials.layout-position', ['position' => 'horizontal3', 'size' => 'small'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>

                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php echo $__env->make('livewire.admin.partials.layout-position', ['position' => 'column5', 'size' => 'medium'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php echo $__env->make('livewire.admin.partials.layout-position', ['position' => 'column6', 'size' => 'medium'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>

            
            <div class="lg:col-span-1 space-y-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                    <?php echo e(__('articles.layout.sidebar_area')); ?>

                </h2>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?>
                    <?php echo $__env->make('livewire.admin.partials.layout-position', [
                        'position' => 'sidebar' . $i,
                        'size' => 'small'
                    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showSearchModal): ?>
        <div class="fixed inset-0 z-[9999] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="background-color: rgba(0,0,0,0.5);">
            <div class="flex items-center justify-center min-h-screen p-4">
                
                
                <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-3xl" style="z-index: 10000;">
                    
                    
                    <div class="bg-white dark:bg-gray-800 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    <?php echo e(__('articles.layout.select_article')); ?>

                                </h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    Posizione: <?php echo e($currentPosition); ?> | Risultati: <?php echo e($searchResults ? $searchResults->count() : 0); ?>

                                </p>
                            </div>
                            <button wire:click="closeSearchModal" 
                                    class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        
                        <div class="mt-4">
                            <input type="text" 
                                   wire:model.live.debounce.300ms="searchTerm"
                                   placeholder="<?php echo e(__('articles.layout.search_articles')); ?>"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-accent-500 focus:border-accent-500">
                        </div>
                    </div>

                    
                    <div class="bg-white dark:bg-gray-800 px-6 py-4 max-h-96 overflow-y-auto">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($searchResults && $searchResults->count() > 0): ?>
                            <div class="space-y-3">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $searchResults; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div wire:click="selectArticle(<?php echo e($article->id); ?>)"
                                         class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors duration-200">
                                        <div class="flex gap-4">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($article->featured_image_url): ?>
                                                <img src="<?php echo e($article->featured_image_url); ?>" 
                                                     alt="<?php echo e($article->title); ?>"
                                                     class="w-20 h-20 object-cover rounded">
                                            <?php else: ?>
                                                <div class="w-20 h-20 bg-gray-200 dark:bg-gray-600 rounded flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-900 dark:text-white">
                                                    <?php echo e($article->title); ?>

                                                </h4>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($article->category): ?>
                                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                                        <?php echo e($article->category->name); ?>

                                                    </span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1 line-clamp-2">
                                                    <?php echo e($article->excerpt); ?>

                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400 font-medium">
                                    <?php echo e(__('articles.index.no_articles')); ?>

                                </p>
                                <p class="text-sm text-gray-400 dark:text-gray-500 mt-2">
                                    Nessun articolo trovato nel database
                                </p>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    
                    <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4">
                        <button wire:click="closeSearchModal"
                                class="w-full px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors duration-200">
                            <?php echo e(__('common.cancel')); ?>

                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/livewire/admin/article-layout-manager.blade.php ENDPATH**/ ?>