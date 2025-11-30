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
     <?php $__env->slot('title', null, []); ?> <?php echo e(__('terms.title')); ?> <?php $__env->endSlot(); ?>

    <div class="min-h-screen bg-white dark:bg-neutral-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <h1 class="text-4xl md:text-5xl font-bold text-neutral-900 dark:text-white mb-4" style="font-family: 'Crimson Pro', serif;">
                <?php echo e(__('terms.title')); ?>

            </h1>
            
            <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-8">
                <?php echo e(__('terms.version')); ?>

            </p>
            
            <div class="prose prose-lg dark:prose-invert max-w-none">
                <div class="text-neutral-700 dark:text-neutral-300 space-y-6">
                    <p class="text-lg font-medium">
                        <?php echo e(__('terms.intro')); ?>

                    </p>

                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4"><?php echo e(__('terms.about_document_title')); ?></h2>
                        <p><?php echo e(__('terms.about_document_p1')); ?></p>
                        <p><?php echo e(__('terms.about_document_p2')); ?></p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4"><?php echo e(__('terms.acceptance_title')); ?></h2>
                        <p><?php echo e(__('terms.acceptance_text')); ?></p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4"><?php echo e(__('terms.community_notice_title')); ?></h2>
                        <p><?php echo e(__('terms.community_notice_text')); ?></p>
                    </section>

                    <section>
                        <h2 class="text-3xl font-bold text-neutral-900 dark:text-white mt-12 mb-6"><?php echo e(__('terms.terms_title')); ?></h2>

                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3"><?php echo e(__('terms.1_title')); ?></h3>
                            <p><?php echo e(__('terms.1_text')); ?></p>
                        </article>

                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3"><?php echo e(__('terms.2_title')); ?></h3>
                            <p><?php echo e(__('terms.2_p1')); ?></p>
                            <p class="font-semibold"><?php echo e(__('terms.2_p2')); ?></p>
                        </article>

                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3"><?php echo e(__('terms.3_title')); ?></h3>
                            <p><?php echo e(__('terms.3_p1')); ?></p>
                            <p><?php echo e(__('terms.3_p2')); ?></p>
                        </article>

                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3"><?php echo e(__('terms.4_title')); ?></h3>
                            <p><?php echo e(__('terms.4_p1')); ?></p>
                            <p><?php echo e(__('terms.4_p2')); ?></p>
                            <p class="font-semibold text-red-600 dark:text-red-400"><?php echo e(__('terms.4_warning')); ?></p>
                        </article>

                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3"><?php echo e(__('terms.5_title')); ?></h3>
                            <p><?php echo e(__('terms.5_p1')); ?></p>
                            <p><?php echo e(__('terms.5_p2')); ?></p>
                        </article>

                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3"><?php echo e(__('terms.6_title')); ?></h3>
                            <p><?php echo e(__('terms.6_p1')); ?></p>
                            <p><?php echo e(__('terms.6_p2')); ?></p>
                        </article>

                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3"><?php echo e(__('terms.7_title')); ?></h3>
                            <p><?php echo e(__('terms.7_intro')); ?></p>
                            <ul class="list-disc pl-6 space-y-2 mt-3">
                                <li><?php echo e(__('terms.7_item1')); ?></li>
                                <li><?php echo e(__('terms.7_item2')); ?></li>
                                <li><?php echo e(__('terms.7_item3')); ?></li>
                                <li><?php echo e(__('terms.7_item4')); ?></li>
                                <li><?php echo e(__('terms.7_item5')); ?></li>
                                <li><?php echo e(__('terms.7_item6')); ?></li>
                                <li><?php echo e(__('terms.7_item7')); ?></li>
                            </ul>
                        </article>

                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3"><?php echo e(__('terms.8_title')); ?></h3>
                            <p><?php echo e(__('terms.8_p1')); ?></p>
                            <p><?php echo e(__('terms.8_p2')); ?></p>
                            <p><?php echo e(__('terms.8_p3')); ?></p>
                            <p><?php echo e(__('terms.8_p4')); ?></p>
                            <p><?php echo e(__('terms.8_p5')); ?></p>
                            <p><?php echo e(__('terms.8_p6')); ?></p>
                        </article>

                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3"><?php echo e(__('terms.9_title')); ?></h3>
                            <p><?php echo e(__('terms.9_text')); ?></p>
                        </article>

                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3"><?php echo e(__('terms.10_title')); ?></h3>
                            <p><?php echo e(__('terms.10_p1')); ?></p>
                            <p><?php echo e(__('terms.10_p2')); ?> <a href="<?php echo e(route('privacy')); ?>" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 font-semibold"><?php echo e(__('terms.10_privacy_link')); ?></a>.</p>
                        </article>

                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3"><?php echo e(__('terms.11_title')); ?></h3>
                            <p><?php echo e(__('terms.11_text')); ?></p>
                        </article>

                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3"><?php echo e(__('terms.12_title')); ?></h3>
                            <p><?php echo e(__('terms.12_intro')); ?></p>
                            <ul class="list-disc pl-6 space-y-2 mt-3">
                                <li><?php echo e(__('terms.12_item1')); ?></li>
                                <li><?php echo e(__('terms.12_item2')); ?></li>
                            </ul>
                            <p class="mt-3"><?php echo e(__('terms.12_outro')); ?></p>
                        </article>

                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3"><?php echo e(__('terms.13_title')); ?></h3>
                            <p><?php echo e(__('terms.13_p1')); ?></p>
                            <p><?php echo e(__('terms.13_p2')); ?></p>
                        </article>
                    </section>

                    <section class="mt-12">
                        <h2 class="text-3xl font-bold text-neutral-900 dark:text-white mb-6"><?php echo e(__('terms.guidelines_title')); ?></h2>
                        <p><?php echo e(__('terms.guidelines_intro_p1')); ?></p>
                        <p><?php echo e(__('terms.guidelines_intro_p2')); ?></p>
                        <p><?php echo e(__('terms.guidelines_intro_p3')); ?></p>
                        <p><?php echo e(__('terms.guidelines_intro_p4')); ?></p>

                        <article class="mb-8 mt-6">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3"><?php echo e(__('terms.guideline_1_title')); ?></h3>
                            <p><?php echo e(__('terms.guideline_1_p1')); ?></p>
                            <p><?php echo e(__('terms.guideline_1_p2')); ?></p>
                            <p><?php echo e(__('terms.guideline_1_p3')); ?></p>
                        </article>

                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3"><?php echo e(__('terms.guideline_2_title')); ?></h3>
                            <p><?php echo e(__('terms.guideline_2_text')); ?></p>
                        </article>

                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3"><?php echo e(__('terms.guideline_3_title')); ?></h3>
                            <p><?php echo e(__('terms.guideline_3_p1')); ?></p>
                            <p><?php echo e(__('terms.guideline_3_p2')); ?></p>
                        </article>

                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3"><?php echo e(__('terms.guideline_4_title')); ?></h3>
                            <p><?php echo e(__('terms.guideline_4_p1')); ?></p>
                            <p><?php echo e(__('terms.guideline_4_p2')); ?></p>
                            <p><?php echo e(__('terms.guideline_4_p3')); ?></p>
                            <p><?php echo e(__('terms.guideline_4_p4')); ?></p>
                            <p><?php echo e(__('terms.guideline_4_p5')); ?></p>
                            <p><?php echo e(__('terms.guideline_4_p6')); ?></p>
                        </article>
                    </section>

                    <section class="mt-12 pt-8 border-t border-neutral-200 dark:border-neutral-700">
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-4"><?php echo e(__('terms.changes_title')); ?></h2>
                        <p><?php echo e(__('terms.changes_text')); ?></p>
                    </section>

                    <div class="mt-12 pt-8 border-t border-neutral-200 dark:border-neutral-700 text-sm text-neutral-600 dark:text-neutral-400">
                        <p><?php echo e(__('terms.last_updated')); ?></p>
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
<?php /**PATH /Users/mazzi/slamin_v2/resources/views/pages/terms.blade.php ENDPATH**/ ?>