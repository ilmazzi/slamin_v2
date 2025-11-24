<?php

namespace App\Livewire\Forum\Moderation;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use App\Models\Subreddit;
use App\Models\ForumReport;
use Illuminate\Support\Facades\Auth;

class Reports extends Component
{
    use WithPagination;

    public Subreddit $subreddit;
    public $filter = 'pending'; // pending, reviewed, all

    public function mount(Subreddit $subreddit)
    {
        if (!$subreddit->isModerator(Auth::user())) {
            abort(403, 'Non sei un moderatore di questo subreddit');
        }

        $this->subreddit = $subreddit;
    }

    public function title(): string
    {
        return 'Segnalazioni - ' . $this->subreddit->name;
    }

    public function updatedFilter()
    {
        $this->resetPage();
    }

    public function getReportsProperty()
    {
        $query = ForumReport::with(['reporter', 'target', 'handler'])
            ->where(function ($q) {
                // Get reports for posts in this subreddit
                $q->whereHasMorph('target', [\App\Models\ForumPost::class], function ($query) {
                    $query->where('subreddit_id', $this->subreddit->id);
                })
                // Or comments on posts in this subreddit
                ->orWhereHasMorph('target', [\App\Models\ForumComment::class], function ($query) {
                    $query->whereHas('post', function ($q) {
                        $q->where('subreddit_id', $this->subreddit->id);
                    });
                });
            });

        if ($this->filter !== 'all') {
            $query->where('status', $this->filter);
        }

        return $query->latest()->paginate(20);
    }

    public function resolve($reportId, $notes = null)
    {
        $report = ForumReport::findOrFail($reportId);
        $report->resolve(Auth::user(), $notes);
        
        session()->flash('success', 'Segnalazione risolta');
    }

    public function dismiss($reportId, $notes = null)
    {
        $report = ForumReport::findOrFail($reportId);
        $report->dismiss(Auth::user(), $notes);
        
        session()->flash('success', 'Segnalazione respinta');
    }

    public function deleteContent($reportId)
    {
        $report = ForumReport::findOrFail($reportId);
        
        if ($report->target instanceof \App\Models\ForumPost) {
            $report->target->delete();
            $this->subreddit->decrementPostsCount();
        } elseif ($report->target instanceof \App\Models\ForumComment) {
            $report->target->softDelete(Auth::user());
            $report->target->post->decrementCommentsCount();
        }

        $report->resolve(Auth::user(), 'Contenuto rimosso');
        
        session()->flash('success', 'Contenuto eliminato e segnalazione risolta');
    }

    public function render()
    {
        return view('livewire.forum.moderation.reports', [
            'reports' => $this->reports,
        ]);
    }
}

