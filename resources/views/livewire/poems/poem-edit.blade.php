@push('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    /* Quill Editor - Stile Foglio di Carta */
    .ql-container {
        font-family: 'Crimson Pro', Georgia, serif !important;
        font-size: 1.25rem !important;
        line-height: 1.8 !important;
    }
    
    .ql-editor {
        min-height: 500px !important;
        padding: 3rem 2rem !important;
        color: #1c1917 !important;
    }
    
    .ql-editor.ql-blank::before {
        font-family: 'Crimson Pro', Georgia, serif !important;
        font-style: italic !important;
        color: #a8a29e !important;
        font-size: 1.125rem !important;
    }
    
    /* Toolbar - Stile Poetico */
    .ql-toolbar {
        background: linear-gradient(to bottom, #f5f5f4, #e7e5e4) !important;
        border: none !important;
        border-bottom: 2px solid #a7f3d0 !important;
        border-radius: 1rem 1rem 0 0 !important;
        padding: 1rem !important;
    }
    
    .ql-snow .ql-stroke {
        stroke: #10b981 !important;
    }
    
    .ql-snow .ql-fill {
        fill: #10b981 !important;
    }
    
    .ql-snow .ql-picker-label:hover,
    .ql-snow button:hover {
        color: #059669 !important;
    }
    
    .ql-snow button:hover .ql-stroke {
        stroke: #059669 !important;
    }
    
    /* FOGLIO DI CARTA REALISTICO - Bordi Consumati */
    .paper-bg {
        position: relative;
        background: #fefcf5;
        /* Bordi irregolari consumati */
        clip-path: polygon(
            0.5% 0.2%, 1.5% 0.8%, 3% 0.3%, 5% 1.2%, 8% 0.5%, 12% 1%, 
            15% 0.4%, 20% 0.9%, 25% 0.3%, 30% 0.8%, 35% 0.5%, 40% 1.1%, 
            45% 0.4%, 50% 0.9%, 55% 0.6%, 60% 1%, 65% 0.4%, 70% 0.8%, 
            75% 0.5%, 80% 1.2%, 85% 0.6%, 90% 0.9%, 95% 0.4%, 97% 0.8%, 99% 0.5%,
            /* TOP-RIGHT angolo piegato */
            99.5% 2%, 99% 4%, 98.5% 6%, 98% 8%,
            /* DESTRA */
            99.2% 15%, 99.8% 20%, 99.3% 25%, 99.7% 30%, 99.4% 35%, 99.8% 40%,
            99.5% 45%, 99.9% 50%, 99.4% 55%, 99.7% 60%, 99.5% 65%, 99.8% 70%,
            99.3% 75%, 99.7% 80%, 99.5% 85%, 99.8% 90%, 99.4% 95%, 99.6% 97%,
            /* BOTTOM-RIGHT */
            99% 99%, 98% 99.5%, 96% 99.2%, 94% 99.7%,
            /* BASSO */
            90% 99.5%, 85% 99.2%, 80% 99.6%, 75% 99.3%, 70% 99.7%, 65% 99.4%,
            60% 99.8%, 55% 99.3%, 50% 99.6%, 45% 99.4%, 40% 99.7%, 35% 99.5%,
            30% 99.8%, 25% 99.4%, 20% 99.7%, 15% 99.5%, 10% 99.8%, 5% 99.4%,
            /* BOTTOM-LEFT */
            2% 99.2%, 1% 98.5%, 0.5% 97%,
            /* SINISTRA */
            0.3% 90%, 0.8% 85%, 0.4% 80%, 0.7% 75%, 0.5% 70%, 0.9% 65%,
            0.3% 60%, 0.7% 55%, 0.5% 50%, 0.8% 45%, 0.4% 40%, 0.9% 35%,
            0.5% 30%, 0.8% 25%, 0.4% 20%, 0.9% 15%, 0.5% 10%, 0.7% 5%, 0.4% 2%
        );
        box-shadow: 
            /* Ombre profonde realistiche */
            0 2px 3px rgba(0,0,0,0.12),
            0 4px 8px rgba(0,0,0,0.08),
            0 8px 20px rgba(0,0,0,0.06),
            0 16px 32px rgba(0,0,0,0.04),
            /* Ombra interna per depth */
            inset 0 0 100px rgba(0,0,0,0.02),
            /* Bordi scuri (spessore carta) */
            inset 2px 0 2px -1px rgba(0,0,0,0.08),
            inset -2px 0 2px -1px rgba(0,0,0,0.08),
            inset 0 2px 2px -1px rgba(255,255,255,0.5),
            inset 0 -2px 3px -1px rgba(0,0,0,0.1);
    }
    
    /* Angolo piegato BOTTOM-RIGHT (visibile!) */
    .paper-bg::before {
        content: '';
        position: absolute;
        bottom: 0;
        right: 0;
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 0 0 60px 60px;
        border-color: transparent transparent #e7e5e4 transparent;
        z-index: 100;
        filter: drop-shadow(-3px -3px 4px rgba(0,0,0,0.18));
    }
    
    /* Triangolo ombra angolo piegato */
    .paper-corner-shadow {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 0 0 60px 60px;
        border-color: transparent transparent rgba(0,0,0,0.12) transparent;
        z-index: 99;
    }
    
    /* Texture carta + imperfezioni */
    .paper-texture {
        position: absolute;
        inset: 0;
        background-image: 
            url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='2' numOctaves='4' /%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.06'/%3E%3C/svg%3E"),
            radial-gradient(circle at 15% 20%, rgba(210,180,140,0.04) 0%, transparent 40%),
            radial-gradient(circle at 85% 80%, rgba(210,180,140,0.03) 0%, transparent 40%),
            radial-gradient(circle at 60% 50%, rgba(139,119,101,0.02) 0%, transparent 50%);
        pointer-events: none;
        mix-blend-mode: multiply;
        border-radius: 4px;
        z-index: 1;
    }
    
    /* Quill container */
    .ql-container {
        border: none !important;
        border-radius: 0 0 0.5rem 0.5rem !important;
        background: transparent !important;
    }
    
    /* Quill editor area */
    .ql-editor {
        background: transparent !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
@endpush

<div class="min-h-screen bg-gradient-to-br from-neutral-50 via-primary-50/20 to-neutral-50 dark:from-neutral-900 dark:via-primary-950/10 dark:to-neutral-900"
     wire:poll.30s="autoSave">
    
    <!-- VERSI ISPIRATORI FLUTTUANTI -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden" style="z-index: 5;" aria-hidden="true">
        @php
            $inspirationalVerses = [
                "Le parole sono ali dell'anima...",
                "Ogni verso un battito del cuore",
                "La poesia è musica silenziosa",
                "Scrivi con il cuore, leggi con l'anima",
                "Nel silenzio nascono i versi più belli",
                "La bellezza delle parole non dette"
            ];
        @endphp
        
        @foreach($inspirationalVerses as $idx => $verse)
            <div class="absolute font-poem text-2xl md:text-3xl italic font-light"
                 style="
                    top: {{ 10 + ($idx * 15) }}%;
                    {{ $idx % 2 === 0 ? 'left' : 'right' }}: {{ 3 + ($idx * 8) }}%;
                    color: #10b981;
                    opacity: 0.10;
                    animation: float-gentle-{{ $idx }} {{ 25 + ($idx * 3) }}s ease-in-out infinite;
                    animation-delay: {{ $idx * 2 }}s;
                    z-index: 5;
                ">
                "{{ $verse }}"
            </div>
            
            <style>
                @keyframes float-gentle-{{ $idx }} {
                    0%, 100% { transform: translateY(0) rotate({{ -3 + $idx }}deg); }
                    50% { transform: translateY(-35px) rotate({{ -2 + $idx }}deg); }
                }
            </style>
        @endforeach
    </div>
    
    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12" style="z-index: 10;">
        
        <!-- Back Button -->
        <a href="{{ route('poems.index') }}" 
           class="inline-flex items-center gap-2 text-neutral-600 dark:text-neutral-400
                  hover:text-primary-500 transition-colors mb-8 group">
            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span class="font-poem">Torna alle poesie</span>
        </a>
        
        <!-- Header Poetico -->
        <div class="text-center mb-12 relative">
            <div class="absolute -top-6 left-1/2 -translate-x-1/2 text-primary-200 dark:text-primary-900/30 text-9xl font-poem leading-none pointer-events-none">
                ✍
            </div>
            
            <h1 class="text-5xl md:text-6xl font-bold text-neutral-900 dark:text-white mb-4 font-poem relative z-10">
                Modifica la Tua Poesia
            </h1>
            <p class="text-xl text-neutral-600 dark:text-neutral-400 font-poem italic max-w-2xl mx-auto">
                "Raffina i tuoi versi, perfeziona la tua arte"
            </p>
            
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mt-4 inline-flex items-center gap-2 px-6 py-3 rounded-2xl
                            bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 text-base shadow-lg
                            animate-fade-in-scale">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif
            
            @if(session('error'))
                <div class="mt-4 inline-flex items-center gap-2 px-6 py-3 rounded-2xl
                            bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 text-base shadow-lg
                            animate-fade-in-scale">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            @endif
            
            @if($errors->any())
                <div class="mt-4 px-6 py-4 rounded-2xl bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 shadow-lg">
                    <p class="font-semibold mb-2">Errori di validazione:</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <!-- Auto-save indicator -->
            @if($lastSaved)
                <div class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-full
                            bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 text-sm">
                    <svg class="w-4 h-4 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">Bozza salvata alle {{ $lastSaved }}</span>
                </div>
            @endif
        </div>
        
        <form wire:submit.prevent="save" 
              @submit="console.log('Form submitted')"
              class="space-y-8">
            
            <!-- Main Card - Come un diario poetico -->
            <div class="backdrop-blur-2xl bg-white/90 dark:bg-neutral-800/90 
                        rounded-[3rem] shadow-2xl border-2 border-primary-100 dark:border-primary-900/50
                        overflow-hidden">
                
                <div class="p-8 md:p-12 lg:p-16">
                    
                    <!-- Titolo -->
                    <div class="mb-8">
                        <label class="block text-lg font-semibold text-neutral-900 dark:text-white mb-3 font-poem flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                            </svg>
                            Titolo <span class="text-neutral-400 font-normal text-sm">(opzionale)</span>
                        </label>
                        <input wire:model.blur="title"
                               type="text"
                               placeholder="Un titolo per i tuoi versi..."
                               class="w-full px-6 py-4 rounded-2xl border-2 border-neutral-200 dark:border-neutral-700
                                      bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white
                                      focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20
                                      transition-all duration-300
                                      font-poem text-2xl font-bold placeholder:text-neutral-400 placeholder:font-normal">
                        @error('title') 
                            <p class="mt-2 text-sm text-red-500 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <!-- Editor Principale con Quill -->
                    <div class="mb-8">
                        <label class="block text-lg font-semibold text-neutral-900 dark:text-white mb-3 font-poem flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            I Tuoi Versi <span class="text-red-500">*</span>
                        </label>
                        
                        <!-- FOGLIO DI CARTA REALISTICO CON BORDI 3D -->
                        <div class="relative" style="transform: perspective(1000px) rotateX(0.5deg);">
                            <div class="relative overflow-visible paper-bg"
                                 style="
                                    background-image: 
                                        repeating-linear-gradient(
                                            transparent,
                                            transparent 38px,
                                            rgba(59, 130, 246, 0.15) 38px,
                                            rgba(59, 130, 246, 0.15) 39px
                                        ),
                                        linear-gradient(to right,
                                            transparent 0px,
                                            transparent 50px,
                                            rgba(220, 38, 38, 0.25) 50px,
                                            rgba(220, 38, 38, 0.25) 52px,
                                            transparent 52px
                                        );
                                    background-position: 0 10px, 0 0;
                                    background-size: 100% 100%, 100% 100%;
                                ">
                                
                                <!-- Ombra angolo piegato -->
                                <div class="paper-corner-shadow"></div>
                                
                                <!-- Texture carta -->
                                <div class="paper-texture"></div>
                            
                            <!-- Quill Editor Container -->
                            <div id="quill-editor-wrapper">
                                <div id="quill-editor" 
                                     class="min-h-[500px] font-poem text-xl leading-relaxed bg-transparent"
                                     style="border: none; padding-left: 72px;"></div>
                            </div>
                            <textarea wire:model="content" id="quill-content" style="display:none;"></textarea>
                        </div>
                        </div>
                        
                        @error('content') 
                            <p class="mt-2 text-sm text-red-500 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        
                        <!-- Word count -->
                        <div class="mt-2 text-sm text-neutral-500 dark:text-neutral-400 flex items-center gap-4">
                            <span>{{ str_word_count($content) }} parole</span>
                            <span>•</span>
                            <span>{{ strlen($content) }} caratteri</span>
                        </div>
                    </div>
                    
                    <!-- Descrizione Breve -->
                    <div class="mb-8">
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-3 font-poem">
                            Descrizione Breve <span class="text-neutral-400">(opzionale)</span>
                        </label>
                        <textarea wire:model.blur="description"
                                  rows="3"
                                  placeholder="Una breve introduzione alla tua poesia..."
                                  class="w-full px-6 py-4 rounded-2xl border-2 border-neutral-200 dark:border-neutral-700
                                         bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white
                                         focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20
                                         transition-all duration-300
                                         font-poem placeholder:text-neutral-400 placeholder:italic
                                         resize-none"></textarea>
                    </div>
                    
                </div>
            </div>
            
            <!-- Metadata Card -->
            <div class="backdrop-blur-xl bg-white/85 dark:bg-neutral-800/85 
                        rounded-3xl shadow-xl border border-white/50 dark:border-neutral-700/50
                        p-8 md:p-10">
                
                <h3 class="text-2xl font-bold text-neutral-900 dark:text-white mb-6 font-poem flex items-center gap-3">
                    <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Dettagli
                </h3>
                
                <div class="grid md:grid-cols-2 gap-6">
                    
                    <!-- Categoria -->
                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-3">
                            Categoria
                        </label>
                        <div class="relative">
                            <select wire:model.live="category"
                                    class="w-full appearance-none pl-4 pr-10 py-4 rounded-2xl 
                                           bg-gradient-to-br from-white to-neutral-50 dark:from-neutral-800 dark:to-neutral-900
                                           border-2 border-neutral-200 dark:border-neutral-700
                                           text-neutral-900 dark:text-white
                                           focus:border-primary-500 focus:ring-2 focus:ring-primary-500/30
                                           transition-all duration-200 cursor-pointer font-medium">
                                <option value="">Seleziona categoria</option>
                                @foreach($categories as $key => $name)
                                    <option value="{{ $key }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-neutral-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tipo Poesia -->
                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-3">
                            Tipo di Poesia
                        </label>
                        <div class="relative">
                            <select wire:model.live="poemType"
                                    class="w-full appearance-none pl-4 pr-10 py-4 rounded-2xl 
                                           bg-gradient-to-br from-white to-neutral-50 dark:from-neutral-800 dark:to-neutral-900
                                           border-2 border-neutral-200 dark:border-neutral-700
                                           text-neutral-900 dark:text-white
                                           focus:border-primary-500 focus:ring-2 focus:ring-primary-500/30
                                           transition-all duration-200 cursor-pointer font-medium">
                                <option value="">Seleziona tipo</option>
                                @foreach($poemTypes as $key => $name)
                                    <option value="{{ $key }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-neutral-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Lingua -->
                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-3">
                            Lingua
                        </label>
                        <div class="relative">
                            <select wire:model.live="language"
                                    class="w-full appearance-none pl-4 pr-10 py-4 rounded-2xl 
                                           bg-gradient-to-br from-white to-neutral-50 dark:from-neutral-800 dark:to-neutral-900
                                           border-2 border-neutral-200 dark:border-neutral-700
                                           text-neutral-900 dark:text-white
                                           focus:border-primary-500 focus:ring-2 focus:ring-primary-500/30
                                           transition-all duration-200 cursor-pointer font-medium">
                                @foreach(['it' => 'Italiano', 'en' => 'English', 'fr' => 'Français', 'es' => 'Español', 'de' => 'Deutsch'] as $code => $name)
                                    <option value="{{ $code }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-neutral-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tags -->
                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-3">
                            Tags <span class="text-neutral-400">(separa con virgole)</span>
                        </label>
                        <input wire:model.blur="tags"
                               type="text"
                               placeholder="amore, natura, vita, ..."
                               class="w-full px-6 py-4 rounded-2xl border-2 border-neutral-200 dark:border-neutral-700
                                      bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white
                                      focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20
                                      transition-all duration-300
                                      font-medium placeholder:text-neutral-400">
                    </div>
                    
                </div>
                
                <!-- Upload Thumbnail -->
                <div class="px-8 md:px-12 lg:px-16 pb-8">
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-3">
                        Immagine di Copertina <span class="text-neutral-400">(opzionale)</span>
                    </label>
                    
                    <div class="flex flex-col md:flex-row gap-6">
                        <label class="flex-1 cursor-pointer group">
                            <div class="border-2 border-dashed border-neutral-300 dark:border-neutral-600 
                                        rounded-2xl p-8 text-center
                                        group-hover:border-primary-500 group-hover:bg-primary-50/50 dark:group-hover:bg-primary-900/10
                                        transition-all duration-300">
                                <svg class="w-12 h-12 mx-auto mb-4 text-neutral-400 group-hover:text-primary-500 transition-colors" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400 group-hover:text-primary-600 transition-colors">
                                    Clicca per caricare un'immagine
                                </p>
                                <p class="text-xs text-neutral-500 dark:text-neutral-500 mt-2">
                                    JPG, PNG, WebP (max 2MB)
                                </p>
                            </div>
                            <input wire:model="thumbnail" type="file" accept="image/*" class="hidden">
                        </label>
                        
                        @if($thumbnail)
                            <div class="flex-1">
                                <div class="relative rounded-2xl overflow-hidden shadow-lg group">
                                    <img src="{{ $thumbnail->temporaryUrl() }}" 
                                         alt="Preview"
                                         class="w-full h-64 object-cover">
                                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 
                                                transition-opacity flex items-center justify-center">
                                        <button type="button" 
                                                wire:click="$set('thumbnail', null)"
                                                class="px-4 py-2 bg-red-500 text-white rounded-lg font-medium
                                                       hover:bg-red-600 transition-colors">
                                            Rimuovi
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    @error('thumbnail') 
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Actions Bar -->
            <div class="flex items-center justify-between gap-4 flex-wrap">
                <button type="button"
                        wire:click="togglePreview"
                        class="px-6 py-3 rounded-2xl font-medium
                               bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300
                               hover:bg-neutral-200 dark:hover:bg-neutral-600
                               transition-all duration-200 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <span class="font-poem">{{ $showPreview ? 'Nascondi' : 'Anteprima' }}</span>
                </button>
                
                <div class="flex items-center gap-4">
                    <button type="button"
                            wire:click="saveDraft"
                            @click="window.dispatchEvent(new Event('beforesubmit'))"
                            class="px-8 py-4 rounded-2xl font-semibold
                                   bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300
                                   hover:bg-neutral-200 dark:hover:bg-neutral-600
                                   transition-all duration-200 shadow-lg hover:shadow-xl
                                   flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        <span class="font-poem">Salva Bozza</span>
                    </button>
                    
                    <button type="button"
                            wire:click="save"
                            class="px-8 py-4 rounded-2xl font-bold
                                   bg-gradient-to-r from-primary-500 to-primary-600
                                   hover:from-primary-600 hover:to-primary-700
                                   text-white shadow-xl hover:shadow-2xl
                                   hover:-translate-y-1
                                   transition-all duration-300
                                   flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="font-poem">Aggiorna Poesia</span>
                    </button>
                </div>
            </div>
            
            <!-- Loading Indicator -->
            <div wire:loading class="fixed bottom-8 right-8 z-50">
                <div class="backdrop-blur-xl bg-primary-500/90 text-white px-6 py-4 rounded-2xl shadow-2xl
                            flex items-center gap-3">
                    <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="font-poem font-medium">Salvando...</span>
                </div>
            </div>
            
        </form>
        
        <!-- Preview Modal - Anteprima Poetica -->
        @if($showPreview && $content)
            <div class="fixed inset-0 bg-black/70 backdrop-blur-md z-50 flex items-center justify-center p-4 animate-fade-in"
                 @click.self="$wire.togglePreview()">
                <div class="relative bg-gradient-to-br from-amber-50 via-white to-amber-50 dark:from-neutral-800 dark:via-neutral-900 dark:to-neutral-800 
                            rounded-3xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
                    
                    <!-- Header con sfondo poetico -->
                    <div class="relative bg-gradient-to-r from-primary-500/10 via-primary-400/5 to-primary-500/10 
                                border-b-2 border-primary-200 dark:border-primary-900/50 px-8 py-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <svg class="w-7 h-7 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <h2 class="text-2xl font-bold text-neutral-900 dark:text-white font-poem">
                                    Anteprima
                                </h2>
                            </div>
                            <button type="button" 
                                    wire:click="togglePreview"
                                    class="p-2 rounded-xl hover:bg-primary-100 dark:hover:bg-primary-900/30 
                                           transition-all duration-200 hover:rotate-90">
                                <svg class="w-6 h-6 text-neutral-600 dark:text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Content Area con scroll -->
                    <div class="overflow-y-auto max-h-[calc(90vh-100px)] p-8 md:p-12">
                        <!-- Decorazione virgolette -->
                        <div class="text-8xl text-primary-200 dark:text-primary-900/30 font-serif leading-none mb-6">
                            "
                        </div>
                        
                        @if($title)
                            <h3 class="text-4xl md:text-5xl font-bold text-neutral-900 dark:text-white mb-8 font-poem 
                                       leading-tight text-center animate-fade-in-scale">
                                {{ $title }}
                            </h3>
                        @endif
                        
                        <!-- Contenuto Poesia -->
                        <div class="poem-content prose prose-lg md:prose-xl prose-neutral dark:prose-invert max-w-none
                                    font-poem text-neutral-800 dark:text-neutral-200 leading-relaxed
                                    px-4 md:px-8">
                            {!! $content !!}
                        </div>
                        
                        <!-- Decorazione finale -->
                        <div class="mt-12 flex justify-center">
                            <svg class="w-20 h-6 text-primary-300 dark:text-primary-800" viewBox="0 0 100 24" fill="none">
                                <path d="M0 12 Q25 0, 50 12 T100 12" stroke="currentColor" stroke-width="2" fill="none"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Success Message -->
        @if (session()->has('success'))
            <div class="fixed bottom-8 right-8 z-50 animate-fade-in">
                <div class="backdrop-blur-xl bg-green-500/90 text-white px-6 py-4 rounded-2xl shadow-2xl
                            flex items-center gap-3">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-poem font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editorDiv = document.getElementById('quill-editor');
    const textarea = document.getElementById('quill-content');
    
    if (!editorDiv || !textarea) {
        console.error('Quill elements not found');
        return;
    }
    
    const quill = new Quill(editorDiv, {
        theme: 'snow',
        placeholder: 'Scrivi qui la tua poesia...\n\nOgni verso\nogni parola\nogni silenzio\n\nha il suo significato...',
        modules: {
            toolbar: [['bold', 'italic'], [{ 'align': [] }], ['clean']]
        }
    });
    
    // Sync Quill → Textarea → Livewire
    quill.on('text-change', function() {
        textarea.value = quill.root.innerHTML;
        textarea.dispatchEvent(new Event('input', { bubbles: true }));
    });
    
    console.log('✅ Quill initialized');
});
</script>
