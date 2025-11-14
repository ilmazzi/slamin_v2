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

    {{-- Filtri e Ricerca - Stile Poetico Elegante --}}
    <section class="relative py-8 bg-gradient-to-b from-white to-gray-50 dark:from-gray-900 dark:to-gray-900/95">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Ricerca Principale - Stile Poetico --}}
            <div class="relative max-w-2xl mx-auto">
                <input wire:model.live.debounce.500ms="search"
                       type="text"
                       placeholder="{{ __('articles.index.search_placeholder') }}"
                       class="w-full px-6 py-4 rounded-full 
                              border-2 border-gray-300/50 dark:border-gray-700/50 
                              bg-white/60 dark:bg-gray-800/60
                              backdrop-blur-sm
                              text-gray-900 dark:text-white placeholder:text-gray-500
                              focus:border-primary-400 focus:ring-4 focus:ring-primary-400/20 focus:bg-white dark:focus:bg-gray-800
                              transition-all duration-300 
                              text-center"
                       style="font-family: 'Playfair Display', serif; font-size: 1.125rem;">
                
                @if($search)
                    <button wire:click="$set('search', '')" 
                            class="absolute right-6 top-1/2 -translate-y-1/2
                                   text-gray-400 hover:text-primary-600
                                   hover:scale-110 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                @endif
            </div>
            
            {{-- Filtri Minimali - Nascosti per default --}}
            <details class="mt-6">
                <summary class="text-center text-sm text-gray-500 hover:text-primary-600 cursor-pointer transition-colors" style="font-family: 'Playfair Display', serif;">
                    {{ __('articles.filters.show_filters') ?? 'Mostra filtri avanzati' }}
                </summary>
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4 max-w-xl mx-auto">
                    {{-- Ordinamento --}}
                    <div class="relative">
                        <select wire:model.live="sortBy"
                                class="w-full px-4 py-3 rounded-xl
                                       border-2 border-gray-300/50 dark:border-gray-700/50
                                       bg-white/60 dark:bg-gray-800/60
                                       backdrop-blur-sm
                                       text-gray-700 dark:text-gray-300
                                       focus:border-primary-400 focus:ring-4 focus:ring-primary-400/20
                                       transition-all duration-300
                                       appearance-none cursor-pointer"
                                style="font-family: 'Playfair Display', serif;">
                            <option value="recent">{{ __('articles.filters.recent') }}</option>
                            <option value="popular">{{ __('articles.filters.popular') }}</option>
                            <option value="featured">{{ __('articles.filters.featured') }}</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Categoria --}}
                    <div class="relative">
                        <select wire:model.live="selectedCategory"
                                class="w-full px-4 py-3 rounded-xl
                                       border-2 border-gray-300/50 dark:border-gray-700/50
                                       bg-white/60 dark:bg-gray-800/60
                                       backdrop-blur-sm
                                       text-gray-700 dark:text-gray-300
                                       focus:border-primary-400 focus:ring-4 focus:ring-primary-400/20
                                       transition-all duration-300
                                       appearance-none cursor-pointer"
                                style="font-family: 'Playfair Display', serif;">
                            <option value="">{{ __('articles.filters.all') }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }} ({{ $category->articles_count }})
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </details>

            {{-- Reset Filtri --}}
            @if($search || $selectedCategory)
                <div class="mt-6 text-center">
                    <button wire:click="$set('search', ''); $set('selectedCategory', '')"
                            class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full
                                   bg-gradient-to-r from-primary-500 to-primary-600 
                                   hover:from-primary-600 hover:to-primary-700
                                   text-white text-sm font-medium
                                   shadow-lg shadow-primary-500/30
                                   hover:shadow-xl hover:shadow-primary-500/40
                                   transition-all duration-300"
                            style="font-family: 'Playfair Display', serif;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        {{ __('articles.filters.clear') ?? 'Cancella filtri' }}
                    </button>
                </div>
            @endif
        </div>
    </section>

    {{-- Contenuto Principale --}}
    <section class="bg-gray-50 dark:bg-gray-900 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Layout con Sidebar --}}
            <div class="flex flex-col lg:flex-row gap-8">
                {{-- Main Content Area --}}
                <div class="flex-1 lg:w-2/3">
            
            {{-- Layout Curato dal Manager (solo se non ci sono filtri) --}}
            @if(!$showAllArticles && !$search && !$selectedCategory && !empty($layoutArticles))
                
                {{-- Banner --}}
                @if(!empty($layoutArticles['banner']))
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
                                <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-4 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors cursor-pointer" 
                                    style="font-family: 'Playfair Display', serif;"
                                    onclick="Livewire.dispatch('openArticleModal', { articleId: {{ $bannerArticle->id }} })">
                                    {{ $bannerArticle->title }}
                                </h3>
                                <p class="text-gray-600 dark:text-gray-300 mb-6 line-clamp-3">
                                    {{ $bannerArticle->excerpt }}
                                </p>
                                <div class="flex flex-col gap-4 text-sm text-gray-500 dark:text-gray-400">
                                    <div class="flex items-center gap-4 flex-wrap">
                                        @if($bannerArticle->user)
                                            <div class="flex items-center gap-2">
                                                <img 
                                                    src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($bannerArticle->user, 80) }}" 
                                                    alt="{{ \App\Helpers\AvatarHelper::getDisplayName($bannerArticle->user) }}"
                                                    class="w-9 h-9 rounded-full object-cover ring-2 ring-white/70 dark:ring-gray-700 shadow-sm">
                                                <span class="font-medium text-gray-700 dark:text-gray-200">
                                                    {{ \App\Helpers\AvatarHelper::getDisplayName($bannerArticle->user) }}
                                                </span>
                                            </div>
                                            <span class="text-gray-400">•</span>
                                        @endif
                                        <span>{{ $bannerArticle->published_at->format('d M Y') }}</span>
                                        <span>{{ __('articles.index.reading_time', ['minutes' => $bannerArticle->read_time]) }}</span>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-4 justify-between">
                                        <div class="flex items-center gap-3" @click.stop>
                                            <x-like-button 
                                                :itemId="$bannerArticle->id"
                                                itemType="article"
                                                :isLiked="$bannerArticle->is_liked ?? false"
                                                :likesCount="$bannerArticle->like_count ?? 0"
                                                size="md"
                                                class="[&_button]:!text-primary-600 dark:[&_button]:!text-primary-300 [&_button]:!gap-1.5 [&_svg]:!stroke-current [&_span]:!text-sm" />
                                            
                                            <x-comment-button 
                                                :itemId="$bannerArticle->id"
                                                itemType="article"
                                                :commentsCount="$bannerArticle->comment_count ?? 0"
                                                size="md"
                                                class="[&_button]:!text-primary-600 dark:[&_button]:!text-primary-300 [&_button]:!gap-1.5 [&_svg]:!stroke-current [&_span]:!text-sm" />
                                            
                                            <x-share-button 
                                                :itemId="$bannerArticle->id"
                                                itemType="article"
                                                :url="route('articles.show', $bannerArticle->slug)"
                                                :title="$bannerArticle->title"
                                                size="md"
                                                class="[&_button]:!text-primary-600 dark:[&_button]:!text-primary-300 [&_button]:!gap-1.5 [&_svg]:!stroke-current [&_span]:!text-sm" />
                                        </div>
                                        <button onclick="Livewire.dispatch('openArticleModal', { articleId: {{ $bannerArticle->id }} })" 
                                                class="text-primary-600 dark:text-primary-400 font-semibold hover:underline whitespace-nowrap cursor-pointer">
                                            {{ __('articles.index.read_more') }} →
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                @endif

                {{-- Columns 1 & 2 --}}
                @if(!empty($layoutArticles['column1']) || !empty($layoutArticles['column2']))
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
                        @if(!empty($layoutArticles['column1']))
                            <livewire:articles.article-card :article="$layoutArticles['column1']" size="medium" :key="'column1-'.$layoutArticles['column1']->id" />
                        @endif
                        @if(!empty($layoutArticles['column2']))
                            <livewire:articles.article-card :article="$layoutArticles['column2']" size="medium" :key="'column2-'.$layoutArticles['column2']->id" />
                        @endif
                    </div>
                @endif

                {{-- Horizontal 1 --}}
                @if(!empty($layoutArticles['horizontal1']))
                    <div class="mb-12">
                        <livewire:articles.article-card :article="$layoutArticles['horizontal1']" size="large" :key="'horizontal1-'.$layoutArticles['horizontal1']->id" />
                    </div>
                @endif

                {{-- Columns 3 & 4 --}}
                @if(!empty($layoutArticles['column3']) || !empty($layoutArticles['column4']))
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
                        @if(!empty($layoutArticles['column3']))
                            <livewire:articles.article-card :article="$layoutArticles['column3']" size="medium" :key="'column3-'.$layoutArticles['column3']->id" />
                        @endif
                        @if(!empty($layoutArticles['column4']))
                            <livewire:articles.article-card :article="$layoutArticles['column4']" size="medium" :key="'column4-'.$layoutArticles['column4']->id" />
                        @endif
                    </div>
                @endif

                {{-- Horizontal 2 --}}
                @if(!empty($layoutArticles['horizontal2']))
                    <div class="mb-12">
                        <livewire:articles.article-card :article="$layoutArticles['horizontal2']" size="large" :key="'horizontal2-'.$layoutArticles['horizontal2']->id" />
                    </div>
                @endif

                {{-- Horizontal 3 --}}
                @if(!empty($layoutArticles['horizontal3']))
                    <div class="mb-12">
                        <livewire:articles.article-card :article="$layoutArticles['horizontal3']" size="large" :key="'horizontal3-'.$layoutArticles['horizontal3']->id" />
                    </div>
                @endif

                {{-- Columns 5 & 6 --}}
                @if(!empty($layoutArticles['column5']) || !empty($layoutArticles['column6']))
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
                        @if(!empty($layoutArticles['column5']))
                            <livewire:articles.article-card :article="$layoutArticles['column5']" size="medium" :key="'column5-'.$layoutArticles['column5']->id" />
                        @endif
                        @if(!empty($layoutArticles['column6']))
                            <livewire:articles.article-card :article="$layoutArticles['column6']" size="medium" :key="'column6-'.$layoutArticles['column6']->id" />
                        @endif
                    </div>
                @endif

                {{-- Toggle per mostrare tutti gli articoli --}}
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
                
                </div>{{-- Fine Main Content Area --}}
                
                {{-- Sidebar --}}
                @php
                    $hasSidebar = !empty($layoutArticles['sidebar1']) || !empty($layoutArticles['sidebar2']) || 
                                  !empty($layoutArticles['sidebar3']) || !empty($layoutArticles['sidebar4']) || 
                                  !empty($layoutArticles['sidebar5']);
                @endphp
                @if($hasSidebar && !$search && !$selectedCategory && !$showAllArticles)
                    <aside class="lg:w-1/3">
                        <div class="sticky top-24 space-y-6">
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                    </svg>
                                    {{ __('articles.index.sidebar_articles') }}
                                </h3>
                                <div class="space-y-4">
                                    @foreach(['sidebar1', 'sidebar2', 'sidebar3', 'sidebar4', 'sidebar5'] as $sidebarPos)
                                        @if(!empty($layoutArticles[$sidebarPos]))
                                            @php $sidebarArticle = $layoutArticles[$sidebarPos]; @endphp
                                            <article class="group pb-4 border-b border-gray-200 dark:border-gray-700 last:border-0 last:pb-0">
                                                @if($sidebarArticle->featured_image_url)
                                                    <div class="relative overflow-hidden rounded-lg mb-3 h-32">
                                                        <img 
                                                            src="{{ $sidebarArticle->featured_image_url }}" 
                                                            alt="{{ $sidebarArticle->title }}"
                                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                                        >
                                                    </div>
                                                @endif
                                                <h4 class="font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors line-clamp-2 cursor-pointer"
                                                    onclick="Livewire.dispatch('openArticleModal', { articleId: {{ $sidebarArticle->id }} })">
                                                    {{ $sidebarArticle->title }}
                                                </h4>
                                                @if($sidebarArticle->category)
                                                    <span class="inline-block px-2 py-1 text-xs rounded bg-accent-100 dark:bg-accent-900 text-accent-800 dark:text-accent-200 mb-2">
                                                        {{ $sidebarArticle->category->name }}
                                                    </span>
                                                @endif
                                                <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2 mb-2">
                                                    {{ $sidebarArticle->excerpt }}
                                                </p>
                                                <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                                                    <span>{{ $sidebarArticle->published_at->format('d M Y') }}</span>
                                                    <span>{{ $sidebarArticle->read_time }} min</span>
                                                </div>
                                            </article>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </aside>
                @endif
            </div>{{-- Fine Layout con Sidebar --}}
            
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
    
    {{-- Article Modal --}}
    <livewire:articles.article-modal />
</div>
