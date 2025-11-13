<?php

namespace App\Livewire\Poems;

use App\Models\Poem;
use Livewire\Component;
use Livewire\Attributes\On;

class PoemModal extends Component
{
    public $isOpen = false;
    public $poem = null;
    public $poemId = null;
    
    #[On('openPoemModal')]
    public function openModal($poemId)
    {
        $this->poemId = $poemId;
        $this->poem = Poem::with(['user', 'likes', 'comments.user'])
            ->find($poemId);
        
        if ($this->poem) {
            // Increment view count
            $this->poem->increment('view_count');
            $this->isOpen = true;
        }
    }
    
    public function closeModal()
    {
        $this->isOpen = false;
        $this->poem = null;
        $this->poemId = null;
    }
    
    public function emitTranslationRequest()
    {
        if (!$this->poem) {
            return;
        }
        $this->dispatch('openTranslationRequest', poemId: $this->poem->id);
    }
    
    public function render()
    {
        return view('livewire.poems.poem-modal');
    }
}
