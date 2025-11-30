<x-layouts.app>
    <x-slot name="title">{{ __('terms.title') }}</x-slot>

    <div class="min-h-screen bg-white dark:bg-neutral-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <h1 class="text-4xl md:text-5xl font-bold text-neutral-900 dark:text-white mb-4" style="font-family: 'Crimson Pro', serif;">
                {{ __('terms.title') }}
            </h1>
            
            <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-8">
                {{ __('terms.version') }}
            </p>
            
            <div class="prose prose-lg dark:prose-invert max-w-none">
                <div class="text-neutral-700 dark:text-neutral-300 space-y-6">
                    <p class="text-lg font-medium">
                        {{ __('terms.intro') }}
                    </p>

                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4">{{ __('terms.about_document_title') }}</h2>
                        <p>{{ __('terms.about_document_p1') }}</p>
                        <p>{{ __('terms.about_document_p2') }}</p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4">{{ __('terms.acceptance_title') }}</h2>
                        <p>{{ __('terms.acceptance_text') }}</p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mt-8 mb-4">{{ __('terms.community_notice_title') }}</h2>
                        <p>{{ __('terms.community_notice_text') }}</p>
                    </section>

                    <section>
                        <h2 class="text-3xl font-bold text-neutral-900 dark:text-white mt-12 mb-6">{{ __('terms.terms_title') }}</h2>

                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3">{{ __('terms.1_title') }}</h3>
                            <p>{{ __('terms.1_text') }}</p>
                        </article>

                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3">{{ __('terms.2_title') }}</h3>
                            <p>{{ __('terms.2_p1') }}</p>
                            <p class="font-semibold">{{ __('terms.2_p2') }}</p>
                        </article>

                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3">{{ __('terms.3_title') }}</h3>
                            <p>{{ __('terms.3_p1') }}</p>
                            <p>{{ __('terms.3_p2') }}</p>
                        </article>

                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3">{{ __('terms.4_title') }}</h3>
                            <p>{{ __('terms.4_p1') }}</p>
                            <p>{{ __('terms.4_p2') }}</p>
                            <p class="font-semibold text-red-600 dark:text-red-400">{{ __('terms.4_warning') }}</p>
                        </article>

                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3">{{ __('terms.5_title') }}</h3>
                            <p>{{ __('terms.5_p1') }}</p>
                            <p>{{ __('terms.5_p2') }}</p>
                        </article>

                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3">{{ __('terms.6_title') }}</h3>
                            <p>{{ __('terms.6_p1') }}</p>
                            <p>{{ __('terms.6_p2') }}</p>
                        </article>

                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3">{{ __('terms.7_title') }}</h3>
                            <p>{{ __('terms.7_intro') }}</p>
                            <ul class="list-disc pl-6 space-y-2 mt-3">
                                <li>{{ __('terms.7_item1') }}</li>
                                <li>{{ __('terms.7_item2') }}</li>
                                <li>{{ __('terms.7_item3') }}</li>
                                <li>{{ __('terms.7_item4') }}</li>
                                <li>{{ __('terms.7_item5') }}</li>
                                <li>{{ __('terms.7_item6') }}</li>
                                <li>{{ __('terms.7_item7') }}</li>
                            </ul>
                        </article>

                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3">{{ __('terms.8_title') }}</h3>
                            <p>{{ __('terms.8_p1') }}</p>
                            <p>{{ __('terms.8_p2') }}</p>
                            <p>{{ __('terms.8_p3') }}</p>
                            <p>{{ __('terms.8_p4') }}</p>
                            <p>{{ __('terms.8_p5') }}</p>
                            <p>{{ __('terms.8_p6') }}</p>
                        </article>

                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3">{{ __('terms.9_title') }}</h3>
                            <p>{{ __('terms.9_text') }}</p>
                        </article>

                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3">{{ __('terms.10_title') }}</h3>
                            <p>{{ __('terms.10_p1') }}</p>
                            <p>{{ __('terms.10_p2') }} <a href="{{ route('privacy') }}" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 font-semibold">{{ __('terms.10_privacy_link') }}</a>.</p>
                        </article>

                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3">{{ __('terms.11_title') }}</h3>
                            <p>{{ __('terms.11_text') }}</p>
                        </article>

                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3">{{ __('terms.12_title') }}</h3>
                            <p>{{ __('terms.12_intro') }}</p>
                            <ul class="list-disc pl-6 space-y-2 mt-3">
                                <li>{{ __('terms.12_item1') }}</li>
                                <li>{{ __('terms.12_item2') }}</li>
                            </ul>
                            <p class="mt-3">{{ __('terms.12_outro') }}</p>
                        </article>

                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3">{{ __('terms.13_title') }}</h3>
                            <p>{{ __('terms.13_p1') }}</p>
                            <p>{{ __('terms.13_p2') }}</p>
                        </article>
                    </section>

                    <section class="mt-12">
                        <h2 class="text-3xl font-bold text-neutral-900 dark:text-white mb-6">{{ __('terms.guidelines_title') }}</h2>
                        <p>{{ __('terms.guidelines_intro_p1') }}</p>
                        <p>{{ __('terms.guidelines_intro_p2') }}</p>
                        <p>{{ __('terms.guidelines_intro_p3') }}</p>
                        <p>{{ __('terms.guidelines_intro_p4') }}</p>

                        <article class="mb-8 mt-6">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3">{{ __('terms.guideline_1_title') }}</h3>
                            <p>{{ __('terms.guideline_1_p1') }}</p>
                            <p>{{ __('terms.guideline_1_p2') }}</p>
                            <p>{{ __('terms.guideline_1_p3') }}</p>
                        </article>

                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3">{{ __('terms.guideline_2_title') }}</h3>
                            <p>{{ __('terms.guideline_2_text') }}</p>
                        </article>

                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3">{{ __('terms.guideline_3_title') }}</h3>
                            <p>{{ __('terms.guideline_3_p1') }}</p>
                            <p>{{ __('terms.guideline_3_p2') }}</p>
                        </article>

                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3">{{ __('terms.guideline_4_title') }}</h3>
                            <p>{{ __('terms.guideline_4_p1') }}</p>
                            <p>{{ __('terms.guideline_4_p2') }}</p>
                            <p>{{ __('terms.guideline_4_p3') }}</p>
                            <p>{{ __('terms.guideline_4_p4') }}</p>
                            <p>{{ __('terms.guideline_4_p5') }}</p>
                            <p>{{ __('terms.guideline_4_p6') }}</p>
                        </article>
                    </section>

                    <section class="mt-12 pt-8 border-t border-neutral-200 dark:border-neutral-700">
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-4">{{ __('terms.changes_title') }}</h2>
                        <p>{{ __('terms.changes_text') }}</p>
                    </section>

                    <div class="mt-12 pt-8 border-t border-neutral-200 dark:border-neutral-700 text-sm text-neutral-600 dark:text-neutral-400">
                        <p>{{ __('terms.last_updated') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
