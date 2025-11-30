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
     <?php $__env->slot('title', null, []); ?> <?php echo e(__('about.title')); ?> <?php $__env->endSlot(); ?>

    <div class="min-h-screen bg-gradient-to-br from-neutral-50 via-primary-50/30 to-accent-50/20 dark:from-neutral-900 dark:via-primary-950/50 dark:to-accent-950/30">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 md:pt-12 pb-16 md:pb-24">
            
            <!-- Header -->
            <div class="text-center mb-12 md:mb-16">
                <h1 class="text-4xl md:text-6xl font-bold text-neutral-900 dark:text-white mb-4" style="font-family: 'Crimson Pro', serif;">
                    <?php echo e(__('about.title')); ?>

                </h1>
                <p class="text-xl md:text-2xl text-neutral-600 dark:text-neutral-300 max-w-3xl mx-auto">
                    <?php echo e(__('about.subtitle')); ?>

                </p>
            </div>

            <!-- Main Content -->
            <div class="space-y-16">
                
                <!-- Slam In Section -->
                <div class="bg-white/80 dark:bg-neutral-800/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-neutral-200 dark:border-neutral-700 p-8 md:p-12">
                    <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
                        <!-- Logo Slam In -->
                        <div class="flex-shrink-0">
                            <img src="<?php echo e(asset('assets/images/Logo_orizzontale_nerosubianco.png')); ?>" 
                                 alt="Slam In Logo" 
                                 class="h-20 md:h-24 w-auto dark:invert">
                        </div>
                        
                        <!-- Content -->
                        <div class="flex-1 text-center md:text-left">
                            <h2 class="text-2xl md:text-3xl font-bold text-neutral-900 dark:text-white mb-4">
                                <?php echo e(__('about.slam_in.title')); ?>

                            </h2>
                            <div class="prose prose-lg dark:prose-invert max-w-none text-neutral-700 dark:text-neutral-300">
                                <p class="mb-4">
                                    <?php echo e(__('about.slam_in.description')); ?>

                                </p>
                                <p>
                                    <?php echo e(__('about.slam_in.contact')); ?>

                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hævol Section -->
                <div class="bg-white/80 dark:bg-neutral-800/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-neutral-200 dark:border-neutral-700 p-8 md:p-12">
                    <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
                        <!-- Logo Hævol -->
                        <div class="flex-shrink-0 flex items-center justify-center">
                            <img src="<?php echo e(asset('assets/images/haevol-logo.svg')); ?>" 
                                 alt="Hævol Logo" 
                                 class="h-20 md:h-24 w-auto">
                        </div>
                        
                        <!-- Content -->
                        <div class="flex-1 text-center md:text-left">
                            <h2 class="text-2xl md:text-3xl font-bold text-neutral-900 dark:text-white mb-4">
                                <?php echo e(__('about.haevol.title')); ?>

                            </h2>
                            <div class="prose prose-lg dark:prose-invert max-w-none text-neutral-700 dark:text-neutral-300">
                                <p>
                                    <?php echo e(__('about.haevol.description')); ?>

                                </p>
                            </div>
                        </div>
                    </div>
                </div>

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
<?php /**PATH /Users/mazzi/slamin_v2/resources/views/pages/about.blade.php ENDPATH**/ ?>