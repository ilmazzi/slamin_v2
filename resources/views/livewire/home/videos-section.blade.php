<div>
    @php
    $recentUsers = \App\Models\User::whereNotNull('profile_photo')->latest()->limit(7)->get();
    @endphp
    
    @if($recentUsers && $recentUsers->count() > 0)
    <section class="py-16 md:py-24 bg-gradient-to-br from-primary-900 via-primary-800 to-primary-700 relative overflow-hidden">
        <!-- Animated Background -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute w-96 h-96 bg-white rounded-full blur-3xl -top-48 -left-48 animate-pulse"></div>
            <div class="absolute w-96 h-96 bg-white rounded-full blur-3xl -bottom-48 -right-48 animate-pulse" style="animation-delay: 1s;"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8 relative z-10">
            <!-- Header -->
            <div class="text-center mb-12 md:mb-16">
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 text-white leading-tight" style="font-family: 'Crimson Pro', serif;">
                    La Voce della <span class="italic text-primary-200">Community</span>
                </h2>
                <p class="text-xl md:text-2xl text-white/90">Video, foto e storie dei nostri poeti</p>
            </div>

            <!-- Bento Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4 max-w-6xl mx-auto">
                <!-- Featured (2x2) -->
                @if($recentUsers->first())
                <div class="col-span-2 row-span-2 rounded-2xl md:rounded-3xl overflow-hidden shadow-2xl group"
                     x-data
                     x-intersect.once="$el.classList.add('animate-scale-in')"
                     style="animation-delay: 0.1s">
                    <div class="relative h-full min-h-[300px] md:min-h-[400px] bg-neutral-900">
                        <img src="{{ $recentUsers->first()->profile_photo_url }}" 
                             alt="{{ $recentUsers->first()->name }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent"></div>
                        
                        <!-- Play button overlay (simulato) -->
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <div class="w-20 h-20 bg-white/90 rounded-full flex items-center justify-center shadow-2xl">
                                <svg class="w-10 h-10 text-primary-600 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </div>
                        </div>
                        
                        <div class="absolute bottom-0 left-0 right-0 p-6">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="px-3 py-1 bg-primary-600 text-white text-xs font-bold rounded-full">⭐ Featured</span>
                            </div>
                            <h3 class="text-2xl font-bold text-white mb-2">{{ $recentUsers->first()->name }}</h3>
                            @if($recentUsers->first()->bio)
                            <p class="text-white/90 text-sm mb-3 line-clamp-2">{{ Str::limit($recentUsers->first()->bio, 80) }}</p>
                            @endif
                            <div class="flex gap-4 text-white/80 text-sm">
                                <span>{{ $recentUsers->first()->poems()->count() }} poesie</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Grid Photos -->
                @foreach($recentUsers->skip(1)->take(6) as $i => $user)
                <div class="rounded-xl md:rounded-2xl overflow-hidden shadow-xl group"
                     x-data
                     x-intersect.once="$el.classList.add('animate-scale-in')"
                     style="animation-delay: {{ ($i + 2) * 0.1 }}s">
                    <div class="relative aspect-square bg-neutral-900">
                        <img src="{{ $user->profile_photo_url }}" 
                             alt="{{ $user->name }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                            <div class="absolute bottom-0 left-0 right-0 p-3">
                                <p class="text-white font-semibold text-sm truncate">{{ $user->name }}</p>
                                <p class="text-white/80 text-xs">{{ $user->poems()->count() }} poesie</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- CTA -->
            <div class="text-center mt-12">
                <x-ui.buttons.primary href="#" size="lg">
                    Esplora la Community
                </x-ui.buttons.primary>
            </div>
        </div>
    </section>
    
    <style>
        @keyframes scale-in { from { opacity: 0; transform: scale(0.9); } to { opacity: 1; transform: scale(1); } }
        .animate-scale-in { animation: scale-in 0.5s ease-out forwards; opacity: 0; }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    </style>
    @endif
</div>
