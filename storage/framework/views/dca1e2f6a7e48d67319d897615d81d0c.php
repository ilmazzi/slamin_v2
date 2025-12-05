<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'itemId',
    'itemType',
    'commentsCount' => 0,
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
    'commentsCount' => 0,
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
    'sm' => 'w-5 h-5',
    'md' => 'w-6 h-6',
    'lg' => 'w-7 h-7',
];
$iconSize = $sizeClasses[$size] ?? $sizeClasses['md'];

$textSizeClasses = [
    'sm' => 'text-xs',
    'md' => 'text-sm',
    'lg' => 'text-base',
];
$textSize = $textSizeClasses[$size] ?? $textSizeClasses['md'];
?>

<div <?php echo e($attributes->only(['class'])); ?>>
    <button type="button"
            @click="$dispatch('open-comments', { id: <?php echo e($itemId); ?>, type: '<?php echo e($itemType); ?>' })"
            class="flex items-center gap-1 text-neutral-600 dark:text-neutral-400 hover:text-primary-600 transition-all duration-300 group cursor-pointer">
        <svg class="<?php echo e($iconSize); ?> group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
        </svg>
        <span class="font-medium <?php echo e($textSize); ?>"><?php echo e($commentsCount); ?></span>
    </button>
</div>

<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/components/comment-button.blade.php ENDPATH**/ ?>