<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['statistics']));

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

foreach (array_filter((['statistics']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="events-stats-section">
    <div class="max-w-[95rem] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="events-stats-grid">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [
                ['label' => 'total_events', 'value' => $statistics['total_events'], 'icon' => 'calendar', 'color' => 'text-red-700 dark:text-red-400', 'delay' => 0],
                ['label' => 'public_events', 'value' => $statistics['public_events'], 'icon' => 'globe', 'color' => 'text-amber-700 dark:text-amber-400', 'delay' => 100],
                ['label' => 'upcoming_events', 'value' => $statistics['upcoming_events'], 'icon' => 'clock', 'color' => 'text-red-600 dark:text-red-500', 'delay' => 200],
                ['label' => 'venues_count', 'value' => $statistics['venues_count'], 'icon' => 'map-pin', 'color' => 'text-amber-600 dark:text-amber-500', 'delay' => 300]
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="events-stat-item"
                 x-data="{ count: 0, target: <?php echo e($stat['value']); ?>, visible: false }"
                 x-init="setTimeout(() => { visible = true; let duration = 2000; let increment = target / (duration / 16); let timer = setInterval(() => { count += increment; if (count >= target) { count = target; clearInterval(timer); } }, 16); }, <?php echo e($stat['delay']); ?>)"
                 x-show="visible"
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0">
                
                <div class="events-stat-icon-wrapper <?php echo e($stat['color']); ?>">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($stat['icon'] === 'calendar'): ?>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    <?php elseif($stat['icon'] === 'globe'): ?>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    <?php elseif($stat['icon'] === 'clock'): ?>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    <?php elseif($stat['icon'] === 'map-pin'): ?>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                
                <div class="events-stat-content-wrapper">
                    <div class="events-stat-number <?php echo e($stat['color']); ?>">
                        <span class="events-stat-value" x-text="Math.floor(count).toLocaleString()">0</span>
                    </div>
                    <div class="events-stat-label">
                        <?php echo e(__('events.' . $stat['label'])); ?>

                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</div>

<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/components/events-stats-section.blade.php ENDPATH**/ ?>