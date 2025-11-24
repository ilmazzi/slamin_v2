<div>
    @vite(['resources/css/forum.css', 'resources/js/forum.js'])

    <div class="min-h-screen bg-neutral-50 dark:bg-neutral-950 py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    {{ __('forum.create_subreddit') }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    {{ __('forum.create_subreddit_description') }}
                </p>
            </div>

            {{-- Form --}}
            <form wire:submit="createSubreddit" class="bg-white dark:bg-neutral-900 rounded-xl p-6 space-y-6">
                {{-- Name --}}
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
                               wire:model.live="name" 
                               maxlength="21"
                               class="flex-1 px-4 py-3 rounded-r-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-neutral-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                               placeholder="slamin">
                    </div>
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    <p class="text-sm text-gray-500 mt-1">{{ __('forum.subreddit_name_help') }}</p>
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('forum.description') }} *
                    </label>
                    <textarea id="description" 
                              wire:model="description" 
                              rows="3"
                              maxlength="500"
                              class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-neutral-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                              placeholder="{{ __('forum.description_placeholder') }}"></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    <p class="text-sm text-gray-500 mt-1">{{ strlen($description ?? '') }}/500</p>
                </div>

                {{-- Rules --}}
                <div>
                    <label for="rules" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('forum.rules') }}
                    </label>
                    <textarea id="rules" 
                              wire:model="rules" 
                              rows="6"
                              class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-neutral-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                              placeholder="{{ __('forum.rules_placeholder') }}"></textarea>
                    @error('rules') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Color --}}
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

                {{-- Icon --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('forum.subreddit_icon') }}
                    </label>
                    <div class="flex items-center gap-4">
                        @if($iconPreview)
                            <img src="{{ $iconPreview }}" alt="Icon" class="w-20 h-20 rounded-full object-cover">
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
                                {{ __('forum.upload_icon') }}
                            </label>
                            @if($icon)
                                <button type="button" 
                                        wire:click="$set('icon', null)" 
                                        class="ml-2 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                    {{ __('forum.remove') }}
                                </button>
                            @endif
                        </div>
                    </div>
                    @error('icon') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    <p class="text-sm text-gray-500 mt-1">{{ __('forum.icon_help') }}</p>
                </div>

                {{-- Banner --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('forum.subreddit_banner') }}
                    </label>
                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-lg p-6">
                        @if($bannerPreview)
                            <img src="{{ $bannerPreview }}" alt="Banner" class="w-full h-48 object-cover rounded-lg mb-4">
                            <button type="button" 
                                    wire:click="$set('banner', null)" 
                                    class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                {{ __('forum.remove_banner') }}
                            </button>
                        @else
                            <input type="file" 
                                   wire:model="banner" 
                                   accept="image/*"
                                   class="hidden"
                                   id="bannerUpload">
                            <label for="bannerUpload" class="cursor-pointer block text-center">
                                <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <p class="text-gray-600 dark:text-gray-400">{{ __('forum.click_to_upload_banner') }}</p>
                                <p class="text-sm text-gray-500 mt-1">1920x384px consigliato</p>
                            </label>
                        @endif
                    </div>
                    @error('banner') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Privacy --}}
                <div class="flex items-center gap-3">
                    <input type="checkbox" 
                           id="isPrivate" 
                           wire:model="isPrivate"
                           class="w-5 h-5 rounded border-gray-300 text-orange-500 focus:ring-orange-500">
                    <label for="isPrivate" class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                        {{ __('forum.private_subreddit') }}
                    </label>
                </div>
                <p class="text-sm text-gray-500">{{ __('forum.private_subreddit_help') }}</p>

                {{-- Actions --}}
                <div class="flex justify-between items-center pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('forum.index') }}" wire:navigate
                       class="px-6 py-3 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white font-semibold">
                        {{ __('forum.cancel') }}
                    </a>
                    
                    <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-lg font-semibold hover:shadow-lg transition-all disabled:opacity-50"
                            wire:loading.attr="disabled">
                        <span wire:loading.remove>{{ __('forum.create_subreddit') }}</span>
                        <span wire:loading>{{ __('forum.creating') }}...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

