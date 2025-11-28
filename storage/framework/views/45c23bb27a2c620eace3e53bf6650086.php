<!-- Notification Animation with Busta Image -->
<div wire:poll.5s="pollForNewNotifications" class="notification-animation-wrapper">

    <!-- NOTIFICATION CARD (conditional) -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showAnimation): ?>
    <div class="fixed top-24 right-8 z-[9998] max-w-[450px]" 
         x-data="{ show: true }"
         x-show="show"
         x-transition:enter="transition ease-out duration-700"
         x-transition:enter-start="opacity-0 translate-x-full scale-75 rotate-12"
         x-transition:enter-end="opacity-100 translate-x-0 scale-100 rotate-0"
         x-transition:leave="transition ease-in duration-400"
         x-transition:leave-start="opacity-100 translate-x-0 scale-100"
         x-transition:leave-end="opacity-0 translate-x-full scale-75">
        
        <div class="notification-busta-container bg-gradient-to-br from-white to-neutral-50 dark:from-neutral-800 dark:to-neutral-900 rounded-3xl shadow-2xl border-2 border-primary-300 dark:border-primary-600 overflow-hidden transform hover:scale-105 transition-transform duration-300">
            
            <!-- Header with HUGE Busta -->
            <div class="relative bg-gradient-to-r from-primary-500 via-primary-600 to-primary-700 p-6 overflow-hidden">
                <!-- Animated background particles -->
                <div class="absolute inset-0 opacity-20">
                    <div class="absolute top-0 left-0 w-32 h-32 bg-white rounded-full blur-3xl animate-pulse"></div>
                    <div class="absolute bottom-0 right-0 w-40 h-40 bg-white rounded-full blur-3xl animate-pulse" style="animation-delay: 0.5s;"></div>
                </div>

                <div class="relative flex items-center gap-6">
                    <!-- HUGE Busta Image with Glow -->
                    <div class="relative flex-shrink-0 group">
                        <!-- Outer glow ring -->
                        <div class="absolute inset-0 bg-gradient-to-r from-yellow-300 via-pink-300 to-blue-300 rounded-full blur-2xl opacity-60 animate-pulse scale-150"></div>
                        
                        <!-- Rotating ring -->
                        <div class="absolute inset-0 border-4 border-dashed border-white/30 rounded-full animate-spin-slow scale-125"></div>
                        
                        <!-- Main Busta Image - MOLTO PIÙ GRANDE -->
                        <div class="relative bg-white/10 backdrop-blur-sm rounded-2xl p-4">
                            <img src="<?php echo e(asset('assets/images/busta.png')); ?>"
                                 alt="Notifica!"
                                 class="relative w-24 h-24 object-contain drop-shadow-2xl animate-bounce-slow group-hover:scale-110 transition-transform duration-300"
                                 style="filter: drop-shadow(0 0 20px rgba(255,255,255,0.8));">
                        </div>
                        
                        <!-- Enhanced Sparkles - PIÙ GRANDI -->
                        <div class="absolute -top-2 -right-2 w-4 h-4 bg-yellow-300 rounded-full animate-ping shadow-lg"></div>
                        <div class="absolute top-4 -left-2 w-3 h-3 bg-blue-300 rounded-full animate-ping shadow-lg" style="animation-delay: 0.3s;"></div>
                        <div class="absolute -bottom-2 right-4 w-3 h-3 bg-pink-300 rounded-full animate-ping shadow-lg" style="animation-delay: 0.6s;"></div>
                        
                        <!-- Exclamation badge - PIÙ GRANDE -->
                        <div class="absolute -top-3 -right-3 bg-red-500 text-white text-lg font-bold rounded-full w-10 h-10 flex items-center justify-center animate-bounce shadow-xl border-4 border-white">
                            !
                        </div>
                    </div>

                    <!-- Notification Info -->
                    <div class="flex-1 text-white">
                        <h3 class="font-bold text-2xl mb-2 drop-shadow-lg">✨ Nuova Notifica!</h3>
                        <p class="text-sm text-white/90 mb-3">Hai ricevuto una nuova interazione</p>
                        
                        <!-- CTA Buttons -->
                        <div class="flex gap-2">
                            <button @click="$dispatch('open-notification-modal'); $wire.hideAnimation()"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-white text-primary-600 rounded-full font-semibold text-sm hover:bg-primary-50 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                Tutte
                            </button>
                        </div>
                    </div>

                    <!-- Close Button -->
                    <button wire:click="hideAnimation" 
                            class="absolute top-3 right-3 flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-white/20 hover:bg-white/30 transition-colors backdrop-blur-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Content with Icon -->
            <div class="p-5 bg-gradient-to-b from-transparent to-neutral-50/50 dark:to-neutral-800/50">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-gradient-to-br from-primary-100 to-primary-200 dark:from-primary-900 dark:to-primary-800 flex items-center justify-center shadow-lg">
                        <span class="text-3xl animate-bounce-slow">💬</span>
                    </div>
                    <div class="flex-1">
                        <p class="text-base text-neutral-900 dark:text-white font-semibold mb-1">
                            Nuova attività sul tuo profilo!
                        </p>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400">
                            Qualcuno ha interagito con i tuoi contenuti. Clicca su "Visualizza" per scoprire di più.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Enhanced Animations -->
    <style>
    @keyframes bounce-slow {
        0%, 100% {
            transform: translateY(0) scale(1);
        }
        50% {
            transform: translateY(-15px) scale(1.05);
        }
    }
    
    @keyframes spin-slow {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }
    
    .animate-bounce-slow {
        animation: bounce-slow 2s ease-in-out infinite;
    }
    
    .animate-spin-slow {
        animation: spin-slow 8s linear infinite;
    }
    
    @media (max-width: 640px) {
        .notification-busta-container {
            max-width: calc(100vw - 2rem) !important;
        }
    }
    </style>

    <!-- Auto-hide after 10 seconds -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('auto-hide-notification', () => {
                setTimeout(() => {
                    window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('hideAnimation');
                }, 10000); // 10 secondi per dare tempo di leggere
            });
        });
    </script>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>

<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/livewire/components/notification-animation.blade.php ENDPATH**/ ?>