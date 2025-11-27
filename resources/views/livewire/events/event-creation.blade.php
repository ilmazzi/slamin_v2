{{-- INNOVATIVE EVENT CREATION FORM - Total Redesign --}}
<div class="min-h-screen bg-gradient-to-br from-neutral-50 via-primary-50/30 to-accent-50/20 dark:from-neutral-900 dark:via-primary-950/50 dark:to-accent-950/30 relative overflow-hidden" 
     x-data="{ 
         currentStep: @entangle('currentStep')
     }"
     @scroll-to-top.window="window.scrollTo({ top: 0, behavior: 'smooth' })">
    
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
                            {{ __('events.create.title') }}
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
                                    <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">{{ __('events.create.basic_info') }}</h2>
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
                                            {{ __('events.create.event_title') }} *
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
                                        <span class="text-neutral-900 dark:text-white font-medium">{{ __('events.create.add_subtitle') }}</span>
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
                                                      transition-all duration-300 @error('subtitle') border-red-500 ring-4 ring-red-500/10 @enderror">
                                        <label for="subtitle" 
                                               class="absolute left-5 -top-2.5 px-2 text-sm font-medium bg-white dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400
                                                      peer-placeholder-shown:top-4 peer-placeholder-shown:text-base
                                                      peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-accent-600 dark:peer-focus:text-accent-400
                                                      transition-all duration-200">
                                            Sottotitolo
                                        </label>
                                        @error('subtitle')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
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

                                {{-- Recurrence --}}
                                <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/10 dark:to-orange-900/10 rounded-2xl p-6 border border-amber-200 dark:border-amber-800">
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <h3 class="font-bold text-neutral-900 dark:text-white flex items-center gap-2">
                                                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                </svg>
                                                {{ __('events.create.recurring_event') }}
                                            </h3>
                                            <p class="text-sm text-neutral-600 dark:text-neutral-400">L'evento si ripete nel tempo</p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-7 rounded-full relative transition-all duration-300 cursor-pointer
                                                        {{ $is_recurring ? 'bg-gradient-to-r from-amber-500 to-orange-500' : 'bg-neutral-300 dark:bg-neutral-700' }}"
                                                 wire:click="$toggle('is_recurring')">
                                                <div class="absolute top-1 w-5 h-5 bg-white rounded-full shadow-lg transition-all duration-300
                                                            {{ $is_recurring ? 'left-6' : 'left-1' }}"></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @if($is_recurring)
                                        <div class="space-y-4">
                                            <div class="grid md:grid-cols-3 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">{{ __('events.create.recurrence_type') }} *</label>
                                                    <select wire:model="recurrence_type" 
                                                            class="w-full px-4 py-2 rounded-xl bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white">
                                                        <option value="">Seleziona...</option>
                                                        <option value="daily">Giornaliera</option>
                                                        <option value="weekly">Settimanale</option>
                                                        <option value="monthly">Mensile</option>
                                                        <option value="yearly">Annuale</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Ogni (intervallo) *</label>
                                                    <input type="number" wire:model="recurrence_interval" min="1" 
                                                           class="w-full px-4 py-2 rounded-xl bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">{{ __('events.create.recurrence_count') }}</label>
                                                    <input type="number" wire:model="recurrence_count" min="1" max="100" placeholder="Illimitate" 
                                                           class="w-full px-4 py-2 rounded-xl bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white">
                                                </div>
                                            </div>

                                            @if($recurrence_type === 'weekly')
                                                <div>
                                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-3">Giorni della Settimana *</label>
                                                    <div class="flex flex-wrap gap-2">
                                                        @foreach(['Lun' => '1', 'Mar' => '2', 'Mer' => '3', 'Gio' => '4', 'Ven' => '5', 'Sab' => '6', 'Dom' => '0'] as $label => $value)
                                                            <label class="flex items-center cursor-pointer">
                                                                <input type="checkbox" wire:model="recurrence_weekdays" value="{{ $value }}" class="hidden peer">
                                                                <div class="px-4 py-2 rounded-lg border-2 transition-all
                                                                            peer-checked:border-amber-500 peer-checked:bg-amber-100 dark:peer-checked:bg-amber-900/30 peer-checked:text-amber-900 dark:peer-checked:text-amber-100
                                                                            border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300">
                                                                    {{ $label }}
                                                                </div>
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

                                            @if($recurrence_type === 'monthly')
                                                <div>
                                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Giorno del Mese (1-31) *</label>
                                                    <input type="number" wire:model="recurrence_monthday" min="1" max="31" 
                                                           class="w-full px-4 py-2 rounded-xl bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white">
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                {{-- Availability Based --}}
                                <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/10 dark:to-pink-900/10 rounded-2xl p-6 border border-purple-200 dark:border-purple-800">
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <h3 class="font-bold text-neutral-900 dark:text-white flex items-center gap-2">
                                                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                </svg>
                                                {{ __('events.create.availability_based') }}
                                            </h3>
                                            <p class="text-sm text-neutral-600 dark:text-neutral-400">Gli invitati scelgono tra date/orari proposti</p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-7 rounded-full relative transition-all duration-300 cursor-pointer
                                                        {{ $is_availability_based ? 'bg-gradient-to-r from-purple-500 to-pink-500' : 'bg-neutral-300 dark:bg-neutral-700' }}"
                                                 wire:click="$toggle('is_availability_based')">
                                                <div class="absolute top-1 w-5 h-5 bg-white rounded-full shadow-lg transition-all duration-300
                                                            {{ $is_availability_based ? 'left-6' : 'left-1' }}"></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @if($is_availability_based)
                                        <div class="space-y-4">
                                            <div class="grid md:grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">{{ __('events.create.response_deadline') }}</label>
                                                    <input type="datetime-local" wire:model="availability_deadline" 
                                                           class="w-full px-4 py-2 rounded-xl bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Istruzioni</label>
                                                    <input type="text" wire:model="availability_instructions" placeholder="Es: Scegli almeno 2 opzioni" 
                                                           class="w-full px-4 py-2 rounded-xl bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white">
                                                </div>
                                            </div>

                                            <div>
                                                <div class="flex items-center justify-between mb-3">
                                                    <label class="text-sm font-medium text-neutral-700 dark:text-neutral-300">{{ __('events.create.datetime_options') }}</label>
                                                    <button type="button" wire:click="addAvailabilityOption" 
                                                            class="px-3 py-1 bg-purple-600 hover:bg-purple-700 text-white rounded-lg text-sm font-semibold transition-all hover:scale-105">
                                                        + {{ __('events.create.add_option') }}
                                                    </button>
                                                </div>
                                                
                                                @if(count($availability_options) > 0)
                                                    <div class="space-y-3">
                                                        @foreach($availability_options as $index => $option)
                                                            <div class="flex gap-3">
                                                                <input type="datetime-local" wire:model="availability_options.{{ $index }}.datetime" 
                                                                       class="flex-1 px-4 py-2 rounded-lg bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white">
                                                                <input type="text" wire:model="availability_options.{{ $index }}.description" placeholder="Descrizione opzionale" 
                                                                       class="flex-1 px-4 py-2 rounded-lg bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white">
                                                                <button type="button" wire:click="removeAvailabilityOption({{ $index }})" 
                                                                        class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-bold transition-all hover:scale-110">
                                                                    ×
                                                                </button>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <p class="text-sm text-neutral-500 dark:text-neutral-400 italic text-center py-3">Nessuna opzione aggiunta</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                {{-- Location Type Toggle --}}
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-3">{{ __('events.create.event_mode') }} *</label>
                                    <div class="grid grid-cols-2 gap-4">
                                        <label class="relative cursor-pointer">
                                            <input type="radio" wire:model.live="is_online" value="0" class="sr-only peer">
                                            <div class="p-6 rounded-2xl border-2 text-center transition-all
                                                        peer-checked:border-primary-500 peer-checked:bg-primary-50 dark:peer-checked:bg-primary-900/20 peer-checked:shadow-lg peer-checked:shadow-primary-500/20
                                                        border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 hover:bg-neutral-50 dark:hover:bg-neutral-800">
                                                <svg class="w-8 h-8 mx-auto mb-2 transition-colors {{ !$is_online ? 'text-primary-600 dark:text-primary-400' : 'text-neutral-400 dark:text-neutral-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                </svg>
                                                <span class="font-bold {{ !$is_online ? 'text-neutral-900 dark:text-white' : 'text-neutral-600 dark:text-neutral-400' }}">{{ __('events.create.in_person') }}</span>
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

                                {{-- Online URL - Show only when Online --}}
                                @if($is_online)
                                    <div class="relative group">
                                        <input type="url"
                                               wire:model="online_url"
                                               id="online_url"
                                               placeholder=" "
                                               class="peer w-full px-5 py-4 rounded-2xl bg-white dark:bg-neutral-900 border-2 border-neutral-200 dark:border-neutral-700 text-neutral-900 dark:text-white placeholder-transparent
                                                      focus:border-accent-500 dark:focus:border-accent-400 focus:ring-4 focus:ring-accent-500/10
                                                      transition-all duration-300 @error('online_url') border-red-500 ring-4 ring-red-500/10 @enderror">
                                        <label for="online_url" 
                                               class="absolute left-5 -top-2.5 px-2 text-sm font-medium bg-white dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300
                                                      peer-placeholder-shown:top-4 peer-placeholder-shown:text-base
                                                      peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-accent-600 dark:peer-focus:text-accent-400
                                                      transition-all duration-200">
                                            {{ __('events.create.online_url') }} *
                                        </label>
                                        @error('online_url')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    {{-- Timezone Field - Show only when Online --}}
                                    <div class="relative group mt-4">
                                        <select wire:model="timezone"
                                                id="timezone"
                                                class="w-full px-5 py-4 rounded-2xl bg-white dark:bg-neutral-900 border-2 border-neutral-200 dark:border-neutral-700 text-neutral-900 dark:text-white
                                                       focus:border-accent-500 dark:focus:border-accent-400 focus:ring-4 focus:ring-accent-500/10
                                                       transition-all duration-300 @error('timezone') border-red-500 ring-4 ring-red-500/10 @enderror">
                                            @php
                                                $timezones = timezone_identifiers_list();
                                                $grouped = [];
                                                foreach ($timezones as $tz) {
                                                    $parts = explode('/', $tz);
                                                    if (count($parts) > 1) {
                                                        $group = $parts[0];
                                                        if (!isset($grouped[$group])) {
                                                            $grouped[$group] = [];
                                                        }
                                                        $grouped[$group][] = $tz;
                                                    } else {
                                                        if (!isset($grouped['Other'])) {
                                                            $grouped['Other'] = [];
                                                        }
                                                        $grouped['Other'][] = $tz;
                                                    }
                                                }
                                                ksort($grouped);
                                            @endphp
                                            @foreach($grouped as $group => $tzList)
                                                <optgroup label="{{ $group }}">
                                                    @foreach($tzList as $tz)
                                                        <option value="{{ $tz }}" {{ $timezone === $tz ? 'selected' : '' }}>{{ str_replace($group . '/', '', $tz) }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                        <label for="timezone" 
                                               class="absolute left-5 -top-2.5 px-2 text-sm font-medium bg-white dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300">
                                            {{ __('events.create.timezone') }} *
                                        </label>
                                        <p class="mt-2 text-xs text-neutral-500 dark:text-neutral-400">{{ __('events.create.timezone_help') }}</p>
                                        @error('timezone')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @endif

                                {{-- Physical Location Fields + Map - Show only when In Presenza --}}
                                @if(!$is_online)
                                <div class="space-y-6">
                                    {{-- Recent Venues Dropdown --}}
                                    @if(count($recentVenues) > 0)
                                    <div class="relative group">
                                        <select wire:model.live="selectedRecentVenue"
                                                wire:change="loadRecentVenueFromSelect"
                                                id="recent_venue"
                                                class="w-full px-5 py-4 rounded-2xl bg-gradient-to-br from-primary-50 to-accent-50 dark:from-primary-900/20 dark:to-accent-900/20 
                                                       border-2 border-primary-300 dark:border-primary-700 text-neutral-900 dark:text-white appearance-none cursor-pointer
                                                       focus:border-primary-500 dark:focus:border-primary-400 focus:ring-4 focus:ring-primary-500/20
                                                       transition-all duration-300 font-medium">
                                            <option value="">📍 {{ __('events.create.select_from_recent_venues') }}</option>
                                            @foreach($recentVenues as $index => $venue)
                                                <option value="{{ $index }}">
                                                    {{ $venue['venue_name'] }} - {{ $venue['city'] ?? '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-primary-600 dark:text-primary-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                        <label for="recent_venue" 
                                               class="absolute left-5 -top-2.5 px-2 text-sm font-bold bg-white dark:bg-neutral-800 text-primary-600 dark:text-primary-400">
                                            🏛️ {{ __('events.create.recent_venues') }}
                                        </label>
                                    </div>
                                    @endif

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

                                    {{-- Interactive Map - ALWAYS in DOM --}}
                                    <div>
                                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-3 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            Clicca sulla mappa per posizionare il pin dell'evento
                                        </label>
                                        <div id="eventCreationMap" 
                                             wire:ignore 
                                             class="h-96 w-full border-2 border-neutral-300 dark:border-neutral-700 shadow-lg"
                                             style="min-height: 384px; width: 100%; height: 384px; position: relative; z-index: 1; background: #e5e7eb;"></div>
                                        @if($latitude && $longitude)
                                            <div class="mt-3 flex items-center gap-2 text-sm text-primary-600 dark:text-primary-400">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                <span class="font-medium">Coordinate salvate: {{ number_format($latitude, 6) }}, {{ number_format($longitude, 6) }}</span>
                                            </div>
                                        @endif
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
                                    <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">{{ __('events.create.media_tickets') }}</h2>
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
                                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-3">{{ __('events.create.cover_image') }}</label>
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
                                            {{ __('events.create.promotional_video') }}
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
                                            <span class="text-neutral-900 dark:text-white font-medium">{{ __('events.create.paid_event') }}</span>
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
                                            <span class="font-semibold text-green-700 dark:text-green-300">{{ __('events.create.free_event') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Link to Group --}}
                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/10 dark:to-indigo-900/10 rounded-2xl p-6 border border-blue-200 dark:border-blue-800 mt-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <h3 class="font-bold text-neutral-900 dark:text-white flex items-center gap-2">
                                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                            {{ __('events.create.linked_to_group') }}
                                        </h3>
                                        <p class="text-sm text-neutral-600 dark:text-neutral-400">L'evento fa parte di un gruppo esistente</p>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-7 rounded-full relative transition-all duration-300 cursor-pointer
                                                    {{ $is_linked_to_group ? 'bg-gradient-to-r from-blue-500 to-indigo-500' : 'bg-neutral-300 dark:bg-neutral-700' }}"
                                             wire:click="$toggle('is_linked_to_group')">
                                            <div class="absolute top-1 w-5 h-5 bg-white rounded-full shadow-lg transition-all duration-300
                                                        {{ $is_linked_to_group ? 'left-6' : 'left-1' }}"></div>
                                        </div>
                                    </div>
                                </div>
                                
                                @if($is_linked_to_group)
                                    <div class="bg-white dark:bg-neutral-800 rounded-xl p-4 space-y-4">
                                        {{-- Search Groups --}}
                                        <div>
                                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                                {{ __('events.create.search_group') }}
                                            </label>
                                            <input type="text" 
                                                   wire:model.live.debounce.300ms="groupSearch"
                                                   placeholder="Cerca per nome gruppo..."
                                                   class="w-full px-4 py-2 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                        </div>

                                        {{-- Search Results --}}
                                        @if($groupSearch && strlen($groupSearch) >= 2)
                                            <div class="space-y-2 max-h-60 overflow-y-auto">
                                                @forelse($searchedGroups as $group)
                                                    <div class="p-3 rounded-lg border {{ in_array($group->id, $selected_groups) ? 'bg-blue-50 dark:bg-blue-900/20 border-blue-300 dark:border-blue-700' : 'bg-neutral-50 dark:bg-neutral-700 border-neutral-200 dark:border-neutral-600' }} cursor-pointer hover:shadow-md transition-all"
                                                         wire:click="toggleGroup({{ $group->id }})">
                                                        <div class="flex items-center gap-3">
                                                            @if($group->image)
                                                                <img src="{{ Storage::url($group->image) }}" 
                                                                     alt="{{ $group->name }}"
                                                                     class="w-10 h-10 rounded-full object-cover">
                                                            @else
                                                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-500 flex items-center justify-center text-white font-bold">
                                                                    {{ substr($group->name, 0, 1) }}
                                                                </div>
                                                            @endif
                                                            <div class="flex-1">
                                                                <h4 class="font-semibold text-neutral-900 dark:text-white">{{ $group->name }}</h4>
                                                                <p class="text-xs text-neutral-500 dark:text-neutral-400">
                                                                    {{ $group->members()->count() }} membri • {{ ucfirst($group->visibility) }}
                                                                </p>
                                                            </div>
                                                            @if(in_array($group->id, $selected_groups))
                                                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                                </svg>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @empty
                                                    <p class="text-sm text-neutral-500 dark:text-neutral-400 text-center py-4">
                                                        Nessun gruppo trovato
                                                    </p>
                                                @endforelse
                                            </div>
                                        @endif

                                        {{-- Selected Groups --}}
                                        @if(count($selected_groups) > 0)
                                            <div>
                                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                                    Gruppi Selezionati
                                                </label>
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach($selected_groups as $groupId)
                                                        @php
                                                            $selectedGroup = \App\Models\Group::find($groupId);
                                                        @endphp
                                                        @if($selectedGroup)
                                                            <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-sm font-medium">
                                                                {{ $selectedGroup->name }}
                                                                <button type="button" 
                                                                        wire:click="toggleGroup({{ $groupId }})"
                                                                        class="hover:text-blue-900 dark:hover:text-blue-100">
                                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                                    </svg>
                                                                </button>
                                                            </span>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            {{-- Link to Festival (only if NOT festival) --}}
                            @if($category !== 'festival')
                                <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/10 dark:to-pink-900/10 rounded-2xl p-6 border border-purple-200 dark:border-purple-800 mt-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <h3 class="font-bold text-neutral-900 dark:text-white flex items-center gap-2">
                                                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                                </svg>
                                                {{ __('events.create.part_of_festival') }}
                                            </h3>
                                            <p class="text-sm text-neutral-600 dark:text-neutral-400">Questo evento è collegato a un festival</p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-7 rounded-full relative transition-all duration-300 cursor-pointer
                                                        {{ $festival_id ? 'bg-gradient-to-r from-purple-500 to-pink-500' : 'bg-neutral-300 dark:bg-neutral-700' }}"
                                                 wire:click="$toggle('is_festival_event')">
                                                <div class="absolute top-1 w-5 h-5 bg-white rounded-full shadow-lg transition-all duration-300
                                                            {{ $festival_id ? 'left-6' : 'left-1' }}"></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @if($festival_id || $is_festival_event)
                                        <div>
                                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">{{ __('events.create.select_festival') }}</label>
                                            <select wire:model="festival_id" 
                                                    class="w-full px-4 py-3 rounded-xl bg-white dark:bg-neutral-800 border-2 border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white
                                                           focus:border-purple-500 dark:focus:border-purple-400 focus:ring-4 focus:ring-purple-500/10
                                                           transition-all duration-300 appearance-none cursor-pointer font-medium">
                                                <option value="">Seleziona un festival...</option>
                                                @foreach(\App\Models\Event::where('category', 'festival')->where('status', 'published')->get() as $festival)
                                                    <option value="{{ $festival->id }}">{{ $festival->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            {{-- Festival Events Selector (only if category = festival) --}}
                            @if($category === 'festival')
                                <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/10 dark:to-orange-900/10 rounded-2xl p-6 border border-amber-200 dark:border-amber-800">
                                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-4 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                        </svg>
                                        Eventi del Festival
                                    </h3>
                                    <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-4">
                                        🎪 Questo festival può contenere più eventi. Seleziona quali eventi fanno parte di questo festival.
                                    </p>
                                    
                                    {{-- Festival Events Selector --}}
                                    <div class="space-y-4">
                                        {{-- Search Bar --}}
                                        <div>
                                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Cerca Eventi</label>
                                            <div class="relative">
                                                <input type="text" 
                                                       wire:model.live.debounce.300ms="festivalEventSearch"
                                                       placeholder="Cerca per titolo o città..."
                                                       class="w-full px-4 py-3 pl-11 rounded-xl bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white
                                                              focus:border-amber-500 dark:focus:border-amber-400 focus:ring-4 focus:ring-amber-500/10
                                                              transition-all duration-300">
                                                <svg class="w-5 h-5 absolute left-3 top-3.5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                                </svg>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-3">
                                                Eventi Disponibili
                                                <span class="text-xs text-neutral-500">(solo eventi futuri)</span>
                                            </label>
                                            <div class="max-h-64 overflow-y-auto space-y-2 bg-white dark:bg-neutral-900 rounded-xl p-4 border border-neutral-200 dark:border-neutral-700">
                                                @forelse($this->filteredFestivalEvents as $availableEvent)
                                                    <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-neutral-50 dark:hover:bg-neutral-800 cursor-pointer transition-colors">
                                                        <input type="checkbox" 
                                                               wire:model="selected_festival_events" 
                                                               value="{{ $availableEvent->id }}"
                                                               class="w-5 h-5 text-amber-600 rounded">
                                                        <div class="flex-1">
                                                            <div class="font-semibold text-neutral-900 dark:text-white">{{ $availableEvent->title }}</div>
                                                            <div class="text-xs text-neutral-500">
                                                                {{ $availableEvent->start_datetime ? $availableEvent->start_datetime->format('d M Y') : 'Data TBD' }}
                                                                • {{ $availableEvent->city ?? 'Location TBD' }}
                                                            </div>
                                                        </div>
                                                    </label>
                                                @empty
                                                    <div class="text-center py-8 text-neutral-500 dark:text-neutral-400">
                                                        <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                                        </svg>
                                                        <p class="font-medium">Nessun evento trovato</p>
                                                        <p class="text-sm mt-1">Prova a modificare i termini di ricerca</p>
                                                    </div>
                                                @endforelse
                                            </div>
                                            @if(count($selected_festival_events) > 0)
                                                <div class="mt-3 text-sm text-amber-700 dark:text-amber-300 font-semibold">
                                                    ✓ {{ count($selected_festival_events) }} eventi selezionati
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
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
                                {{-- 1. Invitations (Performers/Organizers) --}}
                                <div class="bg-gradient-to-br from-accent-50 to-primary-50 dark:from-accent-900/20 dark:to-primary-900/20 rounded-2xl p-6 border border-accent-200 dark:border-accent-700">
                                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white flex items-center gap-2 mb-2">
                                        <svg class="w-5 h-5 text-accent-600 dark:text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        {{ __('events.create.invite_participants_title') }}
                                        <span class="text-sm bg-accent-600 dark:bg-accent-500 text-white px-2 py-1 rounded-lg">{{ count($invitations) }}</span>
                                    </h3>
                                    <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-4">{{ __('events.create.invite_participants_description') }}</p>

                                    {{-- Search --}}
                                    <div class="relative mb-4">
                                        <input type="text" wire:model.live.debounce.300ms="userSearchQuery" placeholder="{{ __('events.create.search_users') }}" 
                                               class="w-full px-4 py-3 pl-11 rounded-xl bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white">
                                        <svg class="w-5 h-5 absolute left-3 top-3.5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                </div>

                                    {{-- Search Results --}}
                                    @if(strlen($userSearchQuery) >= 2 && count($searchResults) > 0)
                                        <div class="bg-white dark:bg-neutral-800 rounded-xl p-3 mb-4 max-h-64 overflow-y-auto">
                                            @foreach($searchResults as $result)
                                                <div class="flex items-center justify-between p-3 hover:bg-neutral-50 dark:hover:bg-neutral-700 rounded-lg">
                                                    <div>
                                                        <div class="font-semibold text-neutral-900 dark:text-white">{{ $result['name'] }}</div>
                                                        @if($result['nickname'])
                                                            <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ $result['nickname'] }}</div>
                                                        @endif
                                            </div>
                                                    <div class="flex gap-2">
                                                        <button type="button" wire:click="addInvitation({{ $result['id'] }}, 'performer')" 
                                                                class="px-3 py-1 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-sm">
                                                            Artista
                                                        </button>
                                                        <button type="button" wire:click="addInvitation({{ $result['id'] }}, 'organizer')" 
                                                                class="px-3 py-1 bg-accent-600 hover:bg-accent-700 text-white rounded-lg text-sm">
                                                            Organizer
                                                        </button>
                                        </div>
                                    </div>
                                            @endforeach
                                            </div>
                                    @endif

                                    {{-- Invited List --}}
                                    @if(count($invitations) > 0)
                                        <div class="space-y-2">
                                            @foreach($invitations as $index => $invitation)
                                                <div class="bg-white dark:bg-neutral-800 rounded-lg p-3 flex items-center justify-between">
                                                    <div class="font-semibold text-neutral-900 dark:text-white">{{ $invitation['name'] }}</div>
                                                    <div class="flex items-center gap-3">
                                                        <select wire:model="invitations.{{ $index }}.role" 
                                                                class="px-3 py-1 rounded-lg bg-neutral-50 dark:bg-neutral-900 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white text-sm">
                                                            <option value="performer">Artista</option>
                                                            <option value="organizer">Organizer</option>
                                                        </select>
                                                        <button type="button" wire:click="removeInvitation({{ $index }})" 
                                                                class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm">
                                                            Rimuovi
                                                        </button>
                                            </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                {{-- 2. Gig Positions --}}
                                <div class="bg-gradient-to-br from-primary-50 to-accent-50 dark:from-primary-900/20 dark:to-accent-900/20 rounded-2xl p-6 border border-primary-200 dark:border-primary-700">
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <h3 class="text-lg font-bold text-neutral-900 dark:text-white flex items-center gap-2 mb-2">
                                                <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                </svg>
                                                {{ __('events.create.add_gigs') }}
                                                <span class="text-sm bg-primary-600 dark:bg-primary-500 text-white px-2 py-1 rounded-lg">{{ count($gig_positions) }}</span>
                                            </h3>
                                            <p class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('events.create.add_gigs_description') }}</p>
                                        </div>
                                        <button type="button" wire:click="addGigPosition" 
                                                class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-semibold shadow-lg hover:scale-105 transition-all flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            Aggiungi
                                        </button>
                                    </div>

                                    @if(count($gig_positions) > 0)
                                        <div class="space-y-4">
                                            @foreach($gig_positions as $index => $position)
                                                <div class="bg-white dark:bg-neutral-800 rounded-xl p-5 border border-neutral-200 dark:border-neutral-700">
                                                    <div class="flex items-center justify-between mb-4">
                                                        <h4 class="font-bold text-neutral-900 dark:text-white">Posizione #{{ $index + 1 }}</h4>
                                                        <button type="button" wire:click="removeGigPosition({{ $index }})" 
                                                                class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-semibold">
                                                            Rimuovi
                                                        </button>
                                                    </div>
                                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                        <div>
                                                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Tipo *</label>
                                                            <select wire:model.live="gig_positions.{{ $index }}.type" 
                                                                    class="w-full px-4 py-3 rounded-xl bg-white dark:bg-neutral-800 border-2 border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white
                                                                           focus:border-primary-500 dark:focus:border-primary-400 focus:ring-4 focus:ring-primary-500/10
                                                                           transition-all duration-300 appearance-none cursor-pointer font-medium">
                                                                <option value="">Seleziona...</option>
                                                                <option value="poeta">Poeta/Artista</option>
                                                                <option value="mc">MC/Host</option>
                                                                <option value="tecnico">Supporto Tecnico</option>
                                                                <option value="volontario">Volontario</option>
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Quantità *</label>
                                                            <input type="number" wire:model.live="gig_positions.{{ $index }}.quantity" min="1" 
                                                                   class="w-full px-4 py-3 rounded-xl bg-white dark:bg-neutral-800 border-2 border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white
                                                                          focus:border-primary-500 dark:focus:border-primary-400 focus:ring-4 focus:ring-primary-500/10
                                                                          transition-all duration-300 font-medium">
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Lingua</label>
                                                            <select wire:model.live="gig_positions.{{ $index }}.language" 
                                                                    class="w-full px-4 py-3 rounded-xl bg-white dark:bg-neutral-800 border-2 border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white
                                                                           focus:border-primary-500 dark:focus:border-primary-400 focus:ring-4 focus:ring-primary-500/10
                                                                           transition-all duration-300 appearance-none cursor-pointer font-medium">
                                                                <option value="">Nessuna preferenza</option>
                                                                <option value="italiano">Italiano</option>
                                                                <option value="inglese">Inglese</option>
                                                                <option value="francese">Francese</option>
                                                                <option value="tedesco">Tedesco</option>
                                                                <option value="spagnolo">Spagnolo</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    {{-- Cachet --}}
                                                    <div class="mt-4 p-4 bg-neutral-50 dark:bg-neutral-900 rounded-lg">
                                                        <label class="flex items-center gap-2 cursor-pointer mb-3">
                                                            <input type="checkbox" wire:model.live="gig_positions.{{ $index }}.has_cachet" class="w-5 h-5 text-primary-600 rounded">
                                                            <span class="font-semibold text-neutral-900 dark:text-white">Cachet</span>
                                                        </label>
                                                        @if(isset($position['has_cachet']) && $position['has_cachet'])
                                                            <div class="grid grid-cols-2 gap-3">
                                                                <input type="number" wire:model="gig_positions.{{ $index }}.cachet_amount" step="0.01" placeholder="Importo" 
                                                                       class="px-4 py-3 rounded-xl bg-white dark:bg-neutral-800 border-2 border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white
                                                                              focus:border-primary-500 dark:focus:border-primary-400 focus:ring-4 focus:ring-primary-500/10
                                                                              transition-all duration-300 font-medium">
                                                                <select wire:model="gig_positions.{{ $index }}.cachet_currency" 
                                                                        class="px-4 py-3 rounded-xl bg-white dark:bg-neutral-800 border-2 border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white
                                                                               focus:border-primary-500 dark:focus:border-primary-400 focus:ring-4 focus:ring-primary-500/10
                                                                               transition-all duration-300 appearance-none cursor-pointer font-medium">
                                                                    <option value="EUR">EUR (€)</option>
                                                                    <option value="USD">USD ($)</option>
                                                                    <option value="GBP">GBP (£)</option>
                                                                </select>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    {{-- Travel --}}
                                                    <div class="mt-3 p-4 bg-neutral-50 dark:bg-neutral-900 rounded-lg">
                                                        <label class="flex items-center gap-2 cursor-pointer mb-3">
                                                            <input type="checkbox" wire:model.live="gig_positions.{{ $index }}.has_travel" class="w-5 h-5 text-primary-600 rounded">
                                                            <span class="font-semibold text-neutral-900 dark:text-white">{{ __('events.create.travel_expenses') }}</span>
                                                        </label>
                                                        @if(isset($position['has_travel']) && $position['has_travel'])
                                                            <div class="grid grid-cols-2 gap-3">
                                                                <input type="number" wire:model="gig_positions.{{ $index }}.travel_max" step="0.01" placeholder="Copertura massima" 
                                                                       class="px-4 py-3 rounded-xl bg-white dark:bg-neutral-800 border-2 border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white
                                                                              focus:border-primary-500 dark:focus:border-primary-400 focus:ring-4 focus:ring-primary-500/10
                                                                              transition-all duration-300 font-medium">
                                                                <select wire:model="gig_positions.{{ $index }}.travel_currency" 
                                                                        class="px-4 py-3 rounded-xl bg-white dark:bg-neutral-800 border-2 border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white
                                                                               focus:border-primary-500 dark:focus:border-primary-400 focus:ring-4 focus:ring-primary-500/10
                                                                               transition-all duration-300 appearance-none cursor-pointer font-medium">
                                                                    <option value="EUR">EUR (€)</option>
                                                                    <option value="USD">USD ($)</option>
                                                                    <option value="GBP">GBP (£)</option>
                                                                </select>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    {{-- Accommodation --}}
                                                    <div class="mt-3 p-4 bg-neutral-50 dark:bg-neutral-900 rounded-lg">
                                                        <label class="flex items-center gap-2 cursor-pointer mb-3">
                                                            <input type="checkbox" wire:model.live="gig_positions.{{ $index }}.has_accommodation" class="w-5 h-5 text-primary-600 rounded">
                                                            <span class="font-semibold text-neutral-900 dark:text-white">{{ __('events.create.accommodation') }}</span>
                                                        </label>
                                                        @if(isset($position['has_accommodation']) && $position['has_accommodation'])
                                                            <textarea wire:model="gig_positions.{{ $index }}.accommodation_details" rows="2" placeholder="Dettagli alloggio..." 
                                                                      class="w-full px-4 py-3 rounded-xl bg-white dark:bg-neutral-800 border-2 border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white
                                                                             focus:border-primary-500 dark:focus:border-primary-400 focus:ring-4 focus:ring-primary-500/10
                                                                             transition-all duration-300 font-medium"></textarea>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center py-8 text-neutral-600 dark:text-neutral-400">
                                            <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                            Nessuna posizione lavorativa definita
                                        </div>
                                    @endif
                                </div>

                                {{-- 3. Registration Deadline --}}
                                <div class="bg-neutral-50 dark:bg-neutral-900 rounded-2xl p-6 border border-neutral-200 dark:border-neutral-700">
                                    <div class="flex items-center justify-between mb-4">
                                                    <div>
                                            <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-2">{{ __('events.create.registration_deadline') }}</h3>
                                            <p class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('events.create.registration_deadline_description') }}</p>
                                                    </div>
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-7 rounded-full relative transition-all duration-300 cursor-pointer
                                                        {{ $has_registration_deadline ? 'bg-gradient-to-r from-primary-500 to-accent-500' : 'bg-neutral-300 dark:bg-neutral-700' }}"
                                                 wire:click="$toggle('has_registration_deadline')">
                                                <div class="absolute top-1 w-5 h-5 bg-white rounded-full shadow-lg transition-all duration-300
                                                            {{ $has_registration_deadline ? 'left-6' : 'left-1' }}"></div>
                                                    </div>
                                                </div>
                                        </div>
                                    @if($has_registration_deadline)
                                        <div class="grid grid-cols-2 gap-4 mt-4">
                                            <div>
                                                <input type="date" wire:model="registration_deadline_date" 
                                                       class="w-full px-4 py-3 rounded-xl bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white">
                                                    </div>
                                            <div>
                                                <input type="time" wire:model="registration_deadline_time" 
                                                       class="w-full px-4 py-3 rounded-xl bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white">
                                                </div>
                                        </div>
                                    @endif
                                </div>

                                {{-- 4. Audience Invitations with Capacity Limit --}}
                                <div class="bg-neutral-100 dark:bg-neutral-900 rounded-2xl p-6 border border-neutral-300 dark:border-neutral-700">
                                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white flex items-center gap-2 mb-2">
                                        <svg class="w-5 h-5 text-neutral-600 dark:text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                        </svg>
                                        {{ __('events.create.invite_audience') }}
                                        <span class="text-sm bg-neutral-600 dark:bg-neutral-500 text-white px-2 py-1 rounded-lg">{{ count($audienceInvitations) }}</span>
                                    </h3>
                                    <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-6">{{ __('events.create.invite_audience_description') }}</p>

                                    {{-- Capacity Limit Toggle --}}
                                    <div class="bg-white dark:bg-neutral-800 rounded-xl p-4 mb-4 border border-neutral-200 dark:border-neutral-700">
                                        <div class="flex items-center justify-between mb-3">
                                            <div>
                                                <h4 class="font-semibold text-neutral-900 dark:text-white">{{ __('events.create.capacity_limit') }}</h4>
                                                <p class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('events.create.capacity_limit_description') }}</p>
                                            </div>
                                            <div class="flex items-center gap-3">
                                                <div class="w-12 h-7 rounded-full relative transition-all duration-300 cursor-pointer
                                                            {{ $has_capacity_limit ? 'bg-gradient-to-r from-primary-500 to-accent-500' : 'bg-neutral-300 dark:bg-neutral-700' }}"
                                                     wire:click="$toggle('has_capacity_limit')">
                                                    <div class="absolute top-1 w-5 h-5 bg-white rounded-full shadow-lg transition-all duration-300
                                                                {{ $has_capacity_limit ? 'left-6' : 'left-1' }}"></div>
                                                </div>
                                            </div>
                                        </div>
                                        @if($has_capacity_limit)
                                            <div class="mt-3">
                                                <input type="number"
                                                       wire:model="max_participants"
                                                       min="1"
                                                       placeholder="{{ __('events.create.max_audience_placeholder') }}"
                                                       class="w-full px-4 py-3 rounded-xl bg-neutral-50 dark:bg-neutral-900 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white
                                                              focus:border-primary-500 dark:focus:border-primary-400 focus:ring-4 focus:ring-primary-500/10
                                                              transition-all duration-300">
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Search --}}
                                    <div class="relative mb-4">
                                        <input type="text" wire:model.live.debounce.300ms="audienceSearchQuery" placeholder="{{ __('events.create.search_users') }}" 
                                               class="w-full px-4 py-3 pl-11 rounded-xl bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white">
                                        <svg class="w-5 h-5 absolute left-3 top-3.5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </div>

                                    {{-- Search Results --}}
                                    @if(strlen($audienceSearchQuery) >= 2 && count($audienceSearchResults) > 0)
                                        <div class="bg-white dark:bg-neutral-800 rounded-xl p-3 mb-4 max-h-64 overflow-y-auto">
                                            @foreach($audienceSearchResults as $result)
                                                <div class="flex items-center justify-between p-3 hover:bg-neutral-50 dark:hover:bg-neutral-700 rounded-lg">
                                                    <div>
                                                        <div class="font-semibold text-neutral-900 dark:text-white">{{ $result['name'] }}</div>
                                                        @if($result['nickname'])
                                                            <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ $result['nickname'] }}</div>
                                                        @endif
                                                    </div>
                                                    <button type="button" wire:click="addAudienceInvitation({{ $result['id'] }})" 
                                                            class="px-4 py-2 bg-neutral-600 hover:bg-neutral-700 text-white rounded-lg text-sm">
                                                        Invita
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    {{-- Invited List --}}
                                    @if(count($audienceInvitations) > 0)
                                        <div class="space-y-2">
                                            @foreach($audienceInvitations as $index => $audience)
                                                <div class="bg-white dark:bg-neutral-800 rounded-lg p-3 flex items-center justify-between">
                                                    <div class="font-semibold text-neutral-900 dark:text-white">{{ $audience['name'] }}</div>
                                                    <button type="button" wire:click="removeAudienceInvitation({{ $index }})" 
                                                            class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm">
                                                        Rimuovi
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                {{-- 5. Status --}}
                                <div class="bg-gradient-to-br from-primary-50 to-accent-50 dark:from-primary-900/20 dark:to-accent-900/20 rounded-2xl p-6 border border-primary-200 dark:border-primary-700">
                                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-2">{{ __('events.create.publish_status_title') }} *</h3>
                                    <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-4">{{ __('events.create.publish_status_description') }}</p>
                                    <div class="grid grid-cols-2 gap-4">
                                        <label class="relative cursor-pointer">
                                            <input type="radio" wire:model="status" value="published" class="sr-only peer">
                                            <div class="p-6 rounded-2xl border-2 text-center transition-all
                                                        peer-checked:border-primary-500 peer-checked:bg-primary-50 dark:peer-checked:bg-primary-900/20 peer-checked:shadow-lg
                                                        border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 hover:bg-neutral-50 dark:hover:bg-neutral-800">
                                                <svg class="w-10 h-10 mx-auto mb-3 transition-colors {{ $status === 'published' ? 'text-primary-600 dark:text-primary-400' : 'text-neutral-400 dark:text-neutral-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                <span class="font-bold {{ $status === 'published' ? 'text-neutral-900 dark:text-white' : 'text-neutral-600 dark:text-neutral-400' }}">{{ __('events.create.publish_now') }}</span>
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
                                                <span class="font-bold {{ $status === 'draft' ? 'text-neutral-900 dark:text-white' : 'text-neutral-600 dark:text-neutral-400' }}">{{ __('events.create.save_draft') }}</span>
                                                <p class="text-sm text-neutral-600 dark:text-neutral-400 mt-1">{{ __('events.create.publish_later') }}</p>
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
                                    <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">{{ __('events.create.preview_confirm') }}</h2>
                                    <p class="text-neutral-700 dark:text-neutral-300">Verifica tutti i dati prima di pubblicare</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                {{-- Event Image Preview --}}
                                @if($event_image)
                                    <div class="bg-neutral-50 dark:bg-neutral-900 rounded-2xl p-6 border border-neutral-200 dark:border-neutral-700">
                                        <h3 class="font-bold text-neutral-900 dark:text-white mb-4 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            {{ __('events.create.cover_image') }}
                                        </h3>
                                        <div class="relative rounded-2xl overflow-hidden bg-neutral-100 dark:bg-neutral-800 border-2 border-neutral-200 dark:border-neutral-700">
                                            <img src="{{ $event_image->temporaryUrl() }}" 
                                                 alt="Anteprima immagine evento" 
                                                 class="w-full h-auto max-h-96 object-cover">
                                            <div class="absolute top-4 right-4 px-3 py-1.5 bg-black/50 backdrop-blur-sm rounded-lg text-white text-sm font-semibold">
                                                📸 Anteprima
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                {{-- Basic Info Summary --}}
                                <div class="bg-neutral-50 dark:bg-neutral-900 rounded-2xl p-6 border border-neutral-200 dark:border-neutral-700">
                                    <h3 class="font-bold text-neutral-900 dark:text-white mb-4 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ __('events.create.basic_info') }}
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
                                            <dd class="font-semibold text-neutral-900 dark:text-white">{{ $is_online ? '🌐 ' . __('events.create.online') : '📍 ' . __('events.create.in_person') }}</dd>
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

                                {{-- Recurrence Summary --}}
                                @if($is_recurring)
                                    <div class="bg-neutral-50 dark:bg-neutral-900 rounded-2xl p-6 border border-neutral-200 dark:border-neutral-700">
                                        <h3 class="font-bold text-neutral-900 dark:text-white mb-4 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                            </svg>
                                            Ricorrenza
                                        </h3>
                                        <dl class="space-y-3 text-sm">
                                            <div class="flex justify-between items-start">
                                                <dt class="font-medium text-neutral-600 dark:text-neutral-400">Tipo:</dt>
                                                <dd class="font-semibold text-neutral-900 dark:text-white">
                                                    @if($recurrence_type === 'daily') Giornaliera
                                                    @elseif($recurrence_type === 'weekly') Settimanale
                                                    @elseif($recurrence_type === 'monthly') Mensile
                                                    @endif
                                                </dd>
                                            </div>
                                            @if($recurrence_interval)
                                                <div class="flex justify-between items-start">
                                                    <dt class="font-medium text-neutral-600 dark:text-neutral-400">Ogni:</dt>
                                                    <dd class="font-semibold text-neutral-900 dark:text-white">{{ $recurrence_interval }} 
                                                        @if($recurrence_type === 'daily') giorni
                                                        @elseif($recurrence_type === 'weekly') settimane
                                                        @elseif($recurrence_type === 'monthly') mesi
                                                        @endif
                                                    </dd>
                                                </div>
                                            @endif
                                            @if($recurrence_count)
                                                <div class="flex justify-between items-start">
                                                    <dt class="font-medium text-neutral-600 dark:text-neutral-400">Ripetizioni:</dt>
                                                    <dd class="font-semibold text-neutral-900 dark:text-white">{{ $recurrence_count }} volte</dd>
                                                </div>
                                            @endif
                                            @if($recurrence_type === 'weekly' && !empty($recurrence_weekdays))
                                                <div class="flex justify-between items-start">
                                                    <dt class="font-medium text-neutral-600 dark:text-neutral-400">Giorni:</dt>
                                                    <dd class="font-semibold text-neutral-900 dark:text-white">{{ implode(', ', $recurrence_weekdays) }}</dd>
                                                </div>
                                            @endif
                                        </dl>
                                    </div>
                                @endif

                                {{-- Availability Options Summary --}}
                                @if($is_availability_based && is_array($availability_options) && count($availability_options) > 0)
                                    <div class="bg-neutral-50 dark:bg-neutral-900 rounded-2xl p-6 border border-neutral-200 dark:border-neutral-700">
                                        <h3 class="font-bold text-neutral-900 dark:text-white mb-4 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                            </svg>
                                            Opzioni Disponibilità ({{ count($availability_options) }})
                                        </h3>
                                        <div class="space-y-2">
                                            @foreach($availability_options as $option)
                                                <div class="flex justify-between items-start bg-white dark:bg-neutral-800 rounded-lg p-3">
                                                    <div>
                                                        <div class="font-semibold text-neutral-900 dark:text-white">
                                                            {{ \Carbon\Carbon::parse($option['datetime'])->format('d/m/Y H:i') }}
                                                        </div>
                                                        @if(!empty($option['description']))
                                                            <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ $option['description'] }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        @if($availability_deadline)
                                            <div class="mt-4 pt-4 border-t border-neutral-200 dark:border-neutral-700">
                                                <div class="flex justify-between items-start text-sm">
                                                    <dt class="font-medium text-neutral-600 dark:text-neutral-400">Scadenza:</dt>
                                                    <dd class="font-semibold text-neutral-900 dark:text-white">{{ \Carbon\Carbon::parse($availability_deadline)->format('d/m/Y H:i') }}</dd>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                {{-- Gig Positions Summary --}}
                                @if(is_array($gig_positions) && count($gig_positions) > 0)
                                    <div class="bg-neutral-50 dark:bg-neutral-900 rounded-2xl p-6 border border-neutral-200 dark:border-neutral-700">
                                        <h3 class="font-bold text-neutral-900 dark:text-white mb-4 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                            Posizioni Gig ({{ count($gig_positions) }})
                                        </h3>
                                        <div class="space-y-3">
                                            @foreach($gig_positions as $gig)
                                                <div class="bg-white dark:bg-neutral-800 rounded-lg p-4 space-y-2">
                                                    <div class="flex justify-between items-start">
                                                        <div class="font-semibold text-neutral-900 dark:text-white">{{ $gig['type'] ?? 'N/D' }}</div>
                                                        <div class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Quantità: {{ $gig['quantity'] ?? 1 }}</div>
                                                    </div>
                                                    @if(!empty($gig['language']))
                                                        <div class="text-sm text-neutral-600 dark:text-neutral-400">Lingua: {{ $gig['language'] }}</div>
                                                    @endif
                                                    @if(!empty($gig['cachet_amount']))
                                                        <div class="text-sm font-semibold text-primary-600 dark:text-primary-400">
                                                            Cachet: {{ number_format($gig['cachet_amount'], 2) }} {{ $gig['cachet_currency'] ?? 'EUR' }}
                                                        </div>
                                                    @endif
                                                    @if(!empty($gig['travel_max']))
                                                        <div class="text-sm text-neutral-600 dark:text-neutral-400">
                                                            Spese Viaggio (max): {{ number_format($gig['travel_max'], 2) }} {{ $gig['travel_currency'] ?? 'EUR' }}
                                                        </div>
                                                    @endif
                                                    @if(!empty($gig['accommodation_details']))
                                                        <div class="text-sm text-neutral-600 dark:text-neutral-400">Alloggio: {{ $gig['accommodation_details'] }}</div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                {{-- Invitations Summary --}}
                                @if(is_array($performer_invitations) && count($performer_invitations) > 0)
                                    <div class="bg-neutral-50 dark:bg-neutral-900 rounded-2xl p-6 border border-neutral-200 dark:border-neutral-700">
                                        <h3 class="font-bold text-neutral-900 dark:text-white mb-4 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                            Performer/Organizzatori Invitati ({{ count($performer_invitations) }})
                                        </h3>
                                        <div class="space-y-2">
                                            @foreach($performer_invitations as $invitation)
                                                <div class="flex justify-between items-center bg-white dark:bg-neutral-800 rounded-lg p-3">
                                                    <div class="font-semibold text-neutral-900 dark:text-white">{{ $invitation['name'] }}</div>
                                                    <span class="text-xs px-2 py-1 rounded bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300">
                                                        {{ ucfirst($invitation['role']) }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                {{-- Audience Invitations Summary --}}
                                @if(is_array($audienceInvitations) && count($audienceInvitations) > 0)
                                    <div class="bg-neutral-50 dark:bg-neutral-900 rounded-2xl p-6 border border-neutral-200 dark:border-neutral-700">
                                        <h3 class="font-bold text-neutral-900 dark:text-white mb-4 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                            </svg>
                                            Pubblico Invitato ({{ count($audienceInvitations) }})
                                        </h3>
                                        <div class="grid grid-cols-2 gap-2">
                                            @foreach($audienceInvitations as $audience)
                                                <div class="bg-white dark:bg-neutral-800 rounded-lg p-3 font-semibold text-neutral-900 dark:text-white text-sm">
                                                    {{ $audience['name'] }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                {{-- Groups Summary --}}
                                {{-- @if($is_linked_to_group && count($selected_groups) > 0)
                                    <div class="bg-neutral-50 dark:bg-neutral-900 rounded-2xl p-6 border border-neutral-200 dark:border-neutral-700">
                                        <h3 class="font-bold text-neutral-900 dark:text-white mb-4 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                            Gruppi Collegati
                                        </h3>
                                        <div class="space-y-2">
                                            @foreach($selected_groups as $groupId)
                                                <div class="bg-white dark:bg-neutral-800 rounded-lg p-3 font-semibold text-neutral-900 dark:text-white">
                                                    Gruppo #{{ $groupId }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif --}}

                                {{-- Festival Summary --}}
                                @if($category === 'festival' && is_array($selected_festival_events) && count($selected_festival_events) > 0)
                                    <div class="bg-neutral-50 dark:bg-neutral-900 rounded-2xl p-6 border border-neutral-200 dark:border-neutral-700">
                                        <h3 class="font-bold text-neutral-900 dark:text-white mb-4 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                            </svg>
                                            Eventi nel Festival ({{ count($selected_festival_events) }})
                                        </h3>
                                        <div class="space-y-2">
                                            @foreach($selected_festival_events as $eventId)
                                                @php
                                                    $festEvent = \App\Models\Event::find($eventId);
                                                @endphp
                                                @if($festEvent)
                                                    <div class="bg-white dark:bg-neutral-800 rounded-lg p-3 font-semibold text-neutral-900 dark:text-white">
                                                        {{ $festEvent->title }}
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @elseif($festival_id)
                                    <div class="bg-neutral-50 dark:bg-neutral-900 rounded-2xl p-6 border border-neutral-200 dark:border-neutral-700">
                                        <h3 class="font-bold text-neutral-900 dark:text-white mb-4 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                            </svg>
                                            Fa Parte del Festival
                                        </h3>
                                        @php
                                            $festival = \App\Models\Event::find($festival_id);
                                        @endphp
                                        @if($festival)
                                            <div class="bg-white dark:bg-neutral-800 rounded-lg p-4 font-semibold text-neutral-900 dark:text-white">
                                                {{ $festival->title }}
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                {{-- Promotional Video --}}
                                @if($promotional_video)
                                    <div class="bg-neutral-50 dark:bg-neutral-900 rounded-2xl p-6 border border-neutral-200 dark:border-neutral-700">
                                        <h3 class="font-bold text-neutral-900 dark:text-white mb-4 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                            </svg>
                                            {{ __('events.create.promotional_video') }}
                                        </h3>
                                        <div class="bg-white dark:bg-neutral-800 rounded-lg p-3 font-mono text-sm text-neutral-900 dark:text-white break-all">
                                            {{ $promotional_video }}
                                        </div>
                                    </div>
                                @endif

                                {{-- Requirements --}}
                                @if($requirements)
                                    <div class="bg-neutral-50 dark:bg-neutral-900 rounded-2xl p-6 border border-neutral-200 dark:border-neutral-700">
                                        <h3 class="font-bold text-neutral-900 dark:text-white mb-4 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                            </svg>
                                            Requisiti per la Partecipazione
                                        </h3>
                                        <div class="bg-white dark:bg-neutral-800 rounded-lg p-4 text-neutral-900 dark:text-white whitespace-pre-wrap">
                                            {{ $requirements }}
                                        </div>
                                    </div>
                                @endif

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
                                            <dt class="font-medium text-neutral-600 dark:text-neutral-400">{{ __('events.create.max_participants') }}:</dt>
                                            <dd class="font-semibold text-neutral-900 dark:text-white">{{ $max_participants ?: '∞ ' . __('events.create.unlimited') }}</dd>
                                        </div>
                                        @if($registration_deadline)
                                            <div class="flex justify-between items-start">
                                                <dt class="font-medium text-neutral-600 dark:text-neutral-400">Scadenza Iscrizioni:</dt>
                                                <dd class="font-semibold text-neutral-900 dark:text-white">{{ \Carbon\Carbon::parse($registration_deadline)->format('d/m/Y H:i') }}</dd>
                                            </div>
                                        @endif
                                        <div class="flex justify-between items-start">
                                            <dt class="font-medium text-neutral-600 dark:text-neutral-400">Stato:</dt>
                                            <dd>
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                                                             {{ $status === 'published' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300' }}">
                                                    {{ $status === 'published' ? __('events.create.published_badge') : __('events.create.draft_badge') }}
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
                                    <h4 class="text-xl font-bold text-neutral-900 dark:text-white mb-2">{{ __('events.create.all_set') }}</h4>
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
                                {{ $status === 'published' ? __('events.create.publish_event') : __('events.create.save_draft') }}
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
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

/* Force Leaflet map visibility */
#eventCreationMap {
    display: block !important;
    width: 100% !important;
    height: 384px !important;
}

#eventCreationMap .leaflet-container {
    width: 100% !important;
    height: 100% !important;
    position: relative !important;
}

#eventCreationMap .leaflet-pane,
#eventCreationMap .leaflet-tile-pane,
#eventCreationMap .leaflet-overlay-pane {
    display: block !important;
}

#eventCreationMap .leaflet-tile {
    opacity: 1 !important;
    visibility: visible !important;
}

/* Ensure markers are visible */
#eventCreationMap .leaflet-marker-pane {
    z-index: 600 !important;
}

#eventCreationMap .custom-event-marker {
    display: block !important;
    opacity: 1 !important;
    visibility: visible !important;
}
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
let creationMap = null;
let creationMarker = null;

