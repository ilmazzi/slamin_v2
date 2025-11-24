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
    public $filterStatus = 'pending'; // pending, resolved, all
    public $filterType = 'all'; // all, post, comment

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

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    public function updatedFilterType()
    {
        $this->resetPage();
    }

    public function getReportsProperty()
    {
        $query = ForumReport::with(['reporter', 'reportable', 'handledBy'])
            ->where(function ($q) {
                // Get reports for posts in this subreddit
                $q->whereHasMorph('reportable', [\App\Models\ForumPost::class], function ($query) {
                    $query->where('subreddit_id', $this->subreddit->id);
                })
                // Or comments on posts in this subreddit
                ->orWhereHasMorph('reportable', [\App\Models\ForumComment::class], function ($query) {
                    $query->whereHas('post', function ($q) {
                        $q->where('subreddit_id', $this->subreddit->id);
                    });
                });
            });

        if ($this->filterStatus !== 'all') {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterType === 'post') {
            $query->where('reportable_type', \App\Models\ForumPost::class);
        } elseif ($this->filterType === 'comment') {
            $query->where('reportable_type', \App\Models\ForumComment::class);
        }

        return $query->latest()->paginate(20);
    }

    public function removeContent($reportId)
    {
        $report = ForumReport::findOrFail($reportId);
        
        if ($report->reportable instanceof \App\Models\ForumPost) {
            $report->reportable->delete();
            $this->subreddit->decrementPostsCount();
        } elseif ($report->reportable instanceof \App\Models\ForumComment) {
            $report->reportable->delete();
        }

        $report->update([
            'status' => 'resolved',
            'handled_by' => Auth::id(),
            'resolved_at' => now(),
        ]);
        
        session()->flash('success', 'Contenuto rimosso');
    }

    public function dismissReport($reportId)
    {
        $report = ForumReport::findOrFail($reportId);
        
        $report->update([
            'status' => 'resolved',
            'handled_by' => Auth::id(),
            'resolved_at' => now(),
        ]);
        
        session()->flash('success', 'Segnalazione archiviata');
    }

    public function render()
    {
        return view('livewire.forum.moderation.reports', [
            'reports' => $this->reports,
        ]);
    }
}

