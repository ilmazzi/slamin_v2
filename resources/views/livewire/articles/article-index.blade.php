<div class="min-h-screen">
    
    {{-- HERO con Magazine + Titolo (come media e poems) --}}
    <section class="relative py-12 md:py-20 overflow-hidden bg-neutral-900 dark:bg-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center gap-6 md:flex-row md:justify-center md:gap-12">
                
                <!-- MAGAZINE COVER (dalla home) - Dimensione maggiorata -->
                <div class="hero-magazine-wrapper-large">
                    <div class="hero-magazine-cover-large">
                        <div class="hero-magazine-inner-large">
                            <div class="flex justify-between items-start mb-2">
                                <div class="text-sm font-bold text-neutral-900">SLAMIN</div>
                                <div class="text-xs text-neutral-600">{{ now()->format('M Y') }}</div>
                            </div>
                            <div class="h-px bg-gradient-to-r from-neutral-900 via-neutral-400 to-neutral-900 mb-3"></div>
                            <h3 class="hero-magazine-title-large">
                                {{ __('home.hero_category_articles') }}
                            </h3>
                            <div class="mt-auto pt-3">
                                <div class="text-xs text-neutral-700 leading-tight">
                                    {{ __('articles.hero.tagline') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- TITOLO A FIANCO -->
                <div class="text-center md:text-left">
                    <h1 class="text-5xl md:text-7xl lg:text-8xl font-black text-white leading-tight" style="font-family: 'Playfair Display', serif;">
                        {{ __('articles.hero.title') }}
                    </h1>
                    <p class="text-xl md:text-2xl text-white/80 mt-4 font-medium">
                        {{ __('articles.hero.subtitle') }}
                    </p>
                </div>
            </div>
        </div>
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
            
            {{-- Articolo Banner (dal Layout System) --}}
            @if(!empty($layoutArticles['banner']) && !$search && !$selectedCategory)
                @php $bannerArticle = $layoutArticles['banner']; @endphp
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
                                @if($bannerArticle->featured_image_url)
                                    <img 
                                        src="{{ $bannerArticle->featured_image_url }}" 
                                        alt="{{ $bannerArticle->title }}"
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
                                @if($bannerArticle->category)
                                    <span class="inline-block text-xs font-semibold text-primary-600 dark:text-primary-400 uppercase tracking-wider mb-3">
                                        {{ $bannerArticle->category->name }}
                                    </span>
                                @endif
                                <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-4 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors" style="font-family: 'Playfair Display', serif;">
                                    <a href="{{ route('articles.show', $bannerArticle->slug) }}" wire:navigate>
                                        {{ $bannerArticle->title }}
                                    </a>
                                </h3>
                                <p class="text-gray-600 dark:text-gray-300 mb-6 line-clamp-3">
                                    {{ $bannerArticle->excerpt }}
                                </p>
                                <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                                    <div class="flex items-center gap-4">
                                        <span>{{ $bannerArticle->published_at->format('d M Y') }}</span>
                                        <span>{{ $bannerArticle->read_time }} {{ __('articles.index.reading_time', ['minutes' => $bannerArticle->read_time]) }}</span>
                                    </div>
                                    <a href="{{ route('articles.show', $bannerArticle->slug) }}" wire:navigate class="text-primary-600 dark:text-primary-400 font-semibold hover:underline">
                                        {{ __('articles.index.read_more') }} →
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            @endif

            {{-- Featured Articles (dal Layout System) --}}
            @if(!empty($layoutArticles['featured']) && !$search && !$selectedCategory)
                <div class="mb-12">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="h-px flex-1 bg-gradient-to-r from-transparent via-primary-500 to-transparent"></div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ __('articles.index.featured_articles') }}
                        </h2>
                        <div class="h-px flex-1 bg-gradient-to-r from-transparent via-primary-500 to-transparent"></div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($layoutArticles['featured'] as $article)
                            <livewire:articles.article-card :article="$article" size="medium" :key="'featured-'.$article->id" />
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Latest Articles (dal Layout System) --}}
            @if(!empty($layoutArticles['latest']) && !$search && !$selectedCategory)
                <div class="mb-12">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="h-px flex-1 bg-gradient-to-r from-transparent via-gray-300 dark:via-gray-700 to-transparent"></div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ __('articles.index.latest_articles') }}
                        </h2>
                        <div class="h-px flex-1 bg-gradient-to-r from-transparent via-gray-300 dark:via-gray-700 to-transparent"></div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($layoutArticles['latest'] as $article)
                            <livewire:articles.article-card :article="$article" size="small" :key="'latest-'.$article->id" />
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Toggle per mostrare tutti gli articoli --}}
            @if(!$showAllArticles && (!empty($layoutArticles['banner']) || !empty($layoutArticles['featured']) || !empty($layoutArticles['latest'])))
                <div class="text-center mb-12">
                    <button wire:click="toggleShowAll" class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg shadow-lg transition-all duration-200">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                        {{ __('articles.index.show_all_articles') }}
                    </button>
                </div>
            @endif

            {{-- Griglia Articoli (Tutti o con Filtri) --}}
            @if($showAllArticles || $search || $selectedCategory)
                <div class="mb-8 flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ __('articles.index.all_articles') }}
                    </h2>
                    @if($showAllArticles && !$search && !$selectedCategory)
                        <button wire:click="toggleShowAll" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-200">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-3zM14 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1h-4a1 1 0 01-1-1v-3z"/>
                            </svg>
                            {{ __('articles.index.editor_layout') }}
                        </button>
                    @endif
                </div>

                @if($articles->count())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                        @foreach($articles as $article)
                            <livewire:articles.article-card :article="$article" size="medium" :key="'article-'.$article->id" />
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
            @endif
        </div>
    </section>

    <style>
        /* ========================================
           MAGAZINE COVER - Hero Large Version
           ======================================== */
        
        .hero-magazine-wrapper-large {
            display: block;
            width: 200px;
            transition: all 0.3s ease;
        }
        
        .hero-magazine-wrapper-large:hover {
            transform: translateY(-6px) scale(1.05);
        }
        
        .hero-magazine-cover-large {
            background: linear-gradient(135deg, #f5f5f0 0%, #e8e6e1 100%);
            padding: 1.5rem 1.25rem;
            height: 260px;
            border-radius: 4px;
            box-shadow: 
                inset 0 0 0 2px rgba(100, 100, 100, 0.2),
                inset 0 0 8px rgba(0, 0, 0, 0.1),
                0 8px 12px rgba(0, 0, 0, 0.2),
                0 15px 25px rgba(0, 0, 0, 0.15),
                0 25px 40px rgba(0, 0, 0, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .hero-magazine-wrapper-large:hover .hero-magazine-cover-large {
            box-shadow: 
                inset 0 0 0 2px rgba(100, 100, 100, 0.3),
                inset 0 0 12px rgba(0, 0, 0, 0.15),
                0 12px 18px rgba(0, 0, 0, 0.3),
                0 25px 40px rgba(0, 0, 0, 0.25),
                0 40px 60px rgba(0, 0, 0, 0.2);
        }
        
        .hero-magazine-inner-large {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        
        .hero-magazine-title-large {
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: #1a1a1a;
            line-height: 1.2;
            text-align: center;
            transition: color 0.3s ease;
        }
        
        .hero-magazine-wrapper-large:hover .hero-magazine-title-large {
            color: #2563eb;
        }
        
        @media (max-width: 768px) {
            .hero-magazine-wrapper-large {
                width: 180px;
            }
            
            .hero-magazine-cover-large {
                padding: 1.25rem 1rem;
                height: 240px;
            }
            
            .hero-magazine-title-large {
                font-size: 1.5rem;
            }
        }
    </style>
</div>
