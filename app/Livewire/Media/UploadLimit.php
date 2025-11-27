<?php

namespace App\Livewire\Media;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UploadLimit extends Component
{
    public function mount()
    {
        $user = Auth::user();

        // Se l'utente può caricare più video E più foto, reindirizza alla pagina media
        if ($user->canUploadMoreVideos() && $user->canUploadMorePhotos()) {
            return $this->redirect(route('media.index'), navigate: true);
        }
    }

    public function render()
    {
        $user = Auth::user();
        
        return view('livewire.media.upload-limit', [
            'user' => $user,
            'currentVideoCount' => $user->current_video_count,
            'currentVideoLimit' => $user->current_video_limit,
            'remainingVideoUploads' => $user->remaining_video_uploads,
            'currentPhotoCount' => $user->current_photo_count,
            'currentPhotoLimit' => $user->current_photo_limit,
            'remainingPhotoUploads' => $user->remaining_photo_uploads,
        ])->layout('components.layouts.app', ['title' => __('media.upload_limit_reached')]);
    }
}

