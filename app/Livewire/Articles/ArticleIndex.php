<?php

namespace App\Livewire\Articles;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleLayout;

class ArticleIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCategory = '';
    public $sortBy = 'recent'; // recent, popular, featured
    public $showAllArticles = false; // Toggle for editor-controlled layout vs all articles
    public $layoutArticles = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCategory' => ['except' => ''],
        'sortBy' => ['except' => 'recent'],
    ];

    public function mount()
    {
        $this->loadLayoutArticles();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategory()
    {
        $this->resetPage();
    }

    public function updatingSortBy()
    {
        $this->resetPage();
    }

    public function toggleShowAll()
    {
        $this->showAllArticles = !$this->showAllArticles;
        $this->resetPage();
    }

    private function loadLayoutArticles()
    {
        $this->layoutArticles = [];

        // Banner - single article
        $bannerLayout = ArticleLayout::where('position', 'banner')
            ->where('is_active', true)
            ->with(['article.user', 'article.category'])
            ->first();
        
        if ($bannerLayout && $bannerLayout->article) {
            $this->layoutArticles['banner'] = $bannerLayout->article;
        }

        // Featured - columns 1-2 and horizontal 1-2
        $featuredPositions = ['column1', 'column2', 'horizontal1', 'horizontal2'];
        $featuredLayouts = ArticleLayout::whereIn('position', $featuredPositions)
            ->where('is_active', true)
            ->with(['article.user', 'article.category'])
            ->orderBy('order', 'asc')
            ->get();
        
        if ($featuredLayouts->isNotEmpty()) {
            $this->layoutArticles['featured'] = $featuredLayouts
                ->filter(function($layout) {
                    return $layout->article !== null;
                })
                ->map(function($layout) {
                    return $layout->article;
                })
                ->values(); // Mantiene come Collection
        }

        // Latest - columns 3-6 and horizontal 3
        $latestPositions = ['column3', 'column4', 'horizontal3', 'column5', 'column6'];
        $latestLayouts = ArticleLayout::whereIn('position', $latestPositions)
            ->where('is_active', true)
            ->with(['article.user', 'article.category'])
            ->orderBy('order', 'asc')
            ->get();
        
        if ($latestLayouts->isNotEmpty()) {
            $this->layoutArticles['latest'] = $latestLayouts
                ->filter(function($layout) {
                    return $layout->article !== null;
                })
                ->map(function($layout) {
                    return $layout->article;
                })
                ->values(); // Mantiene come Collection
        }

        // Sidebar - sidebar1-5
        $sidebarPositions = ['sidebar1', 'sidebar2', 'sidebar3', 'sidebar4', 'sidebar5'];
        $sidebarLayouts = ArticleLayout::whereIn('position', $sidebarPositions)
            ->where('is_active', true)
            ->with(['article.user', 'article.category'])
            ->orderBy('order', 'asc')
            ->get();
        
        if ($sidebarLayouts->isNotEmpty()) {
            $this->layoutArticles['sidebar'] = $sidebarLayouts
                ->filter(function($layout) {
                    return $layout->article !== null;
                })
                ->map(function($layout) {
                    return $layout->article;
                })
                ->values(); // Mantiene come Collection
        }
    }

    public function render()
    {
        $query = Article::with(['user', 'category'])
            ->published()
            ->where('is_public', true);

        // Filtro per categoria
        if ($this->selectedCategory) {
            $query->where('category_id', $this->selectedCategory);
        }

        // Ricerca
        if ($this->search) {
            $query->search($this->search);
        }

        // Ordinamento
        switch ($this->sortBy) {
            case 'popular':
                $query->popular();
                break;
            case 'featured':
                $query->featured()->recent();
                break;
            default:
                $query->recent();
                break;
        }

        $articles = $query->paginate(12);

        $categories = ArticleCategory::withCount(['articles' => function ($query) {
            $query->published()->where('is_public', true);
        }])->orderBy('name')->get();

        return view('livewire.articles.article-index', [
            'articles' => $articles,
            'categories' => $categories,
            'layoutArticles' => $this->layoutArticles,
        ])->title(__('articles.title'));
    }
}
