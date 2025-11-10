<?php

namespace App\Livewire\Translations;

use App\Models\Gig;
use App\Models\GigApplication;
use App\Notifications\GigApplicationReceived;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class GigShow extends Component
{
    public Gig $gig;
    public $showApplicationForm = false;
    
    // Application Form Fields
    public $applicationMessage = '';
    public $applicationExperience = '';
    public $applicationPortfolio = '';
    public $applicationPortfolioUrl = '';
    public $applicationAvailability = '';
    public $applicationCompensationExpectation = '';

    public function mount(Gig $gig)
    {
        $this->gig = $gig->load(['user', 'event', 'group', 'applications.user', 'poem', 'requester', 'acceptedTranslator']);
    }

    public function toggleApplicationForm()
    {
        if (!Auth::check()) {
            session()->flash('error', __('gigs.messages.login_to_interact'));
            return redirect()->route('login');
        }

        if (Auth::user()->hasRole('audience')) {
            session()->flash('error', __('gigs.messages.audience_not_allowed'));
            return;
        }

        $this->showApplicationForm = !$this->showApplicationForm;
    }

    public function submitApplication()
    {
        if (!Auth::check()) {
            session()->flash('error', __('gigs.messages.login_to_interact'));
            return redirect()->route('login');
        }

        if (!$this->gig->canUserApply(Auth::user())) {
            session()->flash('error', __('gigs.applications.cannot_apply'));
            return;
        }

        $this->validate([
            'applicationMessage' => 'required|min:10|max:1000',
            'applicationExperience' => 'nullable|max:1000',
            'applicationPortfolio' => 'nullable|max:2000',
            'applicationPortfolioUrl' => 'nullable|url|max:500',
            'applicationAvailability' => 'nullable|max:500',
            'applicationCompensationExpectation' => 'nullable|max:200',
        ]);

        GigApplication::create([
            'gig_id' => $this->gig->id,
            'user_id' => Auth::id(),
            'message' => $this->applicationMessage,
            'experience' => $this->applicationExperience,
            'portfolio' => $this->applicationPortfolio,
            'portfolio_url' => $this->applicationPortfolioUrl,
            'availability' => $this->applicationAvailability,
            'compensation_expectation' => $this->applicationCompensationExpectation,
            'status' => 'pending',
        ]);

        // Increment application count
        $this->gig->increment('application_count');

        // Send notification to gig owner/requester
        $recipient = $this->gig->requester ?? $this->gig->user;
        if ($recipient) {
            $recipient->notify(new GigApplicationReceived($application));
        }

        // Refresh notifications globally
        $this->dispatch('refresh-notifications');
        
        // Dispatch browser event for instant UI update
        $this->js('window.dispatchEvent(new CustomEvent("notification-received"))');

        session()->flash('success', __('gigs.applications.application_sent'));
        
        $this->reset([
            'applicationMessage',
            'applicationExperience',
            'applicationPortfolio',
            'applicationPortfolioUrl',
            'applicationAvailability',
            'applicationCompensationExpectation',
            'showApplicationForm'
        ]);
        
        $this->gig->refresh();
    }

    public function closeGig()
    {
        if (!Auth::check() || !$this->gig->canBeEditedBy(Auth::user())) {
            session()->flash('error', __('gigs.messages.unauthorized'));
            return;
        }

        $this->gig->close();
        session()->flash('success', __('gigs.messages.gig_closed'));
        $this->gig->refresh();
    }

    public function reopenGig()
    {
        if (!Auth::check() || !$this->gig->canBeEditedBy(Auth::user())) {
            session()->flash('error', __('gigs.messages.unauthorized'));
            return;
        }

        $this->gig->reopen();
        session()->flash('success', __('gigs.messages.gig_reopened'));
        $this->gig->refresh();
    }

    public function shareGig()
    {
        if (!Auth::check() || !$this->gig->canBeEditedBy(Auth::user())) {
            session()->flash('error', __('gigs.messages.unauthorized'));
            return;
        }

        $count = $this->gig->share();
        session()->flash('success', __('gigs.messages.gig_shared', ['count' => $count]));
    }

    public function deleteGig()
    {
        if (!Auth::check() || !$this->gig->canBeEditedBy(Auth::user())) {
            session()->flash('error', __('gigs.messages.unauthorized'));
            return;
        }

        $this->gig->delete();
        session()->flash('success', __('gigs.messages.gig_deleted'));
        return redirect()->route('gigs.index');
    }

    public function getUserApplicationProperty()
    {
        if (!Auth::check()) {
            return null;
        }

        return $this->gig->applications()
            ->where('user_id', Auth::id())
            ->first();
    }

    public function render()
    {
        $canApply = Auth::check() && $this->gig->canUserApply(Auth::user());
        $isOwner = Auth::check() && (
            $this->gig->user_id === Auth::id() || 
            $this->gig->requester_id === Auth::id()
        );

        return view('livewire.translations.gig-show', [
            'userApplication' => $this->userApplication,
            'canApply' => $canApply,
            'isOwner' => $isOwner,
        ]);
    }
}
