<div class="chat-conversations">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $conversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conversation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div wire:click="$dispatch('conversationSelected', { conversationId: <?php echo e($conversation->id); ?> })" 
             class="chat-conversation-item <?php echo e($selectedConversation && $selectedConversation->id === $conversation->id ? 'active' : ''); ?>">
            
            <!-- Avatar -->
            <?php
                $name = $conversation->getDisplayName(auth()->user());
                // Per conversazioni private, ottieni l'altro utente
                if ($conversation->type === 'private') {
                    $otherUser = $conversation->users->where('id', '!=', auth()->id())->first();
                    $avatar = $otherUser ? \App\Helpers\AvatarHelper::getUserAvatarUrl($otherUser, 80) : null;
                } else {
                    // Per gruppi, usa avatar del gruppo o default
                    $avatar = $conversation->avatar;
                }
            ?>
            
            <img src="<?php echo e($avatar); ?>" alt="<?php echo e($name); ?>" class="chat-avatar">
            
            <!-- Info -->
            <div class="chat-conversation-info">
                <div class="chat-conversation-header">
                    <span class="chat-conversation-name"><?php echo e($name); ?></span>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($conversation->latestMessage): ?>
                        <span class="chat-conversation-time">
                            <?php echo e($conversation->latestMessage->created_at->diffForHumans()); ?>

                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($conversation->latestMessage): ?>
                    <p class="chat-conversation-preview">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($conversation->latestMessage->user_id === auth()->id()): ?>
                            <span class="font-medium"><?php echo e(__('chat.you')); ?>:</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php echo e(Str::limit($conversation->latestMessage->body, 50)); ?>

                    </p>
                <?php else: ?>
                    <p class="chat-conversation-preview"><?php echo e(__('chat.no_messages')); ?></p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            
            <!-- Unread Badge -->
            <?php
                $unread = $conversation->unreadCount(auth()->user());
            ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($unread > 0): ?>
                <span class="chat-unread-badge"><?php echo e($unread > 99 ? '99+' : $unread); ?></span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="p-8 text-center text-neutral-500 dark:text-neutral-400">
            <p><?php echo e(__('chat.no_conversations')); ?></p>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH /Users/mazzi/slamin_v2/resources/views/livewire/chat/chat-list.blade.php ENDPATH**/ ?>