<div class="p-6">
    <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-6">{{ __('admin.gig_positions.title') }}</h1>
    <p class="text-neutral-600 dark:text-neutral-400 mb-8">{{ __('admin.gig_positions.description') }}</p>
    
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
    
    <div class="mb-6">
        <button wire:click="create" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
            {{ __('admin.gig_positions.create') }}
        </button>
    </div>
    
    {{-- Placeholder for positions list --}}
    <div>
        <p class="text-neutral-600 dark:text-neutral-400">{{ __('admin.gig_positions.placeholder') }}</p>
    </div>
</div>

