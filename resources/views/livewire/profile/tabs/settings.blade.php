{{-- Settings Tab --}}
<div class="space-y-6">
    <div class="bg-white dark:bg-neutral-800 rounded-xl p-6 border border-neutral-200 dark:border-neutral-700 shadow-sm">
        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-6">{{ __('profile.settings.title') }}</h2>
        
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="{{ route('profile.edit') }}" class="group">
                <div class="bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/20 dark:to-primary-800/20 rounded-xl p-6 border-2 border-primary-200 dark:border-primary-800 hover:border-primary-400 dark:hover:border-primary-600 transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center gap-4 mb-3">
                        <div class="w-12 h-12 bg-primary-600 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-lg text-neutral-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                            {{ __('profile.settings.edit_profile') }}
                        </h3>
                    </div>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('profile.settings.edit_profile_desc') }}</p>
                </div>
            </a>

            <a href="{{ route('profile.my-badges') }}" class="group">
                <div class="bg-gradient-to-br from-accent-50 to-accent-100 dark:from-accent-900/20 dark:to-accent-800/20 rounded-xl p-6 border-2 border-accent-200 dark:border-accent-800 hover:border-accent-400 dark:hover:border-accent-600 transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center gap-4 mb-3">
                        <div class="w-12 h-12 bg-accent-600 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-lg text-neutral-900 dark:text-white group-hover:text-accent-600 dark:group-hover:text-accent-400 transition-colors">
                            {{ __('profile.settings.badges') }}
                        </h3>
                    </div>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('profile.settings.badges_desc') }}</p>
                </div>
            </a>

            <a href="{{ route('media.index') }}" class="group">
                <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl p-6 border-2 border-green-200 dark:border-green-800 hover:border-green-400 dark:hover:border-green-600 transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center gap-4 mb-3">
                        <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-lg text-neutral-900 dark:text-white group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">
                            {{ __('profile.settings.media') }}
                        </h3>
                    </div>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('profile.settings.media_desc') }}</p>
                </div>
            </a>
        </div>
    </div>
</div>

