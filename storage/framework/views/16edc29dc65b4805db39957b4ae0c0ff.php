<div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isOpen && $article): ?>
    <!-- Modal Overlay -->
    <div x-data="{ show: <?php if ((object) ('isOpen') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('isOpen'->value()); ?>')<?php echo e('isOpen'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('isOpen'); ?>')<?php endif; ?>, leftOpen: false, rightOpen: false }"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-hidden"
         @keydown.escape.window="$wire.closeModal()"
         x-effect="if (show) { leftOpen = false; rightOpen = false; requestAnimationFrame(() => { leftOpen = true; rightOpen = true; }); } else { leftOpen = false; rightOpen = false; }">
        
        <!-- Dark Backdrop -->
        <div x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="absolute inset-0 bg-black/80 backdrop-blur-sm z-0"
             @click="$wire.closeModal()"></div>
        
        <!-- Newspaper Container -->
        <div class="absolute inset-0 flex items-center justify-center p-4 md:p-8 overflow-y-auto overflow-x-hidden z-10">
            
            <div class="article-newspaper-container"
                 x-show="show"
                 x-transition:enter="transition-all ease-out duration-1000"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition-all ease-in duration-500"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95">
                
                <!-- Close Button -->
                <button wire:click="closeModal"
                        class="absolute -top-4 -right-4 z-50 w-12 h-12 bg-white dark:bg-neutral-800 rounded-full shadow-2xl
                               hover:scale-110 hover:rotate-90 transition-all duration-300
                               flex items-center justify-center text-neutral-600 dark:text-neutral-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
                
                <!-- Newspaper Opened (Desktop: Two Pages, Mobile: Single Page) -->
                <div class="article-newspaper-opened">
                    
                    <!-- Left Page (Desktop Only) -->
                    <div class="article-page article-page-left"
                         x-bind:class="leftOpen ? 'article-page-open-left' : 'article-page-closed-left'">
                        
                        <div class="article-page-content">
                            <!-- Newspaper Header -->
                            <div class="article-newspaper-header">
                                <div class="article-newspaper-masthead">
                                    <h1 class="article-newspaper-title"><?php echo e(__('articles.newspaper.title')); ?></h1>
                                    <div class="article-newspaper-date-line">
                                        <span class="article-newspaper-date"><?php echo e($article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y')); ?></span>
                                        <span class="article-newspaper-price">€ 2,50</span>
                                    </div>
                                </div>
                                <div class="article-newspaper-divider"></div>
                            </div>
                            
                            <!-- Author Info -->
                            <div class="article-left-meta">
                                <div class="article-author-info-left">
                                    <img src="<?php echo e(\App\Helpers\AvatarHelper::getUserAvatarUrl($article->user, 80)); ?>" 
                                         alt="<?php echo e($article->user->name); ?>"
                                         class="article-author-avatar-left">
                                    <div>
                                        <a href="<?php echo e(\App\Helpers\AvatarHelper::getUserProfileUrl($article->user)); ?>" 
                                           class="article-author-name-left hover:underline transition-colors">
                                            <?php echo e(\App\Helpers\AvatarHelper::getDisplayName($article->user)); ?>

                                        </a>
                                        <div class="article-author-role-left"><?php echo e(__('articles.newspaper.reporter')); ?></div>
                                    </div>
                                </div>
                                
                                <div class="article-left-stats">
                                    <div class="article-left-stat">
                                        <p class="count"><?php echo e($article->views_count ?? 0); ?></p>
                                        <p class="label"><?php echo e(__('articles.newspaper.views')); ?></p>
                                    </div>
                                    <div class="article-left-stat">
                                        <p class="count"><?php echo e($article->likes_count ?? 0); ?></p>
                                        <p class="label"><?php echo e(__('articles.newspaper.likes')); ?></p>
                                    </div>
                                </div>
                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($article->featured_image_url): ?>
                                <div class="article-featured-image-left">
                                    <img src="<?php echo e($article->featured_image_url); ?>" 
                                         alt="<?php echo e($article->title); ?>"
                                         class="article-image-left">
                                </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->id() === $article->user_id): ?>
                                        <div class="article-owner-actions-left">
                                            <a href="<?php echo e(route('articles.edit', $article->slug)); ?>" class="article-owner-action">
                                                <svg class="article-owner-action-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.5 2.5l3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                                </svg>
                                                <span><?php echo e(__('articles.newspaper.edit_article')); ?></span>
                                            </a>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Page -->
                    <div class="article-page article-page-right"
                         x-bind:class="rightOpen ? 'article-page-open-right' : 'article-page-closed-right'">
                        
                        <div class="article-page-content">
                            <!-- Article Title (Desktop - Right Page) -->
                            <div class="article-title-section">
                                <div class="article-category-badge">
                                    <?php echo e($article->category->name ?? __('articles.category.uncategorized')); ?>

                                </div>
                                <h2 class="article-main-title"><?php echo e($article->title); ?></h2>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($article->excerpt): ?>
                                <p class="article-subtitle"><?php echo e($article->excerpt); ?></p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            
                            <!-- Article Header (Mobile) -->
                            <div class="article-header-section">
                                <!-- Newspaper Header (Mobile Only) -->
                                <div class="article-newspaper-header-mobile">
                                    <div class="article-newspaper-masthead">
                                        <h1 class="article-newspaper-title"><?php echo e(__('articles.newspaper.title')); ?></h1>
                                        <div class="article-newspaper-date-line">
                                            <span class="article-newspaper-date"><?php echo e($article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y')); ?></span>
                                            <span class="article-newspaper-price">€ 2,50</span>
                                        </div>
                                    </div>
                                    <div class="article-newspaper-divider"></div>
                                </div>
                                
                                <div class="article-category-badge">
                                    <?php echo e($article->category->name ?? __('articles.category.uncategorized')); ?>

                                </div>
                                <h2 class="article-main-title"><?php echo e($article->title); ?></h2>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($article->excerpt): ?>
                                <p class="article-subtitle"><?php echo e($article->excerpt); ?></p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <div class="article-byline">
                                    <div class="article-author-info">
                                        <img src="<?php echo e(\App\Helpers\AvatarHelper::getUserAvatarUrl($article->user, 48)); ?>" 
                                             alt="<?php echo e($article->user->name); ?>"
                                             class="article-author-avatar">
                                        <div>
                                            <a href="<?php echo e(\App\Helpers\AvatarHelper::getUserProfileUrl($article->user)); ?>" 
                                               class="article-author-name hover:underline transition-colors">
                                                <?php echo e(\App\Helpers\AvatarHelper::getDisplayName($article->user)); ?>

                                            </a>
                                            <div class="article-author-role"><?php echo e(__('articles.newspaper.reporter')); ?></div>
                                        </div>
                                    </div>
                                    <div class="article-meta">
                                        <span><?php echo e($article->created_at->diffForHumans()); ?></span>
                                        <span class="article-meta-divider">•</span>
                                        <span><?php echo e($article->views_count ?? 0); ?> <?php echo e(__('articles.newspaper.views')); ?></span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Featured Image -->
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($article->featured_image_url): ?>
                            <div class="article-featured-image">
                                <img src="<?php echo e($article->featured_image_url); ?>" 
                                     alt="<?php echo e($article->title); ?>"
                                     class="article-image">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($article->excerpt): ?>
                                <div class="article-image-caption"><?php echo e($article->excerpt); ?></div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            
                            <!-- Article Body -->
                            <div class="article-body">
                                <?php echo $article->content; ?>

                            </div>
                            
                            <!-- Article Footer -->
                            <div class="article-footer">
                                <div class="article-social-actions">
                                    <?php if (isset($component)) { $__componentOriginal332a28e2e55aa3574ada95b4497eb0b2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal332a28e2e55aa3574ada95b4497eb0b2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.like-button','data' => ['itemId' => $article->id,'itemType' => 'article','isLiked' => $article->is_liked ?? false,'likesCount' => $article->likes_count ?? 0,'size' => 'md']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('like-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article->id),'itemType' => 'article','isLiked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article->is_liked ?? false),'likesCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article->likes_count ?? 0),'size' => 'md']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.comment-button','data' => ['itemId' => $article->id,'itemType' => 'article','commentsCount' => $article->comments_count ?? 0,'size' => 'md']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('comment-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article->id),'itemType' => 'article','commentsCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article->comments_count ?? 0),'size' => 'md']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.share-button','data' => ['itemId' => $article->id,'itemType' => 'article','size' => 'md']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('share-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article->id),'itemType' => 'article','size' => 'md']); ?>
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
                                    
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                                        <?php if(auth()->user()->hasRole(['admin', 'editor'])): ?>
                                            <?php if (isset($component)) { $__componentOriginal08ca651474e3c3c5bc66931d6ae05962 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal08ca651474e3c3c5bc66931d6ae05962 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.add-to-carousel-button','data' => ['contentId' => $article->id,'contentType' => 'article','size' => 'md']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('add-to-carousel-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['contentId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article->id),'contentType' => 'article','size' => 'md']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal08ca651474e3c3c5bc66931d6ae05962)): ?>
<?php $attributes = $__attributesOriginal08ca651474e3c3c5bc66931d6ae05962; ?>
<?php unset($__attributesOriginal08ca651474e3c3c5bc66931d6ae05962); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal08ca651474e3c3c5bc66931d6ae05962)): ?>
<?php $component = $__componentOriginal08ca651474e3c3c5bc66931d6ae05962; ?>
<?php unset($__componentOriginal08ca651474e3c3c5bc66931d6ae05962); ?>
<?php endif; ?>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    
                                    <?php if (isset($component)) { $__componentOriginalcab7032bfdfb17b0d85d7225950dd852 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcab7032bfdfb17b0d85d7225950dd852 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.report-button','data' => ['itemId' => $article->id,'itemType' => 'article','size' => 'md']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('report-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article->id),'itemType' => 'article','size' => 'md']); ?>
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
                        </div>
                    </div>
                    
                    <!-- Newspaper Spine (Desktop Only) -->
                    <div class="article-newspaper-spine"></div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>

<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/livewire/articles/article-modal.blade.php ENDPATH**/ ?>