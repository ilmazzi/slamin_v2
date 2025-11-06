<x-layouts.app>
    <div class="min-h-screen bg-neutral-50 dark:bg-neutral-900 py-12">
        <div class="max-w-5xl mx-auto px-4">
            {{-- Photo --}}
            <div class="mb-8 bg-white dark:bg-neutral-800 rounded-3xl overflow-hidden shadow-2xl border border-neutral-200 dark:border-neutral-700">
                <img src="{{ $photo->image_url }}" 
                     alt="{{ $photo->title }}" 
                     class="w-full max-h-[70vh] object-contain">
            </div>

            {{-- Photo Info --}}
            <div class="bg-white dark:bg-neutral-800 rounded-3xl p-8 shadow-xl border border-neutral-200 dark:border-neutral-700">
                <h1 class="text-4xl font-black text-neutral-900 dark:text-white mb-4" style="font-family: 'Crimson Pro', serif;">
                    {{ $photo->title ?? 'Senza titolo' }}
                </h1>

                @if($photo->description)
                    <p class="text-lg text-neutral-600 dark:text-neutral-400 mb-6">
                        {{ $photo->description }}
                    </p>
                @endif

                <div class="flex items-center justify-between">
                    @if($photo->user)
                        <x-ui.user-avatar :user="$photo->user" size="lg" :showName="true" :showNickname="true" />
                    @endif

                    <div class="flex items-center gap-3">
                        <x-like-button 
                            :itemId="$photo->id"
                            itemType="photo"
                            :isLiked="false"
                            :likesCount="0"
                            size="md" />
                        <x-comment-button 
                            :itemId="$photo->id"
                            itemType="photo"
                            :commentsCount="0"
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
</x-layouts.app>


