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
    public $showParticipantSelectionModal = false;
    public $editingRound = null;
    public $round_number;
    public $round_name;
    public $scoring_type = 'average';
    public $selectedParticipants = []; // For participant selection when creating new round

    // Score entry
    public $scores = []; // [participant_id => [judge_number => score_value]]
    public $savedScores = []; // Track which participants have all scores saved [participant_id => true]
    public $sortBy = 'performance_order'; // 'performance_order', 'name', 'score'
    public $sortDirection = 'asc';

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
        $baseParticipants = $allParticipants->filter(function($participant) {
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
        });
        
        // For rounds after the first, filter participants based on selected_participants or scores
        if ($this->selectedRound > 1) {
            $currentRound = $this->rounds->where('round_number', $this->selectedRound)->first();
            
            if ($currentRound && $currentRound->selected_participants) {
                // Use selected participants if available
                $this->participants = $baseParticipants->filter(function($participant) use ($currentRound) {
                    return in_array($participant->id, $currentRound->selected_participants);
                });
            } else {
                // Fallback: use participants who have scores in previous round
                $previousRound = $this->selectedRound - 1;
                $participantIdsWithScores = EventScore::where('event_id', $this->event->id)
                    ->where('round', $previousRound)
                    ->pluck('participant_id')
                    ->unique()
                    ->toArray();
                
                $this->participants = $baseParticipants->filter(function($participant) use ($participantIdsWithScores) {
                    return in_array($participant->id, $participantIdsWithScores);
                });
            }
        } else {
            $this->participants = $baseParticipants;
        }
        
        // Apply sorting
        $this->applySorting();
        
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

    public $participantScores = []; // [participant_id => [scores with judge info]]
    
    public function loadScoresForRound()
    {
        $currentRound = $this->rounds->where('round_number', $this->selectedRound)->first();
        $judgesCount = $currentRound ? ($currentRound->judges_count ?? 5) : 5;
        
        // Load all scores for this round
        $allScores = EventScore::where('event_id', $this->event->id)
            ->where('round', $this->selectedRound)
            ->get()
            ->groupBy('participant_id');

        // Preserve unsaved scores (don't reset the entire array)
        $unsavedScores = $this->scores;
        
        $this->scores = [];
        $this->savedScores = [];
        $this->participantScores = [];
        
        foreach ($this->participants as $participant) {
            $participantScoresList = $allScores->get($participant->id, collect());
            
            // Initialize scores array for this participant [judge_number => score]
            $this->scores[$participant->id] = [];
            for ($i = 1; $i <= $judgesCount; $i++) {
                $existingScore = $participantScoresList->firstWhere('judge_number', $i);
                // Preserve unsaved value if exists, otherwise use saved score
                $this->scores[$participant->id][$i] = $unsavedScores[$participant->id][$i] ?? $existingScore?->score ?? '';
            }
            
            // Check if all scores are saved
            $allSaved = $participantScoresList->count() >= $judgesCount;
            $this->savedScores[$participant->id] = $allSaved;
            
            // Store all scores for display
            $this->participantScores[$participant->id] = $participantScoresList->sortBy('judge_number')->map(function($score) {
                return [
                    'id' => $score->id,
                    'score' => $score->score,
                    'judge_number' => $score->judge_number ?? 0,
                    'scored_at' => $score->scored_at,
                ];
            })->values();
        }
    }

    public function updatedSelectedRound()
    {
        $this->loadData(); // Reload participants for the selected round
    }

    public function saveScores($participantId)
    {
        if ($this->isLocked) {
            $this->dispatch('swal:error', ['title' => __('events.scoring.error'), 'text' => __('events.scoring.cannot_modify_scores_event_completed')]);
            return;
        }
        
        $currentRound = $this->rounds->where('round_number', $this->selectedRound)->first();
        $judgesCount = $currentRound ? ($currentRound->judges_count ?? 5) : 5;
        
        if (!isset($this->scores[$participantId])) {
            $this->scores[$participantId] = [];
        }
        
        $participantScores = $this->scores[$participantId];
        
        $hasScores = false;
        foreach ($participantScores as $score) {
            if ($score !== '' && $score !== null && $score !== '0' && $score !== 0 && is_numeric($score)) {
                $hasScores = true;
                break;
            }
        }
        
        if (!$hasScores) {
            $this->dispatch('swal:warning', [
                'title' => __('events.scoring.warning'),
                'text' => 'Nessun voto da salvare. Inserisci almeno un voto.'
            ]);
            return;
        }

        $savedCount = 0;
        $errors = [];

        // Save all scores for this participant
        foreach ($participantScores as $judgeNumber => $score) {
            if ($score === '' || $score === null || $score === '0' || $score === 0) {
                continue; // Skip empty or zero scores
            }

            // Convert to numeric if it's a string
            $score = is_string($score) ? (float) $score : $score;

            // Validate score is a valid number (no upper limit, but must be positive)
            if (!is_numeric($score) || $score < 0) {
                $errors[] = __('events.scoring.judge') . ' ' . $judgeNumber . ': ' . __('events.scoring.score_must_be_positive');
                continue;
            }

            try {
                EventScore::updateOrCreate(
                    [
                        'event_id' => $this->event->id,
                        'participant_id' => $participantId,
                        'round' => $this->selectedRound,
                        'judge_number' => $judgeNumber,
                    ],
                    [
                        'judge_id' => auth()->id(), // User who entered the scores
                        'score' => round((float) $score, 1),
                        'scored_at' => now(),
                    ]
                );
                
                $savedCount++;
            } catch (\Exception $e) {
                $errors[] = __('events.scoring.judge') . ' ' . $judgeNumber . ': ' . $e->getMessage();
            }
        }

        // Reload scores to show updated list
        $this->loadScoresForRound();
        
        // Mark as saved if all scores are filled
        $filledCount = count(array_filter($participantScores, function($s) { return $s !== '' && $s !== null; }));
        $this->savedScores[$participantId] = $filledCount >= $judgesCount;

        $participantName = $this->participants->firstWhere('id', $participantId)?->display_name ?? '';
        
        if (!empty($errors)) {
            $this->dispatch('swal:warning', [
                'title' => __('events.scoring.warning'), 
                'text' => implode("\n", $errors)
            ]);
        } else if ($savedCount > 0) {
            $message = __('events.scoring.scores_saved_successfully');
            $message = str_replace(':count', $savedCount, $message);
            $message = str_replace(':participant', $participantName, $message);
            
            $this->dispatch('swal:success', [
                'title' => __('events.scoring.saved'), 
                'text' => $message
            ]);
        } else {
            $this->dispatch('swal:warning', [
                'title' => __('events.scoring.warning'),
                'text' => __('events.scoring.no_scores_to_save', [], 'Nessun voto valido da salvare.')
            ]);
        }
    }

    public function createDefaultRound()
    {
        EventRound::create([
            'event_id' => $this->event->id,
            'round_number' => 1,
            'name' => __('events.scoring.single_round'),
            'scoring_type' => 'average',
            'judges_count' => 5,
            'order' => 1,
        ]);
        
        $this->loadData();
    }

    public function openRoundModal()
    {
        // If creating a new round (not editing), check if previous round has all scores
        if ($this->rounds->count() > 0) {
            $previousRound = $this->rounds->max('round_number');
            $previousRoundParticipants = $this->getParticipantsForRound($previousRound);
            $previousRoundScores = EventScore::where('event_id', $this->event->id)
                ->where('round', $previousRound)
                ->pluck('participant_id')
                ->unique()
                ->toArray();
            
            // Check if all participants have scores
            $participantsWithoutScores = $previousRoundParticipants->filter(function($participant) use ($previousRoundScores) {
                return !in_array($participant->id, $previousRoundScores);
            });
            
            if ($participantsWithoutScores->count() > 0) {
                $this->dispatch('swal:error', [
                    'title' => __('events.scoring.error'), 
                    'text' => __('events.scoring.cannot_create_round_participants_without_scores', ['count' => $participantsWithoutScores->count()])
                ]);
                return;
            }
            
            // Show participant selection modal for new round
            $this->prepareParticipantSelection($previousRound);
            $this->showParticipantSelectionModal = true;
            return;
        }
        
        $this->resetRoundForm();
        $this->editingRound = null;
        $this->showRoundModal = true;
    }
    
    private function getParticipantsForRound($roundNumber)
    {
        // For first round, return all participants
        if ($roundNumber == 1) {
            return $this->participants;
        }
        
        // For subsequent rounds, return participants who have scores in previous round
        $previousRound = $roundNumber - 1;
        $participantIdsWithScores = EventScore::where('event_id', $this->event->id)
            ->where('round', $previousRound)
            ->pluck('participant_id')
            ->unique()
            ->toArray();
        
        return $this->participants->filter(function($participant) use ($participantIdsWithScores) {
            return in_array($participant->id, $participantIdsWithScores);
        });
    }
    
    private function prepareParticipantSelection($previousRound)
    {
        // Get participants who have scores in the previous round
        $participantIdsWithScores = EventScore::where('event_id', $this->event->id)
            ->where('round', $previousRound)
            ->pluck('participant_id')
            ->unique()
            ->toArray();
        
        $participants = $this->event->participants()
            ->whereIn('id', $participantIdsWithScores)
            ->get();
        
        // Get average scores for each participant in the previous round
        $scores = EventScore::where('event_id', $this->event->id)
            ->where('round', $previousRound)
            ->get()
            ->groupBy('participant_id')
            ->map(function($scores) {
                return $scores->avg('score');
            });
        
        // Pre-select all participants by default
        $this->selectedParticipants = $participants->pluck('id')->toArray();
        
        // Store participants with scores for display
        $this->participantsWithScores = $participants->map(function($participant) use ($scores) {
            return [
                'id' => $participant->id,
                'name' => $participant->display_name,
                'score' => $scores->get($participant->id, 0),
            ];
        })->sortByDesc('score')->values();
    }
    
    public $participantsWithScores = [];

    public function editRound($roundId)
    {
        $round = EventRound::findOrFail($roundId);
        $this->editingRound = $round;
        $this->round_number = $round->round_number;
        $this->round_name = $round->name;
        $this->scoring_type = $round->scoring_type;
        $this->judges_count = $round->judges_count ?? 5;
        $this->showRoundModal = true;
    }

    public function confirmParticipantSelection()
    {
        if (empty($this->selectedParticipants)) {
            $this->dispatch('swal:warning', ['title' => __('events.scoring.warning'), 'text' => __('events.scoring.select_at_least_one_participant')]);
            return;
        }
        
        $this->showParticipantSelectionModal = false;
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
            'scoring_type' => 'required|in:average,sum,best_of,trimmed_mean,elimination',
            'judges_count' => 'required|integer|min:1|max:20',
        ]);

        $data = [
            'event_id' => $this->event->id,
            'round_number' => $this->round_number,
            'name' => $this->round_name,
            'scoring_type' => $this->scoring_type,
            'judges_count' => $this->judges_count,
            'order' => $this->round_number,
        ];

        if ($this->editingRound) {
            $this->editingRound->update($data);
        } else {
            // Store selected participants for this round
            $data['selected_participants'] = $this->selectedParticipants;
            EventRound::create($data);
        }

        $this->dispatch('swal:success', ['title' => __('events.scoring.saved'), 'text' => __('events.scoring.round_saved_successfully')]);
        $this->showRoundModal = false;
        $this->selectedParticipants = [];
        $this->participantsWithScores = [];
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

    public $judges_count = 5;
    
    private function resetRoundForm()
    {
        $this->round_number = ($this->rounds->max('round_number') ?? 0) + 1;
        $this->round_name = '';
        $this->scoring_type = 'average';
        $this->judges_count = 5;
    }
    
    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->applySorting();
    }
    
    private function applySorting()
    {
        $participants = $this->participants;
        
        switch ($this->sortBy) {
            case 'name':
                $participants = $participants->sortBy(function($participant) {
                    return strtolower($participant->display_name);
                }, SORT_REGULAR, $this->sortDirection === 'desc');
                break;
            case 'score':
                $participants = $participants->sortBy(function($participant) {
                    $scores = EventScore::where('event_id', $this->event->id)
                        ->where('participant_id', $participant->id)
                        ->where('round', $this->selectedRound)
                        ->pluck('score');
                    
                    if ($scores->isEmpty()) {
                        return 0;
                    }
                    
                    $currentRound = $this->rounds->where('round_number', $this->selectedRound)->first();
                    $scoringType = $currentRound ? $currentRound->scoring_type : 'average';
                    
                    return match($scoringType) {
                        'sum' => $scores->sum(),
                        'best_of' => $scores->max(),
                        'trimmed_mean' => $scores->count() >= 3 ? $scores->sort()->slice(1, -1)->sum() : $scores->sum(),
                        default => $scores->avg(),
                    };
                }, SORT_REGULAR, $this->sortDirection === 'desc');
                break;
            case 'performance_order':
            default:
                $participants = $participants->sortBy('performance_order', SORT_REGULAR, $this->sortDirection === 'desc');
                break;
        }
        
        $this->participants = $participants->values();
    }
    
    public function finalizeEvent()
    {
        if ($this->isLocked) {
            $this->dispatch('swal:error', ['title' => __('events.scoring.error'), 'text' => __('events.scoring.event_already_completed')]);
            return;
        }
        
        try {
            $scoringService = app(\App\Services\EventScoringService::class);
            
            // 1. Calculate final rankings
            $scoringService->calculateRankings($this->event);
            
            // 2. Award badges to winners
            $badgesAwarded = $scoringService->awardBadgesToWinners($this->event);
            
            // 3. Mark event as completed
            $this->event->status = Event::STATUS_COMPLETED;
            $this->event->save();
            
            $this->isLocked = true;
            $this->loadData();
            
            $this->dispatch('swal:success', [
                'title' => __('events.scoring.success'), 
                'text' => __('events.scoring.event_completed_success', ['badges' => $badgesAwarded])
            ]);
            
        } catch (\Exception $e) {
            $this->dispatch('swal:error', ['title' => __('events.scoring.error'), 'text' => $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.events.scoring.score-entry')
            ->layout('components.layouts.app');
    }
}

