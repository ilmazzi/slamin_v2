<div x-data="{ open: <?php if ((object) ('showNegotiation') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showNegotiation'->value()); ?>')<?php echo e('showNegotiation'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showNegotiation'); ?>')<?php endif; ?> }">
    <!-- Toggle Button -->
    <button @click="$wire.toggleNegotiation()" 
            class="relative px-4 py-2 rounded-xl bg-blue-100 dark:bg-blue-900 hover:bg-blue-200 dark:hover:bg-blue-800 text-blue-900 dark:text-blue-100 font-medium transition-colors">
        💬 <?php echo e(__('negotiations.negotiate')); ?>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($unreadCount > 0): ?>
            <span class="absolute -top-2 -right-2 flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 rounded-full">
                <?php echo e($unreadCount); ?>

            </span>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </button>

    <!-- Negotiation Modal/Panel -->
    <template x-teleport="body">
        <div x-show="open"
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[9999] overflow-y-auto flex items-center justify-center p-4"
             style="margin: 0 !important; padding: 1rem !important;">
            
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-neutral-900/75 backdrop-blur-sm" 
                 @click="$wire.toggleNegotiation()"></div>

            <!-- Modal panel -->
            <div x-show="open"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="relative w-full max-w-4xl max-h-[90vh] bg-white dark:bg-neutral-800 shadow-2xl rounded-3xl overflow-hidden flex flex-col">
                    
                    <!-- Header -->
                    <div class="flex items-center justify-between p-6 border-b border-neutral-200 dark:border-neutral-700">
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">
                            💬 <?php echo e(__('negotiations.title')); ?>

                        </h2>
                        <button @click="$wire.toggleNegotiation()" 
                                class="text-neutral-500 hover:text-neutral-700 dark:hover:text-neutral-300 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Gig Info Summary -->
                    <div class="p-4 bg-neutral-50 dark:bg-neutral-900/50 border-b border-neutral-200 dark:border-neutral-700">
                        <div class="text-sm">
                            <span class="font-semibold text-neutral-700 dark:text-neutral-300"><?php echo e(__('negotiations.gig')); ?>:</span>
                            <span class="text-neutral-600 dark:text-neutral-400 ml-2"><?php echo e($application->gig->title); ?></span>
                        </div>
                        <div class="text-sm mt-1">
                            <span class="font-semibold text-neutral-700 dark:text-neutral-300"><?php echo e(__('negotiations.applicant')); ?>:</span>
                            <span class="text-neutral-600 dark:text-neutral-400 ml-2"><?php echo e($application->user->name); ?></span>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($application->compensation_expectation): ?>
                            <div class="text-sm mt-1">
                                <span class="font-semibold text-neutral-700 dark:text-neutral-300"><?php echo e(__('negotiations.original_offer')); ?>:</span>
                                <span class="text-neutral-600 dark:text-neutral-400 ml-2"><?php echo e($application->compensation_expectation); ?></span>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <!-- Messages -->
                    <div class="flex-1 p-6 space-y-4 overflow-y-auto" id="negotiation-messages" style="min-height: 200px; max-height: 400px;">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $negotiations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $negotiation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="flex <?php echo e($negotiation->user_id === Auth::id() ? 'justify-end' : 'justify-start'); ?>">
                                <div class="max-w-md">
                                    <!-- User info -->
                                    <div class="flex items-center gap-2 mb-1 <?php echo e($negotiation->user_id === Auth::id() ? 'justify-end' : 'justify-start'); ?>">
                                        <span class="text-xs text-neutral-500 dark:text-neutral-400">
                                            <?php echo e($negotiation->user->name); ?>

                                        </span>
                                        <span class="text-xs text-neutral-400 dark:text-neutral-500">
                                            <?php echo e($negotiation->created_at->diffForHumans()); ?>

                                        </span>
                                    </div>

                                    <!-- Message bubble -->
                                    <div class="rounded-2xl p-4 <?php echo e($negotiation->user_id === Auth::id() 
                                        ? 'bg-primary-600 text-white' 
                                        : 'bg-neutral-100 dark:bg-neutral-700 text-neutral-900 dark:text-white'); ?>">
                                        
                                        <!-- Message Type Badge -->
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($negotiation->message_type !== 'info'): ?>
                                            <div class="mb-2">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($negotiation->message_type === 'proposal'): ?>
                                                    <span class="px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                                        💰 <?php echo e(__('negotiations.types.proposal')); ?>

                                                    </span>
                                                <?php elseif($negotiation->message_type === 'counter'): ?>
                                                    <span class="px-2 py-1 rounded-full text-xs font-semibold bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200">
                                                        🔄 <?php echo e(__('negotiations.types.counter')); ?>

                                                    </span>
                                                <?php elseif($negotiation->message_type === 'accept'): ?>
                                                    <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                                        ✓ <?php echo e(__('negotiations.types.accept')); ?>

                                                    </span>
                                                <?php elseif($negotiation->message_type === 'reject'): ?>
                                                    <span class="px-2 py-1 rounded-full text-xs font-semibold bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200">
                                                        ✗ <?php echo e(__('negotiations.types.reject')); ?>

                                                    </span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                        <!-- Message text -->
                                        <p class="text-sm"><?php echo e($negotiation->message); ?></p>

                                        <!-- Proposed values -->
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($negotiation->proposed_compensation || $negotiation->proposed_deadline): ?>
                                            <div class="mt-3 pt-3 border-t <?php echo e($negotiation->user_id === Auth::id() ? 'border-primary-500' : 'border-neutral-200 dark:border-neutral-600'); ?>">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($negotiation->proposed_compensation): ?>
                                                    <div class="text-sm font-semibold">
                                                        <?php echo e(__('negotiations.proposed_compensation')); ?>: €<?php echo e(number_format($negotiation->proposed_compensation, 2)); ?>

                                                    </div>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($negotiation->proposed_deadline): ?>
                                                    <div class="text-sm">
                                                        <?php echo e(__('negotiations.proposed_deadline')); ?>: <?php echo e($negotiation->proposed_deadline->format('d M Y')); ?>

                                                    </div>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-center py-8 text-neutral-500 dark:text-neutral-400">
                                <p><?php echo e(__('negotiations.no_messages')); ?></p>
                                <p class="text-sm mt-2"><?php echo e(__('negotiations.start_negotiation')); ?></p>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <!-- Message Input Form -->
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($application->status === 'pending'): ?>
                    <div class="flex-shrink-0 p-6 border-t border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-900/50">
                        
                        <!-- Message Type Selector -->
                        <div class="flex flex-wrap gap-2 mb-4">
                            <button type="button" 
                                    wire:click="setMessageType('info')"
                                    class="px-3 py-1 rounded-lg text-sm font-medium transition-colors <?php echo e($messageType === 'info' ? 'bg-neutral-600 text-white' : 'bg-neutral-200 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-300 dark:hover:bg-neutral-600'); ?>">
                                💬 <?php echo e(__('negotiations.types.info')); ?>

                            </button>

                            <button type="button" 
                                    wire:click="setMessageType('proposal')"
                                    class="px-3 py-1 rounded-lg text-sm font-medium transition-colors <?php echo e($messageType === 'proposal' ? 'bg-blue-600 text-white' : 'bg-neutral-200 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-300 dark:hover:bg-neutral-600'); ?>">
                                💰 <?php echo e(__('negotiations.types.proposal')); ?>

                            </button>

                            <button type="button" 
                                    wire:click="setMessageType('counter')"
                                    class="px-3 py-1 rounded-lg text-sm font-medium transition-colors <?php echo e($messageType === 'counter' ? 'bg-orange-600 text-white' : 'bg-neutral-200 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-300 dark:hover:bg-neutral-600'); ?>">
                                🔄 <?php echo e(__('negotiations.types.counter')); ?>

                            </button>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isRequester): ?>
                                <button type="button" 
                                        wire:click="setMessageType('accept')"
                                        class="px-3 py-1 rounded-lg text-sm font-medium transition-colors <?php echo e($messageType === 'accept' ? 'bg-green-600 text-white' : 'bg-neutral-200 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-300 dark:hover:bg-neutral-600'); ?>">
                                    ✓ <?php echo e(__('negotiations.types.accept')); ?>

                                </button>

                                <button type="button" 
                                        wire:click="setMessageType('reject')"
                                        class="px-3 py-1 rounded-lg text-sm font-medium transition-colors <?php echo e($messageType === 'reject' ? 'bg-red-600 text-white' : 'bg-neutral-200 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-300 dark:hover:bg-neutral-600'); ?>">
                                    ✗ <?php echo e(__('negotiations.types.reject')); ?>

                                </button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <!-- Form -->
                        <form wire:submit.prevent="sendMessage" class="space-y-4">
                            
                            <!-- Message -->
                            <div>
                                <textarea wire:model="message" 
                                          rows="3"
                                          placeholder="<?php echo e(__('negotiations.message_placeholder')); ?>"
                                          class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 resize-none"></textarea>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                    <span class="text-sm text-red-600 dark:text-red-400 mt-1"><?php echo e($message); ?></span> 
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <!-- Optional: Proposed Compensation & Deadline -->
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($messageType, ['proposal', 'counter', 'accept'])): ?>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700">
                                    <div>
                                        <label class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                                            <?php echo e(__('negotiations.proposed_compensation')); ?>

                                        </label>
                                        <div class="relative">
                                            <span class="absolute left-3 top-3 text-neutral-500">€</span>
                                            <input type="number" 
                                                   wire:model="proposedCompensation"
                                                   step="0.01"
                                                   min="0"
                                                   placeholder="50.00"
                                                   class="w-full pl-8 pr-4 py-2 rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                                        </div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['proposedCompensation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                            <span class="text-xs text-red-600 dark:text-red-400 mt-1"><?php echo e($message); ?></span> 
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                                            <?php echo e(__('negotiations.proposed_deadline')); ?>

                                        </label>
                                        <input type="date" 
                                               wire:model="proposedDeadline"
                                               class="w-full px-4 py-2 rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['proposedDeadline'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                            <span class="text-xs text-red-600 dark:text-red-400 mt-1"><?php echo e($message); ?></span> 
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <!-- Submit Button -->
                            <div class="flex gap-3">
                                <button type="submit" 
                                        class="flex-1 px-6 py-3 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-semibold transition-colors">
                                    <?php echo e(__('negotiations.send_message')); ?>

                                </button>
                                
                                <button type="button" 
                                        wire:click="toggleNegotiation"
                                        class="px-6 py-3 rounded-xl bg-neutral-200 dark:bg-neutral-700 hover:bg-neutral-300 dark:hover:bg-neutral-600 text-neutral-900 dark:text-white font-semibold transition-colors">
                                    <?php echo e(__('common.cancel')); ?>

                                </button>
                            </div>
                        </form>

                    </div>
                    <?php else: ?>
                    <!-- Negotiation Closed Notice -->
                    <div class="flex-shrink-0 p-6 border-t border-neutral-200 dark:border-neutral-700 bg-neutral-100 dark:bg-neutral-900">
                        <div class="text-center space-y-3">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($application->status === 'accepted'): ?>
                                <div class="inline-flex items-center gap-2 px-6 py-3 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 rounded-xl font-semibold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <?php echo e(__('negotiations.negotiation_closed_accepted')); ?>

                                </div>
                                
                                <a href="<?php echo e(route('gigs.workspace', $application)); ?>" 
                                   class="inline-flex items-center gap-2 px-6 py-3 bg-accent-600 hover:bg-accent-700 text-white font-bold rounded-lg shadow-lg transition-all hover:scale-105">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    🚀 Vai al Workspace Collaborativo
                                </a>
                            <?php elseif($application->status === 'rejected'): ?>
                                <div class="inline-flex items-center gap-2 px-6 py-3 bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 rounded-xl font-semibold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <?php echo e(__('negotiations.negotiation_closed_rejected')); ?>

                                </div>
                            <?php else: ?>
                                <div class="inline-flex items-center gap-2 px-6 py-3 bg-neutral-200 dark:bg-neutral-700 text-neutral-800 dark:text-neutral-300 rounded-xl font-semibold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    <?php echo e(__('negotiations.negotiation_closed')); ?>

                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                </div>

            </div>
        </div>
    </template>
</div>

<script>
    // Auto-scroll to bottom when new messages arrive
    document.addEventListener('livewire:initialized', () => {
        const messagesContainer = document.getElementById('negotiation-messages');
        if (messagesContainer) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    });

    // Also scroll on updates
    document.addEventListener('livewire:update', () => {
        // Use setTimeout to ensure DOM is updated
        setTimeout(() => {
            const messagesContainer = document.getElementById('negotiation-messages');
            if (messagesContainer) {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
        }, 100);
    });

    // Scroll when modal opens
    window.addEventListener('load', () => {
        setTimeout(() => {
            const messagesContainer = document.getElementById('negotiation-messages');
            if (messagesContainer) {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
        }, 100);
    });
</script>
<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/livewire/gigs/negotiation-chat.blade.php ENDPATH**/ ?>