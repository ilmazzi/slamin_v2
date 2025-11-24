<?php

namespace App\Livewire\Forum\Moderation;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use App\Models\Subreddit;
use App\Models\ForumPost;
use Illuminate\Support\Facades\Auth;

class ModerationQueue extends Component
{
    use WithPagination;

    public Subreddit $subreddit;

    public function mount(Subreddit $subreddit)
    {
        if (!$subreddit->isModerator(Auth::user())) {
            abort(403, 'Non sei un moderatore di questo subreddit');
        }

        $this->subreddit = $subreddit;
    }

    public function title(): string
    {
        return 'Coda Moderazione - ' . $this->subreddit->name;
    }

    public function getPendingPostsProperty()
    {
        return $this->subreddit->posts()
            ->whereNull('approved_at')
            ->with('user')
            ->latest()
            ->paginate(20);
    }

    public function approve($postId)
    {
        $post = ForumPost::findOrFail($postId);
        
        if ($post->subreddit_id !== $this->subreddit->id) {
            return;
        }

        $post->approve(Auth::user());
        session()->flash('success', 'Post approvato');
    }

    public function reject($postId)
    {
        $post = ForumPost::findOrFail($postId);
        
        if ($post->subreddit_id !== $this->subreddit->id) {
            return;
        }

        $post->delete();
        $this->subreddit->decrementPostsCount();
        
        session()->flash('success', 'Post rimosso');
    }

    public function render()
    {
        return view('livewire.forum.moderation.moderation-queue', [
            'pendingPosts' => $this->pendingPosts,
        ]);
    }
}

