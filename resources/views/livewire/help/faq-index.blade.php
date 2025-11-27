<div class="min-h-screen bg-neutral-50 dark:bg-neutral-950 py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-black text-neutral-900 dark:text-white mb-4" style="font-family: 'Crimson Pro', serif;">
                {{ __('help.faq.title') }}
            </h1>
            <p class="text-lg text-neutral-600 dark:text-neutral-400">
                {{ __('help.faq.description') }}
            </p>
        </div>

        {{-- Filters --}}
        <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Search --}}
                <div>
                    <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                        🔍 Cerca
                    </label>
                    <input type="text" 
                           wire:model.live.debounce.300ms="search"
                           placeholder="Cerca nelle FAQ..."
                           class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium">
                </div>

                {{-- Category Filter --}}
                @if($categories->count() > 0)
                <div>
                    <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                        Categoria
                    </label>
                    <select wire:model.live="selectedCategory" 
                            class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium">
                        <option value="all">Tutte le categorie</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}">{{ ucfirst($category) }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
            </div>
        </div>

        {{-- FAQ List (Accordion) --}}
        <div class="space-y-3">
            @forelse($faqs as $faq)
                <div x-data="{ open: false }" class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg overflow-hidden">
                    {{-- Accordion Header --}}
                    <button @click="open = !open" 
                            class="w-full px-6 py-4 flex items-center gap-4 hover:bg-neutral-50 dark:hover:bg-neutral-700/50 transition-colors text-left">
                        <div class="flex-shrink-0 w-10 h-10 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center">
                            <span class="text-primary-600 dark:text-primary-400 font-bold text-lg">?</span>
                        </div>
                        <div class="flex-1">
                            @if($faq->category)
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-medium bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 mb-1">
                                    {{ $faq->category }}
                                </span>
                            @endif
                            <h3 class="text-lg font-bold text-neutral-900 dark:text-white">
                                {{ $faq->translated_title }}
                            </h3>
                        </div>
                        <svg class="w-6 h-6 text-neutral-400 transition-transform duration-200"
                             :class="{ 'rotate-180': open }"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    
                    {{-- Accordion Content --}}
                    <div x-show="open" 
                         x-collapse
                         class="px-6 pb-6 pt-2">
                        <div class="pl-14 text-neutral-600 dark:text-neutral-400 prose dark:prose-invert max-w-none">
                            {!! nl2br(e($faq->translated_content)) !!}
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg p-12 text-center">
                    <div class="text-6xl mb-4">❓</div>
                    <h3 class="text-2xl font-bold text-neutral-900 dark:text-white mb-2">Nessuna FAQ trovata</h3>
                    <p class="text-neutral-600 dark:text-neutral-400">
                        @if(!empty($search))
                            Prova a modificare i criteri di ricerca
                        @else
                            Non ci sono FAQ disponibili al momento
                        @endif
                    </p>
                </div>
            @endforelse
        </div>
    </div>
</div>

