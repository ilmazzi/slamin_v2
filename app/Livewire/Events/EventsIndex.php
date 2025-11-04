<?php

namespace App\Livewire\Events;

use Livewire\Component;
use App\Models\Event;
use App\Models\UnifiedLike;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EventsIndex extends Component
{
    public $search = '';
    public $city = '';
    public $type = '';
    public $quickFilter = '';
    public $dateFrom = '';
    public $dateTo = '';
    public $freeOnly = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'city' => ['except' => ''],
        'type' => ['except' => ''],
        'quickFilter' => ['except' => ''],
    ];

    public function mount()
    {
        // Initialize filters from query string
    }

    public function applyQuickFilter($filter)
    {
        $now = Carbon::now();
        
        switch($filter) {
            case 'today':
                $this->dateFrom = $now->format('Y-m-d');
                $this->dateTo = $now->format('Y-m-d');
                break;
            
            case 'tomorrow':
                $tomorrow = $now->copy()->addDay();
                $this->dateFrom = $tomorrow->format('Y-m-d');
                $this->dateTo = $tomorrow->format('Y-m-d');
                break;
            
            case 'weekend':
                $saturday = $now->copy()->next(Carbon::SATURDAY);
                $sunday = $saturday->copy()->addDay();
                $this->dateFrom = $saturday->format('Y-m-d');
                $this->dateTo = $sunday->format('Y-m-d');
                break;
            
            case 'free':
                $this->freeOnly = true;
                break;
            
            case 'my':
                $this->quickFilter = 'my';
                break;
            
            default:
                $this->dateFrom = '';
                $this->dateTo = '';
                $this->freeOnly = false;
                $this->quickFilter = '';
        }
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->city = '';
        $this->type = '';
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->freeOnly = false;
        $this->quickFilter = '';
    }

    public function getEventsProperty()
    {
        $query = Event::with(['organizer', 'venueOwner'])
            ->whereIn('status', [Event::STATUS_PUBLISHED, Event::STATUS_COMPLETED])
            ->where(function ($q) {
                $q->where('start_datetime', '>', Carbon::now())
                  ->orWhere('is_availability_based', true)
                  ->orWhere('status', Event::STATUS_COMPLETED);
            });

        // Search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhere('venue_name', 'like', '%' . $this->search . '%')
                  ->orWhere('city', 'like', '%' . $this->search . '%');
            });
        }

        // City filter
        if ($this->city) {
            $query->where('city', 'like', '%' . $this->city . '%');
        }

        // Type filter (public/private)
        if ($this->type) {
            $query->where('is_public', $this->type === 'public');
        }

        // Date range filter
        if ($this->dateFrom) {
            $query->whereDate('start_datetime', '>=', $this->dateFrom);
        }
        if ($this->dateTo) {
            $query->whereDate('start_datetime', '<=', $this->dateTo);
        }

        // Free events only
        if ($this->freeOnly) {
            $query->where(function($q) {
                $q->where('entry_fee', 0)->orWhereNull('entry_fee');
            });
        }

        // My events filter
        if ($this->quickFilter === 'my' && Auth::check()) {
            $query->where('organizer_id', Auth::id());
        }

        $events = $query->orderBy('start_datetime', 'asc')
                       ->withCount(['views', 'likes', 'comments'])
                       ->get();

        // Check if user has liked each event
        if (Auth::check()) {
            foreach ($events as $event) {
                $event->is_liked = UnifiedLike::where('user_id', Auth::id())
                    ->where('likeable_type', Event::class)
                    ->where('likeable_id', $event->id)
                    ->exists();
            }
        } else {
            foreach ($events as $event) {
                $event->is_liked = false;
            }
        }

        return $events;
    }

    public function getStatisticsProperty()
    {
        return [
            'total_events' => Event::whereIn('status', [Event::STATUS_PUBLISHED, Event::STATUS_COMPLETED])->count(),
            'public_events' => Event::where('is_public', true)
                                   ->whereIn('status', [Event::STATUS_PUBLISHED, Event::STATUS_COMPLETED])
                                   ->count(),
            'upcoming_events' => Event::where('start_datetime', '>', Carbon::now())
                                     ->where('status', Event::STATUS_PUBLISHED)
                                     ->count(),
            'venues_count' => Event::whereIn('status', [Event::STATUS_PUBLISHED, Event::STATUS_COMPLETED])
                                   ->distinct('venue_name')
                                   ->count('venue_name'),
        ];
    }

    public function getCitiesProperty()
    {
        return Event::whereIn('status', [Event::STATUS_PUBLISHED, Event::STATUS_COMPLETED])
                   ->whereNotNull('city')
                   ->distinct()
                   ->pluck('city')
                   ->filter()
                   ->sort()
                   ->values();
    }

    public function render()
    {
        return view('livewire.events.events-index', [
            'events' => $this->events,
            'statistics' => $this->statistics,
            'cities' => $this->cities,
        ])->layout('components.layouts.app');
    }
}
