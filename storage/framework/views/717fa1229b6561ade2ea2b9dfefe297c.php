<?php
    $heightClass = match($size) {
        'large' => 'h-64',
        'small' => 'h-40',
        default => 'h-48',
    };
    $titleSize = match($size) {
        'large' => 'text-2xl',
        'small' => 'text-base',
        default => 'text-xl',
    };
?>

<article class="group bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col h-full">
    
    <div class="relative overflow-hidden <?php echo e($heightClass); ?>">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($article->featured_image_url): ?>
            <img 
                src="<?php echo e($article->featured_image_url); ?>" 
                alt="<?php echo e($article->title); ?>"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
            >
        <?php else: ?>
            <div class="w-full h-full bg-gradient-to-br from-primary-400 to-accent-400 flex items-center justify-center">
                <svg class="w-16 h-16 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showCategory && $article->category): ?>
            <div class="absolute top-3 left-3">
                <span class="px-2.5 py-1 bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm text-xs font-semibold text-gray-700 dark:text-gray-300 rounded-full">
                    <?php echo e($article->category->name); ?>

                </span>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <div class="p-6 flex-1 flex flex-col">
        <h3 class="<?php echo e($titleSize); ?> font-bold text-gray-900 dark:text-white mb-3 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors line-clamp-2">
            <div onclick="Livewire.dispatch('openArticleModal', { articleId: <?php echo e($article->id); ?> })" class="cursor-pointer">
                <?php echo e($article->title); ?>

            </div>
        </h3>
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showExcerpt && $article->excerpt): ?>
            <p class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-3 flex-1">
                <?php echo e($article->excerpt); ?>

            </p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        
        <div class="flex flex-col gap-4 pt-4 border-t border-gray-200 dark:border-gray-700 mt-auto">
            <div class="flex items-center gap-3 text-sm text-gray-500 dark:text-gray-400 flex-wrap">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showAuthor && $article->user): ?>
                    <div class="flex items-center gap-2">
                        <img src="<?php echo e(\App\Helpers\AvatarHelper::getUserAvatarUrl($article->user, 64)); ?>" 
                             alt="<?php echo e(\App\Helpers\AvatarHelper::getDisplayName($article->user)); ?>"
                             class="w-7 h-7 rounded-full object-cover ring-2 ring-white/80 dark:ring-gray-700 shadow-sm">
                        <span class="font-medium text-gray-700 dark:text-gray-200">
                            <a href="<?php echo e(\App\Helpers\AvatarHelper::getUserProfileUrl($article->user)); ?>" 
                               class="hover:underline transition-colors">
                                <?php echo e(\App\Helpers\AvatarHelper::getDisplayName($article->user)); ?>

                            </a>
                        </span>
                    </div>
                    <span class="text-gray-400">•</span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <span><?php echo e($article->published_at->format('d M Y')); ?></span>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showStats): ?>
                    <span class="text-gray-400">•</span>
                    <span><?php echo e($article->read_time); ?> min</span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3" @click.stop>
                    <?php if (isset($component)) { $__componentOriginal332a28e2e55aa3574ada95b4497eb0b2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal332a28e2e55aa3574ada95b4497eb0b2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.like-button','data' => ['itemId' => $article->id,'itemType' => 'article','isLiked' => $article->is_liked ?? false,'likesCount' => $article->like_count ?? 0,'size' => 'sm','class' => '[&_button]:!text-neutral-600 dark:[&_button]:!text-neutral-300 [&_button]:!gap-1 [&_svg]:!stroke-current [&_span]:!text-xs']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('like-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article->id),'itemType' => 'article','isLiked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article->is_liked ?? false),'likesCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article->like_count ?? 0),'size' => 'sm','class' => '[&_button]:!text-neutral-600 dark:[&_button]:!text-neutral-300 [&_button]:!gap-1 [&_svg]:!stroke-current [&_span]:!text-xs']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal332a28e2e55aa3574ada95b4497eb0b2)): ?>
