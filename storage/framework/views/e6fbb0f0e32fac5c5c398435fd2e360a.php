<div class="relative" 
     x-data="{ show: <?php if ((object) ('showPanel') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showPanel'->value()); ?>')<?php echo e('showPanel'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showPanel'); ?>')<?php endif; ?> }"
     wire:poll.10s="loadNotifications"
     x-on:notification-received.window="$wire.loadNotifications()">
    
    <!-- Bell Icon with Badge -->
    <button @click="$dispatch('open-notification-modal')" 
            class="relative p-2 rounded-xl text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-700 transition-colors">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($unreadCount > 0): ?>
            <span class="absolute top-0 right-0 flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full animate-pulse">
                <?php echo e($unreadCount > 9 ? '9+' : $unreadCount); ?>

            </span>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </button>

    <!-- Notification Panel (HIDDEN - using modal instead) -->
    <div x-show="false" 
         class="hidden">
        
        <!-- Header -->
        <div class="flex items-center justify-between p-4 border-b border-neutral-200 dark:border-neutral-700">
            <h3 class="text-lg font-bold text-neutral-900 dark:text-white">
                🔔 <?php echo e(__('notifications.title')); ?>

            </h3>
            
            <div class="flex items-center gap-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($unreadCount > 0): ?>
                    <button wire:click="markAllAsRead" 
                            class="text-xs text-primary-600 dark:text-primary-400 hover:underline">
                        <?php echo e(__('notifications.mark_all_read')); ?>

                    </button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($notifications) > 0): ?>
                    <button wire:click="clearAll" 
                            wire:confirm="<?php echo e(__('notifications.confirm_clear_all')); ?>"
                            class="text-xs text-red-600 dark:text-red-400 hover:underline ml-2">
                        <?php echo e(__('notifications.clear_all')); ?>

                    </button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <!-- Notifications List -->
        <div class="max-h-[32rem] overflow-y-auto">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="p-4 border-b border-neutral-100 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-700/50 transition-colors <?php echo e($notification->read_at ? '' : 'bg-blue-50 dark:bg-blue-900/10'); ?>">
                    
                    <div class="flex items-start gap-3">
                        <!-- User Avatar -->
                        <?php
                            $senderUserId = $notification->data['sender_id'] ?? null;
                            $senderUser = $senderUserId ? \App\Models\User::find($senderUserId) : null;
                        ?>
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($senderUser): ?>
                            <img src="<?php echo e(\App\Helpers\AvatarHelper::getUserAvatarUrl($senderUser, 80)); ?>" 
                                 alt="<?php echo e($senderUser->name); ?>"
                                 class="flex-shrink-0 w-10 h-10 rounded-full object-cover <?php echo e($notification->read_at ? 'opacity-75' : 'ring-2 ring-primary-500'); ?>">
                        <?php else: ?>
                            <!-- Fallback icon based on notification type -->
                            <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center
                                        <?php echo e($notification->read_at 
                                            ? 'bg-neutral-100 dark:bg-neutral-700' 
                                            : 'bg-primary-100 dark:bg-primary-900 animate-pulse'); ?>">
                                <?php
                                    $icon = '🔔';
                                    if (isset($notification->data['type'])) {
                                        $icon = match($notification->data['type']) {
                                            'gig_application' => '📝',
                                            'application_accepted' => '✅',
                                            'application_rejected' => '❌',
                                            'negotiation_message' => '💬',
                                            'gig_created' => '✨',
                                            default => '🔔'
                                        };
                                    }
                                ?>
                                <span class="text-xl"><?php echo e($icon); ?></span>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-neutral-900 dark:text-white mb-1">
                                <?php echo e($notification->data['title'] ?? __('notifications.new_notification')); ?>

                            </p>
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($notification->data['message'])): ?>
                                <p class="text-sm text-neutral-600 dark:text-neutral-400 line-clamp-2">
                                    <?php echo e($notification->data['message']); ?>

                                </p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <div class="flex items-center flex-wrap gap-x-3 gap-y-1 mt-2">
                                <span class="text-xs text-neutral-500 dark:text-neutral-400">
                                    <?php echo e($notification->created_at->diffForHumans()); ?>

                                </span>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($notification->data['url'])): ?>
                                    <a href="<?php echo e($notification->data['url']); ?>" 
                                       wire:click="markAsRead('<?php echo e($notification->id); ?>')"
                                       class="text-xs font-medium text-primary-600 dark:text-primary-400 hover:underline">
                                        <?php echo e(__('notifications.view')); ?>

                                    </a>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$notification->read_at): ?>
                                    <button wire:click="markAsRead('<?php echo e($notification->id); ?>')" 
                                            class="text-xs text-neutral-500 dark:text-neutral-400 hover:text-neutral-700 dark:hover:text-neutral-300 hover:underline">
                                        <?php echo e(__('notifications.mark_read')); ?>

                                    </button>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <button wire:click="deleteNotification('<?php echo e($notification->id); ?>')" 
                                        class="text-xs text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 hover:underline ml-auto">
                                    <?php echo e(__('notifications.delete')); ?>

                                </button>
                            </div>
                        </div>

                        <!-- Unread indicator -->
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$notification->read_at): ?>
                            <div class="flex-shrink-0 w-2 h-2 bg-primary-600 rounded-full"></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="p-12 text-center">
                    <div class="text-6xl mb-4">🔕</div>
                    <h3 class="text-lg font-semibold text-neutral-900 dark:text-white mb-2">
                        <?php echo e(__('notifications.no_notifications')); ?>

                    </h3>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">
                        <?php echo e(__('notifications.no_notifications_description')); ?>

                    </p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- Footer -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($notifications) > 0): ?>
            <div class="p-3 bg-neutral-50 dark:bg-neutral-900/50 border-t border-neutral-200 dark:border-neutral-700 text-center">
                <a href="#" class="text-sm text-primary-600 dark:text-primary-400 hover:underline font-medium">
                    <?php echo e(__('notifications.view_all')); ?>

                </a>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    </div>

</div>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
<script>
    // Listen for real-time notifications via Echo
    if (window.Echo) {
        window.Echo.private('App.Models.User.<?php echo e(Auth::id()); ?>')
            .notification((notification) => {
                console.log('🔔 Notification received via Echo:', notification);
                console.log('🔔 Notification type:', notification.type);
                console.log('🔔 Notification data:', notification.data);
                
                // Refresh Livewire component
                Livewire.dispatch('refresh-notifications');
                
                // Skip browser notification for chat messages (badge is enough)
                // Check multiple possible locations for the type
                const notifType = notification.type || notification.data?.type || '';
                const isChatMessage = notifType.includes('chat_new_message') || 
                                     notifType.includes('NewMessageNotification') ||
                                     notification.data?.type === 'chat_new_message';
                
                console.log('🔔 Is chat message?', isChatMessage);
                
                // Show browser notification if supported (but NOT for chat messages)
                if (!isChatMessage && 'Notification' in window && Notification.permission === 'granted') {
                    new Notification(notification.title || notification.data?.title || 'New notification', {
                        body: notification.message || notification.data?.message || '',
                        icon: '/assets/images/logo.png',
                    });
                }
            });
            
        console.log('✅ Echo listening on private channel: App.Models.User.<?php echo e(Auth::id()); ?>');
    }
</script>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/livewire/components/notification-center.blade.php ENDPATH**/ ?>