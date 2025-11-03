<div>
    <div class="max-w-6xl mx-auto px-4 md:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-3xl md:text-4xl font-bold text-neutral-900 dark:text-white mb-2">
                La Community in Numeri
            </h2>
            <p class="text-neutral-600 dark:text-neutral-400">La nostra crescita continua</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
            <!-- Users -->
            <div class="text-center group"
                 x-data="{ count: 0, target: {{ $stats['total_users'] ?? 0 }}, started: false }"
                 x-intersect:enter.half.once="if (!started) { started = true; 
                     let duration = 2000;
                     let start = Date.now();
                     let animate = () => {
                         let now = Date.now();
                         let progress = Math.min((now - start) / duration, 1);
                         count = Math.floor(progress * target);
                         if (progress < 1) requestAnimationFrame(animate);
                     };
                         animate(); }">
                <div class="inline-flex items-center justify-center w-16 h-16 md:w-20 md:h-20 bg-primary-100 dark:bg-primary-900/30 rounded-2xl mb-3 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                    <svg class="w-8 h-8 md:w-10 md:h-10 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <div class="text-3xl md:text-4xl font-bold text-primary-700 dark:text-primary-400 mb-1">
                    <span x-text="count"></span>
                </div>
                <div class="text-sm text-neutral-600 dark:text-neutral-400 font-medium">Poeti</div>
            </div>

            <!-- Videos -->
            <div class="text-center group"
                 x-data="{ count: 0, target: {{ $stats['total_videos'] ?? 0 }}, started: false }"
                 x-intersect:enter.half.once="if (!started) { started = true; 
                     let duration = 2000;
                     let start = Date.now();
                     let animate = () => {
                         let now = Date.now();
                         let progress = Math.min((now - start) / duration, 1);
                         count = Math.floor(progress * target);
                         if (progress < 1) requestAnimationFrame(animate);
                     };
                         animate(); }">
                <div class="inline-flex items-center justify-center w-16 h-16 md:w-20 md:h-20 bg-primary-100 dark:bg-primary-900/30 rounded-2xl mb-3 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                    <svg class="w-8 h-8 md:w-10 md:h-10 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="text-3xl md:text-4xl font-bold text-primary-700 dark:text-primary-400 mb-1">
                    <span x-text="count"></span>
                </div>
                <div class="text-sm text-neutral-600 dark:text-neutral-400 font-medium">Video</div>
            </div>

            <!-- Events -->
            <div class="text-center group"
                 x-data="{ count: 0, target: {{ $stats['total_events'] ?? 0 }}, started: false }"
                 x-intersect:enter.half.once="if (!started) { started = true; 
                     let duration = 2000;
                     let start = Date.now();
                     let animate = () => {
                         let now = Date.now();
                         let progress = Math.min((now - start) / duration, 1);
                         count = Math.floor(progress * target);
                         if (progress < 1) requestAnimationFrame(animate);
                     };
                         animate(); }">
                <div class="inline-flex items-center justify-center w-16 h-16 md:w-20 md:h-20 bg-primary-100 dark:bg-primary-900/30 rounded-2xl mb-3 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                    <svg class="w-8 h-8 md:w-10 md:h-10 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="text-3xl md:text-4xl font-bold text-primary-700 dark:text-primary-400 mb-1">
                    <span x-text="count"></span>
                </div>
                <div class="text-sm text-neutral-600 dark:text-neutral-400 font-medium">Eventi</div>
            </div>

            <!-- Views -->
            <div class="text-center group"
                 x-data="{ count: 0, target: {{ $stats['total_views'] ?? 0 }}, started: false }"
                 x-intersect:enter.half.once="if (!started) { started = true; 
                     let duration = 2000;
                     let start = Date.now();
                     let animate = () => {
                         let now = Date.now();
                         let progress = Math.min((now - start) / duration, 1);
                         count = Math.floor(progress * target);
                         if (progress < 1) requestAnimationFrame(animate);
                     };
                         animate(); }">
                <div class="inline-flex items-center justify-center w-16 h-16 md:w-20 md:h-20 bg-primary-100 dark:bg-primary-900/30 rounded-2xl mb-3 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                    <svg class="w-8 h-8 md:w-10 md:h-10 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                <div class="text-3xl md:text-4xl font-bold text-primary-700 dark:text-primary-400 mb-1">
                    <span x-text="count"></span>
                </div>
                <div class="text-sm text-neutral-600 dark:text-neutral-400 font-medium">Visualizzazioni</div>
            </div>
        </div>
    </div>
</div>
