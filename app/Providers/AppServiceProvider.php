<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Events\Verified;
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
use App\Observers\GroupObserver;
use App\Observers\GroupMemberObserver;
use App\Listeners\CreatePeerTubeAccount;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Prevent timeout issues during development
        if (config('app.debug')) {
            ini_set('max_execution_time', '300');
        }
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
        
        // Register Group observers
        \App\Models\Group::observe(GroupObserver::class);
        \App\Models\GroupMember::observe(GroupMemberObserver::class);
        
        // ForumPost observer - uncomment if ForumPost model exists
        // if (class_exists(\App\Models\ForumPost::class)) {
        //     \App\Models\ForumPost::observe(\App\Observers\ForumPostObserver::class);
        // }
        
        // Register event listeners
        Event::listen(Verified::class, CreatePeerTubeAccount::class);
        
        // Register Gates for permissions
        $this->registerGates();
    }
    
    /**
     * Register authorization gates based on permissions
     * Uses helper methods from User model for consistency
     */
    protected function registerGates(): void
    {
        // Gate per caricare video
        Gate::define('upload.video', function ($user) {
            return $user->canUploadVideo();
        });
        
        // Gate per creare poesie
        Gate::define('create.poem', function ($user) {
            return $user->canCreatePoem();
        });
        
        // Gate per creare eventi
        Gate::define('create.event', function ($user) {
            return $user->canCreateEvent();
        });
        
        // Gate per caricare foto
        Gate::define('upload.photo', function ($user) {
            return $user->canUploadPhoto();
        });
        
        // Gate per creare articoli
        Gate::define('create.article', function ($user) {
            return $user->canCreateArticle();
        });
        
        // Gate per moderare contenuti
        Gate::define('moderate.content', function ($user) {
            return $user->canModerateContent();
        });
        
        // Gate per giudicare eventi
        Gate::define('judge.events', function ($user) {
            return $user->canJudge();
        });
        
        // Gate per organizzare eventi
        Gate::define('organize.events', function ($user) {
            return $user->canOrganizeEvents();
        });
    }
}
