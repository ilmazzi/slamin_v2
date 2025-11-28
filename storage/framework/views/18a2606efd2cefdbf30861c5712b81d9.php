<div class="min-h-screen bg-neutral-50 dark:bg-neutral-950">
    <!-- Navigation Header -->
    <?php if (isset($component)) { $__componentOriginalf3d89a6becff7fafd48b3236eb38787d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf3d89a6becff7fafd48b3236eb38787d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.navigation-modern','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.navigation-modern'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf3d89a6becff7fafd48b3236eb38787d)): ?>
<?php $attributes = $__attributesOriginalf3d89a6becff7fafd48b3236eb38787d; ?>
<?php unset($__attributesOriginalf3d89a6becff7fafd48b3236eb38787d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf3d89a6becff7fafd48b3236eb38787d)): ?>
<?php $component = $__componentOriginalf3d89a6becff7fafd48b3236eb38787d; ?>
<?php unset($__componentOriginalf3d89a6becff7fafd48b3236eb38787d); ?>
<?php endif; ?>
    
    <!-- Main Content -->
    <div class="pt-16 md:pt-20">
        <div class="min-h-[calc(100vh-4rem)] md:min-h-[calc(100vh-5rem)] flex flex-col lg:flex-row max-w-7xl mx-auto">
            <!-- Left Side - Form -->
            <div class="flex-1 flex items-center justify-center px-4 py-6 sm:px-6 lg:px-8 bg-white dark:bg-neutral-900 lg:min-h-[calc(100vh-5rem)] overflow-x-hidden">
                <div class="max-w-md w-full mx-auto space-y-6 sm:space-y-8">
                    <!-- Logo -->
                    <div class="text-center">
                        <img src="<?php echo e(asset('assets/images/Logo_orizzontale_nerosubianco.png')); ?>" 
                             alt="<?php echo e(config('app.name')); ?>" 
                             class="h-12 mx-auto mb-8">
                        
                        <h2 class="text-4xl font-bold text-neutral-900 dark:text-white mb-2" style="font-family: 'Crimson Pro', serif;">
                            <?php echo e(__('auth.forgot_password')); ?>

                        </h2>
                        <p class="text-neutral-600 dark:text-neutral-400">
                            <?php echo e(__('auth.forgot_password_description')); ?>

                        </p>
                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($status === 'sent'): ?>
                        <!-- Success Message -->
                        <div class="bg-green-50 dark:bg-green-900/20 border-2 border-green-200 dark:border-green-800 rounded-xl p-6">
                            <div class="flex items-start gap-3">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <div>
                                    <h3 class="text-lg font-semibold text-green-900 dark:text-green-100 mb-1">
                                        <?php echo e(__('auth.reset_link_sent')); ?>

                                    </h3>
                                    <p class="text-sm text-green-700 dark:text-green-300">
                                        <?php echo e(__('auth.reset_link_sent_description', ['email' => $email])); ?>

                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Back to Login -->
                        <div class="text-center">
                            <a href="<?php echo e(route('login')); ?>" class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700 font-semibold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                <?php echo e(__('auth.back_to_login')); ?>

                            </a>
                        </div>
                    <?php else: ?>
                        <!-- Forgot Password Form -->
                        <form wire:submit="sendResetLink" class="mt-8 space-y-6">
                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                                    <?php echo e(__('login.email')); ?>

                                </label>
                                <input id="email" 
                                       wire:model="email"
                                       type="email" 
                                       required 
                                       autocomplete="email"
                                       placeholder="<?php echo e(__('login.email_placeholder')); ?>"
                                       class="w-full px-4 py-3 border-2 border-neutral-200 dark:border-neutral-700 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:bg-neutral-800 dark:text-white transition-all">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
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

                            <!-- Submit Button -->
                            <button type="submit" class="w-full px-4 py-3 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-xl transition-colors">
                                <?php echo e(__('auth.send_reset_link')); ?>

                            </button>

                            <!-- Back to Login -->
                            <div class="text-center">
                                <a href="<?php echo e(route('login')); ?>" class="inline-flex items-center gap-2 text-sm text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                    <?php echo e(__('auth.back_to_login')); ?>

                                </a>
                            </div>
                        </form>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <!-- Right Side - Features (Hidden on Mobile) -->
            <div class="hidden lg:flex flex-1 bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800 items-center justify-center p-6 xl:p-8 relative overflow-hidden">
                <!-- Animated Background -->
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute w-96 h-96 bg-white rounded-full blur-3xl -top-48 -left-48 animate-pulse"></div>
                    <div class="absolute w-96 h-96 bg-white rounded-full blur-3xl -bottom-48 -right-48 animate-pulse" style="animation-delay: 1s;"></div>
                </div>

                <div class="max-w-lg relative z-10 text-white">
                    <h3 class="text-4xl font-bold mb-4" style="font-family: 'Crimson Pro', serif;">
                        <?php echo e(__('auth.password_reset_help_title')); ?>

                    </h3>
                    <p class="text-lg mb-8 text-white/90">
                        <?php echo e(__('auth.password_reset_help_description')); ?>

                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <?php if (isset($component)) { $__componentOriginal7f75b765bca1e533f9d8c8fa950f02fb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7f75b765bca1e533f9d8c8fa950f02fb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.footer-modern','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.footer-modern'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7f75b765bca1e533f9d8c8fa950f02fb)): ?>
<?php $attributes = $__attributesOriginal7f75b765bca1e533f9d8c8fa950f02fb; ?>
<?php unset($__attributesOriginal7f75b765bca1e533f9d8c8fa950f02fb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7f75b765bca1e533f9d8c8fa950f02fb)): ?>
<?php $component = $__componentOriginal7f75b765bca1e533f9d8c8fa950f02fb; ?>
<?php unset($__componentOriginal7f75b765bca1e533f9d8c8fa950f02fb); ?>
<?php endif; ?>
</div>

<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/livewire/auth/forgot-password.blade.php ENDPATH**/ ?>