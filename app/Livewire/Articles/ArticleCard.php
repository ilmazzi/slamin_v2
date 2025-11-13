<?php

namespace App\Livewire\Articles;

use Livewire\Component;
use App\Models\Article;

class ArticleCard extends Component
{
    public Article $article;
    public string $size = 'medium'; // small, medium, large
    public bool $showExcerpt = true;
    public bool $showCategory = true;
    public bool $showAuthor = true;
    public bool $showStats = true;

    public function mount(Article $article, string $size = 'medium')
    {
        $this->article = $article;
        $this->size = $size;
    }

    public function render()
    {
        return view('livewire.articles.article-card');
    }
}
