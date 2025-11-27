<?php

namespace App\Livewire\Events\Scoring;

use Livewire\Component;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\User;

class ParticipantManagement extends Component
{
    public $event;
    public $participants;
    public $isLocked = false;
    public $showAddModal = false;
    public $participantType = 'user'; // 'user' or 'guest'
    
    // User participant
    public $userSearch = '';
    public $searchResults = [];
    public $selectedUser = null;
    
    // Guest participant
    public $guest_name;
    public $guest_email;
    public $guest_phone;
    public $guest_bio;
    
    // Common fields
    public $performance_order;
    public $notes;

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
        $this->loadParticipants();
    }

    public function loadParticipants()
    {
        // Get all participants
        $allParticipants = $this->event->participants()
            ->with(['user', 'ranking'])
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
    }

    public function openAddModal()
    {
        $this->resetForm();
        $this->showAddModal = true;
    }

    public function updatedUserSearch()
    {
        if (strlen($this->userSearch) >= 2) {
            $this->searchResults = User::where(function($query) {
                $query->where('name', 'like', '%' . $this->userSearch . '%')
                      ->orWhere('email', 'like', '%' . $this->userSearch . '%');
            })
            ->limit(10)
            ->get()
            ->map(function($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'display_name' => $user->getDisplayName(),
                    'avatar' => $user->profile_photo_url ?? asset('assets/images/avatar/default-avatar.webp'),
                ];
            });
        } else {
            $this->searchResults = [];
        }
    }

    public function selectUser($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $this->selectedUser = [
                'id' => $user->id,
                'display_name' => $user->getDisplayName(),
                'avatar' => $user->profile_photo_url ?? asset('assets/images/avatar/default-avatar.webp'),
            ];
            $this->userSearch = $user->getDisplayName();
            $this->searchResults = [];
        }
    }

    public function clearSelectedUser()
    {
        $this->selectedUser = null;
        $this->userSearch = '';
        $this->searchResults = [];
    }

    public function addParticipant()
    {
        if ($this->isLocked) {
            $this->dispatch('swal:error', ['title' => __('events.scoring.error'), 'text' => __('events.scoring.cannot_modify_participants_event_completed')]);
            return;
        }
        
        if ($this->participantType === 'user') {
            $this->validate([
                'selectedUser' => 'required',
            ]);

            // Check if user is already a participant
            $exists = $this->event->participants()->where('user_id', $this->selectedUser['id'])->exists();
            if ($exists) {
                $this->dispatch('swal:warning', ['title' => __('events.scoring.warning'), 'text' => __('events.scoring.user_already_participant')]);
                return;
            }

            EventParticipant::create([
                'event_id' => $this->event->id,
                'user_id' => $this->selectedUser['id'],
                'registration_type' => 'organizer_added',
                'status' => 'confirmed',
                'performance_order' => $this->performance_order ?: ($this->participants->max('performance_order') ?? 0) + 1,
                'notes' => $this->notes,
                'added_by' => auth()->id(),
            ]);

            $this->dispatch('swal:success', ['title' => __('events.scoring.added'), 'text' => __('events.scoring.participant_added_successfully')]);
        } else {
            // Guest participant
            $this->validate([
                'guest_name' => 'required|string|max:255',
                'guest_email' => 'nullable|email',
                'guest_phone' => 'nullable|string',
                'guest_bio' => 'nullable|string',
            ]);

            EventParticipant::create([
                'event_id' => $this->event->id,
                'guest_name' => $this->guest_name,
                'guest_email' => $this->guest_email,
                'guest_phone' => $this->guest_phone,
                'guest_bio' => $this->guest_bio,
                'registration_type' => 'guest',
                'status' => 'confirmed',
                'performance_order' => $this->performance_order ?: ($this->participants->max('performance_order') ?? 0) + 1,
                'notes' => $this->notes,
                'added_by' => auth()->id(),
            ]);

            $this->dispatch('swal:success', ['title' => __('events.scoring.added'), 'text' => __('events.scoring.guest_participant_added_successfully')]);
        }

        $this->loadParticipants();
        $this->showAddModal = false;
        $this->resetForm();
    }

    public function updateStatus($participantId, $newStatus)
    {
        if ($this->isLocked) {
            $this->dispatch('swal:error', ['title' => __('events.scoring.error'), 'text' => __('events.scoring.cannot_modify_participants_event_completed')]);
            return;
        }
        
        $participant = EventParticipant::findOrFail($participantId);
        $participant->status = $newStatus;
        $participant->save();

        $this->loadParticipants();
        $this->dispatch('swal:success', ['title' => __('events.scoring.updated'), 'text' => __('events.scoring.participant_status_updated')]);
    }

    public function removeParticipant($participantId)
    {
        if ($this->isLocked) {
            $this->dispatch('swal:error', ['title' => __('events.scoring.error'), 'text' => __('events.scoring.cannot_modify_participants_event_completed')]);
            return;
        }
        
        $participant = EventParticipant::findOrFail($participantId);
        $participant->delete();

        $this->loadParticipants();
        $this->dispatch('swal:success', ['title' => __('events.scoring.removed'), 'text' => __('events.scoring.participant_removed_successfully')]);
    }

    private function resetForm()
    {
        $this->reset(['userSearch', 'searchResults', 'selectedUser', 'guest_name', 'guest_email', 'guest_phone', 'guest_bio', 'performance_order', 'notes']);
        $this->participantType = 'user';
    }

    public function render()
    {
        return view('livewire.events.scoring.participant-management')
            ->layout('components.layouts.app');
    }
}

