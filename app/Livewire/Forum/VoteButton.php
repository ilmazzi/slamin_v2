<?php

namespace App\Livewire\Forum;

use Livewire\Component;
use App\Models\ForumVote;
use Illuminate\Support\Facades\Auth;

class VoteButton extends Component
{
    public $voteable;
    public $voteableType;
    public $voteableId;
    public $currentVote = null;
    public $score = 0;

    public function mount($voteable)
    {
        $this->voteable = $voteable;
        $this->voteableType = get_class($voteable);
        $this->voteableId = $voteable->id;
        $this->score = $voteable->score;

        if (Auth::check()) {
            $this->currentVote = $voteable->getUserVote(Auth::user());
        }
    }

    public function vote($type)
    {
        if (!Auth::check()) {
            return $this->redirect(route('login'));
        }

        if (!in_array($type, ['upvote', 'downvote'])) {
            return;
        }

        $existingVote = ForumVote::where('user_id', Auth::id())
            ->where('voteable_type', $this->voteableType)
            ->where('voteable_id', $this->voteableId)
            ->first();

        // If clicking the same vote, remove it
        if ($existingVote && $existingVote->vote_type === $type) {
            // Remove vote
            if ($type === 'upvote') {
                $this->voteable->decrement('upvotes');
            } else {
                $this->voteable->decrement('downvotes');
            }
            
            $existingVote->delete();
            $this->currentVote = null;
        } else {
            // Change or add vote
            if ($existingVote) {
                // Change vote
                $oldType = $existingVote->vote_type;
                
                if ($oldType === 'upvote') {
                    $this->voteable->decrement('upvotes');
                    $this->voteable->increment('downvotes');
                } else {
                    $this->voteable->decrement('downvotes');
                    $this->voteable->increment('upvotes');
                }
                
                $existingVote->update(['vote_type' => $type]);
            } else {
                // New vote
                ForumVote::create([
                    'user_id' => Auth::id(),
                    'voteable_type' => $this->voteableType,
                    'voteable_id' => $this->voteableId,
                    'vote_type' => $type,
                ]);
                
                if ($type === 'upvote') {
                    $this->voteable->increment('upvotes');
                    
                    // Notify author (only for upvotes, every 5 upvotes to avoid spam)
                    if ($this->voteable->user_id !== Auth::id() && $this->voteable->upvotes % 5 === 0) {
                        $notificationClass = $this->voteableType === 'App\\Models\\ForumPost'
                            ? \App\Notifications\Forum\PostVotedNotification::class
                            : \App\Notifications\Forum\CommentVotedNotification::class;
                        
                        $this->voteable->user->notify(new $notificationClass(
                            $this->voteable,
                            Auth::user(),
                            $type
                        ));
                    }
                } else {
                    $this->voteable->increment('downvotes');
                }
            }
            
            $this->currentVote = $type;
        }

        // Update score
        $this->voteable->updateScore();
        $this->score = $this->voteable->score;

        // Emit event for parent components
        $this->dispatch('voteUpdated', [
            'voteableType' => $this->voteableType,
            'voteableId' => $this->voteableId,
            'score' => $this->score,
        ]);
    }

    public function render()
    {
        return view('livewire.forum.vote-button');
    }
}

