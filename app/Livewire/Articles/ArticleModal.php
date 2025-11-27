<?php

namespace App\Livewire\Articles;

use App\Models\Article;
use Livewire\Component;
use Livewire\Attributes\On;

class ArticleModal extends Component
{
    public $isOpen = false;
    public $article = null;
    public $articleId = null;
    
    public function mount($articleId = null)
    {
        if ($articleId) {
            $this->openModal($articleId);
        }
    }
    
    #[On('openArticleModal')]
    public function openModal($articleId)
    {
        $this->articleId = $articleId;
        $this->article = Article::with(['user', 'category'])
            ->withCount(['likes', 'comments', 'views'])
            ->find($articleId);
        
        if ($this->article) {
            // Check if user has liked
            if (auth()->check()) {
                $this->article->is_liked = \App\Models\UnifiedLike::where('user_id', auth()->id())
                    ->where('likeable_type', Article::class)
                    ->where('likeable_id', $this->article->id)
                    ->exists();
            } else {
                $this->article->is_liked = false;
            }
            
            // Increment view count using the trait method
            $this->article->incrementViewIfNotOwner(auth()->user());
            $this->isOpen = true;
        }
    }
    
    public function closeModal()
    {
        $this->isOpen = false;
        $this->article = null;
        $this->articleId = null;
    }
    
    public function render()
    {
        return view('livewire.articles.article-modal');
    }
}
