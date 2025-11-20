<div class="p-6">
    <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-6">{{ __('admin.placeholder_settings.title') }}</h1>
    <p class="text-neutral-600 dark:text-neutral-400 mb-8">{{ __('admin.placeholder_settings.description') }}</p>
    
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
                    {{ __('admin.placeholder_settings.poem_color') }}
                </label>
                <input type="color" 
                       wire:model="poem_placeholder_color" 
                       class="w-32 h-10 rounded border border-neutral-300 dark:border-neutral-700">
                <input type="text" 
                       wire:model="poem_placeholder_color" 
                       class="mt-2 block w-full rounded-md border-neutral-300 dark:border-neutral-700 dark:bg-neutral-800">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                    {{ __('admin.placeholder_settings.article_color') }}
                </label>
                <input type="color" 
                       wire:model="article_placeholder_color" 
                       class="w-32 h-10 rounded border border-neutral-300 dark:border-neutral-700">
                <input type="text" 
                       wire:model="article_placeholder_color" 
                       class="mt-2 block w-full rounded-md border-neutral-300 dark:border-neutral-700 dark:bg-neutral-800">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                    {{ __('admin.placeholder_settings.event_color') }}
                </label>
                <input type="color" 
                       wire:model="event_placeholder_color" 
                       class="w-32 h-10 rounded border border-neutral-300 dark:border-neutral-700">
                <input type="text" 
                       wire:model="event_placeholder_color" 
                       class="mt-2 block w-full rounded-md border-neutral-300 dark:border-neutral-700 dark:bg-neutral-800">
            </div>
            
            @error('validation')
                <div class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</div>
            @enderror
            
            <div class="flex gap-4">
                <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                    {{ __('common.save') }}
                </button>
            </div>
        </div>
    </form>
</div>

