<?php

namespace App\Livewire\Home;

use Livewire\Component;
use App\Models\Video;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VideosSection extends Component
{
    /**
     * Get direct file URL from PeerTube API (like original slamin project)
     */
    private function getDirectVideoUrl(Video $video): ?string
    {
        try {
            if (!$video->peertube_uuid) {
                return null;
            }
            
            $baseUrl = config('services.peertube.url', 'https://video.slamin.it');
            $response = Http::timeout(10)->get($baseUrl . '/api/v1/videos/' . $video->peertube_uuid);
            
            if ($response->successful()) {
                $data = $response->json();
                
                // Get the first available file (best quality)
                if (isset($data['files'][0]['fileUrl'])) {
                    return $data['files'][0]['fileUrl'];
                }
            }
        } catch (\Exception $e) {
            Log::error('Error getting PeerTube direct URL', [
                'video_id' => $video->id,
                'error' => $e->getMessage()
            ]);
        }
        
        return null;
    }
    
    public function render()
    {
        // Get top 5 most popular videos by total interactions (views + likes + comments)
        $videos = Video::where('moderation_status', 'approved')
            ->where('is_public', true)
            ->with('user')
            ->selectRaw('videos.*, (COALESCE(view_count, 0) + COALESCE(like_count, 0) + COALESCE(comment_count, 0)) as total_interactions')
            ->orderByDesc('total_interactions')
            ->limit(5)
            ->get();
        
        // Get direct URLs for PeerTube videos
        foreach ($videos as $video) {
            $video->direct_url = $this->getDirectVideoUrl($video);
        }
        
        return view('livewire.home.videos-section', [
            'videos' => $videos
        ]);
    }
}
