<div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isOpen && $video): ?>
        
        <div class="fixed inset-0 bg-black/80 backdrop-blur-sm z-[9999] flex items-center justify-center p-4"
             x-data="{ 
                 show: <?php if ((object) ('isOpen') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('isOpen'->value()); ?>')<?php echo e('isOpen'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('isOpen'); ?>')<?php endif; ?>,
                 playVideo() {
                     setTimeout(() => {
                         const video = this.$el.querySelector('video');
                         if (video) {
                             video.load();
                             video.play().catch(e => console.log('Play bloccato:', e));
                         }
                     }, 100);
                 }
             }"
             x-show="show"
             x-init="playVideo()"
             @open-video.window="playVideo()"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click.self="$wire.closeModal()"
             @keydown.escape.window="$wire.closeModal()">
            
            
            <div class="relative w-full max-w-5xl bg-white dark:bg-neutral-900 rounded-3xl shadow-2xl overflow-hidden"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 @click.stop>
                
                
                <button wire:click="closeModal"
                        class="absolute top-4 right-4 z-10 w-10 h-10 bg-black/50 hover:bg-black/70 backdrop-blur-sm rounded-full flex items-center justify-center text-white transition-all hover:scale-110">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($videoDirectUrl): ?>
                    <div class="px-6 pt-16 pb-3 bg-neutral-900 flex items-center gap-4">
                        <div class="flex-1">
                            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('snap.snap-timeline', ['video' => $video]);

