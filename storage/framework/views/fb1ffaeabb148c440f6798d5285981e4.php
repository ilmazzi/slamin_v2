<div 
    x-data="{ 
        showBanner: false,
        showPreferences: false,
        necessary: true,
        analytics: false,
        
        init() {
            // Check if user has already made a choice
            const consent = localStorage.getItem('cookie_consent');
            if (!consent) {
                this.showBanner = true;
            }
        },
        
        acceptAll() {
            this.necessary = true;
            this.analytics = true;
            this.savePreferences();
            this.showBanner = false;
        },
        
        acceptNecessary() {
            this.necessary = true;
            this.analytics = false;
            this.savePreferences();
            this.showBanner = false;
        },
        
        saveCustomPreferences() {
            this.savePreferences();
            this.showBanner = false;
            this.showPreferences = false;
        },
        
        savePreferences() {
            const preferences = {
                necessary: this.necessary,
                analytics: this.analytics,
                timestamp: new Date().toISOString()
            };
            localStorage.setItem('cookie_consent', JSON.stringify(preferences));
            
            // Load analytics scripts if accepted
            if (this.analytics) {
                this.loadAnalytics();
            }
        },
        
        loadAnalytics() {
            // Example: Load Google Analytics or similar
            console.log('Analytics cookies enabled');
            // window.gtag && window.gtag('consent', 'update', { 'analytics_storage': 'granted' });
        }
    }"
    x-show="showBanner"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-4"
    class="fixed bottom-0 left-0 right-0 z-50 p-4 md:p-6"
    style="display: none;"
    x-cloak
>
    <div class="max-w-7xl mx-auto">
        <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl border border-neutral-200 dark:border-neutral-700 overflow-hidden">
            
            <!-- Main Banner -->
            <div class="p-6 md:p-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    
                    <!-- Content -->
                    <div class="flex-1">
                        <div class="flex items-start gap-3 mb-3">
                            <div class="text-3xl flex-shrink-0">🍪</div>
                            <div>
                                <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-2">
                                    <?php echo e(__('cookies.banner_title')); ?>

                                </h3>
                                <p class="text-sm text-neutral-600 dark:text-neutral-400 leading-relaxed">
                                    <?php echo e(__('cookies.banner_description')); ?>

                                </p>
                            </div>
                        </div>
                        
                        <div class="mt-4 flex flex-wrap gap-2 text-xs">
                            <a href="<?php echo e(route('cookies')); ?>" target="_blank" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 font-semibold hover:underline">
                                <?php echo e(__('cookies.learn_more')); ?>

                            </a>
                            <span class="text-neutral-400">•</span>
                            <a href="<?php echo e(route('privacy')); ?>" target="_blank" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 font-semibold hover:underline">
                                <?php echo e(__('cookies.privacy_policy')); ?>

                            </a>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row gap-3 lg:flex-shrink-0">
                        <button 
                            @click="showPreferences = !showPreferences"
                            class="px-4 py-2.5 text-sm font-semibold text-neutral-700 dark:text-neutral-300 bg-neutral-100 dark:bg-neutral-700 hover:bg-neutral-200 dark:hover:bg-neutral-600 rounded-lg transition-colors"
                        >
                            <?php echo e(__('cookies.customize')); ?>

                        </button>
                        
                        <button 
                            @click="acceptNecessary"
                            class="px-4 py-2.5 text-sm font-semibold text-neutral-700 dark:text-neutral-300 bg-neutral-100 dark:bg-neutral-700 hover:bg-neutral-200 dark:hover:bg-neutral-600 rounded-lg transition-colors"
                        >
                            <?php echo e(__('cookies.necessary_only')); ?>

                        </button>
                        
                        <button 
                            @click="acceptAll"
                            class="px-6 py-2.5 text-sm font-semibold text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors shadow-lg shadow-primary-600/30"
                        >
                            <?php echo e(__('cookies.accept_all')); ?>

                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Preferences Panel -->
            <div 
                x-show="showPreferences"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="border-t border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-900/50 p-6 md:p-8"
            >
                <h4 class="text-base font-bold text-neutral-900 dark:text-white mb-4">
                    <?php echo e(__('cookies.preferences_title')); ?>

                </h4>
                
                <div class="space-y-4">
                    <!-- Necessary Cookies -->
                    <div class="flex items-start justify-between p-4 bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700">
                        <div class="flex-1 pr-4">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-lg">🔒</span>
                                <h5 class="text-sm font-bold text-neutral-900 dark:text-white">
                                    <?php echo e(__('cookies.necessary_title')); ?>

                                </h5>
                                <span class="px-2 py-0.5 text-xs font-semibold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded">
                                    <?php echo e(__('cookies.always_active')); ?>

                                </span>
                            </div>
                            <p class="text-xs text-neutral-600 dark:text-neutral-400 leading-relaxed">
                                <?php echo e(__('cookies.necessary_description')); ?>

                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <input type="checkbox" x-model="necessary" disabled checked class="w-5 h-5 rounded border-neutral-300 text-primary-600 focus:ring-primary-500 cursor-not-allowed opacity-50">
                        </div>
                    </div>
                    
                    <!-- Analytics Cookies -->
                    <div class="flex items-start justify-between p-4 bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700">
                        <div class="flex-1 pr-4">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-lg">📊</span>
                                <h5 class="text-sm font-bold text-neutral-900 dark:text-white">
                                    <?php echo e(__('cookies.analytics_title')); ?>

                                </h5>
                            </div>
                            <p class="text-xs text-neutral-600 dark:text-neutral-400 leading-relaxed">
                                <?php echo e(__('cookies.analytics_description')); ?>

                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <input type="checkbox" x-model="analytics" class="w-5 h-5 rounded border-neutral-300 text-primary-600 focus:ring-primary-500 cursor-pointer">
                        </div>
                    </div>
                    
                    <!-- Anti-Marketing Statement -->
                    <div class="p-4 bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/20 dark:to-orange-900/20 rounded-lg border-2 border-red-200 dark:border-red-800">
                        <div class="flex items-start gap-3">
                            <span class="text-2xl flex-shrink-0">🚫</span>
                            <div>
                                <div class="flex items-center gap-2 mb-2">
                                    <h5 class="text-sm font-bold text-red-900 dark:text-red-300">
                                        <?php echo e(__('cookies.no_marketing_title')); ?>

                                    </h5>
                                </div>
                                <p class="text-xs text-red-800 dark:text-red-300 leading-relaxed font-medium">
                                    <?php echo e(__('cookies.no_marketing_statement')); ?>

                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 flex flex-col sm:flex-row gap-3">
                    <button 
                        @click="showPreferences = false"
                        class="px-4 py-2.5 text-sm font-semibold text-neutral-700 dark:text-neutral-300 bg-white dark:bg-neutral-800 hover:bg-neutral-100 dark:hover:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 rounded-lg transition-colors"
                    >
                        <?php echo e(__('cookies.cancel')); ?>

                    </button>
                    
                    <button 
                        @click="saveCustomPreferences"
                        class="px-6 py-2.5 text-sm font-semibold text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors shadow-lg shadow-primary-600/30"
                    >
                        <?php echo e(__('cookies.save_preferences')); ?>

                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/components/cookie-banner.blade.php ENDPATH**/ ?>