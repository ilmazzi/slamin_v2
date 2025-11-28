<div class="min-h-screen bg-[#fefaf3] dark:bg-neutral-900">
    
    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="fixed top-4 left-4 right-4 z-50" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
            <div class="bg-green-600 text-white px-4 py-3 rounded-xl shadow-lg flex items-center gap-2">
                <i class="ph ph-check-circle text-xl"></i>
                <span class="font-medium"><?php echo e(session('success')); ?></span>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="sticky top-0 z-40 bg-[#fefaf3] dark:bg-neutral-900 border-b border-[rgba(139,115,85,0.2)] dark:border-neutral-700 shadow-sm">
        <div class="px-4 py-3">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-lg font-bold text-[#1a1a1a] dark:text-white truncate" style="font-family: 'Crimson Pro', serif;">
                        <?php echo e($event->title); ?>

                    </h1>
                    <div class="flex items-center gap-3 text-xs text-[#8b7355] dark:text-neutral-400">
                        <span><i class="ph ph-users"></i> <?php echo e($stats['total_participants']); ?></span>
                        <span><i class="ph ph-medal"></i> <?php echo e($stats['badges_awarded']); ?> badges</span>
                    </div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->status === \App\Models\Event::STATUS_COMPLETED): ?>
                    <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-lg text-xs font-bold">
                        <i class="ph ph-check-circle"></i> <?php echo e(__('events.scoring.completed')); ?>

                    </span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
        
        
        <div class="flex border-t border-[rgba(139,115,85,0.1)] dark:border-neutral-800">
            <a href="<?php echo e(route('events.scoring.scores', $event)); ?>" wire:navigate 
               class="flex-1 py-3 text-center text-sm font-medium text-[#8b7355] dark:text-neutral-400 hover:bg-[rgba(139,115,85,0.1)]">
                <i class="ph ph-pencil-line"></i>
                <span class="hidden sm:inline ml-1"><?php echo e(__('events.scoring.scores')); ?></span>
            </a>
            <a href="<?php echo e(route('events.scoring.participants', $event)); ?>" wire:navigate 
               class="flex-1 py-3 text-center text-sm font-medium text-[#8b7355] dark:text-neutral-400 hover:bg-[rgba(139,115,85,0.1)]">
                <i class="ph ph-users"></i>
                <span class="hidden sm:inline ml-1"><?php echo e(__('events.scoring.participants')); ?></span>
            </a>
            <a href="<?php echo e(route('events.scoring.rankings', $event)); ?>" wire:navigate 
               class="flex-1 py-3 text-center text-sm font-bold bg-[#b91c1c] text-white">
                <i class="ph ph-trophy"></i>
                <span class="hidden sm:inline ml-1"><?php echo e(__('events.scoring.rankings')); ?></span>
            </a>
        </div>
    </div>

    
    <div class="px-4 py-4 space-y-4 pb-24">
        
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->status !== \App\Models\Event::STATUS_COMPLETED): ?>
            <div class="grid grid-cols-2 gap-3">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canCalculate): ?>
                    <button wire:click="calculatePartialRankings" 
                            class="p-4 rounded-xl bg-amber-50 dark:bg-amber-900/20 border-2 border-amber-200 dark:border-amber-800 text-center">
                        <div class="text-3xl mb-1">🧮</div>
                        <div class="text-sm font-bold text-amber-700 dark:text-amber-400"><?php echo e(__('events.scoring.calculate')); ?></div>
                    </button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canCalculate && $stats['with_scores'] > 0): ?>
                    <button onclick="confirmFinalize()" 
                            class="p-4 rounded-xl bg-green-50 dark:bg-green-900/20 border-2 border-green-200 dark:border-green-800 text-center">
                        <div class="text-3xl mb-1">🏆</div>
                        <div class="text-sm font-bold text-green-700 dark:text-green-400"><?php echo e(__('events.scoring.finalize_event')); ?></div>
                    </button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$canCalculate || $stats['with_scores'] === 0): ?>
                <div class="p-4 rounded-xl bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800">
                    <p class="text-sm text-blue-700 dark:text-blue-400 flex items-center gap-2">
                        <i class="ph ph-info text-lg"></i>
                        <?php echo e(__('events.scoring.insert_scores_before_generating_rankings')); ?>

                    </p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php else: ?>
            <div class="p-4 rounded-xl bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800">
                <p class="text-sm text-green-700 dark:text-green-400 flex items-center gap-2">
                    <span class="text-xl">🎊</span>
                    <strong><?php echo e(__('events.scoring.event_completed')); ?></strong> - <?php echo e(__('events.scoring.final_rankings_published')); ?>

                </p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($rankings->where('position', '<=', 3)->count() > 0): ?>
            <?php
                $first = $rankings->where('position', 1)->first();
                $second = $rankings->where('position', 2)->first();
                $third = $rankings->where('position', 3)->first();
            ?>
            
            <div class="grid grid-cols-3 gap-2 items-end">
                
                <div class="text-center">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($second): ?>
                        <div class="bg-gradient-to-b from-gray-100 to-gray-200 dark:from-neutral-700 dark:to-neutral-800 rounded-t-xl p-3 h-28 flex flex-col items-center justify-end">
                            <div class="text-2xl">🥈</div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($second->participant && $second->participant->user): ?>
                                <img src="<?php echo e($second->participant->user->profile_photo_url ?? asset('assets/images/avatar/default-avatar.webp')); ?>" 
                                     class="w-10 h-10 rounded-full border-2 border-white shadow">
                            <?php else: ?>
                                <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center">
                                    <i class="ph ph-user"></i>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="bg-gray-200 dark:bg-neutral-700 rounded-b-xl p-2">
                            <div class="text-xs font-bold text-[#1a1a1a] dark:text-white truncate"><?php echo e($second->participant->display_name ?? '-'); ?></div>
                            <div class="text-lg font-bold text-[#b91c1c]"><?php echo e(number_format($second->total_score, 1)); ?></div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                
                
                <div class="text-center">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($first): ?>
                        <div class="bg-gradient-to-b from-yellow-100 to-yellow-200 dark:from-yellow-900/50 dark:to-yellow-800/50 rounded-t-xl p-3 h-36 flex flex-col items-center justify-end shadow-lg">
                            <div class="text-3xl">🥇</div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($first->participant && $first->participant->user): ?>
                                <img src="<?php echo e($first->participant->user->profile_photo_url ?? asset('assets/images/avatar/default-avatar.webp')); ?>" 
                                     class="w-14 h-14 rounded-full border-4 border-yellow-400 shadow-lg">
                            <?php else: ?>
                                <div class="w-14 h-14 rounded-full bg-yellow-300 flex items-center justify-center">
                                    <i class="ph ph-user text-2xl"></i>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="bg-yellow-200 dark:bg-yellow-800/50 rounded-b-xl p-2">
                            <div class="text-sm font-bold text-[#1a1a1a] dark:text-white truncate"><?php echo e($first->participant->display_name ?? '-'); ?></div>
                            <div class="text-2xl font-bold text-yellow-700 dark:text-yellow-400"><?php echo e(number_format($first->total_score, 1)); ?></div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                
                
                <div class="text-center">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($third): ?>
                        <div class="bg-gradient-to-b from-orange-100 to-orange-200 dark:from-orange-900/30 dark:to-orange-800/30 rounded-t-xl p-3 h-24 flex flex-col items-center justify-end">
                            <div class="text-xl">🥉</div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($third->participant && $third->participant->user): ?>
                                <img src="<?php echo e($third->participant->user->profile_photo_url ?? asset('assets/images/avatar/default-avatar.webp')); ?>" 
                                     class="w-10 h-10 rounded-full border-2 border-white shadow">
                            <?php else: ?>
                                <div class="w-10 h-10 rounded-full bg-orange-300 flex items-center justify-center">
                                    <i class="ph ph-user"></i>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="bg-orange-200 dark:bg-orange-800/30 rounded-b-xl p-2">
                            <div class="text-xs font-bold text-[#1a1a1a] dark:text-white truncate"><?php echo e($third->participant->display_name ?? '-'); ?></div>
                            <div class="text-lg font-bold text-orange-700 dark:text-orange-400"><?php echo e(number_format($third->total_score, 1)); ?></div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($rankings->count() > 0): ?>
            <div class="space-y-2">
                <h3 class="text-xs font-black uppercase tracking-widest text-[#8b7355] dark:text-neutral-500">
                    <?php echo e(__('events.scoring.complete_rankings')); ?>

                </h3>
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $rankings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ranking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white dark:bg-neutral-800 rounded-xl p-4 shadow-sm border border-[rgba(139,115,85,0.15)] dark:border-neutral-700
                                <?php echo e($ranking->position <= 3 ? 'border-l-4 ' . ($ranking->position == 1 ? 'border-l-yellow-400' : ($ranking->position == 2 ? 'border-l-gray-400' : 'border-l-orange-400')) : ''); ?>">
                        <div class="flex items-center gap-3">
                            
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-lg font-bold flex-shrink-0
                                        <?php echo e($ranking->position == 1 ? 'bg-yellow-100 text-yellow-700' : 
                                           ($ranking->position == 2 ? 'bg-gray-100 text-gray-700' : 
                                           ($ranking->position == 3 ? 'bg-orange-100 text-orange-700' : 'bg-[rgba(139,115,85,0.1)] text-[#8b7355]'))); ?>">
                                <?php echo e($ranking->medal ?: $ranking->position); ?>

                            </div>
                            
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ranking->participant && $ranking->participant->user): ?>
                                <img src="<?php echo e($ranking->participant->user->profile_photo_url ?? asset('assets/images/avatar/default-avatar.webp')); ?>" 
                                     class="w-10 h-10 rounded-full object-cover flex-shrink-0">
                            <?php else: ?>
                                <div class="w-10 h-10 rounded-full bg-[rgba(139,115,85,0.1)] flex items-center justify-center flex-shrink-0">
                                    <i class="ph ph-user text-[#8b7355]"></i>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            
                            
                            <div class="flex-1 min-w-0">
                                <div class="font-bold text-[#1a1a1a] dark:text-white truncate" style="font-family: 'Crimson Pro', serif;">
                                    <?php echo e($ranking->participant->display_name ?? '-'); ?>

                                </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ranking->round_scores): ?>
                                    <div class="flex flex-wrap gap-1 mt-1">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $ranking->round_scores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $round => $score): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="text-[10px] px-1.5 py-0.5 rounded bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 font-medium">
                                                T<?php echo e($round); ?>: <?php echo e(number_format($score, 1)); ?>

                                            </span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            
                            
                            <div class="text-right">
                                <div class="text-xl font-bold text-[#b91c1c] dark:text-[#8b7355]"><?php echo e(number_format($ranking->total_score, 1)); ?></div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ranking->badge): ?>
                                    <div class="flex items-center gap-1 justify-end mt-1">
                                        <img src="<?php echo e($ranking->badge->icon_url); ?>" class="w-4 h-4">
                                        <span class="text-[10px] text-green-600 font-bold"><?php echo e($ranking->badge_awarded ? '✓' : ''); ?></span>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php else: ?>
            
            <div class="text-center py-12">
                <div class="text-6xl mb-4">📊</div>
                <h4 class="text-xl font-bold text-[#1a1a1a] dark:text-white mb-2"><?php echo e(__('gamification.no_rankings')); ?></h4>
                <p class="text-[#8b7355] dark:text-neutral-400 mb-4"><?php echo e(__('events.scoring.insert_scores_before_generating_rankings')); ?></p>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canCalculate): ?>
                    <button wire:click="calculatePartialRankings" 
                            class="px-6 py-3 bg-[#b91c1c] text-white rounded-xl font-bold">
                        <?php echo e(__('events.scoring.calculate_partial_rankings')); ?>

                    </button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmFinalize() {
            Swal.fire({
                title: '<?php echo e(__('events.scoring.confirm_finalize_event')); ?>',
                text: '<?php echo e(__('events.scoring.this_action_will_complete_the_event')); ?>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#b91c1c',
                cancelButtonColor: '#8b7355',
                confirmButtonText: '<?php echo e(__('events.scoring.finalize_event')); ?>',
                cancelButtonText: '<?php echo e(__('events.scoring.cancel')); ?>'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('finalizeEvent');
                }
            });
        }

        document.addEventListener('livewire:init', () => {
            Livewire.on('swal:success', (data) => {
                Swal.fire({ icon: 'success', title: data[0].title, text: data[0].text, toast: true, position: 'top', showConfirmButton: false, timer: 2000 });
            });
            Livewire.on('swal:error', (data) => {
                Swal.fire({ icon: 'error', title: data[0].title, text: data[0].text, confirmButtonColor: '#b91c1c' });
            });
        });
    </script>
    <?php $__env->stopPush(); ?>
</div>
<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/livewire/events/scoring/rankings.blade.php ENDPATH**/ ?>