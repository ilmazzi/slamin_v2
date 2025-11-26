<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;

class WishlistButton extends Component
{
    public Event $event;
    public $isInWishlist = false;

    public function mount(Event $event)
    {
        $this->event = $event;
        $this->checkWishlistStatus();
    }

    public function toggleWishlist()
    {
        if (!Auth::check()) {
            $this->dispatch('notify', [
                'message' => __('events.must_login_to_add_wishlist'),
                'type' => 'error'
            ]);
            return;
        }

        $user = Auth::user();

        if ($this->isInWishlist) {
            $user->wishlistedEvents()->detach($this->event->id);
            $this->dispatch('notify', [
                'message' => __('events.removed_from_wishlist'),
                'type' => 'success'
            ]);
        } else {
            $user->wishlistedEvents()->attach($this->event->id);
            $this->dispatch('notify', [
                'message' => __('events.added_to_wishlist'),
                'type' => 'success'
            ]);
        }

        $this->checkWishlistStatus();
        
        // Dispatch event per aggiornare il calendario se necessario
        $this->dispatch('wishlist-updated');
    }

    protected function checkWishlistStatus()
    {
        if (Auth::check()) {
            $this->isInWishlist = Auth::user()->wishlistedEvents()->where('event_id', $this->event->id)->exists();
        }
    }

    public function render()
    {
        return view('livewire.components.wishlist-button');
    }
}

