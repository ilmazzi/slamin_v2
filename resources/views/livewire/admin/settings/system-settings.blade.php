<div class="p-6">
    <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-2">{{ __('admin.settings.system.title') }}</h1>
    <p class="text-neutral-600 dark:text-neutral-400 mb-6">{{ __('admin.settings.system.description') }}</p>

    {{-- Tab Navigation --}}
    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow mb-6 border border-neutral-200 dark:border-neutral-700">
        <div class="flex flex-wrap border-b border-neutral-200 dark:border-neutral-700">
            @foreach($this->groups as $group => $groupKey)
                <button wire:click="selectGroup('{{ $group }}')" 
                        class="px-6 py-4 text-sm font-medium transition-colors border-b-2 
                               @if($activeGroup === $group) 
                                   border-primary-600 text-primary-600 dark:text-primary-400 
                               @else 
                                   border-transparent text-neutral-500 dark:text-neutral-400 hover:text-neutral-700 dark:hover:text-neutral-300 hover:border-neutral-300 dark:hover:border-neutral-600 
                               @endif">
                    {{ __('admin.settings.system.groups.' . $group) }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Settings Form --}}
    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow border border-neutral-200 dark:border-neutral-700 overflow-hidden">
        <form wire:submit="updateSettings">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-white mb-6">
                    {{ __('admin.settings.system.groups.' . $activeGroup) }}
                </h2>

                @if(isset($settings[$activeGroup]) && count($settings[$activeGroup]) > 0)
                    <div class="space-y-6">
                        @foreach($settings[$activeGroup] as $key => $setting)
                            <div class="border-b border-neutral-200 dark:border-neutral-700 pb-6 last:border-b-0 last:pb-0">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                    @php
                                        $displayNameKey = "admin.settings.system.setting.{$key}.display_name";
                                        $displayName = __($displayNameKey);
                                        if ($displayName === $displayNameKey) {
                                            $displayName = $setting['display_name'] ?? ucfirst(str_replace('_', ' ', $key));
                                        }
                                    @endphp
                                    {{ $displayName }}
                                </label>
                                
                                @if(isset($setting['description']) && !empty($setting['description']))
                                    @php
                                        $descriptionKey = "admin.settings.system.setting.{$key}.description";
                                        $description = __($descriptionKey);
                                        if ($description === $descriptionKey) {
                                            $description = $setting['description'] ?? '';
                                        }
                                    @endphp
                                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-3">
                                        {{ $description }}
                                    </p>
                                @endif

                                @if($setting['type'] === 'boolean')
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" 
                                               wire:model="settings.{{ $activeGroup }}.{{ $key }}.value"
                                               value="1"
                                               @if(($setting['value'] ?? false)) checked @endif
                                               class="sr-only peer">
                                        <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-neutral-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-neutral-600 peer-checked:bg-primary-600"></div>
                                        <span class="ml-3 text-sm text-neutral-700 dark:text-neutral-300">
                                            @if(($setting['value'] ?? false))
                                                {{ __('common.enabled') }}
                                            @else
                                                {{ __('common.disabled') }}
                                            @endif
                                        </span>
                                    </label>
                                @elseif($setting['type'] === 'json')
                                    <textarea wire:model="settings.{{ $activeGroup }}.{{ $key }}.value"
                                              rows="4"
                                              class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent font-mono text-sm"
                                              placeholder='["value1", "value2"]'>{{ is_array($setting['value']) ? json_encode($setting['value'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : ($setting['value'] ?? '') }}</textarea>
                                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                                        {{ __('admin.settings.system.json_format_hint') }}
                                    </p>
                                @elseif($setting['type'] === 'integer')
                                    <input type="number" 
                                           wire:model="settings.{{ $activeGroup }}.{{ $key }}.value"
                                           step="1"
                                           class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                           placeholder="{{ $setting['value'] ?? '' }}">
                                @elseif($setting['type'] === 'float')
                                    <input type="number" 
                                           wire:model="settings.{{ $activeGroup }}.{{ $key }}.value"
                                           step="0.01"
                                           class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                           placeholder="{{ $setting['value'] ?? '' }}">
                                @else
                                    <input type="text" 
                                           wire:model="settings.{{ $activeGroup }}.{{ $key }}.value"
                                           class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                           placeholder="{{ $setting['value'] ?? '' }}">
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <p class="text-neutral-500 dark:text-neutral-400">
                            {{ __('admin.settings.system.no_settings_for_group') }}
                        </p>
                    </div>
                @endif
            </div>

            {{-- Actions --}}
            <div class="px-6 py-4 bg-neutral-50 dark:bg-neutral-700/50 border-t border-neutral-200 dark:border-neutral-700 flex items-center justify-between">
                <button type="button" 
                        wire:click="resetSettings" 
                        wire:confirm="{{ __('admin.settings.system.reset_confirm') }}"
                        class="px-4 py-2 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700 rounded-lg transition-colors">
                    {{ __('admin.settings.system.reset') }}
                </button>
                <button type="submit" 
                        class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                    {{ __('admin.settings.system.save') }}
                </button>
            </div>
        </form>
    </div>

    {{-- Messaggi flash --}}
    @if (session()->has('message'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 3000)"
             class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 5000)"
             class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('error') }}
        </div>
    @endif
</div>
