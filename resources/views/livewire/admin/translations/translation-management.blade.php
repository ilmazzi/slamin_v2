<div class="p-6">
    <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-6">{{ __('admin.translations.title') }}</h1>
    <p class="text-neutral-600 dark:text-neutral-400 mb-8">{{ __('admin.translations.description') }}</p>
    
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
    
    {{-- Language Selection and Stats --}}
    <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                {{ __('admin.translations.select_language') }}
            </label>
            <select wire:model.live="selectedLanguage" class="block w-full rounded-md border-neutral-300 dark:border-neutral-700 dark:bg-neutral-800">
                @foreach($this->languages as $lang)
                    <option value="{{ $lang }}">{{ strtoupper($lang) }}</option>
                @endforeach
            </select>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                {{ __('admin.translations.select_file') }}
            </label>
            <select wire:model.live="selectedFile" class="block w-full rounded-md border-neutral-300 dark:border-neutral-700 dark:bg-neutral-800">
                @foreach($this->translationFiles as $fileKey => $fileDisplayName)
                    <option value="{{ $fileKey }}">{{ $fileDisplayName }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="flex items-end gap-2">
            <button wire:click="$toggle('showCreateLanguageModal')" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                {{ __('admin.translations.add_language') }}
            </button>
            <button wire:click="syncLanguage('{{ $selectedLanguage }}')" class="px-4 py-2 bg-neutral-600 text-white rounded-lg hover:bg-neutral-700">
                {{ __('admin.translations.sync') }}
            </button>
        </div>
    </div>
    
    {{-- Stats for selected language --}}
    @if(isset($this->languageStats[$selectedLanguage]))
        @php $stats = $this->languageStats[$selectedLanguage]; @endphp
        <div class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="p-4 bg-white dark:bg-neutral-800 rounded-lg shadow">
                <h3 class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('admin.translations.total_keys') }}</h3>
                <p class="text-2xl font-bold text-neutral-900 dark:text-white">{{ $stats['total_keys'] }}</p>
            </div>
            <div class="p-4 bg-white dark:bg-neutral-800 rounded-lg shadow">
                <h3 class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('admin.translations.translated_keys') }}</h3>
                <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $stats['translated_keys'] }}</p>
            </div>
            <div class="p-4 bg-white dark:bg-neutral-800 rounded-lg shadow">
                <h3 class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('admin.translations.missing_keys') }}</h3>
                <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $stats['missing_keys'] }}</p>
            </div>
            <div class="p-4 bg-white dark:bg-neutral-800 rounded-lg shadow">
                <h3 class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('admin.translations.progress') }}</h3>
                <p class="text-2xl font-bold text-primary-600 dark:text-primary-400">{{ $stats['progress_percentage'] }}%</p>
            </div>
        </div>
    @endif
    
    {{-- Translation Data Table --}}
    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b border-neutral-200 dark:border-neutral-700 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-neutral-900 dark:text-white">
                {{ __('admin.translations.translations_for') }}: {{ strtoupper($selectedLanguage) }} - {{ $this->translationFiles[$selectedFile] ?? $selectedFile }}
            </h2>
            <div class="flex gap-2">
                <button wire:click="copyFromItalian" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                    {{ __('admin.translations.copy_from_italian') }}
                </button>
                <button wire:click="clearAll" wire:confirm="{{ __('admin.translations.confirm_clear') }}" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">
                    {{ __('admin.translations.clear_all') }}
                </button>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                <thead class="bg-neutral-50 dark:bg-neutral-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase">{{ __('admin.translations.key') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase">{{ __('admin.translations.italian') }} (IT)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase">{{ __('admin.translations.translation') }} ({{ strtoupper($selectedLanguage) }})</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase">{{ __('admin.translations.status') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                    @forelse($this->translationData as $key => $data)
                        <tr class="{{ $data['is_missing'] ? 'bg-red-50 dark:bg-red-900/20' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-neutral-900 dark:text-white">
                                <code class="text-xs">{{ $key }}</code>
                            </td>
                            <td class="px-6 py-4 text-sm text-neutral-600 dark:text-neutral-400">
                                {{ $data['reference'] }}
                            </td>
                            <td class="px-6 py-4">
                                <input 
                                    type="text" 
                                    value="{{ $data['translation'] }}"
                                    wire:change="saveTranslation('{{ $key }}', $event.target.value)"
                                    class="block w-full rounded-md border-neutral-300 dark:border-neutral-700 dark:bg-neutral-900 text-sm"
                                >
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($data['is_translated'])
                                    <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 rounded">{{ __('admin.translations.translated') }}</span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400 rounded">{{ __('admin.translations.missing') }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-neutral-500 dark:text-neutral-400">
                                {{ __('admin.translations.no_translations') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    {{-- Modal per nuova lingua --}}
    @if($showCreateLanguageModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-neutral-800 rounded-lg p-6 max-w-md w-full mx-4">
                <h2 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">{{ __('admin.translations.create_language') }}</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('admin.translations.language_code') }}
                        </label>
                        <input type="text" wire:model="newLanguageCode" maxlength="2" 
                               class="block w-full rounded-md border-neutral-300 dark:border-neutral-700 dark:bg-neutral-900"
                               placeholder="en, fr, es, etc.">
                        @error('newLanguageCode') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('admin.translations.language_name') }}
                        </label>
                        <input type="text" wire:model="newLanguageName" 
                               class="block w-full rounded-md border-neutral-300 dark:border-neutral-700 dark:bg-neutral-900"
                               placeholder="English, Français, Español, etc.">
                        @error('newLanguageName') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="flex gap-2 justify-end">
                        <button wire:click="$toggle('showCreateLanguageModal')" class="px-4 py-2 bg-neutral-600 text-white rounded-lg hover:bg-neutral-700">
                            {{ __('common.cancel') }}
                        </button>
                        <button wire:click="createLanguage" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                            {{ __('common.create') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

