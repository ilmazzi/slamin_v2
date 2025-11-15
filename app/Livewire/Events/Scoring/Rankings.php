<?php

namespace App\Livewire\Events\Scoring;

use Livewire\Component;
use App\Models\Event;
use App\Services\EventScoringService;

class Rankings extends Component
{
    public $event;
    public $isLocked = false;
    public $rankings;
    public $canCalculate = false;
    public $stats;

    public function mount(Event $event)
    {
        // Check permissions - only organizer or users who can organize events
        if (!auth()->check()) {
            abort(403, __('events.scoring.unauthorized'));
        }
        
        if (auth()->user()->id !== $event->organizer_id && !auth()->user()->canOrganizeEvents()) {
            abort(403, __('events.scoring.unauthorized'));
        }
        
        // Check if event is a Poetry Slam
        if ($event->category !== Event::CATEGORY_POETRY_SLAM) {
            abort(404, __('events.scoring.scoring_not_enabled'));
        }
        
        $this->event = $event;
        $this->isLocked = $event->status === Event::STATUS_COMPLETED;
        $this->loadRankings();
    }

    public function loadRankings()
    {
        $this->rankings = $this->event->rankings()
            ->with(['participant.user', 'badge'])
            ->ordered()
            ->get();

        // Check if we can calculate rankings
        // Need: participants with scores (rounds are configured in this phase)
        $this->canCalculate = $this->event->scores()->exists() && $this->event->participants()->whereIn('status', ['performed', 'confirmed'])->exists();

        // Load stats
        $this->stats = [
            'total_participants' => $this->event->participants()->count(),
            'with_scores' => $this->event->participants()
                ->whereHas('scores')
                ->count(),
            'total_scores' => $this->event->scores()->count(),
            'badges_awarded' => $this->rankings->where('badge_awarded', true)->count(),
        ];
    }

    public function calculatePartialRankings()
    {
        try {
            $scoringService = app(EventScoringService::class);
            $scoringService->calculateRankings($this->event);
            
            $this->loadRankings();
            session()->flash('success', __('events.scoring.partial_rankings_updated'));
        } catch (\Exception $e) {
            session()->flash('error', __('events.scoring.error_calculating') . ': ' . $e->getMessage());
        }
    }

    public function finalizeEvent()
    {
        if ($this->isLocked) {
            session()->flash('error', __('events.scoring.event_already_completed'));
            return;
        }
        
        try {
            $scoringService = app(EventScoringService::class);
            
            // 1. Calculate final rankings
            $scoringService->calculateRankings($this->event);
            
            // 2. Award badges to winners
            $badgesAwarded = $scoringService->awardBadgesToWinners($this->event);
            
            // 3. Mark event as completed
            $this->event->status = Event::STATUS_COMPLETED;
            $this->event->save();
            
            $this->isLocked = true;
            $this->loadRankings();
            
            session()->flash('success', __('events.scoring.event_completed_success', ['badges' => $badgesAwarded]));
            
        } catch (\Exception $e) {
            session()->flash('error', __('events.scoring.error') . ': ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.events.scoring.rankings')
            ->layout('components.layouts.app');
    }
}

