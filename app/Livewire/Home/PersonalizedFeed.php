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

        // Get IDs of users the current user follows
        $followingIds = [];
        if ($user) {
            // Specify table name to avoid ambiguity with the pivot table
            $followingIds = $user->following()->pluck('users.id')->toArray();
            
            // Also get users followed by users you follow (second degree)
            if (!empty($followingIds)) {
                $secondDegreeIds = \DB::table('follows')
                    ->whereIn('follower_id', $followingIds)
                    ->pluck('following_id')
                    ->unique()
                    ->toArray();
                
                // Merge and remove duplicates
                $followingIds = array_unique(array_merge($followingIds, $secondDegreeIds));
            }
        }

        // If user follows no one, show popular content
        $whereUserClause = !empty($followingIds) 
            ? fn($query) => $query->whereIn('user_id', $followingIds)
            : fn($query) => $query->where('like_count', '>', 0);
        
        // For events, use organizer_id instead of user_id
        $whereEventOrganizerClause = !empty($followingIds)
            ? fn($query) => $query->whereIn('organizer_id', $followingIds)
            : fn($query) => $query->where('like_count', '>', 0);
        
        // Recent poems from followed users
        $poems = Poem::with('user')
            ->where('is_public', true)
            ->where('moderation_status', 'approved')
            ->where($whereUserClause)
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

        // Upcoming events from followed users
        $events = Event::where('is_public', true)
            ->where('moderation_status', 'approved')
            ->where('start_datetime', '>=', now())
            ->where($whereEventOrganizerClause)
            ->orderBy('start_datetime')
            ->limit(2)
            ->get();

        foreach ($events as $event) {
            // TODO: Implement participants count when EventParticipant model is created
            // For now, show 0 or hide the count
            $participantsCount = 0;
            
            $this->feedItems[] = [
                'type' => 'event',
                'id' => $event->id,
                'title' => $event->title,
                'location' => ($event->city ?? 'Milano') . ', ' . ($event->venue_name ?? ''),
                'date' => Carbon::parse($event->start_datetime)->isoFormat('dddd D MMM, HH:mm'),
                'participants_count' => $participantsCount,
                'image' => $event->image_url ?? 'https://images.unsplash.com/photo-1506157786151-b8491531f063?w=800&auto=format&fit=crop',
                'is_attending' => false,
            ];
        }

        // Videos from followed users
        $videos = Video::with('user')
            ->where('is_public', true)
            ->where('moderation_status', 'approved')
            ->where($whereUserClause)
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

        // Articles from followed users
        $articles = Article::with('user')
            ->where('is_public', true)
            ->where('moderation_status', 'approved')
            ->where($whereUserClause)
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

        // TODO: Add real gallery feature when implemented
        // For now, galleries are not included in the feed
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


    public function getTrendingTopics()
    {
        $trending = [];
        
        // Get tags from ALL poems (global, not time-limited)
        $poemTags = Poem::where('is_public', true)
            ->where('moderation_status', 'approved')
            ->whereNotNull('tags')
            ->pluck('tags')
            ->flatten()
            ->filter()
            ->countBy()
            ->sortDesc()
            ->take(10);
        
        foreach ($poemTags as $tag => $count) {
            $trending[$tag] = ($trending[$tag] ?? 0) + $count;
        }
        
        // Get tags from ALL articles (global, not time-limited)
        $articleTags = Article::where('is_public', true)
            ->where('moderation_status', 'approved')
            ->withCount(['tags'])
            ->with('tags')
            ->get()
            ->pluck('tags')
            ->flatten()
            ->pluck('name')
            ->filter()
            ->countBy()
            ->sortDesc();
        
        foreach ($articleTags as $tag => $count) {
            $trending[$tag] = ($trending[$tag] ?? 0) + $count;
        }
        
        // Sort by count and take top 5
        arsort($trending);
        $trending = array_slice($trending, 0, 5, true);
        
        // Format with # if not already present
        $formatted = [];
        foreach ($trending as $tag => $count) {
            $formattedTag = str_starts_with($tag, '#') ? $tag : '#' . $tag;
            $formatted[] = [
                'tag' => $formattedTag,
                'count' => $count
            ];
        }
        
        // If no trending topics, return defaults
        if (empty($formatted)) {
            return [
                ['tag' => '#PoesiaContemporanea', 'count' => 0],
                ['tag' => '#Haiku', 'count' => 0],
                ['tag' => '#Versi', 'count' => 0],
            ];
        }
        
        return $formatted;
    }

    public function render()
    {
        $trendingTopics = $this->getTrendingTopics();
        
        return view('livewire.home.personalized-feed', [
            'trendingTopics' => $trendingTopics
        ]);
    }
}

