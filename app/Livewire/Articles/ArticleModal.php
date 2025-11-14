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
    
    #[On('openArticleModal')]
    public function openModal($articleId)
    {
        $this->articleId = $articleId;
        $this->article = Article::with(['user', 'category'])
            ->find($articleId);
        
        if ($this->article) {
            // Increment view count
            $this->article->increment('views_count');
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
