<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-2">
                {{ __('admin.moderation_settings.title') }}
            </h1>
            <p class="text-neutral-600 dark:text-neutral-400">
                {{ __('admin.moderation_settings.description') }}
            </p>
        </div>

        @if (session()->has('success'))
            <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-6 p-4 bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-md p-6 border border-neutral-200 dark:border-neutral-700">
            <h2 class="text-xl font-semibold text-neutral-900 dark:text-white mb-4">
                {{ __('admin.moderation_settings.auto_approve_title') }}
            </h2>
            <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-6">
                {{ __('admin.moderation_settings.auto_approve_description') }}
            </p>

            <form wire:submit.prevent="save" class="space-y-4">
                {{-- Poems --}}
                <div class="flex items-center justify-between p-4 bg-neutral-50 dark:bg-neutral-900 rounded-lg">
                    <div class="flex-1">
                        <label for="autoApprovePoems" class="text-sm font-medium text-neutral-900 dark:text-white cursor-pointer">
                            📝 {{ __('admin.moderation_settings.poems') }}
                        </label>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                            {{ __('admin.moderation_settings.poems_desc') }}
                        </p>
                    </div>
                    <div class="ml-4">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="autoApprovePoems" id="autoApprovePoems" class="sr-only peer">
                            <div class="w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-neutral-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-neutral-600 peer-checked:bg-primary-600"></div>
                        </label>
                    </div>
                </div>

                {{-- Articles --}}
                <div class="flex items-center justify-between p-4 bg-neutral-50 dark:bg-neutral-900 rounded-lg">
                    <div class="flex-1">
                        <label for="autoApproveArticles" class="text-sm font-medium text-neutral-900 dark:text-white cursor-pointer">
                            📰 {{ __('admin.moderation_settings.articles') }}
                        </label>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                            {{ __('admin.moderation_settings.articles_desc') }}
                        </p>
                    </div>
                    <div class="ml-4">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="autoApproveArticles" id="autoApproveArticles" class="sr-only peer">
                            <div class="w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-neutral-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-neutral-600 peer-checked:bg-primary-600"></div>
                        </label>
                    </div>
                </div>

                {{-- Photos --}}
                <div class="flex items-center justify-between p-4 bg-neutral-50 dark:bg-neutral-900 rounded-lg">
                    <div class="flex-1">
                        <label for="autoApprovePhotos" class="text-sm font-medium text-neutral-900 dark:text-white cursor-pointer">
                            📷 {{ __('admin.moderation_settings.photos') }}
                        </label>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                            {{ __('admin.moderation_settings.photos_desc') }}
                        </p>
                    </div>
                    <div class="ml-4">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="autoApprovePhotos" id="autoApprovePhotos" class="sr-only peer">
                            <div class="w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-neutral-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-neutral-600 peer-checked:bg-primary-600"></div>
                        </label>
                    </div>
                </div>

                {{-- Videos --}}
                <div class="flex items-center justify-between p-4 bg-neutral-50 dark:bg-neutral-900 rounded-lg">
                    <div class="flex-1">
                        <label for="autoApproveVideos" class="text-sm font-medium text-neutral-900 dark:text-white cursor-pointer">
                            🎥 {{ __('admin.moderation_settings.videos') }}
                        </label>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                            {{ __('admin.moderation_settings.videos_desc') }}
                        </p>
                    </div>
                    <div class="ml-4">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="autoApproveVideos" id="autoApproveVideos" class="sr-only peer">
                            <div class="w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-neutral-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-neutral-600 peer-checked:bg-primary-600"></div>
                        </label>
                    </div>
                </div>

                {{-- Events --}}
                <div class="flex items-center justify-between p-4 bg-neutral-50 dark:bg-neutral-900 rounded-lg">
                    <div class="flex-1">
                        <label for="autoApproveEvents" class="text-sm font-medium text-neutral-900 dark:text-white cursor-pointer">
                            🎪 {{ __('admin.moderation_settings.events') }}
                        </label>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                            {{ __('admin.moderation_settings.events_desc') }}
                        </p>
                    </div>
                    <div class="ml-4">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="autoApproveEvents" id="autoApproveEvents" class="sr-only peer">
                            <div class="w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-neutral-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-neutral-600 peer-checked:bg-primary-600"></div>
                        </label>
                    </div>
                </div>

                {{-- Gigs --}}
                <div class="flex items-center justify-between p-4 bg-neutral-50 dark:bg-neutral-900 rounded-lg">
                    <div class="flex-1">
                        <label for="autoApproveGigs" class="text-sm font-medium text-neutral-900 dark:text-white cursor-pointer">
                            🎤 {{ __('admin.moderation_settings.gigs') }}
                        </label>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                            {{ __('admin.moderation_settings.gigs_desc') }}
                        </p>
                    </div>
                    <div class="ml-4">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="autoApproveGigs" id="autoApproveGigs" class="sr-only peer">
                            <div class="w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-neutral-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-neutral-600 peer-checked:bg-primary-600"></div>
                        </label>
                    </div>
                </div>

                {{-- Forum Posts --}}
                <div class="flex items-center justify-between p-4 bg-neutral-50 dark:bg-neutral-900 rounded-lg">
                    <div class="flex-1">
                        <label for="autoApproveForumPosts" class="text-sm font-medium text-neutral-900 dark:text-white cursor-pointer">
                            💬 {{ __('admin.moderation_settings.forum_posts') }}
                        </label>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                            {{ __('admin.moderation_settings.forum_posts_desc') }}
                        </p>
                    </div>
                    <div class="ml-4">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="autoApproveForumPosts" id="autoApproveForumPosts" class="sr-only peer">
                            <div class="w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-neutral-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-neutral-600 peer-checked:bg-primary-600"></div>
                        </label>
                    </div>
                </div>

                {{-- Forum Comments --}}
                <div class="flex items-center justify-between p-4 bg-neutral-50 dark:bg-neutral-900 rounded-lg">
                    <div class="flex-1">
                        <label for="autoApproveForumComments" class="text-sm font-medium text-neutral-900 dark:text-white cursor-pointer">
                            💭 {{ __('admin.moderation_settings.forum_comments') }}
                        </label>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                            {{ __('admin.moderation_settings.forum_comments_desc') }}
                        </p>
                    </div>
                    <div class="ml-4">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="autoApproveForumComments" id="autoApproveForumComments" class="sr-only peer">
                            <div class="w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-neutral-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-neutral-600 peer-checked:bg-primary-600"></div>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" 
                            class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                        {{ __('admin.moderation_settings.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
