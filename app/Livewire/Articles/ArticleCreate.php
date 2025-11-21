<?php

namespace App\Livewire\Articles;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleCreate extends Component
{
    use WithFileUploads;

    // Form fields
    public $title = '';
    public $content = '';
    public $excerpt = '';
    public $category_id = null;
    public $featured_image;
    public $status = 'draft';
    public $is_public = true;
    public $published_at = null;
    
    // Categories
    public $categories = [];
    
    // Editor
    public $editorContent = '';

    public function mount()
    {
        // Check authentication
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Devi essere autenticato per creare un articolo');
        }
        
        // Check permissions
        if (!$user->canCreateArticle()) {
            abort(403, 'Non hai i permessi per creare articoli');
        }
        
        // Load categories
        $this->categories = ArticleCategory::orderBy('name')->get();
    }
    
    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'category_id' => 'nullable|exists:article_categories,id',
            'featured_image' => 'nullable|image|max:5120',
            'status' => 'required|in:draft,published,archived',
            'is_public' => 'boolean',
            'published_at' => 'nullable|date',
        ];
    }
    
    protected function messages()
    {
        return [
            'title.required' => __('articles.create.title_required'),
            'title.max' => __('articles.create.title_max'),
            'content.required' => __('articles.create.content_required'),
            'excerpt.max' => __('articles.create.excerpt_max'),
            'category_id.exists' => __('articles.create.category_invalid'),
            'featured_image.image' => __('articles.create.image_invalid'),
            'featured_image.max' => __('articles.create.image_max'),
            'status.required' => __('articles.create.status_required'),
            'status.in' => __('articles.create.status_invalid'),
            'published_at.date' => __('articles.create.published_at_invalid'),
        ];
    }
    
    public function save()
    {
        $this->validate();
        
        try {
            $locale = app()->getLocale();
            
            // Prepare multilingual data
            $titleArray = [$locale => $this->title];
            $contentArray = [$locale => $this->content];
            $excerptArray = $this->excerpt ? [$locale => $this->excerpt] : null;
            
            // Generate slug from title
            $slug = Str::slug($this->title);
            
            // Ensure slug is unique
            $originalSlug = $slug;
            $counter = 1;
            while (Article::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            
            // Create article
            $article = new Article();
            $article->user_id = Auth::id();
            $article->title = $titleArray;
            $article->content = $contentArray;
            if ($excerptArray) {
                $article->excerpt = $excerptArray;
            }
            $article->category_id = $this->category_id;
            $article->status = $this->status;
            $article->is_public = $this->is_public;
            $article->slug = $slug;
            
            if ($this->published_at) {
                $article->published_at = \Carbon\Carbon::parse($this->published_at);
            } else if ($this->status === 'published') {
                $article->published_at = now();
            }
            
            // Handle featured image upload
            if ($this->featured_image) {
                $path = $this->featured_image->store('articles', 'public');
                $article->featured_image = $path;
            }
            
            $article->save();
            
            // Dispatch success message
            session()->flash('message', __('articles.create.created_successfully'));
            
            // Redirect to article edit page or index
            return $this->redirect(route('articles.edit', $article->slug), navigate: true);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation errors are automatically handled by Livewire
            throw $e;
        } catch (\Exception $e) {
            session()->flash('error', __('articles.create.create_error') . ': ' . $e->getMessage());
            \Log::error('Article create error', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
    
    public function render()
    {
        return view('livewire.articles.article-create')
            ->layout('components.layouts.app');
    }
}

