<?php

namespace App\Livewire\Moderation;

use Livewire\Component;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class ReportModal extends Component
{
    public $showModal = false;
    public $itemId;
    public $itemType;
    public $reason = '';
    public $description = '';

    protected $listeners = ['openReportModal'];

    protected $rules = [
        'reason' => 'required|in:spam,inappropriate,violence,harassment,copyright,misinformation,other',
        'description' => 'nullable|string|max:1000',
    ];

    protected $messages = [
        'reason.required' => 'Seleziona un motivo per la segnalazione',
        'reason.in' => 'Motivo non valido',
        'description.max' => 'La descrizione non può superare i 1000 caratteri',
    ];

    public function openReportModal($itemId, $itemType)
    {
        $this->itemId = $itemId;
        $this->itemType = $itemType;
        $this->showModal = true;
        $this->reset(['reason', 'description']);
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['itemId', 'itemType', 'reason', 'description']);
        $this->resetValidation();
    }

    public function submitReport()
    {
        if (!Auth::check()) {
            $this->dispatch('notify', [
                'message' => __('report.login_required'),
                'type' => 'warning'
            ]);
            return;
        }

        $this->validate();

        // Map item type to model class
        $modelMap = [
            'poem' => 'App\Models\Poem',
            'article' => 'App\Models\Article',
            'video' => 'App\Models\Video',
            'photo' => 'App\Models\Photo',
            'event' => 'App\Models\Event',
            'carousel' => 'App\Models\Carousel',
            'comment' => 'App\Models\Comment',
        ];

        $reportableType = $modelMap[$this->itemType] ?? null;

        if (!$reportableType) {
            $this->dispatch('notify', [
                'message' => __('report.invalid_type'),
                'type' => 'error'
            ]);
            return;
        }

        // Check if content exists
        $content = $reportableType::find($this->itemId);
        if (!$content) {
            $this->dispatch('notify', [
                'message' => __('report.content_not_found'),
                'type' => 'error'
            ]);
            return;
        }

        // Check if already reported
        $existingReport = Report::where('user_id', Auth::id())
            ->where('reportable_type', $reportableType)
            ->where('reportable_id', $this->itemId)
            ->whereIn('status', [Report::STATUS_PENDING, Report::STATUS_INVESTIGATING])
            ->first();

        if ($existingReport) {
            $this->dispatch('notify', [
                'message' => __('report.already_reported'),
                'type' => 'info'
            ]);
            $this->closeModal();
            return;
        }

        // Create report
        try {
            Report::create([
                'user_id' => Auth::id(),
                'reportable_type' => $reportableType,
                'reportable_id' => $this->itemId,
                'reason' => $this->reason,
                'description' => $this->description,
                'status' => Report::STATUS_PENDING,
            ]);

            $this->dispatch('notify', [
                'message' => __('report.success'),
                'type' => 'success'
            ]);

            // Update reported status in parent component if exists
            $this->dispatch('content-reported', [
                'itemId' => $this->itemId,
                'itemType' => $this->itemType
            ]);

            $this->closeModal();
        } catch (\Exception $e) {
            \Log::error('Report creation failed', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'item_id' => $this->itemId,
                'item_type' => $this->itemType
            ]);

            $this->dispatch('notify', [
                'message' => __('report.error'),
                'type' => 'error'
            ]);
        }
    }

    public function getReasons()
    {
        return [
            Report::REASON_SPAM => __('report.reasons.spam'),
            Report::REASON_INAPPROPRIATE => __('report.reasons.inappropriate'),
            Report::REASON_VIOLENCE => __('report.reasons.violence'),
            Report::REASON_HARASSMENT => __('report.reasons.harassment'),
            Report::REASON_COPYRIGHT => __('report.reasons.copyright'),
            Report::REASON_MISINFORMATION => __('report.reasons.misinformation'),
            Report::REASON_OTHER => __('report.reasons.other'),
        ];
    }

    public function render()
    {
        return view('livewire.moderation.report-modal', [
            'reasons' => $this->getReasons()
        ]);
    }
}

