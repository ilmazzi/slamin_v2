<div class="min-h-screen bg-neutral-50 dark:bg-neutral-950">
    <!-- Navigation Header -->
    <x-layouts.navigation-modern />
    
    <!-- Main Content -->
    <div class="pt-16 md:pt-20">
        <div class="flex items-center justify-center min-h-[calc(100vh-4rem)] md:min-h-[calc(100vh-5rem)] px-4 py-6 sm:px-6 lg:px-8">
            <div class="max-w-md w-full mx-auto">
                <!-- Success Message -->
                @if (session('status'))
                    <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl">
                        <p class="text-sm text-green-600 dark:text-green-400">{{ session('status') }}</p>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl">
                        <p class="text-sm text-green-600 dark:text-green-400">{{ session('success') }}</p>
                    </div>
                @endif

                <!-- Verification Notice Card -->
                <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-xl p-8 border border-neutral-200 dark:border-neutral-800">
                    <!-- Icon -->
                    <div class="flex justify-center mb-6">
                        <div class="w-16 h-16 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Title -->
                    <h2 class="text-3xl font-bold text-center text-neutral-900 dark:text-white mb-4" style="font-family: 'Crimson Pro', serif;">
                        {{ __('auth.email_verification_required') }}
                    </h2>

                    <!-- Description -->
                    <p class="text-center text-neutral-600 dark:text-neutral-400 mb-8">
                        {{ __('auth.email_verification_description') }}
                    </p>

                    <!-- Email Info -->
                    <div class="mb-6 p-4 bg-neutral-50 dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700">
                        <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-1">
                            {{ __('auth.email') }}:
                        </p>
                        <p class="text-base font-semibold text-neutral-900 dark:text-white">
                            {{ auth()->user()->email }}
                        </p>
                    </div>

                    <!-- Resend Section -->
                    <div class="mb-6">
                        <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-4 text-center">
                            {{ __('auth.email_not_received') }}
                        </p>
                        <button wire:click="resend" 
                                class="w-full px-4 py-3 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-xl transition-colors">
                            {{ __('auth.resend_verification') }}
                        </button>
                    </div>

                    <!-- Back to Login -->
                    <div class="text-center">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                                {{ __('auth.back_to_login') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <x-layouts.footer-modern />
</div>
