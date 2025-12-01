<x-layouts.app>
    <x-slot name="title">{{ __('cookies.policy_title') }}</x-slot>

    <div class="min-h-screen bg-white dark:bg-neutral-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <h1 class="text-4xl md:text-5xl font-bold text-neutral-900 dark:text-white mb-4" style="font-family: 'Crimson Pro', serif;">
                {{ __('cookies.policy_title') }}
            </h1>
            
            <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-8">
                {{ __('cookies.policy_version') }}
            </p>
            
            <div class="prose prose-lg dark:prose-invert max-w-none">
                <div class="text-neutral-700 dark:text-neutral-300 space-y-6">
                    
                    <!-- What are cookies -->
                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4">{{ __('cookies.what_are_cookies_title') }}</h2>
                        <p>{{ __('cookies.what_are_cookies_text') }}</p>
                    </section>

                    <!-- How we use cookies -->
                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4">{{ __('cookies.how_we_use_title') }}</h2>
                        <p>{{ __('cookies.how_we_use_text') }}</p>
                    </section>

                    <!-- Types of cookies -->
                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4">{{ __('cookies.types_title') }}</h2>

                        <!-- Necessary cookies -->
                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3 flex items-center gap-2">
                                <span class="text-2xl">🔒</span>
                                {{ __('cookies.necessary_cookies_title') }}
                            </h3>
                            <p>{{ __('cookies.necessary_cookies_text') }}</p>
                            <p class="mt-2 text-sm italic text-neutral-600 dark:text-neutral-400">
                                {{ __('cookies.necessary_cookies_examples') }}
                            </p>
                        </article>

                        <!-- Analytics cookies -->
                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3 flex items-center gap-2">
                                <span class="text-2xl">📊</span>
                                {{ __('cookies.analytics_cookies_title') }}
                            </h3>
                            <p>{{ __('cookies.analytics_cookies_text') }}</p>
                            <p class="mt-2 text-sm italic text-neutral-600 dark:text-neutral-400">
                                {{ __('cookies.analytics_cookies_examples') }}
                            </p>
                        </article>

                        <!-- NO Marketing cookies - Political Statement -->
                        <article class="mb-8 p-6 bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/20 dark:to-orange-900/20 rounded-xl border-2 border-red-200 dark:border-red-800">
                            <h3 class="text-xl font-bold text-red-900 dark:text-red-300 mb-3 flex items-center gap-2">
                                <span class="text-2xl">🚫</span>
                                {{ __('cookies.no_marketing_title') }}
                            </h3>
                            <p class="text-red-800 dark:text-red-300 font-semibold leading-relaxed">
                                {{ __('cookies.no_marketing_statement') }}
                            </p>
                            <p class="mt-4 text-red-900 dark:text-red-400 font-bold text-lg">
                                {{ __('cookies.no_marketing_emphasis') }}
                            </p>
                        </article>
                    </section>

                    <!-- Managing preferences -->
                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4">{{ __('cookies.manage_title') }}</h2>
                        <p>{{ __('cookies.manage_text') }}</p>
                        
                        <div class="mt-4">
                            <button 
                                onclick="localStorage.removeItem('cookie_consent'); location.reload();"
                                class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg transition-colors shadow-lg">
                                🍪 {{ __('cookies.customize') }}
                            </button>
                        </div>
                    </section>

                    <!-- Browser settings -->
                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4">{{ __('cookies.browser_settings_title') }}</h2>
                        <p>{{ __('cookies.browser_settings_text') }}</p>
                    </section>

                    <!-- More information -->
                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4">{{ __('cookies.more_info_title') }}</h2>
                        <p>
                            {{ __('cookies.more_info_text') }}
                            <a href="{{ route('privacy') }}" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 font-semibold">
                                {{ __('cookies.more_info_link') }}
                            </a>.
                        </p>
                    </section>

                    <!-- Contact -->
                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4">{{ __('cookies.contact_title') }}</h2>
                        <p>
                            {{ __('cookies.contact_text') }}
                            <a href="mailto:mail@slamin.it" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 font-semibold">
                                mail@slamin.it
                            </a>.
                        </p>
                    </section>

                    <!-- Last updated -->
                    <div class="mt-12 pt-8 border-t border-neutral-200 dark:border-neutral-700 text-sm text-neutral-600 dark:text-neutral-400">
                        <p>{{ __('cookies.last_updated') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

