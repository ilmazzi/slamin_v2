<div>
    @php
    $videos = \App\Models\Video::where('moderation_status', 'approved')->latest()->limit(1)->get();
    $photos = \App\Models\User::whereNotNull('profile_photo')->latest()->limit(6)->get();
    @endphp
    
    @if(($videos && $videos->count() > 0) || ($photos && $photos->count() > 0))
    <section class="py-12 md:py-16 bg-neutral-50 dark:bg-neutral-950">
        <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
            <!-- Header Minimal -->
            <div class="text-center mb-8">
                <h2 class="text-3xl md:text-4xl font-bold text-neutral-900 dark:text-white mb-2">
                    Dalla Community
                </h2>
                <p class="text-neutral-600 dark:text-neutral-400">Video e foto dei nostri poeti</p>
            </div>

            <!-- Grid Compatto -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4 max-w-5xl mx-auto">
                <!-- Video (se esiste) -->
                @foreach($videos as $i => $video)
                <div class="col-span-2 rounded-xl md:rounded-2xl overflow-hidden shadow-lg group bg-neutral-900"
                     x-data
                     x-intersect.once="$el.classList.add('animate-fade-in')">
                    <div class="relative aspect-video">
                        @if($video->thumbnail_url)
                        <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full bg-gradient-to-br from-neutral-700 to-neutral-800"></div>
                        @endif
                        <div class="absolute inset-0 bg-black/40"></div>
                        
                        <!-- Play Button -->
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center group-hover:scale-110 transition-transform shadow-xl">
                                <svg class="w-8 h-8 text-primary-600 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </div>
                        </div>
                        
                        <div class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black/80 to-transparent">
                            <p class="text-white font-semibold text-sm">{{ $video->title }}</p>
                            <p class="text-white/80 text-xs">{{ $video->user->name }}</p>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Foto Utenti -->
                @foreach($photos as $i => $user)
                <div class="rounded-lg md:rounded-xl overflow-hidden shadow-lg group"
                     x-data
                     x-intersect.once="$el.classList.add('animate-fade-in')"
                     style="animation-delay: {{ ($videos->count() > 0 ? $i + 1 : $i) * 0.1 }}s">
                    <div class="relative aspect-square bg-neutral-200 dark:bg-neutral-800">
                        <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                            <div class="absolute bottom-0 left-0 right-0 p-2">
                                <p class="text-white text-xs font-semibold truncate">{{ $user->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    
    <style>
        @keyframes fade-in { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        .animate-fade-in { animation: fade-in 0.4s ease-out forwards; opacity: 0; }
    </style>
    @endif
</div>
