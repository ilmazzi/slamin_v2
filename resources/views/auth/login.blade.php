<x-layouts.master>
    <x-slot name="title">{{ __('login.login_to_your_account') }}</x-slot>

    <div class="min-h-screen flex">
        <!-- Left Side - Form -->
        <div class="flex-1 flex items-center justify-center px-4 py-12 sm:px-6 lg:px-8 bg-white dark:bg-neutral-900">
            <div class="max-w-md w-full space-y-8">
                <!-- Logo -->
                <div class="text-center">
                    <img src="{{ asset('assets/images/Logo_orizzontale_nerosubianco.png') }}" 
                         alt="{{ config('app.name') }}" 
                         class="h-12 mx-auto mb-8">
                    
                    <h2 class="text-4xl font-bold text-neutral-900 dark:text-white mb-2" style="font-family: 'Crimson Pro', serif;">
                        {{ __('login.login_to_your_account') }}
                    </h2>
                    <p class="text-neutral-600 dark:text-neutral-400">
                        {{ __('login.enter_slam_in_and_discover_the_italian_slam_world') }}
                    </p>
                </div>

                <!-- Login Form -->
                <form action="{{ route('login.process') }}" method="POST" class="mt-8 space-y-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('login.email') }}
                        </label>
                        <input id="email" 
                               name="email" 
                               type="email" 
                               required 
                               autocomplete="email"
                               value="{{ old('email') }}"
                               placeholder="{{ __('login.email_placeholder') }}"
                               class="w-full px-4 py-3 border-2 border-neutral-200 dark:border-neutral-700 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:bg-neutral-800 dark:text-white transition-all">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('login.password') }}
                        </label>
                        <input id="password" 
                               name="password" 
                               type="password" 
                               required 
                               autocomplete="current-password"
                               placeholder="{{ __('login.password_placeholder') }}"
                               class="w-full px-4 py-3 border-2 border-neutral-200 dark:border-neutral-700 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:bg-neutral-800 dark:text-white transition-all">
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="remember" 
                                   class="w-4 h-4 text-primary-600 border-neutral-300 rounded focus:ring-primary-500">
                            <span class="ml-2 text-sm text-neutral-700 dark:text-neutral-300">
                                {{ __('login.remember_me') }}
                            </span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <x-ui.buttons.primary type="submit" class="w-full">
                        {{ __('login.enter_slam_in') }}
                    </x-ui.buttons.primary>

                    <!-- Register Link -->
                    <div class="text-center">
                        <p class="text-sm text-neutral-600 dark:text-neutral-400">
                            {{ __('login.no_account') }}
                            <a href="{{ route('register') }}" class="font-semibold text-primary-600 hover:text-primary-700">
                                {{ __('login.register_here') }}
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Side - Features (Hidden on Mobile) -->
        <div class="hidden lg:flex flex-1 bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800 items-center justify-center p-12 relative overflow-hidden">
            <!-- Animated Background -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute w-96 h-96 bg-white rounded-full blur-3xl -top-48 -left-48 animate-pulse"></div>
                <div class="absolute w-96 h-96 bg-white rounded-full blur-3xl -bottom-48 -right-48 animate-pulse" style="animation-delay: 1s;"></div>
            </div>

            <div class="max-w-lg relative z-10 text-white">
                <h3 class="text-4xl font-bold mb-4" style="font-family: 'Crimson Pro', serif;">
                    {{ __('login.welcome_text') }}
                </h3>
                
                <ul class="space-y-4 mt-8">
                    <li class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <span class="text-lg">{{ __('login.events_and_shows') }}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <span class="text-lg">{{ __('login.poets_community') }}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <span class="text-lg">{{ __('login.share_your_performances') }}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-lg">{{ __('login.participate_in_competitions') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</x-layouts.master>
