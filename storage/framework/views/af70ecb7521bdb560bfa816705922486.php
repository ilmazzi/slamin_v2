<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(isset($title) ? $title . ' - ' . config('app.name') : config('app.name')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Crimson+Pro:ital,wght@0,400;0,600;0,700;1,400;1,600&display=swap" rel="stylesheet">

    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Dark Mode Script - MUST run before page renders -->
    <script>
        // Initialize theme IMMEDIATELY (before page renders)
        // Preserve dark mode preference from localStorage
        (function() {
            const html = document.documentElement;
            const savedMode = localStorage.getItem('darkMode');
            
            // If no preference saved, default to LIGHT mode
            if (savedMode === null) {
                localStorage.setItem('darkMode', 'false');
                html.classList.remove('dark');
            } else if (savedMode === 'true') {
                // Add dark if explicitly saved as true
                html.classList.add('dark');
            } else {
                // Remove dark if explicitly saved as false
                html.classList.remove('dark');
            }
            
            // Set color scheme
            html.style.colorScheme = savedMode === 'true' ? 'dark' : 'light';
        })();
    </script>

    <!-- Styles & Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    
    <?php echo $__env->yieldPushContent('styles'); ?>
    
    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request()->routeIs('events.index')): ?>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/events-map.css', 'resources/css/events-index.css', 'resources/css/event-ticket.css']); ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    
    
    <?php if(request()->routeIs('events.scoring.*')): ?>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/scoring.css']); ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    
    
    <?php if(request()->routeIs('profile.*') || request()->routeIs('user.*')): ?>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/profile.css', 'resources/css/event-ticket.css', 'resources/js/profile.js']); ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/notification-animation.css']); ?>
    
    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/article-modal.css']); ?>

    <?php echo e($head ?? ''); ?>

</head>
<body class="antialiased bg-neutral-50 dark:bg-neutral-950 text-neutral-900 dark:text-neutral-100 overflow-x-hidden" 
      x-data="{ scrollY: 0, sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true' }" 
      x-init="window.addEventListener('scroll', () => { scrollY = window.scrollY; }, { passive: true })"
      @sidebar-changed.window="sidebarCollapsed = $event.detail.collapsed">
    
    <!-- Top Bar -->
    <?php if (isset($component)) { $__componentOriginal5f954b3ba4e7a1a392c014525a6ffa48 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5f954b3ba4e7a1a392c014525a6ffa48 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.topbar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.topbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5f954b3ba4e7a1a392c014525a6ffa48)): ?>
<?php $attributes = $__attributesOriginal5f954b3ba4e7a1a392c014525a6ffa48; ?>
<?php unset($__attributesOriginal5f954b3ba4e7a1a392c014525a6ffa48); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5f954b3ba4e7a1a392c014525a6ffa48)): ?>
<?php $component = $__componentOriginal5f954b3ba4e7a1a392c014525a6ffa48; ?>
<?php unset($__componentOriginal5f954b3ba4e7a1a392c014525a6ffa48); ?>
<?php endif; ?>

    <!-- Sidebar -->
    <?php if (isset($component)) { $__componentOriginala12ee38770dfc9ba212665cdb25e4cfd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala12ee38770dfc9ba212665cdb25e4cfd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.sidebar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala12ee38770dfc9ba212665cdb25e4cfd)): ?>
