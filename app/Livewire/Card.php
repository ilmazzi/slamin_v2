<?php

namespace App\Livewire;

use Livewire\Component;

class Card extends Component
{
    public bool $hover = true;

    public function render()
    {
        return view('livewire.card');
    }
}
