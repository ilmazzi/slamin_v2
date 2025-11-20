<div>
    <h1>{{ __('admin.social_settings.title') }}</h1>
    <p>{{ __('admin.social_settings.description') }}</p>
    
    @if(session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @if(session()->has('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif
    
    <form wire:submit="update">
        {{-- Placeholder for settings form --}}
        <button type="submit">{{ __('common.save') }}</button>
        <button type="button" wire:click="resetToDefaults">{{ __('admin.social_settings.reset') }}</button>
    </form>
</div>

