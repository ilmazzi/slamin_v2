<div>
    @if($isOpen && $video)
        {{-- Modal Backdrop --}}
        <div class="fixed inset-0 bg-black/80 backdrop-blur-sm z-[9999] flex items-center justify-center p-4"
             x-data="{ 
                 show: @entangle('isOpen'),
                 playVideo() {
                     setTimeout(() => {
                         const video = this.$el.querySelector('video');
                         if (video) {
                             video.load();
                             video.play().catch(e => console.log('Play bloccato:', e));
                         }
                     }, 100);
                 }
             }"
             x-show="show"
             x-init="playVideo()"
             @open-video.window="playVideo()"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click.self="$wire.closeModal()"
             @keydown.escape.window="$wire.closeModal()">
            
            {{-- Modal Content --}}
            <div class="relative w-full max-w-5xl bg-white dark:bg-neutral-900 rounded-3xl shadow-2xl overflow-hidden"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 @click.stop>
                
                {{-- Close Button --}}
                <button wire:click="closeModal"
                        class="absolute top-4 right-4 z-10 w-10 h-10 bg-black/50 hover:bg-black/70 backdrop-blur-sm rounded-full flex items-center justify-center text-white transition-all hover:scale-110">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                {{-- Timeline Snap (sopra il video) --}}
                @if($videoDirectUrl)
                    <div class="px-6 pt-16 pb-3 bg-neutral-900 flex items-center gap-4">
                        <div class="flex-1">
                            @livewire('snap.snap-timeline', ['video' => $video], key('snap-timeline-modal-' . $video->id))
                        </div>
                        
                        {{-- Pulsante Crea Snap (solo per utenti autenticati) --}}
                        @auth
                        <button @click.stop="$dispatch('open-snap-modal')"
                                class="flex-shrink-0 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-full shadow-lg hover:scale-105 transition-all duration-300 flex items-center gap-2">
                            <img src="{{ asset('assets/icon/new/snap.svg') }}" 
                                 alt="Snap" 
                                 class="w-5 h-5"
                                 style="filter: brightness(0) saturate(100%) invert(100%);">
                            <span class="text-sm font-medium">Crea Snap</span>
                        </button>
                        @endauth
                    </div>
                @endif

                {{-- Video Player --}}
                <div class="aspect-video bg-black relative" 
                     @seek-video.window="seekToTime($event.detail.timestamp)"
                     @open-snap-modal.window="openSnapModal()"
                     x-data="{
                    currentTime: 0,
                    duration: 0,
                    snapTimestamp: 0,
                    showSnapModal: false,
                    snapTitle: '',
                    snapDescription: '',
                    
                    updateTime(event) {
                        this.currentTime = event.target.currentTime;
                        // Ottieni durata reale dal player
                        if (event.target.duration && !isNaN(event.target.duration)) {
                            this.duration = event.target.duration;
                        }
                        // Dispatch per aggiornare timeline
                        Livewire.dispatch('video-time-update', [this.currentTime, this.duration]);
                    },
                    
                    seekToTime(timestamp) {
                        const video = this.$refs.videoPlayer;
                        if (video) {
                            video.currentTime = timestamp;
                            video.play();
                        }
                    },
                    
                    openSnapModal() {
                        // Salva il timestamp CORRENTE quando apri il modal
                        this.snapTimestamp = Math.floor(this.currentTime);
                        // Opzionalmente metti in pausa il video
                        const video = this.$refs.videoPlayer;
                        if (video) video.pause();
                        this.showSnapModal = true;
                    },
                    
                    async createSnap() {
                        if (!this.snapTitle) return;
                        
                        @guest
                            window.dispatchEvent(new CustomEvent('notify', { 
                                detail: { 
                                    message: 'Devi effettuare il login per creare snap!', 
                                    type: 'error' 
                                } 
                            }));
                            setTimeout(() => window.location.href = '{{ route('login') }}', 1500);
                            return;
                        @endguest
                        
                        try {
                            const response = await fetch('{{ route('api.snaps.store') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    video_id: {{ $video->id }},
                                    title: this.snapTitle,
                                    description: this.snapDescription,
                                    timestamp: this.snapTimestamp
                                })
                            });
                            
                            const text = await response.text();
                            
                            let data;
                            try {
                                data = JSON.parse(text);
                            } catch (e) {
                                console.error('JSON parse error:', e, 'Response:', text);
                                window.dispatchEvent(new CustomEvent('notify', { 
                                    detail: { 
                                        message: 'Errore nel salvataggio dello snap', 
                                        type: 'error' 
                                    } 
                                }));
                                return;
                            }
                            
                            if (data.success) {
                                this.snapTitle = '';
                                this.snapDescription = '';
                                this.showSnapModal = false;
                                
                                // Animazione draghetto come per i like
                                window.dispatchEvent(new CustomEvent('notify', { 
                                    detail: { 
                                        message: data.message || 'Snap creato!', 
                                        type: 'snap' 
                                    } 
                                }));
                                
                                // Refresh timeline
                                Livewire.dispatch('snap-created', { videoId: {{ $video->id }} });
                            } else {
                                window.dispatchEvent(new CustomEvent('notify', { 
                                    detail: { 
                                        message: data.message || 'Impossibile creare lo snap', 
                                        type: 'error' 
                                    } 
                                }));
                            }
                        } catch (error) {
                            console.error('Error creating snap:', error);
                            window.dispatchEvent(new CustomEvent('notify', { 
                                detail: { 
                                    message: 'Errore: ' + error.message, 
                                    type: 'error' 
                                } 
                            }));
                        }
                    }
                }">
                    @if($videoDirectUrl)
                        {{-- Video Player HTML5 --}}
                        <video x-ref="videoPlayer"
                               controls 
                               playsinline
                               webkit-playsinline
                               preload="auto"
                               class="w-full h-full"
                               @loadedmetadata="if ($event.target.duration) { duration = $event.target.duration; Livewire.dispatch('video-time-update', [currentTime, duration]); }"
                               @timeupdate="updateTime($event)"
                               src="{{ $videoDirectUrl }}">
                            Your browser does not support the video tag.
                        </video>
                        
                        
                        {{-- Modal Snap --}}
                        <template x-if="showSnapModal">
                            <div class="fixed inset-0 z-[10000] flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm"
                                 @click.self="showSnapModal = false">
                                <div class="relative w-full max-w-md bg-white dark:bg-neutral-800 rounded-2xl overflow-hidden"
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
                                        <button @click="showSnapModal = false"
                                                class="text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-300">
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
                                                   x-model="snapTitle"
                                                   class="w-full px-4 py-2 border-2 border-neutral-200 dark:border-neutral-700 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:bg-neutral-700 dark:text-white transition-all"
                                                   placeholder="Titolo del momento">
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                                                Descrizione
                                            </label>
                                            <textarea x-model="snapDescription"
                                                      class="w-full px-4 py-2 border-2 border-neutral-200 dark:border-neutral-700 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:bg-neutral-700 dark:text-white transition-all resize-none"
                                                      rows="3"
                                                      placeholder="Descrizione del momento"></textarea>
                                        </div>
                                        
                                        <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-neutral-400 bg-neutral-50 dark:bg-neutral-700 px-4 py-2 rounded-lg">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="font-medium" x-text="Math.floor(snapTimestamp / 60) + ':' + String(snapTimestamp % 60).padStart(2, '0')"></span>
                                        </div>
                                    </div>
                                    
                                    {{-- Footer --}}
                                    <div class="flex items-center justify-end gap-3 p-6 border-t border-neutral-200 dark:border-neutral-700">
                                        <button @click="showSnapModal = false"
                                                class="px-5 py-2.5 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700 rounded-xl font-medium">
                                            Annulla
                                        </button>
                                        <button @click="createSnap()"
                                                :disabled="!snapTitle"
                                                class="px-5 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-medium disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                                            <img src="{{ asset('assets/icon/new/snap.svg') }}" 
                                                 alt="Snap" 
                                                 class="w-5 h-5"
                                                 style="filter: brightness(0) saturate(100%) invert(100%);">
                                            Crea Snap
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    @else
                        {{-- Video non disponibile --}}
                        <div class="flex items-center justify-center h-full">
                            <div class="text-center text-white">
                                <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-lg">Video non disponibile</p>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Video Info --}}
                <div class="p-6 border-t border-neutral-200 dark:border-neutral-800">
                    <h2 class="text-2xl font-black text-neutral-900 dark:text-white mb-3" style="font-family: 'Crimson Pro', serif;">
                        {{ $video->title }}
                    </h2>
                    
                    @if($video->description)
                        <p class="text-neutral-600 dark:text-neutral-400 mb-4">
                            {{ $video->description }}
                        </p>
                    @endif

                    <div class="flex items-center justify-between">
                        {{-- Author --}}
                        @if($video->user)
                            <div class="flex items-center gap-3">
                                <x-ui.user-avatar :user="$video->user" size="md" :showName="true" :showNickname="true" />
                            </div>
                        @endif

                        {{-- Social Actions --}}
                        <div class="flex items-center gap-3">
                            <x-like-button 
                                :itemId="$video->id"
                                itemType="video"
                                :isLiked="false"
                                :likesCount="$video->likes_count ?? 0"
                                size="md" />
                            <x-comment-button 
                                :itemId="$video->id"
                                itemType="video"
                                :commentsCount="$video->comments_count ?? 0"
                                size="md" />
                            <x-share-button 
                                :itemId="$video->id"
                                itemType="video"
                                size="md" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>


