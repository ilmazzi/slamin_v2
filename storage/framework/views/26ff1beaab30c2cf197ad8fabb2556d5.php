<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->hasRole(['admin', 'editor'])): ?>
        <form action="<?php echo e(route('admin.carousels.add', ['type' => $contentType, 'id' => $contentId])); ?>" 
              method="POST" 
              class="inline"
              onsubmit="return confirm('<?php echo e(__('admin.sections.carousels.confirm_add')); ?>');">
            <?php echo csrf_field(); ?>
            <button type="submit" 
                    class="flex items-center gap-2 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-xl transition-colors <?php echo e(isset($size) && $size === 'md' ? 'text-sm' : 'text-base'); ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span><?php echo e(__('admin.sections.carousels.add_to_carousel')); ?></span>
            </button>
        </form>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/components/add-to-carousel-button.blade.php ENDPATH**/ ?>