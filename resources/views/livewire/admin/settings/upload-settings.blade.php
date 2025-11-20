<div>
    <h1>Impostazioni Upload</h1>
    
    <form wire:submit="updateSettings">
        @foreach($settings as $key => $value)
            <div>
                <label>{{ ucfirst(str_replace('_', ' ', $key)) }}</label>
                <input type="text" wire:model="settings.{{ $key }}">
            </div>
        @endforeach
        <button type="submit">Salva</button>
    </form>

    @if (session()->has('message'))
        <div>{{ session('message') }}</div>
    @endif
</div>

