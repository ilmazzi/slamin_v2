<?php

namespace App\Livewire\Home;

use Livewire\Component;
use App\Models\Gig;
use Illuminate\Support\Facades\Auth;

class GigsSection extends Component
{
    public function render()
    {
        // Gli utenti audience non possono vedere gli ingaggi
        if (Auth::check() && Auth::user()->hasRole('audience')) {
            return view('livewire.home.gigs-section', [
                'topGigs' => collect(),
            ]);
        }
        
        // Get top gigs: featured, open (not closed), with most applications, recent
        $topGigs = Gig::with(['user', 'event'])
            ->where('is_closed', false)
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
