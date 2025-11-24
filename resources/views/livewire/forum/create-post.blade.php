<div>
    @vite(['resources/css/forum.css', 'resources/js/forum.js'])

    <div class="min-h-screen bg-neutral-50 dark:bg-neutral-950 py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    {{ __('forum.create_post_in') }} r/{{ $subreddit->name }}
                </h1>
                <a href="{{ route('forum.subreddit.show', $subreddit) }}" wire:navigate
                   class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                    ← {{ __('forum.back_to_subreddit') }}
                </a>
            </div>

            {{-- Post Type Tabs --}}
            <div class="bg-white dark:bg-neutral-900 rounded-t-xl border-b border-gray-200 dark:border-gray-700">
                <div class="flex">
                    <button wire:click="$set('postType', 'text')" 
                            class="flex-1 px-6 py-4 font-semibold transition-all {{ $postType === 'text' ? 'text-orange-500 border-b-2 border-orange-500' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-neutral-800' }}">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                        </svg>
                        {{ __('forum.text_post') }}
                    </button>
                    <button wire:click="$set('postType', 'image')" 
                            class="flex-1 px-6 py-4 font-semibold transition-all {{ $postType === 'image' ? 'text-orange-500 border-b-2 border-orange-500' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-neutral-800' }}">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ __('forum.image_post') }}
                    </button>
                    <button wire:click="$set('postType', 'link')" 
                            class="flex-1 px-6 py-4 font-semibold transition-all {{ $postType === 'link' ? 'text-orange-500 border-b-2 border-orange-500' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-neutral-800' }}">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                        {{ __('forum.link_post') }}
                    </button>
                </div>
            </div>

            {{-- Post Form --}}
            <form wire:submit="createPost" class="bg-white dark:bg-neutral-900 rounded-b-xl p-6 space-y-6">
                {{-- Title --}}
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('forum.post_title') }}
                    </label>
                    <input type="text" 
                           id="title" 
                           wire:model="title" 
                           maxlength="300"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-neutral-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                           placeholder="{{ __('forum.post_title_placeholder') }}">
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    <p class="text-sm text-gray-500 mt-1">{{ strlen($title ?? '') }}/300</p>
                </div>

                {{-- Content based on type --}}
                @if($postType === 'text')
                    <div>
                        <label for="content" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('forum.post_content') }}
                        </label>
                        <textarea id="content" 
                                  wire:model="content" 
                                  rows="10"
                                  class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-neutral-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                  placeholder="{{ __('forum.post_content_placeholder') }}"></textarea>
                        @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                @elseif($postType === 'image')
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('forum.upload_image') }}
                        </label>
                        <div class="border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-lg p-6 text-center">
                            <input type="file" 
                                   wire:model="image" 
                                   accept="image/*"
                                   class="hidden"
                                   id="imageUpload">
                            
                            @if($imagePreview)
                                <img src="{{ $imagePreview }}" alt="Preview" class="max-w-full max-h-96 mx-auto rounded-lg mb-4">
                                <button type="button" 
                                        wire:click="$set('image', null)" 
                                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                    {{ __('forum.remove_image') }}
                                </button>
                            @else
                                <label for="imageUpload" class="cursor-pointer">
                                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    <p class="text-gray-600 dark:text-gray-400">{{ __('forum.click_to_upload') }}</p>
                                    <p class="text-sm text-gray-500 mt-1">PNG, JPG, GIF fino a 10MB</p>
                                </label>
                            @endif
                        </div>
                        @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                @elseif($postType === 'link')
                    <div>
                        <label for="url" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('forum.link_url') }}
                        </label>
                        <input type="url" 
                               id="url" 
                               wire:model="url" 
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-neutral-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                               placeholder="https://example.com">
                        @error('url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                @endif

                {{-- Actions --}}
                <div class="flex justify-between items-center pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('forum.subreddit.show', $subreddit) }}" wire:navigate
                       class="px-6 py-3 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white font-semibold">
                        {{ __('forum.cancel') }}
                    </a>
                    
                    <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-lg font-semibold hover:shadow-lg transition-all disabled:opacity-50"
                            wire:loading.attr="disabled">
                        <span wire:loading.remove>{{ __('forum.publish_post') }}</span>
                        <span wire:loading>{{ __('forum.publishing') }}...</span>
                    </button>
                </div>
            </form>

            {{-- Rules Sidebar --}}
            <div class="mt-6 bg-white dark:bg-neutral-900 rounded-xl p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('forum.posting_rules') }}</h3>
                @if($subreddit->rules)
                    <div class="prose dark:prose-invert prose-sm">
                        {!! nl2br(e($subreddit->rules)) !!}
                    </div>
                @else
                    <p class="text-gray-500">{{ __('forum.no_rules_yet') }}</p>
                @endif
            </div>
        </div>
    </div>
</div>

