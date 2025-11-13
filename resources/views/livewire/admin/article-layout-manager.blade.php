<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                    {{ __('articles.layout.title') }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    {{ __('articles.layout.description') }}
                </p>
            </div>
            <button wire:click="saveAllLayouts" 
                    class="px-6 py-3 bg-accent-600 hover:bg-accent-700 text-white rounded-lg shadow-lg transition-all duration-200">
                {{ __('articles.layout.save_all') }}
            </button>
        </div>

        {{-- Messaggi di successo/errore --}}
        @if (session()->has('success'))
            <div class="mb-6 p-4 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-6 p-4 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        {{-- Layout Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            
            {{-- Main Area (3 columns) --}}
            <div class="lg:col-span-3 space-y-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                    {{ __('articles.layout.main_area') }}
                </h2>

                {{-- Banner - Full Width --}}
                <div class="w-full">
                    @include('livewire.admin.partials.layout-position', [
                        'position' => 'banner',
                        'size' => 'large'
                    ])
                </div>

                {{-- Column 1 & 2 --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @include('livewire.admin.partials.layout-position', ['position' => 'column1', 'size' => 'medium'])
                    @include('livewire.admin.partials.layout-position', ['position' => 'column2', 'size' => 'medium'])
                </div>

                {{-- Horizontal 1 --}}
                <div class="w-full">
                    @include('livewire.admin.partials.layout-position', ['position' => 'horizontal1', 'size' => 'small'])
                </div>

                {{-- Horizontal 2 --}}
                <div class="w-full">
                    @include('livewire.admin.partials.layout-position', ['position' => 'horizontal2', 'size' => 'small'])
                </div>

                {{-- Column 3 & 4 --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @include('livewire.admin.partials.layout-position', ['position' => 'column3', 'size' => 'medium'])
                    @include('livewire.admin.partials.layout-position', ['position' => 'column4', 'size' => 'medium'])
                </div>

                {{-- Horizontal 3 --}}
                <div class="w-full">
                    @include('livewire.admin.partials.layout-position', ['position' => 'horizontal3', 'size' => 'small'])
                </div>

                {{-- Column 5 & 6 --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @include('livewire.admin.partials.layout-position', ['position' => 'column5', 'size' => 'medium'])
                    @include('livewire.admin.partials.layout-position', ['position' => 'column6', 'size' => 'medium'])
                </div>
            </div>

            {{-- Sidebar Area (1 column) --}}
            <div class="lg:col-span-1 space-y-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                    {{ __('articles.layout.sidebar_area') }}
                </h2>

                @for ($i = 1; $i <= 5; $i++)
                    @include('livewire.admin.partials.layout-position', [
                        'position' => 'sidebar' . $i,
                        'size' => 'small'
                    ])
                @endfor
            </div>
        </div>
    </div>

    {{-- Modal per la ricerca articoli --}}
    @if($showSearchModal)
        <div class="fixed inset-0 z-[9999] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="background-color: rgba(0,0,0,0.5);">
            <div class="flex items-center justify-center min-h-screen p-4">
                
                {{-- Modal Panel --}}
                <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-3xl" style="z-index: 10000;">
                    
                    {{-- Header --}}
                    <div class="bg-white dark:bg-gray-800 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ __('articles.layout.select_article') }}
                                </h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    Posizione: {{ $currentPosition }} | Risultati: {{ $searchResults ? $searchResults->count() : 0 }}
                                </p>
                            </div>
                            <button wire:click="closeSearchModal" 
                                    class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        {{-- Search Input --}}
                        <div class="mt-4">
                            <input type="text" 
                                   wire:model.live.debounce.300ms="searchTerm"
                                   placeholder="{{ __('articles.layout.search_articles') }}"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-accent-500 focus:border-accent-500">
                        </div>
                    </div>

                    {{-- Results --}}
                    <div class="bg-white dark:bg-gray-800 px-6 py-4 max-h-96 overflow-y-auto">
                        @if($searchResults && $searchResults->count() > 0)
                            <div class="space-y-3">
                                @foreach($searchResults as $article)
                                    <div wire:click="selectArticle({{ $article->id }})"
                                         class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors duration-200">
                                        <div class="flex gap-4">
                                            @if($article->featured_image_url)
                                                <img src="{{ $article->featured_image_url }}" 
                                                     alt="{{ $article->title }}"
                                                     class="w-20 h-20 object-cover rounded">
                                            @else
                                                <div class="w-20 h-20 bg-gray-200 dark:bg-gray-600 rounded flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-900 dark:text-white">
                                                    {{ $article->title }}
                                                </h4>
                                                @if($article->category)
                                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $article->category->name }}
                                                    </span>
                                                @endif
                                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1 line-clamp-2">
                                                    {{ $article->excerpt }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400 font-medium">
                                    {{ __('articles.index.no_articles') }}
                                </p>
                                <p class="text-sm text-gray-400 dark:text-gray-500 mt-2">
                                    Nessun articolo trovato nel database
                                </p>
                            </div>
                        @endif
                    </div>

                    {{-- Footer --}}
                    <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4">
                        <button wire:click="closeSearchModal"
                                class="w-full px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors duration-200">
                            {{ __('common.cancel') }}
                        </button>
                    </div>
                </div>{{-- Fine Modal Panel --}}
            </div>{{-- Fine Flex Container --}}
        </div>{{-- Fine Modal Wrapper --}}
    @endif
</div>
