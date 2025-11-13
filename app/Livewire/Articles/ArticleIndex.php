<?php

namespace App\Livewire\Articles;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Article;
use App\Models\ArticleCategory;

class ArticleIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCategory = '';
    public $sortBy = 'recent'; // recent, popular, featured

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCategory' => ['except' => ''],
        'sortBy' => ['except' => 'recent'],
    ];

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
        $featuredArticle = Article::published()
            ->where('is_public', true)
            ->where('featured', true)
            ->latest('published_at')
            ->first();

        $categories = ArticleCategory::withCount(['articles' => function ($query) {
            $query->published()->where('is_public', true);
        }])->orderBy('name')->get();

        return view('livewire.articles.article-index', [
            'articles' => $articles,
            'featuredArticle' => $featuredArticle,
            'categories' => $categories,
        ]);
    }
}
