<?php

namespace App\Livewire\Translations;

use App\Models\GigApplication;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class MyApplications extends Component
{
    use WithPagination;
    
    public string $filter = 'all'; // all, pending, accepted, rejected
    
    public function updatingFilter()
    {
        $this->resetPage();
    }
    
    public function withdrawApplication($applicationId)
    {
        $application = GigApplication::findOrFail($applicationId);
        
        if ($application->translator_id !== Auth::id()) {
            session()->flash('error', __('translations.unauthorized'));
            return;
        }
        
        if ($application->status === 'pending') {
            $application->update(['status' => 'withdrawn']);
            session()->flash('success', __('translations.application_withdrawn'));
        }
    }
    
    public function render()
    {
        $query = GigApplication::with(['gig.poem.user', 'gig.requester'])
            ->where('translator_id', Auth::id());
        
        // Filter by status
        if ($this->filter !== 'all') {
            $query->where('status', $this->filter);
        }
        
        $applications = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('livewire.translations.my-applications', [
            'applications' => $applications,
        ]);
    }
}
