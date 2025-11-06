<?php

namespace App\Livewire\Snap;

use App\Models\Video;
use Livewire\Component;

class SnapTimeline extends Component
{
    public $video;
    public $snaps;
    public $currentTime = 0;
    public $duration = 0;
    
    protected $listeners = [
        'video-time-update' => 'updateTime',
        'snap-created' => 'refreshSnaps'
    ];
    
    public function mount(Video $video)
    {
        $this->video = $video;
        $this->snaps = $video->approvedSnaps()->orderBy('timestamp')->get();
        $this->duration = $video->duration ?? 0;
    }
    
    public function seekToTime($timestamp)
    {
        $this->dispatch('seek-video', timestamp: $timestamp);
    }
    
    public function updateTime($time = null, $duration = null)
    {
        // Se riceve parametri individuali
        if ($time !== null) {
            $this->currentTime = $time;
        }
        
        if ($duration !== null && $duration > 0) {
            $this->duration = $duration;
        }
    }
    
    public function refreshSnaps()
    {
        $this->snaps = $this->video->approvedSnaps()->orderBy('timestamp')->get();
    }
    
    public function render()
    {
        return view('livewire.snap.snap-timeline');
    }
}
