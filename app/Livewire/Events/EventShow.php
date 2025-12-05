<?php

namespace App\Livewire\Events;

use Livewire\Component;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EventShow extends Component
{
    public Event $event;
    public $userInvitation = null;

    public function mount(Event $event)
    {
        $this->event = $event;
        $this->loadUserInvitation();
    }

    public function loadUserInvitation()
    {
        if (Auth::check()) {
            $this->userInvitation = $this->event->invitations()
                ->where('invited_user_id', Auth::id())
                ->first();
        }
    }

    public function acceptInvitation()
    {
        if (!$this->userInvitation || $this->userInvitation->invited_user_id !== Auth::id()) {
            session()->flash('error', __('events.invitation.cannot_accept_others_invitation'));
            return;
        }

        if (!$this->userInvitation->isPending()) {
            session()->flash('error', __('events.invitation.already_responded'));
            return;
        }

        // Create EventParticipant if role is 'performer' and participant doesn't exist
        if ($this->userInvitation->role === 'performer') {
            $existingParticipant = \App\Models\EventParticipant::where('event_id', $this->event->id)
                ->where('user_id', Auth::id())
                ->first();

            if (!$existingParticipant) {
                \App\Models\EventParticipant::create([
                    'event_id' => $this->event->id,
                    'user_id' => Auth::id(),
                    'registration_type' => 'invited',
                    'status' => 'confirmed',
                    'added_by' => $this->userInvitation->inviter_id,
                ]);
            }
        }

        $this->userInvitation->update(['status' => 'accepted']);

        // Refresh event to update relationships
        $this->event->refresh();
        $this->loadUserInvitation();
        session()->flash('success', __('events.invitation.accepted_success'));
    }

    public function declineInvitation()
    {
        if (!$this->userInvitation || $this->userInvitation->invited_user_id !== Auth::id()) {
            session()->flash('error', __('events.invitation.cannot_decline_others_invitation'));
            return;
        }

        if (!$this->userInvitation->isPending()) {
            session()->flash('error', __('events.invitation.already_responded'));
            return;
        }

        $this->userInvitation->update(['status' => 'declined']);

        // Refresh event to update relationships
        $this->event->refresh();
        $this->loadUserInvitation();
        session()->flash('success', __('events.invitation.declined_success'));
    }

    public function resendInvitations()
    {
        // Check if user is organizer
        if (Auth::id() !== $this->event->organizer_id && !Auth::user()->canOrganizeEvents()) {
            abort(403, 'Non hai i permessi per reinviare gli inviti');
        }

        $invitations = $this->event->invitations()->where('status', 'pending')->get();
        $sentCount = 0;

        foreach ($invitations as $invitation) {
            $invitedUser = $invitation->invitedUser;
            if ($invitedUser) {
                try {
                    $invitedUser->notify(new \App\Notifications\EventInvitationNotification($invitation));
                    $sentCount++;
                } catch (\Exception $e) {
                    Log::error('Error resending event invitation', [
                        'invitation_id' => $invitation->id,
                        'user_id' => $invitedUser->id,
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }

        if ($sentCount > 0) {
            session()->flash('success', __('events.invitation.resend_success', ['count' => $sentCount]));
        } else {
            session()->flash('info', __('events.invitation.no_pending_invitations'));
        }
    }

    public function render()
    {
        return view('livewire.events.event-show')
            ->layout('components.layouts.app');
    }
}
