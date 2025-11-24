<div>
    @vite(['resources/css/forum.css', 'resources/js/forum.js'])

    <div class="min-h-screen bg-neutral-50 dark:bg-neutral-950 py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-6">
                <a href="{{ route('forum.subreddit.show', $subreddit) }}" wire:navigate
                   class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to r/{{ $subreddit->name }}
                </a>
                
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    {{ __('forum.subreddit_settings') }} - r/{{ $subreddit->name }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    {{ __('forum.settings_description') }}
                </p>
            </div>

            {{-- Settings Form --}}
            <form wire:submit="updateSettings" class="space-y-6">
                {{-- Basic Info --}}
                <div class="bg-white dark:bg-neutral-900 rounded-xl p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('forum.basic_info') }}</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('forum.subreddit_name') }} *
                            </label>
                            <div class="flex items-center">
                                <span class="px-4 py-3 bg-gray-100 dark:bg-neutral-800 border border-r-0 border-gray-300 dark:border-gray-700 rounded-l-lg text-gray-600 dark:text-gray-400">
                                    r/
                                </span>
                                <input type="text" 
                                       id="name" 
                                       wire:model="name" 
                                       maxlength="21"
                                       class="flex-1 px-4 py-3 rounded-r-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-neutral-800 text-gray-900 dark:text-white">
                            </div>
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('forum.description') }} *
                            </label>
                            <textarea id="description" 
                                      wire:model="description" 
                                      rows="3"
                                      maxlength="500"
                                      class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-neutral-800 text-gray-900 dark:text-white"></textarea>
                            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            <p class="text-sm text-gray-500 mt-1">{{ strlen($description ?? '') }}/500</p>
                        </div>

                        <div>
                            <label for="rules" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('forum.rules') }}
                            </label>
                            <textarea id="rules" 
                                      wire:model="rules" 
                                      rows="6"
                                      class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-neutral-800 text-gray-900 dark:text-white"></textarea>
                            @error('rules') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                {{-- Appearance --}}
                <div class="bg-white dark:bg-neutral-900 rounded-xl p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('forum.appearance') }}</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="color" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('forum.theme_color') }}
                            </label>
                            <div class="flex items-center gap-4">
                                <input type="color" 
                                       id="color" 
                                       wire:model.live="color" 
                                       class="h-12 w-24 rounded cursor-pointer">
                                <span class="text-gray-600 dark:text-gray-400">{{ $color }}</span>
                            </div>
                            @error('color') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('forum.subreddit_icon') }}
                            </label>
                            <div class="flex items-center gap-4">
                                @if($iconPreview)
                                    <img src="{{ $iconPreview }}" alt="Icon" class="w-20 h-20 rounded-full object-cover">
                                @elseif($subreddit->icon)
                                    <img src="{{ Storage::url($subreddit->icon) }}" alt="Icon" class="w-20 h-20 rounded-full object-cover">
                                @else
                                    <div class="w-20 h-20 rounded-full flex items-center justify-center text-2xl font-bold text-white" style="background: {{ $color }};">
                                        {{ $name ? substr($name, 0, 1) : '?' }}
                                    </div>
                                @endif
                                
                                <div>
                                    <input type="file" 
                                           wire:model="icon" 
                                           accept="image/*"
                                           class="hidden"
                                           id="iconUpload">
                                    <label for="iconUpload" class="px-4 py-2 bg-gray-100 dark:bg-neutral-800 text-gray-700 dark:text-gray-300 rounded-lg cursor-pointer hover:bg-gray-200 dark:hover:bg-neutral-700 inline-block">
                                        {{ __('forum.change_icon') }}
                                    </label>
                                    @if($icon || $subreddit->icon)
                                        <button type="button" 
                                                wire:click="removeIcon" 
                                                class="ml-2 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                            {{ __('forum.remove') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                            @error('icon') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('forum.subreddit_banner') }}
                            </label>
                            <div class="border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-lg p-6">
                                @if($bannerPreview)
                                    <img src="{{ $bannerPreview }}" alt="Banner" class="w-full h-48 object-cover rounded-lg mb-4">
                                @elseif($subreddit->banner)
                                    <img src="{{ Storage::url($subreddit->banner) }}" alt="Banner" class="w-full h-48 object-cover rounded-lg mb-4">
                                @endif
                                
                                <div class="text-center">
                                    <input type="file" 
                                           wire:model="banner" 
                                           accept="image/*"
                                           class="hidden"
                                           id="bannerUpload">
                                    <label for="bannerUpload" class="cursor-pointer inline-block px-4 py-2 bg-gray-100 dark:bg-neutral-800 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-neutral-700">
                                        {{ $subreddit->banner ? __('forum.change_banner') : __('forum.upload_banner') }}
                                    </label>
                                    @if($banner || $subreddit->banner)
                                        <button type="button" 
                                                wire:click="removeBanner" 
                                                class="ml-2 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                            {{ __('forum.remove_banner') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                            @error('banner') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                {{-- Privacy --}}
                <div class="bg-white dark:bg-neutral-900 rounded-xl p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('forum.privacy') }}</h3>
                    
                    <div class="flex items-start gap-3">
                        <input type="checkbox" 
                               id="isPrivate" 
                               wire:model="isPrivate"
                               class="w-5 h-5 mt-1 rounded border-gray-300 text-orange-500 focus:ring-orange-500">
                        <div>
                            <label for="isPrivate" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                {{ __('forum.private_subreddit') }}
                            </label>
                            <p class="text-sm text-gray-500 mt-1">{{ __('forum.private_subreddit_help') }}</p>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex justify-between items-center">
                    <button type="button" 
                            @click="if(confirm('Sei sicuro di voler eliminare questo subreddit? Questa azione è irreversibile!')) $wire.deleteSubreddit()"
                            class="px-6 py-3 bg-red-500 text-white rounded-lg font-semibold hover:bg-red-600 transition-all">
                        {{ __('forum.delete_subreddit') }}
                    </button>
                    
                    <div class="flex gap-3">
                        <a href="{{ route('forum.subreddit.show', $subreddit) }}" wire:navigate
                           class="px-6 py-3 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white font-semibold">
                            {{ __('forum.cancel') }}
                        </a>
                        
                        <button type="submit" 
                                class="px-8 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-lg font-semibold hover:shadow-lg transition-all disabled:opacity-50"
                                wire:loading.attr="disabled">
                            <span wire:loading.remove>{{ __('forum.save_changes') }}</span>
                            <span wire:loading>{{ __('forum.saving') }}...</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

