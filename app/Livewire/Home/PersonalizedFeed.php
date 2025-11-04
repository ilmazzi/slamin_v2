<?php

namespace App\Livewire\Home;

use Livewire\Component;
use App\Models\Poem;
use App\Models\Article;
use App\Models\Event;
use App\Models\Video;
use App\Models\User;
use App\Models\UnifiedLike;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PersonalizedFeed extends Component
{
    public $feedItems = [];

    public function mount()
    {
        $this->loadFeed();
    }

    public function loadFeed()
    {
        $user = Auth::user();
        $this->feedItems = [];

        // Load real data from database
        
        // Recent poems
        $poems = Poem::with('user')
            ->where('is_public', true)
            ->where('moderation_status', 'approved')
            ->latest('published_at')
            ->limit(3)
            ->get();

        foreach ($poems as $poem) {
            // Check if user already liked this
            $isLiked = Auth::check() && UnifiedLike::where('user_id', Auth::id())
                ->where('likeable_type', Poem::class)
                ->where('likeable_id', $poem->id)
                ->exists();

            $this->feedItems[] = [
                'type' => 'poem',
                'id' => $poem->id,
                'author' => [
                    'name' => $poem->user->name,
                    'avatar' => $poem->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($poem->user->name) . '&background=059669&color=fff',
                    'verified' => false,
                ],
                'title' => $poem->title,
                'excerpt' => \Str::limit($poem->content, 150),
                'likes_count' => $poem->like_count ?? 0,
                'comments_count' => $poem->comment_count ?? 0,
                'created_at' => $poem->published_at ? Carbon::parse($poem->published_at)->diffForHumans() : Carbon::parse($poem->created_at)->diffForHumans(),
                'image' => $poem->thumbnail,
                'is_liked' => $isLiked,
            ];
        }

        // Upcoming events
        $events = Event::where('is_public', true)
            ->where('moderation_status', 'approved')
            ->where('start_datetime', '>=', now())
            ->orderBy('start_datetime')
            ->limit(2)
            ->get();

        foreach ($events as $event) {
            $this->feedItems[] = [
                'type' => 'event',
                'id' => $event->id,
                'title' => $event->title,
                'location' => ($event->city ?? 'Milano') . ', ' . ($event->venue_name ?? ''),
                'date' => Carbon::parse($event->start_datetime)->isoFormat('dddd D MMM, HH:mm'),
                'participants_count' => fake()->numberBetween(20, 200),
                'image' => $event->image_url ?? 'https://images.unsplash.com/photo-1506157786151-b8491531f063?w=800&auto=format&fit=crop',
                'is_attending' => false,
            ];
        }

        // Videos
        $videos = Video::with('user')
            ->where('is_public', true)
            ->where('moderation_status', 'approved')
            ->latest('created_at')
            ->limit(2)
            ->get();

        foreach ($videos as $video) {
            $minutes = floor($video->duration / 60);
            $seconds = $video->duration % 60;

            $isLiked = Auth::check() && UnifiedLike::where('user_id', Auth::id())
                ->where('likeable_type', Video::class)
                ->where('likeable_id', $video->id)
                ->exists();
            
            $this->feedItems[] = [
                'type' => 'video',
                'id' => $video->id,
                'author' => [
                    'name' => $video->user->name,
                    'avatar' => $video->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($video->user->name) . '&background=0891b2&color=fff',
                    'verified' => false,
                ],
                'title' => $video->title,
                'duration' => sprintf('%d:%02d', $minutes, $seconds),
                'views_count' => $video->view_count ?? 0,
                'likes_count' => $video->like_count ?? 0,
                'thumbnail' => $video->thumbnail ?? 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&auto=format&fit=crop',
                'created_at' => Carbon::parse($video->created_at)->diffForHumans(),
                'is_liked' => $isLiked,
            ];
        }

        // Articles
        $articles = Article::with('user')
            ->where('is_public', true)
            ->where('moderation_status', 'approved')
            ->latest('published_at')
            ->limit(2)
            ->get();

        $locale = app()->getLocale();
        foreach ($articles as $article) {
            $isLiked = Auth::check() && UnifiedLike::where('user_id', Auth::id())
                ->where('likeable_type', Article::class)
                ->where('likeable_id', $article->id)
                ->exists();

            $this->feedItems[] = [
                'type' => 'article',
                'id' => $article->id,
                'author' => [
                    'name' => $article->user->name,
                    'avatar' => $article->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($article->user->name) . '&background=059669&color=fff',
                    'verified' => false,
                ],
                'title' => is_array($article->title) ? ($article->title[$locale] ?? $article->title['it'] ?? '') : $article->title,
                'excerpt' => is_array($article->excerpt) ? \Str::limit($article->excerpt[$locale] ?? $article->excerpt['it'] ?? '', 150) : \Str::limit($article->excerpt, 150),
                'likes_count' => $article->like_count ?? 0,
                'comments_count' => $article->comment_count ?? 0,
                'created_at' => $article->published_at ? Carbon::parse($article->published_at)->diffForHumans() : Carbon::parse($article->created_at)->diffForHumans(),
                'image' => $article->thumbnail ?? 'https://images.unsplash.com/photo-1455390582262-044cdead277a?w=800&auto=format&fit=crop',
                'is_liked' => $isLiked,
            ];
        }


        // New poet suggestions
        $newPoets = User::whereHas('poems', function($query) {
                $query->where('moderation_status', 'approved');
            })
            ->withCount('poems')
            ->latest('created_at')
            ->limit(1)
            ->get();

        foreach ($newPoets as $poet) {
            $this->feedItems[] = [
                'type' => 'suggestion',
                'id' => $poet->id,
                'poet' => [
                    'name' => $poet->name,
                    'avatar' => $poet->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($poet->name) . '&background=dc2626&color=fff',
                    'followers_count' => fake()->numberBetween(50, 2000),
                    'poems_count' => $poet->poems_count,
                    'bio' => $poet->bio ?? 'Poeta contemporaneo, amo scrivere di natura e sentimenti.',
                ],
                'mutual_followers' => fake()->numberBetween(0, 15),
            ];
        }

        // Mock gallery (placeholder - will be replaced with real galleries)
        $randomUser = User::inRandomOrder()->first();
        if ($randomUser) {
            $this->feedItems[] = [
                'type' => 'gallery',
                'id' => 1,
                'author' => [
                    'name' => $randomUser->name,
                    'avatar' => $randomUser->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($randomUser->name) . '&background=f59e0b&color=fff',
                    'verified' => false,
                ],
                'title' => 'Momenti Poetici - ' . fake()->randomElement(['Firenze', 'Roma', 'Milano']),
                'photos_count' => fake()->numberBetween(5, 12),
                'images' => [
                    'https://images.unsplash.com/photo-1523906834658-6e24ef2386f9?w=400&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1516589178581-6cd7833ae3b2?w=400&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1549877452-9c387954fbc2?w=400&auto=format&fit=crop',
                ],
                'likes_count' => fake()->numberBetween(50, 300),
                'created_at' => Carbon::instance(fake()->dateTimeBetween('-7 days', 'now'))->diffForHumans(),
                'is_liked' => false,
            ];
        }
    }

    public function toggleLike($itemId, $itemType)
    {
        if (!Auth::check()) {
            $this->dispatch('notify', [
                'message' => __('social.login_to_like'),
                'type' => 'warning'
            ]);
            return ['liked' => false, 'count' => 0];
        }

        // Map type to model class
        $modelMap = [
            'poem' => Poem::class,
            'video' => Video::class,
            'article' => Article::class,
            'event' => Event::class,
            'gallery' => 'App\Models\Gallery', // Placeholder
        ];

        $modelClass = $modelMap[$itemType] ?? null;
        if (!$modelClass) {
            return ['liked' => false, 'count' => 0];
        }

        // Check if already liked
        $existingLike = UnifiedLike::where('user_id', Auth::id())
            ->where('likeable_type', $modelClass)
            ->where('likeable_id', $itemId)
            ->first();

        if ($existingLike) {
            // Unlike
            $existingLike->delete();
            
            // Update counter in model
            $model = $modelClass::find($itemId);
            if ($model) {
                $model->decrement('like_count');
            }
            
            return ['liked' => false, 'count' => $model->like_count ?? 0];
        } else {
            // Like
            UnifiedLike::create([
                'user_id' => Auth::id(),
                'likeable_type' => $modelClass,
                'likeable_id' => $itemId,
            ]);
            
            // Update counter in model
            $model = $modelClass::find($itemId);
            if ($model) {
                $model->increment('like_count');
            }
            
            $this->dispatch('notify', [
                'message' => __('social.liked'),
                'type' => 'success'
            ]);
            
            return ['liked' => true, 'count' => $model->like_count ?? 1];
        }
    }

    public function attendEvent($eventId)
    {
        // Handle event attendance
        $this->dispatch('notify', ['message' => 'Ti sei iscritto all\'evento!', 'type' => 'success']);
    }

    public function followPoet($poetId)
    {
        // Handle follow
        $this->dispatch('notify', ['message' => 'Ora segui questo poeta!', 'type' => 'success']);
    }

    public function render()
    {
        return view('livewire.home.personalized-feed');
    }
}

