<?php

namespace App\Livewire\Forum;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;
use App\Models\ForumPost;
use App\Models\ForumComment;
use Illuminate\Support\Facades\Auth;

class PostShow extends Component
{
    public ForumPost $post;
    public $commentContent = '';
    public $replyTo = null;
    public $sortComments = 'best'; // best, new, old, top
    public $editingContent = '';
    
    // Report
    public $showReportModal = false;
    public $reportTargetType = null;
    public $reportTargetId = null;
    public $reportReason = 'spam';
    public $reportDescription = '';

    public function mount(ForumPost $post)
    {
        $this->post = $post;
        $this->post->incrementViews();
    }

    public function title(): string
    {
        return $this->post->title . ' - ' . $this->post->subreddit->name;
    }

    public function getCommentsProperty()
    {
        $query = $this->post->rootComments()->with(['user', 'replies.user', 'replies.replies']);

        switch ($this->sortComments) {
            case 'new':
                $query->latest();
                break;
            case 'old':
                $query->oldest();
                break;
            case 'top':
                $query->orderBy('score', 'desc');
                break;
            case 'best':
            default:
                // Best algorithm considers score and time
                $query->selectRaw('forum_comments.*, (score / POW((TIMESTAMPDIFF(HOUR, created_at, NOW()) + 2), 0.8)) as best_score')
                      ->orderBy('best_score', 'desc');
                break;
        }

        return $query->get();
    }

    public function getUserVoteProperty()
    {
        if (!Auth::check()) {
            return null;
        }

        return $this->post->getUserVote(Auth::user());
    }

    public function getIsModeratorProperty()
    {
        if (!Auth::check()) {
            return false;
        }

        return $this->post->subreddit->isModerator(Auth::user());
    }

    public function postComment()
    {
        if (!Auth::check()) {
            return $this->redirect(route('login'));
        }

        $this->validate([
            'commentContent' => 'required|string|min:1|max:10000',
        ]);

        $comment = ForumComment::create([
            'post_id' => $this->post->id,
            'parent_id' => $this->replyTo,
            'user_id' => Auth::id(),
            'content' => $this->commentContent,
            'depth' => $this->replyTo ? ForumComment::find($this->replyTo)->depth + 1 : 0,
        ]);

        $this->post->incrementCommentsCount();

        // Send notifications
        if ($this->replyTo) {
            // Notify parent comment author
            $parentComment = ForumComment::find($this->replyTo);
            if ($parentComment->user_id !== Auth::id()) {
                $parentComment->user->notify(new \App\Notifications\Forum\NewReplyNotification($comment));
            }
        } else {
            // Notify post author
            if ($this->post->user_id !== Auth::id()) {
                $this->post->user->notify(new \App\Notifications\Forum\NewCommentNotification($comment));
            }
        }

        $this->commentContent = '';
        $this->replyTo = null;

        session()->flash('success', 'Commento pubblicato');
    }

    public function setReplyTo($commentId)
    {
        $this->replyTo = $commentId;
    }

    public function cancelReply()
    {
        $this->replyTo = null;
    }

    #[On('lock-post')]
    public function toggleLock()
    {
        if (!$this->isModerator) {
            session()->flash('error', 'Non hai i permessi per bloccare post');
            return;
        }

        $this->post->update([
            'is_locked' => !$this->post->is_locked,
        ]);

        session()->flash('success', $this->post->is_locked ? 'Post bloccato' : 'Post sbloccato');
    }

    #[On('sticky-post')]
    public function toggleSticky()
    {
        if (!$this->isModerator) {
            session()->flash('error', 'Non hai i permessi per fissare post');
            return;
        }

        $this->post->update([
            'is_sticky' => !$this->post->is_sticky,
        ]);

        session()->flash('success', $this->post->is_sticky ? 'Post fissato in alto' : 'Post rimosso dall\'alto');
    }

    public function deletePost()
    {
        if (!Auth::check()) {
            return;
        }

        if (!$this->post->canDelete(Auth::user())) {
            session()->flash('error', 'Non hai i permessi per eliminare questo post');
            return;
        }

        $subreddit = $this->post->subreddit;
        $this->post->delete();
        $subreddit->decrementPostsCount();

        return $this->redirect(route('forum.subreddit.show', $subreddit), navigate: true);
    }

    public function deleteComment($commentId)
    {
        $comment = ForumComment::findOrFail($commentId);

        if ($comment->user_id !== Auth::id() && !$this->isModerator) {
            session()->flash('error', 'Non hai i permessi per eliminare questo commento');
            return;
        }

        $comment->delete();
        $this->post->decrementCommentsCount();

        session()->flash('success', 'Commento eliminato');
    }

    public function updateComment($commentId)
    {
        $comment = ForumComment::findOrFail($commentId);

        if ($comment->user_id !== Auth::id()) {
            return;
        }

        $this->validate([
            'editingContent' => 'required|string|min:1|max:10000',
        ]);

        $comment->update([
            'content' => $this->editingContent,
            'is_edited' => true,
        ]);

        session()->flash('success', 'Commento aggiornato');
    }

    public function replyToComment($commentId)
    {
        $this->replyTo = $commentId;
    }

    public function openReportModal($type, $id)
    {
        if (!Auth::check()) {
            return $this->redirect(route('login'));
        }

        $this->reportTargetType = $type;
        $this->reportTargetId = $id;
        $this->showReportModal = true;
    }

    public function closeReportModal()
    {
        $this->showReportModal = false;
        $this->reportTargetType = null;
        $this->reportTargetId = null;
        $this->reportReason = 'spam';
        $this->reportDescription = '';
    }

    public function submitReport()
    {
        if (!Auth::check()) {
            return;
        }

        $this->validate([
            'reportReason' => 'required|in:spam,harassment,hate_speech,inappropriate_content,misinformation,violence,self_harm,other',
            'reportDescription' => 'nullable|string|max:1000',
        ]);

        // Check if already reported
        $exists = \App\Models\ForumReport::where('reporter_id', Auth::id())
            ->where('target_type', $this->reportTargetType)
            ->where('target_id', $this->reportTargetId)
            ->where('status', 'pending')
            ->exists();

        if ($exists) {
            session()->flash('error', 'Hai già segnalato questo contenuto');
            $this->closeReportModal();
            return;
        }

        $report = \App\Models\ForumReport::create([
            'reporter_id' => Auth::id(),
            'target_type' => $this->reportTargetType,
            'target_id' => $this->reportTargetId,
            'reason' => $this->reportReason,
            'description' => $this->reportDescription,
            'status' => 'pending',
        ]);

        // Notify moderators
        $subreddit = $this->reportTargetType === 'App\\Models\\ForumPost' 
            ? \App\Models\ForumPost::find($this->reportTargetId)->subreddit
            : \App\Models\ForumComment::find($this->reportTargetId)->post->subreddit;

        $moderators = $subreddit->moderators()->with('user')->get()->pluck('user');
        
        $notificationClass = $this->reportTargetType === 'App\\Models\\ForumPost'
            ? \App\Notifications\Forum\PostReportedNotification::class
            : \App\Notifications\Forum\CommentReportedNotification::class;

        foreach ($moderators as $moderator) {
            $moderator->notify(new $notificationClass($report));
        }

        session()->flash('success', 'Segnalazione inviata. I moderatori la esamineranno al più presto.');
        $this->closeReportModal();
    }

    public function render()
    {
        return view('livewire.forum.post-show', [
            'comments' => $this->comments,
            'userVote' => $this->userVote,
            'isModerator' => $this->isModerator,
        ]);
    }
}

