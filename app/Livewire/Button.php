<?php

namespace App\Livewire;

use Livewire\Component;

class Button extends Component
{
    public string $variant = 'primary';
    public string $size = 'md';
    public ?string $href = null;
    public ?string $method = null;
    public bool $disabled = false;

    public function render()
    {
        return view('livewire.button');
    }

    public function click()
    {
        $this->dispatch('click');
    }
}
