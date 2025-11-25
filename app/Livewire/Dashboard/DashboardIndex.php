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
        $activities = [];
        
        // Poesie pubblicate recentemente dall'utente
        $recentPoems = Poem::where('user_id', $user->id)
            ->where('is_public', true)
            ->where('is_draft', false)
            ->latest()
            ->take(3)
            ->get();
        
        foreach ($recentPoems as $poem) {
            $activities[] = [
                'type' => 'poem',
                'id' => $poem->id,
                'slug' => $poem->slug,
                'title' => __('dashboard.activity_published_poem'),
                'description' => $poem->title ?: __('poems.untitled'),
                'time' => $poem->created_at->diffForHumans(),
                'icon' => 'book',
                'url' => null, // Usa evento Livewire invece di route
            ];
        }
        
        // Eventi creati recentemente dall'utente
        $recentEvents = Event::where('organizer_id', $user->id)
            ->latest()
            ->take(2)
            ->get();
        
        foreach ($recentEvents as $event) {
            $activities[] = [
                'type' => 'event',
                'id' => $event->id,
                'title' => __('dashboard.activity_created_event'),
                'description' => $event->title,
                'time' => $event->created_at->diffForHumans(),
                'icon' => 'calendar',
                'url' => route('events.show', $event),
            ];
        }
        
        // Ordina per data di creazione (più recenti prima) e prendi i primi 5
        usort($activities, function($a, $b) {
            // Estrai la data dal tempo relativo (approssimativo)
            // Per semplicità, ordina per ordine di inserimento
            return 0;
        });
        
        $activities = array_slice($activities, 0, 5);
        
        // Se non ci sono attività reali, mostra placeholder
        if (empty($activities)) {
            return [
                [
                    'type' => 'placeholder',
                    'title' => __('dashboard.no_recent_activity'),
                    'description' => __('dashboard.explore_content_description'),
                    'time' => '',
                    'icon' => 'compass',
                    'url' => route('poems.index'),
                ],
            ];
        }
        
        return $activities;
    }
    
    private function getQuickActions($user)
    {
        $actions = [];
        
        // Scrivere poesie
        if ($user->canCreatePoem()) {
            $actions[] = [
                'icon' => 'ph-pen-nib',
                'title' => __('dashboard.write_poem'),
                'description' => __('dashboard.write_poem_description'),
                'url' => route('poems.create'),
            ];
        }
        
        // Creare eventi
        if ($user->canCreateEvent()) {
            $actions[] = [
                'icon' => 'ph-calendar-plus',
                'title' => __('dashboard.create_event'),
                'description' => __('dashboard.create_event_description'),
                'url' => route('events.create'),
            ];
        }
        
        // Caricare video
        if ($user->canUploadVideo()) {
            $actions[] = [
                'icon' => 'ph-video-camera',
                'title' => __('dashboard.upload_video'),
                'description' => __('dashboard.upload_video_description'),
                'url' => route('media.upload.video'),
            ];
        }
        
        return $actions;
    }
    
    private function getSocialActivities($user)
    {
        // Conta gruppi attivi (se il modello esiste)
        $activeGroupsCount = 0;
        if (class_exists(\App\Models\Group::class)) {
            try {
                $activeGroupsCount = \App\Models\Group::whereHas('members', function($query) use ($user) {
                    $query->where('user_id', $user->id);
                })->count();
            } catch (\Exception $e) {
                // Se la relazione non esiste, usa 0
                $activeGroupsCount = 0;
            }
        }
        
        // Conta inviti ricevuti (group invitations) - anche inviti eventi
        $invitationsCount = 0;
        if (class_exists(\App\Models\GroupInvitation::class)) {
            try {
                $invitationsCount = \App\Models\GroupInvitation::where('user_id', $user->id)
                    ->where('status', 'pending')
                    ->count();
            } catch (\Exception $e) {
                // Se il modello non esiste, usa 0
            }
        }
        
        // Aggiungi anche gli inviti agli eventi
        try {
            $eventInvitationsCount = \App\Models\EventInvitation::where('invited_user_id', $user->id)
                ->where('status', 'pending')
                ->count();
            $invitationsCount += $eventInvitationsCount;
        } catch (\Exception $e) {
            // Ignora se non esiste
        }
        
        // Conta messaggi non letti (da implementare quando sarà disponibile il sistema di chat completo)
        $unreadMessagesCount = 0; // TODO: Implementare quando sarà disponibile
        
        return [
            [
                'icon' => 'ph-user-circle',
                'title' => __('dashboard.online_friends'),
                'description' => __('dashboard.friends_active_now', ['count' => 0]),
                'count' => 0,
                'color' => 'primary',
                'url' => 'javascript:void(0)', // TODO: Implementare quando sarà disponibile il sistema di amicizie
            ],
            [
                'icon' => 'ph-users-three',
                'title' => __('dashboard.active_groups'),
                'description' => __('dashboard.groups_with_activities', ['count' => $activeGroupsCount]),
                'count' => $activeGroupsCount,
                'color' => 'accent',
                'url' => route('groups.index'),
            ],
            [
                'icon' => 'ph-envelope',
                'title' => __('dashboard.received_invitations'),
                'description' => __('dashboard.invitations_to_reply', ['count' => $invitationsCount]),
                'count' => $invitationsCount,
                'color' => 'warning',
                'url' => route('group-invitations.index'),
            ],
            [
                'icon' => 'ph-chat-circle',
                'title' => __('dashboard.messages'),
                'description' => __('dashboard.unread_messages', ['count' => $unreadMessagesCount]),
                'count' => $unreadMessagesCount,
                'color' => 'info',
                'url' => route('chat.index'),
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
