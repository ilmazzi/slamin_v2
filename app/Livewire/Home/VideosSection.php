<?php

namespace App\Livewire\Home;

use Livewire\Component;
use App\Models\Video;

class VideosSection extends Component
{
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
        
        return view('livewire.home.videos-section', [
            'videos' => $videos
        ]);
    }
}
