<?php

namespace App\Livewire\Home;

use Livewire\Component;

class HomeIndex extends Component
{
    public function render()
    {
        return view('livewire.home.home-index')
            ->layout('components.layouts.master', [
                'title' => 'Home - Poetry Social Network'
            ]);
    }
}