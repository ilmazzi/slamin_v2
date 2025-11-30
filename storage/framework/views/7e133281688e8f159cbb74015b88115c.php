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
     <?php $__env->slot('title', null, []); ?> <?php echo e(__('privacy.title')); ?> <?php $__env->endSlot(); ?>

    <div class="min-h-screen bg-white dark:bg-neutral-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <h1 class="text-4xl md:text-5xl font-bold text-neutral-900 dark:text-white mb-4" style="font-family: 'Crimson Pro', serif;">
                <?php echo e(__('privacy.title')); ?>

            </h1>
            
            <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-8">
                <?php echo e(__('privacy.version')); ?>

            </p>
            
            <div class="prose prose-lg dark:prose-invert max-w-none">
                <div class="text-neutral-700 dark:text-neutral-300 space-y-6">
                    
                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4"><?php echo e(__('privacy.about_title')); ?></h2>
                        <p><?php echo e(__('privacy.about_p1')); ?></p>
                        <p><?php echo e(__('privacy.about_p2')); ?></p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4"><?php echo e(__('privacy.definitions_title')); ?></h2>
                        <dl class="space-y-4">
                            <div>
                                <dt class="font-semibold text-neutral-900 dark:text-white"><?php echo e(__('privacy.def_gdpr')); ?></dt>
                                <dd class="mt-1"><?php echo e(__('privacy.def_gdpr_text')); ?></dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-neutral-900 dark:text-white"><?php echo e(__('privacy.def_data')); ?></dt>
                                <dd class="mt-1"><?php echo e(__('privacy.def_data_text')); ?></dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-neutral-900 dark:text-white"><?php echo e(__('privacy.def_services')); ?></dt>
                                <dd class="mt-1"><?php echo e(__('privacy.def_services_text')); ?></dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-neutral-900 dark:text-white"><?php echo e(__('privacy.def_user')); ?></dt>
                                <dd class="mt-1"><?php echo e(__('privacy.def_user_text')); ?></dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-neutral-900 dark:text-white"><?php echo e(__('privacy.def_slamin')); ?></dt>
                                <dd class="mt-1"><?php echo e(__('privacy.def_slamin_text')); ?></dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-neutral-900 dark:text-white"><?php echo e(__('privacy.def_platform')); ?></dt>
                                <dd class="mt-1"><?php echo e(__('privacy.def_platform_text')); ?></dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-neutral-900 dark:text-white"><?php echo e(__('privacy.def_credentials')); ?></dt>
                                <dd class="mt-1"><?php echo e(__('privacy.def_credentials_text')); ?></dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-neutral-900 dark:text-white"><?php echo e(__('privacy.def_attacks')); ?></dt>
                                <dd class="mt-1"><?php echo e(__('privacy.def_attacks_text')); ?></dd>
                            </div>
                        </dl>
                    </section>

                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4"><?php echo e(__('privacy.protected_title')); ?></h2>
                        <p><?php echo e(__('privacy.protected_p1')); ?></p>
                        <p><?php echo e(__('privacy.protected_p2')); ?> <strong><?php echo e(__('privacy.protected_p2_link')); ?></strong><?php echo e(__('privacy.protected_p2_end')); ?></p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4"><?php echo e(__('privacy.1_title')); ?></h2>
                        <p><?php echo e(__('privacy.1_intro')); ?></p>
                        <ul class="list-disc pl-6 space-y-2 mt-3">
                            <li><strong><?php echo e(__('privacy.1_email')); ?></strong> <?php echo e(__('privacy.1_email_text')); ?></li>
                            <li><strong><?php echo e(__('privacy.1_password')); ?></strong> <?php echo e(__('privacy.1_password_text')); ?></li>
                        </ul>
                        <p class="mt-4"><?php echo e(__('privacy.1_outro')); ?></p>

                        <h3 class="text-xl font-bold text-neutral-900 dark:text-white mt-6 mb-3"><?php echo e(__('privacy.1_1_title')); ?></h3>
                        <p><?php echo e(__('privacy.1_1_p1')); ?></p>
                        <p><?php echo e(__('privacy.1_1_p2')); ?></p>

                        <h3 class="text-xl font-bold text-neutral-900 dark:text-white mt-6 mb-3"><?php echo e(__('privacy.1_2_title')); ?></h3>
                        <p><?php echo e(__('privacy.1_2_intro')); ?></p>
                        <ul class="list-disc pl-6 space-y-2 mt-3">
                            <li><?php echo e(__('privacy.1_2_item1')); ?></li>
                            <li><?php echo e(__('privacy.1_2_item2')); ?></li>
                            <li><?php echo e(__('privacy.1_2_item3')); ?></li>
                        </ul>

                        <h3 class="text-xl font-bold text-neutral-900 dark:text-white mt-6 mb-3"><?php echo e(__('privacy.1_3_title')); ?></h3>
                        <p><?php echo e(__('privacy.1_3_text')); ?></p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4"><?php echo e(__('privacy.2_title')); ?></h2>
                        <ul class="list-disc pl-6 space-y-2">
                            <li><strong>NON</strong> <?php echo e(__('privacy.2_item1')); ?></li>
                            <li><strong>NON</strong> <?php echo e(__('privacy.2_item2')); ?> <strong>NON</strong> <?php echo e(__('privacy.2_item2_b')); ?> <strong>NON</strong> <?php echo e(__('privacy.2_item2_c')); ?> <strong>NON</strong> <?php echo e(__('privacy.2_item2_d')); ?></li>
                            <li><strong>NON</strong> <?php echo e(__('privacy.2_item3')); ?></li>
                            <li><strong>NON</strong> <?php echo e(__('privacy.2_item4')); ?></li>
                            <li><strong>NON</strong> <?php echo e(__('privacy.2_item5')); ?></li>
                            <li><strong>NON</strong> <?php echo e(__('privacy.2_item6')); ?> <a href="<?php echo e(route('terms')); ?>" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 font-semibold"><?php echo e(__('privacy.2_item6_link')); ?></a><?php echo e(__('privacy.2_item6_end')); ?></li>
                        </ul>
                    </section>

                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4"><?php echo e(__('privacy.3_title')); ?></h2>
                        <p><?php echo e(__('privacy.3_text')); ?></p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4"><?php echo e(__('privacy.4_title')); ?></h2>
                        <p><?php echo e(__('privacy.4_intro')); ?></p>
                        <ul class="list-disc pl-6 space-y-2 mt-3">
                            <li><strong><?php echo e(__('privacy.4_access')); ?></strong> <?php echo e(__('privacy.4_access_text')); ?></li>
                            <li><strong><?php echo e(__('privacy.4_rectification')); ?></strong> <?php echo e(__('privacy.4_rectification_text')); ?></li>
                            <li><strong><?php echo e(__('privacy.4_erasure')); ?></strong> <?php echo e(__('privacy.4_erasure_text')); ?></li>
                            <li><strong><?php echo e(__('privacy.4_restriction')); ?></strong> <?php echo e(__('privacy.4_restriction_text')); ?></li>
                            <li><strong><?php echo e(__('privacy.4_portability')); ?></strong> <?php echo e(__('privacy.4_portability_text')); ?></li>
                            <li><strong><?php echo e(__('privacy.4_objection')); ?></strong> <?php echo e(__('privacy.4_objection_text')); ?></li>
                        </ul>
                        <p class="mt-4 text-sm italic"><?php echo e(__('privacy.4_note')); ?></p>
                        <p class="mt-4"><?php echo e(__('privacy.4_contact')); ?> <a href="mailto:mail@slamin.it" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 font-semibold">mail@slamin.it</a></p>
                        <p class="mt-4"><?php echo e(__('privacy.4_gdpr')); ?></p>
                        
                        <div class="mt-6 p-4 bg-neutral-100 dark:bg-neutral-800 rounded-lg">
                            <p class="font-semibold"><?php echo e(__('privacy.4_company')); ?></p>
                            <p class="text-sm"><?php echo e(__('privacy.4_vat')); ?></p>
                        </div>

                        <h3 class="text-xl font-bold text-neutral-900 dark:text-white mt-6 mb-3"><?php echo e(__('privacy.4_1_title')); ?></h3>
                        <p><?php echo e(__('privacy.4_1_p1')); ?></p>
                        <p class="mt-2"><?php echo e(__('privacy.4_1_p2')); ?> <strong><?php echo e(__('privacy.4_1_p2_link')); ?></strong><?php echo e(__('privacy.4_1_p2_end')); ?></p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4"><?php echo e(__('privacy.5_title')); ?></h2>
                        <p><?php echo e(__('privacy.5_p1')); ?></p>
                        <p><?php echo e(__('privacy.5_p2')); ?></p>
                    </section>

                    <div class="mt-12 pt-8 border-t border-neutral-200 dark:border-neutral-700 text-sm text-neutral-600 dark:text-neutral-400">
                        <p><?php echo e(__('privacy.last_updated')); ?></p>
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
<?php /**PATH /Users/mazzi/slamin_v2/resources/views/pages/privacy.blade.php ENDPATH**/ ?>