<?php

namespace App\Livewire\Events;

use Livewire\Component;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EventShow extends Component
{
    public Event $event;

    public function mount(Event $event)
    {
        $this->event = $event;
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
