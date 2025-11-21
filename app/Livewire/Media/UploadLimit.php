<?php

namespace App\Livewire\Media;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UploadLimit extends Component
{
    public function mount()
    {
        $user = Auth::user();

        // Se l'utente può caricare più video, reindirizza all'upload
        if ($user->canUploadMoreVideos()) {
            return $this->redirect(route('media.upload.video'), navigate: true);
        }
    }

    public function render()
    {
        $user = Auth::user();
        
        return view('livewire.media.upload-limit', [
            'user' => $user,
            'currentVideoCount' => $user->current_video_count,
            'currentVideoLimit' => $user->current_video_limit,
            'remainingUploads' => $user->remaining_video_uploads,
        ])->layout('components.layouts.app', ['title' => __('media.upload_limit_reached')]);
    }
}

