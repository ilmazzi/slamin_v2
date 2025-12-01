<?php

namespace App\Livewire\Articles;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleTag;
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
    public $tags = ''; // Stringa separata da virgole
    
    // Categories
    public $categories = [];
    
    // Editor
    public $editorContent = '';

    public function mount(Article $article)
    {
        $this->article = $article->load('category');
        $this->articleId = $this->article->id;
        
        // Check permissions
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Devi essere autenticato per modificare un articolo');
        }
        
        // Check general permission
        if (!$user->canCreateArticle()) {
            abort(403, 'Non hai i permessi per modificare articoli');
        }
        
        // Check if user owns the article or is admin/moderator
        if ($user->id !== $this->article->user_id && !$user->canModerateContent()) {
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
        
        // Load tags
        $this->loadTags();
    }
    
    protected function loadTags()
    {
        $locale = app()->getLocale();
        $tags = $this->article->tags()->get();
        $tagNames = [];
        
        foreach ($tags as $tag) {
            $name = is_array($tag->name) 
                ? ($tag->name[$locale] ?? $tag->name['it'] ?? $tag->name['en'] ?? '')
                : $tag->name;
            if (!empty($name)) {
                $tagNames[] = $name;
            }
        }
        
        $this->tags = implode(', ', $tagNames);
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
            'tags' => 'nullable|string|max:500',
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
            
            // Handle tags
            $this->syncTags($this->article, $this->tags);
            
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
    
    /**
     * Sincronizza i tag con l'articolo
     */
    protected function syncTags(Article $article, string $tagsString)
    {
        $locale = app()->getLocale();
        $tagNames = array_map('trim', explode(',', $tagsString));
        $tagNames = array_filter($tagNames); // Rimuovi vuoti
        
        $tagIds = [];
        $oldTagIds = $article->tags()->pluck('article_tags.id')->toArray();
        
        foreach ($tagNames as $tagName) {
            // Rimuovi # se presente
            $tagName = ltrim($tagName, '#');
            if (empty($tagName)) continue;
            
            // Cerca tag esistente per slug
            $slug = Str::slug($tagName);
            $tag = ArticleTag::where('slug', $slug)->first();
            
            if (!$tag) {
                // Crea nuovo tag
                $tag = ArticleTag::create([
                    'name' => [$locale => $tagName],
                    'slug' => $slug,
                    'is_active' => true,
                    'usage_count' => 0,
                ]);
            }
            
            $tagIds[] = $tag->id;
            
            // Incrementa usage solo se non era già associato
            if (!in_array($tag->id, $oldTagIds)) {
                $tag->incrementUsage();
            }
        }
        
        // Decrementa usage per tag rimossi (solo se non sono più associati ad altri articoli)
        $removedTagIds = array_diff($oldTagIds, $tagIds);
        foreach ($removedTagIds as $removedTagId) {
            $tag = ArticleTag::find($removedTagId);
            if ($tag) {
                // Verifica se il tag è ancora associato ad altri articoli
                $otherArticlesCount = $tag->articles()->where('articles.id', '!=', $article->id)->count();
                if ($otherArticlesCount === 0) {
                    $tag->decrementUsage();
                }
            }
        }
        
        // Sincronizza i tag con l'articolo
        $article->tags()->sync($tagIds);
    }
    
    public function render()
    {
        return view('livewire.articles.article-edit')
            ->layout('components.layouts.app');
    }
}

