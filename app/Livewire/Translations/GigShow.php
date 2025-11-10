<?php

namespace App\Livewire\Translations;

use App\Models\Gig;
use App\Models\GigApplication;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class GigShow extends Component
{
    public Gig $gig;
    public bool $showApplicationForm = false;
    
    // Application Form
    public string $coverLetter = '';
    public string $proposedCompensation = '';
    public string $estimatedDelivery = '';
    
    public function mount(Gig $gig)
    {
        $this->gig = $gig->load(['poem.user', 'requester', 'applications.translator', 'acceptedTranslator']);
        $this->proposedCompensation = (string) $gig->proposed_compensation;
    }
    
    public function toggleApplicationForm()
    {
        if (!$this->gig->canApply(Auth::user())) {
            session()->flash('error', __('translations.cannot_apply'));
            return;
        }
        
        $this->showApplicationForm = !$this->showApplicationForm;
    }
    
    public function submitApplication()
    {
        if (!$this->gig->canApply(Auth::user())) {
            session()->flash('error', __('translations.cannot_apply'));
            return;
        }
        
        $this->validate([
            'coverLetter' => 'required|string|min:50|max:1000',
            'proposedCompensation' => 'required|numeric|min:0',
            'estimatedDelivery' => 'required|date|after:today',
        ]);
        
        GigApplication::create([
            'gig_id' => $this->gig->id,
            'user_id' => Auth::id(), // Campo corretto nella tabella gig_applications
            'cover_letter' => $this->coverLetter,
            'proposed_compensation' => $this->proposedCompensation,
            'estimated_delivery' => $this->estimatedDelivery,
            'status' => 'pending',
        ]);
        
        session()->flash('success', __('translations.application_sent'));
        $this->showApplicationForm = false;
        $this->reset(['coverLetter', 'proposedCompensation', 'estimatedDelivery']);
        
        // Reload gig to show updated applications count
        $this->gig->refresh();
    }
    
    public function acceptApplication($applicationId)
    {
        $application = GigApplication::findOrFail($applicationId);
        
        // Solo il richiedente può accettare
        if ($this->gig->requester_id !== Auth::id()) {
            session()->flash('error', __('translations.unauthorized'));
            return;
        }
        
        if ($this->gig->acceptApplication($application)) {
            session()->flash('success', __('translations.application_accepted'));
            $this->gig->refresh();
        } else {
            session()->flash('error', __('translations.cannot_accept'));
        }
    }
    
    public function cancelGig()
    {
        // Solo il richiedente può cancellare
        if ($this->gig->requester_id !== Auth::id()) {
            session()->flash('error', __('translations.unauthorized'));
            return;
        }
        
        if ($this->gig->status === 'open') {
            $this->gig->update(['status' => 'cancelled']);
            session()->flash('success', __('translations.gig_cancelled'));
            return $this->redirect(route('translations.my-gigs'), navigate: true);
        }
    }
    
    public function render()
    {
        $userApplication = Auth::check() 
            ? $this->gig->applications()->where('user_id', Auth::id())->first()
            : null;
        
        $canApply = Auth::check() && $this->gig->canApply(Auth::user());
        $isRequester = Auth::check() && $this->gig->requester_id === Auth::id();
        
        return view('livewire.translations.gig-show', [
            'userApplication' => $userApplication,
            'canApply' => $canApply,
            'isRequester' => $isRequester,
        ]);
    }
}
