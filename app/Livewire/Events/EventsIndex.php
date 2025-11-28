<?php

namespace App\Livewire\Events;

use Livewire\Component;
use App\Models\Event;
use App\Models\UnifiedLike;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
                $this->quickFilter = '';
                break;
            
            case 'tomorrow':
                $tomorrow = $now->copy()->addDay();
                $this->dateFrom = $tomorrow->format('Y-m-d');
                $this->dateTo = $tomorrow->format('Y-m-d');
                $this->quickFilter = '';
                break;
            
            case 'weekend':
                $saturday = $now->copy()->next(Carbon::SATURDAY);
                $sunday = $saturday->copy()->addDay();
                $this->dateFrom = $saturday->format('Y-m-d');
                $this->dateTo = $sunday->format('Y-m-d');
                $this->quickFilter = '';
                break;
            
            case 'free':
                $this->freeOnly = true;
                $this->quickFilter = '';
                break;
            
            case 'past':
                $this->quickFilter = 'past';
                $this->dateFrom = '';
                $this->dateTo = '';
                $this->freeOnly = false;
                break;
            
            case 'my':
                $this->quickFilter = 'my';
                $this->dateFrom = '';
                $this->dateTo = '';
                $this->freeOnly = false;
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

    public function hasActiveFilters()
    {
        return !empty($this->search) 
            || !empty($this->city) 
            || !empty($this->type) 
            || !empty($this->dateFrom) 
            || !empty($this->dateTo) 
            || $this->freeOnly 
            || !empty($this->quickFilter);
    }

    public function getEventsProperty()
    {
        $query = Event::with(['organizer', 'venueOwner'])
            ->whereIn('status', [Event::STATUS_PUBLISHED, Event::STATUS_COMPLETED]);
        
        // Events are visible until end_datetime + 6 hours
        $visibilityCutoff = Carbon::now()->subHours(6);
        
        // Filter by past events if selected
        if ($this->quickFilter === 'past') {
            $query->where(function ($q) use ($visibilityCutoff) {
                $q->where(function ($q1) use ($visibilityCutoff) {
                    $q1->whereNotNull('end_datetime')
                       ->where('end_datetime', '<', $visibilityCutoff);
                })
                  ->orWhere(function ($q2) use ($visibilityCutoff) {
                      $q2->where('status', Event::STATUS_COMPLETED)
                         ->whereNotNull('end_datetime')
                         ->where('end_datetime', '<', $visibilityCutoff);
                  });
            });
        } else {
            // Default: show upcoming events (including events that ended less than 6 hours ago)
            $query->where(function ($q) use ($visibilityCutoff) {
                $q->where('start_datetime', '>', Carbon::now())
                  ->orWhere('is_availability_based', true)
                  ->orWhere(function ($q2) use ($visibilityCutoff) {
                      $q2->whereNotNull('end_datetime')
                         ->where('end_datetime', '>=', $visibilityCutoff);
                  });
            });
        }

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

    public function getUpcomingEventsProperty()
    {
        $events = Event::with(['organizer', 'venueOwner'])
            ->whereIn('status', [Event::STATUS_PUBLISHED, Event::STATUS_COMPLETED])
            ->where('start_datetime', '>', Carbon::now())
            ->orderBy('start_datetime', 'asc')
            ->limit(10)
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

    /**
     * Get today's events for timeline
     */
    public function getTodayEventsTimelineProperty()
    {
        $now = Carbon::now();
        $startOfToday = $now->copy()->startOfDay();
        $endOfToday = $now->copy()->endOfDay();
        
        $events = Event::with(['organizer', 'venueOwner'])
            ->whereIn('status', [Event::STATUS_PUBLISHED, Event::STATUS_COMPLETED])
            ->where(function ($q) use ($startOfToday, $endOfToday) {
                $q->whereBetween('start_datetime', [$startOfToday, $endOfToday])
                  ->orWhere(function ($q2) use ($startOfToday, $endOfToday) {
                      $q2->whereNotNull('end_datetime')
                         ->whereBetween('end_datetime', [$startOfToday, $endOfToday]);
                  })
                  ->orWhere(function ($q3) use ($startOfToday, $endOfToday) {
                      $q3->where('start_datetime', '<=', $startOfToday)
                         ->where(function ($q4) use ($endOfToday) {
                             $q4->whereNull('end_datetime')
                                ->orWhere('end_datetime', '>=', $endOfToday);
                         });
                  });
            })
            ->orderBy('start_datetime', 'asc')
            ->withCount(['views', 'likes', 'comments'])
            ->get();

        // Load rankings for Poetry Slam events
        foreach ($events as $event) {
            if ($event->category === Event::CATEGORY_POETRY_SLAM) {
                $event->load(['rankings' => function($query) {
                    $query->where('position', '<=', 3)
                          ->with(['participant.user', 'badge'])
                          ->ordered();
                }]);
            }
        }

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

    /**
     * Get upcoming events for timeline (ordered by start_datetime ASC - closest first)
     * Excludes today's events
     */
    public function getUpcomingEventsTimelineProperty()
    {
        $now = Carbon::now();
        $endOfToday = $now->copy()->endOfDay();
        $visibilityCutoff = $now->copy()->subHours(6);
        
        $events = Event::with(['organizer', 'venueOwner'])
            ->whereIn('status', [Event::STATUS_PUBLISHED, Event::STATUS_COMPLETED])
            ->where(function ($q) use ($endOfToday, $visibilityCutoff) {
                $q->where('start_datetime', '>', $endOfToday)
                  ->orWhere(function ($q2) use ($endOfToday, $visibilityCutoff) {
                      $q2->whereNotNull('end_datetime')
                         ->where('end_datetime', '>=', $visibilityCutoff)
                         ->where('start_datetime', '>', $endOfToday);
                  })
                  ->orWhere(function ($q3) use ($endOfToday) {
                      $q3->where('is_availability_based', true)
                         ->where('start_datetime', '>', $endOfToday);
                  });
            })
            ->orderBy('start_datetime', 'asc') // Più vicino a sinistra
            ->withCount(['views', 'likes', 'comments'])
            ->get();

        // Load rankings for Poetry Slam events
        foreach ($events as $event) {
            if ($event->category === Event::CATEGORY_POETRY_SLAM) {
                $event->load(['rankings' => function($query) {
                    $query->where('position', '<=', 3)
                          ->with(['participant.user', 'badge'])
                          ->ordered();
                }]);
            }
        }

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

    /**
     * Get past events for timeline (ordered by end_datetime DESC - most recent first)
     * Excludes today's events
     */
    public function getPastEventsTimelineProperty()
    {
        $now = Carbon::now();
        $startOfToday = $now->copy()->startOfDay();
        $visibilityCutoff = $now->copy()->subHours(6);
        
        $events = Event::with(['organizer', 'venueOwner'])
            ->whereIn('status', [Event::STATUS_PUBLISHED, Event::STATUS_COMPLETED])
            ->where(function ($q) use ($visibilityCutoff) {
                $q->where(function ($q2) use ($visibilityCutoff) {
                      $q2->whereNotNull('end_datetime')
                         ->where('end_datetime', '<', $visibilityCutoff);
                  })
                  ->orWhere(function ($q3) use ($visibilityCutoff) {
                      $q3->where('status', Event::STATUS_COMPLETED)
                         ->whereNotNull('end_datetime')
                         ->where('end_datetime', '<', $visibilityCutoff);
                  });
            })
            ->orderBy('end_datetime', 'desc') // Più recente a sinistra
            ->withCount(['views', 'likes', 'comments'])
            ->get();

        // Load rankings for Poetry Slam events
        foreach ($events as $event) {
            if ($event->category === Event::CATEGORY_POETRY_SLAM) {
                $event->load(['rankings' => function($query) {
                    $query->where('position', '<=', 3)
                          ->with(['participant.user', 'badge'])
                          ->ordered();
                }]);
            }
        }

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

    public function getPersonalizedEventsProperty()
    {
        if (!Auth::check()) {
            return collect([]);
        }

        $user = Auth::user();
        $eventIds = collect([]);

        // 1. Eventi creati dall'utente (organizer)
        $createdEventIds = Event::where('organizer_id', $user->id)
            ->whereIn('status', [Event::STATUS_PUBLISHED, Event::STATUS_COMPLETED])
            ->pluck('id');

        // 2. Eventi ai quali l'utente partecipa
        $participatingEventIds = DB::table('event_participants')
            ->where('user_id', $user->id)
            ->where('status', 'confirmed')
            ->pluck('event_id');

        // 3. Eventi nella wishlist dell'utente
        $wishlistEventIds = $user->wishlistedEvents()
            ->whereIn('status', [Event::STATUS_PUBLISHED, Event::STATUS_COMPLETED])
            ->pluck('events.id');

        // 4. Utenti che l'utente segue
        $followingIds = $user->following()->pluck('following_id');

        if ($followingIds->isNotEmpty()) {
            // 5. Eventi ai quali partecipano gli utenti che segue
            $followingParticipatingEventIds = DB::table('event_participants')
                ->whereIn('user_id', $followingIds)
                ->where('status', 'confirmed')
                ->pluck('event_id');

            // 6. Eventi nella wishlist degli utenti che segue
            $followingWishlistEventIds = DB::table('wishlists')
                ->whereIn('user_id', $followingIds)
                ->pluck('event_id');

            $eventIds = $eventIds
                ->merge($createdEventIds)
                ->merge($participatingEventIds)
                ->merge($wishlistEventIds)
                ->merge($followingParticipatingEventIds)
                ->merge($followingWishlistEventIds)
                ->unique();
        } else {
            $eventIds = $eventIds
                ->merge($createdEventIds)
                ->merge($participatingEventIds)
                ->merge($wishlistEventIds)
                ->unique();
        }

        if ($eventIds->isEmpty()) {
            return collect([]);
        }

        $events = Event::with(['organizer', 'venueOwner'])
            ->whereIn('id', $eventIds)
            ->whereIn('status', [Event::STATUS_PUBLISHED, Event::STATUS_COMPLETED])
            ->where(function ($q) {
                $q->where('start_datetime', '>', Carbon::now())
                  ->orWhere('is_availability_based', true);
            })
            ->orderBy('start_datetime', 'asc')
            ->withCount(['views', 'likes', 'comments'])
            ->get();

        // Check if user has liked each event
        foreach ($events as $event) {
            $event->is_liked = UnifiedLike::where('user_id', Auth::id())
                ->where('likeable_type', Event::class)
                ->where('likeable_id', $event->id)
                ->exists();
        }

        return $events;
    }

    public function getMapDataProperty()
    {
        return $this->events
            ->filter(fn($e) => $e->latitude && $e->longitude)
            ->values()
            ->map(function($e) {
                // Render ticket component to HTML
                $ticketHtml = view('components.event-ticket', ['event' => $e])->render();
                
                return [
                    'id' => $e->id,
                    'title' => $e->title,
                    'category' => $e->category,
                    'city' => $e->city,
                    'venue_name' => $e->venue_name,
                    'start_datetime' => $e->start_datetime ? $e->start_datetime->format('d M Y H:i') : 'Data da definire',
                    'latitude' => floatval($e->latitude),
                    'longitude' => floatval($e->longitude),
                    'image_url' => $e->image_url,
                    'url' => route('events.show', $e->id),
                    'ticket_html' => $ticketHtml
                ];
            });
    }

    public function render()
    {
        return view('livewire.events.events-index', [
            'events' => $this->events,
            'upcomingEvents' => $this->upcomingEvents,
            'todayEventsTimeline' => $this->todayEventsTimeline,
            'upcomingEventsTimeline' => $this->upcomingEventsTimeline,
            'pastEventsTimeline' => $this->pastEventsTimeline,
            'personalizedEvents' => $this->personalizedEvents,
            'statistics' => $this->statistics,
            'cities' => $this->cities,
            'mapData' => $this->mapData,
            'hasActiveFilters' => $this->hasActiveFilters(),
        ])->layout('components.layouts.app');
    }
}