// DO NOT auto-initialize! Only when Step 2 is visible and In Presenza is selected
function initCreationMap() {
    const mapContainer = document.getElementById('eventCreationMap');
    
    if (!mapContainer) {
        console.log('❌ Map container not found');
        return;
    }
    
    if (typeof L === 'undefined') {
        console.log('❌ Leaflet not loaded, retrying...');
        setTimeout(initCreationMap, 300);
        return;
    }

    // Don't re-initialize if map already exists
    if (creationMap) {
        console.log('✅ Map already initialized, skipping...');
        creationMap.invalidateSize();
        return;
    }

    // Check if container is visible AND has dimensions
    const rect = mapContainer.getBoundingClientRect();
    console.log('📐 Container dimensions:', rect.width, 'x', rect.height, 'visible:', mapContainer.offsetParent !== null);
    
    if (rect.width === 0 || rect.height === 0) {
        console.log('❌ Map container has no dimensions, skipping init');
        return;
    }

    console.log('🗺️ CREATING NEW map with container size:', rect.width, 'x', rect.height);

    // Default to Rome, Italy
    const defaultLat = 41.9028;
    const defaultLng = 12.4964;

    creationMap = L.map('eventCreationMap', {
        center: [defaultLat, defaultLng],
        zoom: 6,
        zoomControl: true,
        scrollWheelZoom: true
    });

    console.log('🗺️ Map object created, adding tile layer...');

    const tileLayer = L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
        attribution: '© OpenStreetMap, © CartoDB',
        maxZoom: 19,
        minZoom: 3
    });

    tileLayer.on('loading', () => console.log('🔄 Tiles loading...'));
    tileLayer.on('load', () => console.log('✅ Tiles loaded!'));
    tileLayer.on('tileerror', (error) => console.error('❌ Tile error:', error));

    tileLayer.addTo(creationMap);
    
    console.log('✅ Tile layer added to map');

    // Click to add marker
    creationMap.on('click', function(e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;

        console.log('📍 Click on map at:', lat, lng);

        // Remove old marker
        if (creationMarker) {
            console.log('🗑️ Removing old marker');
            creationMap.removeLayer(creationMarker);
        }

        // Add new marker with custom icon
        creationMarker = L.marker([lat, lng], {
            icon: L.divIcon({
                html: `<div style="background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); width: 32px; height: 32px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); box-shadow: 0 4px 12px rgba(34, 197, 94, 0.4); border: 3px solid white; position: relative; z-index: 1000;"></div>`,
                className: 'custom-event-marker',
                iconSize: [32, 32],
                iconAnchor: [16, 32]
            }),
            zIndexOffset: 1000
        }).addTo(creationMap);

        console.log('✅ Marker added at:', lat, lng);

        // Center map on marker
        creationMap.setView([lat, lng], creationMap.getZoom());

        // Update Livewire component
        @this.set('latitude', lat.toFixed(6));
        @this.set('longitude', lng.toFixed(6));

        // Reverse geocode to get address
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&accept-language=it`)
            .then(response => response.json())
            .then(data => {
                if (data.address) {
                    if (data.address.city || data.address.town || data.address.village) {
                        @this.set('city', data.address.city || data.address.town || data.address.village);
                    }
                    if (data.address.postcode) {
                        @this.set('postcode', data.address.postcode);
                    }
                    if (data.address.road && data.address.house_number) {
                        @this.set('venue_address', data.address.road + ', ' + data.address.house_number);
                    } else if (data.address.road) {
                        @this.set('venue_address', data.address.road);
                    }
                }
            })
            .catch(err => console.error('Geocoding error:', err));
    });

    // MULTIPLE invalidateSize calls to ensure proper rendering
    setTimeout(() => {
        if (creationMap) {
            console.log('🔧 First resize (200ms)...');
            creationMap.invalidateSize();
        }
    }, 200);
    
    setTimeout(() => {
        if (creationMap) {
            console.log('🔧 Second resize (500ms)...');
            creationMap.invalidateSize();
        }
    }, 500);
    
    setTimeout(() => {
        if (creationMap) {
            console.log('🔧 Final resize (1000ms)...');
            creationMap.invalidateSize();
        }
    }, 1000);

    console.log('✅ Event creation map initialized successfully!');

    // Load existing marker if coordinates exist (e.g., from recent venue)
    setTimeout(() => {
        const existingLat = @this.get('latitude');
        const existingLng = @this.get('longitude');
        
        if (existingLat && existingLng && creationMap) {
            console.log('📍 Loading existing marker at:', existingLat, existingLng);
            
            const lat = parseFloat(existingLat);
            const lng = parseFloat(existingLng);
            
            // Add marker
            creationMarker = L.marker([lat, lng], {
                icon: L.divIcon({
                    html: `<div style="background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); width: 32px; height: 32px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); box-shadow: 0 4px 12px rgba(34, 197, 94, 0.4); border: 3px solid white; position: relative; z-index: 1000;"></div>`,
                    className: 'custom-event-marker',
                    iconSize: [32, 32],
                    iconAnchor: [16, 32]
                }),
                zIndexOffset: 1000
            }).addTo(creationMap);
            
            // Center map on marker
            creationMap.setView([lat, lng], 14);
            
            console.log('✅ Existing marker loaded!');
        }
    }, 1200);
}

// Geocode address and place marker
function geocodeAddress() {
    if (!creationMap) {
        console.log('❌ Map not initialized yet');
        return;
    }

    const address = @this.get('venue_address') || '';
    const city = @this.get('city') || '';
    const country = @this.get('country') || '';

    if (!address && !city) {
        console.log('❌ No address or city to geocode');
        return;
    }

    const fullAddress = [address, city, country].filter(Boolean).join(', ');
    
    console.log('🔍 Geocoding address:', fullAddress);

    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(fullAddress)}&accept-language=it&limit=1`)
        .then(response => response.json())
        .then(data => {
            if (data && data.length > 0) {
                const result = data[0];
                const lat = parseFloat(result.lat);
                const lng = parseFloat(result.lon);

                console.log('✅ Geocoded to:', lat, lng);

                // Remove old marker
                if (creationMarker) {
                    creationMap.removeLayer(creationMarker);
                }

                // Add new marker
                creationMarker = L.marker([lat, lng], {
                    icon: L.divIcon({
                        html: `<div style="background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); width: 32px; height: 32px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); box-shadow: 0 4px 12px rgba(34, 197, 94, 0.4); border: 3px solid white; position: relative; z-index: 1000;"></div>`,
                        className: 'custom-event-marker',
                        iconSize: [32, 32],
                        iconAnchor: [16, 32]
                    }),
                    zIndexOffset: 1000
                }).addTo(creationMap);

                // Center map on marker
                creationMap.setView([lat, lng], 14);

                // Update coordinates
                @this.set('latitude', lat.toFixed(6));
                @this.set('longitude', lng.toFixed(6));

                console.log('📍 Marker placed at geocoded address');
            } else {
                console.log('❌ No geocoding results found');
            }
        })
        .catch(err => console.error('Geocoding error:', err));
}

