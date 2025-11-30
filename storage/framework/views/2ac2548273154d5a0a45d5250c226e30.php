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
     <?php $__env->slot('title', null, []); ?> <?php echo e(__('cookies.policy_title')); ?> <?php $__env->endSlot(); ?>

    <div class="min-h-screen bg-white dark:bg-neutral-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <h1 class="text-4xl md:text-5xl font-bold text-neutral-900 dark:text-white mb-4" style="font-family: 'Crimson Pro', serif;">
                <?php echo e(__('cookies.policy_title')); ?>

            </h1>
            
            <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-8">
                <?php echo e(__('cookies.policy_version')); ?>

            </p>
            
            <div class="prose prose-lg dark:prose-invert max-w-none">
                <div class="text-neutral-700 dark:text-neutral-300 space-y-6">
                    
                    <!-- What are cookies -->
                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4"><?php echo e(__('cookies.what_are_cookies_title')); ?></h2>
                        <p><?php echo e(__('cookies.what_are_cookies_text')); ?></p>
                    </section>

                    <!-- How we use cookies -->
                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4"><?php echo e(__('cookies.how_we_use_title')); ?></h2>
                        <p><?php echo e(__('cookies.how_we_use_text')); ?></p>
                    </section>

                    <!-- Types of cookies -->
                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4"><?php echo e(__('cookies.types_title')); ?></h2>

                        <!-- Necessary cookies -->
                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3 flex items-center gap-2">
                                <span class="text-2xl">🔒</span>
                                <?php echo e(__('cookies.necessary_cookies_title')); ?>

                            </h3>
                            <p><?php echo e(__('cookies.necessary_cookies_text')); ?></p>
                            <p class="mt-2 text-sm italic text-neutral-600 dark:text-neutral-400">
                                <?php echo e(__('cookies.necessary_cookies_examples')); ?>

                            </p>
                        </article>

                        <!-- Analytics cookies -->
                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3 flex items-center gap-2">
                                <span class="text-2xl">📊</span>
                                <?php echo e(__('cookies.analytics_cookies_title')); ?>

                            </h3>
                            <p><?php echo e(__('cookies.analytics_cookies_text')); ?></p>
                            <p class="mt-2 text-sm italic text-neutral-600 dark:text-neutral-400">
                                <?php echo e(__('cookies.analytics_cookies_examples')); ?>

                            </p>
                        </article>

                        <!-- Marketing cookies -->
                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3 flex items-center gap-2">
                                <span class="text-2xl">🎯</span>
                                <?php echo e(__('cookies.marketing_cookies_title')); ?>

                            </h3>
                            <p><?php echo e(__('cookies.marketing_cookies_text')); ?></p>
                            <p class="mt-2 text-sm italic text-neutral-600 dark:text-neutral-400">
                                <?php echo e(__('cookies.marketing_cookies_examples')); ?>

                            </p>
                        </article>
                    </section>

                    <!-- Managing preferences -->
                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4"><?php echo e(__('cookies.manage_title')); ?></h2>
                        <p><?php echo e(__('cookies.manage_text')); ?></p>
                        
                        <div class="mt-4">
                            <button 
                                onclick="localStorage.removeItem('cookie_consent'); location.reload();"
                                class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg transition-colors shadow-lg">
                                🍪 <?php echo e(__('cookies.customize')); ?>

                            </button>
                        </div>
                    </section>

                    <!-- Browser settings -->
                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4"><?php echo e(__('cookies.browser_settings_title')); ?></h2>
                        <p><?php echo e(__('cookies.browser_settings_text')); ?></p>
                    </section>

                    <!-- More information -->
                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4"><?php echo e(__('cookies.more_info_title')); ?></h2>
                        <p>
                            <?php echo e(__('cookies.more_info_text')); ?>

                            <a href="<?php echo e(route('privacy')); ?>" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 font-semibold">
                                <?php echo e(__('cookies.more_info_link')); ?>

                            </a>.
                        </p>
                    </section>

                    <!-- Contact -->
                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4"><?php echo e(__('cookies.contact_title')); ?></h2>
                        <p>
                            <?php echo e(__('cookies.contact_text')); ?>

                            <a href="mailto:mail@slamin.it" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 font-semibold">
                                mail@slamin.it
                            </a>.
                        </p>
                    </section>

                    <!-- Last updated -->
                    <div class="mt-12 pt-8 border-t border-neutral-200 dark:border-neutral-700 text-sm text-neutral-600 dark:text-neutral-400">
                        <p><?php echo e(__('cookies.last_updated')); ?></p>
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

<?php /**PATH /Users/mazzi/slamin_v2/resources/views/pages/cookies.blade.php ENDPATH**/ ?>