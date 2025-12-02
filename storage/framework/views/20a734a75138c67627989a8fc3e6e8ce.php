<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paginator->hasPages()): ?>
    <nav role="navigation" aria-label="<?php echo e(__('pagination.aria_label')); ?>" class="w-full">
        <div class="flex flex-col items-center gap-4">
            <p class="text-sm text-neutral-600 dark:text-neutral-300 font-poem">
                <?php echo trans_choice('pagination.results', $paginator->total(), [
                    'from' => $paginator->firstItem() ?? 0,
                    'to' => $paginator->lastItem() ?? $paginator->count(),
                    'total' => $paginator->total(),
                ]); ?>

            </p>

            <div class="inline-flex items-center gap-1 px-3 py-2 rounded-full border border-neutral-200/70 dark:border-neutral-700/60 bg-white/80 dark:bg-neutral-800/80 shadow-[0_10px_25px_rgba(0,0,0,0.08)] backdrop-blur-md">
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paginator->onFirstPage()): ?>
                    <span aria-disabled="true" aria-label="<?php echo e(__('pagination.previous')); ?>"
                          class="w-9 h-9 flex items-center justify-center rounded-full text-neutral-400 cursor-not-allowed select-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </span>
                <?php else: ?>
                    <a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev"
                       class="w-9 h-9 flex items-center justify-center rounded-full text-neutral-600 dark:text-neutral-200 hover:text-accent-600 hover:bg-accent-100/60 dark:hover:bg-accent-500/20 transition"
                       aria-label="<?php echo e(__('pagination.previous')); ?>">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(is_string($element)): ?>
                        <span class="px-3 py-2 text-sm font-medium text-neutral-400 select-none">
                            <?php echo e($element); ?>

                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(is_array($element)): ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($page == $paginator->currentPage()): ?>
                                <span aria-current="page"
                                      class="min-w-[2.25rem] h-9 px-3 flex items-center justify-center rounded-full bg-accent-500 text-white text-sm font-semibold shadow-lg shadow-accent-500/30">
                                    <?php echo e($page); ?>

                                </span>
                            <?php else: ?>
                                <a href="<?php echo e($url); ?>"
                                   class="min-w-[2.25rem] h-9 px-3 flex items-center justify-center rounded-full text-sm font-medium text-neutral-600 dark:text-neutral-200 hover:bg-accent-100/70 dark:hover:bg-accent-500/20 hover:text-accent-700 transition"
                                   aria-label="<?php echo e(__('pagination.go_to_page', ['page' => $page])); ?>">
                                    <?php echo e($page); ?>

                                </a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paginator->hasMorePages()): ?>
                    <a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next"
                       class="w-9 h-9 flex items-center justify-center rounded-full text-neutral-600 dark:text-neutral-200 hover:text-accent-600 hover:bg-accent-100/60 dark:hover:bg-accent-500/20 transition"
                       aria-label="<?php echo e(__('pagination.next')); ?>">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                <?php else: ?>
                    <span aria-disabled="true" aria-label="<?php echo e(__('pagination.next')); ?>"
                          class="w-9 h-9 flex items-center justify-center rounded-full text-neutral-400 cursor-not-allowed select-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </nav>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/components/pagination/poetic.blade.php ENDPATH**/ ?>