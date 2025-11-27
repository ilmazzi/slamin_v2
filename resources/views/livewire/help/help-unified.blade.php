<div class="min-h-screen bg-neutral-50 dark:bg-neutral-950 py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-black text-neutral-900 dark:text-white mb-4" style="font-family: 'Crimson Pro', serif;">
                {{ __('help.unified.title') }}
            </h1>
            <p class="text-lg text-neutral-600 dark:text-neutral-400">
                {{ __('help.unified.description') }}
            </p>
        </div>

        {{-- Filters --}}
        <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Type Filter --}}
                <div>
                    <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                        {{ __('help.unified.type_label') }}
                    </label>
                    <select wire:model.live="selectedType" 
                            class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium">
                        <option value="all">{{ __('help.unified.type_all') }}</option>
                        <option value="faq">{{ __('help.unified.type_faq') }}</option>
                        <option value="help">{{ __('help.unified.type_help') }}</option>
                    </select>
                </div>

                {{-- Category Filter --}}
                @if($categories->count() > 0)
                <div>
                    <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                        {{ __('help.unified.category_label') }}
                    </label>
                    <select wire:model.live="selectedCategory" 
                            class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium">
                        <option value="all">{{ __('help.unified.category_all') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}">{{ ucfirst($category) }}</option>
                        @endforeach
                    </select>
                </div>
                @endif

                {{-- Search --}}
                <div>
                    <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                        🔍 {{ __('help.unified.search_label') }}
                    </label>
                    <input type="text" 
                           wire:model.live.debounce.300ms="search"
                           placeholder="{{ __('help.unified.search_placeholder') }}"
                           class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium">
                </div>
            </div>
        </div>

        {{-- FAQ Section --}}
        @if($selectedType === 'all' || $selectedType === 'faq')
            @if($faqs->count() > 0)
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-6 flex items-center gap-3">
                        <span class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 dark:text-blue-400 font-bold">?</span>
                        </span>
                        {{ __('help.unified.faq_title') }}
                    </h2>
                    <div class="space-y-4">
                        @foreach($faqs as $faq)
                            <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg p-6">
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0 w-10 h-10 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center">
                                        <span class="text-primary-600 dark:text-primary-400 font-bold text-lg">?</span>
                                    </div>
                                    <div class="flex-1">
                                        @if($faq->category)
                                            <span class="inline-block px-3 py-1 rounded-full text-xs font-medium bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 mb-2">
                                                {{ $faq->category }}
                                            </span>
                                        @endif
                                        <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3">
                                            {{ $faq->translated_title }}
                                        </h3>
                                        <div class="text-neutral-600 dark:text-neutral-400 prose dark:prose-invert max-w-none">
                                            {!! nl2br(e($faq->translated_content)) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif

        {{-- Help Section --}}
        @if($selectedType === 'all' || $selectedType === 'help')
            @if($helpItems->count() > 0)
                <div>
                    <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-6 flex items-center gap-3">
                        <span class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                            <span class="text-green-600 dark:text-green-400 font-bold">ℹ️</span>
                        </span>
                        {{ __('help.unified.help_title') }}
                    </h2>
                    <div class="space-y-4">
                        @foreach($helpItems as $help)
                            <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg p-6">
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0 w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                                        <span class="text-green-600 dark:text-green-400 font-bold text-lg">ℹ️</span>
                                    </div>
                                    <div class="flex-1">
                                        @if($help->category)
                                            <span class="inline-block px-3 py-1 rounded-full text-xs font-medium bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 mb-2">
                                                {{ $help->category }}
                                            </span>
                                        @endif
                                        <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3">
                                            {{ $help->translated_title }}
                                        </h3>
                                        <div class="text-neutral-600 dark:text-neutral-400 prose dark:prose-invert max-w-none">
                                            {!! nl2br(e($help->translated_content)) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif

        {{-- Empty State --}}
        @if($helps->count() === 0)
            <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg p-12 text-center">
                <div class="text-6xl mb-4">📚</div>
                <h3 class="text-2xl font-bold text-neutral-900 dark:text-white mb-2">{{ __('help.unified.no_content_title') }}</h3>
                <p class="text-neutral-600 dark:text-neutral-400">
                    @if(!empty($search))
                        {{ __('help.unified.no_content_search') }}
                    @else
                        {{ __('help.unified.no_content_empty') }}
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>

