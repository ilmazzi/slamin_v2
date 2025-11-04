<?php

namespace App\Livewire\Home;

use Livewire\Component;
use App\Models\Poem;
use App\Models\Article;
use App\Models\Event;
use App\Models\Video;
use App\Models\User;
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
            ];
        }
    }

    public function toggleLike($itemId, $itemType)
    {
        // Handle like toggle
        $this->dispatch('notify', ['message' => 'Like aggiunto!', 'type' => 'success']);
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

