<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="min-h-screen bg-[#fefaf3] dark:bg-neutral-900">
        
        
        <div class="sticky top-0 z-40 bg-[#fefaf3] dark:bg-neutral-900 border-b border-[rgba(139,115,85,0.2)] dark:border-neutral-700 shadow-sm">
            <div class="px-4 py-3">
                <div class="flex items-center gap-3">
                    <a href="<?php echo e(route('events.show', $event)); ?>" class="p-2 text-[#8b7355] hover:bg-[rgba(139,115,85,0.1)] rounded-lg">
                        <i class="ph ph-arrow-left text-xl"></i>
                    </a>
                    <div class="flex-1 min-w-0">
                        <h1 class="text-lg font-bold text-[#1a1a1a] dark:text-white truncate" style="font-family: 'Crimson Pro', serif;">
                            <?php echo e(__('events.manage.title')); ?>

                        </h1>
                        <p class="text-xs text-[#8b7355] dark:text-neutral-400 truncate"><?php echo e($event->title); ?></p>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="px-4 py-6 space-y-4 max-w-2xl mx-auto">
            
            
            <div class="bg-white dark:bg-neutral-800 rounded-2xl p-4 shadow-sm border border-[rgba(139,115,85,0.15)] dark:border-neutral-700">
                <div class="flex items-center gap-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->cover_image): ?>
                        <img src="<?php echo e(Storage::url($event->cover_image)); ?>" class="w-20 h-20 rounded-xl object-cover">
                    <?php else: ?>
                        <div class="w-20 h-20 rounded-xl bg-gradient-to-br from-[#b91c1c] to-[#991b1b] flex items-center justify-center">
                            <i class="ph ph-calendar-blank text-3xl text-white"></i>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <div class="flex-1 min-w-0">
                        <h2 class="font-bold text-[#1a1a1a] dark:text-white truncate" style="font-family: 'Crimson Pro', serif;">
                            <?php echo e($event->title); ?>

                        </h2>
                        <p class="text-sm text-[#8b7355] dark:text-neutral-400">
                            <?php echo e($event->start_datetime->format('d M Y, H:i')); ?>

                        </p>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-xs px-2 py-0.5 rounded-full 
                                <?php echo e($event->status === 'published' ? 'bg-green-100 text-green-700' : 
                                   ($event->status === 'draft' ? 'bg-gray-100 text-gray-700' : 
                                   ($event->status === 'completed' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700'))); ?>">
                                <?php echo e(ucfirst($event->status)); ?>

                            </span>
                            <span class="text-xs text-[#8b7355]">
                                <i class="ph ph-users"></i> <?php echo e($event->participants()->count()); ?>

                            </span>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="space-y-3">
                <h3 class="text-xs font-black uppercase tracking-widest text-[#8b7355] dark:text-neutral-500">
                    <?php echo e(__('events.manage.quick_actions')); ?>

                </h3>
                
                
                <a href="<?php echo e(route('events.edit', $event)); ?>" 
                   class="flex items-center gap-4 bg-white dark:bg-neutral-800 rounded-xl p-4 shadow-sm border border-[rgba(139,115,85,0.15)] dark:border-neutral-700 hover:border-[#b91c1c] transition-all">
                    <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                        <i class="ph ph-pencil-simple text-2xl text-blue-600"></i>
                    </div>
                    <div class="flex-1">
                        <div class="font-bold text-[#1a1a1a] dark:text-white"><?php echo e(__('events.manage.edit_event')); ?></div>
                        <div class="text-xs text-[#8b7355] dark:text-neutral-400"><?php echo e(__('events.manage.edit_event_desc')); ?></div>
                    </div>
                    <i class="ph ph-caret-right text-[#8b7355]"></i>
                </a>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->category === \App\Models\Event::CATEGORY_POETRY_SLAM): ?>
                    <a href="<?php echo e(route('events.scoring.scores', $event)); ?>" 
                       class="flex items-center gap-4 bg-white dark:bg-neutral-800 rounded-xl p-4 shadow-sm border border-[rgba(139,115,85,0.15)] dark:border-neutral-700 hover:border-[#b91c1c] transition-all">
                        <div class="w-12 h-12 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                            <i class="ph ph-trophy text-2xl text-green-600"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-bold text-[#1a1a1a] dark:text-white"><?php echo e(__('events.manage.scoring')); ?></div>
                            <div class="text-xs text-[#8b7355] dark:text-neutral-400"><?php echo e(__('events.manage.scoring_desc')); ?></div>
                        </div>
                        <i class="ph ph-caret-right text-[#8b7355]"></i>
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <a href="<?php echo e(route('events.scoring.participants', $event)); ?>" 
                   class="flex items-center gap-4 bg-white dark:bg-neutral-800 rounded-xl p-4 shadow-sm border border-[rgba(139,115,85,0.15)] dark:border-neutral-700 hover:border-[#b91c1c] transition-all">
                    <div class="w-12 h-12 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                        <i class="ph ph-users text-2xl text-purple-600"></i>
                    </div>
                    <div class="flex-1">
                        <div class="font-bold text-[#1a1a1a] dark:text-white"><?php echo e(__('events.manage.participants')); ?></div>
                        <div class="text-xs text-[#8b7355] dark:text-neutral-400"><?php echo e($event->participants()->count()); ?> <?php echo e(__('events.manage.registered')); ?></div>
                    </div>
                    <i class="ph ph-caret-right text-[#8b7355]"></i>
                </a>

                
                <a href="<?php echo e(route('events.show', $event)); ?>" 
                   class="flex items-center gap-4 bg-white dark:bg-neutral-800 rounded-xl p-4 shadow-sm border border-[rgba(139,115,85,0.15)] dark:border-neutral-700 hover:border-[#b91c1c] transition-all">
                    <div class="w-12 h-12 rounded-full bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                        <i class="ph ph-eye text-2xl text-amber-600"></i>
                    </div>
                    <div class="flex-1">
                        <div class="font-bold text-[#1a1a1a] dark:text-white"><?php echo e(__('events.manage.view_event')); ?></div>
                        <div class="text-xs text-[#8b7355] dark:text-neutral-400"><?php echo e(__('events.manage.view_event_desc')); ?></div>
                    </div>
                    <i class="ph ph-caret-right text-[#8b7355]"></i>
                </a>
            </div>

            
            <div class="space-y-3 mt-8">
                <h3 class="text-xs font-black uppercase tracking-widest text-red-600">
                    <?php echo e(__('events.manage.danger_zone')); ?>

                </h3>
                
                <div class="bg-red-50 dark:bg-red-900/20 rounded-xl p-4 border-2 border-red-200 dark:border-red-800">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/50 flex items-center justify-center flex-shrink-0">
                            <i class="ph ph-trash text-2xl text-red-600"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-bold text-red-700 dark:text-red-400"><?php echo e(__('events.manage.delete_event')); ?></div>
                            <p class="text-xs text-red-600 dark:text-red-400/80 mt-1">
                                <?php echo e(__('events.manage.delete_event_warning')); ?>

                            </p>
                            <form action="<?php echo e(route('events.destroy', $event)); ?>" method="POST" class="mt-3"
                                  onsubmit="return confirm('<?php echo e(__('events.manage.delete_confirm')); ?>')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" 
                                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-bold text-sm transition-all">
                                    <i class="ph ph-trash"></i> <?php echo e(__('events.manage.delete_button')); ?>

                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $attributes = $__attributesOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__attributesOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $component = $__componentOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__componentOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>

<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/livewire/events/event-manage.blade.php ENDPATH**/ ?>