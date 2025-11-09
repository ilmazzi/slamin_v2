<?php

namespace App\Livewire\Translations;

use App\Models\Gig;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class MyGigs extends Component
{
    use WithPagination;
    
    public string $filter = 'all'; // all, open, in_progress, completed
    
    public function updatingFilter()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $query = Gig::with(['poem', 'acceptedTranslator', 'applications'])
            ->where('requester_id', Auth::id());
        
        // Filter by status
        if ($this->filter !== 'all') {
            $query->where('status', $this->filter);
        }
        
        $gigs = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('livewire.translations.my-gigs', [
            'gigs' => $gigs,
        ]);
    }
}
