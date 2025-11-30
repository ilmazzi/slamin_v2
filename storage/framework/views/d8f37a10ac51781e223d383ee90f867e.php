<!-- Notification Modal with Busta Theme -->
<div x-data="{ showModal: <?php if ((object) ('showModal') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showModal'->value()); ?>')<?php echo e('showModal'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showModal'); ?>')<?php endif; ?> }">
    <template x-teleport="body">
        <div x-show="showModal"
             class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 py-8 overflow-y-auto"
             style="z-index: 999999 !important;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click.self="$wire.closeModal()">

            <!-- Modal Container -->
            <div class="bg-white dark:bg-neutral-900 rounded-3xl shadow-2xl max-w-3xl w-full max-h-[85vh] overflow-hidden my-auto"
                 x-show="showModal"
                 x-transition:enter="transition ease-out duration-300 delay-100"
                 x-transition:enter-start="opacity-0 scale-90 -translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-90"
                 @click.stop>

            <!-- Header with Busta -->
            <div class="relative bg-gradient-to-br from-primary-500 via-primary-600 to-primary-700 p-8 overflow-hidden">
                <!-- Animated background -->
                <div class="absolute inset-0 opacity-20">
                    <div class="absolute top-0 left-0 w-64 h-64 bg-white rounded-full blur-3xl animate-pulse"></div>
                    <div class="absolute bottom-0 right-0 w-80 h-80 bg-white rounded-full blur-3xl animate-pulse" style="animation-delay: 0.5s;"></div>
                </div>

                <div class="relative flex items-center justify-between">
                    <div class="flex items-center gap-6">
                        <!-- Busta Icon -->
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-yellow-300 via-pink-300 to-blue-300 rounded-full blur-xl opacity-60 animate-pulse scale-150"></div>
                            <div class="relative bg-white/20 backdrop-blur-sm rounded-2xl p-4">
                                <img src="<?php echo e(asset('assets/images/busta.png')); ?>"
                                     alt="Notifiche"
                                     class="w-20 h-20 object-contain drop-shadow-2xl animate-bounce-slow"
                                     style="filter: drop-shadow(0 0 20px rgba(255,255,255,0.8));">
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($unreadCount > 0): ?>
                            <div class="absolute -top-2 -right-2 bg-red-500 text-white text-sm font-bold rounded-full w-8 h-8 flex items-center justify-center animate-bounce shadow-xl border-4 border-white">
                                <?php echo e($unreadCount); ?>

                            </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <!-- Title -->
                        <div class="text-white">
                            <h2 class="text-3xl font-bold mb-2 drop-shadow-lg">Le Tue Notifiche</h2>
                            <p class="text-white/90 text-sm">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($unreadCount > 0): ?>
                                    Hai <?php echo e($unreadCount); ?> <?php echo e($unreadCount === 1 ? 'notifica non letta' : 'notifiche non lette'); ?>

                                <?php else: ?>
                                    Tutte le notifiche sono state lette
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </p>
                        </div>
                    </div>

                    <!-- Close Button -->
                    <button wire:click="closeModal" 
                            class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full bg-white/20 hover:bg-white/30 transition-colors backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Actions -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($unreadCount > 0): ?>
                <div class="relative mt-4">
                    <button wire:click="markAllAsRead"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white rounded-full text-sm font-medium transition-all duration-300 border border-white/30">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Segna tutte come lette
                    </button>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Notifications List -->
            <div class="overflow-y-auto max-h-[50vh] p-6">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($notifications) > 0): ?>
                    <div class="space-y-3">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e($notification['url']); ?>" 
                           wire:click="markAsRead('<?php echo e($notification['id']); ?>')"
                           class="group relative bg-gradient-to-r <?php echo e($notification['read'] ? 'from-neutral-50 to-neutral-100 dark:from-neutral-800 dark:to-neutral-800' : 'from-primary-50 to-primary-100 dark:from-primary-900/30 dark:to-primary-800/30'); ?> rounded-2xl p-4 hover:shadow-lg transition-all duration-300 border-2 <?php echo e($notification['read'] ? 'border-transparent' : 'border-primary-200 dark:border-primary-700'); ?> block cursor-pointer">
                            <div class="flex items-start gap-4">
                                <!-- Icon -->
                                <div class="flex-shrink-0 w-12 h-12 rounded-full bg-gradient-to-br from-primary-100 to-primary-200 dark:from-primary-900 dark:to-primary-800 flex items-center justify-center shadow-md">
                                    <span class="text-2xl"><?php echo e($notification['icon']); ?></span>
                                </div>

                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2 mb-1">
                                        <h4 class="font-semibold text-neutral-900 dark:text-white text-sm">
                                            <?php echo e($notification['title']); ?>

                                        </h4>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$notification['read']): ?>
                                        <span class="flex-shrink-0 w-2 h-2 bg-primary-500 rounded-full animate-pulse"></span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                    
                                    <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-2">
                                        <?php echo e($notification['message']); ?>

                                    </p>

                                    <div class="flex items-center justify-between gap-2">
                                        <span class="text-xs text-neutral-500 dark:text-neutral-500">
                                            <?php echo e($notification['created_at']); ?>

                                        </span>

                                        <div class="flex items-center gap-2">
                                            <span class="text-xs text-primary-600 dark:text-primary-400 font-medium">
                                                Visualizza →
                                            </span>
                                            
                                            <button wire:click.stop="deleteNotification('<?php echo e($notification['id']); ?>')"
                                                    class="text-xs text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 font-medium">
                                                ✕
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Hover effect -->
                            <div class="absolute inset-0 bg-gradient-to-r from-primary-500/5 to-primary-600/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                        </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php else: ?>
                    <!-- Empty State -->
                    <div class="text-center py-16">
                        <div class="inline-block mb-6">
                            <img src="<?php echo e(asset('assets/images/busta.png')); ?>"
                                 alt="Nessuna notifica"
                                 class="w-32 h-32 object-contain opacity-30 grayscale">
                        </div>
                        <h3 class="text-xl font-semibold text-neutral-900 dark:text-white mb-2">
                            Nessuna notifica
                        </h3>
                        <p class="text-neutral-600 dark:text-neutral-400">
                            Non hai ancora ricevuto notifiche. Quando qualcuno interagirà con i tuoi contenuti, le vedrai qui!
                        </p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Footer -->
            <div class="border-t border-neutral-200 dark:border-neutral-700 p-4 bg-neutral-50 dark:bg-neutral-800/50">
                <button wire:click="closeModal"
                        class="w-full px-6 py-3 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    Chiudi
                </button>
            </div>
        </div>
        </div>
    </template>

    <style>
    @keyframes bounce-slow {
        0%, 100% {
            transform: translateY(0) scale(1);
        }
        50% {
            transform: translateY(-10px) scale(1.05);
        }
    }
    
    .animate-bounce-slow {
        animation: bounce-slow 2s ease-in-out infinite;
    }
    </style>
</div>
<?php /**PATH /Users/mazzi/slamin_v2/resources/views/livewire/notifications/notification-modal.blade.php ENDPATH**/ ?>