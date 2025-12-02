<div class="min-h-screen bg-gradient-to-br from-neutral-50 via-primary-50/30 to-neutral-50 dark:from-neutral-900 dark:via-primary-950/20 dark:to-neutral-900">
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-bold text-neutral-900 dark:text-white mb-2">
                <?php echo e(__('gigs.applications.manage_applications')); ?>

            </h1>
            <p class="text-lg text-neutral-600 dark:text-neutral-400">
                <?php echo e($gig->title); ?>

            </p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-2xl p-6 border border-white/20 dark:border-neutral-700/50">
                <div class="text-3xl font-bold text-primary-600 dark:text-primary-400 mb-2">
                    <?php echo e(number_format($stats['total'])); ?>

                </div>
                <div class="text-sm text-neutral-600 dark:text-neutral-400">
                    <?php echo e(__('gigs.applications.total_applications')); ?>

                </div>
            </div>
            
            <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-2xl p-6 border border-white/20 dark:border-neutral-700/50">
                <div class="text-3xl font-bold text-orange-600 dark:text-orange-400 mb-2">
                    <?php echo e(number_format($stats['pending'])); ?>

                </div>
                <div class="text-sm text-neutral-600 dark:text-neutral-400">
                    <?php echo e(__('gigs.applications.status_pending')); ?>

                </div>
            </div>
            
            <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-2xl p-6 border border-white/20 dark:border-neutral-700/50">
                <div class="text-3xl font-bold text-green-600 dark:text-green-400 mb-2">
                    <?php echo e(number_format($stats['accepted'])); ?>

                </div>
                <div class="text-sm text-neutral-600 dark:text-neutral-400">
                    <?php echo e(__('gigs.applications.status_accepted')); ?>

                </div>
            </div>
            
            <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-2xl p-6 border border-white/20 dark:border-neutral-700/50">
                <div class="text-3xl font-bold text-red-600 dark:text-red-400 mb-2">
                    <?php echo e(number_format($stats['rejected'])); ?>

                </div>
                <div class="text-sm text-neutral-600 dark:text-neutral-400">
                    <?php echo e(__('gigs.applications.status_rejected')); ?>

                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-2xl p-6 border border-white/20 dark:border-neutral-700/50 mb-8">
            <div class="flex flex-wrap items-center gap-4">
                <button wire:click="$set('status_filter', 'all')" 
                        class="px-4 py-2 rounded-xl font-medium transition-colors <?php echo e($status_filter === 'all' ? 'bg-primary-600 text-white' : 'bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-200 dark:hover:bg-neutral-600'); ?>">
                    <?php echo e(__('gigs.filters.all')); ?>

                </button>

                <button wire:click="$set('status_filter', 'pending')" 
                        class="px-4 py-2 rounded-xl font-medium transition-colors <?php echo e($status_filter === 'pending' ? 'bg-primary-600 text-white' : 'bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-200 dark:hover:bg-neutral-600'); ?>">
                    <?php echo e(__('gigs.applications.status_pending')); ?>

                </button>

                <button wire:click="$set('status_filter', 'accepted')" 
                        class="px-4 py-2 rounded-xl font-medium transition-colors <?php echo e($status_filter === 'accepted' ? 'bg-primary-600 text-white' : 'bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-200 dark:hover:bg-neutral-600'); ?>">
                    <?php echo e(__('gigs.applications.status_accepted')); ?>

                </button>

                <button wire:click="$set('status_filter', 'rejected')" 
                        class="px-4 py-2 rounded-xl font-medium transition-colors <?php echo e($status_filter === 'rejected' ? 'bg-primary-600 text-white' : 'bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-200 dark:hover:bg-neutral-600'); ?>">
                    <?php echo e(__('gigs.applications.status_rejected')); ?>

                </button>
            </div>
        </div>

        <!-- Applications List -->
        <div class="space-y-6">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $application): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-2xl p-6 border border-white/20 dark:border-neutral-700/50">
                    
                    <div class="flex flex-col md:flex-row gap-6">
                        
                        <!-- User Info -->
                        <div class="flex items-start gap-4">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($application->user->profile_photo_path): ?>
                                <img src="<?php echo e(asset('storage/' . $application->user->profile_photo_path)); ?>" 
                                     alt="<?php echo e($application->user->name); ?>"
                                     class="w-16 h-16 rounded-full object-cover">
                            <?php else: ?>
                                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center text-white font-bold text-xl">
                                    <?php echo e(strtoupper(substr($application->user->name, 0, 2))); ?>

                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <div>
                                <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-1">
                                    <?php echo e($application->user->name); ?>

                                </h3>
                                <p class="text-sm text-neutral-600 dark:text-neutral-400">
                                    <?php echo e(__('gigs.applications.applied_at')); ?>: <?php echo e($application->created_at->format('d M Y H:i')); ?>

                                </p>
                            </div>
                        </div>

                        <!-- Application Content -->
                        <div class="flex-1">
                            <!-- Status Badge -->
                            <div class="mb-3">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($application->status === 'pending'): ?>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200">
                                        <?php echo e(__('gigs.applications.status_pending')); ?>

                                    </span>
                                <?php elseif($application->status === 'accepted'): ?>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                        ✓ <?php echo e(__('gigs.applications.status_accepted')); ?>

                                    </span>
                                <?php elseif($application->status === 'rejected'): ?>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200">
                                        ✗ <?php echo e(__('gigs.applications.status_rejected')); ?>

                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <!-- Message -->
                            <div class="bg-neutral-50 dark:bg-neutral-900/50 rounded-xl p-4 mb-3">
                                <h4 class="text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                                    <?php echo e(__('gigs.applications.message')); ?>:
                                </h4>
                                <p class="text-sm text-neutral-700 dark:text-neutral-300">
                                    <?php echo e($application->message); ?>

                                </p>
                            </div>

                            <!-- Additional Info -->
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($application->experience): ?>
                                <div class="mb-2">
                                    <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300"><?php echo e(__('gigs.applications.experience')); ?>:</span>
                                    <p class="text-sm text-neutral-600 dark:text-neutral-400 mt-1"><?php echo e($application->experience); ?></p>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($application->portfolio_url): ?>
                                <div class="mb-2">
                                    <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300"><?php echo e(__('gigs.applications.portfolio_url')); ?>:</span>
                                    <a href="<?php echo e($application->portfolio_url); ?>" 
                                       target="_blank"
                                       class="text-sm text-primary-600 dark:text-primary-400 hover:underline ml-2">
                                        <?php echo e($application->portfolio_url); ?>

                                    </a>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($application->availability): ?>
                                <div class="mb-2">
                                    <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300"><?php echo e(__('gigs.applications.availability')); ?>:</span>
                                    <p class="text-sm text-neutral-600 dark:text-neutral-400 mt-1"><?php echo e($application->availability); ?></p>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($application->compensation_expectation): ?>
                                <div class="mb-2">
                                    <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300"><?php echo e(__('gigs.applications.compensation_expectation')); ?>:</span>
                                    <span class="text-sm text-neutral-600 dark:text-neutral-400 ml-2"><?php echo e($application->compensation_expectation); ?></span>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-col gap-2 min-w-[180px]">
                            <!-- Negotiation Chat Component -->
                            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('gigs.negotiation-chat', ['application' => $application]);

