<?php

namespace App\Livewire\Gigs;

use App\Models\Gig;
use App\Models\GigApplication;
use App\Notifications\GigApplicationAccepted;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\Auth;

class ApplicationsManagement extends Component
{
    use WithPagination;

    public Gig $gig;
    
    #[Url]
    public $status_filter = 'all';

    public function mount(Gig $gig)
    {
        $this->gig = $gig->load(['user', 'event', 'group']);

        if (!Auth::check() || !$this->gig->canBeEditedBy(Auth::user())) {
            session()->flash('error', __('gigs.messages.unauthorized'));
            return redirect()->route('gigs.index');
        }
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function acceptApplication($applicationId)
    {
        $application = GigApplication::findOrFail($applicationId);
        
        if ($application->gig_id === $this->gig->id) {
            if ($this->gig->acceptApplication($application)) {
                // Send notification to applicant
                $application->user->notify(new GigApplicationAccepted($application));
                
                session()->flash('success', __('gigs.messages.application_accepted'));
                $this->gig->refresh();
            } else {
                session()->flash('error', __('gigs.messages.cannot_accept_application'));
            }
        }
    }

    public function rejectApplication($applicationId)
    {
        $application = GigApplication::findOrFail($applicationId);
        
        if ($application->gig_id === $this->gig->id && $application->status === 'pending') {
            $application->update([
                'status' => 'rejected',
                'rejected_at' => now(),
            ]);
            
            session()->flash('success', __('gigs.messages.application_rejected'));
        }
    }

    public function getApplicationsProperty()
    {
        $query = $this->gig->applications()->with('user');

        if ($this->status_filter !== 'all') {
            $query->where('status', $this->status_filter);
        }

        $query->orderBy('created_at', 'desc');

        return $query->paginate(12);
    }

    public function getStatsProperty()
    {
        return [
            'total' => $this->gig->applications()->count(),
            'pending' => $this->gig->applications()->where('status', 'pending')->count(),
            'accepted' => $this->gig->applications()->where('status', 'accepted')->count(),
            'rejected' => $this->gig->applications()->where('status', 'rejected')->count(),
        ];
    }

    public function render()
    {
        return view('livewire.gigs.applications-management', [
            'applications' => $this->applications,
            'stats' => $this->stats,
        ]);
    }
}
