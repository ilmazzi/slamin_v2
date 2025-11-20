<div class="p-6">
    <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-6">{{ __('admin.payouts.title') }}</h1>
    <p class="text-neutral-600 dark:text-neutral-400 mb-8">{{ __('admin.payouts.description') }}</p>
    
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
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="p-4 bg-white dark:bg-neutral-800 rounded-lg shadow">
            <h3 class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('admin.payouts.total_payments') }}</h3>
            <p class="text-2xl font-bold text-neutral-900 dark:text-white">{{ $this->stats['total_payments'] ?? 0 }}</p>
        </div>
        <div class="p-4 bg-white dark:bg-neutral-800 rounded-lg shadow">
            <h3 class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('admin.payouts.pending_payouts') }}</h3>
            <p class="text-2xl font-bold text-neutral-900 dark:text-white">{{ $this->stats['pending_payouts'] ?? 0 }}</p>
        </div>
        <div class="p-4 bg-white dark:bg-neutral-800 rounded-lg shadow">
            <h3 class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('admin.payouts.total_amount') }}</h3>
            <p class="text-2xl font-bold text-neutral-900 dark:text-white">€{{ number_format($this->stats['total_amount'] ?? 0, 2) }}</p>
        </div>
    </div>
    
    {{-- Placeholder for payments list --}}
    <div>
        <p class="text-neutral-600 dark:text-neutral-400">{{ __('admin.payouts.placeholder') }}</p>
    </div>
</div>

