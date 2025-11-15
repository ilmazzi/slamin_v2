<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Video;
use App\Models\Poem;
use App\Models\Article;
use App\Models\Photo;
use App\Models\UnifiedLike;
use App\Models\UnifiedComment;
use App\Observers\VideoObserver;
use App\Observers\PoemObserver;
use App\Observers\ArticleObserver;
use App\Observers\PhotoObserver;
use App\Observers\LikeObserver;
use App\Observers\CommentObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register observers for gamification
        Video::observe(VideoObserver::class);
        Poem::observe(PoemObserver::class);
        Article::observe(ArticleObserver::class);
        Photo::observe(PhotoObserver::class);
        UnifiedLike::observe(LikeObserver::class);
        UnifiedComment::observe(CommentObserver::class);
        
        // ForumPost observer - uncomment if ForumPost model exists
        // if (class_exists(\App\Models\ForumPost::class)) {
        //     \App\Models\ForumPost::observe(\App\Observers\ForumPostObserver::class);
        // }
    }
}
