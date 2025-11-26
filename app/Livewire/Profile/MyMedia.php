<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Video;
use App\Models\Photo;
use Livewire\WithPagination;

class MyMedia extends Component
{
    use WithPagination;

    public $activeTab = 'videos'; // 'videos' or 'photos'
    public $search = '';
    public $videoFilter = 'all'; // 'all', 'approved', 'pending', 'rejected'
    public $photoFilter = 'all'; // 'all', 'approved', 'pending', 'rejected'

    public function mount()
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingVideoFilter()
    {
        $this->resetPage();
    }

    public function updatingPhotoFilter()
    {
        $this->resetPage();
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
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

    public function deletePhoto($photoId)
    {
        $photo = Photo::where('id', $photoId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Delete file from storage
        if ($photo->image_path) {
            try {
                if (str_starts_with($photo->image_path, 'http')) {
                    // External URL, skip file deletion
                } elseif (str_starts_with($photo->image_path, '/storage/')) {
                    $filePath = str_replace('/storage/', '', $photo->image_path);
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($filePath);
                } else {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($photo->image_path);
                }
            } catch (\Exception $e) {
                Log::warning("Error deleting photo file: " . $e->getMessage());
            }
        }

        // Delete thumbnail if exists
        if ($photo->thumbnail_path) {
            try {
                if (str_starts_with($photo->thumbnail_path, 'http')) {
                    // External URL, skip file deletion
                } elseif (str_starts_with($photo->thumbnail_path, '/storage/')) {
                    $thumbPath = str_replace('/storage/', '', $photo->thumbnail_path);
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($thumbPath);
                } else {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($photo->thumbnail_path);
                }
            } catch (\Exception $e) {
                Log::warning("Error deleting photo thumbnail: " . $e->getMessage());
            }
        }

        $photo->delete();

        session()->flash('success', __('media.photo_deleted_successfully'));
    }

    public function getVideosProperty()
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
        if ($this->videoFilter === 'approved') {
            $query->where('moderation_status', 'approved');
        } elseif ($this->videoFilter === 'pending') {
            $query->where('moderation_status', 'pending');
        } elseif ($this->videoFilter === 'rejected') {
            $query->where('moderation_status', 'rejected');
        }

        return $query->orderBy('created_at', 'desc')
            ->paginate(12, ['*'], 'videos_page');
    }

    public function getPhotosProperty()
    {
        $user = Auth::user();

        $query = Photo::where('user_id', $user->id)
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
        if ($this->photoFilter === 'approved') {
            $query->where('status', 'approved')->where('moderation_status', 'approved');
        } elseif ($this->photoFilter === 'pending') {
            $query->where(function($q) {
                $q->where('status', 'pending')->orWhere('moderation_status', 'pending');
            });
        } elseif ($this->photoFilter === 'rejected') {
            $query->where('moderation_status', 'rejected');
        }

        return $query->orderBy('created_at', 'desc')
            ->paginate(12, ['*'], 'photos_page');
    }

    public function render()
    {
        $user = Auth::user();

        return view('livewire.profile.my-media', [
            'videos' => $this->videos,
            'photos' => $this->photos,
            'currentVideoCount' => $user->current_video_count,
            'currentVideoLimit' => $user->current_video_limit,
            'remainingUploads' => $user->remaining_video_uploads,
        ])->layout('components.layouts.app', [
            'title' => __('profile.my_media')
        ]);
    }
}

