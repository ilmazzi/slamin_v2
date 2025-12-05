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


<div class="min-h-screen bg-neutral-50 dark:bg-neutral-950 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-8"><?php echo e(__('groups.my_invitations')); ?></h1>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $invitations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $invitation = $item['invitation'];
                $type = $item['type'];
            ?>
            <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-sm p-6 mb-4">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($type === 'group'): ?>
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-2"><?php echo e($invitation->group->name); ?></h3>
                            <p class="text-neutral-600 dark:text-neutral-400 mb-2">
                                Invitato da <strong><?php echo e($invitation->invitedBy->name); ?></strong>
                            </p>
                        <?php else: ?>
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-2">
                                <?php echo e($invitation->event->title); ?>

                            </h3>
                            <p class="text-neutral-600 dark:text-neutral-400 mb-2">
                                Invitato da <strong><?php echo e($invitation->inviter->name); ?></strong> come 
                                <strong>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invitation->role === 'performer'): ?>
                                        <?php echo e(__('events.invitation.role_performer')); ?>

                                    <?php elseif($invitation->role === 'organizer'): ?>
                                        <?php echo e(__('events.invitation.role_organizer')); ?>

                                    <?php elseif($invitation->role === 'audience'): ?>
                                        <?php echo e(__('events.invitation.role_audience')); ?>

                                    <?php else: ?>
                                        <?php echo e(__('events.invitation.role_participant')); ?>

                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </strong>
                            </p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <p class="text-sm text-neutral-500 dark:text-neutral-500"><?php echo e($invitation->created_at->diffForHumans()); ?></p>
                    </div>
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invitation->status === 'pending'): ?>
                        <div class="flex gap-2">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($type === 'group'): ?>
                                <form action="<?php echo e(route('group-invitations.accept', $invitation)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                        Accetta
                                    </button>
                                </form>
                                <form action="<?php echo e(route('group-invitations.decline', $invitation)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                        Rifiuta
                                    </button>
                                </form>
                            <?php else: ?>
                                <form action="<?php echo e(route('event-invitations.accept', $invitation)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                        <?php echo e(__('events.invitation.accept')); ?>

                                    </button>
                                </form>
                                <form action="<?php echo e(route('event-invitations.decline', $invitation)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                        <?php echo e(__('events.invitation.decline')); ?>

                                    </button>
                                </form>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php else: ?>
                        <span class="px-3 py-1 rounded-lg text-sm font-semibold
                            <?php echo e($invitation->status === 'accepted' ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : ''); ?>

                            <?php echo e($invitation->status === 'declined' ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' : ''); ?>">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invitation->status === 'accepted'): ?>
                                <?php echo e(__('events.invitation.accepted')); ?>

                            <?php elseif($invitation->status === 'declined'): ?>
                                <?php echo e(__('events.invitation.declined')); ?>

                            <?php else: ?>
                                <?php echo e(ucfirst($invitation->status)); ?>

                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center py-12 bg-white dark:bg-neutral-900 rounded-2xl">
                <p class="text-neutral-500 dark:text-neutral-400">Nessun invito ricevuto</p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div class="mt-6">
            <?php echo e($invitations->links()); ?>

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

<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/groups/invitations/index.blade.php ENDPATH**/ ?>