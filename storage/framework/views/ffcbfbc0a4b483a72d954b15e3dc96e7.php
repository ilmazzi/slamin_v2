<div class="min-h-screen bg-[#fefaf3] dark:bg-neutral-900">
    
    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="fixed top-4 left-4 right-4 z-50" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
            <div class="bg-green-600 text-white px-4 py-3 rounded-xl shadow-lg flex items-center gap-2">
                <i class="ph ph-check-circle text-xl"></i>
                <span class="font-medium"><?php echo e(session('success')); ?></span>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
        <div class="fixed top-4 left-4 right-4 z-50" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
            <div class="bg-red-600 text-white px-4 py-3 rounded-xl shadow-lg flex items-center gap-2">
                <i class="ph ph-x-circle text-xl"></i>
                <span class="font-medium"><?php echo e(session('error')); ?></span>
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
                        <span><i class="ph ph-users"></i> <?php echo e($participants->count()); ?> <?php echo e(__('events.scoring.participants')); ?></span>
                        <span><i class="ph ph-check-circle"></i> <?php echo e($participants->where('status', 'confirmed')->count()); ?> <?php echo e(__('events.scoring.confirmed')); ?></span>
                    </div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isLocked): ?>
                    <span class="px-2 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 rounded-lg text-xs font-bold">
                        <i class="ph ph-lock"></i>
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
               class="flex-1 py-3 text-center text-sm font-bold bg-[#b91c1c] text-white">
                <i class="ph ph-users"></i>
                <span class="hidden sm:inline ml-1"><?php echo e(__('events.scoring.participants')); ?></span>
            </a>
            <a href="<?php echo e(route('events.scoring.rankings', $event)); ?>" wire:navigate 
               class="flex-1 py-3 text-center text-sm font-medium text-[#8b7355] dark:text-neutral-400 hover:bg-[rgba(139,115,85,0.1)]">
                <i class="ph ph-trophy"></i>
                <span class="hidden sm:inline ml-1"><?php echo e(__('events.scoring.rankings')); ?></span>
            </a>
        </div>
    </div>

    
    <div class="px-4 py-4 space-y-4 pb-24">
        
        
        <div class="grid grid-cols-3 gap-2">
            <div class="bg-white dark:bg-neutral-800 rounded-xl p-3 text-center shadow-sm border border-[rgba(139,115,85,0.15)]">
                <div class="text-2xl font-bold text-[#b91c1c] dark:text-[#8b7355]"><?php echo e($participants->count()); ?></div>
                <div class="text-[10px] uppercase font-bold text-[#8b7355] dark:text-neutral-500"><?php echo e(__('events.scoring.total')); ?></div>
            </div>
            <div class="bg-white dark:bg-neutral-800 rounded-xl p-3 text-center shadow-sm border border-[rgba(139,115,85,0.15)]">
                <div class="text-2xl font-bold text-green-600"><?php echo e($participants->where('status', 'confirmed')->count()); ?></div>
                <div class="text-[10px] uppercase font-bold text-[#8b7355] dark:text-neutral-500"><?php echo e(__('events.scoring.confirmed')); ?></div>
            </div>
            <div class="bg-white dark:bg-neutral-800 rounded-xl p-3 text-center shadow-sm border border-[rgba(139,115,85,0.15)]">
                <div class="text-2xl font-bold text-blue-600"><?php echo e($participants->where('status', 'performed')->count()); ?></div>
                <div class="text-[10px] uppercase font-bold text-[#8b7355] dark:text-neutral-500"><?php echo e(__('events.scoring.performed')); ?></div>
            </div>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$isLocked): ?>
            <button wire:click="openAddModal" 
                    class="w-full py-4 rounded-xl bg-[#b91c1c] text-white font-bold text-lg shadow-lg flex items-center justify-center gap-2">
                <i class="ph ph-plus-circle text-xl"></i>
                <?php echo e(__('events.scoring.add_participant')); ?>

            </button>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($participants->count() > 0): ?>
            <div class="space-y-3">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $participants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $participant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-sm border border-[rgba(139,115,85,0.15)] dark:border-neutral-700 overflow-hidden">
                        <div class="p-4">
                            <div class="flex items-center gap-3">
                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($participant->performance_order): ?>
                                    <div class="w-8 h-8 rounded-full bg-[#b91c1c] dark:bg-[#8b7355] text-white flex items-center justify-center text-sm font-bold flex-shrink-0">
                                        <?php echo e($participant->performance_order); ?>

                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                
                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($participant->user && $participant->user->profile_photo_url): ?>
                                    <img src="<?php echo e($participant->user->profile_photo_url); ?>" 
                                         class="w-12 h-12 rounded-full object-cover flex-shrink-0 border-2 border-[rgba(139,115,85,0.2)]">
                                <?php else: ?>
                                    <div class="w-12 h-12 rounded-full bg-[rgba(139,115,85,0.1)] flex items-center justify-center flex-shrink-0">
                                        <i class="ph ph-user text-xl text-[#8b7355]"></i>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                
                                
                                <div class="flex-1 min-w-0">
                                    <div class="font-bold text-[#1a1a1a] dark:text-white truncate" style="font-family: 'Crimson Pro', serif;">
                                        <?php echo e($participant->display_name); ?>

                                    </div>
                                    <div class="flex items-center gap-2 mt-1">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($participant->isGuest()): ?>
                                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 font-bold">
                                                <?php echo e(__('events.scoring.guest')); ?>

                                            </span>
                                        <?php else: ?>
                                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 font-bold">
                                                <?php echo e(__('events.scoring.registered')); ?>

                                            </span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($participant->guest_email): ?>
                                            <span class="text-xs text-[#8b7355] truncate"><?php echo e($participant->guest_email); ?></span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="mt-4 flex items-center gap-2">
                                <select wire:change="updateStatus(<?php echo e($participant->id); ?>, $event.target.value)" 
                                        class="flex-1 h-12 px-4 rounded-xl border-2 border-[rgba(139,115,85,0.3)] bg-[#fefaf3] dark:bg-neutral-900 text-[#1a1a1a] dark:text-white font-medium">
                                    <option value="confirmed" <?php echo e($participant->status === 'confirmed' ? 'selected' : ''); ?>>✓ <?php echo e(__('events.scoring.confirmed')); ?></option>
                                    <option value="performed" <?php echo e($participant->status === 'performed' ? 'selected' : ''); ?>>🎤 <?php echo e(__('events.scoring.performed')); ?></option>
                                    <option value="disqualified" <?php echo e($participant->status === 'disqualified' ? 'selected' : ''); ?>>❌ <?php echo e(__('events.scoring.disqualified')); ?></option>
                                    <option value="no_show" <?php echo e($participant->status === 'no_show' ? 'selected' : ''); ?>>👻 <?php echo e(__('events.scoring.no_show')); ?></option>
                                </select>
                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$isLocked): ?>
                                    <button wire:click="removeParticipant(<?php echo e($participant->id); ?>)" 
                                            onclick="return confirm('<?php echo e(__('events.scoring.are_you_sure_you_want_to_remove_this_participant')); ?>')"
                                            class="h-12 w-12 rounded-xl border-2 border-red-200 text-red-600 flex items-center justify-center hover:bg-red-50">
                                        <i class="ph ph-trash text-xl"></i>
                                    </button>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php else: ?>
            
            <div class="text-center py-12">
                <div class="text-6xl mb-4">👥</div>
                <h4 class="text-xl font-bold text-[#1a1a1a] dark:text-white mb-2"><?php echo e(__('events.scoring.no_participants')); ?></h4>
                <p class="text-[#8b7355] dark:text-neutral-400 mb-4"><?php echo e(__('events.scoring.add_first_participant_to_event')); ?></p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showAddModal): ?>
        <div class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4 bg-black/50 backdrop-blur-sm"
             x-data="{ show: true }" x-show="show" x-transition>
            <div class="w-full sm:max-w-lg bg-white dark:bg-neutral-800 rounded-t-3xl sm:rounded-2xl shadow-2xl max-h-[90vh] overflow-y-auto"
                 @click.away="$wire.set('showAddModal', false)">
                
                <div class="sticky top-0 bg-white dark:bg-neutral-800 px-4 py-4 border-b border-[rgba(139,115,85,0.1)] dark:border-neutral-700">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-[#1a1a1a] dark:text-white">
                            <?php echo e(__('events.scoring.add_participant')); ?>

                        </h3>
                        <button wire:click="$set('showAddModal', false)" class="p-2 text-[#8b7355] hover:bg-[rgba(139,115,85,0.1)] rounded-lg">
                            <i class="ph ph-x text-xl"></i>
                        </button>
                    </div>
                </div>
                
                <div class="p-4 space-y-4">
                    
                    <div class="grid grid-cols-2 gap-2">
                        <button type="button" wire:click="$set('participantType', 'user')"
                                class="p-4 rounded-xl border-2 text-center transition-all
                                       <?php echo e($participantType === 'user' ? 'border-[#b91c1c] bg-[#b91c1c]/5' : 'border-[rgba(139,115,85,0.2)]'); ?>">
                            <i class="ph ph-user-check text-2xl <?php echo e($participantType === 'user' ? 'text-[#b91c1c]' : 'text-[#8b7355]'); ?>"></i>
                            <div class="text-sm font-bold mt-1 <?php echo e($participantType === 'user' ? 'text-[#b91c1c]' : 'text-[#1a1a1a] dark:text-white'); ?>">
                                <?php echo e(__('events.scoring.registered_user')); ?>

                            </div>
                        </button>
                        <button type="button" wire:click="$set('participantType', 'guest')"
                                class="p-4 rounded-xl border-2 text-center transition-all
                                       <?php echo e($participantType === 'guest' ? 'border-[#b91c1c] bg-[#b91c1c]/5' : 'border-[rgba(139,115,85,0.2)]'); ?>">
                            <i class="ph ph-user-circle text-2xl <?php echo e($participantType === 'guest' ? 'text-[#b91c1c]' : 'text-[#8b7355]'); ?>"></i>
                            <div class="text-sm font-bold mt-1 <?php echo e($participantType === 'guest' ? 'text-[#b91c1c]' : 'text-[#1a1a1a] dark:text-white'); ?>">
                                <?php echo e(__('events.scoring.guest')); ?>

                            </div>
                        </button>
                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($participantType === 'user'): ?>
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedUser): ?>
                            <div class="p-4 rounded-xl bg-green-50 dark:bg-green-900/20 border-2 border-green-200 dark:border-green-800">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <img src="<?php echo e($selectedUser['avatar']); ?>" class="w-12 h-12 rounded-full">
                                        <span class="font-bold text-[#1a1a1a] dark:text-white"><?php echo e($selectedUser['display_name']); ?></span>
                                    </div>
                                    <button wire:click="clearSelectedUser" class="p-2 text-red-600 hover:bg-red-50 rounded-lg">
                                        <i class="ph ph-x"></i>
                                    </button>
                                </div>
                            </div>
                        <?php else: ?>
                            <div>
                                <input type="text" wire:model.live.debounce.300ms="userSearch"
                                       class="w-full h-12 px-4 rounded-xl border-2 border-[rgba(139,115,85,0.3)] bg-[#fefaf3] dark:bg-neutral-900 text-[#1a1a1a] dark:text-white"
                                       placeholder="<?php echo e(__('events.scoring.name_nickname_email')); ?>">
                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($searchResults) > 0): ?>
                                    <div class="mt-2 rounded-xl border border-[rgba(139,115,85,0.2)] overflow-hidden max-h-48 overflow-y-auto">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $searchResults; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <button wire:click="selectUser(<?php echo e($result['id']); ?>)"
                                                    class="w-full p-3 flex items-center gap-3 hover:bg-[rgba(139,115,85,0.05)] border-b last:border-b-0">
                                                <img src="<?php echo e($result['avatar']); ?>" class="w-10 h-10 rounded-full">
                                                <div class="text-left">
                                                    <div class="font-bold text-[#1a1a1a] dark:text-white"><?php echo e($result['display_name']); ?></div>
                                                    <div class="text-xs text-[#8b7355]"><?php echo e($result['email']); ?></div>
                                                </div>
                                            </button>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php else: ?>
                        
                        <div>
                            <label class="block text-sm font-bold text-[#8b7355] mb-2"><?php echo e(__('events.scoring.name')); ?> *</label>
                            <input type="text" wire:model="guest_name" 
                                   class="w-full h-12 px-4 rounded-xl border-2 border-[rgba(139,115,85,0.3)] bg-[#fefaf3] dark:bg-neutral-900 text-[#1a1a1a] dark:text-white">
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-sm font-bold text-[#8b7355] mb-2"><?php echo e(__('events.scoring.email')); ?></label>
                                <input type="email" wire:model="guest_email" 
                                       class="w-full h-12 px-4 rounded-xl border-2 border-[rgba(139,115,85,0.3)] bg-[#fefaf3] dark:bg-neutral-900 text-[#1a1a1a] dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-[#8b7355] mb-2"><?php echo e(__('events.scoring.phone')); ?></label>
                                <input type="text" wire:model="guest_phone" 
                                       class="w-full h-12 px-4 rounded-xl border-2 border-[rgba(139,115,85,0.3)] bg-[#fefaf3] dark:bg-neutral-900 text-[#1a1a1a] dark:text-white">
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <div>
                        <label class="block text-sm font-bold text-[#8b7355] mb-2"><?php echo e(__('events.scoring.performance_order')); ?></label>
                        <input type="number" wire:model="performance_order" min="1"
                               class="w-full h-12 px-4 rounded-xl border-2 border-[rgba(139,115,85,0.3)] bg-[#fefaf3] dark:bg-neutral-900 text-[#1a1a1a] dark:text-white text-center text-xl font-bold"
                               placeholder="#">
                        <p class="text-xs text-[#8b7355] mt-1"><?php echo e(__('events.scoring.leave_empty_for_auto_assignment')); ?></p>
                    </div>
                </div>
                
                <div class="sticky bottom-0 bg-white dark:bg-neutral-800 p-4 border-t border-[rgba(139,115,85,0.1)] dark:border-neutral-700 flex gap-3">
                    <button wire:click="$set('showAddModal', false)" 
                            class="flex-1 py-3 rounded-xl border-2 border-[rgba(139,115,85,0.3)] text-[#8b7355] font-bold">
                        <?php echo e(__('events.scoring.cancel')); ?>

                    </button>
                    <button wire:click="addParticipant" 
                            class="flex-1 py-3 rounded-xl bg-[#b91c1c] text-white font-bold">
                        <i class="ph ph-plus"></i> <?php echo e(__('events.scoring.add')); ?>

                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('swal:success', (data) => {
                Swal.fire({ icon: 'success', title: data[0].title, text: data[0].text, toast: true, position: 'top', showConfirmButton: false, timer: 2000 });
            });
            Livewire.on('swal:warning', (data) => {
                Swal.fire({ icon: 'warning', title: data[0].title, text: data[0].text, confirmButtonColor: '#b91c1c' });
            });
            Livewire.on('swal:error', (data) => {
                Swal.fire({ icon: 'error', title: data[0].title, text: data[0].text, confirmButtonColor: '#b91c1c' });
            });
        });
    </script>
    <?php $__env->stopPush(); ?>
</div>
<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/livewire/events/scoring/participant-management.blade.php ENDPATH**/ ?>