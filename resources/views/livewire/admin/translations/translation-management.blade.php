<div class="p-6 max-w-7xl mx-auto">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-4xl font-black text-neutral-900 dark:text-white mb-2" style="font-family: 'Crimson Pro', serif;">
            {{ __('admin.translations.title') }}
        </h1>
        <p class="text-lg text-neutral-600 dark:text-neutral-400">{{ __('admin.translations.description') }}</p>
    </div>
    
    {{-- Flash Messages --}}
    @if(session()->has('success'))
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-xl">
            <p class="text-green-800 dark:text-green-400 font-semibold">{{ session('success') }}</p>
        </div>
    @endif
    
    @if(session()->has('error'))
        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-xl">
            <p class="text-red-800 dark:text-red-400 font-semibold">{{ session('error') }}</p>
        </div>
    @endif
    
    {{-- Controls Bar --}}
    <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
            {{-- Language Selector --}}
            <div>
                <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                    {{ __('admin.translations.select_language') }}
                </label>
                <select wire:model.live="selectedLanguage" 
                        class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    @foreach($this->languages as $lang)
                        <option value="{{ $lang }}">{{ strtoupper($lang) }}</option>
                    @endforeach
                </select>
            </div>
            
            {{-- File Selector --}}
            <div>
                <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                    {{ __('admin.translations.select_file') }}
                </label>
                <select wire:model.live="selectedFile" 
                        class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    @foreach($this->translationFiles as $fileKey => $fileDisplayName)
                        <option value="{{ $fileKey }}">{{ $fileDisplayName }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Search --}}
            <div>
                <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                    🔍 Cerca
                </label>
                <input type="text" 
                       wire:model.live.debounce.300ms="search"
                       placeholder="Cerca chiave o testo..."
                       class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium focus:ring-2 focus:ring-primary-500 focus:border-transparent">
            </div>

            {{-- Filter Status --}}
            <div>
                <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                    Filtra
                </label>
                <select wire:model.live="filterStatus" 
                        class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="all">Tutte</option>
                    <option value="translated">Tradotte</option>
                    <option value="missing">Mancanti</option>
                </select>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex flex-wrap gap-3">
            <button wire:click="$toggle('showCreateLanguageModal')" 
                    class="px-5 py-2.5 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-colors">
                ➕ {{ __('admin.translations.add_language') }}
            </button>
            <button wire:click="syncLanguage('{{ $selectedLanguage }}')" 
                    class="px-5 py-2.5 bg-neutral-600 hover:bg-neutral-700 text-white font-bold rounded-xl transition-colors">
                🔄 {{ __('admin.translations.sync') }}
            </button>
            <button wire:click="downloadExport('excel')" 
                    wire:loading.attr="disabled"
                    class="px-5 py-2.5 bg-green-600 hover:bg-green-700 disabled:bg-neutral-400 disabled:cursor-not-allowed text-white font-bold rounded-xl transition-colors">
                <span wire:loading.remove wire:target="downloadExport">📊 Esporta Excel (Tutti i file)</span>
                <span wire:loading wire:target="downloadExport">⏳ Generazione Excel...</span>
            </button>
            <button wire:click="downloadExport('ods')" 
                    wire:loading.attr="disabled"
                    class="px-5 py-2.5 bg-purple-600 hover:bg-purple-700 disabled:bg-neutral-400 disabled:cursor-not-allowed text-white font-bold rounded-xl transition-colors">
                <span wire:loading.remove wire:target="downloadExport">📄 Esporta ODS/LibreOffice (Tutti i file)</span>
                <span wire:loading wire:target="downloadExport">⏳ Generazione ODS...</span>
            </button>
            <button wire:click="$toggle('showImportModal')" 
                    class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-colors">
                📤 {{ __('admin.translations.import') }}
            </button>
        </div>
    </div>
    
    {{-- Stats Cards --}}
    @if(isset($this->languageStats[$selectedLanguage]))
        @php $stats = $this->languageStats[$selectedLanguage]; @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-2xl p-6 border-2 border-blue-200 dark:border-blue-800">
                <h3 class="text-sm font-bold text-blue-600 dark:text-blue-400 mb-2">{{ __('admin.translations.total_keys') }}</h3>
                <p class="text-4xl font-black text-blue-900 dark:text-blue-100">{{ $stats['total_keys'] }}</p>
            </div>
            <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-2xl p-6 border-2 border-green-200 dark:border-green-800">
                <h3 class="text-sm font-bold text-green-600 dark:text-green-400 mb-2">{{ __('admin.translations.translated_keys') }}</h3>
                <p class="text-4xl font-black text-green-900 dark:text-green-100">{{ $stats['translated_keys'] }}</p>
            </div>
            <div class="bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 rounded-2xl p-6 border-2 border-red-200 dark:border-red-800">
                <h3 class="text-sm font-bold text-red-600 dark:text-red-400 mb-2">{{ __('admin.translations.missing_keys') }}</h3>
                <p class="text-4xl font-black text-red-900 dark:text-red-100">{{ $stats['missing_keys'] }}</p>
            </div>
            <div class="bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/20 dark:to-primary-800/20 rounded-2xl p-6 border-2 border-primary-200 dark:border-primary-800">
                <h3 class="text-sm font-bold text-primary-600 dark:text-primary-400 mb-2">{{ __('admin.translations.progress') }}</h3>
                <p class="text-4xl font-black text-primary-900 dark:text-primary-100">{{ $stats['progress_percentage'] }}%</p>
            </div>
        </div>
    @endif
    
    {{-- Translations Grid (Card-based) --}}
    <div class="space-y-4">
        @php
            $filtered = $this->getFilteredTranslationsProperty();
            $perPage = 20;
            $currentPage = $this->getPage();
            $offset = ($currentPage - 1) * $perPage;
            $paginated = array_slice($filtered, $offset, $perPage, true);
        @endphp

        @forelse($paginated as $key => $data)
            <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg border-2 {{ $data['is_missing'] ? 'border-red-200 dark:border-red-800 bg-red-50/50 dark:bg-red-900/10' : 'border-neutral-200 dark:border-neutral-700' }} p-6 hover:shadow-xl transition-all duration-300">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2 flex-wrap">
                            <div class="flex items-center gap-2">
                                @if(str_contains($key, '.'))
                                    <span class="text-xs text-neutral-400 dark:text-neutral-500">📁</span>
                                @endif
                                <code class="px-3 py-1.5 bg-neutral-100 dark:bg-neutral-900 rounded-lg text-sm font-bold text-neutral-900 dark:text-neutral-300 break-all">
                                    {{ $key }}
                                </code>
                            </div>
                            @if($data['is_translated'])
                                <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 rounded-lg text-xs font-bold">
                                    ✅ {{ __('admin.translations.translated') }}
                                </span>
                            @else
                                <span class="px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400 rounded-lg text-xs font-bold">
                                    ⚠️ {{ __('admin.translations.missing') }}
                                </span>
                            @endif
                        </div>
                        @if(str_contains($key, '.'))
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1 italic">
                                Chiave annidata ({{ str_replace('.', ' → ', $key) }})
                            </p>
                        @endif
                    </div>
                </div>

                {{-- Reference (Italian) --}}
                <div class="mb-4">
                    <label class="block text-xs font-bold text-neutral-500 dark:text-neutral-400 mb-2 uppercase tracking-wide">
                        🇮🇹 Italiano (IT) - Riferimento
                    </label>
                    <div class="p-4 bg-neutral-50 dark:bg-neutral-900 rounded-xl border border-neutral-200 dark:border-neutral-700 min-h-[60px]">
                        @if(!empty($data['reference']))
                            <p class="text-neutral-700 dark:text-neutral-300 font-medium whitespace-pre-wrap">{{ $data['reference'] }}</p>
                        @else
                            <p class="text-neutral-400 dark:text-neutral-500 italic">Nessun testo di riferimento</p>
                        @endif
                    </div>
                </div>

                {{-- Translation (Editable) --}}
                <div>
                    <label class="block text-xs font-bold text-neutral-500 dark:text-neutral-400 mb-2 uppercase tracking-wide">
                        {{ strtoupper($selectedLanguage) }} - {{ __('admin.translations.translation') }}
                    </label>
                    
                    @if($editingKey === $key)
                        {{-- Editing Mode --}}
                        <div class="space-y-3">
                            <textarea wire:model="editingValue" 
                                      rows="6"
                                      class="w-full px-4 py-3 rounded-xl border-2 border-primary-500 dark:border-primary-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium focus:ring-2 focus:ring-primary-500 focus:border-transparent resize-y"
                                      placeholder="Inserisci la traduzione qui..."></textarea>
                            <div class="flex gap-2">
                                <button wire:click="saveEditing" 
                                        wire:loading.attr="disabled"
                                        class="px-5 py-2.5 bg-green-600 hover:bg-green-700 disabled:bg-neutral-400 disabled:cursor-not-allowed text-white font-bold rounded-xl transition-colors">
                                    <span wire:loading.remove wire:target="saveEditing">💾 Salva</span>
                                    <span wire:loading wire:target="saveEditing">⏳ Salvataggio...</span>
                                </button>
                                <button wire:click="cancelEditing" 
                                        wire:loading.attr="disabled"
                                        class="px-5 py-2.5 bg-neutral-600 hover:bg-neutral-700 disabled:bg-neutral-400 disabled:cursor-not-allowed text-white font-bold rounded-xl transition-colors">
                                    ❌ Annulla
                                </button>
                            </div>
                        </div>
                    @else
                        {{-- View Mode --}}
                        <div class="space-y-3">
                            <div class="p-4 bg-neutral-50 dark:bg-neutral-900 rounded-xl border-2 border-neutral-200 dark:border-neutral-700 min-h-[100px]">
                                @if(!empty(trim($data['translation'])))
                                    <p class="text-neutral-700 dark:text-neutral-300 font-medium whitespace-pre-wrap">{{ $data['translation'] }}</p>
                                @else
                                    <p class="text-neutral-400 dark:text-neutral-500 italic">⚠️ Nessuna traduzione - Clicca "Modifica" per aggiungerla</p>
                                @endif
                            </div>
                            <button wire:click="startEditing('{{ $key }}')" 
                                    class="px-5 py-2.5 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-colors">
                                ✏️ {{ empty(trim($data['translation'])) ? 'Aggiungi Traduzione' : 'Modifica' }}
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg p-12 text-center">
                <div class="text-6xl mb-4">🔍</div>
                <h3 class="text-2xl font-bold text-neutral-900 dark:text-white mb-2">Nessuna traduzione trovata</h3>
                <p class="text-neutral-600 dark:text-neutral-400">
                    @if(!empty($search))
                        Prova a modificare i criteri di ricerca
                    @else
                        Non ci sono traduzioni da mostrare
                    @endif
                </p>
            </div>
        @endforelse

        {{-- Pagination --}}
        @if(count($filtered) > $perPage)
            <div class="mt-6 flex justify-center">
                <div class="flex gap-2">
                    @if($currentPage > 1)
                        <button wire:click="previousPage" 
                                class="px-4 py-2 bg-neutral-600 hover:bg-neutral-700 text-white font-bold rounded-xl transition-colors">
                            ← Precedente
                        </button>
                    @endif
                    
                    <div class="px-4 py-2 bg-primary-600 text-white font-bold rounded-xl">
                        Pagina {{ $currentPage }} di {{ ceil(count($filtered) / $perPage) }}
                    </div>
                    
                    @if($currentPage < ceil(count($filtered) / $perPage))
                        <button wire:click="nextPage" 
                                class="px-4 py-2 bg-neutral-600 hover:bg-neutral-700 text-white font-bold rounded-xl transition-colors">
                            Successiva →
                        </button>
                    @endif
                </div>
            </div>
        @endif
    </div>
    
    {{-- Modal per Import --}}
    @if($showImportModal)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4"
             x-data="{ show: true }"
             x-show="show"
             @import-started.window="show = true"
             @import-completed.window="setTimeout(() => show = false, 2000)">
            <div class="bg-white dark:bg-neutral-800 rounded-3xl shadow-2xl p-8 max-w-md w-full">
                <h2 class="text-2xl font-black text-neutral-900 dark:text-white mb-6" style="font-family: 'Crimson Pro', serif;">
                    {{ __('admin.translations.import_translations') }}
                </h2>
                
                {{-- Progress Bar --}}
                @if($isImporting)
                    <div class="mb-6 space-y-3" 
                         wire:poll.500ms
                         wire:key="import-progress-{{ now()->timestamp }}">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-bold text-neutral-700 dark:text-neutral-300">
                                {{ $importStatus ?: 'Importazione in corso...' }}
                            </span>
                            <span class="text-sm font-bold text-primary-600 dark:text-primary-400">
                                {{ $importProgress }}%
                            </span>
                        </div>
                        <div class="w-full bg-neutral-200 dark:bg-neutral-700 rounded-full h-3 overflow-hidden">
                            <div class="bg-gradient-to-r from-primary-500 to-primary-600 h-full rounded-full transition-all duration-500 ease-out"
                                 style="width: {{ $importProgress }}%">
                            </div>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-neutral-400">
                            <svg class="w-5 h-5 animate-spin text-primary-600" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Elaborazione in corso, attendere...</span>
                        </div>
                    </div>
                @endif
                
                <form wire:submit="importTranslations" 
                      class="space-y-6" 
                      @if($isImporting) style="display: none;" @endif>
                    <div>
                        <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('admin.translations.select_file') }}
                        </label>
                        <input type="file" 
                               wire:model.live="importFile" 
                               accept=".csv,.txt,.xlsx,.xls,.ods,application/vnd.oasis.opendocument.spreadsheet,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                               wire:loading.attr="disabled"
                               wire:target="importFile"
                               class="block w-full text-sm text-neutral-500 dark:text-neutral-400
                                      file:mr-4 file:py-3 file:px-5
                                      file:rounded-xl file:border-0
                                      file:text-sm file:font-bold
                                      file:bg-primary-600 file:text-white
                                      hover:file:bg-primary-700
                                      cursor-pointer
                                      disabled:opacity-50 disabled:cursor-not-allowed">
                        @error('importFile') 
                            <div class="mt-2 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
                                <span class="text-red-600 dark:text-red-400 text-sm font-bold block">{{ $message }}</span>
                                <p class="text-xs text-red-500 dark:text-red-500 mt-1">
                                    Assicurati di aver selezionato un file valido (CSV, Excel o LibreOffice ODS).
                                </p>
                            </div>
                        @enderror
                        
                        @if($importFile)
                            <div class="mt-2 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl">
                                <p class="text-sm text-green-700 dark:text-green-400 font-bold">
                                    ✓ File selezionato: {{ $importFile->getClientOriginalName() }}
                                </p>
                                <p class="text-xs text-green-600 dark:text-green-500 mt-1">
                                    Dimensione: {{ number_format($importFile->getSize() / 1024, 2) }} KB
                                </p>
                            </div>
                        @endif
                    </div>
                    
                    <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-xl border border-blue-200 dark:border-blue-800">
                        <p class="text-sm font-bold text-blue-800 dark:text-blue-300 mb-2">📋 Formato File Supportato</p>
                        <ul class="text-xs text-blue-700 dark:text-blue-400 space-y-1 list-disc list-inside">
                            <li><strong>Excel (.xlsx, .xls):</strong> File Excel con fogli multipli (uno per file di traduzione)</li>
                            <li><strong>LibreOffice (.ods):</strong> File OpenDocument Spreadsheet con fogli multipli (uno per file di traduzione)</li>
                            <li><strong>CSV (.csv):</strong> File CSV con colonne: Chiave, Italiano, Traduzione, Stato, Note</li>
                        </ul>
                        <p class="text-xs text-blue-700 dark:text-blue-400 mt-3">
                            <strong>Nota:</strong> Per Excel e LibreOffice, ogni foglio corrisponde a un file di traduzione. Il sistema rileva automaticamente il file corretto dal nome del foglio.
                        </p>
                    </div>
                    
                    <div class="flex gap-3 justify-end">
                        <button type="button" 
                                wire:click="$toggle('showImportModal')"
                                wire:loading.attr="disabled"
                                wire:target="importTranslations"
                                class="px-6 py-3 bg-neutral-600 hover:bg-neutral-700 disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold rounded-xl transition-colors">
                            {{ __('common.cancel') }}
                        </button>
                        <button type="submit" 
                                wire:loading.attr="disabled"
                                wire:target="importTranslations"
                                class="px-6 py-3 bg-primary-600 hover:bg-primary-700 disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold rounded-xl transition-colors flex items-center gap-2">
                            <span wire:loading.remove wire:target="importTranslations">
                                {{ __('admin.translations.import') }}
                            </span>
                            <span wire:loading wire:target="importTranslations" class="flex items-center gap-2">
                                <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Avvio...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Modal per nuova lingua --}}
    @if($showCreateLanguageModal)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
            <div class="bg-white dark:bg-neutral-800 rounded-3xl shadow-2xl p-8 max-w-md w-full">
                <h2 class="text-2xl font-black text-neutral-900 dark:text-white mb-6" style="font-family: 'Crimson Pro', serif;">
                    {{ __('admin.translations.create_language') }}
                </h2>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('admin.translations.language_code') }}
                        </label>
                        <input type="text" wire:model="newLanguageCode" maxlength="2" 
                               class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium"
                               placeholder="en, fr, es, etc.">
                        @error('newLanguageCode') 
                            <span class="text-red-600 text-sm mt-2 block">{{ $message }}</span> 
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('admin.translations.language_name') }}
                        </label>
                        <input type="text" wire:model="newLanguageName" 
                               class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium"
                               placeholder="English, Français, Español, etc.">
                        @error('newLanguageName') 
                            <span class="text-red-600 text-sm mt-2 block">{{ $message }}</span> 
                        @enderror
                    </div>
                    
                    <div class="flex gap-3 justify-end">
                        <button wire:click="$toggle('showCreateLanguageModal')" 
                                class="px-6 py-3 bg-neutral-600 hover:bg-neutral-700 text-white font-bold rounded-xl transition-colors">
                            {{ __('common.cancel') }}
                        </button>
                        <button wire:click="createLanguage" 
                                class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-colors">
                            {{ __('common.create') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
