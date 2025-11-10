<?php

namespace App\Livewire\Translations;

use App\Models\Gig;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\Auth;

class MyGigs extends Component
{
    use WithPagination;

    #[Url]
    public $status_filter = 'all';
    
    #[Url]
    public $sort_by = 'created_at';
    
    #[Url]
    public $sort_direction = 'desc';

    public function mount()
    {
        if (!Auth::check()) {
            session()->flash('error', __('gigs.messages.login_required'));
            return redirect()->route('login');
        }

        if (Auth::user()->hasRole('audience')) {
            session()->flash('error', __('gigs.messages.audience_not_allowed'));
            return redirect()->route('gigs.index');
        }
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sort_by === $field) {
            $this->sort_direction = $this->sort_direction === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sort_by = $field;
            $this->sort_direction = 'asc';
        }
    }

    public function closeGig($gigId)
    {
        $gig = Gig::findOrFail($gigId);
        
        if ($gig->canBeEditedBy(Auth::user())) {
            $gig->close();
            session()->flash('success', __('gigs.messages.gig_closed'));
        }
    }

    public function reopenGig($gigId)
    {
        $gig = Gig::findOrFail($gigId);
        
        if ($gig->canBeEditedBy(Auth::user())) {
            $gig->reopen();
            session()->flash('success', __('gigs.messages.gig_reopened'));
        }
    }

    public function deleteGig($gigId)
    {
        $gig = Gig::findOrFail($gigId);
        
        if ($gig->canBeEditedBy(Auth::user())) {
            $gig->delete();
            session()->flash('success', __('gigs.messages.gig_deleted'));
        }
    }

    public function getMyGigsProperty()
    {
        $query = Gig::query()
            ->with(['event', 'group', 'applications', 'poem'])
            ->where(function($q) {
                $q->where('user_id', Auth::id())
                  ->orWhere('requester_id', Auth::id());
            });

        if ($this->status_filter === 'open') {
            $query->open();
        } elseif ($this->status_filter === 'closed') {
            $query->closed();
        } elseif ($this->status_filter === 'expired') {
            $query->where('deadline', '<=', now())->where('is_closed', false);
        }

        $query->orderBy($this->sort_by, $this->sort_direction);

        return $query->paginate(12);
    }

    public function getStatsProperty()
    {
        $baseQuery = Gig::where(function($q) {
            $q->where('user_id', Auth::id())
              ->orWhere('requester_id', Auth::id());
        });

        return [
            'total_gigs' => (clone $baseQuery)->count(),
            'open_gigs' => (clone $baseQuery)->open()->count(),
            'total_applications' => (clone $baseQuery)->withCount('applications')->get()->sum('applications_count'),
            'pending_applications' => (clone $baseQuery)->withCount(['applications' => function($q) {
                $q->where('status', 'pending');
            }])->get()->sum('applications_count'),
        ];
    }

    public function render()
    {
        return view('livewire.translations.my-gigs', [
            'gigs' => $this->myGigs,
            'stats' => $this->stats,
        ]);
    }
}
