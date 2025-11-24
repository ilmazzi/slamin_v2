<div class="min-h-screen bg-neutral-50 dark:bg-neutral-950">
    <!-- Navigation Header -->
    <x-layouts.navigation-modern />
    
    <!-- Main Content -->
    <div class="pt-16 md:pt-20">
        <div class="min-h-[calc(100vh-4rem)] md:min-h-[calc(100vh-5rem)] flex flex-col lg:flex-row max-w-7xl mx-auto">
            <!-- Left Side - Form -->
            <div class="flex-1 flex items-center justify-center px-4 py-6 sm:px-6 lg:px-8 bg-white dark:bg-neutral-900 lg:min-h-[calc(100vh-5rem)] overflow-x-hidden">
                <div class="max-w-md w-full mx-auto space-y-6 sm:space-y-8">
                    <!-- Logo -->
                    <div class="text-center">
                        <img src="{{ asset('assets/images/Logo_orizzontale_nerosubianco.png') }}" 
                             alt="{{ config('app.name') }}" 
                             class="h-12 mx-auto mb-8">
                        
                        <h2 class="text-4xl font-bold text-neutral-900 dark:text-white mb-2" style="font-family: 'Crimson Pro', serif;">
                            {{ __('auth.forgot_password') }}
                        </h2>
                        <p class="text-neutral-600 dark:text-neutral-400">
                            {{ __('auth.forgot_password_description') }}
                        </p>
                    </div>

                    @if($status === 'sent')
                        <!-- Success Message -->
                        <div class="bg-green-50 dark:bg-green-900/20 border-2 border-green-200 dark:border-green-800 rounded-xl p-6">
                            <div class="flex items-start gap-3">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <div>
                                    <h3 class="text-lg font-semibold text-green-900 dark:text-green-100 mb-1">
                                        {{ __('auth.reset_link_sent') }}
                                    </h3>
                                    <p class="text-sm text-green-700 dark:text-green-300">
                                        {{ __('auth.reset_link_sent_description', ['email' => $email]) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Back to Login -->
                        <div class="text-center">
                            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700 font-semibold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                {{ __('auth.back_to_login') }}
                            </a>
                        </div>
                    @else
                        <!-- Forgot Password Form -->
                        <form wire:submit="sendResetLink" class="mt-8 space-y-6">
                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                                    {{ __('login.email') }}
                                </label>
                                <input id="email" 
                                       wire:model="email"
                                       type="email" 
                                       required 
                                       autocomplete="email"
                                       placeholder="{{ __('login.email_placeholder') }}"
                                       class="w-full px-4 py-3 border-2 border-neutral-200 dark:border-neutral-700 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:bg-neutral-800 dark:text-white transition-all">
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="w-full px-4 py-3 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-xl transition-colors">
                                {{ __('auth.send_reset_link') }}
                            </button>

                            <!-- Back to Login -->
                            <div class="text-center">
                                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-sm text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                    {{ __('auth.back_to_login') }}
                                </a>
                            </div>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Right Side - Features (Hidden on Mobile) -->
            <div class="hidden lg:flex flex-1 bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800 items-center justify-center p-6 xl:p-8 relative overflow-hidden">
                <!-- Animated Background -->
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute w-96 h-96 bg-white rounded-full blur-3xl -top-48 -left-48 animate-pulse"></div>
                    <div class="absolute w-96 h-96 bg-white rounded-full blur-3xl -bottom-48 -right-48 animate-pulse" style="animation-delay: 1s;"></div>
                </div>

                <div class="max-w-lg relative z-10 text-white">
                    <h3 class="text-4xl font-bold mb-4" style="font-family: 'Crimson Pro', serif;">
                        {{ __('auth.password_reset_help_title') }}
                    </h3>
                    <p class="text-lg mb-8 text-white/90">
                        {{ __('auth.password_reset_help_description') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <x-layouts.footer-modern />
</div>

