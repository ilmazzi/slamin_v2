<?php

namespace App\Livewire\Poems;

use App\Models\Poem;
use Livewire\Component;

class PoemCard extends Component
{
    public Poem $poem;
    public bool $showActions = true;
    public string $size = 'md'; // sm, md, lg

    public function mount(Poem $poem, bool $showActions = true, string $size = 'md')
    {
        $this->poem = $poem;
        $this->showActions = $showActions;
        $this->size = $size;
    }

    public function openPoem()
    {
        return $this->redirect(route('poems.show', $this->poem->slug));
    }

    public function render()
    {
        return view('livewire.poems.poem-card');
    }
}


