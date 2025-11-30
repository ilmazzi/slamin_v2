<div class="min-h-screen">
    
    
    <section class="relative py-12 md:py-20 overflow-hidden bg-neutral-900 dark:bg-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center gap-6 md:flex-row md:justify-center md:gap-12">
                
                <!-- FILM CARD (come homepage, ma più grande) -->
                <div class="media-page-film-card">
                    <!-- Film codes -->
                    <div class="media-page-film-code-top">SLAMIN</div>
                    <div class="media-page-film-code-bottom">ISO 400</div>
                    
                    <!-- Film frame -->
                    <div class="media-page-film-frame">
                        <!-- Perforations -->
                        <div class="media-page-film-perf-left">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($h = 0; $h < 10; $h++): ?>
                            <div class="media-page-perf-hole"></div>
                            <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        
                        <div class="media-page-film-perf-right">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($h = 0; $h < 10; $h++): ?>
                            <div class="media-page-perf-hole"></div>
                            <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        
                        <!-- Frame numbers -->
                        <div class="media-page-frame-number-tl">///01</div>
                        <div class="media-page-frame-number-tr">01A</div>
                        <div class="media-page-frame-number-bl">35MM</div>
                        <div class="media-page-frame-number-br">1</div>
                        
                        <!-- Thumbnail with random image -->
                        <div class="media-page-film-thumbnail" style="background: url('<?php echo [
                            'https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?w=600',
                            'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?w=600',
                            'https://images.unsplash.com/photo-1514320291840-2e0a9bf2a9ae?w=600',
                            'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?w=600'
                        ][rand(0, 3)]; ?>') center/cover;"></div>
                        
                        <!-- Media text overlay -->
                        <div class="media-page-film-text">
                            Media
                        </div>
                    </div>
                </div>
                
                <!-- TITOLO A FIANCO -->
                <div class="text-center md:text-left">
                    <h1 class="text-5xl md:text-7xl lg:text-8xl font-black text-white leading-tight" style="font-family: 'Crimson Pro', serif;">
                        Video & <span class="italic text-primary-400">Foto</span>
                    </h1>
                    <p class="text-xl md:text-2xl text-white/80 mt-4 font-medium">
                        Dalla community Slamin
                    </p>
                    
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                        <div class="flex flex-col sm:flex-row gap-3 mt-6 justify-center md:justify-start">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('upload.video')): ?>
                                <button type="button"
                                        wire:click="navigateToVideoUpload"
                                        class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-semibold shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                    <span><?php echo e(__('media.upload_video')); ?></span>
                                </button>
                            <?php endif; ?>
                            
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('upload.photo')): ?>
                                <a href="#" 
                                   class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-accent-600 hover:bg-accent-700 text-white font-semibold shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span><?php echo e(__('media.upload_photo')); ?></span>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    
    <section class="relative py-12 md:py-16 film-studio-section">
        <div class="max-w-[1800px] mx-auto px-4 sm:px-6 lg:px-8">
            
            
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-10">
                <div class="flex items-baseline gap-4">
                    <h2 class="text-5xl md:text-7xl font-black text-neutral-900 dark:text-white" style="font-family: 'Crimson Pro', serif;">
                        Video
                    </h2>
                    <div class="text-primary-600 dark:text-primary-400 text-3xl md:text-4xl font-black">
                        <?php echo e($videoType === 'popular' ? ($popularVideos->count() + 1) : ($recentVideos->count() + 1)); ?>

                    </div>
                </div>

                
                <div class="flex items-center gap-1 bg-neutral-100 dark:bg-neutral-800 p-1 rounded-full self-start md:self-auto">
                    <button wire:click="toggleVideoType('popular')"
                            class="px-4 md:px-6 py-2 md:py-3 rounded-full font-black text-xs md:text-sm transition-all <?php echo e($videoType === 'popular' ? 'bg-primary-600 text-white shadow-lg' : 'text-neutral-600 dark:text-neutral-400'); ?>">
                        POPOLARI
                    </button>
                    <button wire:click="toggleVideoType('recent')"
                            class="px-4 md:px-6 py-2 md:py-3 rounded-full font-black text-xs md:text-sm transition-all <?php echo e($videoType === 'recent' ? 'bg-accent-600 text-white shadow-lg' : 'text-neutral-600 dark:text-neutral-400'); ?>">
                        RECENTI
                    </button>
                </div>
            </div>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($mostPopularVideo): ?>
                <?php $videos = $videoType === 'popular' ? $popularVideos : $recentVideos; ?>
                
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
                    
                    <div class="lg:col-span-2 group cursor-pointer rounded-lg overflow-hidden bg-black"
                         onclick="Livewire.dispatch('openVideoModal', { videoId: <?php echo e($mostPopularVideo->id); ?> })"
                         x-data="{ visible: false }" 
                         x-intersect.once="visible = true">
                        <div x-show="visible"
                             x-transition:enter="transition ease-out duration-1000"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="relative aspect-video">
                            
                            <img src="<?php echo e($mostPopularVideo->thumbnail_url); ?>" 
                                 onerror="this.src='https://images.unsplash.com/photo-1574375927938-d5a98e8ffe85?w=1200&q=80'"
                                 class="absolute inset-0 w-full h-full object-cover"
                                 style="object-position: 50% 35%;">
                            <div class="absolute inset-0 bg-gradient-to-tr from-black/80 via-black/40 to-transparent"></div>

                            
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-20 h-20 md:w-24 md:h-24 bg-white/95 backdrop-blur-sm rounded-full flex items-center justify-center shadow-2xl group-hover:scale-110 transition-all">
                                    <svg class="w-12 h-12 text-primary-600 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                </div>
                            </div>

                            
                            <div class="absolute bottom-0 left-0 right-0 p-4 md:p-6 bg-gradient-to-t from-black/95 to-transparent">
                                <div class="inline-block px-3 py-1 bg-primary-600 rounded-full mb-2 md:mb-3">
                                    <span class="text-white text-xs font-bold tracking-wider">IN EVIDENZA</span>
                                </div>
                                <h3 class="text-xl md:text-3xl font-bold text-white mb-2 md:mb-3 line-clamp-2" style="font-family: 'Crimson Pro', serif;">
                                    <?php echo e($mostPopularVideo->title); ?>

                                </h3>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($mostPopularVideo->user): ?>
                                    <div class="flex items-center gap-2 mb-3">
                                        <img src="<?php echo e($mostPopularVideo->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($mostPopularVideo->user->name) . '&background=059669&color=fff'); ?>" 
                                             alt="<?php echo e($mostPopularVideo->user->name); ?>"
                                             class="w-7 h-7 md:w-8 md:h-8 rounded-full object-cover ring-2 ring-white/30">
                                        <a href="<?php echo e(\App\Helpers\AvatarHelper::getUserProfileUrl($mostPopularVideo->user)); ?>" 
                                           class="text-white hover:text-white/80 font-semibold text-sm md:text-base hover:underline transition-colors">
                                            <?php echo e(\App\Helpers\AvatarHelper::getDisplayName($mostPopularVideo->user)); ?>

                                        </a>
                                        <span class="text-white/70 text-xs md:text-sm ml-1"><?php echo e(number_format($mostPopularVideo->view_count ?? 0)); ?> views</span>
                                    </div>
                                    
                                    
                                    <div class="flex items-center gap-3" @click.stop>
                                        <?php if (isset($component)) { $__componentOriginal332a28e2e55aa3574ada95b4497eb0b2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal332a28e2e55aa3574ada95b4497eb0b2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.like-button','data' => ['itemId' => $mostPopularVideo->id,'itemType' => 'video','isLiked' => false,'likesCount' => $mostPopularVideo->like_count ?? 0,'size' => 'sm','class' => '[&_span]:!text-white/90 [&_svg]:!text-white/90 [&_svg]:w-4 [&_svg]:h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('like-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($mostPopularVideo->id),'itemType' => 'video','isLiked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'likesCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($mostPopularVideo->like_count ?? 0),'size' => 'sm','class' => '[&_span]:!text-white/90 [&_svg]:!text-white/90 [&_svg]:w-4 [&_svg]:h-4']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.comment-button','data' => ['itemId' => $mostPopularVideo->id,'itemType' => 'video','commentsCount' => $mostPopularVideo->comment_count ?? 0,'size' => 'sm','class' => '[&_button]:!text-white/90 [&_span]:!text-white/90 [&_svg]:!stroke-white [&_svg]:w-4 [&_svg]:h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('comment-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($mostPopularVideo->id),'itemType' => 'video','commentsCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($mostPopularVideo->comment_count ?? 0),'size' => 'sm','class' => '[&_button]:!text-white/90 [&_span]:!text-white/90 [&_svg]:!stroke-white [&_svg]:w-4 [&_svg]:h-4']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.share-button','data' => ['itemId' => $mostPopularVideo->id,'itemType' => 'video','size' => 'sm','class' => '[&_button]:!text-white/90 [&_svg]:!stroke-white [&_svg]:w-4 [&_svg]:h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('share-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($mostPopularVideo->id),'itemType' => 'video','size' => 'sm','class' => '[&_button]:!text-white/90 [&_svg]:!stroke-white [&_svg]:w-4 [&_svg]:h-4']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.report-button','data' => ['itemId' => $mostPopularVideo->id,'itemType' => 'video','size' => 'sm','class' => '[&_button]:!text-white/90 [&_svg]:!stroke-white [&_svg]:w-4 [&_svg]:h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('report-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($mostPopularVideo->id),'itemType' => 'video','size' => 'sm','class' => '[&_button]:!text-white/90 [&_svg]:!stroke-white [&_svg]:w-4 [&_svg]:h-4']); ?>
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
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>

                    
                    <div class="grid grid-cols-2 lg:grid-cols-1 gap-4">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $videos->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if (isset($component)) { $__componentOriginal62e51b8b2b86176d67a62d57d4552eec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal62e51b8b2b86176d67a62d57d4552eec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.video-frame-light','data' => ['video' => $video,'index' => $index + 2]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('video-frame-light'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['video' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($video),'index' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($index + 2)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal62e51b8b2b86176d67a62d57d4552eec)): ?>
<?php $attributes = $__attributesOriginal62e51b8b2b86176d67a62d57d4552eec; ?>
<?php unset($__attributesOriginal62e51b8b2b86176d67a62d57d4552eec); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal62e51b8b2b86176d67a62d57d4552eec)): ?>
<?php $component = $__componentOriginal62e51b8b2b86176d67a62d57d4552eec; ?>
<?php unset($__componentOriginal62e51b8b2b86176d67a62d57d4552eec); ?>
<?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $videos->skip(2)->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if (isset($component)) { $__componentOriginal62e51b8b2b86176d67a62d57d4552eec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal62e51b8b2b86176d67a62d57d4552eec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.video-frame-light','data' => ['video' => $video,'index' => $index + 4]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('video-frame-light'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['video' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($video),'index' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($index + 4)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal62e51b8b2b86176d67a62d57d4552eec)): ?>
<?php $attributes = $__attributesOriginal62e51b8b2b86176d67a62d57d4552eec; ?>
<?php unset($__attributesOriginal62e51b8b2b86176d67a62d57d4552eec); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal62e51b8b2b86176d67a62d57d4552eec)): ?>
<?php $component = $__componentOriginal62e51b8b2b86176d67a62d57d4552eec; ?>
<?php unset($__componentOriginal62e51b8b2b86176d67a62d57d4552eec); ?>
<?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </section>

    
    <section class="relative py-12 md:py-16 bg-white dark:bg-neutral-900">
        <div class="max-w-[1800px] mx-auto px-4 sm:px-6 lg:px-8">
            
            
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-10">
                <div class="flex items-baseline gap-4">
                    <h2 class="text-5xl md:text-7xl font-black text-neutral-900 dark:text-white" style="font-family: 'Crimson Pro', serif;">
                        Foto
                    </h2>
                    <div class="text-accent-600 dark:text-accent-400 text-3xl md:text-4xl font-black">
                        <?php echo e($photoType === 'popular' ? ($popularPhotos->count() + 1) : ($recentPhotos->count() + 1)); ?>

                    </div>
                </div>

                
                <div class="flex items-center gap-1 bg-white dark:bg-neutral-800 p-1 rounded-full shadow-xl self-start md:self-auto">
                    <button wire:click="togglePhotoType('popular')"
                            class="px-4 md:px-6 py-2 md:py-3 rounded-full font-black text-xs md:text-sm transition-all <?php echo e($photoType === 'popular' ? 'bg-accent-600 text-white shadow-lg' : 'text-neutral-600 dark:text-neutral-400'); ?>">
                        POPOLARI
                    </button>
                    <button wire:click="togglePhotoType('recent')"
                            class="px-4 md:px-6 py-2 md:py-3 rounded-full font-black text-xs md:text-sm transition-all <?php echo e($photoType === 'recent' ? 'bg-primary-600 text-white shadow-lg' : 'text-neutral-600 dark:text-neutral-400'); ?>">
                        RECENTI
                    </button>
                </div>
            </div>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($mostPopularPhoto): ?>
                <?php $photos = $photoType === 'popular' ? $popularPhotos : $recentPhotos; ?>
                
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
                    
                    <div class="lg:col-span-2 group cursor-pointer rounded-lg overflow-hidden bg-neutral-100 dark:bg-neutral-800"
                         onclick="Livewire.dispatch('openPhotoModal', { photoId: <?php echo e($mostPopularPhoto->id); ?> })"
                         x-data="{ visible: false }" 
                         x-intersect.once="visible = true">
                        <div x-show="visible"
                             x-transition:enter="transition ease-out duration-1000"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="h-full relative aspect-square lg:aspect-[4/3]">
                            
                            <img src="<?php echo e($mostPopularPhoto->image_url); ?>" 
                                 onerror="this.src='https://images.unsplash.com/photo-1452587925148-ce544e77e70d?w=1200&q=80'"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 filter grayscale hover:grayscale-0"
                                 style="object-position: center 35%;">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>

                            
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                <div class="w-16 h-16 md:w-20 md:h-20 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-2xl">
                                    <svg class="w-8 h-8 md:w-10 md:h-10 text-neutral-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/>
                                    </svg>
                                </div>
                            </div>

                            
                            <div class="absolute bottom-0 left-0 right-0 p-4 md:p-6 bg-gradient-to-t from-black/95 to-transparent">
                                <div class="inline-block px-3 py-1 bg-accent-600 rounded-full mb-2 md:mb-3">
                                    <span class="text-white text-xs font-bold tracking-wider">IN EVIDENZA</span>
                                </div>
                                <h3 class="text-xl md:text-3xl font-bold text-white mb-2 md:mb-3 line-clamp-2" style="font-family: 'Crimson Pro', serif;">
                                    <?php echo e($mostPopularPhoto->title ?? __('media.untitled')); ?>

                                </h3>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($mostPopularPhoto->user): ?>
                                    <div class="flex items-center gap-2 mb-3">
                                        <img src="<?php echo e($mostPopularPhoto->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($mostPopularPhoto->user->name) . '&background=059669&color=fff'); ?>" 
                                             alt="<?php echo e($mostPopularPhoto->user->name); ?>"
                                             class="w-7 h-7 md:w-8 md:h-8 rounded-full object-cover ring-2 ring-white/30">
                                        <a href="<?php echo e(\App\Helpers\AvatarHelper::getUserProfileUrl($mostPopularPhoto->user)); ?>" 
                                           class="text-white hover:text-white/80 font-semibold text-sm md:text-base hover:underline transition-colors">
                                            <?php echo e(\App\Helpers\AvatarHelper::getDisplayName($mostPopularPhoto->user)); ?>

                                        </a>
                                        <span class="text-white/70 text-xs md:text-sm ml-1"><?php echo e(number_format($mostPopularPhoto->view_count ?? 0)); ?> views</span>
                                    </div>
                                    
                                    
                                    <div class="flex items-center gap-3" @click.stop>
                                        <?php if (isset($component)) { $__componentOriginal332a28e2e55aa3574ada95b4497eb0b2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal332a28e2e55aa3574ada95b4497eb0b2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.like-button','data' => ['itemId' => $mostPopularPhoto->id,'itemType' => 'photo','isLiked' => false,'likesCount' => $mostPopularPhoto->like_count ?? 0,'size' => 'sm','class' => '[&_span]:!text-white/90 [&_svg]:!text-white/90 [&_svg]:w-4 [&_svg]:h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('like-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($mostPopularPhoto->id),'itemType' => 'photo','isLiked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'likesCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($mostPopularPhoto->like_count ?? 0),'size' => 'sm','class' => '[&_span]:!text-white/90 [&_svg]:!text-white/90 [&_svg]:w-4 [&_svg]:h-4']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.comment-button','data' => ['itemId' => $mostPopularPhoto->id,'itemType' => 'photo','commentsCount' => $mostPopularPhoto->comment_count ?? 0,'size' => 'sm','class' => '[&_button]:!text-white/90 [&_span]:!text-white/90 [&_svg]:!stroke-white [&_svg]:w-4 [&_svg]:h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('comment-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($mostPopularPhoto->id),'itemType' => 'photo','commentsCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($mostPopularPhoto->comment_count ?? 0),'size' => 'sm','class' => '[&_button]:!text-white/90 [&_span]:!text-white/90 [&_svg]:!stroke-white [&_svg]:w-4 [&_svg]:h-4']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.share-button','data' => ['itemId' => $mostPopularPhoto->id,'itemType' => 'photo','size' => 'sm','class' => '[&_button]:!text-white/90 [&_svg]:!stroke-white [&_svg]:w-4 [&_svg]:h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('share-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($mostPopularPhoto->id),'itemType' => 'photo','size' => 'sm','class' => '[&_button]:!text-white/90 [&_svg]:!stroke-white [&_svg]:w-4 [&_svg]:h-4']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.report-button','data' => ['itemId' => $mostPopularPhoto->id,'itemType' => 'photo','size' => 'sm','class' => '[&_button]:!text-white/90 [&_svg]:!stroke-white [&_svg]:w-4 [&_svg]:h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('report-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($mostPopularPhoto->id),'itemType' => 'photo','size' => 'sm','class' => '[&_button]:!text-white/90 [&_svg]:!stroke-white [&_svg]:w-4 [&_svg]:h-4']); ?>
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
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>

                    
                    <div class="grid grid-cols-2 lg:grid-cols-1 gap-4">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $photos->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if (isset($component)) { $__componentOriginal3ab8e5e52dd40d94912cf644687ff420 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3ab8e5e52dd40d94912cf644687ff420 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.photo-frame-light','data' => ['photo' => $photo,'index' => $index + 2]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('photo-frame-light'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['photo' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($photo),'index' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($index + 2)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3ab8e5e52dd40d94912cf644687ff420)): ?>
<?php $attributes = $__attributesOriginal3ab8e5e52dd40d94912cf644687ff420; ?>
<?php unset($__attributesOriginal3ab8e5e52dd40d94912cf644687ff420); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3ab8e5e52dd40d94912cf644687ff420)): ?>
<?php $component = $__componentOriginal3ab8e5e52dd40d94912cf644687ff420; ?>
<?php unset($__componentOriginal3ab8e5e52dd40d94912cf644687ff420); ?>
<?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $photos->skip(2)->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if (isset($component)) { $__componentOriginal3ab8e5e52dd40d94912cf644687ff420 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3ab8e5e52dd40d94912cf644687ff420 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.photo-frame-light','data' => ['photo' => $photo,'index' => $index + 4]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('photo-frame-light'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['photo' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($photo),'index' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($index + 4)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3ab8e5e52dd40d94912cf644687ff420)): ?>
<?php $attributes = $__attributesOriginal3ab8e5e52dd40d94912cf644687ff420; ?>
<?php unset($__attributesOriginal3ab8e5e52dd40d94912cf644687ff420); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3ab8e5e52dd40d94912cf644687ff420)): ?>
<?php $component = $__componentOriginal3ab8e5e52dd40d94912cf644687ff420; ?>
<?php unset($__componentOriginal3ab8e5e52dd40d94912cf644687ff420); ?>
<?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </section>

    
    <section class="relative py-20 bg-neutral-900 dark:bg-black">
        
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle, #10b981 1px, transparent 1px); background-size: 40px 40px;"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            
            
            <div class="text-center mb-12">
                <h2 class="text-6xl md:text-7xl font-black text-white mb-4" style="font-family: 'Crimson Pro', serif;">
                    Ricerca
                </h2>
                <p class="text-white/60 text-xl">Trova ciò che cerchi</p>
            </div>

            
            <div class="max-w-4xl mx-auto mb-12">
                <div class="relative">
                    <input type="text"
                           wire:model.live.debounce.300ms="searchQuery"
                           placeholder="<?php echo e(__('media.search_placeholder')); ?>"
                           class="w-full px-8 py-6 pl-16 bg-white/10 backdrop-blur-lg border-2 border-white/20 text-white placeholder:text-white/40 rounded-2xl
                                  focus:border-primary-500 focus:bg-white/15 transition-all text-xl font-bold">
                    <svg class="absolute left-6 top-1/2 -translate-y-1/2 w-6 h-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>

            
            <div class="grid md:grid-cols-5 gap-4 mb-16 max-w-5xl mx-auto">
                <div class="relative">
                    <select wire:model.live="mediaType"
                            class="w-full px-5 py-4 bg-white/5 border border-white/10 text-white appearance-none rounded-xl font-bold
                                   focus:border-primary-500 transition-all">
                        <option value="" class="bg-neutral-900">Tutti i Media</option>
                        <option value="video" class="bg-neutral-900">Solo Video</option>
                        <option value="photo" class="bg-neutral-900">Solo Foto</option>
                    </select>
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 text-white/50 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>

                <input type="text"
                       wire:model.live.debounce.300ms="userId"
                       placeholder="Utente..."
                       class="px-5 py-4 bg-white/5 border border-white/10 text-white placeholder:text-white/30 rounded-xl font-bold
                              focus:border-primary-500 transition-all">

                <input type="date"
                       wire:model.live="dateFrom"
                       class="px-5 py-4 bg-white/5 border border-white/10 text-white rounded-xl font-bold
                              focus:border-primary-500 transition-all">

                <input type="date"
                       wire:model.live="dateTo"
                       class="px-5 py-4 bg-white/5 border border-white/10 text-white rounded-xl font-bold
                              focus:border-primary-500 transition-all">

                <button wire:click="clearSearch"
                        class="px-5 py-4 bg-white/10 hover:bg-white/20 border border-white/20 text-white font-black rounded-xl transform hover:scale-105 transition-all">
                    <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasActiveSearch && $searchResults['total'] > 0): ?>
                <div class="mb-12 flex items-center justify-center gap-4">
                    <div class="h-px w-32 bg-gradient-to-r from-transparent to-primary-600"></div>
                    <div class="px-6 py-3 bg-primary-600 rounded-full">
                        <span class="text-white font-black text-xl"><?php echo e($searchResults['total']); ?> RISULTATI</span>
                    </div>
                    <div class="h-px w-32 bg-gradient-to-l from-transparent to-primary-600"></div>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $searchResults['videos']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="group cursor-pointer relative overflow-hidden" 
                             onclick="Livewire.dispatch('openVideoModal', { videoId: <?php echo e($video->id); ?> })">
                            <div class="aspect-[3/4] relative bg-neutral-800">
                                <img src="<?php echo e($video->thumbnail_url); ?>" 
                                     onerror="this.src='https://images.unsplash.com/photo-1574375927938-d5a98e8ffe85?w=800&q=80'"
                                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 to-transparent"></div>
                                
                                <div class="absolute top-4 right-4">
                                    <span class="px-3 py-1.5 bg-primary-600 text-white text-xs font-black rounded-full">VIDEO</span>
                                </div>
                                
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-white/80 group-hover:scale-125 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                </div>

                                <div class="absolute bottom-0 left-0 right-0 p-5">
                                    <h4 class="text-xl font-black text-white mb-2 line-clamp-2"><?php echo e($video->title); ?></h4>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($video->user): ?>
                                        <a href="<?php echo e(\App\Helpers\AvatarHelper::getUserProfileUrl($video->user)); ?>" 
                                           class="text-white/80 hover:text-white text-sm font-medium hover:underline transition-colors">
                                            <?php echo e(\App\Helpers\AvatarHelper::getDisplayName($video->user)); ?>

                                        </a>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $searchResults['photos']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="group cursor-pointer relative overflow-hidden" 
                             onclick="Livewire.dispatch('openPhotoModal', { photoId: <?php echo e($photo->id); ?> })">
                            <div class="aspect-[3/4] relative bg-neutral-800">
                                <img src="<?php echo e($photo->image_url); ?>" 
                                     onerror="this.src='https://images.unsplash.com/photo-1452587925148-ce544e77e70d?w=800&q=80'"
                                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 to-transparent"></div>
                                
                                <div class="absolute top-4 right-4">
                                    <span class="px-3 py-1.5 bg-accent-600 text-white text-xs font-black rounded-full">FOTO</span>
                                </div>
                                
                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <svg class="w-16 h-16 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>

                                <div class="absolute bottom-0 left-0 right-0 p-5">
                                    <h4 class="text-xl font-black text-white mb-2 line-clamp-2"><?php echo e($photo->title ?? __('media.untitled')); ?></h4>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($photo->user): ?>
                                        <a href="<?php echo e(\App\Helpers\AvatarHelper::getUserProfileUrl($photo->user)); ?>" 
                                           class="text-white/80 hover:text-white text-sm font-medium hover:underline transition-colors">
                                            <?php echo e(\App\Helpers\AvatarHelper::getDisplayName($photo->user)); ?>

                                        </a>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php elseif($hasActiveSearch): ?>
                <div class="text-center py-20">
                    <div class="w-32 h-32 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-16 h-16 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <p class="text-3xl text-white/70 font-black mb-2">Nessun risultato</p>
                    <p class="text-white/50">Prova con altri filtri</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </section>

    
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('media.video-modal', []);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3062581594-0', null);

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
[$__name, $__params] = $__split('media.photo-modal', []);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3062581594-1', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

    <style>
        /* Updated: 1762971590 */
        .featured-hero-media {
            object-position: 50% 35% !important;
        }

        @media (max-width: 1024px) {
            .featured-hero-media {
                object-position: 50% 38% !important;
            }
        }

        /* ========================================
           MEDIA PAGE HERO - Film Card (come homepage)
           ======================================== */
        
        .media-page-film-card {
            position: relative;
            background: linear-gradient(90deg, 
                rgba(255, 255, 255, 0.08) 0%,
                transparent 30%
            ),
            linear-gradient(180deg, 
                rgba(80, 55, 35, 0.95) 0%,
                rgba(70, 48, 30, 0.97) 50%,
                rgba(80, 55, 35, 0.95) 100%
            );
            padding: 1.75rem 0.75rem;
            height: 250px;
            width: 200px;
            border-radius: 6px;
            box-shadow: 
                0 8px 16px rgba(0, 0, 0, 0.35),
                0 16px 32px rgba(0, 0, 0, 0.3),
                inset 0 2px 4px rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .media-page-film-card:hover {
            transform: translateY(-6px) scale(1.03);
            box-shadow: 
                0 12px 24px rgba(0, 0, 0, 0.4),
                0 20px 40px rgba(0, 0, 0, 0.35);
        }
        
        /* Film codes */
        .media-page-film-code-top,
        .media-page-film-code-bottom {
            position: absolute;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 0.65rem;
            font-weight: 700;
            color: white;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
            letter-spacing: 0.1em;
            z-index: 2;
        }
        
        .media-page-film-code-top { top: 0.4rem; }
        .media-page-film-code-bottom { bottom: 0.4rem; }
        
        /* Film frame */
        .media-page-film-frame {
            position: relative;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 2px;
            overflow: hidden;
        }
        
        /* Perforations */
        .media-page-film-perf-left,
        .media-page-film-perf-right {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 1.25rem;
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
            align-items: center;
            background: linear-gradient(180deg, 
                rgba(80, 55, 35, 0.98) 0%,
                rgba(70, 48, 30, 1) 50%,
                rgba(80, 55, 35, 0.98) 100%
            );
            z-index: 3;
        }
        
        .media-page-film-perf-left { left: 0; }
        .media-page-film-perf-right { right: 0; }
        
        .media-page-perf-hole {
            width: 14px;
            height: 12px;
            background: rgba(240, 235, 228, 0.95);
            border-radius: 1px;
            box-shadow: 
                inset 0 2px 3px rgba(0, 0, 0, 0.4),
                inset 0 1px 2px rgba(0, 0, 0, 0.3);
        }
        
        .dark .media-page-perf-hole {
            background: #1a1a1a;
        }
        
        /* Thumbnail */
        .media-page-film-thumbnail {
            position: absolute;
            inset: 0;
            z-index: 1;
        }
        
        /* Media text overlay */
        .media-page-film-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-family: 'Crimson Pro', serif;
            font-size: 2rem;
            font-weight: 900;
            color: white;
            text-shadow: 
                0 0 25px rgba(16, 185, 129, 0.9),
                0 0 50px rgba(16, 185, 129, 0.7),
                0 0 75px rgba(16, 185, 129, 0.5),
                0 4px 8px rgba(0, 0, 0, 0.9);
            z-index: 10;
            white-space: nowrap;
            letter-spacing: 0.05em;
            animation: media-glow 2s ease-in-out infinite alternate;
        }
        
        @keyframes media-glow {
            0% {
                text-shadow: 
                    0 0 25px rgba(16, 185, 129, 0.9),
                    0 0 50px rgba(16, 185, 129, 0.7),
                    0 0 75px rgba(16, 185, 129, 0.5),
                    0 4px 8px rgba(0, 0, 0, 0.9);
            }
            100% {
                text-shadow: 
                    0 0 35px rgba(16, 185, 129, 1),
                    0 0 60px rgba(16, 185, 129, 0.9),
                    0 0 95px rgba(16, 185, 129, 0.7),
                    0 6px 12px rgba(0, 0, 0, 0.9);
            }
        }
        
        /* Frame numbers */
        .media-page-frame-number-tl,
        .media-page-frame-number-tr,
        .media-page-frame-number-bl,
        .media-page-frame-number-br {
            position: absolute;
            font-size: 0.65rem;
            font-weight: 700;
            color: white;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
            z-index: 4;
        }
        
        .media-page-frame-number-tl { top: 0.4rem; left: 1.5rem; }
        .media-page-frame-number-tr { top: 0.4rem; right: 1.5rem; }
        .media-page-frame-number-bl { bottom: 0.4rem; left: 1.5rem; }
        .media-page-frame-number-br { bottom: 0.4rem; right: 1.5rem; }
        
        @media (max-width: 768px) {
            .media-page-film-card {
                width: 180px;
                height: 220px;
                padding: 1.5rem 0.7rem;
            }
            
            .media-page-film-perf-left,
            .media-page-film-perf-right {
                width: 1.1rem;
            }
            
            .media-page-perf-hole {
                width: 12px;
                height: 10px;
            }
            
            .media-page-film-text {
                font-size: 1.75rem;
            }
        }
        
        
        /* ========================================
           BACKGROUND - Lightbox per Film
           ======================================== */
        
        .film-studio-section {
            position: relative;
            background: 
                /* Lightbox pattern */
                repeating-linear-gradient(
                    0deg,
                    rgba(240, 240, 235, 0.5),
                    rgba(240, 240, 235, 0.5) 1px,
                    rgba(230, 230, 225, 0.4) 1px,
                    rgba(230, 230, 225, 0.4) 2px
                ),
                repeating-linear-gradient(
                    90deg,
                    rgba(240, 240, 235, 0.5),
                    rgba(240, 240, 235, 0.5) 1px,
                    rgba(230, 230, 225, 0.4) 1px,
                    rgba(230, 230, 225, 0.4) 2px
                ),
                url("data:image/svg+xml,%3Csvg width='100' height='100' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='grain'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='1.5' numOctaves='3' seed='5' /%3E%3C/filter%3E%3Crect width='100' height='100' filter='url(%23grain)' opacity='0.05'/%3E%3C/svg%3E"),
                radial-gradient(ellipse at center, 
                    rgba(255, 250, 240, 0.8) 0%,
                    rgba(245, 240, 230, 0.7) 50%,
                    rgba(235, 230, 220, 0.6) 100%
                ),
                linear-gradient(135deg, 
                    #f0ede8 0%,
                    #e8e5e0 25%,
                    #ece9e4 50%,
                    #e5e2dd 75%,
                    #eae7e2 100%
                );
            box-shadow: 
                inset 0 0 100px rgba(255, 250, 240, 0.3),
                inset 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        :is(.dark .film-studio-section) {
            background: 
                repeating-linear-gradient(
                    0deg,
                    rgba(40, 40, 38, 0.6),
                    rgba(40, 40, 38, 0.6) 1px,
                    rgba(35, 35, 33, 0.5) 1px,
                    rgba(35, 35, 33, 0.5) 2px
                ),
                repeating-linear-gradient(
                    90deg,
                    rgba(40, 40, 38, 0.6),
                    rgba(40, 40, 38, 0.6) 1px,
                    rgba(35, 35, 33, 0.5) 1px,
                    rgba(35, 35, 33, 0.5) 2px
                ),
                url("data:image/svg+xml,%3Csvg width='100' height='100' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='grain'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='1.5' numOctaves='3' seed='5' /%3E%3C/filter%3E%3Crect width='100' height='100' filter='url(%23grain)' opacity='0.08'/%3E%3C/svg%3E"),
                radial-gradient(ellipse at center, 
                    rgba(60, 58, 55, 0.7) 0%,
                    rgba(50, 48, 45, 0.6) 50%,
                    rgba(40, 38, 35, 0.5) 100%
                ),
                linear-gradient(135deg, 
                    #2a2826 0%,
                    #252321 25%,
                    #282624 50%,
                    #232120 75%,
                    #272523 100%
                );
            box-shadow: 
                inset 0 0 80px rgba(0, 0, 0, 0.4),
                inset 0 2px 10px rgba(0, 0, 0, 0.3);
        }
        
    </style>
</div>
<?php /**PATH /Users/mazzi/slamin_v2/resources/views/livewire/media/media-index.blade.php ENDPATH**/ ?>