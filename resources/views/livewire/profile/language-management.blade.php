<div class="max-w-4xl mx-auto p-6">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-bold text-neutral-900 dark:text-white">
                {{ __('languages.manage_languages') }}
            </h2>
            <p class="text-neutral-600 dark:text-neutral-400 mt-1">
                {{ __('languages.manage_languages_desc') }}
            </p>
        </div>
        <a href="{{ route('profile.edit') }}" 
           class="px-4 py-2 bg-neutral-200 dark:bg-neutral-700 text-neutral-900 dark:text-white rounded-lg hover:bg-neutral-300 dark:hover:bg-neutral-600 transition">
            {{ __('common.back') }}
        </a>
    </div>

    {{-- Add Language Button --}}
    @if(!$showForm)
    <button wire:click="showAddForm" 
            class="w-full mb-6 px-6 py-4 bg-primary-500 hover:bg-primary-600 text-white rounded-lg font-semibold transition flex items-center justify-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        {{ __('languages.add_language') }}
    </button>
    @endif

    {{-- Form --}}
    @if($showForm)
    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-lg p-6 mb-6">
        <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">
            {{ $editingLanguage ? __('languages.edit_language') : __('languages.add_language') }}
        </h3>
        
        <form wire:submit.prevent="save" class="space-y-4">
            {{-- Language Search --}}
            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                    {{ __('languages.language_name') }}
                </label>
                <div class="relative">
                    <input type="text" 
                           wire:model.live="searchLanguage"
                           class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                           placeholder="{{ __('languages.search_language') }}"
                           autocomplete="off">
                    
                    @if($showLanguageDropdown && count($this->filteredLanguages) > 0)
                    <div class="absolute z-50 w-full mt-1 bg-white dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                        @foreach($this->filteredLanguages as $lang)
                        <button type="button" 
                                wire:click="selectLanguage('{{ $lang['name'] }}', '{{ $lang['code'] }}')"
                                class="w-full px-4 py-2 text-left hover:bg-neutral-100 dark:hover:bg-neutral-600 transition">
                            <span class="font-semibold text-neutral-900 dark:text-white">{{ $lang['name'] }}</span>
                            <span class="ml-2 text-sm text-neutral-500 dark:text-neutral-400">{{ $lang['code'] }}</span>
                        </button>
                        @endforeach
                    </div>
                    @endif
                </div>
                
                @if($language_name && $language_code)
                <div class="mt-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary-100 dark:bg-primary-900 text-primary-800 dark:text-primary-200">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        {{ $language_name }} ({{ $language_code }})
                    </span>
                </div>
                @endif
                
                @error('language_name')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Type and Level --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        {{ __('languages.type') }}
                    </label>
                    <select wire:model.live="type" 
                            class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="native">{{ __('languages.native') }}</option>
                        <option value="spoken">{{ __('languages.spoken') }}</option>
                        <option value="written">{{ __('languages.written') }}</option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                @if($type !== 'native')
                <div>
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        {{ __('languages.level') }}
                    </label>
                    <select wire:model="level" 
                            class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="">{{ __('languages.select_level') }}</option>
                        <option value="excellent">{{ __('languages.excellent') }}</option>
                        <option value="good">{{ __('languages.good') }}</option>
                        <option value="poor">{{ __('languages.poor') }}</option>
                    </select>
                    @error('level')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                @endif
            </div>

            @error('language')
                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror

            {{-- Actions --}}
            <div class="flex gap-3">
                <button type="submit" 
                        class="flex-1 px-6 py-2 bg-primary-500 hover:bg-primary-600 text-white rounded-lg font-semibold transition">
                    {{ $editingLanguage ? __('common.update') : __('common.add') }}
                </button>
                <button type="button" 
                        wire:click="resetForm"
                        class="px-6 py-2 bg-neutral-200 dark:bg-neutral-700 text-neutral-900 dark:text-white rounded-lg font-semibold hover:bg-neutral-300 dark:hover:bg-neutral-600 transition">
                    {{ __('common.cancel') }}
                </button>
            </div>
        </form>
    </div>
    @endif

    {{-- Languages List --}}
    @if($languages->count() > 0)
    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-neutral-50 dark:bg-neutral-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            {{ __('languages.language') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            {{ __('languages.type') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            {{ __('languages.level') }}
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            {{ __('common.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                    @foreach($languages as $language)
                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-700 transition">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-neutral-900 dark:text-white">{{ $language->language_name }}</div>
                            <div class="text-sm text-neutral-500 dark:text-neutral-400">{{ $language->language_code }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($language->type === 'native') bg-primary-100 dark:bg-primary-900 text-primary-800 dark:text-primary-200
                                @elseif($language->type === 'spoken') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                                @else bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200
                                @endif">
                                {{ $language->type_display }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($language->level)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($language->level === 'excellent') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                                    @elseif($language->level === 'good') bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                                    @else bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200
                                    @endif">
                                    {{ $language->level_display }}
                                </span>
                            @else
                                <span class="text-neutral-400 dark:text-neutral-500">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <button wire:click="editLanguage({{ $language->id }})"
                                        class="p-2 text-primary-600 dark:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                <button onclick="confirm('{{ __('languages.confirm_delete') }}') && @this.deleteLanguage({{ $language->id }})"
                                        class="p-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-lg p-12 text-center">
        <svg class="w-16 h-16 mx-auto text-neutral-400 dark:text-neutral-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
        </svg>
        <h3 class="text-lg font-semibold text-neutral-900 dark:text-white mb-2">
            {{ __('languages.no_languages') }}
        </h3>
        <p class="text-neutral-600 dark:text-neutral-400 mb-4">
            {{ __('languages.add_first_language') }}
        </p>
        <button wire:click="showAddForm" 
                class="px-6 py-2 bg-primary-500 hover:bg-primary-600 text-white rounded-lg font-semibold transition">
            {{ __('languages.add_language') }}
        </button>
    </div>
    @endif
</div>
