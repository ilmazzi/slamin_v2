<div class="min-h-screen bg-gradient-to-br from-neutral-50 via-white to-primary-50 dark:from-neutral-900 dark:via-neutral-900 dark:to-neutral-800 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Page Header --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-primary-500 to-accent-600 mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-neutral-900 dark:text-white mb-2">
                Crea Nuovo Evento
            </h1>
            <p class="text-neutral-600 dark:text-neutral-400">
                Compila il form per creare un nuovo evento sulla piattaforma
            </p>
        </div>

        {{-- Progress Steps --}}
        <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg p-6 mb-6">
            {{-- Desktop Progress --}}
            <div class="hidden lg:flex items-center justify-between">
                @for($i = 1; $i <= $totalSteps; $i++)
                    <div class="flex items-center {{ $i < $totalSteps ? 'flex-1' : '' }}">
                        <button wire:click="goToStep({{ $i }})" 
                                type="button"
                                class="flex flex-col items-center group cursor-pointer">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mb-2 transition-all duration-300
                                        {{ $i <= $currentStep 
                                            ? 'bg-gradient-to-br from-primary-500 to-accent-600 text-white shadow-lg scale-110' 
                                            : 'bg-neutral-200 dark:bg-neutral-700 text-neutral-500 dark:text-neutral-400' }}">
                                @if($i == 1)
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                @elseif($i == 2)
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                @elseif($i == 3)
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                @elseif($i == 4)
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                @endif
                            </div>
                            <span class="text-sm font-medium {{ $i <= $currentStep ? 'text-primary-600 dark:text-primary-400' : 'text-neutral-500' }}">
                                Step {{ $i }}
                            </span>
                        </button>
                        @if($i < $totalSteps)
                            <div class="flex-1 h-1 mx-4 rounded-full {{ $i < $currentStep ? 'bg-primary-500' : 'bg-neutral-200 dark:bg-neutral-700' }}"></div>
                        @endif
                    </div>
                @endfor
            </div>

            {{-- Mobile Progress --}}
            <div class="lg:hidden">
                <div class="text-center mb-4">
                    <span class="text-sm font-medium text-neutral-600 dark:text-neutral-400">
                        Step {{ $currentStep }} di {{ $totalSteps }}
                    </span>
                </div>
                <div class="w-full bg-neutral-200 dark:bg-neutral-700 rounded-full h-2">
                    <div class="bg-gradient-to-r from-primary-500 to-accent-600 h-2 rounded-full transition-all duration-300"
                         style="width: {{ ($currentStep / $totalSteps) * 100 }}%">
                    </div>
                </div>
            </div>
        </div>

        {{-- Form --}}
        <form wire:submit.prevent="save">
            {{-- ========================================
                 STEP 1: BASIC INFORMATION
                 ======================================== --}}
            <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg p-6 mb-6 {{ $currentStep == 1 ? 'block' : 'hidden' }}">
                <div class="border-b border-neutral-200 dark:border-neutral-700 pb-4 mb-6">
                    <h2 class="text-2xl font-bold text-neutral-900 dark:text-white flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        Informazioni Base
                    </h2>
                    <p class="text-neutral-600 dark:text-neutral-400 mt-2">
                        Inserisci titolo, categoria e descrizione dell'evento
                    </p>
                </div>

                <div class="space-y-6">
                    {{-- Title --}}
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                            Titolo Evento *
                        </label>
                        <input type="text"
                               wire:model.live="title"
                               class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('title') border-red-500 @enderror"
                               placeholder="Es: Poetry Slam Roma 2025">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        @if(strlen($title) > 0)
                            <p class="mt-1 text-sm text-neutral-500">{{ strlen($title) }}/255 caratteri</p>
                        @endif
                    </div>

                    {{-- Subtitle Toggle --}}
                    <div class="bg-neutral-50 dark:bg-neutral-900/50 rounded-xl p-4">
                        <label class="flex items-center cursor-pointer group">
                            <input type="checkbox"
                                   wire:click="toggleSubtitle"
                                   class="w-5 h-5 text-primary-600 bg-neutral-100 dark:bg-neutral-800 border-neutral-300 dark:border-neutral-600 rounded focus:ring-primary-500"
                                   {{ $has_subtitle ? 'checked' : '' }}>
                            <span class="ml-3 text-sm font-medium text-neutral-700 dark:text-neutral-300 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                                {{ $has_subtitle ? 'Sottotitolo attivo' : 'Aggiungi sottotitolo (opzionale)' }}
                            </span>
                        </label>

                        @if($has_subtitle)
                            <div class="mt-4">
                                <input type="text"
                                       wire:model.live="subtitle"
                                       class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('subtitle') border-red-500 @enderror"
                                       placeholder="Es: Competizione nazionale di poesia">
                                @error('subtitle')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                @if(strlen($subtitle) > 0)
                                    <p class="mt-1 text-sm text-neutral-500">{{ strlen($subtitle) }}/255 caratteri</p>
                                @endif
                            </div>
                        @endif
                    </div>

                    {{-- Category & Visibility --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                Categoria *
                            </label>
                            <select wire:model.live="category"
                                    class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('category') border-red-500 @enderror">
                                <option value="">Seleziona categoria</option>
                                @foreach($categories as $key => $categoryName)
                                    <option value="{{ $key }}">{{ $categoryName }}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                Visibilità *
                            </label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="flex items-center justify-center px-4 py-3 rounded-xl border-2 cursor-pointer transition-all
                                              {{ $is_public ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20' : 'border-neutral-300 dark:border-neutral-600 hover:border-neutral-400' }}">
                                    <input type="radio"
                                           wire:model="is_public"
                                           value="1"
                                           class="sr-only">
                                    <span class="text-sm font-medium {{ $is_public ? 'text-primary-700 dark:text-primary-300' : 'text-neutral-700 dark:text-neutral-300' }}">
                                        Pubblico
                                    </span>
                                </label>
                                <label class="flex items-center justify-center px-4 py-3 rounded-xl border-2 cursor-pointer transition-all
                                              {{ !$is_public ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20' : 'border-neutral-300 dark:border-neutral-600 hover:border-neutral-400' }}">
                                    <input type="radio"
                                           wire:model="is_public"
                                           value="0"
                                           class="sr-only">
                                    <span class="text-sm font-medium {{ !$is_public ? 'text-primary-700 dark:text-primary-300' : 'text-neutral-700 dark:text-neutral-300' }}">
                                        Privato
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                            Descrizione
                        </label>
                        <textarea wire:model.live="description"
                                  rows="5"
                                  class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('description') border-red-500 @enderror"
                                  placeholder="Descrivi l'evento, cosa aspettarsi, programma..."></textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Requirements --}}
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                            Requisiti
                        </label>
                        <textarea wire:model.live="requirements"
                                  rows="3"
                                  class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                  placeholder="Eventuali requisiti per partecipare (es: maggiorenne, testo originale, ecc)"></textarea>
                        <p class="mt-1 text-xs text-neutral-500">Indica eventuali requisiti o condizioni per partecipare</p>
                    </div>
                </div>
            </div>

            {{-- ========================================
                 STEP 2: DATE & LOCATION
                 ======================================== --}}
            <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg p-6 mb-6 {{ $currentStep == 2 ? 'block' : 'hidden' }}">
                <div class="border-b border-neutral-200 dark:border-neutral-700 pb-4 mb-6">
                    <h2 class="text-2xl font-bold text-neutral-900 dark:text-white flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        Data & Luogo
                    </h2>
                    <p class="text-neutral-600 dark:text-neutral-400 mt-2">
                        Quando e dove si terrà l'evento
                    </p>
                </div>

                <div class="space-y-6">
                    {{-- Date & Time --}}
                    <div>
                        <h3 class="text-lg font-semibold text-neutral-900 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Data e Ora
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                    Data/Ora Inizio *
                                </label>
                                <input type="datetime-local"
                                       wire:model="start_datetime"
                                       class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('start_datetime') border-red-500 @enderror">
                                @error('start_datetime')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                    Data/Ora Fine *
                                </label>
                                <input type="datetime-local"
                                       wire:model="end_datetime"
                                       class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('end_datetime') border-red-500 @enderror">
                                @error('end_datetime')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Location Type --}}
                    <div>
                        <h3 class="text-lg font-semibold text-neutral-900 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Modalità Evento
                        </h3>

                        <div class="grid grid-cols-2 gap-4">
                            <label class="flex flex-col items-center justify-center p-6 rounded-xl border-2 cursor-pointer transition-all
                                          {{ !$is_online ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20' : 'border-neutral-300 dark:border-neutral-600 hover:border-neutral-400' }}">
                                <input type="radio"
                                       wire:model.live="is_online"
                                       value="0"
                                       class="sr-only">
                                <svg class="w-8 h-8 mb-2 {{ !$is_online ? 'text-primary-600 dark:text-primary-400' : 'text-neutral-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <span class="font-medium {{ !$is_online ? 'text-primary-700 dark:text-primary-300' : 'text-neutral-700 dark:text-neutral-300' }}">
                                    In Presenza
                                </span>
                            </label>

                            <label class="flex flex-col items-center justify-center p-6 rounded-xl border-2 cursor-pointer transition-all
                                          {{ $is_online ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20' : 'border-neutral-300 dark:border-neutral-600 hover:border-neutral-400' }}">
                                <input type="radio"
                                       wire:model.live="is_online"
                                       value="1"
                                       class="sr-only">
                                <svg class="w-8 h-8 mb-2 {{ $is_online ? 'text-primary-600 dark:text-primary-400' : 'text-neutral-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                </svg>
                                <span class="font-medium {{ $is_online ? 'text-primary-700 dark:text-primary-300' : 'text-neutral-700 dark:text-neutral-300' }}">
                                    Online
                                </span>
                            </label>
                        </div>
                    </div>

                    {{-- Online URL --}}
                    @if($is_online)
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4">
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                URL Evento Online *
                            </label>
                            <input type="url"
                                   wire:model="online_url"
                                   class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('online_url') border-red-500 @enderror"
                                   placeholder="https://zoom.us/...">
                            @error('online_url')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    {{-- Physical Location --}}
                    @if(!$is_online)
                        <div class="space-y-4">
                            {{-- Venue Name --}}
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                    Nome Venue
                                </label>
                                <input type="text"
                                       wire:model="venue_name"
                                       class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                       placeholder="Es: Teatro Argentina">
                            </div>

                            {{-- Address --}}
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                    Indirizzo
                                </label>
                                <input type="text"
                                       wire:model="venue_address"
                                       class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                       placeholder="Via, numero civico">
                            </div>

                            {{-- City, Postcode, Country --}}
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                        Città
                                    </label>
                                    <input type="text"
                                           wire:model="city"
                                           class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                           placeholder="Roma">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                        CAP
                                    </label>
                                    <input type="text"
                                           wire:model="postcode"
                                           class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                           placeholder="00100">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                        Paese
                                    </label>
                                    <select wire:model="country"
                                            class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                        <option value="IT">Italia</option>
                                        <option value="CH">Svizzera</option>
                                        <option value="FR">Francia</option>
                                        <option value="DE">Germania</option>
                                        <option value="ES">Spagna</option>
                                        <option value="UK">Regno Unito</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Coordinates - Hidden but available for map integration --}}
                            <input type="hidden" wire:model="latitude">
                            <input type="hidden" wire:model="longitude">

                            {{-- TODO: Map Integration Placeholder --}}
                            <div class="bg-neutral-100 dark:bg-neutral-900 rounded-xl p-8 text-center border-2 border-dashed border-neutral-300 dark:border-neutral-700">
                                <svg class="w-12 h-12 text-neutral-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                </svg>
                                <p class="text-neutral-600 dark:text-neutral-400">
                                    Mappa interattiva (da implementare)
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ========================================
                 STEP 3: DETAILS
                 ======================================== --}}
            <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg p-6 mb-6 {{ $currentStep == 3 ? 'block' : 'hidden' }}">
                <div class="border-b border-neutral-200 dark:border-neutral-700 pb-4 mb-6">
                    <h2 class="text-2xl font-bold text-neutral-900 dark:text-white flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        Dettagli & Media
                    </h2>
                    <p class="text-neutral-600 dark:text-neutral-400 mt-2">
                        Immagine, video promozionale e biglietti
                    </p>
                </div>

                <div class="space-y-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        {{-- Media --}}
                        <div class="space-y-4">
                            <div class="bg-neutral-50 dark:bg-neutral-900/50 rounded-xl p-4">
                                <h3 class="font-semibold text-neutral-900 dark:text-white mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Media
                                </h3>

                                {{-- Image Upload --}}
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                        Immagine Copertina
                                    </label>
                                    <input type="file"
                                           wire:model="event_image"
                                           accept="image/*"
                                           class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                    @error('event_image')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-neutral-500">Max 2MB (JPG, PNG, GIF)</p>

                                    @if ($event_image)
                                        <div class="mt-3">
                                            <img src="{{ $event_image->temporaryUrl() }}" 
                                                 class="rounded-xl shadow-md max-h-48 mx-auto">
                                        </div>
                                    @endif
                                </div>

                                {{-- Promotional Video --}}
                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                        Video Promozionale (URL)
                                    </label>
                                    <input type="url"
                                           wire:model="promotional_video"
                                           class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                           placeholder="https://youtube.com/...">
                                    @error('promotional_video')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Payment --}}
                        <div class="space-y-4">
                            <div class="bg-neutral-50 dark:bg-neutral-900/50 rounded-xl p-4">
                                <h3 class="font-semibold text-neutral-900 dark:text-white mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Biglietti
                                </h3>

                                <label class="flex items-center cursor-pointer group mb-4">
                                    <input type="checkbox"
                                           wire:model.live="is_paid_event"
                                           class="w-5 h-5 text-primary-600 bg-neutral-100 dark:bg-neutral-800 border-neutral-300 dark:border-neutral-600 rounded focus:ring-primary-500">
                                    <span class="ml-3 text-sm font-medium text-neutral-700 dark:text-neutral-300 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                                        Evento a Pagamento
                                    </span>
                                </label>

                                @if($is_paid_event)
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                                Prezzo
                                            </label>
                                            <input type="number"
                                                   wire:model="ticket_price"
                                                   min="0"
                                                   step="0.01"
                                                   class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                                   placeholder="10.00">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                                Valuta
                                            </label>
                                            <select wire:model="ticket_currency"
                                                    class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                                <option value="EUR">EUR (€)</option>
                                                <option value="USD">USD ($)</option>
                                                <option value="GBP">GBP (£)</option>
                                                <option value="CHF">CHF</option>
                                            </select>
                                        </div>
                                    </div>
                                @else
                                    <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-3 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span class="text-sm font-medium text-green-700 dark:text-green-300">
                                            Evento Gratuito
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ========================================
                 STEP 4: SETTINGS
                 ======================================== --}}
            <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg p-6 mb-6 {{ $currentStep == 4 ? 'block' : 'hidden' }}">
                <div class="border-b border-neutral-200 dark:border-neutral-700 pb-4 mb-6">
                    <h2 class="text-2xl font-bold text-neutral-900 dark:text-white flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        Impostazioni
                    </h2>
                    <p class="text-neutral-600 dark:text-neutral-400 mt-2">
                        Partecipanti, inviti e stato pubblicazione
                    </p>
                </div>

                <div class="space-y-6">
                    {{-- Max Participants --}}
                    <div class="bg-neutral-50 dark:bg-neutral-900/50 rounded-xl p-4">
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                            Numero Massimo Partecipanti
                        </label>
                        <input type="number"
                               wire:model="max_participants"
                               min="1"
                               class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                               placeholder="Lascia vuoto per nessun limite">
                        <p class="mt-1 text-xs text-neutral-500">Opzionale - lascia vuoto se non c'è limite</p>
                    </div>

                    {{-- Allow Requests --}}
                    <div class="bg-neutral-50 dark:bg-neutral-900/50 rounded-xl p-4">
                        <label class="flex items-center cursor-pointer group">
                            <input type="checkbox"
                                   wire:model="allow_requests"
                                   class="w-5 h-5 text-primary-600 bg-neutral-100 dark:bg-neutral-800 border-neutral-300 dark:border-neutral-600 rounded focus:ring-primary-500">
                            <span class="ml-3 text-sm font-medium text-neutral-700 dark:text-neutral-300 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                                Permetti Richieste di Partecipazione
                            </span>
                        </label>
                        <p class="mt-2 text-xs text-neutral-500 ml-8">
                            Gli utenti potranno richiedere di partecipare all'evento
                        </p>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-3">
                            Stato Pubblicazione *
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="flex items-center justify-center px-4 py-4 rounded-xl border-2 cursor-pointer transition-all
                                          {{ $status === 'published' ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20' : 'border-neutral-300 dark:border-neutral-600 hover:border-neutral-400' }}">
                                <input type="radio"
                                       wire:model="status"
                                       value="published"
                                       class="sr-only">
                                <div class="text-center">
                                    <svg class="w-8 h-8 mb-2 mx-auto {{ $status === 'published' ? 'text-primary-600 dark:text-primary-400' : 'text-neutral-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span class="text-sm font-medium {{ $status === 'published' ? 'text-primary-700 dark:text-primary-300' : 'text-neutral-700 dark:text-neutral-300' }}">
                                        Pubblica Subito
                                    </span>
                                </div>
                            </label>

                            <label class="flex items-center justify-center px-4 py-4 rounded-xl border-2 cursor-pointer transition-all
                                          {{ $status === 'draft' ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20' : 'border-neutral-300 dark:border-neutral-600 hover:border-neutral-400' }}">
                                <input type="radio"
                                       wire:model="status"
                                       value="draft"
                                       class="sr-only">
                                <div class="text-center">
                                    <svg class="w-8 h-8 mb-2 mx-auto {{ $status === 'draft' ? 'text-primary-600 dark:text-primary-400' : 'text-neutral-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    <span class="text-sm font-medium {{ $status === 'draft' ? 'text-primary-700 dark:text-primary-300' : 'text-neutral-700 dark:text-neutral-300' }}">
                                        Salva come Bozza
                                    </span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ========================================
                 STEP 5: PREVIEW
                 ======================================== --}}
            <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg p-6 mb-6 {{ $currentStep == 5 ? 'block' : 'hidden' }}">
                <div class="border-b border-neutral-200 dark:border-neutral-700 pb-4 mb-6">
                    <h2 class="text-2xl font-bold text-neutral-900 dark:text-white flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                        Anteprima & Conferma
                    </h2>
                    <p class="text-neutral-600 dark:text-neutral-400 mt-2">
                        Verifica i dati prima di creare l'evento
                    </p>
                </div>

                <div class="space-y-4">
                    {{-- Basic Info --}}
                    <div class="bg-neutral-50 dark:bg-neutral-900/50 rounded-xl p-4">
                        <h3 class="font-semibold text-neutral-900 dark:text-white mb-3">Informazioni Base</h3>
                        <dl class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-neutral-600 dark:text-neutral-400">Titolo:</dt>
                                <dd class="font-medium text-neutral-900 dark:text-white">{{ $title ?: '-' }}</dd>
                            </div>
                            @if($subtitle)
                                <div class="flex justify-between">
                                    <dt class="text-neutral-600 dark:text-neutral-400">Sottotitolo:</dt>
                                    <dd class="font-medium text-neutral-900 dark:text-white">{{ $subtitle }}</dd>
                                </div>
                            @endif
                            <div class="flex justify-between">
                                <dt class="text-neutral-600 dark:text-neutral-400">Categoria:</dt>
                                <dd class="font-medium text-neutral-900 dark:text-white">{{ $categories[$category] ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-neutral-600 dark:text-neutral-400">Visibilità:</dt>
                                <dd class="font-medium text-neutral-900 dark:text-white">{{ $is_public ? 'Pubblico' : 'Privato' }}</dd>
                            </div>
                        </dl>
                    </div>

                    {{-- Date & Location --}}
                    <div class="bg-neutral-50 dark:bg-neutral-900/50 rounded-xl p-4">
                        <h3 class="font-semibold text-neutral-900 dark:text-white mb-3">Data & Luogo</h3>
                        <dl class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-neutral-600 dark:text-neutral-400">Inizio:</dt>
                                <dd class="font-medium text-neutral-900 dark:text-white">{{ $start_datetime ? date('d/m/Y H:i', strtotime($start_datetime)) : '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-neutral-600 dark:text-neutral-400">Fine:</dt>
                                <dd class="font-medium text-neutral-900 dark:text-white">{{ $end_datetime ? date('d/m/Y H:i', strtotime($end_datetime)) : '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-neutral-600 dark:text-neutral-400">Modalità:</dt>
                                <dd class="font-medium text-neutral-900 dark:text-white">{{ $is_online ? 'Online' : 'In Presenza' }}</dd>
                            </div>
                            @if(!$is_online && $city)
                                <div class="flex justify-between">
                                    <dt class="text-neutral-600 dark:text-neutral-400">Città:</dt>
                                    <dd class="font-medium text-neutral-900 dark:text-white">{{ $city }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>

                    {{-- Payment --}}
                    <div class="bg-neutral-50 dark:bg-neutral-900/50 rounded-xl p-4">
                        <h3 class="font-semibold text-neutral-900 dark:text-white mb-3">Biglietti</h3>
                        <dl class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-neutral-600 dark:text-neutral-400">Tipo:</dt>
                                <dd class="font-medium text-neutral-900 dark:text-white">
                                    {{ $is_paid_event ? 'A Pagamento' : 'Gratuito' }}
                                </dd>
                            </div>
                            @if($is_paid_event)
                                <div class="flex justify-between">
                                    <dt class="text-neutral-600 dark:text-neutral-400">Prezzo:</dt>
                                    <dd class="font-medium text-neutral-900 dark:text-white">
                                        {{ number_format($ticket_price, 2) }} {{ $ticket_currency }}
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </div>

                    {{-- Settings --}}
                    <div class="bg-neutral-50 dark:bg-neutral-900/50 rounded-xl p-4">
                        <h3 class="font-semibold text-neutral-900 dark:text-white mb-3">Impostazioni</h3>
                        <dl class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-neutral-600 dark:text-neutral-400">Max Partecipanti:</dt>
                                <dd class="font-medium text-neutral-900 dark:text-white">{{ $max_participants ?: 'Nessun limite' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-neutral-600 dark:text-neutral-400">Richieste:</dt>
                                <dd class="font-medium text-neutral-900 dark:text-white">{{ $allow_requests ? 'Permesse' : 'Non permesse' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-neutral-600 dark:text-neutral-400">Stato:</dt>
                                <dd class="font-medium text-neutral-900 dark:text-white">{{ $status === 'published' ? 'Pubblicato' : 'Bozza' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            {{-- Navigation Buttons --}}
            <div class="flex items-center justify-between gap-4">
                @if($currentStep > 1)
                    <button type="button"
                            wire:click="prevStep"
                            class="px-6 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 text-neutral-700 dark:text-neutral-300 font-medium hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Indietro
                    </button>
                @else
                    <div></div>
                @endif

                @if($currentStep < $totalSteps)
                    <button type="button"
                            wire:click="nextStep"
                            class="px-6 py-3 rounded-xl bg-gradient-to-r from-primary-500 to-accent-600 text-white font-medium hover:shadow-lg transition-all flex items-center gap-2">
                        Avanti
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                @else
                    <button type="submit"
                            class="px-8 py-4 rounded-xl bg-gradient-to-r from-primary-500 to-accent-600 text-white font-bold text-lg hover:shadow-lg transition-all flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ $status === 'published' ? 'Crea Evento' : 'Salva Bozza' }}
                    </button>
                @endif
            </div>
        </form>
    </div>
</div>

