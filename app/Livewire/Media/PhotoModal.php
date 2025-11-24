<?php

namespace App\Livewire\Media;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Photo;
use App\Models\UnifiedComment;
use Illuminate\Support\Facades\Auth;
use App\Events\SocialInteractionReceived;

class PhotoModal extends Component
{
    public $photoId;
    public $photo;
    public $isOpen = false;
    public $newComment = '';

    #[On('openPhotoModal')]
    public function openModal($photoId)
    {
        $this->photoId = $photoId;
        $this->photo = Photo::with(['user'])
            ->withCount(['likes', 'comments', 'views'])
            ->find($photoId);
        
        if ($this->photo) {
            $this->isOpen = true;
            // Increment view count
            $this->photo->incrementViewCount();
        }
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->photo = null;
        $this->photoId = null;
        $this->newComment = '';
    }

    public function addComment()
    {
        if (!Auth::check()) {
            session()->flash('error', __('social.login_to_comment'));
            return;
        }

        $this->validate([
            'newComment' => 'required|string|min:2|max:1000',
        ]);

        $comment = UnifiedComment::create([
            'user_id' => Auth::id(),
            'commentable_type' => Photo::class,
            'commentable_id' => $this->photo->id,
            'content' => $this->newComment,
            'status' => 'approved',
        ]);

        // Update counter
        $this->photo->increment('comment_count');

        // Send notification to photo owner if different from commenter
        if ($this->photo->user_id !== Auth::id()) {
            event(new SocialInteractionReceived($comment, Auth::user(), $this->photo->user, $this->photo, 'comment'));
        }

        // Reset form and refresh photo
        $this->newComment = '';
        $this->photo->refresh();
        $this->photo->loadCount(['likes', 'comments', 'views']);

        session()->flash('success', __('social.comment_added'));
    }

    public function render()
    {
        return view('livewire.media.photo-modal');
    }
}


