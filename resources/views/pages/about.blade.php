<x-layouts.app>
    <x-slot name="title">{{ __('about.title') }}</x-slot>

    <div class="min-h-screen bg-gradient-to-br from-neutral-50 via-primary-50/30 to-accent-50/20 dark:from-neutral-900 dark:via-primary-950/50 dark:to-accent-950/30">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 md:pt-12 pb-16 md:pb-24">
            
            <!-- Header -->
            <div class="text-center mb-12 md:mb-16">
                <h1 class="text-4xl md:text-6xl font-bold text-neutral-900 dark:text-white mb-4" style="font-family: 'Crimson Pro', serif;">
                    {{ __('about.title') }}
                </h1>
                <p class="text-xl md:text-2xl text-neutral-600 dark:text-neutral-300 max-w-3xl mx-auto">
                    {{ __('about.subtitle') }}
                </p>
            </div>

            <!-- Main Content -->
            <div class="space-y-16">
                
                <!-- Slam In Section -->
                <div class="bg-white/80 dark:bg-neutral-800/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-neutral-200 dark:border-neutral-700 p-8 md:p-12">
                    <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
                        <!-- Logo Slam In -->
                        <div class="flex-shrink-0">
                            <img src="{{ asset('assets/images/Logo_orizzontale_nerosubianco.png') }}" 
                                 alt="Slam In Logo" 
                                 class="h-20 md:h-24 w-auto dark:invert">
                        </div>
                        
                        <!-- Content -->
                        <div class="flex-1 text-center md:text-left">
                            <h2 class="text-2xl md:text-3xl font-bold text-neutral-900 dark:text-white mb-4">
                                {{ __('about.slam_in.title') }}
                            </h2>
                            <div class="prose prose-lg dark:prose-invert max-w-none text-neutral-700 dark:text-neutral-300">
                                <p class="mb-4">
                                    {{ __('about.slam_in.description') }}
                                </p>
                                <p>
                                    {{ __('about.slam_in.contact') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hævol Section -->
                <div class="bg-white/80 dark:bg-neutral-800/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-neutral-200 dark:border-neutral-700 p-8 md:p-12">
                    <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
                        <!-- Logo Hævol -->
                        <div class="flex-shrink-0 flex items-center justify-center">
                            <img src="{{ asset('assets/images/haevol-logo.svg') }}" 
                                 alt="Hævol Logo" 
                                 class="h-20 md:h-24 w-auto">
                        </div>
                        
                        <!-- Content -->
                        <div class="flex-1 text-center md:text-left">
                            <h2 class="text-2xl md:text-3xl font-bold text-neutral-900 dark:text-white mb-4">
                                {{ __('about.haevol.title') }}
                            </h2>
                            <div class="prose prose-lg dark:prose-invert max-w-none text-neutral-700 dark:text-neutral-300">
                                <p>
                                    {{ __('about.haevol.description') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-layouts.app>
