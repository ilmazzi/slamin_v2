<div>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-yellow-100 dark:bg-yellow-900/20 mb-6">
                <svg class="w-10 h-10 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-neutral-900 dark:text-white mb-4" style="font-family: 'Crimson Pro', serif;">
                {{ __('media.upload_limit_reached') }}
            </h1>
            <p class="text-lg text-neutral-600 dark:text-neutral-400">
                {{ __('media.limit_reached_message') }}
            </p>
        </div>

        {{-- Current Usage Card --}}
        <div class="bg-white dark:bg-neutral-800 rounded-3xl shadow-xl p-8 mb-8 border-2 border-yellow-200 dark:border-yellow-800">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-6" style="font-family: 'Crimson Pro', serif;">
                    {{ __('media.current_usage') }}
                </h2>
                
                {{-- Video Usage --}}
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-neutral-700 dark:text-neutral-300 mb-4">{{ __('media.video') }}</h3>
                    <div class="flex items-center justify-center gap-8 mb-6">
                        <div class="text-center">
                            <div class="text-4xl font-black text-yellow-600 dark:text-yellow-400 mb-2">
                                {{ $currentVideoCount }}
                            </div>
                            <div class="text-sm text-neutral-600 dark:text-neutral-400 font-medium">
                                {{ __('media.videos_used') }}
                            </div>
                        </div>
                        <div class="text-2xl text-neutral-400 dark:text-neutral-500 font-bold">
                            /
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-black text-neutral-900 dark:text-white mb-2">
                                {{ $currentVideoLimit }}
                            </div>
                            <div class="text-sm text-neutral-600 dark:text-neutral-400 font-medium">
                                {{ __('media.video_limit') }}
                            </div>
                        </div>
                    </div>
                    <div class="w-full max-w-md mx-auto bg-neutral-200 dark:bg-neutral-700 rounded-full h-4 mb-4">
                        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 h-4 rounded-full transition-all duration-300" 
                             style="width: {{ min(100, ($currentVideoCount / max($currentVideoLimit, 1)) * 100) }}%"></div>
                    </div>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">
                        {{ __('media.videos_remaining') }}: <span class="font-bold {{ $remainingVideoUploads > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">{{ $remainingVideoUploads }}</span>
                    </p>
                </div>
                
                {{-- Photo Usage --}}
                <div>
                    <h3 class="text-lg font-semibold text-neutral-700 dark:text-neutral-300 mb-4">{{ __('media.photo') }}</h3>
                    <div class="flex items-center justify-center gap-8 mb-6">
                        <div class="text-center">
                            <div class="text-4xl font-black text-accent-600 dark:text-accent-400 mb-2">
                                {{ $currentPhotoCount }}
                            </div>
                            <div class="text-sm text-neutral-600 dark:text-neutral-400 font-medium">
                                {{ __('media.photos_used') }}
                            </div>
                        </div>
                        <div class="text-2xl text-neutral-400 dark:text-neutral-500 font-bold">
                            /
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-black text-neutral-900 dark:text-white mb-2">
                                {{ $currentPhotoLimit }}
                            </div>
                            <div class="text-sm text-neutral-600 dark:text-neutral-400 font-medium">
                                {{ __('media.photo_limit') }}
                            </div>
                        </div>
                    </div>
                    <div class="w-full max-w-md mx-auto bg-neutral-200 dark:bg-neutral-700 rounded-full h-4 mb-4">
                        <div class="bg-gradient-to-r from-accent-500 to-accent-600 h-4 rounded-full transition-all duration-300" 
                             style="width: {{ min(100, ($currentPhotoCount / max($currentPhotoLimit, 1)) * 100) }}%"></div>
                    </div>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">
                        {{ __('media.photos_remaining') }}: <span class="font-bold {{ $remainingPhotoUploads > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">{{ $remainingPhotoUploads }}</span>
                    </p>
                </div>
            </div>
        </div>

        {{-- Upgrade Options --}}
        <div class="grid md:grid-cols-2 gap-6 mb-8">
            {{-- Upgrade to Premium --}}
            <div class="bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/20 dark:to-primary-800/20 rounded-3xl shadow-xl p-8 border-2 border-primary-200 dark:border-primary-800">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary-600 mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-neutral-900 dark:text-white mb-4" style="font-family: 'Crimson Pro', serif;">
                        {{ __('media.upgrade_to_premium') }}
                    </h3>
                    <p class="text-neutral-600 dark:text-neutral-400 mb-6">
                        {{ __('media.upgrade_benefits') }}
                    </p>
                    <a href="#" 
                       class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-bold shadow-lg hover:-translate-y-0.5 transition-all duration-300 opacity-50 cursor-not-allowed"
                       title="{{ __('media.premium_coming_soon') ?? 'Funzionalità Premium in arrivo' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                        {{ __('media.view_packages') }}
                    </a>
                </div>
            </div>

            {{-- Manage Videos --}}
            <div class="bg-white dark:bg-neutral-800 rounded-3xl shadow-xl p-8 border-2 border-neutral-200 dark:border-neutral-700">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-neutral-200 dark:bg-neutral-700 mb-6">
                        <svg class="w-8 h-8 text-neutral-600 dark:text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-neutral-900 dark:text-white mb-4" style="font-family: 'Crimson Pro', serif;">
                        {{ __('media.manage_videos') }}
                    </h3>
                    <p class="text-neutral-600 dark:text-neutral-400 mb-6">
                        {{ __('media.manage_existing_videos') }}
                    </p>
                    <a href="{{ route('media.my-videos') }}" 
                       class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-neutral-600 hover:bg-neutral-700 text-white font-bold shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        {{ __('media.view_my_videos') }}
                    </a>
                </div>
            </div>
        </div>

        {{-- Current Plan Info --}}
        <div class="bg-white dark:bg-neutral-800 rounded-3xl shadow-xl p-8 border-2 border-neutral-200 dark:border-neutral-700">
            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-6" style="font-family: 'Crimson Pro', serif;">
                {{ __('media.current_plan_info') }}
            </h3>
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-2">
                        {{ __('media.your_current_plan') }}
                    </p>
                    <p class="text-lg font-bold text-neutral-900 dark:text-white">
                        @if($user->hasPremiumSubscription())
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-400">
                                {{ __('premium.premium_package') ?? 'Premium' }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-neutral-200 dark:bg-neutral-700 text-neutral-800 dark:text-neutral-300">
                                {{ __('premium.free_package') ?? 'Gratuito' }}
                            </span>
                        @endif
                    </p>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                    {{-- Video Stats --}}
                    <div class="text-center">
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">
                            {{ __('media.video_limit') }}
                        </p>
                        <p class="text-xl font-bold text-neutral-900 dark:text-white">
                            {{ $currentVideoLimit }}
                        </p>
                    </div>
                    <div class="text-center">
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">
                            {{ __('media.videos_used') }}
                        </p>
                        <p class="text-xl font-bold text-yellow-600 dark:text-yellow-400">
                            {{ $currentVideoCount }}
                        </p>
                    </div>
                    <div class="text-center">
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">
                            {{ __('media.videos_remaining') }}
                        </p>
                        <p class="text-xl font-bold {{ $remainingVideoUploads > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                            {{ $remainingVideoUploads }}
                        </p>
                    </div>
                    {{-- Photo Stats --}}
                    <div class="text-center">
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">
                            {{ __('media.photo_limit') }}
                        </p>
                        <p class="text-xl font-bold text-neutral-900 dark:text-white">
                            {{ $currentPhotoLimit }}
                        </p>
                    </div>
                    <div class="text-center">
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">
                            {{ __('media.photos_used') }}
                        </p>
                        <p class="text-xl font-bold text-accent-600 dark:text-accent-400">
                            {{ $currentPhotoCount }}
                        </p>
                    </div>
                    <div class="text-center">
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">
                            {{ __('media.photos_remaining') }}
                        </p>
                        <p class="text-xl font-bold {{ $remainingPhotoUploads > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                            {{ $remainingPhotoUploads }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mt-8">
            <a href="{{ route('media.index') }}" 
               class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-neutral-200 dark:bg-neutral-700 hover:bg-neutral-300 dark:hover:bg-neutral-600 text-neutral-900 dark:text-white font-bold transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ __('common.back_to_media') }}
            </a>
            <a href="#" 
               class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-bold shadow-lg hover:-translate-y-0.5 transition-all duration-300 opacity-50 cursor-not-allowed"
               title="{{ __('media.premium_coming_soon') ?? 'Funzionalità Premium in arrivo' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
                {{ __('media.upgrade_now') }}
            </a>
        </div>
    </div>
</div>

