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

                {{-- Video Player con Snap --}}
                <div class="bg-black">
                    @livewire('snap.snap-player', ['video' => $video], key('snap-player-' . $video->id))
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


