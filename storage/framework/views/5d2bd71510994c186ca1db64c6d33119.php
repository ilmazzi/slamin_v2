<footer class="bg-neutral-900 dark:bg-black text-neutral-300 pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        <!-- Main Footer Content -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 md:gap-12 mb-12">
            <!-- Brand -->
            <div>
                <a href="<?php echo e(route('home')); ?>" class="flex items-center mb-4 group">
                    <img src="<?php echo e(asset('assets/images/Logo_orizzontale_bianco.png')); ?>" 
                         alt="<?php echo e(config('app.name')); ?>" 
                         class="h-10 w-auto group-hover:scale-105 transition-transform">
                </a>
                <p class="text-sm text-neutral-400 leading-relaxed">
                    <?php echo e(__('footer.description')); ?>

                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-white font-bold mb-4"><?php echo e(__('footer.discover')); ?></h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="<?php echo e(route('events.index')); ?>" class="hover:text-primary-400 transition-colors"><?php echo e(__('footer.events')); ?></a></li>
                    <li><a href="<?php echo e(route('poems.index')); ?>" class="hover:text-primary-400 transition-colors"><?php echo e(__('footer.poems')); ?></a></li>
                    <li><a href="<?php echo e(route('articles.index')); ?>" class="hover:text-primary-400 transition-colors"><?php echo e(__('footer.articles')); ?></a></li>
                    <li><a href="<?php echo e(route('media.index')); ?>" class="hover:text-primary-400 transition-colors"><?php echo e(__('footer.media')); ?></a></li>
                </ul>
            </div>

            <!-- Community -->
            <div>
                <h3 class="text-white font-bold mb-4"><?php echo e(__('footer.community')); ?></h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="<?php echo e(route('faq')); ?>" class="hover:text-primary-400 transition-colors"><?php echo e(__('footer.faq')); ?></a></li>
                    <li><a href="<?php echo e(route('help')); ?>" class="hover:text-primary-400 transition-colors"><?php echo e(__('footer.help')); ?></a></li>
                    <li><a href="<?php echo e(route('support')); ?>" class="hover:text-primary-400 transition-colors"><?php echo e(__('footer.support')); ?></a></li>
                    <li><a href="<?php echo e(route('contact')); ?>" class="hover:text-primary-400 transition-colors"><?php echo e(__('footer.contact')); ?></a></li>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <li>
                        <button onclick="Livewire.dispatch('openTutorial')" 
                                class="hover:text-primary-400 transition-colors flex items-center gap-2 text-left">
                            <span>📚</span>
                            <span><?php echo e(__('footer.tutorial')); ?></span>
                        </button>
                    </li>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </ul>
            </div>

            <!-- Info -->
            <div>
                <h3 class="text-white font-bold mb-4"><?php echo e(__('footer.info') ?? 'Info'); ?></h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="<?php echo e(route('about')); ?>" class="hover:text-primary-400 transition-colors"><?php echo e(__('footer.about') ?? 'Chi siamo'); ?></a></li>
                    <li><a href="<?php echo e(route('terms')); ?>" class="hover:text-primary-400 transition-colors"><?php echo e(__('footer.terms') ?? 'Termini di servizio'); ?></a></li>
                    <li><a href="<?php echo e(route('privacy')); ?>" class="hover:text-primary-400 transition-colors"><?php echo e(__('footer.privacy') ?? 'Informativa privacy'); ?></a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div>
                <h3 class="text-white font-bold mb-4"><?php echo e(__('footer.newsletter') ?? 'Newsletter'); ?></h3>
                <p class="text-sm text-neutral-400 mb-4">
                    <?php echo e(__('footer.newsletter_description') ?? 'Resta aggiornato con le ultime novità'); ?>

                </p>
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('components.newsletter-subscribe', []);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-2211667594-0', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            </div>
        </div>

        <!-- Quick Info Links (visible on all layouts) -->
        <div class="mb-8 flex items-center flex-wrap gap-4 text-sm">
            <a href="<?php echo e(route('about')); ?>" class="text-neutral-300 hover:text-primary-300 transition-colors"><?php echo e(__('footer.about') ?? 'Chi siamo'); ?></a>
            <span class="text-neutral-500">•</span>
            <a href="<?php echo e(route('terms')); ?>" class="text-neutral-300 hover:text-primary-300 transition-colors"><?php echo e(__('footer.terms') ?? 'Termini di servizio'); ?></a>
            <span class="text-neutral-500">•</span>
            <a href="<?php echo e(route('privacy')); ?>" class="text-neutral-300 hover:text-primary-300 transition-colors"><?php echo e(__('footer.privacy') ?? 'Informativa privacy'); ?></a>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-neutral-800 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center flex-wrap gap-3 text-sm text-neutral-500">
                <span>Everything by everyone on this site is licensed under</span>
                <a href="https://creativecommons.org/licenses/by-nc-sa/4.0/" class="text-primary-400 hover:text-primary-300 transition-colors" target="_blank" rel="noopener noreferrer">CC BY-NC-SA 4.0</a>
                <span class="inline-flex items-center gap-1 ml-1">
                    <img src="https://mirrors.creativecommons.org/presskit/icons/cc.svg" alt="CC" class="w-4 h-4 inline-block">
                    <img src="https://mirrors.creativecommons.org/presskit/icons/by.svg" alt="BY" class="w-4 h-4 inline-block">
                    <img src="https://mirrors.creativecommons.org/presskit/icons/nc.svg" alt="NC" class="w-4 h-4 inline-block">
                    <img src="https://mirrors.creativecommons.org/presskit/icons/sa.svg" alt="SA" class="w-4 h-4 inline-block">
                </span>
            </div>
            <div class="flex items-center flex-wrap gap-6 text-sm">
                <a href="<?php echo e(route('about')); ?>" class="text-neutral-400 hover:text-primary-400 transition-colors"><?php echo e(__('footer.about') ?? 'Chi siamo'); ?></a>
                <a href="<?php echo e(route('terms')); ?>" class="text-neutral-400 hover:text-primary-400 transition-colors"><?php echo e(__('footer.terms') ?? 'Termini di servizio'); ?></a>
                <a href="<?php echo e(route('privacy')); ?>" class="text-neutral-400 hover:text-primary-400 transition-colors"><?php echo e(__('footer.privacy') ?? 'Informativa privacy'); ?></a>
            </div>
        </div>
    </div>
</footer><?php /**PATH /Users/mazzi/slamin_v2/resources/views/components/layouts/footer-modern.blade.php ENDPATH**/ ?>