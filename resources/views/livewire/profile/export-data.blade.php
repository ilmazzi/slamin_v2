<x-layouts.app>
    <x-slot name="title">{{ __('data_export.page_title') }}</x-slot>

    <div class="min-h-screen bg-neutral-50 dark:bg-neutral-950 py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="bg-primary-50 dark:bg-primary-900/20 border-2 border-primary-200 dark:border-primary-800 rounded-xl p-6 mb-8">
                <div class="flex items-start gap-4">
                    <div class="text-4xl">📦</div>
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold text-primary-900 dark:text-primary-100 mb-2">
                            {{ __('data_export.page_title') }}
                        </h1>
                        <p class="text-primary-800 dark:text-primary-200 leading-relaxed">
                            {{ __('data_export.page_subtitle') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Main Card -->
            <div class="bg-white dark:bg-neutral-900 rounded-xl shadow-lg border border-neutral-200 dark:border-neutral-800 overflow-hidden">
                
                <!-- What's included -->
                <div class="p-6 md:p-8 border-b border-neutral-200 dark:border-neutral-800">
                    <h2 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">
                        {{ __('data_export.what_included_title') }}
                    </h2>
                    
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div class="flex items-start gap-3 p-4 bg-neutral-50 dark:bg-neutral-800/50 rounded-lg">
                            <span class="text-xl">👤</span>
                            <div>
                                <h3 class="font-semibold text-neutral-900 dark:text-white">
                                    {{ __('data_export.personal_info') }}
                                </h3>
                                <p class="text-sm text-neutral-600 dark:text-neutral-400">
                                    {{ __('data_export.personal_info_desc') }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3 p-4 bg-neutral-50 dark:bg-neutral-800/50 rounded-lg">
                            <span class="text-xl">📝</span>
                            <div>
                                <h3 class="font-semibold text-neutral-900 dark:text-white">
                                    {{ __('data_export.content') }}
                                </h3>
                                <p class="text-sm text-neutral-600 dark:text-neutral-400">
                                    {{ __('data_export.content_desc') }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3 p-4 bg-neutral-50 dark:bg-neutral-800/50 rounded-lg">
                            <span class="text-xl">💬</span>
                            <div>
                                <h3 class="font-semibold text-neutral-900 dark:text-white">
                                    {{ __('data_export.interactions') }}
                                </h3>
                                <p class="text-sm text-neutral-600 dark:text-neutral-400">
                                    {{ __('data_export.interactions_desc') }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3 p-4 bg-neutral-50 dark:bg-neutral-800/50 rounded-lg">
                            <span class="text-xl">🔒</span>
                            <div>
                                <h3 class="font-semibold text-neutral-900 dark:text-white">
                                    {{ __('data_export.privacy') }}
                                </h3>
                                <p class="text-sm text-neutral-600 dark:text-neutral-400">
                                    {{ __('data_export.privacy_desc') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Export Action -->
                <div class="p-6 md:p-8 space-y-6">
                    @if(!$exportReady)
                        <div class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-primary-100 dark:bg-primary-900/30 mb-4">
                                <svg class="w-10 h-10 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            
                            <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-2">
                                {{ __('data_export.ready_title') }}
                            </h3>
                            <p class="text-neutral-600 dark:text-neutral-400 mb-6">
                                {{ __('data_export.ready_description') }}
                            </p>
                            
                            <button 
                                wire:click="generateExport"
                                wire:loading.attr="disabled"
                                class="inline-flex items-center gap-2 px-8 py-3 bg-primary-600 hover:bg-primary-700 disabled:bg-neutral-400 disabled:cursor-not-allowed text-white font-semibold rounded-lg transition-colors shadow-lg"
                            >
                                <span wire:loading.remove>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </span>
                                <span wire:loading>
                                    <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-white"></div>
                                </span>
                                <span wire:loading.remove>{{ __('data_export.generate_button') }}</span>
                                <span wire:loading>{{ __('data_export.generating') }}</span>
                            </button>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-green-100 dark:bg-green-900/30 mb-4">
                                <svg class="w-10 h-10 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            
                            <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-2">
                                {{ __('data_export.ready_download_title') }}
                            </h3>
                            <p class="text-neutral-600 dark:text-neutral-400 mb-6">
                                {{ __('data_export.ready_download_description') }}
                            </p>
                            
                            <a 
                                href="{{ route('profile.export.download') }}"
                                class="inline-flex items-center gap-2 px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-colors shadow-lg"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                {{ __('data_export.download_button') }}
                            </a>
                            
                            <div class="mt-4">
                                <button 
                                    wire:click="$set('exportReady', false)"
                                    class="text-sm text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-neutral-200"
                                >
                                    {{ __('data_export.generate_new') }}
                                </button>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Info -->
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                        <div class="flex gap-3">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="text-sm text-blue-800 dark:text-blue-200">
                                <p class="font-semibold mb-1">{{ __('data_export.info_title') }}</p>
                                <p>{{ __('data_export.info_description') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Back Button -->
                    <div class="text-center">
                        <a 
                            href="{{ route('profile.edit') }}" 
                            class="inline-flex items-center gap-2 text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-neutral-200 transition-colors"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            {{ __('data_export.back_to_settings') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- GDPR Notice -->
            <div class="mt-6 text-center">
                <p class="text-xs text-neutral-500 dark:text-neutral-400">
                    {{ __('data_export.gdpr_note') }}
                </p>
            </div>
        </div>
    </div>
</x-layouts.app>
