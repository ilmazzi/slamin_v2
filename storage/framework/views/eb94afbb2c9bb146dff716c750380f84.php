<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['search', 'cities', 'city', 'type', 'freeOnly']));

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

foreach (array_filter((['search', 'cities', 'city', 'type', 'freeOnly']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="events-search-section" x-data="{ showFilters: false }">
    <div class="max-w-[95rem] mx-auto px-4 sm:px-6 lg:px-8 ">
        <!-- Elegant Search Bar -->
        <div class="events-search-container">
            <div class="relative group">
                <div class="events-search-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input 
                    type="text" 
                    wire:model.live.debounce.500ms="search"
                    placeholder="<?php echo e(__('events.search_placeholder')); ?>"
                    class="events-search-input">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search): ?>
                    <button wire:click="$set('search', '')" 
                            class="events-search-clear">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            
            <!-- Quick Filter Pills -->
            <div class="events-quick-filters">
                <button wire:click="applyQuickFilter('today')" class="events-filter-pill">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span><?php echo e(__('events.today')); ?></span>
                </button>
                <button wire:click="applyQuickFilter('tomorrow')" class="events-filter-pill">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span><?php echo e(__('events.tomorrow')); ?></span>
                </button>
                <button wire:click="applyQuickFilter('weekend')" class="events-filter-pill">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                    <span><?php echo e(__('events.weekend')); ?></span>
                </button>
                <button wire:click="applyQuickFilter('free')" class="events-filter-pill">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                    </svg>
                    <span><?php echo e(__('events.free')); ?></span>
                </button>
                <button wire:click="applyQuickFilter('past')" class="events-filter-pill">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span><?php echo e(__('events.past_events')); ?></span>
                </button>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <button wire:click="applyQuickFilter('my')" class="events-filter-pill">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span><?php echo e(__('events.my_events')); ?></span>
                    </button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <button wire:click="resetFilters" class="events-filter-pill events-filter-pill--ghost">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <span><?php echo e(__('events.reset')); ?></span>
                </button>
            </div>
            
            <!-- Advanced Filters Toggle -->
            <div class="events-advanced-toggle">
                <button @click="showFilters = !showFilters"
                        class="events-advanced-button">
                    <span><?php echo e(__('events.advanced_filters')); ?></span>
                    <svg class="events-advanced-icon" :class="{ 'rotate-180': showFilters }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
            </div>
            
            <!-- Advanced Filters Panel -->
            <div x-show="showFilters"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-4"
                 class="events-advanced-panel">
                <div class="events-advanced-grid">
                    <div class="events-filter-field">
                        <label class="events-filter-label"><?php echo e(__('events.city')); ?></label>
                        <select wire:model.live="city" class="events-filter-select">
                            <option value=""><?php echo e(__('events.all_cities')); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cityOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cityOption); ?>"><?php echo e($cityOption); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>
                    <div class="events-filter-field">
                        <label class="events-filter-label"><?php echo e(__('events.type')); ?></label>
                        <select wire:model.live="type" class="events-filter-select">
                            <option value=""><?php echo e(__('events.all_types')); ?></option>
                            <option value="public"><?php echo e(__('events.public')); ?></option>
                            <option value="private"><?php echo e(__('events.private')); ?></option>
                        </select>
                    </div>
                    <div class="events-filter-field events-filter-field--checkbox">
                        <div class="events-checkbox-wrapper">
                            <label class="events-checkbox-label">
                                <input type="checkbox" wire:model.live="freeOnly" class="events-checkbox">
                                <span class="events-checkbox-custom"></span>
                                <span class="events-checkbox-text"><?php echo e(__('events.free_only')); ?></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/components/events-search-section.blade.php ENDPATH**/ ?>