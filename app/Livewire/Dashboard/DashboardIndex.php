<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Poem;
use App\Models\Event;
use App\Models\Video;
use Carbon\Carbon;

class DashboardIndex extends Component
{
    public $currentMonth;
    public $currentYear;
    public $calendarEvents = [];
    
    // Mobile views
    public $currentView = 'month'; // list, week, month
    public $listPage = 1;
    public $weekPage = 0;
    
    // Calendar visibility
    public $calendarVisible = true;

    public function mount()
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        $this->loadCalendarData();
    }

    public function render()
    {
        $user = Auth::user();
        
        return view('livewire.dashboard.dashboard-index', [
            'user' => $user,
            'stats' => $this->getUserStats($user),
            'calendarData' => $this->getCalendarData(),
            'socialActivities' => $this->getSocialActivities($user),
            'quickActions' => $this->getQuickActions($user),
            'upcomingEvents' => $this->getUpcomingEvents($user),
            'recentActivity' => $this->getRecentActivity($user),
        ]);
    }
    
    private function getUpcomingEvents($user)
    {
        return Event::where('organizer_id', $user->id)
            ->where('start_datetime', '>=', now())
            ->orderBy('start_datetime', 'asc')
            ->take(3)
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'date' => $event->start_datetime->isoFormat('D MMMM YYYY'),
                    'time' => $event->start_datetime->format('H:i'),
                    'venue' => $event->venue_name ?? __('dashboard.online_event'),
                    'city' => $event->city,
                    'image' => $event->image_url,
                    'url' => route('events.show', $event),
                ];
            })
            ->toArray();
    }
    
    private function getRecentActivity($user)
    {
        // TODO: Implementare con dati reali quando disponibili
        return [
            [
                'type' => 'poem',
                'title' => __('dashboard.activity_published_poem'),
                'description' => 'Notte Stellata',
                'time' => '2 ore fa',
                'icon' => 'book',
            ],
            [
                'type' => 'event',
                'title' => __('dashboard.activity_created_event'),
                'description' => 'Poetry Slam Milano',
                'time' => '5 ore fa',
                'icon' => 'calendar',
            ],
            [
                'type' => 'like',
                'title' => __('dashboard.activity_received_likes'),
                'description' => '15 nuovi mi piace',
                'time' => '1 giorno fa',
                'icon' => 'heart',
            ],
        ];
    }
    
    private function getQuickActions($user)
    {
        return [
            [
                'icon' => 'ph-pen-nib',
                'title' => __('dashboard.write_poem'),
                'description' => __('dashboard.write_poem_description'),
                'url' => '#', // route('poems.create')
            ],
            [
                'icon' => 'ph-calendar-plus',
                'title' => __('dashboard.create_event'),
                'description' => __('dashboard.create_event_description'),
                'url' => '#', // route('events.create')
            ],
            [
                'icon' => 'ph-video-camera',
                'title' => __('dashboard.upload_video'),
                'description' => __('dashboard.upload_video_description'),
                'url' => '#', // route('videos.create')
            ],
            [
                'icon' => 'ph-compass',
                'title' => __('dashboard.explore_content'),
                'description' => __('dashboard.explore_content_description'),
                'url' => '#', // route('explore')
            ],
        ];
    }
    
    private function getSocialActivities($user)
    {
        // TODO: Implementare con dati reali quando saranno disponibili i modelli
        return [
            [
                'icon' => 'ph-user-circle',
                'title' => __('dashboard.online_friends'),
                'description' => __('dashboard.friends_active_now', ['count' => 3]),
                'count' => 3,
                'color' => 'primary',
                'url' => '#', // route('friends.index')
            ],
            [
                'icon' => 'ph-users-three',
                'title' => __('dashboard.active_groups'),
                'description' => __('dashboard.groups_with_activities', ['count' => 2]),
                'count' => 2,
                'color' => 'accent',
                'url' => '#', // route('groups.index')
            ],
            [
                'icon' => 'ph-envelope',
                'title' => __('dashboard.received_invitations'),
                'description' => __('dashboard.invitations_to_reply', ['count' => 1]),
                'count' => 1,
                'color' => 'warning',
                'url' => '#', // route('events.invitations')
            ],
            [
                'icon' => 'ph-chat-circle',
                'title' => __('dashboard.messages'),
                'description' => __('dashboard.unread_messages', ['count' => 5]),
                'count' => 5,
                'color' => 'info',
                'url' => '#', // route('messages.index')
            ],
        ];
    }

    private function getUserStats($user)
    {
        return [
            // Eventi
            'organized_events' => Event::where('organizer_id', $user->id)->count(),
            'upcoming_events' => Event::where('organizer_id', $user->id)
                ->where('start_datetime', '>=', now())
                ->count(),
            'past_events' => Event::where('organizer_id', $user->id)
                ->where('start_datetime', '<', now())
                ->count(),
            
            // Poesie
            'total_poems' => Poem::where('user_id', $user->id)->count(),
            'published_poems' => Poem::where('user_id', $user->id)
                ->where('is_public', true)
                ->where('is_draft', false)
                ->count(),
            'draft_poems' => Poem::where('user_id', $user->id)
                ->where('is_draft', true)
                ->count(),
            
            // Video
            'total_videos' => Video::where('user_id', $user->id)->count(),
            'total_views' => Poem::where('user_id', $user->id)->sum('view_count') +
                           Video::where('user_id', $user->id)->sum('view_count'),
            'total_likes' => Poem::where('user_id', $user->id)->sum('like_count') +
                           Video::where('user_id', $user->id)->sum('like_count'),
            
            // Engagement
            'member_since' => $user->created_at->diffForHumans(),
            'days_active' => $user->created_at->diffInDays(now()),
        ];
    }

    public function loadCalendarData()
    {
        $user = Auth::user();
        $startDate = Carbon::create($this->currentYear, $this->currentMonth, 1)->startOfMonth();
        $endDate = Carbon::create($this->currentYear, $this->currentMonth, 1)->endOfMonth();

        $events = Event::where('organizer_id', $user->id)
            ->whereBetween('start_datetime', [$startDate, $endDate])
            ->where('is_public', true)
            ->get();

        $this->calendarEvents = $events->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start_datetime->format('Y-m-d'),
                'time' => $event->start_datetime->format('H:i'),
                'type' => 'organized',
                'color' => 'primary',
                'image' => $event->image_url ?? null,
                'location' => $event->venue_name ?? $event->city ?? null,
                'url' => route('events.show', $event),
            ];
        })->toArray();
    }

    private function getCalendarData()
    {
        $firstDay = Carbon::create($this->currentYear, $this->currentMonth, 1)->startOfMonth();
        $lastDay = Carbon::create($this->currentYear, $this->currentMonth, 1)->endOfMonth();
        $startDay = $firstDay->copy()->startOfWeek()->addDay(); // Lunedì
        $endDay = $lastDay->copy()->endOfWeek()->addDay();
        
        $weeks = [];
        $currentDate = $startDay->copy();
        
        while ($currentDate->lte($endDay)) {
            $week = [];
            for ($i = 0; $i < 7; $i++) {
                $dayEvents = collect($this->calendarEvents)
                    ->where('start', $currentDate->format('Y-m-d'))
                    ->values();
                
                $week[] = [
                    'date' => $currentDate->copy(),
                    'isCurrentMonth' => $currentDate->month == $this->currentMonth,
                    'isToday' => $currentDate->isToday(),
                    'events' => $dayEvents,
                ];
                
                $currentDate->addDay();
            }
            $weeks[] = $week;
        }
        
        return [
            'weeks' => $weeks,
            'monthName' => $firstDay->locale(app()->getLocale())->isoFormat('MMMM YYYY'),
        ];
    }

    public function previousMonth()
    {
        $this->currentMonth--;
        if ($this->currentMonth < 1) {
            $this->currentMonth = 12;
            $this->currentYear--;
        }
        $this->loadCalendarData();
    }

    public function nextMonth()
    {
        $this->currentMonth++;
        if ($this->currentMonth > 12) {
            $this->currentMonth = 1;
            $this->currentYear++;
        }
        $this->loadCalendarData();
    }
    
    public function getCalendarDataProperty()
    {
        return $this->getCalendarData();
    }
    
    // Mobile view switching
    public function switchView($view)
    {
        $this->currentView = $view;
        $this->listPage = 1;
        $this->weekPage = 0;
    }
    
    public function nextListPage()
    {
        $this->listPage++;
    }
    
    public function previousListPage()
    {
        if ($this->listPage > 1) {
            $this->listPage--;
        }
    }
    
    public function nextWeek()
    {
        $this->weekPage++;
    }
    
    public function previousWeek()
    {
        $this->weekPage--;
    }
    
    public function toggleCalendar()
    {
        $this->calendarVisible = !$this->calendarVisible;
    }
}