<?php $attributes = $__attributesOriginala12ee38770dfc9ba212665cdb25e4cfd; ?>
<?php unset($__attributesOriginala12ee38770dfc9ba212665cdb25e4cfd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala12ee38770dfc9ba212665cdb25e4cfd)): ?>
<?php $component = $__componentOriginala12ee38770dfc9ba212665cdb25e4cfd; ?>
<?php unset($__componentOriginala12ee38770dfc9ba212665cdb25e4cfd); ?>
<?php endif; ?>

    <!-- Floating Chat Button -->
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('chat.chat-button');

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-2559968631-0', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

    <!-- Main Content Area -->
    <main class="pt-[7.5rem] md:pt-16 transition-all duration-300 lg:ml-0 overflow-x-hidden"
          :class="sidebarCollapsed ? 'lg:ml-20' : 'lg:ml-64'">
        <div class="min-h-screen overflow-visible">
            <?php echo e($slot); ?>

        </div>

        <!-- Footer -->
        <?php if (isset($component)) { $__componentOriginal7f75b765bca1e533f9d8c8fa950f02fb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7f75b765bca1e533f9d8c8fa950f02fb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.footer-modern','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.footer-modern'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7f75b765bca1e533f9d8c8fa950f02fb)): ?>
<?php $attributes = $__attributesOriginal7f75b765bca1e533f9d8c8fa950f02fb; ?>
<?php unset($__attributesOriginal7f75b765bca1e533f9d8c8fa950f02fb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7f75b765bca1e533f9d8c8fa950f02fb)): ?>
<?php $component = $__componentOriginal7f75b765bca1e533f9d8c8fa950f02fb; ?>
<?php unset($__componentOriginal7f75b765bca1e533f9d8c8fa950f02fb); ?>
<?php endif; ?>
    </main>
    
    <?php echo e($scripts ?? ''); ?>


    <!-- Comments Modal -->
    <div x-data="{
        show: false,
        contentId: null,
        contentType: null,
        comments: [],
        newComment: '',
        loading: false,
        
        openModal(data) {
            this.contentId = data.id;
            this.contentType = data.type;
            this.show = true;
            this.loadComments();
        },
        
        loadComments() {
            this.loading = true;
            fetch(`<?php echo e(route('api.comments.index')); ?>?id=${this.contentId}&type=${this.contentType}`)
                .then(res => res.json())
                .then(data => {
                    this.comments = data.comments;
                    this.loading = false;
                });
        },
        
        addComment() {
            if(!this.newComment.trim()) return;
            
            fetch('<?php echo e(route('api.comments.store')); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                body: JSON.stringify({
                    id: this.contentId,
                    type: this.contentType,
                    content: this.newComment
                })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    this.comments.unshift(data.comment);
                    this.newComment = '';
                    $dispatch('notify', { message: data.message, type: 'success' });
                }
            });
        }
    }"
    @open-comments.window="openModal($event.detail)"
    x-show="show"
    x-cloak
    class="fixed inset-0 z-[10000] flex items-center justify-center p-4"
    style="display: none;">
        <!-- Backdrop -->
        <div @click="show = false" 
             x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
        
        <!-- Modal -->
        <div x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="relative bg-white dark:bg-neutral-900 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[80vh] flex flex-col">
            
            <!-- Header -->
            <div class="p-6 border-b border-neutral-200 dark:border-neutral-800 flex items-center justify-between">
                <h3 class="text-xl font-bold text-neutral-900 dark:text-white"><?php echo e(__('social.comments_title')); ?></h3>
                <button @click="show = false" class="text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Comments List -->
            <div class="flex-1 overflow-y-auto p-6 space-y-4">
                <template x-if="loading">
                    <div class="text-center py-8 text-neutral-500"><?php echo e(__('common.loading')); ?></div>
                </template>
                
                <template x-if="!loading && comments.length === 0">
                    <div class="text-center py-8 text-neutral-500"><?php echo e(__('social.no_comments')); ?></div>
                </template>
                
                <template x-for="comment in comments" :key="comment.id">
                    <div class="flex gap-3">
                        <img :src="comment.user.avatar" 
                             :alt="comment.user.name" 
                             class="w-10 h-10 rounded-full object-cover flex-shrink-0">
                        <div class="flex-1">
                            <div class="bg-neutral-100 dark:bg-neutral-800 rounded-2xl p-4">
                                <h4 class="font-semibold text-sm text-neutral-900 dark:text-white" x-text="comment.user.name"></h4>
                                <p class="text-neutral-700 dark:text-neutral-300 mt-1" x-text="comment.content"></p>
                            </div>
                            <p class="text-xs text-neutral-500 mt-1 ml-4" x-text="comment.created_at"></p>
                        </div>
                    </div>
                </template>
            </div>
            
            <!-- Comment Form -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
            <div class="p-6 border-t border-neutral-200 dark:border-neutral-800">
                <form @submit.prevent="addComment()" class="flex gap-3">
                    <img src="<?php echo e(auth()->user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=059669&color=fff'); ?>" 
                         alt="<?php echo e(auth()->user()->name); ?>" 
                         class="w-10 h-10 rounded-full object-cover flex-shrink-0">
                    <div class="flex-1 flex gap-2">
                        <input type="text" 
                               x-model="newComment"
                               placeholder="<?php echo e(__('social.write_comment_placeholder')); ?>"
                               class="flex-1 px-4 py-2 bg-neutral-100 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent text-neutral-900 dark:text-white">
                        <button type="submit"
                                class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-xl transition-colors">
                            <?php echo e(__('social.send')); ?>

                        </button>
                    </div>
                </form>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <!-- Dragon Like/Snap Animation with Confetti -->
    <div x-data="{ 
        show: false,
        confetti: [],
        animationType: 'like',
        showDragon(data) {
            if(data.type === 'like' || data.type === 'snap') {
                this.animationType = data.type;
                this.show = true;
                this.generateConfetti();
                setTimeout(() => { this.show = false; }, 2000);
            }
        },
        generateConfetti() {
            this.confetti = [];
            const colors = ['#ef4444', '#f59e0b', '#10b981', '#3b82f6', '#8b5cf6', '#ec4899', '#f97316', '#14b8a6'];
            for(let i = 0; i < 50; i++) {
                this.confetti.push({
                    id: i,
                    color: colors[Math.floor(Math.random() * colors.length)],
                    left: Math.random() * 100,
                    delay: Math.random() * 0.5,
                    duration: 2 + Math.random() * 1,
                    rotation: Math.random() * 360
                });
            }
        }
    }"
    @notify.window="showDragon($event.detail)"
    x-show="show"
    x-cloak
    class="fixed inset-0 z-[99999] flex items-center justify-center pointer-events-none"
    style="display: none;">
        <!-- Confetti -->
        <template x-for="conf in confetti" :key="conf.id">
            <div class="absolute top-0 w-3 h-3 rounded-sm"
                 :style="`
                    left: ${conf.left}%;
                    background-color: ${conf.color};
                    animation: confetti-fall ${conf.duration}s linear ${conf.delay}s forwards;
                    transform: rotate(${conf.rotation}deg);
                 `"></div>
        </template>
        
        <!-- Animated Dragon/Snap -->
        <div x-show="show"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 scale-0 rotate-[-180deg]"
             x-transition:enter-end="opacity-100 scale-100 rotate-0"
             x-transition:leave="transition ease-in duration-500"
             x-transition:leave-start="opacity-100 scale-100 rotate-0"
             x-transition:leave-end="opacity-0 scale-150 rotate-180"
             class="relative z-10">
            
            <!-- Like Animation -->
            <template x-if="animationType === 'like'">
                <img src="<?php echo e(asset('assets/images/draghetto-like.png')); ?>" 
                     alt="Like!" 
                     class="w-80 h-80 drop-shadow-2xl animate-bounce">
            </template>
            
            <!-- Snap Animation -->
            <template x-if="animationType === 'snap'">
                <img src="<?php echo e(asset('assets/images/draghetto-snap.png')); ?>" 
                     alt="Snap!" 
                     class="w-80 h-80 drop-shadow-2xl animate-bounce">
            </template>
            
            <!-- Particles Effect -->
            <div class="absolute inset-0 -z-10">
                <div class="absolute top-0 left-0 w-4 h-4 rounded-full animate-ping" 
                     :class="animationType === 'like' ? 'bg-red-500' : 'bg-primary-500'" 
                     style="animation-delay: 0ms;"></div>
                <div class="absolute top-10 right-0 w-3 h-3 rounded-full animate-ping" 
                     :class="animationType === 'like' ? 'bg-pink-500' : 'bg-primary-400'" 
                     style="animation-delay: 200ms;"></div>
                <div class="absolute bottom-0 left-10 w-5 h-5 rounded-full animate-ping" 
                     :class="animationType === 'like' ? 'bg-red-400' : 'bg-primary-600'" 
                     style="animation-delay: 400ms;"></div>
                <div class="absolute bottom-10 right-10 w-3 h-3 rounded-full animate-ping" 
                     :class="animationType === 'like' ? 'bg-pink-400' : 'bg-primary-300'" 
                     style="animation-delay: 600ms;"></div>
            </div>
        </div>
    </div>
    
    <!-- Confetti Animation CSS -->
    <style>
        @keyframes confetti-fall {
            0% {
                transform: translateY(0) rotateZ(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh) rotateZ(720deg);
                opacity: 0;
            }
        }
    </style>

    <!-- Toast Notifications (solo per info/warning/error) -->
    <div x-data="{ 
        show: false, 
        message: '', 
        type: 'success',
        showToast(data) {
            // Skip dragon likes
            if(data && data.type === 'like') return;
            
            console.log('🔔 Toast data received:', data);
            console.log('🔔 Data type:', typeof data);
            console.log('🔔 Data keys:', data ? Object.keys(data) : 'no data');
            
            // Gestisci sia array che oggetto
            if (Array.isArray(data)) {
                this.message = data[0]?.message || data.message || data[0] || 'Messaggio non disponibile';
                this.type = data[0]?.type || data.type || 'success';
            } else if (typeof data === 'object' && data !== null) {
                this.message = data.message || 'Messaggio non disponibile';
                this.type = data.type || 'success';
            } else {
                this.message = data || 'Messaggio non disponibile';
                this.type = 'success';
            }
            
            console.log('🔔 Final message:', this.message);
            console.log('🔔 Final type:', this.type);
            
            this.show = true;
            setTimeout(() => { this.show = false; }, 5000);
        }
    }"
    @notify.window="showToast($event.detail)"
    x-show="show"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-4"
    class="fixed bottom-4 right-4 z-[9999] max-w-sm">
        <div class="rounded-xl shadow-2xl overflow-hidden"
             :class="{
                'bg-success-600': type === 'success',
                'bg-info-600': type === 'info',
                'bg-warning-600': type === 'warning',
                'bg-danger-600': type === 'error'
             }">
            <div class="p-4 flex items-center gap-3">
                <!-- Icon Success -->
                <svg x-show="type === 'success'" class="w-6 h-6 text-white flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <!-- Icon Info -->
                <svg x-show="type === 'info'" class="w-6 h-6 text-white flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <!-- Icon Warning -->
                <svg x-show="type === 'warning'" class="w-6 h-6 text-white flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <!-- Icon Error -->
                <svg x-show="type === 'error'" class="w-6 h-6 text-white flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <!-- Message -->
                <span x-text="message || 'Messaggio non disponibile'" class="text-white font-medium flex-1"></span>
                <!-- Close -->
                <button @click="show = false" class="text-white/80 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
    
    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request()->routeIs('events.index')): ?>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/js/events-map.js']); ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('badge-notification', []);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-2559968631-1', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    
    
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('moderation.report-modal', []);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-2559968631-2', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    
    
    <?php if(request()->routeIs('profile.*') || request()->routeIs('user.*')): ?>
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('articles.article-modal', []);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-2559968631-3', null);

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
[$__name, $__params] = $__split('poems.poem-modal', []);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-2559968631-4', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Userback Widget -->
    <script>
        window.Userback = window.Userback || {};
        Userback.access_token = "A-XS47P2vKL4SvC5uR2tFpztFlb";
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->check()): ?>
        // Identify logged-in user
        Userback.user_data = {
            id: "<?php echo auth()->id(); ?>",
            info: {
                name: "<?php echo addslashes(auth()->user()->name); ?>",
                email: "<?php echo auth()->user()->email; ?>"
            }
        };
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        
        (function(d) {
            var s = d.createElement('script');
            s.async = true;
            s.src = 'https://static.userback.io/widget/v1.js';
            (d.head || d.body).appendChild(s);
        })(document);
    </script>
</body>
</html>
<?php /**PATH /Users/mazzi/slamin_v2/resources/views/components/layouts/app.blade.php ENDPATH**/ ?>