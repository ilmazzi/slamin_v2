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
     <?php $__env->slot('title', null, []); ?> <?php echo e(__('account_deletion.page_title')); ?> <?php $__env->endSlot(); ?>

    <div class="min-h-screen bg-neutral-50 dark:bg-neutral-950 py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Warning Header -->
            <div class="bg-red-50 dark:bg-red-900/20 border-2 border-red-200 dark:border-red-800 rounded-xl p-6 mb-8">
                <div class="flex items-start gap-4">
                    <div class="text-4xl">⚠️</div>
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold text-red-900 dark:text-red-100 mb-2">
                            <?php echo e(__('account_deletion.warning_title')); ?>

                        </h1>
                        <p class="text-red-800 dark:text-red-200 leading-relaxed">
                            <?php echo e(__('account_deletion.warning_subtitle')); ?>

                        </p>
                    </div>
                </div>
            </div>

            <!-- Main Card -->
            <div class="bg-white dark:bg-neutral-900 rounded-xl shadow-lg border border-neutral-200 dark:border-neutral-800 overflow-hidden">
                
                <!-- What will happen -->
                <div class="p-6 md:p-8 border-b border-neutral-200 dark:border-neutral-800">
                    <h2 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">
                        <?php echo e(__('account_deletion.what_happens_title')); ?>

                    </h2>
                    
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <span class="text-xl">🔒</span>
                            <p class="text-neutral-700 dark:text-neutral-300">
                                <?php echo e(__('account_deletion.what_happens_1')); ?>

                            </p>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <span class="text-xl">📝</span>
                            <p class="text-neutral-700 dark:text-neutral-300">
                                <?php echo e(__('account_deletion.what_happens_2')); ?>

                            </p>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <span class="text-xl">💬</span>
                            <p class="text-neutral-700 dark:text-neutral-300">
                                <?php echo e(__('account_deletion.what_happens_3')); ?>

                            </p>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <span class="text-xl">⏰</span>
                            <p class="text-neutral-700 dark:text-neutral-300">
                                <?php echo e(__('account_deletion.what_happens_4')); ?>

                            </p>
                        </div>
                    </div>
                </div>

                <!-- Deletion Form -->
                <form wire:submit.prevent="deleteAccount" class="p-6 md:p-8 space-y-6">
                    
                    <!-- Reason (Optional) -->
                    <div>
                        <label for="reason" class="block text-sm font-semibold text-neutral-900 dark:text-white mb-2">
                            <?php echo e(__('account_deletion.reason_label')); ?>

                            <span class="text-neutral-500 dark:text-neutral-400 font-normal">
                                (<?php echo e(__('account_deletion.optional')); ?>)
                            </span>
                        </label>
                        <textarea 
                            wire:model="reason" 
                            id="reason"
                            rows="4"
                            class="w-full px-4 py-3 bg-neutral-50 dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-700 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-neutral-900 dark:text-white"
                            placeholder="<?php echo e(__('account_deletion.reason_placeholder')); ?>"
                        ></textarea>
                        <p class="mt-2 text-sm text-neutral-600 dark:text-neutral-400">
                            <?php echo e(__('account_deletion.reason_help')); ?>

                        </p>
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-neutral-900 dark:text-white mb-2">
                            <?php echo e(__('account_deletion.password_label')); ?> *
                        </label>
                        <input 
                            type="password" 
                            wire:model="password" 
                            id="password"
                            class="w-full px-4 py-3 bg-neutral-50 dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-700 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-neutral-900 dark:text-white"
                            placeholder="<?php echo e(__('account_deletion.password_placeholder')); ?>"
                        >
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <!-- Confirmation Text -->
                    <div>
                        <label for="confirmText" class="block text-sm font-semibold text-neutral-900 dark:text-white mb-2">
                            <?php echo e(__('account_deletion.confirm_label')); ?> *
                        </label>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-3">
                            <?php echo __('account_deletion.confirm_help'); ?>

                        </p>
                        <input 
                            type="text" 
                            wire:model="confirmText" 
                            id="confirmText"
                            class="w-full px-4 py-3 bg-neutral-50 dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-700 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-neutral-900 dark:text-white font-mono text-lg"
                            placeholder="ELIMINA"
                        >
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['confirmText'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-4">
                        <a 
                            href="<?php echo e(route('profile.settings')); ?>" 
                            class="flex-1 px-6 py-3 text-center bg-neutral-200 dark:bg-neutral-800 hover:bg-neutral-300 dark:hover:bg-neutral-700 text-neutral-900 dark:text-white font-semibold rounded-lg transition-colors"
                        >
                            <?php echo e(__('account_deletion.cancel')); ?>

                        </a>
                        
                        <button 
                            type="submit"
                            class="flex-1 px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors shadow-lg"
                        >
                            <?php echo e(__('account_deletion.delete_button')); ?>

                        </button>
                    </div>

                    <p class="text-xs text-neutral-500 dark:text-neutral-400 text-center">
                        <?php echo e(__('account_deletion.gdpr_note')); ?>

                    </p>
                </form>
            </div>

            <!-- Additional Info -->
            <div class="mt-6 text-center">
                <p class="text-sm text-neutral-600 dark:text-neutral-400">
                    <?php echo e(__('account_deletion.need_help')); ?>

                    <a href="mailto:mail@slamin.it" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 font-semibold">
                        mail@slamin.it
                    </a>
                </p>
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
<?php /**PATH /Users/mazzi/slamin_v2/resources/views/livewire/profile/delete-account.blade.php ENDPATH**/ ?>