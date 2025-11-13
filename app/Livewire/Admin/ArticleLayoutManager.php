<?php

namespace App\Livewire\Admin;

use App\Models\Article;
use App\Models\ArticleLayout;
use Livewire\Component;
use Livewire\Attributes\On;

class ArticleLayoutManager extends Component
{
    public $layouts = [];
    public $searchTerm = '';
    public $searchResults;
    public $showSearchModal = false;
    public $currentPosition = null;

    protected $positions = [
        'main' => [
            'banner' => ['width' => 'full', 'height' => 'large'],
            'column1' => ['width' => 'half', 'height' => 'medium'],
            'column2' => ['width' => 'half', 'height' => 'medium'],
            'horizontal1' => ['width' => 'full', 'height' => 'small'],
            'horizontal2' => ['width' => 'full', 'height' => 'small'],
            'column3' => ['width' => 'half', 'height' => 'medium'],
            'column4' => ['width' => 'half', 'height' => 'medium'],
            'horizontal3' => ['width' => 'full', 'height' => 'small'],
            'column5' => ['width' => 'half', 'height' => 'medium'],
            'column6' => ['width' => 'half', 'height' => 'medium'],
        ],
        'sidebar' => [
            'sidebar1' => ['width' => 'full', 'height' => 'small'],
            'sidebar2' => ['width' => 'full', 'height' => 'small'],
            'sidebar3' => ['width' => 'full', 'height' => 'small'],
            'sidebar4' => ['width' => 'full', 'height' => 'small'],
            'sidebar5' => ['width' => 'full', 'height' => 'small'],
        ],
    ];

    public function mount()
    {
        // Verifica permessi
        if (!auth()->user()->hasAnyRole(['admin', 'moderator', 'editor'])) {
            abort(403, 'Unauthorized action.');
        }
        
        // Inizializza searchResults come collection vuota
        $this->searchResults = collect([]);
        
        $this->loadLayouts();
    }

    public function loadLayouts()
    {
        // Carica tutti i layout attivi
        $existingLayouts = ArticleLayout::with('article')
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        // Inizializza array con tutte le posizioni
        $allPositions = array_merge(
            array_keys($this->positions['main']),
            array_keys($this->positions['sidebar'])
        );

        foreach ($allPositions as $position) {
            $layout = $existingLayouts->firstWhere('position', $position);
            $this->layouts[$position] = [
                'article_id' => $layout?->article_id,
                'article' => $layout?->article,
                'order' => $layout?->order ?? 0,
            ];
        }
    }

    public function openSearchModal($position)
    {
        $this->currentPosition = $position;
        $this->showSearchModal = true;
        $this->searchTerm = '';
        $this->searchResults = collect([]);
        $this->searchArticles();
    }

    public function closeSearchModal()
    {
        $this->showSearchModal = false;
        $this->currentPosition = null;
        $this->searchTerm = '';
        $this->searchResults = collect([]);
    }

    public function searchArticles()
    {
        $query = Article::query()
            ->with(['category', 'user'])
            ->orderBy('created_at', 'desc');

        // Mostra tutti gli articoli (anche draft) per il layout manager
        // Rimuovo il filtro published() per permettere di selezionare qualsiasi articolo

        if (!empty($this->searchTerm)) {
            $searchTerm = $this->searchTerm;
            $query->where(function ($q) use ($searchTerm) {
                // Cerca nei campi JSON title ed excerpt
                $q->whereRaw("JSON_EXTRACT(title, '$.it') LIKE ?", ['%' . $searchTerm . '%'])
                  ->orWhereRaw("JSON_EXTRACT(title, '$.en') LIKE ?", ['%' . $searchTerm . '%'])
                  ->orWhereRaw("JSON_EXTRACT(title, '$.fr') LIKE ?", ['%' . $searchTerm . '%'])
                  ->orWhereRaw("JSON_EXTRACT(excerpt, '$.it') LIKE ?", ['%' . $searchTerm . '%'])
                  ->orWhereRaw("JSON_EXTRACT(excerpt, '$.en') LIKE ?", ['%' . $searchTerm . '%'])
                  ->orWhereRaw("JSON_EXTRACT(excerpt, '$.fr') LIKE ?", ['%' . $searchTerm . '%']);
            });
        }

        $this->searchResults = $query->limit(20)->get();
        
        // Debug: log il numero di risultati
        \Log::info('ArticleLayoutManager searchArticles', [
            'searchTerm' => $this->searchTerm,
            'resultsCount' => $this->searchResults->count(),
            'totalArticles' => Article::count()
        ]);
    }

    public function selectArticle($articleId)
    {
        if (!$this->currentPosition) {
            return;
        }

        $article = Article::find($articleId);
        if (!$article) {
            return;
        }

        $this->layouts[$this->currentPosition]['article_id'] = $article->id;
        $this->layouts[$this->currentPosition]['article'] = $article;

        $this->closeSearchModal();
    }

    public function clearPosition($position)
    {
        $this->layouts[$position]['article_id'] = null;
        $this->layouts[$position]['article'] = null;
    }

    public function saveAllLayouts()
    {
        try {
            // Elimina tutti i layout esistenti
            ArticleLayout::query()->delete();

            // Crea nuovi layout
            foreach ($this->layouts as $position => $data) {
                if (!empty($data['article_id'])) {
                    ArticleLayout::create([
                        'position' => $position,
                        'article_id' => $data['article_id'],
                        'order' => $data['order'] ?? 0,
                        'is_active' => true,
                    ]);
                }
            }

            session()->flash('success', __('articles.layout.layout_updated'));
            $this->loadLayouts();
        } catch (\Exception $e) {
            session()->flash('error', 'Errore durante il salvataggio: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.article-layout-manager', [
            'positions' => $this->positions,
        ])->title(__('articles.layout.title'));
    }

    #[On('search-updated')]
    public function updateSearch()
    {
        $this->searchArticles();
    }
}
