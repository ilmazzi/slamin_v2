<?php

namespace App\Livewire\Gigs;

use App\Models\GigApplication;
use App\Models\PoemTranslationNegotiation;
use App\Notifications\NegotiationMessageReceived;
use App\Notifications\GigApplicationAccepted;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NegotiationChat extends Component
{
    public GigApplication $application;
    public $showNegotiation = false;
    
    // Form fields
    public $message = '';
    public $proposedCompensation = '';
    public $proposedDeadline = '';
    public $messageType = 'info'; // proposal, accept, reject, counter, info

    public function mount(GigApplication $application)
    {
        $this->application = $application->load(['user', 'gig.user', 'gig.requester', 'negotiations.user']);
    }

    public function toggleNegotiation()
    {
        $this->showNegotiation = !$this->showNegotiation;
        
        if ($this->showNegotiation) {
            // Segna come letti i messaggi dell'altro utente
            $this->application->negotiations()
                ->where('user_id', '!=', Auth::id())
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }
    }

    public function sendMessage()
    {
        $this->validate([
            'message' => 'required|string|min:3|max:1000',
            'proposedCompensation' => 'nullable|numeric|min:0',
            'proposedDeadline' => 'nullable|date|after:today',
            'messageType' => 'required|in:proposal,accept,reject,counter,info',
        ]);

        // Verifica che l'utente sia coinvolto nella candidatura
        $isRequester = $this->application->gig->user_id === Auth::id() || 
                       $this->application->gig->requester_id === Auth::id();
        $isApplicant = $this->application->user_id === Auth::id();

        if (!$isRequester && !$isApplicant) {
            session()->flash('error', __('gigs.messages.unauthorized'));
            return;
        }

        // Crea il messaggio di negoziazione
        $negotiation = PoemTranslationNegotiation::create([
            'gig_application_id' => $this->application->id,
            'user_id' => Auth::id(),
            'message_type' => $this->messageType,
            'message' => $this->message,
            'proposed_compensation' => $this->proposedCompensation ?: null,
            'proposed_deadline' => $this->proposedDeadline ?: null,
            'is_read' => false,
        ]);

        // Se è un'accettazione, aggiorna la candidatura e il gig
        if ($this->messageType === 'accept' && $isRequester) {
            // Aggiorna compenso e deadline se proposti
            if ($this->proposedCompensation) {
                $this->application->update(['proposed_compensation' => $this->proposedCompensation]);
            }
            if ($this->proposedDeadline) {
                $this->application->gig->update(['deadline' => $this->proposedDeadline]);
            }
            
            // Accetta la candidatura
            $this->application->gig->acceptApplication($this->application);
            
            // Notifica l'applicant
            $this->application->user->notify(new GigApplicationAccepted($this->application));
        }

        // Send notification ONLY to the other party (not to sender)
        $otherParty = $isRequester ? $this->application->user : ($this->application->gig->requester ?? $this->application->gig->user);
        if ($otherParty && $otherParty->id !== Auth::id()) {
            $otherParty->notify(new NegotiationMessageReceived($negotiation));
            
            // Don't dispatch events - recipient will see notification via polling
            // Sender should NOT see the animation
        }

        // Reset form
        $this->reset(['message', 'proposedCompensation', 'proposedDeadline', 'messageType']);
        
        // Reload negotiations
        $this->application->load('negotiations.user');

        session()->flash('success', __('negotiations.message_sent'));
    }

    public function setMessageType($type)
    {
        $this->messageType = $type;
    }

    public function getUnreadCountProperty()
    {
        return $this->application->negotiations()
            ->where('user_id', '!=', Auth::id())
            ->where('is_read', false)
            ->count();
    }

    public function render()
    {
        $negotiations = $this->application->negotiations()
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();

        $isRequester = $this->application->gig->user_id === Auth::id() || 
                       $this->application->gig->requester_id === Auth::id();
        $isApplicant = $this->application->user_id === Auth::id();

        return view('livewire.gigs.negotiation-chat', [
            'negotiations' => $negotiations,
            'isRequester' => $isRequester,
            'isApplicant' => $isApplicant,
            'unreadCount' => $this->unreadCount,
        ]);
    }
}
