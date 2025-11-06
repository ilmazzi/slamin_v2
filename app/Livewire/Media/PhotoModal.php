<?php

namespace App\Livewire\Media;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Photo;

class PhotoModal extends Component
{
    public $photoId;
    public $photo;
    public $isOpen = false;

    #[On('openPhotoModal')]
    public function openModal($photoId)
    {
        $this->photoId = $photoId;
        $this->photo = Photo::with(['user'])
            ->withCount(['likes', 'comments', 'views'])
            ->find($photoId);
        
        if ($this->photo) {
            $this->isOpen = true;
            // Increment view count
            $this->photo->incrementViewCount();
        }
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->photo = null;
        $this->photoId = null;
    }

    public function render()
    {
        return view('livewire.media.photo-modal');
    }
}


