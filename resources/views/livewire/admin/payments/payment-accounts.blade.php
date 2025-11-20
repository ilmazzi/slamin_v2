<div class="p-6">
    <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-6">{{ __('admin.payment_accounts.title') }}</h1>
    <p class="text-neutral-600 dark:text-neutral-400 mb-8">{{ __('admin.payment_accounts.description') }}</p>
    
    @if(session()->has('success'))
        <div class="mb-4 p-4 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session()->has('error'))
        <div class="mb-4 p-4 bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400 rounded-lg">
            {{ session('error') }}
        </div>
    @endif
    
    {{-- Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="p-4 bg-white dark:bg-neutral-800 rounded-lg shadow">
            <h3 class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('admin.payment_accounts.total_users') }}</h3>
            <p class="text-2xl font-bold text-neutral-900 dark:text-white">{{ $this->stats['total_users'] ?? 0 }}</p>
        </div>
        <div class="p-4 bg-white dark:bg-neutral-800 rounded-lg shadow">
            <h3 class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('admin.payment_accounts.stripe_connected') }}</h3>
            <p class="text-2xl font-bold text-neutral-900 dark:text-white">{{ $this->stats['stripe_connected'] ?? 0 }}</p>
        </div>
        <div class="p-4 bg-white dark:bg-neutral-800 rounded-lg shadow">
            <h3 class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('admin.payment_accounts.paypal_connected') }}</h3>
            <p class="text-2xl font-bold text-neutral-900 dark:text-white">{{ $this->stats['paypal_connected'] ?? 0 }}</p>
        </div>
        <div class="p-4 bg-white dark:bg-neutral-800 rounded-lg shadow">
            <h3 class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('admin.payment_accounts.pending_verification') }}</h3>
            <p class="text-2xl font-bold text-neutral-900 dark:text-white">{{ $this->stats['pending_verification'] ?? 0 }}</p>
        </div>
    </div>
    
    {{-- Placeholder for Stripe Users, PayPal Users, and Recent Payments lists --}}
    <div>
        <p class="text-neutral-600 dark:text-neutral-400">{{ __('admin.payment_accounts.placeholder') }}</p>
    </div>
</div>

