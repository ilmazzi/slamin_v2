<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupJoinRequest;
use App\Models\GroupMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupJoinRequestController extends Controller
{
    /**
     * Mostra le richieste di partecipazione inviate dall'utente
     */
    public function index()
    {
        $user = Auth::user();

        $requests = GroupJoinRequest::where('user_id', $user->id)
                        ->with('group')
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

        return view('groups.join-requests.index', compact('requests'));
    }

    /**
     * Mostra le richieste pendenti di un gruppo (per admin/moderatori)
     */
    public function pending(Group $group)
    {
        $user = Auth::user();

        if (!$group->hasModerator($user)) {
            abort(403, __('groups.no_permission_view_requests'));
        }

        $requests = $group->joinRequests()
                         ->with(['user', 'respondedBy'])
                         ->orderBy('created_at', 'desc')
                         ->paginate(10);

        return view('groups.join-requests.pending', compact('group', 'requests'));
    }

    /**
     * Crea una nuova richiesta di partecipazione
     */
    public function store(Request $request, Group $group)
    {
        $user = Auth::user();

        // Verifica che l'utente non sia già membro del gruppo
        if ($group->hasMember($user)) {
            return back()->with('error', __('groups.already_member'));
        }

        // Verifica che non ci sia già una richiesta pendente
        $existingRequest = GroupJoinRequest::where('group_id', $group->id)
                                          ->where('user_id', $user->id)
                                          ->where('status', 'pending')
                                          ->first();

        if ($existingRequest) {
            return back()->with('error', __('groups.request_already_sent'));
        }

        // Crea la richiesta
        GroupJoinRequest::create([
            'group_id' => $group->id,
            'user_id' => $user->id,
            'status' => 'pending',
            'message' => $request->input('message', ''),
        ]);

        return back()->with('success', __('groups.request_sent'));
    }

    /**
     * Mostra i dettagli di una richiesta
     */
    public function show(GroupJoinRequest $request)
    {
        $user = Auth::user();

        // Verifica che l'utente sia chi ha fatto la richiesta o admin/moderatore del gruppo
        if ($request->user_id !== $user->id && !$request->group->hasModerator($user)) {
            abort(403, __('groups.no_permission_view_request'));
        }

        $request->load(['group', 'user', 'respondedBy']);

        return view('groups.join-requests.show', compact('request'));
    }

    /**
     * Accetta una richiesta di partecipazione
     */
    public function accept(Group $group, GroupJoinRequest $request)
    {
        $user = Auth::user();

        // Verifica che l'utente sia admin/moderatore del gruppo
        if (!$group->hasModerator($user)) {
            abort(403, __('groups.no_permission_accept_requests'));
        }

        // Verifica che la richiesta sia pendente
        if (!$request->isPending()) {
            return back()->with('error', __('groups.request_not_valid'));
        }

        // Verifica che l'utente non sia già membro del gruppo
        if ($group->hasMember($request->user)) {
            $request->update(['status' => 'accepted']);
            return back()->with('error', __('groups.user_already_member'));
        }

        // Accetta la richiesta (il metodo accept crea automaticamente il GroupMember)
        $request->accept($user);

        return back()->with('success', __('groups.request_approved'));
    }

    /**
     * Rifiuta una richiesta di partecipazione
     */
    public function decline(Group $group, GroupJoinRequest $request)
    {
        $user = Auth::user();

        // Verifica che l'utente sia admin/moderatore del gruppo
        if (!$group->hasModerator($user)) {
            abort(403, __('groups.no_permission_decline_requests'));
        }

        // Verifica che la richiesta sia pendente
        if (!$request->isPending()) {
            return back()->with('error', __('groups.request_not_valid'));
        }

        // Rifiuta la richiesta
        $request->decline($user);

        return back()->with('success', __('groups.request_declined'));
    }

    /**
     * Cancella una richiesta di partecipazione (per chi l'ha fatta)
     */
    public function cancel(GroupJoinRequest $request)
    {
        $user = Auth::user();

        // Verifica che l'utente sia chi ha fatto la richiesta
        if ($request->user_id !== $user->id) {
            abort(403, __('groups.cannot_cancel_others_request'));
        }

        // Verifica che la richiesta sia pendente
        if (!$request->isPending()) {
            return back()->with('error', __('groups.request_not_valid'));
        }

        $request->delete();

        return back()->with('success', __('groups.request_cancelled'));
    }

    /**
     * Mostra le statistiche delle richieste per un gruppo
     */
    public function stats(Group $group)
    {
        $user = Auth::user();

        if (!$group->hasModerator($user)) {
            abort(403, __('groups.no_permission_view_stats'));
        }

        $stats = [
            'total_requests' => $group->joinRequests()->count(),
            'pending_requests' => $group->joinRequests()->where('status', 'pending')->count(),
            'accepted_requests' => $group->joinRequests()->where('status', 'accepted')->count(),
            'declined_requests' => $group->joinRequests()->where('status', 'declined')->count(),
            'recent_requests' => $group->joinRequests()->with('user')->latest()->limit(5)->get(),
        ];

        return view('groups.join-requests.stats', compact('group', 'stats'));
    }
}
