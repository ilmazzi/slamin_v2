<div>
    @php
    // Get latest users with profile photos and videos
    $recentUsers = \App\Models\User::whereNotNull('profile_photo')
        ->where('profile_visibility', 'public')
        ->latest()
        ->limit(7)
        ->get();
    @endphp
    
    @if($recentUsers && $recentUsers->count() > 0)
    <section class="py-12 md:py-20 bg-gradient-to-br from-primary-50 via-white to-primary-100 dark:from-neutral-950 dark:via-neutral-900 dark:to-primary-950 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-8 md:mb-12">
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 md:mb-6 text-neutral-900 dark:text-white leading-tight animate-fade-in" 
                    style="font-family: 'Crimson Pro', serif;">
                    La Voce della <span class="italic text-primary-600">Community</span>
                </h2>
                <p class="text-lg md:text-xl lg:text-2xl font-light text-neutral-600 dark:text-neutral-400 animate-fade-in" style="animation-delay: 0.2s">
                    Migliaia di poeti, un'unica passione
                </p>
            </div>

            <!-- Bento Grid (Video + Photos) -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2 md:gap-4 max-w-6xl mx-auto">
                <!-- Large Featured User (Mobile: full width, Desktop: 2 cols) -->
                @if($recentUsers->first())
                <div class="col-span-2 row-span-2 rounded-2xl md:rounded-3xl overflow-hidden shadow-2xl group animate-fade-in-up bg-white dark:bg-neutral-800"
                     style="animation-delay: 0.1s">
                    <div class="relative h-64 md:h-96">
                        <img src="{{ $recentUsers->first()->profile_photo_url }}" 
                             alt="{{ $recentUsers->first()->name }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                        
                        <!-- Featured Badge -->
                        <div class="absolute top-4 right-4">
                            <span class="px-3 py-1.5 bg-primary-600 text-white rounded-full text-xs font-bold uppercase tracking-wider shadow-lg">
                                ⭐ Featured
                            </span>
                        </div>
                        
                        <div class="absolute bottom-0 left-0 right-0 p-4 md:p-6">
                            <h3 class="text-xl md:text-2xl font-bold text-white mb-2">{{ $recentUsers->first()->name }}</h3>
                            @if($recentUsers->first()->bio)
                            <p class="text-sm md:text-base text-white/90 mb-3 line-clamp-2">{{ Str::limit($recentUsers->first()->bio, 100) }}</p>
                            @endif
                            <div class="flex items-center gap-4 text-white/90 text-sm">
                                <span>{{ $recentUsers->first()->poems()->count() }} poesie</span>
                                <span>•</span>
                                <span>{{ $recentUsers->first()->followers_count ?? 0 }} followers</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Photo Grid Items -->
                @foreach($recentUsers->skip(1)->take(6) as $i => $user)
                <div class="rounded-xl md:rounded-2xl overflow-hidden shadow-lg group animate-fade-in-up bg-white dark:bg-neutral-800"
                     style="animation-delay: {{ ($i + 2) * 0.1 }}s">
                    <div class="relative aspect-square">
                        <img src="{{ $user->profile_photo_url }}" 
                             alt="{{ $user->name }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-2 md:p-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <p class="text-white text-xs md:text-sm font-semibold truncate">{{ $user->name }}</p>
                            <p class="text-white/80 text-xs truncate">{{ $user->poems()->count() }} poesie</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- CTA Button -->
            <div class="text-center mt-8 md:mt-12 animate-fade-in" style="animation-delay: 0.8s">
                <x-ui.buttons.primary 
                    href="#"
                    size="lg">
                    Esplora la Community
                </x-ui.buttons.primary>
            </div>
        </div>
    </section>
    
    <style>
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.6s ease-out forwards;
            opacity: 0;
        }
        
        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .animate-fade-in {
            animation: fade-in 0.8s ease-out forwards;
        }
        
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
    @endif
</div>
