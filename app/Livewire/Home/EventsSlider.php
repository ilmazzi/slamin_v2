<?php

namespace App\Livewire\Home;

use Livewire\Component;
use App\Models\Event;
use App\Models\UnifiedLike;
use Illuminate\Support\Facades\Auth;

class EventsSlider extends Component
{
    public function render()
    {
        $recentEvents = Event::where('status', 'published')
            ->where('end_datetime', '>=', now())
            ->with('organizer')
            ->withCount(['views', 'likes', 'comments'])
            ->orderBy('start_datetime', 'asc')
            ->limit(6)
            ->get();
        
        // Check if user has liked each event
        if (Auth::check()) {
            foreach ($recentEvents as $event) {
                $event->is_liked = UnifiedLike::where('user_id', Auth::id())
                    ->where('likeable_type', Event::class)
                    ->where('likeable_id', $event->id)
                    ->exists();
            }
        } else {
            foreach ($recentEvents as $event) {
                $event->is_liked = false;
            }
        }
        
        return view('livewire.home.events-slider', [
            'recentEvents' => $recentEvents
        ]);
    }
}
