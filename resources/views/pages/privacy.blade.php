<x-layouts.app>
    <x-slot name="title">{{ __('privacy.title') }}</x-slot>

    <div class="min-h-screen bg-white dark:bg-neutral-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <h1 class="text-4xl md:text-5xl font-bold text-neutral-900 dark:text-white mb-4" style="font-family: 'Crimson Pro', serif;">
                {{ __('privacy.title') }}
            </h1>
            
            <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-8">
                {{ __('privacy.version') }}
            </p>
            
            <div class="prose prose-lg dark:prose-invert max-w-none">
                <div class="text-neutral-700 dark:text-neutral-300 space-y-6">
                    
                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4">{{ __('privacy.about_title') }}</h2>
                        <p>{{ __('privacy.about_p1') }}</p>
                        <p>{{ __('privacy.about_p2') }}</p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4">{{ __('privacy.definitions_title') }}</h2>
                        <dl class="space-y-4">
                            <div>
                                <dt class="font-semibold text-neutral-900 dark:text-white">{{ __('privacy.def_gdpr') }}</dt>
                                <dd class="mt-1">{{ __('privacy.def_gdpr_text') }}</dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-neutral-900 dark:text-white">{{ __('privacy.def_data') }}</dt>
                                <dd class="mt-1">{{ __('privacy.def_data_text') }}</dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-neutral-900 dark:text-white">{{ __('privacy.def_services') }}</dt>
                                <dd class="mt-1">{{ __('privacy.def_services_text') }}</dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-neutral-900 dark:text-white">{{ __('privacy.def_user') }}</dt>
                                <dd class="mt-1">{{ __('privacy.def_user_text') }}</dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-neutral-900 dark:text-white">{{ __('privacy.def_slamin') }}</dt>
                                <dd class="mt-1">{{ __('privacy.def_slamin_text') }}</dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-neutral-900 dark:text-white">{{ __('privacy.def_platform') }}</dt>
                                <dd class="mt-1">{{ __('privacy.def_platform_text') }}</dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-neutral-900 dark:text-white">{{ __('privacy.def_credentials') }}</dt>
                                <dd class="mt-1">{{ __('privacy.def_credentials_text') }}</dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-neutral-900 dark:text-white">{{ __('privacy.def_attacks') }}</dt>
                                <dd class="mt-1">{{ __('privacy.def_attacks_text') }}</dd>
                            </div>
                        </dl>
                    </section>

                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4">{{ __('privacy.protected_title') }}</h2>
                        <p>{{ __('privacy.protected_p1') }}</p>
                        <p>{{ __('privacy.protected_p2') }} <strong>{{ __('privacy.protected_p2_link') }}</strong>{{ __('privacy.protected_p2_end') }}</p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4">{{ __('privacy.1_title') }}</h2>
                        <p>{{ __('privacy.1_intro') }}</p>
                        <ul class="list-disc pl-6 space-y-2 mt-3">
                            <li><strong>{{ __('privacy.1_email') }}</strong> {{ __('privacy.1_email_text') }}</li>
                            <li><strong>{{ __('privacy.1_password') }}</strong> {{ __('privacy.1_password_text') }}</li>
                        </ul>
                        <p class="mt-4">{{ __('privacy.1_outro') }}</p>

                        <h3 class="text-xl font-bold text-neutral-900 dark:text-white mt-6 mb-3">{{ __('privacy.1_1_title') }}</h3>
                        <p>{{ __('privacy.1_1_p1') }}</p>
                        <p>{{ __('privacy.1_1_p2') }}</p>

                        <h3 class="text-xl font-bold text-neutral-900 dark:text-white mt-6 mb-3">{{ __('privacy.1_2_title') }}</h3>
                        <p>{{ __('privacy.1_2_intro') }}</p>
                        <ul class="list-disc pl-6 space-y-2 mt-3">
                            <li>{{ __('privacy.1_2_item1') }}</li>
                            <li>{{ __('privacy.1_2_item2') }}</li>
                            <li>{{ __('privacy.1_2_item3') }}</li>
                        </ul>

                        <h3 class="text-xl font-bold text-neutral-900 dark:text-white mt-6 mb-3">{{ __('privacy.1_3_title') }}</h3>
                        <p>{{ __('privacy.1_3_text') }}</p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4">{{ __('privacy.2_title') }}</h2>
                        <ul class="list-disc pl-6 space-y-2">
                            <li><strong>NON</strong> {{ __('privacy.2_item1') }}</li>
                            <li><strong>NON</strong> {{ __('privacy.2_item2') }} <strong>NON</strong> {{ __('privacy.2_item2_b') }} <strong>NON</strong> {{ __('privacy.2_item2_c') }} <strong>NON</strong> {{ __('privacy.2_item2_d') }}</li>
                            <li><strong>NON</strong> {{ __('privacy.2_item3') }}</li>
                            <li><strong>NON</strong> {{ __('privacy.2_item4') }}</li>
                            <li><strong>NON</strong> {{ __('privacy.2_item5') }}</li>
                            <li><strong>NON</strong> {{ __('privacy.2_item6') }} <a href="{{ route('terms') }}" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 font-semibold">{{ __('privacy.2_item6_link') }}</a>{{ __('privacy.2_item6_end') }}</li>
                        </ul>
                    </section>

                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4">{{ __('privacy.3_title') }}</h2>
                        <p>{{ __('privacy.3_text') }}</p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4">{{ __('privacy.4_title') }}</h2>
                        <p>{{ __('privacy.4_intro') }}</p>
                        <ul class="list-disc pl-6 space-y-2 mt-3">
                            <li><strong>{{ __('privacy.4_access') }}</strong> {{ __('privacy.4_access_text') }}</li>
                            <li><strong>{{ __('privacy.4_rectification') }}</strong> {{ __('privacy.4_rectification_text') }}</li>
                            <li><strong>{{ __('privacy.4_erasure') }}</strong> {{ __('privacy.4_erasure_text') }}</li>
                            <li><strong>{{ __('privacy.4_restriction') }}</strong> {{ __('privacy.4_restriction_text') }}</li>
                            <li><strong>{{ __('privacy.4_portability') }}</strong> {{ __('privacy.4_portability_text') }}</li>
                            <li><strong>{{ __('privacy.4_objection') }}</strong> {{ __('privacy.4_objection_text') }}</li>
                        </ul>
                        <p class="mt-4 text-sm italic">{{ __('privacy.4_note') }}</p>
                        <p class="mt-4">{{ __('privacy.4_contact') }} <a href="mailto:mail@slamin.it" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 font-semibold">mail@slamin.it</a></p>
                        <p class="mt-4">{{ __('privacy.4_gdpr') }}</p>
                        
                        <div class="mt-6 p-4 bg-neutral-100 dark:bg-neutral-800 rounded-lg">
                            <p class="font-semibold">{{ __('privacy.4_company') }}</p>
                            <p class="text-sm">{{ __('privacy.4_vat') }}</p>
                        </div>

                        <h3 class="text-xl font-bold text-neutral-900 dark:text-white mt-6 mb-3">{{ __('privacy.4_1_title') }}</h3>
                        <p>{{ __('privacy.4_1_p1') }}</p>
                        <p class="mt-2">{{ __('privacy.4_1_p2') }} <strong>{{ __('privacy.4_1_p2_link') }}</strong>{{ __('privacy.4_1_p2_end') }}</p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4">{{ __('privacy.5_title') }}</h2>
                        <p>{{ __('privacy.5_p1') }}</p>
                        <p>{{ __('privacy.5_p2') }}</p>
                    </section>

                    <div class="mt-12 pt-8 border-t border-neutral-200 dark:border-neutral-700 text-sm text-neutral-600 dark:text-neutral-400">
                        <p>{{ __('privacy.last_updated') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
