<?php

namespace App\Livewire\Home;

use Livewire\Component;
use App\Models\Event;
use Carbon\Carbon;

class CompletedPoetrySlams extends Component
{
    public function render()
    {
        // Eventi conclusi negli ultimi 3 giorni
        $threeDaysAgo = Carbon::now()->subDays(3);
        $now = Carbon::now();
        
        $completedEvents = Event::where('status', Event::STATUS_COMPLETED)
            ->whereNotNull('end_datetime')
            ->where('end_datetime', '>=', $threeDaysAgo)
            ->where('end_datetime', '<=', $now)
            ->with(['organizer'])
            ->withCount(['views', 'likes', 'comments'])
            ->orderBy('end_datetime', 'desc')
            ->limit(6)
            ->get();
        
        // Per gli eventi Poetry Slam, carica anche i rankings del podio
        foreach ($completedEvents as $event) {
            if ($event->category === Event::CATEGORY_POETRY_SLAM) {
                $event->load(['rankings' => function($query) {
                    $query->where('position', '<=', 3)
                          ->with(['participant.user', 'badge'])
                          ->ordered();
                }]);
            }
        }

        return view('livewire.home.completed-poetry-slams', [
            'completedEvents' => $completedEvents
        ]);
    }
}

