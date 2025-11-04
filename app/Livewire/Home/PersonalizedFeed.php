<?php

namespace App\Livewire\Home;

use Livewire\Component;
use App\Models\Poem;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

        // Simulated feed items - in production, you'd fetch real data
        
        // Recent poems from followed poets
        $this->feedItems[] = [
            'type' => 'poem',
            'id' => 1,
            'author' => [
                'name' => 'Maria Rossi',
                'avatar' => 'https://ui-avatars.com/api/?name=Maria+Rossi&background=059669&color=fff',
                'verified' => true,
            ],
            'title' => 'Sussurri del Vento',
            'excerpt' => 'Nel silenzio della notte il vento parla, racconta storie di terre lontane...',
            'likes_count' => 47,
            'comments_count' => 12,
            'created_at' => '2 ore fa',
            'image' => null,
        ];

        // Upcoming event
        $this->feedItems[] = [
            'type' => 'event',
            'id' => 1,
            'title' => 'Serata Poetica sotto le Stelle',
            'location' => 'Milano, Parco Sempione',
            'date' => 'Venerdì 15 Nov, 20:00',
            'participants_count' => 156,
            'image' => 'https://images.unsplash.com/photo-1506157786151-b8491531f063?w=800&auto=format&fit=crop',
            'is_attending' => false,
        ];

        // Video from followed poet
        $this->feedItems[] = [
            'type' => 'video',
            'id' => 1,
            'author' => [
                'name' => 'Luca Bianchi',
                'avatar' => 'https://ui-avatars.com/api/?name=Luca+Bianchi&background=0891b2&color=fff',
                'verified' => false,
            ],
            'title' => 'Recita di "Infinito" di Leopardi',
            'duration' => '3:24',
            'views_count' => 892,
            'likes_count' => 134,
            'thumbnail' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&auto=format&fit=crop',
            'created_at' => '5 ore fa',
        ];

        // Poem from followed poet
        $this->feedItems[] = [
            'type' => 'poem',
            'id' => 2,
            'author' => [
                'name' => 'Giulia Verdi',
                'avatar' => 'https://ui-avatars.com/api/?name=Giulia+Verdi&background=7c3aed&color=fff',
                'verified' => true,
            ],
            'title' => 'Alba Dorata',
            'excerpt' => 'Quando il sole bacia l\'orizzonte, dipinge il cielo di mille colori...',
            'likes_count' => 89,
            'comments_count' => 23,
            'created_at' => '1 giorno fa',
            'image' => 'https://images.unsplash.com/photo-1470252649378-9c29740c9fa8?w=800&auto=format&fit=crop',
        ];

        // New poet suggestion
        $this->feedItems[] = [
            'type' => 'suggestion',
            'id' => 1,
            'poet' => [
                'name' => 'Alessandro Neri',
                'avatar' => 'https://ui-avatars.com/api/?name=Alessandro+Neri&background=dc2626&color=fff',
                'followers_count' => 1243,
                'poems_count' => 67,
                'bio' => 'Poeta contemporaneo, amo scrivere di natura e sentimenti.',
            ],
            'mutual_followers' => 8,
        ];

        // Photo gallery
        $this->feedItems[] = [
            'type' => 'gallery',
            'id' => 1,
            'author' => [
                'name' => 'Sofia Romano',
                'avatar' => 'https://ui-avatars.com/api/?name=Sofia+Romano&background=f59e0b&color=fff',
                'verified' => false,
            ],
            'title' => 'Momenti Poetici - Firenze',
            'photos_count' => 8,
            'images' => [
                'https://images.unsplash.com/photo-1523906834658-6e24ef2386f9?w=400&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1516589178581-6cd7833ae3b2?w=400&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1549877452-9c387954fbc2?w=400&auto=format&fit=crop',
            ],
            'likes_count' => 156,
            'created_at' => '2 giorni fa',
        ];
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

