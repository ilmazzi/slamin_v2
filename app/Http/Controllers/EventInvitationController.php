<?php

namespace App\Http\Controllers;

use App\Models\EventInvitation;
use App\Models\EventParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EventInvitationController extends Controller
{
    public function accept(EventInvitation $invitation)
    {
        // Check if the invitation belongs to the authenticated user
        // For email invitations, check by email
        if ($invitation->invited_user_id && $invitation->invited_user_id !== Auth::id()) {
            abort(403, __('events.invitation.cannot_accept_others_invitation'));
        }
        
        if ($invitation->invited_email && $invitation->invited_email !== Auth::user()->email) {
            abort(403, __('events.invitation.cannot_accept_others_invitation'));
        }
        
        // If it's an email invitation, link it to the user now
        if ($invitation->invited_email && !$invitation->invited_user_id) {
            $invitation->update(['invited_user_id' => Auth::id()]);
        }

        // Check if invitation is still pending
        if (!$invitation->isPending()) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => __('events.invitation.already_responded')
                ], 400);
            }
            return redirect()->route('group-invitations.index')
                ->with('error', __('events.invitation.already_responded'));
        }

        // Update invitation status
        $invitation->update(['status' => 'accepted']);

        // Create EventParticipant if role is 'performer' and participant doesn't exist
        if ($invitation->role === 'performer') {
            $existingParticipant = EventParticipant::where('event_id', $invitation->event_id)
                ->where('user_id', $invitation->invited_user_id)
                ->first();
            
            if (!$existingParticipant) {
                EventParticipant::create([
                    'event_id' => $invitation->event_id,
                    'user_id' => $invitation->invited_user_id,
                    'registration_type' => 'invited',
                    'status' => 'confirmed',
                    'added_by' => $invitation->inviter_id,
                ]);
            }
        }

        // Optionally send notification to organizer
        try {
            $organizer = $invitation->event->organizer;
            if ($organizer && $organizer->id !== Auth::id()) {
                // Could send a notification here if needed
            }
        } catch (\Exception $e) {
            Log::error('Error notifying organizer of invitation acceptance', [
                'invitation_id' => $invitation->id,
                'error' => $e->getMessage()
            ]);
        }

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('events.invitation.accepted_success')
            ]);
        }

        return redirect()->route('group-invitations.index')
            ->with('success', __('events.invitation.accepted_success'));
    }

    public function decline(EventInvitation $invitation)
    {
        // Check if the invitation belongs to the authenticated user
        // For email invitations, check by email
        if ($invitation->invited_user_id && $invitation->invited_user_id !== Auth::id()) {
            abort(403, __('events.invitation.cannot_decline_others_invitation'));
        }
        
        if ($invitation->invited_email && $invitation->invited_email !== Auth::user()->email) {
            abort(403, __('events.invitation.cannot_decline_others_invitation'));
        }
        
        // If it's an email invitation, link it to the user now
        if ($invitation->invited_email && !$invitation->invited_user_id) {
            $invitation->update(['invited_user_id' => Auth::id()]);
        }

        // Check if invitation is still pending
        if (!$invitation->isPending()) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => __('events.invitation.already_responded')
                ], 400);
            }
            return redirect()->route('group-invitations.index')
                ->with('error', __('events.invitation.already_responded'));
        }

        // Update invitation status
        $invitation->update(['status' => 'declined']);

        // Optionally send notification to organizer
        try {
            $organizer = $invitation->event->organizer;
            if ($organizer && $organizer->id !== Auth::id()) {
                // Could send a notification here if needed
            }
        } catch (\Exception $e) {
            Log::error('Error notifying organizer of invitation decline', [
                'invitation_id' => $invitation->id,
                'error' => $e->getMessage()
            ]);
        }

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('events.invitation.declined_success')
            ]);
        }

        return redirect()->route('group-invitations.index')
            ->with('success', __('events.invitation.declined_success'));
    }
}

