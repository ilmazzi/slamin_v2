<?php

namespace App\Livewire\Admin\Articles;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Url;
use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleList extends Component
{
    use WithPagination, WithFileUploads;

    #[Url]
    public $search = '';

    #[Url]
    public $category = 'all';

    #[Url]
    public $status = 'all'; // all, draft, published, archived

    #[Url]
    public $moderationStatus = 'all'; // all, pending, approved, rejected

    #[Url]
    public $sortBy = 'created_at';

    #[Url]
    public $sortDirection = 'desc';

    // Modal create/edit
    public $showModal = false;
    public $isEditing = false;
    public $editingArticleId = null;

    // Form fields
    public $title = [];
    public $content = [];
    public $excerpt = [];
    public $category_id = null;
    public $featured_image;
    public $existing_featured_image = null;
    public $articleStatus = 'draft';
    public $featured = false;
    public $tag_ids = [];

    public function mount()
    {
        if (!Auth::check() || !Auth::user()->hasAnyRole(['admin', 'editor'])) {
            abort(403, 'Accesso negato');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function updatingModerationStatus()
    {
        $this->resetPage();
    }

    public function sortByColumn($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function create()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function edit($articleId)
    {
        $article = Article::with(['category', 'tags'])->findOrFail($articleId);
        $this->editingArticleId = $article->id;
        $this->title = $article->title ?? [];
        $this->content = $article->content ?? [];
        $this->excerpt = $article->excerpt ?? [];
        $this->category_id = $article->category_id;
        $this->existing_featured_image = $article->featured_image;
        $this->articleStatus = $article->status;
        $this->featured = $article->featured ?? false;
        $this->tag_ids = $article->tags->pluck('id')->toArray();
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->isEditing = false;
        $this->editingArticleId = null;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'title', 'content', 'excerpt', 'category_id',
            'featured_image', 'existing_featured_image',
            'articleStatus', 'featured', 'tag_ids'
        ]);
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|array',
            'title.it' => 'required|string|max:255',
            'content' => 'required|array',
            'content.it' => 'required|string',
            'excerpt' => 'nullable|array',
            'category_id' => 'nullable|exists:article_categories,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'articleStatus' => 'required|in:draft,published,archived',
            'featured' => 'boolean',
            'tag_ids' => 'array',
        ]);

        $data = [
            'user_id' => Auth::id(),
            'title' => $this->title,
            'content' => $this->content,
            'excerpt' => $this->excerpt,
            'category_id' => $this->category_id,
            'status' => $this->articleStatus,
            'featured' => $this->featured,
            'slug' => Str::slug($this->title['it']),
            'moderation_status' => 'approved', // Admin articles auto-approved
            'is_public' => true,
        ];

        if ($this->featured_image) {
            // Delete old image if exists
            if ($this->existing_featured_image) {
                Storage::disk('public')->delete($this->existing_featured_image);
            }
            $data['featured_image'] = $this->featured_image->store('articles', 'public');
        }

        if ($this->isEditing) {
            $article = Article::findOrFail($this->editingArticleId);
            $article->update($data);
            
            if (!empty($this->tag_ids)) {
                $article->tags()->sync($this->tag_ids);
            }

            if ($this->articleStatus === 'published' && $article->status !== 'published') {
                $article->publish();
            }
        } else {
            $article = Article::create($data);
            
            if (!empty($this->tag_ids)) {
                $article->tags()->attach($this->tag_ids);
            }

            if ($this->articleStatus === 'published') {
                $article->publish();
            }
        }

        session()->flash('message', 'Articolo salvato con successo');
        $this->closeModal();
    }

    public function delete($articleId)
    {
        $article = Article::findOrFail($articleId);

        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }

        $article->delete();

        session()->flash('message', 'Articolo eliminato con successo');
    }

    public function toggleFeatured($articleId)
    {
        $article = Article::findOrFail($articleId);
        
        // Check limit (max 3 featured)
        if (!$article->featured && Article::where('featured', true)->count() >= 3) {
            session()->flash('error', 'Limite massimo di 3 articoli featured raggiunto');
            return;
        }

        $article->update(['featured' => !$article->featured]);
        session()->flash('message', $article->featured ? 'Articolo aggiunto ai featured' : 'Articolo rimosso dai featured');
    }

    public function approve($articleId)
    {
        $article = Article::findOrFail($articleId);
        $article->approve(Auth::user());
        session()->flash('message', 'Articolo approvato');
    }

    public function reject($articleId)
    {
        $article = Article::findOrFail($articleId);
        $article->reject(Auth::user(), 'Rifiutato da admin');
        session()->flash('message', 'Articolo rifiutato');
    }

    public function publish($articleId)
    {
        $article = Article::findOrFail($articleId);
        $article->publish();
        $article->update(['moderation_status' => 'approved']);
        session()->flash('message', 'Articolo pubblicato');
    }

    public function unpublish($articleId)
    {
        $article = Article::findOrFail($articleId);
        $article->unpublish();
        if ($article->featured) {
            $article->update(['featured' => false]);
        }
        session()->flash('message', 'Articolo rimesso in bozza');
    }

    public function getCategoriesProperty()
    {
        return ArticleCategory::active()->ordered()->get();
    }

    public function getTagsProperty()
    {
        // TODO: Implementare quando ArticleTag sarà disponibile
        return collect([]);
    }

    public function render()
    {
        $query = Article::with(['user', 'category', 'tags'])
            ->orderBy($this->sortBy, $this->sortDirection);

        // Filtri
        if ($this->search) {
            $query->where(function($q) {
                $q->whereRaw("JSON_EXTRACT(title, '$.it') LIKE ?", ['%' . $this->search . '%'])
                  ->orWhereRaw("JSON_EXTRACT(title, '$.en') LIKE ?", ['%' . $this->search . '%'])
                  ->orWhereRaw("JSON_EXTRACT(excerpt, '$.it') LIKE ?", ['%' . $this->search . '%']);
            });
        }

        if ($this->category !== 'all') {
            $query->where('category_id', $this->category);
        }

        if ($this->status !== 'all') {
            $query->where('status', $this->status);
        }

        if ($this->moderationStatus !== 'all') {
            $query->where('moderation_status', $this->moderationStatus);
        }

        $articles = $query->paginate(12);

        return view('livewire.admin.articles.article-list', [
            'articles' => $articles,
        ])->layout('components.layouts.app');
    }
}
