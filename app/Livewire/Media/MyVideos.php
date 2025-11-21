<?php

namespace App\Livewire\Media;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Video;
use Livewire\WithPagination;

class MyVideos extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all'; // 'all', 'approved', 'pending', 'rejected'

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function deleteVideo($videoId)
    {
        $video = Video::where('id', $videoId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $video->delete();

        session()->flash('success', __('media.video_deleted_successfully'));
    }

    public function render()
    {
        $user = Auth::user();

        $query = Video::where('user_id', $user->id)
            ->with(['user'])
            ->withCount(['likes', 'comments', 'views']);

        // Apply search filter
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Apply status filter
        if ($this->filter === 'approved') {
            $query->where('moderation_status', 'approved');
        } elseif ($this->filter === 'pending') {
            $query->where('moderation_status', 'pending');
        } elseif ($this->filter === 'rejected') {
            $query->where('moderation_status', 'rejected');
        }

        $videos = $query->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('livewire.media.my-videos', [
            'videos' => $videos,
            'currentVideoCount' => $user->current_video_count,
            'currentVideoLimit' => $user->current_video_limit,
            'remainingUploads' => $user->remaining_video_uploads,
        ])->layout('components.layouts.app', ['title' => __('media.my_videos')]);
    }
}

