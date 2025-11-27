<?php

namespace App\Livewire\Events\Scoring;

use Livewire\Component;
use App\Models\Event;
use App\Models\EventRound;
use App\Models\EventScore;
use App\Models\EventParticipant;

class ScoreEntry extends Component
{
    public $event;
    public $isLocked = false;
    public $rounds;
    public $participants;
    public $selectedRound = 1;
    
    // Round management
    public $showRoundModal = false;
    public $editingRound = null;
    public $round_number;
    public $round_name;
    public $scoring_type = 'average';

    // Score entry
    public $scores = []; // [participant_id => score_value]

    public function mount(Event $event)
    {
        // Check permissions
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
        $this->loadData();
    }

    public function loadData()
    {
        $this->rounds = $this->event->rounds()->ordered()->get();
        
        // Sync accepted invitations with participants (create missing participants)
        $this->syncAcceptedInvitationsToParticipants();
        
        // Get all participants with confirmed/performed status
        $allParticipants = $this->event->participants()
            ->whereIn('status', ['confirmed', 'performed'])
            ->get();
        
        // Filter to show only participants who have accepted invitations as performers/artists
        $this->participants = $allParticipants->filter(function($participant) {
            // If participant is a guest (no user_id), include them
            if ($participant->isGuest()) {
                return true;
            }
            
            // For registered users, check if they have an accepted invitation with role 'performer'
            $acceptedInvitation = $this->event->invitations()
                ->where('invited_user_id', $participant->user_id)
                ->where('status', 'accepted')
                ->where('role', 'performer')
                ->first();
            
            return $acceptedInvitation !== null;
        })->sortBy('performance_order')->values();
        
        // Load existing scores for selected round
        $this->loadScoresForRound();
        
        // Auto-create first round if none exist
        if ($this->rounds->count() === 0) {
            $this->createDefaultRound();
        }
    }

    /**
     * Sync accepted invitations to participants (create missing EventParticipant records)
     */
    private function syncAcceptedInvitationsToParticipants()
    {
        $acceptedInvitations = $this->event->invitations()
            ->where('status', 'accepted')
            ->where('role', 'performer')
            ->get();
        
        foreach ($acceptedInvitations as $invitation) {
            $existingParticipant = \App\Models\EventParticipant::where('event_id', $this->event->id)
                ->where('user_id', $invitation->invited_user_id)
                ->first();
            
            if (!$existingParticipant) {
                \App\Models\EventParticipant::create([
                    'event_id' => $this->event->id,
                    'user_id' => $invitation->invited_user_id,
                    'registration_type' => 'invited',
                    'status' => 'confirmed',
                    'added_by' => $invitation->inviter_id,
                ]);
            }
        }
    }

    public function loadScoresForRound()
    {
        $existingScores = EventScore::where('event_id', $this->event->id)
            ->where('round', $this->selectedRound)
            ->get()
            ->keyBy('participant_id');

        $this->scores = [];
        foreach ($this->participants as $participant) {
            $this->scores[$participant->id] = $existingScores->get($participant->id)?->score ?? '';
        }
    }

    public function updatedSelectedRound()
    {
        $this->loadScoresForRound();
    }

    public function saveScore($participantId)
    {
        if ($this->isLocked) {
            $this->dispatch('swal:error', ['title' => __('events.scoring.error'), 'text' => __('events.scoring.cannot_modify_scores_event_completed')]);
            return;
        }
        
        $score = $this->scores[$participantId] ?? null;
        
        if ($score === '' || $score === null) {
            return;
        }

        // Validate score is a valid number (no upper limit)
        if (!is_numeric($score) || $score < 0) {
            $this->dispatch('swal:warning', ['title' => __('events.scoring.error'), 'text' => __('events.scoring.score_must_be_positive')]);
            return;
        }

        EventScore::updateOrCreate(
            [
                'event_id' => $this->event->id,
                'participant_id' => $participantId,
                'round' => $this->selectedRound,
                'judge_id' => auth()->id(),
            ],
            [
                'score' => round($score, 1),
                'scored_at' => now(),
            ]
        );

        $this->dispatch('swal:success', ['title' => __('events.scoring.saved'), 'text' => __('events.scoring.score_saved')]);
    }

    public function createDefaultRound()
    {
        EventRound::create([
            'event_id' => $this->event->id,
            'round_number' => 1,
            'name' => __('events.scoring.single_round'),
            'scoring_type' => 'average',
            'order' => 1,
        ]);
        
        $this->loadData();
    }

    public function openRoundModal()
    {
        $this->resetRoundForm();
        $this->editingRound = null;
        $this->showRoundModal = true;
    }

    public function editRound($roundId)
    {
        $round = EventRound::findOrFail($roundId);
        $this->editingRound = $round;
        $this->round_number = $round->round_number;
        $this->round_name = $round->name;
        $this->scoring_type = $round->scoring_type;
        $this->showRoundModal = true;
    }

    public function saveRound()
    {
        if ($this->isLocked) {
            $this->dispatch('swal:error', ['title' => __('events.scoring.error'), 'text' => __('events.scoring.cannot_modify_rounds_event_completed')]);
            return;
        }
        
        $this->validate([
            'round_number' => 'required|integer|min:1',
            'round_name' => 'required|string|max:255',
            'scoring_type' => 'required|in:average,sum,best_of,elimination',
        ]);

        $data = [
            'event_id' => $this->event->id,
            'round_number' => $this->round_number,
            'name' => $this->round_name,
            'scoring_type' => $this->scoring_type,
            'order' => $this->round_number,
        ];

        if ($this->editingRound) {
            $this->editingRound->update($data);
        } else {
            EventRound::create($data);
        }

        $this->dispatch('swal:success', ['title' => __('events.scoring.saved'), 'text' => __('events.scoring.round_saved_successfully')]);
        $this->showRoundModal = false;
        $this->loadData();
    }

    public function deleteRound($roundId)
    {
        if ($this->isLocked) {
            $this->dispatch('swal:error', ['title' => __('events.scoring.error'), 'text' => __('events.scoring.cannot_delete_rounds_event_completed')]);
            return;
        }
        
        $round = EventRound::findOrFail($roundId);
        $round->delete();
        
        $this->dispatch('swal:success', ['title' => __('events.scoring.deleted'), 'text' => __('events.scoring.round_deleted')]);
        $this->loadData();
    }

    private function resetRoundForm()
    {
        $this->round_number = ($this->rounds->max('round_number') ?? 0) + 1;
        $this->round_name = '';
        $this->scoring_type = 'average';
    }

    public function render()
    {
        return view('livewire.events.scoring.score-entry')
            ->layout('components.layouts.app');
    }
}

