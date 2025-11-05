{{-- INNOVATIVE EVENT CREATION FORM - Total Redesign --}}
<div class="min-h-screen bg-gradient-to-br from-neutral-50 via-primary-50/30 to-accent-50/20 dark:from-neutral-900 dark:via-primary-950/50 dark:to-accent-950/30 relative overflow-hidden" 
     x-data="{ 
         currentStep: @entangle('currentStep')
     }">
    
    {{-- ANIMATED BACKGROUND WITH SUBTLE BLOBS --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        {{-- Morphing Blobs (più sottili) --}}
        <div class="absolute top-0 -left-40 w-96 h-96 bg-gradient-to-br from-primary-200/40 to-primary-300/40 dark:from-primary-600/20 dark:to-primary-500/20 rounded-full blur-3xl animate-blob"></div>
        <div class="absolute top-40 -right-40 w-80 h-80 bg-gradient-to-br from-accent-200/40 to-accent-300/40 dark:from-accent-600/20 dark:to-accent-500/20 rounded-full blur-3xl animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-20 left-1/3 w-72 h-72 bg-gradient-to-br from-primary-300/30 to-accent-300/30 dark:from-primary-500/15 dark:to-accent-500/15 rounded-full blur-3xl animate-blob animation-delay-4000"></div>
    </div>

    <div class="relative z-10 max-w-[1400px] mx-auto px-6 py-12">
        {{-- HERO SECTION - Asymmetric Layout --}}
        <div class="grid lg:grid-cols-[1fr_2fr] gap-12 mb-12">
            {{-- Left: Steps Navigation (Vertical on desktop) --}}
            <div class="relative">
                {{-- Floating Card with Steps --}}
                <div class="sticky top-24 backdrop-blur-xl bg-white dark:bg-neutral-800 rounded-3xl p-8 border border-neutral-200 dark:border-neutral-700 shadow-2xl">
                    <div class="mb-8">
                        <h1 class="text-4xl font-black text-neutral-900 dark:text-white mb-3 tracking-tight">
                            Crea Evento
                        </h1>
                        <p class="text-neutral-700 dark:text-neutral-300">
                            Segui i passaggi per pubblicare il tuo evento
                        </p>
                    </div>

                    {{-- Vertical Steps --}}
                    <div class="space-y-4">
                        @php
                            $steps = [
                                ['icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Base', 'desc' => 'Informazioni essenziali'],
                                ['icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'title' => 'Data & Luogo', 'desc' => 'Quando e dove'],
                                ['icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z', 'title' => 'Media', 'desc' => 'Immagini e video'],
                                ['icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'title' => 'Impostazioni', 'desc' => 'Dettagli finali'],
                                ['icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z', 'title' => 'Anteprima', 'desc' => 'Revisione finale']
                            ];
                        @endphp
                        
                        @foreach($steps as $index => $step)
                            @php $stepNum = $index + 1; @endphp
                            <button wire:click="goToStep({{ $stepNum }})"
                                    type="button"
                                    class="group w-full flex items-center gap-4 p-4 rounded-2xl transition-all duration-300
                                           {{ $stepNum == $currentStep 
                                               ? 'bg-gradient-to-r from-primary-500/20 to-accent-500/20 border border-primary-500/50' 
                                               : 'hover:bg-white/5 border border-transparent' }}">
                                {{-- Step Number with Glow --}}
                                <div class="relative flex-shrink-0">
                                    @if($stepNum < $currentStep)
                                        {{-- Completed --}}
                                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center shadow-lg shadow-primary-500/50">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300
                                                    {{ $stepNum == $currentStep 
                                                        ? 'bg-gradient-to-br from-primary-500 to-accent-600 shadow-lg shadow-primary-500/50' 
                                                        : 'bg-neutral-100 dark:bg-neutral-700 group-hover:bg-neutral-200 dark:group-hover:bg-neutral-600' }}">
                                            <svg class="w-6 h-6 {{ $stepNum == $currentStep ? 'text-white' : 'text-neutral-500 dark:text-neutral-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $step['icon'] }}"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                
                                {{-- Step Info --}}
                                <div class="flex-1 text-left">
                                    <div class="font-bold {{ $stepNum == $currentStep ? 'text-neutral-900 dark:text-white' : 'text-neutral-700 dark:text-neutral-300 group-hover:text-neutral-900 dark:group-hover:text-white' }}">
                                        {{ $step['title'] }}
                                    </div>
                                    <div class="text-sm {{ $stepNum == $currentStep ? 'text-neutral-700 dark:text-neutral-300' : 'text-neutral-600 dark:text-neutral-400' }}">
                                        {{ $step['desc'] }}
                                    </div>
                                </div>
                            </button>
                        @endforeach
                    </div>

                    {{-- Progress Bar --}}
                    <div class="mt-8 pt-8 border-t border-neutral-200 dark:border-neutral-700">
                        <div class="flex items-center justify-between text-sm text-neutral-700 dark:text-neutral-300 mb-2">
                            <span class="font-medium">Progresso</span>
                            <span class="font-bold text-neutral-900 dark:text-white">{{ round(($currentStep / $totalSteps) * 100) }}%</span>
                        </div>
                        <div class="h-2 bg-neutral-200 dark:bg-neutral-700 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-primary-500 to-accent-500 rounded-full transition-all duration-700 shadow-lg shadow-primary-500/30"
                                 style="width: {{ ($currentStep / $totalSteps) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: Form Content --}}
            <div class="relative">
                
                <form wire:submit.prevent="save" class="space-y-8">
                    {{-- ============ STEP 1: BASIC INFO ============ --}}
                    <div x-show="$wire.currentStep === 1"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 translate-x-20"
                         x-transition:enter-end="opacity-100 translate-x-0">
                        
                        {{-- Card with Neomorphism + Glass --}}
                        <div class="backdrop-blur-sm bg-white dark:bg-neutral-800 rounded-3xl p-8 border border-neutral-200 dark:border-neutral-700 shadow-2xl">
                            {{-- Header --}}
                            <div class="flex items-center gap-4 mb-8">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary-500 to-accent-600 flex items-center justify-center shadow-lg shadow-primary-500/50">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">Informazioni Base</h2>
                                    <p class="text-neutral-700 dark:text-neutral-300">I dettagli essenziali del tuo evento</p>
                                </div>
                            </div>

                            <div class="space-y-6">
                                {{-- Title with Floating Label --}}
                                <div class="group">
                                    <div class="relative">
                                        <input type="text" 
                                               wire:model.live="title"
                                               id="title"
                                               placeholder=" "
                                               class="peer w-full px-5 py-4 rounded-2xl bg-white dark:bg-neutral-900 border-2 border-neutral-200 dark:border-neutral-700 text-neutral-900 dark:text-white placeholder-transparent
                                                      focus:border-primary-500 dark:focus:border-primary-400 focus:ring-4 focus:ring-primary-500/10
                                                      transition-all duration-300 @error('title') border-red-500 ring-4 ring-red-500/10 @enderror">
                                        <label for="title" 
                                               class="absolute left-5 -top-2.5 px-2 text-sm font-medium bg-white dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400
                                                      peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:text-neutral-400 dark:peer-placeholder-shown:text-neutral-500
                                                      peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-primary-600 dark:peer-focus:text-primary-400
                                                      transition-all duration-200">
                                            Titolo Evento *
                                        </label>
                                    </div>
                                    @error('title')
                                        <p class="mt-2 text-sm text-red-400 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"/></svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                    @if(strlen($title) > 0)
                                        <p class="mt-2 text-sm text-neutral-500 dark:text-neutral-400">{{ strlen($title) }}/255 caratteri</p>
                                    @endif
                                </div>

                                {{-- Subtitle Toggle (Neumorphic Switch) --}}
                                <div class="flex items-center justify-between p-5 rounded-2xl bg-neutral-50 dark:bg-neutral-900/50 border border-neutral-200 dark:border-neutral-700 hover:bg-neutral-100 dark:hover:bg-neutral-900 transition-all group cursor-pointer"
                                     wire:click="toggleSubtitle">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-7 rounded-full relative transition-all duration-300
                                                    {{ $has_subtitle ? 'bg-gradient-to-r from-primary-500 to-accent-500' : 'bg-neutral-300 dark:bg-neutral-700' }}">
                                            <div class="absolute top-1 w-5 h-5 bg-white rounded-full shadow-lg transition-all duration-300
                                                        {{ $has_subtitle ? 'left-6' : 'left-1' }}"></div>
                                        </div>
                                        <span class="text-neutral-900 dark:text-white font-medium">Aggiungi Sottotitolo</span>
                                    </div>
                                    <span class="text-sm text-neutral-500 dark:text-neutral-400">Opzionale</span>
                                </div>

                                {{-- Subtitle Field (Animated Height) --}}
                                <div x-show="$wire.has_subtitle"
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 -translate-y-4"
                                     x-transition:enter-end="opacity-100 translate-y-0">
                                    <div class="relative group">
                                        <input type="text" 
                                               wire:model.live="subtitle"
                                               id="subtitle"
                                               placeholder=" "
                                               class="peer w-full px-5 py-4 rounded-2xl bg-white dark:bg-neutral-900 border-2 border-neutral-200 dark:border-neutral-700 text-neutral-900 dark:text-white placeholder-transparent
                                                      focus:border-accent-500 dark:focus:border-accent-400 focus:ring-4 focus:ring-accent-500/10
                                                      transition-all duration-300">
                                        <label for="subtitle" 
                                               class="absolute left-5 -top-2.5 px-2 text-sm font-medium bg-white dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400
                                                      peer-placeholder-shown:top-4 peer-placeholder-shown:text-base
                                                      peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-accent-600 dark:peer-focus:text-accent-400
                                                      transition-all duration-200">
                                            Sottotitolo
                                        </label>
                                    </div>
                                </div>

                                {{-- Category & Visibility (Grid) --}}
                                <div class="grid md:grid-cols-2 gap-6">
                                    {{-- Category Dropdown --}}
                                    <div class="relative group">
                                        <select wire:model.live="category"
                                                id="category"
                                                class="w-full px-5 py-4 rounded-2xl bg-white dark:bg-neutral-900 border-2 border-neutral-200 dark:border-neutral-700 text-neutral-900 dark:text-white appearance-none cursor-pointer
                                                       focus:border-primary-500 dark:focus:border-primary-400 focus:ring-4 focus:ring-primary-500/10
                                                       transition-all duration-300">
                                            <option value="" class="bg-white dark:bg-neutral-900">Seleziona categoria</option>
                                            @foreach(App\Models\Event::getCategories() as $key => $name)
                                                <option value="{{ $key }}" class="bg-white dark:bg-neutral-900">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="category" class="absolute left-5 -top-2.5 px-2 text-sm font-medium bg-white dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400">
                                            Categoria *
                                        </label>
                                        <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-neutral-400 dark:text-neutral-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>

                                    {{-- Visibility Radio Cards --}}
                                    <div>
                                        <label class="block text-sm font-medium text-neutral-600 dark:text-neutral-400 mb-3">Visibilità *</label>
                                        <div class="grid grid-cols-2 gap-3">
                                            <label class="relative cursor-pointer">
                                                <input type="radio" wire:model="is_public" value="1" class="sr-only peer">
                                                <div class="p-4 rounded-2xl border-2 text-center transition-all
                                                            peer-checked:border-primary-500 peer-checked:bg-primary-50 dark:peer-checked:bg-primary-900/20 peer-checked:shadow-lg peer-checked:shadow-primary-500/20
                                                            border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 hover:bg-neutral-50 dark:hover:bg-neutral-800">
                                                    <svg class="w-6 h-6 mx-auto mb-1 transition-colors {{ $is_public ? 'text-primary-600 dark:text-primary-400' : 'text-neutral-400 dark:text-neutral-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <span class="text-sm font-medium {{ $is_public ? 'text-neutral-900 dark:text-white' : 'text-neutral-600 dark:text-neutral-400' }}">Pubblico</span>
                                                </div>
                                            </label>
                                            <label class="relative cursor-pointer">
                                                <input type="radio" wire:model="is_public" value="0" class="sr-only peer">
                                                <div class="p-4 rounded-2xl border-2 text-center transition-all
                                                            peer-checked:border-accent-500 peer-checked:bg-accent-50 dark:peer-checked:bg-accent-900/20 peer-checked:shadow-lg peer-checked:shadow-accent-500/20
                                                            border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 hover:bg-neutral-50 dark:hover:bg-neutral-800">
                                                    <svg class="w-6 h-6 mx-auto mb-1 transition-colors {{ !$is_public ? 'text-accent-600 dark:text-accent-400' : 'text-neutral-400 dark:text-neutral-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                                    </svg>
                                                    <span class="text-sm font-medium {{ !$is_public ? 'text-neutral-900 dark:text-white' : 'text-neutral-600 dark:text-neutral-400' }}">Privato</span>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                {{-- Description Textarea --}}
                                <div class="relative group">
                                    <textarea wire:model.live="description"
                                              id="description"
                                              rows="5"
                                              placeholder=" "
                                              class="peer w-full px-5 py-4 rounded-2xl bg-white dark:bg-neutral-900 border-2 border-neutral-200 dark:border-neutral-700 text-neutral-900 dark:text-white placeholder-transparent resize-none
                                                     focus:border-primary-500 dark:focus:border-primary-400 focus:ring-4 focus:ring-primary-500/10
                                                     transition-all duration-300"></textarea>
                                    <label for="description" 
                                           class="absolute left-5 -top-2.5 px-2 text-sm font-medium bg-white dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400
                                                  peer-placeholder-shown:top-4 peer-placeholder-shown:text-base
                                                  peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-primary-600 dark:peer-focus:text-primary-400
                                                  transition-all duration-200">
                                        Descrizione
                                    </label>
                                </div>

                                {{-- Requirements --}}
                                <div class="relative group">
                                    <textarea wire:model.live="requirements"
                                              id="requirements"
                                              rows="3"
                                              placeholder=" "
                                              class="peer w-full px-5 py-4 rounded-2xl bg-white dark:bg-neutral-900 border-2 border-neutral-200 dark:border-neutral-700 text-neutral-900 dark:text-white placeholder-transparent resize-none
                                                     focus:border-accent-500 dark:focus:border-accent-400 focus:ring-4 focus:ring-accent-500/10
                                                     transition-all duration-300"></textarea>
                                    <label for="requirements" 
                                           class="absolute left-5 -top-2.5 px-2 text-sm font-medium bg-white dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400
                                                  peer-placeholder-shown:top-4 peer-placeholder-shown:text-base
                                                  peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-accent-600 dark:peer-focus:text-accent-400
                                                  transition-all duration-200">
                                        Requisiti
                                    </label>
                                    <p class="mt-2 text-sm text-neutral-500 dark:text-neutral-400">Eventuali requisiti per partecipare</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ============ STEP 2: DATE & LOCATION ============ --}}
                    <div x-show="$wire.currentStep === 2"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 translate-x-20"
                         x-transition:enter-end="opacity-100 translate-x-0">
                        
                        <div class="backdrop-blur-sm bg-white dark:bg-neutral-800 rounded-3xl p-8 border border-neutral-200 dark:border-neutral-700 shadow-2xl">
                            {{-- Header --}}
                            <div class="flex items-center gap-4 mb-8">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary-500 to-accent-600 flex items-center justify-center shadow-lg shadow-primary-500/50">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">Data & Luogo</h2>
                                    <p class="text-neutral-700 dark:text-neutral-300">Quando e dove si terrà l'evento</p>
                                </div>
                            </div>

                            <div class="space-y-6">
                                {{-- Date & Time --}}
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div class="relative group">
                                        <input type="datetime-local"
                                               wire:model="start_datetime"
                                               id="start_datetime"
                                               class="w-full px-5 py-4 rounded-2xl bg-white dark:bg-neutral-900 border-2 border-neutral-200 dark:border-neutral-700 text-neutral-900 dark:text-white
                                                      focus:border-primary-500 dark:focus:border-primary-400 focus:ring-4 focus:ring-primary-500/10
                                                      transition-all duration-300 @error('start_datetime') border-red-500 ring-4 ring-red-500/10 @enderror">
                                        <label for="start_datetime" class="absolute left-5 -top-2.5 px-2 text-sm font-medium bg-white dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300">
                                            Data/Ora Inizio *
                                        </label>
                                        @error('start_datetime')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="relative group">
                                        <input type="datetime-local"
                                               wire:model="end_datetime"
                                               id="end_datetime"
                                               class="w-full px-5 py-4 rounded-2xl bg-white dark:bg-neutral-900 border-2 border-neutral-200 dark:border-neutral-700 text-neutral-900 dark:text-white
                                                      focus:border-primary-500 dark:focus:border-primary-400 focus:ring-4 focus:ring-primary-500/10
                                                      transition-all duration-300 @error('end_datetime') border-red-500 ring-4 ring-red-500/10 @enderror">
                                        <label for="end_datetime" class="absolute left-5 -top-2.5 px-2 text-sm font-medium bg-white dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300">
                                            Data/Ora Fine *
                                        </label>
                                        @error('end_datetime')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Location Type Toggle --}}
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-3">Modalità Evento *</label>
                                    <div class="grid grid-cols-2 gap-4">
                                        <label class="relative cursor-pointer">
                                            <input type="radio" wire:model.live="is_online" value="0" class="sr-only peer">
                                            <div class="p-6 rounded-2xl border-2 text-center transition-all
                                                        peer-checked:border-primary-500 peer-checked:bg-primary-50 dark:peer-checked:bg-primary-900/20 peer-checked:shadow-lg peer-checked:shadow-primary-500/20
                                                        border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 hover:bg-neutral-50 dark:hover:bg-neutral-800">
                                                <svg class="w-8 h-8 mx-auto mb-2 transition-colors {{ !$is_online ? 'text-primary-600 dark:text-primary-400' : 'text-neutral-400 dark:text-neutral-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                </svg>
                                                <span class="font-bold {{ !$is_online ? 'text-neutral-900 dark:text-white' : 'text-neutral-600 dark:text-neutral-400' }}">In Presenza</span>
                                            </div>
                                        </label>
                                        <label class="relative cursor-pointer">
                                            <input type="radio" wire:model.live="is_online" value="1" class="sr-only peer">
                                            <div class="p-6 rounded-2xl border-2 text-center transition-all
                                                        peer-checked:border-accent-500 peer-checked:bg-accent-50 dark:peer-checked:bg-accent-900/20 peer-checked:shadow-lg peer-checked:shadow-accent-500/20
                                                        border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 hover:bg-neutral-50 dark:hover:bg-neutral-800">
                                                <svg class="w-8 h-8 mx-auto mb-2 transition-colors {{ $is_online ? 'text-accent-600 dark:text-accent-400' : 'text-neutral-400 dark:text-neutral-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                                </svg>
                                                <span class="font-bold {{ $is_online ? 'text-neutral-900 dark:text-white' : 'text-neutral-600 dark:text-neutral-400' }}">Online</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                {{-- Online URL --}}
                                @if($is_online)
                                    <div class="relative group" x-show="$wire.is_online" x-transition>
                                        <input type="url"
                                               wire:model="online_url"
                                               id="online_url"
                                               placeholder=" "
                                               class="peer w-full px-5 py-4 rounded-2xl bg-white dark:bg-neutral-900 border-2 border-neutral-200 dark:border-neutral-700 text-neutral-900 dark:text-white placeholder-transparent
                                                      focus:border-accent-500 dark:focus:border-accent-400 focus:ring-4 focus:ring-accent-500/10
                                                      transition-all duration-300">
                                        <label for="online_url" 
                                               class="absolute left-5 -top-2.5 px-2 text-sm font-medium bg-white dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300
                                                      peer-placeholder-shown:top-4 peer-placeholder-shown:text-base
                                                      peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-accent-600 dark:peer-focus:text-accent-400
                                                      transition-all duration-200">
                                            URL Evento Online *
                                        </label>
                                    </div>
                                @endif

                                {{-- Physical Location --}}
                                @if(!$is_online)
                                    <div x-show="!$wire.is_online" x-transition class="space-y-6">
                                        <div class="relative group">
                                            <input type="text"
                                                   wire:model="venue_name"
                                                   id="venue_name"
                                                   placeholder=" "
                                                   class="peer w-full px-5 py-4 rounded-2xl bg-white dark:bg-neutral-900 border-2 border-neutral-200 dark:border-neutral-700 text-neutral-900 dark:text-white placeholder-transparent
                                                          focus:border-primary-500 dark:focus:border-primary-400 focus:ring-4 focus:ring-primary-500/10
                                                          transition-all duration-300">
                                            <label for="venue_name" 
                                                   class="absolute left-5 -top-2.5 px-2 text-sm font-medium bg-white dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300
                                                          peer-placeholder-shown:top-4 peer-placeholder-shown:text-base
                                                          peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-primary-600 dark:peer-focus:text-primary-400
                                                          transition-all duration-200">
                                                Nome Venue
                                            </label>
                                        </div>

                                        <div class="relative group">
                                            <input type="text"
                                                   wire:model="venue_address"
                                                   id="venue_address"
                                                   placeholder=" "
                                                   class="peer w-full px-5 py-4 rounded-2xl bg-white dark:bg-neutral-900 border-2 border-neutral-200 dark:border-neutral-700 text-neutral-900 dark:text-white placeholder-transparent
                                                          focus:border-primary-500 dark:focus:border-primary-400 focus:ring-4 focus:ring-primary-500/10
                                                          transition-all duration-300">
                                            <label for="venue_address" 
                                                   class="absolute left-5 -top-2.5 px-2 text-sm font-medium bg-white dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300
                                                          peer-placeholder-shown:top-4 peer-placeholder-shown:text-base
                                                          peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-primary-600 dark:peer-focus:text-primary-400
                                                          transition-all duration-200">
                                                Indirizzo
                                            </label>
                                        </div>

                                        <div class="grid md:grid-cols-3 gap-4">
                                            <div class="relative group">
                                                <input type="text"
                                                       wire:model="city"
                                                       id="city"
                                                       placeholder=" "
                                                       class="peer w-full px-5 py-4 rounded-2xl bg-white dark:bg-neutral-900 border-2 border-neutral-200 dark:border-neutral-700 text-neutral-900 dark:text-white placeholder-transparent
                                                              focus:border-primary-500 dark:focus:border-primary-400 focus:ring-4 focus:ring-primary-500/10
                                                              transition-all duration-300">
                                                <label for="city" 
                                                       class="absolute left-5 -top-2.5 px-2 text-sm font-medium bg-white dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300
                                                              peer-placeholder-shown:top-4 peer-placeholder-shown:text-base
                                                              peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-primary-600 dark:peer-focus:text-primary-400
                                                              transition-all duration-200">
                                                    Città
                                                </label>
                                            </div>
                                            <div class="relative group">
                                                <input type="text"
                                                       wire:model="postcode"
                                                       id="postcode"
                                                       placeholder=" "
                                                       class="peer w-full px-5 py-4 rounded-2xl bg-white dark:bg-neutral-900 border-2 border-neutral-200 dark:border-neutral-700 text-neutral-900 dark:text-white placeholder-transparent
                                                              focus:border-primary-500 dark:focus:border-primary-400 focus:ring-4 focus:ring-primary-500/10
                                                              transition-all duration-300">
                                                <label for="postcode" 
                                                       class="absolute left-5 -top-2.5 px-2 text-sm font-medium bg-white dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300
                                                              peer-placeholder-shown:top-4 peer-placeholder-shown:text-base
                                                              peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-primary-600 dark:peer-focus:text-primary-400
                                                              transition-all duration-200">
                                                    CAP
                                                </label>
                                            </div>
                                            <div class="relative group">
                                                <select wire:model="country"
                                                        id="country"
                                                        class="w-full px-5 py-4 rounded-2xl bg-white dark:bg-neutral-900 border-2 border-neutral-200 dark:border-neutral-700 text-neutral-900 dark:text-white appearance-none cursor-pointer
                                                               focus:border-primary-500 dark:focus:border-primary-400 focus:ring-4 focus:ring-primary-500/10
                                                               transition-all duration-300">
                                                    <option value="IT">Italia</option>
                                                    <option value="CH">Svizzera</option>
                                                    <option value="FR">Francia</option>
                                                    <option value="DE">Germania</option>
                                                    <option value="ES">Spagna</option>
                                                    <option value="UK">Regno Unito</option>
                                                </select>
                                                <label for="country" class="absolute left-5 -top-2.5 px-2 text-sm font-medium bg-white dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300">
                                                    Paese
                                                </label>
                                                <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-neutral-400 dark:text-neutral-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                                </svg>
                                            </div>
                                        </div>

                                        {{-- Map Placeholder --}}
                                        <div class="bg-neutral-100 dark:bg-neutral-900 rounded-2xl p-8 border-2 border-dashed border-neutral-300 dark:border-neutral-700 text-center">
                                            <svg class="w-16 h-16 text-neutral-400 dark:text-neutral-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                            </svg>
                                            <p class="text-neutral-600 dark:text-neutral-400 font-medium">Mappa Interattiva</p>
                                            <p class="text-sm text-neutral-500 dark:text-neutral-500 mt-2">Clicca sulla mappa per selezionare le coordinate</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- ============ STEP 3: MEDIA & PAYMENT ============ --}}
                    <div x-show="$wire.currentStep === 3"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 translate-x-20"
                         x-transition:enter-end="opacity-100 translate-x-0">
                        
                        <div class="backdrop-blur-sm bg-white dark:bg-neutral-800 rounded-3xl p-8 border border-neutral-200 dark:border-neutral-700 shadow-2xl">
                            {{-- Header --}}
                            <div class="flex items-center gap-4 mb-8">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary-500 to-accent-600 flex items-center justify-center shadow-lg shadow-primary-500/50">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">Media & Biglietti</h2>
                                    <p class="text-neutral-700 dark:text-neutral-300">Immagini, video e informazioni sui biglietti</p>
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-8">
                                {{-- Left: Media --}}
                                <div class="space-y-6">
                                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white flex items-center gap-2">
                                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Media
                                    </h3>

                                    {{-- Image Upload --}}
                                    <div>
                                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-3">Immagine Copertina</label>
                                        <div class="relative">
                                            <input type="file"
                                                   wire:model="event_image"
                                                   accept="image/*"
                                                   id="event_image"
                                                   class="hidden">
                                            <label for="event_image" 
                                                   class="flex flex-col items-center justify-center w-full h-48 rounded-2xl border-2 border-dashed border-neutral-300 dark:border-neutral-600 bg-neutral-50 dark:bg-neutral-900 cursor-pointer hover:bg-neutral-100 dark:hover:bg-neutral-800 hover:border-primary-500 transition-all">
                                                @if ($event_image)
                                                    <img src="{{ $event_image->temporaryUrl() }}" class="max-h-full rounded-2xl">
                                                @else
                                                    <svg class="w-12 h-12 text-neutral-400 dark:text-neutral-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                                    </svg>
                                                    <p class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Clicca per caricare</p>
                                                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">JPG, PNG max 2MB</p>
                                                @endif
                                            </label>
                                        </div>
                                        @error('event_image')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- Promotional Video --}}
                                    <div class="relative group">
                                        <input type="url"
                                               wire:model="promotional_video"
                                               id="promotional_video"
                                               placeholder=" "
                                               class="peer w-full px-5 py-4 rounded-2xl bg-white dark:bg-neutral-900 border-2 border-neutral-200 dark:border-neutral-700 text-neutral-900 dark:text-white placeholder-transparent
                                                      focus:border-primary-500 dark:focus:border-primary-400 focus:ring-4 focus:ring-primary-500/10
                                                      transition-all duration-300">
                                        <label for="promotional_video" 
                                               class="absolute left-5 -top-2.5 px-2 text-sm font-medium bg-white dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300
                                                      peer-placeholder-shown:top-4 peer-placeholder-shown:text-base
                                                      peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-primary-600 dark:peer-focus:text-primary-400
                                                      transition-all duration-200">
                                            Video Promozionale (URL)
                                        </label>
                                    </div>
                                </div>

                                {{-- Right: Payment --}}
                                <div class="space-y-6">
                                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white flex items-center gap-2">
                                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Biglietti
                                    </h3>

                                    {{-- Paid Event Toggle --}}
                                    <div class="flex items-center justify-between p-5 rounded-2xl bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-700 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-all cursor-pointer"
                                         wire:click="$toggle('is_paid_event')">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-7 rounded-full relative transition-all duration-300
                                                        {{ $is_paid_event ? 'bg-gradient-to-r from-primary-500 to-accent-500' : 'bg-neutral-300 dark:bg-neutral-700' }}">
                                                <div class="absolute top-1 w-5 h-5 bg-white rounded-full shadow-lg transition-all duration-300
                                                            {{ $is_paid_event ? 'left-6' : 'left-1' }}"></div>
                                            </div>
                                            <span class="text-neutral-900 dark:text-white font-medium">Evento a Pagamento</span>
                                        </div>
                                    </div>

                                    {{-- Payment Fields --}}
                                    <div x-show="$wire.is_paid_event" x-transition class="grid grid-cols-2 gap-4">
                                        <div class="relative group">
                                            <input type="number"
                                                   wire:model="ticket_price"
                                                   id="ticket_price"
                                                   min="0"
                                                   step="0.01"
                                                   placeholder=" "
                                                   class="peer w-full px-5 py-4 rounded-2xl bg-white dark:bg-neutral-900 border-2 border-neutral-200 dark:border-neutral-700 text-neutral-900 dark:text-white placeholder-transparent
                                                          focus:border-primary-500 dark:focus:border-primary-400 focus:ring-4 focus:ring-primary-500/10
                                                          transition-all duration-300">
                                            <label for="ticket_price" 
                                                   class="absolute left-5 -top-2.5 px-2 text-sm font-medium bg-white dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300
                                                          peer-placeholder-shown:top-4 peer-placeholder-shown:text-base
                                                          peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-primary-600 dark:peer-focus:text-primary-400
                                                          transition-all duration-200">
                                                Prezzo
                                            </label>
                                        </div>
                                        <div class="relative group">
                                            <select wire:model="ticket_currency"
                                                    id="ticket_currency"
                                                    class="w-full px-5 py-4 rounded-2xl bg-white dark:bg-neutral-900 border-2 border-neutral-200 dark:border-neutral-700 text-neutral-900 dark:text-white appearance-none cursor-pointer
                                                           focus:border-primary-500 dark:focus:border-primary-400 focus:ring-4 focus:ring-primary-500/10
                                                           transition-all duration-300">
                                                <option value="EUR">EUR (€)</option>
                                                <option value="USD">USD ($)</option>
                                                <option value="GBP">GBP (£)</option>
                                                <option value="CHF">CHF</option>
                                            </select>
                                            <label for="ticket_currency" class="absolute left-5 -top-2.5 px-2 text-sm font-medium bg-white dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300">
                                                Valuta
                                            </label>
                                            <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-neutral-400 dark:text-neutral-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </div>
                                    </div>

                                    @if(!$is_paid_event)
                                        <div class="flex items-center gap-3 p-4 bg-green-50 dark:bg-green-900/20 rounded-2xl border border-green-200 dark:border-green-800">
                                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            <span class="font-semibold text-green-700 dark:text-green-300">Evento Gratuito</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ============ STEP 4: SETTINGS ============ --}}
                    <div x-show="$wire.currentStep === 4"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 translate-x-20"
                         x-transition:enter-end="opacity-100 translate-x-0">
                        
                        <div class="backdrop-blur-sm bg-white dark:bg-neutral-800 rounded-3xl p-8 border border-neutral-200 dark:border-neutral-700 shadow-2xl">
                            {{-- Header --}}
                            <div class="flex items-center gap-4 mb-8">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary-500 to-accent-600 flex items-center justify-center shadow-lg shadow-primary-500/50">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">Impostazioni</h2>
                                    <p class="text-neutral-700 dark:text-neutral-300">Partecipanti e pubblicazione</p>
                                </div>
                            </div>

                            <div class="space-y-6">
                                {{-- Max Participants --}}
                                <div class="relative group">
                                    <input type="number"
                                           wire:model="max_participants"
                                           id="max_participants"
                                           min="1"
                                           placeholder=" "
                                           class="peer w-full px-5 py-4 rounded-2xl bg-white dark:bg-neutral-900 border-2 border-neutral-200 dark:border-neutral-700 text-neutral-900 dark:text-white placeholder-transparent
                                                  focus:border-primary-500 dark:focus:border-primary-400 focus:ring-4 focus:ring-primary-500/10
                                                  transition-all duration-300">
                                    <label for="max_participants" 
                                           class="absolute left-5 -top-2.5 px-2 text-sm font-medium bg-white dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300
                                                  peer-placeholder-shown:top-4 peer-placeholder-shown:text-base
                                                  peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-primary-600 dark:peer-focus:text-primary-400
                                                  transition-all duration-200">
                                        Numero Massimo Partecipanti
                                    </label>
                                    <p class="mt-2 text-sm text-neutral-600 dark:text-neutral-400">Lascia vuoto per nessun limite</p>
                                </div>

                                {{-- Allow Requests --}}
                                <div class="flex items-center justify-between p-5 rounded-2xl bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-700 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-all cursor-pointer"
                                     wire:click="$toggle('allow_requests')">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-7 rounded-full relative transition-all duration-300
                                                    {{ $allow_requests ? 'bg-gradient-to-r from-primary-500 to-accent-500' : 'bg-neutral-300 dark:bg-neutral-700' }}">
                                            <div class="absolute top-1 w-5 h-5 bg-white rounded-full shadow-lg transition-all duration-300
                                                        {{ $allow_requests ? 'left-6' : 'left-1' }}"></div>
                                        </div>
                                        <span class="text-neutral-900 dark:text-white font-medium">Permetti Richieste di Partecipazione</span>
                                    </div>
                                </div>

                                {{-- Status --}}
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-3">Stato Pubblicazione *</label>
                                    <div class="grid grid-cols-2 gap-4">
                                        <label class="relative cursor-pointer">
                                            <input type="radio" wire:model="status" value="published" class="sr-only peer">
                                            <div class="p-6 rounded-2xl border-2 text-center transition-all
                                                        peer-checked:border-primary-500 peer-checked:bg-primary-50 dark:peer-checked:bg-primary-900/20 peer-checked:shadow-lg
                                                        border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 hover:bg-neutral-50 dark:hover:bg-neutral-800">
                                                <svg class="w-10 h-10 mx-auto mb-3 transition-colors {{ $status === 'published' ? 'text-primary-600 dark:text-primary-400' : 'text-neutral-400 dark:text-neutral-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                <span class="font-bold {{ $status === 'published' ? 'text-neutral-900 dark:text-white' : 'text-neutral-600 dark:text-neutral-400' }}">Pubblica Subito</span>
                                                <p class="text-sm text-neutral-600 dark:text-neutral-400 mt-1">Visibile immediatamente</p>
                                            </div>
                                        </label>
                                        <label class="relative cursor-pointer">
                                            <input type="radio" wire:model="status" value="draft" class="sr-only peer">
                                            <div class="p-6 rounded-2xl border-2 text-center transition-all
                                                        peer-checked:border-accent-500 peer-checked:bg-accent-50 dark:peer-checked:bg-accent-900/20 peer-checked:shadow-lg
                                                        border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 hover:bg-neutral-50 dark:hover:bg-neutral-800">
                                                <svg class="w-10 h-10 mx-auto mb-3 transition-colors {{ $status === 'draft' ? 'text-accent-600 dark:text-accent-400' : 'text-neutral-400 dark:text-neutral-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                <span class="font-bold {{ $status === 'draft' ? 'text-neutral-900 dark:text-white' : 'text-neutral-600 dark:text-neutral-400' }}">Salva Bozza</span>
                                                <p class="text-sm text-neutral-600 dark:text-neutral-400 mt-1">Pubblica più tardi</p>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ============ STEP 5: PREVIEW ============ --}}
                    <div x-show="$wire.currentStep === 5"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 translate-x-20"
                         x-transition:enter-end="opacity-100 translate-x-0">
                        
                        <div class="backdrop-blur-sm bg-white dark:bg-neutral-800 rounded-3xl p-8 border border-neutral-200 dark:border-neutral-700 shadow-2xl">
                            {{-- Header --}}
                            <div class="flex items-center gap-4 mb-8">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary-500 to-accent-600 flex items-center justify-center shadow-lg shadow-primary-500/50">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">Anteprima & Conferma</h2>
                                    <p class="text-neutral-700 dark:text-neutral-300">Verifica tutti i dati prima di pubblicare</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                {{-- Basic Info Summary --}}
                                <div class="bg-neutral-50 dark:bg-neutral-900 rounded-2xl p-6 border border-neutral-200 dark:border-neutral-700">
                                    <h3 class="font-bold text-neutral-900 dark:text-white mb-4 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Informazioni Base
                                    </h3>
                                    <dl class="space-y-3 text-sm">
                                        <div class="flex justify-between items-start">
                                            <dt class="font-medium text-neutral-600 dark:text-neutral-400">Titolo:</dt>
                                            <dd class="font-semibold text-neutral-900 dark:text-white text-right max-w-md">{{ $title ?: '-' }}</dd>
                                        </div>
                                        @if($subtitle)
                                            <div class="flex justify-between items-start">
                                                <dt class="font-medium text-neutral-600 dark:text-neutral-400">Sottotitolo:</dt>
                                                <dd class="font-semibold text-neutral-900 dark:text-white text-right max-w-md">{{ $subtitle }}</dd>
                                            </div>
                                        @endif
                                        <div class="flex justify-between items-start">
                                            <dt class="font-medium text-neutral-600 dark:text-neutral-400">Categoria:</dt>
                                            <dd class="font-semibold text-neutral-900 dark:text-white">{{ $category ? (App\Models\Event::getCategories()[$category] ?? '-') : '-' }}</dd>
                                        </div>
                                        <div class="flex justify-between items-start">
                                            <dt class="font-medium text-neutral-600 dark:text-neutral-400">Visibilità:</dt>
                                            <dd>
                                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-semibold
                                                             {{ $is_public ? 'bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300' : 'bg-neutral-200 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300' }}">
                                                    {{ $is_public ? '🌍 Pubblico' : '🔒 Privato' }}
                                                </span>
                                            </dd>
                                        </div>
                                    </dl>
                                </div>

                                {{-- Date & Location Summary --}}
                                <div class="bg-neutral-50 dark:bg-neutral-900 rounded-2xl p-6 border border-neutral-200 dark:border-neutral-700">
                                    <h3 class="font-bold text-neutral-900 dark:text-white mb-4 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Data & Luogo
                                    </h3>
                                    <dl class="space-y-3 text-sm">
                                        <div class="flex justify-between items-start">
                                            <dt class="font-medium text-neutral-600 dark:text-neutral-400">Inizio:</dt>
                                            <dd class="font-semibold text-neutral-900 dark:text-white">{{ $start_datetime ? \Carbon\Carbon::parse($start_datetime)->format('d/m/Y H:i') : '-' }}</dd>
                                        </div>
                                        <div class="flex justify-between items-start">
                                            <dt class="font-medium text-neutral-600 dark:text-neutral-400">Fine:</dt>
                                            <dd class="font-semibold text-neutral-900 dark:text-white">{{ $end_datetime ? \Carbon\Carbon::parse($end_datetime)->format('d/m/Y H:i') : '-' }}</dd>
                                        </div>
                                        <div class="flex justify-between items-start">
                                            <dt class="font-medium text-neutral-600 dark:text-neutral-400">Modalità:</dt>
                                            <dd class="font-semibold text-neutral-900 dark:text-white">{{ $is_online ? '🌐 Online' : '📍 In Presenza' }}</dd>
                                        </div>
                                        @if(!$is_online && $city)
                                            <div class="flex justify-between items-start">
                                                <dt class="font-medium text-neutral-600 dark:text-neutral-400">Città:</dt>
                                                <dd class="font-semibold text-neutral-900 dark:text-white">{{ $city }}</dd>
                                            </div>
                                        @endif
                                        @if($is_online && $online_url)
                                            <div class="flex justify-between items-start">
                                                <dt class="font-medium text-neutral-600 dark:text-neutral-400">URL:</dt>
                                                <dd class="font-semibold text-neutral-900 dark:text-white text-right break-all">{{ $online_url }}</dd>
                                            </div>
                                        @endif
                                    </dl>
                                </div>

                                {{-- Payment Summary --}}
                                <div class="bg-neutral-50 dark:bg-neutral-900 rounded-2xl p-6 border border-neutral-200 dark:border-neutral-700">
                                    <h3 class="font-bold text-neutral-900 dark:text-white mb-4 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Biglietti
                                    </h3>
                                    <dl class="space-y-3 text-sm">
                                        <div class="flex justify-between items-start">
                                            <dt class="font-medium text-neutral-600 dark:text-neutral-400">Tipo:</dt>
                                            <dd class="font-semibold text-neutral-900 dark:text-white">{{ $is_paid_event ? '💳 A Pagamento' : '🎁 Gratuito' }}</dd>
                                        </div>
                                        @if($is_paid_event)
                                            <div class="flex justify-between items-start">
                                                <dt class="font-medium text-neutral-600 dark:text-neutral-400">Prezzo:</dt>
                                                <dd class="font-bold text-2xl text-primary-600 dark:text-primary-400">{{ number_format($ticket_price, 2) }} {{ $ticket_currency }}</dd>
                                            </div>
                                        @endif
                                    </dl>
                                </div>

                                {{-- Settings Summary --}}
                                <div class="bg-neutral-50 dark:bg-neutral-900 rounded-2xl p-6 border border-neutral-200 dark:border-neutral-700">
                                    <h3 class="font-bold text-neutral-900 dark:text-white mb-4 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        Impostazioni
                                    </h3>
                                    <dl class="space-y-3 text-sm">
                                        <div class="flex justify-between items-start">
                                            <dt class="font-medium text-neutral-600 dark:text-neutral-400">Max Partecipanti:</dt>
                                            <dd class="font-semibold text-neutral-900 dark:text-white">{{ $max_participants ?: '∞ Illimitati' }}</dd>
                                        </div>
                                        <div class="flex justify-between items-start">
                                            <dt class="font-medium text-neutral-600 dark:text-neutral-400">Richieste Partecipazione:</dt>
                                            <dd class="font-semibold text-neutral-900 dark:text-white">{{ $allow_requests ? '✅ Permesse' : '❌ Non permesse' }}</dd>
                                        </div>
                                        <div class="flex justify-between items-start">
                                            <dt class="font-medium text-neutral-600 dark:text-neutral-400">Stato:</dt>
                                            <dd>
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                                                             {{ $status === 'published' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300' }}">
                                                    {{ $status === 'published' ? '🚀 Pubblicato' : '📝 Bozza' }}
                                                </span>
                                            </dd>
                                        </div>
                                    </dl>
                                </div>

                                {{-- Final CTA --}}
                                <div class="bg-gradient-to-r from-primary-50 to-accent-50 dark:from-primary-900/20 dark:to-accent-900/20 rounded-2xl p-6 border border-primary-200 dark:border-primary-800 text-center">
                                    <svg class="w-16 h-16 mx-auto mb-4 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <h4 class="text-xl font-bold text-neutral-900 dark:text-white mb-2">Tutto Pronto!</h4>
                                    <p class="text-neutral-700 dark:text-neutral-300 mb-4">Clicca il pulsante in basso per {{ $status === 'published' ? 'pubblicare' : 'salvare' }} il tuo evento</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Navigation Buttons --}}
                    <div class="flex items-center justify-between gap-4 pt-8">
                        @if($currentStep > 1)
                            <button type="button"
                                    wire:click="prevStep"
                                    class="px-8 py-4 rounded-2xl bg-white dark:bg-neutral-700 border-2 border-neutral-200 dark:border-neutral-600 text-neutral-900 dark:text-white font-semibold
                                           hover:bg-neutral-50 dark:hover:bg-neutral-600 hover:border-neutral-300 dark:hover:border-neutral-500 hover:scale-105
                                           active:scale-95 transition-all duration-200 flex items-center gap-2 shadow-lg">
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
                                    class="px-8 py-4 rounded-2xl bg-gradient-to-r from-primary-500 to-accent-600 text-white font-bold text-lg shadow-xl shadow-primary-500/30
                                           hover:shadow-2xl hover:shadow-primary-500/50 hover:scale-105
                                           active:scale-95 transition-all duration-200 flex items-center gap-2">
                                Avanti
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        @else
                            <button type="submit"
                                    class="px-12 py-4 rounded-2xl bg-gradient-to-r from-primary-500 to-accent-600 text-white font-black text-xl shadow-xl shadow-primary-500/30
                                           hover:shadow-2xl hover:shadow-primary-500/50 hover:scale-105
                                           active:scale-95 transition-all duration-200 flex items-center gap-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ $status === 'published' ? 'Pubblica Evento' : 'Salva Bozza' }}
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
@keyframes blob {
    0%, 100% { transform: translate(0, 0) scale(1); }
    25% { transform: translate(20px, -50px) scale(1.1); }
    50% { transform: translate(-20px, 20px) scale(0.9); }
    75% { transform: translate(50px, 50px) scale(1.05); }
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}
</style>
@endpush
