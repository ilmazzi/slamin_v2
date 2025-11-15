<?php

namespace App\Livewire\Articles;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleEdit extends Component
{
    use WithFileUploads;

    public $article;
    public $articleId;
    
    // Form fields
    public $title = '';
    public $content = '';
    public $excerpt = '';
    public $category_id = null;
    public $featured_image;
    public $existing_featured_image = null;
    public $status = 'draft';
    public $is_public = true;
    public $published_at = null;
    
    // Categories
    public $categories = [];
    
    // Editor
    public $editorContent = '';

    public function mount(Article $article)
    {
        $this->article = $article->load('category');
        $this->articleId = $this->article->id;
        
        // Check permissions
        if (!Auth::check()) {
            abort(403, 'Devi essere autenticato per modificare un articolo');
        }
        
        if (Auth::id() !== $this->article->user_id && !Auth::user()->hasRole(['admin', 'editor'])) {
            abort(403, 'Non hai i permessi per modificare questo articolo');
        }
        
        // Load article data
        $this->loadArticleData();
        
        // Load categories
        $this->categories = ArticleCategory::orderBy('name')->get();
    }
    
    protected function loadArticleData()
    {
        $locale = app()->getLocale();
        
        // Get localized values
        $titleArray = is_array($this->article->title) ? $this->article->title : json_decode($this->article->title ?? '{}', true);
        $contentArray = is_array($this->article->content) ? $this->article->content : json_decode($this->article->content ?? '{}', true);
        $excerptArray = is_array($this->article->excerpt) ? $this->article->excerpt : json_decode($this->article->excerpt ?? '{}', true);
        
        $this->title = $titleArray[$locale] ?? $titleArray['it'] ?? $titleArray['en'] ?? '';
        $this->content = $contentArray[$locale] ?? $contentArray['it'] ?? $contentArray['en'] ?? '';
        $this->excerpt = $excerptArray[$locale] ?? $excerptArray['it'] ?? $excerptArray['en'] ?? '';
        
        $this->category_id = $this->article->category_id;
        $this->existing_featured_image = $this->article->featured_image_url;
        $this->status = $this->article->status ?? 'draft';
        $this->is_public = $this->article->is_public ?? true;
        $this->published_at = $this->article->published_at ? $this->article->published_at->format('Y-m-d\TH:i') : null;
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
            'title.required' => __('articles.edit.title_required'),
            'title.max' => __('articles.edit.title_max'),
            'content.required' => __('articles.edit.content_required'),
            'excerpt.max' => __('articles.edit.excerpt_max'),
            'category_id.exists' => __('articles.edit.category_invalid'),
            'featured_image.image' => __('articles.edit.image_invalid'),
            'featured_image.max' => __('articles.edit.image_max'),
            'status.required' => __('articles.edit.status_required'),
            'status.in' => __('articles.edit.status_invalid'),
            'published_at.date' => __('articles.edit.published_at_invalid'),
        ];
    }
    
    public function save()
    {
        $this->validate();
        
        try {
            $locale = app()->getLocale();
            
            // Get existing multilingual data
            $titleArray = is_array($this->article->title) ? $this->article->title : json_decode($this->article->title ?? '{}', true);
            $contentArray = is_array($this->article->content) ? $this->article->content : json_decode($this->article->content ?? '{}', true);
            $excerptArray = is_array($this->article->excerpt) ? $this->article->excerpt : json_decode($this->article->excerpt ?? '{}', true);
            
            // Update current locale
            $titleArray[$locale] = $this->title;
            $contentArray[$locale] = $this->content;
            if ($this->excerpt) {
                $excerptArray[$locale] = $this->excerpt;
            }
            
            // Update article
            $this->article->title = $titleArray;
            $this->article->content = $contentArray;
            if ($this->excerpt) {
                $this->article->excerpt = $excerptArray;
            }
            $this->article->category_id = $this->category_id;
            $this->article->status = $this->status;
            $this->article->is_public = $this->is_public;
            
            if ($this->published_at) {
                $this->article->published_at = \Carbon\Carbon::parse($this->published_at);
            }
            
            // Handle featured image upload
            if ($this->featured_image) {
                // Delete old image if exists
                if ($this->article->featured_image && Storage::disk('public')->exists($this->article->featured_image)) {
                    Storage::disk('public')->delete($this->article->featured_image);
                }
                
                // Store new image
                $path = $this->featured_image->store('articles', 'public');
                $this->article->featured_image = $path;
            }
            
            // Update slug if title changed
            $titleForSlug = $titleArray['it'] ?? $titleArray['en'] ?? $this->title;
            $this->article->slug = Str::slug($titleForSlug);
            
            $this->article->save();
            
            // Dispatch success message
            session()->flash('message', __('articles.edit.saved_successfully'));
            
            // Redirect to articles index
            return $this->redirect(route('articles.index'), navigate: true);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation errors are automatically handled by Livewire
            throw $e;
        } catch (\Exception $e) {
            session()->flash('error', __('articles.edit.save_error') . ': ' . $e->getMessage());
            \Log::error('Article edit error', [
                'article_id' => $this->articleId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
    
    public function render()
    {
        return view('livewire.articles.article-edit')
            ->layout('components.layouts.app');
    }
}

