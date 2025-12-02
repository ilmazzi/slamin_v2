<div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($articles && $articles->count() > 0): ?>
    
    <div class="relative" x-data="{ 
        scrollHorizontal(direction) {
            const container = $refs.scrollContainer;
            const scrollAmount = container.offsetWidth * 0.8;
            container.scrollBy({ 
                left: direction * scrollAmount, 
                behavior: 'smooth' 
            });
        }
    }">
        <!-- Left Arrow (Desktop Only) - OUTSIDE content -->
        <button @click="scrollHorizontal(-1)" 
                class="hidden md:flex absolute -left-16 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white/95 dark:bg-neutral-800/95 backdrop-blur-sm rounded-full shadow-xl hover:scale-110 transition-all duration-300 items-center justify-center text-neutral-900 dark:text-white group">
            <svg class="w-6 h-6 transform group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        
        <!-- Right Arrow (Desktop Only) - OUTSIDE content -->
        <button @click="scrollHorizontal(1)" 
                class="hidden md:flex absolute -right-16 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white/95 dark:bg-neutral-800/95 backdrop-blur-sm rounded-full shadow-xl hover:scale-110 transition-all duration-300 items-center justify-center text-neutral-900 dark:text-white group">
            <svg class="w-6 h-6 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
        
            <!-- Mobile Scroll Indicator -->
            <div class="md:hidden relative mb-4">
                <div class="flex items-center justify-center gap-2 text-neutral-600 dark:text-neutral-400 text-sm">
                    <svg class="w-5 h-5 animate-bounce-horizontal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                    </svg>
                    <span>Scorri per vedere altro</span>
                </div>
            </div>
            
            <div x-ref="scrollContainer" class="flex gap-6 overflow-x-auto pb-12 pt-20 px-8 md:px-12 scrollbar-hide"
                 style="-webkit-overflow-scrolling: touch; overflow-y: visible;">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $articles->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            // Random positioning for magazine covers
            $rotation = rand(-3, 3);
            $pinColor = ['#e53e3e', '#3182ce', '#38a169', '#d69e2e', '#805ad5'][rand(0, 4)];
            $pinRotation = rand(-15, 15);
        ?>
        <article class="w-80 md:w-96 flex-shrink-0 magazine-article-wrapper fade-scale-item" 
                 x-data 
                 x-intersect.once="$el.classList.add('animate-fade-in')" 
                 style="animation-delay: <?php echo e($i * 0.1); ?>s">
            
            
            <div class="thumbtack" 
                 style="background: <?php echo e($pinColor); ?>; transform: rotate(<?php echo e($pinRotation); ?>deg);">
                <div class="thumbtack-needle"></div>
            </div>
            
            
            <div class="magazine-cover" style="transform: rotate(<?php echo e($rotation); ?>deg);">
                
                <div onclick="Livewire.dispatch('openArticleModal', { articleId: <?php echo e($article->id); ?> })" class="magazine-inner group cursor-pointer">
                    
                    
                    <div class="magazine-header">
                        <div class="magazine-logo"><?php echo e(strtoupper(config('app.name'))); ?></div>
                        <div class="magazine-issue">Vol. <?php echo e(date('Y')); ?> · N.<?php echo e(str_pad($article->id, 2, '0', STR_PAD_LEFT)); ?></div>
                    </div>
                    
                    
                    <div class="magazine-category">
                        Cultura
                    </div>
                    
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($article->featured_image_url): ?>
                    <div class="magazine-image">
                        <img src="<?php echo e($article->featured_image_url); ?>" 
                             alt="<?php echo e($article->title); ?>"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    
                    
                    <h3 class="magazine-title">
                        <?php echo e($article->title); ?>

                    </h3>
                    
                    
                    <p class="magazine-excerpt">
                        <?php echo e($article->excerpt ?? Str::limit(strip_tags($article->content), 120)); ?>

                    </p>
                    
                    
                    <div class="magazine-author">
                        <img src="<?php echo e(\App\Helpers\AvatarHelper::getUserAvatarUrl($article->user, 80)); ?>" 
                             alt="<?php echo e($article->user->name); ?>"
                             class="magazine-avatar">
                        <div class="magazine-author-info">
                            <a href="<?php echo e(\App\Helpers\AvatarHelper::getUserProfileUrl($article->user)); ?>" 
                               class="magazine-author-name hover:underline transition-colors">
                                <?php echo e(\App\Helpers\AvatarHelper::getDisplayName($article->user)); ?>

                            </a>
                            <div class="magazine-author-date"><?php echo e($article->created_at->format('d M Y')); ?></div>
                        </div>
                    </div>
                    
                </div>
                
                
                <div class="magazine-actions" @click.stop>
                    <?php if (isset($component)) { $__componentOriginal332a28e2e55aa3574ada95b4497eb0b2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal332a28e2e55aa3574ada95b4497eb0b2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.like-button','data' => ['itemId' => $article->id,'itemType' => 'article','isLiked' => $article->is_liked ?? false,'likesCount' => $article->like_count ?? 0,'size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('like-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article->id),'itemType' => 'article','isLiked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article->is_liked ?? false),'likesCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article->like_count ?? 0),'size' => 'sm']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.comment-button','data' => ['itemId' => $article->id,'itemType' => 'article','commentsCount' => $article->comment_count ?? 0,'size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('comment-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article->id),'itemType' => 'article','commentsCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article->comment_count ?? 0),'size' => 'sm']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.share-button','data' => ['itemId' => $article->id,'itemType' => 'article','size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('share-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article->id),'itemType' => 'article','size' => 'sm']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.report-button','data' => ['itemId' => $article->id,'itemType' => 'article','size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('report-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article->id),'itemType' => 'article','size' => 'sm']); ?>
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
                
            </div>
        </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    
    <div class="text-center mt-10">
        <a href="<?php echo e(route('articles.index')); ?>" 
           class="inline-block text-2xl md:text-3xl font-bold text-neutral-900 dark:text-white hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-300"
           style="font-family: 'Crimson Pro', serif;">
            → <?php echo e(__('home.all_articles_button')); ?>

        </a>
    </div>
    
    <style>
        @keyframes fade-in { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in { animation: fade-in 0.6s ease-out forwards; opacity: 0; }
        
        /* ============================================
           LITERARY MAGAZINE WALL
           ============================================ */
        
        .magazine-article-wrapper {
            position: relative;
            padding-top: 0;
        }
        
        /* Thumbtack/Puntina colorata - PINNED INTO CARD */
        .thumbtack {
            position: absolute;
            top: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 28px;
            height: 28px;
            border-radius: 50%;
            z-index: 100;
            box-shadow: 
                0 3px 6px rgba(0, 0, 0, 0.35),
                0 1px 3px rgba(0, 0, 0, 0.25),
                inset 0 -6px 10px rgba(0, 0, 0, 0.25),
                inset 0 6px 10px rgba(255, 255, 255, 0.4);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .thumbtack-needle {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 4px;
            height: 4px;
            background: #1a1a1a;
            border-radius: 50%;
            box-shadow: 
                0 1px 3px rgba(0, 0, 0, 0.6),
                inset 0 1px 1px rgba(255, 255, 255, 0.2);
        }
        
        /* Magazine Cover - Copertina Rivista */
        .magazine-cover {
            position: relative;
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.15);
            box-shadow: 
                0 4px 8px rgba(0, 0, 0, 0.12),
                0 8px 16px rgba(0, 0, 0, 0.08),
                0 12px 24px rgba(0, 0, 0, 0.06);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Hover on wrapper - pin moves with card! */
        .magazine-article-wrapper:hover .magazine-cover {
            transform: translateY(-8px) scale(1.02) !important;
            box-shadow: 
                0 12px 20px rgba(0, 0, 0, 0.18),
                0 20px 36px rgba(0, 0, 0, 0.12),
                0 28px 48px rgba(0, 0, 0, 0.08);
        }
        
        .magazine-article-wrapper:hover .thumbtack {
            transform: translateX(-50%) translateY(-8px);
        }
        
        :is(.dark .magazine-cover) {
            background: #2a2724;
            border-color: rgba(255, 255, 255, 0.1);
        }
        
        .magazine-inner {
            display: block;
            padding: 1.5rem;
            text-decoration: none;
        }
        
        /* Magazine Header - Testata */
        .magazine-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 0.75rem;
            margin-bottom: 1rem;
            border-bottom: 2px solid #000;
        }
        
        :is(.dark .magazine-header) {
            border-bottom-color: #fff;
        }
        
        .magazine-logo {
            font-family: 'Crimson Pro', serif;
            font-size: 1.5rem;
            font-weight: 900;
            letter-spacing: 0.15em;
            color: #000;
        }
        
        :is(.dark .magazine-logo) {
            color: #fff;
        }
        
        .magazine-issue {
            font-family: 'Crimson Pro', serif;
            font-size: 0.625rem;
            font-weight: 600;
            color: #666;
            letter-spacing: 0.05em;
        }
        
        :is(.dark .magazine-issue) {
            color: #aaa;
        }
        
        /* Category Badge */
        .magazine-category {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background: #10b981;
            color: #fff;
            font-size: 0.625rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 1rem;
        }
        
        /* Featured Image */
        .magazine-image {
            position: relative;
            aspect-ratio: 16/10;
            overflow: hidden;
            margin-bottom: 1rem;
            background: #000;
        }
        
        /* Title */
        .magazine-title {
            font-family: 'Crimson Pro', serif;
            font-size: 1.25rem;
            font-weight: 700;
            line-height: 1.3;
            color: #1a1a1a;
            margin-bottom: 0.75rem;
            transition: color 0.3s ease;
        }
        
        .group:hover .magazine-title {
            color: #10b981;
        }
        
        :is(.dark .magazine-title) {
            color: #f5f5f5;
        }
        
        :is(.dark .group:hover .magazine-title) {
            color: #34d399;
        }
        
        /* Excerpt */
        .magazine-excerpt {
            font-family: 'Crimson Pro', serif;
            font-size: 0.875rem;
            line-height: 1.6;
            color: #4a4a4a;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        :is(.dark .magazine-excerpt) {
            color: #c5c5c5;
        }
        
        /* Author section with avatar */
        .magazine-author {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 0;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        :is(.dark .magazine-author) {
            border-top-color: rgba(255, 255, 255, 0.1);
        }
        
        .magazine-avatar {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #10b981;
            flex-shrink: 0;
        }
        
        .magazine-author-info {
            flex: 1;
        }
        
        .magazine-author-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: #1a1a1a;
        }
        
        :is(.dark .magazine-author-name) {
            color: #f5f5f5;
        }
        
        .magazine-author-date {
            font-size: 0.75rem;
            color: #666;
        }
        
        :is(.dark .magazine-author-date) {
            color: #999;
        }
        
        /* Social Actions */
        .magazine-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.5rem;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(4px);
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        :is(.dark .magazine-actions) {
            background: rgba(42, 39, 36, 0.9);
            border-top-color: rgba(255, 255, 255, 0.1);
        }
    </style>
    <?php else: ?>
    
    <div class="flex flex-col items-center justify-center py-20 px-4">
        <div class="text-center max-w-md">
            <svg class="w-24 h-24 mx-auto mb-6 text-neutral-400 dark:text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
            </svg>
            <h3 class="text-2xl font-bold text-neutral-900 dark:text-white mb-3" style="font-family: 'Crimson Pro', serif;">
                <?php echo e(__('home.no_articles_title')); ?>

            </h3>
            <p class="text-neutral-600 dark:text-neutral-400 mb-6">
                <?php echo e(__('home.no_articles_subtitle')); ?>

            </p>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
            <a href="<?php echo e(route('articles.create')); ?>" 
               class="inline-block px-6 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors duration-300">
                <?php echo e(__('home.create_content')); ?>

            </a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    
    
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('articles.article-modal', []);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-898236795-0', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
</div>
<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/livewire/home/articles-section.blade.php ENDPATH**/ ?>