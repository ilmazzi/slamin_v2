<?php

namespace App\Livewire\Translations;

use App\Models\Gig;
use Livewire\Component;
use Livewire\WithPagination;

class GigIndex extends Component
{
    use WithPagination;
    
    public string $search = '';
    public string $language = '';
    public string $sort = 'recent';
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingLanguage()
    {
        $this->resetPage();
    }
    
    public function updatingSortChanged()
    {
        $this->resetPage();
    }
    
    public function resetFilters()
    {
        $this->reset(['search', 'language', 'sort']);
    }
    
    public function render()
    {
        $query = Gig::with(['poem.user', 'requester', 'applications'])
            ->where('status', 'open');
        
        // Search
        if ($this->search) {
            $query->whereHas('poem', function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('content', 'like', '%' . $this->search . '%');
            });
        }
        
        // Language filter
        if ($this->language) {
            $query->where('target_language', $this->language);
        }
        
        // Sort
        switch ($this->sort) {
            case 'compensation_high':
                $query->orderBy('proposed_compensation', 'desc');
                break;
            case 'compensation_low':
                $query->orderBy('proposed_compensation', 'asc');
                break;
            case 'deadline':
                $query->orderBy('deadline', 'asc');
                break;
            default: // recent
                $query->orderBy('created_at', 'desc');
        }
        
        $gigs = $query->paginate(12);
        
        $languages = config('poems.languages', []);
        
        return view('livewire.translations.gig-index', [
            'gigs' => $gigs,
            'languages' => $languages,
        ]);
    }
}
