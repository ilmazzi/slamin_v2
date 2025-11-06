<div>
    @if($isOpen && $photo)
        {{-- Modal Backdrop --}}
        <div class="fixed inset-0 bg-black/90 backdrop-blur-sm z-[9999] flex items-center justify-center p-4"
             x-data="{ show: @entangle('isOpen') }"
             x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click.self="$wire.closeModal()"
             @keydown.escape.window="$wire.closeModal()">
            
            {{-- Modal Content --}}
            <div class="relative w-full max-w-6xl"
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
                        class="absolute top-4 right-4 z-10 w-12 h-12 bg-black/50 hover:bg-black/70 backdrop-blur-sm rounded-full flex items-center justify-center text-white transition-all hover:scale-110">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                {{-- Photo --}}
                <div class="relative mb-4">
                    <img src="{{ $photo->image_url }}" 
                         alt="{{ $photo->title }}" 
                         class="w-full max-h-[80vh] object-contain rounded-2xl shadow-2xl">
                </div>

                {{-- Photo Info --}}
                <div class="bg-white dark:bg-neutral-900 rounded-2xl p-6 shadow-xl">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1">
                            <h2 class="text-2xl font-black text-neutral-900 dark:text-white mb-2" style="font-family: 'Crimson Pro', serif;">
                                {{ $photo->title ?? __('media.untitled') }}
                            </h2>
                            
                            @if($photo->description)
                                <p class="text-neutral-600 dark:text-neutral-400 mb-4">
                                    {{ $photo->description }}
                                </p>
                            @endif

                            {{-- Author --}}
                            @if($photo->user)
                                <div class="mb-4">
                                    <x-ui.user-avatar :user="$photo->user" size="md" :showName="true" :showNickname="true" />
                                </div>
                            @endif
                        </div>

                        {{-- Social Actions --}}
                        <div class="flex flex-col gap-3">
                            <x-like-button 
                                :itemId="$photo->id"
                                itemType="photo"
                                :isLiked="false"
                                :likesCount="$photo->likes_count ?? 0"
                                size="md" />
                            <x-comment-button 
                                :itemId="$photo->id"
                                itemType="photo"
                                :commentsCount="$photo->comments_count ?? 0"
                                size="md" />
                            <x-share-button 
                                :itemId="$photo->id"
                                itemType="photo"
                                size="md" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>


