<?php

namespace App\Livewire\Media;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Video;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VideoModal extends Component
{
    public $videoId;
    public $video;
    public $isOpen = false;
    public $videoDirectUrl = null;

    #[On('openVideoModal')]
    public function openModal($videoId)
    {
        $this->videoId = $videoId;
        $this->video = Video::with(['user'])
            ->withCount(['likes', 'comments', 'views'])
            ->find($videoId);
        
        if ($this->video) {
            $this->isOpen = true;
            
            // Ottieni URL diretto da PeerTube
            if ($this->video->peertube_uuid) {
                $this->videoDirectUrl = $this->getDirectVideoUrl();
            } else {
                $this->videoDirectUrl = $this->video->video_url;
            }
            
            // Increment view count
            $this->video->incrementViewCount();
        }
    }
    
    private function getDirectVideoUrl(): ?string
    {
        try {
            $baseUrl = config('services.peertube.url', 'https://video.slamin.it');
            $response = Http::timeout(10)->get($baseUrl . '/api/v1/videos/' . $this->video->peertube_uuid);
            
            if ($response->successful()) {
                $data = $response->json();
                
                // Ottieni il primo file disponibile (migliore qualità)
                if (isset($data['files'][0]['fileUrl'])) {
                    Log::info('URL diretto PeerTube ottenuto', [
                        'video_id' => $this->video->id,
                        'url' => $data['files'][0]['fileUrl']
                    ]);
                    return $data['files'][0]['fileUrl'];
                }
            }
        } catch (\Exception $e) {
            Log::error('Errore ottenimento URL diretto PeerTube', [
                'video_id' => $this->video->id,
                'error' => $e->getMessage()
            ]);
        }
        
        return null;
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


