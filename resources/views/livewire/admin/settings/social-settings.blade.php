<div class="p-6">
    <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-2">{{ __('admin.social_settings.title') }}</h1>
    <p class="text-neutral-600 dark:text-neutral-400 mb-6">{{ __('admin.social_settings.description') }}</p>

    <form wire:submit="update">
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow border border-neutral-200 dark:border-neutral-700 overflow-hidden">
            <div class="p-6">
                {{-- Like Settings --}}
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-neutral-900 dark:text-white mb-4">{{ __('admin.social_settings.likes') }}</h2>
                    <div class="space-y-4">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   wire:model="settings.social_enable_likes"
                                   value="1"
                                   @if($settings['social_enable_likes'] ?? false) checked @endif
                                   class="sr-only peer">
                            <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-neutral-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-neutral-600 peer-checked:bg-primary-600"></div>
                            <span class="ml-3 text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                {{ __('admin.social_settings.enable_likes') }}
                            </span>
                        </label>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('admin.social_settings.likeable_content') }}
                            </label>
                            <textarea wire:model="settings.social_likeable_content"
                                      rows="3"
                                      class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent font-mono text-sm"
                                      placeholder='["video", "photo", "poem", "article", "event", "comment"]'>{{ is_array($settings['social_likeable_content'] ?? []) ? json_encode($settings['social_likeable_content'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : ($settings['social_likeable_content'] ?? '') }}</textarea>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                                {{ __('admin.social_settings.json_format_hint') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Comment Settings --}}
                <div class="mb-8 border-t border-neutral-200 dark:border-neutral-700 pt-6">
                    <h2 class="text-lg font-semibold text-neutral-900 dark:text-white mb-4">{{ __('admin.social_settings.comments') }}</h2>
                    <div class="space-y-4">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   wire:model="settings.social_enable_comments"
                                   value="1"
                                   @if($settings['social_enable_comments'] ?? false) checked @endif
                                   class="sr-only peer">
                            <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-neutral-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-neutral-600 peer-checked:bg-primary-600"></div>
                            <span class="ml-3 text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                {{ __('admin.social_settings.enable_comments') }}
                            </span>
                        </label>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('admin.social_settings.commentable_content') }}
                            </label>
                            <textarea wire:model="settings.social_commentable_content"
                                      rows="3"
                                      class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent font-mono text-sm"
                                      placeholder='["video", "photo", "poem", "article", "event"]'>{{ is_array($settings['social_commentable_content'] ?? []) ? json_encode($settings['social_commentable_content'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : ($settings['social_commentable_content'] ?? '') }}</textarea>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                                {{ __('admin.social_settings.json_format_hint') }}
                            </p>
                        </div>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   wire:model="settings.social_auto_approve_comments"
                                   value="1"
                                   @if($settings['social_auto_approve_comments'] ?? false) checked @endif
                                   class="sr-only peer">
                            <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-neutral-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-neutral-600 peer-checked:bg-primary-600"></div>
                            <span class="ml-3 text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                {{ __('admin.social_settings.auto_approve_comments') }}
                            </span>
                        </label>
                    </div>
                </div>

                {{-- Notification Settings --}}
                <div class="mb-8 border-t border-neutral-200 dark:border-neutral-700 pt-6">
                    <h2 class="text-lg font-semibold text-neutral-900 dark:text-white mb-4">{{ __('admin.social_settings.notifications') }}</h2>
                    <div class="space-y-4">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   wire:model="settings.social_enable_notifications"
                                   value="1"
                                   @if($settings['social_enable_notifications'] ?? false) checked @endif
                                   class="sr-only peer">
                            <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-neutral-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-neutral-600 peer-checked:bg-primary-600"></div>
                            <span class="ml-3 text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                {{ __('admin.social_settings.enable_notifications') }}
                            </span>
                        </label>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('admin.social_settings.notification_types') }}
                            </label>
                            <textarea wire:model="settings.social_notification_types"
                                      rows="3"
                                      class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent font-mono text-sm"
                                      placeholder='["like", "comment", "snap"]'>{{ is_array($settings['social_notification_types'] ?? []) ? json_encode($settings['social_notification_types'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : ($settings['social_notification_types'] ?? '') }}</textarea>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                                {{ __('admin.social_settings.json_format_hint') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- View Settings --}}
                <div class="border-t border-neutral-200 dark:border-neutral-700 pt-6">
                    <h2 class="text-lg font-semibold text-neutral-900 dark:text-white mb-4">{{ __('admin.social_settings.views') }}</h2>
                    <div class="space-y-4">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   wire:model="settings.social_enable_views"
                                   value="1"
                                   @if($settings['social_enable_views'] ?? false) checked @endif
                                   class="sr-only peer">
                            <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-neutral-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-neutral-600 peer-checked:bg-primary-600"></div>
                            <span class="ml-3 text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                {{ __('admin.social_settings.enable_views') }}
                            </span>
                        </label>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('admin.social_settings.viewable_content') }}
                            </label>
                            <textarea wire:model="settings.social_viewable_content"
                                      rows="3"
                                      class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent font-mono text-sm"
                                      placeholder='["video", "photo", "poem", "article", "event"]'>{{ is_array($settings['social_viewable_content'] ?? []) ? json_encode($settings['social_viewable_content'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : ($settings['social_viewable_content'] ?? '') }}</textarea>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                                {{ __('admin.social_settings.json_format_hint') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="px-6 py-4 bg-neutral-50 dark:bg-neutral-700/50 border-t border-neutral-200 dark:border-neutral-700 flex items-center justify-between">
                <button type="button" 
                        wire:click="resetToDefaults" 
                        wire:confirm="{{ __('admin.social_settings.reset_confirm') }}"
                        class="px-4 py-2 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700 rounded-lg transition-colors">
                    {{ __('admin.social_settings.reset') }}
                </button>
                <button type="submit" 
                        class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                    {{ __('admin.social_settings.save') }}
                </button>
            </div>
        </div>
    </form>

    {{-- Messaggi flash --}}
    @if (session()->has('success'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 3000)"
             class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('success') }}
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
