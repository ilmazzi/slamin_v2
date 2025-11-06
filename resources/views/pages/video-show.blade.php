<x-layouts.app>
    <div class="min-h-screen bg-neutral-50 dark:bg-neutral-900 py-12">
        <div class="max-w-5xl mx-auto px-4">
            {{-- Video Player --}}
            <div class="mb-8">
                <x-video-player 
                    :video="$video" 
                    :directUrl="$video->direct_url ?? null" 
                    :showStats="true" 
                    :showAuthor="true" 
                    :showSnaps="true" 
                    size="full" 
                    class="w-full rounded-3xl overflow-hidden shadow-2xl" />
            </div>

            {{-- Video Info --}}
            <div class="bg-white dark:bg-neutral-800 rounded-3xl p-8 shadow-xl border border-neutral-200 dark:border-neutral-700">
                <h1 class="text-4xl font-black text-neutral-900 dark:text-white mb-4" style="font-family: 'Crimson Pro', serif;">
                    {{ $video->title }}
                </h1>

                @if($video->description)
                    <p class="text-lg text-neutral-600 dark:text-neutral-400 mb-6">
                        {{ $video->description }}
                    </p>
                @endif

                <div class="flex items-center justify-between">
                    @if($video->user)
                        <x-ui.user-avatar :user="$video->user" size="lg" :showName="true" :showNickname="true" />
                    @endif

                    <div class="flex items-center gap-3">
                        <x-like-button 
                            :itemId="$video->id"
                            itemType="video"
                            :isLiked="false"
                            :likesCount="0"
                            size="md" />
                        <x-comment-button 
                            :itemId="$video->id"
                            itemType="video"
                            :commentsCount="0"
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
</x-layouts.app>