$key = 'negotiation-'.$application->id;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-2500978665-0', 'negotiation-'.$application->id);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($application->status === 'pending'): ?>
                                <button wire:click="acceptApplication(<?php echo e($application->id); ?>)" 
                                        wire:confirm="<?php echo e(__('gigs.messages.confirm_accept')); ?>"
                                        class="px-4 py-2 rounded-xl bg-green-600 hover:bg-green-700 text-white font-semibold transition-colors">
                                    ✓ <?php echo e(__('gigs.applications.accept')); ?>

                                </button>

                                <button wire:click="rejectApplication(<?php echo e($application->id); ?>)" 
                                        wire:confirm="<?php echo e(__('gigs.messages.confirm_reject')); ?>"
                                        class="px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold transition-colors">
                                    ✗ <?php echo e(__('gigs.applications.reject')); ?>

                                </button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-2xl p-12 border border-white/20 dark:border-neutral-700/50 text-center">
                    <div class="text-6xl mb-4">📭</div>
                    <h3 class="text-xl font-semibold text-neutral-900 dark:text-white mb-2">
                        <?php echo e(__('gigs.applications.no_applications')); ?>

                    </h3>
                    <p class="text-neutral-600 dark:text-neutral-400">
                        <?php echo e(__('gigs.applications.no_applications_yet')); ?>

                    </p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            <?php echo e($applications->links()); ?>

        </div>

        <!-- Back Button -->
        <div class="mt-8">
            <a href="<?php echo e(route('gigs.show', $gig)); ?>" 
               class="inline-flex items-center gap-2 text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                <?php echo e(__('gigs.back_to_gig')); ?>

            </a>
        </div>

    </div>
</div>
<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/livewire/gigs/applications-management.blade.php ENDPATH**/ ?>