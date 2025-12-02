<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'itemId',
    'itemType',
    'isReported' => false,
    'size' => 'md', // sm, md, lg
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
    'itemId',
    'itemType',
    'isReported' => false,
    'size' => 'md', // sm, md, lg
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
$sizeClasses = [
    'sm' => 'w-4 h-4',
    'md' => 'w-5 h-5',
    'lg' => 'w-6 h-6',
];
$iconSize = $sizeClasses[$size] ?? $sizeClasses['md'];

$textSizeClasses = [
    'sm' => 'text-xs',
    'md' => 'text-sm',
    'lg' => 'text-base',
];
$textSize = $textSizeClasses[$size] ?? $textSizeClasses['md'];
?>

<div x-data="{ 
    reported: <?php echo e($isReported ? 'true' : 'false'); ?>,
    
    openReportModal() {
        <?php if(auth()->guard()->guest()): ?>
            this.$dispatch('notify', { 
                message: '<?php echo e(__('report.login_required')); ?>', 
                type: 'warning' 
            });
            return;
        <?php endif; ?>
        
        if (this.reported) {
            this.$dispatch('notify', { 
                message: '<?php echo e(__('report.already_reported')); ?>', 
                type: 'info' 
            });
            return;
        }
        
        // Dispatch event per aprire modal
        this.$dispatch('open-report-modal', {
            itemId: <?php echo e($itemId); ?>,
            itemType: '<?php echo e($itemType); ?>'
        });
    }
}" <?php echo e($attributes->merge(['class' => 'inline-flex items-center'])); ?>>
    <button type="button"
            @click="openReportModal()"
            :disabled="reported"
            :title="reported ? '<?php echo e(__('report.already_reported')); ?>' : '<?php echo e(__('report.report_content')); ?>'"
            class="flex items-center gap-1.5 transition-all duration-300 group cursor-pointer hover:opacity-80"
            :class="{ 'opacity-50 cursor-not-allowed': reported }">
        <svg class="<?php echo e($iconSize); ?> transition-all duration-300" 
             :class="{ 'text-red-500': reported, 'text-neutral-500 group-hover:text-red-500': !reported }"
             fill="none" 
             stroke="currentColor" 
             viewBox="0 0 24 24">
            <path stroke-linecap="round" 
                  stroke-linejoin="round" 
                  stroke-width="2" 
                  d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>
        </svg>
        <span class="font-medium <?php echo e($textSize); ?>" 
              :class="{ 'text-red-500': reported, 'text-neutral-500 group-hover:text-red-500': !reported }"
              x-show="!reported">
            <?php echo e(__('report.report')); ?>

        </span>
        <span class="font-medium <?php echo e($textSize); ?> text-red-500" 
              x-show="reported">
            <?php echo e(__('report.reported')); ?>

        </span>
    </button>
</div>

<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/components/report-button.blade.php ENDPATH**/ ?>