$key = 'snap-timeline-modal-' . $video->id;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-2507620461-0', 'snap-timeline-modal-' . $video->id);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                        </div>
                        
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                        <button @click.stop="$dispatch('open-snap-modal')"
                                class="flex-shrink-0 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-full shadow-lg hover:scale-105 transition-all duration-300 flex items-center gap-2">
                            <img src="<?php echo e(asset('assets/icon/new/snap.svg')); ?>" 
                                 alt="Snap" 
                                 class="w-5 h-5"
                                 style="filter: brightness(0) saturate(100%) invert(100%);">
                            <span class="text-sm font-medium"><?php echo e(__('media.create_snap')); ?></span>
                        </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <div class="aspect-video bg-black relative" 
                     @seek-video.window="seekToTime($event.detail.timestamp)"
                     @open-snap-modal.window="openSnapModal()"
                     x-data="{
                    currentTime: 0,
                    duration: 0,
                    snapTimestamp: 0,
                    showSnapModal: false,
                    snapTitle: '',
                    snapDescription: '',
                    
                    updateTime(event) {
                        this.currentTime = event.target.currentTime;
                        // Ottieni durata reale dal player
                        if (event.target.duration && !isNaN(event.target.duration)) {
                            this.duration = event.target.duration;
                        }
                        // Dispatch per aggiornare timeline
                        Livewire.dispatch('video-time-update', [this.currentTime, this.duration]);
                    },
                    
                    seekToTime(timestamp) {
                        const video = this.$refs.videoPlayer;
                        if (video) {
                            video.currentTime = timestamp;
                            video.play();
                        }
                    },
                    
                    openSnapModal() {
                        // Salva il timestamp CORRENTE quando apri il modal
                        this.snapTimestamp = Math.floor(this.currentTime);
                        // Opzionalmente metti in pausa il video
                        const video = this.$refs.videoPlayer;
                        if (video) video.pause();
                        this.showSnapModal = true;
                    },
                    
                    async createSnap() {
                        if (!this.snapTitle) return;
                        
                        <?php if(auth()->guard()->guest()): ?>
                            window.dispatchEvent(new CustomEvent('notify', { 
                                detail: { 
                                    message: 'Devi effettuare il login per creare snap!', 
                                    type: 'error' 
                                } 
                            }));
                            setTimeout(() => window.location.href = '<?php echo e(route('login')); ?>', 1500);
                            return;
                        <?php endif; ?>
                        
                        try {
                            const response = await fetch('<?php echo e(route('api.snaps.store')); ?>', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                                },
                                body: JSON.stringify({
                                    video_id: <?php echo e($video->id); ?>,
                                    title: this.snapTitle,
                                    description: this.snapDescription,
                                    timestamp: this.snapTimestamp
                                })
                            });
                            
                            const text = await response.text();
                            
                            let data;
                            try {
                                data = JSON.parse(text);
                            } catch (e) {
                                console.error('JSON parse error:', e, 'Response:', text);
                                window.dispatchEvent(new CustomEvent('notify', { 
                                    detail: { 
                                        message: 'Errore nel salvataggio dello snap', 
                                        type: 'error' 
                                    } 
                                }));
                                return;
                            }
                            
                            if (data.success) {
                                this.snapTitle = '';
                                this.snapDescription = '';
                                this.showSnapModal = false;
                                
                                // Animazione draghetto come per i like
                                window.dispatchEvent(new CustomEvent('notify', { 
                                    detail: { 
                                        message: data.message || 'Snap creato!', 
                                        type: 'snap' 
                                    } 
                                }));
                                
                                // Refresh timeline
                                Livewire.dispatch('snap-created', { videoId: <?php echo e($video->id); ?> });
                            } else {
                                window.dispatchEvent(new CustomEvent('notify', { 
                                    detail: { 
                                        message: data.message || 'Impossibile creare lo snap', 
                                        type: 'error' 
                                    } 
                                }));
                            }
                        } catch (error) {
                            console.error('Error creating snap:', error);
                            window.dispatchEvent(new CustomEvent('notify', { 
                                detail: { 
                                    message: 'Errore: ' + error.message, 
                                    type: 'error' 
                                } 
                            }));
                        }
                    }
                }">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($videoDirectUrl): ?>
                        
                        <video x-ref="videoPlayer"
                               controls 
                               playsinline
                               webkit-playsinline
                               preload="auto"
                               class="w-full h-full"
                               @loadedmetadata="if ($event.target.duration) { duration = $event.target.duration; Livewire.dispatch('video-time-update', [currentTime, duration]); }"
                               @timeupdate="updateTime($event)"
                               src="<?php echo e($videoDirectUrl); ?>">
                            Your browser does not support the video tag.
                        </video>
                        
                        
                        
                        <template x-if="showSnapModal">
                            <div class="fixed inset-0 z-[10000] flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm"
                                 @click.self="showSnapModal = false">
                                <div class="relative w-full max-w-md bg-white dark:bg-neutral-800 rounded-2xl overflow-hidden"
                                     @click.stop>
                                    
                                    
                                    <div class="flex items-center justify-between p-6 border-b border-neutral-200 dark:border-neutral-700">
                                        <div class="flex items-center gap-2">
                                            <img src="<?php echo e(asset('assets/icon/new/snap.svg')); ?>" 
                                                 alt="Snap" 
                                                 class="w-6 h-6"
                                                 style="filter: brightness(0) saturate(100%) invert(27%) sepia(98%) saturate(2618%) hue-rotate(346deg) brightness(94%) contrast(97%);">
                                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white"><?php echo e(__('media.create_snap')); ?></h3>
                                        </div>
                                        <button @click="showSnapModal = false"
                                                class="text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-300">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    
                                    <div class="p-6 space-y-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                                                <?php echo e(__('media.title')); ?> *
                                            </label>
                                            <input type="text" 
                                                   x-model="snapTitle"
                                                   class="w-full px-4 py-2 border-2 border-neutral-200 dark:border-neutral-700 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:bg-neutral-700 dark:text-white transition-all"
                                                   placeholder="<?php echo e(__('media.snap_title_placeholder')); ?>">
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                                                <?php echo e(__('media.description')); ?>

                                            </label>
                                            <textarea x-model="snapDescription"
                                                      class="w-full px-4 py-2 border-2 border-neutral-200 dark:border-neutral-700 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:bg-neutral-700 dark:text-white transition-all resize-none"
                                                      rows="3"
                                                      placeholder="<?php echo e(__('media.snap_description_placeholder')); ?>"></textarea>
                                        </div>
                                        
                                        <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-neutral-400 bg-neutral-50 dark:bg-neutral-700 px-4 py-2 rounded-lg">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="font-medium" x-text="Math.floor(snapTimestamp / 60) + ':' + String(snapTimestamp % 60).padStart(2, '0')"></span>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="flex items-center justify-end gap-3 p-6 border-t border-neutral-200 dark:border-neutral-700">
                                        <button @click="showSnapModal = false"
                                                class="px-5 py-2.5 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700 rounded-xl font-medium">
                                            <?php echo e(__('common.cancel')); ?>

                                        </button>
                                        <button @click="createSnap()"
                                                :disabled="!snapTitle"
                                                class="px-5 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-medium disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                                            <img src="<?php echo e(asset('assets/icon/new/snap.svg')); ?>" 
                                                 alt="Snap" 
                                                 class="w-5 h-5"
                                                 style="filter: brightness(0) saturate(100%) invert(100%);">
                                            <?php echo e(__('media.create_snap')); ?>

                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    <?php else: ?>
                        
                        <div class="flex items-center justify-center h-full">
                            <div class="text-center text-white">
                                <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-lg">Video non disponibile</p>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div class="p-6 border-t border-neutral-200 dark:border-neutral-800">
                    <h2 class="text-2xl font-black text-neutral-900 dark:text-white mb-3" style="font-family: 'Crimson Pro', serif;">
                        <?php echo e($video->title); ?>

                    </h2>
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($video->description): ?>
                        <p class="text-neutral-600 dark:text-neutral-400 mb-4">
                            <?php echo e($video->description); ?>

                        </p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <div class="flex items-center justify-between">
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($video->user): ?>
                            <div class="flex items-center gap-3">
                                <?php if (isset($component)) { $__componentOriginal2252ef3298868bc9de4c534a2a83a2a2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2252ef3298868bc9de4c534a2a83a2a2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.user-avatar','data' => ['user' => $video->user,'size' => 'md','showName' => true,'showNickname' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.user-avatar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['user' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($video->user),'size' => 'md','showName' => true,'showNickname' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2252ef3298868bc9de4c534a2a83a2a2)): ?>
<?php $attributes = $__attributesOriginal2252ef3298868bc9de4c534a2a83a2a2; ?>
<?php unset($__attributesOriginal2252ef3298868bc9de4c534a2a83a2a2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2252ef3298868bc9de4c534a2a83a2a2)): ?>
<?php $component = $__componentOriginal2252ef3298868bc9de4c534a2a83a2a2; ?>
<?php unset($__componentOriginal2252ef3298868bc9de4c534a2a83a2a2); ?>
<?php endif; ?>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        
                        <div class="flex items-center gap-3">
                            <?php if (isset($component)) { $__componentOriginal332a28e2e55aa3574ada95b4497eb0b2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal332a28e2e55aa3574ada95b4497eb0b2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.like-button','data' => ['itemId' => $video->id,'itemType' => 'video','isLiked' => false,'likesCount' => $video->likes_count ?? 0,'size' => 'md']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('like-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($video->id),'itemType' => 'video','isLiked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'likesCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($video->likes_count ?? 0),'size' => 'md']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.comment-button','data' => ['itemId' => $video->id,'itemType' => 'video','commentsCount' => $video->comments_count ?? 0,'size' => 'md']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('comment-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($video->id),'itemType' => 'video','commentsCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($video->comments_count ?? 0),'size' => 'md']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.share-button','data' => ['itemId' => $video->id,'itemType' => 'video','size' => 'md']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('share-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($video->id),'itemType' => 'video','size' => 'md']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.report-button','data' => ['itemId' => $video->id,'itemType' => 'video','size' => 'md']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('report-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($video->id),'itemType' => 'video','size' => 'md']); ?>
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
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>


<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/livewire/media/video-modal.blade.php ENDPATH**/ ?>