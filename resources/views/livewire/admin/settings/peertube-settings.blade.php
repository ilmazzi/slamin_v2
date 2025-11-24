<div class="p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-2">{{ __('admin.peertube.title') }}</h1>
        <p class="text-neutral-600 dark:text-neutral-400">{{ __('admin.peertube.description') }}</p>
    </div>
    
    {{-- Status Badge --}}
    <div class="mb-6">
        @if($isConfigured)
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="font-semibold">{{ __('admin.peertube.configured') }}</span>
            </div>
        @else
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <span class="font-semibold">{{ __('admin.peertube.not_configured') }}</span>
            </div>
        @endif
    </div>
    
    @if(session()->has('success'))
        <div class="mb-4 p-4 bg-green-100 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-400 rounded-lg">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif
    
    @if(session()->has('error'))
        <div class="mb-4 p-4 bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-400 rounded-lg">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif
    
    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-sm border border-neutral-200 dark:border-neutral-700 p-6">
        <form wire:submit="update">
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                        {{ __('admin.peertube.url') }} *
                    </label>
                    <input type="url" 
                           wire:model="settings.peertube_url" 
                           placeholder="https://video.slamin.it"
                           class="w-full px-4 py-3 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all">
                    @error('settings.peertube_url')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">{{ __('admin.peertube.url_help') }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                        {{ __('admin.peertube.admin_username') }} *
                    </label>
                    <input type="text" 
                           wire:model="settings.peertube_admin_username" 
                           placeholder="{{ __('admin.peertube.admin_username_placeholder') }}"
                           class="w-full px-4 py-3 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all">
                    @error('settings.peertube_admin_username')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">{{ __('admin.peertube.admin_username_help') }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                        {{ __('admin.peertube.admin_password') }} *
                    </label>
                    <input type="password" 
                           wire:model="settings.peertube_admin_password" 
                           placeholder="{{ __('admin.peertube.admin_password_placeholder') }}"
                           class="w-full px-4 py-3 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all">
                    @error('settings.peertube_admin_password')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">{{ __('admin.peertube.admin_password_help') }}</p>
                </div>
                
                <div class="flex flex-wrap gap-4 pt-4 border-t border-neutral-200 dark:border-neutral-700">
                    <button type="submit" 
                            class="px-6 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ __('admin.peertube.save') }}
                        </span>
                    </button>
                    <button type="button" 
                            wire:click="testConnection"
                            wire:loading.attr="disabled"
                            class="px-6 py-3 bg-neutral-600 text-white font-semibold rounded-lg hover:bg-neutral-700 transition-colors focus:ring-2 focus:ring-neutral-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span class="flex items-center gap-2">
                            <svg wire:loading.remove wire:target="testConnection" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <svg wire:loading wire:target="testConnection" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            {{ __('admin.peertube.test_connection') }}
                        </span>
                    </button>
                </div>
                
                @if($connectionTest)
                    <div class="p-4 rounded-lg border-2 {{ $connectionTest['success'] ? 'bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-800 text-green-800 dark:text-green-400' : 'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800 text-red-800 dark:text-red-400' }}">
                        <div class="flex items-start gap-3">
                            @if($connectionTest['success'])
                                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            @else
                                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            @endif
                            <div class="flex-1">
                                <p class="font-semibold mb-1">{{ $connectionTest['success'] ? __('admin.peertube.connection_success') : __('admin.peertube.connection_failed') }}</p>
                                <p class="text-sm">{{ $connectionTest['message'] }}</p>
                                @if(isset($connectionTest['token']))
                                    <p class="text-xs mt-2 opacity-75">{{ __('admin.peertube.token_preview') }}: {{ $connectionTest['token'] }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </form>
    </div>
    
    {{-- Info Box --}}
    <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="text-sm text-blue-800 dark:text-blue-300">
                <p class="font-semibold mb-1">{{ __('admin.peertube.info_title') }}</p>
                <p>{{ __('admin.peertube.info_description') }}</p>
            </div>
        </div>
    </div>
</div>

