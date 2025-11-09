<?php

namespace App\Livewire\Poems;

use App\Models\Poem;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class PoemIndex extends Component
{
    use WithPagination;
    
    #[Url(as: 'q')]
    public string $search = '';
    
    #[Url]
    public string $category = '';
    
    #[Url]
    public string $language = '';
    
    #[Url]
    public string $type = '';
    
    #[Url]
    public string $sort = 'recent';
    
    #[Url]
    public string $viewMode = 'grid'; // grid, list, masonry, magazine
    
    public int $perPage = 12;
    
    public function setViewMode($mode)
    {
        $this->viewMode = $mode;
    }
    
    // Reset pagination on filter change
    public function updatedSearch()
    {
        $this->resetPage();
    }
    
    public function updatedCategory()
    {
        $this->resetPage();
    }
    
    public function updatedLanguage()
    {
        $this->resetPage();
    }
    
    public function updatedType()
    {
        $this->resetPage();
    }
    
    public function updatedSort()
    {
        $this->resetPage();
    }
    
    public function resetFilters()
    {
        $this->reset(['search', 'category', 'language', 'type', 'sort']);
        $this->resetPage();
    }
    
    public function render()
    {
        $poems = Poem::query()
            ->with(['user'])
            ->published()
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('title', 'like', "%{$this->search}%")
                      ->orWhere('content', 'like', "%{$this->search}%")
                      ->orWhere('description', 'like', "%{$this->search}%")
                      ->orWhereHas('user', function($userQuery) {
                          $userQuery->where('name', 'like', "%{$this->search}%");
                      });
                });
            })
            ->when($this->category, fn($q) => $q->where('category', $this->category))
            ->when($this->language, fn($q) => $q->where('language', $this->language))
            ->when($this->type, fn($q) => $q->where('poem_type', $this->type))
            ->when($this->sort === 'popular', fn($q) => $q->orderBy('view_count', 'desc')->orderBy('like_count', 'desc'))
            ->when($this->sort === 'oldest', fn($q) => $q->orderBy('published_at', 'asc'))
            ->when($this->sort === 'alphabetical', fn($q) => $q->orderBy('title', 'asc'))
            ->when($this->sort === 'recent', fn($q) => $q->orderBy('published_at', 'desc'))
            ->paginate($this->perPage);
        
        return view('livewire.poems.poem-index', [
            'poems' => $poems,
            'categories' => config('poems.categories'),
            'languages' => config('poems.languages'),
            'poemTypes' => config('poems.poem_types'),
        ]);
    }
}

