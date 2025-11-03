<div>
    @php
    $video = \App\Models\Video::where('moderation_status', 'approved')->with('user')->latest()->first();
    $photos = \App\Models\User::whereNotNull('profile_photo')->latest()->limit(5)->get();
    @endphp
    
    @if($video || ($photos && $photos->count() > 0))
    <section class="py-12 md:py-16 bg-neutral-50 dark:bg-neutral-950">
        <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl md:text-4xl font-bold text-neutral-900 dark:text-white mb-2">
                    {{ __('home.videos_section_title') }}
                </h2>
                <p class="text-neutral-600 dark:text-neutral-400">{{ __('home.videos_section_subtitle') }}</p>
            </div>

            <div class="grid md:grid-cols-3 gap-4 max-w-5xl mx-auto">
                <!-- Video Card -->
                @if($video)
                <div class="md:col-span-2 bg-white dark:bg-neutral-900 rounded-xl overflow-hidden shadow-lg group"
                     x-data
                     x-intersect.once="$el.classList.add('animate-fade-in')">
                    <!-- Video Thumbnail -->
                    <div class="relative aspect-video bg-neutral-900">
                        @if($video->thumbnail_url)
                        <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full bg-gradient-to-br from-neutral-700 to-neutral-800 flex items-center justify-center">
                            <svg class="w-20 h-20 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        @endif
                        
                        <!-- Play Button Overlay -->
                        <div class="absolute inset-0 flex items-center justify-center bg-black/30 group-hover:bg-black/40 transition-colors">
                            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-xl group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8 text-primary-600 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Info Utente SOTTO al video -->
                    <div class="p-4">
                        <h3 class="font-bold text-lg text-neutral-900 dark:text-white mb-2">{{ $video->title }}</h3>
                        <div class="flex items-center gap-3">
                            <img src="{{ $video->user->profile_photo_url }}" 
                                 alt="{{ $video->user->name }}" 
                                 class="w-10 h-10 rounded-full object-cover ring-2 ring-primary-200">
                            <div>
                                <p class="font-semibold text-sm text-neutral-900 dark:text-white">{{ $video->user->name }}</p>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400">{{ $video->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Foto Grid -->
                <div class="space-y-4">
                    @foreach($photos->take($video ? 2 : 3) as $i => $user)
                    <div class="bg-white dark:bg-neutral-900 rounded-lg overflow-hidden shadow-md group"
                         x-data
                         x-intersect.once="$el.classList.add('animate-fade-in')"
                         style="animation-delay: {{ ($i + 1) * 0.1 }}s">
                        <div class="flex items-center gap-3 p-3">
                            <img src="{{ $user->profile_photo_url }}" 
                                 alt="{{ $user->name }}" 
                                 class="w-14 h-14 rounded-lg object-cover group-hover:scale-105 transition-transform">
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm text-neutral-900 dark:text-white truncate">{{ $user->name }}</p>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('common.poems_count', ['count' => $user->poems()->count()]) }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    
    <style>
        @keyframes fade-in { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        .animate-fade-in { animation: fade-in 0.4s ease-out forwards; opacity: 0; }
    </style>
    @endif
</div>
