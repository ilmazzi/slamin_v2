<div class="p-6">
    <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-6">{{ __('admin.peertube.title') }}</h1>
    <p class="text-neutral-600 dark:text-neutral-400 mb-8">{{ __('admin.peertube.description') }}</p>
    
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
    
    <form wire:submit="update">
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                    {{ __('admin.peertube.url') }}
                </label>
                <input type="url" 
                       wire:model="settings.peertube_url" 
                       class="block w-full rounded-md border-neutral-300 dark:border-neutral-700 dark:bg-neutral-800">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                    {{ __('admin.peertube.admin_username') }}
                </label>
                <input type="text" 
                       wire:model="settings.peertube_admin_username" 
                       class="block w-full rounded-md border-neutral-300 dark:border-neutral-700 dark:bg-neutral-800">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                    {{ __('admin.peertube.admin_password') }}
                </label>
                <input type="password" 
                       wire:model="settings.peertube_admin_password" 
                       class="block w-full rounded-md border-neutral-300 dark:border-neutral-700 dark:bg-neutral-800">
            </div>
            
            <div class="flex gap-4">
                <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                    {{ __('common.save') }}
                </button>
                <button type="button" wire:click="testConnection" class="px-6 py-2 bg-neutral-600 text-white rounded-lg hover:bg-neutral-700">
                    {{ __('admin.peertube.test_connection') }}
                </button>
            </div>
            
            @if($this->connectionTest)
                <div class="p-4 rounded-lg {{ $this->connectionTest['success'] ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400' : 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400' }}">
                    {{ $this->connectionTest['message'] }}
                </div>
            @endif
        </div>
    </form>
</div>

