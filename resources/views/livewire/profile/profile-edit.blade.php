<div class="min-h-screen bg-neutral-50 dark:bg-neutral-900 py-8 md:py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
                <div>
                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-neutral-900 dark:text-white mb-2" style="font-family: 'Crimson Pro', serif;">
                        {{ __('profile.edit.title') }}
                    </h1>
                    <p class="text-neutral-600 dark:text-neutral-400">{{ __('profile.edit.subtitle') }}</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('profile.languages') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white rounded-lg font-semibold transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                        </svg>
                        <span class="hidden sm:inline">{{ __('profile.languages') }}</span>
                    </a>
                    <a href="{{ route('profile.badges') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-semibold transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                        <span class="hidden sm:inline">{{ __('profile.badges') }}</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Success/Error Messages --}}
        @if(session()->has('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border-2 border-green-200 dark:border-green-800 rounded-xl">
                <p class="text-green-800 dark:text-green-400 font-semibold">{{ session('success') }}</p>
            </div>
        @endif

        @if(session()->has('error'))
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border-2 border-red-200 dark:border-red-800 rounded-xl">
                <p class="text-red-800 dark:text-red-400 font-semibold">{{ session('error') }}</p>
            </div>
        @endif

        {{-- Profile Preview Card --}}
        <div class="bg-white dark:bg-neutral-800 rounded-xl overflow-hidden border border-neutral-200 dark:border-neutral-700 shadow-sm mb-6">
            <div class="relative h-32 sm:h-40 overflow-hidden bg-gradient-to-br from-primary-600 via-accent-600 to-primary-800">
                @if($banner)
                    <img src="{{ $banner->temporaryUrl() }}" alt="Banner" class="w-full h-full object-cover opacity-90">
                @elseif($user->banner_image_url)
                    <img src="{{ $user->banner_image_url }}" alt="Banner" class="w-full h-full object-cover opacity-90">
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                
                {{-- Avatar Preview --}}
                <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2">
                    @if($avatar)
                        <img src="{{ $avatar->temporaryUrl() }}" alt="Avatar" class="w-24 h-24 sm:w-28 sm:h-28 rounded-full border-4 border-white dark:border-neutral-900 shadow-xl object-cover">
                    @else
                        <img src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($user, 200) }}" alt="Avatar" class="w-24 h-24 sm:w-28 sm:h-28 rounded-full border-4 border-white dark:border-neutral-900 shadow-xl object-cover">
                    @endif
                </div>
            </div>
            
            <div class="pt-16 sm:pt-20 pb-6 text-center">
                <h2 class="text-xl font-bold text-neutral-900 dark:text-white">{{ $user->name }}</h2>
                @if($user->nickname)
                    <p class="text-primary-600 dark:text-primary-400">{{ $user->nickname }}</p>
                @endif
            </div>
        </div>

        {{-- Edit Form --}}
        <form wire:submit="save" class="space-y-6">
            {{-- Images Section --}}
            <div class="bg-white dark:bg-neutral-800 rounded-xl p-6 border border-neutral-200 dark:border-neutral-700 shadow-sm">
                <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">{{ __('profile.edit.images') }}</h3>
                
                <div class="grid sm:grid-cols-2 gap-6">
                    {{-- Avatar --}}
                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('profile.edit.avatar') }}
                        </label>
                        <input type="file" 
                               wire:model="avatar" 
                               accept="image/*"
                               class="w-full px-4 py-2 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-900 dark:text-white text-sm">
                        <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">{{ __('profile.edit.avatar_help') }}</p>
                        @error('avatar') 
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> 
                        @enderror
                        @if($avatar || $user->profile_photo)
                            <button type="button" 
                                    wire:click="removeAvatar"
                                    class="mt-2 px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold rounded-lg transition-colors">
                                {{ __('profile.edit.remove_avatar') }}
                            </button>
                        @endif
                    </div>
                    
                    {{-- Banner --}}
                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('profile.edit.banner') }}
                        </label>
                        <input type="file" 
                               wire:model="banner" 
                               accept="image/*"
                               class="w-full px-4 py-2 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-900 dark:text-white text-sm">
                        <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">{{ __('profile.edit.banner_help') }}</p>
                        @error('banner') 
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> 
                        @enderror
                        @if($banner || $user->banner_image)
                            <button type="button" 
                                    wire:click="removeBanner"
                                    class="mt-2 px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold rounded-lg transition-colors">
                                {{ __('profile.edit.remove_banner') }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Basic Information --}}
            <div class="bg-white dark:bg-neutral-800 rounded-xl p-6 border border-neutral-200 dark:border-neutral-700 shadow-sm">
                <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">{{ __('profile.edit.basic_info') }}</h3>
                
                <div class="grid sm:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('profile.edit.name') }} *
                        </label>
                        <input type="text" 
                               id="name"
                               wire:model="name" 
                               required
                               class="w-full px-4 py-2 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-900 dark:text-white">
                        @error('name') 
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> 
                        @enderror
                    </div>
                    
                    <div>
                        <label for="nickname" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('profile.edit.nickname') }} *
                        </label>
                        <input type="text" 
                               id="nickname"
                               wire:model="nickname" 
                               required
                               class="w-full px-4 py-2 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-900 dark:text-white">
                        @error('nickname') 
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> 
                        @enderror
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('profile.edit.email') }} *
                        </label>
                        <input type="email" 
                               id="email"
                               wire:model="email" 
                               required
                               class="w-full px-4 py-2 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-900 dark:text-white">
                        @error('email') 
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> 
                        @enderror
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('profile.edit.phone') }}
                        </label>
                        <input type="tel" 
                               id="phone"
                               wire:model="phone" 
                               class="w-full px-4 py-2 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-900 dark:text-white">
                        @error('phone') 
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> 
                        @enderror
                    </div>
                    
                    <div>
                        <label for="location" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('profile.edit.location') }}
                        </label>
                        <input type="text" 
                               id="location"
                               wire:model="location" 
                               class="w-full px-4 py-2 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-900 dark:text-white">
                        @error('location') 
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> 
                        @enderror
                    </div>
                    
                    <div>
                        <label for="birth_date" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('profile.edit.birth_date') }}
                        </label>
                        <input type="date" 
                               id="birth_date"
                               wire:model="birth_date" 
                               class="w-full px-4 py-2 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-900 dark:text-white">
                        @error('birth_date') 
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> 
                        @enderror
                    </div>
                    
                    <div class="sm:col-span-2">
                        <label for="website" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('profile.edit.website') }}
                        </label>
                        <input type="text" 
                               id="website"
                               wire:model.blur="website" 
                               placeholder="www.example.com"
                               class="w-full px-4 py-2 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-900 dark:text-white">
                        @error('website') 
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> 
                        @enderror
                        <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">{{ __('profile.edit.website_hint') }}</p>
                    </div>
                    
                    <div class="sm:col-span-2">
                        <label for="bio" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('profile.edit.bio') }}
                        </label>
                        <textarea id="bio"
                                  wire:model="bio" 
                                  rows="4"
                                  maxlength="1000"
                                  class="w-full px-4 py-2 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-900 dark:text-white resize-none"></textarea>
                        <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">{{ __('profile.edit.bio_help') }}</p>
                        @error('bio') 
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> 
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Social Links --}}
            <div class="bg-white dark:bg-neutral-800 rounded-xl p-6 border border-neutral-200 dark:border-neutral-700 shadow-sm">
                <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">{{ __('profile.edit.social_links') }}</h3>
                
                <div class="grid sm:grid-cols-2 gap-6">
                    <div>
                        <label for="social_facebook" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            Facebook
                        </label>
                        <input type="text" 
                               id="social_facebook"
                               wire:model.blur="social_facebook" 
                               placeholder="facebook.com/username"
                               class="w-full px-4 py-2 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-900 dark:text-white">
                        @error('social_facebook') 
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> 
                        @enderror
                    </div>
                    
                    <div>
                        <label for="social_instagram" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            Instagram
                        </label>
                        <input type="text" 
                               id="social_instagram"
                               wire:model.blur="social_instagram" 
                               placeholder="instagram.com/username"
                               class="w-full px-4 py-2 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-900 dark:text-white">
                        @error('social_instagram') 
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> 
                        @enderror
                    </div>
                    
                    <div>
                        <label for="social_twitter" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            Twitter
                        </label>
                        <input type="text" 
                               id="social_twitter"
                               wire:model.blur="social_twitter" 
                               placeholder="twitter.com/username"
                               class="w-full px-4 py-2 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-900 dark:text-white">
                        @error('social_twitter') 
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> 
                        @enderror
                    </div>
                    
                    <div>
                        <label for="social_youtube" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            YouTube
                        </label>
                        <input type="text" 
                               id="social_youtube"
                               wire:model.blur="social_youtube" 
                               placeholder="youtube.com/channel/..."
                               class="w-full px-4 py-2 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-900 dark:text-white">
                        @error('social_youtube') 
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> 
                        @enderror
                    </div>
                    
                    <div class="sm:col-span-2">
                        <label for="social_linkedin" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            LinkedIn
                        </label>
                        <input type="text" 
                               id="social_linkedin"
                               wire:model.blur="social_linkedin" 
                               placeholder="linkedin.com/in/username"
                               class="w-full px-4 py-2 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-900 dark:text-white">
                        @error('social_linkedin') 
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> 
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Privacy Settings --}}
            <div class="bg-white dark:bg-neutral-800 rounded-xl p-6 border border-neutral-200 dark:border-neutral-700 shadow-sm">
                <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">{{ __('profile.edit.privacy') }}</h3>
                <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-4">{{ __('profile.edit.privacy_description') }}</p>
                
                <div class="space-y-4">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" 
                               wire:model.live="show_email" 
                               class="w-5 h-5 text-primary-600 rounded focus:ring-primary-500 cursor-pointer">
                        <div>
                            <div class="font-semibold text-neutral-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">{{ __('profile.edit.show_email') }}</div>
                            <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('profile.edit.show_email_help') }}</div>
                        </div>
                    </label>
                    
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" 
                               wire:model.live="show_phone" 
                               class="w-5 h-5 text-primary-600 rounded focus:ring-primary-500 cursor-pointer">
                        <div>
                            <div class="font-semibold text-neutral-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">{{ __('profile.edit.show_phone') }}</div>
                            <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('profile.edit.show_phone_help') }}</div>
                        </div>
                    </label>
                    
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" 
                               wire:model.live="show_birth_date" 
                               class="w-5 h-5 text-primary-600 rounded focus:ring-primary-500 cursor-pointer">
                        <div>
                            <div class="font-semibold text-neutral-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">{{ __('profile.edit.show_birth_date') }}</div>
                            <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('profile.edit.show_birth_date_help') }}</div>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Danger Zone --}}
            <div class="bg-red-50 dark:bg-red-900/20 rounded-xl p-6 border-2 border-red-200 dark:border-red-800 shadow-sm">
                <h3 class="text-xl font-bold text-red-900 dark:text-red-100 mb-2 flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    {{ __('profile.edit.danger_zone') }}
                </h3>
                <p class="text-red-800 dark:text-red-200 mb-4">
                    {{ __('profile.edit.danger_zone_description') }}
                </p>
                <a href="{{ route('profile.delete') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    {{ __('profile.edit.delete_account') }}
                </a>
            </div>

            {{-- Submit Buttons --}}
            <div class="flex flex-col sm:flex-row justify-between gap-4">
                <a href="{{ route('profile.show') }}" 
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-lg bg-neutral-200 dark:bg-neutral-700 hover:bg-neutral-300 dark:hover:bg-neutral-600 text-neutral-900 dark:text-white font-semibold transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    {{ __('profile.edit.cancel') }}
                </a>
                <button type="submit" 
                        wire:loading.attr="disabled"
                        wire:target="save"
                        class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-lg bg-primary-600 hover:bg-primary-700 disabled:bg-neutral-400 disabled:cursor-not-allowed text-white font-semibold shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                    <span wire:loading.remove wire:target="save" class="inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('profile.edit.save') }}
                    </span>
                    <span wire:loading wire:target="save" class="inline-flex items-center gap-2">
                        <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-white"></div>
                        {{ __('profile.edit.saving') }}
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