<?php $attributes = $__attributesOriginal332a28e2e55aa3574ada95b4497eb0b2; ?>
<?php unset($__attributesOriginal332a28e2e55aa3574ada95b4497eb0b2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal332a28e2e55aa3574ada95b4497eb0b2)): ?>
<?php $component = $__componentOriginal332a28e2e55aa3574ada95b4497eb0b2; ?>
<?php unset($__componentOriginal332a28e2e55aa3574ada95b4497eb0b2); ?>
<?php endif; ?>
                    
                    <?php if (isset($component)) { $__componentOriginale34ce5ad0385b05e8d24b4bea6ec4cfd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale34ce5ad0385b05e8d24b4bea6ec4cfd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.comment-button','data' => ['itemId' => $article->id,'itemType' => 'article','commentsCount' => $article->comment_count ?? 0,'size' => 'sm','class' => '[&_button]:!text-neutral-600 dark:[&_button]:!text-neutral-300 [&_button]:!gap-1 [&_svg]:!stroke-current [&_span]:!text-xs']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('comment-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article->id),'itemType' => 'article','commentsCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article->comment_count ?? 0),'size' => 'sm','class' => '[&_button]:!text-neutral-600 dark:[&_button]:!text-neutral-300 [&_button]:!gap-1 [&_svg]:!stroke-current [&_span]:!text-xs']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale34ce5ad0385b05e8d24b4bea6ec4cfd)): ?>
<?php $attributes = $__attributesOriginale34ce5ad0385b05e8d24b4bea6ec4cfd; ?>
<?php unset($__attributesOriginale34ce5ad0385b05e8d24b4bea6ec4cfd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale34ce5ad0385b05e8d24b4bea6ec4cfd)): ?>
<?php $component = $__componentOriginale34ce5ad0385b05e8d24b4bea6ec4cfd; ?>
<?php unset($__componentOriginale34ce5ad0385b05e8d24b4bea6ec4cfd); ?>
<?php endif; ?>
                    
                    <?php if (isset($component)) { $__componentOriginalb32cd1c2ffd206a678a9d8db2f247966 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb32cd1c2ffd206a678a9d8db2f247966 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.share-button','data' => ['itemId' => $article->id,'itemType' => 'article','url' => route('articles.show', $article->slug),'title' => $article->title,'size' => 'sm','class' => '[&_button]:!text-neutral-600 dark:[&_button]:!text-neutral-300 [&_button]:!gap-1 [&_svg]:!stroke-current [&_span]:!text-xs']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('share-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article->id),'itemType' => 'article','url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('articles.show', $article->slug)),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article->title),'size' => 'sm','class' => '[&_button]:!text-neutral-600 dark:[&_button]:!text-neutral-300 [&_button]:!gap-1 [&_svg]:!stroke-current [&_span]:!text-xs']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb32cd1c2ffd206a678a9d8db2f247966)): ?>
<?php $attributes = $__attributesOriginalb32cd1c2ffd206a678a9d8db2f247966; ?>
<?php unset($__attributesOriginalb32cd1c2ffd206a678a9d8db2f247966); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb32cd1c2ffd206a678a9d8db2f247966)): ?>
<?php $component = $__componentOriginalb32cd1c2ffd206a678a9d8db2f247966; ?>
<?php unset($__componentOriginalb32cd1c2ffd206a678a9d8db2f247966); ?>
<?php endif; ?>
                    
                    <?php if (isset($component)) { $__componentOriginalcab7032bfdfb17b0d85d7225950dd852 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcab7032bfdfb17b0d85d7225950dd852 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.report-button','data' => ['itemId' => $article->id,'itemType' => 'article','size' => 'sm','class' => '[&_button]:!text-neutral-600 dark:[&_button]:!text-neutral-300 [&_button]:!gap-1 [&_svg]:!stroke-current [&_span]:!text-xs']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('report-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article->id),'itemType' => 'article','size' => 'sm','class' => '[&_button]:!text-neutral-600 dark:[&_button]:!text-neutral-300 [&_button]:!gap-1 [&_svg]:!stroke-current [&_span]:!text-xs']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcab7032bfdfb17b0d85d7225950dd852)): ?>
<?php $attributes = $__attributesOriginalcab7032bfdfb17b0d85d7225950dd852; ?>
<?php unset($__attributesOriginalcab7032bfdfb17b0d85d7225950dd852); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcab7032bfdfb17b0d85d7225950dd852)): ?>
<?php $component = $__componentOriginalcab7032bfdfb17b0d85d7225950dd852; ?>
<?php unset($__componentOriginalcab7032bfdfb17b0d85d7225950dd852); ?>
<?php endif; ?>
                </div>
                
                <button onclick="Livewire.dispatch('openArticleModal', { articleId: <?php echo e($article->id); ?> })" 
                        class="text-primary-600 dark:text-primary-400 font-semibold text-sm hover:underline cursor-pointer">
                    <?php echo e(__('articles.index.read_more')); ?> →
                </button>
            </div>
        </div>
    </div>
</article>
<?php /**PATH /Users/mazzi/slamin_v2/resources/views/livewire/articles/article-card.blade.php ENDPATH**/ ?>