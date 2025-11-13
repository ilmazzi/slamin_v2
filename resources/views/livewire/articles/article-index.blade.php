<div>
    {{-- Hero Section - Stile Editoriale --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-primary-900 to-primary-800 text-white">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-10 w-72 h-72 bg-accent-500 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-secondary-500 rounded-full blur-3xl animate-pulse delay-700"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28">
            <div class="text-center space-y-6">
                {{-- Sovratitolo editorial --}}
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full border border-white/20">
                    <svg class="w-5 h-5 text-accent-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    <span class="text-sm font-medium text-white">{{ __('articles.hero.tagline') }}</span>
                </div>

                <h1 class="text-5xl md:text-7xl font-bold tracking-tight opacity-0 animate-fade-in" style="font-family: 'Playfair Display', serif;">
                    {{ __('articles.hero.title') }}
                </h1>
                
                <p class="text-xl md:text-2xl text-primary-100 max-w-3xl mx-auto opacity-0 animate-fade-in-delay-1">
                    {{ __('articles.hero.subtitle') }}
                </p>
            </div>
        </div>

        {{-- Decorazione bottom --}}
        <div class="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-gray-50 dark:from-gray-900 to-transparent"></div>
    </section>

    {{-- Filtri e Ricerca --}}
    <section class="bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 sticky top-16 z-20 backdrop-blur-sm bg-gray-50/95 dark:bg-gray-900/95">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                {{-- Ricerca --}}
                <div class="w-full md:w-96">
                    <div class="relative">
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="search"
                            placeholder="{{ __('articles.index.search_placeholder') ?? 'Cerca articoli...' }}"
                            class="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                        >
                        <svg class="absolute left-3 top-3 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>

                {{-- Filtri --}}
                <div class="flex flex-wrap gap-2 items-center">
                    {{-- Ordinamento --}}
                    <select 
                        wire:model.live="sortBy"
                        class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-primary-500"
                    >
                        <option value="recent">{{ __('articles.filters.recent') ?? 'Più recenti' }}</option>
                        <option value="popular">{{ __('articles.filters.popular') ?? 'Più popolari' }}</option>
                        <option value="featured">{{ __('articles.filters.featured') ?? 'In evidenza' }}</option>
                    </select>

                    {{-- Categoria --}}
                    <select 
                        wire:model.live="selectedCategory"
                        class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-primary-500"
                    >
                        <option value="">{{ __('articles.filters.all') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }} ({{ $category->articles_count }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </section>

    {{-- Contenuto Principale --}}
    <section class="bg-gray-50 dark:bg-gray-900 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Articolo in Evidenza --}}
            @if($featuredArticle && !$search && !$selectedCategory)
                <div class="mb-12">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="h-px flex-1 bg-gradient-to-r from-transparent via-accent-500 to-transparent"></div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ __('articles.index.featured') }}
                        </h2>
                        <div class="h-px flex-1 bg-gradient-to-r from-transparent via-accent-500 to-transparent"></div>
                    </div>

                    <article class="group relative bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300">
                        <div class="md:flex">
                            <div class="md:w-1/2 relative overflow-hidden">
                                @if($featuredArticle->featured_image_url)
                                    <img 
                                        src="{{ $featuredArticle->featured_image_url }}" 
                                        alt="{{ $featuredArticle->title }}"
                                        class="w-full h-64 md:h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                    >
                                @else
                                    <div class="w-full h-64 md:h-full bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center">
                                        <svg class="w-24 h-24 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute top-4 left-4">
                                    <span class="px-3 py-1 bg-accent-500 text-white text-xs font-bold rounded-full uppercase tracking-wider">
                                        {{ __('articles.index.featured') }}
                                    </span>
                                </div>
                            </div>
                            <div class="md:w-1/2 p-8 flex flex-col justify-center">
                                @if($featuredArticle->category)
                                    <span class="inline-block text-xs font-semibold text-primary-600 dark:text-primary-400 uppercase tracking-wider mb-3">
                                        {{ $featuredArticle->category->name }}
                                    </span>
                                @endif
                                <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-4 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors" style="font-family: 'Playfair Display', serif;">
                                    <a href="{{ route('articles.show', $featuredArticle->slug) }}" wire:navigate>
                                        {{ $featuredArticle->title }}
                                    </a>
                                </h3>
                                <p class="text-gray-600 dark:text-gray-300 mb-6 line-clamp-3">
                                    {{ $featuredArticle->excerpt }}
                                </p>
                                <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                                    <div class="flex items-center gap-4">
                                        <span>{{ $featuredArticle->published_at->format('d M Y') }}</span>
                                        <span>{{ $featuredArticle->read_time }} {{ __('articles.index.reading_time', ['minutes' => $featuredArticle->read_time]) }}</span>
                                    </div>
                                    <a href="{{ route('articles.show', $featuredArticle->slug) }}" wire:navigate class="text-primary-600 dark:text-primary-400 font-semibold hover:underline">
                                        {{ __('articles.index.read_more') }} →
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            @endif

            {{-- Griglia Articoli --}}
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                    {{ __('articles.index.all_articles') }}
                </h2>
            </div>

            @if($articles->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                    @foreach($articles as $article)
                        <article class="group bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col">
                            {{-- Immagine --}}
                            <div class="relative overflow-hidden h-48">
                                @if($article->featured_image_url)
                                    <img 
                                        src="{{ $article->featured_image_url }}" 
                                        alt="{{ $article->title }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                    >
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-primary-400 to-accent-400 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                        </svg>
                                    </div>
                                @endif
                                @if($article->category)
                                    <div class="absolute top-3 left-3">
                                        <span class="px-2.5 py-1 bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm text-xs font-semibold text-gray-700 dark:text-gray-300 rounded-full">
                                            {{ $article->category->name }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            {{-- Contenuto --}}
                            <div class="p-6 flex-1 flex flex-col">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors line-clamp-2">
                                    <a href="{{ route('articles.show', $article->slug) }}" wire:navigate>
                                        {{ $article->title }}
                                    </a>
                                </h3>
                                <p class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-3 flex-1">
                                    {{ $article->excerpt }}
                                </p>
                                <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <span>{{ $article->published_at->format('d M Y') }}</span>
                                    <span>{{ $article->read_time }} min</span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Paginazione --}}
                <div class="flex justify-center">
                    {{ $articles->links() }}
                </div>
            @else
                {{-- Stato vuoto --}}
                <div class="text-center py-16">
                    <svg class="w-24 h-24 text-gray-300 dark:text-gray-600 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                        {{ __('articles.index.no_articles') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ __('articles.index.no_articles_subtitle') }}
                    </p>
                </div>
            @endif
        </div>
    </section>
</div>
