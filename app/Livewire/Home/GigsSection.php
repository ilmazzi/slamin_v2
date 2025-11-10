<?php

namespace App\Livewire\Home;

use Livewire\Component;
use App\Models\Gig;

class GigsSection extends Component
{
    public function render()
    {
        // Get top gigs: featured, open, with most applications, recent
        $topGigs = Gig::with(['user', 'event'])
            ->where('status', 'open')
            ->where(function($query) {
                $query->where('deadline', '>', now())
                      ->orWhereNull('deadline');
            })
            ->orderByDesc('is_featured')
            ->orderByDesc('is_urgent')
            ->orderByDesc('application_count')
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();

        return view('livewire.home.gigs-section', [
            'topGigs' => $topGigs,
        ]);
    }
}
