<?php

namespace App\Livewire\Home;

use Livewire\Component;
use App\Models\Article;
use App\Models\UnifiedLike;
use Illuminate\Support\Facades\Auth;

class ArticlesSection extends Component
{
    public $contentType = 'new'; // 'new' o 'popular'

    public function toggleContent($type)
    {
        $this->contentType = $type;
    }

    public function render()
    {
        if ($this->contentType === 'popular') {
            $articles = Article::where('moderation_status', 'approved')
                ->where('is_public', true)
                ->with('user')
                ->withCount(['views', 'likes', 'comments'])
                ->orderBy('views_count', 'desc')
                ->limit(6)
                ->get();
        } else {
            $articles = Article::where('moderation_status', 'approved')
                ->where('is_public', true)
                ->with('user')
                ->withCount(['views', 'likes', 'comments'])
                ->orderBy('created_at', 'desc')
                ->limit(6)
                ->get();
        }
        
        // Check if user has liked each article
        if (Auth::check()) {
            foreach ($articles as $article) {
                $article->is_liked = UnifiedLike::where('user_id', Auth::id())
                    ->where('likeable_type', Article::class)
                    ->where('likeable_id', $article->id)
                    ->exists();
            }
        } else {
            foreach ($articles as $article) {
                $article->is_liked = false;
            }
        }
        
        return view('livewire.home.articles-section', [
            'articles' => $articles
        ]);
    }
}
