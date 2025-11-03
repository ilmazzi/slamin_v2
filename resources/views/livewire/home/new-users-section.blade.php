<div>
    @php
    $newUsers = \App\Models\User::latest()->limit(8)->get();
    @endphp
    
    @if($newUsers && $newUsers->count() > 0)
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8" x-data :style="`transform: translateY(${scrollY * 0.08}px)`">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-neutral-900 dark:text-white mb-2">Nuovi Poeti</h2>
                <p class="text-neutral-600 dark:text-neutral-400">Dai il benvenuto ai nuovi membri</p>
            </div>
            <x-ui.buttons.primary href="#" variant="ghost" size="sm" icon="M9 5l7 7-7 7">
                Vedi tutti
            </x-ui.buttons.primary>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4 md:gap-6">
            @foreach($newUsers as $i => $user)
            <div class="text-center group" x-data x-intersect.once="$el.classList.add('animate-fade-up')" style="animation-delay: {{ $i * 0.05 }}s">
                <div class="w-20 h-20 mx-auto mb-3 rounded-full overflow-hidden ring-4 ring-primary-100 dark:ring-primary-900 group-hover:ring-primary-400 transition-all shadow-lg">
                    <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                <h3 class="font-semibold text-sm text-neutral-900 dark:text-white truncate px-1">{{ Str::limit($user->name, 15) }}</h3>
                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">{{ $user->poems()->count() }} poesie</p>
            </div>
            @endforeach
        </div>
    </div>
    
    <style>
        @keyframes fade-up { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-up { animation: fade-up 0.4s ease-out forwards; opacity: 0; }
    </style>
    @endif
</div>
