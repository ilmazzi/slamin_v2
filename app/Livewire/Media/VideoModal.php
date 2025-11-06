<?php

namespace App\Livewire\Media;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Video;

class VideoModal extends Component
{
    public $videoId;
    public $video;
    public $isOpen = false;

    #[On('openVideoModal')]
    public function openModal($videoId)
    {
        $this->videoId = $videoId;
        $this->video = Video::with(['user'])
            ->withCount(['likes', 'comments', 'views'])
            ->find($videoId);
        
        if ($this->video) {
            $this->isOpen = true;
            
            // Increment view count
            $this->video->incrementViewCount();
        }
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->video = null;
        $this->videoId = null;
    }

    public function render()
    {
        return view('livewire.media.video-modal');
    }
}


