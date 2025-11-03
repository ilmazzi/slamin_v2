<div>
    @php
    $newUsers = \App\Models\User::where('profile_visibility', 'public')
        ->latest()
        ->limit(8)
        ->get();
    @endphp
    
    @if($newUsers && $newUsers->count() > 0)
    <section class="py-12 md:py-20 bg-white dark:bg-neutral-900">
        <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="flex items-center justify-between mb-8 md:mb-12">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-neutral-900 dark:text-white mb-2">Nuovi Poeti</h2>
                    <p class="text-neutral-600 dark:text-neutral-400">Dai il benvenuto ai nuovi membri della community</p>
                </div>
                <x-ui.buttons.primary 
                    href="#"
                    variant="ghost"
                    size="sm"
                    icon="M9 5l7 7-7 7">
                    Vedi tutti
                </x-ui.buttons.primary>
            </div>

            <!-- Users Carousel -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4 md:gap-6">
                @foreach($newUsers as $i => $user)
                <div class="group text-center"
                     x-data
                     x-intersect.half="$el.classList.add('animate-slide-up')"
                     style="animation-delay: {{ $i * 0.05 }}s">
                    <!-- Avatar -->
                    <div class="relative mb-3">
                        <div class="w-16 h-16 md:w-20 md:h-20 mx-auto rounded-full overflow-hidden ring-4 ring-primary-100 dark:ring-primary-900 group-hover:ring-primary-400 transition-all duration-300 shadow-lg">
                            <img src="{{ $user->profile_photo_url }}" 
                                 alt="{{ $user->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        @if($user->is_online ?? false)
                        <div class="absolute bottom-0 right-1/2 translate-x-6 md:translate-x-8">
                            <div class="w-3 h-3 md:w-4 md:h-4 bg-green-500 rounded-full border-2 border-white dark:border-neutral-900"></div>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Info -->
                    <h3 class="font-semibold text-sm md:text-base text-neutral-900 dark:text-white truncate px-1">
                        {{ Str::limit($user->name, 12) }}
                    </h3>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                        {{ $user->poems()->count() }} {{ $user->poems()->count() === 1 ? 'poesia' : 'poesie' }}
                    </p>
                    
                    <!-- Follow Button -->
                    <button class="mt-2 w-full px-3 py-1.5 text-xs font-semibold text-primary-600 hover:text-white border border-primary-600 hover:bg-primary-600 rounded-full transition-all duration-300 opacity-0 group-hover:opacity-100">
                        Segui
                    </button>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</div>

<style>
    @keyframes slide-up {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-slide-up {
        animation: slide-up 0.5s ease-out forwards;
        opacity: 0;
    }
</style>
