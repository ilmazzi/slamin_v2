<?php

namespace App\Livewire\Admin\Payments;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TranslationPayment;
use App\Services\PayoutService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Payouts extends Component
{
    use WithPagination;

    public $stats = [];
    public $payoutStatus = 'all'; // all, pending, transferred, manual_required

    public function mount()
    {
        if (!Auth::check() || !Auth::user()->hasRole('admin')) {
            abort(403, 'Accesso negato');
        }

        $this->loadStats();
    }

    public function loadStats()
    {
        $this->stats = [
            'total_payments' => TranslationPayment::where('status', 'completed')->count(),
            'total_amount' => TranslationPayment::where('status', 'completed')->sum('amount') ?? 0,
            'total_commission' => TranslationPayment::where('status', 'completed')->sum('commission_total') ?? 0,
            'pending_payouts' => TranslationPayment::where('payout_status', 'pending')->count(),
            'transferred_payouts' => TranslationPayment::where('payout_status', 'transferred')->count(),
            'manual_payouts' => TranslationPayment::where('payout_status', 'manual_required')->count(),
        ];
    }

    public function getPaymentsProperty()
    {
        $query = TranslationPayment::with(['poem', 'client', 'translator', 'gigApplication.gig'])
            ->where('status', 'completed');

        if ($this->payoutStatus !== 'all') {
            $query->where('payout_status', $this->payoutStatus);
        }

        return $query->orderBy('created_at', 'desc')
            ->paginate(20);
    }

    public function processPayout($paymentId, $action, $notes = null)
    {
        $payment = TranslationPayment::findOrFail($paymentId);
        $payoutService = new PayoutService();

        try {
            switch ($action) {
                case 'transfer':
                    $result = $payoutService->transferToTranslator($payment);
                    break;

                case 'manual':
                    $result = $payoutService->createManualPayout($payment, $notes);
                    break;

                case 'skip':
                    $payment->update([
                        'payout_status' => 'skipped',
                        'payout_notes' => $notes ?? __('admin.payouts.skipped_by_admin'),
                    ]);
                    $result = ['success' => true, 'message' => __('admin.payouts.skipped_success')];
                    break;

                default:
                    session()->flash('error', __('admin.payouts.invalid_action'));
                    return;
            }

            if ($result['success'] ?? false) {
                session()->flash('success', $result['message'] ?? __('admin.payouts.processed_success'));
                $this->loadStats();
            } else {
                session()->flash('error', $result['message'] ?? __('admin.payouts.process_error'));
            }
        } catch (\Exception $e) {
            Log::error('Payout processing error', [
                'payment_id' => $paymentId,
                'action' => $action,
                'error' => $e->getMessage(),
                'admin_id' => Auth::id(),
            ]);

            session()->flash('error', __('admin.payouts.process_error') . ': ' . $e->getMessage());
        }
    }

    public function processAll()
    {
        $payoutService = new PayoutService();
        
        try {
            $results = $payoutService->processPendingPayouts();
            $successCount = collect($results)->where('success', true)->count();
            $failCount = collect($results)->where('success', false)->count();

            session()->flash('success', __('admin.payouts.processed_all', [
                'success' => $successCount,
                'failed' => $failCount
            ]));
            
            $this->loadStats();
        } catch (\Exception $e) {
            Log::error('Process all payouts error', [
                'error' => $e->getMessage(),
                'admin_id' => Auth::id(),
            ]);

            session()->flash('error', __('admin.payouts.process_all_error') . ': ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.payments.payouts', [
            'payments' => $this->payments,
        ])
            ->layout('components.layouts.app');
    }
}

