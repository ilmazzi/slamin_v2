<div x-data="{ 
    currentTime: $wire.entangle('currentTime'),
    duration: {{ $video->duration ?? 0 }},
    
    updateTime() {
        this.currentTime = this.$refs.videoPlayer.currentTime;
        this.$dispatch('video-time-update', { time: this.currentTime });
    },
    
    createSnapAtCurrentTime() {
        this.$wire.openSnapModal(Math.floor(this.currentTime));
    }
}" 
     class="snap-player">
    
    {{-- Video Player --}}
    <div class="relative bg-black">
        @if($videoDirectUrl)
            {{-- Video HTML5 con URL diretto (PeerTube) --}}
            <video x-ref="videoPlayer" 
                   controls 
                   playsinline
                   webkit-playsinline
                   class="w-full"
                   style="max-height: 60vh;"
                   @timeupdate="updateTime()">
                <source src="{{ $videoDirectUrl }}" type="video/mp4">
                Il tuo browser non supporta il tag video.
            </video>
        @else
            {{-- Video non disponibile --}}
            <div class="flex items-center justify-center bg-neutral-800"
                 style="height: 400px;">
                <div class="text-center text-white">
                    <svg class="w-16 h-16 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-lg">Video non disponibile</p>
                </div>
            </div>
        @endif
        
        {{-- Pulsante Crea Snap (sopra il video - Desktop) --}}
        @if($videoDirectUrl)
        <div class="absolute top-4 left-4 hidden md:block z-20">
            <button @click="createSnapAtCurrentTime()" 
                    class="w-12 h-12 bg-primary-600 hover:bg-primary-700 text-white rounded-full flex items-center justify-center shadow-lg hover:scale-110 transition-all"
                    title="Crea Snap">
                <img src="{{ asset('assets/icon/new/snap.svg') }}" 
                     alt="Snap" 
                     class="w-6 h-6"
                     style="filter: brightness(0) saturate(100%) invert(100%);">
            </button>
        </div>
        @endif
    </div>
    
    {{-- Pulsante Crea Snap - Mobile (sotto il video) --}}
    @if($videoDirectUrl)
    <div class="md:hidden mt-3 flex justify-center">
        <button @click="createSnapAtCurrentTime()" 
                class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg flex items-center gap-2 transition-colors">
            <img src="{{ asset('assets/icon/new/snap.svg') }}" 
                 alt="Snap" 
                 class="w-5 h-5"
                 style="filter: brightness(0) saturate(100%) invert(100%);">
            <span class="font-medium">Crea Snap</span>
        </button>
    </div>
    @endif
    
    {{-- Messaggi di successo/errore --}}
    @if (session()->has('message'))
        <div class="mt-4 p-4 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-lg">
            {{ session('message') }}
        </div>
    @endif
    
    @if (session()->has('error'))
        <div class="mt-4 p-4 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded-lg">
            {{ session('error') }}
        </div>
    @endif
    
    {{-- Timeline con Snap --}}
    <div class="mt-4" wire:key="snap-timeline-{{ $video->id }}">
        @livewire('snap.snap-timeline', ['video' => $video, 'snaps' => $this->snaps], key('snap-timeline-' . $video->id))
    </div>
    
    {{-- Snap Modal --}}
    @if($showSnapModal)
        <div class="fixed inset-0 z-[10000] flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm"
             @click.self="$wire.closeSnapModal()">
            <div class="relative w-full max-w-md bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl overflow-hidden"
                 @click.stop>
                
                {{-- Header --}}
                <div class="flex items-center justify-between p-6 border-b border-neutral-200 dark:border-neutral-700">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('assets/icon/new/snap.svg') }}" 
                             alt="Snap" 
                             class="w-6 h-6"
                             style="filter: brightness(0) saturate(100%) invert(27%) sepia(98%) saturate(2618%) hue-rotate(346deg) brightness(94%) contrast(97%);">
                        <h3 class="text-xl font-bold text-neutral-900 dark:text-white">Crea Snap</h3>
                    </div>
                    <button @click="$wire.closeSnapModal()"
                            class="text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-300 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                {{-- Body --}}
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            Titolo *
                        </label>
                        <input type="text" 
                               wire:model.defer="snapTitle"
                               class="w-full px-4 py-2 border-2 border-neutral-200 dark:border-neutral-700 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:bg-neutral-700 dark:text-white transition-all"
                               placeholder="Titolo del momento"
                               required>
                        @error('snapTitle') 
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            Descrizione
                        </label>
                        <textarea wire:model.defer="snapDescription"
                                  class="w-full px-4 py-2 border-2 border-neutral-200 dark:border-neutral-700 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:bg-neutral-700 dark:text-white transition-all resize-none"
                                  rows="3"
                                  placeholder="Descrizione del momento"></textarea>
                        @error('snapDescription') 
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-neutral-400 bg-neutral-50 dark:bg-neutral-700 px-4 py-2 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-medium" x-text="Math.floor(currentTime / 60) + ':' + String(Math.floor(currentTime % 60)).padStart(2, '0')"></span>
                    </div>
                </div>
                
                {{-- Footer --}}
                <div class="flex items-center justify-end gap-3 p-6 border-t border-neutral-200 dark:border-neutral-700">
                    <button @click="$wire.closeSnapModal()"
                            class="px-5 py-2.5 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700 rounded-xl font-medium transition-all">
                        Annulla
                    </button>
                    <button wire:click="createSnap"
                            wire:loading.attr="disabled"
                            class="px-5 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-medium transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                        <img src="{{ asset('assets/icon/new/snap.svg') }}" 
                             alt="Snap" 
                             class="w-5 h-5"
                             style="filter: brightness(0) saturate(100%) invert(100%);">
                        <span wire:loading.remove wire:target="createSnap">Crea Snap</span>
                        <span wire:loading wire:target="createSnap">Creazione...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

