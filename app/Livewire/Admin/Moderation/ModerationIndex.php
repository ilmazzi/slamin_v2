<?php

namespace App\Livewire\Admin\Moderation;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\Video;
use App\Models\Poem;
use App\Models\Event;
use App\Models\Photo;
use App\Models\Article;
use App\Models\Report;
use App\Services\LoggingService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ModerationIndex extends Component
{
    use WithPagination;

    #[Url]
    public $type = 'all'; // all, videos, poems, events, photos, articles

    #[Url]
    public $status = 'pending'; // pending, approved, rejected

    #[Url]
    public $sort = 'newest'; // newest, oldest, oldest_pending

    // Modal per note
    public $showNoteModal = false;
    public $selectedContentId = null;
    public $selectedContentType = null;
    public $moderationNotes = '';

    // Modal per report
    public $showReportModal = false;
    public $selectedReportId = null;
    public $reportNotes = '';
    public $reportAction = '';

    public function mount()
    {
        if (!Auth::check() || !Auth::user()->hasAnyRole(['admin', 'moderator'])) {
            abort(403, 'Accesso negato');
        }
    }

    public function updatingType()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function updatingSort()
    {
        $this->resetPage();
    }

    public function getModerationStatsProperty()
    {
        return [
            'videos' => [
                'pending' => Video::pending()->count(),
                'approved' => Video::approved()->count(),
                'rejected' => Video::rejected()->count(),
            ],
            'poems' => [
                'pending' => Poem::pending()->count(),
                'approved' => Poem::approved()->count(),
                'rejected' => Poem::rejected()->count(),
            ],
            'events' => [
                'pending' => Event::pending()->count(),
                'approved' => Event::approved()->count(),
                'rejected' => Event::rejected()->count(),
            ],
            'photos' => [
                'pending' => Photo::pending()->count(),
                'approved' => Photo::approved()->count(),
                'rejected' => Photo::rejected()->count(),
            ],
            'articles' => [
                'pending' => Article::pending()->count(),
                'approved' => Article::approved()->count(),
                'rejected' => Article::rejected()->count(),
            ],
            'reports' => [
                'pending' => Report::pending()->count(),
                'investigating' => Report::investigating()->count(),
                'resolved' => Report::resolved()->count(),
            ],
        ];
    }

    public function getPendingContentProperty()
    {
        return [
            'videos' => Video::pending()->with('user')->latest()->limit(5)->get(),
            'poems' => Poem::pending()->with('user')->latest()->limit(5)->get(),
            'events' => Event::pending()->with('organizer')->latest()->limit(5)->get(),
            'photos' => Photo::pending()->with('user')->latest()->limit(5)->get(),
            'articles' => Article::pending()->with('user')->latest()->limit(5)->get(),
        ];
    }

    public function getActiveReportsProperty()
    {
        return Report::pending()
            ->with(['user', 'reportable'])
            ->latest()
            ->limit(10)
            ->get()
            ->map(function($report) {
                if ($report->reportable) {
                    $content = $report->reportable;
                    $report->content_title = $content->title ?? $content->name ?? substr($content->content ?? '', 0, 50) . '...' ?? 'Contenuto #' . $report->reportable_id;
                } else {
                    $report->content_title = 'Contenuto non trovato';
                }
                return $report;
            });
    }

    private function getContentModel($type, $id)
    {
        return match($type) {
            'videos' => Video::find($id),
            'poems' => Poem::find($id),
            'events' => Event::find($id),
            'photos' => Photo::find($id),
            'articles' => Article::find($id),
            default => null,
        };
    }

    public function approveContent($type, $id)
    {
        $content = $this->getContentModel($type, $id);

        if (!$content) {
            session()->flash('error', 'Contenuto non trovato');
            return;
        }

        $notes = $this->moderationNotes;
        $success = $content->approve(Auth::user(), $notes);

        if ($success) {
            LoggingService::logAdmin('content_approved', [
                'content_type' => $type,
                'content_id' => $id,
                'content_title' => $content->title ?? $content->content ?? 'N/A',
                'moderator_id' => Auth::id(),
                'moderator_name' => Auth::user()->name,
                'notes' => $notes
            ], get_class($content), $id);

            session()->flash('message', 'Contenuto approvato con successo');
            $this->closeNoteModal();
        } else {
            session()->flash('error', 'Errore durante l\'approvazione');
        }
    }

    public function rejectContent($type, $id)
    {
        $content = $this->getContentModel($type, $id);

        if (!$content) {
            session()->flash('error', 'Contenuto non trovato');
            return;
        }

        $notes = $this->moderationNotes;
        $success = $content->reject(Auth::user(), $notes);

        if ($success) {
            // Aggiorna report relativi
            Report::where('reportable_type', get_class($content))
                ->where('reportable_id', $id)
                ->where('status', 'pending')
                ->update([
                    'status' => 'resolved',
                    'resolved_by' => Auth::id(),
                    'resolved_at' => now(),
                    'resolution_notes' => 'Contenuto rifiutato: ' . $notes
                ]);

            LoggingService::logAdmin('content_rejected', [
                'content_type' => $type,
                'content_id' => $id,
                'moderator_id' => Auth::id(),
                'notes' => $notes
            ], get_class($content), $id);

            session()->flash('message', 'Contenuto rifiutato con successo');
            $this->closeNoteModal();
        } else {
            session()->flash('error', 'Errore durante il rifiuto');
        }
    }

    public function setPendingContent($type, $id)
    {
        $content = $this->getContentModel($type, $id);

        if (!$content) {
            session()->flash('error', 'Contenuto non trovato');
            return;
        }

        $notes = $this->moderationNotes;
        $success = $content->setPending($notes);

        if ($success) {
            session()->flash('message', 'Contenuto messo in attesa');
            $this->closeNoteModal();
        } else {
            session()->flash('error', 'Errore durante l\'operazione');
        }
    }

    public function openNoteModal($type, $id)
    {
        $this->selectedContentType = $type;
        $this->selectedContentId = $id;
        $this->moderationNotes = '';
        $this->showNoteModal = true;
    }

    public function closeNoteModal()
    {
        $this->showNoteModal = false;
        $this->selectedContentType = null;
        $this->selectedContentId = null;
        $this->moderationNotes = '';
    }

    public function handleReport($reportId, $action)
    {
        $report = Report::findOrFail($reportId);
        $notes = $this->reportNotes;

        switch ($action) {
            case 'investigate':
                $report->update([
                    'status' => 'investigating',
                    'resolved_by' => Auth::id(),
                    'resolved_at' => now(),
                    'resolution_notes' => $notes
                ]);
                $message = 'Segnalazione messa in investigazione';
                break;

            case 'resolve':
                $report->update([
                    'status' => 'resolved',
                    'resolved_by' => Auth::id(),
                    'resolved_at' => now(),
                    'resolution_notes' => $notes
                ]);

                if ($report->reportable) {
                    $report->reportable->reject(Auth::user(), $notes);
                }

                $message = 'Segnalazione risolta e contenuto rifiutato';
                break;

            case 'dismiss':
                $report->update([
                    'status' => 'dismissed',
                    'resolved_by' => Auth::id(),
                    'resolved_at' => now(),
                    'resolution_notes' => $notes
                ]);
                $message = 'Segnalazione respinta';
                break;
        }

        LoggingService::logAdmin('report_handled', [
            'report_id' => $reportId,
            'action' => $action,
            'moderator_id' => Auth::id(),
            'notes' => $notes,
        ], 'App\Models\Report', $reportId);

        session()->flash('message', $message);
        $this->closeReportModal();
    }

    public function openReportModal($reportId, $action = '')
    {
        $this->selectedReportId = $reportId;
        $this->reportAction = $action;
        $this->reportNotes = '';
        $this->showReportModal = true;
    }

    public function closeReportModal()
    {
        $this->showReportModal = false;
        $this->selectedReportId = null;
        $this->reportAction = '';
        $this->reportNotes = '';
    }

    private function applySorting($query, $sort)
    {
        return match($sort) {
            'newest' => $query->orderBy('created_at', 'desc'),
            'oldest' => $query->orderBy('created_at', 'asc'),
            'oldest_pending' => $query->orderBy('created_at', 'asc'),
            default => $query->orderBy('created_at', 'desc'),
        };
    }

    private function getContentByType($type, $status)
    {
        $query = match($type) {
            'videos' => Video::query(),
            'poems' => Poem::query(),
            'events' => Event::query(),
            'photos' => Photo::query(),
            'articles' => Article::query(),
            default => null,
        };

        if (!$query) {
            return collect();
        }

        return match($status) {
            'pending' => $query->pending(),
            'approved' => $query->approved(),
            'rejected' => $query->rejected(),
            default => $query,
        };
    }

    public function getContentsProperty()
    {
        if ($this->type === 'all') {
            $contents = collect();

            $videos = $this->applySorting($this->getContentByType('videos', $this->status)->with('user'), $this->sort)->limit(10)->get();
            $poems = $this->applySorting($this->getContentByType('poems', $this->status)->with('user'), $this->sort)->limit(10)->get();
            $events = $this->applySorting($this->getContentByType('events', $this->status)->with('organizer'), $this->sort)->limit(10)->get();
            $photos = $this->applySorting($this->getContentByType('photos', $this->status)->with('user'), $this->sort)->limit(10)->get();
            $articles = $this->applySorting($this->getContentByType('articles', $this->status)->with('user'), $this->sort)->limit(10)->get();

            $contents = $contents->merge($videos->map(fn($item) => (object) array_merge(['type' => 'videos'], $item->toArray())))
                                ->merge($poems->map(fn($item) => (object) array_merge(['type' => 'poems'], $item->toArray())))
                                ->merge($events->map(fn($item) => (object) array_merge(['type' => 'events'], $item->toArray())))
                                ->merge($photos->map(fn($item) => (object) array_merge(['type' => 'photos'], $item->toArray())))
                                ->merge($articles->map(fn($item) => (object) array_merge(['type' => 'articles'], $item->toArray())))
                                ->sortByDesc('created_at');

            return $contents;
        } else {
            return $this->applySorting($this->getContentByType($this->type, $this->status)->with($this->getRelationships($this->type)), $this->sort)->paginate(20);
        }
    }

    private function getRelationships($type)
    {
        return match($type) {
            'videos', 'poems', 'photos', 'articles' => ['user'],
            'events' => ['organizer'],
            default => [],
        };
    }

    public function render()
    {
        return view('livewire.admin.moderation.moderation-index')
            ->layout('components.layouts.app');
    }
}

