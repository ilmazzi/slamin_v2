<div>
    <?php
    $carouselSlides = $carousels ?? collect();
    ?>
    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($carouselSlides->count() > 0): ?>
    <section class="relative bg-white dark:bg-neutral-900 overflow-hidden group">
        <div class="relative"
             x-data="{
                 currentSlide: 0,
                 slides: <?php echo e($carouselSlides->count()); ?>,
                 autoplayInterval: null,
                 showArrows: false
             }"
             x-init="
                 if (slides > 1) {
                     autoplayInterval = setInterval(() => {
                         currentSlide = (currentSlide + 1) % slides;
                     }, 6000);
                 }
             "
             @mouseenter="showArrows = true; if (autoplayInterval) clearInterval(autoplayInterval)"
             @mouseleave="showArrows = false; if (slides > 1) autoplayInterval = setInterval(() => { currentSlide = (currentSlide + 1) % slides; }, 6000)">
            
                
                <div class="relative h-[500px] md:h-[600px] lg:h-[700px] overflow-hidden">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $carouselSlides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $carousel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="absolute inset-0 transition-all duration-700 ease-in-out"
                         :class="currentSlide === <?php echo e($index); ?> ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                        
                        
                        <div class="absolute inset-0">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($carousel->video_path && $carousel->videoUrl): ?>
                                <video class="w-full h-full object-cover" autoplay muted loop playsinline>
                                    <source src="<?php echo e($carousel->videoUrl); ?>" type="video/mp4">
                                </video>
                            <?php elseif($carousel->image_url || $carousel->content_image_url): ?>
                                <img src="<?php echo e($carousel->image_url ?? $carousel->content_image_url); ?>" 
                                     alt="<?php echo e($carousel->display_title); ?>"
                                     class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800"></div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            
                            
                            <div class="absolute inset-0 bg-gradient-to-r from-neutral-900/80 via-neutral-900/60 to-transparent"></div>
                            <div class="absolute inset-0 bg-gradient-to-t from-neutral-900/90 via-transparent to-transparent"></div>
                        </div>
                        
                        
                        <div class="absolute inset-0 flex items-center">
                            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                                <div class="max-w-2xl"
                                     x-show="currentSlide === <?php echo e($index); ?>"
                                     x-transition:enter="transition ease-out duration-700 delay-200"
                                     x-transition:enter-start="opacity-0 translate-x-8"
                                     x-transition:enter-end="opacity-100 translate-x-0">
                                    
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($carousel->display_title): ?>
                                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 md:mb-6 leading-tight" style="font-family: 'Crimson Pro', serif;">
                                        <?php echo $carousel->display_title; ?>

                                    </h2>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($carousel->display_description): ?>
                                    <p class="text-lg md:text-xl lg:text-2xl text-white/90 mb-6 md:mb-8 leading-relaxed">
                                        <?php echo e(\Illuminate\Support\Str::limit($carousel->display_description, 200)); ?>

                                    </p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($carousel->content_type && $carousel->content_id): ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($carousel->content_type === 'poem'): ?>
                                        <button onclick="Livewire.dispatch('openPoemModal', { poemId: <?php echo e($carousel->content_id); ?> })" 
                                                class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                            <span><?php echo e($carousel->link_text ?: __('common.discover_more')); ?></span>
                                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </button>
                                        <?php elseif($carousel->content_type === 'article'): ?>
                                        <button onclick="Livewire.dispatch('openArticleModal', { articleId: <?php echo e($carousel->content_id); ?> })" 
                                                class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                            <span><?php echo e($carousel->link_text ?: __('common.discover_more')); ?></span>
                                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </button>
                                        <?php elseif($carousel->display_url): ?>
                                        <a href="<?php echo e($carousel->display_url); ?>" 
                                           class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                            <span><?php echo e($carousel->link_text ?: __('common.discover_more')); ?></span>
                                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php elseif($carousel->display_url): ?>
                                    <a href="<?php echo e($carousel->display_url); ?>" 
                                       class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                        <span><?php echo e($carousel->link_text ?: __('common.discover_more')); ?></span>
                                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($carouselSlides->count() > 1): ?>
                <button @click="currentSlide = (currentSlide - 1 + slides) % slides"
                        x-show="showArrows"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 -translate-x-4"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-x-0"
                        x-transition:leave-end="opacity-0 -translate-x-4"
                        class="absolute left-4 md:left-8 top-1/2 -translate-y-1/2 z-20 w-14 h-14 md:w-16 md:h-16 bg-white/20 backdrop-blur-md border-2 border-white/40 rounded-full flex items-center justify-center text-white hover:bg-white/30 hover:scale-110 transition-all shadow-2xl">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                
                <button @click="currentSlide = (currentSlide + 1) % slides"
                        x-show="showArrows"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-x-4"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-x-0"
                        x-transition:leave-end="opacity-0 translate-x-4"
                        class="absolute right-4 md:right-8 top-1/2 -translate-y-1/2 z-20 w-14 h-14 md:w-16 md:h-16 bg-white/20 backdrop-blur-md border-2 border-white/40 rounded-full flex items-center justify-center text-white hover:bg-white/30 hover:scale-110 transition-all shadow-2xl">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($carouselSlides->count() > 1): ?>
                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-20 flex gap-2">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $carouselSlides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $carousel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button @click="currentSlide = <?php echo e($index); ?>"
                                class="transition-all duration-300"
                                :class="currentSlide === <?php echo e($index); ?> ? 'w-8 h-2 bg-white rounded-full' : 'w-2 h-2 bg-white/40 rounded-full hover:bg-white/60'">
                        </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/livewire/home/hero-carousel.blade.php ENDPATH**/ ?>