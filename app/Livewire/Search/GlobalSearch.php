<?php

namespace App\Livewire\Search;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\Poem;
use App\Models\Article;
use App\Models\Event;
use App\Models\User;
use App\Models\Video;
use App\Models\Photo;
use App\Models\Gig;

class GlobalSearch extends Component
{
    use WithPagination;

    #[Url]
    public $query = '';

    #[Url]
    public $type = 'all'; // all, poems, articles, events, users, videos, photos, gigs

    public function mount($q = null)
    {
        if ($q) {
            $this->query = $q;
        } elseif (request()->has('q')) {
            $this->query = request()->get('q');
        }
    }

    public function updatedQuery()
    {
        $this->resetPage();
    }

    public function updatedType()
    {
        $this->resetPage();
    }

    public function getResultsProperty()
    {
        if (empty($this->query)) {
            return [
                'poems' => collect(),
                'articles' => collect(),
                'events' => collect(),
                'users' => collect(),
                'videos' => collect(),
                'photos' => collect(),
                'gigs' => collect(),
            ];
        }

        $searchTerm = '%' . $this->query . '%';
        $results = [];

        // Poesie
        if ($this->type === 'all' || $this->type === 'poems') {
            $results['poems'] = Poem::where('is_public', true)
                ->where('is_draft', false)
                ->where(function($q) use ($searchTerm) {
                    $q->where('title', 'like', $searchTerm)
                      ->orWhere('content', 'like', $searchTerm);
                })
                ->with('user')
                ->latest()
                ->take(10)
                ->get();
        }

        // Articoli
        if ($this->type === 'all' || $this->type === 'articles') {
            $searchQuery = str_replace('%', '', $searchTerm); // Remove % for JSON search
            $locale = app()->getLocale();
            
            $results['articles'] = Article::published()
                ->where(function($q) use ($searchQuery, $locale) {
                    // Search in JSON fields using LIKE on JSON strings
                    $q->whereRaw("title LIKE ?", ['%' . $searchQuery . '%'])
                      ->orWhereRaw("excerpt LIKE ?", ['%' . $searchQuery . '%'])
                      ->orWhereRaw("content LIKE ?", ['%' . $searchQuery . '%']);
                })
                ->with('user')
                ->latest('published_at')
                ->take(10)
                ->get();
        }

        // Eventi
        if ($this->type === 'all' || $this->type === 'events') {
            $results['events'] = Event::where('is_public', true)
                ->where(function($q) use ($searchTerm) {
                    $q->where('title', 'like', $searchTerm)
                      ->orWhere('description', 'like', $searchTerm)
                      ->orWhere('venue_name', 'like', $searchTerm)
                      ->orWhere('venue_address', 'like', $searchTerm)
                      ->orWhere('city', 'like', $searchTerm)
                      ->orWhere('country', 'like', $searchTerm);
                })
                ->with('organizer')
                ->latest('start_datetime')
                ->take(10)
                ->get();
        }

        // Utenti
        if ($this->type === 'all' || $this->type === 'users') {
            $results['users'] = User::where(function($q) use ($searchTerm) {
                    $q->where('name', 'like', $searchTerm)
                      ->orWhere('nickname', 'like', $searchTerm)
                      ->orWhere('email', 'like', $searchTerm);
                })
                ->whereNotIn('status', ['suspended', 'banned'])
                ->latest()
                ->take(10)
                ->get();
        }

        // Video
        if ($this->type === 'all' || $this->type === 'videos') {
            $results['videos'] = Video::where('status', 'approved')
                ->where(function($q) use ($searchTerm) {
                    $q->where('title', 'like', $searchTerm)
                      ->orWhere('description', 'like', $searchTerm);
                })
                ->with('user')
                ->latest()
                ->take(10)
                ->get();
        }

        // Foto
        if ($this->type === 'all' || $this->type === 'photos') {
            $results['photos'] = Photo::approved()
                ->where(function($q) use ($searchTerm) {
                    $q->where('title', 'like', $searchTerm)
                      ->orWhere('description', 'like', $searchTerm);
                })
                ->with('user')
                ->latest()
                ->take(10)
                ->get();
        }

        // Ingaggi
        if ($this->type === 'all' || $this->type === 'gigs') {
            $results['gigs'] = Gig::where('status', 'open')
                ->where(function($q) use ($searchTerm) {
                    $q->where('title', 'like', $searchTerm)
                      ->orWhere('description', 'like', $searchTerm)
                      ->orWhere('location', 'like', $searchTerm);
                })
                ->with('user')
                ->latest()
                ->take(10)
                ->get();
        }

        // Fill empty types
        $allTypes = ['poems', 'articles', 'events', 'users', 'videos', 'photos', 'gigs'];
        foreach ($allTypes as $type) {
            if (!isset($results[$type])) {
                $results[$type] = collect();
            }
        }

        return $results;
    }

    public function getTotalResultsProperty()
    {
        $results = $this->results;
        return array_sum(array_map(fn($collection) => $collection->count(), $results));
    }

    public function render()
    {
        return view('livewire.search.global-search', [
            'results' => $this->results,
            'totalResults' => $this->totalResults,
        ])->layout('components.layouts.app', [
            'title' => __('search.title') . ($this->query ? ': ' . $this->query : ''),
        ]);
    }
}

