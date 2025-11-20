<?php

namespace App\Livewire\Admin\Payments;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\SystemSetting;
use App\Models\TranslationPayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentAccounts extends Component
{
    use WithPagination;

    public $stats = [];
    public $recentPayments = [];
    public $stripePage = 1;
    public $paypalPage = 1;
    public $selectedTab = 'overview'; // overview, stripe, paypal, recent

    public function mount()
    {
        if (!Auth::check() || !Auth::user()->hasRole('admin')) {
            abort(403, 'Accesso negato');
        }

        $this->loadStats();
        $this->loadRecentPayments();
    }

    public function loadStats()
    {
        $this->stats = [
            'total_users' => User::count(),
            'stripe_connected' => User::where('stripe_connect_status', 'active')->count(),
            'paypal_connected' => User::where('paypal_verified', true)->count(),
            'pending_verification' => User::where('paypal_verified', false)
                ->whereNotNull('paypal_email')
                ->count(),
        ];
    }

    public function loadRecentPayments()
    {
        $this->recentPayments = TranslationPayment::with(['translator', 'client', 'poem'])
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->toArray();
    }

    public function getStripeUsersProperty()
    {
        return User::whereNotNull('stripe_connect_account_id')
            ->withCount(['translationPayments as payments_count' => function($query) {
                $query->where('status', 'completed');
            }])
            ->orderBy('stripe_connected_at', 'desc')
            ->paginate(10, ['*'], 'stripe_page');
    }

    public function getPaypalUsersProperty()
    {
        return User::whereNotNull('paypal_email')
            ->withCount(['translationPayments as payments_count' => function($query) {
                $query->where('status', 'completed');
            }])
            ->orderBy('paypal_connected_at', 'desc')
            ->paginate(10, ['*'], 'paypal_page');
    }

    public function verifyPayPal($userId)
    {
        $user = User::findOrFail($userId);
        if (!$user->paypal_email) {
            session()->flash('error', __('admin.payment_accounts.no_paypal_email'));
            return;
        }

        $user->update(['paypal_verified' => true]);

        Log::info('PayPal account verified by admin', [
            'user_id' => $user->id,
            'paypal_email' => $user->paypal_email,
            'admin_id' => Auth::id(),
        ]);

        session()->flash('success', __('admin.payment_accounts.paypal_verified', ['name' => $user->name]));
    }

    public function unverifyPayPal($userId)
    {
        $user = User::findOrFail($userId);
        $user->update(['paypal_verified' => false]);

        Log::info('PayPal account unverified by admin', [
            'user_id' => $user->id,
            'admin_id' => Auth::id(),
        ]);

        session()->flash('success', __('admin.payment_accounts.paypal_unverified', ['name' => $user->name]));
    }

    public function disconnectAccount($userId, $accountType)
    {
        $user = User::findOrFail($userId);

        if ($accountType === 'stripe') {
            $user->update([
                'stripe_connect_account_id' => null,
                'stripe_connect_status' => 'not_connected',
                'stripe_connect_details' => null,
                'stripe_connected_at' => null,
            ]);
        } else {
            $user->update([
                'paypal_email' => null,
                'paypal_merchant_id' => null,
                'paypal_verified' => false,
                'paypal_connected_at' => null,
            ]);
        }

        Log::info('Account disconnected by admin', [
            'user_id' => $user->id,
            'account_type' => $accountType,
            'admin_id' => Auth::id(),
        ]);

        session()->flash('success', __('admin.payment_accounts.account_disconnected', [
            'type' => $accountType,
            'name' => $user->name
        ]));
    }

    public function render()
    {
        return view('livewire.admin.payments.payment-accounts', [
            'stripeUsers' => $this->stripeUsers,
            'paypalUsers' => $this->paypalUsers,
        ])
            ->layout('components.layouts.app');
    }
}

