<div class="py-16 bg-gradient-to-br from-neutral-50 via-white to-primary-50/30 dark:from-neutral-900 dark:via-neutral-900 dark:to-primary-900/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl lg:text-4xl font-bold text-neutral-900 dark:text-white">
                <?php echo __('feed.title'); ?>

            </h2>
            <p class="text-neutral-600 dark:text-neutral-400 mt-2">
                <?php echo e(__('feed.subtitle')); ?>

            </p>
        </div>

        <!-- Feed Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Main Feed (Left 2/3) -->
            <div class="lg:col-span-2 space-y-6">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $feedItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item['type'] === 'poem'): ?>
                        <!-- Poem Card - Paper Sheet Style (Homepage Match) -->
                        <?php $paperRotation = rand(-2, 2); ?>
                        <div class="poetry-card-container mb-6">
                            <div class="paper-sheet-wrapper" style="transform: rotate(<?php echo e($paperRotation); ?>deg);">
                                <div class="paper-sheet group cursor-pointer" 
                                     onclick="Livewire.dispatch('openPoemModal', { poemId: <?php echo e($item['id']); ?> })">
                                    <!-- Author Avatar & Name -->
                                    <div class="paper-author-info">
                                        <img src="<?php echo e($item['author']['avatar']); ?>" 
                                             alt="<?php echo e($item['author']['name']); ?>"
                                             class="paper-avatar">
                                        <span class="paper-author-name">
                                            <?php echo e($item['author']['name']); ?>

                                        </span>
                                    </div>
                                    
                                    <!-- Poem Title -->
                                    <h3 class="paper-title">
                                        "<?php echo e($item['title']); ?>"
                                    </h3>
                                    
                                    <!-- Poem Content -->
                                    <div class="paper-content">
                                        <?php echo e($item['excerpt']); ?>

                                    </div>
                                    
                                    <!-- Read more hint -->
                                    <div class="paper-readmore">
                                        <?php echo e(__('common.read_more')); ?> →
                                    </div>
                                    
                                    <!-- Social Actions - Inside Paper -->
                                    <div class="paper-actions-integrated" @click.stop>
                                        <?php if (isset($component)) { $__componentOriginal332a28e2e55aa3574ada95b4497eb0b2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal332a28e2e55aa3574ada95b4497eb0b2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.like-button','data' => ['itemId' => $item['id'],'itemType' => 'poem','isLiked' => $item['is_liked'],'likesCount' => $item['likes_count'],'size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('like-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item['id']),'itemType' => 'poem','isLiked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item['is_liked']),'likesCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item['likes_count']),'size' => 'sm']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.comment-button','data' => ['itemId' => $item['id'],'itemType' => 'poem','commentsCount' => $item['comments_count'],'size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('comment-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item['id']),'itemType' => 'poem','commentsCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item['comments_count']),'size' => 'sm']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.share-button','data' => ['itemId' => $item['id'],'itemType' => 'poem','size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('share-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item['id']),'itemType' => 'poem','size' => 'sm']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.report-button','data' => ['itemId' => $item['id'],'itemType' => 'poem','size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('report-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item['id']),'itemType' => 'poem','size' => 'sm']); ?>
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

                    <?php elseif($item['type'] === 'article'): ?>
                        <!-- Article Card - Magazine Cover Style (Homepage Match) -->
                        <?php
                            $rotation = rand(-3, 3);
                            $pinColor = ['#e53e3e', '#3182ce', '#38a169', '#d69e2e', '#805ad5'][rand(0, 4)];
                            $pinRotation = rand(-15, 15);
                        ?>
                        <article class="magazine-article-wrapper mb-6">
                            <!-- Thumbtack/Puntina -->
                            <div class="thumbtack" 
                                 style="background: <?php echo e($pinColor); ?>; transform: rotate(<?php echo e($pinRotation); ?>deg);">
                                <div class="thumbtack-needle"></div>
                            </div>
                            
                            <!-- Magazine Cover -->
                            <div class="magazine-cover" style="transform: rotate(<?php echo e($rotation); ?>deg);">
                                <div onclick="Livewire.dispatch('openArticleModal', { articleId: <?php echo e($item['id']); ?> })" 
                                     class="magazine-inner group cursor-pointer">
                                    <!-- Magazine Header -->
                                    <div class="magazine-header">
                                        <div class="magazine-logo"><?php echo e(strtoupper(config('app.name'))); ?></div>
                                        <div class="magazine-issue">Vol. <?php echo e(date('Y')); ?> · N.<?php echo e(str_pad($item['id'], 2, '0', STR_PAD_LEFT)); ?></div>
                                    </div>
                                    
                                    <!-- Category Badge -->
                                    <div class="magazine-category">
                                        Cultura
                                    </div>
                                    
                                    <!-- Featured Image -->
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($item['image']) && $item['image']): ?>
                                    <div class="magazine-image">
                                        <img src="<?php echo e($item['image']); ?>" 
                                             alt="<?php echo e($item['title']); ?>"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                    </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    
                                    <!-- Article Title -->
                                    <h3 class="magazine-title">
                                        <?php echo e($item['title']); ?>

                                    </h3>
                                    
                                    <!-- Excerpt -->
                                    <p class="magazine-excerpt">
                                        <?php echo e($item['excerpt']); ?>

                                    </p>
                                    
                                    <!-- Author Info with Avatar -->
                                    <div class="magazine-author">
                                        <img src="<?php echo e($item['author']['avatar']); ?>" 
                                             alt="<?php echo e($item['author']['name']); ?>"
                                             class="magazine-avatar">
                                        <div class="magazine-author-info">
                                            <span class="magazine-author-name">
                                                <?php echo e($item['author']['name']); ?>

                                            </span>
                                            <div class="magazine-author-date"><?php echo e($item['created_at']); ?></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Social Actions -->
                                <div class="magazine-actions" @click.stop>
                                    <?php if (isset($component)) { $__componentOriginal332a28e2e55aa3574ada95b4497eb0b2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal332a28e2e55aa3574ada95b4497eb0b2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.like-button','data' => ['itemId' => $item['id'],'itemType' => 'article','isLiked' => $item['is_liked'],'likesCount' => $item['likes_count'],'size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('like-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item['id']),'itemType' => 'article','isLiked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item['is_liked']),'likesCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item['likes_count']),'size' => 'sm']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.comment-button','data' => ['itemId' => $item['id'],'itemType' => 'article','commentsCount' => $item['comments_count'],'size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('comment-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item['id']),'itemType' => 'article','commentsCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item['comments_count']),'size' => 'sm']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.share-button','data' => ['itemId' => $item['id'],'itemType' => 'article','size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('share-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item['id']),'itemType' => 'article','size' => 'sm']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.report-button','data' => ['itemId' => $item['id'],'itemType' => 'article','size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('report-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item['id']),'itemType' => 'article','size' => 'sm']); ?>
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

                    <?php elseif($item['type'] === 'event'): ?>
                        <!-- Event Card - Cinema Ticket Style (Homepage Match) -->
                        <?php
                            $tilt = rand(-3, 3);
                            $ticketColors = [
                                ['#fef7e6', '#fdf3d7', '#fcf0cc'],
                                ['#fff5e1', '#fff0d4', '#ffecc7'],
                                ['#f5f5dc', '#f0f0d0', '#ebebc4'],
                            ];
                            $selectedColors = $ticketColors[array_rand($ticketColors)];
                            $stampRotation = rand(-8, 8);
                        ?>
                        <div class="mb-6">
                            <a href="<?php echo e(route('events.show', $item['id'])); ?>" 
                               class="cinema-ticket group cursor-pointer block"
                               style="transform: rotate(<?php echo e($tilt); ?>deg); 
                                      background: linear-gradient(135deg, <?php echo e($selectedColors[0]); ?> 0%, <?php echo e($selectedColors[1]); ?> 50%, <?php echo e($selectedColors[2]); ?> 100%);">
                                
                                <!-- Perforated Left Edge -->
                                <div class="ticket-perforation"></div>
                                
                                <!-- Watermark Logo -->
                                <div class="ticket-watermark">
                                    <img src="<?php echo e(asset('assets/images/filigrana.png')); ?>" 
                                         alt="Slamin" 
                                         class="w-32 h-auto md:w-40">
                                </div>
                                
                                <!-- Ticket Main Content -->
                                <div class="ticket-content">
                                    <!-- Ticket Header -->
                                    <div class="ticket-header">
                                        <div class="ticket-admit">EVENTO</div>
                                        <div class="ticket-serial">#<?php echo e(str_pad($item['id'], 4, '0', STR_PAD_LEFT)); ?></div>
                                    </div>
                                    
                                    <!-- Event Image (if available) -->
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($item['image']) && $item['image']): ?>
                                    <div class="ticket-image">
                                        <img src="<?php echo e($item['image']); ?>" 
                                             alt="<?php echo e($item['title']); ?>"
                                             class="w-full h-full object-cover">
                                    </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    
                                    <!-- Event Title -->
                                    <h3 class="ticket-title"><?php echo e($item['title']); ?></h3>
                                    
                                    <!-- Price Badge -->
                                    <div class="ticket-price" style="transform: rotate(<?php echo e($stampRotation); ?>deg);">
                                        GRATIS
                                    </div>
                                    
                                    <!-- Event Details Grid -->
                                    <div class="ticket-details">
                                        <div class="ticket-detail-item">
                                            <div class="ticket-detail-label">DATA</div>
                                            <div class="ticket-detail-value"><?php echo e($item['date']); ?></div>
                                        </div>
                                        
                                        <div class="ticket-detail-item">
                                            <div class="ticket-detail-label">LUOGO</div>
                                            <div class="ticket-detail-value ticket-location">
                                                <svg class="location-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                </svg>
                                                <span><?php echo e($item['location']); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                    <?php elseif($item['type'] === 'video'): ?>
                        <!-- Video Card - Film Strip Style (Homepage Match) -->
                        <?php $tilt = rand(-1, 1); ?>
                        <div class="mb-6">
                            <div class="film-strip-container cursor-pointer" 
                                 onclick="Livewire.dispatch('openVideoModal', { videoId: <?php echo e($item['id']); ?> })"
                                 style="transform: rotate(<?php echo e($tilt); ?>deg);">
                                <!-- Film Perforations Left -->
                                <div class="film-perforation film-perforation-left">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($h = 0; $h < 8; $h++): ?>
                                    <div class="perforation-hole"></div>
                                    <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                
                                <!-- Film Perforations Right -->
                                <div class="film-perforation film-perforation-right">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($h = 0; $h < 8; $h++): ?>
                                    <div class="perforation-hole"></div>
                                    <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                
                                <!-- Film Edge Codes -->
                                <div class="film-edge-code-top"><?php echo e(strtoupper(config('app.name'))); ?></div>
                                <div class="film-edge-code-bottom">ISO 400</div>
                                
                                <!-- Film Frame -->
                                <div class="film-frame">
                                    <!-- Frame Numbers -->
                                    <div class="film-frame-number film-frame-number-tl">///<?php echo e(str_pad($index + 1, 2, '0', STR_PAD_LEFT)); ?></div>
                                    <div class="film-frame-number film-frame-number-tr"><?php echo e(str_pad($index + 1, 2, '0', STR_PAD_LEFT)); ?>A</div>
                                
                                    <!-- Video Container -->
                                    <div class="relative aspect-video overflow-hidden bg-black cursor-pointer group">
                                        <!-- Video Thumbnail -->
                                        <img src="<?php echo e($item['thumbnail']); ?>" 
                                             alt="<?php echo e($item['title']); ?>" 
                                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                        
                                        <!-- Dark Overlay -->
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-black/40"></div>
                                        
                                        <!-- Play Button -->
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <div class="w-14 h-14 md:w-16 md:h-16 bg-white/95 backdrop-blur-sm rounded-full flex items-center justify-center shadow-2xl group-hover:scale-110 transition-all duration-300">
                                                <svg class="w-6 h-6 md:w-7 md:h-7 text-primary-600 ml-0.5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M8 5v14l11-7z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        
                                        <!-- Title -->
                                        <div class="absolute top-0 left-0 right-0 pt-4 px-4">
                                            <h3 class="text-sm md:text-lg font-bold text-white drop-shadow-lg line-clamp-2" 
                                                style="font-family: 'Crimson Pro', serif;">
                                                <?php echo e($item['title']); ?>

                                            </h3>
                                        </div>
                                        
                                        <!-- Duration Badge -->
                                        <div class="absolute bottom-4 right-4 px-2 py-1 bg-black/80 text-white text-xs font-semibold rounded">
                                            <?php echo e($item['duration']); ?>

                                        </div>
                                    </div>
                                    
                                    <!-- User & Social Stats -->
                                    <div class="mt-3 px-3 pb-3 space-y-2">
                                        <!-- User Info -->
                                        <div class="flex items-center gap-2">
                                            <img src="<?php echo e($item['author']['avatar']); ?>" 
                                                 alt="<?php echo e($item['author']['name']); ?>"
                                                 class="w-7 h-7 md:w-8 md:h-8 rounded-full object-cover ring-1 ring-white/30">
                                            <p class="font-semibold text-xs md:text-sm text-white/90"><?php echo e($item['author']['name']); ?></p>
                                        </div>
                                        
                                    <!-- Social Buttons -->
                                    <div class="flex items-center gap-4 text-white/90" @click.stop>
                                            <!-- Views -->
                                            <div class="inline-flex items-center gap-1.5">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                <span class="text-xs md:text-sm"><?php echo e($item['views_count']); ?></span>
                                            </div>
                                            
                                            <!-- Like -->
                                            <?php if (isset($component)) { $__componentOriginal332a28e2e55aa3574ada95b4497eb0b2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal332a28e2e55aa3574ada95b4497eb0b2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.like-button','data' => ['itemId' => $item['id'],'itemType' => 'video','isLiked' => $item['is_liked'],'likesCount' => $item['likes_count'],'size' => 'sm','class' => '[&_span]:!text-white/90 [&_svg]:!text-white/90 [&_svg]:w-5 [&_svg]:h-5 md:[&_svg]:w-6 md:[&_svg]:h-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('like-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item['id']),'itemType' => 'video','isLiked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item['is_liked']),'likesCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item['likes_count']),'size' => 'sm','class' => '[&_span]:!text-white/90 [&_svg]:!text-white/90 [&_svg]:w-5 [&_svg]:h-5 md:[&_svg]:w-6 md:[&_svg]:h-6']); ?>
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
                                            
                                            <!-- Share -->
                                            <?php if (isset($component)) { $__componentOriginalb32cd1c2ffd206a678a9d8db2f247966 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb32cd1c2ffd206a678a9d8db2f247966 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.share-button','data' => ['itemId' => $item['id'],'itemType' => 'video','size' => 'sm','class' => '[&_button]:!text-white/90 [&_svg]:!stroke-white [&_svg]:w-5 [&_svg]:h-5 md:[&_svg]:w-6 md:[&_svg]:h-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('share-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item['id']),'itemType' => 'video','size' => 'sm','class' => '[&_button]:!text-white/90 [&_svg]:!stroke-white [&_svg]:w-5 [&_svg]:h-5 md:[&_svg]:w-6 md:[&_svg]:h-6']); ?>
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
                                            
                                            <!-- Report -->
                                            <?php if (isset($component)) { $__componentOriginalcab7032bfdfb17b0d85d7225950dd852 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcab7032bfdfb17b0d85d7225950dd852 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.report-button','data' => ['itemId' => $item['id'],'itemType' => 'video','size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('report-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item['id']),'itemType' => 'video','size' => 'sm']); ?>
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
                        </div>

                    <?php elseif($item['type'] === 'gallery'): ?>
                        <!-- Gallery Card -->
                        <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                            <div class="p-6 flex items-center justify-between border-b border-neutral-100 dark:border-neutral-700">
                                <div class="flex items-center gap-3">
                                    <img src="<?php echo e($item['author']['avatar']); ?>" alt="<?php echo e($item['author']['name']); ?>" 
                                         class="w-12 h-12 rounded-full object-cover ring-2 ring-primary-200">
                                    <div>
                                        <h3 class="font-semibold text-neutral-900 dark:text-white"><?php echo e($item['author']['name']); ?></h3>
                                        <p class="text-sm text-neutral-500 dark:text-neutral-400"><?php echo e($item['created_at']); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6">
                                <h4 class="text-xl font-bold text-neutral-900 dark:text-white mb-4"><?php echo e($item['title']); ?></h4>
                                <div class="grid grid-cols-3 gap-2">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $item['images']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="aspect-square overflow-hidden rounded-xl <?php echo e($idx === 2 ? 'relative' : ''); ?>">
                                            <img src="<?php echo e($image); ?>" alt="Photo <?php echo e($idx + 1); ?>" 
                                                 class="w-full h-full object-cover hover:scale-110 transition-transform duration-300 cursor-pointer">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($idx === 2 && $item['photos_count'] > 3): ?>
                                                <div class="absolute inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center cursor-pointer hover:bg-black/50 transition-colors">
                                                    <span class="text-white text-2xl font-bold">+<?php echo e($item['photos_count'] - 3); ?></span>
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <div class="flex items-center justify-between mt-4 pt-4 border-t border-neutral-100 dark:border-neutral-700">
                                    <span class="text-sm text-neutral-600 dark:text-neutral-400">
                                        <?php echo e($item['photos_count']); ?> <?php echo e(__('feed.photos')); ?>

                                    </span>
                                    <div class="flex items-center gap-4">
                                        <!-- Gallery likes temporaneamente disabilitati finché non avremo un modello Gallery -->
                                        <div class="flex items-center gap-2 text-neutral-400">
                                            <img src="<?php echo e(asset('assets/icon/new/like.svg')); ?>" 
                                                 alt="Like" 
                                                 class="w-5 h-5 opacity-50"
                                                 style="filter: brightness(0) saturate(100%) invert(60%) sepia(0%) saturate(0%) hue-rotate(0deg) brightness(89%) contrast(86%);">
                                            <span class="font-medium text-sm"><?php echo e($item['likes_count']); ?></span>
                                        </div>
                                        
                                        <?php if (isset($component)) { $__componentOriginalb32cd1c2ffd206a678a9d8db2f247966 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb32cd1c2ffd206a678a9d8db2f247966 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.share-button','data' => ['itemId' => $item['id'],'itemType' => $item['type']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('share-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['item-id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item['id']),'item-type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item['type'])]); ?>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Sidebar (Right 1/3) -->
            <div class="space-y-6">
                
                <!-- Trending Topics - GLOBALE -->
                <div class="bg-gradient-to-br from-primary-600 to-primary-700 rounded-2xl shadow-lg p-6 text-white">
                    <h3 class="text-lg font-bold mb-4">🔥 <?php echo e(__('feed.trending')); ?></h3>
                    <div class="space-y-3">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $trendingTopics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex items-center justify-between hover:bg-white/10 -mx-2 px-2 py-2 rounded-lg transition-colors cursor-pointer">
                            <span class="text-sm font-medium"><?php echo e($topic['tag']); ?></span>
                            <span class="text-xs bg-white/20 px-2.5 py-1 rounded-full font-semibold">
                                <?php echo e($topic['count'] > 1000 ? number_format($topic['count'] / 1000, 1) . 'K' : $topic['count']); ?>

                            </span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-sm text-white/70 italic">
                            <?php echo e(__('feed.no_trending_yet')); ?>

                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">
                        ⚡ <?php echo e(__('feed.quick_actions')); ?>

                    </h3>
                    <div class="space-y-2">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create.poem')): ?>
                        <a href="<?php echo e(route('poems.create')); ?>" class="flex items-center gap-3 p-3 rounded-xl hover:bg-neutral-50 dark:hover:bg-neutral-700 transition-colors group">
                            <div class="w-10 h-10 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </div>
                            <span class="font-medium text-neutral-900 dark:text-white"><?php echo e(__('feed.write_poem')); ?></span>
                        </a>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('upload.video')): ?>
                        <a href="#" class="flex items-center gap-3 p-3 rounded-xl hover:bg-neutral-50 dark:hover:bg-neutral-700 transition-colors group">
                            <div class="w-10 h-10 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <span class="font-medium text-neutral-900 dark:text-white"><?php echo e(__('feed.upload_video')); ?></span>
                        </a>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create.event')): ?>
                        <a href="#" class="flex items-center gap-3 p-3 rounded-xl hover:bg-neutral-50 dark:hover:bg-neutral-700 transition-colors group">
                            <div class="w-10 h-10 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <span class="font-medium text-neutral-900 dark:text-white"><?php echo e(__('feed.create_event')); ?></span>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
    
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('poems.poem-modal', []);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3079169080-0', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('articles.article-modal', []);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3079169080-1', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('media.video-modal', []);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3079169080-2', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
</div>
<?php /**PATH /Users/mazzi/slamin_v2/resources/views/livewire/home/personalized-feed.blade.php ENDPATH**/ ?>