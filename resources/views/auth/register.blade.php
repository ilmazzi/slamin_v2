<x-layouts.master>
    <x-slot name="title">{{ __('register.register') }}</x-slot>

    <div class="min-h-screen flex">
        <!-- Left Side - Features -->
        <div class="hidden lg:flex flex-1 bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800 items-center justify-center p-12 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute w-96 h-96 bg-white rounded-full blur-3xl -top-48 -left-48 animate-pulse"></div>
                <div class="absolute w-96 h-96 bg-white rounded-full blur-3xl -bottom-48 -right-48 animate-pulse" style="animation-delay: 1s;"></div>
            </div>

            <div class="max-w-lg relative z-10 text-white">
                <h3 class="text-4xl font-bold mb-4" style="font-family: 'Crimson Pro', serif;">
                    {{ __('register.home_for_poetry') }}
                </h3>
                <p class="text-xl text-white/90 mb-8">
                    {{ __('register.platform_description') }}
                </p>
                
                <div class="grid grid-cols-2 gap-4 mt-8">
                    <div class="text-center p-4 bg-white/10 rounded-xl backdrop-blur-sm">
                        <div class="text-3xl font-bold mb-1">1000+</div>
                        <div class="text-sm">{{ __('register.poets') }}</div>
                    </div>
                    <div class="text-center p-4 bg-white/10 rounded-xl backdrop-blur-sm">
                        <div class="text-3xl font-bold mb-1">500+</div>
                        <div class="text-sm">{{ __('register.events_general') }}</div>
                    </div>
                    <div class="text-center p-4 bg-white/10 rounded-xl backdrop-blur-sm">
                        <div class="text-3xl font-bold mb-1">100+</div>
                        <div class="text-sm">{{ __('register.venues') }}</div>
                    </div>
                    <div class="text-center p-4 bg-white/10 rounded-xl backdrop-blur-sm">
                        <div class="text-3xl font-bold mb-1">5000+</div>
                        <div class="text-sm">{{ __('register.community') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="flex-1 flex items-center justify-center px-4 py-12 sm:px-6 lg:px-8 bg-neutral-50 dark:bg-neutral-950">
            <div class="max-w-md w-full">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h2 class="text-4xl font-bold text-neutral-900 dark:text-white mb-2" style="font-family: 'Crimson Pro', serif;">
                        {{ __('register.create_account') }}
                    </h2>
                    <p class="text-neutral-600 dark:text-neutral-400">
                        {{ __('register.complete_profile') }}
                    </p>
                </div>

                <!-- Register Form -->
                <form action="{{ route('register.process') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Nome Completo -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('register.full_name') }}
                        </label>
                        <input id="name" 
                               name="name" 
                               type="text" 
                               required 
                               value="{{ old('name') }}"
                               placeholder="{{ __('register.full_name_placeholder') }}"
                               class="w-full px-4 py-3 border-2 border-neutral-200 dark:border-neutral-700 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:bg-neutral-800 dark:text-white transition-all">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nickname (Opzionale) -->
                    <div>
                        <label for="nickname" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('register.nickname') }} 
                            <span class="text-xs text-neutral-500">({{ __('register.optional') }})</span>
                        </label>
                        <input id="nickname" 
                               name="nickname" 
                               type="text" 
                               value="{{ old('nickname') }}"
                               placeholder="{{ __('register.nickname_placeholder') }}"
                               class="w-full px-4 py-3 border-2 border-neutral-200 dark:border-neutral-700 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:bg-neutral-800 dark:text-white transition-all">
                        @error('nickname')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('register.email') }}
                        </label>
                        <input id="email" 
                               name="email" 
                               type="email" 
                               required 
                               value="{{ old('email') }}"
                               placeholder="{{ __('register.email_placeholder') }}"
                               class="w-full px-4 py-3 border-2 border-neutral-200 dark:border-neutral-700 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:bg-neutral-800 dark:text-white transition-all">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('register.password') }}
                        </label>
                        <input id="password" 
                               name="password" 
                               type="password" 
                               required 
                               placeholder="{{ __('auth.password_placeholder') }}"
                               class="w-full px-4 py-3 border-2 border-neutral-200 dark:border-neutral-700 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:bg-neutral-800 dark:text-white transition-all">
                        <p class="mt-1 text-xs text-neutral-500">{{ __('register.password_min_characters') }}</p>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('register.confirm_password') }}
                        </label>
                        <input id="password_confirmation" 
                               name="password_confirmation" 
                               type="password" 
                               required 
                               placeholder="{{ __('auth.confirm_password_placeholder') }}"
                               class="w-full px-4 py-3 border-2 border-neutral-200 dark:border-neutral-700 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:bg-neutral-800 dark:text-white transition-all">
                    </div>

                    <!-- Submit Button -->
                    <x-ui.buttons.primary type="submit" class="w-full">
                        {{ __('register.join_slam_in') }}
                    </x-ui.buttons.primary>

                    <!-- Login Link -->
                    <div class="text-center">
                        <p class="text-sm text-neutral-600 dark:text-neutral-400">
                            {{ __('register.already_have_account') }}
                            <a href="{{ route('login') }}" class="font-semibold text-primary-600 hover:text-primary-700">
                                {{ __('register.login') }}
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.master>
