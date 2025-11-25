<?php

namespace App\Livewire\Moderation;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class ReportsDashboard extends Component
{
    use WithPagination;

    public $statusFilter = 'all'; // all, pending, investigating, resolved, dismissed
    public $searchTerm = '';
    public $selectedReport = null;
    public $showResolveModal = false;
    public $resolutionNotes = '';
    public $showContentModal = false;
    public $selectedContent = null;

    protected $queryString = [
        'statusFilter' => ['except' => 'all'],
        'searchTerm' => ['except' => ''],
    ];

    public function mount()
    {
        // Check if user is admin or moderator
        if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('moderator')) {
            abort(403, 'Accesso non autorizzato');
        }
    }

    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function markInvestigating($reportId)
    {
        $report = Report::findOrFail($reportId);
        
        $report->update([
            'status' => Report::STATUS_INVESTIGATING,
        ]);

        $this->dispatch('notify', [
            'message' => __('report.status_updated'),
            'type' => 'success'
        ]);
    }

    public function openResolveModal($reportId)
    {
        $this->selectedReport = Report::with(['user', 'reportable'])->findOrFail($reportId);
        $this->resolutionNotes = '';
        $this->showResolveModal = true;
    }

    public function closeResolveModal()
    {
        $this->showResolveModal = false;
        $this->selectedReport = null;
        $this->resolutionNotes = '';
    }

    public function viewContent($reportId)
    {
        $report = Report::with(['reportable'])->findOrFail($reportId);
        
        if (!$report->reportable) {
            $this->dispatch('notify', [
                'message' => __('report.content_not_available'),
                'type' => 'warning'
            ]);
            return;
        }

        $this->selectedContent = [
            'type' => class_basename($report->reportable_type),
            'data' => $report->reportable,
            'report' => $report,
        ];
        
        $this->showContentModal = true;
    }

    public function closeContentModal()
    {
        $this->showContentModal = false;
        $this->selectedContent = null;
    }

    public function resolveReport()
    {
        if (!$this->selectedReport) {
            return;
        }

        $this->selectedReport->update([
            'status' => Report::STATUS_RESOLVED,
            'resolved_by' => Auth::id(),
            'resolved_at' => now(),
            'resolution_notes' => $this->resolutionNotes,
        ]);

        $this->dispatch('notify', [
            'message' => __('report.report_resolved'),
            'type' => 'success'
        ]);

        $this->closeResolveModal();
    }

    public function dismissReport($reportId)
    {
        $report = Report::findOrFail($reportId);
        
        $report->update([
            'status' => Report::STATUS_DISMISSED,
            'resolved_by' => Auth::id(),
            'resolved_at' => now(),
        ]);

        $this->dispatch('notify', [
            'message' => __('report.report_dismissed'),
            'type' => 'success'
        ]);
    }

    public function deleteContent($reportId)
    {
        $report = Report::with('reportable')->findOrFail($reportId);
        
        if ($report->reportable) {
            // Soft delete o hard delete in base al model
            try {
                $report->reportable->delete();
                
                // Mark report as resolved
                $report->update([
                    'status' => Report::STATUS_RESOLVED,
                    'resolved_by' => Auth::id(),
                    'resolved_at' => now(),
                    'resolution_notes' => 'Contenuto eliminato dal moderatore',
                ]);

                $this->dispatch('notify', [
                    'message' => __('report.content_deleted'),
                    'type' => 'success'
                ]);
            } catch (\Exception $e) {
                $this->dispatch('notify', [
                    'message' => __('report.error_deleting_content'),
                    'type' => 'error'
                ]);
            }
        }
    }

    public function getReportsProperty()
    {
        $query = Report::with(['user', 'reportable', 'resolver'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        // Search
        if ($this->searchTerm) {
            $query->where(function ($q) {
                $q->where('reason', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $this->searchTerm . '%')
                  ->orWhereHas('user', function ($userQuery) {
                      $userQuery->where('name', 'like', '%' . $this->searchTerm . '%');
                  });
            });
        }

        return $query->paginate(20);
    }

    public function getStatsProperty()
    {
        return [
            'pending' => Report::where('status', Report::STATUS_PENDING)->count(),
            'investigating' => Report::where('status', Report::STATUS_INVESTIGATING)->count(),
            'resolved' => Report::where('status', Report::STATUS_RESOLVED)->count(),
            'dismissed' => Report::where('status', Report::STATUS_DISMISSED)->count(),
            'total' => Report::count(),
        ];
    }

    public function getContentUrl($report)
    {
        if (!$report->reportable) {
            return null;
        }

        $type = class_basename($report->reportable_type);
        $content = $report->reportable;

        return match($type) {
            'Poem' => route('poems.show', $content->slug ?? $content->id),
            'Article' => route('articles.show', $content->id),
            'Event' => route('events.show', $content->id),
            'Video' => route('media.index') . '?tab=videos#video-' . $content->id,
            'Photo' => route('media.index') . '?tab=photos#photo-' . $content->id,
            default => null,
        };
    }

    public function render()
    {
        return view('livewire.moderation.reports-dashboard', [
            'reports' => $this->reports,
            'stats' => $this->stats,
        ])->layout('components.layouts.app', ['title' => __('report.moderation_title')]);
    }
}