// Debounce timer for geocoding
let geocodeTimeout = null;

// Function to trigger geocoding when address fields change
function setupAddressGeocoding() {
    const addressInput = document.getElementById('venue_address');
    const cityInput = document.getElementById('city');
    
    if (addressInput) {
        addressInput.addEventListener('input', () => {
            // Clear existing timeout
            if (geocodeTimeout) {
                clearTimeout(geocodeTimeout);
            }
            
            // Debounce geocoding (wait 1.5 seconds after user stops typing)
            geocodeTimeout = setTimeout(() => {
                const address = addressInput.value || '';
                const city = cityInput?.value || '';
                
                if ((address.length > 3 || city.length > 2) && creationMap) {
                    console.log('🔄 Auto-geocoding address...');
                    geocodeAddress();
                }
            }, 1500);
        });
    }
    
    if (cityInput) {
        cityInput.addEventListener('input', () => {
            // Clear existing timeout
            if (geocodeTimeout) {
                clearTimeout(geocodeTimeout);
            }
            
            // Debounce geocoding (wait 1.5 seconds after user stops typing)
            geocodeTimeout = setTimeout(() => {
                const address = addressInput?.value || '';
                const city = cityInput.value || '';
                
                if ((address.length > 3 || city.length > 2) && creationMap) {
                    console.log('🔄 Auto-geocoding address from city...');
                    geocodeAddress();
                }
            }, 1500);
        });
    }
}

