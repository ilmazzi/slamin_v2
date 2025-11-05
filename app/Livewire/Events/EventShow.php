<?php

namespace App\Livewire\Events;

use Livewire\Component;
use App\Models\Event;

class EventShow extends Component
{
    public Event $event;

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function render()
    {
        return view('livewire.events.event-show')
            ->layout('components.layouts.app');
    }
}
