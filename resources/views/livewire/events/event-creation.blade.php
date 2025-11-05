{{-- INNOVATIVE EVENT CREATION FORM - Total Redesign --}}
<div class="min-h-screen bg-neutral-950 relative overflow-hidden" 
     x-data="{ 
         currentStep: @entangle('currentStep'),
         mouseX: 0, 
         mouseY: 0,
         tiltX: 0,
         tiltY: 0
     }"
     @mousemove.window="
         mouseX = $event.clientX; 
         mouseY = $event.clientY;
         tiltX = (($event.clientY / window.innerHeight) - 0.5) * 20;
         tiltY = (($event.clientX / window.innerWidth) - 0.5) * -20;
     ">
    
    {{-- ANIMATED BACKGROUND WITH MORPHING BLOBS --}}
    <div class="absolute inset-0 overflow-hidden">
        {{-- Mesh Gradient Background --}}
        <div class="absolute inset-0 bg-gradient-to-br from-violet-950 via-neutral-950 to-emerald-950"></div>
        
        {{-- Morphing Blobs --}}
        <div class="absolute top-0 -left-40 w-96 h-96 bg-gradient-to-br from-violet-600/30 to-purple-600/30 rounded-full blur-3xl animate-blob"></div>
        <div class="absolute top-0 -right-40 w-96 h-96 bg-gradient-to-br from-emerald-600/30 to-cyan-600/30 rounded-full blur-3xl animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-40 left-1/2 w-96 h-96 bg-gradient-to-br from-pink-600/30 to-rose-600/30 rounded-full blur-3xl animate-blob animation-delay-4000"></div>
        
        {{-- Grid Pattern --}}
        <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_80%_50%_at_50%_50%,black,transparent)]"></div>
    </div>

    <div class="relative z-10 max-w-[1400px] mx-auto px-6 py-12">
        {{-- HERO SECTION - Asymmetric Layout --}}
        <div class="grid lg:grid-cols-[1fr_2fr] gap-12 mb-12">
            {{-- Left: Steps Navigation (Vertical on desktop) --}}
            <div class="relative">
                {{-- Floating Card with Steps --}}
                <div class="sticky top-24 backdrop-blur-2xl bg-white/5 rounded-3xl p-8 border border-white/10 shadow-2xl">
                    <div class="mb-8">
                        <h1 class="text-4xl font-black text-white mb-3 tracking-tight">
                            Crea Evento
                        </h1>
                        <p class="text-white/60">
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
                                               ? 'bg-gradient-to-r from-violet-500/20 to-emerald-500/20 border border-violet-500/50' 
                                               : 'hover:bg-white/5 border border-transparent' }}">
                                {{-- Step Number with Glow --}}
                                <div class="relative flex-shrink-0">
                                    @if($stepNum < $currentStep)
                                        {{-- Completed --}}
                                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-cyan-500 flex items-center justify-center shadow-lg shadow-emerald-500/50">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300
                                                    {{ $stepNum == $currentStep 
                                                        ? 'bg-gradient-to-br from-violet-500 to-pink-500 shadow-lg shadow-violet-500/50' 
                                                        : 'bg-white/10 group-hover:bg-white/20' }}">
                                            <svg class="w-6 h-6 {{ $stepNum == $currentStep ? 'text-white' : 'text-white/40' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $step['icon'] }}"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                
                                {{-- Step Info --}}
                                <div class="flex-1 text-left">
                                    <div class="font-semibold {{ $stepNum == $currentStep ? 'text-white' : 'text-white/60 group-hover:text-white/80' }}">
                                        {{ $step['title'] }}
                                    </div>
                                    <div class="text-sm text-white/40">
                                        {{ $step['desc'] }}
                                    </div>
                                </div>
                            </button>
                        @endforeach
                    </div>

                    {{-- Progress Bar --}}
                    <div class="mt-8 pt-8 border-t border-white/10">
                        <div class="flex items-center justify-between text-sm text-white/60 mb-2">
                            <span>Progresso</span>
                            <span class="font-semibold text-white">{{ round(($currentStep / $totalSteps) * 100) }}%</span>
                        </div>
                        <div class="h-2 bg-white/10 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-violet-500 via-pink-500 to-emerald-500 rounded-full transition-all duration-700"
                                 style="width: {{ ($currentStep / $totalSteps) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: Form Content with 3D Tilt --}}
            <div class="relative" 
                 :style="`transform: perspective(1000px) rotateX(${tiltX}deg) rotateY(${tiltY}deg); transition: transform 0.1s ease-out;`">
                
                <form wire:submit.prevent="save" class="space-y-8">
                    {{-- ============ STEP 1: BASIC INFO ============ --}}
                    <div x-show="$wire.currentStep === 1"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 translate-x-20"
                         x-transition:enter-end="opacity-100 translate-x-0">
                        
                        {{-- Card with Neomorphism + Glass --}}
                        <div class="backdrop-blur-2xl bg-gradient-to-br from-white/10 to-white/5 rounded-3xl p-8 border border-white/20 shadow-2xl">
                            {{-- Header --}}
                            <div class="flex items-center gap-4 mb-8">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-violet-500 to-pink-500 flex items-center justify-center shadow-lg shadow-violet-500/50">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-white">Informazioni Base</h2>
                                    <p class="text-white/60">I dettagli essenziali del tuo evento</p>
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
                                               class="peer w-full px-5 py-4 rounded-2xl bg-white/5 border-2 border-white/10 text-white placeholder-transparent
                                                      focus:border-violet-500/50 focus:bg-white/10 focus:ring-4 focus:ring-violet-500/10
                                                      transition-all duration-300 @error('title') border-red-500/50 ring-4 ring-red-500/10 @enderror">
                                        <label for="title" 
                                               class="absolute left-5 -top-2.5 px-2 text-sm font-medium bg-neutral-950 text-white/60
                                                      peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:text-white/40
                                                      peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-violet-400
                                                      transition-all duration-200">
                                            Titolo Evento *
                                        </label>
                                        {{-- Glow on focus --}}
                                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-violet-500/0 via-pink-500/20 to-violet-500/0 opacity-0 peer-focus:opacity-100 transition-opacity -z-10 blur-xl"></div>
                                    </div>
                                    @error('title')
                                        <p class="mt-2 text-sm text-red-400 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"/></svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                    @if(strlen($title) > 0)
                                        <p class="mt-2 text-sm text-white/40">{{ strlen($title) }}/255 caratteri</p>
                                    @endif
                                </div>

                                {{-- Subtitle Toggle (Neumorphic Switch) --}}
                                <div class="flex items-center justify-between p-5 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition-all group cursor-pointer"
                                     wire:click="toggleSubtitle">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-7 rounded-full relative transition-all duration-300
                                                    {{ $has_subtitle ? 'bg-gradient-to-r from-violet-500 to-pink-500' : 'bg-white/10' }}">
                                            <div class="absolute top-1 w-5 h-5 bg-white rounded-full shadow-lg transition-all duration-300
                                                        {{ $has_subtitle ? 'left-6' : 'left-1' }}"></div>
                                        </div>
                                        <span class="text-white font-medium">Aggiungi Sottotitolo</span>
                                    </div>
                                    <span class="text-sm text-white/40">Opzionale</span>
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
                                               class="peer w-full px-5 py-4 rounded-2xl bg-white/5 border-2 border-white/10 text-white placeholder-transparent
                                                      focus:border-pink-500/50 focus:bg-white/10 focus:ring-4 focus:ring-pink-500/10
                                                      transition-all duration-300">
                                        <label for="subtitle" 
                                               class="absolute left-5 -top-2.5 px-2 text-sm font-medium bg-neutral-950 text-white/60
                                                      peer-placeholder-shown:top-4 peer-placeholder-shown:text-base
                                                      peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-pink-400
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
                                                class="w-full px-5 py-4 rounded-2xl bg-white/5 border-2 border-white/10 text-white appearance-none cursor-pointer
                                                       focus:border-emerald-500/50 focus:bg-white/10 focus:ring-4 focus:ring-emerald-500/10
                                                       transition-all duration-300">
                                            <option value="" class="bg-neutral-900">Seleziona categoria</option>
                                            @foreach(App\Models\Event::getCategories() as $key => $name)
                                                <option value="{{ $key }}" class="bg-neutral-900">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="category" class="absolute left-5 -top-2.5 px-2 text-sm font-medium bg-neutral-950 text-white/60">
                                            Categoria *
                                        </label>
                                        <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-white/40 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>

                                    {{-- Visibility Radio Cards --}}
                                    <div>
                                        <label class="block text-sm font-medium text-white/60 mb-3">Visibilità *</label>
                                        <div class="grid grid-cols-2 gap-3">
                                            <label class="relative cursor-pointer">
                                                <input type="radio" wire:model="is_public" value="1" class="sr-only peer">
                                                <div class="p-4 rounded-2xl border-2 text-center transition-all
                                                            peer-checked:border-emerald-500/50 peer-checked:bg-emerald-500/10 peer-checked:shadow-lg peer-checked:shadow-emerald-500/20
                                                            border-white/10 bg-white/5 hover:bg-white/10">
                                                    <svg class="w-6 h-6 mx-auto mb-1 transition-colors {{ $is_public ? 'text-emerald-400' : 'text-white/40' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <span class="text-sm font-medium {{ $is_public ? 'text-white' : 'text-white/60' }}">Pubblico</span>
                                                </div>
                                            </label>
                                            <label class="relative cursor-pointer">
                                                <input type="radio" wire:model="is_public" value="0" class="sr-only peer">
                                                <div class="p-4 rounded-2xl border-2 text-center transition-all
                                                            peer-checked:border-pink-500/50 peer-checked:bg-pink-500/10 peer-checked:shadow-lg peer-checked:shadow-pink-500/20
                                                            border-white/10 bg-white/5 hover:bg-white/10">
                                                    <svg class="w-6 h-6 mx-auto mb-1 transition-colors {{ !$is_public ? 'text-pink-400' : 'text-white/40' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                                    </svg>
                                                    <span class="text-sm font-medium {{ !$is_public ? 'text-white' : 'text-white/60' }}">Privato</span>
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
                                              class="peer w-full px-5 py-4 rounded-2xl bg-white/5 border-2 border-white/10 text-white placeholder-transparent resize-none
                                                     focus:border-cyan-500/50 focus:bg-white/10 focus:ring-4 focus:ring-cyan-500/10
                                                     transition-all duration-300"></textarea>
                                    <label for="description" 
                                           class="absolute left-5 -top-2.5 px-2 text-sm font-medium bg-neutral-950 text-white/60
                                                  peer-placeholder-shown:top-4 peer-placeholder-shown:text-base
                                                  peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-cyan-400
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
                                              class="peer w-full px-5 py-4 rounded-2xl bg-white/5 border-2 border-white/10 text-white placeholder-transparent resize-none
                                                     focus:border-amber-500/50 focus:bg-white/10 focus:ring-4 focus:ring-amber-500/10
                                                     transition-all duration-300"></textarea>
                                    <label for="requirements" 
                                           class="absolute left-5 -top-2.5 px-2 text-sm font-medium bg-neutral-950 text-white/60
                                                  peer-placeholder-shown:top-4 peer-placeholder-shown:text-base
                                                  peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-amber-400
                                                  transition-all duration-200">
                                        Requisiti
                                    </label>
                                    <p class="mt-2 text-sm text-white/40">Eventuali requisiti per partecipare</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- PLACEHOLDER for other steps --}}
                    @for($i = 2; $i <= 5; $i++)
                        <div x-show="$wire.currentStep === {{ $i }}"
                             x-transition:enter="transition ease-out duration-500"
                             x-transition:enter-start="opacity-0 translate-x-20"
                             x-transition:enter-end="opacity-100 translate-x-0">
                            <div class="backdrop-blur-2xl bg-gradient-to-br from-white/10 to-white/5 rounded-3xl p-8 border border-white/20 shadow-2xl">
                                <div class="text-center py-20">
                                    <div class="w-20 h-20 rounded-3xl bg-gradient-to-br from-violet-500 to-pink-500 flex items-center justify-center mx-auto mb-6 shadow-2xl shadow-violet-500/50">
                                        <span class="text-4xl font-black text-white">{{ $i }}</span>
                                    </div>
                                    <h3 class="text-2xl font-bold text-white mb-2">Step {{ $i }}</h3>
                                    <p class="text-white/60">Contenuto in arrivo...</p>
                                </div>
                            </div>
                        </div>
                    @endfor

                    {{-- Navigation Buttons --}}
                    <div class="flex items-center justify-between gap-4 pt-8">
                        @if($currentStep > 1)
                            <button type="button"
                                    wire:click="prevStep"
                                    class="px-8 py-4 rounded-2xl bg-white/10 border border-white/20 text-white font-semibold
                                           hover:bg-white/20 hover:border-white/30 hover:scale-105
                                           active:scale-95 transition-all duration-200 flex items-center gap-2">
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
                                    class="px-8 py-4 rounded-2xl bg-gradient-to-r from-violet-500 via-pink-500 to-emerald-500 text-white font-bold text-lg
                                           hover:shadow-2xl hover:shadow-violet-500/50 hover:scale-105
                                           active:scale-95 transition-all duration-200 flex items-center gap-2">
                                Avanti
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        @else
                            <button type="submit"
                                    class="px-12 py-4 rounded-2xl bg-gradient-to-r from-emerald-500 to-cyan-500 text-white font-black text-xl
                                           hover:shadow-2xl hover:shadow-emerald-500/50 hover:scale-105
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

{{-- CUSTOM ANIMATIONS --}}
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
