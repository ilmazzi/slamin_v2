<div class="p-6">
    <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-2">{{ __('admin.settings.upload.title') }}</h1>
    <p class="text-neutral-600 dark:text-neutral-400 mb-6">{{ __('admin.settings.upload.description') }}</p>

    <form wire:submit="updateSettings">
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow border border-neutral-200 dark:border-neutral-700 overflow-hidden">
            <div class="p-6">
                {{-- Limiti Dimensione --}}
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-neutral-900 dark:text-white mb-4">{{ __('admin.settings.upload.size_limits') }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('admin.settings.upload.profile_photo_max_size') }}
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       wire:model="settings.profile_photo_max_size"
                                       step="1"
                                       min="0"
                                       class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                       placeholder="5120">
                                <span class="absolute right-3 top-2.5 text-neutral-500 dark:text-neutral-400">KB</span>
                            </div>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                                {{ __('admin.settings.upload.max_size_hint') }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('admin.settings.upload.image_max_size') }}
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       wire:model="settings.image_max_size"
                                       step="1"
                                       min="0"
                                       class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                       placeholder="10240">
                                <span class="absolute right-3 top-2.5 text-neutral-500 dark:text-neutral-400">KB</span>
                            </div>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                                {{ __('admin.settings.upload.max_size_hint') }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('admin.settings.upload.video_max_size') }}
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       wire:model="settings.video_max_size"
                                       step="1"
                                       min="0"
                                       class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                       placeholder="102400">
                                <span class="absolute right-3 top-2.5 text-neutral-500 dark:text-neutral-400">KB</span>
                            </div>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                                {{ __('admin.settings.upload.max_size_hint') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Tipi di File Consentiti --}}
                <div class="border-t border-neutral-200 dark:border-neutral-700 pt-6">
                    <h2 class="text-lg font-semibold text-neutral-900 dark:text-white mb-4">{{ __('admin.settings.upload.allowed_file_types') }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('admin.settings.upload.allowed_image_types') }}
                            </label>
                            <textarea wire:model="settings.allowed_image_types"
                                      rows="3"
                                      class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent font-mono text-sm"
                                      placeholder='["jpeg", "jpg", "png", "gif", "webp"]'></textarea>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                                {{ __('admin.settings.upload.json_format_hint') }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('admin.settings.upload.allowed_video_types') }}
                            </label>
                            <textarea wire:model="settings.allowed_video_types"
                                      rows="3"
                                      class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent font-mono text-sm"
                                      placeholder='["mp4", "avi", "mov", "mkv", "webm", "flv"]'></textarea>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                                {{ __('admin.settings.upload.json_format_hint') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="px-6 py-4 bg-neutral-50 dark:bg-neutral-700/50 border-t border-neutral-200 dark:border-neutral-700 flex items-center justify-between">
                <button type="button" 
                        wire:click="resetSettings" 
                        wire:confirm="{{ __('admin.settings.upload.reset_confirm') }}"
                        class="px-4 py-2 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700 rounded-lg transition-colors">
                    {{ __('admin.settings.upload.reset') }}
                </button>
                <button type="submit" 
                        class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                    {{ __('admin.settings.upload.save') }}
                </button>
            </div>
        </div>
    </form>

    {{-- Messaggi flash --}}
    @if (session()->has('message'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 3000)"
             class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 5000)"
             class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('error') }}
        </div>
    @endif
</div>
