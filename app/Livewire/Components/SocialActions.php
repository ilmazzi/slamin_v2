<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class SocialActions extends Component
{
    public $contentId;
    public $contentType; // 'poem', 'video', 'gallery', 'article'
    public $likesCount = 0;
    public $commentsCount = 0;
    public $viewsCount = 0;
    public $isLiked = false;
    public $showCounts = true;
    public $size = 'default'; // 'small', 'default', 'large'
    public $layout = 'horizontal'; // 'horizontal', 'vertical'

    public function mount()
    {
        // Simulate checking if user has liked this content
        // In production, you'd query the database
        $this->isLiked = false;
    }

    public function toggleLike()
    {
        if (!Auth::check()) {
            $this->dispatch('notify', [
                'message' => __('social.login_to_like'),
                'type' => 'warning'
            ]);
            return;
        }

        $this->isLiked = !$this->isLiked;
        
        if ($this->isLiked) {
            $this->likesCount++;
            $this->dispatch('notify', [
                'message' => __('social.liked'),
                'type' => 'success'
            ]);
        } else {
            $this->likesCount--;
        }

        // In production, you'd save to database here
        // $this->saveLikeToDatabase();
    }

    public function incrementViews()
    {
        $this->viewsCount++;
        // In production, save to database
    }

    public function openComments()
    {
        $this->dispatch('open-comments', [
            'contentId' => $this->contentId,
            'contentType' => $this->contentType
        ]);
    }

    public function share()
    {
        $this->dispatch('open-share-modal', [
            'contentId' => $this->contentId,
            'contentType' => $this->contentType
        ]);
    }

    public function render()
    {
        return view('livewire.components.social-actions');
    }
}

