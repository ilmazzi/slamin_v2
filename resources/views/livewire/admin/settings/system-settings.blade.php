<div>
    <h1>Impostazioni Sistema</h1>
    
    <div>
        @foreach($this->groups as $group => $displayName)
            <button wire:click="selectGroup('{{ $group }}')" 
                    class="{{ $activeGroup === $group ? 'active' : '' }}">
                {{ $displayName }}
            </button>
        @endforeach
    </div>

    <div>
        <h2>{{ $this->groups[$activeGroup] }}</h2>
        <form wire:submit="updateSettings">
            @if(isset($settings[$activeGroup]))
                @foreach($settings[$activeGroup] as $key => $setting)
                    <div>
                        <label>{{ $setting['display_name'] ?? ucfirst(str_replace('_', ' ', $key)) }}</label>
                        @if($setting['type'] === 'boolean')
                            <input type="checkbox" wire:model="settings.{{ $activeGroup }}.{{ $key }}.value">
                        @elseif($setting['type'] === 'json')
                            <textarea wire:model="settings.{{ $activeGroup }}.{{ $key }}.value">{{ is_array($setting['value']) ? json_encode($setting['value']) : $setting['value'] }}</textarea>
                        @else
                            <input type="text" wire:model="settings.{{ $activeGroup }}.{{ $key }}.value">
                        @endif
                        @if(isset($setting['description']))
                            <small>{{ $setting['description'] }}</small>
                        @endif
                    </div>
                @endforeach
            @endif
            <button type="submit">Salva Impostazioni</button>
        </form>
    </div>

    <div>
        <button wire:click="resetSettings" wire:confirm="Sei sicuro di voler resettare le impostazioni?">Reset Impostazioni</button>
    </div>

    @if (session()->has('message'))
        <div>{{ session('message') }}</div>
    @endif
</div>

