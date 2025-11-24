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
    public $activeTab = 'posts'; // posts, comments

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
            ->get();
    }

    public function getPendingPostsCountProperty()
    {
        return $this->subreddit->posts()->whereNull('approved_at')->count();
    }

    public function getPendingCommentsProperty()
    {
        return \App\Models\ForumComment::whereHas('post', function($q) {
                $q->where('subreddit_id', $this->subreddit->id);
            })
            ->whereNull('approved_at')
            ->with('user', 'post')
            ->latest()
            ->get();
    }

    public function getPendingCommentsCountProperty()
    {
        return \App\Models\ForumComment::whereHas('post', function($q) {
                $q->where('subreddit_id', $this->subreddit->id);
            })
            ->whereNull('approved_at')
            ->count();
    }

    public function approvePost($postId)
    {
        $post = ForumPost::findOrFail($postId);
        
        if ($post->subreddit_id !== $this->subreddit->id) {
            return;
        }

        $post->update([
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);
        
        session()->flash('success', 'Post approvato');
    }

    public function removePost($postId)
    {
        $post = ForumPost::findOrFail($postId);
        
        if ($post->subreddit_id !== $this->subreddit->id) {
            return;
        }

        $post->delete();
        $this->subreddit->decrementPostsCount();
        
        session()->flash('success', 'Post rimosso');
    }

    public function approveComment($commentId)
    {
        $comment = \App\Models\ForumComment::findOrFail($commentId);
        
        $comment->update([
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);
        
        session()->flash('success', 'Commento approvato');
    }

    public function removeComment($commentId)
    {
        $comment = \App\Models\ForumComment::findOrFail($commentId);
        
        $comment->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::id(),
        ]);
        
        session()->flash('success', 'Commento rimosso');
    }

    public function render()
    {
        return view('livewire.forum.moderation.moderation-queue', [
            'pendingPosts' => $this->pendingPosts,
            'pendingPostsCount' => $this->pendingPostsCount,
            'pendingComments' => $this->pendingComments,
            'pendingCommentsCount' => $this->pendingCommentsCount,
        ]);
    }
}