// Listen for Livewire initialization
document.addEventListener('livewire:init', () => {
    // Setup address geocoding after a delay to ensure DOM is ready
    setTimeout(() => {
        setupAddressGeocoding();
    }, 500);
    
    Livewire.hook('commit', ({ component, commit, respond, succeed, fail }) => {
        succeed(({ snapshot, effect }) => {
            setTimeout(() => {
                const mapContainer = document.getElementById('eventCreationMap');
                if (mapContainer && mapContainer.offsetParent !== null && !creationMap) {
                    console.log('🔄 Livewire updated, map container visible, initializing...');
                    initCreationMap();
                    // Setup geocoding listeners again after map init
                    setupAddressGeocoding();
                }
            }, 500);
        });
    });
});

// Also try when Step 2 becomes visible
document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        const mapContainer = document.getElementById('eventCreationMap');
        if (mapContainer && mapContainer.offsetParent !== null) {
            console.log('📍 DOMContentLoaded, map visible, initializing...');
            initCreationMap();
            setupAddressGeocoding();
        }
    }, 1000);
});

// Watch for Livewire updates (step changes, etc.)
document.addEventListener('livewire:navigated', () => {
    setTimeout(() => {
        setupAddressGeocoding();
        const mapContainer = document.getElementById('eventCreationMap');
        if (mapContainer && mapContainer.offsetParent !== null && !creationMap) {
            initCreationMap();
        }
    }, 500);
});
</script>
@endpush
